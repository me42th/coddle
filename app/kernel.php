<?php
const COMMAND_PATH = __DIR__.DS.'Commands'.DS;
const TRAIT_PATH = __DIR__.DS.'Traits'.DS;
const STUB_PATH = __DIR__.DS.'Stubs'.DS;
const TEST_PATH = __DIR__.DS.'..'.DS.'tests'.DS.'Unit'.DS;

try{
    (Dotenv\Dotenv::createImmutable(__DIR__.DS.'..'))->load();
    $application = new Symfony\Component\Console\Application(
        env('APP_NAME','Coddle'),
        env('APP_VERSION','0.0.1')
    );
    $application->setCommandLoader(new Me42th\Coddle\Services\CommandLoader);
    $application->run();

} catch(Throwable $t){
    if(env('DS_ACTIVE',false)){
        ds($t->getTraceAsString())->label($t->getMessage());
    }
    throw $t;
}