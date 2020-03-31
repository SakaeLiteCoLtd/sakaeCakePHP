<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
use App\myClass\Productcheck\htmlProductcheck;

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
       $this->CheckLots = TableRegistry::get('checkLots');
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

       if($product_code1 != null){
         $product_code = $product_code1;
         $htmlProductcheck = new htmlProductcheck();//クラスを使用
         $product_code_check = $htmlProductcheck->Productcheck($product_code);
         if($product_code_check == 1){
           return $this->redirect(
            ['controller' => 'Products', 'action' => 'index']
           );
         }else{
           $product_code_check = $product_code_check;
         }
       }
       if($product_code2 != null){
         $product_code = $product_code2;
         $htmlProductcheck = new htmlProductcheck();//クラスを使用
         $product_code_check = $htmlProductcheck->Productcheck($product_code);
         if($product_code_check == 1){
           return $this->redirect(
             ['controller' => 'Products', 'action' => 'index']
           );
         }else{
           $product_code_check = $product_code_check;
         }
       }

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

     public function zensuendstaff()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
     }

     public function zensuendstafflogin()
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
            return $this->redirect(['action' => 'zensutourokupre',//以下のデータを持ってzensulottourokuに移動
            's' => ['username' => $username]]);
 					}
 				}
     }

     public function zensutourokupre()
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

       $ResultZensuHead = $this->ResultZensuHeads->find()->where(['datetime_finish IS' => Null])->toArray();
       $cnt = count($ResultZensuHead);//配列の個数
       $this->set('cnt',$cnt);

       for($n=0; $n<$cnt; $n++){
         ${"id".$n} = $ResultZensuHead[$n]->id;
         $this->set('id'.$n,${"id".$n});
         ${"product_code".$n} = $ResultZensuHead[$n]->product_code;
         $this->set('product_code'.$n,${"product_code".$n});
         ${"lot_num".$n} = $ResultZensuHead[$n]->lot_num;
         $this->set('lot_num'.$n,${"lot_num".$n});
         $Product = $this->Products->find()->where(['product_code' => ${"product_code".$n}])->toArray();
         ${"product_name".$n} = $Product[0]->product_name;
         $this->set('product_name'.$n,${"product_name".$n});
       }
     }

     public function zensufinishpre()
     {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $Staff = $data['Staff'];
       $this->set('Staff',$Staff);
       $staff_id = $data['staff_id'];
       $this->set('staff_id',$staff_id);

       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);

       $array = array();
       $num = $data["cnt"];
       for ($k=0; $k<=$num; $k++){
         if(isset($data["$k"])){
           $product_code = $data["product_code".$k];
           $this->set('product_code',$product_code);
           $product_name = $data["product_name".$k];
           $this->set('product_name',$product_name);
           $lot_num = $data["lot_num".$k];
           $this->set('lot_num',$lot_num);
           $result_zensu_head_id = $data["id".$k];
           $this->set('result_zensu_head_id',$result_zensu_head_id);
         }else{
         }
       }
/*
       echo "<pre>";
       print_r($result_zensu_head_id);
       echo "</pre>";
*/
      $arrContRejections = $this->ContRejections->find('all')->toArray();
 			$arrContRejection = array();
      $n = 0;
 			foreach ($arrContRejections as $value) {
        $n = $n + 1;
 				$arrContRejection[] = array($value->id=>$value->cont);
 			}
 			$this->set('arrContRejection',$arrContRejection);
     }

     public function zensufinish()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $Staff = $data['Staff'];
       $this->set('Staff',$Staff);
       $staff_id = $data['staff_id'];
       $this->set('staff_id',$staff_id);
       $product_code = $data["product_code"];
       $this->set('product_code',$product_code);
       $product_name = $data["product_name"];
       $this->set('product_name',$product_name);
       $lot_num = $data["lot_num"];
       $this->set('lot_num',$lot_num);
       $result_zensu_head_id = $data["result_zensu_head_id"];
       $this->set('result_zensu_head_id',$result_zensu_head_id);

       $arrContRejections = $this->ContRejections->find('all')->toArray();
       $arrContRejection = array();
       foreach ($arrContRejections as $value) {
         $arrContRejection[] = array($value->id=>$value->cont);
       }
       $this->set('arrContRejection',$arrContRejection);

       if(isset($data['tuika'])){
         $tuika = $data['num'] + 1;
         $this->set('tuika',$tuika);
       }elseif(isset($data['sakujo'])){
         if($data['num'] == 0){
           $tuika = 0;
           $this->set('tuika',$tuika);
         }else{
           $tuika = $data['num'] - 1;
           $this->set('tuika',$tuika);
         }
       }elseif(isset($data['kakunin'])){
         $tuika = $data['num'];
         $this->set('tuika',$tuika);
         return $this->redirect(['action' => 'zensufinishconfirm',//以下のデータを持ってzensufinishconfirmに移動
         's' => ['data' => $data]]);//登録するデータを全部配列に入れておく
       }
       //result_zensu_fooders…result_zensu_head_id,cont_rejection_id,amount,bik,delete_flag,created_staff
       //result_zensu_heads…datetime_finish,updated_staff
     }

     public function zensufinishconfirm()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
       $Data = $this->request->query('s');
       $data = $Data['data'];//postデータ取得し、$dataと名前を付ける
       $this->set('data',$data);
       $tuika = $data['num'];
       $this->set('tuika',$tuika);
       $Staff = $data['Staff'];
       $this->set('Staff',$Staff);
       $staff_id = $data['staff_id'];
       $this->set('staff_id',$staff_id);
       $product_code = $data["product_code"];
       $this->set('product_code',$product_code);
       $product_name = $data["product_name"];
       $this->set('product_name',$product_name);
       $lot_num = $data["lot_num"];
       $this->set('lot_num',$lot_num);
       $result_zensu_head_id = $data["result_zensu_head_id"];
       $this->set('result_zensu_head_id',$result_zensu_head_id);
/*
       echo "<pre>";
       print_r($Data['data']);
       echo "</pre>";
*/
       session_start();
       for($n=0; $n<=$tuika; $n++){
         $_SESSION['zensufooder'][$n] = array(
           'result_zensu_head_id' => $result_zensu_head_id,
           'cont_rejection_id' => $data["cont{$n}"],
           'amount' => $data["amount{$n}"],
           'bik' => $data["bik{$n}"],
           "delete_flag" => 0,
  //         "created_at" => date('Y-m-d h:m:s'),
           "created_staff" => $staff_id
         );
        }
        $_SESSION['zensuhead'] = array(
          'datetime_finish' => date('Y-m-d h:m:s'),
          'updated_staff' => $staff_id
        );
        $_SESSION['result_zensu_head_id'] = array(
          'product_code' => $product_code,
          'lot_num' => $lot_num,
          'result_zensu_head_id' => $result_zensu_head_id
        );
        /*
        echo "<pre>";
        print_r($_SESSION['result_zensu_head_id']);
        echo "</pre>";
        */
     }

     public function zensufinishdo()
     {
       $session = $this->request->getSession();
       $data = $session->read();
/*
       echo "<pre>";
       print_r($_SESSION);
       echo "</pre>";
*/
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
       $ResultZensuFooders = $this->ResultZensuFooders->newEntity();
       $this->set('ResultZensuFooders',$ResultZensuFooders);
       $CheckLots = $this->CheckLots->newEntity();
       $this->set('CheckLots',$CheckLots);

       $ResultZensuFooders = $this->ResultZensuFooders->patchEntities($ResultZensuFooders, $_SESSION['zensufooder']);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
           if ($this->ResultZensuFooders->saveMany($ResultZensuFooders)) {//saveManyで一括登録

             if ($this->ResultZensuHeads->updateAll(
               ['datetime_finish' => $_SESSION['zensuhead']['datetime_finish'], 'updated_staff' => $_SESSION['zensuhead']['updated_staff']],
               ['id'  => $_SESSION['result_zensu_head_id']['result_zensu_head_id']]
             )){

               $CheckLot = $this->CheckLots->find()->where(['product_code' => $_SESSION['result_zensu_head_id']['product_code'], 'lot_num' => $_SESSION['result_zensu_head_id']['lot_num']])->toArray();
               $CheckLotId = $CheckLot[0]->id;
               $CheckLotflag_used = $CheckLot[0]->flag_used;
               $CheckLotcreated_at = $CheckLot[0]->created_at;

               if($CheckLotflag_used == 0){//更新する必要がないとき
                 $mes = "登録されました。";
                 $this->set('mes',$mes);
                 $connection->commit();// コミット5
               }else{
                 if ($this->CheckLots->updateAll(
                   ['flag_used' => 0, 'created_at' => $CheckLotcreated_at, 'updated_staff' => $_SESSION['zensuhead']['updated_staff']],
                   ['id'  => $CheckLotId]
                 )){

                   //INだった場合親ロットの'flag_used' => 0にするかどうかをチェックする。
                   $lot_oomoto = substr($_SESSION['result_zensu_head_id']['lot_num'], 4, 6);
                   $lot_kodomo = substr($_SESSION['result_zensu_head_id']['lot_num'], 0, 6);
                   $CheckLotkodomo = $this->CheckLots->find()->where(['product_code' => $_SESSION['result_zensu_head_id']['product_code'], 'lot_num like' => '%'.$lot_kodomo.'%'])->toArray();//子ロットの仲間全部
                   $CheckLotoya = $this->CheckLots->find()->where(['product_code' => $_SESSION['result_zensu_head_id']['product_code'], 'lot_num like' => '%'.$lot_oomoto.'%',//親ロットの仲間全部
                   'NOT' => [['lot_num like' => '%'."IN.".'%']]])->toArray();
                   $cntkodomo = count($CheckLotkodomo);//子ロットの仲間の個数
                   $cntoya = count($CheckLotoya);//親ロットの仲間の個数

                   echo "<pre>";
                   print_r($cntkodomo."---".$cntoya);
                   echo "</pre>";

                   $mes = "登録されました。";
                   $this->set('mes',$mes);
                   $connection->commit();// コミット5
                 }else{
                   $mes = "登録されませんでした。";
                   $this->set('mes',$mes);
                   $this->Flash->error(__('The CheckLots could not be saved. Please, try again.'));
                   throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                 }
             }

             }else{
               $mes = "登録されませんでした。";
               $this->set('mes',$mes);
               $this->Flash->error(__('The ResultZensuHeads could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
             }

           } else {
             $mes = "登録されませんでした。";
             $this->set('mes',$mes);
             $this->Flash->error(__('The ResultZensuFooders could not be saved. Please, try again.'));
             throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
           }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

     }

}
