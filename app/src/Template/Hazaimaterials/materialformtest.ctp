<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');
 ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
$arrMaterial_list = json_encode($arrMaterial_list);//jsに配列を受け渡すために変換
$arrProduct_list = json_encode($arrProduct_list);//jsに配列を受け渡すために変換
?>

<script>

function orgFloor(value, base) {
        return Math.floor(value * base) / base;
}

$(document).ready(function() {
    $("#product_list").focusout(function() {
      var inputNumber = $("#product_list").val();
      var multiplicationResult = inputNumber * 10;
      var dataForLast = $("#material_list").val(multiplicationResult);
    })
});

/*
function orgFloor(value, base) {
        return Math.floor(value * base) / base;
}

$(document).ready(function() {
    $("#product_list").focusout(function() {
      var inputNumber = $("#product_list").val();

      const data = inputNumber; // 渡したいデータ

      $.ajax({
          type: "POST", //　GETでも可
          url: "http://localhost:5000/hazaimaterials/materialformtest", //　送り先
          data: {'データ': data }, //　渡したいデータをオブジェクトで渡す
          dataType : "json", //　データ形式を指定
          scriptCharset: 'utf-8' //　文字コードを指定
      })
      .then(
          function(param){　 //　paramに処理後のデータが入って戻ってくる
              console.log(param); //　帰ってきたら実行する処理
          },
          function(XMLHttpRequest, textStatus, errorThrown){ //　エラーが起きた時はこちらが実行される
              console.log(XMLHttpRequest); //　エラー内容表示
      });
*/
<?php
/*
header('Content-type: application/json; charset=utf-8'); // ヘッダ（データ形式、文字コードなど指定）
$data = filter_input(INPUT_POST, 'データ'); // 送ったデータを受け取る（GETで送った場合は、INPUT_GET）

$product_code = $data;	//　やりたい処理

$Products = $this->Products->find()
->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();
if(isset($Products[0])){
  $auto_grade_color = $Products[0]["grade"]."_".$Products[0]["color"];
}else{
  $auto_grade_color = "";
}

$auto_grade_color = json_encode($auto_grade_color);//jsに配列を受け渡すために変換
*/
?>
/*
      var dataForLast = $("#material_list").val(<?php echo $auto_grade_color; ?>);
    })
});
*/

$(function() {
      // 入力補完候補の単語リスト
      let wordlist = <?php echo $arrMaterial_list; ?>
      // 入力補完を実施する要素に単語リストを設定
      $("#material_list").autocomplete({
        source: wordlist
      });
  });

  $(function() {
        // 入力補完候補の単語リスト
        let wordlist = <?php echo $arrProduct_list; ?>
        // 入力補完を実施する要素に単語リストを設定
        $("#product_list").autocomplete({
          source: wordlist
        });
    });

</script>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaigenryou.gif',array('width'=>'105','url'=>array('action'=>'materiallogin')));?></td>
 </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<?= $this->Form->create($stockEndMaterials, ['url' => ['action' => 'materialconfirm']]) ?>
<br>
<div align="center"><font color="red" size="3"><?= __($mess) ?></font></div>
<legend align="center"><font color="black"><?= __("「品番」または「原料グレード_色」を入力してください。") ?></font></legend>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">登録社員</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= h($staff_name) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= $this->Form->control('product_code', array('type'=>'text', 'label'=>false, 'id'=>"product_list", 'autofocus'=>true)) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料グレード_色</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= $this->Form->control('materialgrade_color', array('type'=>'text', 'label'=>false, 'id'=>"material_list")) ?>
    </td>
	</tr>
</table>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('次へ', array('name' => 'next')); ?></div></td>
  </tr>
</table>
<br><br><br><br><br><br><br>
<?= $this->Form->control('username', array('type'=>'hidden', 'value'=>$username, 'label'=>false)) ?>
<?= $this->Form->control('staff_name', array('type'=>'hidden', 'value'=>$staff_name, 'label'=>false)) ?>
