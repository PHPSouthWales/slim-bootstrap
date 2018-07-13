<?php

namespace App\Console;

class Kernel
{
    /**
     * All application commands
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\SayHelloCommand::class
    ];

    /**
     * Default Commands to be included
     *
     * @var array
     */
    protected $defaultCommands = [
        \App\Console\Commands\ConsoleGeneratorCommand::class,
        \App\Console\Commands\MailableGeneratorCommand::class,
        \App\Console\Commands\ControllerGeneratorCommand::class,
        \App\Console\Commands\MiddlewareGeneratorCommand::class,
    ];

    /**
     * Get all registered commands
     *
     * @return array
     */
    public function getCommands() : array
    {
        return array_merge($this->commands, $this->defaultCommands);
    }
}
