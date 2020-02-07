<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>

<?php
 use App\myClass\EDImenus\htmlEDImenu;//myClassフォルダに配置したクラスを使用
 $htmlEDImenu = new htmlEDImenu();
 $htmlEDIs = $htmlEDImenu->EDImenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlEDIs;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/keikaku_csv.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'OrderEdis','action'=>'dnpcsv')));?></td>
  </tr>
</table>

<?php if(isset($_FILES['file']['tmp_name']) == FALSE): ?>
  <br><br><br>

  <form method="post" action="keikakucsv" enctype="multipart/form-data">
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="20" style="border-bottom: solid;border-width: 1px" ><input name="file" type="file" size="80" /></td>
          <td colspan="20" style="border-bottom: solid;border-width: 1px"><input type="submit" name="submit" value="登録" /></td>
        </tr>
    </table>
  </form>

  <br>
  <br>

<?php else: ?>

  <br><br>
  <legend align="center"><font color="red"><?= __($mes) ?></font></legend>
  <br>


<?php endif; ?>
