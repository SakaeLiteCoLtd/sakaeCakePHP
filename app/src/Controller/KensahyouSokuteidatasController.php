<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//他のテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use App\myClass\KensahyouSokuteidata\htmlKensahyouSokuteidata;//myClassフォルダに配置したクラスを使用

use App\myClass\Sessioncheck\htmlSessioncheck;//myClassフォルダに配置したクラスを使用

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
      $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');//Usersテーブルを使う
      $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');//KadouSeikeisテーブルを使う
      $this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');
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
      $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
      $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

      if($this->request->is('post')){
        $data = $this->request->getData();
      }else{
        $data = $this->request->query();
      }

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
    	$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

      if (isset($data['start'])) {//データがpostで送られたとき（日付を選んだ場合）

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
      $KensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();
      $this->set('KensahyouSokuteidatas',$KensahyouSokuteidatas);

    	$data = array_values($this->request->query);//getで取り出した配列の値を取り出す

      $lot_num = $data[1];//idをセット
      $this->set('lot_num',$lot_num);//セット

    	$product_code = $data[0];//配列の0番目（product_code）に$product_codeと名前を付ける
    	$this->set('product_code',$product_code);//$product_codeをセット

      $KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//KensahyouHeadsテーブルの'product_id' = $Productidとなるものを配列で取り出す
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version + 1;//新しいバージョンをセット
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

      $KensahyouHeadid = $KensahyouHead[0]->id;//idをセット
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

    	$KensahyouHead_manu_date = $data[2];//配列の10文字だけ抜き取りセット（manu_dateの表示のため）
    	$this->set('KensahyouHead_manu_date',$KensahyouHead_manu_date);//セット

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

      for($i=1; $i<=27; $i++){
        ${"ImKikakuid_".$i} = "ノギス";
        $this->set('ImKikakuid_'.$i,${"ImKikakuid_".$i});
      }

      $ImKikakus = $this->ImKikakuTaious->find()
      ->where(['product_code' => $product_code ,'status' => '0'])->order(["version"=>"desc"])->toArray();
      foreach ((array)$ImKikakus as $key => $value) {
           $sort[$key] = $value['kensahyuo_num'];
       }
       if(isset($ImKikakus[0])){
        array_multisort($sort, SORT_ASC, $ImKikakus);
      }

      for($i=0; $i<count($ImKikakus); $i++){
        $j = $i + 1;
      if(isset($ImKikakus[$i])) {
        $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

          if($ImKikakus[$i]['kind_kensa'] != "") {
            ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット
          }

        }
      }

      $KensahyouHeadbik = $KensahyouHead[0]->bik;
      $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

      $KensahyouHead = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();
      $this->set('KensahyouHead',$KensahyouHead);//セット

      $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

      $maisu = $KensahyouHead[0]->maisu;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('maisu',$maisu);//セット

      $KensahyouHeadid = $KensahyouHead[0]->id;
      $this->set('KensahyouHeadid',$KensahyouHeadid);

      $KensahyouHeads = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();

      $num_size = 0;
      for($k=1; $k<=$maisu; $k++){

        for($i=1; $i<=9; $i++){
          $num_size = ($k - 1)*9 + $i;

          if(isset($KensahyouHeads[$k-1]["size_".$i])){
            ${"size_".$num_size} = $KensahyouHeads[$k-1]["size_".$i];
          }else{
            ${"size_".$num_size} = "";
          }
          $this->set('size_'.$num_size,${"size_".$num_size});
        }

        for($j=1; $j<=8; $j++){
          $num_size = ($k - 1)*9 + $j;

          if(isset($KensahyouHeads[$k-1]["upper_".$j])){
            ${"upper_".$num_size} = $KensahyouHeads[$k-1]["upper_".$j];
          }else{
            ${"upper_".$num_size} = "";
          }
          $this->set('upper_'.$num_size,${"upper_".$num_size});

          if(isset($KensahyouHeads[$k-1]["lower_".$j])){
            ${"lower_".$num_size} = $KensahyouHeads[$k-1]["lower_".$j];
          }else{
            ${"lower_".$num_size} = "";
          }
          $this->set('lower_'.$num_size,${"lower_".$num_size});

        }

      }

      for($i=10; $i<=11; $i++){
        ${"text_".$i} = $KensahyouHeads[0]["text_".$i];
        $this->set('text_'.$i,${"text_".$i});
     }

     $KensahyouSokuteiDatas = $this->KensahyouSokuteidatas->find()->where([
       'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'manu_date' => $KensahyouHead_manu_date])->toArray();//KensahyouSokuteidatasテーブルの'product_code' => $product_code,'manu_date' => $KensahyouHead_manu_dateとなるものを配列で取り出す（object型ででてくる）
       $this->set('KensahyouHead_inspec_date',$KensahyouSokuteiDatas[0]["inspec_date"]);
/*
       echo "<pre>";
       print_r($KensahyouSokuteiDatas);
       echo "</pre>";
*/
       for($i=0; $i<count($KensahyouSokuteiDatas); $i++){

         if(strpos($KensahyouSokuteiDatas[$i]["product_code"],'---') === false){//---が含まれていない

             $j = $KensahyouSokuteiDatas[$i]["cavi_num"];
             for($k=1; $k<=9; $k++){
               ${"result_size_".$j."_".$k} = $KensahyouSokuteiDatas[$i]['result_size_'.$k];
               $this->set('result_size_'.$j."_".$k,${"result_size_".$j."_".$k});
             }

             ${"situation_dist1_".$j} = $KensahyouSokuteiDatas[$i]['situation_dist1'];
             $this->set('situation_dist1_'.$j,${"situation_dist1_".$j});
             ${"situation_dist2_".$j} = $KensahyouSokuteiDatas[$i]['situation_dist2'];
             $this->set('situation_dist2_'.$j,${"situation_dist2_".$j});
             ${"result_weight_".$j} = $KensahyouSokuteiDatas[$i]['result_weight'];
             $this->set('result_weight_'.$j,${"result_weight_".$j});

         }elseif(strpos($KensahyouSokuteiDatas[$i]["product_code"],'---3') === false){//---3が含まれていない(2枚目のとき)

           $j = $KensahyouSokuteiDatas[$i]["cavi_num"];
           for($k=10; $k<=18; $k++){
             $size_num = $k - 9;
             ${"result_size_".$j."_".$k} = $KensahyouSokuteiDatas[$i]['result_size_'.$size_num];
             $this->set('result_size_'.$j."_".$k,${"result_size_".$j."_".$k});
           }

         }else{

           $j = $KensahyouSokuteiDatas[$i]["cavi_num"];
           for($k=19; $k<=27; $k++){
             $size_num = $k - 18;
             ${"result_size_".$j."_".$k} = $KensahyouSokuteiDatas[$i]['result_size_'.$size_num];
             $this->set('result_size_'.$j."_".$k,${"result_size_".$j."_".$k});
           }

         }

       }

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

   $Data=$this->request->query('s');
   if(isset($Data["mess"])){
     $mess = $Data["mess"];
     $this->set('mess',$mess);
   }else{
     $mess = "";
     $this->set('mess',$mess);
   }

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
       if(((0 === strpos($product_code, "W")) && ($customer_id == 2)) || ((0 === strpos($product_code, "AW")) && ($customer_id == 2))){
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

    if(isset($data["value"])){
      $product_code = $data["name"];
      $this->set('product_code',$product_code);
      $kadouseikeiId = $data["value"];
      $this->set('kadouseikeiId',$kadouseikeiId);//セット

      if(strpos($kadouseikeiId,'_') !== false){
        $arr_id = explode("_",$data["value"]);
      }else{
        $arr_id = explode("=",$data["value"]);
      }

      if(!isset($arr_id[1])){
        $KadouSeikeis = $this->KadouSeikeis->find()->where(['id' => $kadouseikeiId])->toArray();
        $KadouSeikeisdaymoto = $KadouSeikeis[0]->starting_tm->format('Y-m-d_H_:i:s');
        list($a, $h, $c) = explode('_', $KadouSeikeisdaymoto);
        if(8 <= intval($h) && intval($h) <= 23){//開始時間が８時～２３時の場合はその日がmanu_date
          $manu_date = $KadouSeikeis[0]->starting_tm->format('Y-m-d');
        }else{//開始時間が８時～２３時でない場合はその前日がmanu_date
          $KariKadouSeikeisdayymd = $KadouSeikeis[0]->starting_tm->format('Y-m-d');
          $manu_date = date("Y-m-d", strtotime("-1 day", strtotime($KariKadouSeikeisdayymd)));
        }
        $this->set('manu_date',$manu_date);//セット

      }else{

        $manu_date = date("Y-m-d");
        $this->set('manu_date',$manu_date);//セット

      }

    }elseif(isset($data["name"])){
      $product_code = $data["name"];
      $kadouseikeiId = "aaa";
      $this->set('kadouseikeiId',$kadouseikeiId);//セット
      $manu_date = date("Y-m-d");
      $this->set('manu_date',$manu_date);//セット
    }else{
      $data = $this->request->getData();
      $product_code = $data["product_code"];
      $kadouseikeiId = "aaa";
      $this->set('kadouseikeiId',$kadouseikeiId);//セット
      $manu_date = date("Y-m-d");
      $this->set('manu_date',$manu_date);//セット
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
    $KensahyouHead = $this->KensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
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

      $ImKikakus = $this->ImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => '0'])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得（プルダウン）
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
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $kadouseikeiId = $data["kadouseikeiId"];
      $this->set('kadouseikeiId',$kadouseikeiId);

      $today = strtotime(date('Y-m-d'));
      $date2back = date('Y-m-d', strtotime('-2 day', $today));

      $product_code = $data['product_code1'];
      $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
      $product_name = $data['product_name1'];
      $this->set('Productname',$product_name);//セット
      $lot_num = $data['lot_num'];
      $this->set('lot_num',$lot_num);//セット
      if(isset($data['lot_num_new'])){
        $lot_num_new = $data['lot_num_new'];
        $this->set('lot_num_new',$lot_num_new);//セット
      }

      $mess = "";
      $this->set('mess',$mess);

      for($i=1; $i<=27; $i++){
        ${"ImKikakuid_".$i} = "ノギス";
        $this->set('ImKikakuid_'.$i,${"ImKikakuid_".$i});
      }

      $ImKikakus = $this->ImKikakuTaious->find()
      ->where(['product_code' => $product_code ,'status' => '0'])->order(["version"=>"desc"])->toArray();
      foreach ((array)$ImKikakus as $key => $value) {
           $sort[$key] = $value['kensahyuo_num'];
       }
       if(isset($ImKikakus[0])){
        array_multisort($sort, SORT_ASC, $ImKikakus);
      }

      for($i=0; $i<count($ImKikakus); $i++){
        $j = $i + 1;
      if(isset($ImKikakus[$i])) {
        $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

          if($ImKikakus[$i]['kind_kensa'] != "") {
            ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
            $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット
          }

        }
      }

//ここから修正追加211222

$ImSokuteidataResults = $this->ImSokuteidataResults->find()
->select(['im_sokuteidata_head_id', 'size_num', 'lot_num', 'serial', 'result', 'inspec_datetime'])
->where(['lot_num' => $lot_num])->order(['inspec_datetime' => "ASC"])->toArray();

$arrImSokuteidataResult = array();//空の配列を作る
for($k=0; $k<count($ImSokuteidataResults); $k++){

  ${"ImSokuteidataHeads".$k} = $this->ImSokuteidataHeads->find()
  ->where(['id' => $ImSokuteidataResults[$k]["im_sokuteidata_head_id"], 'product_code' => $product_code])->toArray();
  if(isset(${"ImSokuteidataHeads".$k}[0])){

    $kind_kensa = ${"ImSokuteidataHeads".$k}[0]["kind_kensa"];
    $arrkind_kensa = explode('_', $kind_kensa);
    if(isset($arrkind_kensa[1])){
      $kind_kensa = $arrkind_kensa[1];
    }else{
      $kind_kensa = $arrkind_kensa[0];
    }

    $arrImSokuteidataResult[] = [
      "size_num" => $ImSokuteidataResults[$k]["size_num"],
      "serial" => $ImSokuteidataResults[$k]["serial"],
      "result" => $ImSokuteidataResults[$k]["result"],
      "kind_kensa" => $kind_kensa
    ];
  }

}

/*なぜかエラー
$ImSokuteidataResults = $this->ImSokuteidataResults->find()->contain(["ImSokuteidataHeads"])
->select(['im_sokuteidata_head_id', 'size_num', 'ImSokuteidataResults.lot_num', 'serial', 'result', 'inspec_datetime', 'ImSokuteidataHeads.product_code'])
->where(['ImSokuteidataResults.lot_num' => $lot_num, 'product_code' => $product_code])->order(['inspec_datetime' => "ASC"])->toArray();
*/
/*
echo "<pre>";
print_r($arrImSokuteidataResult);
echo "</pre>";
*/
for($k=0; $k<count($arrImSokuteidataResult); $k++){

  ${"ImKikakuTaious".$k} = $this->ImKikakuTaious->find()
  ->where(['product_code' => $product_code, 'kind_kensa' => $arrImSokuteidataResult[$k]["kind_kensa"], 'size_num' => $arrImSokuteidataResult[$k]["size_num"], 'status' => '0'])->order(["version"=>"desc"])->toArray();

  if(isset(${"ImKikakuTaious".$k}[0])){

    $i = ${"ImKikakuTaious".$k}[0]["kensahyuo_num"];
    $j = round($arrImSokuteidataResult[$k]["serial"],0);
    ${"ImSokuteidata_result_".$i."_".$j} = $arrImSokuteidataResult[$k]["result"];
    ${"ImSokuteidata_result_".$i."_".$j} = round(${"ImSokuteidata_result_".$i."_".$j},2);
    $this->set('ImSokuteidata_result_'.$i.'_'.$j,${"ImSokuteidata_result_".$i."_".$j});//セット

  }

}

//ここまで

        $staff_id = $this->Auth->user('staff_id');//created_staffの登録用
        $this->set('staff_id',$staff_id);//セット

        $this->set('kensahyouSokuteidata',$this->KensahyouSokuteidatas->newEntity());//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

        $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
        $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_code);//
        $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

        $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
        $Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
        $Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
        $this->set('Productname',$Productname);//セット
        /*
        $KensahyouHead = $this->KensahyouHeads->find()
        ->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
*/
        $KensahyouHead = $this->KensahyouHeads->find()->where([
          'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();
        $this->set('KensahyouHead',$KensahyouHead);//セット

        $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
        $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

        $maisu = $KensahyouHead[0]->maisu;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
        $this->set('maisu',$maisu);//セット

        $KensahyouHeadid = $KensahyouHead[0]->id;
        $this->set('KensahyouHeadid',$KensahyouHeadid);

        $KensahyouHeads = $this->KensahyouHeads->find()->where([
          'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();

        $num_size = 0;
        for($k=1; $k<=$maisu; $k++){

          for($i=1; $i<=9; $i++){
            $num_size = ($k - 1)*9 + $i;

            if(isset($KensahyouHeads[$k-1]["size_".$i])){
              ${"size_".$num_size} = $KensahyouHeads[$k-1]["size_".$i];
            }else{
              ${"size_".$num_size} = "";
            }
            $this->set('size_'.$num_size,${"size_".$num_size});
          }

          for($j=1; $j<=8; $j++){
            $num_size = ($k - 1)*9 + $j;

            if(isset($KensahyouHeads[$k-1]["upper_".$j])){
              ${"upper_".$num_size} = $KensahyouHeads[$k-1]["upper_".$j];
            }else{
              ${"upper_".$num_size} = "";
            }
            $this->set('upper_'.$num_size,${"upper_".$num_size});

            if(isset($KensahyouHeads[$k-1]["lower_".$j])){
              ${"lower_".$num_size} = $KensahyouHeads[$k-1]["lower_".$j];
            }else{
              ${"lower_".$num_size} = "";
            }
            $this->set('lower_'.$num_size,${"lower_".$num_size});

          }

        }

        for($i=10; $i<=11; $i++){
          ${"text_".$i} = $KensahyouHeads[0]["text_".$i];
          $this->set('text_'.$i,${"text_".$i});
       }

        $arrhantei = [''=>'','OK'=>'OK','out'=>'out'];
        $this->set('arrhantei',$arrhantei);//セット

        $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
        $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

        if(isset($data["next"])){
          $count = $data["num"]*9;
          for($k=1; $k<=$count; $k++){

            for($j=1; $j<=8; $j++){
              ${"result_size_".$j."_".$k} = $data['result_size_'.$j."_".$k];
              $this->set('result_size_'.$j."_".$k,${"result_size_".$j."_".$k});
            }

          }

            for($j=1; $j<=8; $j++){
              ${"situation_dist1_".$j} = $data['situation_dist1_'.$j];
              $this->set('situation_dist1_'.$j,${"situation_dist1_".$j});
              ${"situation_dist2_".$j} = $data['situation_dist2_'.$j];
              $this->set('situation_dist2_'.$j,${"situation_dist2_".$j});
              ${"result_weight_".$j} = $data['result_weight_'.$j];
              $this->set('result_weight_'.$j,${"result_weight_".$j});
            }

//ここから入力チェック
            $size_count = 0;
            $count_minus = ($data["num"] - 1)*9 + 1;
            for($m=1; $m<=8; $m++){//上から何個入力されているか
              if(strlen($data["result_size_{$m}_{$count_minus}"]) > 0){
                $size_count = $size_count + 1;
              }
            }

            $count_left = 0;
            for($k=$count_minus; $k<=$count; $k++){
              $count_left = $count_left + 1;
              for($j=1; $j<=$size_count; $j++){
                if(strlen(${"size_".$k}) > 0){
                  if(strlen($data["result_size_{$j}_{$k}"]) == 0){
                    $mess = $mess."左から".$count_left."番目、上から".$j."番目に入力漏れがあります<br>";
                  }
                }
              }
            }

            if($data["num"] == 1){
              for($j=1; $j<=$size_count; $j++){
                if(strlen($data["result_weight_{$j}"]) == 0){
                  $mess = $mess."単重データの上から".$j."番目に入力漏れがあります<br>";
                }
                if($text_10 == "外観1" && strlen($data["situation_dist1_{$j}"]) == 0){
                  $mess = $mess."外観１データの上から".$j."番目に入力漏れがあります<br>";
                }
                if($text_11 == "外観1" && strlen($data["situation_dist2_{$j}"]) == 0){
                  $mess = $mess."外観２データの上から".$j."番目に入力漏れがあります<br>";
                }
              }
            }

            $dotcheck = 0;
            for($n=1; $n<=8; $n++){

              for($l=1; $l<=9; $l++){
                $m = ($data["num"] - 1)*9 + $l;

                $dot1 = substr($data["result_size_{$n}_{$m}"], 0, 1);
                $dot2 = substr($data["result_size_{$n}_{$m}"], -1, 1);

                if($dot1 == "." || $dot2 == "."){
                  $dotcheck = $dotcheck + 1;
                  $mess = $mess."左から".$m."番目、上から".$n."番目のデータの「.」の位置を確認してください。<br>";
                }

              }

            }
            $this->set('mess',$mess);

            if(strlen($mess) > 0){//入力ミスがある場合

              $num = $data['num'];
              $this->set('num',$num);//セット

            }else{//入力ミスがない場合

              $num = $data['num'] + 1;
              $this->set('num',$num);//セット

              if($data["num"] == $data["maisu"]){

                if(!isset($_SESSION)){
                  session_start();
                }
                $_SESSION['formkensahyousokuteidatas'] = array();
                $_SESSION['formkensahyousokuteidatas'] = $data;

                return $this->redirect(['action' => 'confirm']);

              }

            }

        }elseif(isset($data["signess"])){

          $num = $data['num'];
          $this->set('num',$num);//セット
/*
          echo "<pre>";
          print_r("signess");
          echo "</pre>";
*/
        }else{//この画面に最初に来た時

          $num = 1;
          $this->set('num',$num);//セット

        }

    }

     public function confirm()//「出荷検査表登録」確認画面
    {
      $session = $this->request->getSession();
      $_SESSION = $session->read();

      $data = $_SESSION['formkensahyousokuteidatas'];
      /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
  //  	$data = $this->request->getData();//postデータを$dataに

      $kadouseikeiId = $data["kadouseikeiId"];
      $this->set('kadouseikeiId',$kadouseikeiId);
      $maisu = $data["maisu"];
      $this->set('maisu',$maisu);

    	$product_code = $data['product_code'];//$dataの'product_code'を$product_codeに
    	$this->set('product_code',$product_code);//セット

      $KensahyouHeads = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();

      $num_size = 0;
      for($k=1; $k<=$maisu; $k++){

        for($i=1; $i<=9; $i++){
          $num_size = ($k - 1)*9 + $i;

          if(isset($KensahyouHeads[$k-1]["size_".$i])){
            ${"size_".$num_size} = $KensahyouHeads[$k-1]["size_".$i];
          }else{
            ${"size_".$num_size} = "";
          }
          $this->set('size_'.$num_size,${"size_".$num_size});
        }

        for($j=1; $j<=8; $j++){
          $num_size = ($k - 1)*9 + $j;

          if(isset($KensahyouHeads[$k-1]["upper_".$j])){
            ${"upper_".$num_size} = $KensahyouHeads[$k-1]["upper_".$j];
          }else{
            ${"upper_".$num_size} = "";
          }
          $this->set('upper_'.$num_size,${"upper_".$num_size});

          if(isset($KensahyouHeads[$k-1]["lower_".$j])){
            ${"lower_".$num_size} = $KensahyouHeads[$k-1]["lower_".$j];
          }else{
            ${"lower_".$num_size} = "";
          }
          $this->set('lower_'.$num_size,${"lower_".$num_size});

        }

      }

      for($i=10; $i<=11; $i++){
        ${"text_".$i} = $KensahyouHeads[0]["text_".$i];
        $this->set('text_'.$i,${"text_".$i});
     }

     $count = $data["maisu"]*9;
     for($k=1; $k<=$count; $k++){

       for($j=1; $j<=8; $j++){
         ${"result_size_".$j."_".$k} = $data['result_size_'.$j."_".$k];
         $this->set('result_size_'.$j."_".$k,${"result_size_".$j."_".$k});
       }

     }

       for($j=1; $j<=8; $j++){
         ${"situation_dist1_".$j} = $data['situation_dist1_'.$j];
         $this->set('situation_dist1_'.$j,${"situation_dist1_".$j});
         ${"situation_dist2_".$j} = $data['situation_dist2_'.$j];
         $this->set('situation_dist2_'.$j,${"situation_dist2_".$j});
         ${"result_weight_".$j} = $data['result_weight_'.$j];
         $this->set('result_weight_'.$j,${"result_weight_".$j});
       }

     for($i=1; $i<=27; $i++){
       ${"ImKikakuid_".$i} = "ノギス";
       $this->set('ImKikakuid_'.$i,${"ImKikakuid_".$i});
     }

     $ImKikakus = $this->ImKikakuTaious->find()
     ->where(['product_code' => $product_code ,'status' => '0'])->order(["version"=>"desc"])->toArray();
     foreach ((array)$ImKikakus as $key => $value) {
          $sort[$key] = $value['kensahyuo_num'];
      }
      if(isset($ImKikakus[0])){
       array_multisort($sort, SORT_ASC, $ImKikakus);
     }

     for($i=0; $i<count($ImKikakus); $i++){
       $j = $i + 1;
     if(isset($ImKikakus[$i])) {
       $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

         if($ImKikakus[$i]['kind_kensa'] != "") {
           ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
           $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット
         }

       }
     }

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

      $KensahyouHeadid = $data['kensahyou_heads_id'];
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      $lot_num = $data['lot_num_new'];
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
    	$KensahyouHead = $this->KensahyouHeads->find()
      ->where(['product_code' => $product_code,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット
    	$Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      $ImKikakus = $this->ImKikakuTaious->find()
      ->where(['product_code' => $product_code ,'status' => '0'])->order(["version"=>"desc"])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得（プルダウン）
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

      $count_size = 0;
      for($i=1; $i<=8; $i++){//size_1～8までセット
        ${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
        $this->set('size_'.$i,${"size_".$i});//セット

        if(strlen(${"size_".$i}) > 0){
          $count_size = $count_size + 1;
        }

      }
      $this->set('count_size',$count_size);

      $count_sori = 0;
      if(strlen($KensahyouHead[0]->size_9) > 0){
        $count_sori = 1;
      }
      $this->set('count_sori',$count_sori);

      $count_text_10 = 0;
      if($KensahyouHead[0]->text_10 == "外観1"){
        $count_text_10 = 1;
      }
      $this->set('count_text_10',$count_text_10);

      $count_text_11 = 0;
      if($KensahyouHead[0]->text_11 == "外観2"){
        $count_text_11 = 1;
      }
      $this->set('count_text_11',$count_text_11);
/*
      echo "<pre>";
      print_r($count_size." ".$count_sori." ".$count_text_10." ".$count_text_11);
      echo "</pre>";
*/
      $count_total = $count_size + $count_sori + $count_text_10 + $count_text_11 + 1;
      $this->set('count_total',$count_total);

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
  //    $this->request->session()->destroy();// セッションの破棄

      $data = $this->request->getData();

      $gaikancount = 0;
      for($n=1; $n<=8; $n++){

        if($data["situation_dist1_{$n}"] == "out"){
          $gaikancount = $gaikancount + 1;
        }

        if($data["situation_dist2_{$n}"] == "out"){
          $gaikancount = $gaikancount + 1;
        }

      }

      $this->set('gaikancount',$gaikancount);//セット

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

       if(isset($_POST["kensahyou_heads_id"])){

         if(!isset($_SESSION)){
         session_start();
         }
         $session = $this->request->getSession();
         $_SESSION['sokuteidata'.$username] = array();
         $_SESSION['kadouseikeiId'.$username] = array();

         for($k=1; $k<=$_POST["maisu"]; $k++){

           if($k == 1){
             $product_code = $_POST["product_code"];

             for($n=1; $n<=8; $n++){
               $_SESSION['sokuteidata'.$username][$n] = array(
                 'kensahyou_heads_id' => $_POST["kensahyou_heads_id"],
                 'product_code' => $product_code,
                 'lot_num' => $_POST["lot_num"],
                 'manu_date' => $_POST["manu_date"],
                 'inspec_date' => $_POST["inspec_date"],
                 'cavi_num' => $n,
                 'delete_flag' => $_POST["delete_flag"],
                 'updated_staff' => $_POST["updated_staff"],
                 'result_weight' => $_POST["result_weight_{$n}"],
                 'situation_dist1' => $_POST["situation_dist1_{$n}"],
                 'situation_dist2' => $_POST["situation_dist2_{$n}"],
               );

               for($m=1; $m<=9; $m++){
                 $_SESSION['sokuteidata'.$username][$n]["result_size_".$m] = $_POST["result_size_{$n}_{$m}"];
                }
              }

           }elseif($k == 2){
             $product_code = $_POST["product_code"]."---2";

             for($n=1; $n<=8; $n++){
               $num_count2 = $n + 8;

               $_SESSION['sokuteidata'.$username][$num_count2] = array(
                 'kensahyou_heads_id' => $_POST["kensahyou_heads_id"],
                 'product_code' => $product_code,
                 'lot_num' => $_POST["lot_num"],
                 'manu_date' => $_POST["manu_date"],
                 'inspec_date' => $_POST["inspec_date"],
                 'cavi_num' => $n,
                 'delete_flag' => $_POST["delete_flag"],
                 'updated_staff' => $_POST["updated_staff"],
                 'result_weight' => null,
                 'situation_dist1' => null,
                 'situation_dist2' => null,
               );

               for($m=1; $m<=9; $m++){
                 $num = $m + 9;
                 $_SESSION['sokuteidata'.$username][$num_count2]["result_size_".$m] = $_POST["result_size_{$n}_{$num}"];
                }
              }

           }else{
             $product_code = $_POST["product_code"]."---3";

             for($n=1; $n<=8; $n++){
               $num_count2 = $n + 16;

               $_SESSION['sokuteidata'.$username][$num_count2] = array(
                 'kensahyou_heads_id' => $_POST["kensahyou_heads_id"],
                 'product_code' => $product_code,
                 'lot_num' => $_POST["lot_num"],
                 'manu_date' => $_POST["manu_date"],
                 'inspec_date' => $_POST["inspec_date"],
                 'cavi_num' => $n,
                 'delete_flag' => $_POST["delete_flag"],
                 'updated_staff' => $_POST["updated_staff"],
                 'result_weight' => null,
                 'situation_dist1' => null,
                 'situation_dist2' => null,
               );

               for($m=1; $m<=9; $m++){
                 $num = $m + 18;
                 $_SESSION['sokuteidata'.$username][$num_count2]["result_size_".$m] = $_POST["result_size_{$n}_{$num}"];
                }
              }

           }

         }

         $_SESSION['kadouseikeiId'.$username][] = $_POST["kadouseikeiId"];

       }

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
  //   $this->request->session()->destroy(); // セッションの破棄
 //    return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
   }

     public function do()//「出荷検査表登録」登録画面
    {
      $session = $this->request->getSession();
      $sessiondata = $session->read();
/*
      $session_names = "Auth";//データ登録に必要なセッションの名前をカンマでつなぐ
      $htmlSessioncheck = new htmlSessioncheck();
      $arr_session_flag = $htmlSessioncheck->check($session_names);
      if($arr_session_flag["num"] > 1){//セッション切れの場合
        return $this->redirect(['action' => 'tourokuyobidashicustomer',
        's' => ['mess' => $arr_session_flag["mess"]]]);
      }
*/
      for($n=1; $n<=count($_SESSION['sokuteidata'.$this->Auth->user('username')]); $n++){
        $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
        $_SESSION['sokuteidata'.$this->Auth->user('username')][$n] = array_merge($created_staff,$_SESSION['sokuteidata'.$this->Auth->user('username')][$n]);
      }

      $tourokudata = $_SESSION['sokuteidata'.$this->Auth->user('username')];
      $data = $_SESSION['formkensahyousokuteidatas'];
/*
      echo "<pre>";
      print_r($tourokudata);
      echo "</pre>";
*/
      $maisu = $data['maisu'];
      $this->set('maisu',$maisu);

      $kousin_id = $_SESSION['kadouseikeiId'.$this->Auth->user('username')][0];

      $product_code = $data['product_code'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
      $this->set('product_code',$product_code);//セット

      $lot_num = $data['lot_num'];
      $this->set('lot_num',$lot_num);//セット

      $KensahyouHeads = $this->KensahyouHeads->find()->where([
        'OR' => [['product_code' => $product_code], ['product_code like' => $product_code.'---%']], 'delete_flag' => '0'])->order(["product_code"=>"asc"])->toArray();

      $num_size = 0;
      for($k=1; $k<=$maisu; $k++){

        for($i=1; $i<=9; $i++){
          $num_size = ($k - 1)*9 + $i;

          if(isset($KensahyouHeads[$k-1]["size_".$i])){
            ${"size_".$num_size} = $KensahyouHeads[$k-1]["size_".$i];
          }else{
            ${"size_".$num_size} = "";
          }
          $this->set('size_'.$num_size,${"size_".$num_size});
        }

        for($j=1; $j<=8; $j++){
          $num_size = ($k - 1)*9 + $j;

          if(isset($KensahyouHeads[$k-1]["upper_".$j])){
            ${"upper_".$num_size} = $KensahyouHeads[$k-1]["upper_".$j];
          }else{
            ${"upper_".$num_size} = "";
          }
          $this->set('upper_'.$num_size,${"upper_".$num_size});

          if(isset($KensahyouHeads[$k-1]["lower_".$j])){
            ${"lower_".$num_size} = $KensahyouHeads[$k-1]["lower_".$j];
          }else{
            ${"lower_".$num_size} = "";
          }
          $this->set('lower_'.$num_size,${"lower_".$num_size});

        }

      }

      for($i=10; $i<=11; $i++){
        ${"text_".$i} = $KensahyouHeads[0]["text_".$i];
        $this->set('text_'.$i,${"text_".$i});
     }

     $count = $maisu*9;
     for($k=1; $k<=$count; $k++){

       for($j=1; $j<=8; $j++){
         ${"result_size_".$j."_".$k} = $data['result_size_'.$j."_".$k];
         $this->set('result_size_'.$j."_".$k,${"result_size_".$j."_".$k});
       }

     }

       for($j=1; $j<=8; $j++){
         ${"situation_dist1_".$j} = $data['situation_dist1_'.$j];
         $this->set('situation_dist1_'.$j,${"situation_dist1_".$j});
         ${"situation_dist2_".$j} = $data['situation_dist2_'.$j];
         $this->set('situation_dist2_'.$j,${"situation_dist2_".$j});
         ${"result_weight_".$j} = $data['result_weight_'.$j];
         $this->set('result_weight_'.$j,${"result_weight_".$j});
       }

     for($i=1; $i<=27; $i++){
       ${"ImKikakuid_".$i} = "ノギス";
       $this->set('ImKikakuid_'.$i,${"ImKikakuid_".$i});
     }

     $ImKikakus = $this->ImKikakuTaious->find()
     ->where(['product_code' => $product_code ,'status' => '0'])->order(["version"=>"desc"])->toArray();
     foreach ((array)$ImKikakus as $key => $value) {
          $sort[$key] = $value['kensahyuo_num'];
      }
      if(isset($ImKikakus[0])){
       array_multisort($sort, SORT_ASC, $ImKikakus);
     }

     for($i=0; $i<count($ImKikakus); $i++){
       $j = $i + 1;
     if(isset($ImKikakus[$i])) {
       $kensahyuo_num = $ImKikakus[$i]["kensahyuo_num"];

         if($ImKikakus[$i]['kind_kensa'] != "") {
           ${"ImKikakuid_".$kensahyuo_num} = $ImKikakus[$i]['kind_kensa'];
           $this->set('ImKikakuid_'.$kensahyuo_num,${"ImKikakuid_".$kensahyuo_num});//セット
         }

       }
     }

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

    	$kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    	$KensahyouHead = $this->KensahyouHeads->find()
      ->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット
    	$Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      for($j=1; $j<=8; $j++){
        ${"result_weight_".$j} = $_SESSION['sokuteidata'.$this->Auth->user('username')][$j]['result_weight'];
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

    	if ($this->request->is('get')) {
    		$kensahyouSokuteidata = $this->KensahyouSokuteidatas->patchEntities($kensahyouSokuteidata, $tourokudata);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
    		$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
    		$connection->begin();//トランザクション3
    		try {//トランザクション4
    				if ($this->KensahyouSokuteidatas->saveMany($kensahyouSokuteidata)) {//saveManyで一括登録

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('kensahyou_sokuteidata_result');
              $table->setConnection($connection);

              $kensahyou_sokuteidata_head_id = $tourokudata[1]["product_code"]."-".$tourokudata[1]["lot_num"];

              $connection->insert('kensahyou_sokuteidata_head', [
                'kensahyou_sokuteidata_head_id' => $kensahyou_sokuteidata_head_id,
                'product_id' => $tourokudata[1]["product_code"],
                'manu_date' => $tourokudata[1]["manu_date"],
                'inspec_date' => $tourokudata[1]["inspec_date"],
                'lot_num' => $tourokudata[1]["lot_num"],
                'emp_id' => $tourokudata[1]["created_staff"],
                'timestamp' => date('Y-m-d H:i:s')
              ]);

              for($k=1; $k<=count($tourokudata); $k++){

                for($i=1; $i<=9; $i++){
                  if(empty($tourokudata[$k]["result_size_".$i])){
                    $tourokudata[$k]["result_size_".$i] = null;
                  }
              	}

                if(empty($tourokudata[$k]["result_weight"])){
                  $tourokudata[$k]["result_weight"] = null;
                }

                $kensahyou_sokuteidata_head_id = $tourokudata[$k]["product_code"]."-".$tourokudata[$k]["lot_num"];

                $connection->insert('kensahyou_sokuteidata_result', [
                  'kensahyou_sokuteidata_result_id' => $kensahyou_sokuteidata_head_id,
                  'cavi_num' => $tourokudata[$k]["cavi_num"],
                  'product_id' => $tourokudata[$k]["product_code"],
                  'result_size_a' => $tourokudata[$k]["result_size_1"],
                  'result_size_b' => $tourokudata[$k]["result_size_2"],
                  'result_size_c' => $tourokudata[$k]["result_size_3"],
                  'result_size_d' => $tourokudata[$k]["result_size_4"],
                  'result_size_e' => $tourokudata[$k]["result_size_5"],
                  'result_size_f' => $tourokudata[$k]["result_size_6"],
                  'result_size_g' => $tourokudata[$k]["result_size_7"],
                  'result_size_h' => $tourokudata[$k]["result_size_8"],
                  'result_size_i' => $tourokudata[$k]["result_size_9"],
                  'result_text_j' => $tourokudata[$k]["situation_dist1"],
                  'result_text_k' => $tourokudata[$k]["situation_dist2"],
                  'result_weight' => $tourokudata[$k]["result_weight"]
              //    'situation_dist' => ""
                ]);

              }


              if($kousin_id != "aaa" && strpos($kousin_id,'_') !== false){
                $sch_id = explode("_",$kousin_id);

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

              }elseif($kousin_id != "aaa" && strpos($kousin_id,'=') !== false){
                  $kari_id = explode("=",$kousin_id);

                  $this->KariKadouSeikeis->updateAll(
                  ['present_kensahyou' => 1],
                  ['id'   => $kari_id[1]]
                  );

                  $KariKadouSeikeisData = $this->KariKadouSeikeis->find()->where(['id' => $kari_id[1]])->toArray();

                  $KariKadouSeikeistarting_tm = $KariKadouSeikeisData[0]->starting_tm->format('Y-m-d H:i:s');
                  $KariKadouSeikeifinishing_tm = $KariKadouSeikeisData[0]->finishing_tm->format('Y-m-d H:i:s');
                  $KariKadouSeikeicreated_at = $KariKadouSeikeisData[0]->created_at->format('Y-m-d H:i:s');
                  $KariKadouSeikeiseikeiki_code = $KariKadouSeikeisData[0]->seikeiki_code;
                  $KariKadouSeikeiproduct_code = $KariKadouSeikeisData[0]->product_code;

                  $connection = ConnectionManager::get('DB_ikou_test');
                  $table = TableRegistry::get('kari_kadou_seikei');
                  $table->setConnection($connection);

                  $num = 1;
                  $updater = "UPDATE kari_kadou_seikei set present_kensahyou ='".$num."'
                   where product_id ='".$KariKadouSeikeiproduct_code."' and seikeiki_id ='".$KariKadouSeikeiseikeiki_code."' and starting_tm ='".$KariKadouSeikeistarting_tm."'";
                   $connection->execute($updater);

                  $connection = ConnectionManager::get('default');//新DBに戻る
                  $table->setConnection($connection);

                }elseif($kousin_id != "aaa"){

                  $KadouSeikeiData = $this->KadouSeikeis->find()->where(['id' => $kousin_id])->toArray();
                  $KadouSeikeistarting_tm = $KadouSeikeiData[0]->starting_tm->format('Y-m-d H:i:s');
                  $KadouSeikeifinishing_tm = $KadouSeikeiData[0]->finishing_tm->format('Y-m-d H:i:s');
                  $KadouSeikeicreated_at = $KadouSeikeiData[0]->created_at->format('Y-m-d H:i:s');
                  $KadouSeikeiseikeiki_code = $KadouSeikeiData[0]->seikeiki_code;
                  $KadouSeikeiproduct_code = $KadouSeikeiData[0]->product_code;

                  $this->KadouSeikeis->updateAll(
                  ['present_kensahyou' => 1 ,'starting_tm' => $KadouSeikeistarting_tm ,'finishing_tm' => $KadouSeikeifinishing_tm ,'created_at' => $KadouSeikeicreated_at ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
                  ['id' => $kousin_id]
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
