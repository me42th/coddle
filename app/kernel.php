<?php

const COMMAND_PATH = __DIR__.DS.'Commands'.DS;
const TRAIT_PATH = __DIR__.DS.'Traits'.DS;
const STUB_PATH = __DIR__.DS.'Stubs'.DS;
const TEST_PATH = __DIR__.DS.'..'.DS.'tests'.DS.'Unit'.DS;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.DS.'..');
$dotenv->load();

$application = new Symfony\Component\Console\Application(
    env('APP_NAME','Coddle'),
    env('APP_VERSION','0.0.1')
);
$application->setCommandLoader(new Me42th\Coddle\Services\CommandLoader);
try{
    $application->run();
} catch(Throwable $t){
    echo $t->getMessage().PHP_EOL;
}