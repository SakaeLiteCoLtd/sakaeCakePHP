<?php
 use App\myClass\Genryoumenu\htmlGenryoumenu;//myClassフォルダに配置したクラスを使用
 $htmlGenryoumenu = new htmlGenryoumenu();
 $htmlGenryou = $htmlGenryoumenu->Genryoumenus();

 use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
 $htmlPrelogin = new htmlLogin();
 $htmlPrelogin = $htmlPrelogin->Prelogin();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlGenryou;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/hazaitab.gif',array('width'=>'105','url'=>array('action'=>'torikomilogin')));?></td>
  </tr>
</table>
<hr size="5" style="margin: 0.5rem">
<br>

<?= $this->Form->control('torikomi', array('type'=>'hidden', 'value'=>1, 'label'=>false)) ?>

  <form method="post" action="torikomiselectdo" enctype="multipart/form-data">
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="20" style="border-bottom: solid;border-width: 1px" ><input name="file" type="file" required="true" size="80" /></td>
          <td colspan="20" style="border-bottom: solid;border-width: 1px"><input type="submit" value="登録" /></td>
          <input type="hidden" name="username" value="<?php echo $username; ?>">
        </tr>
    </table>
  </form>

  <br><br>
