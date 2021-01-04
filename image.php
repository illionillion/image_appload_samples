<?php
  require "common.php";

  try{
    $id=filter_input(INPUT_GET,"id");

    //データベースからレコードを取得
    $sql='SELECT `id`, `title`, `path` FROM `images` WHERE `id` = :id';
    
    $arr=[];
    $arr[":id"]=$id;
    $rows=select($sql,$arr);
    $row=reset($rows);
  }catch(Exception $e){
    $error=$e->getMessage();
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ビュー</title>
  <style>
    .error{
      color:red;
    }
  </style>
</head>
<body>
  <div id="wrap">
  <?php if (isset($error)) : ?>
      <p class="error"><?= f($error); ?></p>
  <?php endif; ?>
    <p><?= f($row['title']); ?></p>
    <p>
      <img src="<?= f($row['path']); ?>" alt="<?= f($row['title']); ?>" />
    </p>
    <a href="./index.php">back</a>
  </div>
</body>
</html>