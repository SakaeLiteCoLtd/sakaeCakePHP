<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

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
   $this->Materials = TableRegistry::get('materials');
//   $this->PriceMaterials = TableRegistry::get('priceMaterials');
   $this->StockEndMaterials = TableRegistry::get('stockEndMaterials');
  }

   public function menu()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $StockEndMaterials = $this->StockEndMaterials->find()
     ->where(['status_import_tab' => 0, 'delete_flag' => 0])->toArray();

     $arrStockEndMaterials = array();//空の配列を作る
     for($k=0; $k<count($StockEndMaterials); $k++){

       $Materials = $this->Materials->find()
       ->where(['id' => $StockEndMaterials[$k]["material_id"]])->toArray();
       $grade = $Materials[0]["grade"];
       $color = $Materials[0]["color"];

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
         'grade' => $grade,
         'color' => $color,
         'status_material' => $status_material,
         'amount' => $StockEndMaterials[$k]["amount"],
         'created_at' => $StockEndMaterials[$k]["created_at"]->format('Y-n-j'),
         'staff_name' => $staff_name,
       ];

     }
     $this->set('arrStockEndMaterials',$arrStockEndMaterials);
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

     $Material_list = $this->Materials->find()
     ->where(['delete_flag' => 0])->toArray();
     $arrMaterial_list = array();
     for($j=0; $j<count($Material_list); $j++){
       array_push($arrMaterial_list,$Material_list[$j]["grade"]."_".$Material_list[$j]["color"]);
     }
     $arrMaterial_list = array_unique($arrMaterial_list);
     $arrMaterial_list = array_values($arrMaterial_list);
     $this->set('arrMaterial_list', $arrMaterial_list);
   }

   public function materialformsyousai()
   {
     $stockEndMaterials = $this->StockEndMaterials->newEntity();
     $this->set('stockEndMaterials',$stockEndMaterials);

     $data = $this->request->getData();
     $username = $data["username"];
     $this->set('username', $username);

     $Users = $this->Users->find()
     ->where(['username' => $username])->toArray();

     $Staffs = $this->Staffs->find()
     ->where(['id' => $Users[0]["staff_id"]])->toArray();
     $staff_name = $Staffs[0]["f_name"]." ".$Staffs[0]["l_name"];
     $this->set('staff_name', $staff_name);

     $grade_color = explode('_', $data["materialgrade_color"]);
     $grade = $grade_color[0];
     $color = $grade_color[1];
     $this->set('grade', $grade);
     $this->set('color', $color);

     $Materials = $this->Materials->find()
     ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

     if(isset($Materials[0])){

     }else{

       return $this->redirect(['action' => 'materialform',
       's' => ['username' => $username, 'mess' => "グレード：「".$grade."」、色：「".$color."」の原料は原料登録されていません。"]]);

     }
     /*
     echo "<pre>";
     print_r($Materials[0]);
     echo "</pre>";
     */
     $material_id = $Materials[0]["id"];
     $this->set('material_id', $material_id);

     $arrStatusMaterial = [
       '0' => 'バージン',
       '1' => '粉砕',
       '2' => 'バージン＋粉砕'
     ];
     $this->set('arrStatusMaterial',$arrStatusMaterial);

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
     $grade = $data["grade"];
     $this->set('grade', $grade);
     $color = $data["color"];
     $this->set('color', $color);
     $material_id = $data["material_id"];
     $this->set('material_id', $material_id);
     $status_material = $data["status_material"];
     $this->set('status_material', $status_material);
     $amount = $data["amount"];

     $countdot = mb_substr_count($amount, ".");
     if($countdot > 1){
       $amount = str_replace('.', '', $amount);
     }

     $dotini = substr($amount, 0, 1);
     $dotend = substr($amount, -1, 1);

     if($dotini == "."){
       $amount = "0".$amount;
     }elseif($dotend == "."){
       $amount = $amount."0";
     }
     $this->set('amount', $amount);

     if($status_material == 0){
       $hyouji_status_material = 'バージン';
     }elseif($status_material == 1){
       $hyouji_status_material = '粉砕';
     }else{
       $hyouji_status_material = 'バージン＋粉砕';
     }
     $this->set('hyouji_status_material', $hyouji_status_material);

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
     $grade = $data["grade"];
     $this->set('grade', $grade);
     $color = $data["color"];
     $this->set('color', $color);
     $material_id = $data["material_id"];
     $this->set('material_id', $material_id);
     $status_material = $data["status_material"];
     $this->set('status_material', $status_material);
     $amount = $data["amount"];
     $this->set('amount', $amount);
     $hyouji_status_material = $data["hyouji_status_material"];
     $this->set('hyouji_status_material', $hyouji_status_material);

     $Users = $this->Users->find()
     ->where(['username' => $username])->toArray();

     $http = new Client();

     $postdata = array();//空の配列を作る
     $postdata = [
       'material_id' => $material_id,
       'status_material' => $status_material,
       'amount' => $amount,
       'staff_id' => $Users[0]["staff_id"],
     ];

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

       $arrTourokuStockEndMaterials = [
         'material_id' => $arr["material_id"],
         'status_material' => $arr["status_material"],
         'amount' => $arr["amount"],
         'state' => 0,
         'status_import_tab' => 0,
         'delete_flag' => 0,
         'created_at' => date('Y-m-d H:i:s'),
         'created_staff' => $arr["staff_id"],
       ];
/*
$arrTourokuStockEndMaterials = [
  'material_id' => 1,
  'status_material' => 1,
  'amount' => 1,
  'lot_num' => "111",
  'state' => 0,
  'status_import_tab' => 0,
  'delete_flag' => 0,
  'created_at' => date('Y-m-d H:i:s'),
  'created_staff' => 1,
];
*/
       $lotdate = date('y').date('m').date('d');
       $countStockEndMaterials = $this->StockEndMaterials->find()
       ->where(['material_id' => $arrTourokuStockEndMaterials["material_id"], 'lot_num like' => $lotdate.'%'])->toArray();
       $countLot = count($countStockEndMaterials) + 1;
       $lot_num = $lotdate."-".sprintf('%03d', $countLot);

       $arrTourokuStockEndMaterials = array_merge($arrTourokuStockEndMaterials,array('lot_num' => $lot_num));

       $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $arrTourokuStockEndMaterials);
       if ($this->StockEndMaterials->save($StockEndMaterials)) {
           $message = 'Saved';
       } else {
           $message = 'Error';
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

       $Materials = $this->Materials->find()
       ->where(['id' => $StockEndMaterials[$k]["material_id"]])->toArray();
       $grade = $Materials[0]["grade"];
       $color = $Materials[0]["color"];

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
         'grade' => $grade,
         'color' => $color,
         'status_material' => $status_material,
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

         $Materials = $this->Materials->find()
         ->where(['id' => $StockEndMaterials[$k]["material_id"]])->toArray();
         $grade = $Materials[0]["grade"];
         $color = $Materials[0]["color"];

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
           'grade' => $grade,
           'color' => $color,
           'status_material' => $status_material,
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

       $arrCsvs[] = ['maisu' => 1, 'layout' => "-", 'lotnum' => $csvStockEndMaterials[$k]['lot_num'],
        'renban' => 1, 'place1' => "栄ライト工業所", 'place2' => "",
        'product_code' => $csvStockEndMaterials[$k]['grade'], 'product_code2' => "", 'product_name' => "",
        'product_name2' => "", 'irisu' => $csvStockEndMaterials[$k]['amount'], 'irisu2' => "", 'unit' => "", 'unit2' => "", 'line_code1' => ""];

     }

       $StockEndMaterials = $this->StockEndMaterials->patchEntity($this->StockEndMaterials->newEntity(), $csvStockEndMaterials);
       $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4

          for($k=0; $k<count($csvStockEndMaterials); $k++){

            $Materials = $this->Materials->find()
            ->where(['grade' => $csvStockEndMaterials[$k]["grade"], 'color' => $csvStockEndMaterials[$k]["color"]])->toArray();
            $material_id = $Materials[0]["id"];

            if ($this->StockEndMaterials->updateAll(//検査終了時間の更新
              ['status_import_tab' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
              ['material_id'  => $material_id, 'lot_num' => $csvStockEndMaterials[$k]['lot_num']]
            )){

              if($k == count($csvStockEndMaterials) - 1){
                $fp = fopen('hazai/hazai.csv', 'w');//local
               // $fp = fopen('/home/centosuser/hazai_csv/hazai.csv', 'w');//192

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

        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10

   }

   public function torikomilogin()
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

   public function torikomiselect()
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

    public function torikomiselectdo()
    {
      $stockEndMaterials = $this->StockEndMaterials->newEntity();
      $this->set('stockEndMaterials',$stockEndMaterials);

      $data = $this->request->getData();

      $username = $data["username"];
      echo "<pre>";
      print_r($username);
      echo "</pre>";

      $source_file = $_FILES['file']['tmp_name'];

      $fp = fopen($source_file, "r");
      $fpcount = fopen($source_file, 'r' );
       for($count = 0; fgets( $fpcount ); $count++ );
       $arrFp = array();//空の配列を作る
       $arrLot = array();//空の配列を作る

       for ($k=1; $k<=$count; $k++) {//最後の行まで

         $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
         $sample = explode("\t",$line);//$lineを"（スペース）"毎に配列に入れる
         $arrFp[] = $sample;//配列に追加する
         $arrLot[] = ['product_code' => $arrFp[$k-1][6]];

       }

       echo "<pre>";
       print_r($arrFp);
       echo "</pre>";

     }

}
