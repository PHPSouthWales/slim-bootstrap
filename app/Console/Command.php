<?php

namespace App\Console;

use Interop\Container\ContainerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command as BaseCommand;

abstract class Command extends BaseCommand
{
    protected $input;

    private $output;

    private $container;

    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    protected function configure()
    {
        $this->setName($this->command)->setDescription($this->description);

        $this->addArguments();
        $this->addOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;
        
        return $this->handle($input, $output);
    }

    protected function argument($name)
    {
        return $this->input->getArgument($name);
    }

    protected function option($name)
    {
        return $this->input->getOption($name);
    }

    protected function addArguments()
    {
        foreach ($this->arguments() as $argument) {
            $this->addArgument($argument[0], $argument[1], $argument[2]);
        }
    }

    protected function addOptions()
    {
        foreach ($this->options() as $option) {
            $this->addOption($option[0], $option[1], $option[2], $option[3], $option[4]);
        }
    }

    protected function info(String $value)
    {
        return $this->output->writeln("<info>{$value}</info>");
    }

    protected function error(String $value)
    {
        return $this->output->writeln("<error>{$value}</error>");
    }
}
