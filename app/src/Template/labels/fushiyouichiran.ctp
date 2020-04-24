<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');//productsテーブルを使う
 $this->NameLotFlagUseds = TableRegistry::get('nameLotFlagUseds');
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
        ?>

<?=$this->Form->create($checkLots, ['url' => ['action' => 'fushiyouichiran']]) ?>
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
<table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_touroku.gif',array('width'=>'85','height'=>'30','url'=>array('controller'=>'Labels','action'=>'fushiyoupreadd')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_ichiran.gif',array('width'=>'85','height'=>'30','url'=>array('controller'=>'Labels','action'=>'fushiyouichiranpre')));?></td>
          </tr>
</table>
<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">日付</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 12pt; color:blue">作成枚数</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">不使用ロット枚数</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">使用禁止ロット数</strong></div></td>
              <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:blue">在庫ロット数</strong></div></td>
            </tr>
        </thead>
          <?php
          for($n=0; $n<=$icount; $n++){
            echo "<tr style='border-bottom: solid;border-width: 1px'><td bgcolor='#FFFFCC' nowrap='nowrap' colspan='20' style='width: 150'>\n";
            echo ${"date".$n};
            echo "</td>\n";
            echo "<td bgcolor='#FFFFCC' nowrap='nowrap' colspan='20' style='width: 150'>\n";
            echo ${"countAll".$n};
            echo "</td>\n";
            echo "<td bgcolor='#FFFFCC' nowrap='nowrap' colspan='20' style='width: 150'>\n";
            echo ${"countfushiyou".$n};
            echo "</td>\n";
            echo "<td bgcolor='#FFFFCC' nowrap='nowrap' colspan='20' style='width: 150'>\n";
            echo ${"countkinnshi".$n};
            echo "</td>\n";
            echo "<td bgcolor='#FFFFCC' nowrap='nowrap' colspan='20' style='width: 150'>\n";
            echo ${"countzaiko".$n};
            echo "</td></tr>\n";
          }
          ?>


        </tbody>
    </table>
<br><br>
