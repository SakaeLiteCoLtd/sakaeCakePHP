<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */

///////////Model/Tableで、テーブルのnotemptyを変更

use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Customers = TableRegistry::get('customers');//customersテーブルを使う
$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
?>
<?=$this->Form->create($product, ['url' => ['action' => 'docsv']])?>
<br>
<?=$this->Form->input('CSV', array('type'=>'file' )); ?>
<br>
            <?php
              $username = $this->request->Session()->read('Auth.User.username');
            
              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

              echo $this->Form->create($product, ['url' => ['action' => 'docsv']]);
/*
              for($n=1; $n<=$count-1; $n++){//1~90ならいける（90データ以下ならデータが登録できるが91データ以上だとエラーが出る）
//              for($n=650; $n<=$count-1; $n++){//1~90ならいける（90データまでしか配列に入らない？？）
                      $resultArray = Array();
                          $sample0 = $arrFp["{$n}"]['product_code'];
                          echo "<input type='hidden' name=productdata[$n][product_code] value='$sample0' />\n";
                          $sample1 = $arrFp["{$n}"]['product_name'];
                          echo "<input type='hidden' name=productdata[$n][product_name] value='$sample1' />\n";
                          $sample2 = $arrFp["{$n}"]['weight'];
                          echo "<input type='hidden' name=productdata[$n][weight] value='$sample2' />\n";

                          $sample3 = $arrFp["{$n}"]['customer_id'];
                            $Customer = $this->Customers->find()->where(['customer_code' => $sample3])->toArray();//'role_code' => $sample5となるデータをRolesテーブルから配列で取得
                            $customer_id = $Customer[0]->id;//配列の0番目（0番目しかない）のidに$role_idと名前を付ける
                            echo "<input type='hidden' name=productdata[$n][customer_id] value='$customer_id' size='6'/>\n";//sokuteidataに追加

                          $sample4 = $arrFp["{$n}"]['torisu'];
                          echo "<input type='hidden' name=productdata[$n][torisu] value='$sample4' />\n";
                          $sample5 = $arrFp["{$n}"]['cycle'];
                          echo "<input type='hidden' name=productdata[$n][cycle] value='$sample5' />\n";
                          $sample6 = $arrFp["{$n}"]['primary_p'];
                          echo "<input type='hidden' name=productdata[$n][primary_p] value='$sample6' />\n";
                          $sample7 = $arrFp["{$n}"]['gaityu'];
                          echo "<input type='hidden' name=productdata[$n][gaityu] value='$sample7' />\n";
                          echo "<input type='hidden' name=productdata[$n][delete_flag] value='0' />\n";
                          echo "<input type='hidden' name=productdata[$n][status] value='0' size='6'/>\n";
                          echo "<input type='hidden' name=productdata[$n][created_staff] value='$staff_id' size='6'/>\n";
              }
*/
            ?>
            
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
