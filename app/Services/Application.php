<?php
namespace Me42th\Coddle\Services;
use Symfony\Component\Console\Application as SymfonyApplication;

class Application extends SymfonyApplication{
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN'){
        parent::__construct($name,$version);
    }
}