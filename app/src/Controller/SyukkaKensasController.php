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

class SyukkaKensasController extends AppController {

      public function initialize()
    {
     parent::initialize();
     $this->ImKikakuTaious = TableRegistry::get('imKikakuTaious');//ImKikakuTaiousテーブルを使う
     $this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//imSokuteidataHeadsテーブルを使う
     $this->ImKikakus = TableRegistry::get('imKikakus');//imKikakusテーブルを使う
     $this->ImSokuteidataResults = TableRegistry::get('imSokuteidataResults');//imSokuteidataResultsテーブルを使う
     $this->Products = TableRegistry::get('products');//productsテーブルを使う
     $this->Customers = TableRegistry::get('customers');
     $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
     $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouSokuteidatasテーブルを使う
     $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');//KadouSeikeisテーブルを使う
     $this->Users = TableRegistry::get('users');
     $this->KouteiKensahyouHeads = TableRegistry::get('kouteiKensahyouHeads');
     $this->FileCopyChecks = TableRegistry::get('fileCopyChecks');
     $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
    }

    public function index()
    {
      //メニュー画面
    }

    public function yobidashimenu()//「出荷検査用呼出」ページトップ
    {
      $KensahyouHeads = $this->KensahyouHeads->newEntity();
      $this->set('KensahyouHeads',$KensahyouHeads);
    }

    public function yobidashicustomer()//「出荷検査用呼出」ページトップ
    {
      $KensahyouHeads = $this->KensahyouHeads->newEntity();
      $this->set('KensahyouHeads',$KensahyouHeads);
    }

    public function typeyobidashicustomer()//「出荷検査用呼出」ページトップ
    {
      $KensahyouHeads = $this->KensahyouHeads->newEntity();
      $this->set('KensahyouHeads',$KensahyouHeads);
    }

    public function yobidashipana()
    {
      $this->set('products', $this->Products->find()
       ->select(['product_code','delete_flag' => '0'])
       );
    }

    public function typeyobidashipana()
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

    public function typeyobidashipanap0()
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

    public function typeyobidashipanap1()
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

    public function typeyobidashipanap2()
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

    public function typeyobidashipanaw()
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

    public function typeyobidashipanah()
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

    public function typeyobidashipanare()
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

    public function typeyobidashidnp()
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

    public function typeyobidashiothers()
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

    public function version()//IMtaiou
    {
      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
      $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット
/*
    	$this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
      */
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();

      $ImKikakuex = $this->ImKikakuTaious->find()->where(['product_code' => $product_code])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
      $this->set('ImKikakuex',$ImKikakuex);//セット

      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $ImSokuteidataHeads = $this->ImSokuteidataHeads->find()
    	->where(['product_code' => $product_code])->toArray();

      $arrKindKensa = array("","ノギス");//配列の初期化
    	 	foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
    			$arrKindKensa[] = $value->kind_kensa;//配列に追加
    		}
        $arrKindKensa = array_unique($arrKindKensa);
      $this->set('ImSokuteidataHeads',$ImSokuteidataHeads);//セット
      $this->set('arrKindKensa',$arrKindKensa);//セット

      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

    	 foreach ($Products as $value) {//$Productsそれぞれに対し
    		$product_code= $value->product_code;
    	}
    	$this->set('product_code',$product_code);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();
    	$Productid = $Producti[0]->id;
    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

    	for($i=1; $i<=9; $i++){//size_1～9までセット
    		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
    		$this->set('size_'.$i,${"size_".$i});//セット
    	}

    	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
    		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
    		$this->set('upper_'.$j,${"upper_".$j});//セット
    		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
    		$this->set('lower_'.$j,${"lower_".$j});//セット
    	}

    }

    public function imtaiouform()//IMtaiou
    {
      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
      $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    	$this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
  //    $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

  //    $product_code = $data["product_code"];
  //    $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();

      $ImKikakuex = $this->ImKikakuTaious->find()->where(['product_code' => $product_code])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
      $this->set('ImKikakuex',$ImKikakuex);//セット

      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $ImSokuteidataHeads = $this->ImSokuteidataHeads->find()
    	->where(['product_code' => $product_code])->toArray();

      $arrKindKensa = array("","ノギス");//配列の初期化
    	 	foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
    			$arrKindKensa[] = $value->kind_kensa;//配列に追加
    		}
        $arrKindKensa = array_unique($arrKindKensa);
      $this->set('ImSokuteidataHeads',$ImSokuteidataHeads);//セット
      $this->set('arrKindKensa',$arrKindKensa);//セット

      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

    	 foreach ($Products as $value) {//$Productsそれぞれに対し
    		$product_code= $value->product_code;
    	}
    	$this->set('product_code',$product_code);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

      if(isset($KensahyouHead[0])){
        $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

      	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
      	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      	for($i=1; $i<=9; $i++){//size_1～9までセット
      		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
      		$this->set('size_'.$i,${"size_".$i});//セット
      	}

      	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
      		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
      		$this->set('upper_'.$j,${"upper_".$j});//セット
      		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
      		$this->set('lower_'.$j,${"lower_".$j});//セット
      	}
      }

    }

    public function typeimtaiouform()//IMtaiou
    {
      $this->request->session()->destroy();// セッションの破棄

      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
      $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    	$this->set('KensahyouHeads',$this->KensahyouHeads->newEntity());

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);

      $KensahyouHeads = $this->KensahyouHeads->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->order(["version"=>"desc"])->toArray();//versionが大きいものから順に呼出
/*
      echo "<pre>";
      print_r(count($KouteiKensahyouHeads));
      echo "</pre>";
*/
      if(isset($KensahyouHeads[0])){
        $id = $KensahyouHeads[0]->id;
        $this->set('id',$id);
        $versionnow = $KensahyouHeads[0]->version;
        $this->set('versionnow',$versionnow);
        $typenow = $KensahyouHeads[0]->type_im;
        $newversion = $versionnow + 1;
        $this->set('newversion',$newversion);
        if($typenow == 0){
          $typenow = "IM6120(1号機)";
        }else{
          $typenow = "IM7000(2号機)";
        }
        $this->set('typenow',$typenow);
        $check = 1;
        $this->set('check',$check);
      }else{
        $check = 2;
        $this->set('check',$check);
      }

      $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
			$this->set('arrType',$arrType);

    }

    public function imtaiouconfirm()//IMtaiou
    {
     $data = $this->request->getData();
     $product_code = $data["product_code"];

     $this->set('product_code',$product_code);//セット
     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
     $Productname = $Product[0]->product_name;
     $this->set('Productname',$Productname);//セット

     $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
       'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
     ]);
     foreach ($Products as $value) {//$Productsそれぞれに対し
      $product_code= $value->product_code;
    }
    $this->set('product_code',$product_code);//セット

    $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
    }

    public function impreadd()
    {
      $this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

     $session = $this->request->getSession();
     $data = $session->read();//postデータ取得し、$dataと名前を付ける
    }

    public function typeimtaioupreadd()
    {
      $this->set('KouteiKensahyouHeads',$this->KouteiKensahyouHeads->newEntity());

     $session = $this->request->getSession();
     $data = $session->read();//postデータ取得し、$dataと名前を付ける

     $_SESSION['imdatanew'][0] = array(
       'id' => $_POST['id'],
       'version' => $_POST['version'],
       'type_im' => $_POST['type_im']
     );
    }

   public function imlogin()
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
           $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'imtaioudo']);
         }
       }
   }

   public function typeimlogin()
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
           $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'typeimtaioudo']);
         }
       }
   }

    public function imtaioudo()
    {
      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける
      $data = $sessiondata['kikakudata'];

      $Product = $this->Products->find()->where(['product_code' => $sessiondata['kikakudata'][1]['product_code']])->toArray();
      $product_code = $Product[0]->product_code;
      $this->set('product_code',$product_code);//セット
      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
        'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
      ]);
      foreach ($Products as $value) {//$Productsそれぞれに対し
       $product_code= $value->product_code;
     }
     $this->set('product_code',$product_code);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $ImKikakuTaiou = $this->ImKikakuTaious->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('ImKikakuTaiou',$ImKikakuTaiou);//セット

     $count = count($data);
     for($k=1; $k<=$count; $k++){

       if(!empty($data[$k]["kind_kensa"]) && !empty($data[$k]["size_num"])){

         $k = $k;
         $staff_id = $sessiondata['Auth']['User']['staff_id'];//ログイン中のuserのstaff_idに$staff_idという名前を付ける
         $data[$k]['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
         $data[$k]['created_at'] = date('Y-m-d H:i:s');

       }else{
         unset($data[$k]);
       }

     }

     $data = array_values($data);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
      if ($this->request->is('get')) {//getなら登録
        $ImKikakuTaiou = $this->ImKikakuTaious->patchEntities($ImKikakuTaiou, $data);
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
            if ($this->ImKikakuTaious->saveMany($ImKikakuTaiou)) {//saveManyで一括登録

            //旧DB更新
            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('im_kikaku_taiou');
            $table->setConnection($connection);

            for($k=0; $k<count($data); $k++){
              $connection->insert('im_kikaku_taiou', [
                'product_id' => $data[$k]["product_code"],
                'kensahyou_size' => $data[$k]["kensahyuo_num"],
                'kind_kensa' => $data[$k]["kind_kensa"],
                'im_size_num' => $data[$k]["size_num"]
              ]);
            }
            $connection = ConnectionManager::get('default');

            $mes = "※登録されました。";
            $this->set('mes',$mes);
            $connection->commit();// コミット5

            } else {

            $mes = "※登録できませんでした。";
            $this->set('mes',$mes);

            $this->Flash->error(__('The KensahyouSokuteidatasimdo could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
          }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10

      }

    }

    public function typeimtaioudo()
    {
      $session = $this->request->getSession();
      $data = $session->read();//postデータ取得し、$dataと名前を付ける

      $updated_staff = array('updated_staff'=>$data['Auth']['User']['staff_id']);
      $data["imdatanew"][0] = array_merge($data["imdatanew"][0],$updated_staff);

      $this->set('KensahyouHeads',$this->KensahyouHeads->newEntity());

      $KensahyouHeads = $this->KensahyouHeads->find()->where(['id' => $data["imdatanew"][0]['id']])->toArray();
      $product_code = $KensahyouHeads[0]->product_code;
      $tourokuData = [
        'product_code' => $product_code,
        'version' => $data["imdatanew"][0]['version'],
        'type_im' => $data["imdatanew"][0]['type_im'],
        'size_1' => $KensahyouHeads[0]->size_1,
        'upper_1' => $KensahyouHeads[0]->upper_1,
        'lower_1' => $KensahyouHeads[0]->lower_1,
        'size_2' => $KensahyouHeads[0]->size_2,
        'upper_2' => $KensahyouHeads[0]->upper_2,
        'lower_2' => $KensahyouHeads[0]->lower_2,
        'size_3' => $KensahyouHeads[0]->size_3,
        'upper_3' => $KensahyouHeads[0]->upper_3,
        'lower_3' => $KensahyouHeads[0]->lower_3,
        'size_4' => $KensahyouHeads[0]->size_4,
        'upper_4' => $KensahyouHeads[0]->upper_4,
        'lower_4' => $KensahyouHeads[0]->lower_4,
        'size_5' => $KensahyouHeads[0]->size_5,
        'upper_5' => $KensahyouHeads[0]->upper_5,
        'lower_5' => $KensahyouHeads[0]->lower_5,
        'size_6' => $KensahyouHeads[0]->size_6,
        'upper_6' => $KensahyouHeads[0]->upper_6,
        'lower_6' => $KensahyouHeads[0]->lower_6,
        'size_7' => $KensahyouHeads[0]->size_7,
        'upper_7' => $KensahyouHeads[0]->upper_7,
        'lower_7' => $KensahyouHeads[0]->lower_7,
        'size_8' => $KensahyouHeads[0]->size_8,
        'upper_8' => $KensahyouHeads[0]->upper_8,
        'lower_8' => $KensahyouHeads[0]->lower_8,
        'size_9' => $KensahyouHeads[0]->size_9,
        'text_10' => $KensahyouHeads[0]->text_10,
        'text_11' => $KensahyouHeads[0]->text_11,
        'bik' => $KensahyouHeads[0]->bik,
        'status' => $KensahyouHeads[0]->status,
        'created_at' => date('Y-m-d H:i:s'),
        'created_staff' => $data["imdatanew"][0]['updated_staff']
      ];
/*
      echo "<pre>";
      print_r($tourokuData);
      echo "</pre>";
*/
      if ($this->request->is('get')) {//getなら登録
        $KouteiKensahyouHead = $this->KensahyouHeads->patchEntities($this->KensahyouHeads->newEntity(), $data["imdatanew"][0]);
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->KensahyouHeads->updateAll(
        //    ['version' => $data["imdatanew"][0]['version'], 'type_im' => $data["imdatanew"][0]['type_im'], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data["imdatanew"][0]['updated_staff']],
            ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data["imdatanew"][0]['updated_staff']],
            ['id'  => $data["imdatanew"][0]['id']]
            )){

              $KensahyouHeads = $this->KensahyouHeads->patchEntity($this->KensahyouHeads->newEntity(), $tourokuData);
  						$this->KensahyouHeads->save($KensahyouHeads);

              $KensahyouHeads = $this->KensahyouHeads->find()->where(['id' => $data["imdatanew"][0]['id']])->toArray();

              //旧DBに登録
  						$connection = ConnectionManager::get('DB_ikou_test');
  						$table = TableRegistry::get('kensahyou_head');
  						$table->setConnection($connection);

              $delete_flag = 1;
              $versionmoto = $data["imdatanew"][0]['version'] - 1;
              $updater = "UPDATE kensahyou_head set status ='".$delete_flag."'
              where product_id ='".$product_code."' and version ='".$versionmoto."'";
              $connection->execute($updater);

  							$connection->insert('kensahyou_head', [
                  'product_id' => $product_code,
                  'version' => $data["imdatanew"][0]['version'],
            //      'type_im' => $data["imdatanew"][0]['type_im'],
                  'size_1' => $KensahyouHeads[0]->size_1,
                  'upper_1' => $KensahyouHeads[0]->upper_1,
                  'lower_1' => $KensahyouHeads[0]->lower_1,
                  'size_2' => $KensahyouHeads[0]->size_2,
                  'upper_2' => $KensahyouHeads[0]->upper_2,
                  'lower_2' => $KensahyouHeads[0]->lower_2,
                  'size_3' => $KensahyouHeads[0]->size_3,
                  'upper_3' => $KensahyouHeads[0]->upper_3,
                  'lower_3' => $KensahyouHeads[0]->lower_3,
                  'size_4' => $KensahyouHeads[0]->size_4,
                  'upper_4' => $KensahyouHeads[0]->upper_4,
                  'lower_4' => $KensahyouHeads[0]->lower_4,
                  'size_5' => $KensahyouHeads[0]->size_5,
                  'upper_5' => $KensahyouHeads[0]->upper_5,
                  'lower_5' => $KensahyouHeads[0]->lower_5,
                  'size_6' => $KensahyouHeads[0]->size_6,
                  'upper_6' => $KensahyouHeads[0]->upper_6,
                  'lower_6' => $KensahyouHeads[0]->lower_6,
                  'size_7' => $KensahyouHeads[0]->size_7,
                  'upper_7' => $KensahyouHeads[0]->upper_7,
                  'lower_7' => $KensahyouHeads[0]->lower_7,
                  'size_8' => $KensahyouHeads[0]->size_8,
                  'upper_8' => $KensahyouHeads[0]->upper_8,
                  'lower_8' => $KensahyouHeads[0]->lower_8,
                  'size_9' => $KensahyouHeads[0]->size_9,
                  'text_10' => $KensahyouHeads[0]->text_10,
                  'text_11' => $KensahyouHeads[0]->text_11,
                  'bik' => $KensahyouHeads[0]->bik,
                  'status' => 0
  							]);

                $connection = ConnectionManager::get('default');//新DBに戻る
                $table->setConnection($connection);

              $mes = "※更新されました。";
   						$this->set('mes',$mes);
              $connection->commit();// コミット5
            } else {
              $mes = "※更新されませんでした。";
   						$this->set('mes',$mes);
              $this->Flash->error(__('The KensahyouSokuteidatasimdo could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10
      }

    }

    public function indexhome()//取り込み画面
    {
      $this->request->session()->destroy(); // セッションの破棄

      $imKikakus = $this->ImKikakus->newEntity();
      $this->set('imKikakus', $imKikakus);

      $today = date("Y-m-d");

      $connection = ConnectionManager::get('DB_ikou_test');//旧DBを参照
      $table = TableRegistry::get('schedule_koutei');
      $table->setConnection($connection);
//今日以降のスケジュールのデータを旧DBから引っ張り出す
      $sql = "SELECT datetime,seikeiki,product_id,present_kensahyou,product_name,tantou FROM schedule_koutei".
       " where datetime >= '".$today."' order by datetime asc";
      $arrSchedule_koutei = $connection->execute($sql)->fetchAll('assoc');

      $connection = ConnectionManager::get('default');
      $table->setConnection($connection);

      $arrTouroku = array();
      for($i=0; $i<count($arrSchedule_koutei); $i++){//新DBにデータが存在しなければ新DBに保存するための配列に追加する

        $ScheduleKouteiData = $this->ScheduleKouteis->find()->where(['datetime' => $arrSchedule_koutei[$i]["datetime"], 'seikeiki' => $arrSchedule_koutei[$i]["seikeiki"]])->toArray();

        if(!isset($ScheduleKouteiData[0])){

          $arrTouroku[] = [
            'datetime' => $arrSchedule_koutei[$i]["datetime"],
            'seikeiki' => $arrSchedule_koutei[$i]["seikeiki"],
            'product_code' => $arrSchedule_koutei[$i]["product_id"],
            'present_kensahyou' => $arrSchedule_koutei[$i]["present_kensahyou"],
            'product_name' => $arrSchedule_koutei[$i]["product_name"],
            'tantou' => $arrSchedule_koutei[$i]["tantou"]
          ];

        }

      }

      if(isset($arrTouroku[0])){//登録するデータがある場合は一括登録

        $ScheduleKouteis = $this->ScheduleKouteis->patchEntities($this->ScheduleKouteis->newEntity(), $arrTouroku);
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->ScheduleKouteis->saveMany($ScheduleKouteis)){
            $connection->commit();// コミット5
          } else {
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
          }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10
      }


      $KadouSeikeiDatab = $this->KadouSeikeis->find()->where(['present_kensahyou' => 0])->order(["product_code"=>"ASC"])->toArray();//'present_kensahyou' => 0となるデータをKadouSeikeisテーブルから配列で取得

      $arrProduct = array();
      for($i=0; $i<count($KadouSeikeiDatab); $i++){//'present_kensahyou' => 0の製品を重複なしで集める
        $arrProduct[] = $KadouSeikeiDatab[$i]["product_code"];
      }
      $arrProduct = array_unique($arrProduct, SORT_REGULAR);//重複削除
      $arrProduct = array_values($arrProduct);

      for($i=0; $i<count($arrProduct); $i++){//それぞれの品番に対して、最新のロットの日報とその日報の一つ前の日報の差を取得し、２４時間成形+２時間以内は同一ロットとみなす➝前回ロットの'present_kensahyou' => 1にする
        ${"product_code".$i} = $arrProduct[$i];
        $KadouSeikeiPro = $this->KadouSeikeis->find()->where(['present_kensahyou' => 0, 'product_code' => ${"product_code".$i}])->order(["starting_tm"=>"desc"])->toArray();

        for($j=1; $j<count($KadouSeikeiPro); $j++){

          $zenkaihikaku = strtotime($KadouSeikeiPro[$j-1]["starting_tm"]) - strtotime($KadouSeikeiPro[$j]["starting_tm"]);

          if($zenkaihikaku < 93600){//この場合'present_kensahyou' => 1にする

            $KadouSeikeis = $this->KadouSeikeis->patchEntity($this->KadouSeikeis->newEntity(), $this->request->getData());
            $connection = ConnectionManager::get('default');//トランザクション1
     				// トランザクション開始2
     				$connection->begin();//トランザクション3
     				try {//トランザクション4
   						if ($this->KadouSeikeis->updateAll(//検査終了時間の更新
   							['present_kensahyou' => 1, 'updated_at' => date('Y-m-d H:i:s')],
   							['id'  => $KadouSeikeiPro[$j]["id"]]
   						)){

    							//旧DBに単価登録
    							$connection = ConnectionManager::get('DB_ikou_test');
    							$table = TableRegistry::get('kadou_seikei');
    							$table->setConnection($connection);

                  $num = 1;
                  $updater = "UPDATE kadou_seikei set present_kensahyou ='".$num."'
                   where pro_num ='".$KadouSeikeiPro[$j]['product_code']."' and seikeiki_id ='".$KadouSeikeiPro[$j]['seikeiki_code']."' and starting_tm ='".$KadouSeikeiPro[$j]['starting_tm']."'";
                   $connection->execute($updater);

    							$connection = ConnectionManager::get('default');//新DBに戻る
    							$table->setConnection($connection);

                  $connection->commit();// コミット5

                } else {
                  throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                }

              } catch (Exception $e) {//トランザクション7
              //ロールバック8
                $connection->rollback();//トランザクション9
              }//トランザクション10

          }

        }

      }

      $countnamec = 1;//今日のデータをカウントする変数
      $this->set('countnamec',$countnamec);//セット
      $countnamed = 1;//昨日までのデータをカウントする変数
      $this->set('countnamed',$countnamed);//セット

      $ScheduleKouteisDatac = $this->ScheduleKouteis->find()->where(['datetime >=' => $today." 8:00", 'datetime <=' => $today."23:59", 'present_kensahyou' => 0])->order(["datetime"=>"desc"])->toArray();

      for($i=0; $i<count($ScheduleKouteisDatac); $i++){//既に検査済みの場合は'present_kensahyou' => 1に更新する

        $scheduleId = $ScheduleKouteisDatac[$i]->id;
        $schedulepro = $ScheduleKouteisDatac[$i]->product_code;
        $scheduleday = $ScheduleKouteisDatac[$i]->datetime->format('Y-m-d');

        $KensahyouSokuteidatasData = $this->KensahyouSokuteidatas->find()->where(['product_code' => $schedulepro, 'manu_date' => $scheduleday])->order(["product_code"=>"desc"])->toArray();
        if(isset($KensahyouSokuteidatasData[0])){

          $ScheduleKouteis = $this->ScheduleKouteis->patchEntity($this->ScheduleKouteis->newEntity(), $this->request->getData());
          $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
          $connection->begin();//トランザクション3
          try {//トランザクション4
            if ($this->ScheduleKouteis->updateAll(//検査終了時間の更新
              ['present_kensahyou' => 1],
              ['id'  => $scheduleId]
            )){

                //旧DB
                $connection = ConnectionManager::get('DB_ikou_test');
                $table = TableRegistry::get('schedule_koutei');
                $table->setConnection($connection);

                $num = 1;
                $datetime = $ScheduleKouteisDatac[$i]->datetime;
                $seikeiki = $ScheduleKouteisDatac[$i]->seikeiki;
                $updater = "UPDATE schedule_koutei set present_kensahyou ='".$num."'
                 where product_id ='".$schedulepro."' and datetime ='".$datetime."' and seikeiki ='".$seikeiki."'";
                 $connection->execute($updater);

                $connection = ConnectionManager::get('default');//新DBに戻る
                $table->setConnection($connection);

                $connection->commit();// コミット5

              } else {
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }

            } catch (Exception $e) {//トランザクション7
            //ロールバック8
              $connection->rollback();//トランザクション9
            }//トランザクション10

          }else{//検査していない場合

            ${"product_codec".$countnamec} = $ScheduleKouteisDatac[$i]->product_code;
            ${"ProductDatac".$countnamec} = $this->Products->find()->where(['product_code' => ${"product_codec".$countnamec}])->toArray();
            if(isset(${"ProductDatac".$countnamec}[0])){
              ${"product_namec".$countnamec} = ${"ProductDatac".$countnamec}[0]->product_name;

              ${"KadouSeikeiidc".$countnamec} = "sch_".$scheduleId;

              $this->set('KadouSeikeiidc'.$countnamec,${"KadouSeikeiidc".$countnamec});

              ${"KadouSeikeifinishing_tm".$countnamec} = $ScheduleKouteisDatac[$i]->datetime->format('Y-m-d H:i:s');
              ${"KadouSeikeifinishing_datec".$countnamec} = substr(${"KadouSeikeifinishing_tm".$countnamec},0,4)."-".substr(${"KadouSeikeifinishing_tm".$countnamec},5,2)."-".substr(${"KadouSeikeifinishing_tm".$countnamec},8,2);

              $this->set('product_codec'.$countnamec,${"product_codec".$countnamec});
              $this->set('product_namec'.$countnamec,${"product_namec".$countnamec});
              $this->set('KadouSeikeifinishing_datec'.$countnamec,${"KadouSeikeifinishing_datec".$countnamec});

              $session = $this->request->session();
              $session->write('product_codec', ${"product_codec".$countnamec});
              $session->write('product_namec', ${"product_namec".$countnamec});

              $countnamec += 1;//ファイル名の日付を識別するためカウント
              $this->set('countnamec',$countnamec);//セット

            }

          }

      }


      $KadouSeikeiDatac = $this->KadouSeikeis->find()->where(['present_kensahyou' => 0])->toArray();//'present_kensahyou' => 0となるデータをKadouSeikeisテーブルから配列で取得
      for($i=1; $i<=count($KadouSeikeiDatac); $i++){//KadouSeikeisテーブルの'present_kensahyou' => 0のデータに対して
        $KadouSeikeisId = $KadouSeikeiDatac[$i-1]->id;
        $KadouSeikeispro = $KadouSeikeiDatac[$i-1]->product_code;
        $KadouSeikeisdaymoto = $KadouSeikeiDatac[$i-1]->starting_tm->format('Y-m-d_H_:i:s');

        list($a, $h, $c) = explode('_', $KadouSeikeisdaymoto);
        if(8 <= intval($h) && intval($h) <= 23){//開始時間が８時～２３時の場合はその日がmanu_date

          $KadouSeikeisday = $KadouSeikeiDatac[$i-1]->starting_tm->format('Y-m-d');

        }else{//開始時間が８時～２３時でない場合はその前日がmanu_date

          $KadouSeikeisdayymd = $KadouSeikeiDatac[$i-1]->starting_tm->format('Y-m-d');
          $KadouSeikeisday = date("Y-m-d", strtotime("-1 day", strtotime($KadouSeikeisdayymd)));

        }

        $KensahyouSokuteidatasData = $this->KensahyouSokuteidatas->find()->where(['product_code' => $KadouSeikeispro, 'manu_date' => $KadouSeikeisday])->order(["product_code"=>"desc"])->toArray();

        if(isset($KensahyouSokuteidatasData[0])){//検査済みの場合は'present_kensahyou' => 1

          $KadouSeikeis = $this->KadouSeikeis->patchEntity($this->KadouSeikeis->newEntity(), $this->request->getData());
          $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
          $connection->begin();//トランザクション3
          try {//トランザクション4
            if ($this->KadouSeikeis->updateAll(//検査終了時間の更新
              ['present_kensahyou' => 1],
              ['id'  => $KadouSeikeisId]
            )){

                //旧DBに単価登録
                $connection = ConnectionManager::get('DB_ikou_test');
                $table = TableRegistry::get('kadou_seikei');
                $table->setConnection($connection);

                $num = 1;
                $KadouSeikeispro = $KadouSeikeiDatac[$i-1]->product_code;
                $KadouSeikeisseikeiki = $KadouSeikeiDatac[$i-1]->seikeiki_code;
                $KadouSeikeisstartingtm = $KadouSeikeiDatac[$i-1]->starting_tm->format('Y-m-d H:i:s');
/*
                echo "<pre>";
                print_r($KadouSeikeisstartingtm);
                echo "</pre>";
*/
                $updater = "UPDATE kadou_seikei set present_kensahyou ='".$num."'
                 where pro_num ='".$KadouSeikeispro."' and seikeiki_id ='".$KadouSeikeisseikeiki."' and starting_tm ='".$KadouSeikeisstartingtm."'";
                 $connection->execute($updater);

                $connection = ConnectionManager::get('default');//新DBに戻る
                $table->setConnection($connection);

                $connection->commit();// コミット5

              } else {
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }

            } catch (Exception $e) {//トランザクション7
            //ロールバック8
              $connection->rollback();//トランザクション9
            }//トランザクション10

          }else{//検査していない場合

          ${"KadouSeikeifinishing_tm".$i} = $KadouSeikeiDatac[$i-1]->finishing_tm->format('Y-m-d H:i:s');//配列の$i番目のfinishing_tm
          ${"KadouSeikeifinishing_date".$i} = substr(${"KadouSeikeifinishing_tm".$i},0,4)."-".substr(${"KadouSeikeifinishing_tm".$i},5,2)."-".substr(${"KadouSeikeifinishing_tm".$i},8,2);//finishing_tmの年月日を取得

            if(substr(${"KadouSeikeifinishing_date".$i},0,10) === substr($today,0,10)){//今日のデータの場合は表示しない
              $countnamed = $countnamed;
            }else{//今日ではないデータの場合
              ${"KadouSeikeiidd".$countnamed} = $KadouSeikeiDatac[$i-1]->id;//以下、index2に持っていくデータをセット
              $this->set('KadouSeikeiidd'.$countnamed,${"KadouSeikeiidd".$countnamed});//セット

              ${"product_coded".$countnamed} = $KadouSeikeiDatac[$i-1]->product_code;//以下、index2に持っていくデータをセット
              ${"ProductDatad".$countnamed} = $this->Products->find()->where(['product_code' => ${"product_coded".$countnamed}])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
              if(isset(${"ProductDatad".$countnamed}[0])){
                ${"product_named".$countnamed} = ${"ProductDatad".$countnamed}[0]->product_name;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける
                $this->set('product_named'.$countnamed,${"product_named".$countnamed});//セット
              }else{
                ${"product_named".$countnamed} = "";//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける
                $this->set('product_named'.$countnamed,${"product_named".$countnamed});//セット
              }
              ${"KadouSeikeifinishing_tm".$countnamed} = $KadouSeikeiDatac[$i-1]->finishing_tm->format('Y-m-d H:i:s');//配列の$i番目のfinishing_tm
              ${"KadouSeikeifinishing_dated".$countnamed} = substr(${"KadouSeikeifinishing_tm".$countnamed},0,4)."-".substr(${"KadouSeikeifinishing_tm".$countnamed},5,2)."-".substr(${"KadouSeikeifinishing_tm".$countnamed},8,2);//finishing_tmの年月日を取得

              $this->set('product_coded'.$countnamed,${"product_coded".$countnamed});//セット

              $this->set('KadouSeikeifinishing_dated'.$countnamed,${"KadouSeikeifinishing_dated".$countnamed});//セット

              $session = $this->request->session();
              $session->write('product_coded', ${"product_coded".$countnamed});

              $countnamed += 1;//ファイル名の日付を識別するためカウント
              $this->set('countnamed',$countnamed);//セット
            }
          }
      }

    }

     public function torikomi()//取り込み（画面なし自動で次のページへ）
    {

      $dirName = 'data_IM測定/';//ローカル//IM測定器ナンバー１のフォルダ
  //    $dirName = '/data/share/syukkaIM/data_IM測定/';//192//IM測定器ナンバー１のフォルダ
      $countname = 0;//ファイル名のかぶりを防ぐため

      if(is_dir($dirName)){//ファイルがディレクトリかどうかを調べる(ディレクトリであるので次へ)
    	  if($dir = opendir($dirName)){//opendir でディレクトリ・ハンドルをオープンし、readdir でディレクトリ（フォルダ）内のファイル一覧を取得する。（という定石）
    	    while(($folder = readdir($dir)) !== false){//親while（ディレクトリ内のファイル一覧を取得する）
    	      if($folder != '.' && $folder != '..'){//フォルダーなら("."が無いならフォルダーという認識)
    	        if(strpos($folder,'.',0)==''){//$folderが'.'を含まなかった時
    	          if(is_dir($dirName.$folder)){//$dirName.$folderがディレクトリかどうかを調べる
    	            if($child_dir = opendir($dirName.$folder)){//opendir で$dirName.$folderの子ディレクトリをオープン
              			$folder_check = 0;//$folder_checkを定義
                			if(strpos($folder,'_',0)==''){//$folderが'_'を含まなかった時
                				$folder_check = 1;//$folder_check=1にする
                			}else{//$folderが'_'を含む時
                				$num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                				$product_code = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する

                          while(($file = readdir($child_dir)) !== false){//子while

                               if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN

                                  $fp = fopen('data_IM測定/'.$folder.'/'.$file, "r");//kesuyatu
                          //        $fp = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, "r");//kesuyatu

                                   if(substr($file, 0, 5) != "sumi_" ){//sumi_でないファイルだけOPEN
                                    $countname += 1;//ファイル名がかぶらないようにカウントしておく

                                    $fp = fopen('data_IM測定/'.$folder.'/'.$file, "r");//ローカル
                          //          $fp = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, "r");//192
                              			$this->set('fp',$fp);

                                    $fpcount = fopen('data_IM測定/'.$folder.'/'.$file, 'r' );
                          //          $fpcount = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, 'r' );
                              			for( $count = 0; fgets( $fpcount ); $count++ );

                              			$arrFp = array();//空の配列を作る
                                    for ($k=1; $k<=$count; $k++) {
                                        $line = fgets($fp);//ファイル$fpの上の１行を取る
                                        $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                        $keys=array_keys($ImData);
                                        $ImData = array_combine( $keys, $ImData );
                                				$arrFp[] = $ImData;//配列に追加する
                                    }

                                    $arrLot_nums = array();//lot_numの重複チェック
                                    for ($k=4; $k<=$count-1; $k++) {
                                      ${"arrLot_nums".$countname}[] = $arrFp[$k][2];
                                    }
                                    $arruniLot_num = array_unique(${"arrLot_nums".$countname});//lot_numの重複削除
                                    ${"arruniLot_num".$countname} = array_values($arruniLot_num);//配列の添字を振り直し
                                    $cntLot = count(${"arruniLot_num".$countname});//配列の要素数確認

                                    //ImSokuteidataHeadsの登録用データをセット
                                    $arrIm_head = array();//空の配列を作る
                                    for ($k=1; $k<=$cntLot; $k++) {
                                      $arrIm_heads = array();//空の配列を作る
                                      $len = mb_strlen($folder);
                                      $product_code = mb_substr($folder,0,$num);
                                      $inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);
                                      $kind_kensa = substr($folder,$num+1,$len);

                                      $session = $this->request->session();
                                      $session->write('kind_kensa', $kind_kensa);

                                      $arrIm_heads[] = $product_code;
                                      $arrIm_heads[] = $kind_kensa;
                                      $arrIm_heads[] = $inspec_date;
                                      $arrIm_heads[] = ${"arruniLot_num".$countname}[$k-1];
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = 0;

                                      $name_heads = array('product_code', 'kind_kensa', 'inspec_date', 'lot_num', 'torikomi', 'delete_flag');
                                      $arrIm_heads = array_combine($name_heads, $arrIm_heads);
                                      $arrIm_head[] = $arrIm_heads;
                                    }

                                     //ImSokuteidataHeadsデータベースに登録
                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->newEntity();//newentityに$userという名前を付ける

                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->patchEntities($imSokuteidataHeads, $arrIm_head);
                                    $connection = ConnectionManager::get('default');//トランザクション1
                                    // トランザクション開始2
                                    $connection->begin();//トランザクション3
                                    try {//トランザクション4
                                      if ($this->ImSokuteidataHeads->saveMany($imSokuteidataHeads)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                        $connection = ConnectionManager::get('DB_ikou_test');
                                        $table = TableRegistry::get('im_sokuteidata_head');
                                        $table->setConnection($connection);

                                        $connection->insert('im_sokuteidata_head', [
                                            'product_id' => $arrIm_head[0]['product_code'],
                                            'kind_kensa' => $arrIm_head[0]['kind_kensa'],
                                            'inspec_date' => $arrIm_head[0]['inspec_date'],
                                            'lot_num' => $arrIm_head[0]['lot_num'],
                                            'torikomi' => $arrIm_head[0]['torikomi']
                                        ]);
                                        $connection = ConnectionManager::get('default');

                                          //ImKikakusの登録用データをセット
                                          $cnt = count($arrFp[1]);
                                          $arrImKikakus = array_slice($arrFp , 1, 3);
                                          $arrIm_kikaku = array();

                                        for ($m=1; $m<=$cntLot; $m++) {
                                          for ($k=7; $k<=$cnt-2; $k++) {//

                                            $arrIm_kikaku_data = array();

                                            $size_num = $k-6;
                                            $size = $arrImKikakus[0][$k];
                                            $upper = $arrImKikakus[1][$k];
                                            $lower = $arrImKikakus[2][$k];

                                            $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => ${"arruniLot_num".$countname}[$m-1], 'kind_kensa' => $kind_kensa])->order(["id"=>"desc"])->toArray();
                                            $im_sokuteidata_head_id = $ImSokuteidataHeadsData[0]->id;

                                            $arrIm_kikaku_data[] = $im_sokuteidata_head_id;//配列に追加する
                                            $arrIm_kikaku_data[] = $size_num;//配列に追加する
                                            $arrIm_kikaku_data[] = $size;//配列に追加する
                                            $arrIm_kikaku_data[] = $upper;//配列に追加する
                                            $arrIm_kikaku_data[] = $lower;//配列に追加する
                                            $name_kikaku = array('im_sokuteidata_head_id', 'size_num', 'size', 'upper', 'lower');
                                            $arrIm_kikaku_data = array_combine($name_kikaku, $arrIm_kikaku_data);
                                            $arrIm_kikaku[] = $arrIm_kikaku_data;

                                          }
                                        }

                                           //ImKikakusデータベースに登録
                                          $imKikakus = $this->ImKikakus->newEntity();//newentityに$userという名前を付ける

                                          $imKikakus = $this->ImKikakus->patchEntities($imKikakus, $arrIm_kikaku);
                                             if ($this->ImKikakus->saveMany($imKikakus)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $table = TableRegistry::get('im_kikaku');
                                               $table->setConnection($connection);

                                               $sql = "SELECT id FROM im_sokuteidata_head".
                                               " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                 order by id desc limit 1";
                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                               for($k=0; $k<count($arrIm_kikaku); $k++){
                                                 $connection->insert('im_kikaku', [
                                                     'id' => $im_sokuteidata_head_id[0]["id"],
                                                     'size_num' => $arrIm_kikaku[$k]["size_num"],
                                                     'size' => $arrIm_kikaku[$k]["size"],
                                                     'upper' => $arrIm_kikaku[$k]["upper"],
                                                     'lower' => $arrIm_kikaku[$k]["lower"]
                                                 ]);
                                               }

                                               $connection = ConnectionManager::get('default');


                                                //ImSokuteidataResultsの登録用データをセット
                                                $inspec_datetime = substr($arrFp[4][1],0,4)."-".substr($arrFp[4][1],5,2)."-".substr($arrFp[4][1],8,mb_strlen($arrFp[4][1])-8);
                                                $arrIm_Result = array();

                                                 $arrImResults = array_slice($arrFp , 4, $count);
                                                 for ($j=0; $j<=$count-5; $j++) {
                                                    for ($k=7; $k<=$cnt-2; $k++) {
                                                      $arrIm_Result_data = array();

                                                      $serial = $arrImResults[$j][3];
                                                      $size_num = $k-6;
                                                      $result = $arrImResults[$j][$k];
                                                      $status = $arrImResults[$j][4];

                                                      $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => $arrFp[$j+4][2], 'kind_kensa' => $kind_kensa])->order(["id"=>"desc"])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                                      $im_sokuteidata_head_id = $ImSokuteidataHeadsData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

                                                      $arrIm_Result_data[] = $im_sokuteidata_head_id;//配列に追加する
                                                      $arrIm_Result_data[] = $inspec_datetime;//配列に追加する
                                                      $arrIm_Result_data[] = $serial;//配列に追加する
                                                      $arrIm_Result_data[] = $size_num;//配列に追加する
                                                      $arrIm_Result_data[] = $result;//配列に追加する
                                                      $arrIm_Result_data[] = $status;//配列に追加する
                                                      $name_Result = array('im_sokuteidata_head_id', 'inspec_datetime', 'serial', 'size_num', 'result', 'status');
                                                      $arrIm_Result_data = array_combine($name_Result, $arrIm_Result_data);

                                                      $arrIm_Result[] = $arrIm_Result_data;
                                                  }
                                                 }

                                                  //ImSokuteidataResultsデータベースに登録
                                                  $imSokuteidataResults = $this->ImSokuteidataResults->newEntity();//newentityに$userという名前を付ける

                              //                    echo "<pre>";
                                //                  print_r("ImSokuteidataResults");
                                  //                echo "</pre>";
                                    //              echo "<pre>";
                                      //            print_r($arrIm_Result);
                                        //          echo "</pre>";

                                                  $imSokuteidataResults = $this->ImSokuteidataResults->patchEntities($imSokuteidataResults, $arrIm_Result);
                                                  if ($this->ImSokuteidataResults->saveMany($imSokuteidataResults)) {//ImSokuteidataResultsをsaveできた時（saveManyで一括登録）

                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $table = TableRegistry::get('im_sokuteidata_result');
                                                    $table->setConnection($connection);

                                                    $sql = "SELECT id FROM im_sokuteidata_head".
                                                    " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                     and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                      order by id desc limit 1";
                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                                    for($k=0; $k<count($arrIm_Result); $k++){
                                                      $connection->insert('im_sokuteidata_result', [
                                                          'id' => $im_sokuteidata_head_id[0]["id"],
                                                          'inspec_datetime' => $arrIm_Result[$k]["inspec_datetime"],
                                                          'serial' => $arrIm_Result[$k]["serial"],
                                                          'size_num' => $arrIm_Result[$k]["size_num"],
                                                          'result' => $arrIm_Result[$k]["result"],
                                                          'status' => $arrIm_Result[$k]["status"]
                                                      ]);
                                                    }

                                                    $connection = ConnectionManager::get('default');

                                                    } else {
                                                      $this->Flash->error(__('This data1 could not be saved. Please, try again.'));
                                                      throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                                  }

                                            } else {
                                              $this->Flash->error(__('This data2 could not be saved. Please, try again.'));
                                              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                            }
                                            $connection->commit();// コミット5
                                      } else {
                                        $this->Flash->error(__('This data3 could not be saved. Please, try again.'));
                                        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                      }
                                    } catch (Exception $e) {//トランザクション7
                                    //ロールバック8
                                      $connection->rollback();//トランザクション9
                                  }//トランザクション10

                                  }else{
                                   print_r('else ');
                                  }


                                  $output_dir = 'backupData_IM測定/'.$folder;
                          //        $output_dir = '/data/share/syukkaIM/backupData_IM測定/'.$folder;

                                  if (! file_exists($output_dir)) {//backupData_IM測定の中に$folderがないとき
                                   if (mkdir($output_dir)) {
                                      $Filebi2 = mb_substr($file,0,-4);
                                      if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."005.bi2", $output_dir.'/'.$Filebi2."005.bi2")) {
                                        //DBに登録fileCopyChecks

                                        $arrfiledate = [
                                  				'name_folder' => $folder,
                                  				'name_file' => $file,
                                  				'created_at' => date('Y-m-d H:i:s')
                                        ];

                                        $fileCopyChecks = $this->FileCopyChecks->newEntity();
                                        $fileCopyCheck = $this->FileCopyChecks->patchEntity($fileCopyChecks, $arrfiledate);
                                        $this->FileCopyChecks->save($fileCopyCheck);

                                        fclose($fp);
                                        $fp = fopen('data_IM測定/'.$folder.'/'.$file, "r");
                            //            $fp = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, "r");
                                        $fpcount = fopen('data_IM測定/'.$folder.'/'.$file, 'r' );
                            //            $fpcount = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, 'r' );
                                  			for( $count = 0; fgets( $fpcount ); $count++ );

                                  			$arrFpmoto = array();//空の配列を作る
                                        for ($k=1; $k<=$count; $k++) {
                                            $line = fgets($fp);//ファイル$fpの上の１行を取る
                                            $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                            $keys=array_keys($ImData);
                                            $ImData = array_combine( $keys, $ImData );
                                    				$arrFpmoto[] = $ImData;//配列に追加する
                                        }

                                        $fpnew = fopen($output_dir.'/'.$file, "r");
                                        $fpcountnew = fopen($output_dir.'/'.$file, 'r' );
                                  			for( $count = 0; fgets( $fpcountnew ); $count++ );

                                  			$arrFnew = array();//空の配列を作る
                                        for ($k=1; $k<=$count; $k++) {
                                            $line = fgets($fpnew);//ファイル$fpの上の１行を取る
                                            $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                            $keys=array_keys($ImData);
                                            $ImData = array_combine( $keys, $ImData );
                                    				$arrFnew[] = $ImData;//配列に追加する
                                        }

                                        $arrayDiff = array();
                                        $copy_check = 0;
                                        for ($k=0; $k<count($arrFpmoto); $k++) {
                                          array_diff($arrFpmoto[$k], $arrFnew[$k]);
                                          if(isset(array_diff($arrFpmoto[$k], $arrFnew[$k])[0])){
                                            $copy_check = $copy_check + 1;
                                          }
                                        }

                                        if($copy_check == 0){//元ファイルとコピーしたファイルが一致している場合
                                          $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $FileCopyChecks[0]->id;

                                          $this->FileCopyChecks->updateAll(
                                            ['copy_status' => 1, 'updated_at' => date('Y-m-d H:i:s')],
                                            ['id'  => $id]
                                          );

                                          $countfile =  1;//フォルダーに入る最初のファイル

                                          $toCopyFile = "sumi_".$countfile."_".$file;
                                          if (rename($output_dir.'/'.$file, $output_dir.'/'.$toCopyFile)) {//ファイル名変更
                                            unlink($dirName.$folder.'/'.$file);
                                            unlink($dirName.$folder.'/'.$Filebi2."005.bi2");
                                          }

                                        }else{//元ファイルとコピーしたファイルが一致していない場合
                                          $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $FileCopyChecks[0]->id;

                                          $this->FileCopyChecks->updateAll(
                                            ['copy_status' => 9, 'updated_at' => date('Y-m-d H:i:s')],
                                            ['id'  => $id]
                                          );
                                        }

                                      }
                                    }

                                  } else {//backupData_IM測定の中に$folderがあるとき
                                    $Filebi2 = mb_substr($file,0,-4);
                                    if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."005.bi2", $output_dir.'/'.$Filebi2."005.bi2")) {
                                      //DBに登録

                                      $arrfiledate = [
                                        'name_folder' => $folder,
                                        'name_file' => $file,
                                        'created_at' => date('Y-m-d H:i:s')
                                      ];

                                      $fileCopyChecks = $this->FileCopyChecks->newEntity();
                                      $fileCopyCheck = $this->FileCopyChecks->patchEntity($fileCopyChecks, $arrfiledate);
                                      $this->FileCopyChecks->save($fileCopyCheck);//FileCopyChecksテーブルに登録

                                      fclose($fp);
                                      $fp = fopen('data_IM測定/'.$folder.'/'.$file, "r");
                            //          $fp = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, "r");
                                      $fpcount = fopen('data_IM測定/'.$folder.'/'.$file, 'r' );
                            //          $fpcount = fopen('/data/share/syukkaIM/data_IM測定/'.$folder.'/'.$file, 'r' );
                                      for( $count = 0; fgets( $fpcount ); $count++ );

                                      $arrFpmoto = array();//空の配列を作る
                                      for ($k=1; $k<=$count; $k++) {
                                          $line = fgets($fp);//ファイル$fpの上の１行を取る
                                          $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                          $keys=array_keys($ImData);
                                          $ImData = array_combine( $keys, $ImData );
                                          $arrFpmoto[] = $ImData;//配列に追加する
                                      }

                                      $fpnew = fopen($output_dir.'/'.$file, "r");
                                      $fpcountnew = fopen($output_dir.'/'.$file, 'r' );
                                      for( $count = 0; fgets( $fpcountnew ); $count++ );

                                      $arrFnew = array();//空の配列を作る
                                      for ($k=1; $k<=$count; $k++) {
                                          $line = fgets($fpnew);//ファイル$fpの上の１行を取る
                                          $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                          $keys=array_keys($ImData);
                                          $ImData = array_combine( $keys, $ImData );
                                          $arrFnew[] = $ImData;//配列に追加する
                                      }

                                      $arrayDiff = array();
                                      $copy_check = 0;
                                      for ($k=0; $k<count($arrFpmoto); $k++) {
                                        array_diff($arrFpmoto[$k], $arrFnew[$k]);
                                        if(isset(array_diff($arrFpmoto[$k], $arrFnew[$k])[0])){
                                          $copy_check = $copy_check + 1;
                                        }
                                      }

                                      if($copy_check == 0){//元ファイルとコピーしたファイルが一致している場合
                                        $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $FileCopyChecks[0]->id;

                                        $this->FileCopyChecks->updateAll(//FileCopyChecksテーブルのcopy_statusを１に更新
                                          ['copy_status' => 1, 'updated_at' => date('Y-m-d H:i:s')],
                                          ['id'  => $id]
                                        );

                                        $arrAllfiles = glob("$output_dir/*");
                                        $countfile = count($arrAllfiles) - 1;//フォルダーのファイルが二つずつ増えるから

                                        $toCopyFile = "sumi_".$countfile."_".$file;
                                        if (rename($output_dir.'/'.$file, $output_dir.'/'.$toCopyFile)) {//ファイル名変更（元ファイルを削除）
                                          unlink($dirName.$folder.'/'.$file);
                                          unlink($dirName.$folder.'/'.$Filebi2."005.bi2");
                                        }

                                      }else{//元ファイルとコピーしたファイルが一致していない場合
                                        $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $FileCopyChecks[0]->id;

                                        $this->FileCopyChecks->updateAll(//FileCopyChecksテーブルのcopy_statusを９に更新
                                          ['copy_status' => 9, 'updated_at' => date('Y-m-d H:i:s')],
                                          ['id'  => $id]
                                        );
                                      }

                                    }
                                  }

                               }
                             }
                          }
                	 		}
       	            }
    	           }//if(ファイルでなくフォルダーであるなら)の終わり
    	        }//フォルダーであるなら
     	      }
     	    }//親whileの終わり
    	  }
    	}


      $dirName = 'data_2_IM測定/';//ローカル//IM測定器ナンバー２のフォルダ
  //    $dirName = '/data/share/syukkaIM/data_2_IMsokutei/';//192//IM測定器ナンバー２のフォルダ

      if(is_dir($dirName)){//ファイルがディレクトリかどうかを調べる(ディレクトリであるので次へ)
    	  if($dir = opendir($dirName)){//opendir でディレクトリ・ハンドルをオープンし、readdir でディレクトリ（フォルダ）内のファイル一覧を取得する。（という定石）
    	    while(($folder = readdir($dir)) !== false){//親while（ディレクトリ内のファイル一覧を取得する）
    	      if($folder != '.' && $folder != '..'){//フォルダーなら("."が無いならフォルダーという認識)
    	        if(strpos($folder,'.',0)==''){//$folderが'.'を含まなかった時
    	          if(is_dir($dirName.$folder)){//$dirName.$folderがディレクトリかどうかを調べる
    	            if($child_dir = opendir($dirName.$folder)){//opendir で$dirName.$folderの子ディレクトリをオープン
              			$folder_check = 0;//$folder_checkを定義
                			if(strpos($folder,'_',0)==''){//$folderが'_'を含まなかった時
                				$folder_check = 1;//$folder_check=1にする
                			}else{//$folderが'_'を含む時

                        $foldername = explode("_",$folder);

                        $product_code = $foldername[1];
                        $kind_kensa = $foldername[2];

                	//			$num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                	//			$product_code = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する
                          while(($file = readdir($child_dir)) !== false){//子while
                               if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN

                                  $fp = fopen('data_2_IM測定/'.$folder.'/'.$file, "r");//kesuyatu
                      //            $fp = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, "r");//kesuyatu

                                   if(substr($file, 0, 5) != "sumi_" ){//sumi_でないファイルだけOPEN
                                    $countname += 1;//ファイル名がかぶらないようにカウントしておく

                                    $fp = fopen('data_2_IM測定/'.$folder.'/'.$file, "r");//csvファイルはwebrootに入れる
                      //              $fp = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, "r");//csvファイルはwebrootに入れる
                              			$this->set('fp',$fp);

                                    $fpcount = fopen('data_2_IM測定/'.$folder.'/'.$file, 'r' );
                      //              $fpcount = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, 'r' );
                              			for( $count = 0; fgets( $fpcount ); $count++ );

                              			$arrFp = array();//空の配列を作る
                                    for ($k=1; $k<=$count; $k++) {
                                        $line = fgets($fp);//ファイル$fpの上の１行を取る
                                        $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                        $keys=array_keys($ImData);
                                        $ImData = array_combine( $keys, $ImData );
                                				$arrFp[] = $ImData;//配列に追加する
                                    }

                                    $arrLot_nums = array();//lot_numの重複チェック
                                    for ($k=4; $k<=$count-1; $k++) {
                                      ${"arrLot_nums".$countname}[] = $arrFp[$k][2];
                                    }

                                    if(!isset(${"arrLot_nums".$countname})){
                                      ${"arruniLot_num".$countname} = array();
                                    }else{
                                      $arruniLot_num = array_unique(${"arrLot_nums".$countname});//lot_numの重複削除
                                      ${"arruniLot_num".$countname} = array_values($arruniLot_num);//配列の添字を振り直し
                                    }

                            //        $arruniLot_num = array_unique(${"arrLot_nums".$countname});//lot_numの重複削除
                            //        ${"arruniLot_num".$countname} = array_values($arruniLot_num);//配列の添字を振り直し
                                    $cntLot = count(${"arruniLot_num".$countname});//配列の要素数確認

                                    //ImSokuteidataHeadsの登録用データをセット
                                    $arrIm_head = array();//空の配列を作る
                                    for ($k=1; $k<=$cntLot; $k++) {
                                      $arrIm_heads = array();//空の配列を作る
                                      $len = mb_strlen($folder);

                                //      $product_code = mb_substr($folder,0,$num);
                                      $inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);
                                //      $kind_kensa = substr($folder,$num+1,$len);

                                      $session = $this->request->session();
                                      $session->write('kind_kensa', $kind_kensa);

                                      $arrIm_heads[] = $product_code;
                                      $arrIm_heads[] = $kind_kensa;
                                      $arrIm_heads[] = $inspec_date;
                                      $arrIm_heads[] = ${"arruniLot_num".$countname}[$k-1];
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = 0;

                                      $name_heads = array('product_code', 'kind_kensa', 'inspec_date', 'lot_num', 'torikomi', 'delete_flag');
                                      $arrIm_heads = array_combine($name_heads, $arrIm_heads);
                                      $arrIm_head[] = $arrIm_heads;
                                    }

                                     //ImSokuteidataHeadsデータベースに登録
                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->newEntity();//newentityに$userという名前を付ける

                                    if($cntLot > 0){

                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->patchEntities($imSokuteidataHeads, $arrIm_head);
                                    $connection = ConnectionManager::get('default');//トランザクション1
                                    // トランザクション開始2
                                    $connection->begin();//トランザクション3
                                    try {//トランザクション4
                                      if ($this->ImSokuteidataHeads->saveMany($imSokuteidataHeads)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                        $connection = ConnectionManager::get('DB_ikou_test');
                                        $table = TableRegistry::get('im_sokuteidata_head');
                                        $table->setConnection($connection);

                                        $connection->insert('im_sokuteidata_head', [
                                            'product_id' => $arrIm_head[0]['product_code'],
                                            'kind_kensa' => $arrIm_head[0]['kind_kensa'],
                                            'inspec_date' => $arrIm_head[0]['inspec_date'],
                                            'lot_num' => $arrIm_head[0]['lot_num'],
                                            'torikomi' => $arrIm_head[0]['torikomi']
                                        ]);
                                        $connection = ConnectionManager::get('default');

                                          //ImKikakusの登録用データをセット
                                          $cnt = count($arrFp[1]);
                                          $arrImKikakus = array_slice($arrFp , 1, 3);
                                          $arrIm_kikaku = array();

                                        for ($m=1; $m<=$cntLot; $m++) {
                                          for ($k=7; $k<=$cnt-1; $k++) {//IM2の方はカンマが１つ少ない

                                            $arrIm_kikaku_data = array();

                                            $size_num = $k-6;
                                            $size = trim($arrImKikakus[0][$k]);
                                            $upper = trim($arrImKikakus[1][$k]);
                                            $lower = trim($arrImKikakus[2][$k]);

                                            $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => ${"arruniLot_num".$countname}[$m-1], 'kind_kensa' => $kind_kensa])->order(["id"=>"desc"])->toArray();
                                            $im_sokuteidata_head_id = $ImSokuteidataHeadsData[0]->id;

                                            $arrIm_kikaku_data[] = $im_sokuteidata_head_id;//配列に追加する
                                            $arrIm_kikaku_data[] = $size_num;//配列に追加する
                                            $arrIm_kikaku_data[] = $size;//配列に追加する
                                            $arrIm_kikaku_data[] = $upper;//配列に追加する
                                            $arrIm_kikaku_data[] = $lower;//配列に追加する
                                            $name_kikaku = array('im_sokuteidata_head_id', 'size_num', 'size', 'upper', 'lower');
                                            $arrIm_kikaku_data = array_combine($name_kikaku, $arrIm_kikaku_data);
                                            $arrIm_kikaku[] = $arrIm_kikaku_data;

                                          }
                                        }

                                           //ImKikakusデータベースに登録
                                          $imKikakus = $this->ImKikakus->newEntity();//newentityに$userという名前を付ける

                    //                      echo "<pre>";
                      //                    print_r("ImKikakus");
                        //                  echo "</pre>";
                          //                echo "<pre>";
                            //              print_r($arrIm_kikaku);
                              //            echo "</pre>";

                                          $imKikakus = $this->ImKikakus->patchEntities($imKikakus, $arrIm_kikaku);
                                             if ($this->ImKikakus->saveMany($imKikakus)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $table = TableRegistry::get('im_kikaku');
                                               $table->setConnection($connection);

                                               $sql = "SELECT id FROM im_sokuteidata_head".
                                               " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                order by id desc limit 1";
                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                               for($k=0; $k<count($arrIm_kikaku); $k++){
                                                 $connection->insert('im_kikaku', [
                                                     'id' => $im_sokuteidata_head_id[0]["id"],
                                                     'size_num' => $arrIm_kikaku[$k]["size_num"],
                                                     'size' => $arrIm_kikaku[$k]["size"],
                                                     'upper' => $arrIm_kikaku[$k]["upper"],
                                                     'lower' => $arrIm_kikaku[$k]["lower"]
                                                 ]);
                                               }

                                               $connection = ConnectionManager::get('default');


                                                //ImSokuteidataResultsの登録用データをセット
                                                $inspec_datetime = substr($arrFp[4][1],0,4)."-".substr($arrFp[4][1],5,2)."-".substr($arrFp[4][1],8,mb_strlen($arrFp[4][1])-8);
                                                $arrIm_Result = array();

                                                 $arrImResults = array_slice($arrFp , 4, $count);
                                                 for ($j=0; $j<=$count-5; $j++) {
                                                    for ($k=7; $k<=$cnt-1; $k++) {//IM2の方はカンマが１つ少ない
                                                      $arrIm_Result_data = array();

                                                      $serial = $arrImResults[$j][3];
                                                      $size_num = $k-6;
                                                      $result = trim($arrImResults[$j][$k]);
                                                      $status = $arrImResults[$j][4];

                                                      $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => $arrFp[$j+4][2], 'kind_kensa' => $kind_kensa])->order(["id"=>"desc"])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                                      $im_sokuteidata_head_id = $ImSokuteidataHeadsData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

                                                      $arrIm_Result_data[] = $im_sokuteidata_head_id;//配列に追加する
                                                      $arrIm_Result_data[] = $inspec_datetime;//配列に追加する
                                                      $arrIm_Result_data[] = $serial;//配列に追加する
                                                      $arrIm_Result_data[] = $size_num;//配列に追加する
                                                      $arrIm_Result_data[] = $result;//配列に追加する
                                                      $arrIm_Result_data[] = $status;//配列に追加する
                                                      $name_Result = array('im_sokuteidata_head_id', 'inspec_datetime', 'serial', 'size_num', 'result', 'status');
                                                      $arrIm_Result_data = array_combine($name_Result, $arrIm_Result_data);

                                                      $arrIm_Result[] = $arrIm_Result_data;
                                                  }
                                                 }

                                                  //ImSokuteidataResultsデータベースに登録
                                                  $imSokuteidataResults = $this->ImSokuteidataResults->newEntity();//newentityに$userという名前を付ける

                                                  $imSokuteidataResults = $this->ImSokuteidataResults->patchEntities($imSokuteidataResults, $arrIm_Result);
                                                  if ($this->ImSokuteidataResults->saveMany($imSokuteidataResults)) {//ImSokuteidataResultsをsaveできた時（saveManyで一括登録）

                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $table = TableRegistry::get('im_sokuteidata_result');
                                                    $table->setConnection($connection);

                                                    $sql = "SELECT id FROM im_sokuteidata_head".
                                                    " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                     and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                      order by id desc limit 1";
                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                                    for($k=0; $k<count($arrIm_Result); $k++){

                                                      if(!empty($arrIm_Result[$k]["result"])){

                                                        if($arrIm_Result[$k]["status"] == "Fail"){
                                                          $arrIm_Result[$k]["status"] = "NO";
                                                        }

                                                        $connection->insert('im_sokuteidata_result', [
                                                            'id' => $im_sokuteidata_head_id[0]["id"],
                                                            'inspec_datetime' => $arrIm_Result[$k]["inspec_datetime"],
                                                            'serial' => $arrIm_Result[$k]["serial"],
                                                            'size_num' => $arrIm_Result[$k]["size_num"],
                                                            'result' => $arrIm_Result[$k]["result"],
                                                            'status' => $arrIm_Result[$k]["status"]
                                                        ]);
                                                      }

                                                    }

                                                    $connection = ConnectionManager::get('default');

                                                    } else {
                                                      $this->Flash->error(__('This data1 could not be saved. Please, try again.'));
                                                      throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                                  }

                                            } else {
                                              $this->Flash->error(__('This data2 could not be saved. Please, try again.'));
                                              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                            }
                                            $connection->commit();// コミット5
                                      } else {
                                        $this->Flash->error(__('This data3 could not be saved. Please, try again.'));
                                        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                      }
                                    } catch (Exception $e) {//トランザクション7
                                    //ロールバック8
                                      $connection->rollback();//トランザクション9
                                  }//トランザクション10

                                }

                              }


                              $output_dir = 'backupData_2_IM測定/'.$folder;
                      //        $output_dir = '/data/share/syukkaIM/backupData_2_IMsokutei/'.$folder;

                                  if (! file_exists($output_dir)) {//backupData_IM測定の中に$folderがないとき
                                   if (mkdir($output_dir)) {
                                      $Filebi2 = mb_substr($file,0,-4);
                                      if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."110.bi3", $output_dir.'/'.$Filebi2."110.bi3")) {
                                        //DBに登録fileCopyChecks

                                        $arrfiledate = [
                                  				'name_folder' => $folder,
                                  				'name_file' => $file,
                                  				'created_at' => date('Y-m-d H:i:s')
                                        ];

                                        $fileCopyChecks = $this->FileCopyChecks->newEntity();
                                        $fileCopyCheck = $this->FileCopyChecks->patchEntity($fileCopyChecks, $arrfiledate);
                                        $this->FileCopyChecks->save($fileCopyCheck);

                                        fclose($fp);
                                        $fp = fopen('data_2_IM測定/'.$folder.'/'.$file, "r");
                                  //      $fp = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, "r");
                                        $fpcount = fopen('data_2_IM測定/'.$folder.'/'.$file, 'r' );
                                  //      $fpcount = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, 'r' );
                                  			for( $count = 0; fgets( $fpcount ); $count++ );

                                  			$arrFpmoto = array();//空の配列を作る
                                        for ($k=1; $k<=$count; $k++) {
                                            $line = fgets($fp);//ファイル$fpの上の１行を取る
                                            $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                            $keys=array_keys($ImData);
                                            $ImData = array_combine( $keys, $ImData );
                                    				$arrFpmoto[] = $ImData;//配列に追加する
                                        }

                                        $fpnew = fopen($output_dir.'/'.$file, "r");
                                        $fpcountnew = fopen($output_dir.'/'.$file, 'r' );
                                  			for( $count = 0; fgets( $fpcountnew ); $count++ );

                                  			$arrFnew = array();//空の配列を作る
                                        for ($k=1; $k<=$count; $k++) {
                                            $line = fgets($fpnew);//ファイル$fpの上の１行を取る
                                            $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                            $keys=array_keys($ImData);
                                            $ImData = array_combine( $keys, $ImData );
                                    				$arrFnew[] = $ImData;//配列に追加する
                                        }

                                        $arrayDiff = array();
                                        $copy_check = 0;
                                        for ($k=0; $k<count($arrFpmoto); $k++) {
                                          array_diff($arrFpmoto[$k], $arrFnew[$k]);
                                          if(isset(array_diff($arrFpmoto[$k], $arrFnew[$k])[0])){
                                            $copy_check = $copy_check + 1;
                                          }
                                        }

                                        if($copy_check == 0){//元ファイルとコピーしたファイルが一致している場合
                                          $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $FileCopyChecks[0]->id;

                                          $this->FileCopyChecks->updateAll(
                                            ['copy_status' => 1, 'updated_at' => date('Y-m-d H:i:s')],
                                            ['id'  => $id]
                                          );

                                          $countfile =  1;//フォルダーに入る最初のファイル

                                          $toCopyFile = "sumi_".$countfile."_".$file;
                                          if (rename($output_dir.'/'.$file, $output_dir.'/'.$toCopyFile)) {//ファイル名変更
                                            unlink($dirName.$folder.'/'.$file);
                                            unlink($dirName.$folder.'/'.$Filebi2."110.bi3");
                                          }

                                        }else{//元ファイルとコピーしたファイルが一致していない場合
                                          $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $FileCopyChecks[0]->id;

                                          $this->FileCopyChecks->updateAll(
                                            ['copy_status' => 9, 'updated_at' => date('Y-m-d H:i:s')],
                                            ['id'  => $id]
                                          );
                                        }

                                      }
                                    }

                                  } else {//backupData_IM測定の中に$folderがあるとき
                                    $Filebi2 = mb_substr($file,0,-4);
                                    if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."110.bi3", $output_dir.'/'.$Filebi2."110.bi3")) {
                                      //DBに登録

                                      $arrfiledate = [
                                        'name_folder' => $folder,
                                        'name_file' => $file,
                                        'created_at' => date('Y-m-d H:i:s')
                                      ];

                                      $fileCopyChecks = $this->FileCopyChecks->newEntity();
                                      $fileCopyCheck = $this->FileCopyChecks->patchEntity($fileCopyChecks, $arrfiledate);
                                      $this->FileCopyChecks->save($fileCopyCheck);//FileCopyChecksテーブルに登録

                                      fclose($fp);
                                      $fp = fopen('data_2_IM測定/'.$folder.'/'.$file, "r");
                          //            $fp = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, "r");
                                      $fpcount = fopen('data_2_IM測定/'.$folder.'/'.$file, 'r' );
                          //            $fpcount = fopen('/data/share/syukkaIM/data_2_IMsokutei/'.$folder.'/'.$file, 'r' );
                                      for( $count = 0; fgets( $fpcount ); $count++ );

                                      $arrFpmoto = array();//空の配列を作る
                                      for ($k=1; $k<=$count; $k++) {
                                          $line = fgets($fp);//ファイル$fpの上の１行を取る
                                          $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                          $keys=array_keys($ImData);
                                          $ImData = array_combine( $keys, $ImData );
                                          $arrFpmoto[] = $ImData;//配列に追加する
                                      }

                                      $fpnew = fopen($output_dir.'/'.$file, "r");
                                      $fpcountnew = fopen($output_dir.'/'.$file, 'r' );
                                      for( $count = 0; fgets( $fpcountnew ); $count++ );

                                      $arrFnew = array();//空の配列を作る
                                      for ($k=1; $k<=$count; $k++) {
                                          $line = fgets($fpnew);//ファイル$fpの上の１行を取る
                                          $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                          $keys=array_keys($ImData);
                                          $ImData = array_combine( $keys, $ImData );
                                          $arrFnew[] = $ImData;//配列に追加する
                                      }

                                      $arrayDiff = array();
                                      $copy_check = 0;
                                      for ($k=0; $k<count($arrFpmoto); $k++) {
                                        array_diff($arrFpmoto[$k], $arrFnew[$k]);
                                        if(isset(array_diff($arrFpmoto[$k], $arrFnew[$k])[0])){
                                          $copy_check = $copy_check + 1;
                                        }
                                      }

                                      if($copy_check == 0){//元ファイルとコピーしたファイルが一致している場合
                                        $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $FileCopyChecks[0]->id;

                                        $this->FileCopyChecks->updateAll(//FileCopyChecksテーブルのcopy_statusを１に更新
                                          ['copy_status' => 1, 'updated_at' => date('Y-m-d H:i:s')],
                                          ['id'  => $id]
                                        );

                                        $arrAllfiles = glob("$output_dir/*");
                                        $countfile = count($arrAllfiles) - 1;//フォルダーのファイルが二つずつ増えるから

                                        $toCopyFile = "sumi_".$countfile."_".$file;
                                        if (rename($output_dir.'/'.$file, $output_dir.'/'.$toCopyFile)) {//ファイル名変更（元ファイルを削除）
                                          unlink($dirName.$folder.'/'.$file);
                                          unlink($dirName.$folder.'/'.$Filebi2."110.bi3");
                                        }

                                      }else{//元ファイルとコピーしたファイルが一致していない場合
                                        $FileCopyChecks = $this->FileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $FileCopyChecks[0]->id;

                                        $this->FileCopyChecks->updateAll(//FileCopyChecksテーブルのcopy_statusを９に更新
                                          ['copy_status' => 9, 'updated_at' => date('Y-m-d H:i:s')],
                                          ['id'  => $id]
                                        );
                                      }

                                    }
                                  }


                               }
                             }
                          }
                	 		}
       	            }
    	           }//if(ファイルでなくフォルダーであるなら)の終わり
    	        }//フォルダーであるなら
     	      }
     	    }//親whileの終わり
    	  }
    	}

    return $this->redirect(['action' => 'indexhome']);

    }

    public function preform()//「出荷検査表登録」ページで検査結果を入力
    {
      $data = array_values($this->request->query);//getで取り出した配列の値を取り出す

      $product_code = $data[1];
      $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
      $product_name = $data[2];
      $this->set('Productname',$product_name);//セット
      $kadouseikeiId = $data[3];
      $this->set('kadouseikeiId',$kadouseikeiId);//セット

    	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
    	->select(['product_id','delete_flag' => '0'])
    	->group('product_id');

    	$staff_id = $this->Auth->user('staff_id');//created_staffの登録用
    	$this->set('staff_id',$staff_id);//セット

      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

      foreach ($Products as $value) {//$Productsそれぞれに対し
       $product_code= $value->product_code;
     }
     $this->set('product_code',$product_code);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();
    	$Productid = $Producti[0]->id;
    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

    	for($i=1; $i<=9; $i++){//size_1～9までセット
    		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
    		$this->set('size_'.$i,${"size_".$i});//セット
    	}

    	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
    		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
    		$this->set('upper_'.$j,${"upper_".$j});//セット
    		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
    		$this->set('lower_'.$j,${"lower_".$j});//セット
    	}

      $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

    }

    public function form()//「出荷検査表登録」ページで検査結果を入力
    {
        $data = $this->request->getData();//postデータを$dataに

        $product_code = $data['product_code1'];
        $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
        $product_name = $data['product_name1'];
        $this->set('Productname',$product_name);//セット
        $lot_num = $data['lot_num'];
        $this->set('lot_num',$lot_num);//セット
        $kadouseikeiId = $data['kadouseikeiId'];
        $this->set('kadouseikeiId',$kadouseikeiId);//セット

      	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
      	->select(['product_id','delete_flag' => '0'])
      	->group('product_id');

    	$staff_id = $this->Auth->user('staff_id');//created_staffの登録用
    	$this->set('staff_id',$staff_id);//セット

      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

      foreach ($Products as $value) {//$Productsそれぞれに対し
       $product_code= $value->product_code;
     }
     $this->set('product_code',$product_code);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();
    	$Productid = $Producti[0]->id;
    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();
      //
      for($i=1; $i<=9; $i++){//size_1～9までセット
        ${"kind_kensa".$i} = "ノギス";
        $this->set('kind_kensa'.$i,${"kind_kensa".$i});//セット
      }
      if(isset($ImSokuteidataHead[0])){
      //
      $ImSokuteidataHead_id = $ImSokuteidataHead[0]->id;
      $ImKikaku = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHead_id])->toArray();
      for($i=1; $i<=5; $i++){//size_1～9までセット
        if(isset($ImSokuteidataHead[$i])){
          ${"ImSokuteidataHead_id_".$i} = $ImSokuteidataHead[$i]->id;
          $ImKikakutuika = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => ${"ImSokuteidataHead_id_".$i}])->toArray();
          $ImKikaku = array_merge($ImKikaku, $ImKikakutuika);
        }
      }
      $ImSokuteidataHead_id = $ImKikaku[0]->id;
      $ImSokuteidataHeadId = $ImKikaku[0]->im_sokuteidata_head_id;
      $ImSokuteidataResult = $this->ImSokuteidataResults->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHeadId ])->toArray();

    	for($i=1; $i<=9; $i++){//size_1～9までセット
        ${"kind_kensa".$i} = "ノギス";
        $this->set('kind_kensa'.$i,${"kind_kensa".$i});//セット
    		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
    		$this->set('size_'.$i,${"size_".$i});//セット
        for($j=0; $j<=20; $j++){//size_1～9までセット
          if(isset($ImKikaku[$j])){//
            if(${"size_".$i} == $ImKikaku[$j]['size'] and ${"size_".$i} != 0){//KensahyouHeadのsize$iと$ImKikaku[$j]['size']が同じ場合
/*
              echo "<pre>";
              print_r(${"size_".$i}."-".$ImKikaku[$j]['size']);
              echo "</pre>";
*/
              $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['id' => $ImKikaku[$j]['im_sokuteidata_head_id']])->toArray();
              ${"kind_kensa".$i} = $ImSokuteidataHead[0]->kind_kensa;

              $this->set('kind_kensa'.$i,${"kind_kensa".$i});//セット
              $ImSokuteidataResult = $this->ImSokuteidataResults->find()->where(['im_sokuteidata_head_id' => $ImKikaku[$j]['im_sokuteidata_head_id'] , 'size_num' => $ImKikaku[$j]['size_num']])->toArray();

              $ImSokuteidataResultarry = array();//空の配列を作る

              foreach ((array)$ImSokuteidataResult as $key => $value) {//serialで並び替え
                   $sort[$key] = $value['serial'];
                    array_push($ImSokuteidataResultarry, [$value['serial'], $value['result']]);
               }
             if(isset($ImSokuteidataResultarry[0])){
                array_multisort($ImSokuteidataResultarry, SORT_ASC, $ImSokuteidataResultarry);
                $cnt = count($ImSokuteidataResultarry);
/*
                echo "<pre>";
                print_r($ImSokuteidataResultarry);
                echo "</pre>";
*/
                for($r=1; $r<=$cnt; $r++){
                  $r1 = $r-1;
                  ${"ImSokuteidata_result_".$i."_".$r} = $ImSokuteidataResultarry[$r1][1];
                  ${"ImSokuteidata_result_".$i."_".$r} = round(${"ImSokuteidata_result_".$i."_".$r},2);
                  $this->set('ImSokuteidata_result_'.$i.'_'.$r,${"ImSokuteidata_result_".$i."_".$r});//セット
                 }
               }
            }
          }
        }
    	}
//
    }
//
    	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
    		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
    		$this->set('upper_'.$j,${"upper_".$j});//セット
    		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
    		$this->set('lower_'.$j,${"lower_".$j});//セット
    	}

      $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

      $arrhantei = [''=>'','OK'=>'OK','out'=>'out'];
      $this->set('arrhantei',$arrhantei);//セット

    }


    public function confirm()//「出荷検査表登録」確認画面
   {
      $data = $this->request->getData();
      $product_code = $data['product_code'];
      session_start();//session_startは$this->request->getData();の後に入れないとエラーが出る
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
     $this->set('product_code',$product_code);//セット
     $lot_num = $data['lot_num'];
     $this->set('lot_num',$lot_num);//セット

     $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
       'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
     ]);
     foreach ($Products as $value) {//$Productsそれぞれに対し
      $product_code= $value->product_code;
    }
    $this->set('product_code',$product_code);//セット

    $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

     $KensahyouHeadid = $data['kensahyou_heads_id'];
     $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

     $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
     $Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
     $KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
     $this->set('KensahyouHead',$KensahyouHead);//セット
     $Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
     $this->set('Productname',$Productname);//セット

     $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
     $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

     $KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
     $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

     for($i=1; $i<=9; $i++){//size_1～9までセット
       ${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
       $this->set('size_'.$i,${"size_".$i});//セット
     }

     for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
       ${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
       $this->set('upper_'.$j,${"upper_".$j});//セット
       ${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
       $this->set('lower_'.$j,${"lower_".$j});//セット

       ${"result_weight_".$j} = $data['result_weight_'.$j];
       if(!empty(${"result_weight_".$j})){
         ${"hikaku_".$j} = " _ _ _ _ _ ";
         $this->set('hikaku_'.$j,${"hikaku_".$j});//セット
       }else{
         ${"hikaku_".$j} = NULL;
         $this->set('hikaku_'.$j,${"hikaku_".$j});//セット
       }

     }

     $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
     $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

   }


   public function preadd()
   {
     $kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット
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

      $staff_id = $this->Auth->user('staff_id');//created_staffの登録用
    	$this->set('staff_id',$staff_id);//セット

        if(empty($Userdata)){
          $delete_flag = "";
        }else{
          $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
          $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
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
  }

      public function do()//「出荷検査表登録」登録画面
     {
      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

      for($n=1; $n<=8; $n++){
        $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
        $_SESSION['sokuteidata'][$n] = array_merge($created_staff,$_SESSION['sokuteidata'][$n]);
      }
      $data = $_SESSION['sokuteidata'];

      $product_code = $data[1]['product_code'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
      $this->set('product_code',$product_code);//セット

      $lot_num = $data[1]['lot_num'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
      $this->set('lot_num',$lot_num);//セット

        $manu_date = $data[1]['manu_date'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
        $this->set('manu_date',$manu_date);//セット

        $inspec_date = $data[1]['inspec_date'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
        $this->set('inspec_date',$inspec_date);//セット

        $ImKikakuid_1 = "ノギス";
        $this->set('ImKikakuid_1',$ImKikakuid_1);
        $ImKikakuid_2 = "ノギス";
        $this->set('ImKikakuid_2',$ImKikakuid_2);
        $ImKikakuid_3 = "ノギス";
        $this->set('ImKikakuid_3',$ImKikakuid_3);
        $ImKikakuid_4 = "ノギス";
        $this->set('ImKikakuid_4',$ImKikakuid_4);
        $ImKikakuid_5 = "ノギス";
        $this->set('ImKikakuid_5',$ImKikakuid_5);
        $ImKikakuid_6 = "ノギス";
        $this->set('ImKikakuid_6',$ImKikakuid_6);
        $ImKikakuid_7 = "ノギス";
        $this->set('ImKikakuid_7',$ImKikakuid_7);
        $ImKikakuid_8 = "ノギス";
        $this->set('ImKikakuid_8',$ImKikakuid_8);
        $ImKikakuid_9 = "ノギス";
        $this->set('ImKikakuid_9',$ImKikakuid_9);

        $ImKikakus = $this->ImKikakuTaious->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得（プルダウン）
        foreach ((array)$ImKikakus as $key => $value) {
             $sort[$key] = $value['kensahyuo_num'];
         }
         if(isset($ImKikakus[0])){
          array_multisort($sort, SORT_ASC, $ImKikakus);
        }

        for($i=0; $i<=8; $i++){
          $j = $i + 1;
          if(isset($ImKikakus[$i])) {
            if($ImKikakus[$i]['kind_kensa'] != "") {
              ${"ImKikakuid_".$j} = $ImKikakus[$i]['kind_kensa'];//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける（プルダウン）
              $this->set('ImKikakuid_'.$j,${"ImKikakuid_".$j});//セット
            }else{
            }
          }else{
            ${"ImKikakuid_".$j} = "ノギス";//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける（プルダウン）
            $this->set('ImKikakuid_'.$j,${"ImKikakuid_".$j});//セット
          }
        }

        for($q=1; $q<=8; $q++){
          ${"result_weight_".$q} = $data["{$q}"]["result_weight"];
          $this->set('result_weight_'.$q,${"result_weight_".$q});//セット
          for($r=1; $r<=8; $r++){
            ${"result_size_".$q."_".$r} = $data["{$q}"]["result_size_{$r}"];
            $this->set('result_size_'.$q.'_'.$r,${"result_size_".$q."_".$r});//セット
          }
        }

       $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
         'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
       ]);

       foreach ($Products as $value) {//$Productsそれぞれに対し
        $product_code= $value->product_code;
      }
      $this->set('product_code',$product_code);//セット

      $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
      $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
      $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

       $kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
       $this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

       $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
       $Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
       $KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
       $this->set('KensahyouHead',$KensahyouHead);//セット
       $Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
       $this->set('Productname',$Productname);//セット

       $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
       $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

       $KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
       $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

       for($i=1; $i<=9; $i++){//size_1～9までセット
         ${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
         $this->set('size_'.$i,${"size_".$i});//セット
       }

       for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
         ${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
         $this->set('upper_'.$j,${"upper_".$j});//セット
         ${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
         $this->set('lower_'.$j,${"lower_".$j});//セット
       }

       for($j=1; $j<=8; $j++){
         ${"result_weight_".$j} = $data[$j]['result_weight'];
         if(!empty(${"result_weight_".$j})){
           ${"hikaku_".$j} = " _ _ _ _ _ ";
           $this->set('hikaku_'.$j,${"hikaku_".$j});//セット
         }else{
           ${"hikaku_".$j} = NULL;
           $this->set('hikaku_'.$j,${"hikaku_".$j});//セット
         }
       }

       $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
       $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット
    /*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
    */
       if ($this->request->is('get')) {//postなら登録
         $kensahyouSokuteidata = $this->KensahyouSokuteidatas->patchEntities($kensahyouSokuteidata, $data);
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
             if ($this->KensahyouSokuteidatas->saveMany($kensahyouSokuteidata)) {//saveManyで一括登録

               $connection = ConnectionManager::get('DB_ikou_test');
               $table = TableRegistry::get('kensahyou_sokuteidata_result');
               $table->setConnection($connection);

               $kensahyou_sokuteidata_head_id = $data[1]["product_code"]."-".$data[1]["lot_num"];

               $connection->insert('kensahyou_sokuteidata_head', [
                 'kensahyou_sokuteidata_head_id' => $kensahyou_sokuteidata_head_id,
                 'product_id' => $data[1]["product_code"],
                 'manu_date' => $data[1]["manu_date"],
                 'inspec_date' => $data[1]["inspec_date"],
                 'lot_num' => $data[1]["lot_num"],
                 'emp_id' => $data[1]["created_staff"],
                 'timestamp' => date('Y-m-d H:i:s')
               ]);


               for($k=1; $k<=count($data); $k++){

                 for($i=1; $i<=9; $i++){
                   if(empty($data[$k]["result_size_".$i])){
                     $data[$k]["result_size_".$i] = null;
                   }
                 }

                 if(empty($data[$k]["result_weight"])){
                   $data[$k]["result_weight"] = null;
                 }

                 $kensahyou_sokuteidata_head_id = $data[$k]["product_code"]."-".$data[$k]["lot_num"];

                 $connection->insert('kensahyou_sokuteidata_result', [
                   'kensahyou_sokuteidata_result_id' => $kensahyou_sokuteidata_head_id,
                   'cavi_num' => $data[$k]["cavi_num"],
                   'product_id' => $data[$k]["product_code"],
                   'result_size_a' => $data[$k]["result_size_1"],
                   'result_size_b' => $data[$k]["result_size_2"],
                   'result_size_c' => $data[$k]["result_size_3"],
                   'result_size_d' => $data[$k]["result_size_4"],
                   'result_size_e' => $data[$k]["result_size_5"],
                   'result_size_f' => $data[$k]["result_size_6"],
                   'result_size_g' => $data[$k]["result_size_7"],
                   'result_size_h' => $data[$k]["result_size_8"],
                   'result_size_i' => $data[$k]["result_size_9"],
                   'result_text_j' => $data[$k]["situation_dist1"],
                   'result_text_k' => $data[$k]["situation_dist2"],
                   'result_weight' => $data[$k]["result_weight"]
               //    'situation_dist' => ""
                 ]);

               }

               $connection = ConnectionManager::get('default');

             if(strpos($_SESSION['kadouseikeiId'],'_') !== false){
               $sch_id = explode("_",$_SESSION['kadouseikeiId']);

               $this->ScheduleKouteis->updateAll(
               ['present_kensahyou' => 1],
               ['id'   => $sch_id[1]]
               );

               $ScheduleKouteiData = $this->ScheduleKouteis->find()->where(['id' => $sch_id[1]])->toArray();

               $ScheduleKouteidatetime = $ScheduleKouteiData[0]->datetime->format('Y-m-d H:i:s');
               $ScheduleKouteiseikeiki = $ScheduleKouteiData[0]->seikeiki;

               $connection = ConnectionManager::get('DB_ikou_test');
               $table = TableRegistry::get('schedule_koutei');
               $table->setConnection($connection);

               $num = 1;
               $updater = "UPDATE schedule_koutei set present_kensahyou ='".$num."'
                where datetime ='".$ScheduleKouteidatetime."' and seikeiki ='".$ScheduleKouteiseikeiki."'";
                $connection->execute($updater);

               $connection = ConnectionManager::get('default');//新DBに戻る
               $table->setConnection($connection);

             }else{

               $KadouSeikeiData = $this->KadouSeikeis->find()->where(['id' => $_SESSION['kadouseikeiId']])->toArray();
               $KadouSeikeistarting_tm = $KadouSeikeiData[0]->starting_tm->format('Y-m-d H:i:s');
               $KadouSeikeifinishing_tm = $KadouSeikeiData[0]->finishing_tm->format('Y-m-d H:i:s');
               $KadouSeikeicreated_at = $KadouSeikeiData[0]->created_at->format('Y-m-d H:i:s');
               $KadouSeikeiseikeiki_code = $KadouSeikeiData[0]->seikeiki_code;
               $KadouSeikeiproduct_code = $KadouSeikeiData[0]->product_code;

               $this->KadouSeikeis->updateAll(
               ['present_kensahyou' => 1 ,'starting_tm' => $KadouSeikeistarting_tm ,'finishing_tm' => $KadouSeikeifinishing_tm ,'created_at' => $KadouSeikeicreated_at ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
               ['id'   => $_SESSION['kadouseikeiId'] ]
               );

               $connection = ConnectionManager::get('DB_ikou_test');
               $table = TableRegistry::get('kadou_seikei');
               $table->setConnection($connection);

               $num = 1;
               $updater = "UPDATE kadou_seikei set present_kensahyou ='".$num."'
                where pro_num ='".$KadouSeikeiproduct_code."' and seikeiki_id ='".$KadouSeikeiseikeiki_code."' and starting_tm ='".$KadouSeikeistarting_tm."'";
                $connection->execute($updater);

               $connection = ConnectionManager::get('default');//新DBに戻る
               $table->setConnection($connection);

             }

             $mes = "＊下記のように登録されました";
             $this->set('mes',$mes);
                 $connection->commit();// コミット5
             } else {
               $this->Flash->error(__('The KensahyouSokuteidatasdo could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
             }
         } catch (Exception $e) {//トランザクション7
         //ロールバック8
           $connection->rollback();//トランザクション9
         }//トランザクション10
       }

     }

     public function imtaiouedit($id = null)
     {
       $this->request->session()->destroy(); // セッションの破棄

       $ImKikakuTaious = $this->ImKikakuTaious->get($id);
       $this->set('ImKikakuTaious', $ImKikakuTaious);//$kensahyouHeadをctpで使えるようにセット

       $KouteiKensahyouHeadid = $ImKikakuTaious['id'];//product_idという名前のデータに$product_idと名前を付ける
       $this->set('KouteiKensahyouHeadid',$KouteiKensahyouHeadid);//セット
/*
       echo "<pre>";
       print_r($KouteiKensahyouHeadid);
       echo "</pre>";
*/
       $product_code = $ImKikakuTaious['product_code'];//product_idという名前のデータに$product_idと名前を付ける
       $this->set('product_code',$product_code);//セット
       $this->set('Productcode',$product_code);//セット

       $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
       $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
       $this->set('Productname',$Productname);//セット

       $newversion = $ImKikakuTaious['version'] + 1;
       $this->set('newversion',$newversion);

       $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
       $this->set('arrType',$arrType);

       $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
       $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
       $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

       $ImSokuteidataHeads = $this->ImSokuteidataHeads->find()
      ->where(['product_code' => $product_code])->toArray();

       $arrKindKensa = array("","ノギス");//配列の初期化
        foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
           $arrKindKensa[] = $value->kind_kensa;//配列に追加
        }
         $arrKindKensa = array_unique($arrKindKensa);

        $this->set('arrKindKensa',$arrKindKensa);

     }

     public function imtaioueditconfirm()
     {
      $data = $this->request->getData();
      $product_code = $data["product_code"];

      $this->set('product_code',$product_code);//セット
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
        'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
      ]);
      foreach ($Products as $value) {//$Productsそれぞれに対し
       $product_code= $value->product_code;
     }
     $this->set('product_code',$product_code);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

      $this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
     }

     public function imtaioueditpreadd()
     {
       $this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

       $session = $this->request->getSession();
       $data = $session->read();//postデータ取得し、$dataと名前を付ける
     }

     public function imtaioueditlogin()
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
             $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
           }
             $user = $this->Auth->identify();
           if ($user) {
             $this->Auth->setUser($user);
             return $this->redirect(['action' => 'imtaioueditdo']);
           }
         }
     }

     public function imtaioueditdo()
    {
      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

      $data = $sessiondata['kikakudata'];
      $kousinn_flag = $_SESSION['kousinn_flag']['kousinn_flag'];

      $Product = $this->Products->find()->where(['product_code' => $sessiondata['kikakudata'][1]['product_code']])->toArray();
      $product_code = $Product[0]->product_code;
      $this->set('product_code',$product_code);//セット
      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
        'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
      ]);
      foreach ($Products as $value) {//$Productsそれぞれに対し
       $product_code= $value->product_code;
     }
     $this->set('product_code',$product_code);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $ImKikakuTaious = $this->ImKikakuTaious->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('ImKikakuTaious',$ImKikakuTaious);//セット

     $count = count($data);
     for($k=1; $k<=$count; $k++){

       if(!empty($data[$k]["kind_kensa"]) && !empty($data[$k]["size_num"])){

         $staff_id = $sessiondata['Auth']['User']['staff_id'];//ログイン中のuserのstaff_idに$staff_idという名前を付ける
         $data[$k]['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする
         $data[$k]['created_at'] = date('Y-m-d H:i:s');

       }else{

         unset($data[$k]);

       }

     }

     $data = array_values($data);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
         if ($kousinn_flag == 5) {

/*
           $ImKikakuTaiou = $this->ImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => '0'])->toArray();

           for($k=0; $k<count($ImKikakuTaiou); $k++){

             ${"id".$k} = $ImKikakuTaiou[$k]->id;

             $this->ImKikakuTaious->updateAll(
               ['status' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data[0]['created_staff']],
               ['id'  => ${"id".$k}]
             );

           }

           //旧DB更新
           $connection = ConnectionManager::get('DB_ikou_test');
           $table = TableRegistry::get('im_kikaku_taiou');
           $table->setConnection($connection);

           for($k=0; $k<count($data); $k++){
             $connection->insert('im_kikaku_taiou', [
               'product_id' => $data[$k]["product_code"],
               'kensahyou_size' => $data[$k]["kensahyuo_num"],
               'kind_kensa' => $data[$k]["kind_kensa"],
               'im_size_num' => $data[$k]["size_num"]
             ]);
           }
           $connection = ConnectionManager::get('default');

           $mes = "※下記のように更新されました";
           $this->set('mes',$mes);
           $connection->commit();// コミット5
*/
        }else{

          $KensahyouHeads = $this->ImKikakuTaious->patchEntity($ImKikakuTaious, $this->request->getData());
          $connection = ConnectionManager::get('default');//トランザクション1
            // トランザクション開始2
          $connection->begin();//トランザクション3
          try {//トランザクション4

            $ImKikakuTaiou = $this->ImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => '0'])->toArray();

            for($k=0; $k<count($ImKikakuTaiou); $k++){

              ${"id".$k} = $ImKikakuTaiou[$k]->id;

              $this->ImKikakuTaious->updateAll(
                ['status' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data[0]['created_staff']],
                ['id'  => ${"id".$k}]
              );

            }

             $ImKikakuTaious = $this->ImKikakuTaious->patchEntities($this->ImKikakuTaious->newEntity(), $data);
             $this->ImKikakuTaious->saveMany($ImKikakuTaious);

             //旧DB更新
             $connection = ConnectionManager::get('DB_ikou_test');
             $table = TableRegistry::get('im_kikaku_taiou');
             $table->setConnection($connection);

             $statusmoto = 0;
             $status = 1;
             $updater = "UPDATE im_kikaku_taiou set status = '".$status."'
             , updated_at = '".date('Y-m-d H:i:s')."' , updated_staff = '".$data[0]['created_staff']."'
             where product_id ='".$product_code."' and status ='".$statusmoto."'";
             $connection->execute($updater);

             //旧DB更新
             $connection = ConnectionManager::get('DB_ikou_test');
             $table = TableRegistry::get('im_kikaku_taiou');
             $table->setConnection($connection);

             for($k=0; $k<count($data); $k++){
               $connection->insert('im_kikaku_taiou', [
                 'product_id' => $data[$k]["product_code"],
                 'kensahyou_size' => $data[$k]["kensahyuo_num"],
                 'kind_kensa' => $data[$k]["kind_kensa"],
                 'im_size_num' => $data[$k]["size_num"]
               ]);
             }
             $connection = ConnectionManager::get('default');

              $mes = "※下記のように更新されました";
               $this->set('mes',$mes);
               $connection->commit();// コミット5

          } catch (Exception $e) {//トランザクション7
          //ロールバック8
            $connection->rollback();//トランザクション9
          }//トランザクション10

        }

    }


}
