<?php

namespace App\Console\Commands;

use App\Console\Command;
use App\Console\Traits\Generatable;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MailableGeneratorCommand extends Command
{
    use Generatable;

    /**
     * Command Name
     *
     * @var string
     */
    protected $command = 'make:mail';

    /**
     * Command Description
     *
     * @var string
     */
    protected $description = 'Genereate Mailable Command';

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
        $base = __DIR__ . '/../';
        $path = $base . '/';
        $namespace = 'App\\Mail';

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
            return $this->error('Maiable already exists');
        }

        $stub = $this->generateStub('mailable', [
            'DummyClass' => $fileName,
            'DummyNamespace' => $namespace,
        ]);

        file_put_contents($target, $stub);

        $this->info('Mailable generated');
    }

    /**
     * Command Arguments
     *
     * @return array
     */
    protected function arguments() : array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the command to generate']
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
