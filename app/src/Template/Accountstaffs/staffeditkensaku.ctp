<?php
$this->layout = 'defaultaccount';
?>

<?php
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
?>
<?php
    $htmlShinkimenu = new htmlShinkimenu();
    $htmlaccountmenus = $htmlShinkimenu->accountmenus();
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
       echo $htmlaccountmenus;
  ?>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/stafftouroku.gif',array('width'=>'105','url'=>array('action'=>'staffmenu')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/chokusoushinki.gif',array('width'=>'105','url'=>array('action'=>'staffaddform')));?></td>
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/yobidashiyellow.gif',array('width'=>'105','url'=>array('action'=>'staffeditkensaku')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">

<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="http://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<?php
$arrStaffs_list = json_encode($arrStaffs_list);//jsに配列を受け渡すために変換
?>

<script>

$(function() {
      // 入力補完候補の単語リスト
      let wordlist = <?php echo $arrStaffs_list; ?>
      // 入力補完を実施する要素に単語リストを設定
      $("#staffs_list").autocomplete({
        source: wordlist
      });
  });

</script>

    <?= $this->Form->create($user, ['url' => ['action' => 'staffkensakusyousai']]) ?>
    <fieldset>

      <br>
      <div align="center"><font color="red" size="3"><?= __($mess) ?></font></div>
      <div align="center"><font color="black" size="3"><?= __("データを呼び出す社員名を「姓_名」の形で入力してください。") ?></font></div>
      <br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td width="200" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">姓_名</strong></td>
	</tr>
  <tr>
    <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= $this->Form->control('name', array('type'=>'text', 'label'=>false,'id'=>"staffs_list",  'autofocus'=>true, 'required'=>true)) ?></td>
	</tr>
</table>

    </fieldset>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr>
      <td style="border-style: none;"><div align="center"><?= $this->Form->submit(__('次へ'), array('name' => 'kakunin')); ?></div></td>
    </tr>
  </table>
<br>
