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
		 $this->ProductSuppliers = TableRegistry::get('productSuppliers');
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
				$check_kannou = date('Y-m-d');
			}else{
				$kannoutouroku = 0;
				$sessiondata["tourokusyoumouheader"] = array_merge($sessiondata["tourokusyoumouheader"],array('kannou'=>$kannoutouroku));
				$check_kannou = null;
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

						//旧DBに登録
						$connection = ConnectionManager::get('DB_ikou_test');
						$table = TableRegistry::get('order_syoumou_shiire_header');
						$table->setConnection($connection);

						$connection->insert('order_syoumou_shiire_header', [
							'date_order' => $sessiondata["tourokusyoumouheader"]["date_order"],
							'num_order' => $sessiondata["tourokusyoumouheader"]["num_order"],
							'syoumou_supplier_id' => $sessiondata["tourokusyoumouheader"]["syoumou_supplier_id"],
							'tax_include' => $sessiondata["tourokusyoumouheader"]["tax_include"],
							'from_order_id' => $sessiondata["tourokusyoumouheader"]["from_order"],
							'kannou' => $sessiondata["tourokusyoumouheader"]["kannou"],
							'check_kannou' => $check_kannou,
							'delete_flag' => 0,
							'created_emp_id' => $sessiondata["tourokusyoumouheader"]["created_staff"],
							'created_at' => date('Y-m-d H:i:s')
						]);

						$connection = ConnectionManager::get('default');//新DBに戻る
						$table->setConnection($connection);

							//fooder登録
							$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find()
							->where(['date_order' => $sessiondata["tourokusyoumouheader"]["date_order"], 'num_order' => $sessiondata["tourokusyoumouheader"]["num_order"]])
							->order(["created_at"=>"DESC"])->toArray();
							$OrderSyoumouShiireHeaderId = $OrderSyoumouShiireHeaders[0]->id;
							$OrderSyoumouShiireHeaderKannou = $OrderSyoumouShiireHeaders[0]->kannou;

							for($n=0; $n<=$tuika; $n++){

								$sessiondata["tourokusyoumoufooder"][$n] = array_merge($sessiondata["tourokusyoumoufooder"][$n],array('order_syoumou_shiire_header_id'=>$OrderSyoumouShiireHeaderId));

								if($OrderSyoumouShiireHeaderKannou == 1){
									$sessiondata["tourokusyoumoufooder"][$n] = array_merge($sessiondata["tourokusyoumoufooder"][$n],array('real_date_deliver'=>$sessiondata["tourokusyoumoufooder"][$n]["date_deliver"]));
								}

								$OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders
								->patchEntity($this->OrderSyoumouShiireFooders->newEntity(), $sessiondata["tourokusyoumoufooder"][$n]);
								$this->OrderSyoumouShiireFooders->save($OrderSyoumouShiireFooders);

								//旧DBに登録
								$connection = ConnectionManager::get('DB_ikou_test');
								$table = TableRegistry::get('order_syoumou_shiire_header');
								$table->setConnection($connection);

								$sql = "SELECT id FROM order_syoumou_shiire_header".
				              " where date_order ='".$sessiondata["tourokusyoumouheader"]["date_order"]."' and num_order = '".$sessiondata["tourokusyoumouheader"]["num_order"].
											"' and kannou = '".$sessiondata["tourokusyoumouheader"]["kannou"]."' order by id desc";
				        $connection = ConnectionManager::get('DB_ikou_test');
				        $order_syoumou_shiire_header = $connection->execute($sql)->fetchAll('assoc');
								$order_syoumou_shiire_header_id = $order_syoumou_shiire_header[0]['id'];

								$connection->insert('order_syoumou_shiire_fooder', [
									'order_syoumou_shiire_header_id' => $order_syoumou_shiire_header_id,
									'element_shiwake_id' => $sessiondata["tourokusyoumoufooder"][$n]["element_shiwake"],
									'order_product_id' => $sessiondata["tourokusyoumoufooder"][$n]["order_product_code"],
									'order_product_name' => $sessiondata["tourokusyoumoufooder"][$n]["order_product_name"],
									'price' => $sessiondata["tourokusyoumoufooder"][$n]["price"],
									'amount' => $sessiondata["tourokusyoumoufooder"][$n]["amount"],
									'date_deliver' => $sessiondata["tourokusyoumoufooder"][$n]["date_deliver"],
									'price' => $sessiondata["tourokusyoumoufooder"][$n]["price"],
									'kannou' => $sessiondata["tourokusyoumoufooder"][$n]["kannou"],
									'delete_flag' => 0
								]);

								$connection = ConnectionManager::get('default');//新DBに戻る
								$table->setConnection($connection);

							}

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

		public function syoumouitiranform()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['delete_flag' => 0])->order(['furigana' => 'ASC']);
			$arrSyoumouSupplier = array();
			foreach ($arrSyoumouSuppliers as $value) {
  	 		 $arrSyoumouSupplier[] = array($value->id=>$value->name);
  	 	 }
			 $this->set('arrSyoumouSupplier',$arrSyoumouSupplier);

	 	}

		public function syoumouitiran()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			if(isset($data["minyuuka"])){

				$arrOrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['delete_flag' => 0, 'kannou' => 0])->order(['date_deliver' => 'ASC'])->toArray();
				$arrOrderSyoumouShiireFooder = array();
				for($n=0; $n<count($arrOrderSyoumouShiireFooders); $n++){
					$order_syoumou_shiire_header_id = $arrOrderSyoumouShiireFooders[$n]->order_syoumou_shiire_header_id;

					$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find('all')->where(['id' => $order_syoumou_shiire_header_id])->order(['date_order' => 'ASC'])->toArray();
					$num_order = $OrderSyoumouShiireHeaders[0]->num_order;
					$syoumou_supplier_id = $OrderSyoumouShiireHeaders[0]->syoumou_supplier_id;

					$arrOrderSyoumouShiireFooder[] = [
						'id' => $arrOrderSyoumouShiireFooders[$n]->id,
						'order_syoumou_shiire_header_id' => $order_syoumou_shiire_header_id,
						'num_order' => $num_order,
						'syoumou_supplier_id' => $syoumou_supplier_id,
						'order_product_name' => $arrOrderSyoumouShiireFooders[$n]->order_product_name,
						'element_shiwake' => $arrOrderSyoumouShiireFooders[$n]->element_shiwake,
						'date_deliver' => $arrOrderSyoumouShiireFooders[$n]->date_deliver->format('Y-m-d'),
						'price' => round($arrOrderSyoumouShiireFooders[$n]->price, 2),
						'amount' => $arrOrderSyoumouShiireFooders[$n]->element_shiwake,
						'kannou' => $arrOrderSyoumouShiireFooders[$n]->kannou
				 ];
			 }
			 $this->set('arrOrderSyoumouShiireFooder',$arrOrderSyoumouShiireFooder);

			}else{

				$date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
	      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

				if(empty($data['syoumousupplierid'])){

					$arrOrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['date_deliver >=' => $date_sta, 'date_deliver <' => $date_fin, 'delete_flag' => 0])->order(['date_deliver' => 'ASC'])->toArray();

				}else{

					$arrOrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find()->contain(["OrderSyoumouShiireHeaders"])
					->where(['date_deliver >=' => $date_sta, 'date_deliver <' => $date_fin, 'syoumou_supplier_id' => $data['syoumousupplierid']])->toArray();

				}

				$arrOrderSyoumouShiireFooder = array();
				for($n=0; $n<count($arrOrderSyoumouShiireFooders); $n++){
					$order_syoumou_shiire_header_id = $arrOrderSyoumouShiireFooders[$n]->order_syoumou_shiire_header_id;

					$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find('all')->where(['id' => $order_syoumou_shiire_header_id])->order(['date_order' => 'ASC'])->toArray();
					$num_order = $OrderSyoumouShiireHeaders[0]->num_order;
					$syoumou_supplier_id = $OrderSyoumouShiireHeaders[0]->syoumou_supplier_id;

					$arrOrderSyoumouShiireFooder[] = [
						'id' => $arrOrderSyoumouShiireFooders[$n]->id,
						'order_syoumou_shiire_header_id' => $order_syoumou_shiire_header_id,
						'num_order' => $num_order,
						'syoumou_supplier_id' => $syoumou_supplier_id,
						'order_product_name' => $arrOrderSyoumouShiireFooders[$n]->order_product_name,
						'element_shiwake' => $arrOrderSyoumouShiireFooders[$n]->element_shiwake,
						'date_deliver' => $arrOrderSyoumouShiireFooders[$n]->date_deliver->format('Y-m-d'),
						'price' => round($arrOrderSyoumouShiireFooders[$n]->price, 2),
						'amount' => $arrOrderSyoumouShiireFooders[$n]->element_shiwake,
						'kannou' => $arrOrderSyoumouShiireFooders[$n]->kannou
				 ];
			 }
			 $this->set('arrOrderSyoumouShiireFooder',$arrOrderSyoumouShiireFooder);

			}

	 	}

		public function syoumousyuuseiview()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$data = $this->request->getData();
			$data = array_keys($data, '表示');
			$order_syoumou_shiire_header_id = $data[0];
			$this->set('order_syoumou_shiire_header_id',$order_syoumou_shiire_header_id);
/*
			echo "<pre>";
			print_r($order_syoumou_shiire_header_id);
			echo "</pre>";
*/
			$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find('all')->where(['id' => $order_syoumou_shiire_header_id])->order(['date_order' => 'ASC'])->toArray();
			$created_staff = $OrderSyoumouShiireHeaders[0]->created_staff;

			$Staffs = $this->Staffs->find('all')->where(['id' => $created_staff])->toArray();
			if(isset($Staffs[0])){
				$staff = $Staffs[0]->f_name." ".$Staffs[0]->l_name;
				$Staffid = $Staffs[0]->id;
			}else{
				$Staffs = $this->Staffs->find('all')->where(['staff_code' => $created_staff])->toArray();
				if(isset($Staffs[0])){
					$staff = $Staffs[0]->f_name." ".$Staffs[0]->l_name;
					$Staffid = $Staffs[0]->id;
				}else{
					$staff = "";
					$Staffid = "";
				}
			}
			$Staff = $staff;
			$this->set('Staff',$Staff);
			$this->set('Staffid',$Staffid);

			$date_order = $OrderSyoumouShiireHeaders[0]->date_order->format('Y-m-d');
			$this->set('date_order',$date_order);

			$fromorderid = $OrderSyoumouShiireHeaders[0]->from_order;
			$this->set('fromorderid',$fromorderid);
			if($fromorderid == 1){
  	 		 $fromorderhyouji = '製造';
  	 	 }else{
  	 		 $fromorderhyouji = '営業';
			 }
			 $this->set('fromorderhyouji',$fromorderhyouji);

			 $num_order = $OrderSyoumouShiireHeaders[0]->num_order;
			 $this->set('num_order',$num_order);

			 $syoumousupplierid = $OrderSyoumouShiireHeaders[0]->syoumou_supplier_id;
			 $this->set('syoumousupplierid',$syoumousupplierid);
			 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
			 $syoumousupplierhyouji = $arrSyoumouSuppliers[0]->name;
			 $this->set('syoumousupplierhyouji',$syoumousupplierhyouji);

			 $OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['order_syoumou_shiire_header_id' => $order_syoumou_shiire_header_id])->order(['id' => 'ASC'])->toArray();
			 $tuika = count($OrderSyoumouShiireFooders) - 1;
			 $this->set('tuika',$tuika);

			 $totalprice = 0;
			 for($n=0; $n<count($OrderSyoumouShiireFooders); $n++){
				 ${"elementsiwakeid".$n} = $OrderSyoumouShiireFooders[$n]["element_shiwake"];
				 $this->set('elementsiwakeid'.$n,${"elementsiwakeid".$n});
				 $arrAccountSyoumouElements = $this->AccountSyoumouElements->find('all')->where(['id' => ${"elementsiwakeid".$n}])->toArray();
				 ${"elementhyouji".$n} = $arrAccountSyoumouElements[0]->element;
				 $this->set('elementhyouji'.$n,${"elementhyouji".$n});
				 ${"order_product_code".$n} = $OrderSyoumouShiireFooders[$n]["order_product_code"];
				 $this->set('order_product_code'.$n,${"order_product_code".$n});
				 ${"order_product_name".$n} = $OrderSyoumouShiireFooders[$n]["order_product_name"];
				 $this->set('order_product_name'.$n,${"order_product_name".$n});
				 ${"price".$n} = $OrderSyoumouShiireFooders[$n]["price"];
				 $this->set('price'.$n,${"price".$n});
				 ${"amount".$n} = $OrderSyoumouShiireFooders[$n]["amount"];
				 $this->set('amount'.$n,${"amount".$n});
				 ${"date_deliver".$n} = $OrderSyoumouShiireFooders[$n]["date_deliver"]->format('Y-m-d');
				 $this->set('date_deliver'.$n,${"date_deliver".$n});

				 if($OrderSyoumouShiireFooders[$n]["kannou"] == 1){
					 ${"kannouhyouji".$n} = "完納";
				 }else{
					 ${"kannouhyouji".$n} = "未納";
				 }
				 $this->set('kannouhyouji'.$n,${"kannouhyouji".$n});

				 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
				 $tax_include = $arrSyoumouSuppliers[0]->tax_include;
				 if($tax_include == 1){
					 ${"price".$n} = $OrderSyoumouShiireFooders[$n]["price"] * $OrderSyoumouShiireFooders[$n]["amount"];
				 }else{
					 ${"price".$n} = $OrderSyoumouShiireFooders[$n]["price"] * $OrderSyoumouShiireFooders[$n]["amount"] * 1.1;
				 }
				 $totalprice = round($totalprice + ${"price".$n}, 2);//小数点以下2桁
			 }
			 $this->set('totalprice',$totalprice);
/*
			echo "<pre>";
			print_r($staff);
			echo "</pre>";
*/
	 	}

		public function syoumousyuuseipreadd()
		{
			$this->request->session()->destroy();// セッションの破棄

			$data = $this->request->getData();

			session_start();

			$_SESSION['order_syoumou_shiire_header_id'] = array(
				'id' => $data["order_syoumou_shiire_header_id"]
			);

			$Users = $this->Users->newEntity();
	    $this->set('Users',$Users);
	 	}

		public function syoumousyuuseilogin()
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
 					return $this->redirect(['action' => 'syoumousyuuseiform',
 					's' => ['username' => $username]]);
 				}
 			}
	 	}

		public function syoumousyuuseiform()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$session = $this->request->getSession();
			$sessiondata = $session->read();

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

			 $OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find('all')->where(['id' => $sessiondata["order_syoumou_shiire_header_id"]["id"]])->order(['date_order' => 'ASC'])->toArray();

			 $OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['order_syoumou_shiire_header_id' => $sessiondata["order_syoumou_shiire_header_id"]["id"]])->order(['id' => 'ASC'])->toArray();
			 $tuika = count($OrderSyoumouShiireFooders) - 1;
			 $this->set('tuika',$tuika);

			 $date_order = $OrderSyoumouShiireHeaders[0]->date_order->format('Y-m-d');
 			$this->set('date_order',$date_order);

 			$fromorderid = $OrderSyoumouShiireHeaders[0]->from_order;
 			$this->set('fromorderid',$fromorderid);
 			if($fromorderid == 1){
   	 		 $fromorderhyouji = '製造';
   	 	 }else{
   	 		 $fromorderhyouji = '営業';
 			 }
 			 $this->set('fromorderhyouji',$fromorderhyouji);

 			 $num_order = $OrderSyoumouShiireHeaders[0]->num_order;
 			 $this->set('num_order',$num_order);

 			 $syoumousupplierid = $OrderSyoumouShiireHeaders[0]->syoumou_supplier_id;
 			 $this->set('syoumousupplierid',$syoumousupplierid);
 			 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
 			 $syoumousupplierhyouji = $arrSyoumouSuppliers[0]->name;
 			 $this->set('syoumousupplierhyouji',$syoumousupplierhyouji);

 			 $OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['order_syoumou_shiire_header_id' => $sessiondata["order_syoumou_shiire_header_id"]["id"]])->order(['id' => 'ASC'])->toArray();
 			 $tuika = count($OrderSyoumouShiireFooders) - 1;
 			 $this->set('tuika',$tuika);

 			 $totalprice = 0;
 			 for($n=0; $n<count($OrderSyoumouShiireFooders); $n++){
				 ${"fooderid".$n} = $OrderSyoumouShiireFooders[$n]["id"];
 				 $this->set('fooderid'.$n,${"fooderid".$n});
				 ${"elementsiwakeid".$n} = $OrderSyoumouShiireFooders[$n]["element_shiwake"];
 				 $this->set('elementsiwakeid'.$n,${"elementsiwakeid".$n});
 				 $arrAccountSyoumouElements = $this->AccountSyoumouElements->find('all')->where(['id' => ${"elementsiwakeid".$n}])->toArray();
 				 ${"elementhyouji".$n} = $arrAccountSyoumouElements[0]->element;
 				 $this->set('elementhyouji'.$n,${"elementhyouji".$n});
 				 ${"order_product_code".$n} = $OrderSyoumouShiireFooders[$n]["order_product_code"];
 				 $this->set('order_product_code'.$n,${"order_product_code".$n});
 				 ${"order_product_name".$n} = $OrderSyoumouShiireFooders[$n]["order_product_name"];
 				 $this->set('order_product_name'.$n,${"order_product_name".$n});
 				 ${"price".$n} = $OrderSyoumouShiireFooders[$n]["price"];
 				 $this->set('price'.$n,${"price".$n});
 				 ${"amount".$n} = $OrderSyoumouShiireFooders[$n]["amount"];
 				 $this->set('amount'.$n,${"amount".$n});
 				 ${"date_deliver".$n} = $OrderSyoumouShiireFooders[$n]["date_deliver"]->format('Y-m-d');
 				 $this->set('date_deliver'.$n,${"date_deliver".$n});

 				 if($OrderSyoumouShiireFooders[$n]["kannou"] == 1){
 					 ${"kannouhyouji".$n} = "完納";
 				 }else{
 					 ${"kannouhyouji".$n} = "未納";
 				 }
 				 $this->set('kannouhyouji'.$n,${"kannouhyouji".$n});

 				 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
 				 $tax_include = $arrSyoumouSuppliers[0]->tax_include;
 				 if($tax_include == 1){
 					 ${"price".$n} = $OrderSyoumouShiireFooders[$n]["price"] * $OrderSyoumouShiireFooders[$n]["amount"];
 				 }else{
 					 ${"price".$n} = $OrderSyoumouShiireFooders[$n]["price"] * $OrderSyoumouShiireFooders[$n]["amount"] * 1.1;
 				 }
 				 $totalprice = round($totalprice + ${"price".$n}, 2);//小数点以下2桁
 			 }
 			 $this->set('totalprice',$totalprice);

	 	}

		public function syoumousyuuseiconfirm()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$session = $this->request->getSession();
			$sessiondata = $session->read();

			$data = $this->request->getData();

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

		 $arrKannou = [
			 '0' => '未納',
			 '1' => '完納'
						 ];
		 $this->set('arrKannou',$arrKannou);

 		 $num_order = $data['num_order'];
 		 $this->set('num_order',$num_order);
 		 $syoumousupplierid = $data['syoumousupplierid'];
 		 $this->set('syoumousupplierid',$syoumousupplierid);
 		 $arrSyoumouSuppliers = $this->SyoumouSuppliers->find('all')->where(['id' => $syoumousupplierid])->toArray();
 		 $syoumousupplierhyouji = $arrSyoumouSuppliers[0]->name;
 		 $this->set('syoumousupplierhyouji',$syoumousupplierhyouji);

 		 $date_order = $data['date_order']['year']."-".$data['date_order']['month']."-".$data['date_order']['day'];
 		 $this->set('date_order',$date_order);

		 $OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['order_syoumou_shiire_header_id' => $sessiondata["order_syoumou_shiire_header_id"]["id"]])->order(['id' => 'ASC'])->toArray();

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

			 ${"kannou".$n} = $OrderSyoumouShiireFooders[$n]["kannou"];
			 $this->set('kannou'.$n,${"kannou".$n});

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

 		 $_SESSION['tourokusyoumouheadersyuusei'] = array(
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
 			 $_SESSION['tourokusyoumoufoodersyuusei'][$n] = array(
				 'fooderid' => $data["fooderid{$n}"],
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

	 	}

		public function syoumousyuuseido()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);

			$session = $this->request->getSession();
			$sessiondata = $session->read();

			$data = $this->request->getData();

			$kannoucheck = 0;
			for($n=0; $n<=$data['num']; $n++){
				$kannoucheck = $kannoucheck + $data["kannou{$n}"];
			}

			if($kannoucheck == $data['num']+1){
				$kannoutouroku = 1;
				$sessiondata["tourokusyoumouheadersyuusei"] = array_merge($sessiondata["tourokusyoumouheadersyuusei"],array('check_kannou'=>date('Y-m-d')));
				$sessiondata["tourokusyoumouheadersyuusei"] = array_merge($sessiondata["tourokusyoumouheadersyuusei"],array('kannou'=>$kannoutouroku));
				$check_kannou = date('Y-m-d');
			}else{
				$kannoutouroku = 0;
				$sessiondata["tourokusyoumouheadersyuusei"] = array_merge($sessiondata["tourokusyoumouheadersyuusei"],array('kannou'=>$kannoutouroku));
				$check_kannou = null;
			}

			for($n=0; $n<=$data['num']; $n++){
				$sessiondata["tourokusyoumoufoodersyuusei"][$n] = array_merge($sessiondata["tourokusyoumoufoodersyuusei"][$n],array('kannou'=>$data["kannou{$n}"]));
			}

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
/*
			echo "<pre>";
			print_r($sessiondata);
			echo "</pre>";
*/
			$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->find('all')->where(['id' => $sessiondata["order_syoumou_shiire_header_id"]["id"]])->toArray();
			$moto_date_order = $OrderSyoumouShiireHeaders[0]->date_order;
			$moto_num_order = $OrderSyoumouShiireHeaders[0]->num_order;
			$moto_from_order = $OrderSyoumouShiireHeaders[0]->from_order;
			$moto_kannou = $OrderSyoumouShiireHeaders[0]->kannou;

			if ($this->request->is('post')) {
				$OrderSyoumouShiireHeaders = $this->OrderSyoumouShiireHeaders->patchEntity($this->OrderSyoumouShiireHeaders->newEntity(), $sessiondata['tourokusyoumouheadersyuusei']);
				$connection = ConnectionManager::get('default');//トランザクション1
				 // トランザクション開始2
				 $connection->begin();//トランザクション3
				 try {//トランザクション4
					 if ($this->OrderSyoumouShiireHeaders->updateAll(
						 ['date_order' => $sessiondata['tourokusyoumouheadersyuusei']['date_order'], 'num_order' => $sessiondata['tourokusyoumouheadersyuusei']['num_order'],
							'syoumou_supplier_id' => $sessiondata['tourokusyoumouheadersyuusei']['syoumou_supplier_id'], 'tax_include' => $sessiondata['tourokusyoumouheadersyuusei']['tax_include'],
							'from_order' => $sessiondata['tourokusyoumouheadersyuusei']['from_order'], 'kannou' => $kannoutouroku, 'check_kannou' => $check_kannou,
							'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessiondata['tourokusyoumouheadersyuusei']['created_staff']],
						 ['id'  => $sessiondata['order_syoumou_shiire_header_id']['id']]
					 )){

						 //旧DBに単価登録
						 $connection = ConnectionManager::get('DB_ikou_test');
						 $table = TableRegistry::get('order_syoumou_shiire_header');
						 $table->setConnection($connection);

						 if($check_kannou != null){//$check_kannouがnullでないとき

							 $updater = "UPDATE order_syoumou_shiire_header set date_order ='".$sessiondata['tourokusyoumouheadersyuusei']['date_order']."' , num_order ='".$sessiondata['tourokusyoumouheadersyuusei']['num_order']."' ,
							  syoumou_supplier_id ='".$sessiondata['tourokusyoumouheadersyuusei']['syoumou_supplier_id']."' ,tax_include ='".$sessiondata['tourokusyoumouheadersyuusei']['tax_include']."' ,kannou ='".$kannoutouroku."' ,
								check_kannou ='".$check_kannou."' ,updated_emp_id ='".$sessiondata['tourokusyoumouheadersyuusei']['created_staff']."' ,updated_at ='".date('Y-m-d H:i:s')."' ,
								from_order_id ='".$sessiondata['tourokusyoumouheadersyuusei']['from_order']."'
							 where date_order ='".$moto_date_order."' and num_order ='".$moto_num_order."' and from_order_id ='".$moto_from_order."' and kannou ='".$moto_kannou."'";
							 $connection->execute($updater);

						 }else{//$check_kannouがnullのとき

							 $updater = "UPDATE order_syoumou_shiire_header set date_order ='".$sessiondata['tourokusyoumouheadersyuusei']['date_order']."' , num_order ='".$sessiondata['tourokusyoumouheadersyuusei']['num_order']."' ,
							  syoumou_supplier_id ='".$sessiondata['tourokusyoumouheadersyuusei']['syoumou_supplier_id']."' ,tax_include ='".$sessiondata['tourokusyoumouheadersyuusei']['tax_include']."' ,kannou ='".$kannoutouroku."' ,
								updated_emp_id ='".$sessiondata['tourokusyoumouheadersyuusei']['created_staff']."' ,updated_at ='".date('Y-m-d H:i:s')."' ,
								from_order_id ='".$sessiondata['tourokusyoumouheadersyuusei']['from_order']."'
							 where date_order ='".$moto_date_order."' and num_order ='".$moto_num_order."' and from_order_id ='".$moto_from_order."' and kannou ='".$moto_kannou."'";
							 $connection->execute($updater);

						 }

						 $connection = ConnectionManager::get('default');//新DBに戻る
						 $table->setConnection($connection);

						 //fooder更新
						 for($n=0; $n<=$tuika; $n++){

							 $OrderSyoumouShiireFooders = $this->OrderSyoumouShiireFooders->find('all')->where(['id' => $sessiondata["tourokusyoumoufoodersyuusei"][$n]["fooderid"]])->toArray();
							 $moto_order_product_code = $OrderSyoumouShiireFooders[0]->order_product_code;
							 $moto_amount = $OrderSyoumouShiireFooders[0]->amount;
							 $moto_date_deliver = $OrderSyoumouShiireFooders[0]->date_deliver;
							 $moto_kannou = $OrderSyoumouShiireFooders[0]->kannou;

							 if($kannoutouroku == 1){
								 $real_date_deliver = $sessiondata["tourokusyoumoufoodersyuusei"][$n]["date_deliver"];
							 }else{
								 $real_date_deliver = null;
							 }

							 $this->OrderSyoumouShiireFooders->updateAll(
               ['element_shiwake' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['element_shiwake'], 'order_product_code' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['order_product_code'],
							 'order_product_name' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['order_product_name'], 'price' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['price'],
							 'amount' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['amount'], 'date_deliver' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['date_deliver'],
							 'real_date_deliver' => $real_date_deliver, 'kannou' => $sessiondata['tourokusyoumoufoodersyuusei'][$n]['kannou'],
							 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $sessiondata['tourokusyoumouheadersyuusei']['created_staff']],
               ['id'   => $sessiondata["tourokusyoumoufoodersyuusei"][$n]["fooderid"]]
               );

							 //旧DBに登録
							 $connection = ConnectionManager::get('DB_ikou_test');
							 $table = TableRegistry::get('order_syoumou_shiire_fooder');
							 $table->setConnection($connection);

							 if($kannoutouroku == 1){//real_date_deliverも更新

								 $real_date_deliver = $sessiondata["tourokusyoumoufoodersyuusei"][$n]["date_deliver"];
								 $updater = "UPDATE order_syoumou_shiire_fooder set element_shiwake_id ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['element_shiwake']."' , order_product_id ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['order_product_code']."' ,
								  order_product_name ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['order_product_name']."' ,price ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['price']."' ,amount ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['amount']."' ,
									date_deliver ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['date_deliver']."' ,real_date_deliver ='".$real_date_deliver."' ,kannou ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['kannou']."' ,
									updated_emp_id ='".$sessiondata['tourokusyoumouheadersyuusei']['created_staff']."' ,updated_at ='".date('Y-m-d')."'
									where order_product_id ='".$moto_order_product_code."' and amount ='".$moto_amount."' and date_deliver ='".$moto_date_deliver."' and kannou ='".$moto_kannou."'";
									$connection->execute($updater);

							 }else{//real_date_deliverは更新しない

								 $updater = "UPDATE order_syoumou_shiire_fooder set element_shiwake_id ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['element_shiwake']."' , order_product_id ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['order_product_code']."' ,
								  order_product_name ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['order_product_name']."' ,price ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['price']."' ,amount ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['amount']."' ,
									date_deliver ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['date_deliver']."', kannou ='".$sessiondata['tourokusyoumoufoodersyuusei'][$n]['kannou']."' ,
									updated_emp_id ='".$sessiondata['tourokusyoumouheadersyuusei']['created_staff']."', updated_at ='".date('Y-m-d')."'
									where order_product_id ='".$moto_order_product_code."' and amount ='".$moto_amount."' and date_deliver ='".$moto_date_deliver."' and kannou ='".$moto_kannou."'";
									$connection->execute($updater);

							 }

							 $connection = ConnectionManager::get('default');//新DBに戻る
							 $table->setConnection($connection);

						 }

						 $mes = "※下記のように更新されました";
						 $this->set('mes',$mes);
						 $connection->commit();// コミット5

					 } else {

						 $mes = "※更新されませんでした";
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

		public function shiirepreadd()
		{
			$Users = $this->Users->newEntity();
			$this->set('Users',$Users);
	 	}

		public function shiirelogin()
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
 					return $this->redirect(['action' => 'shiireform',//以下のデータを持ってshiireformに移動
 					's' => ['username' => $username]]);
 				}
 			}
	 	}

		public function shiireform()
		{
			//仕入業者
			//ProductSuppliers

			//仕入項目
			//$data[]=array("0"=>"","kanagatashinsaku"=>"金型新作","kanagatakaizou"=>"金型改造","kanagatasyuri"=>"金型修理","shisaku"=>"試作",
			//"zumen"=>"図面","sonota"=>"その他");

			//$order_name =$order_name."(".$element.")";

			//from_order,check_kannouは使わない

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

			$arrProductSuppliers = $this->ProductSuppliers->find('all')->where(['delete_flag' => 0])->order(['id' => 'ASC']);
			$arrProductSupplier = array();
	  	 foreach ($arrProductSuppliers as $value) {
	  		 $arrProductSupplier[] = array($value->id=>$value->name);
	  	 }
	  	 $this->set('arrProductSupplier',$arrProductSupplier);

			$arrElement = [
				"kanagatashinsaku"=>"金型新作","kanagatakaizou"=>"金型改造","kanagatasyuri"=>"金型修理","shisaku"=>"試作","zumen"=>"図面","sonota"=>"その他"
			];
	 	 $this->set('arrElement',$arrElement);

	 	}

		public function shiireconfirm()
		{
			$data = $this->request->getData();

			echo "<pre>";
			print_r($data);
			echo "</pre>";

	 	}

		public function shiiredo()
		{

	 	}

		public function shiireitiranform()
		{

	 	}

		public function shiireitiran()
		{

	 	}

		public function shiiresyuuseipreadd()
		{

	 	}

		public function shiiresyuuseilogin()
		{

	 	}

		public function shiiresyuuseiform()
		{

	 	}

		public function shiiresyuuseiconfirm()
		{

	 	}

		public function shiiresyuuseido()
		{

	 	}

	}
