<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();
 ?>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
$arrMaterial_list = json_encode($arrMaterial_list);//jsに配列を受け渡すために変換
$arrProduct_list = json_encode($arrProduct_list);//jsに配列を受け渡すために変換
?>

<script>

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
      <?= $this->Form->control('materialgrade_color', array('type'=>'text', 'label'=>false, 'id'=>"material_list", 'autofocus'=>true)) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">端材ステイタス</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= $this->Form->input("status_material", ["type"=>"select", "options"=>$arrStatusMaterial, 'label'=>false, 'required'=>true]) ?>
    </td>
	</tr>
</table>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">数量（kg）</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem">
      <?= $this->Form->control('amount', array('type'=>'text', 'label'=>false, 'pattern'=>'^[0-9.]+$', 'title'=>'半角数字で入力して下さい。', 'required'=>true)) ?>
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
