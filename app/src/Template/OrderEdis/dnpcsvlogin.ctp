<?php
error_reporting(0);
?>
<?php
$arrusername = array();
$arrusername[] = $username;
$arrusername[] = $delete_flag;

 use App\myClass\Logins\htmlLogin;
 $htmlPrelogin = new htmlLogin();
 $htmlLoginview = $htmlPrelogin->Loginview($arrusername);
?>

<?php if ($username != "" && strlen($delete_flag) > 0): ?>

  <?= $this->Form->create() ?>
  <?php
     echo $htmlLoginview;
  ?>
  <?= $this->Form->end() ?>

<?php else : ?>

  <?php
     echo $htmlLoginview;
  ?>

<?php endif; ?>
