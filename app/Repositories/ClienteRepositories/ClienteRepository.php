<?php

namespace App\Repositories\ClienteRepositories;

use App\Models\ClienteModel;

class ClienteRepository implements ClienteRepositoryInterface
{
    protected $clienteModel;
    private $db;
    protected $validation;
    public function __construct()
    {
        $this->clienteModel = new ClienteModel();
        $this->db = \Config\Database::connect();
        $this->validation = \Config\Services::validation();
    }

    /**
     * Busca um cliente pelo seu ID
     * @param int $id
     * @return array[]|array{cpf: mixed, id: mixed, nome: mixed, pedidos: array}
     */
    public function buscarClientePorId(int $id)
    {
        // Consulta para obter o cliente e seus pedidos (se houver)
        $resultados = $this->db->table('clientes')
            ->select('clientes.id, clientes.id as cliente_id, clientes.nome, clientes.cpf, pedidos_de_compra.*')
            ->join('pedidos_de_compra', 'pedidos_de_compra.idCliente = clientes.id', 'left')
            ->where('clientes.id', $id)
            ->get()
            ->getResultArray();

        // Se não houver resultados, retorna um array vazio
        if (empty($resultados)) {
            return [];
        }

        // Estrutura para organizar o cliente e seus pedidos
        $cliente = [
            'id' => $resultados[0]['cliente_id'],
            'nome' => $resultados[0]['nome'],
            'cpf' => $resultados[0]['cpf'],
            'pedidos' => []
        ];

        // Adiciona os pedidos ao array de pedidos do cliente (se existirem)
        foreach ($resultados as $row) {
            if ($row['id'] !== null) { // Verifica se há um pedido associado
                $cliente['pedidos'][] = [
                    'id' => $row['id'],
                    'dia' => $row['dia'],
                    'quantidade' => $row['quantidade'],
                    'valor_compra' => $row['valor_compra'],
                    'idProduto' => $row['idProduto'],
                    'status' => $row['status']
                ];
            }
        }

        return $cliente;
    }

    /**
     * Adiciona um cliente
     * @param array $dados
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: array|null}|array{cabecalho: array{mensagem: string, status: int}, retorno: null}}
     */
    public function adicionarCliente(array $dados)
    {
        // Define as regras e mensagens de validação
        $this->validation->setRules(
            $this->clienteModel->getValidationRules(), // Regras de validação
            $this->clienteModel->getValidationMessages() // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de valicação ' . $this->validation->getErrors(),
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }
        try {
            $this->db->table('clientes')->insert($dados);
        } catch (\Throwable $th) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao adicionar cliente ' . $th->getMessage(),
                    'status' => 500,
                ],
                'retorno' => null
            ];
        }

        return [
            'cabecalho' => [
                'mensagem' => 'Cliente adicionado com sucesso',
                'status' => 200
            ],
            'retorno' => $this->buscarClientePorId($this->db->insertID())
        ];
    }

    /**
     * Altera os dados de um cliente
     * @param int $id
     * @param array $dados
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: array|null}|array{cabecalho: array{mensagem: string, status: int}, retorno: null}}
     */
    public function alterarCliente(int $id, array $dados)
    {
        // Busca o cliente pelo ID
        $cliente = $this->buscarClientePorId($id);

        // Verifica se o cliente existe
        if (!$cliente) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Cliente não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

        // Define as regras e mensagens de validação
        $this->validation->setRules(
            $this->clienteModel->validationRules, // Regras de validação
            $this->clienteModel->validationMessages // Mensagens de erro personalizadas
        );

        // Executa a validação
        if (!$this->validation->run($dados)) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro de valicação ' . $this->validation->getErrors(),
                    'status' => 400,
                ],
                'retorno' => null
            ];
        }

        // Atualiza os dados do cliente
        $this->db->table('clientes')
            ->where('id', $id)
            ->update($dados);

        // Retorna o cliente atualizado
        return [
            'cabecalho' => [
                'mensagem' => 'Cliente atualizado com sucesso',
                'status' => 200,
            ],
            'retorno' => $this->buscarClientePorId($id)
        ];
    }

    /**
     * Remove um cliente
     * @param int $id
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: null}}
     */
    public function removerCliente(int $id)
    {
        // Busca o cliente pelo ID
        $cliente = $this->buscarClientePorId($id);

        // Verifica se o cliente existe
        if (!$cliente) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Cliente não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

        if (!$this->db->table('clientes')->where('id', $id)->delete()) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Erro ao remover cliente',
                    'status' => 500,
                ],
                'retorno' => null
            ];
        }

        return [
            'cabecalho' => [
                'mensagem' => 'Cliente removido com sucesso',
                'status' => 200,
            ],
            'retorno' => null
        ];
    }

    /**
     * Mostra todos os clientes
     * @param int $page
     * @param array $filtros
     * @return array{cabecalho: array{mensagem: string, status: int, retorno: array}}
     */
    public function mostrarTodos(int $page = 1, array $filtros = [])
    {
        unset($filtros['page']);
        // Carrega a biblioteca de paginação
        $pager = \Config\Services::pager();

        // Número de clientes por página
        $perPage = 2; // 2 clientes por página (ajuste conforme necessário)

        // Calcula o offset
        $offset = ($page - 1) * $perPage;

        // Inicia a consulta para os clientes
        $queryClientes = $this->db->table('clientes')
            ->select('clientes.id as cliente_id, clientes.nome, clientes.cpf');

        // Aplica os filtros (apenas se houver valores)
        foreach ($filtros as $campo => $valor) {
            if (!empty($valor)) {
                $queryClientes->like($campo, $valor); // Filtra usando "LIKE"
            }
        }

        // Executa a consulta de clientes com paginação
        $clientes = $queryClientes->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        // Para cada cliente, busca seus pedidos
        foreach ($clientes as &$cliente) {
            $pedidos = $this->db->table('pedidos_de_compra')
                ->select('*')
                ->where('idCliente', $cliente['cliente_id'])
                ->get()
                ->getResultArray();

            $cliente['pedidos'] = $pedidos;
        }

        // Total de clientes (para calcular o número total de páginas)
        $totalClientes = $queryClientes->countAllResults(false); // "false" para não resetar a consulta

        // Configura a paginação
        $pager->makeLinks($page, $perPage, $totalClientes);

        // Retorna os dados paginados
        return [
            'cabecalho' => [
                'mensagem' => 'Listagem de clientes',
                'status' => 200,
            ],
            'retorno' => [
                'clientes' => $clientes,
                'paginacao' => $pager->links() // Links de paginação
            ]
        ];
    }

    public function mostrarUm($id)
    {
        $cliente = $this->buscarClientePorId($id);
        if (!$cliente) {
            return [
                'cabecalho' => [
                    'mensagem' => 'Cliente não encontrado',
                    'status' => 404,
                ],
                'retorno' => null
            ];
        }

        return [
            'cabecalho' => [
                'mensagem' => 'dados do cliente',
                'status' => 500,
            ],
            'retorno' => $cliente
        ];
    }
}
