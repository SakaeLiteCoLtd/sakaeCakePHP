<?php
$this->layout = 'defaultshinki';
?>
<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Deliver $product
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>

 <?php
     $username = $this->request->Session()->read('Auth.User.username');
 ?>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlShinkis;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <br>

 <legend align="center"><strong style="font-size: 14pt; color:blue"><?= __("製品登録") ?></strong></legend>
<?= $this->Form->create($product, ['url' => ['action' => 'confirm']]) ?>
<fieldset>

<?php
   echo $this->Form->hidden('delete_flag');
   echo $this->Form->hidden('created_staff', ['empty' => true]);
   echo $this->Form->hidden('updated_staff');
?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品番</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">品名</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('product_code', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('product_name', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="140" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">グレード</strong></td>
    <td width="140"  bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色番号</strong></td>
    <td width="282" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">色調</strong></td>
	</tr>
  <tr>
    <td width="140" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('m_grade', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
    <td width="140"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('col_num', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
    <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("color", ["type"=>"select","empty"=>"選択してください", "options"=>$arrColor, 'label'=>false, 'required'=>true]) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">原料の種類</strong></td>
    <td width="280" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単価（円/個）</strong></td>
	</tr>
  <tr>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("material_kind", ["type"=>"select","empty"=>"選択してください", "options"=>$arrMultipleCs, 'label'=>false, 'required'=>true]) ?></td>
    <td width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= $this->Form->control('price', array('type'=>'text', 'label'=>false)) ?></td>
    <td width="62" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">円/個</strong></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="250" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">単重</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">金型No.</strong></td>
	</tr>
  <tr>
    <td  width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= $this->Form->control('weight', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
    <td width="62" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">g</strong></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("kataban", ["type"=>"select","empty"=>"選択してください", "options"=>$arrKanagata, 'label'=>false, 'required'=>true]) ?></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" colspan="4" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">SET取り</strong></td>
    <td width="250" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">金型取数</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue"></strong></td>
    <td bgcolor="#FFFFCC" style="border-right-style: none;border-left-style: none;padding: 0.2rem"><input type="radio" name="set_tori" value="0" required><strong style="font-size: 11pt; color:blue">NO</strong></td>
    <td bgcolor="#FFFFCC" style="border-left-style: none;border-right-style: none;padding: 0.2rem"><input type="radio" name="set_tori" value="1" required><strong style="font-size: 11pt; color:blue">YES</strong></td>
    <td bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue"></strong></td>
    <td  width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= $this->Form->control('torisu', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
    <td width="62" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">ヶ取</strong></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="250" colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">入数</strong></td>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">箱No.</strong></td>
	</tr>
  <tr>
    <td  width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= $this->Form->control('irisu', array('type'=>'text', 'label'=>false, 'required'=>true)) ?></td>
    <td width="62" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">ケ</strong></td>
    <td width="280"  bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("id_box", ["type"=>"select","empty"=>"選択してください", "options"=>$arrBox, 'label'=>false, 'required'=>true]) ?></td>
	</tr>
</table>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">ショットサイクル</strong></td>
    <td width="280"  colspan="2" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">外観検査基準時間</strong></td>
	</tr>
  <tr>
    <td width="280" bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('shot_cycle', array('type'=>'text', 'label'=>false)) ?></td>
    <td  width="220" bgcolor="#FFFFCC" style="border-right-style: none;padding: 0.2rem"><?= $this->Form->control('kijyun', array('type'=>'text', 'label'=>false)) ?></td>
    <td width="62" bgcolor="#FFFFCC" style="border-left-style: none;padding: 0.2rem"><strong style="font-size: 13pt; color:blue">分</strong></td>
	</tr>
</table>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="562" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">出荷先</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->input("place_deliver_id", ["type"=>"select","empty"=>"選択してください", "options"=>$arrPlaceDeliver, 'label'=>false, 'required'=>true]) ?></td>
	</tr>
</table>


    </fieldset>

    <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
    <br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
