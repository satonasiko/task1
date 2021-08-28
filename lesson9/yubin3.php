<?php
$yubin = $_GET['post'];

$fp = fopen("../../KEN_ALL.CSV", "r") or die("ファイルが開けません");


while( !feof($fp)) {
   $line = fgets($fp); //fgets — ファイルポインタから 1 行取得する
   if (empty($line)) {
   break;
   }
   $line_utf8 = mb_convert_encoding($line, "UTF-8", "SJIS");
   $value = explode(",", $line_utf8); //,で分割して配列に格納
   $value = str_replace('"', '', $value); //"を除いて$valueを再定義
   if ($value[2] == $yubin) {
      echo $value[6].$value[7].$value[8]."<br>";
   }
}
fclose($fp);
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Yubin</title>
</head>
<body>

<h1>郵便番号検索</h1>
<form action = "yubin3.php" method = "GET">
<input type = "text" name ="post" value="<?php if (isset($postnum) === TRUE){print $postnum;}?>"><br/>
<input type = "submit" value ="検索">
</form>

    
</body>
</html>

