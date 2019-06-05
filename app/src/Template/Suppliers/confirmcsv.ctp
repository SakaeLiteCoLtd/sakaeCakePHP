<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 
///////////Model/Tableで、テーブルのnotemptyを変更

use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->SupplierSections = TableRegistry::get('supplierSections');//supplierSections
$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
?>
<?=$this->Form->create($supplier, ['url' => ['action' => 'docsv']])?>
<br>
<?=$this->Form->input('CSV', array('type'=>'file' )); ?>
<br>
            <?php
              $username = $this->request->Session()->read('Auth.User.username');
                
              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

              echo $this->Form->create($supplier, ['url' => ['action' => 'docsv']]);

              for($n=1; $n<=$count-1; $n++){
                      $resultArray = Array();
                          $SupplierSection = $this->SupplierSections->find()->where(['account_code' => 12345])->toArray();//'account_code' => 12345となるデータをRolesテーブルから配列で取得
                          $supplier_section_id = $SupplierSection[0]->id;//配列の0番目（0番目しかない）のidに$supplier_section_idと名前を付ける
                          echo "<input type='hidden' name=supplierdata[$n][supplier_section_id] value='$supplier_section_id' size='6'/>\n";//sokuteidataに追加

                          $sample0 = $arrFp["{$n}"]['supplier_code'];
                          echo "<input type='hidden' name=supplierdata[$n][supplier_code] value='$sample0' />\n";
                          $sample1 = $arrFp["{$n}"]['name'];
                          echo "<input type='hidden' name=supplierdata[$n][name] value='$sample1' />\n";
//                          echo "<input type='hidden' name=supplierdata[$n][zip] value='' size='6'/>\n";
                          $sample2 = $arrFp["{$n}"]['address'];
                          echo "<input type='hidden' name=supplierdata[$n][address] value='$sample2' />\n";
                          $sample3 = $arrFp["{$n}"]['tel'];
                          echo "<input type='hidden' name=supplierdata[$n][tel] value='$sample3' />\n";
                          $sample4 = $arrFp["{$n}"]['fax'];
                          echo "<input type='hidden' name=supplierdata[$n][fax] value='$sample4' />\n";
                          $sample5 = $arrFp["{$n}"]['charge_p'];
                          echo "<input type='hidden' name=supplierdata[$n][charge_p] value='$sample5' />\n";
                          $sample6 = $arrFp["{$n}"]['delete_flag'];
                          echo "<input type='hidden' name=supplierdata[$n][delete_flag] value='$sample6' />\n";
                          echo "<input type='hidden' name=supplierdata[$n][status] value='0' size='6'/>\n";
                          echo "<input type='hidden' name=supplierdata[$n][created_staff] value='$staff_id' size='6'/>\n";
              }
            ?>
                
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
