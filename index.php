<?php
require('Includes/Hunspell.php');

header('Content-Type: application/json');
$input = array_key_exists('input', $_REQUEST) ? preg_replace('/[^\da-z\s]+/i', '', $_REQUEST['input']) : '';
$hunspell = new Hunspell;
echo json_encode($hunspell->check($input));
