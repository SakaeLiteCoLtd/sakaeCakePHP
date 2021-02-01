<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//他のテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use App\myClass\KensahyouSokuteidata\htmlKensahyouSokuteidata;//myClassフォルダに配置したクラスを使用

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 *
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KensahyouSokuteidatasController  extends AppController
{
     public function initialize()
     {
    	parent::initialize();
    	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
      $this->Products = TableRegistry::get('products');//productsテーブルを使う
      $this->Customers = TableRegistry::get('customers');
      $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
      $this->ImKikakus = TableRegistry::get('imKikakus');//ImKikakuTaiousテーブルを使う
      $this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//ImKikakuTaiousテーブルを使う
      $this->ImSokuteidataResults = TableRegistry::get('imSokuteidataResults');//ImKikakuTaiousテーブルを使う
      $this->ImKikakuTaious = TableRegistry::get('imKikakuTaious');//ImKikakuTaiousテーブルを使う
      $this->Users = TableRegistry::get('users');//Usersテーブルを使う
     }

     public function yobidashicustomer()//「出荷検査用呼出」ページトップ
     {
     	$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()
     	->select(['product_code','delete_flag' => '0'])
     	->group('product_code')
     	);
     }

     public function yobidashipana()
     {
       $this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()
      	->select(['product_code','delete_flag' => '0'])
      	->group('product_code')
      	);
     }

     public function yobidashipanap0()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);
/*
        $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
        ->select(['product_code','delete_flag' => '0'])
        ->group('product_code')->toArray();

        $count = count($Sokuteidataproduct_code);

        $arrProduct = array();

        for ($k=0; $k<$count; $k++) {
          $product_code = $Sokuteidataproduct_code[$k]["product_code"];
          if(0 === strpos($product_code, "P0")){
            $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code, 'customer_id' => 1]])->toArray();
            if(isset($Products[0])){
              $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
            }
          }
        }
*/

        $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
        $arrProduct = $Panayobidashi->Pana0();
        $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanap1()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->Pana1();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanap2()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->Pana2();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanaw()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->PanaW();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanah()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->PanaH();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidashipanare()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->PanaRE();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidashidnp()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->Dnp();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidashiothers()
     {
       $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
       $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

       $Panayobidashi = new htmlKensahyouSokuteidata();//クラスを使用
       $arrProduct = $Panayobidashi->Others();
       $this->set('arrProduct',$arrProduct);
     }

     public function yobidasi1()//Pから始まるものだけにする
     {
     	$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()
     	->select(['product_code','delete_flag' => '0'])
     	->group('product_code')
     	);
     }

    public function indexcsv()//csvテスト用
    {
    	$this->set('kensahyouSokuteidata',$this->KensahyouSokuteidatas->newEntity());//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

      if ($this->request->is('post')) {
        $data = $this->request->getData();
        $source_file = $_FILES['file']['tmp_name'];
        echo "<pre>";
        print_r($data);
        echo "</pre>";
        echo "<pre>";
        print_r($source_file);
        echo "</pre>";
      }
    }

    public function search()//「出荷検査用呼出」の日付で絞り込むページ
    {
      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
    	$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    	if ($this->request->is('post') && isset($data['start'])) {//データがpostで送られたとき（日付を選んだ場合）

    		$data = $this->request->data;//postで送られたデータの呼び出し

    		$value1s = $data['start']['year'];//startのyearに$value1sと名前をつける
    		$value2s = $data['start']['month'];//startのmonthに$value2sと名前をつける
    		$value3s = $data['start']['day'];//startのdayに$value3sと名前をつける
    		$value123s = array($value1s,$value2s,$value3s);//$value1s,$value2s,$value3sの配列に$value123s
    		$value_start = implode("-",$value123s);//$value1s,$value2s,$value3sを「-」でつなぐ
    		$this->set('value_start',$value_start);//$value_startをctpで使用できるようセット

    		$value1e = $data['end']['year'];//endのyearに$value1eと名前をつける
    		$value2e = $data['end']['month'];//endのyearに$value2eと名前をつける
    		$value3e = $data['end']['day'];//endのyearに$value3eと名前をつける
    		$value123e = array($value1e,$value2e,$value3e);//$value1e,$value2e,$value3eの配列に$value123e
    		$value_end = implode("-",$value123e);//$value1e,$value2e,$value3eを「-」でつなぐ
    		$this->set('value_end',$value_end);//$value_endをctpで使用できるようセット

    		$data2 = array_values($this->request->getData());//postで取り出した配列の値を取り出す
    		$product_code = $data2[2];//2番目の値が$product_code
    		$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    		$mes = '検索結果';//$mesを「検索結果」とする
    		$this->set('mes',$mes);//$mesをctpで使用できるようセット

        $KensahyouSokuteidata = $this->KensahyouSokuteidatas->find()->where(['manu_date >=' => $value_start, 'manu_date <=' => $value_end, 'delete_flag' => '0', 'product_code' => $product_code])->toArray();//Productsテーブルの'product_code' = $product_codeとなるものを配列で取り出す

      $arrP = array();//配列に追加$product_code, $lot_num, $manu_date
    	foreach ($KensahyouSokuteidata as $value) {
        $product_code= $value->product_code;
        $lot_num = $value->lot_num;
        $manu_date = $value->manu_date->format('Y-m-d H:i:s');
        $manu_date = substr($manu_date,0,10);
        $arrP[] = ['product_code' => $product_code, 'lot_num' => $lot_num, 'manu_date' => $manu_date];
    	}

      $tmp = [];//重複削除$lot_num
      $uniquearrP = [];
      foreach ($arrP as $arrP){
         if (!in_array($arrP['lot_num'], $tmp)) {
            $tmp[] = $arrP['lot_num'];
            $uniquearrP[] = $arrP;
         }
      }

      foreach ((array) $uniquearrP as $key => $value) {//並び替え$manu_date
          $sort[$key] = $value['manu_date'];
      }
      if(isset($uniquearrP[0])){
        array_multisort($sort, SORT_DESC, $uniquearrP);
      }

      $this->set('uniquearrP',$uniquearrP);//セット

    	} else {//post以外（get）でデータが送信された場合

    		$mes = '＊最新の上位３つの検査表です。';//$mesを「＊最新の上位３つの検査表です。」とする
    		$this->set('mes',$mes);//$mesをctpで使用できるようセット

        $KensahyouSokuteidata = $this->KensahyouSokuteidatas->find()->where(['delete_flag' => '0', 'product_code' => $product_code])->toArray();//Productsテーブルの'product_code' = $product_codeとなるものを配列で取り出す

      $arrP = array();//配列に追加$product_code, $lot_num, $manu_date
    	foreach ($KensahyouSokuteidata as $value) {
        $product_code= $value->product_code;
        $lot_num = $value->lot_num;
        $manu_date = $value->manu_date->format('Y-m-d H:i:s');
        $manu_date = substr($manu_date,0,10);
        $arrP[] = ['product_code' => $product_code, 'lot_num' => $lot_num, 'manu_date' => $manu_date];
    	}

      $tmp = [];//重複削除$lot_num
      $uniquearrP = [];
      foreach ($arrP as $arrP){
         if (!in_array($arrP['lot_num'], $tmp)) {
            $tmp[] = $arrP['lot_num'];
            $uniquearrP[] = $arrP;
         }
      }

      foreach ((array) $uniquearrP as $key => $value) {//並び替え$manu_date
          $sort[$key] = $value['manu_date'];
      }

      if(count($uniquearrP) > 0){
        array_multisort($sort, SORT_DESC, $uniquearrP);
        $uniquearrP = array_slice($uniquearrP , 0, 3);
      }

      $this->set('uniquearrP',$uniquearrP);//セット
    	}

    }

    public function view()//「出荷検査用呼出」詳細表示用
    {
    	$data = array_values($this->request->query);//getで取り出した配列の値を取り出す

      $lot_num = $data[1];//idをセット
      $this->set('lot_num',$lot_num);//セット

    	$product_code = $data[0];//配列の0番目（product_code）に$product_codeと名前を付ける
    	$this->set('product_code',$product_code);//$product_codeをセット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.php
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//$htmlKensahyouHeaderをセット

    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルの'product_id' = $Productidとなるものを配列で取り出す
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//新しいバージョンをセット
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

      $KensahyouHeadid = $KensahyouHead[0]->id;//idをセット
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

    	$KensahyouHead_manu_date = $data[2];//配列の10文字だけ抜き取りセット（manu_dateの表示のため）

    	$this->set('KensahyouHead_manu_date',$KensahyouHead_manu_date);//セット

    	$Kensahyou_inspec_date = $this->KensahyouSokuteidatas->find()->where(['product_code' => $product_code,'manu_date' => $KensahyouHead_manu_date])->toArray();//KensahyouSokuteidatasテーブルの'product_code' => $product_code,'manu_date' => $KensahyouHead_manu_dateとなるものを配列で取り出す（object型ででてくる）
    	$Kensahyou_inspec_date = (array)$Kensahyou_inspec_date[0]['inspec_date'];//1行下でsubstrを使うため、objectをarrayに変換
    	$KensahyouHead_inspec_date = substr($Kensahyou_inspec_date['date'],0,10);//配列の10文字だけ抜き取りセット（inspec_dateの表示のため）
    	$this->set('KensahyouHead_inspec_date',$KensahyouHead_inspec_date);//セット

    	$Productn = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルの'product_code' = $product_codeとなるものを配列で取り出す
      $Productname = $Productn[0]->product_name;//配列の0番目のproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット
  //    $Productid = $Productn[0]->id;//配列の0番目のproduct_nameに$Productnameと名前を付ける

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
            ${"ImKikakuid_".$j} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$j,${"ImKikakuid_".$j});//セット
          }else{
          }
        }else{
          ${"ImKikakuid_".$j} = "ノギス";
          $this->set('ImKikakuid_'.$j,${"ImKikakuid_".$j});//セット
        }
      }

      $KensahyouHeadbik = $KensahyouHead[0]->bik;
      $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

    	$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find('all', Array(//セット
    	'conditions' => Array('product_code' => $product_code,'lot_num' => $lot_num,'delete_flag' => '0','manu_date' => $data[2]),
    	'order' => array('cavi_num ASC')//cavi_numの小さい順
    	)));

    }

    public function kensahyouproductform()//「出荷検査表登録」ページトップ
    {
    	$this->set('entity',$this->KensahyouSokuteidatas->newEntity());//空のカラムにentityと名前を付け、ctpで使えるようにセット

    	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
    	->select(['product_code','delete_flag' => '0'])
    	->group('product_code');
/*
      $KensahyouHeads = $KensahyouHeads->toArray();//データを配列に変更
      if(isset($KensahyouHeads[0])){
        echo "<pre>";
        print_r($KensahyouHeads[0]['product_id']);
        echo "</pre>";
     }else{
       echo "<pre>";
       print_r("bbb");
       echo "</pre>";
     }
*/
    	$arrProductcode = array();//配列の初期化
    		foreach ($KensahyouHeads as $value) {//$KensahyouHeadsのそれぞれに対して
    			$product_code = $value->product_code;//$KensahyouHeadsのproduct_idに$product_idと名前を付ける
    	//		$product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得
    	//		$product_code = $product[0]->product_code;//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける
    			$arrProductcode[] = $product_code;//$product_codeを配列に追加
    		}
    		sort($arrProductcode);//配列$arrProductcodeのデータを昇順に並び替え
    		$this->set('arrProductcode',$arrProductcode);//セット
	}

  public function tourokuyobidashicustomer()//「出荷検査表登録」ページトップ
  {
   $this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()
   ->select(['product_code','delete_flag' => '0'])
   ->group('product_code')
   );
  }

  public function tourokuyobidashipana()
  {
    $this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()
     ->select(['product_code','delete_flag' => '0'])
     ->group('product_code')
     );
  }

  public function tourokuyobidashipanap0()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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
  }

  public function tourokuyobidashipanap1()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function tourokuyobidashipanap2()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function tourokuyobidashipanaw()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function tourokuyobidashipanah()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function tourokuyobidashipanare()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function tourokuyobidashidnp()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function tourokuyobidashiothers()
  {
    $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
    $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

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

  public function preform()//「出荷検査表登録」ページで検査結果を入力
  {
    $data = $this->request->query();

    if(isset($data["name"])){
      $product_code = $data["name"];
    }else{
      $data = $this->request->getData();
      $product_code = $data["product_code"];
    }
    $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    $product_name = $Product[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
    $this->set('Productname',$product_name);//セット

    $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    $this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    $KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    $this->set('KensahyouHead',$KensahyouHead);//セット

    if(isset($KensahyouHead[0])){

      $check = 1;
      $this->set('check',$check);

      $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

      $KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
      $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

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
        $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

          if($ImKikakus[$i]['kind_kensa'] != "") {
            ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット

          }else{
          }

        }
      }

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

    }else{

      $check = 2;
      $this->set('check',$check);

    }

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

    	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
    	->select(['product_code','delete_flag' => '0'])
    	->group('product_code');

      $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
      if(isset($ImSokuteidataHead[0])){
        $ImSokuteidataHead_id = $ImSokuteidataHead[0]->id;
        $ImKikaku = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHead_id])->toArray();
        for($i=1; $i<=5; $i++){//size_1～9までセット
          if(isset($ImSokuteidataHead[$i])){
            ${"ImSokuteidataHead_id_".$i} = $ImSokuteidataHead[$i]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
            $ImKikakutuika = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => ${"ImSokuteidataHead_id_".$i}])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
            $ImKikaku = array_merge($ImKikaku, $ImKikakutuika);
          }
        }
        $ImSokuteidataHead_id = $ImKikaku[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
        $ImSokuteidataHeadId = $ImKikaku[0]->im_sokuteidata_head_id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
        $ImSokuteidataResult = $this->ImSokuteidataResults->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHeadId ])->toArray();
      }

      $product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $productId = $product[0]->id;
      $this->set('productId',$productId);//セット

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
        $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

          if($ImKikakus[$i]['kind_kensa'] != "") {
            ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット

          }else{
          }

        }
      }

      $KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける

              for($i=1; $i<=9; $i++){//size_1～9までセット
                ${"kind_kensa".$i} = "ノギス";
                $this->set('kind_kensa'.$i,${"kind_kensa".$i});//セット
            		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
            		$this->set('size_'.$i,${"size_".$i});//セット
                for($j=0; $j<=20; $j++){//size_1～9までセット
                  if(isset($ImKikaku[$j])){//
                    if(${"size_".$i} == $ImKikaku[$j]['size'] and ${"size_".$i} != 0){//KensahyouHeadのsize$iと$ImKikaku[$j]['size']が同じ場合
                      $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['id' => $ImKikaku[$j]['im_sokuteidata_head_id']])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
                      ${"kind_kensa".$i} = $ImSokuteidataHead[0]->kind_kensa;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける

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

            	$staff_id = $this->Auth->user('staff_id');//created_staffの登録用
            	$this->set('staff_id',$staff_id);//セット

            	$this->set('kensahyouSokuteidata',$this->KensahyouSokuteidatas->newEntity());//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

            	$Products = $this->Products->find('all',[
            		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
            	]);

            	 foreach ($Products as $value) {//$Productsそれぞれに対し
            		$product_id= $value->id;//idに$product_idと名前を付ける
            	}
            	$this->set('product_id',$product_id);//セット

            	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
            	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
            	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

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

              $arrhantei = [''=>'','OK'=>'OK','out'=>'out'];
              $this->set('arrhantei',$arrhantei);//セット

              $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
              $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

    }

     public function confirm()//「出荷検査表登録」確認画面
    {
    	$data = $this->request->getData();//postデータを$dataに

    	$product_code = $data['product_code'];//$dataの'product_code'を$product_codeに
    	$this->set('product_code',$product_code);//セット

    	$Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
    		'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
    	]);
    	foreach ($Products as $value) {//上で見つけた$Productsに対して
    		$product_id= $value->id;//$Productsのidに$product_idと名前を付ける
    	}
    	$this->set('product_id',$product_id);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//myClassフォルダに配置したクラスを使う
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

      $KensahyouHeadid = $data['kensahyou_heads_id'];//$dataのkensahyou_heads_idに$kensahyou_heads_idと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      $lot_num = $data['lot_num'];//$dataのkensahyou_heads_idに$kensahyou_heads_idと名前を付ける
    	$this->set('lot_num',$lot_num);//セット

    	$manu_dateY = $data['manu_date']['year'];//manu_dateのyearに$manu_dateYと名前を付ける
    	$manu_dateM = $data['manu_date']['month'];//manu_dateのmonthに$manu_dateMと名前を付ける
    	$manu_dateD = $data['manu_date']['day'];//manu_dateのdayに$manu_dateDと名前を付ける
    	$manu_dateYMD = array($manu_dateY,$manu_dateM,$manu_dateD);//$manu_dateY,$manu_dateM,$manu_dateDの配列に$manu_dateYMD
    	$manu_date = implode("-",$manu_dateYMD);//$manu_dateY,$manu_dateM,$manu_dateDを「-」でつなぐ
    	$this->set('manu_date',$manu_date);//セット

      if(isset($data['inspec_date']['year'])){
      	$inspec_dateY = $data['inspec_date']['year'];//inspec_dateのyearに$inspec_dateYと名前を付ける
      	$inspec_dateM = $data['inspec_date']['month'];//inspec_dateのmonthに$inspec_dateMと名前を付ける
      	$inspec_dateD = $data['inspec_date']['day'];//inspec_dateのdayに$inspec_dateDと名前を付ける
      	$inspec_dateYMD = array($inspec_dateY,$inspec_dateM,$inspec_dateD);//$inspec_dateY,$inspec_dateM,$inspec_dateDの配列に$manu_dateYMD
      	$inspec_date = implode("-",$inspec_dateYMD);//$inspec_dateY,$inspec_dateM,$inspec_dateDを「-」でつなぐ
      	$this->set('inspec_date',$inspec_date);//セット
      }else{
        $inspec_date = $data['inspec_date'];
        $this->set('inspec_date',$inspec_date);//セット
      }

    	$delete_flag = $data['delete_flag'];//$dataのdelete_flagに$delete_flagと名前を付ける
    	$this->set('delete_flag',$delete_flag);//セット

    	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffと名前を付ける
    	$this->set('created_staff',$created_staff);//セット

    	$updated_staff = $data['updated_staff'];//$dataのupdated_staffに$updated_staffと名前を付ける
    	$this->set('updated_staff',$updated_staff);//セット

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
        $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

          if($ImKikakus[$i]['kind_kensa'] != "") {
            ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット

          }else{
          }

        }
      }

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

     $session = $this->request->getSession();
     $data = $session->read();//postデータ取得し、$dataと名前を付ける
    }

   public function login()
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換

       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
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
 //    return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
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

      $lot_num = $data[1]['lot_num'];//$dataのkensahyou_heads_idに$kensahyou_heads_idと名前を付ける
      $this->set('lot_num',$lot_num);//セット

    	$Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
    		'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
    	]);

    	foreach ($Products as $value) {//上で見つけた$Productsに対して
    		$product_code= $value->product_code;//$Productsのidに$product_idと名前を付ける
    	}
    	$this->set('product_code',$product_code);//セット

    	$kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//表示用
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

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
        $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

          if($ImKikakus[$i]['kind_kensa'] != "") {
            ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット

          }else{
          }

        }
      }

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
    	if ($this->request->is('get')) {
    		$kensahyouSokuteidata = $this->KensahyouSokuteidatas->patchEntities($kensahyouSokuteidata, $data);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
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

              $mes = "※登録されました。";
   						$this->set('mes',$mes);
    					$connection->commit();// コミット5
    				} else {
              $mes = "※登録できませんでした。";
   						$this->set('mes',$mes);
    					$this->Flash->error(__('The KensahyouSokuteidatas could not be saved. Please, try again.'));
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
    	$kensahyouSokuteidata = $this->KensahyouSokuteidatas->get($id);
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidata);

    	$staff_id = $this->Auth->user('staff_id');
    	$kensahyouHead['updated_staff'] = $staff_id;

    		if ($this->request->is(['patch', 'post', 'put'])) {
    			$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());

    			$connection = ConnectionManager::get('default');//トランザクション1
    				// トランザクション開始2
    			$connection->begin();//トランザクション3
    			try {//トランザクション4

    				if ($this->KensahyouHeads->save($kensahyouHead)) {
    					$this->Flash->success(__('The KensahyouHeads has been updated.'));
    					$connection->commit();// コミット5
    					return $this->redirect(['action' => 'index']);
    				} else {
    					$this->Flash->error(__('The KensahyouHeads could not be updated. Please, try again.'));
    					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
    				}
    			} catch (Exception $e) {//トランザクション7
    			//ロールバック8
    				$connection->rollback();//トランザクション9
    			}//トランザクション10
    		}
    }

}
