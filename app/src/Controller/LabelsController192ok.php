<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
use App\myClass\Productcheck\htmlProductcheck;

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LabelsController extends AppController
{
     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');
       $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
       $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
       $this->Users = TableRegistry::get('users');
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->Customers = TableRegistry::get('customers');//customersテーブルを使う
       $this->Konpous = TableRegistry::get('konpous');
       $this->LabelElementPlaces = TableRegistry::get('labelElementPlaces');
       $this->LabelElementUnits = TableRegistry::get('labelElementUnits');
       $this->LabelInsideouts = TableRegistry::get('labelInsideouts');
       $this->LabelNashies = TableRegistry::get('labelNashies');
       $this->LabelSetikkatsues = TableRegistry::get('labelSetikkatsues');
       $this->LabelTypeProducts = TableRegistry::get('labelTypeProducts');
       $this->LabelTypes = TableRegistry::get('labelTypes');
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->CheckLots = TableRegistry::get('checkLots');
       $this->LabelCsvs = TableRegistry::get('labelCsvs');
       $this->NameLotFlagUseds = TableRegistry::get('nameLotFlagUseds');
       $this->ZensuProducts = TableRegistry::get('zensuProducts');
       $this->OrderEdis = TableRegistry::get('orderEdis');
       $this->MotoLots = TableRegistry::get('motoLots');
       $this->PlaceDelivers = TableRegistry::get('placeDelivers');
       $this->CheckLotsDoubles = TableRegistry::get('checkLotsDoubles');
  //     $this->ScheduleKoutei = TableRegistry::get('scheduleKoutei');//sakaeMotoDB必要なし
 }
     public function indexMenu()
     {
       //$this->request->session()->destroy(); // セッションの破棄
       if(!isset($_SESSION)){//sessionsyuuseituika
       session_start();
       }
     }
     public function indexShinki()
     {
       //$this->request->session()->destroy(); // セッションの破棄
     }
     public function labelhakkoumenu()
     {
       //$this->request->session()->destroy(); // セッションの破棄
     }
     public function lotmenu()
     {
       //$this->request->session()->destroy(); // セッションの破棄
     }

   public function layouttypeform()//レイアウト入力
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
      $arrLabelTypes = $this->LabelTypes->find('all', ['conditions' => ['delete_flag' => '0']])->order(['type_id' => 'ASC']);
     	$arrLabelType = array();//配列の初期化
     	foreach ($arrLabelTypes as $value) {
     		$arrLabelType[] = array($value->type_id=>$value->type_id);
     	}
     	$this->set('arrLabelType',$arrLabelType);
   }

   public function layoutform()//レイアウト入力
   {

     $data = $this->request->getData();
     /*
     echo "<pre>";
     print_r($data["product_code"]);
     echo "</pre>";
*/
     $htmlProductcheck = new htmlProductcheck();//クラスを使用
     $product_code_check = $htmlProductcheck->Productcheck($data["product_code"]);
     if($product_code_check == 1){
       return $this->redirect(
        ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $data["product_code"]]]
       );
     }else{
       $product_code_check = $product_code_check;
     }

     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
     $arrLabelElementUnits = $this->LabelElementUnits->find('all', ['conditions' => ['delete_flag' => '0']])->order(['unit' => 'ASC']);
     $arrLabelElementUnit = array();//配列の初期化
     foreach ($arrLabelElementUnits as $value) {
       $arrLabelElementUnit[] = array($value->unit=>$value->unit);
     }
     $this->set('arrLabelElementUnit',$arrLabelElementUnit);
     $arrLabelElementPlaces = $this->LabelElementPlaces->find('all', ['conditions' => ['delete_flag' => '0']])->order(['place1' => 'ASC']);
     $arrLabelElementPlace = array();//配列の初期化
     foreach ($arrLabelElementPlaces as $value) {
       $arrLabelElementPlace[] = array($value->place_code=>$value->place1." ".$value->place2);
     }
     $this->set('arrLabelElementPlace',$arrLabelElementPlace);
   }

   public function layoutconfirm()//レイアウト確認
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);

     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labellayouts'] = array();
   }

   public function layoutpreadd()//レイアウトログイン
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
   }

   public function layoutlogin()//レイアウトログイン
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'layoutdo']);
         }
       }
   }

   public function layoutdo()//レイアウト登録
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labellayouts'] = array_merge($created_staff,$_SESSION['labellayouts']);

     $created_staff = $_SESSION['labellayouts']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelTypeProducts = $this->LabelTypeProducts->patchEntity($labelTypeProducts, $_SESSION['labellayouts']);//$productデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelTypeProducts->save($labelTypeProducts)) {
/*
           echo "<pre>";
           print_r($_SESSION['labellayouts']);
           echo "</pre>";
*/
           $connection->commit();// コミット5

           //$_SESSION['labellayouts']をinsert into label_type_productする
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('label_type_product');
           $table->setConnection($connection);

             $connection->insert('label_type_product', [
                 'product_id' => $_SESSION['labellayouts']["product_code"],
                 'type_id' => $_SESSION['labellayouts']["type"],
                 'place_id' => $_SESSION['labellayouts']["place_code"],
                 'unit_id' => $_SESSION['labellayouts']["unit"]
             ]);

         } else {
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10
     }
   }

   public function placeform()//納品場所入力
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
   }

   public function placeconfirm()//納品場所確認
   {
     $PlaceData = $this->LabelElementPlaces->find()->where(['delete_flag' => '0'])->toArray();
     $arrPlaceData = array();//配列の初期化
     foreach ($PlaceData as $value) {
       $arrPlaceData[] = array($value->place_code=>$value->place_code);
     }
     $place_code = max(array_keys($arrPlaceData)) + 2;
     $this->set('place_code',$place_code);
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);

     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labelplaces'] = array();
   }

   public function placepreadd()//納品場所ログイン
   {
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
     $session = $this->request->getSession();
     $data = $session->read();
   }

   public function placelogin()//納品場所ログイン
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'placedo']);
         }
       }
   }

   public function placedo()//納品場所登録
   {
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelplaces'] = array_merge($created_staff,$_SESSION['labelplaces']);
     $created_staff = $_SESSION['labelplaces']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelElementPlace = $this->LabelElementPlaces->patchEntity($labelElementPlaces, $_SESSION['labelplaces']);//$productデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelElementPlaces->save($labelElementPlaces)) {
/*
           echo "<pre>";
           print_r($_SESSION['labelplaces']);
           echo "</pre>";
*/
           $connection->commit();// コミット5

           //$_SESSION['labelplaces']をinsert into label_element_placeする
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('label_element_place');
           $table->setConnection($connection);

             $connection->insert('label_element_place', [
                 'place1' => $_SESSION['labelplaces']["place1"],
                 'place2' => $_SESSION['labelplaces']["place2"],
                 'genjyou' => $_SESSION['labelplaces']["genjyou"]
             ]);

         } else {
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10
     }
   }

   public function nashiform()//ラベル無し入力
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
   }

   public function nashiconfirm()//セット取り確認
   {
     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labelnashis'] = array();

     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);

     $data = $this->request->getData();

     $htmlProductcheck = new htmlProductcheck();//クラスを使用
     $product_code_check = $htmlProductcheck->Productcheck($data["product_code"]);
     if($product_code_check == 1){
       return $this->redirect(
        ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $data["product_code"]]]
       );
     }else{
       $product_code_check = $product_code_check;
     }

   }

   public function nashipreadd()//ラベル無しログイン
   {
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
   }

   public function nashilogin()//ラベル無しログイン
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'nashido']);
         }
       }
   }

   public function nashido()//ラベル無し登録
   {
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelnashis'] = array_merge($created_staff,$_SESSION['labelnashis']);
     $created_staff = $_SESSION['labelnashis']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelNashie = $this->LabelNashies->patchEntity($labelNashies, $_SESSION['labelnashis']);
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelNashies->save($labelNashies)) {
/*
           echo "<pre>";
           print_r($_SESSION['labelnashis']);
           echo "</pre>";
*/
           $connection->commit();// コミット5

           //$_SESSION['labelnashis']をinsert into label_nashiする
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('label_nashi');
           $table->setConnection($connection);

             $connection->insert('label_nashi', [
                 'product_id' => $_SESSION['labelnashis']["product_code"],
                 'tourokubi' => $_SESSION['labelnashis']["tourokubi"]
             ]);

         } else {
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10
     }
   }

   public function setikkatsuform()//セット取り入力
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
   }

   public function setikkatsuconfirm()//セット取り確認
   {
     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labelsetikkatsus'] = array();

     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $htmlProductcheck = new htmlProductcheck();//クラスを使用
     $product_code_check = $htmlProductcheck->Productcheck($data["product_id1"]);
     if($product_code_check == 1){
       return $this->redirect(
        ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $data["product_id1"]]]
       );
     }else{
       $product_code_check = $product_code_check;
     }

     $product_code_check = $htmlProductcheck->Productcheck($data["product_id2"]);
     if($product_code_check == 1){
       return $this->redirect(
        ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $data["product_id2"]]]
       );
     }else{
       $product_code_check = $product_code_check;
     }

   }

   public function setikkatsupreadd()//セット取りログイン
   {
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
   }

   public function setikkatsulogin()//セット取りログイン
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'setikkatsudo']);
         }
       }
   }

   public function setikkatsudo()//セット取り登録
   {
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelsetikkatsus'] = array_merge($created_staff,$_SESSION['labelsetikkatsus']);
     $created_staff = $_SESSION['labelsetikkatsus']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelSetikkatsue = $this->LabelSetikkatsues->patchEntity($labelSetikkatsues, $_SESSION['labelsetikkatsus']);
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelSetikkatsues->save($labelSetikkatsues)) {
/*
           echo "<pre>";
           print_r($_SESSION['labelsetikkatsus']);
           echo "</pre>";
*/
           $connection->commit();// コミット5

           //$_SESSION['labelnashis']をinsert into label_setikkatsuする
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('label_setikkatsu');
           $table->setConnection($connection);

             $connection->insert('label_setikkatsu', [
             'product_id1' => $_SESSION['labelsetikkatsus']["product_id1"],
             'product_id2' => $_SESSION['labelsetikkatsus']["product_id2"],
             'tourokubi' => $_SESSION['labelsetikkatsus']["tourokubi"]
             ]);

         } else {
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10
     }
   }

   public function insideoutform()//外箱中身入力
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
   }

   public function insideoutconfirm()//外箱中身確認
   {
     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labelinsideouts'] = array();

     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
     $data = $this->request->getData();
/*
     echo "<pre>";
     print_r($data["product_code"]);
     echo "</pre>";
*/
     $htmlProductcheck = new htmlProductcheck();//クラスを使用
     $product_code_check = $htmlProductcheck->Productcheck($data["product_code"]);
     if($product_code_check == 1){
       return $this->redirect(
        ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $data["product_code"]]]
       );
     }else{
       $product_code_check = $product_code_check;
     }

   }

   public function insideoutpreadd()//外箱中身ログイン
   {
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
   }

   public function insideoutlogin()//外箱中身ログイン
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'insideoutdo']);
         }
       }
   }

   public function insideoutdo()//外箱中身登録
   {
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelinsideouts'] = array_merge($created_staff,$_SESSION['labelinsideouts']);
     $created_staff = $_SESSION['labelinsideouts']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelInsideout = $this->LabelInsideouts->patchEntity($labelInsideouts, $_SESSION['labelinsideouts']);
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelInsideouts->save($labelInsideouts)) {
/*
           echo "<pre>";
           print_r($_SESSION['labelinsideouts']);
           echo "</pre>";
*/
           $connection->commit();// コミット5

           //$_SESSION['labelnashis']をinsert into label_setikkatsuする
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('label_insideout');
           $table->setConnection($connection);

             $connection->insert('label_insideout', [
             'product_id' => $_SESSION['labelinsideouts']["product_code"],
             'num_inside' => $_SESSION['labelinsideouts']["num_inside"]
             ]);

         } else {
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10
     }
   }

   public function unitform()//数量単位入力
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }

   public function unitconfirm()//数量単位確認
   {
     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labelunits'] = array();

     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }

   public function unitpreadd()//数量単位ログイン
   {
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }

   public function unitlogin()//数量単位ログイン
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'unitdo']);
         }
       }
   }

   public function unitdo()//数量単位登録
   {
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelunits'] = array_merge($created_staff,$_SESSION['labelunits']);
     $created_staff = $_SESSION['labelunits']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelElementUnit = $this->LabelElementUnits->patchEntity($labelElementUnits, $_SESSION['labelunits']);//$productデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelElementUnits->save($labelElementUnits)) {
/*
           echo "<pre>";
           print_r($_SESSION['labelunits']);
           echo "</pre>";
*/
           $connection->commit();// コミット5

           //$_SESSION['labelnashis']をinsert into label_element_unitする
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('label_element_unit');
           $table->setConnection($connection);

             $connection->insert('label_element_unit', [
             'unit' => $_SESSION['labelunits']["unit"],
             'genjyou' => $_SESSION['labelunits']["genjyou"]
             ]);

         } else {
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10
     }
   }
   public function ikkatsupreform()//一括ラベル発行
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $scheduleKouteis = $this->ScheduleKouteis->newEntity();
     $this->set('scheduleKouteis',$scheduleKouteis);
/*
	//$f = fopen("\\192.168.4.1\Public\Downloads\label_csv\label_hakkou.csv", "r");
	     $f = fopen('labels/label_ikkatu_200407.csv', 'r');
	 //    $f = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'r');
	while($line = fgetcsv($f)){
	               echo "<pre>";
	               print_r($line);
	               echo "</pre>";
	}
	fclose($f);
*/
   }
   public function ikkatsuform()//一括ラベル発行
   {
     if(!isset($_SESSION)){//sessionsyuuseituika
     session_start();
     }
     $_SESSION['labeljunbi'] = array();

     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);
     $data = $this->request->getData();//postデータを$dataに

      if(isset($data['touroku'])){//csv確認おしたとき
        $this->set('touroku',$data['touroku']);
        $session = $this->request->getSession();
        $dateYMDs = $data['dateYMDs'];
        $dateYMDf = $data['dateYMDf'];
        $this->set('dateYMDs',$dateYMDs);
        $this->set('dateYMDf',$dateYMDf);
        $arrCsv = array();
        for($i=1; $i<=$data['m']; $i++){
          $date = date('Y/m/d H:i:s');
          $datetimeymd = substr($date,0,10);
          $datetimehm = substr($date,11,5);
  //        $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
          $lotnum = substr($_SESSION['lotdate']['lotnum'],2,6);
          $date = substr($date,0,4)."-".substr($date,5,2)."-".substr($date,8,2);
          $Product = $this->Products->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($Product[0])){
            $costomerId = $Product[0]->customer_id;
            $product_name = $Product[0]->product_name;
          }else{
            $costomerId = "";
            $product_name = "登録されていません";
          }
          $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($Konpou[0])){
            $irisu = $Konpou[0]->irisu;
          }else{
            $irisu = "";
            $meserror = "登録されていない製品です：".$_SESSION['labeljunbi'][$i]['product_code'];
          }
          $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
          if(isset($Customer[0])){
            $costomerName = $Customer[0]->name;
          }else{
            $costomerName = "登録されていません";
          }
          $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($LabelTypeProduct[0])){
            $Layout = $LabelTypeProduct[0]->type;
          }else{
            $Layout = "-";
          }

          $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          $unit = "";
          if(isset($LabelTypeProduct[0])){
            $place_code = $LabelTypeProduct[0]->place_code;
            $unit = $LabelTypeProduct[0]->unit;
            if($unit == 2){
              $unit = "set";
            }else{
              $unit = "";
            }
            if($place_code != 0){
              $LabelElementPlace = $this->LabelElementPlaces->find()->where(['place_code' => $place_code])->toArray();
              $place1 = $LabelElementPlace[0]->place1;
              $place2 = $LabelElementPlace[0]->place2;
            }else{
              $place1 = "登録されていません";
              $place2 = "";
            }
          }else{
            $place1 = $costomerName;
            $place2 = "";
          }

          $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();

          //セット取りのINラベルのmaisuの調整
          if(isset($LabelSetikkatsu1[0]) || isset($LabelSetikkatsu2[0])){
            $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
              if(isset($Konpou[0])){
                $irisu1 = $Konpou[0]->irisu;
              }else{
                $irisu1 = "";
              }
              $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
              if(isset($LabelInsideout1[0])){
                $num_inside1 = $LabelInsideout1[0]->num_inside;
              }else{
                $num_inside1 = 1;
              }
              $pro_total1 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $irisu1;
            if(isset($LabelSetikkatsu1[0])){
              $product_id2 = $LabelSetikkatsu1[0]->product_id2;
              $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                if(isset($Konpou[0])){
                  $irisu2 = $Konpou[0]->irisu;
                }else{
                  $irisu2 = "";
                }
                $LabelInsideout2 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                if(isset($LabelInsideout2[0])){
                  $num_inside2 = $LabelInsideout2[0]->num_inside;
                }else{
                  $num_inside2 = 1;
                }
                $maisu2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside2;
                $pro_total2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $irisu2;
            }elseif(isset($LabelSetikkatsu2[0])){
              $product_id2 = $LabelSetikkatsu2[0]->product_id1;
              $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                if(isset($Konpou[0])){
                  $irisu2 = $Konpou[0]->irisu;
                }else{
                  $irisu2 = "";
                }
                $LabelInsideout2 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                if(isset($LabelInsideout2[0])){
                  $num_inside2 = $LabelInsideout2[0]->num_inside;
                }else{
                  $num_inside2 = 1;
                }
                $maisu2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside2;
                $pro_total2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $irisu2;
            }
            if($pro_total1 > $pro_total2){
              $pro_total = $pro_total1;
              $maisu1 = $pro_total/$irisu1;
              $maisu2 = $pro_total/$irisu2;
            }else{
              $pro_total = $pro_total2;
              $maisu1 = $pro_total/$irisu1;
              $maisu2 = $pro_total/$irisu2;
            }
          }else{
            $maisu1 = $_SESSION['labeljunbi'][$i]['yoteimaisu'];
          }
          //セット取りのINラベルのmaisuの調整ここまで

          if($_SESSION['labeljunbi'][$i]['product_code'] === "MLD-NDS-20001" || $_SESSION['labeljunbi'][$i]['product_code'] === "MLD-NDS-20002"){
            $InsideFuyou = 9999;
          }else{
            $InsideFuyou = 0;
          }

          if($Layout == "C"){//〇タイプCの場合は１行に２製品の表示//OK

            if(isset($LabelSetikkatsu1[0])){
              $product_code2 = $LabelSetikkatsu1[0]->product_id2;
              $Product2 = $this->Products->find()->where(['product_code' => $product_code2])->toArray();
              $product_name2 = $Product2[0]->product_name;
              $Konpou = $this->Konpous->find()->where(['product_code' => $product_code2])->toArray();
                if(isset($Konpou[0])){
                  $irisu2 = $Konpou[0]->irisu;
                }else{
                  $irisu2 = "";
                }
            }elseif(isset($LabelSetikkatsu2[0])){
              $product_code2 = $LabelSetikkatsu2[0]->product_id1;
              $Product2 = $this->Products->find()->where(['product_code' => $product_code2])->toArray();
              $product_name2 = $Product2[0]->product_name;
              $Konpou = $this->Konpous->find()->where(['product_code' => $product_code2])->toArray();
                if(isset($Konpou[0])){
                  $irisu2 = $Konpou[0]->irisu;
                }else{
                  $irisu2 = "";
                }
            }else{
              $product_code2 = "";
              $product_name2 = "";
              $irisu2 = "";
            }

            $arrCsv[] = ['maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'], 'layout' => $Layout, 'lotnum' => $lotnum,
             'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
             'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
             'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
             $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
              'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
              'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
              'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

          }elseif(isset($LabelSetikkatsu1[0]) || isset($LabelSetikkatsu2[0])){//〇タイプCでなくセット取りの場合
      //      echo "<pre>";
      //      print_r("タイプCでなくセット取りの場合");
      //      echo "</pre>";
          //まずセット取りの片方の行を登録
            $product_code2 = "";
            $product_name2 = "";
            $irisu2 = "";
            $maisu = $maisu1;

            $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnum,//１行目
             'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
             'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
             'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
             $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
              'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
              'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
              'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

              if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
        //        echo "<pre>";
        //        print_r($_SESSION['labeljunbi'][$i]['product_code']."=pro1にINラベルが必要");
        //        echo "</pre>";

                $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                //maisu=$_SESSION['labeljunbi'][$i][$i]['yoteimaisu']*num_inside
                $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                if(isset($LabelInsideout1[0])){
                  $num_inside1 = $LabelInsideout1[0]->num_inside;
                }else{
                  $num_inside1 = 1;
                }
                $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                if(isset($LabelTypeProduct[0])){
                  $Layout = $LabelTypeProduct[0]->type;
                }else{
                  $Layout = "-";
                }
      //          $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                $maisu = $maisu1 * $num_inside1;
                $irisu12 = $irisu/$num_inside1;
                $irisu22 = "";
                $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,//OK
                'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                 'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                 'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                 'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
               }

                if(isset($LabelSetikkatsu1[0])){//セット取りのもう片方が$LabelSetikkatsu1[0]にあった場合
        //          echo "<pre>";
        //          print_r($LabelSetikkatsu1[0]->product_id2."=pro2セット取りのもう片方がLabelSetikkatsu１");
        //          echo "</pre>";

                  $product_id2 = $LabelSetikkatsu1[0]->product_id2;
                  $Product2 = $this->Products->find()->where(['product_code' => $product_id2])->toArray();
                  $product_name = $Product2[0]->product_name;
                  $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                    if(isset($Konpou[0])){
                      $irisu = $Konpou[0]->irisu;
                    }else{
                      $irisu = "";
                    }
                    $product_code2 = "";
                    $product_name2 = "";
                    $irisu2 = "";
                    $maisu = $maisu2;

                    $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnum,//３行目
                     'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                     'product_code' => $product_id2, 'product_code2' => $product_code2, 'product_name' => trim($product_name),
                     'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                     $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                      'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                      'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                      'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                      if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
                  //      echo "<pre>";
                //        print_r($product_id2."セット取りのもう片方にもINラベルが必要な場合1");
                  //      echo "</pre>";

                        $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                        $LabelInsideout = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                        if(isset($LabelInsideout[0])){
                          $num_inside1 = $LabelInsideout[0]->num_inside;
                        }else{
                          $num_inside1 = 1;
                        }
                        $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $product_id2])->toArray();
                        if(isset($LabelTypeProduct[0])){
                          $Layout = $LabelTypeProduct[0]->type;
                        }else{
                          $Layout = "-";
                        }
                    //    $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                        $maisu = $maisu2 * $num_inside1;
                        $irisu12 = $irisu/$num_inside1;
                        $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                        $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,//4行目
                        'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                        'product_code' => $product_id2, 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                        'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                        $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                         'product1' => $product_id2, 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                         'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                         'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                       }

                }else{//セット取りのもう片方が$LabelSetikkatsu2[0]にあった場合//OK
      //            echo "<pre>";
      //            print_r($LabelSetikkatsu2[0]->product_id1."=pro2セット取りのもう片方がLabelSetikkatsu２");
      //            echo "</pre>";

                  $product_id2 = $LabelSetikkatsu2[0]->product_id1;
                  $Product2 = $this->Products->find()->where(['product_code' => $product_id2])->toArray();
                  $product_name = $Product2[0]->product_name;
                  $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                    if(isset($Konpou[0])){
                      $irisu = $Konpou[0]->irisu;
                    }else{
                      $irisu = "";
                    }
                    $maisu = $maisu2;

                    $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnum,//３行目
                     'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                     'product_code' => $product_id2, 'product_code2' => $product_code2, 'product_name' => trim($product_name),
                     'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                     $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                      'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                      'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                      'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                      if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
                        $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                        $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                        if(isset($LabelInsideout1[0])){
                          $num_inside1 = $LabelInsideout1[0]->num_inside;
                        }else{
                          $num_inside1 = 1;
                        }
                        $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $product_id2])->toArray();
                        if(isset($LabelTypeProduct[0])){
                          $Layout = $LabelTypeProduct[0]->type;
                        }else{
                          $Layout = "-";
                        }
            //            $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                        $maisu = $maisu2 * $num_inside1;
                        $irisu12 = $irisu/$num_inside1;
                        $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));
                //        echo "<pre>";
                //        print_r($product_id2."セット取りのもう片方にもINラベルが必要な場合2".$maisu2."--".$num_inside1);
                //        echo "</pre>";

                        $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,//4行目
                        'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                        'product_code' => $product_id2, 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                        'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                        $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                         'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                         'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                         'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                       }
              }

          }else{//〇タイプCでもセット取りでもない場合１行に１製品
            $product_code2 = "";//修正
            $product_name2 = "";//修正
            $irisu2 = "";//修正

            $arrCsv[] = ['maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'], 'layout' => $Layout, 'lotnum' => $lotnum,
             'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
             'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
             'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
             $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
              'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
              'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
              'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

              if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合

                $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                //maisu=$_SESSION['labeljunbi'][$i][$i]['yoteimaisu']*num_inside
                $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                if(isset($LabelInsideout1[0])){
                  $num_inside1 = $LabelInsideout1[0]->num_inside;
                }else{
                  $num_inside1 = 1;
                }
                $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                if(isset($LabelTypeProduct[0])){
                  $Layout = $LabelTypeProduct[0]->type;
                }else{
                  $Layout = "-";
                }
                $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                $irisu12 = $irisu/$num_inside1;
                $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));
                $irisu22 = "";

                $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,
                'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                 'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                 'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                 'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
               }
          }

        }

  //      $fp = fopen('labels/label_ikkatu_200601.csv', 'w');
        $fp = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'w');

        foreach ($arrCsv as $line) {
          $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
        	fputcsv($fp, $line);
        }
        fclose($fp);
/*
          echo "<pre>";
          print_r($arrCsvtouroku);
          echo "</pre>";
*/

          $labelCsvs = $this->LabelCsvs->newEntity();
          $this->set('labelCsvs',$labelCsvs);
           if ($this->request->is('post')) {
             $labelCsvs = $this->LabelCsvs->patchEntities($labelCsvs, $arrCsvtouroku);
             $connection = ConnectionManager::get('default');//トランザクション1
             // トランザクション開始2
             $connection->begin();//トランザクション3
             try {//トランザクション4
                 if ($this->LabelCsvs->saveMany($labelCsvs)) {//saveManyで一括登録
                   $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました";
                   $this->set('mes',$mes);
                   $connection->commit();// コミット5

                   //insert into label_csvする
                   $connection = ConnectionManager::get('sakaeMotoDB');
                   $table = TableRegistry::get('label_csv');
                   $table->setConnection($connection);

                   for($k=0; $k<count($arrCsvtouroku); $k++){
                     $connection->insert('label_csv', [
                         'number_sheet' => $arrCsvtouroku[$k]["number_sheet"],
                         'hanbetsu' => $arrCsvtouroku[$k]["hanbetsu"],
                         'place1' => $arrCsvtouroku[$k]["place1"],
                         'place2' => $arrCsvtouroku[$k]["place2"],
                         'product1' => $arrCsvtouroku[$k]["product1"],
                         'product2' => $arrCsvtouroku[$k]["product2"],
                         'name_pro1' => $arrCsvtouroku[$k]["name_pro1"],
                         'name_pro2' => $arrCsvtouroku[$k]["name_pro2"],
                         'irisu1' => $arrCsvtouroku[$k]["irisu1"],
                         'irisu2' => $arrCsvtouroku[$k]["irisu2"],
                         'unit1' => $arrCsvtouroku[$k]["unit1"],
                         'unit2' => $arrCsvtouroku[$k]["unit2"],
                         'line_code' => $arrCsvtouroku[$k]["line_code"],
                         'date' => $arrCsvtouroku[$k]["date"],
                         'start_lot' => $arrCsvtouroku[$k]["start_lot"]
                     ]);
                   }


                 } else {
                   $mes = "\\192.168.4.246\home\centosuser\label_csv にＣＳＶファイルが出力されました。※データベースへ登録されませんでした。Productsテーブルに".$meserror;
                   $this->set('mes',$mes);
                   $this->Flash->error(__('The data could not be saved. Please, try again.'));
                   throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                 }
             } catch (Exception $e) {//トランザクション7
             //ロールバック8
               $connection->rollback();//トランザクション9
             }//トランザクション10
           }

      }elseif(isset($data['confirm'])){//確認おしたとき
       $this->set('confirm',$data['confirm']);
       $dateYMDs = $data['dateYMDs'];
       $dateYMDf = $data['dateYMDf'];
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
     }elseif(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
       $data = $this->request->getData();//postデータを$dataに
       $dateYMDs = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 08:00";
  //     $dateYMDf = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 07:59";
       $dateYMDf0 = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day'];
       $dateYMDf1 = strtotime($dateYMDf0);
       $dateYMDf2 = date('Y-m-d', strtotime('+1 day', $dateYMDf1));
       $dateHI = date("07:59");
       $dateYMDf = $dateYMDf2." ".$dateHI;
       $_SESSION['lotdate'] = array(
         "lotnum" => $data['manu_date']['year'].$data['manu_date']['month'].$data['manu_date']['day']
       );
/*
       echo "<pre>";
       print_r($_SESSION['lotdate']['lotnum']);
       echo "</pre>";
*/
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
       for($i=1; $i<=9; $i++){
        ${"tuika".$i} = 0;
        $this->set('tuika'.$i,${"tuika".$i});//セット
       }
       for($i=1; $i<=9; $i++){
        ${"ntuika".$i} = 0;
        $this->set('ntuika'.$i,${"ntuika".$i});//セット
       }
     }else{//追加押したとき
       $dateYMDs = $data['dateYMDs'];
       $dateYMDf = $data['dateYMDf'];
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
       for($i=1; $i<=9; $i++){
         ${"tuika".$i} = $data["tuika".$i];
         $this->set('tuika'.$i,${"tuika".$i});//セット
       }
       for($i=1; $i<=9; $i++){
         if(isset($data["ntuika".$i])) {
             ${"ntuika".$i} = $data["ntuika".$i];
             $this->set('ntuika'.$i,${"ntuika".$i});//セット
        }
      }
     }

     $i = 1;
     if($i == 1){//sakaeMotoDBを使う
       /*
       $connection = ConnectionManager::get('DB_ikou_test');
       $table = TableRegistry::get('scheduleKoutei');
       $table->setConnection($connection);
       $connection = ConnectionManager::get('DB_ikou_test');
*/
//       $ScheduleKoutei = $this->ScheduleKoutei->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'present_kensahyou' => 0])->toArray();
//※findに対応していないため、SQL文で持ってくる

        for($j=1; $j<=9; $j++){
          $dateYMDs = mb_substr($dateYMDs, 0, 10);
          $dateYMDf = mb_substr($dateYMDf, 0, 10);
/*
          $sql = "SELECT datetime,seikeiki,product_id,present_kensahyou,product_name FROM schedule_koutei".
                " where datetime >= '".$dateYMDs."' and datetime <= '".$dateYMDf."' and seikeiki = ".$j." order by datetime asc";
          $connection = ConnectionManager::get('sakaeMotoDB');
          $scheduleKoutei = $connection->execute($sql)->fetchAll('assoc');

          echo "<pre>";
          print_r($scheduleKoutei);
          echo "</pre>";
*/
          $scheduleKoutei = $this->ScheduleKouteis->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'seikeiki' => $j, 'delete_flag' => 0])->toArray();

          ${"arrP".$j} = array();
          ${"n".$j} = 0;
          $this->set('n'.$j,${"n".$j});
           for($i=1; $i<=10; $i++){
             ${"arrP".$j.$i} = array();
             if(isset($scheduleKoutei[$i-1])) {
               ${"ScheduleKoutei_id".$i} = 0;
               ${"datetime".$i} = $scheduleKoutei[$i-1]["datetime"]->format('Y-m-d H:i:s');
               $dateYMD = $scheduleKoutei[$i-1]["datetime"]->format('Y-m-d');
               $dateYMD1 = strtotime($dateYMD);
               $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
               $dateHI = date("08:00");
               ${"finishing_tm".$i} = $dayto." ".$dateHI;
               ${"seikeiki".$i} = $scheduleKoutei[$i-1]["seikeiki"];
               ${"product_code".$i} = $scheduleKoutei[$i-1]["product_code"];
               ${"present_kensahyou".$i} = $scheduleKoutei[$i-1]["present_kensahyou"];
               ${"product_name".$i} = $scheduleKoutei[$i-1]["product_name"];
               ${"arrP".$j}[] = ['id' => ${"ScheduleKoutei_id".$i}, 'datetime' => ${"datetime".$i},
                'product_code' => ${"product_code".$i},'seikeiki' => ${"seikeiki".$i},
                'present_kensahyou' => ${"present_kensahyou".$i},'product_name' => ${"product_name".$i},
                'finishing_tm' => ${"finishing_tm".$i}];
               ${"n".$j} = $i;
               $this->set('n'.$j,${"n".$j});//セット
             }
            }
            ${"ScheduleKouteisarry".$j} = array();//空の配列を作る
            foreach ((array)${"arrP".$j} as $key => $value) {//datetimeで並び替え
                 $sort[$key] = $value['datetime'];
                  array_push(${"ScheduleKouteisarry".$j}, ['id' => $value['id'], 'starting_tm' => $value['datetime'],
                   'seikeiki' => $value['seikeiki'], 'product_code' => $value['product_code'],
                    'present_kensahyou' => $value['present_kensahyou'], 'product_name' => $value['product_name'],
                  'finishing_tm' => $value['finishing_tm']]);
            }
             if(isset(${"ScheduleKouteisarry".$j}[0])){
                array_multisort(array_map("strtotime", array_column( ${"ScheduleKouteisarry".$j}, "starting_tm" ) ), SORT_ASC, ${"ScheduleKouteisarry".$j});
            for($m=1; $m<=${"n".$j}; $m++){//同じ成型機で製品が作られている個数分
              ${"arrP".$j.$m}[] = ${"ScheduleKouteisarry".$j}[$m-1];
              $this->set('arrP'.$j.$m,${"arrP".$j.$m});//セット
                if($m>=2){//同じ成型機で２つ以上の製品ができているとき
                  $m1 = $m-1 ;
                  ${"arrP".$j.$m1} = array();//m-1の配列を空にする
                  $replacements = array('finishing_tm' => ${"ScheduleKouteisarry".$j}[$m-1]['starting_tm']);//１つ前のfin_tmを後のsta_tmに変更する
                  ${"ScheduleKouteisarry".$j}[$m-2] = array_replace(${"ScheduleKouteisarry".$j}[$m-2], $replacements);
                  ${"arrP".$j.$m1}[] = ${"ScheduleKouteisarry".$j}[$m-2];
                  $this->set('arrP'.$j.$m1,${"arrP".$j.$m1});//セット
                }
            }
          }
        }

     }else{//defaultを使う

        for($j=1; $j<=9; $j++){

        $ScheduleKoutei = $this->ScheduleKouteis->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'seikeiki' => $j, 'delete_flag' => 0])->toArray();
        ${"arrP".$j} = array();
        ${"n".$j} = 0;
        $this->set('n'.$j,${"n".$j});
           for($i=1; $i<=10; $i++){
             ${"arrP".$j.$i} = array();
             if(isset($ScheduleKoutei[$i-1])) {
               ${"ScheduleKoutei_id".$i} = $ScheduleKoutei[$i-1]->id;
               ${"datetime".$i} = $ScheduleKoutei[$i-1]->datetime->format('Y-m-d H:i:s');
               $dateYMD = $ScheduleKoutei[$i-1]->datetime->format('Y-m-d');
               $dateYMD1 = strtotime($dateYMD);
               $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
               $dateHI = date("08:00");
               ${"finishing_tm".$i} = $dayto." ".$dateHI;
               ${"seikeiki".$i} = $ScheduleKoutei[$i-1]->seikeiki;
               ${"product_code".$i} = $ScheduleKoutei[$i-1]->product_code;
               ${"present_kensahyou".$i} = $ScheduleKoutei[$i-1]->present_kensahyou;
               ${"product_name".$i} = $ScheduleKoutei[$i-1]->product_name;
               ${"arrP".$j}[] = ['id' => ${"ScheduleKoutei_id".$i}, 'datetime' => ${"datetime".$i},
                'product_code' => ${"product_code".$i},'seikeiki' => ${"seikeiki".$i},
                'present_kensahyou' => ${"present_kensahyou".$i},'product_name' => ${"product_name".$i},
                'finishing_tm' => ${"finishing_tm".$i}];
               ${"n".$j} = $i;
               $this->set('n'.$j,${"n".$j});//セット
/*
               echo "<pre>";
               print_r(${"arrP".$j});
               echo "</pre>";
*/
             }
            }
            ${"ScheduleKouteisarry".$j} = array();//空の配列を作る
            foreach ((array)${"arrP".$j} as $key => $value) {//datetimeで並び替え
                 $sort[$key] = $value['datetime'];
                  array_push(${"ScheduleKouteisarry".$j}, ['id' => $value['id'], 'starting_tm' => $value['datetime'],
                   'seikeiki' => $value['seikeiki'], 'product_code' => $value['product_code'],
                    'present_kensahyou' => $value['present_kensahyou'], 'product_name' => $value['product_name'],
                  'finishing_tm' => $value['finishing_tm']]);
            }
             if(isset(${"ScheduleKouteisarry".$j}[0])){
                array_multisort(array_map("strtotime", array_column( ${"ScheduleKouteisarry".$j}, "starting_tm" ) ), SORT_ASC, ${"ScheduleKouteisarry".$j});
            for($m=1; $m<=${"n".$j}; $m++){//同じ成型機で製品が作られている個数分
              ${"arrP".$j.$m}[] = ${"ScheduleKouteisarry".$j}[$m-1];
              $this->set('arrP'.$j.$m,${"arrP".$j.$m});//セット
                if($m>=2){//同じ成型機で２つ以上の製品ができているとき
                  $m1 = $m-1 ;
                  ${"arrP".$j.$m1} = array();//m-1の配列を空にする
                  $replacements = array('finishing_tm' => ${"ScheduleKouteisarry".$j}[$m-1]['starting_tm']);//１つ前のfin_tmを後のsta_tmに変更する
                  ${"ScheduleKouteisarry".$j}[$m-2] = array_replace(${"ScheduleKouteisarry".$j}[$m-2], $replacements);
                  ${"arrP".$j.$m1}[] = ${"ScheduleKouteisarry".$j}[$m-2];
                  $this->set('arrP'.$j.$m1,${"arrP".$j.$m1});//セット
                }
            }
          }
        }
     }
   }

		public function preadd()
		{
      $KadouSeikei = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikei',$KadouSeikei);
		}

		public function login()
		{
			if ($this->request->is('post')) {
				$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
				$str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
				$ary = explode(',', $str);//$strを配列に変換
				$username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
				//※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
				$this->set('username', $username);
				$Userdata = $this->Users->find()->where(['username' => $username])->toArray();
					if(empty($Userdata)){
						$delete_flag = "";
					}else{
						$delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
						$this->set('delete_flag',$delete_flag);//登録者の表示のため
					}
						$user = $this->Auth->identify();
					if ($user) {
						$this->Auth->setUser($user);
						return $this->redirect(['action' => 'do']);
					}
				}
		}

    public function logout()
		{
      //$this->request->session()->destroy(); // セッションの破棄
			return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
		}

   public function do()
  {
    $KadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('KadouSeikeis',$KadouSeikeis);
    $session = $this->request->getSession();
    $data = $session->read();
    for($n=1; $n<=100; $n++){
      if(isset($_SESSION['kadouseikei'][$n])){
        $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
        $_SESSION['kadouseikei'][$n] = array_merge($_SESSION['kadouseikei'][$n],$created_staff);
      }else{
        break;
      }
    }
    if ($this->request->is('get')) {
      $KadouSeikeis = $this->KadouSeikeis->patchEntities($KadouSeikeis, $_SESSION['kadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->KadouSeikeis->saveMany($KadouSeikeis)) {
          for($n=1; $n<=100; $n++){
            if(isset($_SESSION['kadouseikei'][$n])){
              $KariKadouSeikeiData = $this->KariKadouSeikeis->find()->where(['id' => $_SESSION['kadouseikeiId'][$n]])->toArray();//'present_kensahyou' => 0となるデータをKadouSeikeisテーブルから配列で取得
              $KariKadouSeikeistarting_tm = $KariKadouSeikeiData[0]->starting_tm->format('Y-m-d H:i:s');
        //      $KariKadouSeikeistarting_tm = substr($KariKadouSeikeistarting_tm,0,4)."-".substr($KariKadouSeikeistarting_tm,5,2)."-".substr($KariKadouSeikeistarting_tm,8,2);
              $KariKadouSeikeifinishing_tm = $KariKadouSeikeiData[0]->finishing_tm->format('Y-m-d H:i:s');
        //      $KariKadouSeikeifinishing_tm = substr($KariKadouSeikeifinishing_tm,0,4)."-".substr($KariKadouSeikeifinishing_tm,5,2)."-".substr($KariKadouSeikeifinishing_tm,8,2);
              $KariKadouSeikeicreated_at = $KariKadouSeikeiData[0]->created_at->format('Y-m-d H:i:s');
              $this->KariKadouSeikeis->updateAll(
              ['present_kensahyou' => 1 ,'starting_tm' => $KariKadouSeikeistarting_tm ,'finishing_tm' => $KariKadouSeikeifinishing_tm ,'created_at' => $KariKadouSeikeicreated_at ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
              ['id'   => $_SESSION['kadouseikeiId'][$n] ]
              );
            }else{
              break;
            }
          }
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

  public function kobetuform()//個別成形（時間なし）
  {
    session_start();
    $labelCsvs = $this->LabelCsvs->newEntity();
    $this->set('labelCsvs',$labelCsvs);
    $data = $this->request->getData();//postデータを$dataに

     if(isset($data['touroku'])){//csv確認おしたとき
       $this->set('touroku',$data['touroku']);
       $session = $this->request->getSession();
       $arrCsv = array();
         $date = date('Y/m/d H:i:s');
         $datetimeymd = substr($date,0,10);
         $datetimehm = substr($date,11,5);
  //       $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
         $lotnum = substr($_SESSION['lotdate']['lotnum'],2,6);
         $date = substr($date,0,4)."-".substr($date,5,2)."-".substr($date,8,2);
         $Product = $this->Products->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
         if(isset($Product[0])){
           $costomerId = $Product[0]->customer_id;
           $product_name = $Product[0]->product_name;
         }else{
           $costomerId = "";
         }
         $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
         if(isset($Konpou[0])){
           $irisu = $Konpou[0]->irisu;
         }else{
           $irisu = "";
         }
         $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
         if(isset($Customer[0])){
           $costomerName = $Customer[0]->name;
         }else{
           $costomerName = "";
         }
         $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
         if(isset($LabelTypeProduct[0])){
           $Layout = $LabelTypeProduct[0]->type;
         }else{
           $Layout = "-";
         }

         $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
         $unit = "";
         if(isset($LabelTypeProduct[0])){
           $place_code = $LabelTypeProduct[0]->place_code;
           $unit = $LabelTypeProduct[0]->unit;
           if($unit == 2){
             $unit = "set";
           }else{
             $unit = "";
           }
           if($place_code != 0){
             $LabelElementPlace = $this->LabelElementPlaces->find()->where(['place_code' => $place_code])->toArray();
             $place1 = $LabelElementPlace[0]->place1;
             $place2 = $LabelElementPlace[0]->place2;
           }else{
             $place1 = "";
             $place2 = "";
           }
         }else{
           $place1 = $costomerName;
           $place2 = "";
         }

         $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $_SESSION['labeljunbi']['product_code']])->toArray();
         $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $_SESSION['labeljunbi']['product_code']])->toArray();
         $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();


         if($_SESSION['labeljunbi']['product_code'] === "MLD-NDS-20001" || $_SESSION['labeljunbi']['product_code'] === "MLD-NDS-20002"){
           $InsideFuyou = 9999;
         }else{
           $InsideFuyou = 0;
         }

         if($LabelTypeProduct[0]->type == "C"){//〇タイプCの場合は１行に２製品の表示

           if(isset($LabelSetikkatsu1[0])){
             $product_code2 = $LabelSetikkatsu1[0]->product_id2;
             $Product2 = $this->Products->find()->where(['product_code' => $product_code2])->toArray();
             $product_name2 = $Product2[0]->product_name;
             $Konpou = $this->Konpous->find()->where(['product_code' => $product_code2])->toArray();
               if(isset($Konpou[0])){
                 $irisu2 = $Konpou[0]->irisu;
               }else{
                 $irisu2 = "";
               }
           }elseif(isset($LabelSetikkatsu2[0])){
             $product_code2 = $LabelSetikkatsu2[0]->product_id1;
             $Product2 = $this->Products->find()->where(['product_code' => $product_code2])->toArray();
             $product_name2 = $Product2[0]->product_name;
             $Konpou = $this->Konpous->find()->where(['product_code' => $product_code2])->toArray();
               if(isset($Konpou[0])){
                 $irisu2 = $Konpou[0]->irisu;
               }else{
                 $irisu2 = "";
               }
           }else{
             $product_code2 = "";
             $product_name2 = "";
             $irisu2 = "";
           }

           $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnum,
            'renban' => $_SESSION['labeljunbi']['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
            'product_code' => $_SESSION['labeljunbi']['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
            'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
            $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
             'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
             'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
             'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

         }elseif(isset($LabelSetikkatsu1[0]) || isset($LabelSetikkatsu2[0])){//〇タイプCでなくセット取りの場合
           //まずセット取りの片方の行を登録
             $product_code2 = "";
             $product_name2 = "";
             $irisu2 = "";

             $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnum,//１行目
              'renban' => $_SESSION['labeljunbi']['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
              'product_code' => $_SESSION['labeljunbi']['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
              'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
              $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
               'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
               'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
               'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

               if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
         //        echo "<pre>";
         //        print_r($_SESSION['labeljunbi']['product_code']."=pro1にINラベルが必要");
         //        echo "</pre>";

                 $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                 //maisu=$_SESSION['labeljunbi'][$i]['yoteimaisu']*num_inside
                 $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
                 if(isset($LabelInsideout1[0])){
                   $num_inside1 = $LabelInsideout1[0]->num_inside;
                 }else{
                   $num_inside1 = 1;
                 }
                 $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
                 if(isset($LabelTypeProduct[0])){
                   $Layout = $LabelTypeProduct[0]->type;
                 }else{
                   $Layout = "-";
                 }
        //         $maisu = $_SESSION['labeljunbi']['yoteimaisu'] * $num_inside1;
                 $irisu12 = $irisu/$num_inside1;
                 $irisu22 = "";
                 $renban = (($_SESSION['labeljunbi']['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                 $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnumIN,//OK
                 'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                 'product_code' => $_SESSION['labeljunbi']['product_code'], 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                 'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                 $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                  'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                  'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                  'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                }

                 if(isset($LabelSetikkatsu1[0])){//セット取りのもう片方が$LabelSetikkatsu1[0]にあった場合
         //          echo "<pre>";
         //          print_r($LabelSetikkatsu1[0]->product_id2."=pro2セット取りのもう片方がLabelSetikkatsu１");
         //          echo "</pre>";

                   $product_id2 = $LabelSetikkatsu1[0]->product_id2;
                   $Product2 = $this->Products->find()->where(['product_code' => $product_id2])->toArray();
                   $product_name = $Product2[0]->product_name;
                   $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                     if(isset($Konpou[0])){
                       $irisu = $Konpou[0]->irisu;
                     }else{
                       $irisu = "";
                     }
                     $product_code2 = "";
                     $product_name2 = "";
                     $irisu2 = "";

                     $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnum,//３行目
                      'renban' => $_SESSION['labeljunbi']['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                      'product_code' => $product_id2, 'product_code2' => $product_code2, 'product_name' => trim($product_name),
                      'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                      $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                       'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                       'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                       'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                       if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
           //              echo "<pre>";
           //              print_r($product_id2."セット取りのもう片方にもINラベルが必要な場合1");
           //              echo "</pre>";

                         $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                         $LabelInsideout = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                         if(isset($LabelInsideout[0])){
                           $num_inside1 = $LabelInsideout[0]->num_inside;
                         }else{
                           $num_inside1 = 1;
                         }
                         $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $product_id2])->toArray();
                         if(isset($LabelTypeProduct[0])){
                           $Layout = $LabelTypeProduct[0]->type;
                         }else{
                           $Layout = "-";
                         }
                //         $maisu = $_SESSION['labeljunbi']['yoteimaisu'] * $num_inside1;
                         $irisu12 = $irisu/$num_inside1;
                         $renban = (($_SESSION['labeljunbi']['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                         $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnumIN,//4行目
                         'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                         'product_code' => $product_id2, 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                         'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                         $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                          'product1' => $product_id2, 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                          'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                          'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                        }

                 }else{//セット取りのもう片方が$LabelSetikkatsu2[0]にあった場合//OK
       //            echo "<pre>";
       //            print_r($LabelSetikkatsu2[0]->product_id1."=pro2セット取りのもう片方がLabelSetikkatsu２");
       //            echo "</pre>";

                   $product_id2 = $LabelSetikkatsu2[0]->product_id1;
                   $Product2 = $this->Products->find()->where(['product_code' => $product_id2])->toArray();
                   $product_name = $Product2[0]->product_name;
                   $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                     if(isset($Konpou[0])){
                       $irisu = $Konpou[0]->irisu;
                     }else{
                       $irisu = "";
                     }

                     $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnum,//３行目
                      'renban' => $_SESSION['labeljunbi']['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                      'product_code' => $product_id2, 'product_code2' => $product_code2, 'product_name' => trim($product_name),
                      'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                      $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                       'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                       'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                       'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                       if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
       //                  echo "<pre>";
       //                  print_r($product_id2."セット取りのもう片方にもINラベルが必要な場合2");
       //                  echo "</pre>";

                         $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                         $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                         if(isset($LabelInsideout1[0])){
                           $num_inside1 = $LabelInsideout1[0]->num_inside;
                         }else{
                           $num_inside1 = 1;
                         }
                         $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $product_id2])->toArray();
                         if(isset($LabelTypeProduct[0])){
                           $Layout = $LabelTypeProduct[0]->type;
                         }else{
                           $Layout = "-";
                         }
                //         $maisu = $_SESSION['labeljunbi']['yoteimaisu'] * $num_inside1;
                         $irisu12 = $irisu/$num_inside1;
                         $renban = (($_SESSION['labeljunbi']['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                         $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnumIN,//4行目
                         'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                         'product_code' => $product_id2, 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                         'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                         $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                          'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                          'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                          'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                        }
               }

         }else{//〇タイプCでもセット取りでもない場合１行に１製品
           $product_code2 = "";//修正
           $product_name2 = "";//修正
           $irisu2 = "";//修正

           $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnum,
            'renban' => $_SESSION['labeljunbi']['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
            'product_code' => $_SESSION['labeljunbi']['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
            'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
            $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
             'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
             'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
             'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

             if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合

               $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
               //maisu=$_SESSION['labeljunbi'][$i]['yoteimaisu']*num_inside
               $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
               if(isset($LabelInsideout1[0])){
                 $num_inside1 = $LabelInsideout1[0]->num_inside;
               }else{
                 $num_inside1 = 1;
               }
               $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi']['product_code']])->toArray();
               if(isset($LabelTypeProduct[0])){
                 $Layout = $LabelTypeProduct[0]->type;
               }else{
                 $Layout = "-";
               }
          //     $maisu = $_SESSION['labeljunbi']['yoteimaisu'] * $num_inside1;
               $irisu12 = $irisu/$num_inside1;
               $renban = (($_SESSION['labeljunbi']['hakoNo'] * $num_inside1) - ($num_inside1 - 1));
               $irisu22 = "";

               $arrCsv[] = ['maisu' => "", 'layout' => $Layout, 'lotnum' => $lotnumIN,
               'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
               'product_code' => $_SESSION['labeljunbi']['product_code'], 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
               'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
               $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                'product1' => $_SESSION['labeljunbi']['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi']['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
              }
         }//修正

/*
      echo "<pre>";
      print_r($arrCsvtouroku);
      echo "</pre>";
*/
  //     $fp = fopen('labels/label_kobetu200601.csv', 'w');
       $fp = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'w');
       foreach ($arrCsv as $line) {
         $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
         fputcsv($fp, $line);
       }
       fclose($fp);

         $labelCsvs = $this->LabelCsvs->newEntity();
         $this->set('labelCsvs',$labelCsvs);
          if ($this->request->is('post')) {
            $labelCsvs = $this->LabelCsvs->patchEntities($labelCsvs, $arrCsvtouroku);
            $connection = ConnectionManager::get('default');//トランザクション1
            // トランザクション開始2
            $connection->begin();//トランザクション3
            try {//トランザクション4
                if ($this->LabelCsvs->saveMany($labelCsvs)) {//saveManyで一括登録
                  $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました";
                  $this->set('mes',$mes);
                  $connection->commit();// コミット5

                  //insert into label_csvする
                  $connection = ConnectionManager::get('sakaeMotoDB');
                  $table = TableRegistry::get('label_csv');
                  $table->setConnection($connection);

                  for($k=0; $k<count($arrCsvtouroku); $k++){
                    $connection->insert('label_csv', [
                        'number_sheet' => $arrCsvtouroku[$k]["number_sheet"],
                        'hanbetsu' => $arrCsvtouroku[$k]["hanbetsu"],
                        'place1' => $arrCsvtouroku[$k]["place1"],
                        'place2' => $arrCsvtouroku[$k]["place2"],
                        'product1' => $arrCsvtouroku[$k]["product1"],
                        'product2' => $arrCsvtouroku[$k]["product2"],
                        'name_pro1' => $arrCsvtouroku[$k]["name_pro1"],
                        'name_pro2' => $arrCsvtouroku[$k]["name_pro2"],
                        'irisu1' => $arrCsvtouroku[$k]["irisu1"],
                        'irisu2' => $arrCsvtouroku[$k]["irisu2"],
                        'unit1' => $arrCsvtouroku[$k]["unit1"],
                        'unit2' => $arrCsvtouroku[$k]["unit2"],
                        'line_code' => $arrCsvtouroku[$k]["line_code"],
                        'date' => $arrCsvtouroku[$k]["date"],
                        'start_lot' => $arrCsvtouroku[$k]["start_lot"]
                    ]);
                  }


                } else {
                  $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました※データベースへ登録されませんでした";
                  $this->set('mes',$mes);
                  $this->Flash->error(__('The data could not be saved. Please, try again.'));
                  throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                }
            } catch (Exception $e) {//トランザクション7
            //ロールバック8
              $connection->rollback();//トランザクション9
            }//トランザクション10
          }

     }elseif(isset($data['confirm'])){//確認おしたとき
      $this->set('confirm',$data['confirm']);
      $_SESSION['lotdate'] = array(
        "lotnum" => $data['kobetudate']['year'].$data['kobetudate']['month'].$data['kobetudate']['day']
      );

      $product_code = mb_strtoupper($data["product_code"]);
      $this->set('product_code',$product_code);

      $htmlProductcheck = new htmlProductcheck();//クラスを使用
      $product_code_check = $htmlProductcheck->Productcheck($product_code);
      if($product_code_check == 1){
        return $this->redirect(
         ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $product_code]]
        );
      }else{
        $product_code_check = $product_code_check;
      }

/*
      echo "<pre>";
      print_r($product_code);//大文字に変換
      echo "</pre>";
*/
    }elseif(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
    }else{
      echo "<pre>";
      print_r("error");
      echo "</pre>";
    }
  }

     public function kobetupreform()//個別成形時間
     {
       //$this->request->session()->destroy(); // セッションの破棄
       $scheduleKouteis = $this->ScheduleKouteis->newEntity();
       $this->set('scheduleKouteis',$scheduleKouteis);
     }

     public function kobetujikanform()//個別成形時間
     {
       session_start();
       $KadouSeikeis = $this->KadouSeikeis->newEntity();
       $this->set('KadouSeikeis',$KadouSeikeis);
       $data = $this->request->getData();//postデータを$dataに
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
        if(isset($data['touroku'])){//csv確認おしたとき
          $this->set('touroku',$data['touroku']);
          $session = $this->request->getSession();
          $arrCsv = array();
          for($i=1; $i<=$data['m']; $i++){
            $date = date('Y/m/d H:i:s');
            $datetimeymd = substr($date,0,10);
            $datetimehm = substr($date,11,5);
        //    $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
            $lotnum = $_SESSION['lotdate']['lotnum'];
            $date = substr($date,0,4)."-".substr($date,5,2)."-".substr($date,8,2);
            $Product = $this->Products->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($Product[0])){
              $costomerId = $Product[0]->customer_id;
              $product_name = $Product[0]->product_name;
            }else{
              $costomerId = "";
            }
            $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($Konpou[0])){
              $irisu = $Konpou[0]->irisu;
            }else{
              $irisu = "";
            }
            $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
            if(isset($Customer[0])){
              $costomerName = $Customer[0]->name;
            }else{
              $costomerName = "";
            }
            $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($LabelTypeProduct[0])){
              $Layout = $LabelTypeProduct[0]->type;
            }else{
              $Layout = "-";
            }

            $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            $unit = "";
            if(isset($LabelTypeProduct[0])){
              $place_code = $LabelTypeProduct[0]->place_code;
              $unit = $LabelTypeProduct[0]->unit;
              if($unit == 2){
                $unit = "set";
              }else{
                $unit = "";
              }
              if($place_code != 0){
                $LabelElementPlace = $this->LabelElementPlaces->find()->where(['place_code' => $place_code])->toArray();
                $place1 = $LabelElementPlace[0]->place1;
                $place2 = $LabelElementPlace[0]->place2;
              }else{
                $place1 = "";
                $place2 = "";
              }
            }else{
              $place1 = $costomerName;
              $place2 = "";
            }

            $LabelSetikkatsu1 = $this->LabelSetikkatsues->find()->where(['product_id1' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            $LabelSetikkatsu2 = $this->LabelSetikkatsues->find()->where(['product_id2' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();

//セット取りのINラベルのmaisuの調整
        if(isset($LabelSetikkatsu1[0]) || isset($LabelSetikkatsu2[0])){
          $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($Konpou[0])){
              $irisu1 = $Konpou[0]->irisu;
            }else{
              $irisu1 = "";
            }
            $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($LabelInsideout1[0])){
              $num_inside1 = $LabelInsideout1[0]->num_inside;
            }else{
              $num_inside1 = 1;
            }
            $pro_total1 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $irisu1;
          if(isset($LabelSetikkatsu1[0])){
            $product_id2 = $LabelSetikkatsu1[0]->product_id2;
            $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
              if(isset($Konpou[0])){
                $irisu2 = $Konpou[0]->irisu;
              }else{
                $irisu2 = "";
              }
              $LabelInsideout2 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
              if(isset($LabelInsideout2[0])){
                $num_inside2 = $LabelInsideout2[0]->num_inside;
              }else{
                $num_inside2 = 1;
              }
              $maisu2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside2;
              $pro_total2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $irisu2;
          }elseif(isset($LabelSetikkatsu2[0])){
            $product_id2 = $LabelSetikkatsu2[0]->product_id1;
            $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
              if(isset($Konpou[0])){
                $irisu2 = $Konpou[0]->irisu;
              }else{
                $irisu2 = "";
              }
              $LabelInsideout2 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
              if(isset($LabelInsideout2[0])){
                $num_inside2 = $LabelInsideout2[0]->num_inside;
              }else{
                $num_inside2 = 1;
              }
              $maisu2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside2;
              $pro_total2 = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $irisu2;
          }
          if($pro_total1 > $pro_total2){
            $pro_total = $pro_total1;
            $maisu1 = $pro_total/$irisu1;
            $maisu2 = $pro_total/$irisu2;
          }else{
            $pro_total = $pro_total2;
            $maisu1 = $pro_total/$irisu1;
            $maisu2 = $pro_total/$irisu2;
          }
        }else{
          $maisu1 = $_SESSION['labeljunbi'][$i]['yoteimaisu'];
        }

        if($_SESSION['labeljunbi'][$i]['product_code'] === "MLD-NDS-20001" || $_SESSION['labeljunbi'][$i]['product_code'] === "MLD-NDS-20002"){
          $InsideFuyou = 9999;
        }else{
          $InsideFuyou = 0;
        }

        //セット取りのINラベルのmaisuの調整ここまで

            if($Layout == "C"){//〇タイプCの場合は１行に２製品の表示//OK

              if(isset($LabelSetikkatsu1[0])){
                $product_code2 = $LabelSetikkatsu1[0]->product_id2;
                $Product2 = $this->Products->find()->where(['product_code' => $product_code2])->toArray();
                $product_name2 = $Product2[0]->product_name;
                $Konpou = $this->Konpous->find()->where(['product_code' => $product_code2])->toArray();
                  if(isset($Konpou[0])){
                    $irisu2 = $Konpou[0]->irisu;
                  }else{
                    $irisu2 = "";
                  }
              }elseif(isset($LabelSetikkatsu2[0])){
                $product_code2 = $LabelSetikkatsu2[0]->product_id1;
                $Product2 = $this->Products->find()->where(['product_code' => $product_code2])->toArray();
                $product_name2 = $Product2[0]->product_name;
                $Konpou = $this->Konpous->find()->where(['product_code' => $product_code2])->toArray();
                  if(isset($Konpou[0])){
                    $irisu2 = $Konpou[0]->irisu;
                  }else{
                    $irisu2 = "";
                  }
              }else{
                $product_code2 = "";
                $product_name2 = "";
                $irisu2 = "";
              }

              $arrCsv[] = ['maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'], 'layout' => $Layout, 'lotnum' => $lotnum,
               'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
               'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
               'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
               $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

            }elseif(isset($LabelSetikkatsu1[0]) || isset($LabelSetikkatsu2[0])){//〇タイプCでなくセット取りの場合
        //      echo "<pre>";
        //      print_r("タイプCでなくセット取りの場合");
        //      echo "</pre>";
            //まずセット取りの片方の行を登録
              $product_code2 = "";
              $product_name2 = "";
              $irisu2 = "";
              $maisu = $maisu1;

              $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnum,//１行目
               'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
               'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
               'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
               $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0]))  && $InsideFuyou == 0){//INラベルが必要な場合
          //        echo "<pre>";
          //        print_r($_SESSION['labeljunbi'][$i]['product_code']."=pro1にINラベルが必要");
          //        echo "</pre>";

                  $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                  //maisu=$_SESSION['labeljunbi'][$i][$i]['yoteimaisu']*num_inside
                  $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                  if(isset($LabelInsideout1[0])){
                    $num_inside1 = $LabelInsideout1[0]->num_inside;
                  }else{
                    $num_inside1 = 1;
                  }
                  $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                  if(isset($LabelTypeProduct[0])){
                    $Layout = $LabelTypeProduct[0]->type;
                  }else{
                    $Layout = "-";
                  }
            //      $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                  $maisu = $maisu1 * $num_inside1;
                  $irisu12 = $irisu/$num_inside1;
                  $irisu22 = "";
                  $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                  $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,//OK
                  'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                  'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                  'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                  $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                   'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                   'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                   'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                 }

                  if(isset($LabelSetikkatsu1[0])){//セット取りのもう片方が$LabelSetikkatsu1[0]にあった場合
          //          echo "<pre>";
          //          print_r($LabelSetikkatsu1[0]->product_id2."=pro2セット取りのもう片方がLabelSetikkatsu１");
          //          echo "</pre>";

                    $product_id2 = $LabelSetikkatsu1[0]->product_id2;
                    $Product2 = $this->Products->find()->where(['product_code' => $product_id2])->toArray();
                    $product_name = $Product2[0]->product_name;
                    $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                      if(isset($Konpou[0])){
                        $irisu = $Konpou[0]->irisu;
                      }else{
                        $irisu = "";
                      }
                      $product_code2 = "";
                      $product_name2 = "";
                      $irisu2 = "";
                //      $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'];
                      $maisu = $maisu2;

                      $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnum,//３行目
                       'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                       'product_code' => $product_id2, 'product_code2' => $product_code2, 'product_name' => trim($product_name),
                       'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                       $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                        'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                        'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                        'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                        if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0])) && $InsideFuyou == 0){//INラベルが必要な場合
            //              echo "<pre>";
            //              print_r($product_id2."セット取りのもう片方にもINラベルが必要な場合1");
            //              echo "</pre>";

                          $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                          $LabelInsideout = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                          if(isset($LabelInsideout[0])){
                            $num_inside1 = $LabelInsideout[0]->num_inside;
                          }else{
                            $num_inside1 = 1;
                          }
                          $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $product_id2])->toArray();
                          if(isset($LabelTypeProduct[0])){
                            $Layout = $LabelTypeProduct[0]->type;
                          }else{
                            $Layout = "-";
                          }
                          $maisu = $maisu2 * $num_inside1;
              //            $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                          $irisu12 = $irisu/$num_inside1;
                          $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                          $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,//4行目
                          'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                          'product_code' => $product_id2, 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                          'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                          $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                           'product1' => $product_id2, 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                           'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                           'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                         }

                  }else{//セット取りのもう片方が$LabelSetikkatsu2[0]にあった場合//OK
        //            echo "<pre>";
        //            print_r($LabelSetikkatsu2[0]->product_id1."=pro2セット取りのもう片方がLabelSetikkatsu２");
        //            echo "</pre>";

                    $product_id2 = $LabelSetikkatsu2[0]->product_id1;
                    $Product2 = $this->Products->find()->where(['product_code' => $product_id2])->toArray();
                    $product_name = $Product2[0]->product_name;
                    $Konpou = $this->Konpous->find()->where(['product_code' => $product_id2])->toArray();
                      if(isset($Konpou[0])){
                        $irisu = $Konpou[0]->irisu;
                      }else{
                        $irisu = "";
                      }
              //        $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'];
                      $maisu = $maisu2;

                      $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnum,//３行目
                       'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                       'product_code' => $product_id2, 'product_code2' => $product_code2, 'product_name' => trim($product_name),
                       'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                       $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                        'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                        'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                        'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                        if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0])) && $InsideFuyou == 0){//mb_substrだと文字化けしない//修正変更
        //                  echo "<pre>";
        //                  print_r($product_id2."セット取りのもう片方にもINラベルが必要な場合2");
        //                  echo "</pre>";

                          $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                          $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $product_id2])->toArray();
                          if(isset($LabelInsideout1[0])){
                            $num_inside1 = $LabelInsideout1[0]->num_inside;
                          }else{
                            $num_inside1 = 1;
                          }
                          $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $product_id2])->toArray();
                          if(isset($LabelTypeProduct[0])){
                            $Layout = $LabelTypeProduct[0]->type;
                          }else{
                            $Layout = "-";
                          }
                          $maisu = $maisu2 * $num_inside1;
                //          $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                          $irisu12 = $irisu/$num_inside1;
                          $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));

                          $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,//4行目
                          'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                          'product_code' => $product_id2, 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                          'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                          $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                           'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                           'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                           'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                         }
                }

            }else{//〇タイプCでもセット取りでもない場合１行に１製品
              $product_code2 = "";//修正
              $product_name2 = "";//修正
              $irisu2 = "";//修正

              $arrCsv[] = ['maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'], 'layout' => $Layout, 'lotnum' => $lotnum,
               'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
               'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => $product_code2, 'product_name' => trim($product_name),
               'product_name2' => trim($product_name2), 'irisu' => trim($irisu), 'irisu2' => trim($irisu2), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
               $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu), 'irisu2' => trim($irisu2), 'unit1' => trim($unit), 'unit2' => "",
                'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要

                if((mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ" || isset($LabelInsideout1[0])) && $InsideFuyou == 0){//mb_substrだと文字化けしない//修正変更

                  $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
                  //maisu=$_SESSION['labeljunbi'][$i][$i]['yoteimaisu']*num_inside
                  $LabelInsideout1 = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                  if(isset($LabelInsideout1[0])){
                    $num_inside1 = $LabelInsideout1[0]->num_inside;
                  }else{
                    $num_inside1 = 1;
                  }
                  $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
                  if(isset($LabelTypeProduct[0])){
                    $Layout = $LabelTypeProduct[0]->type;
                  }else{
                    $Layout = "-";
                  }
                  $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside1;
                  $irisu12 = $irisu/$num_inside1;
                  $renban = (($_SESSION['labeljunbi'][$i]['hakoNo'] * $num_inside1) - ($num_inside1 - 1));
                  $irisu22 = "";

                  $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,
                  'renban' => $renban, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                  'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], 'product_code2' => trim($product_code2), 'product_name' => trim($product_name),
                  'product_name2' => trim($product_name2), 'irisu' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit' => trim($unit), 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
                  $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
                   'product1' => $_SESSION['labeljunbi'][$i]['product_code'], 'product2' => $product_code2, 'name_pro1' => trim($product_name),
                   'name_pro2' => trim($product_name2), 'irisu1' => trim($irisu12), 'irisu2' => trim($irisu22), 'unit1' => trim($unit), 'unit2' => "",
                   'line_code' => "", 'date' => $date, 'start_lot' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'delete_flag' => 0];//unit2,line_code1...不要
                 }
            }

          }

    //    $fp = fopen('labels/label_kobetu0601.csv', 'w');
        $fp = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'w');
          foreach ($arrCsv as $line) {
            $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
          	fputcsv($fp, $line);
          }
            fclose($fp);

            $labelCsvs = $this->LabelCsvs->newEntity();
            $this->set('labelCsvs',$labelCsvs);
             if ($this->request->is('post')) {
               $labelCsvs = $this->LabelCsvs->patchEntities($labelCsvs, $arrCsvtouroku);
               $connection = ConnectionManager::get('default');//トランザクション1
               // トランザクション開始2
               $connection->begin();//トランザクション3
               try {//トランザクション4
                   if ($this->LabelCsvs->saveMany($labelCsvs)) {//saveManyで一括登録
                     $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました";
                     $this->set('mes',$mes);
                     $connection->commit();// コミット5

                     //insert into label_csvする
                     $connection = ConnectionManager::get('sakaeMotoDB');
                     $table = TableRegistry::get('label_csv');
                     $table->setConnection($connection);

                  //   echo "<pre>";
                  //   print_r($arrCsvtouroku);
                  //   echo "</pre>";

                     for($k=0; $k<count($arrCsvtouroku); $k++){
                       $connection->insert('label_csv', [
                           'number_sheet' => $arrCsvtouroku[$k]["number_sheet"],
                           'hanbetsu' => $arrCsvtouroku[$k]["hanbetsu"],
                           'place1' => $arrCsvtouroku[$k]["place1"],
                           'place2' => $arrCsvtouroku[$k]["place2"],
                           'product1' => $arrCsvtouroku[$k]["product1"],
                           'product2' => $arrCsvtouroku[$k]["product2"],
                           'name_pro1' => $arrCsvtouroku[$k]["name_pro1"],
                           'name_pro2' => $arrCsvtouroku[$k]["name_pro2"],
                           'irisu1' => $arrCsvtouroku[$k]["irisu1"],
                           'irisu2' => $arrCsvtouroku[$k]["irisu2"],
                           'unit1' => $arrCsvtouroku[$k]["unit1"],
                           'unit2' => $arrCsvtouroku[$k]["unit2"],
                           'line_code' => $arrCsvtouroku[$k]["line_code"],
                           'date' => $arrCsvtouroku[$k]["date"],
                           'start_lot' => $arrCsvtouroku[$k]["start_lot"]
                       ]);
                     }

                   } else {
                     $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました※データベースへ登録されませんでした";
                     $this->set('mes',$mes);
                     $this->Flash->error(__('The data could not be saved. Please, try again.'));
                     throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                   }
               } catch (Exception $e) {//トランザクション7
               //ロールバック8
                 $connection->rollback();//トランザクション9
               }//トランザクション10
             }

        }elseif(isset($data['confirm'])){//確認おしたとき
          $_SESSION['lotdate'] = array(
      //      "lotnum" => substr($data['finishing_tm11'],2,2).substr($data['finishing_tm11'],5,2).substr($data['finishing_tm11'],8,2)//200531削除
            "lotnum" => substr($data['finishing_tm11']['year'],2,2).substr($data['finishing_tm11']['month'],0,2).substr($data['finishing_tm11']['day'],0,2)//200531追加
          );

          $product_code = mb_strtoupper($data["product_code11"]);

          $htmlProductcheck = new htmlProductcheck();//クラスを使用
          $product_code_check = $htmlProductcheck->Productcheck($product_code);
          if($product_code_check == 1){
            return $this->redirect(
             ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $product_code]]
            );
          }else{
            $product_code_check = $product_code_check;
          }

         $this->set('confirm',$data['confirm']);
         $dateto = $data['dateto'];
         $this->set('dateto',$dateto);
       }elseif(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
         $i = 1;
         $j = 1;
         ${"product_code1".$i} = "";
         $this->set('product_code1'.$i,${"product_code1".$i});
         $dateYMD = date('Y-m-d');
         $dateYMD1 = strtotime($dateYMD);
         $dateHI = date("09:00");
         $dateto = $dateYMD."T".$dateHI;
         $this->set('dateto',$dateto);
         ${"starting_tm".$j.$i} = $dateto;
         $this->set('starting_tm'.$j.$i,${"starting_tm".$j.$i});
         ${"finishing_tm".$j.$i} = $dateto;
         $this->set('finishing_tm'.$j.$i,${"finishing_tm".$j.$i});
         for($i=1; $i<=1; $i++){
          ${"tuika".$i} = 0;
          $this->set('tuika'.$i,${"tuika".$i});//セット
         }
         for($i=1; $i<=1; $i++){
          ${"ntuika".$i} = 0;
          $this->set('ntuika'.$i,${"ntuika".$i});//セット
         }
       }else{
           $dateto = $data['dateto'];
           $this->set('dateto',$dateto);
           for($i=1; $i<=1; $i++){
             ${"tuika".$i} = $data["tuika".$i];
             $this->set('tuika'.$i,${"tuika".$i});//セット
           }
           for($i=1; $i<=1; $i++){
             if(isset($data["ntuika".$i])) {
                 ${"ntuika".$i} = $data["ntuika".$i];
                 $this->set('ntuika'.$i,${"ntuika".$i});//セット
            }
          }
          $j = 1;
          $count = $data["n".$j] + ${"ntuika".$j} + 1;
          for($i=1; $i<=$count; $i++){
            if(isset($data["product_code1".$i])){
              if(!is_null($data["product_code1".$i])) {
                ${"product_code1".$i} = $data["product_code1".$i];
                $this->set('product_code1'.$i,${"product_code1".$i});

                ${"starting_tm".$j.$i} = $data["starting_tm".$j.$i]['year']."-".$data["starting_tm".$j.$i]['month']."-".$data["starting_tm".$j.$i]['day'].//200531追加
                "T".$data["starting_tm".$j.$i]['hour'].":".$data["starting_tm".$j.$i]['minute'];//200531追加
          //      ${"starting_tm".$j.$i} = $data["starting_tm".$j.$i];//200531削除
                $this->set('starting_tm'.$j.$i,${"starting_tm".$j.$i});

                ${"finishing_tm".$j.$i} = $data["finishing_tm".$j.$i]['year']."-".$data["finishing_tm".$j.$i]['month']."-".$data["finishing_tm".$j.$i]['day'].//200531追加
                "T".$data["finishing_tm".$j.$i]['hour'].":".$data["finishing_tm".$j.$i]['minute'];//200531追加
          //      ${"finishing_tm".$j.$i} = $data["finishing_tm".$j.$i];//200531削除
                $this->set('finishing_tm'.$j.$i,${"finishing_tm".$j.$i});
             }else{
               ${"product_code1".$i} = "";
               $this->set('product_code1'.$i,${"product_code1".$i});
               ${"starting_tm".$j.$i} = $dateto;
               $this->set('starting_tm'.$j.$i,${"starting_tm".$j.$i});
               ${"finishing_tm".$j.$i} = $dateto;
               $this->set('finishing_tm'.$j.$i,${"finishing_tm".$j.$i});
             }
           }else{
             ${"product_code1".$i} = "";
             $this->set('product_code1'.$i,${"product_code1".$i});
             ${"starting_tm".$j.$i} = $dateto;
             $this->set('starting_tm'.$j.$i,${"starting_tm".$j.$i});
             ${"finishing_tm".$j.$i} = $dateto;
             $this->set('finishing_tm'.$j.$i,${"finishing_tm".$j.$i});
           }
         }
       }
     }

     public function torikomiselect()//発行履歴取り込み
     {
       $session = $this->request->getSession();
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);

       if ($this->request->is('post')) {
         $source_file = $_FILES['file']['tmp_name'];

         $fp = fopen($source_file, "r");
         $fpcount = fopen($source_file, 'r' );
          for($count = 0; fgets( $fpcount ); $count++ );
          $arrFp = array();//空の配列を作る
          $arrLot = array();//空の配列を作る
          $created_staff = $this->Auth->user('staff_id');
          for ($k=1; $k<=$count; $k++) {//最後の行まで
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode("\t",$line);//$lineを"（スペース）"毎に配列に入れる
            $arrFp[] = $sample;//配列に追加する
            if(isset($arrFp[$k-1][10]) && ($arrFp[$k-1][10] != "")){//product_codeが２つある時
              $datetime_hakkou = $arrFp[$k-1][0]." ".$arrFp[$k-1][1];
              for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
                $renban = $arrFp[$k-1][5] + $m;
                $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);
                //product_code=$arrFp[$k-1][6],status=0がzensu_productsに存在するときflag_used=9
                //else...flag_used=0
                $ZensuProduct = $this->ZensuProducts->find()->where(['product_code' => $arrFp[$k-1][6], 'status' => 0])->toArray();
                if(isset($ZensuProduct[0])){
                  $flag_used = 9;
                }else{
                  $flag_used = 0;
                }
                $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][6], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => $flag_used, 'delete_flag' => 0, 'created_staff' => $created_staff];
              }
              for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
                $renban = $arrFp[$k-1][5] + $m;
                $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);
                $ZensuProduct = $this->ZensuProducts->find()->where(['product_code' => $arrFp[$k-1][7], 'status' => 0])->toArray();
                if(isset($ZensuProduct[0])){
                  $flag_used = 9;
                }else{
                  $flag_used = 0;
                }
                $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][7], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => $flag_used, 'delete_flag' => 0, 'created_staff' => $created_staff];
              }
            }else{//product_codeが１つの時
              $datetime_hakkou = $arrFp[$k-1][0]." ".$arrFp[$k-1][1];
              for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
                $renban = $arrFp[$k-1][5] + $m;
                $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);
                $ZensuProduct = $this->ZensuProducts->find()->where(['product_code' => $arrFp[$k-1][6], 'status' => 0])->toArray();
                if(isset($ZensuProduct[0])){
                  $flag_used = 9;
                }else{
                  $flag_used = 0;
                }
                $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][6], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => $flag_used, 'delete_flag' => 0, 'created_staff' => $created_staff];
              }
            }
        }
/*
//ファイル名の変更実験
        $file_test = $_FILES['file']['name'];
        $toFile = "copy_".$file_test;
//        echo "<pre>";
//        print_r($_FILES['file']);
//        echo "</pre>";
        echo "<pre>";
        print_r("元々：".$file_test."  登録用：".$toFile);
        echo "</pre>";

    //    if (copy($_FILES['file']['tmp_name'], "copy_".$_FILES['file']['name'])) {//copyはいける//webrootにファイルのコピーが作成される
    //    if (copy($_FILES['file']['tmp_name'], 'test20200213/'."copy_200213.txt")) {//webrootのフォルダにcopyが作成される
        if (copy($_FILES['file']['tmp_name'], '/home/centosuser/test20200213/'.$toFile)) {
          echo 'コピーしました！';
        }else{
          echo 'コピーできない！';
        }
*/
/*
      //if (rename('labels/furiwake111.txt', 'EDI/furiwake111.txt')) {//1回できたが、「Device or resource busy」のエラーが発生
      //if (rename('/home/centosuser/EDI/'.$file_test, '/home/centosuser/EDI/'.$toFile)) {
      if (copy('test20200213/'.$file_test, 'test20200213/'.$toFile)) {//copyはいける
        echo 'コピーしました。';
        if (unlink('test20200213/'.$file_test)) {//unlinkは「Device or resource busy」のエラーが発生（たまにできる時もある）
          echo '削除しました。';
        } else {
          echo '削除できない！';
        }
      }else{
        echo 'コピーできない！';
      }

      if (rename('test20200213/'.$file_test, 'test19080501/'.$toFile)) {//renameは「Device or resource busy」のエラーが発生（たまにできる時もある）
        echo '移動しました。';
      } else {
        echo '移動できない！';
      }
*/
/*
      echo "<pre>";
      print_r(count($arrLot));
      echo "</pre>";
*/
      $count = count($arrLot);
      for($i = 0 ; $i < $count ; $i++){
          $tmp_arr[$arrLot[$i]['datetime_hakkou'].'_'.$arrLot[$i]['product_code'].'_'.$arrLot[$i]['lot_num']]
           = $tmp_arr[$arrLot[$i]['datetime_hakkou'].'_'.$arrLot[$i]['product_code'].'_'.$arrLot[$i]['lot_num']]??$i;
      }
      foreach($tmp_arr as $v){
          $arrLotunique[$v] = $arrLot[$v];
      }

      $arrLot = $arrLotunique;

      $count = 0;
      for($k=0; $k<count($arrLot); $k++){
        $CheckLottourokuzumi = $this->CheckLots->find()->where(['datetime_hakkou' => $arrLot[$k]["datetime_hakkou"], 'product_code' => $arrLot[$k]["product_code"], 'lot_num' => $arrLot[$k]["lot_num"], 'amount' => $arrLot[$k]["amount"]])->toArray();
        $count = $count + count($CheckLottourokuzumi);
      }

      $mes = "";

      if($count != 0){
        $mes = "※以下のロットは既に登録されています。";
        $this->set('mes',$mes);
        $counttourokuzumi = 0;
        $j = 0;
        for($k=0; $k<count($arrLot); $k++){
          $CheckLottourokuzumi = $this->CheckLots->find()->where(['product_code' => $arrLot[$k]["product_code"], 'lot_num' => $arrLot[$k]["lot_num"]])->toArray();
          if(isset($CheckLottourokuzumi[0])){
            ${"CheckLottourokuzumiproduct_code".$j} = $CheckLottourokuzumi[0]->product_code;
            $this->set('CheckLottourokuzumiproduct_code'.$j,${"CheckLottourokuzumiproduct_code".$j});
            ${"CheckLottourokuzumilot_num".$j} = $CheckLottourokuzumi[0]->lot_num;
            $this->set('CheckLottourokuzumilot_num'.$j,${"CheckLottourokuzumilot_num".$j});
            $counttourokuzumi = $counttourokuzumi + 1;
            $this->set('counttourokuzumi',$counttourokuzumi);
            $j = $j + 1;
            $mes = "※以下のロットは既に登録されています。他のロットは登録されました。";
            $this->set('mes',$mes);

//ダブっているデータを２つともダブリチェックデータベースに登録する//いつ、誰が登録したどのロットがダブったかわかるようにする
            $check_lot_id = $CheckLottourokuzumi[0]->id;
            $first_created_staff = $CheckLottourokuzumi[0]->created_staff;
            $first_created_at = $CheckLottourokuzumi[0]->created_at->format('Y-m-d H:i:s');
            $arrLotdouble[] =  ['id_check_lot' => $check_lot_id,'product_code' => $arrLot[$k]["product_code"],'lot_num' => $arrLot[$k]["lot_num"],
            'first_created_time' => $first_created_at,'first_created_staff' => $first_created_staff,
            'second_created_time' => date('Y-m-d H:i:s'),'second_created_staff' => $arrLot[$k]["created_staff"],'delete_flag' => 0];

          }else{
            /*
            ${"CheckLottourokuzumiproduct_code".$k} = "";
            $this->set('CheckLottourokuzumiproduct_code'.$k,${"CheckLottourokuzumiproduct_code".$k});
            ${"CheckLottourokuzumilot_num".$k} = "";
            $this->set('CheckLottourokuzumilot_num'.$k,${"CheckLottourokuzumilot_num".$k});
            $counttourokuzumi = $counttourokuzumi + 1;
            $this->set('counttourokuzumi',$counttourokuzumi);
            */
            $arrLotmitouroku[] = $arrLot[$k];
            $mes = "※以下のロットは既に登録されています。他のロットは登録されました。";
            $this->set('mes',$mes);
          }
        }
        if(isset($arrLotmitouroku)){
          $arrLot = $arrLotmitouroku;
        }
      }

/*
      echo "<pre>";
      print_r("登録されるデータの個数　＝　".count($arrLot));
      echo "</pre>";

      echo "<pre>";
      print_r($arrLotdouble);
      echo "</pre>";
*/

          if(isset($arrLotdouble[0])){
            $CheckLotsDoubles = $this->CheckLotsDoubles->patchEntities($this->CheckLotsDoubles->newEntity(), $arrLotdouble);
            $this->CheckLotsDoubles->saveMany($CheckLotsDoubles);
          }

           $checkLots = $this->CheckLots->newEntity();
           $this->set('checkLots',$checkLots);
           $checkLots = $this->CheckLots->patchEntities($this->CheckLots->newEntity(), $arrLot);
           $connection = ConnectionManager::get('default');//トランザクション1
           // トランザクション開始2
           $connection->begin();//トランザクション3

           try {//トランザクション4

             if ($this->CheckLots->saveMany($checkLots)) {//saveManyで一括登録
               $mes = "登録されました。".$mes;
               $this->set('mes',$mes);

               //$arrLotをinsert into check_lotsする
               $connection = ConnectionManager::get('sakaeMotoDB');
               $table = TableRegistry::get('check_lots');
               $table->setConnection($connection);

               for($k=0; $k<count($arrLot); $k++){
                 $connection->insert('check_lots', [
                     'datetime_hakkou' => $arrLot[$k]["datetime_hakkou"],
                     'product_id' => $arrLot[$k]["product_code"],
                     'lot_num' => $arrLot[$k]["lot_num"],
                     'amount' => $arrLot[$k]["amount"],
                     'flag_used' => $arrLot[$k]["flag_used"]
                 ]);
               }
               $connection = ConnectionManager::get('default');

               $connection->commit();// コミット5

             } else {

               $mes = "登録できませんでした。".$mes;
               $this->set('mes',$mes);

      //         $this->Flash->error(__('The data could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
             }
           } catch (Exception $e) {//トランザクション7
           //ロールバック8
             $connection->rollback();//トランザクション9
           }//トランザクション10

        }


     }

     public function torikomipreadd()
 		{
      session_start();
      $checkLots = $this->CheckLots->newEntity();
      $this->set('checkLots',$checkLots);
 		}

 		public function torikomilogin()
 		{
 			if ($this->request->is('post')) {
 				$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
 				$str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
 				$ary = explode(',', $str);//$strを配列に変換
 				$username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
 				//※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
 				$this->set('username', $username);
 				$Userdata = $this->Users->find()->where(['username' => $username])->toArray();
 					if(empty($Userdata)){
 						$delete_flag = "";
 					}else{
 						$delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
 						$this->set('delete_flag',$delete_flag);//登録者の表示のため
 					}
 						$user = $this->Auth->identify();
 					if ($user) {
 						$this->Auth->setUser($user);
            return $this->redirect(['action' => 'torikomiselect']);
 					}
 				}
 		}

    public function fushiyouMenu()
		{
      //$this->request->session()->destroy(); // セッションの破棄
      $checkLots = $this->CheckLots->newEntity();
      $this->set('checkLots',$checkLots);
		}

    public function fushiyoupreadd()
		{
      //$this->request->session()->destroy(); // セッションの破棄
      $checkLots = $this->CheckLots->newEntity();
      $this->set('checkLots',$checkLots);
		}

		public function fushiyoulogin()
		{
			if ($this->request->is('post')) {
				$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
				$str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
				$ary = explode(',', $str);//$strを配列に変換
				$username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
				//※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
				$this->set('username', $username);
				$Userdata = $this->Users->find()->where(['username' => $username])->toArray();
					if(empty($Userdata)){
						$delete_flag = "";
					}else{
						$delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
						$this->set('delete_flag',$delete_flag);//登録者の表示のため
					}
						$user = $this->Auth->identify();
					if ($user) {
						$this->Auth->setUser($user);
						return $this->redirect(['action' => 'fushiyouform']);
					}
				}
		}

     public function fushiyouform()//ラベル不使用qr
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
     }

     public function fushiyoumaisuu()//ラベル不使用
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
       $data = $this->request->getData();

       $str = implode(',', $data);//配列データをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換
       $product_code1 = $ary[0];//入力したデータをカンマ区切りの最初のデータを$product_code1とする（以下同様）
       $this->set('product_code1',$product_code1);
       $lot_num = $ary[4];
       $this->set('lot_num',$lot_num);
       $CheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
         ->where(['product_code' => $product_code1, 'lot_num' => $lot_num])->toArray();
       if(isset($CheckLots[0])){
         $CheckLotId = $CheckLots[0]->id;
       }
       /*
         echo "<pre>";
         print_r($CheckLotId."-".$product_code1."-".$lot_num);
         echo "</pre>";
         */
     }

     public function fushiyouconfirm()//ラベル不使用
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
       $data = $this->request->getData();
       $product_code = $data["product_code"];
       $this->set('product_code',$product_code);
       $lot_num = $data["lot_num"];
       $this->set('lot_num',$lot_num);
       $maisuu = $data["maisuu"];
       $this->set('maisuu',$maisuu);

       $lot_num_oya = substr($lot_num, 0, -3);
       $lot_num_renban = substr($lot_num, -3, 3);
       for($i=0; $i<$maisuu; $i++){//１号機
         ${"lot_num_renban".$i} = sprintf('%03d', $lot_num_renban + $i);
         ${"lot_num_".$i} = $lot_num_oya.${"lot_num_renban".$i};
         $this->set('lot_num_'.$i,${"lot_num_".$i});
       }
     }

     public function fushiyoudo()//ラベル不使用//新DBを見る?データがある場合ダブル更新、データがない場合旧DBのみ更新
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
       $data = $this->request->getData();
       $maisuu = $data["maisuu"];


       $CheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
         ->where(['product_code' => $data["product_code"], 'lot_num' => $data["lot_num_0"]])->toArray();
       if(isset($CheckLots[0])){//新DBにデータがある場合ダブル更新
         for($i=0; $i<$maisuu; $i++){
           $CheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['product_code' => $data["product_code"], 'lot_num' => $data["lot_num_".$i]])->toArray();
           $CheckLotId = $CheckLots[0]->id;
  /*
           echo "<pre>";
           print_r($CheckLotId);
           echo "</pre>";
  */
           if(isset($CheckLotId)){
             $connection = ConnectionManager::get('default');
             $table = TableRegistry::get('check_lots');
             $table->setConnection($connection);

             $this->CheckLots->updateAll(
             ['flag_used' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
             ['id'   => $CheckLotId ]
             );
             $mes = "不使用ロットが登録されました";
             $this->set('mes',$mes);

             $connection = ConnectionManager::get('sakaeMotoDB');
             $table = TableRegistry::get('check_lots');
             $table->setConnection($connection);

             $updater = "UPDATE check_lots set flag_used = 1 where product_id ='".$data["product_code"]."' and lot_num = '".$data["lot_num_".$i]."'";//もとのDBも更新
             $connection->execute($updater);

           }else{
             echo "<pre>";
             print_r($data["lot_num_".$i]."というロットナンバーは存在しません（存在するロットは不使用登録されます）");
             echo "</pre>";
           }
         }

       }else{//新DBにデータがない場合旧DBのみ更新

         for($i=0; $i<$maisuu; $i++){
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('check_lots');
           $table->setConnection($connection);

           $sql = "SELECT datetime_hakkou,lot_num,product_id,amount,flag_used,flag_deliver FROM check_lots".
                 " where product_id ='".$data["product_code"]."' and lot_num = '".$data["lot_num_".$i]."'";
           $connection = ConnectionManager::get('sakaeMotoDB');
           $checkLot = $connection->execute($sql)->fetchAll('assoc');
/*
           echo "<pre>";
           print_r($checkLot);
           echo "</pre>";
*/
           if(isset($checkLot[0])){
             $mes = "不使用ロットが登録されました（このロットは新DBには登録されていません。）";
             $this->set('mes',$mes);

             $updater = "UPDATE check_lots set flag_used = 1 where product_id ='".$data["product_code"]."' and lot_num = '".$data["lot_num_".$i]."'";//もとのDBも更新
             $connection->execute($updater);

           }else{
             print_r($data["lot_num_".$i]."というロットナンバーは存在しません（他のロットは不使用登録されます）");
           }
         }

       }
     }

     public function fushiyouichiranpre()//ラベル不使用一覧
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
     }

     public function fushiyouichiran()//ラベル不使用一覧
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
       $data = $this->request->getData();
       $datesta = $data["date_sta"].' 08:00:00';
       $datefin = $data["date_fin"].' 08:00:00';
       $date_count = (strtotime($data["date_fin"])-strtotime($data["date_sta"]))/(3600*24);

       for($i=0; $i<$date_count; $i++){
         $dateYMD = $data["date_sta"];
         $dateYMD1 = strtotime($dateYMD);
         $date_sta = date('Y-m-d', strtotime("+{$i} day", $dateYMD1)).' 08:00:00';
         $j = $i + 1;
         $date_fin = date('Y-m-d', strtotime("+{$j} day", $dateYMD1)).' 08:00:00';
         $this->set('date'.$i,date('Y-m-d', strtotime("+{$i} day", $dateYMD1)));

         $arrAll = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
           ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin])->toArray();
           $countAll = count($arrAll);
           $this->set('countAll'.$i,$countAll);
         $arrfushiyou = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
           ->where(['delete_flag' => '0','flag_used' => '1','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin])->toArray();
           $countfushiyou = count($arrfushiyou);
           $this->set('countfushiyou'.$i,$countfushiyou);
         $arrkinnshi = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
           ->where(['delete_flag' => '0','flag_used' => '2','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin])->toArray();
           $countkinnshi = count($arrkinnshi);
           $this->set('countkinnshi'.$i,$countkinnshi);
         $arrzaiko = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
           ->where(['lot_num not like' => '%'."IN".'%','flag_deliver IS' => NULL, 'delete_flag' => '0', 'flag_used' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin])->toArray();
           $countzaiko = count($arrzaiko);
           $this->set('countzaiko'.$i,$countzaiko);
           $this->set('icount',$i);//ループ回数-1
         }
     }

     public function kensakuform()//ロット検索
     {
       //$this->request->session()->destroy(); // セッションの破棄
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
     }

     public function kensakuview()//ロット検索
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
       $data = $this->request->getData();
       $product_code = $data['product_code'];
       $lot_num = $data['lot_num'];
       $date_sta = $data['date_sta'];
       $date_fin = $data['date_fin'];

       $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
       $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

       $date_fin = strtotime($date_fin);
       $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));
/*
       $connection = ConnectionManager::get('DB_ikou_test');
       $table = TableRegistry::get('check_lots');
       $table->setConnection($connection);

       $sql = "SELECT datetime,seikeiki,product_id,present_kensahyou,product_name FROM check_lots".
             " where datetime >= '".$dateYMDs."' and datetime <= '".$dateYMDf."' and seikeiki = ".$j." order by datetime asc";
       $connection = ConnectionManager::get('DB_ikou_test');
       $scheduleKoutei = $connection->execute($sql)->fetchAll('assoc');
*/

       if(empty($data['product_code'])){//product_codeの入力がないとき
         $product_code = "no";
         if(empty($data['lot_num'])){//lot_numの入力がないとき　product_code×　lot_num×　date〇
           $lot_num = "no";//日にちだけで絞り込み
           $arrcheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
           ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin])->toArray();

//並べかえ
             foreach($arrcheckLots as $key => $row ) {
               $tmp_product_array[$key] = $row["product_code"];
               $tmp_lot_num_array[$key] = $row["lot_num"];
             }

             if(count($arrcheckLots) > 0){
               array_multisort($tmp_product_array, $tmp_lot_num_array, SORT_ASC, SORT_NUMERIC, $arrcheckLots);
             }

            $this->set('checkLot',$arrcheckLots);

         }else{//lot_numの入力があるとき　product_code×　lot_num〇　date〇//ロットと日にちで絞り込み
           $arrcheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['delete_flag' => '0', 'lot_num like' => '%'.$lot_num.'%', 'datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin])->toArray();

             //並べかえ
             foreach($arrcheckLots as $key => $row ) {
               $tmp_product_array[$key] = $row["product_code"];
               $tmp_lot_num_array[$key] = $row["lot_num"];
             }

             if(count($arrcheckLots) > 0){
               array_multisort($tmp_product_array, $tmp_lot_num_array, SORT_ASC, SORT_NUMERIC, $arrcheckLots);
             }

            $this->set('checkLot',$arrcheckLots);

         }
       }else{//product_codeの入力があるとき
         if(empty($data['lot_num'])){//lot_numの入力がないとき　product_code〇　lot_num×　date〇
           $lot_num = "no";//プロダクトコードと日にちで絞り込み
           $arrcheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
              ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin, 'product_code' => $product_code])->toArray();

              //並べかえ
              foreach($arrcheckLots as $key => $row ) {
                $tmp_product_array[$key] = $row["product_code"];
                $tmp_lot_num_array[$key] = $row["lot_num"];
              }

              if(count($arrcheckLots) > 0){
                array_multisort($tmp_product_array, $tmp_lot_num_array, SORT_ASC, SORT_NUMERIC, $arrcheckLots);
              }

             $this->set('checkLot',$arrcheckLots);

         }else{//lot_numの入力があるとき　product_code〇　lot_num〇　date〇//プロダクトコードとロットナンバーと日にちで絞り込み
           $arrcheckLots = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin, 'lot_num like' => '%'.$lot_num.'%', 'product_code' => $product_code])->toArray();

             //並べかえ
             foreach($arrcheckLots as $key => $row ) {
               $tmp_product_array[$key] = $row["product_code"];
               $tmp_lot_num_array[$key] = $row["lot_num"];
             }

             if(count($arrcheckLots) > 0){
               array_multisort($tmp_product_array, $tmp_lot_num_array, SORT_ASC, SORT_NUMERIC, $arrcheckLots);
             }

            $this->set('checkLot',$arrcheckLots);

         }

       }

     }

     public function hasuform()//ラベル発行の端数登録（日程絞り込み画面）
     {
       //$this->request->session()->destroy(); // セッションの破棄
       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);
     }

     public function hasuichiran()//ラベル発行の端数登録（一覧画面）
     {
       if(!isset($_SESSION)){//sessionsyuuseituika
       session_start();
       }
       $_SESSION['labelhasu'] = array();
       $_SESSION['lotdate'] = array();

       $data = $this->request->getData();
       $Data = $this->request->query('s');//1度henkou5panaへ行って戻ってきたとき（検索を押したとき）
       if(isset($Data)){
         $data_yobidashi_input = $Data['data_yobidashi'];
         $data_yobidashi_Y = $Data['data_yobidashi']['year'];
         $data_yobidashi_M = $Data['data_yobidashi']['month'];
         $data_yobidashi_D = $Data['data_yobidashi']['day'];
         $data_yobidashi = $data_yobidashi_Y."-".$data_yobidashi_M."-".$data_yobidashi_D;
         $this->set('data_yobidashi',$data_yobidashi);
         $_SESSION['lotdate'] = array(
           "lotnum" => $Data['data_yobidashi']['year'].$Data['data_yobidashi']['month'].$Data['data_yobidashi']['day']
         );

       }else{
         $data_yobidashi_input = $data['data_yobidashi'];
         $data_yobidashi_Y = $data['data_yobidashi']['year'];
         $data_yobidashi_M = $data['data_yobidashi']['month'];
         $data_yobidashi_D = $data['data_yobidashi']['day'];
         $data_yobidashi = $data_yobidashi_Y."-".$data_yobidashi_M."-".$data_yobidashi_D;
         $this->set('data_yobidashi',$data_yobidashi);
         $_SESSION['lotdate'] = array(
           "lotnum" => $data['data_yobidashi']['year'].$data['data_yobidashi']['month'].$data['data_yobidashi']['day']
         );

       }

       $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
         ->where(['delete_flag' => '0', 'date_deliver' => $data_yobidashi, 'place_deliver_code !=' => '00000']
         ));//対象の製品を絞り込む

      $arrorderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0', 'date_deliver' => $data_yobidashi, 'place_deliver_code !=' => '00000'])->toArray();

      $arrProcode = array();
      for($n=0; $n<count($arrorderEdis); $n++){
        $arrProcode[] = $arrorderEdis[$n]->product_code;
      }
      $arrProcode = array_unique($arrProcode);
      $arrProcode = array_values($arrProcode);

      asort($arrProcode);//アルファベット順に並び替え
      $arrProcode = array_values($arrProcode);//添え字の振り直し

      $this->set('arrProcode',$arrProcode);
      /*
      echo "<pre>";
      print_r($arrProcode);
      echo "</pre>";
*/
      for($n=0; $n<count($arrProcode); $n++){
        ${"amount".$n} = 0;
        $arrorderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0', 'date_deliver' => $data_yobidashi, 'product_code' => $arrProcode[$n]])->toArray();
        for($m=0; $m<count($arrorderEdis); $m++){
          $amount = $arrorderEdis[$m]->amount;
          ${"amount".$n} = ${"amount".$n} + $amount;
        }

        $Konpou = $this->Konpous->find()->where(['product_code' => $arrProcode[$n]])->toArray();
        if(isset($Konpou[0])){
          $irisu = $Konpou[0]->irisu;
          ${"hasu".$n} = ${"amount".$n} % $irisu;
        }else{
          ${"hasu".$n} = "konpousテーブルに登録されていません！責任者に報告してください";
        }
        $this->set('product_code'.$n,$arrProcode[$n]);
        $this->set('hasu'.$n,${"hasu".$n});
      }

     }

     public function hasuconfirm()//ラベル発行の端数登録（確認画面）
     {
       $data = $this->request->getData();

       if(isset($data['yobidasi'])){//もう一度検索（絞り込み）をした場合
         return $this->redirect(['action' => 'hasuichiran',//以下のデータを持ってhenkou4panaに移動
         's' => ['data_yobidashi' => $data['data_yobidashi']]]);
       }

       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);
       $checknum = 0;
       $i_num = 0;

       for ($k=0; $k<=$data["nummax"]; $k++){
         if(isset($data["subete"])){
           $array[] = $data["$k"];
         }elseif(isset($data["check".$k])){//checkがついているもののidをキープ
           $array[] = $data["$k"];
         }else{
         }
       }
/*
       echo "<pre>";
       print_r($array);
       echo "</pre>";
*/
       for ($i=0; $i<=$data["nummax"]; $i++){
         if(isset($array[$i])){//checkがついているもののidと同じidのデータを取り出す
           $n = $array[$i];
           ${"product_code".$i} = $data["product_code{$n}"];
           $this->set('product_code'.$i,${"product_code".$i});
           ${"hasu".$i} = $data["hasu{$n}"];
           $this->set('hasu'.$i,${"hasu".$i});
           $i_num = $i_num + 1;
           $this->set('i_num',$i_num);
         }else{
         }
       }

     }

     public function hasudo()//端数ラベル発行
     {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();

      //csv発行と、データベース登録
      $arrCsv = array();
      for($i=0; $i<count($data['labelhasu']); $i++){
        $date = date('Y/m/d H:i:s');
        $datetimeymd = substr($date,0,10);
        $datetimehm = substr($date,11,5);
  //      $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
        $lotnum = substr($_SESSION['lotdate']['lotnum'],2,6);
        $lotnumHS = "HS.".$lotnum;//端数用のロットナンバー
        $date = substr($date,0,4)."-".substr($date,5,2)."-".substr($date,8,2);
        $Product = $this->Products->find()->where(['product_code' => $data['labelhasu'][$i]['product_code']])->toArray();
        if(isset($Product[0])){
          $costomerId = $Product[0]->customer_id;
          $product_name = $Product[0]->product_name;
        }else{
          $costomerId = "";
          $product_name = "登録されていません";
        }
        $Konpou = $this->Konpous->find()->where(['product_code' => $data['labelhasu'][$i]['product_code']])->toArray();
        if(isset($Konpou[0])){
          $irisu = $data['labelhasu'][$i]['hasu'];
        }else{
          $irisu = "";
          $meserror = "登録されていない製品です：".$data['labelhasu'][$i]['product_code'];
        }
        $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();
        if(isset($Customer[0])){
          $costomerName = $Customer[0]->name;
        }else{
          $costomerName = "登録されていません";
        }
        $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $data['labelhasu'][$i]['product_code']])->toArray();
        if(isset($LabelTypeProduct[0])){
          $Layout = $LabelTypeProduct[0]->type;
        }else{
          $Layout = "-";
        }

        $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $data['labelhasu'][$i]['product_code']])->toArray();
        if(isset($LabelTypeProduct[0])){
          $place_code = $LabelTypeProduct[0]->place_code;
          if($place_code != 0){
            $LabelElementPlace = $this->LabelElementPlaces->find()->where(['place_code' => $place_code])->toArray();
            $place1 = $LabelElementPlace[0]->place1;
            $place2 = $LabelElementPlace[0]->place2;
          }else{
            $place1 = "登録されていません";
            $place2 = "";
          }
        }else{
          $place1 = $costomerName;
          $place2 = "";
        }

        $arrCsv[] = ['maisu' => 1, 'layout' => $Layout, 'lotnum' => $lotnumHS,
         'renban' => 1, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
         'product_code' => $data['labelhasu'][$i]['product_code'], 'product_code2' => "", 'product_name' => trim($product_name),
         'product_name2' => "", 'irisu' => trim($irisu), 'irisu2' => "", 'unit' => "", 'unit2' => "", 'line_code1' => ""];//unit2,line_code1...不要
         //date…出力した日付、datetime…出力した時間、layout…レイアウト、maisu…予定枚数、lotnum…lotnum、renban…連番、product_code…product_code、irisu…irisu
         $arrCsvtouroku[] = ['number_sheet' => 0, 'hanbetsu' => $Layout, 'place1' => trim($place1), 'place2' => trim($place2),//trim…文字の前後の空白削除
          'product1' => $data['labelhasu'][$i]['product_code'], 'product2' => "", 'name_pro1' => trim($product_name),
          'name_pro2' => "", 'irisu1' => $data['labelhasu'][$i]['hasu'], 'irisu2' => "", 'unit1' => "", 'unit2' => "",
          'line_code' => "", 'date' => $date, 'start_lot' => 1, 'delete_flag' => 0];//unit2,line_code1...不要
      }

  //    $fp = fopen('labels/label_hasu_200507.csv', 'w');
      $fp = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'w');
      foreach ($arrCsv as $line) {
        $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
        fputcsv($fp, $line);
      }
        fclose($fp);

        $labelCsvs = $this->LabelCsvs->newEntity();
        $this->set('labelCsvs',$labelCsvs);
         if ($this->request->is('post')) {
           $labelCsvs = $this->LabelCsvs->patchEntities($labelCsvs, $arrCsvtouroku);
           $connection = ConnectionManager::get('default');//トランザクション1
           // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
               if ($this->LabelCsvs->saveMany($labelCsvs)) {//saveManyで一括登録
                 $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました";
                 $this->set('mes',$mes);
                 $connection->commit();// コミット5

                 //insert into label_csvする
                 $connection = ConnectionManager::get('sakaeMotoDB');
                 $table = TableRegistry::get('label_csv');
                 $table->setConnection($connection);
/*
                 echo "<pre>";
                 print_r($arrCsvtouroku);
                 echo "</pre>";
*/
                 for($k=0; $k<count($arrCsvtouroku); $k++){
                   $connection->insert('label_csv', [
                       'number_sheet' => $arrCsvtouroku[$k]["number_sheet"],
                       'hanbetsu' => $arrCsvtouroku[$k]["hanbetsu"],
                       'place1' => $arrCsvtouroku[$k]["place1"],
                       'place2' => $arrCsvtouroku[$k]["place2"],
                       'product1' => $arrCsvtouroku[$k]["product1"],
                       'product2' => $arrCsvtouroku[$k]["product2"],
                       'name_pro1' => $arrCsvtouroku[$k]["name_pro1"],
                       'name_pro2' => $arrCsvtouroku[$k]["name_pro2"],
                       'irisu1' => $arrCsvtouroku[$k]["irisu1"],
                       'irisu2' => $arrCsvtouroku[$k]["irisu2"],
                       'unit1' => $arrCsvtouroku[$k]["unit1"],
                       'unit2' => $arrCsvtouroku[$k]["unit2"],
                       'line_code' => $arrCsvtouroku[$k]["line_code"],
                       'date' => $arrCsvtouroku[$k]["date"],
                       'start_lot' => $arrCsvtouroku[$k]["start_lot"]
                   ]);
                 }


               } else {
                 $mes = "\\192.168.4.246\centosuser\label_csv にＣＳＶファイルが出力されました。※データベースへ登録されませんでした。Productsテーブルに".$meserror;
                 $this->set('mes',$mes);
                 $this->Flash->error(__('The data could not be saved. Please, try again.'));
                 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
               }
           } catch (Exception $e) {//トランザクション7
           //ロールバック8
             $connection->rollback();//トランザクション9
           }//トランザクション10
         }
     }

     public function hasulotstafftouroku()
    {
      //$this->request->session()->destroy(); // セッションの破棄
      $MotoLots = $this->MotoLots->newEntity();
      $this->set('MotoLots',$MotoLots);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }

    }

    public function hasulotlogin()
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
          return $this->redirect(['action' => 'hasulotform',//以下のデータを持ってhasulotformに移動
          's' => ['username' => $username]]);
        }
      }
   }

      public function hasulotform()
     {
       $MotoLots = $this->MotoLots->newEntity();
       $this->set('MotoLots',$MotoLots);
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

     public function hasulotmoto()
    {
      $MotoLots = $this->MotoLots->newEntity();
      $this->set('MotoLots',$MotoLots);
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      if(isset($data['torikomi'])){//取り込みの場合
        $str = implode(',', $data);//配列データをカンマ区切りの文字列にする
        $ary = explode(',', $str);//$strを配列に変換
        $product_code1 = $ary[0];//入力したデータをカンマ区切りの最初のデータを$product_code1とする（以下同様）
        $this->set('product_code1',$product_code1);
        $product_code2 = $ary[1];
        $this->set('product_code2',$product_code2);
        $amount = $ary[2];
        $this->set('amount',$amount);
        $lot_num = $ary[4];
        $this->set('lot_num',$lot_num);
        $staff_id = $ary[7];
        $this->set('staff_id',$staff_id);


        $staffData = $this->Staffs->find()->where(['id' => $staff_id])->toArray();
        $Staff = $staffData[0]->staff_code." : ".$staffData[0]->f_name." ".$staffData[0]->l_name;
        $this->set('Staff',$Staff);
        $tuika = 0;
        $this->set('tuika',$tuika);
        $htmlProductcheck = new htmlProductcheck();//クラスを使用
        $product_code_check = $htmlProductcheck->Productcheck($product_code1);
        if($product_code_check == 1){
          return $this->redirect(
            ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $product_code1]]
          );
        }else{
          $product_code_check = $product_code_check;
        }
      }else{
        $product_code1 = $data['product_code'];
        $this->set('product_code1',$product_code1);
        $lot_num = $data['lot_num'];
        $this->set('lot_num',$lot_num);
        $amount = $data['amount'];
        $this->set('amount',$amount);
        $Staff = $data['Staff'];
        $this->set('Staff',$Staff);
        $staff_id = $data['staff_id'];
        $this->set('staff_id',$staff_id);
      }
      /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if(isset($data['tuika'])){

        sleep(1);

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
      }elseif(isset($data['suuryou'])){
        $tuika = $data['num'];
        $this->set('tuika',$tuika);
        return $this->redirect(['action' => 'hasulotsuuryou',//以下のデータを持ってhasulotconfirmに移動
        's' => ['data' => $data]]);//登録するデータを全部配列に入れておく
      }
    }

    public function hasulotsuuryou()
   {
       $Data = $this->request->query('s');
       $data = $Data['data'];//postデータ取得し、$dataと名前を付ける

       $check_product = 0;
       for($i=0; $i<=$data['num']; $i++){
         $ary = explode(',', $data['text'.$i]);//$strを配列に変換
         if(isset($ary[2])){
           $product_code = $ary[0];//入力したデータをカンマ区切りの最初のデータを$product_code1とする（以下同様）
           if($data["product_code"] == $product_code){
             $check_product = $check_product;
             $this->set('check_product',$check_product);
           }else{
             $check_product = 1;
             $this->set('check_product',$check_product);
           }
         }
       }
/*
       echo "<pre>";
       print_r($check_product);
       echo "</pre>";
*/
       $amount_sum = 0;
       $MotoLots = $this->MotoLots->newEntity();
       $this->set('MotoLots',$MotoLots);
       $Data = $this->request->query('s');
       $data = $Data['data'];//postデータ取得し、$dataと名前を付ける
       $product_code1 = $data['product_code'];
       $this->set('product_code1',$product_code1);
       $lot_num = $data['lot_num'];
       $this->set('lot_num',$lot_num);
       $amount = $data['amount'];
       $this->set('amount',$amount);
       $Staff = $data['Staff'];
       $this->set('Staff',$Staff);
       $staff_id = $data['staff_id'];
       $this->set('staff_id',$staff_id);
       for($i=0; $i<=$data['num']; $i++){
         if(isset($data['text'.$i])){
           $ary = explode(',', $data['text'.$i]);//$data['text'.$i]を配列に変換
           if(isset($ary[2])){
             $i = $i;
             $this->set('tuika',$i);
             ${"product_moto".$i} = $ary[0];//入力したデータをカンマ区切りの最初のデータを$product_code1とする（以下同様）
             $this->set('product_moto'.$i,${"product_moto".$i});
             ${"amount_moto".$i} = $ary[2];
             $this->set('amount_moto'.$i,${"amount_moto".$i});
             ${"lot_moto".$i} = $ary[4];
             $this->set('lot_moto'.$i,${"lot_moto".$i});

             $amount_sum = $amount_sum + ${"amount_moto".$i};
             $this->set('amount_sum',$amount_sum);

             ${"CheckLot".$i} = $this->CheckLots->find()->where(['lot_num' => ${"lot_moto".$i},  'product_code' => ${"product_moto".$i}])->toArray();

             if(isset(${"CheckLot".$i}[0])){
               ${"CheckLotflag_used".$i} = ${"CheckLot".$i}[0]->flag_used;
             }else{
               return $this->redirect(
                 ['action' => 'hasulotstafftouroku', 's' => ['mess' => "品番:".${"product_moto".$i}."　ロット番号:".${"lot_moto".$i}." のロットはcheck_lotsテーブルに登録されていません。管理者に報告してください。"]]
               );
             }

             if(${"CheckLotflag_used".$i} == 0){
               $check_product = $check_product;
               $this->set('check_product',$check_product);
             }else{
               $check_product = 1;
               $this->set('check_product',$check_product);
             }

             if(${"product_moto".$i} == $product_code1){
               $check_product = $check_product;
               $this->set('check_product',$check_product);
             }else{
               $check_product = 1;
               $this->set('check_product',$check_product);
             }
           }else{
             $check_product = $check_product;
           }
         }else{
           $i = $i;
         }
       }
    //   $tuika = $data['num'];
    //   $this->set('tuika',$tuika);
    //   echo "<pre>";
    //   print_r($check_product);
    //   echo "</pre>";

   }

      public function hasulotconfirm()
     {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

       $MotoLots = $this->MotoLots->newEntity();
       $this->set('MotoLots',$MotoLots);
//       $Data = $this->request->query('s');
  //     $data = $Data['data'];//postデータ取得し、$dataと名前を付ける
       $product_code1 = $data['product_code'];
       $this->set('product_code1',$product_code1);
       $lot_num = $data['lot_num'];
       $this->set('lot_num',$lot_num);
       $amount = $data['amount'];
       $this->set('amount',$amount);
       $Staff = $data['Staff'];
       $this->set('Staff',$Staff);
       $staff_id = $data['staff_id'];
       $this->set('staff_id',$staff_id);
       $tuika = $data['num'];
       $this->set('tuika',$tuika);

       if(!isset($_SESSION)){//sessionsyuuseituika
       session_start();
       }
       $_SESSION['hyouji'] = array();
       $_SESSION['check_lot_id'] = array();
       $_SESSION['lot_hasu'] = array();
       $_SESSION['oldDBtouroku'] = array();

       $_SESSION['hyouji'] = array(
         'Staff' => $Staff,
         'product_code1' => $product_code1,
         'amount' => $amount,
         'tuika' => $tuika,
         'lot_num' => $lot_num
       );

       $CheckLot = $this->CheckLots->find()->where(['lot_num' => $lot_num,  'product_code' => $product_code1])->toArray();
       $CheckLotId = $CheckLot[0]->id;
       $_SESSION['check_lot_id'] = array(
         'check_lot_id' => $CheckLotId
       );
/*       echo "<pre>";
       print_r($_SESSION['check_lot_id']["check_lot_id"]);
       echo "</pre>";
*/
       $amount_sum = 0;
       $check_product = 0;
       for($i=0; $i<=$data['num']; $i++){
         if(isset($data['amount_moto'.$i])){
    //       $ary = explode(',', $data['text'.$i]);//$data['text'.$i]を配列に変換
           ${"product_moto".$i} = $data['product_code'];
           $this->set('product_moto'.$i,${"product_moto".$i});
           ${"amount_moto".$i} = $data['amount_moto'.$i];
           $this->set('amount_moto'.$i,${"amount_moto".$i});
           ${"lot_moto".$i} = $data['lot_moto'.$i];
           $this->set('lot_moto'.$i,${"lot_moto".$i});

           $_SESSION['lot_hasu'][$i] = array(
             'hasu_lot' => $lot_num,
             'product_code' => $product_code1,
             'moto_lot' => ${"lot_moto".$i},
             'moto_lot_amount' => ${"amount_moto".$i},
             "delete_flag" => 0,
             "created_staff" => $staff_id
           );
           /*
           echo "<pre>";
           print_r($_SESSION['lot_hasu'][$i]);
           echo "</pre>";
*/

//以下級DBへの登録用
          $hasu_lot = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
            ->where(['lot_num' => $lot_num,  'product_code' => $product_code1])->toArray();
            if(isset($hasu_lot[0])){
              $hasu_lot_id = $hasu_lot[0]->id;
            }else{
              echo "<pre>";
              print_r("このロットはデータベースに登録されていません--".$lot_num."---".$product_code1);
              echo "</pre>";
            }
          $moto_lot = $this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
            ->where(['lot_num' => ${"lot_moto".$i},  'product_code' => $product_code1])->toArray();
            if(isset($moto_lot[0])){
              $moto_lot_id = $moto_lot[0]->id;
            }else{
              echo "<pre>";
              print_r("このロットはデータベースに登録されていません--".${"lot_moto".$i}."---".$product_code1);
              echo "</pre>";
            }

          $_SESSION['oldDBtouroku'][$i] = array(
            'hasu_lot_id' => $hasu_lot_id,
            'moto_lot_id' => $moto_lot_id,
            'moto_lot_amount' => ${"amount_moto".$i},
            "emp_id" => $staff_id,
    // /        'touroku_datetime' => date("Y-m-d H:i:s")//ここで決めておくとエラーが出る
          );
//ここまで
           $amount_sum = $amount_sum + ${"amount_moto".$i};
           $this->set('amount_sum',$amount_sum);

           if(${"product_moto".$i} == $product_code1){
             $check_product = $check_product;
             $this->set('check_product',$check_product);
           }else{
             $check_product = 1;
             $this->set('check_product',$check_product);
           }
         }else{
           $i = $i;
         }
       }
     }

     public function hasulotdo()
    {
      $session = $this->request->getSession();
      $data = $session->read();

      $Staff = $_SESSION['hyouji']['Staff'];
      $this->set('Staff',$Staff);
      $product_code1 = $_SESSION['hyouji']['product_code1'];
      $this->set('product_code1',$product_code1);
      $lot_num = $_SESSION['hyouji']['lot_num'];
      $this->set('lot_num',$lot_num);
      $amount = $_SESSION['hyouji']['amount'];
      $this->set('amount',$amount);
      $tuika = $_SESSION['hyouji']['tuika'];
      $this->set('tuika',$tuika);
      for($i=0; $i<=$tuika; $i++){
        ${"lot_moto".$i} = $_SESSION['lot_hasu'][$i]["moto_lot"];
        $this->set('lot_moto'.$i,${"lot_moto".$i});
        ${"amount_moto".$i} = $_SESSION['lot_hasu'][$i]["moto_lot_amount"];
        $this->set('amount_moto'.$i,${"amount_moto".$i});
      }

      $motoLots = $this->MotoLots->newEntity();
      $this->set('MotoLots',$motoLots);
      if ($this->request->is('post')) {
        $motoLots = $this->MotoLots->patchEntities($this->MotoLots->newEntity(), $data['lot_hasu']);
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->MotoLots->saveMany($motoLots)) {
            $this->CheckLots->updateAll(
            ['flag_used' => 0 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],
            ['id'   => $_SESSION['check_lot_id']["check_lot_id"] ]
            );

            $mes = "※以上のように登録されました。";
            $this->set('mes',$mes);
            $connection->commit();// コミット5

            //insert into order_ediする
            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('moto_lots');
            $table->setConnection($connection);

            for($k=0; $k<count($data['oldDBtouroku']); $k++){
              $connection->insert('moto_lots', [
                  'hasu_lot_id' => $data['oldDBtouroku'][$k]["hasu_lot_id"],
                  'moto_lot_id' => $data['oldDBtouroku'][$k]["moto_lot_id"],
                  'moto_lot_amount' => $data['oldDBtouroku'][$k]["moto_lot_amount"],
                  'emp_id' => $data['oldDBtouroku'][$k]["emp_id"],
                  'touroku_datetime' => date("Y-m-d H:i:s")
              ]);
            }

            $table = TableRegistry::get('check_lots');
            $table->setConnection($connection);
            $updater = "UPDATE check_lots set flag_used = 0, updated_at = '".date('Y-m-d H:i:s')."'
             where product_id ='".$product_code1."' and lot_num = '".$lot_num."'";//もとのDBも更新
            $connection->execute($updater);

          } else {
            $mes = "登録されませんでした。";
            $this->set('mes',$mes);
            $this->Flash->error(__('The data could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
          }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10
      }
    }

    public function hasukensakuform()
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $MotoLots = $this->MotoLots->newEntity();
     $this->set('MotoLots',$MotoLots);
   }

   public function hasukensakuview()
  {
    $MotoLots = $this->MotoLots->newEntity();
    $this->set('MotoLots',$MotoLots);
    $data = $this->request->getData();
    $product_code = $data['product_code'];
    $this->set('product_code',$product_code);
    $lot_num = $data['lot_num'];
    $this->set('lot_num',$lot_num);

    if(empty($data['product_code'])){//product_codeの入力がないとき
      $product_code = "入力されていません";
      $this->set('product_code',$product_code);
      if(empty($data['lot_num'])){//lot_numの入力がないとき
        $mes = "※検索情報が入力されていません";
        $this->set('mes',$mes);
        $kensakucheck = 2;
        $this->set('kensakucheck',$kensakucheck);
      }else{//lot_numの入力があるとき　ロットで絞り込み
        $this->set('MotoLots',$this->MotoLots->find()//以下の条件を満たすデータをMotoLotsテーブルから見つける
          ->where(['delete_flag' => '0', 'hasu_lot' => $lot_num]));
          $kensakucheck = 1;
          $this->set('kensakucheck',$kensakucheck);
      }
    }else{//product_codeの入力があるとき
      if(empty($data['lot_num'])){//lot_numの入力がないとき
        $lot_num = "入力されていません";//プロダクトコードで絞り込み
        $this->set('lot_num',$lot_num);
        $this->set('MotoLots',$this->MotoLots->find()//以下の条件を満たすデータをMotoLotsテーブルから見つける
          ->where(['delete_flag' => '0', 'product_code' => $product_code]));
          $kensakucheck = 1;
          $this->set('kensakucheck',$kensakucheck);
      }else{//lot_numの入力があるとき　プロダクトコードとロットナンバーで絞り込み
        $this->set('MotoLots',$this->MotoLots->find()//以下の条件を満たすデータをMotoLotsテーブルから見つける
          ->where(['delete_flag' => '0', 'hasu_lot' => $lot_num, 'product_code' => $product_code]));
          $kensakucheck = 1;
          $this->set('kensakucheck',$kensakucheck);
      }
    }
  }

      public function genzaijoukyoumenu()
     {
       //$this->request->session()->destroy(); // セッションの破棄
     }

     public function genzaijoukyouform()
    {
      //$this->request->session()->destroy(); // セッションの破棄
      $checkLots = $this->CheckLots->newEntity();
      $this->set('checkLots',$checkLots);
    }

    public function genzaijoukyouichiran()
   {
     $checkLots = $this->CheckLots->newEntity();
     $this->set('checkLots',$checkLots);

     $data = $this->request->getData();

     $datesta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
     $datefin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];
     $dif_days = ((strtotime($datefin) - strtotime($datesta)) / 86400);//日時の差を取る
     $this->set('dif_days',$dif_days);

     $date0 = $datesta;

     for($i=0; $i<=$dif_days; $i++){//それぞれのdate_deliverについて

       ${"arrPlace_kannou".$i} =  array();
       ${"arrPlace_minou".$i} =  array();

       $this->set('date'.$i,${"date".$i});

       ${"arrCheckLots".$i} = $this->CheckLots->find()->where(['date_deliver' => ${"date".$i}, 'delete_flag' => '0'])->toArray();
       ${"arrOrderEdis".$i} = $this->OrderEdis->find()->where(['date_deliver' => ${"date".$i}, 'delete_flag' => '0'])->toArray();

       ${"arrPro_c".$i} =  array();//同じdate_deliverのデータから品番を一意に取り出す
       if(count(${"arrOrderEdis".$i}) > 0){
         for($j=0; $j<count(${"arrOrderEdis".$i}); $j++){
           ${"arrPro_c".$i}[] = ${"arrOrderEdis".$i}[$j]->product_code;
         }
       }
/*
       echo "<pre>";
       print_r(count(${"arrPro_c".$i}));
       echo "</pre>";
*/
       ${"arrPro_c".$i} = array_unique(${"arrPro_c".$i}, SORT_REGULAR);//重複削除
       ${"arrPro_c".$i} = array_values(${"arrPro_c".$i});//連番振り直し

       if(count(${"arrPro_c".$i}) > 0){

         for($m=0; $m<count(${"arrPro_c".$i}); $m++){//それぞれのproduct_codeについて
           $amount_c = 0;
           $amount_o = 0;

           ${"arrCheckdouitu".$m} = $this->CheckLots->find()->where(['date_deliver' => ${"date".$i}, 'product_code' => ${"arrPro_c".$i}[$m], 'delete_flag' => '0'])->toArray();

           if(isset(${"arrCheckdouitu".$m}[0])){

             for($n=0; $n<count(${"arrCheckdouitu".$m}); $n++){
               $amount_c = $amount_c + ${"arrCheckdouitu".$m}[$n]->amount;
             }
           }

           ${"arrOrderdouitu".$m} = $this->OrderEdis->find()->where(['date_deliver' => ${"date".$i}, 'product_code' => ${"arrPro_c".$i}[$m], 'delete_flag' => '0'])->toArray();

           if(isset(${"arrOrderdouitu".$m}[0])){
             for($n=0; $n<count(${"arrOrderdouitu".$m}); $n++){
               $amount_o = $amount_o + ${"arrOrderdouitu".$m}[$n]->amount;
             }
           }

           if($amount_c == $amount_o){//date_deliver,product_codeが同じもののamount合計が同じ（$amount_c == $amount_o）場合は完納チェックする（update）

             for($p=0; $p<count(${"arrOrderdouitu".$m}); $p++){

                $connection = ConnectionManager::get('default');//トランザクション1
                // トランザクション開始2
                $connection->begin();//トランザクション3
                try {//トランザクション4

                  if ($this->OrderEdis->updateAll(//新DBをupdate
                   ['kannou' => 1, 'check_kannou' => date('Y-m-d H:i:s')],
                   ['id'  => ${"arrOrderdouitu".$m}[$p]->id])) {

                     $connection->commit();// コミット5ここに持ってくる//これを旧DBの登録の後に持ってきたら新DBに登録されない（トランザクションが途中で途切れる？）

                     //insert 旧update
                     $connection = ConnectionManager::get('sakaeMotoDB');
                     $table = TableRegistry::get('order_edi');
                     $table->setConnection($connection);

                     $num_order = ${"arrOrderdouitu".$m}[$p]->num_order;
                     $updater = "UPDATE order_edi set kannou = 1 , check_kannou = '".date('Y-m-d H:i:s')."'
                       where product_id ='".${"arrPro_c".$i}[$m]."' and date_deliver = '".${"date".$i}."' and num_order = '".$num_order."'";//もとのDBも更新
                     $connection->execute($updater);

                     $connection = ConnectionManager::get('default');//新DBに戻る
                     $table->setConnection($connection);

                  } else {
                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                    throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                  }
                } catch (Exception $e) {//トランザクション7
                //ロールバック8
                  $connection->rollback();//トランザクション9
                }//トランザクション10


               $arrPlaceDelivers = $this->PlaceDelivers->find()->where(['id_from_order' => ${"arrOrderdouitu".$m}[$p]->place_deliver_code])->toArray();
               if(${"arrOrderdouitu".$m}[$p]->place_deliver_code == "199969" || ${"arrOrderdouitu".$m}[$p]->place_deliver_code == "199929" || ${"arrOrderdouitu".$m}[$p]->place_deliver_code == "199999" || ${"arrOrderdouitu".$m}[$p]->place_deliver_code == "100360"){
                 ${"arrPlaceDelivers_kannou".$i}[] = "DNP".$arrPlaceDelivers[0]->name;
               }else{
                 ${"arrPlaceDelivers_kannou".$i}[] = $arrPlaceDelivers[0]->name;
               }

             }

           }else{

             for($p=0; $p<count(${"arrOrderdouitu".$m}); $p++){

                if(${"arrOrderdouitu".$m}[$p]->place_deliver_code !== "00000"){

                  $arrPlaceDelivers = $this->PlaceDelivers->find()->where(['id_from_order' => ${"arrOrderdouitu".$m}[$p]->place_deliver_code])->toArray();
                  if(${"arrOrderdouitu".$m}[$p]->place_deliver_code == "199969" || ${"arrOrderdouitu".$m}[$p]->place_deliver_code == "199929" || ${"arrOrderdouitu".$m}[$p]->place_deliver_code == "199999" || ${"arrOrderdouitu".$m}[$p]->place_deliver_code == "100360"){
                    ${"arrPlaceDelivers_minou".$i}[] = "DNP".$arrPlaceDelivers[0]->name;
                  }else{
                    ${"arrPlaceDelivers_minou".$i}[] = $arrPlaceDelivers[0]->name;
                  }

                }

             }

           }

         }

       }

       if(isset(${"arrPlaceDelivers_kannou".$i}[0])){//完納のものがある場合
         ${"arrPlaceDelivers_kannou".$i} = array_unique(${"arrPlaceDelivers_kannou".$i}, SORT_REGULAR);//重複削除
         ${"arrPlaceDelivers_kannou".$i} = array_values(${"arrPlaceDelivers_kannou".$i});//連番振り直し
         $this->set('arrPlaceDelivers_kannou'.$i,${"arrPlaceDelivers_kannou".$i});

         ${"arrPlaceDelivers_kannou_hyouji".$i} = "";
         for($r=0; $r<count(${"arrPlaceDelivers_kannou".$i}); $r++){
           ${"arrPlaceDelivers_kannou_hyouji".$i} = ${"arrPlaceDelivers_kannou_hyouji".$i}."　".${"arrPlaceDelivers_kannou".$i}[$r];
         }

         $this->set('arrPlaceDelivers_kannou_hyouji'.$i,${"arrPlaceDelivers_kannou_hyouji".$i});

       }else{//完納のものがない場合
         ${"arrPlaceDelivers_kannou_hyouji".$i} = "";
         $this->set('arrPlaceDelivers_kannou_hyouji'.$i,${"arrPlaceDelivers_kannou_hyouji".$i});
       }

       if(isset(${"arrPlaceDelivers_minou".$i}[0])){//未納のものがある場合
         ${"arrPlaceDelivers_minou".$i} = array_unique(${"arrPlaceDelivers_minou".$i}, SORT_REGULAR);//重複削除
         ${"arrPlaceDelivers_minou".$i} = array_values(${"arrPlaceDelivers_minou".$i});//連番振り直し

         ${"arrPlaceDelivers_minou_hyouji".$i} = "";
         for($r=0; $r<count(${"arrPlaceDelivers_minou".$i}); $r++){
           ${"arrPlaceDelivers_minou_hyouji".$i} = ${"arrPlaceDelivers_minou_hyouji".$i}."　".${"arrPlaceDelivers_minou".$i}[$r];
         }

         $this->set('arrPlaceDelivers_minou_hyouji'.$i,${"arrPlaceDelivers_minou_hyouji".$i});

       }else{//未納のものがない場合
         ${"arrPlaceDelivers_minou_hyouji".$i} = "";
         $this->set('arrPlaceDelivers_minou_hyouji'.$i,${"arrPlaceDelivers_minou_hyouji".$i});
       }

       $k = $i +1;//最後に、次の日に変更
       ${"date".$k} = strtotime(${"date".$i});
       ${"date".$k} = date('Y-m-d', strtotime('+1 day', ${"date".$k}));

     }

   }


        public function syukkajoukyouform()
       {
         //$this->request->session()->destroy(); // セッションの破棄
         $orderEdis = $this->OrderEdis->newEntity();
         $this->set('orderEdis',$orderEdis);
       }

       public function syukkajoukyouselect()
      {
        $orderEdis = $this->OrderEdis->newEntity();
        $this->set('orderEdis',$orderEdis);

        $data = $this->request->getData();

        $inputdate = $data['inputday']['year']."-".$data['inputday']['month']."-".$data['inputday']['day'];
        $this->set('inputdate',$inputdate);

        $arrPlace =  array();
        $arrPlacecode =  array();

        $arrOrderEdis = $this->OrderEdis->find()->where(['date_deliver' => $inputdate, 'delete_flag' => '0'])->toArray();

        if(count($arrOrderEdis) > 0){
          for($j=0; $j<count($arrOrderEdis); $j++){
            ${"place_deliver_code".$j} = $arrOrderEdis[$j]->place_deliver_code;
            if(${"place_deliver_code".$j} !== "00000"){
              ${"arrPlaceDelivers".$j} = $this->PlaceDelivers->find()->where(['id_from_order' => ${"place_deliver_code".$j}])->toArray();
              if(${"place_deliver_code".$j} == "199969" || ${"place_deliver_code".$j} == "199929" || ${"place_deliver_code".$j} == "199999" || ${"place_deliver_code".$j} == "100360"){
                $arrPlace[] = "DNP".${"arrPlaceDelivers".$j}[0]->name;
                $arrPlacecode[] = ${"place_deliver_code".$j};
              }else{
                $arrPlace[] = ${"arrPlaceDelivers".$j}[0]->name;
                $arrPlacecode[] = ${"place_deliver_code".$j};
              }
            }
          }
        }

        $arrPlace = array_unique($arrPlace, SORT_REGULAR);//重複削除
        $arrPlace = array_values($arrPlace);//連番振り直し
        $this->set('arrPlace',$arrPlace);

        $arrPlacecode = array_unique($arrPlacecode, SORT_REGULAR);//重複削除
        $arrPlacecode = array_values($arrPlacecode);//連番振り直し
        $this->set('arrPlacecode',$arrPlacecode);
/*
        echo "<pre>";
        print_r($arrPlace);
        echo "</pre>";
*/
      }

      public function syukkajoukyouichiran()
     {
       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);

       $data = $this->request->getData();
       $inputdate = $data['inputdate'];
       $this->set('inputdate',$inputdate);

       $arrOrderEdis = $this->OrderEdis->find()->where(['date_deliver' => $inputdate, 'place_deliver_code' => array_keys($data)[0], 'delete_flag' => '0'])->toArray();

       $place_deliver = $data[array_keys($data)[0]];
       $this->set('place_deliver',$place_deliver);
       $place_deliver_code = array_keys($data)[0];

/*
       echo "<pre>";
       print_r(array_keys($data)[0]);
       echo "</pre>";
*/
       $arrPro =  array();
       $arrPlace =  array();

       if(count($arrOrderEdis) > 0){

         for($j=0; $j<count($arrOrderEdis); $j++){

           $arrPro[] = $arrOrderEdis[$j]->product_code;
           $Product = $this->Products->find()->where(['product_code' => $arrOrderEdis[$j]->product_code])->toArray();
           if(isset($Product[0])){
             $product_name = $Product[0]->product_name;
           }else{
             echo "<pre>";
             print_r($arrOrderEdis[$j]->product_code."は製品登録されていません。製品登録してください。");
             echo "</pre>";
             $product_name = "";
           }
           $arrPlace[] = ['product_code' => $arrOrderEdis[$j]->product_code, 'product_name' => $product_name, 'amount' => $arrOrderEdis[$j]->amount, 'check' => $arrOrderEdis[$j]->kannou];

         }

       }

       $this->set('arrPlace',$arrPlace);
/*
       echo "<pre>";
       print_r($arrPlace);
       echo "</pre>";
*/
       $arrPro = array_unique($arrPro, SORT_REGULAR);//重複削除
       $arrPro = array_values($arrPro);//連番振り直し

       $this->set('arrPro',$arrPro);

       if(count($arrPro) > 0){

         for($j=0; $j<count($arrPro); $j++){//それぞれの品番に対して

           ${"product_code".$j} = $arrPro[$j];
           ${"total_amount".$j} = 0;
           ${"check_amount".$j} = 0;

           for($k=0; $k<count($arrPlace); $k++){

             if($arrPlace[$k]['product_code'] == ${"product_code".$j}){//その品番に一致する場合

               ${"total_amount".$j} = ${"total_amount".$j} + $arrPlace[$k]['amount'];

               if($arrPlace[$j]['check'] == 1){

                 ${"check_amount".$j} = ${"check_amount".$j} + $arrPlace[$k]['amount'];

               }else{

                 ${"check_amount".$j} = ${"check_amount".$j};

               }

             }

           }

         }

       }

       for($j=0; $j<count($arrPro); $j++){

         ${"Products".$j} = $this->Products->find()->where(['product_code' => ${"product_code".$j}])->toArray();
         ${"product_name".$j} = ${"Products".$j}[0]->product_name;

         $this->set('product_code'.$j,${"product_code".$j});
         $this->set('product_name'.$j,${"product_name".$j});
         $this->set('total_amount'.$j,${"total_amount".$j});

         ${"arrCheckLots".$j} = $this->CheckLots->find()->where(['date_deliver' => $inputdate, 'product_code' => ${"product_code".$j},  'place_deliver_code' => $place_deliver_code, 'delete_flag' => '0'])->toArray();

         if(count(${"arrCheckLots".$j}) > 0){

          ${"check_amount".$j} = 0;

           for($k=0; $k<count(${"arrCheckLots".$j}); $k++){

             ${"check_amount".$j} = ${"check_amount".$j} + ${"arrCheckLots".$j}[$k]->amount;
             $this->set('check_amount'.$j,${"check_amount".$j});

           }

         }else{

           ${"check_amount".$j} = 0;
           $this->set('check_amount'.$j,${"check_amount".$j});

         }

       }

     }

     public function syukkajoukyousyousai()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $data = $this->request->getData();
      $inputdate = $data['inputdate'];
      $this->set('inputdate',$inputdate);
      $place_deliver = $data['place_deliver'];
      $this->set('place_deliver',$place_deliver);

      $pro_amount = explode('_', array_keys($data)[0]);
      $product_code = $pro_amount[0];
      $this->set('product_code',$product_code);

      $Products = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Products[0]->product_name;
      $this->set('product_name',$product_name);

      $total_amount = $pro_amount[1];
      $this->set('total_amount',$total_amount);
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $arrCheckLots = $this->CheckLots->find()->where(['date_deliver' => $inputdate, 'product_code' => $product_code, 'delete_flag' => '0'])->toArray();

      if(count($arrCheckLots) > 0){

        for($j=0; $j<count($arrCheckLots); $j++){

          $arrPlace[] = ['lot_num' => $arrCheckLots[$j]->lot_num, 'amount' => $arrCheckLots[$j]->amount];

        }

        $this->set('arrPlace',$arrPlace);

      }
/*
      echo "<pre>";
      print_r($arrPlace);
      echo "</pre>";
*/

    }


    public function doubletourokuform()
   {
     //$this->request->session()->destroy(); // セッションの破棄
     $CheckLotsDoubles = $this->CheckLotsDoubles->newEntity();
     $this->set('CheckLotsDoubles',$CheckLotsDoubles);

     $arrStaffs = $this->Staffs->find('all', ['conditions' => ['delete_flag' => '0']])->order(['staff_code' => 'ASC']);
     $arrStaff = array();
     $arrStaff[] = array("");
       foreach ($arrStaffs as $value) {
         $arrStaff[] = array($value->id=>$value->f_name.$value->l_name);
       }
      $this->set('arrStaff',$arrStaff);

   }

   public function doubletourokuichiran()
  {
    //$this->request->session()->destroy(); // セッションの破棄
    $CheckLotsDoubles = $this->CheckLotsDoubles->newEntity();
    $this->set('CheckLotsDoubles',$CheckLotsDoubles);

    $data = $this->request->getData();
/*
    echo "<pre>";
    print_r($data);
    echo "</pre>";
*/
    $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
    $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];
    $date_fin = strtotime($date_fin);
    $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));
/*
    $CheckLotsDoubles = $this->CheckLotsDoubles->find()
    ->where(['second_created_time >=' => $date_sta, 'second_created_time <=' => $date_fin])->order(["second_created_time"=>"ASC"]);
    $this->set('CheckLotsDoubles',$CheckLotsDoubles);
*/
    if(empty($data['lot_num'])){//lot_numの入力がないとき

      if(empty($data['staff'])){//staffの入力がないとき

        $CheckLotsDoubles = $this->CheckLotsDoubles->find()
        ->where(['delete_flag' => '0', 'second_created_time >=' => $date_sta, 'second_created_time <=' => $date_fin])->order(["second_created_time"=>"ASC"]);
        $this->set('CheckLotsDoubles',$CheckLotsDoubles);

      }else{//staffの入力があるとき

        $CheckLotsDoubles = $this->CheckLotsDoubles->find()
        ->where(['delete_flag' => '0', 'second_created_time >=' => $date_sta, 'second_created_time <=' => $date_fin, 'second_created_staff' => $data['staff']])->order(["second_created_time"=>"ASC"]);
        $this->set('CheckLotsDoubles',$CheckLotsDoubles);

      }
    }else{//lot_numの入力があるとき
      if(empty($data['staff'])){//staffの入力がないとき

        $CheckLotsDoubles = $this->CheckLotsDoubles->find()
        ->where(['delete_flag' => '0', 'second_created_time >=' => $date_sta, 'second_created_time <=' => $date_fin, 'lot_num' => $data['lot_num']])->order(["second_created_time"=>"ASC"]);
        $this->set('CheckLotsDoubles',$CheckLotsDoubles);

      }else{//staffの入力があるとき

        $CheckLotsDoubles = $this->CheckLotsDoubles->find()
        ->where(['delete_flag' => '0', 'second_created_time >=' => $date_sta, 'second_created_time <=' => $date_fin, 'lot_num' => $data['lot_num'], 'second_created_staff' => $data['staff']])->order(["second_created_time"=>"ASC"]);
        $this->set('CheckLotsDoubles',$CheckLotsDoubles);

      }
    }

  }

     public function confirmcsv()
    {
      /*    $fp = fopen("191106konpou.csv", "r");//csvファイルはwebrootに入れる
          $this->set('fp',$fp);
          $fpcount = fopen("191106konpou.csv", 'r' );
          for( $count = 0; fgets( $fpcount ); $count++ );
          $this->set('count',$count);
          $arrFp = array();//空の配列を作る
        	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
          for ($k=1; $k<=$count-1; $k++) {//最後の行まで
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
            $keys=array_keys($sample);
        		$keys[array_search('0',$keys)]='product_code';//名前の変更
        		$keys[array_search('1',$keys)]='irisu';
        		$keys[array_search('2',$keys)]='id_box';
            $keys[array_search('3',$keys)]='delete_flag';
            $keys[array_search('4',$keys)]='created_staff';
        		$sample = array_combine($keys, $sample );
        		unset($sample['5']);//削除
            $arrFp[] = $sample;//配列に追加する
          }
          $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
          echo "<pre>";
          print_r($arrFp);
          echo "<br>";
          $konpous = $this->Konpous->newEntity();
          $this->set('konpous',$konpous);
        	if ($this->request->is('get')) {
        		$konpous = $this->Konpous->patchEntities($konpous, $arrFp);
        		$connection = ConnectionManager::get('default');//トランザクション1
        		// トランザクション開始2
        		$connection->begin();//トランザクション3
        		try {//トランザクション4
        				if ($this->Konpous->saveMany($konpous)) {//saveManyで一括登録
        					$connection->commit();// コミット5
        				} else {
        					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
        					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        				}
        		} catch (Exception $e) {//トランザクション7
        		//ロールバック8
        			$connection->rollback();//トランザクション9
        		}//トランザクション10
        	}
      */
    }

}
