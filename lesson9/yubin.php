<?php

// シフトJISファイルを読み込み、UTF-8に変換
$data= file_get_contents("../../KEN_ALL.CSV"); 
$str = mb_convert_encoding($data,"utf-8","sjis");
$rows = explode("\n", $str);
//echo $str; 

//郵便番号取得
if(isset($_GET["post"])) {
$postnum = $_GET["post"];
//echo $postnum;
}

for ($i = 0; $i < count($rows); $i++) {
    if (empty($rows[$i])) break;
    $value = explode(",", $rows[$i]);
    $value = str_replace('"', '', $value);
    if ($value[2] == $postnum) {
        echo $value[6].$value[7].$value[8]."<br>";
    }
}
error_reporting(E_ALL & ~E_NOTICE);

/*if(is_numeric($_POST["postcode"])) {
$csv_data = array();
$csv_file = "../../KEN_ALL.CSV";
//$fp = fopen($csv_file, "r") or die ("ファイルが開けません");
while(!== FALSE) {
if(area_search($_POST["postcode", $csv_data])){
}
}
fclose($fp);

$address = $csv_data[0][6] . $csv_data[0][7];
$address . = ($csv_data[0][8] == '以下に掲載がない場合') ? '';
$csv_data[0][8];
}
*/
?>
<!doctype html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>Yubin</title>
</head>
<body>

<h1>郵便番号検索</h1>
<form action = "yubin.php" method = "GET">
<input type = "text" name ="post" value="<?php if (isset($postnum) === TRUE){print $postnum;}?>"><br/>
<input type = "submit" value ="検索">
</form>

    
</body>
</html>

