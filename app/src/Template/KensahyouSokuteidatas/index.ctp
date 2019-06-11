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
          echo $this->Form->create($kensahyouSokuteidatas, ['url' => ['action' => 'search']]);
?>
<br>
    <table align="center" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
            <?php foreach ($kensahyouSokuteidatas as $KensahyouSokuteidata): ?>
            <tr>
                <?php
                    $Productcode = $KensahyouSokuteidata->product_code;
                    $Product = $this->Products->find()->where(['product_code' => $Productcode])->toArray();
        	        $Productname = $Product[0]->product_name;
                ?>
                <td><button style="color:#0000ff;background-color:#E6FFFF;margin:0rem" type="hidden" name="<?php echo $Productname;?>" value="<?php echo $Productcode;?>"><?php echo $Productcode;?></button></td>
                <td><?= h($Productname) ?></td>
            </tr>
            <?php endforeach; ?>
    </table>
<br>
<br>
