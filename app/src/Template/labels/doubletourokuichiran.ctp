<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
?>

<?=$this->Form->create($CheckLotsDoubles, ['url' => ['action' => 'doubletourokuichiran']]) ?>
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

 <br><br>
 <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
         <thead>
             <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
               <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt">品番</strong></div></td>
               <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt">ロットNO.</strong></div></td>
               <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt">元登録スタッフ</strong></div></td>
               <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt">元登録時間</strong></div></td>
               <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt">二重登録スタッフ</strong></div></td>
               <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt">二重登録時間</strong></div></td>
             </tr>
         </thead>
         <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
           <?php foreach ($CheckLotsDoubles as $CheckLotsDoubles): ?>
           <tr style="border-bottom: solid;border-width: 1px">

             <?php
             $first_created_time = $CheckLotsDoubles->first_created_time->format('Y-m-d H:i:s');
             $second_created_time = $CheckLotsDoubles->second_created_time->format('Y-m-d H:i:s');
             $Created = $this->Staffs->find()->where(['id' => $CheckLotsDoubles->first_created_staff])->toArray();
             $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;
             $Second = $this->Staffs->find()->where(['id' => $CheckLotsDoubles->second_created_staff])->toArray();
             $SecondStaff = $Second[0]->f_name.$Second[0]->l_name;
             ?>

             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($CheckLotsDoubles->product_code) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($CheckLotsDoubles->lot_num) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($CreatedStaff) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($first_created_time) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($SecondStaff) ?></font></td>
             <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($second_created_time) ?></font></td>
           </tr>
           <?php endforeach; ?>
         </tbody>
     </table>
 <br><br>
