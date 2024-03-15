<?php
namespace Me42th\Coddle\Services;

use Symfony\Component\Console\CommandLoader\CommandLoaderInterface as CommandContract;
use Symfony\Component\Console\Exception\CommandNotFoundException;
use Me42th\Coddle\Commands\DefaultCommand;
use Me42th\Coddle\Traits\LoadCommandsFilesTrait;

class CommandLoader implements CommandContract
{
        use LoadCommandsFilesTrait;

        public function __construct()
        {
            $this->commands = $this->loadCommands();
        }

        public function get(string $name): DefaultCommand
        {
            $class = $this->commands[$name]['class'];
            return new $class;
        }

        public function has(string $name): bool
        {
            return array_key_exists($name, $this->commands);
        }

        public function getNames(): array
        {
            return array_keys($this->commands);
        }
}