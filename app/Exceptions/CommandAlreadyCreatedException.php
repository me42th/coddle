<?php
namespace Me42th\Coddle\Exceptions;

class CommandAlreadyCreatedException extends \Exception{

    public function __construct(string $msg){
        parent::__construct($msg);
    }
}