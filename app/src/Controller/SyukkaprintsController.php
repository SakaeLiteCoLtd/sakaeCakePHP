<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\myClass\KensahyouSokuteidata\htmlKensahyouSokuteidata;//myClassフォルダに配置したクラスを使用

class SyukkaprintsController extends AppController {

      public function initialize()
    {
     parent::initialize();
     $this->Products = TableRegistry::get('products');//productsテーブルを使う
     $this->Customers = TableRegistry::get('customers');
     $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
     $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouSokuteidatasテーブルを使う
     $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');//KadouSeikeisテーブルを使う
     $this->Users = TableRegistry::get('users');
     $this->KouteiKensahyouHeads = TableRegistry::get('kouteiKensahyouHeads');
     $this->OrderEdis = TableRegistry::get('orderEdis');
    }

    public function form()
    {
      $product = $this->Products->newEntity();
			$this->set('product',$product);

      $field = array();
  		$field[] = array("10001"=>"PDF草津食洗");
  		$field[] = array("99999"=>"印刷その他顧客");
			$this->set('field',$field);
    }

    public function ichiran()
    {
      $product = $this->Products->newEntity();
			$this->set('product',$product);

      $data = $this->request->getData();

      if(isset($data['date_deliver']['year'])){
        $date_deliver = $data['date_deliver']['year']."-".$data['date_deliver']['month']."-".$data['date_deliver']['day'];
      }else{
        $date_deliver = $data['date_deliver'];
      }
      $this->set('date_deliver',$date_deliver);

      $check = array_keys($data, '全てチェックをはずす');

      if(isset($check[0])){
        $allcheck_flag = 0;
      }else{
        $allcheck_flag = 1;
      }
      $this->set('allcheck_flag',$allcheck_flag);
/*
      echo "<pre>";
      print_r($allcheck_flag);
      echo "</pre>";
*/
      if($data['field'] == 10001){
        $field = "PDF草津食洗";
      }elseif($data['field'] == 99999){
        $field = "印刷その他顧客";
      }else{
        $field = $data['field'];
      }
			$this->set('field',$field);

      if($field === "PDF草津食洗"){

        $OrderEdis = $this->OrderEdis->find()->where(['date_deliver' => $date_deliver, 'customer_code' => '10001'])->order(['product_code' => 'ASC'])->toArray();

      }else{

        $OrderEdis = $this->OrderEdis->find()->where(['date_deliver' => $date_deliver, 'customer_code not like' => '10001%'])->order(['product_code' => 'ASC'])->toArray();

      }
      $this->set('orderEdis',$OrderEdis);

      if(isset($data['kakunin'])){

        for ($k=2; $k<=$data["nummax"]; $k++){
          if(isset($data["check".$k])){
            $array[] = [
              'product_code' => $data["product_code".$k],
              'product_name' => $data["product_name".$k],
              'amount' => $data["amount".$k],
              'place_line' => $data["place_line".$k],
              'manu_date' => $data["manu_date".$k],
              'field' => $data["field"],
              'date_deliver' => $data["date_deliver"]
           ];
          }
        }

        return $this->redirect(['action' => 'confirm',
        's' => ['arrinsatsu' => $array]]);

      }

    }

    public function confirm()
    {
      $product = $this->Products->newEntity();
			$this->set('product',$product);

      $Data=$this->request->query('s');

      $arrinsatsu = $Data['arrinsatsu'];
/*
      echo "<pre>";
      print_r($arrinsatsu);
      echo "</pre>";
*/
      $this->set('orderEdis',$arrinsatsu);

      session_start();
      $session = $this->request->getSession();
      $_SESSION['insatsu'] = $arrinsatsu;

    }

    public function preadd()
		{
      $product = $this->Products->newEntity();
			$this->set('product',$product);
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

    public function do()
    {
      $product = $this->Products->newEntity();
			$this->set('product',$product);

      $session = $this->request->getSession();
      $data = $session->read();

      echo "<pre>";
      print_r($data["insatsu"]);
      echo "</pre>";
      $this->set('orderEdis',$data["insatsu"]);

    }

}
