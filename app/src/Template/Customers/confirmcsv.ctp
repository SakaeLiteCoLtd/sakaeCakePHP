<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 
///////////Model/Tableで、テーブルのnotemptyを変更

use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
?>
<?=$this->Form->create($customer, ['url' => ['action' => 'docsv']])?>
<br>
<?=$this->Form->input('CSV', array('type'=>'file' )); ?>
<br>
            <?php
              $username = $this->request->Session()->read('Auth.User.username');
                
              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

              echo $this->Form->create($customer, ['url' => ['action' => 'docsv']]);

              for($n=1; $n<=$count-1; $n++){
                      $resultArray = Array();
                          $sample0 = $arrFp["{$n}"]['customer_code'];
                          echo "<input type='hidden' name=customerdata[$n][customer_code] value='$sample0' />\n";
                          $sample1 = $arrFp["{$n}"]['name'];
                          echo "<input type='hidden' name=customerdata[$n][name] value='$sample1' />\n";
                          $sampleyuubin = $arrFp["{$n}"]['yuubin'];
                          $sampleaddress = $arrFp["{$n}"]['address'];
                          $sample2 = $sampleyuubin.' '.$sampleaddress;
                          echo "<input type='hidden' name=customerdata[$n][address] value='$sample2' />\n";
                          $sample3 = $arrFp["{$n}"]['tel'];
                          echo "<input type='hidden' name=customerdata[$n][tel] value='$sample3' />\n";
                          $sample4 = $arrFp["{$n}"]['fax'];
                          echo "<input type='hidden' name=customerdata[$n][fax] value='$sample4' />\n";
                          $sample6 = $arrFp["{$n}"]['delete_flag'];
                          $sampleflag = substr($sample6, 0, 1);//最初の1文字（delete_flagの数値のみ）に$sampleflagと名前を付ける
                          echo "<input type='hidden' name=customerdata[$n][delete_flag] value='$sampleflag' />\n";
                          echo "<input type='hidden' name=customerdata[$n][status] value='0' size='6'/>\n";
                          echo "<input type='hidden' name=customerdata[$n][created_staff] value='$staff_id' size='6'/>\n";
              }
            ?>
            
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
