<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AdminModel;
use CodeIgniter\API\ResponseTrait;
use \Firebase\JWT\JWT;

class Login extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $input = $this->request->getJSON(true); // Obtém o JSON como array associativo

        if (!isset($input['parametros'])) {
            return $this->response->setJSON([
                'cabecalho' => [
                    'status' => 400,
                    'mensagem' => 'Parâmetros ausentes na requisição.'
                ],
                'retorno' => null
            ])->setStatusCode(400);
        }

        $email = $input['parametros']['email'];
        $senha = $input['parametros']['senha'];

        $adminModel = new AdminModel();

        $user = $adminModel->where('email', $email)->first();
        if (is_null($user)) {
            return $this->respond(['error' => 'Usuário ou senha inválidos.'], 401);
        }

        $pwd_verify = password_verify($senha, $user['senha']);
        if (!$pwd_verify) {
            return $this->respond(['error' => 'Usuário ou senha inválidos.'], 401);
        }

        // Verifique e defina a chave secreta
        $key = env('JWT_SECRET', 'PV2%IsQZ*P2>&&F');
        if (empty($key)) {
            return $this->respond(['error' => 'Chave de login não está configurada.'], 500);
        }

        $iat = time(); // current timestamp value
        $exp = $iat + 3600;

        $payload = array(
            "iss" => "Issuer of the JWT",
            "aud" => "Audience that the JWT",
            "sub" => "Subject of the JWT",
            "iat" => $iat, //Time the JWT issued at
            "exp" => $exp, // Expiration time of token
            "email" => $user['email'],
            "id" => $user['id'] // Adiciona o ID do usuário ao payload
        );

        try {
            $token = JWT::encode($payload, $key, 'HS256');
        } catch (\Exception $e) {
            return $this->respond(['error' => 'erro ao gerar token: ' . $e->getMessage()], 500);
        }

        return $this->response->setJSON([
            'cabecalho' => [
                'message' => 'Login realizado com sucesso',
                'status' => 200
            ],
            'retorno' => ['token' => $token]
        ]);
    }
}