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
       $this->LabelInsideouts = TableRegistry::get('labelInsideouts');
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
       $this->set('data',$data);

       $str = implode(',', $data);//配列データをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $product_code1 = $ary[0];//入力したデータをカンマ区切りの最初のデータを$product_code1とする（以下同様）
       $product_code2 = $ary[1];
       $lot_num = $ary[4];
       $staff_id = $ary[7];
       $created_staff = $ary[8];
  //     $datetime_start = $ary[9];

       $staffData = $this->Staffs->find()->where(['id' => $staff_id])->toArray();
       $staff_code = $staffData[0]->staff_code;

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
       $arr1 = array_merge($arr1,array('datetime_start'=> date("Y-m-d H:i:s")));
       $arr1 = array_merge($arr1,array('delete_flag'=>0));
       $arr1 = array_merge($arr1,array('created_staff'=>$staff_id));
       $arr1touroku[] = $arr1;
/*
       echo "<pre>";
       print_r($arr1touroku);
       echo "</pre>";
*/
       $ResultZensuHead = $this->ResultZensuHeads->find()->where(['product_code' => $product_code1, 'staff_id' => $staff_id, 'lot_num' => $lot_num, 'datetime_finish IS' => Null])->toArray();

       if(isset($ResultZensuHead[0])){
         $ResultZensuHead = $ResultZensuHead;//既にResultZensuHeadsテーブルにあって、検査済みではない場合（検査中にもう一度検査しようとした場合）
       }else{
         $ResultZensuHead = $this->ResultZensuHeads->patchEntities($ResultZensuHeads, $arr1touroku);
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
           if ($this->ResultZensuHeads->saveMany($ResultZensuHead)) {

             //insert 旧DB
             $connection = ConnectionManager::get('DB_ikou_test');
             $table = TableRegistry::get('result_zensu_head');
             $table->setConnection($connection);

             for($k=0; $k<count($arr1touroku); $k++){
               $connection->insert('result_zensu_head', [
                   'product_id' => $arr1touroku[$k]["product_code"],
                   'lot_num' => $arr1touroku[$k]["lot_num"],
                   'emp_id' => $staff_code,
                   'datetime_start' => date("Y-m-d H:i:s")
               ]);
             }

             $connection = ConnectionManager::get('default');//新DBに戻る
             $table->setConnection($connection);

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
         $arr2 = array_merge($arr2,array('datetime_start'=> date("Y-m-d H:i:s")));
         $arr2 = array_merge($arr2,array('delete_flag'=>0));
         $arr2 = array_merge($arr2,array('created_staff'=>$staff_id));
         $arr2touroku[] = $arr2;
          $ResultZensuHead = $this->ResultZensuHeads->find()->where(['product_code' => $product_code2, 'staff_id' => $staff_id, 'lot_num' => $lot_num, 'datetime_finish IS' => Null])->toArray();
          if(isset($ResultZensuHead[0])){
            $ResultZensuHead = $ResultZensuHead;//既にResultZensuHeadsテーブルにあって、検査済みではない場合（検査中にもう一度検査しようとした場合）
          }else{
            $ResultZensuHead = $this->ResultZensuHeads->patchEntities($ResultZensuHeads, $arr2touroku);
            $connection = ConnectionManager::get('default');//トランザクション1
            // トランザクション開始2
            $connection->begin();//トランザクション3
            try {//トランザクション4
              if ($this->ResultZensuHeads->saveMany($ResultZensuHead)) {

                //insert 旧DB
                $connection = ConnectionManager::get('DB_ikou_test');
                $table = TableRegistry::get('result_zensu_head');
                $table->setConnection($connection);

                for($k=0; $k<count($arr2touroku); $k++){
                  $connection->insert('result_zensu_head', [
                      'product_id' => $arr2touroku[$k]["product_code"],
                      'lot_num' => $arr2touroku[$k]["lot_num"],
                      'emp_id' => $staff_code,
                      'datetime_start' => date("Y-m-d H:i:s")
                  ]);
                }

                $connection = ConnectionManager::get('default');//新DBに戻る
                $table->setConnection($connection);

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
      $ResultZensuHead = $this->ResultZensuHeads->find()->where(['datetime_finish IS' => Null, 'staff_id' => $staff_id])->toArray();
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

     public function zensuendstaff()//検査終了時のスタッフ登録
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
       $this->set('Data',$Data);

       $username = $Data['username'];
       $UserData = $this->Users->find()->where(['username' => $username])->toArray();
       $staffData = $this->Staffs->find()->where(['id' => $UserData[0]['staff_id']])->toArray();
       $Staff = $staffData[0]->staff_code." : ".$staffData[0]->f_name." ".$staffData[0]->l_name;
       $this->set('Staff',$Staff);
       $Staffcode = $staffData[0]->staff_code;
       $this->set('Staffcode',$Staffcode);
       $Staffid = $staffData[0]->id;
       $this->set('Staffid',$Staffid);

       $ResultZensuHead = $this->ResultZensuHeads->find()->where(['datetime_finish IS' => Null, 'staff_id' => $Staffid])->toArray();
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
       $this->set('data',$data);

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
/*
      $arrContRejections = $this->ContRejections->find('all')->toArray();
 			$arrContRejection = array();
      $n = 0;
 			foreach ($arrContRejections as $value) {
        $n = $n + 1;
 				$arrContRejection[] = array($value->id=>$value->cont);
 			}
      */
      $arrContRejection = [
        '10000' => '異常なし',
        '0' => '異物（点）',
        '1' => '異物（マーブル）',
        '2' => '異物（樹脂袋）',
        '3' => 'ガスヤケ',
        '4' => '汚れ',
        '5' => 'ショート',
        '6' => 'フラッシュ',
        '7' => '気泡',
        '8' => '変形',
        '9' => '寸法不良',
        '10' => '混入',
        '11' => '糸ひき',
        '12' => '因数不足',
        '13' => '過剰因数',
        '9999' => 'その他'
              ];

 			$this->set('arrContRejection',$arrContRejection);
     }

     public function zensufinish()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $this->set('data',$data);
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

       $arrContRejection = [
         '10000' => '異常なし',
         '0' => '異物（点）',
         '1' => '異物（マーブル）',
         '2' => '異物（樹脂袋）',
         '3' => 'ガスヤケ',
         '4' => '汚れ',
         '5' => 'ショート',
         '6' => 'フラッシュ',
         '7' => '気泡',
         '8' => '変形',
         '9' => '寸法不良',
         '10' => '混入',
         '11' => '糸ひき',
         '12' => '因数不足',
         '13' => '過剰因数',
         '9999' => 'その他'
               ];
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

       $staffData = $this->Staffs->find()->where(['id' => $staff_id])->toArray();
       $staff_code = $staffData[0]->staff_code;
/*
       echo "<pre>";
       print_r($staff_code);
       echo "</pre>";
*/

       //旧DBのresult_zensu_head_idが必要
       //新DBの$result_zensu_head_idのデータと同じ$product_code、$lot_num、created_staff、'datetime_finish IS' => Nullのものを拾ってくる

       $connection = ConnectionManager::get('DB_ikou_test');
       $table = TableRegistry::get('result_zensu_head');
       $table->setConnection($connection);

       $sql = "SELECT id FROM result_zensu_head".
             " where product_id ='".$product_code."' and lot_num = '".$lot_num."' and emp_id = '".$staff_id."' and datetime_finish IS NULL";
       $connection = ConnectionManager::get('DB_ikou_test');
       $result_zensu_head_id_moto = $connection->execute($sql)->fetchAll('assoc');
/*
       echo "<pre>";
       print_r($result_zensu_head_id_moto[0]['id']);
       echo "</pre>";
*/
       $connection = ConnectionManager::get('default');//新DBに戻る
       $table->setConnection($connection);

       session_start();

       for($n=0; $n<=$tuika; $n++){
         $_SESSION['zensufooder'][$n] = array(
           'result_zensu_head_id' => $result_zensu_head_id,
           'cont_rejection_id' => $data["cont{$n}"],
           'amount' => $data["amount{$n}"],
           'bik' => $data["bik{$n}"],
           "delete_flag" => 0,
           "created_staff" => $staff_id
         );
        }
        $_SESSION['zensuhead'] = array(
          'datetime_finish' => date('Y-m-d H:i:s'),
          'updated_staff' => $staff_id
        );
        $_SESSION['result_zensu_head_id'] = array(
          'product_code' => $product_code,
          'lot_num' => $lot_num,
          'result_zensu_head_id' => $result_zensu_head_id,
          'result_zensu_head_id_moto' => $result_zensu_head_id_moto[0]['id']
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

             //insert 旧DB
             $connection = ConnectionManager::get('DB_ikou_test');
             $table = TableRegistry::get('result_zensu_fooder');
             $table->setConnection($connection);

             for($k=0; $k<count($_SESSION['zensufooder']); $k++){
               $connection->insert('result_zensu_fooder', [
                   'result_zensu_head_id' => $_SESSION['result_zensu_head_id']["result_zensu_head_id_moto"],
                   'cont_rejection_id' => $_SESSION['zensufooder'][$k]["cont_rejection_id"],
                   'amount' => $_SESSION['zensufooder'][$k]["amount"],
                   'bik' => $_SESSION['zensufooder'][$k]["bik"],
                   'datetime_finish' => date("Y-m-d H:i:s")
               ]);
             }

             $connection = ConnectionManager::get('default');//新DBに戻る
             $table->setConnection($connection);

             if ($this->ResultZensuHeads->updateAll(
               ['datetime_finish' => $_SESSION['zensuhead']['datetime_finish'], 'updated_staff' => $_SESSION['zensuhead']['updated_staff'], 'updated_at' => date('Y-m-d H:i:s')],
               ['id'  => $_SESSION['result_zensu_head_id']['result_zensu_head_id']]
             )){

               //insert 旧DB
               $connection = ConnectionManager::get('DB_ikou_test');
               $table = TableRegistry::get('result_zensu_head');
               $table->setConnection($connection);

               $updater = "UPDATE result_zensu_head set datetime_finish = '".date('Y-m-d H:i:s')."'
                 where product_id ='".$_SESSION['result_zensu_head_id']['product_code']."' and lot_num = '".$_SESSION['result_zensu_head_id']['lot_num']."' and datetime_finish IS NULL";//もとのDBも更新
               $connection->execute($updater);

               $connection = ConnectionManager::get('default');//新DBに戻る
               $table->setConnection($connection);

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
                   ['flag_used' => 0, 'created_at' => $CheckLotcreated_at, 'updated_staff' => $_SESSION['zensuhead']['updated_staff'], 'updated_at' => date('Y-m-d H:i:s')],
                   ['id'  => $CheckLotId]
                 )){

                   //insert 旧DB
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('check_lots');
                   $table->setConnection($connection);

                   $updater = "UPDATE check_lots set flag_used = 0, updated_at = '".date('Y-m-d H:i:s')."'
                     where product_id ='".$_SESSION['result_zensu_head_id']['product_code']."' and lot_num = '".$_SESSION['result_zensu_head_id']['lot_num']."'";//もとのDBも更新
                   $connection->execute($updater);

                   $connection = ConnectionManager::get('default');//新DBに戻る
                   $table->setConnection($connection);

                   //INだった場合親ロットの'flag_used' => 0にするかどうかをチェックする。
                   $lot_in = substr($_SESSION['result_zensu_head_id']['lot_num'], 0, 3);
                   if($lot_in == "IN."){
                     $lot_oomoto = substr($_SESSION['result_zensu_head_id']['lot_num'], 4, 6);
                     $lot_kodomo = substr($_SESSION['result_zensu_head_id']['lot_num'], 0, 6);
                     $lot_num_touroku = substr($_SESSION['result_zensu_head_id']['lot_num'], -3);
/*
                     echo "<pre>";
                     print_r($lot_in);
                     echo "</pre>";
*/
                     $CheckLotkodomo = $this->CheckLots->find()->where(['product_code' => $_SESSION['result_zensu_head_id']['product_code'], 'lot_num like' => '%'.$lot_kodomo.'%'])->toArray();//子ロットの仲間全部
                     $CheckLotoya = $this->CheckLots->find()->where(['product_code' => $_SESSION['result_zensu_head_id']['product_code'], 'lot_num like' => '%'.$lot_oomoto.'%',//親ロットの仲間全部
                     'NOT' => [['lot_num like' => '%'."IN.".'%']]])->toArray();
                     $cntkodomo = count($CheckLotkodomo);//子ロットの仲間の個数
                     $cntoya = count($CheckLotoya);//親ロットの仲間の個数

                     $arrCheckLotkodomo = array();//空の配列を作る　$lot_kodomoの仲間を全部集める
                     foreach ((array)$CheckLotkodomo as $key => $value) {//lot_numで並び替え
                       $sort[$key] = $value['lot_num'];
                       array_push($arrCheckLotkodomo, ['id' => $value['id'], 'product_code' => $value['product_code'], 'lot_num' => $value['lot_num'], 'flag_used' => $value['flag_used']]);
                     }
                  //   array_multisort(array_map("strtotime", array_column( $arrCheckLotkodomo, "lot_num" ) ), SORT_ASC, $arrCheckLotkodomo);
                     array_multisort($sort , SORT_ASC, $arrCheckLotkodomo);
                     $lot_kodomo_first = substr($arrCheckLotkodomo[0]['lot_num'], -3);
                     $bangou_lot = $lot_num_touroku - ($lot_kodomo_first - 1);//$lot_num_tourokuが同じ$lot_oomotoの中で何番目なのか調べる
  /*
                     echo "<pre>";
                     print_r($arrCheckLotkodomo);
                     echo "</pre>";
  */
                     $LabelInsideout = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['result_zensu_head_id']['product_code']])->toArray();
                     $LabelInside_num = $LabelInsideout[0]->num_inside;

                     $mod = $bangou_lot/$LabelInside_num;//親ロットは全部で何個か
                     $mod_int = floor($mod);//整数部分

                     if(($mod_int - $mod) == 0){//割り切れた時
                       $bangou_oya_lot = $mod_int;//親ロットは$mod_int番目
                     }else{//割り切れなかったとき
                       $bangou_oya_lot = $mod_int + 1;//親ロットは$mod_int + 1番目か
                     }

                     $arrCheckLotkodomotati = array();//$lot_kodomoの仲間を全部集める
                     $flag_used_total = 0;
                     for($m=($bangou_oya_lot*$LabelInside_num - $LabelInside_num); $m<=($bangou_oya_lot*$LabelInside_num - 1); $m++){
                       $arrCheckLotkodomotati[] = $CheckLotkodomo[$m]->flag_used;
                       $flag_used_total = $flag_used_total + $CheckLotkodomo[$m]->flag_used;
                     }

                    if($flag_used_total == 0){//子ロットが全部検査済みの場合は親ロットのflag_usedを０に変更
                      $arrCheckLotoya = array();//空の配列を作る　$lot_oyaの仲間を全部集める
                      foreach ((array)$CheckLotoya as $key => $value) {//lot_numで並び替え
                        $sort[$key] = $value['lot_num'];
                        array_push($arrCheckLotoya, ['id' => $value['id'], 'product_code' => $value['product_code'], 'lot_num' => $value['lot_num'], 'flag_used' => $value['flag_used']]);
                      }
                      array_multisort(array_map("strtotime", array_column($arrCheckLotoya, "lot_num" ) ), SORT_ASC, $arrCheckLotoya);
                //      array_multisort($sort , SORT_ASC, $CheckLotoya);

                       $bangou_arr_oya_lot = $bangou_oya_lot - 1;
                       $this->CheckLots->updateAll(
                        ['flag_used' => 0, 'created_at' => $CheckLotcreated_at, 'updated_staff' => $_SESSION['zensuhead']['updated_staff'], 'updated_at' => date('Y-m-d H:i:s')],
                        ['id'  => $arrCheckLotoya[$bangou_arr_oya_lot]['id']]);

                        //insert 旧DB
                        $connection = ConnectionManager::get('DB_ikou_test');
                        $table = TableRegistry::get('check_lots');
                        $table->setConnection($connection);

                        $updater = "UPDATE check_lots set flag_used = 0 , updated_at = '".date('Y-m-d H:i:s')."'
                          where product_id ='".$_SESSION['result_zensu_head_id']['product_code']."' and lot_num = '".$arrCheckLotoya[$bangou_arr_oya_lot]['lot_num']."'";//もとのDBも更新
                        $connection->execute($updater);

                        $connection = ConnectionManager::get('default');//新DBに戻る
                        $table->setConnection($connection);

                        $mes = "登録されました。親ロットも検査済みに変更しました。";
                        $this->set('mes',$mes);
                        $connection->commit();// コミット5

                    }else{
                      $connection->commit();// コミット5
                      $mes = "登録されました。";
                      $this->set('mes',$mes);
                    }

                  }else{
                    $mes = "登録されました。";
                    $this->set('mes',$mes);
                    $connection->commit();// コミット5
                  }

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

     public function zensukensakuform()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);

       $arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);
   		 $arrStaff = array();
       $arrStaff[] = array("");
   			foreach ($arrStaffs as $value) {
   				$arrStaff[] = array($value->id=>$value->f_name.$value->l_name);
   			}
 	 		 $this->set('arrStaff',$arrStaff);

       $arrContRejection = [
         '11111' => '',
         '10000' => '異常なし',
         '0' => '異物（点）',
         '1' => '異物（マーブル）',
         '2' => '異物（樹脂袋）',
         '3' => 'ガスヤケ',
         '4' => '汚れ',
         '5' => 'ショート',
         '6' => 'フラッシュ',
         '7' => '気泡',
         '8' => '変形',
         '9' => '寸法不良',
         '10' => '混入',
         '11' => '糸ひき',
         '12' => '因数不足',
         '13' => '過剰因数',
         '9999' => 'その他'
               ];
       $this->set('arrContRejection',$arrContRejection);

       $arrKensakuday = [
         '1' => '検査年月日',
         '2' => 'ラベル発行年月日'
               ];
       $this->set('arrKensakuday',$arrKensakuday);

       $dateYMDf0 = date('Y-m-d');
       $dateYMDf1 = strtotime($dateYMDf0);
       $dateYMDf2 = date('Y-m-d', strtotime('+1 day', $dateYMDf1));
       $dateYMDf12 = strtotime($dateYMDf2);
       $dateYMDf1 = date('Y-m-d', strtotime('-1 day', $dateYMDf12));
       $dateHI = date("08:00");
       $dateTo = $dateYMDf1."T".$dateHI;
       $this->set('dateTo',$dateTo);
       $dateTomo = $dateYMDf2."T".$dateHI;
       $this->set('dateTomo',$dateTomo);

     }

     public function zensukensakuichiran()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);
       $data = $this->request->getData();
/*
echo "<pre>";
print_r($data);
echo "</pre>";
*/
         $product_code = $data['product'];
         $this->set('product_code',$product_code);

         if($data['staff'] == 0){
           $Staff = "";
           $this->set('Staff',$Staff);
         }else{
           $staffData = $this->Staffs->find()->where(['id' => $data['staff']])->toArray();
           $Staff = $staffData[0]->f_name." ".$staffData[0]->l_name;
           $this->set('Staff',$Staff);
         }

         $Kensakuday_num = $data['Kensakuday'];
         $this->set('Kensakuday_num',$Kensakuday_num);
         if($data['Kensakuday'] == 1){
           $Kensakuday = "：　検査年月日";
           $this->set('Kensakuday',$Kensakuday);
         }else{
           $Kensakuday = "：　ラベル発行年月日";
           $this->set('Kensakuday',$Kensakuday);
         }


         if(isset($data['datesta']['year'])){
           $datesta = $data['datesta']['year']."-".$data['datesta']['month']."-".$data['datesta']['day']." ".$data['datesta']['hour'].":".$data['datesta']['minute'];
           $this->set('datesta',$datesta);
           $datefin = $data['datefin']['year']."-".$data['datefin']['month']."-".$data['datefin']['day']." ".$data['datefin']['hour'].":".$data['datefin']['minute'];
           $this->set('datefin',$datefin);
         }else{
           $datesta = $data['datesta'];
           $this->set('datesta',$datesta);
           $datefin = $data['datefin'];
           $this->set('datefin',$datefin);
         }

         if($data['ContRejection'] == 11111){
           $ContRejection = "";
           $this->set('ContRejection',$ContRejection);
           $cont = "11111";
           $this->set('cont',$cont);
         }else{
           $ContRejections = $this->ContRejections->find()->where(['id' => $data['ContRejection']])->toArray();
           $ContRejection = $ContRejections[0]->cont;
           $this->set('ContRejection',$ContRejection);
           $cont = $data['ContRejection'];
           $this->set('cont',$cont);
         }

         if($data['amount'] > 0){
           $amount = $data['amount'];
           $this->set('amount',$amount);
         }else{
           $amount = "";
           $this->set('amount',$amount);
         }

         if($data['check'] == 0){
           $check = "不良数ゼロ検索";
           $this->set('check',$check);
         }else{
           $check = "不良数ゼロを省いて検索";
           $this->set('check',$check);
         }

         $bik = $data['bik'];
         $this->set('bik',$bik);

         //以下入力内容に合わせてデータを取り出す

         $arrFooder =  array();
         $arrZensuHeads =  array();
         $ResultZensuHeads = $this->ResultZensuHeads->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
          ->where(['delete_flag' => '0','datetime_start >=' => $datesta, 'datetime_start <=' => $datefin])->toArray();


          if(isset($ResultZensuHeads[0])){

            for($j=0; $j<count($ResultZensuHeads); $j++){

              $arrZensuHeads[] = $ResultZensuHeads[$j]->id;

            }

          }

          $arrZensuproduct =  array();
         if(!empty($data['product'])){//productの入力がある場合

           $ResultZensuHeads = $this->ResultZensuHeads->find()
            ->where(['product_code' => $data['product'],'delete_flag' => '0','datetime_start >=' => $datesta, 'datetime_start <=' => $datefin])->toArray();

            if(isset($ResultZensuHeads[0])){//絞り込んだ結果が存在する場合

              for($j=0; $j<count($ResultZensuHeads); $j++){

                $arrZensuproduct[] = $ResultZensuHeads[$j]->id;

              }

            }else{//絞り込んだ結果が存在しない場合

              $arrZensuproduct = [];

            }

            $arrZensuHeads = array_intersect($arrZensuHeads, $arrZensuproduct);//共通部分だけを取り出す

         }else{//productの入力がない場合

           $arrZensuHeads = $arrZensuHeads;

         }


         $arrZensustaff =  array();
         if($data['staff'] !== "0"){//staffの入力がある場合

           $ResultZensuHeads = $this->ResultZensuHeads->find()
            ->where(['staff_id' => $data['staff'],'delete_flag' => '0','datetime_start >=' => $datesta, 'datetime_start <=' => $datefin])->toArray();

            if(isset($ResultZensuHeads[0])){//絞り込んだ結果が存在する場合

              for($j=0; $j<count($ResultZensuHeads); $j++){

                $arrZensustaff[] = $ResultZensuHeads[$j]->id;

              }

            }else{//絞り込んだ結果が存在しない場合

              $arrZensustaff = [];

            }

            $arrZensuHeads = array_intersect($arrZensuHeads, $arrZensustaff);//共通部分だけを取り出す

         }else{//staffの入力がない場合

           $arrZensuHeads = $arrZensuHeads;

         }


         if(isset($arrZensuHeads[0])){

           for($j=0; $j<count($arrZensuHeads); $j++){

             ${"ResultZensuFooders".$j} = $this->ResultZensuFooders->find()
              ->where(['result_zensu_head_id' => $arrZensuHeads[$j],'delete_flag' => '0'])->toArray();

              if(isset($arrZensuHeads[0])){

                for($k=0; $k<count(${"ResultZensuFooders".$j}); $k++){

                  $arrFooder[] = ${"ResultZensuFooders".$j}[$k]->id;

                }

             }

           }

         }

         $arrZensuContRejection =  array();
         if($data['ContRejection'] !== "11111"){//ContRejectionの入力がある場合

           $ResultZensuFooders = $this->ResultZensuFooders->find()
            ->where(['cont_rejection_id' => $data['ContRejection'],'delete_flag' => '0'])->toArray();

            if(isset($ResultZensuFooders[0])){//絞り込んだ結果が存在する場合

              for($j=0; $j<count($ResultZensuFooders); $j++){

                $arrZensuContRejection[] = $ResultZensuFooders[$j]->id;

              }

            }else{//絞り込んだ結果が存在しない場合

              $arrZensuContRejection = [];

            }

            $arrFooder = array_intersect($arrFooder, $arrZensuContRejection);//共通部分だけを取り出す

         }else{//ContRejectionの入力がない場合

           $arrZensuHeads = $arrZensuHeads;
           $arrFooder = $arrFooder;

         }


         $arrZensuamount =  array();
         if(!empty($data['amount'])){//amountの入力がある場合

           $ResultZensuFooders = $this->ResultZensuFooders->find()
            ->where(['amount >=' => $data['amount'],'delete_flag' => '0'])->toArray();

            if(isset($ResultZensuFooders[0])){//絞り込んだ結果が存在する場合

              for($j=0; $j<count($ResultZensuFooders); $j++){

                $arrZensuamount[] = $ResultZensuFooders[$j]->id;

              }

            }else{//絞り込んだ結果が存在しない場合

              $arrZensuamount = [];

            }

            $arrFooder = array_intersect($arrFooder, $arrZensuamount);//共通部分だけを取り出す

         }else{//amountの入力がない場合

           $arrZensuHeads = $arrZensuHeads;
           $arrFooder = $arrFooder;

         }


         $arrZensucheck =  array();
         if($data['check'] == 1){//checkがある場合

           $ResultZensuFooders = $this->ResultZensuFooders->find()
            ->where(['amount >' => '0','delete_flag' => '0'])->toArray();

            if(isset($ResultZensuFooders[0])){//絞り込んだ結果が存在する場合

              for($j=0; $j<count($ResultZensuFooders); $j++){

                $arrZensucheck[] = $ResultZensuFooders[$j]->id;

              }

            }else{//絞り込んだ結果が存在しない場合

              $arrZensucheck = [];

            }

            $arrFooder = array_intersect($arrFooder, $arrZensucheck);//共通部分だけを取り出す

         }else{//checkがない場合

           $arrZensuHeads = $arrZensuHeads;
           $arrFooder = $arrFooder;

         }


         $arrZensubik =  array();
         if(!empty($data['bik'])){//bikの入力がある場合

           $ResultZensuFooders = $this->ResultZensuFooders->find()
            ->where(['bik' => $data['bik'],'delete_flag' => '0'])->toArray();

            if(isset($ResultZensuFooders[0])){//絞り込んだ結果が存在する場合

              for($j=0; $j<count($ResultZensuFooders); $j++){

                $arrZensubik[] = $ResultZensuFooders[$j]->id;

              }

            }else{//絞り込んだ結果が存在しない場合

              $arrZensubik = [];

            }

            $arrFooder = array_intersect($arrFooder, $arrZensubik);//共通部分だけを取り出す

         }else{//bikの入力がない場合

           $arrZensuHeads = $arrZensuHeads;
           $arrFooder = $arrFooder;

         }

         $arrFooder = array_values($arrFooder);//連番振り直し

        //セットする
        $arrichiran =  array();
         if(isset($arrFooder[0])){
           for($j=0; $j<count($arrFooder); $j++){
             $ResultZensuFooders = $this->ResultZensuFooders->find()
              ->where(['id' => $arrFooder[$j],'delete_flag' => '0'])->toArray();

              $amount = $ResultZensuFooders[0]->amount;
              $bik = $ResultZensuFooders[0]->bik;

              $ContRejections = $this->ContRejections->find()
               ->where(['id' => $ResultZensuFooders[0]->cont_rejection_id])->toArray();
              $cont_rejection = $ContRejections[0]->cont;

              $ResultZensuHeads = $this->ResultZensuHeads->find()
               ->where(['id' => $ResultZensuFooders[0]->result_zensu_head_id])->toArray();

              $product_code = $ResultZensuHeads[0]->product_code;
              $lot_num = $ResultZensuHeads[0]->lot_num;
              $date_sta = $ResultZensuHeads[0]->datetime_start->format('Y-m-d H:i:s');
              $date_fin = $ResultZensuHeads[0]->datetime_finish->format('Y-m-d H:i:s');

              $from = strtotime($date_sta);
              $to   = strtotime($date_fin);

              $diff = $to - $from;//差分を求める

              $diff = gmdate("i分s秒", $diff);// フォーマットする

              $staffData = $this->Staffs->find()->where(['id' => $ResultZensuHeads[0]->staff_id])->toArray();
              $staff = $staffData[0]->f_name." ".$staffData[0]->l_name;

              $arrichiran[] = ['product_code' => $product_code, 'lot_num' => $lot_num,
               'date_sta' => $date_sta, 'date_fin' => $date_fin, 'cont_rejection' => $cont_rejection,
                'diff' => $diff, 'amount' => $amount, 'bik' => $bik, 'staff' => $staff];

           }

         }

         $this->set('arrichiran',$arrichiran);


       if(isset($data['kakunin'])){//並び変え

         return $this->redirect(['action' => 'zensukensakuichiran',//以下のデータを持ってhasulotconfirmに移動
         's' => ['data' => $data]]);//登録するデータを全部配列に入れておく

       }


     }


     public function zensukensakuichirannarabikae()
     {
       $ResultZensuHeads = $this->ResultZensuHeads->newEntity();
       $this->set('ResultZensuHeads',$ResultZensuHeads);

       $Data = $this->request->query('s');

       echo "<pre>";
       print_r($Data);
       echo "</pre>";
     }



}
