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

    private function isTest(){
        $argv = $_SERVER['argv']??[];
        return in_array('-t',$argv) || in_array('--test',$argv);
    }

    private function setArgs($test_active = false) : void
    {
        if($this->isTest()){
            return;
        }
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
        $this->addOption('test','t',InputOption::VALUE_NONE,'Run the test for this command',null);
        if($this->isTest()){
            return;
        }
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
            if($this->isTest()){
                $this->executeTest();
            } else {
                $this->handle();
                $this->info("Execution in seconds for {$this}:\t".microtime(true)-CODDLE_INIT);
            }
            return self::SUCCESS;
        } catch(Exception $ex){
            return self::ERROR;
        }
    }

    public function __toString(){
        return $this->getName();
    }

    private function executeTest(){
        $shell_return = '';
        $file_name = $this->test();
        exec("./vendor/bin/pest ./tests/Unit/$file_name.php", $shell_return);
        echo implode("\n",$shell_return);
        $this->ds($file_name,$shell_return);
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
        $this->ds($type,$text);
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

    public function ds($label = null,...$content){
        if(env('DS_ACTIVE',false)){
            $ds = ds(...$content);
            if(!is_null($label)){
                $ds->label($label);
            }
        }
    }

    abstract protected function handle():void;
    protected function test():string
    {
        return ucfirst($this->getName()).'Test';
    }

    public function __destruct(){

    }

    protected function trait(){
        return "Me42th\Coddle\Traits\\".ucfirst($this->getName()).'Trait';
    }
}