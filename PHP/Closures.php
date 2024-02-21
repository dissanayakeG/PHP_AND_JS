<?php

$c = 10;

function execute($a, $b,  Closure $fn)
{
    return $fn($a, $b);
};

//to use outside variables inside a closure, use #use keyword

$closure = function ($a, $b) use ($c) {
    return $a * $b * $c;
};

//no need in arrow functions
$closureArrow = fn ($a, $b) => $a * $b * $c;


var_dump(execute(1, 2, $closure), execute(1, 2, $closureArrow));
