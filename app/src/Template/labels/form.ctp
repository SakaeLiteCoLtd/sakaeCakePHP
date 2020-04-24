<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う

$this->Products = TableRegistry::get('products');//productsテーブルを使う
$this->Konpous = TableRegistry::get('konpous');//productsテーブルを使う

?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($KadouSeikeis, ['url' => ['action' => 'form']]);
?>
<?php
 use App\myClass\Labelmenus\htmlLabelmenu;//myClassフォルダに配置したクラスを使用
 $htmlLabelmenu = new htmlLabelmenu();
 $htmlLabels = $htmlLabelmenu->Labelmenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlLabels;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<?php if(!isset($confirm) && !isset($touroku)): ?>

<br>
<table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('１号機'), array('name' => '1gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('２号機'), array('name' => '2gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('３号機'), array('name' => '3gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('４号機'), array('name' => '4gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('５号機'), array('name' => '5gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('６号機'), array('name' => '6gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('７号機'), array('name' => '7gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('８号機'), array('name' => '8gouki')); ?></div></td>
  <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('９号機'), array('name' => '9gouki')); ?></div></td>
</tr>
</table>
<br><br><br><br>


<?php for ($j=1;$j<10;$j++): ?>
  <?php for ($i=1;$i<${"n".$j}+1;$i++): ?>
    <?php foreach (${"arrP".$j.$i} as ${"arrP".$j.$i}): ?>
    <?php endforeach; ?>
  <?php endfor;?>
<?php endfor;?>

<?php   /*ここから１号機*/    ?>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">１号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 1;
if(null == ($this->request->getData("11gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){//１号機
    if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
    if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
      $torisu = $Product[0]->torisu;
      $cycle = $Product[0]->cycle;
    }else{
      $cycle = 1;
      $torisu = 0;
    }
    $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
    $irisu = $Konpou[0]->irisu;
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
      ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
      ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
    }elseif((int)$cycle*$irisu > 0){
      ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
      ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
    }else{
      ${"yoteimaisu".$i} = "0";
    }
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap'>\n";
        echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
        echo "開始";
        echo "</strong></div></td>\n";
        echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
        echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
        echo "終了";
        echo "</strong></div></td>\n";
        echo "<td colspan='37'><div align='center'>\n";
        echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "</tr>\n";

        echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
        echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
        echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
      }
    }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

//以下追加または削除を押された場合
  if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
    ${"tuika".$j} = ${"tuika".$j} + 1;
    ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
    echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
  }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
    ${"tuika".$j} = ${"tuika".$j} - 1;
    ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
    echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
  }
    for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
      if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
        $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
        $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
        echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
        echo "開始";
        echo "</strong></div></td>\n";
        echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
        echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
        echo "終了";
        echo "</strong></div></td>\n";
        echo "<td colspan='37'><div align='center'>\n";
        echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "</tr>\n";
      }
    }
}
 ?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika11', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo11', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで１号機*/    ?>

<?php   /*ここから２号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">２号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 2;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("22gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
  for($i=1; $i<=${"n".$j}; $i++){//２号機
    if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
    if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
      $torisu = $Product[0]->torisu;
      $cycle = $Product[0]->cycle;
    }else{
      $cycle = 1;
      $torisu = 0;
    }
    $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
    $irisu = $Konpou[0]->irisu;
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
      ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
      ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
    }elseif((int)$cycle*$irisu > 0){
      ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
      ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
    }else{
      ${"yoteimaisu".$i} = "0";
    }
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
      echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";
    }
  }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika22', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo22', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで２号機*/    ?>
<?php   /*ここから３号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">３号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 3;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("33gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
  for($i=1; $i<=${"n".$j}; $i++){
    if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
    ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
    $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
    if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
      $torisu = $Product[0]->torisu;
      $cycle = $Product[0]->cycle;
    }else{
      $cycle = 1;
      $torisu = 0;
    }
    $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
    $irisu = $Konpou[0]->irisu;
    ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
    ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
    if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
      ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
      ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
    }elseif((int)$cycle*$irisu > 0){
      ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
      ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
    }else{
      ${"yoteimaisu".$i} = "0";
    }
    ${"id".$i} = ${"arrP".$j.$i}['id'];
    ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
    ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
      echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "開始";
      echo "</strong></div></td>\n";
      echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
      echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
      echo "</td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
      echo "終了";
      echo "</strong></div></td>\n";
      echo "<td colspan='37'><div align='center'>\n";
      echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
      echo "</div></td>\n";
      echo "</tr>\n";

      echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
      echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

    }
  }
  echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika33', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo33', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで３号機*/    ?>
<?php   /*ここから４号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">４号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 4;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("44gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){
     if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
     ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
       $torisu = $Product[0]->torisu;
       $cycle = $Product[0]->cycle;
     }else{
       $cycle = 1;
       $torisu = 0;
     }
     $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     $irisu = $Konpou[0]->irisu;
     ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
     ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
     if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }elseif((int)$cycle*$irisu > 0){
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }
     ${"id".$i} = ${"arrP".$j.$i}['id'];
     ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
     ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
       echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";

       echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

     }
   }
   echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika44', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo44', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで４号機*/    ?>
<?php   /*ここから５号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">５号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 5;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("55gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){
     if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
     ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
       $torisu = $Product[0]->torisu;
       $cycle = $Product[0]->cycle;
     }else{
       $cycle = 1;
       $torisu = 0;
     }
     $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     $irisu = $Konpou[0]->irisu;
     ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
     ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
     if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }elseif((int)$cycle*$irisu > 0){
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }
     ${"id".$i} = ${"arrP".$j.$i}['id'];
     ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
     ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
       echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";

       echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

     }
   }
   echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika55', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo55', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで５号機*/    ?>
<?php   /*ここから６号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">６号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 6;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("66gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){
     if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
     ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
       $torisu = $Product[0]->torisu;
       $cycle = $Product[0]->cycle;
     }else{
       $cycle = 1;
       $torisu = 0;
     }
     $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     $irisu = $Konpou[0]->irisu;
     ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
     ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
     if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }elseif((int)$cycle*$irisu > 0){
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }
     ${"id".$i} = ${"arrP".$j.$i}['id'];
     ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
     ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
       echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";

       echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

     }
   }
   echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika66', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo66', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで６号機*/    ?>
<?php   /*ここから７号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">７号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 7;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("77gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){
     if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
     ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
       $torisu = $Product[0]->torisu;
       $cycle = $Product[0]->cycle;
     }else{
       $cycle = 1;
       $torisu = 0;
     }
     $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     $irisu = $Konpou[0]->irisu;
     ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
     ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
     if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }elseif((int)$cycle*$irisu > 0){
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }
     ${"id".$i} = ${"arrP".$j.$i}['id'];
     ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
     ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
       echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";

       echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

     }
   }
   echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika77', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo77', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで７号機*/    ?>
<?php   /*ここから８号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">８号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 8;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("88gouki")) && null == ($this->request->getData("9gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){
     if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
     ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
       $torisu = $Product[0]->torisu;
       $cycle = $Product[0]->cycle;
     }else{
       $cycle = 1;
       $torisu = 0;
     }
     $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     $irisu = $Konpou[0]->irisu;
     ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
     ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
     if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }elseif((int)$cycle*$irisu > 0){
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }
     ${"id".$i} = ${"arrP".$j.$i}['id'];
     ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
     ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
       echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";

       echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

     }
   }
   echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika88', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo88', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで８号機*/    ?>
<?php   /*ここから９号機*/    ?>
<br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">９号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 9;
if(null == ($this->request->getData("1gouki")) && null == ($this->request->getData("2gouki")) && null == ($this->request->getData("3gouki"))//null == ($this->request->getData("1gouki")) && を削除する
 && null == ($this->request->getData("4gouki")) && null == ($this->request->getData("5gouki")) && null == ($this->request->getData("6gouki"))
 && null == ($this->request->getData("7gouki")) && null == ($this->request->getData("8gouki")) && null == ($this->request->getData("99gouki"))) {//1gouki以外のやつが押されたら消えるようにする
   for($i=1; $i<=${"n".$j}; $i++){
     if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
     ${"product_code".$i} = ${"arrP".$j.$i}['product_code'];
     $Product = $this->Products->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     if(($Product[0]->torisu) > 0 && ($Product[0]->cycle) > 0){
       $torisu = $Product[0]->torisu;
       $cycle = $Product[0]->cycle;
     }else{
       $cycle = 1;
       $torisu = 0;
     }
     $Konpou = $this->Konpous->find()->where(['product_code' => ${"product_code".$i}])->toArray();
     $irisu = $Konpou[0]->irisu;
     ${"hyoujistarting_tm".$i} = substr(${"arrP".$j.$i}['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['starting_tm'], 11, 5);
     ${"hyoujifinishing_tm".$i} = substr(${"arrP".$j.$i}['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}['finishing_tm'], 11, 5);
     if($i == 1){//i=1のときはそのまま、i>1のときは時間を-1する
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }elseif((int)$cycle*$irisu > 0){
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$i}) - strtotime(${"hyoujistarting_tm".$i}) - 3600);
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }
     ${"id".$i} = ${"arrP".$j.$i}['id'];
     ${"seikeiki".$i} = ${"arrP".$j.$i}['seikeiki'];
     ${"present_kensahyou".$i} = ${"arrP".$j.$i}['present_kensahyou'];

       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
       echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"product_code".$i} name=product_code".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujistarting_tm".$i} name=starting_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=${"yoteimaisu".$i}  name=yoteimaisu".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
       echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
       echo "</td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td colspan='37'><div align='center'>\n";
       echo "<input type='datetime-local' value=${"hyoujifinishing_tm".$i} name=finishing_tm".$j.$i." size='6'/>\n";
       echo "</div></td>\n";
       echo "</tr>\n";

       echo "<input type='hidden' value=${"id".$i}  name=id".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"seikeiki".$i}  name=seikeiki".$j.$i." size='6'/>\n";
       echo "<input type='hidden' value=${"present_kensahyou".$i}  name=present_kensahyou".$j.$i." size='6'/>\n";

     }
   }
   echo $this->Form->hidden('n'.$j ,['value'=>${"n".$j}]);

  //以下追加または削除を押された場合
    if(null !== ($this->request->getData('tuika'.$j.$j))){//追加の場合
      ${"tuika".$j} = ${"tuika".$j} + 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }elseif (null !== ($this->request->getData('sakujo'.$j.$j)) && ${"tuika".$j} != 0) {//追加後の追加取り消しの場合
      ${"tuika".$j} = ${"tuika".$j} - 1;
      ${"ntuika".$j} = ${"n".$j} + ${"tuika".$j};
      echo $this->Form->hidden('ntuika'.$j ,['value'=>${"ntuika".$j}]);
    }
      for($i=${"n".$j}+1; $i<=${"ntuika".$j}; $i++){
        if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
          $hyoujistarting_tm1 = substr(${"arrP".$j."1"}['starting_tm'], 0, 10)."T08:00";
          $hyoujifinishing_tm1 = substr(${"arrP".$j."1"}['finishing_tm'], 0, 10)."T08:00";

          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'>\n";
          echo "<input type='checkbox' name=check".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=product_code".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";
          echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujistarting_tm1 name=starting_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' name=yoteimaisu".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
          echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
          echo "</td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";
          echo "<td colspan='37'><div align='center'>\n";
          echo "<input type='datetime-local' value=$hyoujifinishing_tm1 name=finishing_tm".$j.$i." size='6'/>\n";
          echo "</div></td>\n";
          echo "</tr>\n";
        }
      }
}
?>
 <tr bgcolor="#E6FFFF" >
   <td width="550" colspan="40" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td width="550" colspan="50" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加', array('type'=>'submit', 'name' => 'tuika99', 'value'=>1, 'label'=>false)) ?></div></td>
   <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->control('追加取り消し', array('type'=>'submit', 'name' => 'sakujo99', 'value'=>1, 'label'=>false)) ?></div></td>
 </tr>
</table>
<br>
<?php   /*ここまで９号機*/    ?>

<br>
<table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
  <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('チェックした工程全削除'), array('name' => 'checksakujo', 'value'=>"1")); ?></div></td>
</tr>
</table>
<br><br><br><br><br><br><br>

<fieldset>
  <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
  <?= $this->Form->control('tuika1', array('type'=>'hidden', 'value'=>$tuika1, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika1', array('type'=>'hidden', 'value'=>$ntuika1, 'label'=>false)) ?>
  <?= $this->Form->control('tuika2', array('type'=>'hidden', 'value'=>$tuika2, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika2', array('type'=>'hidden', 'value'=>$ntuika2, 'label'=>false)) ?>
  <?= $this->Form->control('tuika3', array('type'=>'hidden', 'value'=>$tuika3, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika3', array('type'=>'hidden', 'value'=>$ntuika3, 'label'=>false)) ?>
  <?= $this->Form->control('tuika4', array('type'=>'hidden', 'value'=>$tuika4, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika4', array('type'=>'hidden', 'value'=>$ntuika4, 'label'=>false)) ?>
  <?= $this->Form->control('tuika5', array('type'=>'hidden', 'value'=>$tuika5, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika5', array('type'=>'hidden', 'value'=>$ntuika5, 'label'=>false)) ?>
  <?= $this->Form->control('tuika6', array('type'=>'hidden', 'value'=>$tuika6, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika6', array('type'=>'hidden', 'value'=>$ntuika6, 'label'=>false)) ?>
  <?= $this->Form->control('tuika7', array('type'=>'hidden', 'value'=>$tuika7, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika7', array('type'=>'hidden', 'value'=>$ntuika7, 'label'=>false)) ?>
  <?= $this->Form->control('tuika8', array('type'=>'hidden', 'value'=>$tuika8, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika8', array('type'=>'hidden', 'value'=>$ntuika8, 'label'=>false)) ?>
  <?= $this->Form->control('tuika9', array('type'=>'hidden', 'value'=>$tuika9, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika9', array('type'=>'hidden', 'value'=>$ntuika9, 'label'=>false)) ?>
  <?= $this->Form->control('dateYMDs', array('type'=>'hidden', 'value'=>$dateYMDs, 'label'=>false)) ?>
  <?= $this->Form->control('dateYMDf', array('type'=>'hidden', 'value'=>$dateYMDf, 'label'=>false)) ?>
</fieldset>


<?php elseif(isset($confirm)): //確認押したとき ?>

<br><br><br>
<?php   /*ここから１号機*/    ?>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">１号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

 <?php
 $j = 1;
 $countj = 0;
 $m = 0;
 $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
 for($i=1; $i<=$nij; $i++){//１号機
   if(null !== ($this->request->getData("product_code{$j}{$i}"))){
     $countj = $countj + 1;
     ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
     ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
     ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
     ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo $this->request->getData("product_code{$j}{$i}");
       echo "</div></td>\n";
       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "開始";
       echo "</strong></div></td>\n";
       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
       echo ${"hyoujistarting_tm".$j.$i};
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
       echo ${"yoteimaisu".$i};
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
       echo ${"hakoNo".$i};
       echo "</div></td>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
       echo "終了";
       echo "</strong></div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
       echo ${"hyoujifinishing_tm".$j.$i};
       echo "</div></td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "</tr>\n";

       $session = $this->request->getSession();
       $username = $this->request->Session()->read('Auth.User.username');
         $m = $m + 1;
               $resultArray = Array();
                 $_SESSION['labeljunbi'][$m] = array(
                   'product_code' => $_POST["product_code{$j}{$i}"],
                   'seikeiki' => $j,
                   'seikeiki_code' => "",
                   'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                   'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                   'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                   'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                   "present_kensahyou" => 0,
                 );
       $this->set('m',$m);
     }
   }
  ?>
 </table>
 <br><br>

 <?php
//   $session = $this->request->getSession();
//   $username = $this->request->Session()->read('Auth.User.username');
/*
   $m = 0;
   for($n=1; $n<=$countj; $n++){
     $m = $m + 1;
           $resultArray = Array();
             $_SESSION['labeljunbi'][$m] = array(
               'product_code' => $_POST["product_code{$j}{$n}"],
               'seikeiki' => $j,
               'seikeiki_code' => "",
               'starting_tm' => $_POST["starting_tm{$j}{$n}"],
               'finishing_tm' => $_POST["finishing_tm{$j}{$n}"],
               'hakoNo' => $_POST["hakoNo{$j}{$n}"],
               'yoteimaisu' => $_POST["yoteimaisu{$j}{$n}"],
               "present_kensahyou" => 0,
             );
         }
   $this->set('m',$m);
   $m1 = $m;
   $this->set('m1',$m1);

   echo "<pre>";
   print_r($_SESSION['labeljunbi']);
   echo "</pre>";
  echo "<pre>";
  print_r($m);
  echo "</pre>";
*/
  ?>
  <br>
  <?php   /*ここまで１号機*/    ?>

  <?php   /*ここから２号機*/    ?>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">２号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
        <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
      </tr>

   <?php
   $j = 2;
   $countj = 0;
   $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
   for($i=1; $i<=$nij; $i++){
     if(null !== ($this->request->getData("product_code{$j}{$i}"))){
       $countj = $countj + 1;
       ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
       ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
       ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
       ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo $this->request->getData("product_code{$j}{$i}");
         echo "</div></td>\n";
         echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
         echo "開始";
         echo "</strong></div></td>\n";
         echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
         echo ${"hyoujistarting_tm".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
         echo ${"yoteimaisu".$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
         echo ${"hakoNo".$i};
         echo "</div></td>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
         echo "終了";
         echo "</strong></div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
         echo ${"hyoujifinishing_tm".$j.$i};
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";

         $session = $this->request->getSession();
         $username = $this->request->Session()->read('Auth.User.username');
           $m = $m + 1;
                 $resultArray = Array();
                   $_SESSION['labeljunbi'][$m] = array(
                     'product_code' => $_POST["product_code{$j}{$i}"],
                     'seikeiki' => $j,
                     'seikeiki_code' => "",
                     'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                     'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                     'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                     'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                     "present_kensahyou" => 0,
                   );
         $this->set('m',$m);
       }
     }
    ?>
   </table>
   <br>
   <br>

    <br>
    <?php   /*ここまで２号機*/    ?>
    <?php   /*ここから３号機*/    ?>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <caption style="text-align: left">３号機</caption>
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <tr style="border-bottom: 0px;border-width: 0px">
          <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
          <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
          <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
          <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
        </tr>

     <?php
     $j = 3;
     $countj = 0;
     $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
     for($i=1; $i<=$nij; $i++){
       if(null !== ($this->request->getData("product_code{$j}{$i}"))){
         $countj = $countj + 1;
         ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
         ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
         ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
         ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo $this->request->getData("product_code{$j}{$i}");
           echo "</div></td>\n";
           echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
           echo "開始";
           echo "</strong></div></td>\n";
           echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
           echo ${"hyoujistarting_tm".$j.$i};
           echo "</div></td>\n";
           echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
           echo ${"yoteimaisu".$i};
           echo "</div></td>\n";
           echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
           echo ${"hakoNo".$i};
           echo "</div></td>\n";
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
           echo "終了";
           echo "</strong></div></td>\n";
           echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
           echo ${"hyoujifinishing_tm".$j.$i};
           echo "</div></td>\n";
           echo "</tr>\n";
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "</tr>\n";

           $session = $this->request->getSession();
           $username = $this->request->Session()->read('Auth.User.username');
             $m = $m + 1;
                   $resultArray = Array();
                     $_SESSION['labeljunbi'][$m] = array(
                       'product_code' => $_POST["product_code{$j}{$i}"],
                       'seikeiki' => $j,
                       'seikeiki_code' => "",
                       'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                       'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                       'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                       'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                       "present_kensahyou" => 0,
                     );
           $this->set('m',$m);
         }
       }
      ?>
     </table>
     <br><br><br>
      <?php   /*ここまで３号機*/    ?>
      <?php   /*ここから４号機*/    ?>
      <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
        <caption style="text-align: left">４号機</caption>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
          <tr style="border-bottom: 0px;border-width: 0px">
            <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
            <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
            <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
            <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
          </tr>

       <?php
       $j = 4;
       $countj = 0;
       $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
       for($i=1; $i<=$nij; $i++){
         if(null !== ($this->request->getData("product_code{$j}{$i}"))){
           $countj = $countj + 1;
           ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
           ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
           ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
           ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
             echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
             echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
             echo $this->request->getData("product_code{$j}{$i}");
             echo "</div></td>\n";
             echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
             echo "開始";
             echo "</strong></div></td>\n";
             echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
             echo ${"hyoujistarting_tm".$j.$i};
             echo "</div></td>\n";
             echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
             echo ${"yoteimaisu".$i};
             echo "</div></td>\n";
             echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
             echo ${"hakoNo".$i};
             echo "</div></td>\n";
             echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
             echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
             echo "終了";
             echo "</strong></div></td>\n";
             echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
             echo ${"hyoujifinishing_tm".$j.$i};
             echo "</div></td>\n";
             echo "</tr>\n";
             echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
             echo "</tr>\n";

             $session = $this->request->getSession();
             $username = $this->request->Session()->read('Auth.User.username');
               $m = $m + 1;
                     $resultArray = Array();
                       $_SESSION['labeljunbi'][$m] = array(
                         'product_code' => $_POST["product_code{$j}{$i}"],
                         'seikeiki' => $j,
                         'seikeiki_code' => "",
                         'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                         'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                         'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                         'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                         "present_kensahyou" => 0,
                       );
             $this->set('m',$m);
           }
         }
        ?>
       </table>
       <br><br><br>
        <?php   /*ここまで４号機*/    ?>
        <?php   /*ここから５号機*/    ?>
        <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
          <caption style="text-align: left">５号機</caption>
          <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <tr style="border-bottom: 0px;border-width: 0px">
              <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
              <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
              <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
              <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
            </tr>

         <?php
         $j = 5;
         $countj = 0;
         $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
         for($i=1; $i<=$nij; $i++){
           if(null !== ($this->request->getData("product_code{$j}{$i}"))){
             $countj = $countj + 1;
             ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
             ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
             ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
             ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
               echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
               echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
               echo $this->request->getData("product_code{$j}{$i}");
               echo "</div></td>\n";
               echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
               echo "開始";
               echo "</strong></div></td>\n";
               echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
               echo ${"hyoujistarting_tm".$j.$i};
               echo "</div></td>\n";
               echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
               echo ${"yoteimaisu".$i};
               echo "</div></td>\n";
               echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
               echo ${"hakoNo".$i};
               echo "</div></td>\n";
               echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
               echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
               echo "終了";
               echo "</strong></div></td>\n";
               echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
               echo ${"hyoujifinishing_tm".$j.$i};
               echo "</div></td>\n";
               echo "</tr>\n";
               echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
               echo "</tr>\n";

               $session = $this->request->getSession();
               $username = $this->request->Session()->read('Auth.User.username');
                 $m = $m + 1;
                       $resultArray = Array();
                         $_SESSION['labeljunbi'][$m] = array(
                           'product_code' => $_POST["product_code{$j}{$i}"],
                           'seikeiki' => $j,
                           'seikeiki_code' => "",
                           'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                           'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                           'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                           'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                           "present_kensahyou" => 0,
                         );
               $this->set('m',$m);
             }
           }
          ?>
         </table>
         <br><br><br>
          <?php   /*ここまで５号機*/    ?>
          <?php   /*ここから６号機*/    ?>
          <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
            <caption style="text-align: left">６号機</caption>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
              <tr style="border-bottom: 0px;border-width: 0px">
                <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
                <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
                <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
                <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
              </tr>

           <?php
           $j = 6;
           $countj = 0;
           $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
           for($i=1; $i<=$nij; $i++){
             if(null !== ($this->request->getData("product_code{$j}{$i}"))){
               $countj = $countj + 1;
               ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
               ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
               ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
               ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
                 echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                 echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
                 echo $this->request->getData("product_code{$j}{$i}");
                 echo "</div></td>\n";
                 echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                 echo "開始";
                 echo "</strong></div></td>\n";
                 echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
                 echo ${"hyoujistarting_tm".$j.$i};
                 echo "</div></td>\n";
                 echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                 echo ${"yoteimaisu".$i};
                 echo "</div></td>\n";
                 echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                 echo ${"hakoNo".$i};
                 echo "</div></td>\n";
                 echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                 echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                 echo "終了";
                 echo "</strong></div></td>\n";
                 echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
                 echo ${"hyoujifinishing_tm".$j.$i};
                 echo "</div></td>\n";
                 echo "</tr>\n";
                 echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                 echo "</tr>\n";

                 $session = $this->request->getSession();
                 $username = $this->request->Session()->read('Auth.User.username');
                   $m = $m + 1;
                         $resultArray = Array();
                           $_SESSION['labeljunbi'][$m] = array(
                             'product_code' => $_POST["product_code{$j}{$i}"],
                             'seikeiki' => $j,
                             'seikeiki_code' => "",
                             'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                             'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                             'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                             'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                             "present_kensahyou" => 0,
                           );
                 $this->set('m',$m);
               }
             }
            ?>
           </table>
           <br><br><br>
            <?php   /*ここまで６号機*/    ?>
            <?php   /*ここから７号機*/    ?>
            <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
              <caption style="text-align: left">７号機</caption>
              <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
                <tr style="border-bottom: 0px;border-width: 0px">
                  <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
                  <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
                  <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
                  <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
                </tr>

             <?php
             $j = 7;
             $countj = 0;
             $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
             for($i=1; $i<=$nij; $i++){
               if(null !== ($this->request->getData("product_code{$j}{$i}"))){
                 $countj = $countj + 1;
                 ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
                 ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
                 ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
                 ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
                   echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                   echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
                   echo $this->request->getData("product_code{$j}{$i}");
                   echo "</div></td>\n";
                   echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                   echo "開始";
                   echo "</strong></div></td>\n";
                   echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
                   echo ${"hyoujistarting_tm".$j.$i};
                   echo "</div></td>\n";
                   echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                   echo ${"yoteimaisu".$i};
                   echo "</div></td>\n";
                   echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                   echo ${"hakoNo".$i};
                   echo "</div></td>\n";
                   echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                   echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                   echo "終了";
                   echo "</strong></div></td>\n";
                   echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
                   echo ${"hyoujifinishing_tm".$j.$i};
                   echo "</div></td>\n";
                   echo "</tr>\n";
                   echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                   echo "</tr>\n";

                   $session = $this->request->getSession();
                   $username = $this->request->Session()->read('Auth.User.username');
                     $m = $m + 1;
                           $resultArray = Array();
                             $_SESSION['labeljunbi'][$m] = array(
                               'product_code' => $_POST["product_code{$j}{$i}"],
                               'seikeiki' => $j,
                               'seikeiki_code' => "",
                               'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                               'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                               'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                               'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                               "present_kensahyou" => 0,
                             );
                   $this->set('m',$m);
                 }
               }
              ?>
             </table>
             <br><br><br>
              <?php   /*ここまで７号機*/    ?>
              <?php   /*ここから８号機*/    ?>
              <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
                <caption style="text-align: left">８号機</caption>
                <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
                  <tr style="border-bottom: 0px;border-width: 0px">
                    <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
                    <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
                    <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
                    <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
                  </tr>

               <?php
               $j = 8;
               $countj = 0;
               $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
               for($i=1; $i<=$nij; $i++){
                 if(null !== ($this->request->getData("product_code{$j}{$i}"))){
                   $countj = $countj + 1;
                   ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
                   ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
                   ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
                   ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
                     echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                     echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
                     echo $this->request->getData("product_code{$j}{$i}");
                     echo "</div></td>\n";
                     echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                     echo "開始";
                     echo "</strong></div></td>\n";
                     echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
                     echo ${"hyoujistarting_tm".$j.$i};
                     echo "</div></td>\n";
                     echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                     echo ${"yoteimaisu".$i};
                     echo "</div></td>\n";
                     echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                     echo ${"hakoNo".$i};
                     echo "</div></td>\n";
                     echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                     echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                     echo "終了";
                     echo "</strong></div></td>\n";
                     echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
                     echo ${"hyoujifinishing_tm".$j.$i};
                     echo "</div></td>\n";
                     echo "</tr>\n";
                     echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                     echo "</tr>\n";

                     $session = $this->request->getSession();
                     $username = $this->request->Session()->read('Auth.User.username');
                       $m = $m + 1;
                             $resultArray = Array();
                               $_SESSION['labeljunbi'][$m] = array(
                                 'product_code' => $_POST["product_code{$j}{$i}"],
                                 'seikeiki' => $j,
                                 'seikeiki_code' => "",
                                 'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                                 'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                                 'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                                 'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                                 "present_kensahyou" => 0,
                               );
                     $this->set('m',$m);
                   }
                 }
                ?>
               </table>
               <br><br><br>
                <?php   /*ここまで８号機*/    ?>
                <?php   /*ここから９号機*/    ?>
                <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
                  <caption style="text-align: left">９号機</caption>
                  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
                    <tr style="border-bottom: 0px;border-width: 0px">
                      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
                      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
                      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
                      <td width="200" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
                    </tr>

                 <?php
                 $j = 9;
                 $countj = 0;
                 $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
                 for($i=1; $i<=$nij; $i++){
                   if(null !== ($this->request->getData("product_code{$j}{$i}"))){
                     $countj = $countj + 1;
                     ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
                     ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
                     ${"yoteimaisu".$i} = $this->request->getData("yoteimaisu{$j}{$i}");
                     ${"hakoNo".$i} = $this->request->getData("hakoNo{$j}{$i}");
                       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                       echo "<td rowspan='2'  height='10' colspan='20' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
                       echo $this->request->getData("product_code{$j}{$i}");
                       echo "</div></td>\n";
                       echo "<td colspan='3' nowrap='nowrap' style='border-bottom: 0px'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                       echo "開始";
                       echo "</strong></div></td>\n";
                       echo "<td colspan='37' nowrap='nowrap' style='border-bottom: 0px; font-size: 15pt'><div align='center'>\n";
                       echo ${"hyoujistarting_tm".$j.$i};
                       echo "</div></td>\n";
                       echo "<td rowspan='2' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                       echo ${"yoteimaisu".$i};
                       echo "</div></td>\n";
                       echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap' style='font-size: 15pt'><div align='center'>\n";
                       echo ${"hakoNo".$i};
                       echo "</div></td>\n";
                       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                       echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
                       echo "終了";
                       echo "</strong></div></td>\n";
                       echo "<td rowspan='2'  height='6' colspan='37' nowrap='nowrap'><div align='center' style='font-size: 15pt'>\n";
                       echo ${"hyoujifinishing_tm".$j.$i};
                       echo "</div></td>\n";
                       echo "</tr>\n";
                       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
                       echo "</tr>\n";

                       $session = $this->request->getSession();
                       $username = $this->request->Session()->read('Auth.User.username');
                         $m = $m + 1;
                               $resultArray = Array();
                                 $_SESSION['labeljunbi'][$m] = array(
                                   'product_code' => $_POST["product_code{$j}{$i}"],
                                   'seikeiki' => $j,
                                   'seikeiki_code' => "",
                                   'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                                   'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                                   'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                                   'yoteimaisu' => $_POST["yoteimaisu{$j}{$i}"],
                                   "present_kensahyou" => 0,
                                 );
                       $this->set('m',$m);
                     }
                   }
                  ?>
                 </table>
                 <br><br><br>
                  <?php   /*ここまで９号機*/    ?>
                  <?php
      /*            echo "<pre>";
                  print_r($_SESSION['labeljunbi']);
                  echo "</pre>";
      */            ?>

  <table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FFFF" >
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('csv登録'), array('name' => 'touroku', 'value'=>"1")); ?></div></td>
    <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
  </tr>
  </table>
  <fieldset>
    <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
    <?= $this->Form->control('m', array('type'=>'hidden', 'value'=>$m, 'label'=>false)) ?>
    <?= $this->Form->control('dateYMDs', array('type'=>'hidden', 'value'=>$dateYMDs, 'label'=>false)) ?>
    <?= $this->Form->control('dateYMDf', array('type'=>'hidden', 'value'=>$dateYMDf, 'label'=>false)) ?>
  </fieldset>


<?php else: //csv押したとき ?>
  <br><br>
    <div align="center"><font color="red" size="4"><?= __($mes) ?></font></div>
  <br><br><br><br><br>

<?php endif; ?>
