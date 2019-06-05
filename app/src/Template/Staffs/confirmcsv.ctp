<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff $staff
 */
 
///////////Model/Tableで、テーブルのnotemptyを変更

use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->Roles = TableRegistry::get('roles');//Rolesテーブルを使う
?>
<?=$this->Form->create($staff, ['url' => ['action' => 'docsv']])?>
<br>
<?=$this->Form->input('CSV', array('type'=>'file' )); ?>
<br>
            <?php
              $username = $this->request->Session()->read('Auth.User.username');
                
              header('Expires:-1');
              header('Cache-Control:');
              header('Pragma:');

              echo $this->Form->create($staff, ['url' => ['action' => 'docsv']]);

              for($n=1; $n<=$count-1; $n++){
                      $resultArray = Array();
                          $sample0 = $arrFp["{$n}"]['staff_code'];
                          echo "<input type='hidden' name=staffdata[$n][staff_code] value='$sample0' />\n";
                          $sample1 = $arrFp["{$n}"]['f_name'];
                          echo "<input type='hidden' name=staffdata[$n][f_name] value='$sample1' />\n";
                          $sample2 = $arrFp["{$n}"]['l_name'];
                          echo "<input type='hidden' name=staffdata[$n][l_name] value='$sample2' size='6'/>\n";
                          $sample3 = $arrFp["{$n}"]['mail'];
                          echo "<input type='hidden' name=staffdata[$n][mail] value='$sample3' size='6'/>\n";
                          $delete_flag = 0;
                          echo "<input type='hidden' name=staffdata[$n][delete_flag] value='$delete_flag' size='6'/>\n";
                          
                          $samplestatus = $arrFp["{$n}"]['status'];//statusは行の最後のため、改行まで含まれてしまう
                          $sample5 = substr($samplestatus, 0, 1);//最初の1文字（statusの数値のみ）に$sample5と名前を付ける
                          echo "<input type='hidden' name=staffdata[$n][status] value='$sample5' size='6'/>\n";
                          
                          //実験statusをrole_idにする（以下３行）
                            $Role = $this->Roles->find()->where(['role_code' => $sample5])->toArray();//'role_code' => $sample5となるデータをRolesテーブルから配列で取得
                            $role_id = $Role[0]->id;//配列の0番目（0番目しかない）のidに$role_idと名前を付ける
                            echo "<input type='hidden' name=staffdata[$n][created_staff] value='$role_id' size='6'/>\n";//sokuteidataに追加
                          
              }
            ?>
                
        <p align="center"><?= $this->Form->button('back', ['onclick' => 'history.back()', 'type' => 'button']) ?>
        <?= $this->Form->button(__('OK'), array('name' => 'touroku')) ?></p>

        <?= $this->Form->end() ?>
