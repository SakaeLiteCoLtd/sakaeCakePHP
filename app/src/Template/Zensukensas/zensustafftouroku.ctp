<?php
 use App\myClass\Zensumenus\htmlzensumenu;//myClassフォルダに配置したクラスを使用
 $htmlzensumenu = new htmlzensumenu();
 $htmlzensus = $htmlzensumenu->zensumenus();
 $htmlzensusubs = $htmlzensumenu->zensussubmenus();
 $htmlzensustartends = $htmlzensumenu->zensustartend();
 ?>

 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlzensustartends;
 ?>
 </table>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($ResultZensuHeads, ['url' => ['action' => 'zensustafflogin']]) ?>
    <br>
     <div align="center"><font color="red" size="2"><?= __($mess) ?></font></div>
     <br>
    <legend align="center"><strong style="font-size: 11pt; color:blue"><?= __("開始　社員ID登録") ?></strong></legend>
    <fieldset>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
  <tr>
    <td bgcolor="#FFFFCC" style="font-size: 12pt;"><strong style="font-size: 11pt; color:blue">社員ID</strong></td>
		<td bgcolor="#FFFFCC"><?= $this->Form->control('username', array('type'=>'text', 'label'=>false,'autofocus'=>true)) ?></td>
	</tr>
</table>
    </fieldset>


    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tr>
       <form method="post" onclick=”submit();”>
        <td style="border-style: none;"><div align="center"><?= $this->Form->submit('開始', array('name' => 'login')); ?></div></td>
       </form>
      </tr>
<?php
/*
  <form onsubmit="return false;">
    <button type="submit" onclick="submit();">開始</button>
  </form>
*/
?>
  </table>
<br>
    <?= $this->Form->end() ?>
