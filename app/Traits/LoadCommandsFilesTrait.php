<?php
namespace Me42th\Coddle\Traits;

trait LoadCommandsFilesTrait
{

    public function loadCommands():array{

        $command_files = $this->getFiles();
        $commands = [];
        foreach($command_files as $file){
            [$name,$class] =  $this->getSignature($file);
            $commands[$name] = [
                'class' => $class
            ];
        }
        return $commands;
    }

    private function getFiles(){
        $command_files = scandir(COMMAND_PATH);
        foreach($command_files as $key => &$file){
            $unset_flag = $file === '.';
            $unset_flag = $file === '..' || $unset_flag;
            $unset_flag = $file === 'DefaultCommand.php' || $unset_flag;
            if($unset_flag){
                unset($command_files[$key]);
            }
        }
        return $command_files;
    }

    private function getSignature($file){
        $path = "Me42th\Coddle\Commands\\";
        $file = str_replace('.php','',$file);
        $file = $path.$file;
        return [$file::$name,$file];
    }
}