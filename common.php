<?php
function connect_db(){

  $dns="mysql:host=localhost;dbname=upfile_sample;charset=utf8";
  $username="root";
  $password="";
  $options=[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ];
  return new PDO($dns,$username,$password,$options);
}

function insert($sql,$arr=[])
{
  $pdo=connect_db();
  $stmt=$pdo->prepare($sql);
  $stmt->execute($arr);
  return $pdo ->lastInsertId();
}

function select($sql,$arr=[])
{
  $pdo = connect_db();
  $stmt = $pdo->prepare($sql);
  $stmt->execute($arr);
  return $stmt->fetchAll();
}

function f($string)
{
  return htmlspecialchars($string,ENT_QUOTES,"utf-8");
}

?>