<?php

function env(string $var, $arg = null):string
{
    return $_ENV[$var]??$arg;
}