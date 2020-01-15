<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
?>
<?= $this->Form->create($KadouSeikeis, ['url' => ['action' => 'preadd']]) ?>
<br>
<br>

<?php   /*ここから１号機*/    ?>

<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <caption style="text-align: left">１号機</caption>
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
    <tr style="border-bottom: 0px;border-width: 0px">
      <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
      <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
    </tr>

<?php
$j = 1;//１号機
/*echo "<pre>";
print_r($this->request->getData('n'.$j));
echo "</pre>";
*/
for($i=1; $i<=$this->request->getData('n'.$j); $i++){
  ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
  ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
  ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
  ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
  ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo $this->request->getData("product_code{$j}{$i}");
      echo "</div></td>\n";
      echo "</strong></div></td>\n";
      echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo ${"kadoujikan".$j.$i}/3600;
      echo "</div></td>\n";
      echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo $this->request->getData("amount_shot{$j}{$i}");
      echo "</div></td>\n";
      echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
      echo ${"riron_shot".$j.$i};
      echo "</div></td>\n";
      echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
      echo ${"accomp_rate".$j.$i}."%";
      echo "</div></td>\n";
      echo "</tr>\n";
      echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
      echo "</tr>\n";
  }
 ?>
</table>

<?php
  $session = $this->request->getSession();
  $username = $this->request->Session()->read('Auth.User.username');

  $j=1;
  $m = 0;
  for($n=1; $n<=$this->request->getData('n'.$j); $n++){
    $m = $m + 1;
    ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
    ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
          $resultArray = Array();
            if(isset($_POST["seikeiki_code{$j}{$n}"])){
              ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
            }else{
              ${"seikeiki_code".$j.$n} = "";
            }
            $_SESSION['kadouseikei'][$m] = array(
              'product_code' => $_POST["product_code{$j}{$n}"],
              'seikeiki' => $_POST["seikeiki{$j}{$n}"],
              'seikeiki_code' => ${"seikeiki_code".$j.$n},
              'starting_tm' => ${"starting_tm".$j.$n},
              'finishing_tm' => ${"finishing_tm".$j.$n},
              'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
              'amount_shot' => $_POST["amount_shot{$j}{$n}"],
              'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
              "present_kensahyou" => 0,
/*              'id' => $_POST["id{$j}_{$n}"],
              'created_at' => $_POST["created_at{$j}_{$n}"],
              'created_staff' => $_POST["created_staff{$j}{$n}"],
*/            );

          $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];

          }
/*
  echo "<pre>";
  print_r($_SESSION['kadouseikei']);
  echo "</pre>";
*/
   $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
   ${"m".$j} = $m;
   $this->set('m'.$j,${"m".$j});//セット

 ?>
 <br>
 <?php   /*ここまで１号機*/    ?>
 <?php   /*ここから２号機*/    ?>
 <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <caption style="text-align: left">２号機</caption>
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
     <tr style="border-bottom: 0px;border-width: 0px">
       <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
       <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
     </tr>
 <?php
 $j = 2;//２号機
 for($i=1; $i<=$this->request->getData('n'.$j); $i++){
   ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
   ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
   ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
   ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
   ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo $this->request->getData("product_code{$j}{$i}");
       echo "</div></td>\n";
       echo "</strong></div></td>\n";
       echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"kadoujikan".$j.$i}/3600;
       echo "</div></td>\n";
       echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo $this->request->getData("amount_shot{$j}{$i}");
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
       echo ${"riron_shot".$j.$i};
       echo "</div></td>\n";
       echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
       echo ${"accomp_rate".$j.$i}."%";
       echo "</div></td>\n";
       echo "</tr>\n";
       echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
       echo "</tr>\n";
   }
  ?>
 </table>
 <?php
   $session = $this->request->getSession();
   $username = $this->request->Session()->read('Auth.User.username');
   $j=2;
   for($n=1; $n<=$this->request->getData('n'.$j); $n++){
     $m = $m + 1;
     ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
     ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
           $resultArray = Array();
           if(isset($_POST["seikeiki_code{$j}{$n}"])){
             ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
           }else{
             ${"seikeiki_code".$j.$n} = "";
           }
             $_SESSION['kadouseikei'][$m] = array(
               'product_code' => $_POST["product_code{$j}{$n}"],
               'seikeiki' => $_POST["seikeiki{$j}{$n}"],
               'seikeiki_code' => ${"seikeiki_code".$j.$n},
               'starting_tm' => ${"starting_tm".$j.$n},
               'finishing_tm' => ${"finishing_tm".$j.$n},
               'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
               'amount_shot' => $_POST["amount_shot{$j}{$n}"],
               'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
               "present_kensahyou" => 0,
             );


            $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


           }
           $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
           ${"m".$j} = $m;
           $this->set('m'.$j,${"m".$j});//セット
  ?>
  <br>
  <?php   /*ここまで２号機*/    ?>
  <?php   /*ここから３号機*/    ?>
  <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <caption style="text-align: left">３号機</caption>
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr style="border-bottom: 0px;border-width: 0px">
        <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
        <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
      </tr>
  <?php
  $j = 3;//３号機
  for($i=1; $i<=$this->request->getData('n'.$j); $i++){
    ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
    ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
    ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
    ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
    ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("product_code{$j}{$i}");
        echo "</div></td>\n";
        echo "</strong></div></td>\n";
        echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"kadoujikan".$j.$i}/3600;
        echo "</div></td>\n";
        echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo $this->request->getData("amount_shot{$j}{$i}");
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
        echo ${"riron_shot".$j.$i};
        echo "</div></td>\n";
        echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
        echo ${"accomp_rate".$j.$i}."%";
        echo "</div></td>\n";
        echo "</tr>\n";
        echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
        echo "</tr>\n";
    }
   ?>
  </table>
  <?php
    $session = $this->request->getSession();
    $username = $this->request->Session()->read('Auth.User.username');
    $j=3;
    for($n=1; $n<=$this->request->getData('n'.$j); $n++){
      $m = $m + 1;
      ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
      ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
            $resultArray = Array();
            if(isset($_POST["seikeiki_code{$j}{$n}"])){
              ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
            }else{
              ${"seikeiki_code".$j.$n} = "";
            }
              $_SESSION['kadouseikei'][$m] = array(
                'product_code' => $_POST["product_code{$j}{$n}"],
                'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                'seikeiki_code' => ${"seikeiki_code".$j.$n},
                'starting_tm' => ${"starting_tm".$j.$n},
                'finishing_tm' => ${"finishing_tm".$j.$n},
                'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                "present_kensahyou" => 0,
              );

            $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


            }
            $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
            ${"m".$j} = $m;
            $this->set('m'.$j,${"m".$j});//セット
   ?>
   <br>
   <?php   /*ここまで３号機*/    ?>
   <?php   /*ここから４号機*/    ?>
   <br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">４号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>
   <?php
   $j = 4;//４号機
   for($i=1; $i<=$this->request->getData('n'.$j); $i++){
     ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
     ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
     ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
     ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
     ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo $this->request->getData("product_code{$j}{$i}");
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo $this->request->getData("amount_shot{$j}{$i}");
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <?php
     $session = $this->request->getSession();
     $username = $this->request->Session()->read('Auth.User.username');
     $j=4;
     for($n=1; $n<=$this->request->getData('n'.$j); $n++){
       $m = $m + 1;
       ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
       ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
             $resultArray = Array();
             if(isset($_POST["seikeiki_code{$j}{$n}"])){
               ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
             }else{
               ${"seikeiki_code".$j.$n} = "";
             }
               $_SESSION['kadouseikei'][$m] = array(
                 'product_code' => $_POST["product_code{$j}{$n}"],
                 'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                 'seikeiki_code' => ${"seikeiki_code".$j.$n},
                 'starting_tm' => ${"starting_tm".$j.$n},
                 'finishing_tm' => ${"finishing_tm".$j.$n},
                 'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                 'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                 'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                 "present_kensahyou" => 0,
               );

            $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


             }
             $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
             ${"m".$j} = $m;
             $this->set('m'.$j,${"m".$j});//セット
    ?>
    <br>
    <?php   /*ここまで４号機*/    ?>
    <?php   /*ここから５号機*/    ?>
    <br>
  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <caption style="text-align: left">５号機</caption>
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <tr style="border-bottom: 0px;border-width: 0px">
          <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
        </tr>
    <?php
    $j = 5;//５号機
    for($i=1; $i<=$this->request->getData('n'.$j); $i++){
      ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
      ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
      ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
      ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
      ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo $this->request->getData("product_code{$j}{$i}");
          echo "</div></td>\n";
          echo "</strong></div></td>\n";
          echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo ${"kadoujikan".$j.$i}/3600;
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo $this->request->getData("amount_shot{$j}{$i}");
          echo "</div></td>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo ${"riron_shot".$j.$i};
          echo "</div></td>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
          echo ${"accomp_rate".$j.$i}."%";
          echo "</div></td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "</tr>\n";
      }
     ?>
    </table>
    <?php
      $session = $this->request->getSession();
      $username = $this->request->Session()->read('Auth.User.username');
      $j=5;
      for($n=1; $n<=$this->request->getData('n'.$j); $n++){
        $m = $m + 1;
        ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
        ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
              $resultArray = Array();
              if(isset($_POST["seikeiki_code{$j}{$n}"])){
                ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
              }else{
                ${"seikeiki_code".$j.$n} = "";
              }
                $_SESSION['kadouseikei'][$m] = array(
                  'product_code' => $_POST["product_code{$j}{$n}"],
                  'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                  'seikeiki_code' => ${"seikeiki_code".$j.$n},
                  'starting_tm' => ${"starting_tm".$j.$n},
                  'finishing_tm' => ${"finishing_tm".$j.$n},
                  'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                  'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                  'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                  "present_kensahyou" => 0,
                );

              $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


              }
              $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
              ${"m".$j} = $m;
              $this->set('m'.$j,${"m".$j});//セット
     ?>
     <br>
     <?php   /*ここまで５号機*/    ?>
     <?php   /*ここから６号機*/    ?>
     <br>
     <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
       <caption style="text-align: left">６号機</caption>
       <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
         <tr style="border-bottom: 0px;border-width: 0px">
           <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
         </tr>
     <?php
     $j = 6;//７号機
     for($i=1; $i<=$this->request->getData('n'.$j); $i++){
       ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
       ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
       ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
       ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
       ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo $this->request->getData("product_code{$j}{$i}");
           echo "</div></td>\n";
           echo "</strong></div></td>\n";
           echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo ${"kadoujikan".$j.$i}/3600;
           echo "</div></td>\n";
           echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo $this->request->getData("amount_shot{$j}{$i}");
           echo "</div></td>\n";
           echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo ${"riron_shot".$j.$i};
           echo "</div></td>\n";
           echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
           echo ${"accomp_rate".$j.$i}."%";
           echo "</div></td>\n";
           echo "</tr>\n";
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "</tr>\n";
       }
      ?>
     </table>
     <?php
       $session = $this->request->getSession();
       $username = $this->request->Session()->read('Auth.User.username');
       $j=6;
       for($n=1; $n<=$this->request->getData('n'.$j); $n++){
         $m = $m + 1;
         ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
         ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
               $resultArray = Array();
               if(isset($_POST["seikeiki_code{$j}{$n}"])){
                 ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
               }else{
                 ${"seikeiki_code".$j.$n} = "";
               }
                 $_SESSION['kadouseikei'][$m] = array(
                   'product_code' => $_POST["product_code{$j}{$n}"],
                   'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                   'seikeiki_code' => ${"seikeiki_code".$j.$n},
                   'starting_tm' => ${"starting_tm".$j.$n},
                   'finishing_tm' => ${"finishing_tm".$j.$n},
                   'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                   'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                   'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                   "present_kensahyou" => 0,
                 );

              $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


               }
               $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
               ${"m".$j} = $m;
               $this->set('m'.$j,${"m".$j});//セット
      ?>
      <br>
      <?php   /*ここまで６号機*/    ?>
     <?php   /*ここから７号機*/    ?>
     <br>
     <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
       <caption style="text-align: left">７号機</caption>
       <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
         <tr style="border-bottom: 0px;border-width: 0px">
           <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
           <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
         </tr>
     <?php
     $j = 7;//７号機
     for($i=1; $i<=$this->request->getData('n'.$j); $i++){
       ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
       ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
       ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
       ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
       ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo $this->request->getData("product_code{$j}{$i}");
           echo "</div></td>\n";
           echo "</strong></div></td>\n";
           echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo ${"kadoujikan".$j.$i}/3600;
           echo "</div></td>\n";
           echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo $this->request->getData("amount_shot{$j}{$i}");
           echo "</div></td>\n";
           echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
           echo ${"riron_shot".$j.$i};
           echo "</div></td>\n";
           echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
           echo ${"accomp_rate".$j.$i}."%";
           echo "</div></td>\n";
           echo "</tr>\n";
           echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
           echo "</tr>\n";
       }
      ?>
     </table>
     <?php
       $session = $this->request->getSession();
       $username = $this->request->Session()->read('Auth.User.username');
       $j=7;
       for($n=1; $n<=$this->request->getData('n'.$j); $n++){
         $m = $m + 1;
         ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
         ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
               $resultArray = Array();
               if(isset($_POST["seikeiki_code{$j}{$n}"])){
                 ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
               }else{
                 ${"seikeiki_code".$j.$n} = "";
               }
                 $_SESSION['kadouseikei'][$m] = array(
                   'product_code' => $_POST["product_code{$j}{$n}"],
                   'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                   'seikeiki_code' => ${"seikeiki_code".$j.$n},
                   'starting_tm' => ${"starting_tm".$j.$n},
                   'finishing_tm' => ${"finishing_tm".$j.$n},
                   'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                   'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                   'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                   "present_kensahyou" => 0,
                 );

              $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


               }
               $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
               ${"m".$j} = $m;
               $this->set('m'.$j,${"m".$j});//セット
      ?>
      <br>
      <?php   /*ここまで７号機*/    ?>
   <?php   /*ここから８号機*/    ?>
   <br>
   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
     <caption style="text-align: left">８号機</caption>
     <tbody border="2" bordercolor="#E6FFFF" bgcolor="#ffc0cb" style="border-bottom: solid;border-width: 1px">
       <tr style="border-bottom: 0px;border-width: 0px">
         <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
         <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
       </tr>
   <?php
   $j = 8;//８号機
   for($i=1; $i<=$this->request->getData('n'.$j); $i++){
     ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
     ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
     ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
     ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
     ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo $this->request->getData("product_code{$j}{$i}");
         echo "</div></td>\n";
         echo "</strong></div></td>\n";
         echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"kadoujikan".$j.$i}/3600;
         echo "</div></td>\n";
         echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo $this->request->getData("amount_shot{$j}{$i}");
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
         echo ${"riron_shot".$j.$i};
         echo "</div></td>\n";
         echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
         echo ${"accomp_rate".$j.$i}."%";
         echo "</div></td>\n";
         echo "</tr>\n";
         echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
         echo "</tr>\n";
     }
    ?>
   </table>
   <?php
     $session = $this->request->getSession();
     $username = $this->request->Session()->read('Auth.User.username');
     $j=8;
     for($n=1; $n<=$this->request->getData('n'.$j); $n++){
       $m = $m + 1;
       ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
       ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
             $resultArray = Array();
             if(isset($_POST["seikeiki_code{$j}{$n}"])){
               ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
             }else{
               ${"seikeiki_code".$j.$n} = "";
             }
               $_SESSION['kadouseikei'][$m] = array(
                 'product_code' => $_POST["product_code{$j}{$n}"],
                 'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                 'seikeiki_code' => ${"seikeiki_code".$j.$n},
                 'starting_tm' => ${"starting_tm".$j.$n},
                 'finishing_tm' => ${"finishing_tm".$j.$n},
                 'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                 'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                 'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                 "present_kensahyou" => 0,
               );

              $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];


             }
             $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
             ${"m".$j} = $m;
             $this->set('m'.$j,${"m".$j});//セット
    ?>
    <br>
    <?php   /*ここまで８号機*/    ?>
    <?php   /*ここから９号機*/    ?>
    <br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <caption style="text-align: left">９号機</caption>
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <tr style="border-bottom: 0px;border-width: 0px">
          <td width="250" height="60" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 20pt; color:blue">品番</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">成形時間</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">ショット数</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">理論ショット数</strong></div></td>
          <td width="200" colspan="10" nowrap="nowrap"><div align="center"><strong style="font-size: 15pt; color:blue">達成率</strong></div></td>
        </tr>
    <?php
    $j = 9;//９号機
    for($i=1; $i<=$this->request->getData('n'.$j); $i++){
      ${"amount_shot".$j.$i} = $this->request->getData("amount_shot{$j}{$i}");
      ${"cycle_shot".$j.$i} = $this->request->getData("cycle_shot{$j}{$i}");
      ${"kadoujikan".$j.$i} = ((strtotime($this->request->getData("finishing_tm{$j}{$i}")) - strtotime($this->request->getData("starting_tm{$j}{$i}"))));
      ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
      ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td rowspan='2'  height='10' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo $this->request->getData("product_code{$j}{$i}");
          echo "</div></td>\n";
          echo "</strong></div></td>\n";
          echo "<td colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo ${"kadoujikan".$j.$i}/3600;
          echo "</div></td>\n";
          echo "<td rowspan='2' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo $this->request->getData("amount_shot{$j}{$i}");
          echo "</div></td>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap' style='font-size: 18pt'><div align='center'>\n";
          echo ${"riron_shot".$j.$i};
          echo "</div></td>\n";
          echo "<td rowspan='2'  height='6' colspan='10' nowrap='nowrap'><div align='center' style='font-size: 18pt; color:red'>\n";
          echo ${"accomp_rate".$j.$i}."%";
          echo "</div></td>\n";
          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "</tr>\n";
      }
     ?>
    </table>
    <?php
      $session = $this->request->getSession();
      $username = $this->request->Session()->read('Auth.User.username');
      $j=9;
      for($n=1; $n<=$this->request->getData('n'.$j); $n++){
        $m = $m + 1;
        ${"starting_tm".$j.$n} = substr($_POST["starting_tm{$j}{$n}"], 0, 10)." ".substr($_POST["starting_tm{$j}{$n}"], 11, 5);
        ${"finishing_tm".$j.$n} = substr($_POST["finishing_tm{$j}{$n}"], 0, 10)." ".substr($_POST["finishing_tm{$j}{$n}"], 11, 5);
              $resultArray = Array();
              if(isset($_POST["seikeiki_code{$j}{$n}"])){
                ${"seikeiki_code".$j.$n} = $_POST["seikeiki_code{$j}{$n}"];
              }else{
                ${"seikeiki_code".$j.$n} = "";
              }
                $_SESSION['kadouseikei'][$m] = array(
                  'product_code' => $_POST["product_code{$j}{$n}"],
                  'seikeiki' => $_POST["seikeiki{$j}{$n}"],
                  'seikeiki_code' => ${"seikeiki_code".$j.$n},
                  'starting_tm' => ${"starting_tm".$j.$n},
                  'finishing_tm' => ${"finishing_tm".$j.$n},
                  'cycle_shot' => $_POST["cycle_shot{$j}{$n}"],
                  'amount_shot' => $_POST["amount_shot{$j}{$n}"],
                  'accomp_rate' => $_POST["accomp_rate{$j}{$n}"],
                  "present_kensahyou" => 0,
                );

                $_SESSION['kadouseikeiId'][$m] = $_POST["id{$j}{$n}"];

              }
              $this->set('m',$m);//1行上の$roleをctpで使えるようにセット
              ${"m".$j} = $m;
              $this->set('m'.$j,${"m".$j});//セット
     ?>
     <br>
     <?php   /*ここまで９号機*/    ?>

 <br>

 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
 <tr>
   <td style="border-style: none;"><div align="center"><?= $this->Form->submit('戻る', ['onclick' => 'history.back()', 'type' => 'button']); ?></div></td>
   <td style="border-style: none;"><div align="center"><?= $this->Form->submit('追加', array('name' => 'kakunin')); ?></div></td>
 </tr>
 </table>
 <br>
 <?= $this->Form->end() ?>
