<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class ChecklotsController extends AppController
{

    public function initialize()
    {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');
			$this->Users = TableRegistry::get('users');
      $this->CheckLots = TableRegistry::get('checkLots');
      $this->Products = TableRegistry::get('products');
      $this->ZensuProducts = TableRegistry::get('zensuProducts');
    }

    public function preadd()
    {
      $CheckLots = $this->CheckLots->newEntity();
      $this->set('CheckLots',$CheckLots);
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
            return $this->redirect(['action' => 'addform']);
          }
        }
    }

    public function addform()
    {
      $CheckLots = $this->CheckLots->newEntity();
      $this->set('CheckLots',$CheckLots);

      $session = $this->request->getSession();
      $data = $session->read();

      $staff_id = $data["Auth"]["User"]["staff_id"];
      $this->set('staff_id',$staff_id);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }

      /*
      echo "<pre>";
      print_r($staff_id);
      echo "</pre>";
*/
			if(!isset($_SESSION)){
				session_start();
			}
				header('Expires:-1');
				header('Cache-Control:');
				header('Pragma:');

    }

     public function addconfirm()
    {
      $CheckLots = $this->CheckLots->newEntity();
      $this->set('CheckLots',$CheckLots);

      $data = $this->request->getData();

      $Products = $this->Products->find()
      ->where(['product_code' => $data["product_code"], 'delete_flag' => 0])->toArray();

      if(!isset($Products[0])){

        return $this->redirect(['action' => 'addform',
        's' => ['mess' => "品番：「".$data["product_code"]."」の製品は製品登録されていません。"]]);

      }
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $maisu = $data["maisu"];
      $arrlot_num = explode('-', $data['lot_num']);
      $arraylot_nums = array();//空の配列を作る
      $arraylot_numtorikomizumis = array();//空の配列を作る

      for($k=0; $k<$maisu; $k++){
        $renban = $arrlot_num[1] + $k;

        $lot_num = $arrlot_num[0]."-".sprintf('%03d', $renban);

        $CheckLottourokuzumi = $this->CheckLots->find()
        ->where(['product_code' => $data["product_code"], 'lot_num' => $lot_num])->toArray();

        if(isset($CheckLottourokuzumi[0])){//すでにある場合
          $arraylot_numtorikomizumis[] = $lot_num;
        }else{
          $arraylot_nums[] = $lot_num;
        }

      }
      $this->set('arraylot_numtorikomizumis',$arraylot_numtorikomizumis);
      $this->set('arraylot_nums',$arraylot_nums);

    }

     public function adddo()
    {
      $CheckLots = $this->CheckLots->newEntity();
      $this->set('CheckLots',$CheckLots);

			$data = $this->request->getData();

      $datetime_hakkou = str_replace("T", " ", $data["datetime_hakkou"]);
      $ZensuProduct = $this->ZensuProducts->find()->where(['product_code' => $data["product_code"], 'status' => 0])->toArray();
      if(isset($ZensuProduct[0])){
        $flag_used = 9;
      }else{
        $flag_used = 0;
      }

      $nummax = $data["nummax"];
      $this->set('nummax',$nummax);

      $arraylot_nums = array();//空の配列を作る
      $tourokuCheckLots = array();//空の配列を作る
      for($k=0; $k<=$nummax; $k++){
        $arraylot_nums[] = $data["lot_num".$k];

        $tourokuCheckLots[] = [
          'datetime_hakkou' => $datetime_hakkou,
          'product_code' => $data["product_code"],
          'lot_num' => $data["lot_num".$k],
          'amount' => $data["amount"],
          'flag_used' => $flag_used,
  				'delete_flag' => 0,
  				'created_at' => date('Y-m-d H:i:s'),
  				'created_staff' => $data["staff_id"],
  			];

      }
      $this->set('arraylot_nums',$arraylot_nums);
/*
      echo "<pre>";
      print_r($tourokuCheckLots);
      echo "</pre>";
*/
			$CheckLots = $this->CheckLots->patchEntities($this->CheckLots->newEntity(), $tourokuCheckLots);
			$connection = ConnectionManager::get('default');//トランザクション1
			 // トランザクション開始2
			 $connection->begin();//トランザクション3
			 try {//トランザクション4
				 if ($this->CheckLots->saveMany($CheckLots)) {

					 $mes = "登録されました。";
					 $this->set('mes',$mes);
					 $connection->commit();// コミット5

					 } else {

						 $mes = "※登録されませんでした";
						 $this->set('mes',$mes);
						 $this->Flash->error(__('The product could not be saved. Please, try again.'));
						 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

					 }

			 } catch (Exception $e) {//トランザクション7
			 //ロールバック8
				 $connection->rollback();//トランザクション9
			 }//トランザクション10

    }

}
