<?php

$callStack = [];
fib(4);

function fib($n)
{
    pushIntoStack(func_get_args());

    if ($n <= 1) {
        echo PHP_EOL . "Return: $n" . PHP_EOL;
        popFromStack(__FUNCTION__, $n);
        return $n;
    }
    $result = fib($n - 1) + fib($n - 2);
    popFromStack(__FUNCTION__, $result);
    return $result;
}

function pushIntoStack($args)
{
    global $callStack;
    $backtrace = debug_backtrace();

    $currentFunction = $backtrace[1]['function'];
    $callerName = isset($backtrace[2]) ? $backtrace[2]['function'] : 'main';
    $callerArgs = isset($backtrace[2]) ? json_encode($backtrace[2]['args']) : '[]';
    $args = json_encode($args);

    array_push($callStack, "$currentFunction($args)");
    echo PHP_EOL . "Push: {$currentFunction}($args) called by $callerName($callerArgs)" . PHP_EOL;
    displayStack($callStack);
}
function popFromStack($function, $returnValue)
{
    global $callStack;
    
    echo PHP_EOL . "Return: {$function} with result $returnValue" . PHP_EOL;
    array_pop($callStack);
    displayStack($callStack);
}
function displayStack($stack)
{
    echo "Current Stack: " . json_encode($stack) . PHP_EOL;
}
