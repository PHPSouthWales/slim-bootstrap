<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeEmail;
use App\Http\Controllers\Controller;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class HomeController extends Controller
{
    public function index(RequestInterface $request, ResponseInterface $response)
    {
        $this->container->mail->to('test@test.com', 'Steve McDougall')
            ->send(new WelcomeEmail([
                'name' => 'Steve McDougall'
            ]));

        return $response->withJson([
            'route' => 'home'
        ]);
    }
}
