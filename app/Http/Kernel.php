<?php

namespace App\Http;

class Kernel
{
    protected $app;

    protected $middleware = [
        \App\Http\Middleware\ExampleMiddleware::class
    ];

    public function __construct(\Slim\App $app)
    {
        $this->app = $app;
    }

    public function boot()
    {
        array_map(function ($middleware) {
            $this->app->add(new $middleware);
        }, $this->middleware);
    }
}
