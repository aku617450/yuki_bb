<?
/**
 * DB接続
 */
try{
  $dsn = 'mysql:dbname=manual;host=db;charset=utf8';
  $user = 'root';
  $password = 'root';
  $pdo = new PDO($dsn, $user, $password);
}catch (PDOException $e){
  print('Error:'.$e->getMessage());
}