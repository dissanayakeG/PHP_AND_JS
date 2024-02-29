<?php

//stdClass
$stdClass = new \stdClass();
$stdClass->a = 10;

var_dump($stdClass);

//JSON to stdClass
$json = '{"a":1,"b":2, "c":3}';
// $obj = json_decode($json, true); //print array
$obj = json_decode($json); //print std class
var_dump( $obj);
var_dump( $obj->a);


//CASTING to stdClass

//casting arrays
$arr = (object)[1,2,3]; //this also print a std class
var_dump($arr);
var_dump($arr->{1}); //need to use {} to access 


//casting integer

$intObj = (object) 1;
var_dump($intObj, $intObj->scalar);
