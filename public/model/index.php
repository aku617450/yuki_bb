<?php

require '../controller/request.php';

$createClass = new requestProcess();
$res = $createClass->index();

echo json_encode($res);