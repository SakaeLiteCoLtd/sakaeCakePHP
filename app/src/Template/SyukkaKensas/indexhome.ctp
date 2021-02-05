<?php
 use App\myClass\Syukkakensa\htmlSyukkakensamenu;//myClassフォルダに配置したクラスを使用
 $htmlSyukkakensamenu = new htmlSyukkakensamenu();
 $htmlSyukkakensamenus = $htmlSyukkakensamenu->Syukkakensamenu();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlSyukkakensamenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?= $this->Form->create($imKikakus, ['url' => ['action' => 'torikomi']]) ?>
<fieldset>
<br>

<div align="center"><font color="red" size="4">＊下記の製品が未検査です</font></div>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('品番') ?></font></strong></div></td>
          <td width="300" ><div align="center"><strong><font color="blue" size="3"><?= h('品名') ?></font></strong></div></td>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('製造年月日') ?></font></strong></div></td>
      </tr>

      <?php
    //  echo $this->Url->build("/MLD-MD-20032_jigu");
    if($countnamed!=1){
      for($i=1; $i<$countnamed; $i++){
        echo '<tr><td><div align="center">';
        echo (${"product_coded".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center">';
        echo (${"product_named".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center"><font color="blue">';
    //    echo (${"inspec_dateb".$i}) ;
    echo $this->Html->link(${"KadouSeikeifinishing_dated".$i}, ['controller'=>'KensahyouSokuteidatas', 'action'=>'preform', 'namemoto' => ${"KadouSeikeifinishing_dated".$i}, 'name' => ${"product_coded".$i}, 'value' => ${"KadouSeikeiidd".$i}]) ;
  //  echo $this->Html->link(${"KadouSeikeifinishing_dated".$i}, ['controller'=>'KensahyouSokuteidatas', 'action'=>'preform', 'name' => ${"product_coded".$i}]) ;
        echo '</div></font></td></tr>';
      }
    }
      ?>

</table>

<br>
<br>

<div align="center"><font color="blue" size="4">＊以下は、現在成形中の製品です。（成形品が違う場合は仮日報登録を修正してください。）</font></div>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
      <tr>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('品番') ?></font></strong></div></td>
          <td width="300" ><div align="center"><strong><font color="blue" size="3"><?= h('品名') ?></font></strong></div></td>
          <td width="200" ><div align="center"><strong><font color="blue" size="3"><?= h('製造年月日') ?></font></strong></div></td>
      </tr>

      <?php
    //  echo $this->Url->build("/MLD-MD-20032_jigu");
    if($countnamec!=1){
      for($i=1; $i<$countnamec; $i++){
        echo '<tr><td><div align="center">';
        echo (${"product_codec".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center">';
        echo (${"product_namec".$i}) ;
        echo '</div></td>';
        echo '<td><div align="center"><font color="blue">';
    //    echo (${"inspec_dateb".$i}) ;
    //    echo $this->Html->link(${"KadouSeikeifinishing_datec".$i}, ['action'=>'preform', 'name' => ${"KadouSeikeifinishing_datec".$i}, 'value1' => ${"product_codec".$i}, 'value2' => ${"product_namec".$i}, 'value3' => ${"KadouSeikeiidc".$i}]) ;
        echo $this->Html->link(${"KadouSeikeifinishing_datec".$i}, ['controller'=>'KensahyouSokuteidatas', 'action'=>'preform', 'namemoto' => ${"KadouSeikeifinishing_datec".$i}, 'name' => ${"product_codec".$i}, 'value' => ${"KadouSeikeiidc".$i}]) ;
        echo '</div></font></td></tr>';
      }
    }
      ?>

</table>

<br>
<br>


</fieldset>
<?= $this->Form->end() ?>
