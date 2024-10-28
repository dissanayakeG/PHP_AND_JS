<?php

$callStack = [];

$grid = [
    ['1', '1', '0', '1'],
    ['1', '0', '0', '0'],
    ['0', '0', '1', '0'],

];

countIslands($grid);

function countIslands(&$grid)
{
    $numIslands = 0;
    for ($i = 0; $i < count($grid); $i++) {
        for ($j = 0; $j < count($grid[0]); $j++) {
            if ($grid[$i][$j] === '1') {
                $numIslands++;
                dfs($grid, $i, $j);
            }
        }
    }
    return $numIslands;
}

function dfs(&$grid, $i, $j, $way = 'initial call')
{
    if ($i < 0 || $j < 0 || $i >= count($grid) || $j >= count($grid[0]) || $grid[$i][$j] === '0') {
        return;
    }
    $grid[$i][$j] = '0';

    callStackPush(__FUNCTION__, [$i, $j, $way]);

    dfs($grid, $i + 1, $j, 'down'); // Down
    dfs($grid, $i - 1, $j, 'up'); // Up
    dfs($grid, $i, $j + 1, 'right'); // Right
    dfs($grid, $i, $j - 1, 'left'); // Left

    callStackPop(__FUNCTION__, "visited ($i, $j)");
}
function callStackPush($function, $args)
{
    global $callStack;
    $backtrace = debug_backtrace();
    $currentFunction = $backtrace[1]['function'];
    $callerName = isset($backtrace[2]) ? $backtrace[2]['function'] : 'main';
    $callerArgs = isset($backtrace[2]) ? $backtrace[2]['args'] : '[]';

    $callerCoordinates = '';
    if (isset($callerArgs[1]) && isset($callerArgs[2])) {
        $callerCoordinates = "$callerArgs[1], $callerArgs[2]";
    }

    $argsJson = json_encode($args);
    array_push($callStack, "$currentFunction($argsJson)");

    echo PHP_EOL . "Push: {$currentFunction}($argsJson) called by $callerName($callerCoordinates)" . PHP_EOL;
    displayStack($callStack);
}

function callStackPop($function, $returnValue)
{
    global $callStack;
    echo PHP_EOL . "Return: {$function} with result $returnValue" . PHP_EOL;
    array_pop($callStack);
    displayStack($callStack);
}

function displayStack($stack)
{
    $stackText = "[" . implode(", ", $stack) . "]";
    echo "Current Stack: $stackText" . PHP_EOL;
}
