<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController extends Controller
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        return $response->withJson([
            'route' => 'home'
        ]);
    }
}
