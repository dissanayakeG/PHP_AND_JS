<?php

$callStack = [];
fib(4);

function fib($n, $args = '')
{
    global $callStack;
    $backtrace = debug_backtrace();
    $function = $backtrace[0]['function'];
    $args = json_encode($backtrace[0]['args']);
    $callerName = isset($backtrace[1]) ? $backtrace[1]['function'] : 'main';
    $callerArgs = isset($backtrace[1]) ? json_encode($backtrace[1]['args']) : '[]';

    array_push($callStack, "$function($args)");
    echo PHP_EOL . "Push: {$function}($args) called by $callerName($callerArgs)" . PHP_EOL;
    displayStack($callStack);

    if ($n <= 1) {
        echo PHP_EOL . "Return: $n" . PHP_EOL;
        array_pop($callStack);
        displayStack($callStack);
        return $n;
    }
    $result = fib($n - 1, 'fib(' . $n . '-1)') + fib($n - 2, 'fib(' . $n . '-2)');

    // Pop the function from the call stack after returning
    echo PHP_EOL . "Return: {$function}($args)" . PHP_EOL;
    array_pop($callStack);
    displayStack($callStack);
    return $result;
}

function displayStack($stack)
{
    echo "Current Stack: " . json_encode($stack) . PHP_EOL;
}
