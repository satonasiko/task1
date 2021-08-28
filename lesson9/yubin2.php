<?php
$yubin = $_GET['post'];

$fp = fopen("../../KEN_ALL.CSV", "r") or die("ファイルが開けません");

while( !feof($fp)) { //一行ずつ読み込んで回している
   $line = fgetcsv($fp); // fgetcsv() は行を CSV フォーマットのフィールドとして読込み処理を行い、 読み込んだフィールドを含む配列を返す
   if (empty($line)) { //$lineが空になったらbreakしないと空の行が取得できてしまい配列が１つもない$lineが生成されそんな配列番号は無いと言われる
   break;
   }
   $line_utf8 = mb_convert_encoding($line, "UTF-8", "SJIS");
   if ($line_utf8[2] == $yubin) { //while( !feof($fp) )で一行ずつ読み込んでいってる中で$yubinと一致した行(配列)があった→読み込み済みの配列の6.7.8番目を表示した
      echo $line_utf8[6].$line_utf8[7].$line_utf8[8]."<br>"; //同じ郵便番号で複数の住所を持つものもあるので改行を入れる
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
   <form action = "yubin2.php" method = "GET">
      <input type = "text" name ="post" value="<?php if (isset($postnum) === TRUE){print $postnum;}?>"><br/>
      <input type = "submit" value ="検索">
   </form>
</body>
</html>

