<?php
 use App\myClass\menulists\htmlcompanymenu;//myClassフォルダに配置したクラスを使用
 use App\myClass\menulists\htmlloginmenu;//myClassフォルダに配置したクラスを使用
 $htmlcompanymenu = new htmlcompanymenu();
 $htmlcompany = $htmlcompanymenu->Companiesmenus();
 $htmlloginmenu = new htmlloginmenu();
 $htmllogin = $htmlloginmenu->Loginmenu();

 $i = 1;
?>
<?php
     echo $htmllogin;
?>
<?php
     echo $htmlcompany;
?>

<form method="post" action="/companies/deletedo">

<?= $this->Form->create($company, ['url' => ['action' => 'deletedo']]) ?>

<nav class="large-3 medium-4 columns" style="width:70%">
    <?= $this->Form->create($company) ?>
    <fieldset>

      <?= $this->Form->control('id', array('type'=>'hidden', 'value'=>$company['id'], 'label'=>false)) ?>

        <legend><?= __('会社情報削除') ?></legend>
        <br>
        <table align="center">
          <tr align="center"><td style="border:none"><strong style="font-size: 13pt; color:red"><?= __('以下のデータを削除します。よろしければ「削除」ボタンを押してください。') ?></strong></td></tr>
        </table>
        <br>

        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
          <tr>
            <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">会社名</strong></td>
            <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">代表者</strong></td>
        	</tr>
          <tr>
            <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($company['name']) ?></td>
            <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($company['address']) ?></td>
        	</tr>
        </table>
        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
          <tr>
            <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">電話番号</strong></td>
            <td width="280" bgcolor="#FFFFCC" style="font-size: 8pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">FAX</strong></td>
        	</tr>
          <tr>
            <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($company['tel']) ?></td>
            <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($company['fax']) ?></td>
        	</tr>
        </table>
        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
          <tr>
            <td width="560" bgcolor="#FFFFCC" style="font-size: 12pt;padding: 0.2rem"><strong style="font-size: 11pt; color:blue">所在地</strong></td>
        	</tr>
          <tr>
            <td bgcolor="#FFFFCC" style="padding: 0.2rem"><?= h($company['address']) ?></td>
        	</tr>
        </table>

    </fieldset>

    <table align="center">
      <tr>
        <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
        <td style="border-style: none;"><div align="center"><?= $this->Form->submit('決定', array('name' => 'kettei')); ?></div></td>
      </tr>
    </table>

    <?= $this->Form->end() ?>
  </nav>
</form>
