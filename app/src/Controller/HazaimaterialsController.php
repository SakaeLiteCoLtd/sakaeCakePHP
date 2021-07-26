<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\hazaiploglam\htmlhazaicheck;

use Cake\Routing\Router;//urlの取得
use Cake\Http\Client;//httpの読取に必要

use App\myClass\Rolecheck\htmlRolecheck;

class HazaimaterialsController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->loadComponent('RequestHandler');
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->Products = TableRegistry::get('products');
   $this->PriceMaterials = TableRegistry::get('priceMaterials');
   $this->StockEndMaterials = TableRegistry::get('stockEndMaterials');
   $this->StatusRoles = TableRegistry::get('statusRoles');
  }

   public function menu()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $StockEndMaterials = $this->StockEndMaterials->find()//CSV未出力データ
     ->where(['status_import_tab' => 0, 'delete_flag' => 0])->toArray();

     $arrStockEndMaterials = array();//空の配列を作る
     for($k=0; $k<count($StockEndMaterials); $k++){

       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['id' => $StockEndMaterials[$k]["price_material_id"]])->toArray();
       $grade = $PriceMaterials[0]["grade"];
       $color = $PriceMaterials[0]["color"];

       if($StockEndMaterials[$k]["status_material"] == 0){
         $status_material = "バージン";
       }elseif($StockEndMaterials[$k]["status_material"] == 1){
         $status_material = "粉砕";
       }else{
         $status_material = "バージン＋粉砕";
       }

       $Staffs = $this->Staffs->find()
       ->where(['id' => $StockEndMaterials[$k]["created_staff"]])->toArray();
       $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];

       $arrStockEndMaterials[] = [
         'hazai' => $grade."_".$color,
         'lot_num' => $StockEndMaterials[$k]["lot_num"],
         'status_material' => $status_material,
         'amount' => $StockEndMaterials[$k]["amount"],
         'created_at' => $StockEndMaterials[$k]["created_at"]->format('Y-n-j'),
         'staff_name' => $staff_name,
       ];

     }
     $this->set('arrStockEndMaterials',$arrStockEndMaterials);

     $tabStockEndMaterials = $this->StockEndMaterials->find()//TABファイル未取込データ
     ->where(['status_import_tab' => 1, 'import_tab_staff IS' => NULL, 'delete_flag' => 0])->toArray();

     $arrtabStockEndMaterials = array();//空の配列を作る
     for($k=0; $k<count($tabStockEndMaterials); $k++){

       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['id' => $tabStockEndMaterials[$k]["price_material_id"]])->toArray();
       $grade = $PriceMaterials[0]["grade"];
       $color = $PriceMaterials[0]["color"];

       if($tabStockEndMaterials[$k]["status_material"] == 0){
         $status_material = "バージン";
       }elseif($tabStockEndMaterials[$k]["status_material"] == 1){
         $status_material = "粉砕";
       }else{
         $status_material = "バージン＋粉砕";
       }

       $Staffs = $this->Staffs->find()
       ->where(['id' => $tabStockEndMaterials[$k]["created_staff"]])->toArray();
       $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];

       $arrtabStockEndMaterials[] = [
         'hazai' => $grade."_".$color,
         'lot_num' => $tabStockEndMaterials[$k]["lot_num"],
         'status_material' => $status_material,
         'amount' => $tabStockEndMaterials[$k]["amount"],
         'created_at' => $tabStockEndMaterials[$k]["created_at"]->format('Y-n-j'),
         'staff_name' => $staff_name,
       ];

     }
     $this->set('arrtabStockEndMaterials',$arrtabStockEndMaterials);

     $shippedStockEndMaterials = $this->StockEndMaterials->find()//出荷待ちデータ
     ->where(['status_import_tab' => 1, 'import_tab_staff >=' => 0, 'shiped_staff IS' => NULL, 'delete_flag' => 0])->toArray();

     $arrshippedStockEndMaterials = array();//空の配列を作る
     for($k=0; $k<count($shippedStockEndMaterials); $k++){

       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['id' => $shippedStockEndMaterials[$k]["price_material_id"]])->toArray();
       $grade = $PriceMaterials[0]["grade"];
       $color = $PriceMaterials[0]["color"];

       if($shippedStockEndMaterials[$k]["status_material"] == 0){
         $status_material = "バージン";
       }elseif($shippedStockEndMaterials[$k]["status_material"] == 1){
         $status_material = "粉砕";
       }else{
         $status_material = "バージン＋粉砕";
       }

       $Staffs = $this->Staffs->find()
       ->where(['id' => $shippedStockEndMaterials[$k]["created_staff"]])->toArray();
       $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];

       $arrshippedStockEndMaterials[] = [
         'hazai' => $grade."_".$color,
         'lot_num' => $shippedStockEndMaterials[$k]["lot_num"],
         'status_material' => $status_material,
         'amount' => $shippedStockEndMaterials[$k]["amount"],
         'created_at' => $shippedStockEndMaterials[$k]["created_at"]->format('Y-n-j'),
         'staff_name' => $staff_name,
       ];

     }
     $this->set('arrshippedStockEndMaterials',$arrshippedStockEndMaterials);

   }

   public function materialmenu()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);
   }

   public function materiallogin()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $Data=$this->request->query('s');
     if(isset($Data["mess"])){
       $mess = $Data["mess"];
       $this->set('mess',$mess);
     }else{
       $mess = "";
       $this->set('mess',$mess);
     }
   }

   public function materialform()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $Data=$this->request->query('s');
     if(isset($Data["mess"])){
       $username = $Data["username"];
       $mess = $Data["mess"];
       $this->set('mess',$mess);
     }else{
       $data = $this->request->getData();
       $mess = "";
       $this->set('mess',$mess);
     }

     if(isset($data["username"])){//登録者の確認

       $ary = explode(',', $data["username"]);
       $username = $ary[0];

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();

       if(!isset($Users[0])){

         return $this->redirect(['action' => 'materiallogin',
         's' => ['mess' => "社員コードが間違っています。もう一度やり直してください。"]]);

       }

     }
     $this->set('username', $username);

     $Users = $this->Users->find()
     ->where(['username' => $username])->toArray();

     $Staffs = $this->Staffs->find()
     ->where(['id' => $Users[0]["staff_id"]])->toArray();
     $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];
     $this->set('staff_name', $staff_name);

     $Product_list = $this->Products->find()
     ->where(['delete_flag' => 0])->toArray();
     $arrProduct_list = array();
     for($j=0; $j<count($Product_list); $j++){
       array_push($arrProduct_list,$Product_list[$j]["product_code"]);
     }
     $arrProduct_list = array_unique($arrProduct_list);
     $arrProduct_list = array_values($arrProduct_list);
     $this->set('arrProduct_list', $arrProduct_list);

     $Material_list = $this->PriceMaterials->find()
     ->where(['delete_flag' => 0])->toArray();
     $arrMaterial_list = array();
     for($j=0; $j<count($Material_list); $j++){
       array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);
     }
     $arrMaterial_list = array_unique($arrMaterial_list);
     $arrMaterial_list = array_values($arrMaterial_list);
     $this->set('arrMaterial_list', $arrMaterial_list);

     $arrStatusMaterial = [
       '0' => 'バージン',
       '1' => '粉砕',
       '2' => 'バージン＋粉砕'
     ];
     $this->set('arrStatusMaterial',$arrStatusMaterial);

     if(!isset($_SESSION)){
       session_start();
       header('Expires:-1');
       header('Cache-Control:');
       header('Pragma:');
     }

   }

   public function materialconfirm()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $data = $this->request->getData();

     $username = $data["username"];
     $this->set('username', $username);
     $staff_name = $data["staff_name"];
     $this->set('staff_name', $staff_name);
     $product_code = $data["product_code"];
     $this->set('product_code', $product_code);
     $materialgrade_color = $data["materialgrade_color"];
     $this->set('materialgrade_color', $materialgrade_color);

     $price_material_id = "";
     $this->set('price_material_id', $price_material_id);

     $mess = "";
     $this->set('mess', $mess);

     $check_product = 1;
     $this->set('check_product', $check_product);

     if(strlen($product_code) > 0 && strlen($materialgrade_color) > 0){//品番と原料の両方入力されているとき

       //$product_codeを送って配列を返してもらう
      $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
      $arrhazaicheckproduct = $htmlhazaicheck->productcheck($product_code);

      if($arrhazaicheckproduct["productcheck"] == 0){

        $this->set('price_material_id', $arrhazaicheckproduct["price_material_id"]);
        $this->set('materialgrade_color', $arrhazaicheckproduct["materialgrade_color"]);

      }elseif($arrhazaicheckproduct["productcheck"] == 1){

        return $this->redirect(['action' => 'materialform',
        's' => ['username' => $username, 'mess' => "品番：「".$product_code."」の製品は製品登録されていません。"]]);

      }else{

        $Products = $this->Products->find()
        ->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();

        return $this->redirect(['action' => 'materialform',
        's' => ['username' => $username, 'mess' => "品番：「".$product_code."」の原料：「".$Products[0]["m_grade"]."」、色：「".$Products[0]["col_num"]."」は原料登録されていません。"]]);

      }

      //$grade_colorを送って配列を返してもらう
      $grade_color = explode('_', $data["materialgrade_color"]);

      $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
      $arrhazaicheckmaterial = $htmlhazaicheck->materialcheck($grade_color);

      if($arrhazaicheckmaterial["materialcheck"] == 0){//okのとき

        $this->set('price_material_id', $arrhazaicheckmaterial["price_material_id"]);
        $this->set('materialgrade_color', $data["materialgrade_color"]);

      }elseif($arrhazaicheckmaterial["materialcheck"] == 1){//PriceMaterialsになかった時

        return $this->redirect(['action' => 'materialform',
        's' => ['username' => $username, 'mess' => "「原料グレード_色」:「".$data["materialgrade_color"]."」の原料は原料登録されていません。"]]);

      }else{//入力されてないとき

        return $this->redirect(['action' => 'materialform',
        's' => ['username' => $username, 'mess' => "グレードと色を「_」（アンダーバー）でつないで入力してください。"]]);

      }

       $mess = "※「品番」と「原料グレード_色」が両方入力されました。製品に対応する「原料グレード_色」を自動で呼び出しています。";
       $this->set('mess', $mess);

     }elseif(strlen($product_code) > 0){//品番だけ入力されているとき

       //$product_codeを送って配列を返してもらう
       $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
       $arrhazaicheckproduct = $htmlhazaicheck->productcheck($product_code);

       if($arrhazaicheckproduct["productcheck"] == 0){

         $this->set('price_material_id', $arrhazaicheckproduct["price_material_id"]);
         $this->set('materialgrade_color', $arrhazaicheckproduct["materialgrade_color"]);

       }elseif($arrhazaicheckproduct["productcheck"] == 1){

         return $this->redirect(['action' => 'materialform',
         's' => ['username' => $username, 'mess' => "品番：「".$product_code."」の製品は製品登録されていません。"]]);

       }else{

         $Products = $this->Products->find()
         ->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();

         return $this->redirect(['action' => 'materialform',
         's' => ['username' => $username, 'mess' => "品番：「".$product_code."」の原料：「".$Products[0]["m_grade"]."」、色：「".$Products[0]["col_num"]."」は原料登録されていません。"]]);

       }

       $mess = "※製品に対応する「原料グレード_色」を自動で呼び出しています。";
       $this->set('mess', $mess);

     }elseif(strlen($materialgrade_color) > 0){//原料だけ入力されているとき

       $check_product = 0;
       $this->set('check_product', $check_product);

       //$grade_colorを送って配列を返してもらう
       $grade_color = explode('_', $data["materialgrade_color"]);

       $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
       $arrhazaicheckmaterial = $htmlhazaicheck->materialcheck($grade_color);

       if($arrhazaicheckmaterial["materialcheck"] == 0){//okのとき

         $this->set('price_material_id', $arrhazaicheckmaterial["price_material_id"]);
         $this->set('materialgrade_color', $data["materialgrade_color"]);

       }elseif($arrhazaicheckmaterial["materialcheck"] == 1){//PriceMaterialsになかった時

         return $this->redirect(['action' => 'materialform',
         's' => ['username' => $username, 'mess' => "「原料グレード_色」:「".$data["materialgrade_color"]."」の原料は原料登録されていません。"]]);

       }else{//入力されてないとき

         return $this->redirect(['action' => 'materialform',
         's' => ['username' => $username, 'mess' => "グレードと色を「_」（アンダーバー）でつないで入力してください。"]]);

       }

     }else{//両方入力されていないとき

       return $this->redirect(['action' => 'materialform',
       's' => ['username' => $username, 'mess' => "「品番」と「原料グレード_色」がどちらも入力されていません。"]]);

     }

     $status_material = $data["status_material"];
     $this->set('status_material', $status_material);
     $amount = $data["amount"];

     $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
     $amount = $htmlhazaicheck->amountcheck($amount);
     $this->set('amount', $amount);

     if($status_material == 0){
       $hyouji_status_material = 'バージン';
     }elseif($status_material == 1){
       $hyouji_status_material = '粉砕';
     }else{
       $hyouji_status_material = 'バージン＋粉砕';
     }
     $this->set('hyouji_status_material', $hyouji_status_material);

     if(!isset($_SESSION)){
       session_start();
       header('Expires:-1');
       header('Cache-Control:');
       header('Pragma:');
     }

   }

   public function materialdo()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $data = $this->request->getData();
     $username = $data["username"];
     $this->set('username', $username);
     $staff_name = $data["staff_name"];
     $this->set('staff_name', $staff_name);
     $materialgrade_color = $data["materialgrade_color"];
     $this->set('materialgrade_color', $materialgrade_color);
     $product_code = $data["product_code"];
     $this->set('product_code', $product_code);
     $price_material_id = $data["price_material_id"];
     $this->set('price_material_id', $price_material_id);
     $status_material = $data["status_material"];
     $this->set('status_material', $status_material);
     $amount = $data["amount"];
     $this->set('amount', $amount);
     $check_product = $data["check_product"];
     $this->set('check_product', $check_product);
     $hyouji_status_material = $data["hyouji_status_material"];
     $this->set('hyouji_status_material', $hyouji_status_material);

     $Users = $this->Users->find()
     ->where(['username' => $username])->toArray();

     $http = new Client();

     $postdata = array();//空の配列を作る

     if($check_product == 1){//product_codeの入力がある時

       $postdata = [
         'product_code' => $product_code,
         'price_material_id' => $price_material_id,
         'status_material' => $status_material,
         'amount' => $amount,
         'staff_id' => $Users[0]["staff_id"],
       ];

     }else{//product_codeの入力がない時

       $postdata = [
         'price_material_id' => $price_material_id,
         'status_material' => $status_material,
         'amount' => $amount,
         'staff_id' => $Users[0]["staff_id"],
       ];

     }

     $response = $http->post('http://192.168.4.246/Hazaimaterials/hazaitourokuapi/api.json', [//post,put,get
       'postdata' => $postdata,
       ['type' => 'json']
     ]);
/*
     echo "<pre>";
     print_r($postdata);
     echo "</pre>";
*/
   }

                                   //https://192.168.4.246/Hazaimaterials/hazaitourokuapi/api.json
   public function hazaitourokuapi($id)//http://localhost:5000/Hazaimaterials/hazaitourokuapi/3.json
   {
     if($this->request->is(['post'])) {//登録postの時

       $postdata = $this->request->getData();
       $arr = $postdata["postdata"];

       $arrTourokuStockEndMaterials = array();//空の配列を作る

       if(!isset($arr["product_code"])){

         $arrTourokuStockEndMaterials = [
           'price_material_id' => $arr["price_material_id"],
           'status_material' => $arr["status_material"],
           'amount' => $arr["amount"],
           'state' => 0,
           'status_import_tab' => 0,
           'delete_flag' => 0,
           'created_at' => date('Y-m-d H:i:s'),
           'created_staff' => $arr["staff_id"],
         ];

         $lotdate = date('y').date('m').date('d');
         $countStockEndMaterials = $this->StockEndMaterials->find()
         ->where(['price_material_id' => $arrTourokuStockEndMaterials["price_material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
         $countLot = count($countStockEndMaterials) + 1;
         $lot_num = $lotdate."-".sprintf('%03d', $countLot);

         $arrTourokuStockEndMaterials = array_merge($arrTourokuStockEndMaterials,array('lot_num' => $lot_num));

         $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $arrTourokuStockEndMaterials);
         if ($this->StockEndMaterials->save($StockEndMaterials)) {
             $message = 'Saved';
         } else {
             $message = 'Error';
         }

       }elseif(isset($arr["product_code"])){

         $arrTourokuStockEndMaterials = [
           'product_code' => $arr["product_code"],
           'price_material_id' => $arr["price_material_id"],
           'status_material' => $arr["status_material"],
           'amount' => $arr["amount"],
           'state' => 0,
           'status_import_tab' => 0,
           'delete_flag' => 0,
           'created_at' => date('Y-m-d H:i:s'),
           'created_staff' => $arr["staff_id"],
         ];

         $lotdate = date('y').date('m').date('d');
         $countStockEndMaterials = $this->StockEndMaterials->find()
         ->where(['product_code' => $arrTourokuStockEndMaterials["product_code"], 'lot_num like' => $lotdate.'%'])->toArray();
         $countLot = count($countStockEndMaterials) + 1;
         $lot_num = $lotdate."-".sprintf('%03d', $countLot);

         $arrTourokuStockEndMaterials = array_merge($arrTourokuStockEndMaterials,array('lot_num' => $lot_num));

         $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $arrTourokuStockEndMaterials);
         if ($this->StockEndMaterials->save($StockEndMaterials)) {
             $message = 'Saved';
         } else {
             $message = 'Error';
         }

       }

       $this->viewBuilder()->className('Json');
       $this->set([
           'message' => $message,
           'StockEndMaterials' => $StockEndMaterials,
           '_serialize' => ['message', 'StockEndMaterials']
       ]);

     }elseif($this->request->is(['put'])){//更新・削除putの時

       $mess = "method = put ; id = ".$id;
       $this->set([
         'mess' => "api_test_hirokawa... ".$mess,
         '_serialize' => ['mess']
       ]);

     }elseif($this->request->is(['get'])){//取得・一覧getの時

       $mess = "method = get ; id = ".$id;
       $arr = $this->request->getData();

       $this->set([
         'mess' => "api_test_hirokawa... ".$mess,
         'arr' => $arr,
         '_serialize' => ['mess', 'arr']
       ]);

     }else{

       $mess = "エラー（post,put,getではありません。）";
       $this->set([
         'mess' => "api_test_hirokawa... ".$mess,
         '_serialize' => ['mess']
       ]);

     }

   }

   public function csvlogin()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $Data=$this->request->query('s');
     if(isset($Data["mess"])){
       $mess = $Data["mess"];
       $this->set('mess',$mess);
     }else{
       $mess = "";
       $this->set('mess',$mess);
     }
   }

   public function csvichiran()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $data = $this->request->getData();

     if(isset($data["username"])){//登録者の確認

       $ary = explode(',', $data["username"]);
       $username = $ary[0];

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();

       if(!isset($Users[0])){

         return $this->redirect(['action' => 'csvlogin',
         's' => ['mess' => "社員コードが間違っています。もう一度やり直してください。"]]);

       }

     }
     $this->set('username',$username);

     if(isset($data["alldel"])){
       $chesk_flag = 0;
     }else{
       $chesk_flag = 1;
     }
     $this->set('chesk_flag',$chesk_flag);

     if(isset($data["kakuninn"])){

       if(!isset($_SESSION)){
         session_start();
         header('Expires:-1');
         header('Cache-Control:');
         header('Pragma:');
       }

       $_SESSION['hazaicsvdatas'] = array();
       $_SESSION['hazaicsvdata'] = $data;

       return $this->redirect(['action' => 'csvconfirm']);

     }

     $StockEndMaterials = $this->StockEndMaterials->find()
     ->where(['status_import_tab' => 0, 'delete_flag' => 0])->toArray();

     $arrStockEndMaterials = array();//空の配列を作る
     for($k=0; $k<count($StockEndMaterials); $k++){

       if($StockEndMaterials[$k]["price_material_id"] > 0){

         $PriceMaterials = $this->PriceMaterials->find()
         ->where(['id' => $StockEndMaterials[$k]["price_material_id"]])->toArray();
         $grade = $PriceMaterials[0]["grade"];
         $color = $PriceMaterials[0]["color"];
         $hazai = $grade."_".$color;

       }elseif(strlen($StockEndMaterials[$k]["product_code"]) > 0){

         $hazai = $StockEndMaterials[$k]["product_code"];

       }

       if($StockEndMaterials[$k]["status_material"] == 0){
         $status_material = "バージン";
       }elseif($StockEndMaterials[$k]["status_material"] == 1){
         $status_material = "粉砕";
       }else{
         $status_material = "バージン＋粉砕";
       }

       $Staffs = $this->Staffs->find()
       ->where(['id' => $StockEndMaterials[$k]["created_staff"]])->toArray();
       $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];

       $arrStockEndMaterials[] = [
         'hazai' => $hazai,
         'status_material' => $status_material,
         'lot_num' => $StockEndMaterials[$k]["lot_num"],
         'amount' => $StockEndMaterials[$k]["amount"],
         'created_at' => $StockEndMaterials[$k]["created_at"]->format('Y-n-j'),
         'staff_name' => $staff_name,
       ];

     }
     $this->set('arrStockEndMaterials',$arrStockEndMaterials);

   }

   public function csvconfirm()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $session = $this->request->getSession();
     $_SESSION = $session->read();

     $data = $_SESSION['hazaicsvdata'];

     $username = $data["username"];
     $this->set('username',$username);

     $Users = $this->Users->find()
     ->where(['username' => $data["username"]])->toArray();
     $staff_id = $Users[0]["staff_id"];
     $this->set('staff_id',$staff_id);

     $StockEndMaterials = $this->StockEndMaterials->find()
     ->where(['status_import_tab' => 0, 'delete_flag' => 0])->toArray();
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
     $csvStockEndMaterials = array();//空の配列を作る
     for($k=0; $k<=$data["nummax"]; $k++){
       if(isset($data["check".$k])){//checkがついているもの

         $PriceMaterials = $this->PriceMaterials->find()
         ->where(['id' => $StockEndMaterials[$k]["price_material_id"]])->toArray();
         $grade = $PriceMaterials[0]["grade"];
         $color = $PriceMaterials[0]["color"];
         $hazai = $grade."_".$color;

         if(strlen($StockEndMaterials[$k]["product_code"]) > 0){
           $product_code = $StockEndMaterials[$k]["product_code"];
         }else{
           $product_code = "";
         }

         if($StockEndMaterials[$k]["status_material"] == 0){
           $status_material = "バージン";
         }elseif($StockEndMaterials[$k]["status_material"] == 1){
           $status_material = "粉砕";
         }else{
           $status_material = "バージン＋粉砕";
         }

         $Staffs = $this->Staffs->find()
         ->where(['id' => $StockEndMaterials[$k]["created_staff"]])->toArray();
         $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];

         $csvStockEndMaterials[] = [
           'product_code' => $product_code,
           'hazai' => $hazai,
           'status_material' => $status_material,
           'lot_num' => $StockEndMaterials[$k]["lot_num"],
           'amount' => $StockEndMaterials[$k]["amount"],
           'lot_num' => $StockEndMaterials[$k]["lot_num"],
           'created_at' => $StockEndMaterials[$k]["created_at"]->format('Y-n-j'),
           'staff_name' => $staff_name,
         ];

       }

     }
     $this->set('csvStockEndMaterials',$csvStockEndMaterials);

     if(!isset($_SESSION)){
       session_start();
       header('Expires:-1');
       header('Cache-Control:');
       header('Pragma:');
     }

     $_SESSION['hazaicsvdatasdo'] = array();
     $_SESSION['hazaicsvdatasdo'] = $csvStockEndMaterials;
     $_SESSION['hazaicsvstaffdo'] = array();
     $_SESSION['hazaicsvstaffdo'] = $staff_id;
/*
     echo "<pre>";
     print_r($csvStockEndMaterials);
     echo "</pre>";
*/
   }

   public function csvdo()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $session = $this->request->getSession();
     $_SESSION = $session->read();

     $csvStockEndMaterials = $_SESSION['hazaicsvdatasdo'];
     $staff_id = $_SESSION['hazaicsvstaffdo'];

     $this->set('csvStockEndMaterials',$csvStockEndMaterials);

     $arrCsvs = array();//空の配列を作る
     for($k=0; $k<count($csvStockEndMaterials); $k++){
/*
       echo "<pre>";
       print_r($csvStockEndMaterials[$k]['status_material']);
       echo "</pre>";
*/
       if($csvStockEndMaterials[$k]['status_material'] == "バージン"){
         $status_material = "バ";
       }elseif($csvStockEndMaterials[$k]['status_material'] == "粉砕"){
         $status_material = "粉";
       }else{
         $status_material = "バ＋粉";
       }

       $lot_num = mb_substr($csvStockEndMaterials[$k]['lot_num'], 0, 6);
       $lot_renban = (int)mb_substr($csvStockEndMaterials[$k]['lot_num'], 8, 3);

       if(strlen($csvStockEndMaterials[$k]["product_code"]) < 1){//grade_colorの場合
         $hazai = $csvStockEndMaterials[$k]['hazai'];

         $arrCsvs[] = ['maisu' => 1, 'layout' => "B", 'lotnum' => $lot_num,
          'renban' => $lot_renban, 'place1' => "", 'place2' => "",
          'product_code' => $hazai, 'product_code2' => "", 'product_name' => $status_material,
          'product_name2' => "", 'irisu' => $csvStockEndMaterials[$k]['amount'], 'irisu2' => "", 'unit' => "", 'unit2' => "", 'line_code1' => ""];

       }else{//製品の場合

         $hazai = $csvStockEndMaterials[$k]['hazai'];

         $arrCsvs[] = ['maisu' => 1, 'layout' => "B", 'lotnum' => $lot_num,
          'renban' => $lot_renban, 'place1' => $csvStockEndMaterials[$k]["product_code"], 'place2' => "",
          'product_code' => $hazai, 'product_code2' => "", 'product_name' => $status_material,
          'product_name2' => "", 'irisu' => $csvStockEndMaterials[$k]['amount'], 'irisu2' => "", 'unit' => "", 'unit2' => "", 'line_code1' => ""];

       }

     }

       $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $csvStockEndMaterials);
       $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4

          for($k=0; $k<count($csvStockEndMaterials); $k++){

            $arrhazai = explode('_', $csvStockEndMaterials[$k]['hazai']);
            if(isset($arrhazai[1])){//grade_colorの場合

              $grade = $arrhazai[0];
              $color = $arrhazai[1];

              $PriceMaterials = $this->PriceMaterials->find()
              ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();
              $price_material_id = $PriceMaterials[0]["id"];

              if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
                ['status_import_tab' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
                ['price_material_id'  => $price_material_id, 'lot_num' => $csvStockEndMaterials[$k]['lot_num']]
              )){

                if($k == count($csvStockEndMaterials) - 1){//最後のデータが登録されたときにCSVを出力
  //                $fp = fopen('hazai/hazai.csv', 'w');//local
                  $fp = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'w');//192

                  foreach ($arrCsvs as $line) {
                    $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
                   fputcsv($fp, $line);
                  }
                  fclose($fp);

                  $mes = "192.168.4.246\home\centosuser\hazai_csv にＣＳＶファイルが出力されました。";
                  $this->set('mes',$mes);
                  $connection->commit();// コミット5
                }

              } else {

                $mes = "※登録されませんでした";
                $this->set('mes',$mes);
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

              }

            }else{//製品の場合

              $Products = $this->Products->find()
              ->where(['product_code' => $csvStockEndMaterials[$k]["hazai"], 'delete_flag' => 0])->toArray();
              $product_code = $Products[0]["product_code"];

              if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
                ['status_import_tab' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
                ['product_code'  => $product_code, 'lot_num' => $csvStockEndMaterials[$k]['lot_num']]
              )){

                if($k == count($csvStockEndMaterials) - 1){//最後のデータが登録されたときにCSVを出力
  //                $fp = fopen('hazai/hazai.csv', 'w');//local
                  $fp = fopen('/home/centosuser/label_csv/label_hakkou.csv', 'w');//192

                  foreach ($arrCsvs as $line) {
                    $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
                   fputcsv($fp, $line);
                  }
                  fclose($fp);

                  $mes = "192.168.4.246\home\centosuser\hazai_csv にＣＳＶファイルが出力されました。";
                  $this->set('mes',$mes);
                  $connection->commit();// コミット5
                }

              } else {

                $mes = "※登録されませんでした";
                $this->set('mes',$mes);
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

              }

            }

          }

        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10

   }

   public function torikomilogin()//210720不使用ラベルメニューの取込を使用
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $Data=$this->request->query('s');
     if(isset($Data["mess"])){
       $mess = $Data["mess"];
       $this->set('mess',$mess);
     }else{
       $mess = "";
       $this->set('mess',$mess);
     }
   }

   public function torikomiselect()//210720不使用ラベルメニューの取込を使用
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $data = $this->request->getData();

     if(isset($data["username"])){

       $ary = explode(',', $data["username"]);
       $username = $ary[0];

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();

       if(!isset($Users[0])){

         return $this->redirect(['action' => 'torikomilogin',
         's' => ['mess' => "社員コードが間違っています。もう一度やり直してください。"]]);

       }

     }
     $this->set('username',$username);

    }

    public function torikomiselectdo()//210720不使用ラベルメニューの取込を使用
    {
      $stockEndMaterials = $this->StockEndMaterials->newEntity();
      $this->set('stockEndMaterials',$stockEndMaterials);

      $data = $this->request->getData();

      $username = $data["username"];
      $Users = $this->Users->find()
      ->where(['username' => $username])->toArray();
      $staff_id = $Users[0]["staff_id"];

      $source_file = $_FILES['file']['tmp_name'];

      $fp = fopen($source_file, "r");
      $fpcount = fopen($source_file, 'r' );
       for($count = 0; fgets( $fpcount ); $count++ );
       $arrFp = array();//空の配列を作る
       $arrLot = array();//空の配列を作る
       $arrLottouroku = array();//空の配列を作る

       for ($k=1; $k<=$count; $k++) {//最後の行まで

         $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
         $sample = explode("\t",$line);//$lineを"（スペース）"毎に配列に入れる
         $arrFp[] = $sample;//配列に追加する

         if(isset($arrFp[$k-1][4]) && isset($arrFp[$k-1][6])){
           //lot_nunmをふり直し
           for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//枚数分ループ
             $renban = $arrFp[$k-1][5] + $m;
             $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);

             $arrLot[] = ['lot_num' => $lot_num, 'hazai' => $arrFp[$k-1][6]];
           }

         }

       }

       for ($k=0; $k<count($arrLot); $k++){

         $arrhazai = explode('_', $arrLot[$k]['hazai']);

         if(isset($arrhazai[1])){//grade_colorの場合

           $grade = $arrhazai[0];
           $color = $arrhazai[1];

           $PriceMaterials = $this->PriceMaterials->find()
           ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

           $StockEndMaterials = $this->StockEndMaterials->find()
           ->where(["price_material_id" => $PriceMaterials[0]["id"], 'lot_num' => $arrLot[$k]["lot_num"], 'status_import_tab' => 1, 'delete_flag' => 0])->toArray();

         }else{//製品の場合

           $StockEndMaterials = $this->StockEndMaterials->find()
           ->where(["product_code" => $arrLot[$k]['hazai'], 'lot_num' => $arrLot[$k]["lot_num"], 'status_import_tab' => 1, 'delete_flag' => 0])->toArray();

         }

         if(isset($StockEndMaterials[0])){

           $arr_StockEndMaterials_id = array('StockEndMaterialsId' => $StockEndMaterials[0]["id"]);
           $arrLot[$k] = array_merge($arr_StockEndMaterials_id, $arrLot[$k]);
           $arrLottouroku[] = $arrLot[$k];

         }

       }
/*
       echo "<pre>";
       print_r($arrLottouroku);
       echo "</pre>";
*/
       $this->set('arrLottouroku',$arrLottouroku);
       if(count($arrLottouroku) < 1){
         $mes = "※登録される端材原料がありません。正しいファイルが選択されているか確認してください。";
         $this->set('mes',$mes);
       }

       $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $arrLottouroku);
       $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4

          for($k=0; $k<count($arrLottouroku); $k++){

            if ($this->StockEndMaterials->updateAll(
              ['import_tab_staff' => $staff_id, 'import_tab_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
              ['id'  => $arrLottouroku[$k]["StockEndMaterialsId"]]
            )){

              if($k == count($arrLottouroku) - 1){

                $mes = "※以下の端材原料が登録されました";
                $this->set('mes',$mes);
                $connection->commit();// コミット5

              }

            } else {

              $mes = "※登録されませんでした";
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

     public function kensakuform()//ロット検索
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $Material_list = $this->PriceMaterials->find()
       ->where(['delete_flag' => 0])->toArray();
       $arrMaterial_list = array();
       for($j=0; $j<count($Material_list); $j++){
         array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);
       }
       $arrMaterial_list = array_unique($arrMaterial_list);
       $arrMaterial_list = array_values($arrMaterial_list);
       $this->set('arrMaterial_list', $arrMaterial_list);

       $arrShipped = [
         '0' => '',
         '1' => '使用済',
         '2' => '未使用'
               ];
       $this->set('arrShipped',$arrShipped);

     }

     public function kensakuview()//ロット検索
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();

       $grade_color = explode('_', $data["materialgrade_color"]);

       $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
       $arrhazaicheckmaterial = $htmlhazaicheck->materialcheck($grade_color);

       if($arrhazaicheckmaterial["materialcheck"] == 0){//okのとき

         $price_material_id = $arrhazaicheckmaterial["price_material_id"];

       }else{//PriceMaterialsになかった時

         $price_material_id = "";

       }

       $lot_num = $data['lot_num'];
       $date_sta = $data['date_sta'];
       $date_fin = $data['date_fin'];

       $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
       $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

       $date_fin = strtotime($date_fin);
       $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       if($price_material_id > 0){

         if($data["shippedflag"] == 1){//出荷済み

           $StockEndMaterials = $this->StockEndMaterials->find()
             ->where(['delete_flag' => '0','import_tab_at >=' => $date_sta, 'import_tab_at <=' => $date_fin, 'shiped_staff >=' => 0,
              'lot_num like' => '%'.$lot_num.'%', 'price_material_id' => $price_material_id])->toArray();

         }elseif($data["shippedflag"] == 2){//出荷待ち

           $StockEndMaterials = $this->StockEndMaterials->find()
             ->where(['delete_flag' => '0','import_tab_at >=' => $date_sta, 'import_tab_at <=' => $date_fin, 'shiped_staff IS' => NULL,
              'lot_num like' => '%'.$lot_num.'%', 'price_material_id' => $price_material_id])->toArray();

         }else{//選択なし

           $StockEndMaterials = $this->StockEndMaterials->find()
             ->where(['delete_flag' => '0','import_tab_at >=' => $date_sta, 'import_tab_at <=' => $date_fin,
              'lot_num like' => '%'.$lot_num.'%', 'price_material_id' => $price_material_id])->toArray();

         }

       }else{

         if($data["shippedflag"] == 1){//出荷済み

           $StockEndMaterials = $this->StockEndMaterials->find()
             ->where(['delete_flag' => '0','import_tab_at >=' => $date_sta, 'import_tab_at <=' => $date_fin, 'shiped_staff >=' => 0,
              'lot_num like' => '%'.$lot_num.'%'])->toArray();

         }elseif($data["shippedflag"] == 2){//出荷待ち

           $StockEndMaterials = $this->StockEndMaterials->find()
             ->where(['delete_flag' => '0','import_tab_at >=' => $date_sta, 'import_tab_at <=' => $date_fin, 'shiped_staff IS' => NULL,
              'lot_num like' => '%'.$lot_num.'%'])->toArray();

         }else{//選択なし

           $StockEndMaterials = $this->StockEndMaterials->find()
             ->where(['delete_flag' => '0','import_tab_at >=' => $date_sta, 'import_tab_at <=' => $date_fin,
              'lot_num like' => '%'.$lot_num.'%'])->toArray();

         }

       }

         //並べかえ
         foreach($StockEndMaterials as $key => $row ) {
           $tmp_hazai_array[$key] = $row["hazai"];
           $tmp_lot_num_array[$key] = $row["lot_num"];
         }

         if(count($StockEndMaterials) > 0){
           array_multisort($tmp_hazai_array, $tmp_lot_num_array, SORT_ASC, SORT_NUMERIC, $StockEndMaterials);
         }

        $arrStockEndMaterials = array();//空の配列を作る
        for($k=0; $k<count($StockEndMaterials); $k++){

          $PriceMaterials = $this->PriceMaterials->find()
          ->where(['id' => $StockEndMaterials[$k]["price_material_id"]])->toArray();
          $grade = $PriceMaterials[0]["grade"];
          $color = $PriceMaterials[0]["color"];

          if($StockEndMaterials[$k]["status_material"] == 0){
            $status_material = "バージン";
          }elseif($StockEndMaterials[$k]["status_material"] == 1){
            $status_material = "粉砕";
          }else{
            $status_material = "バージン＋粉砕";
          }

          $Staffs = $this->Staffs->find()
          ->where(['id' => $StockEndMaterials[$k]["created_staff"]])->toArray();
          $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];

          $arrStockEndMaterials[] = [
            'hazai' => $grade."_".$color,
            'lot_num' => $StockEndMaterials[$k]["lot_num"],
            'status_material' => $status_material,
            'shiped_staff' => $StockEndMaterials[$k]["shiped_staff"],
            'amount' => $StockEndMaterials[$k]["amount"],
            'created_at' => $StockEndMaterials[$k]["created_at"]->format('Y-n-j'),
            'staff_name' => $staff_name,
          ];

        }
        $this->set('arrStockEndMaterials',$arrStockEndMaterials);

     }

     public function shippedlogin()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $Data=$this->request->query('s');
       if(isset($Data["mess"])){
         $mess = $Data["mess"];
         $this->set('mess',$mess);
       }else{
         $mess = "";
         $this->set('mess',$mess);
       }
     }

     public function shippedform()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();

       $Data=$this->request->query('s');
       if(isset($Data["mess"])){
         $username = $Data["username"];
         $mess = $Data["mess"];
         $this->set('mess',$mess);
       }else{
         $data = $this->request->getData();
         $mess = "";
         $this->set('mess',$mess);
       }

       if(isset($data["username"])){//登録者の確認

         $ary = explode(',', $data["username"]);
         $username = $ary[0];

         $Users = $this->Users->find()
         ->where(['username' => $username])->toArray();

         if(!isset($Users[0])){

           return $this->redirect(['action' => 'shippedlogin',
           's' => ['mess' => "社員コードが間違っています。もう一度やり直してください。"]]);

         }

       }
       $this->set('username', $username);

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();
       $Staffs = $this->Staffs->find()
       ->where(['id' => $Users[0]["staff_id"]])->toArray();
       $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];
       $this->set('staff_name', $staff_name);

       if(!isset($_SESSION)){
         session_start();
         header('Expires:-1');
         header('Cache-Control:');
         header('Pragma:');
       }

     }

     public function shippedconfirm()//210722不要いきなり登録へ
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();
       $username = $data["username"];
       $this->set('username',$username);
       $staff_name = $data["staff_name"];
       $this->set('staff_name',$staff_name);
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       $arrshippeddata = explode(',', $data['shippeddata']);
       $materialgrade_color = $arrshippeddata[0];

       if(isset($arrshippeddata[4])){

         $lot_num = $arrshippeddata[4];

       }else{

         return $this->redirect(['action' => 'shippedform',
         's' => ['username' => $username, 'mess' => "端材が読み込まれません。正しいラベルか確認してください。"]]);

       }

       $this->set('materialgrade_color',$materialgrade_color);
       $this->set('lot_num',$lot_num);

       $arrhazai = explode('_', $materialgrade_color);

       $grade = $arrhazai[0];

       if(isset($arrhazai[1])){
         $color = $arrhazai[1];
       }else{

         return $this->redirect(['action' => 'shippedform',
         's' => ['username' => $username, 'mess' => "端材が読み込まれません。正しいラベルか確認してください。"]]);

       }

       $check_stock_end = 0;

       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

       if(isset($PriceMaterials[0])){

         $StockEndMaterials = $this->StockEndMaterials->find()
         ->where(["price_material_id" => $PriceMaterials[0]['id'], 'lot_num' => $lot_num,
          'import_tab_staff >=' => 0, 'delete_flag' => 0])->toArray();

          if(isset($StockEndMaterials[0])){

            $check_stock_end = 1;
            $this->set('StockEndMaterialsId',$StockEndMaterials[0]["id"]);

          }

       }

       if($check_stock_end == 0){

         return $this->redirect(['action' => 'shippedform',
         's' => ['username' => $username, 'mess' => "読み込まれた端材原料はTAB取込されていません。"]]);

       }

       if(!isset($_SESSION)){
         session_start();
         header('Expires:-1');
         header('Cache-Control:');
         header('Pragma:');
       }

     }

     public function shippeddo()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();
       $username = $data["username"];
       $this->set('username',$username);
       $staff_name = $data["staff_name"];
       $this->set('staff_name',$staff_name);

       $arrshippeddata = explode(',', $data['shippeddata']);
       $materialgrade_color = $arrshippeddata[0];

       if(isset($arrshippeddata[4])){

         $lot_num = $arrshippeddata[4];

       }else{

         return $this->redirect(['action' => 'shippedform',
         's' => ['username' => $username, 'mess' => "端材が読み込まれません。正しいラベルか確認してください。"]]);

       }

       $this->set('materialgrade_color',$materialgrade_color);
       $this->set('lot_num',$lot_num);

       $arrhazai = explode('_', $materialgrade_color);

       $grade = $arrhazai[0];

       if(isset($arrhazai[1])){
         $color = $arrhazai[1];
       }else{

         return $this->redirect(['action' => 'shippedform',
         's' => ['username' => $username, 'mess' => "端材が読み込まれません。正しいラベルか確認してください。"]]);

       }

       $check_stock_end = 0;

       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

       if(isset($PriceMaterials[0])){

         $StockEndMaterials = $this->StockEndMaterials->find()
         ->where(["price_material_id" => $PriceMaterials[0]['id'], 'lot_num' => $lot_num,
          'import_tab_staff >=' => 0, 'delete_flag' => 0])->toArray();

          if(isset($StockEndMaterials[0])){

            $check_stock_end = 1;
            $StockEndMaterialsId = $StockEndMaterials[0]["id"];

          }

       }

       if($check_stock_end == 0){

         return $this->redirect(['action' => 'shippedform',
         's' => ['username' => $username, 'mess' => "読み込まれた端材原料はTAB取込されていません。"]]);

       }

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();
       $staff_id = $Users[0]["staff_id"];
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $data);
       $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
            ['shiped_staff' => $staff_id, 'shiped_at' => date('Y-m-d H:i:s'),
             'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
            ['id'  => $StockEndMaterialsId]
          )){

          $mes = "※登録されました";
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

     public function editlogin()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $Data=$this->request->query('s');
       if(isset($Data["mess"])){
         $mess = $Data["mess"];
         $this->set('mess',$mess);
       }else{
         $mess = "";
         $this->set('mess',$mess);
       }
     }

     public function editform()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();

       $Data=$this->request->query('s');
       if(isset($Data["mess"])){
         $username = $Data["username"];
         $mess = $Data["mess"];
         $this->set('mess',$mess);
       }else{
         $data = $this->request->getData();
         $mess = "";
         $this->set('mess',$mess);
       }

       if(isset($data["username"])){//登録者の確認

         $ary = explode(',', $data["username"]);
         $username = $ary[0];

         $Users = $this->Users->find()
         ->where(['username' => $username])->toArray();

         if(!isset($Users[0])){

           return $this->redirect(['action' => 'editlogin',
           's' => ['mess' => "社員コードが間違っています。もう一度やり直してください。"]]);

         }else{//管理者チェック

           $StatusRolesData = $this->StatusRoles->find()->where(['staff_id' => $Users[0]["staff_id"], 'role_id <=' => 3, 'delete_flag' => 0])->toArray();

           if(!isset($StatusRolesData[0])){

             return $this->redirect(['action' => 'editlogin',
             's' => ['mess' => "端材原料情報を修正する権限がありません。"]]);

           }

         }

       }
       $this->set('username', $username);

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();
       $Staffs = $this->Staffs->find()
       ->where(['id' => $Users[0]["staff_id"]])->toArray();
       $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];
       $this->set('staff_name', $staff_name);

       $Material_list = $this->PriceMaterials->find()
       ->where(['delete_flag' => 0])->toArray();
       $arrMaterial_list = array();
       for($j=0; $j<count($Material_list); $j++){
         array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);
       }
       $arrMaterial_list = array_unique($arrMaterial_list);
       $arrMaterial_list = array_values($arrMaterial_list);
       $this->set('arrMaterial_list', $arrMaterial_list);

       if(!isset($_SESSION)){
         session_start();
         header('Expires:-1');
         header('Cache-Control:');
         header('Pragma:');
       }

     }

     public function editformsyousai()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $Data=$this->request->query('s');
       if(isset($Data["mess"])){
         $username = $Data["username"];
         $mess = $Data["mess"];
         $this->set('mess',$mess);
       }else{
         $data = $this->request->getData();
         $mess = "";
         $this->set('mess',$mess);
       }

       $data = $this->request->getData();
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       $username = $data["username"];
       $this->set('username',$username);
       $staff_name = $data["staff_name"];
       $this->set('staff_name',$staff_name);

       $materialgrade_color = $data["materialgrade_color"];
       $this->set('materialgrade_color',$materialgrade_color);
       $lot_num = $data["lot_num"];
       $this->set('lot_num',$lot_num);

       $arrhazai = explode('_', $materialgrade_color);

       $grade = $arrhazai[0];

       if(isset($arrhazai[1])){
         $color = $arrhazai[1];
       }else{

         return $this->redirect(['action' => 'editform',
         's' => ['username' => $username, 'mess' => "グレードと色を「_」（アンダーバー）でつないで入力してください。"]]);

       }

       $check_stock_end = 0;

       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

       if(isset($PriceMaterials[0])){

         $StockEndMaterials = $this->StockEndMaterials->find()
         ->where(["price_material_id" => $PriceMaterials[0]['id'], 'lot_num' => $lot_num,
          'delete_flag' => 0])->toArray();

          if(isset($StockEndMaterials[0])){

            $check_stock_end = 1;
            $StockEndMaterialsId = $StockEndMaterials[0]["id"];
            $this->set('StockEndMaterialsId',$StockEndMaterialsId);
            $this->set('StockEndMaterialData',$StockEndMaterials[0]);

          }

       }

       if($check_stock_end == 0){

         return $this->redirect(['action' => 'editform',
         's' => ['username' => $username, 'mess' => "入力された端材原料は登録されていません。"]]);

       }

       if(strlen($StockEndMaterials[0]["shiped_staff"]) > 0){
         $shippedflag = 1;
       }else{
         $shippedflag = 0;
       }
       $this->set('shippedflag',$shippedflag);
/*
       echo "<pre>";
       print_r($shippedflag);
       echo "</pre>";
*/
       if(!isset($_SESSION)){
         session_start();
         header('Expires:-1');
         header('Cache-Control:');
         header('Pragma:');
       }

     }

     public function editconfirm()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       $username = $data["username"];
       $this->set('username',$username);
       $staff_name = $data["staff_name"];
       $this->set('staff_name',$staff_name);

       $product_code = $data["product_code"];
       $this->set('product_code',$product_code);
       $materialgrade_color = $data["materialgrade_color"];
       $this->set('materialgrade_color',$materialgrade_color);
       $lot_num = $data["lot_num"];
       $this->set('lot_num',$lot_num);
       $StockEndMaterialsId = $data["StockEndMaterialsId"];
       $this->set('StockEndMaterialsId',$StockEndMaterialsId);

       $amount = $data["amount"];
       $htmlhazaicheck = new htmlhazaicheck();//クラスを使用
       $amount = $htmlhazaicheck->amountcheck($amount);
       $this->set('amount', $amount);

       $shippedflag = $data["shippedflag"];
       $this->set('shippedflag',$shippedflag);
       if($data["shippedflag"] > 0){
         $shipped = "使用済";
       }else{
         $shipped = "未使用";
       }
       $this->set('shipped',$shipped);

       if($data["check"] > 0){
         $mess = "以下のデータを削除します。よろしければ「決定」ボタンを押してください。";
         $delete_flag = 1;
       }else{
         $mess = "以下のように更新します。よろしければ「決定」ボタンを押してください。";
         $delete_flag = 0;
       }
       $this->set('mess', $mess);
       $this->set('delete_flag', $delete_flag);

       if(!isset($_SESSION)){
         session_start();
         header('Expires:-1');
         header('Cache-Control:');
         header('Pragma:');
       }

     }

     public function editdo()
     {
       $stockEndMaterials = $this->StockEndMaterials->newEntity();
       $this->set('stockEndMaterials',$stockEndMaterials);

       $data = $this->request->getData();
/*
       echo "<pre>";
       print_r($data);
       echo "</pre>";
*/
       $username = $data["username"];
       $this->set('username',$username);
       $staff_name = $data["staff_name"];
       $this->set('staff_name',$staff_name);

       $Users = $this->Users->find()
       ->where(['username' => $username])->toArray();
       $staff_id = $Users[0]["staff_id"];

       $product_code = $data["product_code"];
       $this->set('product_code',$product_code);
       $materialgrade_color = $data["materialgrade_color"];
       $this->set('materialgrade_color',$materialgrade_color);
       $lot_num = $data["lot_num"];
       $this->set('lot_num',$lot_num);
       $StockEndMaterialsId = $data["StockEndMaterialsId"];
       $this->set('StockEndMaterialsId',$StockEndMaterialsId);
       $amount = $data["amount"];
       $this->set('amount', $amount);

       $shippedflag = $data["shippedflag"];
       $this->set('shippedflag',$shippedflag);
       if($data["shippedflag"] > 0){
         $shipped = "使用済";
       }else{
         $shipped = "未使用";
       }
       $this->set('shipped',$shipped);

       $StockEndMaterials = $this->StockEndMaterials->find()
       ->where(['id' => $StockEndMaterialsId])->toArray();

       if(strlen($StockEndMaterials[0]["shiped_staff"]) > 0){//もともと使用済み

         if($shippedflag > 0){//変更なし

           $shippedflaghennkou = 0;

         }else{//不使用に変更

           $shippedflaghennkou = 1;

         }

       }else{//もともと不使用

         if($shippedflag > 0){//使用に変更

           $shippedflaghennkou = 2;

         }else{//変更なし

           $shippedflaghennkou = 0;

         }

       }

       $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $data);
       $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4

          if($data["delete_flag"] == 0){//削除ではないとき

            if($shippedflaghennkou == 2){//不使用を使用に変更する場合

              if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
                ['amount' => $amount, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id,
                'shiped_staff' => $staff_id, 'shiped_at' => date('Y-m-d H:i:s')],
                ['id'  => $StockEndMaterialsId]
              )){

                $mes = "※更新されました";
                $this->set('mes',$mes);
                $connection->commit();// コミット5

              } else {

                $mes = "※更新されませんでした";
                $this->set('mes',$mes);
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

              }

            }elseif($shippedflaghennkou == 1){//使用を不使用に変更する場合

              if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
                ['amount' => $amount, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id,
                'shiped_staff' => NULL, 'shiped_at' => NULL],
                ['id'  => $StockEndMaterialsId]
              )){

                $mes = "※更新されました";
                $this->set('mes',$mes);
                $connection->commit();// コミット5

              } else {

                $mes = "※更新されませんでした";
                $this->set('mes',$mes);
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

              }

            }else{//使用は変更なしの場合

              if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
                ['amount' => $amount, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
                ['id'  => $StockEndMaterialsId]
              )){

                $mes = "※更新されました";
                $this->set('mes',$mes);
                $connection->commit();// コミット5

              } else {

                $mes = "※更新されませんでした";
                $this->set('mes',$mes);
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

              }

            }

          }else{//削除のとき

            if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
              ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
              ['id'  => $StockEndMaterialsId]
            )){

              $mes = "※削除されました";
              $this->set('mes',$mes);
              $connection->commit();// コミット5

            } else {

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
