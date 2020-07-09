<?php
$imgObj = array();
$this->set('imgObj',$imgObj);
?>

<br><br>

<?php if(isset($_SESSION['hyoujitourokudata'])) : ?>

<legend align="center"><strong style="font-size: 12pt; color:red"><?= __("データベースに登録できません。登録済のデータでないか確認してください。") ?></strong></legend>
<br>
<legend align="center"><strong style="font-size: 12pt; color:red"><?= __("※データに誤りがなければ、データ入力画面からもう一度やり直してください。") ?></strong></legend>

<br><br>

<?php
echo "<pre>";
print_r("入力データ\n");
print_r("\n");
print_r($_SESSION['hyoujitourokudata']);
echo "</pre>";

echo "<pre>";
print_r("入力データ（型）\n");
print_r("\n");
var_dump($_SESSION['hyoujitourokudata']);
echo "</pre>";
?>

<?php else : ?>

  <legend align="center"><strong style="font-size: 12pt; color:red"><?= __("データベースに登録できません。登録済のデータでないか確認してください。") ?></strong></legend>
  <br>
  <legend align="center"><strong style="font-size: 12pt; color:red"><?= __("※データに誤りがなければ、データ入力画面からもう一度やり直してください。") ?></strong></legend>

  <br><br>

<?php endif; ?>
