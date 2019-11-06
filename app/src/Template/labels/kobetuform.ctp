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
          echo $this->Form->create($KadouSeikeis, ['url' => ['action' => 'kobetuform']]);
?>

<?php if(!isset($confirm) && !isset($touroku)): ?>

<br><br><br>

<?php   /*ここから１号機*/    ?>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="10" colspan="10" nowrap="nowrap"><div align="center"></div></td>
      <td width="250" height="60" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">予定枚数</strong></div></td>
      <td width="150" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">箱NO.</strong></div></td>
    </tr>

<?php
$j = 1;
${"n".$j} = 1;
   for($i=1; $i<=${"n".$j}; $i++){
    if(null == ($this->request->getData('check'.$j.$i))){//削除のチェックがついていなかった場合
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
        echo "<input type='datetime-local' value=$dateto name=starting_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='20' nowrap='nowrap'><div align='center'>\n";
        echo "自動で計算されます";
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
        echo "終了";
        echo "</strong></div></td>\n";
        echo "<td colspan='37'><div align='center'>\n";
        echo "<input type='datetime-local' value=$dateto name=finishing_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "</tr>\n";
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
        echo "<input type='datetime-local' value=$dateto name=starting_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='20' nowrap='nowrap'><div align='center'>\n";
        echo "自動で計算されます";
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='20' nowrap='nowrap'>\n";
        echo "<input type='text' value=1  name=hakoNo".$j.$i." size='6'/>\n";
        echo "</td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td colspan='3' nowrap='nowrap'><div align='center'><strong style='font-size: 15pt; color:blue'>\n";
        echo "終了";
        echo "</strong></div></td>\n";
        echo "<td colspan='37'><div align='center'>\n";
        echo "<input type='datetime-local' value=$dateto name=finishing_tm".$j.$i." size='6'/>\n";
        echo "</div></td>\n";
        echo "</tr>\n";
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

<br>
<table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
<tr bgcolor="#E6FFFF" >
  <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('確認'), array('name' => 'confirm', 'value'=>"1")); ?></div></td>
  <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('チェックした工程削除'), array('name' => 'checksakujo', 'value'=>"1")); ?></div></td>
</tr>
</table>
<br><br><br><br><br><br><br>

<fieldset>
  <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
  <?= $this->Form->control('tuika1', array('type'=>'hidden', 'value'=>$tuika1, 'label'=>false)) ?>
  <?= $this->Form->control('ntuika1', array('type'=>'hidden', 'value'=>$ntuika1, 'label'=>false)) ?>
  <?= $this->Form->control('dateto', array('type'=>'hidden', 'value'=>$dateto, 'label'=>false)) ?>
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
 ${"n".$j} = 1;
 $countj = 0;
 $m = 0;
 $nij = ${"n".$j} + $this->request->getData("ntuika{$j}");
 for($i=1; $i<=$nij; $i++){//１号機
   if(null !== ($this->request->getData("product_code{$j}{$i}"))){
     ${"product_code".$i} = $this->request->getData("product_code{$j}{$i}");
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
     if((int)$cycle*$irisu > 0){
       ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
       ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
       ${"kadoujikan".$i} = (strtotime(${"hyoujifinishing_tm".$j.$i}) - strtotime(${"hyoujistarting_tm".$j.$i}));
       ${"yoteimaisu".$i} = round((${"kadoujikan".$i}*$torisu)/($cycle*$irisu), 0);
     }else{
       ${"yoteimaisu".$i} = "0";
     }

     $countj = $countj + 1;
     ${"hyoujistarting_tm".$j.$i} = substr($this->request->getData("starting_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("starting_tm{$j}{$i}"), 11, 5);
     ${"hyoujifinishing_tm".$j.$i} = substr($this->request->getData("finishing_tm{$j}{$i}"), 0, 10)." ".substr($this->request->getData("finishing_tm{$j}{$i}"), 11, 5);
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
                   'seikeiki_code' => "",
                   'starting_tm' => ${"hyoujistarting_tm".$j.$i},
                   'finishing_tm' => ${"hyoujifinishing_tm".$j.$i},
                   'hakoNo' => $_POST["hakoNo{$j}{$i}"],
                   'yoteimaisu' => ${"yoteimaisu".$i},
                   "present_kensahyou" => 0,
                 );
       $this->set('m',$m);
     }
   }
   echo "<pre>";
   print_r($_SESSION['labeljunbi']);
   echo "</pre>";

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

  <table align="right" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tr bgcolor="#E6FFFF" >
    <td align="right" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('csv登録'), array('name' => 'touroku', 'value'=>"1")); ?></div></td>
  </tr>
  </table>
  <fieldset>
    <?= $this->Form->control('formset', array('type'=>'hidden', 'value'=>"1", 'label'=>false)) ?>
    <?= $this->Form->control('m', array('type'=>'hidden', 'value'=>$m, 'label'=>false)) ?>
  </fieldset>
  <p align="right"><?= $this->Form->button('戻る', ['onclick' => 'history.back()', 'type' => 'button']) ?>

<?php else: //csv押したとき ?>
  <br><br>
    <div align="center"><font color="red" size="4">C:\Users\info\sakaeCakePHP\app\webroot\labels にＣＳＶファイルが出力されました</font></div>
  <br><br><br><br><br>

<?php endif; ?>
