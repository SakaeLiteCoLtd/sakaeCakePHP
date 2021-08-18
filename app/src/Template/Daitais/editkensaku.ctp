<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>

 <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
 <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
 <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <?php
 $arrMaterial_list = json_encode($arrMaterial_list);//jsに配列を受け渡すために変換
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

 </script>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlShinkis;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
   <tr style="background-color: #E6FFFF">
     <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusouhensyuu.gif',array('width'=>'105','url'=>array('action'=>'editkensaku')));?></td>
   </tr>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?=$this->Form->create($Materials, ['url' => ['action' => 'editform']]) ?>
<br>
<div align="center"><font color="red" size="3"><?= __($mess) ?></font></div>
<legend align="center"><font color="black"><?= __("修正する端材を入力してください。") ?></font></legend>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">原料グレード_色</strong></div></td>
    </tr>
    <tr style="border-bottom: 0px;border-width: 0px">
      <td rowspan='2'  height='6' colspan='20'>
        <?= $this->Form->control('materialgrade_color', array('type'=>'text', 'label'=>false, 'id'=>"material_list", 'autofocus'=>true)) ?>
      </td>
    </tr>
</table>
<br>
<table align="center">
  <tr bgcolor="#E6FFFF" >
    <td bgcolor="#E6FFFF" style="border: none"><?= $this->Form->submit(__('検索'), array('name' => 'kensaku')); ?></td>
  </tr>
</table>
</fieldset>
<br><br>

<?=$this->Form->end() ?>
