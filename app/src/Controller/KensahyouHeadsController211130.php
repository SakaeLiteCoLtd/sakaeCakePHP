<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//他のテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;

use App\myClass\Sessioncheck\htmlSessioncheck;//myClassフォルダに配置したクラスを使用

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 *
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KensahyouHeadsController  extends AppController
{
     public function initialize()
     {
       parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->Users = TableRegistry::get('users');//Usersテーブルを使う
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->Customers = TableRegistry::get('customers');
       $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//productsテーブルを使う
     }

     public function yobidashicustomer()//「出荷検査用呼出」ページトップ
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Data=$this->request->query('s');
       if(isset($Data["mess"])){
         $mess = $Data["mess"];
         $this->set('mess',$mess);
       }else{
         $mess = "";
         $this->set('mess',$mess);
       }

     }

     public function yobidashipana()
     {
       $this->set('products', $this->Products->find()
      	->select(['product_code','delete_flag' => '0'])
      	);
     }

     public function yobidashipanap0()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

        $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if((0 === strpos($product_code, "P0")) && ($customer_id == 1)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
/*
        echo "<pre>";
        print_r($arrProduct);
        echo "</pre>";
*/
     }

     public function yobidashipanap1()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if((0 === strpos($product_code, "P1")) && ($customer_id == 1)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanap2()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if(0 !== strpos($product_code, "P0") && 0 !== strpos($product_code, "P1") && 0 !== strpos($product_code, "W") && 0 !== strpos($product_code, "H") && 0 !== strpos($product_code, "RE") && ($customer_id == 1)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanaw()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if((0 === strpos($product_code, "W")) && ($customer_id == 2)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanah()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if((0 === strpos($product_code, "H")) && ($customer_id == 2)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanare()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if((0 === strpos($product_code, "R")) && ($customer_id == 3)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashidnp()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          if(($customer_id == 11) || ($customer_id == 12) || ($customer_id == 13) || ($customer_id == 14)){
              $arrProduct[] = ["product_code" => $product_code, "product_name" => $Products[$k]["product_name"]];
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashiothers()
     {
       $KensahyouHeads = $this->KensahyouHeads->newEntity();
       $this->set('KensahyouHeads',$KensahyouHeads);

       $Products = $this->Products->find()->where(['delete_flag' => 0])->order(['product_code' => 'ASC'])->toArray();

        $count = count($Products);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Products[$k]["product_code"];
          $customer_id = $Products[$k]["customer_id"];
          $Customers = $this->Customers->find('all', ['conditions' => ['id' => $customer_id]])->toArray();
          if(isset($Customers[0])){
            $customer_code = $Customers[0]->customer_code;
            if(0 !== strpos($customer_code, "1") && 0 !== strpos($customer_code, "2")){
              $arrProduct[] = ["product_code" => $Products[$k]["product_code"], "product_name" => $Products[$k]["product_name"]];
            }
          }
        }

        $this->set('arrProduct',$arrProduct);
     }

    public function version()//新規登録画面またはバージョン画面
    {
      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
    	$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

      $this->set('Productcode',$product_code);//セット
      $this->set('product_code',$product_code);//セット

    	$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・・・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

    	$KensaProduct = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
    	$this->set('KensaProduct',$KensaProduct);//セット

    	$Productn = $this->Products->find()->where(['product_code' => $product_code])->toArray();//
    	$Productname = $Productn[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	$this->set('kensahyouHeads',$this->KensahyouHeads->find()//KensahyouHeadsテーブルから
    		->where(['delete_flag' => '0','product_code' => $product_code]));//'delete_flag' => '0'、'product_id' => $product_idを満たすデータをkensahyouHeadsにセット

        $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
  			$this->set('arrType',$arrType);

    }

     public function confirm()
    {
      $data = $this->request->getData();//postで送られた全データを取得

    	$product_code = $data['product_code'];//product_idという名前のデータに$product_idと名前を付ける
    	$this->set('product_code',$product_code);//セット

    	$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

    	$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
    	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
    	$this->set('Productcode',$Productcode);//セット

    	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

      if($data['type_im'] == 0){
        $type_im = "IM6120(1号機)";
      }else{
        $type_im = "IM7000(2号機)";
      }
      $this->set('type_im',$type_im);

    }

    public function preadd()
    {
      $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }
    }

   public function login()
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

       $userdata = $data['username'];

       if(isset($data['prelogin'])){

         $htmllogin = new htmlLogin();
         $qrcheck = $htmllogin->qrcheckprogram($userdata);

         if($qrcheck > 0){
           return $this->redirect(['action' => 'preadd',
           's' => ['mess' => "QRコードを読み込んでください。"]]);
         }

       }

       $htmllogin = new htmlLogin();
       $arraylogindate = $htmllogin->htmlloginprogram($userdata);

       $username = $arraylogindate[0];
       $delete_flag = $arraylogindate[1];
       $this->set('username',$username);
       $this->set('delete_flag',$delete_flag);

       $user = $this->Auth->identify();//$delete_flag = 0だとログインできない

       if ($user) {
         $this->Auth->setUser($user);
         return $this->redirect(['action' => 'do']);
       }
     }
   }

   public function logout()
   {
  //   $this->request->session()->destroy(); // セッションの破棄
   }

     public function do()
    {
      $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

      $session_names = "sokuteidata,Auth";//データ登録に必要なセッションの名前をカンマでつなぐ
      $htmlSessioncheck = new htmlSessioncheck();
      $arr_session_flag = $htmlSessioncheck->check($session_names);
      if($arr_session_flag["num"] > 1){//セッション切れの場合
        return $this->redirect(['action' => 'yobidashicustomer',
        's' => ['mess' => $arr_session_flag["mess"]]]);
      }

      $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
      $_SESSION['sokuteidata'] = array_merge($created_staff,$_SESSION['sokuteidata']);

      $data = $_SESSION['sokuteidata'];

      if($data['type_im'] == 0){
        $type_im = "IM6120(1号機)";
      }else{
        $type_im = "IM7000(2号機)";
      }
      $this->set('type_im',$type_im);

      for($i=1; $i<=9; $i++){
        if(strlen($data["size_".$i]) < 1){
          $data["size_".$i] = null;
        }
    	}

    	for($j=1; $j<=8; $j++){
        if(strlen($data["upper_".$j]) < 1){
          $data["upper_".$j] = null;
        }
        if(strlen($data["lower_".$j]) < 1){
          $data["lower_".$j] = null;
        }
    	}

      for($i=10; $i<=11; $i++){
        if(strlen($data["text_".$i]) < 1){
          $data["text_".$i] = null;
        }
    	}
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
    	$product_code = $data['product_code'];//product_idという名前のデータに$product_idと名前を付ける
    	$this->set('product_code',$product_code);//セット
      $this->set('Productcode',$product_code);//セット
    	$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
    	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	if ($this->request->is('get')) {//getでこのページに来た場合の処理
    		$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $data);//$kensahyouHeadデータ（空の行）を$this->request->getData()に更新する
    		$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
    		$connection->begin();//トランザクション3
    		try {//トランザクション4
    			if ($this->KensahyouHeads->save($kensahyouHead)) {//saveできた時

            //旧DB更新
            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('kensahyou_head');
            $table->setConnection($connection);

            $connection->insert('kensahyou_head', [
                'product_id' => $data['product_code'],
                'maisu' => $data['maisu'],
                'size_1' => $data['size_1'],
                'upper_1' => $data['upper_1'],
                'lower_1' => $data['lower_1'],
                'size_2' => $data['size_2'],
                'upper_2' => $data['upper_2'],
                'lower_2' => $data['lower_2'],
                'size_3' => $data['size_3'],
                'upper_3' => $data['upper_3'],
                'lower_3' => $data['lower_3'],
                'size_4' => $data['size_4'],
                'upper_4' => $data['upper_4'],
                'lower_4' => $data['lower_4'],
                'size_5' => $data['size_5'],
                'upper_5' => $data['upper_5'],
                'lower_5' => $data['lower_5'],
                'size_6' => $data['size_6'],
                'upper_6' => $data['upper_6'],
                'lower_6' => $data['lower_6'],
                'size_7' => $data['size_7'],
                'upper_7' => $data['upper_7'],
                'lower_7' => $data['lower_7'],
                'size_8' => $data['size_8'],
                'upper_8' => $data['upper_8'],
                'lower_8' => $data['lower_8'],
                'size_9' => $data['size_9'],
                'text_10' => $data['text_10'],
                'text_11' => $data['text_11'],
                'bik' => $data['bik']
            ]);
            $connection = ConnectionManager::get('default');

            $mes = "※下記のように登録されました";
						$this->set('mes',$mes);
						$connection->commit();// コミット5
    			} else {//saveできなかった時
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

    public function edit($id = null)
    {
  //    $this->request->session()->destroy(); // セッションの破棄

      $kensahyouHead = $this->KensahyouHeads->get($id);
    	$this->set('kensahyouHead', $kensahyouHead);//$kensahyouHeadをctpで使えるようにセット

    	$product_code = $kensahyouHead['product_code'];//product_idという名前のデータに$product_idと名前を付ける
      $this->set('product_code',$product_code);//セット
      $this->set('Productcode',$product_code);//セット

    	$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
    	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

      $KensaProduct = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();
      $KensaProductV = $KensaProduct[0]->version;
      $newversion = $KensaProductV + 1;
      $this->set('newversion',$newversion);

      $bik = $KensaProduct[0]->bik;
      $this->set('bik',$bik);

      $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
      $this->set('arrType',$arrType);

      for($i=1; $i<=9; $i++){
        ${"size_".$i} = $KensaProduct[0]["size_".$i];
        $this->set('size_'.$i,${"size_".$i});
     }

     for($i=1; $i<=8; $i++){
       ${"upper_".$i} = $KensaProduct[0]["upper_".$i];
       $this->set('upper_'.$i,${"upper_".$i});
       ${"lower_".$i} = $KensaProduct[0]["lower_".$i];
       $this->set('lower_'.$i,${"lower_".$i});
     }

      for($i=10; $i<=11; $i++){
        ${"text_".$i} = $KensaProduct[0]["text_".$i];
        $this->set('text_'.$i,${"text_".$i});
     }

    }

    public function editconfirm()
   {
     $data = $this->request->getData();//postで送られた全データを取得

     $id = $data['id'];
     $this->set('id',$id);//セット

     $product_code = $data['product_code'];//product_idという名前のデータに$product_idと名前を付ける
     $this->set('product_code',$product_code);//セット

     $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
     $this->set('kensahyouHead',$kensahyouHead);//セット

     $Product = $this->Products->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->toArray();//'id' => $product_idを満たすものを$Product
     $Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
     $this->set('Productcode',$Productcode);//セット

     $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
     $this->set('Productname',$Productname);//セット

     if ($data['delete_flag'] == 1) {
       $mes = "※削除します";
       $this->set('mes',$mes);
     }else{
       $mes = "※以下のように更新します。";
       $this->set('mes',$mes);
     }

     if($data['type_im'] == 0){
       $type_im = "IM6120(1号機)";
     }else{
       $type_im = "IM7000(2号機)";
     }
     $this->set('type_im',$type_im);

   }

   public function editpreadd()
	{
    $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
    $this->set('kensahyouHead',$kensahyouHead);//セット

    $Data=$this->request->query('s');
    if(isset($Data["mess"])){
      $mess = $Data["mess"];
      $this->set('mess',$mess);
    }else{
      $mess = "";
      $this->set('mess',$mess);
    }

	}

		public function editlogin()
	 {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

       $userdata = $data['username'];

       if(isset($data['prelogin'])){

         $htmllogin = new htmlLogin();
         $qrcheck = $htmllogin->qrcheckprogram($userdata);

         if($qrcheck > 0){
           return $this->redirect(['action' => 'editpreadd',
           's' => ['mess' => "QRコードを読み込んでください。"]]);
         }

       }

       $htmllogin = new htmlLogin();
       $arraylogindate = $htmllogin->htmlloginprogram($userdata);

       $username = $arraylogindate[0];
       $delete_flag = $arraylogindate[1];
       $this->set('username',$username);
       $this->set('delete_flag',$delete_flag);

       $user = $this->Auth->identify();//$delete_flag = 0だとログインできない

       if ($user) {
         $this->Auth->setUser($user);
         return $this->redirect(['action' => 'editdo']);
       }
     }
	 }

	 		public function editdo()
	 	 {
       $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
       $this->set('kensahyouHead',$kensahyouHead);//セット

       $session = $this->request->getSession();
       $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

       $session_names = "sokuteidata,Auth";//データ登録に必要なセッションの名前をカンマでつなぐ
       $htmlSessioncheck = new htmlSessioncheck();
       $arr_session_flag = $htmlSessioncheck->check($session_names);
       if($arr_session_flag["num"] > 1){//セッション切れの場合
         return $this->redirect(['action' => 'yobidashicustomer',
         's' => ['mess' => $arr_session_flag["mess"]]]);
       }

       $created_staff = array('updated_staff'=>$this->Auth->user('staff_id'));
       $_SESSION['sokuteidata'] = array_merge($created_staff,$_SESSION['sokuteidata']);

       $data = $_SESSION['sokuteidata'];
       $kousinn_flag = $_SESSION['kousinn_flag']['kousinn_flag'];

       if($data['type_im'] == 0){
         $type_im = "IM6120(1号機)";
       }else{
         $type_im = "IM7000(2号機)";
       }
       $this->set('type_im',$type_im);

       for($i=1; $i<=9; $i++){
         if(strlen($data["size_".$i]) < 1){
           $data["size_".$i] = null;
         }
     	}

     	for($j=1; $j<=8; $j++){
         if(strlen($data["upper_".$j]) < 1){
           $data["upper_".$j] = null;
         }
         if(strlen($data["lower_".$j]) < 1){
           $data["lower_".$j] = null;
         }
     	}

       for($i=10; $i<=11; $i++){
         if(strlen($data["text_".$i]) < 1){
           $data["text_".$i] = null;
         }
     	}

     	$Productcode = $data["product_code"];
     	$this->set('Productcode',$Productcode);//セット
      $Product = $this->Products->find()->where(['product_code' => $Productcode])->toArray();
     	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
     	$this->set('Productname',$Productname);//セット

        if ($kousinn_flag == 1) {

           $kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());
           $connection = ConnectionManager::get('default');//トランザクション1
             // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
             if ($this->KensahyouHeads->updateAll(//検査終了時間の更新
               ['type_im' => $data['type_im'],
               'size_1' => $data['size_1'],
               'upper_1' => $data['upper_1'],
               'lower_1' => $data['lower_1'],
               'size_2' => $data['size_2'],
               'upper_2' => $data['upper_2'],
               'lower_2' => $data['lower_2'],
               'size_3' => $data['size_3'],
               'upper_3' => $data['upper_3'],
               'lower_3' => $data['lower_3'],
               'size_4' => $data['size_4'],
               'upper_4' => $data['upper_4'],
               'lower_4' => $data['lower_4'],
               'size_5' => $data['size_5'],
               'upper_5' => $data['upper_5'],
               'lower_5' => $data['lower_5'],
               'size_6' => $data['size_6'],
               'upper_6' => $data['upper_6'],
               'lower_6' => $data['lower_6'],
               'size_7' => $data['size_7'],
               'upper_7' => $data['upper_7'],
               'lower_7' => $data['lower_7'],
               'size_8' => $data['size_8'],
               'upper_8' => $data['upper_8'],
               'lower_8' => $data['lower_8'],
               'size_9' => $data['size_9'],
               'text_10' => $data['text_10'],
               'text_11' => $data['text_11'],
               'bik' => $data['bik'],
               'updated_at' => date('Y-m-d H:i:s'),
               'updated_staff' => $data['updated_staff']],
               ['id'  => $data['id']]
             )){

               //旧DBに登録
               $connection = ConnectionManager::get('sakaeMotoDB');
               $table = TableRegistry::get('kensahyou_head');
               $table->setConnection($connection);

               $versionmoto = $data['version'] - 1;

               for($i=1; $i<=9; $i++){
                 if(strlen($data["size_".$i]) < 1){
                   $updater = "UPDATE kensahyou_head set size_$i ='".$data["size_".$i]."'
                   where product_id ='".$Productcode."'";
                   $connection->execute($updater);
                 }
              }

              for($i=1; $i<=9; $i++){
                if(strlen($data["upper_".$j]) < 1){
                  $updater = "UPDATE kensahyou_head set upper_$i ='".$data["upper_".$i]."'
                  where product_id ='".$Productcode."'";
                  $connection->execute($updater);
                }
             }

             for($i=1; $i<=9; $i++){
               if(strlen($data["lower_".$j]) < 1){
                 $updater = "UPDATE kensahyou_head set lower_$i ='".$data["lower_".$i]."'
                 where product_id ='".$Productcode."'";
                 $connection->execute($updater);
               }
            }

            for($i=10; $i<=11; $i++){
              if(strlen($data["text_".$i]) < 1){
                $updater = "UPDATE kensahyou_head set text_$i ='".$data["text_".$i]."'
                where product_id ='".$Productcode."'";
                $connection->execute($updater);
              }
           }

               $updater = "UPDATE kensahyou_head set bik ='".$data['bik']."'
               where product_id ='".$Productcode."'";
               $connection->execute($updater);

               $connection = ConnectionManager::get('default');//新DBに戻る
               $table->setConnection($connection);

               $mes = "※更新しました";
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

         }else{

           $tourokuData = [
             'product_code' => $Productcode,
             'version' => $data['version'],
             'maisu' => $data['maisu'],
             'type_im' => $data['type_im'],
             'size_1' => $data['size_1'],
             'upper_1' => $data['upper_1'],
             'lower_1' => $data['lower_1'],
             'size_2' => $data['size_2'],
             'upper_2' => $data['upper_2'],
             'lower_2' => $data['lower_2'],
             'size_3' => $data['size_3'],
             'upper_3' => $data['upper_3'],
             'lower_3' => $data['lower_3'],
             'size_4' => $data['size_4'],
             'upper_4' => $data['upper_4'],
             'lower_4' => $data['lower_4'],
             'size_5' => $data['size_5'],
             'upper_5' => $data['upper_5'],
             'lower_5' => $data['lower_5'],
             'size_6' => $data['size_6'],
             'upper_6' => $data['upper_6'],
             'lower_6' => $data['lower_6'],
             'size_7' => $data['size_7'],
             'upper_7' => $data['upper_7'],
             'lower_7' => $data['lower_7'],
             'size_8' => $data['size_8'],
             'upper_8' => $data['upper_8'],
             'lower_8' => $data['lower_8'],
             'size_9' => $data['size_9'],
             'text_10' => $data['text_10'],
             'text_11' => $data['text_11'],
             'bik' => $data['bik'],
             'status' => $data['status'],
             'created_at' => date('Y-m-d H:i:s'),
             'created_staff' => $data['updated_staff']
           ];

           $kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());
           $connection = ConnectionManager::get('default');//トランザクション1
             // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
             if ($this->KensahyouHeads->updateAll(//検査終了時間の更新
 							[
              'delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data['updated_staff']],
 							['id'  => $data['id']]
 						)){

              $KensahyouHeads = $this->KensahyouHeads->patchEntity($this->KensahyouHeads->newEntity(), $tourokuData);
  						$this->KensahyouHeads->save($KensahyouHeads);

              $KensahyouHeads = $this->KensahyouHeads->find()->where(['id' => $data['id']])->toArray();

              //旧DBに登録
  						$connection = ConnectionManager::get('sakaeMotoDB');
  						$table = TableRegistry::get('kensahyou_head');
  						$table->setConnection($connection);

              $delete_flag = 1;
              $versionmoto = $data['version'] - 1;
              $updater = "DELETE FROM kensahyou_head
              where product_id ='".$Productcode."'";
              $connection->execute($updater);

  							$connection->insert('kensahyou_head', [
                  'product_id' => $Productcode,
          //        'version' => $data['version'],
                  'maisu' => $data['maisu'],
                  'size_1' => $data['size_1'],
                  'upper_1' => $data['upper_1'],
                  'lower_1' => $data['lower_1'],
                  'size_2' => $data['size_2'],
                  'upper_2' => $data['upper_2'],
                  'lower_2' => $data['lower_2'],
                  'size_3' => $data['size_3'],
                  'upper_3' => $data['upper_3'],
                  'lower_3' => $data['lower_3'],
                  'size_4' => $data['size_4'],
                  'upper_4' => $data['upper_4'],
                  'lower_4' => $data['lower_4'],
                  'size_5' => $data['size_5'],
                  'upper_5' => $data['upper_5'],
                  'lower_5' => $data['lower_5'],
                  'size_6' => $data['size_6'],
                  'upper_6' => $data['upper_6'],
                  'lower_6' => $data['lower_6'],
                  'size_7' => $data['size_7'],
                  'upper_7' => $data['upper_7'],
                  'lower_7' => $data['lower_7'],
                  'size_8' => $data['size_8'],
                  'upper_8' => $data['upper_8'],
                  'lower_8' => $data['lower_8'],
                  'size_9' => $data['size_9'],
                  'text_10' => $data['text_10'],
                  'text_11' => $data['text_11'],
                  'bik' => $data['bik'],
            //      'status' => 0
  							]);

                $connection = ConnectionManager::get('default');//新DBに戻る
                $table->setConnection($connection);

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

}
