<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

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
     }

   public function index()
   {
     $this->request->session()->destroy(); // セッションの破棄
   }

   public function placeform()//納品場所入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
   }

   public function placeconfirm()//納品場所確認
   {
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
   }

   public function placepreadd()//納品場所ログイン
   {
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);

     $session = $this->request->getSession();
     $data = $session->read();
/*
     echo "<pre>";
     print_r($_SESSION['labelplaces']);
     echo "</pre>";
*/
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
           $connection->commit();// コミット5
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
     $this->request->session()->destroy(); // セッションの破棄
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
   }

   public function nashiconfirm()//セット取り確認
   {
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
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
           $connection->commit();// コミット5
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
     $this->request->session()->destroy(); // セッションの破棄
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
   }

   public function setikkatsuconfirm()//セット取り確認
   {
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
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
           $connection->commit();// コミット5
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
     $this->request->session()->destroy(); // セッションの破棄
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
   }

   public function insideoutconfirm()//外箱中身確認
   {
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
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
           $connection->commit();// コミット5
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
     $this->request->session()->destroy(); // セッションの破棄
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }

   public function unitconfirm()//数量単位確認
   {
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
           $connection->commit();// コミット5
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

   public function preform()//ラベル発行
   {
     $this->request->session()->destroy(); // セッションの破棄

     $scheduleKouteis = $this->ScheduleKouteis->newEntity();
     $this->set('scheduleKouteis',$scheduleKouteis);
   }

   public function form()//ラベル発行
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
/*        echo "<pre>";
        print_r($_SESSION['labeljunbi'][$data['m']]);
        echo "</pre>";
*/
        $dateYMDs = $data['dateYMDs'];
        $dateYMDf = $data['dateYMDf'];
        $this->set('dateYMDs',$dateYMDs);
        $this->set('dateYMDf',$dateYMDf);

        $arrCsv = array();
        for($i=1; $i<=$data['m']; $i++){
          $date = date('Y/m/d H:i:s');
          $datetimeymd = substr($date,0,10);
          $datetimehm = substr($date,11,5);
          $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
          $Product = $this->Products->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($Product[0])){
            $costomerId = $Product[0]->customer_id;
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
          if(mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ"){//mb_substrだと文字化けしない
            $Layout = "B";
          }else{
            $Layout = "A";
          }

          $arrCsv[] = ['date' => $datetimeymd, 'datetime' => $datetimehm, 'layout' => '現品札_'.$Layout.'.mllay', 'maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'],
           'lotnum' => $lotnum, 'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'],
           'irisu' => $irisu];

           $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
           if(isset($Customer[0])){
             $costomerName = $Customer[0]->name;
/*             echo "<pre>";
             print_r(mb_substr($costomerName, 0, 6));
             echo "</pre>";
*/
           }else{
             $costomerName = "";
           }
           if(mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ"){//mb_substrだと文字化けしない
             $lotnumIN = "IN.".$lotnum;
             $Layout = "B";
             $arrCsv[] = ['date' => $datetimeymd, 'datetime' => $datetimehm, 'layout' => '現品札_'.$Layout.'.mllay', 'maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'],
              'lotnum' => $lotnumIN, 'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'],
              'irisu' => $irisu];
           }

        }

        $fp = fopen('labels/labeljunbi.csv', 'w');
        foreach ($arrCsv as $line) {
        	fputcsv($fp, $line);
        }
          fclose($fp);

      }elseif(isset($data['confirm'])){//確認おしたとき
       $this->set('confirm',$data['confirm']);
       $dateYMDs = $data['dateYMDs'];
       $dateYMDf = $data['dateYMDf'];
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
/*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
*/
     }elseif(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
       $data = $this->request->getData();//postデータを$dataに
       $dateYMDs = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 00:00";
       $dateYMDf = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 23:59";
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

     }else{

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
     $ScheduleKoutei = $this->ScheduleKouteis->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'present_kensahyou' => 0])->toArray();
     $ScheduleKoutei_product_code = $ScheduleKoutei[0]->product_code;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける

      for($j=1; $j<=9; $j++){
      $ScheduleKoutei = $this->ScheduleKouteis->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'seikeiki' => $j, 'present_kensahyou' => 0])->toArray();

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

      //    echo "<pre>";
      //    print_r(${"ScheduleKouteisarry".$j});
      //    echo "</pre>";

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
/*
                echo "<pre>";
                print_r($j."henkou".$m);
                print_r(${"arrP".$j.$m1});
                echo "</pre>";
                */
              }
/*
            echo "<pre>";
            print_r($j."--".$m);
            print_r(${"arrP".$j.$m});
            echo "</pre>";
*/
          }
        }
      }
   }

		public function preadd()
		{
      $KadouSeikei = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikei',$KadouSeikei);
/*
      $session = $this->request->getSession();
      $data = $session->read();

      echo "<pre>";
      print_r($_SESSION['kadouseikeiId']);
      echo "</pre>";
*/
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
			$this->request->session()->destroy(); // セッションの破棄
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
/*
    if ($this->request->is('get')) {
    echo "<pre>";
    print_r($_SESSION['kadouseikei']);
    echo "</pre>";
  }
*/

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

    public function edit($id = null)
    {
			$role = $this->Roles->get($id);//選んだidに関するRolesテーブルのデータに$roleと名前を付ける
			$this->set('role',$role);//
			$updated_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$role['updated_staff'] = $updated_staff;//$roleのupdated_staffを$staff_idにする

			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
				$role = $this->Roles->patchEntity($role, $this->request->getData());//106行目でとったもともとの$roleデータを$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Roles->save($role)) {
						$this->Flash->success(__('The role has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The role could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}

    }

}
