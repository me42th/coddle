<?php
namespace Me42th\Coddle\Commands;
use Me42th\Coddle\Traits\GenerateTrait;

class GenerateCommand extends DefaultCommand
{
    use GenerateTrait;
    static $name = 'generate';
    static $description = 'Generate your commands';
    static $help = 'Will create what you need';
    static $args = ['*name:Name of the command'];
    static $options = [];

    public function handle():void
    {
        $name = $this->arg('name');
        $name = strtolower($name);
        $this->action($name);
        $this->info("Created Trait, Command and Test for $name");
    }

    public function test():string
    {
        return 'GenerateTest';
    }
}