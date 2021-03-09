<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

$this->Products = TableRegistry::get('products');//productsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($KensahyouHeads, ['url' => ['action' => 'hyouji']]);
?>
<?php
 use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
 $htmlSyukkakensamenu = new htmlSyukkakensamenu();
 $htmlKouteismenus = $htmlSyukkakensamenu->Kouteismenu();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKouteismenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

 <br>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tr>
     <td bgcolor="#FFFFCC" style="width: 50px;border-bottom: solid;border-width: 1px">品番</td>
     <td bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px"><?= $this->Form->control('product_code', array('type'=>'text', 'label'=>false, 'autofocus'=>true)) ?></td>
     <td style="border-style: none"><div align="center"><?= $this->Form->submit(__('検索'), array('name' => 'kakunin')); ?></div></td>
 	</tr>
 </table>
<br><br>
