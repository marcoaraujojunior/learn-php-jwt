<?php

namespace Lab\Controller;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\ParameterBag;
use \Silex\Application;
use \Firebase\JWT\JWT;

class Login
{
    public function index(Application $app, Request $request)
    {
        $user = $request->request->get('user');

        if (is_null($user)) {
            return $app->json([], 201);
        }

        $return = [
            'message' => 'success',
            'token' => $this->encode($user),
        ];

        return $app->json($return, 201);
    }

    public function protectedAccess(Application $app, Request $request)
    {
        $jwt = trim(str_replace('Bearer', '', $request->headers->get('authorization')));
        try {
            $decode = JWT::decode($jwt, $this->key(), ['HS256']);
        } catch (\Exception $e) {
            return new Response('Token Inválido ' . $e->getMessage());
        }
        $fileToken = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $decode->email . '.jwt';
        if (!file_exists($fileToken)) {
            return new Response('Token Inválido', 403);
        }
        if ($jwt != file_get_contents($fileToken) ) {
            return new Response('Token Inválido', 403);
        }

        return new Response('Token Válido', 201);
    }

    protected function key()
    {
        return 'example.key';
    }

    protected function encode(Array $data)
    {
        $token = [
            'email' => $data['email'],
            'date' => date('Y-m-d'),
            'tokenId' => base64_encode(mcrypt_create_iv(32)),
        ];

        $fileToken = sys_get_temp_dir() . DIRECTORY_SEPARATOR . $data['email'] . '.jwt';
        file_put_contents($fileToken, JWT::encode($token, $this->key()));
        return file_get_contents($fileToken);
    }
}
