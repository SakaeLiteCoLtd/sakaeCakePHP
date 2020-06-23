<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');

?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          echo $this->Form->create($KariKadouSeikei, ['url' => ['action' => 'index']]);
?>
<?php
 use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
 $htmlKadoumenu = new htmlKadoumenu();
 $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
 ?>
 <hr size="5" style="margin: 0.5rem">
 <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
 <?php
    echo $htmlKadoumenus;
 ?>
 </table>
 <hr size="5" style="margin: 0.5rem">

<br>
<br>
<br>

   <div align="center"><font color="red" size="4"><?= __($mes) ?></font></div>


   <br>
   <br>

   <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
   <tr bgcolor="#E6FFFF" >
     <td align="center" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="center"><?= $this->Form->submit(__('最終登録'), array('name' => 'touroku', 'value'=>"1")); ?></div></td>
   </tr>
   </table>

<br>
<br>

<?php
echo "<pre>";
print_r($data);
echo "</pre>";
?>


<br>
