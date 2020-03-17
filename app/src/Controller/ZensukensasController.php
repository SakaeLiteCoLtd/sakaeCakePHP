<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class ZensukensasController extends AppController
{
     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');
       $this->Users = TableRegistry::get('users');
       $this->Products = TableRegistry::get('products');
       $this->ContRejections = TableRegistry::get('contRejections');
       $this->NameLotFlagUseds = TableRegistry::get('nameLotFlagUseds');
       $this->ResultZensuFooders = TableRegistry::get('resultZensuFooders');
       $this->ResultZensuHeads = TableRegistry::get('resultZensuHeads');
       $this->ZensuProducts = TableRegistry::get('zensuProducts');
     }

     public function indexmenu()
     {
       $this->request->session()->destroy();// セッションの破棄
     }

     public function indexsubmenu()
     {
       $this->request->session()->destroy();// セッションの破棄
     }

     public function zensustafftouroku()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
     }

     public function zensustafflogin()
     {
       if ($this->request->is('post')) {
         $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
         $this->set('data',$data);//セット
         $userdata = $data['username'];
         $this->set('userdata',$userdata);//セット

         $htmllogin = new htmlLogin();//クラスを使用
         $arraylogindate = $htmllogin->htmllogin($userdata);//クラスを使用（$userdataを持っていき、$arraylogindateを持って帰る）

         $username = $arraylogindate[0];
         $delete_flag = $arraylogindate[1];
         $this->set('username',$username);
         $this->set('delete_flag',$delete_flag);

         $user = $this->Auth->identify();

 					if ($user) {
 						$this->Auth->setUser($user);
            return $this->redirect(['action' => 'zensulottouroku',//以下のデータを持ってzensulottourokuに移動
            's' => ['username' => $username]]);
 					}
 				}
     }

     public function zensulottouroku()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
       $Data=$this->request->query('s');

       $username = $Data['username'];
       $UserData = $this->Users->find()->where(['username' => $username])->toArray();
       $staffData = $this->Staffs->find()->where(['id' => $UserData[0]['staff_id']])->toArray();
       $Staff = $staffData[0]->staff_code." : ".$staffData[0]->f_name." ".$staffData[0]->l_name;
       $this->set('Staff',$Staff);
       $Staffcode = $staffData[0]->staff_code;
       $this->set('Staffcode',$Staffcode);
       $Staffid = $staffData[0]->id;
       $this->set('Staffid',$Staffid);
     }

//P2132-93010,,1600,,191219-001,191219  参考
//P2166-67370,P2166-67470,30,,191223-069,191223  参考

     public function zensukennsatyuu()//開始の時間、スタッフ等を登録
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);

       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//配列データをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $product_code1 = $ary[0];//入力したデータをカンマ区切りの最初のデータを$product_code1とする（以下同様）
       $product_code2 = $ary[1];
       $lot_num = $ary[4];
       $staff_id = $ary[7];
       $created_staff = $ary[8];
       $datetime_start = $ary[9];

       $arr1 = array();//$product_code1用の配列
       $arr1 = array_merge($arr1,array('product_code'=>$product_code1));
       $arr1 = array_merge($arr1,array('lot_num'=>$lot_num));
       $arr1 = array_merge($arr1,array('staff_id'=>$staff_id));
       $arr1 = array_merge($arr1,array('datetime_start'=>$datetime_start));
       $arr1 = array_merge($arr1,array('delete_flag'=>0));
       $arr1 = array_merge($arr1,array('created_staff'=>$created_staff));
       $arr1touroku[] = $arr1;
       $ResultZensuHead = $this->ResultZensuHeads->find()->where(['product_code' => $product_code1, 'lot_num' => $lot_num, 'datetime_finish IS' => Null])->toArray();
       if(isset($ResultZensuHead[0])){
         $ResultZensuHead = $ResultZensuHead;//既にResultZensuHeadsテーブルにあって、検査済みではない場合（検査中にもう一度検査しようとした場合）
       }else{
         $ResultZensuHead = $this->ResultZensuHeads->patchEntities($ResultZensuHeads, $arr1touroku);
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
           if ($this->ResultZensuHeads->saveMany($ResultZensuHead)) {
             $connection->commit();// コミット5
           } else {
             $this->Flash->error(__('The data could not be saved. Please, try again.'));
             throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
           }
         } catch (Exception $e) {//トランザクション7
         //ロールバック8
           $connection->rollback();//トランザクション9
         }//トランザクション10
       }

       if($product_code2 != null){//セット取りの場合
         $arr2 = array();//$product_code2用の配列
         $arr2 = array_merge($arr2,array('product_code'=>$product_code2));
         $arr2 = array_merge($arr2,array('lot_num'=>$lot_num));
         $arr2 = array_merge($arr2,array('staff_id'=>$staff_id));
         $arr2 = array_merge($arr2,array('datetime_start'=>$datetime_start));
         $arr2 = array_merge($arr2,array('delete_flag'=>0));
         $arr2 = array_merge($arr2,array('created_staff'=>$created_staff));
         $arr2touroku[] = $arr2;
          $ResultZensuHead = $this->ResultZensuHeads->find()->where(['product_code' => $product_code2, 'lot_num' => $lot_num, 'datetime_finish IS' => Null])->toArray();
          if(isset($ResultZensuHead[0])){
            $ResultZensuHead = $ResultZensuHead;//既にResultZensuHeadsテーブルにあって、検査済みではない場合（検査中にもう一度検査しようとした場合）
          }else{
            $ResultZensuHead = $this->ResultZensuHeads->patchEntities($ResultZensuHeads, $arr2touroku);
            $connection = ConnectionManager::get('default');//トランザクション1
            // トランザクション開始2
            $connection->begin();//トランザクション3
            try {//トランザクション4
              if ($this->ResultZensuHeads->saveMany($ResultZensuHead)) {
                $connection->commit();// コミット5
              } else {
                $this->Flash->error(__('The data could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }
            } catch (Exception $e) {//トランザクション7
            //ロールバック8
              $connection->rollback();//トランザクション9
            }//トランザクション10
          }
        }
/*
       echo "<pre>";
       print_r($arrdata);
       echo "</pre>";
*/
      $ResultZensuHead = $this->ResultZensuHeads->find()->where(['datetime_finish IS' => Null])->toArray();
      $cnt = count($ResultZensuHead);//配列の個数
      $this->set('cnt',$cnt);

      for($n=0; $n<$cnt; $n++){
        $product_code = $ResultZensuHead[$n]->product_code;
        $lot_num = $ResultZensuHead[$n]->lot_num;
        $staff_id = $ResultZensuHead[$n]->staff_id;
        $staffData = $this->Staffs->find()->where(['id' => $staff_id])->toArray();
        $Staff = $staffData[0]->f_name." ".$staffData[0]->l_name;
        ${"mess".$n} = "　　　".$Staff."さんが、 ".$product_code."　".$lot_num." を登録しました。";
        $this->set('mess'.$n,${"mess".$n});
      }

     }
}
