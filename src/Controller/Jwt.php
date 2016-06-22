<?php

namespace Lab\Controller;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \Symfony\Component\HttpFoundation\ParameterBag;
use \Silex\Application;

class Jwt
{
    public function index(Application $app, Request $request)
    {
        $user = $request->request->get('user');
        $user['oi'] = 'oq';

        return $app->json($user, 201);
    }
}
