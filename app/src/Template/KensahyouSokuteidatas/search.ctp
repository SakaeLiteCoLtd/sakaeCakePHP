<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouHeadsテーブルを使う
?>
<?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
//          echo $this->Form->create($kensahyouSokuteidatas, ['url' => ['action' => 'index']]);
          $i = 0;

          $dateYMD = date('Y-m-d');
          $dateYMD1 = strtotime($dateYMD);
          $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));
?>
<hr size="5" style="margin: 0.5rem">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <?php
   use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
   $htmlSyukkakensamenu = new htmlSyukkakensamenu();
   $htmlSyukkakensamenus = $htmlSyukkakensamenu->Syukkakensamenu();
   ?>
<?php
   echo $htmlSyukkakensamenus;
?>
</table>
<hr size="5" style="margin: 0.5rem">

<br>
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_pana.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidashipana')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_dnp.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidashidnp')));?></td>
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_others.gif',array('width'=>'85','height'=>'36','url'=>array('controller'=>'KensahyouSokuteidatas','action'=>'yobidashiothers')));?></td>
            </tr>
</table>

<div align="center">
     <?=$this->Form->create() ?>
     <fieldset>
<div align="center"><strong><font color="blue"><?php echo "製造年月日";?></font></strong></div>
            <?=$this->Form->create('TimeSearch', ['url' => ['action' => 'search', 'type' => 'post']])?>
            <?=$this->Form->input("start", array('type' => 'date', 'monthNames' => false, 'value' => $dayye)); ?>
            <?=$this->Form->input("end", array('type' => 'date', 'monthNames' => false, 'value' => $dateYMD)); ?>
            <?=$this->Form->hidden("product_code", array('type' => 'value', 'value' => $product_code)); ?>
<br>
     <?= $this->Form->button(__('絞り込み')) ?>
     </fieldset>

<div align="center"><strong><font color="blue"><?php echo $mes;?></font></strong></div>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
              <td><?php echo "ロット番号";?></td>
              <td><?php echo "製造年月日";?></td>
              <td><?php echo "品番";?></td>
              <td><?php echo "品名";?></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFFF">
            <?php foreach ($uniquearrP as $uniquearrP): ?>
            <tr>
                <?php
                $Product = $this->Products->find()->where(['product_code' => $uniquearrP['product_code']])->toArray();
                $Productname = $Product[0]->product_name;
        //        $i = $i + 1;//表示する個数を調整できる
                ?>
                <?php if($i <= 20): ?>
                <td><?php echo $this->Html->link($uniquearrP['lot_num'], ['action'=>'view', 'name' => $uniquearrP['product_code'], 'value1' => $uniquearrP['lot_num'], 'value2' => $uniquearrP['manu_date']]); ?></td>
                <td><?= h($uniquearrP['manu_date']) ?></td>
                <td><?= h($uniquearrP['product_code']) ?></td>
                <td><?= h($Productname) ?></td>
                <?php else: ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
     <?= $this->Form->end() ?>
</div>
<br><br><br><br><br><br><br><br><br><br>
