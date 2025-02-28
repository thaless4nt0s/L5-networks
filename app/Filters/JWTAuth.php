<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;
use Exception;

class JWTAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Verifica se o token está presente no cabeçalho Authorization
        $authHeader = $request->getHeaderLine('Authorization');
        if (empty($authHeader)) {
            return service('response')->setJSON([
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Token de autenticação não fornecido.'
                ],
                'retorno' => null
            ])->setStatusCode(401);
        }

        // Extrai o token do cabeçalho (formato: Bearer <token>)
        $token = null;
        if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            $token = $matches[1];
        }

        if (empty($token)) {
            return service('response')->setJSON([
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Formato do token inválido.'
                ],
                'retorno' => null
            ])->setStatusCode(401);
        }

        try {
            // Verifica e decodifica o token
            $key = env('JWT_SECRET', 'PV2%IsQZ*P2>&&F');
            $decoded = JWT::decode($token, new Key($key, 'HS256'));

            // Adiciona os dados do usuário decodificados à requisição
            $request->user = $decoded;
        } catch (Exception $e) {
            return service('response')->setJSON([
                'cabecalho' => [
                    'status' => 401,
                    'mensagem' => 'Token inválido ou expirado: ' . $e->getMessage()
                ],
                'retorno' => null
            ])->setStatusCode(401);
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Não é necessário fazer nada após a requisição
    }
}