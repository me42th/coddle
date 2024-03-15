<?php
namespace Me42th\Coddle\Commands;
use Me42th\Coddle\Traits\GenerateTrait;

class GenerateCommand extends DefaultCommand {
    use GenerateTrait;
    static $name = 'generate:command';
    static $description = 'Generate your commands';
    static $help = 'Will create what you need';
    static $args = ['*name:Name of the command'];
    static $options = [];

    public function handle():void
    {
        $name = $this->arg('name');
        $status = $this->action($name);
    }
}