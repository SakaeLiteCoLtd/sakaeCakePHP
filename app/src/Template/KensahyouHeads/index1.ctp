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
?>

<?=$this->Form->create($entity, ['url' => ['action' => 'version']]) ?>

<br>
<br>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
		<td bgcolor="#FFDEAD" style="width: 50px">品番</td>
		<td bgcolor="#FFDEAD"><?= $this->Form->control('product_code', array('type'=>'text', 'label'=>false)) ?></td>
	</tr>
</table>

<br>
    <center><?= $this->Form->button(__('select'), array('name' => 'kakunin')) ?></center>
<br>
</fieldset>

<?=$this->Form->end() ?>
