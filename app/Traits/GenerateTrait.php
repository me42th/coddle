<?php
namespace Me42th\Coddle\Traits;
use Me42th\Coddle\Exceptions\CommandAlreadyCreatedException;

trait GenerateTrait {
    public function action(string $name):void
    {
        $flag = $this->hasCommand($name) || $this->hasTrait($name);
        if($flag){
            throw new CommandAlreadyCreatedException('Your command or trait already been created, choose another name');
        }
        $this->createTrait($name);
        $this->createCommand($name);
    }

    private function createCommand(string $name){
        $this->createFile($name,'command');
    }

    private function createTrait(string $name){
        $this->createFile($name,'trait');
    }

    private function createFile(string $name,string $type){
        $stub = STUB_PATH;
        $stub.= "$type.stub";
        $stub = file_get_contents($stub);
        $file_content = str_replace('{name}',ucfirst($name),$stub);
        $file_name = $type === 'trait'?TRAIT_PATH:COMMAND_PATH;
        $file_name.=ucfirst($name).ucfirst($type).'.php';
        file_put_contents($file_name,$file_content);
    }

    private function hasCommand(string $name){
        return $this->hasFile($name,'command');
    }


    private function hasTrait(string $name){
        return $this->hasFile($name,'trait');
    }

    private function hasFile(string $name, string $type){
        $path = $type === 'trait'?TRAIT_PATH:COMMAND_PATH;
        $type = ucfirst($type);
        $name = strtolower($name);
        $name = ucfirst($name);
        return file_exists("$path$name$type.php");
    }
}