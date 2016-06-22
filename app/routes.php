<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;


$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
});

$app->match('/', 'Lab\Controller\Jwt::index')
    ->method('POST|OPTIONS');

$app->match('/t/index', 'Lab\Controller\Jwt::index')
    ->method('GET|POST|OPTIONS');

