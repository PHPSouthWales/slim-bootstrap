<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Console\Traits\Generatable;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MiddlewareGeneratorCommand extends Command
{
    use Generatable;

    /**
     * Command Name
     *
     * @var string
     */
    protected $command = 'make:middleware';

    /**
     * Command Description
     *
     * @var string
     */
    protected $description = 'Genereate Middleware Command';

    /**
     * Handle the command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function handle(InputInterface $input, OutputInterface $output)
    {
        $base = __DIR__ . '/../../../Http/Middleware';
        $path = $base . '/';
        $namespace = 'App\\Http\\Middleware';

        $fileParts = explode('\\', $this->argument('name'));
        $fileName = array_pop($fileParts);

        $cleanPath = implode('/', $fileParts);

        if (count($fileParts) >= 1) {
            $path = $path . $cleanPath;
            $namespace = $namespace . '\\' . str_replace('/', '\\', $cleanPath);

            if (! is_dir($path)) {
                mkdir($path, 0777, true);
            }
        }

        $target = "{$path}/{$fileName}.php";

        if (file_exists($target)) {
            return $this->error('Middleware already exists');
        }

        $stub = $this->generateStub('middleware', [
            'DummyClass' => $fileName,
            'DummyNamespace' => $namespace
        ]);

        file_put_contents($target, $stub);

        $this->info('Middleware generated');
    }

    /**
     * Command Arguments
     *
     * @return array
     */
    protected function arguments() : array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the middleware to generate']
        ];
    }

    /**
     * Command Options
     *
     * @return array
     */
    protected function options() : array
    {
        return [
            //
        ];
    }
}
