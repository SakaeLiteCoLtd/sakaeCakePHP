<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
use App\myClass\Productcheck\htmlProductcheck;

class DenpyousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->Customers = TableRegistry::get('customers');
		 $this->Users = TableRegistry::get('users');
		 $this->Staffs = TableRegistry::get('staffs');
		 $this->SyoumouSuppliers = TableRegistry::get('syoumouSuppliers');
		 $this->AccountSyoumouElements = TableRegistry::get('accountSyoumouElements');
		 $this->OrderSyoumouShiireHeaders = TableRegistry::get('orderSyoumouShiireHeaders');
		 $this->OrderSyoumouShiireFooders = TableRegistry::get('orderSyoumouShiireFooders');
		}

			public function syoumoumenu()
	 	 {
			 $this->request->session()->destroy();// セッションの破棄
		 }

		 public function syoumoupreadd()
		{
			$Users = $this->Users->newEntity();
	    $this->set('Users',$Users);
		}

		public function syoumoulogin()
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
					return $this->redirect(['action' => 'syoumouform',//以下のデータを持ってsyoumouformに移動
					's' => ['username' => $username]]);
				}
			}
	 }

	 public function syoumouform()
	{
		$Users = $this->Users->newEntity();
		$this->set('Users',$Users);

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

		$arrHatyubusyo = [
			'0' => '営業',
			'1' => '製造'
						];
		$this->set('arrHatyubusyo',$arrHatyubusyo);

		$arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['delete_flag' => 0])->order(['furigana' => 'ASC']);
		$arrSyoumouSupplier = array();
  	 foreach ($arrSyoumouSuppliers as $value) {
  		 $arrSyoumouSupplier[] = array($value->id=>$value->name);
  	 }
  	 $this->set('arrSyoumouSupplier',$arrSyoumouSupplier);

		 $arrAccountSyoumouElements = $this->AccountSyoumouElements->find('all')->where(['delete_flag' => 0]);
		 $arrAccountSyoumouElement = array();
		 foreach ($arrAccountSyoumouElements as $value) {
			 $arrAccountSyoumouElement[] = array($value->id=>$value->element);
		 }
		 $this->set('arrAccountSyoumouElement',$arrAccountSyoumouElement);

		$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
		$this->set('data',$data);
/*
		echo "<pre>";
		print_r($username);
		echo "</pre>";
		echo "<pre>";
		print_r($Staff);
		echo "</pre>";
		echo "<pre>";
		print_r($Staffcode);
		echo "</pre>";
		echo "<pre>";
		print_r($Staffid);
		echo "</pre>";
*/
	}

	public function syoumouformtuika()
 {
	 $Users = $this->Users->newEntity();
	 $this->set('Users',$Users);

	 $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	 $this->set('data',$data);
	 $Staff = $data['Staff'];
	 $this->set('Staff',$Staff);
	 $Staffid = $data['Staffid'];
	 $this->set('Staffid',$Staffid);

	 $arrHatyubusyo = [
		 '0' => '営業',
		 '1' => '製造'
					 ];
	 $this->set('arrHatyubusyo',$arrHatyubusyo);

	 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['delete_flag' => 0])->order(['furigana' => 'ASC']);
	 $arrSyoumouSupplier = array();
	 foreach ($arrSyoumouSuppliers as $value) {
		 $arrSyoumouSupplier[] = array($value->id=>$value->name);
	 }
	 $this->set('arrSyoumouSupplier',$arrSyoumouSupplier);

	 $arrAccountSyoumouElements = $this->AccountSyoumouElements->find('all')->where(['delete_flag' => 0]);
	 $arrAccountSyoumouElement = array();
	 foreach ($arrAccountSyoumouElements as $value) {
		 $arrAccountSyoumouElement[] = array($value->id=>$value->element);
	 }
	 $this->set('arrAccountSyoumouElement',$arrAccountSyoumouElement);

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
		 return $this->redirect(['action' => 'syoumouconfirm',//以下のデータを持ってsyoumouconfirmに移動
		 's' => ['data' => $data]]);//登録するデータを全部配列に入れておく
	 }

 }

	public function syoumouconfirm()
 {
	 $Users = $this->Users->newEntity();
	 $this->set('Users',$Users);

	 $Data = $this->request->query('s');
	 $data = $Data['data'];//postデータ取得し、$dataと名前を付ける
/*
	 echo "<pre>";
	 print_r($data);
	 echo "</pre>";
*/
	 $this->set('data',$data);
	 $tuika = $data['num'];
	 $this->set('tuika',$tuika);
	 $Staff = $data['Staff'];
	 $this->set('Staff',$Staff);
	 $Staffid = $data['Staffid'];
	 $this->set('Staffid',$Staffid);

	 $fromorderid = $data['fromorderid'];
	 $this->set('fromorderid',$fromorderid);
	 if($fromorderid == 1){
		 $fromorderhyouji = '製造';
	 }else{
		 $fromorderhyouji = '営業';
	 }
	 $this->set('fromorderhyouji',$fromorderhyouji);

	 $num_order = $data['num_order'];
	 $this->set('num_order',$num_order);
	 $syoumousupplierid = $data['syoumousupplierid'];
	 $this->set('syoumousupplierid',$syoumousupplierid);
	 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
	 $syoumousupplierhyouji = $arrSyoumouSuppliers[0]->name;
	 $this->set('syoumousupplierhyouji',$syoumousupplierhyouji);

	 $date_order = $data['date_order']['year']."-".$data['date_order']['month']."-".$data['date_order']['day'];
	 $this->set('date_order',$date_order);

	 $totalprice = 0;
	 for($n=0; $n<=$tuika; $n++){
		 ${"elementsiwakeid".$n} = $data["elementsiwakeid{$n}"];
		 $this->set('elementsiwakeid'.$n,${"elementsiwakeid".$n});
		 $arrAccountSyoumouElements = $this->AccountSyoumouElements->find('all')->where(['id' => ${"elementsiwakeid".$n}])->toArray();
		 ${"elementhyouji".$n} = $arrAccountSyoumouElements[0]->element;
		 $this->set('elementhyouji'.$n,${"elementhyouji".$n});
		 ${"order_product_code".$n} = $data["order_product_code{$n}"];
		 $this->set('order_product_code'.$n,${"order_product_code".$n});
		 ${"order_product_name".$n} = $data["order_product_name{$n}"];
		 $this->set('order_product_name'.$n,${"order_product_name".$n});
		 ${"price".$n} = $data["price{$n}"];
		 $this->set('price'.$n,${"price".$n});
		 ${"amount".$n} = $data["amount{$n}"];
		 $this->set('amount'.$n,${"amount".$n});
		 ${"date_deliver".$n} = $data["date_deliver{$n}"]['year']."-".$data["date_deliver{$n}"]['month']."-".$data["date_deliver{$n}"]['day'];
		 $this->set('date_deliver'.$n,${"date_deliver".$n});

		 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
		 $tax_include = $arrSyoumouSuppliers[0]->tax_include;
		 if($tax_include == 1){
			 ${"price".$n} = $data["price{$n}"] * $data["amount{$n}"];
		 }else{
			 ${"price".$n} = $data["price{$n}"] * $data["amount{$n}"] * 1.1;
		 }
		 $totalprice = round($totalprice + ${"price".$n}, 2);//小数点以下2桁
	 }
	 $this->set('totalprice',$totalprice);

	 $arrKannou = [
		 '0' => '未納',
		 '1' => '完納'
					 ];
	 $this->set('arrKannou',$arrKannou);

	 session_start();

	 $_SESSION['tourokusyoumouheader'] = array(
		 'date_order' => $date_order,
		 'num_order' => $num_order,
		 'syoumou_supplier_id' => $syoumousupplierid,
		 'tax_include' => $tax_include,
		 'from_order' => $fromorderid,
		 "delete_flag" => 0,
		 'created_at' => date('Y-m-d H:i:s'),
		 'created_staff' => $Staffid
	 );

	 for($n=0; $n<=$tuika; $n++){
		 $_SESSION['tourokusyoumoufooder'][$n] = array(
			 'element_shiwake' => $data["elementsiwakeid{$n}"],
			 'order_product_code' => $data["order_product_code{$n}"],
			 'order_product_name' => $data["order_product_name{$n}"],
			 'price' => $data["price{$n}"],
			 'amount' => $data["amount{$n}"],
			 'date_deliver' => ${"date_deliver".$n},
			 "delete_flag" => 0,
			 "created_staff" => $Staffid
		 );
		}
/*
		echo "<pre>";
		print_r($_SESSION);
		echo "</pre>";
*/
 }

		 public function syoumoudo()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$session = $this->request->getSession();
			$sessiondata = $session->read();

			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$kannoucheck = 0;
			for($n=0; $n<=$data['num']; $n++){
				$kannoucheck = $kannoucheck + $data["kannou{$n}"];
			}

			if($kannoucheck == $data['num']+1){
				$kannoutouroku = 1;
				$sessiondata["tourokusyoumouheader"] = array_merge($sessiondata["tourokusyoumouheader"],array('check_kannou'=>date('Y-m-d')));
				$sessiondata["tourokusyoumouheader"] = array_merge($sessiondata["tourokusyoumouheader"],array('kannou'=>$kannoutouroku));
			}else{
				$kannoutouroku = 0;
				$sessiondata["tourokusyoumouheader"] = array_merge($sessiondata["tourokusyoumouheader"],array('kannou'=>$kannoutouroku));
			}

			for($n=0; $n<=$data['num']; $n++){
				$sessiondata["tourokusyoumoufooder"][$n] = array_merge($sessiondata["tourokusyoumoufooder"][$n],array('kannou'=>$data["kannou{$n}"]));
			}
/*
			echo "<pre>";
			print_r($sessiondata["tourokusyoumouheader"]);
			echo "</pre>";
			echo "<pre>";
			print_r($sessiondata["tourokusyoumoufooder"]);
			echo "</pre>";
*/
			$this->set('data',$data);
			$tuika = $data['num'];
			$this->set('tuika',$tuika);
			$Staff = $data['Staff'];
			$this->set('Staff',$Staff);
			$Staffid = $data['Staffid'];
			$this->set('Staffid',$Staffid);

			$fromorderid = $data['fromorderid'];
			$this->set('fromorderid',$fromorderid);
			if($fromorderid == 1){
				$fromorderhyouji = '製造';
			}else{
				$fromorderhyouji = '営業';
			}
			$this->set('fromorderhyouji',$fromorderhyouji);

			$num_order = $data['num_order'];
			$this->set('num_order',$num_order);
			$syoumousupplierid = $data['syoumousupplierid'];
			$this->set('syoumousupplierid',$syoumousupplierid);
			$arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
			$syoumousupplierhyouji = $arrSyoumouSuppliers[0]->name;
			$this->set('syoumousupplierhyouji',$syoumousupplierhyouji);

			$date_order = $data['date_order'];
			$this->set('date_order',$date_order);

			$totalprice = 0;
			for($n=0; $n<=$tuika; $n++){
				${"elementsiwakeid".$n} = $data["elementsiwakeid{$n}"];
				$this->set('elementsiwakeid'.$n,${"elementsiwakeid".$n});
				$arrAccountSyoumouElements = $this->AccountSyoumouElements->find('all')->where(['id' => ${"elementsiwakeid".$n}])->toArray();
				${"elementhyouji".$n} = $arrAccountSyoumouElements[0]->element;
				$this->set('elementhyouji'.$n,${"elementhyouji".$n});
				${"order_product_code".$n} = $data["order_product_code{$n}"];
				$this->set('order_product_code'.$n,${"order_product_code".$n});
				${"order_product_name".$n} = $data["order_product_name{$n}"];
				$this->set('order_product_name'.$n,${"order_product_name".$n});
				${"price".$n} = $data["price{$n}"];
				$this->set('price'.$n,${"price".$n});
				${"amount".$n} = $data["amount{$n}"];
				$this->set('amount'.$n,${"amount".$n});
				${"date_deliver".$n} = $data["date_deliver{$n}"];
				$this->set('date_deliver'.$n,${"date_deliver".$n});

				${"kannou".$n} = $data["kannou{$n}"];
				if(${"kannou".$n} == 1){
					${"kannouhyouji".$n} = '完納';
				}else{
					${"kannouhyouji".$n} = '未納';
				}
				$this->set('kannouhyouji'.$n,${"kannouhyouji".$n});

				$arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
				$tax_include = $arrSyoumouSuppliers[0]->tax_include;
				if($tax_include == 1){
					${"price".$n} = $data["price{$n}"] * $data["amount{$n}"];
				}else{
					${"price".$n} = $data["price{$n}"] * $data["amount{$n}"] * 1.1;
				}
				$totalprice = round($totalprice + ${"price".$n}, 2);//小数点以下2桁
			}
			$this->set('totalprice',$totalprice);

			if ($this->request->is('post')) {
				$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->patchEntity($this->OrderSyoumouShiireHeaders->newEntity(), $sessiondata["tourokusyoumouheader"]);
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->OrderSyoumouShiireHeaders->save($OrderSyoumouShiireHeaders)) {
/*
						//旧DBに製品登録
						$connection = ConnectionManager::get('DB_ikou_test');
						$table = TableRegistry::get('product');
						$table->setConnection($connection);

							$connection->insert('product', [
									'product_id' => $data['productdata']["product_code"],
									'product_name' => $data['productdata']["product_name"],
									'basic_weight' => $data['productdata']["weight"],
									'price' => $data['pricedata']["price"],
									'm_name' => $data['productdata']["material_kind"],
									'm_grade' => $data['productdata']["m_grade"],
									'col_num' => $data['productdata']["col_num"],
									'color' => $data['productdata']["color"],
									'cs_id' => $data['customerdata']["customer_code"],
									'gaityu' => 0,
									'genjyou' => 0
							]);

						$connection = ConnectionManager::get('default');//新DBに戻る
						$table->setConnection($connection);
*/
							//fooder登録
							for($n=0; $n<=$tuika; $n++){
								$OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders
								->patchEntity($this->OrderSyoumouShiireFooders->newEntity(), $sessiondata["tourokusyoumoufooder"][$n]);
								$this->OrderSyoumouShiireFooders->save($OrderSyoumouShiireFooders);
							}

/*
							//旧DBに単価登録
							$connection = ConnectionManager::get('DB_ikou_test');
							$table = TableRegistry::get('account_price_product');
							$table->setConnection($connection);

								$connection->insert('account_price_product', [
									'product_id' => $data['pricedata']["product_code"],
									'price' => $data['pricedata']["price"],
									'date_koushin' => $data['pricedata']["date_koushin"],
									'emp_id' => $data['pricedata']["created_staff"],
									'tourokubi' => $data['pricedata']["tourokubi"],
									'delete_flag' => 0,
									'created_at' => $data['pricedata']["created_at"]
								]);

							$connection = ConnectionManager::get('default');//新DBに戻る
							$table->setConnection($connection);
*/
						$mes = "※下記のように登録されました";
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

		public function shiiremenu()
		{
	 	}

	}
