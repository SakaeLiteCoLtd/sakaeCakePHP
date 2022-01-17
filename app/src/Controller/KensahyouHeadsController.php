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
       $this->ImKikakuTaious = TableRegistry::get('imKikakuTaious');//ImKikakuTaiousテーブルを使う
       $this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//imSokuteidataHeadsテーブルを使う
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

      $Productn = $this->Products->find()->where(['product_code' => $product_code])->toArray();//
    	$Productname = $Productn[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

      $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・・・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

    	$KensaProduct = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
    	$this->set('KensaProduct',$KensaProduct);//セット

      $this->set('Productcode',$product_code);//セット
      $this->set('product_code',$product_code);//セット

      $this->set('kensahyouHeads',$this->KensahyouHeads->find()//KensahyouHeadsテーブルから
    		->where(['delete_flag' => '0','product_code' => $product_code]));//'delete_flag' => '0'、'product_id' => $product_idを満たすデータをkensahyouHeadsにセット

        $arrmaisu = ['1' => '１枚（A～H）', '2' => '２枚（A～P）', '3' => '３枚（A～X）'];
  			$this->set('arrmaisu',$arrmaisu);

        $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
  			$this->set('arrType',$arrType);

    }

    public function form()
    {

  //    echo Configure::version();

      $data = $this->request->getData();
      $product_code = $data["product_code"];
    	$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

      if(!isset($data["num"])){
        $num = 1;
      }else{

        for($k=1; $k<=$data["num"]; $k++){

          for($i=1; $i<=9; $i++){
              ${"size_".$k.$i} = $data["size_".$k.$i];
              $this->set('size_'.$k.$i,${"size_".$k.$i});
          }

          for($i=1; $i<=8; $i++){
            ${"upper_".$k.$i} = $data["upper_".$k.$i];
            $this->set('upper_'.$k.$i,${"upper_".$k.$i});
            ${"lower_".$k.$i} = $data["lower_".$k.$i];
            $this->set('lower_'.$k.$i,${"lower_".$k.$i});
          }

          for($i=10; $i<=11; $i++){
            ${"text_".$i} = $data["text_".$i];
            $this->set('text_'.$i,${"text_".$i});
          }

        }

        $num = $data["num"] + 1;

        if($data["num"] == $data["maisu"]){

          if(!isset($_SESSION)){
            session_start();
          }
          $_SESSION['kensahyouheadsdata'] = array();
          $_SESSION['kensahyouheadsdata'] = $data;

          return $this->redirect(['action' => 'confirm']);

        }

      }
      $this->set('num',$num);

      $this->set('Productcode',$product_code);
      $this->set('product_code',$product_code);

    	$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・・・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

    	$KensaProduct = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
    	$this->set('KensaProduct',$KensaProduct);//セット

    	$Productn = $this->Products->find()->where(['product_code' => $product_code])->toArray();//
    	$Productname = $Productn[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	$this->set('kensahyouHeads',$this->KensahyouHeads->find()//KensahyouHeadsテーブルから
    		->where(['delete_flag' => '0','product_code' => $product_code]));//'delete_flag' => '0'、'product_id' => $product_idを満たすデータをkensahyouHeadsにセット

        if($data['type_im'] == 0){
          $type_im_hyouji = "IM6120(1号機)";
        }else{
          $type_im_hyouji = "IM7000(2号機)";
        }
        $this->set('type_im',$data['type_im']);
        $this->set('type_im_hyouji',$type_im_hyouji);

        $maisu = $data["maisu"];
        $this->set('maisu',$maisu);

        if(!isset($data["bik"])){
          $bik = "";
        }else{
          $bik = $data["bik"];
        }
        $this->set('bik',$bik);
/*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
*/
    }

     public function confirm()
    {
      $session = $this->request->getSession();
      $_SESSION = $session->read();

      $data = $_SESSION['kensahyouheadsdata'];
      $this->set('data',$data);
      /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
//      $data = $this->request->getData();//postで送られた全データを取得

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

      $session_names = "kensahyouheadsdata,Auth";//データ登録に必要なセッションの名前をカンマでつなぐ
      $htmlSessioncheck = new htmlSessioncheck();
      $arr_session_flag = $htmlSessioncheck->check($session_names);
      if($arr_session_flag["num"] > 1){//セッション切れの場合
        return $this->redirect(['action' => 'yobidashicustomer',
        's' => ['mess' => $arr_session_flag["mess"]]]);
      }

      $created_staff = array('created_staff' => $this->Auth->user('staff_id'));
      $_SESSION['kensahyouheadsdata'] = array_merge($created_staff,$_SESSION['kensahyouheadsdata']);
      $created_at = array('created_at' => date('Y-m-d H:i:s'));
      $_SESSION['kensahyouheadsdata'] = array_merge($created_at,$_SESSION['kensahyouheadsdata']);

      $data = $_SESSION['kensahyouheadsdata'];
      $this->set('data',$data);

      if($data['type_im'] == 0){
        $type_im = "IM6120(1号機)";
      }else{
        $type_im = "IM7000(2号機)";
      }
      $this->set('type_im',$type_im);

      for($k=1; $k<=$data['maisu']; $k++){

        for($i=1; $i<=9; $i++){
          if(strlen($data["size_".$k.$i]) < 1){
            $data["size_".$i] = null;
          }
      	}

      	for($j=1; $j<=8; $j++){
          if(strlen($data["upper_".$k.$j]) < 1){
            $data["upper_".$j] = null;
          }
          if(strlen($data["lower_".$k.$j]) < 1){
            $data["lower_".$j] = null;
          }
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
      $arrtourokuhead = array();
      for($k=1; $k<=$data['maisu']; $k++){

        if($k == 1){
          $product_code = $data['product_code'];
          $text_10 = $data['text_10'];
          $text_11 = $data['text_11'];
          $bik = $data['bik'];
        }else{
          $product_code = $data['product_code']."---".$k;
          $text_10 = null;
          $text_11 = null;
          $bik = null;
        }

        $arrtourokuhead[] = [
          "product_code" => $product_code,
          "version" => $data['version'],
          "type_im" => $data['type_im'],
          "maisu" => $data['maisu'],
          "upper_1" => $data['upper_'.$k."1"],
          "upper_2" => $data['upper_'.$k."2"],
          "upper_3" => $data['upper_'.$k."3"],
          "upper_4" => $data['upper_'.$k."4"],
          "upper_5" => $data['upper_'.$k."5"],
          "upper_6" => $data['upper_'.$k."6"],
          "upper_7" => $data['upper_'.$k."7"],
          "upper_8" => $data['upper_'.$k."8"],
          "lower_1" => $data['lower_'.$k."1"],
          "lower_2" => $data['lower_'.$k."2"],
          "lower_3" => $data['lower_'.$k."3"],
          "lower_4" => $data['lower_'.$k."4"],
          "lower_5" => $data['lower_'.$k."5"],
          "lower_6" => $data['lower_'.$k."6"],
          "lower_7" => $data['lower_'.$k."7"],
          "lower_8" => $data['lower_'.$k."8"],
          "size_1" => $data['size_'.$k."1"],
          "size_2" => $data['size_'.$k."2"],
          "size_3" => $data['size_'.$k."3"],
          "size_4" => $data['size_'.$k."4"],
          "size_5" => $data['size_'.$k."5"],
          "size_6" => $data['size_'.$k."6"],
          "size_7" => $data['size_'.$k."7"],
          "size_8" => $data['size_'.$k."8"],
          "size_9" => $data['size_'.$k."9"],
          "text_10" => $text_10,
          "text_11" => $text_11,
          "bik" => $bik,
          "created_at" => $data['created_at'],
          "created_staff" => $data['created_staff']
        ];
      }
/*
      echo "<pre>";
      print_r($arrtourokuhead);
      echo "</pre>";
*/
    	$product_code = $data['product_code'];//product_idという名前のデータに$product_idと名前を付ける
    	$this->set('product_code',$product_code);//セット
      $this->set('Productcode',$product_code);//セット
    	$Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
    	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	if ($this->request->is('get')) {//getでこのページに来た場合の処理
    		$kensahyouHead = $this->KensahyouHeads->patchEntities($kensahyouHead, $arrtourokuhead);//$kensahyouHeadデータ（空の行）を$this->request->getData()に更新する
    		$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
    		$connection->begin();//トランザクション3
    		try {//トランザクション4

    			if ($this->KensahyouHeads->saveMany($kensahyouHead)) {//saveできた時

            for($k=0; $k<$data['maisu']; $k++){

              //旧DB更新
              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('kensahyou_head');
              $table->setConnection($connection);

              for($i=1; $i<=9; $i++){
                if(strlen($arrtourokuhead[$k]["size_".$i]) < 1){
                  $arrtourokuhead[$k]["size_".$i] = null;
                }
            	}

            	for($j=1; $j<=8; $j++){
                if(strlen($arrtourokuhead[$k]["upper_".$j]) < 1){
                  $arrtourokuhead[$k]["upper_".$j] = null;
                }
                if(strlen($arrtourokuhead[$k]["lower_".$j]) < 1){
                  $arrtourokuhead[$k]["lower_".$j] = null;
                }
            	}

              for($i=10; $i<=11; $i++){
                if(strlen($arrtourokuhead[$k]["text_".$i]) < 1){
                  $arrtourokuhead[$k]["text_".$i] = null;
                }
              }

              $connection->insert('kensahyou_head', [
                  'product_id' => $arrtourokuhead[$k]['product_code'],
                  'maisu' => $arrtourokuhead[$k]['maisu'],
                  'size_1' => $arrtourokuhead[$k]['size_1'],
                  'upper_1' => $arrtourokuhead[$k]['upper_1'],
                  'lower_1' => $arrtourokuhead[$k]['lower_1'],
                  'size_2' => $arrtourokuhead[$k]['size_2'],
                  'upper_2' => $arrtourokuhead[$k]['upper_2'],
                  'lower_2' => $arrtourokuhead[$k]['lower_2'],
                  'size_3' => $arrtourokuhead[$k]['size_3'],
                  'upper_3' => $arrtourokuhead[$k]['upper_3'],
                  'lower_3' => $arrtourokuhead[$k]['lower_3'],
                  'size_4' => $arrtourokuhead[$k]['size_4'],
                  'upper_4' => $arrtourokuhead[$k]['upper_4'],
                  'lower_4' => $arrtourokuhead[$k]['lower_4'],
                  'size_5' => $arrtourokuhead[$k]['size_5'],
                  'upper_5' => $arrtourokuhead[$k]['upper_5'],
                  'lower_5' => $arrtourokuhead[$k]['lower_5'],
                  'size_6' => $arrtourokuhead[$k]['size_6'],
                  'upper_6' => $arrtourokuhead[$k]['upper_6'],
                  'lower_6' => $arrtourokuhead[$k]['lower_6'],
                  'size_7' => $arrtourokuhead[$k]['size_7'],
                  'upper_7' => $arrtourokuhead[$k]['upper_7'],
                  'lower_7' => $arrtourokuhead[$k]['lower_7'],
                  'size_8' => $arrtourokuhead[$k]['size_8'],
                  'upper_8' => $arrtourokuhead[$k]['upper_8'],
                  'lower_8' => $arrtourokuhead[$k]['lower_8'],
                  'size_9' => $arrtourokuhead[$k]['size_9'],
                  'text_10' => $arrtourokuhead[$k]['text_10'],
                  'text_11' => $arrtourokuhead[$k]['text_11'],
                  'bik' => $arrtourokuhead[$k]['bik']
              ]);

            }

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

     $arrmaisu = ['1' => '１枚（A～H）', '2' => '２枚（A～P）', '3' => '３枚（A～X）'];
     $this->set('arrmaisu',$arrmaisu);

    }

    public function editform()
    {
      $data = $this->request->getData();//postで送られた全データを取得

      $id = $data['id'];
      $this->set('id',$id);

      $maisu = $data['maisu'];
      $this->set('maisu',$maisu);

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
      if($data["kousinn_flag"] == 0){
        $newversion = $KensaProductV + 1;
      }else{
        $newversion = $KensaProductV;
      }
      $this->set('newversion',$newversion);

      $bik = $KensaProduct[0]->bik;
      $this->set('bik',$bik);

      $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
      $this->set('arrType',$arrType);

      $KensahyouHeads = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();
/*
      echo "<pre>";
      print_r($KensahyouHeads);
      echo "</pre>";
*/
      for($k=1; $k<=$data['maisu']; $k++){

        for($i=1; $i<=9; $i++){
          if(isset($KensahyouHeads[$k-1]["size_".$i])){
            ${"size_".$k.$i} = $KensahyouHeads[$k-1]["size_".$i];
          }else{
            ${"size_".$k.$i} = "";
          }
          $this->set('size_'.$k.$i,${"size_".$k.$i});
        }

        for($j=1; $j<=8; $j++){

          if(isset($KensahyouHeads[$k-1]["upper_".$j])){
            ${"upper_".$k.$j} = $KensahyouHeads[$k-1]["upper_".$j];
          }else{
            ${"upper_".$k.$j} = "";
          }
          $this->set('upper_'.$k.$j,${"upper_".$k.$j});

          if(isset($KensahyouHeads[$k-1]["lower_".$j])){
            ${"lower_".$k.$j} = $KensahyouHeads[$k-1]["lower_".$j];
          }else{
            ${"lower_".$k.$j} = "";
          }
          $this->set('lower_'.$k.$j,${"lower_".$k.$j});

        }

      }

      for($i=10; $i<=11; $i++){
        ${"text_".$i} = $KensaProduct[0]["text_".$i];
        $this->set('text_'.$i,${"text_".$i});
     }

     if($data['type_im'] == 0){
       $type_im_hyouji = "IM6120(1号機)";
     }else{
       $type_im_hyouji = "IM7000(2号機)";
     }
     $this->set('type_im_hyouji',$type_im_hyouji);
     $this->set('type_im',$data['type_im']);

    }

    public function editconfirm()
   {
     $data = $this->request->getData();//postで送られた全データを取得
     $this->set('data',$data);

     if(!isset($_SESSION)){
       session_start();
     }
     $_SESSION['updatekensahyouheadsdata'] = array();
     $_SESSION['updatekensahyouheadsdata'] = $data;

     $id = $data['id'];
     $this->set('id',$id);//セット

     $product_code = $data['product_code'];
     $this->set('product_code',$product_code);

     $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
     $this->set('kensahyouHead',$kensahyouHead);//セット

     $Product = $this->Products->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->toArray();//'id' => $product_idを満たすものを$Product
     $Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
     $this->set('Productcode',$Productcode);//セット

     $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
     $this->set('Productname',$Productname);//セット

     $mes = "※以下のように更新します。";
     $this->set('mes',$mes);

     if($data['type_im'] == 0){
       $type_im_hyouji = "IM6120(1号機)";
     }else{
       $type_im_hyouji = "IM7000(2号機)";
     }
     $this->set('type_im_hyouji',$type_im_hyouji);
     $this->set('type_im',$data['type_im']);

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

       $session_names = "updatekensahyouheadsdata,Auth";//データ登録に必要なセッションの名前をカンマでつなぐ
       $htmlSessioncheck = new htmlSessioncheck();
       $arr_session_flag = $htmlSessioncheck->check($session_names);
       if($arr_session_flag["num"] > 1){//セッション切れの場合
         return $this->redirect(['action' => 'yobidashicustomer',
         's' => ['mess' => $arr_session_flag["mess"]]]);
       }

  //     $created_staff = array('updated_staff'=>$this->Auth->user('staff_id'));
  //     $_SESSION['updatekensahyouheadsdata'] = array_merge($created_staff,$_SESSION['updatekensahyouheadsdata']);

       $data = $_SESSION['updatekensahyouheadsdata'];
       $this->set('data',$data);
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       if($data['type_im'] == 0){
         $type_im = "IM6120(1号機)";
       }else{
         $type_im = "IM7000(2号機)";
       }
       $this->set('type_im',$type_im);

       for($i=10; $i<=11; $i++){
         if(strlen($data["text_".$i]) < 1){
           $data["text_".$i] = null;
         }
     	}

     	$Productcode = $data["product_code"];
     	$this->set('Productcode',$Productcode);
      $Product = $this->Products->find()->where(['product_code' => $Productcode])->toArray();
     	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
     	$this->set('Productname',$Productname);

      $updated_staff = $this->Auth->user('staff_id');
      $updated_at = date('Y-m-d H:i:s');

      $KensahyouHeadsmoto = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $Productcode], ['product_code like' => $Productcode.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();
/*
        echo "<pre>";
        print_r($KensahyouHeadsmoto);
        echo "</pre>";
*/
        $arrupdatehead = array();
        for($k=1; $k<=$data['maisu']; $k++){

          if($k == 1){
            $product_code = $data['product_code'];
            $text_10 = $data['text_10'];
            $text_11 = $data['text_11'];
            $bik = $data['bik'];
          }else{
            $product_code = $data['product_code']."---".$k;
            $text_10 = null;
            $text_11 = null;
            $bik = null;
          }

          $arrupdatehead[] = [
            "product_code" => $product_code,
            "version" => $data['version'],
            "type_im" => $data['type_im'],
            "maisu" => $data['maisu'],
            "upper_1" => $data['upper_'.$k."1"],
            "upper_2" => $data['upper_'.$k."2"],
            "upper_3" => $data['upper_'.$k."3"],
            "upper_4" => $data['upper_'.$k."4"],
            "upper_5" => $data['upper_'.$k."5"],
            "upper_6" => $data['upper_'.$k."6"],
            "upper_7" => $data['upper_'.$k."7"],
            "upper_8" => $data['upper_'.$k."8"],
            "lower_1" => $data['lower_'.$k."1"],
            "lower_2" => $data['lower_'.$k."2"],
            "lower_3" => $data['lower_'.$k."3"],
            "lower_4" => $data['lower_'.$k."4"],
            "lower_5" => $data['lower_'.$k."5"],
            "lower_6" => $data['lower_'.$k."6"],
            "lower_7" => $data['lower_'.$k."7"],
            "lower_8" => $data['lower_'.$k."8"],
            "size_1" => $data['size_'.$k."1"],
            "size_2" => $data['size_'.$k."2"],
            "size_3" => $data['size_'.$k."3"],
            "size_4" => $data['size_'.$k."4"],
            "size_5" => $data['size_'.$k."5"],
            "size_6" => $data['size_'.$k."6"],
            "size_7" => $data['size_'.$k."7"],
            "size_8" => $data['size_'.$k."8"],
            "size_9" => $data['size_'.$k."9"],
            "text_10" => $text_10,
            "text_11" => $text_11,
            "bik" => $bik,
            "created_at" => $updated_at,
            "created_staff" => $updated_staff,
            "updated_at" => $updated_at,
            "updated_staff" => $updated_staff
          ];
        }
/*
        echo "<pre>";
        print_r($arrupdatehead);
        echo "</pre>";
*/
        $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4

          for($k=0; $k<count($KensahyouHeadsmoto); $k++){

            if ($this->KensahyouHeads->updateAll(//検査終了時間の更新
              ['delete_flag' => 1,
              'updated_at' => date('Y-m-d H:i:s'),
              'updated_staff' => $updated_staff],
              ['id'  => $KensahyouHeadsmoto[$k]['id']]
            )){

              //旧DBに登録
  						$connection = ConnectionManager::get('DB_ikou_test');
  						$table = TableRegistry::get('kensahyou_head');
  						$table->setConnection($connection);

              $updater = "DELETE FROM kensahyou_head
              where product_id ='".$KensahyouHeadsmoto[$k]['product_code']."'";
              $connection->execute($updater);

              $connection = ConnectionManager::get('default');//新DBに戻る
              $table->setConnection($connection);

              if($k == count($KensahyouHeadsmoto) - 1){

                $kensahyouHead = $this->KensahyouHeads->patchEntities($kensahyouHead, $arrupdatehead);
                if ($this->KensahyouHeads->saveMany($kensahyouHead)) {//saveできた時

                  for($k=0; $k<count($arrupdatehead); $k++){

                    //旧DB更新
                    $connection = ConnectionManager::get('DB_ikou_test');
                    $table = TableRegistry::get('kensahyou_head');
                    $table->setConnection($connection);

                    for($i=1; $i<=9; $i++){
                      if(strlen($arrupdatehead[$k]["size_".$i]) < 1){
                        $arrupdatehead[$k]["size_".$i] = null;
                      }
                    }

                    for($j=1; $j<=8; $j++){
                      if(strlen($arrupdatehead[$k]["upper_".$j]) < 1){
                        $arrupdatehead[$k]["upper_".$j] = null;
                      }
                      if(strlen($arrupdatehead[$k]["lower_".$j]) < 1){
                        $arrupdatehead[$k]["lower_".$j] = null;
                      }
                    }

                    for($i=10; $i<=11; $i++){
                      if(strlen($arrupdatehead[$k]["text_".$i]) < 1){
                        $arrupdatehead[$k]["text_".$i] = null;
                      }
                    }

                    $connection->insert('kensahyou_head', [
                        'product_id' => $arrupdatehead[$k]['product_code'],
                        'maisu' => $arrupdatehead[$k]['maisu'],
                        'size_1' => $arrupdatehead[$k]['size_1'],
                        'upper_1' => $arrupdatehead[$k]['upper_1'],
                        'lower_1' => $arrupdatehead[$k]['lower_1'],
                        'size_2' => $arrupdatehead[$k]['size_2'],
                        'upper_2' => $arrupdatehead[$k]['upper_2'],
                        'lower_2' => $arrupdatehead[$k]['lower_2'],
                        'size_3' => $arrupdatehead[$k]['size_3'],
                        'upper_3' => $arrupdatehead[$k]['upper_3'],
                        'lower_3' => $arrupdatehead[$k]['lower_3'],
                        'size_4' => $arrupdatehead[$k]['size_4'],
                        'upper_4' => $arrupdatehead[$k]['upper_4'],
                        'lower_4' => $arrupdatehead[$k]['lower_4'],
                        'size_5' => $arrupdatehead[$k]['size_5'],
                        'upper_5' => $arrupdatehead[$k]['upper_5'],
                        'lower_5' => $arrupdatehead[$k]['lower_5'],
                        'size_6' => $arrupdatehead[$k]['size_6'],
                        'upper_6' => $arrupdatehead[$k]['upper_6'],
                        'lower_6' => $arrupdatehead[$k]['lower_6'],
                        'size_7' => $arrupdatehead[$k]['size_7'],
                        'upper_7' => $arrupdatehead[$k]['upper_7'],
                        'lower_7' => $arrupdatehead[$k]['lower_7'],
                        'size_8' => $arrupdatehead[$k]['size_8'],
                        'upper_8' => $arrupdatehead[$k]['upper_8'],
                        'lower_8' => $arrupdatehead[$k]['lower_8'],
                        'size_9' => $arrupdatehead[$k]['size_9'],
                        'text_10' => $arrupdatehead[$k]['text_10'],
                        'text_11' => $arrupdatehead[$k]['text_11'],
                        'bik' => $arrupdatehead[$k]['bik']
                    ]);

                  }

                  $connection = ConnectionManager::get('default');

                  $mes = "※更新しました";
                   $this->set('mes',$mes);
                   $connection->commit();// コミット5

                 } else {
                   $mes = "※更新されませんでした";
                    $this->set('mes',$mes);
                    $this->Flash->error(__('The product could not be saved. Please, try again.'));
                    throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                 }

              }

            } else {
              $mes = "※更新されませんでした";
               $this->set('mes',$mes);
               $this->Flash->error(__('The product could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }

          }

        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10

	 	 }

     public function deleteconfirm($id = null)
     {
       $kensahyouHead = $this->KensahyouHeads->get($id);
     	$this->set('kensahyouHead', $kensahyouHead);//$kensahyouHeadをctpで使えるようにセット

     	$product_code = $kensahyouHead['product_code'];//product_idという名前のデータに$product_idと名前を付ける
     	$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

      if(!isset($_SESSION)){
        session_start();
      }
      $_SESSION['deletekensahyouheadsdata'] = array();
      $_SESSION['deletekensahyouheadsdata'] = $product_code;

      $ImKikakuTaiouDatas = $this->ImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => 0])->toArray();

      $this->set('product_code',$product_code);//セット
      $this->set('Productcode',$product_code);//セット

      for($k=0; $k<30; $k++){
        $this->set("kind_kensa".$k,"-");
        $this->set("size_num_".$k,"");
      }

      for($k=0; $k<count($ImKikakuTaiouDatas); $k++){
        $this->set("kind_kensa".$ImKikakuTaiouDatas[$k]["kensahyuo_num"],$ImKikakuTaiouDatas[$k]["kind_kensa"]);
        $this->set("size_num_".$ImKikakuTaiouDatas[$k]["kensahyuo_num"],$ImKikakuTaiouDatas[$k]["size_num"]);
      }

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
      $this->set('Productname',$Productname);//セット

      $KensahyouHeads = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();

        $maisu = count($KensahyouHeads);
        $this->set('maisu',$maisu);

      for($k=1; $k<=$maisu; $k++){

        for($i=1; $i<=9; $i++){
          if(isset($KensahyouHeads[$k-1]["size_".$i])){
            ${"size_".$k.$i} = $KensahyouHeads[$k-1]["size_".$i];
          }else{
            ${"size_".$k.$i} = "";
          }
          $this->set('size_'.$k.$i,${"size_".$k.$i});
        }

        for($j=1; $j<=8; $j++){

          if(isset($KensahyouHeads[$k-1]["upper_".$j])){
            ${"upper_".$k.$j} = $KensahyouHeads[$k-1]["upper_".$j];
          }else{
            ${"upper_".$k.$j} = "";
          }
          $this->set('upper_'.$k.$j,${"upper_".$k.$j});

          if(isset($KensahyouHeads[$k-1]["lower_".$j])){
            ${"lower_".$k.$j} = $KensahyouHeads[$k-1]["lower_".$j];
          }else{
            ${"lower_".$k.$j} = "";
          }
          $this->set('lower_'.$k.$j,${"lower_".$k.$j});

        }

      }

      for($i=10; $i<=11; $i++){
        ${"text_".$i} = $KensahyouHeads[0]["text_".$i];
        $this->set('text_'.$i,${"text_".$i});
     }

      $ImSokuteidataHeads = $this->ImSokuteidataHeads->find()
     ->where(['product_code' => $product_code, 'delete_flag' => '0'])->toArray();

      $arrKindKensa = array("","ノギス");//配列の初期化
       foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
          $arrKindKensa[] = $value->kind_kensa;//配列に追加
       }
        $arrKindKensa = array_unique($arrKindKensa);

       $this->set('arrKindKensa',$arrKindKensa);

     }

     public function deletepreadd()
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

    public function deletelogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

        $userdata = $data['username'];

        if(isset($data['prelogin'])){

          $htmllogin = new htmlLogin();
          $qrcheck = $htmllogin->qrcheckprogram($userdata);

          if($qrcheck > 0){
            return $this->redirect(['action' => 'deletepreadd',
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
          return $this->redirect(['action' => 'deletedo']);
        }
      }
    }

    public function deletedo()
    {
      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

      $product_code = $_SESSION['deletekensahyouheadsdata'];
      $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

     $ImKikakuTaiouDatas = $this->ImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => 0])->toArray();

     $this->set('product_code',$product_code);//セット
     $this->set('Productcode',$product_code);//セット

     for($k=0; $k<30; $k++){
       $this->set("kind_kensa".$k,"-");
       $this->set("size_num_".$k,"");
     }

     for($k=0; $k<count($ImKikakuTaiouDatas); $k++){
       $this->set("kind_kensa".$ImKikakuTaiouDatas[$k]["kensahyuo_num"],$ImKikakuTaiouDatas[$k]["kind_kensa"]);
       $this->set("size_num_".$ImKikakuTaiouDatas[$k]["kensahyuo_num"],$ImKikakuTaiouDatas[$k]["size_num"]);
     }

     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
     $this->set('Productname',$Productname);//セット

     $KensahyouHeads = $this->KensahyouHeads->find()->where([
       'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();

       $maisu = count($KensahyouHeads);
       $this->set('maisu',$maisu);

     for($k=1; $k<=$maisu; $k++){

       for($i=1; $i<=9; $i++){
         if(isset($KensahyouHeads[$k-1]["size_".$i])){
           ${"size_".$k.$i} = $KensahyouHeads[$k-1]["size_".$i];
         }else{
           ${"size_".$k.$i} = "";
         }
         $this->set('size_'.$k.$i,${"size_".$k.$i});
       }

       for($j=1; $j<=8; $j++){

         if(isset($KensahyouHeads[$k-1]["upper_".$j])){
           ${"upper_".$k.$j} = $KensahyouHeads[$k-1]["upper_".$j];
         }else{
           ${"upper_".$k.$j} = "";
         }
         $this->set('upper_'.$k.$j,${"upper_".$k.$j});

         if(isset($KensahyouHeads[$k-1]["lower_".$j])){
           ${"lower_".$k.$j} = $KensahyouHeads[$k-1]["lower_".$j];
         }else{
           ${"lower_".$k.$j} = "";
         }
         $this->set('lower_'.$k.$j,${"lower_".$k.$j});

       }

     }

     for($i=10; $i<=11; $i++){
       ${"text_".$i} = $KensahyouHeads[0]["text_".$i];
       $this->set('text_'.$i,${"text_".$i});
    }

     $ImSokuteidataHeads = $this->ImSokuteidataHeads->find()
    ->where(['product_code' => $product_code, 'delete_flag' => '0'])->toArray();

     $arrKindKensa = array("","ノギス");//配列の初期化
      foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
         $arrKindKensa[] = $value->kind_kensa;//配列に追加
      }
       $arrKindKensa = array_unique($arrKindKensa);

      $this->set('arrKindKensa',$arrKindKensa);

      $updated_staff = $this->Auth->user('staff_id');
      $updated_at = date('Y-m-d H:i:s');
/*
      echo "<pre>";
      print_r($KensahyouHeads);
      echo "</pre>";
*/
      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4

        for($k=0; $k<count($KensahyouHeads); $k++){

          if ($this->KensahyouHeads->updateAll(
            ['delete_flag' => 1,
            'updated_at' => $updated_at,
            'updated_staff' => $updated_staff],
            ['id'  => $KensahyouHeads[$k]['id']]
          )){

            if($k == 0){//imtaiouも削除

              for($m=0; $m<count($ImKikakuTaiouDatas); $m++){

                $this->ImKikakuTaious->updateAll(
                  ['status' => 1,
                  'updated_at' => $updated_at,
                  'updated_staff' => $updated_staff],
                  ['id'  => $ImKikakuTaiouDatas[$m]['id']]
                );
              }

              //旧DBに登録
              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('im_kikaku_taiou');
              $table->setConnection($connection);

              $updater = "DELETE FROM im_kikaku_taiou
              where product_id ='".$ImKikakuTaiouDatas[0]['product_code']."'";
              $connection->execute($updater);

              $connection = ConnectionManager::get('default');//新DBに戻る
              $table->setConnection($connection);

            }

            //旧DBに登録
            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('kensahyou_head');
            $table->setConnection($connection);

            $updater = "DELETE FROM kensahyou_head
            where product_id ='".$KensahyouHeads[$k]['product_code']."'";
            $connection->execute($updater);

            $connection = ConnectionManager::get('default');//新DBに戻る
            $table->setConnection($connection);

            if($k == count($KensahyouHeads) - 1){

              $mes = "※以下のデータを削除しました";
               $this->set('mes',$mes);
               $connection->commit();// コミット5

             }

          }else {
           $mes = "※削除されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }

      }

      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

}
