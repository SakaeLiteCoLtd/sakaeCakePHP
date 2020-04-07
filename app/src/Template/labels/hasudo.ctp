<?php
 use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
 $htmlLabelmenu = new htmlLabelmenu();
 $htmlLabels = $htmlLabelmenu->Labelmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabels;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <?php
   $username = $this->request->Session()->read('Auth.User.username');
   use Cake\ORM\TableRegistry;//独立したテーブルを扱う
   $this->Products = TableRegistry::get('products');//productsテーブルを使う
   $this->Konpous = TableRegistry::get('konpous');//productsテーブルを使う
?>
<?php
header('Expires:-1');
header('Cache-Control:');
header('Pragma:');

$data = $this->request->getData();
?>

<br><br>
  <div align="center"><font color="red" size="4"><?= __($mes) ?></font></div>
<br><br><br><br><br>
