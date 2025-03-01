<?php

namespace App\Repositories\AdminRepositories;
use App\Models\AdminModel;
use CodeIgniter\HTTP\RequestInterface;
class AdminRepository implements AdminRepositoryInterface
{
    protected $adminModel;
    private $db;
    protected $validation;
    public function __construct()
    {
        $this->adminModel = new AdminModel();
        $this->validation = \Config\Services::validation();
        $this->db = \Config\Database::connect();
    }

    /**
     * Busca um administrador pelo seu ID
     * @param int $id
     * @return array|null
     */
    public function buscarAdministradorPorId(int $id)
    {
        return $this->db->table('admins')
            ->select('nome, email')
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }

    /**
     * Cria um administrador
     * @param array $dados
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: array|null}|array{cabecalho: array{mensagem: string, status: int}, retorno: null}}
     */
    public function criarAdministrador(array $dados)
    {
        $this->validation->setRules(
            $this->adminModel->getValidationRules(),
            $this->adminModel->getValidationMessages()
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            // Converte o array de erros em uma string
            $erros = implode(' ', $this->validation->getErrors());

            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de validação: ' . $erros, // Concatena a string de erros
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        try {
            $this->db->table('admins')->insert($dados);
            return [
                'cabecalho' => [
                    'mensagem' => 'Administrador adicionado com sucesso',
                    'status' => 200
                ],
                'retorno' => $this->buscarAdministradorPorId($this->db->insertID())
            ];
        } catch (\Exception $e) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao adicionar administrador: ' . $e->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ];
        }
    }

    public function alterarDadosDoAministrador(int $id, array $dados, RequestInterface $request)
    {
        // Valida se o usuário logado é o mesmo do ID passado
        if (!$this->validateUser($request, $id)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Acesso negado: você não tem permissão para alterar este administrador.',
                    'status' => 403,

                ],
                'retorno' => null
            ];
        }

        $admin = $this->buscarAdministradorPorId($id);

        if (!$admin) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Administrador não encontrado',
                    'status' => 404
                ],
                'retorno' => null
            ];
        }

        $this->validation->setRules(
            $this->adminModel->getValidationRules(),
            $this->adminModel->getValidationMessages()
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            // Converte o array de erros em uma string
            $erros = implode(' ', $this->validation->getErrors());

            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de validação: ' . $erros, // Concatena a string de erros
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        $this->db->table('admins')
            ->where('id', $id)
            ->update($dados);

        return [
            'cabecalho' => [
                'mensagem' => 'Administrador atualizado com sucesso',
                'status' => 200
            ],
            'retorno' => $this->buscarAdministradorPorId($id)
        ];
    }

    /**
     * Remove um administrador
     * @param int $id
     * @param \CodeIgniter\HTTP\RequestInterface $request
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: null}}
     */
    public function removerAdministrador(int $id, RequestInterface $request)
    {
        // Valida se o usuário logado é o mesmo do ID passado
        if (!$this->validateUser($request, $id)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Acesso negado: você não tem permissão para alterar este administrador.',
                    'status' => 403,

                ],
                'retorno' => null
            ];
        }

        $admin = $this->buscarAdministradorPorId($id);

        if (!$admin) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Administrador não encontrado',
                    'status' => 404
                ],
                'retorno' => null
            ];
        }

        $this->db->table('admins')
            ->where('id', $id)
            ->delete();

        return [
            'cabecalho' => [
                'mensagem' => 'Administrador excluido com sucesso',
                'status' => 200
            ],
            'retorno' => null
        ];
    }

    /**
     * Valida se o usuário logado é o mesmo usuário que será manipulado na rota
     * @param RequestInterface $request
     * @param int $userId
     * @return bool
     */
    protected function validateUser(RequestInterface $request, int $userId): bool
    {
        // Obtém o ID do usuário logado a partir do token JWT
        $loggedInUserId = (int) $request->user->id;

        // Compara os IDs
        return $loggedInUserId === $userId;
    }

    /**
     * Mostra todos os administradores
     * @param int $page
     * @param array $filtros
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: array|null}}
     */
    public function mostrarTodos(int $page, array $filtros)
    {
        unset($filtros['page']);
        // Carrega a biblioteca de paginação
        $pager = \Config\Services::pager();

        // Número de admins por página
        $perPage = 2; // 2 admins por página (ajuste conforme necessário)

        // Calcula o offset
        $offset = ($page - 1) * $perPage;

        // Inicia a consulta para os admins
        $queryAdmins = $this->db->table('admins')
            ->select('nome, email');

        // Aplica os filtros (apenas se houver valores)
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor)) {
                $queryAdmins->like($campo, $valor); // Filtra usando "LIKE"
            }
        }
        // Executa a consulta de admins com paginação
        $admins = $queryAdmins->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        // Total de admins (para calcular o número total de páginas)
        $totalAdmins = $queryAdmins->countAllResults(false); // "false" para não resetar a consulta

        // Configura a paginação
        $pager->makeLinks($page, $perPage, $totalAdmins);

        // Retorna os dados paginados
        return [
            'cabecalho' => [
                'mensagem' => 'Listagem de admins',
                'status' => 200,
            ],
            'retorno' => [
                'admins' => $admins,
                'paginacao' => $pager->links() // Links de paginação
            ]
        ];
    }

    public function mostrarUm(int $id)
    {
        $admin = $this->buscarAdministradorPorId($id);
        if (!$admin) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Administrador não encontrado',
                    'status' => 404
                ],
                'retorno' => null
            ];
        }

        return [
            'cabecalho' => [
                'mensagem' => 'Administrador',
                'status' => 200
            ],
            'retorno' => $admin
        ];
    }
}