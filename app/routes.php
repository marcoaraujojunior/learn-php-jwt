<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;


$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : []);
    }
    $request->encodedJWT  = $request->headers->get('X-Access-Token');
});

$app->match('/', 'Lab\Controller\Login::index')
    ->method('POST|OPTIONS');

$app->get('/', 'Lab\Controller\Login::protectedAccess');
