<?php
// require "common.php";



$dsn = 'mysql:dbname=upfile_sample;host=localhost;charset=utf8;';
  $user = 'root';
  $password = '';
  $error_message=null;
  session_start();
  $pdo = new PDO(
    $dsn ,$user ,$password 
  );

  if($pdo){
    // echo "OK";
  }else{
    // echo "NO";
  }

  $sql='SELECT * FROM `images`';
  $stmt=$pdo->query($sql);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIEW</title>
</head>
<body>
  <?php foreach($stmt as $row) {
   
   echo "<p><div>{$row['title']}</div><img src='{$row['path']}' /></p>";
    
  }
  ?>
</body>
</html>