<?php

require '../controller/request.php';

// 新規登録
$request = $_POST;
$createClass = new requestProcess();
$res = $createClass->create($request);

echo json_encode($res);