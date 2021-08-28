<?

$ head ../../KEN_ALL.CSV | awk 'BEGIN {FS=",";OFS=","} {print $3,$7,$8,$9}' > postdata.csv
$ vi convert.pl

#! /usr/bin/env perl

while (<>) {
    # 行末の改行文字を除去                                                                                                            
    chomp;

    # 各列の値に分割                                                                                                                  
    my ($code, $pref, $city, $town) = split(/,/, $_, 4);

    # 前後のダブルクォーテーションを除去                                                                                              
    $code =~ s/^"(.*?)"$/$1/;
    $pref =~ s/^"(.*?)"$/$1/;
    $city =~ s/^"(.*?)"$/$1/;
    $town =~ s/^"(.*?)"$/$1/;

    # 「（」又は「〔」から後は不要                                                                                                      
    $town =~ s/^(.*?)(（|〔).*$/$1/;

    # 丁目が「場合」で終わる場合、カンマが含まれる場合、「〜」が含まれる場合は全て削除                                            
    if ($town =~ /^(.+に.+場合|.*、.*|.*〜.*)$/) {
        $town = "";
    }

    # タブ区切りで出力
    print "$code\t$pref\t$city\t$town\n";
    }

$ chmod u+x convert.pl # 実行権を付与
$ cat postdata.csv | ./convert.pl > postdata.txt
$ vi get_addr.php

$dataPath = '/path/to/postdata.txt';  // 郵便番号データのパス
$postCode = $_GET['cd'];  // 郵便番号
if (!empty($postCode)) {
    $fp = fopen($dataPath, 'r');
    try {
        while ($line = fgets($fp)) {
            list($code, $pref, $city, $town) = split("\t", $line, 4);
            if ($postCode == $code) {
                header('Content-Type: application/json');
                $data = array('code' => $code, 'pref' => $pref, 'city' => $city, 'town' => $town);
                echo json_encode($data);
                return;
            }
        }
    } finally {
       fclose($fp);
    }
}
http_response_code(404);
?>

<!doctype html>
<head>
  <meta charset="utf-8">
</head>
<body>
  <form>
    <div>
      <label for="post-code">郵便番号</label>
      <input type="text" id="post-code" name="postCode" size="14">
      <button type="button" id="get-addr-btn">住所取得</button>
    </div>
    <div>
      <label for="address">住所</label>
      <input type="text" id="address" name="address" size="50">
    </div>
  </form>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
  <script>
    (function () {
      // 郵便番号の書式チェック
      function validatePostCode(code) {
        return (code && code.match(/^\d{3}-?\d{4}$/));
      }

      // 住所取得ボタンクリック
      $('#get-addr-btn').click(function(e) {
	var code = $('#post-code').val();
	if (validatePostCode(code)){
          code = code.replace('-', '');
          $.ajax({
            url: 'get_addr.php',
            type: 'get',
            dataType: 'json',
            data: { cd: code },
          }).done(function (res) {
            addr = res.pref + res.city + res.town;
            $('#address').focus().val('').val(addr);
          });
	}
      });
    } ());
  </script>
</body>
</html>