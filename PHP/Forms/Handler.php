<?php
require '../helpers.php';


$_POST['non_exist'] = 10;


echo '<h3>filter_has_var() , isset()</h3>';
echo '<b>both return true if value exist in $_POST original array</b>';

dump('exist-->', filter_has_var(INPUT_POST, 'input'), 'exist-->', isset($_POST['input']));

echo '<b>filter_has_var consider only the values exist in $_POST original array</b>';
dump('non_exist-->', filter_has_var(INPUT_POST, 'non_exist'), 'non_exist-->', isset($_POST['non_exist']));

echo '<h3>filter_var()</h3>';
echo '<b>filter_var consider later set values as well</b>';

dump('input-->', filter_var($_POST['input'], FILTER_SANITIZE_EMAIL), 'non_exist-->', filter_var($_POST['non_exist'], FILTER_SANITIZE_EMAIL));

echo '<h3>filter_input()</h3>';
echo '<b>filter_input consider only the values exist in $_POST original array</b>';

dump('input-->', filter_input(INPUT_POST, 'input', FILTER_SANITIZE_EMAIL), 'non_exist-->', filter_input(INPUT_POST, 'non_exist', FILTER_SANITIZE_EMAIL));


$clean_id = filter_var($_POST['input'], FILTER_SANITIZE_EMAIL);
$id = filter_var($clean_id, FILTER_VALIDATE_EMAIL);

dump($clean_id, $id);

$clean_input = filter_input(INPUT_POST, 'input', FILTER_SANITIZE_EMAIL);
$valid_id = filter_input(INPUT_POST, 'input', FILTER_VALIDATE_EMAIL);

dump($clean_input, $valid_id);
