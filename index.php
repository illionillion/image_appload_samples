<?php
//読み込む
require "common.php";

function file_upload()
{
  //POSTでない時は何もしない
  if(filter_input(INPUT_SERVER,"REQUEST_METHOD")!=="POST"){
    return;
  }

  //タイトル
  $title=filter_input(INPUT_POST,"title");
  if(""===$title){
    throw new Exception('タイトルは入力必須です。');
  }
  //アップロードファイル
  $upfile=$_FILES['upfile'];

  if($upfile['error']>0){
    throw new Exception('ファイルアップロードに失敗しました。');
  }

  $tmp_name=$upfile['tmp_name'];

  //ファイルタイプチェック
  $finfo=finfo_open(FILEINFO_MIME_TYPE);
  $mimetype = finfo_file($finfo, $tmp_name);

  //許可するMINETYPE
  $allowed_types=[
    'jpg'=>'image/jpeg',
    'png'=>'image/png',
    'gif'=>'image/gif'
  ];
  if(!in_array($mimetype,$allowed_types)){
    throw new Exception('許可されていないファイルタイプです。');
  }

  // ファイル名（ハッシュ値でファイル名を決定するため、同一ファイルは同盟で上書きされる）
  $filename = sha1_file($tmp_name);

  //拡張子
  $ext=array_search($mimetype,$allowed_types);

  //保存先ファイルパス
  $destination=sprintf('%s/%s.%s',
  'upfile',
  $filename,
  $ext
  );

  //アップロードディレクトリに移動
  if(!move_uploaded_file($tmp_name,$destination)){
    throw new Exception('ファイルの保存に失敗しました。');
  }

  //Exif 情報の削除

  // $imagick=new Imagick($destination);
  // $imagick->stripimage();
  // $imagick->writeimage($destination);

  //データベースに登録
  $sql='INSERT INTO `images` (`id`, `title`, `path`) VALUES (NULL, :title, :path) ';
  $arr=[];
  $arr[":title"]=$title;
  $arr[":path"]=$destination;
  $lastInsertId=insert($sql,$arr);

  //成功時にページを遷移
  header(sprintf("Location:image.php?id=%d",$lastInsertId));
 } 
 
 try{
    //ファイルのアップロード
    file_upload();
  }catch(Exception $e){
    $error=$e->getMessage();
  }

?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ファイルアップロード</title>
  <style type="text/css">
    .error {
        color: red;
    }
  </style>
</head>
<body>
  <div id="wrap">
    <?php if(isset($error)):?>
      <p class="error"><?=f($error); ?></p>
    <?php endif;?>
  </div>
  <form action="" method="POST" enctype="multipart/form-data">
      <p>
        <label for="title">タイトル</label>
        <input type="text" name="title" id="title">
      </p>
      <p>
        <label for="upfile">画像ファイル</label>
        <input type="file" name="upfile" id="upfile">
      </p>
      <p>
        <button type="submit">送信</button>
      </p>
  </form>
</body>
</html>