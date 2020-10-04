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
          echo $this->Form->create($KensahyouHeads, ['url' => ['action' => 'typeimtaiouform']]);
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

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
            <tr style="background-color: #E6FFFF">
              <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/button_pana.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'typeyobidashipana')));?></td>
            </tr>
</table>

<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/mark_p0001.gif',array('width'=>'70','height'=>'36','url'=>array('action'=>'typeyobidashipanap0')));?></td>
      <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/mark_p1000.gif',array('width'=>'70','height'=>'36','url'=>array('action'=>'typeyobidashipanap1')));?></td>
        <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/mark_p2000.gif',array('width'=>'70','height'=>'36','url'=>array('action'=>'typeyobidashipanap2')));?></td>
  </tr>
  <br><br>
  <tr style="background-color: #E6FFFF">
    <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/mark_w.gif',array('width'=>'70','height'=>'36','url'=>array('action'=>'typeyobidashipanaw')));?></td>
      <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/mark_h.gif',array('width'=>'70','height'=>'36','url'=>array('action'=>'typeyobidashipanah')));?></td>
        <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/mark_re.gif',array('width'=>'70','height'=>'36','url'=>array('action'=>'typeyobidashipanare')));?></td>
  </tr>
</table>

<br><br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-style: none;">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#E6FFFF">
      <?php for($i=0; $i<count($arrProduct); $i++): ?>
      <tr>
          <td class="actions" style="border-style: none; color:#ff0000; text-decoration: underline;">
              <?= $this->Html->link(__($arrProduct[$i]["product_code"]), ['action' => 'typeimtaiouform',  'name' => $arrProduct[$i]["product_code"]]) ?>
          </td>
          <td style="border-style: none;"><?= h($arrProduct[$i]["product_name"]) ?></td>
      </tr>
    <?php endfor;?>
</table>
