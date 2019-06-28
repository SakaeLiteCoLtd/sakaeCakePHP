<?php
/**csv2table.php
 * CSV形式ファイルを HTML TABLE に変換する
 * @copyright	(c)studio pahoo
 * @author		パパぱふぅ
 * @動作環境	PHP 4/5/7
 * @参考URL		http://www.pahoo.org/e-soul/webtech/php01/php09-01.shtm
*/
// 初期化処理 ================================================================
define('INTERNAL_ENCODING', 'UTF-8');
mb_internal_encoding(INTERNAL_ENCODING);
mb_regex_encoding(INTERNAL_ENCODING);
define('MYSELF', basename($_SERVER['SCRIPT_NAME']));
define('REFERENCE', 'http://www.pahoo.org/e-soul/webtech/php01/php09-01.shtm');

//プログラム・タイトル

$encode = INTERNAL_ENCODING;
echo <<< EOD
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="{$encode}">
<title>CSV形式ファイルを HTML TABLE に変換する</title>
</head>
<body>

EOD;
$delimiter = ',';					//CSV区切り文字
$warning = '';						//警告文

//【１】ファイル入力 =========================================================
if (isset($_FILES['file']['tmp_name']) == FALSE) {

	echo <<< EOT
<form method="post" action="indexcsv" enctype="multipart/form-data">
<table align="center" cellpadding="0" cellspacing="0">
<br>
<td style="border:1px solid; bordercolor: #000000; background-color: #FFFFFF; border-right: 0px;"><input name="file" type="file" size="80" /></td>
<td style="border:1px solid; bordercolor: #000000; background-color: #FFFFFF;"><input type="submit" name="submit" value="変換" /></td>
</table>
</form>


<table align="center">
<div style="border-style:solid; background-color: #FFFFFF; border-width:1px; margin:20px 0px 0px 0px; padding:5px; width:1000px; font-size:small;">
<h3>使い方</h3>
<ol>
<li>[<span style="font-weight:bold;">参照</span>] をクリックするとファイルダイアログが表示されるので、目的のCSVファイル（カンマ区切り）を選択してください。</li>
<li>[<span style="font-weight:bold;">変換</span>] をクリックしてください。
<li>表形式で表示されます。</li>
</ol>
</div>
</table>

EOT;
//【２】変換・結果出力 =======================================================
} else {
	if ($_FILES['file']['size'] == 0) {
		echo 'Error! - 指定したファイルが見あたりません';
		exit(1);
	}
	$source_file = $_FILES['file']['tmp_name'];		//アップされたCSVファイル
	if (($infp  = fopen($source_file, 'r')) == FALSE) {
		echo 'Error! - サーバ・トラブルが発生しました';
		exit(1);
	}

	//ロケール設定
	$str = fgets($infp);
	if (($enc = mb_detect_encoding($str)) == FALSE) {
		echo 'Error! - 文字コードが判定できません';
		exit(1);
	}
	//WindowsなどではFALSEでも正常に変換できる
	if (setlocale(LC_ALL, 'ja_JP.' . $enc) == FALSE) {
		$warning = '<li>Warning! - OSがロケール ' . 'ja_JP.' . $enc . ' に対応していません．</li>';
	}
	fseek($infp, 0);	//読み込みポインタを先頭へ戻す

	//CSVファイルの読み込み
	echo "<br>\n";
	echo "<table cellspacing=0 style=\"border: 1px solid black; background-color: #FFFFFF;\">\n";
	while (($csv = fgetcsv($infp, 1000, $delimiter)) !== FALSE) {
		print "<tr>\n";
		foreach ($csv as $key=>$val) {
			if ($val == '')		$val ='&nbsp';	//デリミタ間にデータが存在しない場合は空白出力
			$val = mb_convert_encoding($val, INTERNAL_ENCODING, 'auto');	//コード変換
			echo "<td style=\"border:0px solid; border-width:0.5px; bordercolor: #000000; background-color:#FFFFFF;\">{$val}</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>";

	fclose($infp);
}

$version = phpversion();
echo <<< EOT
<div style="border-style:solid; background-color: #FFFFFF; border-width:1px; margin:20px 0px 0px 0px; padding:5px; width:1000px; font-size:small;">
<h3>補足情報</h3>
<ol>
<li>PHPバージョン： {$version}</li>
<li>CSVファイルのエンコード： {$encode}</li>
{$warning}
</ol>
</div>
</body>
</html>

EOT;
/*
** バージョンアップ履歴 ===================================================
 *
 * @version 1.52  2017/07/01  setlocaleのエラー判定、PHPバージョン表示
 * @version 1.51  2014/07/20  bug-fix:setlocale処理追加
 * @version 1.5   2014/07/19  HTML5対応
 * @version 1.4   2007/10/20  コード自動判別
 * @version 1.3   2007/06/13  デリミタ間にデータが存在しない場合は空白出力
 * @version 1.2   2007/02/11  XSS対策
 * @version 1.1   2006/11/29  CSVファイルから読み込むためのループ制御修正、他
 * @version 1.0   2004/12/25
*/
?>
