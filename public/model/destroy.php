<?php

require '../controller/request.php';

$request = $_POST;
$createClass = new requestProcess();
$res = $createClass->destroy($request);

echo json_encode($res);