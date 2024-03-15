<?php
namespace Me42th\Coddle\Commands;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

abstract class DefaultCommand extends Command {
    private $input,$output;

    public function getName():?string{
        return static::$name;
    }

    public function getDescription(): string
    {
        return static::$description;
    }

    public function getHelp(): string
    {
        return static::$help;
    }

    protected function configure() : void
    {
        $this->setArgs();
        $this->setOptions();
    }

    private function setArgs() : void
    {
        foreach(static::$args as $arg){
            if (str_contains($arg, '?')) {
                $required = InputArgument::OPTIONAL;
                $arg = str_replace('?','',$arg);
            } else {
                $required = InputArgument::REQUIRED;
                $arg = str_replace('*','',$arg);
            }
            [$name,$description] = explode(':',$arg);
            $this->addArgument($name, $required, $description);
        }
    }

    private function setOptions() : void
    {
        foreach(static::$options as $option){
            if (str_contains($option, '?')) {
                $value_required = InputOption::VALUE_OPTIONAL;
                $option = str_replace('?','',$option);
            } else if(str_contains($option, '*')){
                $value_required = InputOption::VALUE_REQUIRED;
                $option = str_replace('*','',$option);
            } else {
                $value_required = InputOption::VALUE_NONE;
                $option = str_replace('-','',$option);
            }

            [$name,$description] = explode(':',$option);
            $name = explode(',',$name);
            $this->addOption($name[0],$name[1]??null,$value_required,$description,null);
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try{
            $this->input = $input;
            $this->output = $output;
            $this->handle();
            return self::SUCCESS;
        } catch(Exception $ex){
            return self::ERROR;
        }
    }

    protected final function arg(string $arg_name):?string{
        $value = $this->input->getArgument($arg_name);
        return $value;
    }

    protected final function option(string $option_name):?string{
        $value = $this->input->getOption($option_name);
        return $value;
    }

    private function writeln(string $type, string $text):void{
        $text = "<$type>$text</$type>";
        $this->output->writeln($text);
    }

    protected final function info(string $text):void{
        $this->writeln(type: 'info',text: $text);
    }

    protected final function comment(string $text):void{
        $this->writeln(type: 'comment',text: $text);
    }

    protected final function question(string $text):void{
        $this->writeln(type: 'question',text: $text);
    }

    protected final function error(string $text):void{
        $this->writeln(type: 'error',text: $text);
    }

    abstract protected function handle():void;
}