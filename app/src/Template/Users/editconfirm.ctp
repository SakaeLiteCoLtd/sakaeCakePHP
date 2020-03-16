<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
 use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

 $htmlShinkimenu = new htmlShinkimenu();
 $htmlShinkis = $htmlShinkimenu->Shinkimenus();
 ?>
<?= $this->Form->create($user, ['url' => ['action' => 'editpreadd']]) ?>
        <?php
            $Data=$this->request->query('s');//1度henkou5panaへ行って戻ってきたとき（検索を押したとき）
            $username = $this->request->Session()->read('Auth.User.username');

            $session = $this->request->getSession();
            $session->write('userdata.id', $Data['id']);
            $session->write('userdata.username', $Data['username']);
            $session->write('userdata.password', $Data['password']);
            $session->write('userdata.role_id', $Data['role_id']);
            $session->write('userdata.staff_id', $Data['staff_id']);
            $session->write('userdata.delete_flag', $Data['delete_flag']);
            $session->write('userdata.created_staff', $Data['created_staff']);
    // /        $session->write('userdata.updated_staff', $Data['updated_staff']);
    if($Data['delete_flag'] == 0){
      $mes = "削除";
    }else{
      $mes = "更新";
    }
        ?>

        <hr size="5">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
        <?php
           echo $htmlShinkis;
        ?>
        </table>
        <hr size="5">

              <p align="center"><?php echo $this->Html->image('ShinkiTourokuMenu/touroku.gif',array('width'=>'157','height'=>'50'));?></p>

<hr size="5">

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('ユーザー名') ?></th>
            <td><?= h($Data['username']) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('パスワード') ?></th>
            <td><?= h('------------') ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('権限') ?></th>
            <td><?= h($Role) ?></td>
        </tr>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
            <th scope="row"><?= __('スタッフ') ?></th>
            <td><?= h($Staff) ?></td>
    </table>
<br>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  <td style="border-style: none;"><div align="center"><?= $this->Form->submit($mes, array('name' => 'kakunin')); ?></div></td>
</tr>
</table>
<br>
<?= $this->Form->end() ?>
