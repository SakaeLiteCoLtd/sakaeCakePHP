<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Roles = TableRegistry::get('roles');//productsテーブルを使う
$this->Staffs = TableRegistry::get('staffs');//productsテーブルを使う
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

$htmlShinkimenu = new htmlShinkimenu();
$htmlShinkis = $htmlShinkimenu->Shinkimenus();
?>
<hr size="5">
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
<?php
   echo $htmlShinkis;
?>
</table>
<hr size="5">
<table width="1500" border="0" bordercolor="#E6FFFF" align="center" cellpadding="0" cellspacing="0" bgcolor="#E6FFFF">
  <tr>
          <tr>
              <br>
              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/shinki_user.gif',array('width'=>'125','height'=>'46'));?></p>
          </tr>
  </tr>
</table>
</body>
</html>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/menu_csv.gif',array('url'=>array('controller'=>'users','action'=>'confirmcsv')));?></p>

<hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/sinnkitouroku.gif',array('url'=>array('controller'=>'users','action'=>'form')));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr  border="2" bordercolor="#E6FFFF" bgcolor="#FFDEAD">
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('ユーザー名') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('権限') ?></th>
                <th scope="col" style="background-color: #FFDEAD"><?= $this->Paginator->sort('スタッフ') ?></th>
                <th scope="col" class="actions" style="background-color: #FFDEAD"><?= __('') ?></th>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFEFD5">
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= h($user->username) ?></td>

            	<?php
                    $role_id = $user->role_id;//$userのrole_idに$role_idと名前をつける
            		$Role = $this->Roles->find()->where(['id' => $role_id])->toArray();//'id' => $role_idとなるデータをRolesテーブルから配列で取得
            		$user_role = $Role[0]->name;//配列の0番目（0番目しかない）のnameに$user_roleと名前を付ける
            	?>

                <td><?= h($user_role) ?></td>

            	<?php
                    $staff_id = $user->staff_id;//$userのrole_idに$role_idと名前をつける
            		$Staff = $this->Staffs->find()->where(['id' => $staff_id])->toArray();//'id' => $role_idとなるデータをRolesテーブルから配列で取得
            		$user_staff = $Staff[0]->f_name.$Staff[0]->l_name;//配列の0番目（0番目しかない）のnameに$user_roleと名前を付ける
            	?>

                <td><?= h($user_staff) ?></td>

                <td class="actions">
                    <?= $this->Html->link(__('編集'), ['action' => 'edit', $user->id]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
