<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 
///////////Model/Tableで、テーブルのnotemptyを変更

use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
$this->Roles = TableRegistry::get('roles');//Rolesテーブルを使う
?>
<?=$this->Form->create($user, ['url' => ['action' => 'docsv']])?>
<br>
<?=$this->Form->input('CSV', array('type'=>'file' )); ?>
<br>
            <?php
              $username = $this->request->Session()->read('Auth.User.username');
                
              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

              echo $this->Form->create($user, ['url' => ['action' => 'docsv']]);

              for($n=1; $n<=$count-1; $n++){
                      $resultArray = Array();
                          $sample0 = $arrFp["{$n}"]['username'];
                          echo "<input type='hidden' name=userdata[$n][username] value='$sample0' />\n";

                        $staff_code = $arrFp["{$n}"]['staff_code'];
                        $Staff = $this->Staffs->find()->where(['staff_code' => $staff_code])->toArray();//'role_code' => $sample5となるデータをRolesテーブルから配列で取得
                        $staf_id = $Staff[0]->id;//配列の0番目（0番目しかない）のidに$role_idと名前を付ける
                        echo "<input type='hidden' name=userdata[$n][staff_id] value='$staf_id' size='6'/>\n";//sokuteidataに追加

                        $Staff = $this->Staffs->find()->where(['staff_code' => 9999])->toArray();//'role_code' => 9999となるデータをStaffsテーブルから配列で取得
                        $staf_id = $Staff[0]->id;//配列の0番目（0番目しかない）のidに$staf_idと名前を付ける
                        echo "<input type='hidden' name=userdata[$n][created_staff] value='$staf_id' size='6'/>\n";//sokuteidataに追加

                          $delete_flag = 0;
                          echo "<input type='hidden' name=userdata[$n][delete_flag] value='$delete_flag' size='6'/>\n";
                          
                          $samplestatus = $arrFp["{$n}"]['password'];//passwordは行の最後のため、改行まで含まれてしまう
                          $sample5 = substr($samplestatus, 0, 4);//最初の4文字（passwordのみ）に$sample5と名前を付ける
                          echo "<input type='hidden' name=userdata[$n][password] value='$sample5' size='6'/>\n";
                          
                          $sample5 = 3;
                            $Role = $this->Roles->find()->where(['role_code' => $sample5])->toArray();//'role_code' => $sample5となるデータをRolesテーブルから配列で取得
                            $role_id = $Role[0]->id;//配列の0番目（0番目しかない）のidに$role_idと名前を付ける
                            echo "<input type='hidden' name=userdata[$n][role_id] value='$role_id' size='6'/>\n";//sokuteidataに追加

              }
            ?>
                
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
