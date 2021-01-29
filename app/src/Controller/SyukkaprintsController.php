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
     $this->KensahyouJyunbiInsatsus = TableRegistry::get('kensahyouJyunbiInsatsus');
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

      $this->set('orderEdis',$data["insatsu"]);

      $arrtouroku = array();
      for ($k=0; $k<count($data["insatsu"]); $k++){

        if($data["insatsu"][$k]['field'] == "PDF草津食洗"){
          $field = 10001;
        }else{
          $field = 99999;
        }

        $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->find()
        ->where(['product_code' => $data["insatsu"][$k]["product_code"], 'manu_date' => $data["insatsu"][$k]["manu_date"]])->toArray();
        $kensahyou_heads_id = $KensahyouSokuteidatas[0]->kensahyou_heads_id;

          $arrtouroku[] = [
            'kensahyou_heads_id' => $kensahyou_heads_id,
            'amount' => $data["insatsu"][$k]["amount"],
            'place_line' => $data["insatsu"][$k]["place_line"],
            'field' => $field,
            'date_deliver' => $data["insatsu"][$k]["date_deliver"]
         ];
      }
/*
      echo "<pre>";
      print_r($arrtouroku);
      echo "</pre>";
*/
      //新しいデータを登録
      $KensahyouJyunbiInsatsus = $this->KensahyouJyunbiInsatsus->patchEntities($this->KensahyouJyunbiInsatsus->newEntity(), $arrtouroku);
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->KensahyouJyunbiInsatsus->saveMany($KensahyouJyunbiInsatsus)) {

          //旧DBに登録
          $connection = ConnectionManager::get('sakaeMotoDB');
          $table = TableRegistry::get('kensahyou_jyunbi_insatsu');
          $table->setConnection($connection);

          for($k=0; $k<count($data["insatsu"]); $k++){

            $sql = "SELECT kensahyou_sokuteidata_head_id FROM kensahyou_sokuteidata_head".
                  " where product_id = '".$data["insatsu"][$k]["product_code"]."' and manu_date = '".$data["insatsu"][$k]["manu_date"]."'";
            $connection = ConnectionManager::get('sakaeMotoDB');
            $kensahyou_sokuteidata_heads = $connection->execute($sql)->fetchAll('assoc');
            $kensahyou_sokuteidata_head = $kensahyou_sokuteidata_heads[0]["kensahyou_sokuteidata_head_id"];

            $connection->insert('kensahyou_jyunbi_insatsu', [
              'kensahyou_sokuteidata_head_id' => $kensahyou_sokuteidata_head,
              'amount' => $data["insatsu"][$k]["amount"],
              'place_line' => $data["insatsu"][$k]["place_line"],
              'field' => $field,
              'date_deliver' => $data["insatsu"][$k]["date_deliver"]
            ]);

          }

          $connection = ConnectionManager::get('default');
          $table->setConnection($connection);

          $connection->commit();// コミット5
          $mes = "※登録されました";
          $this->set('mes',$mes);

        } else {

          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);

        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

}
