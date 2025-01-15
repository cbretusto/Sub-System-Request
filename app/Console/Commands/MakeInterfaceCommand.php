<?php

namespace App\Console\Commands;

// use Illuminate\Console\Command; // Modified by -JD
use Illuminate\Console\GeneratorCommand;

class MakeInterfaceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     * Modified by -JD
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     * Modified by -JD
     *
     * @var string
     */
    protected $description = 'Create a new custom interface';

    /**
     * The type of class being generated.
     * Modified by -JD
     *
     * @var string
     */
    // protected $type = 'class';

    /**
     * Get the stub file for the generator.
     * Modified by -JD
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/interface.stub';
    }

    /**
     * Get the default namespace for the class.
     * Modified by -JD
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Solid\Interfaces';
    }
}