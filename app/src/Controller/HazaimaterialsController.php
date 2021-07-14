<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Auth\DefaultPasswordHasher;//

use App\myClass\Rolecheck\htmlRolecheck;

class HazaimaterialsController extends AppController {

  public function initialize()
  {
   parent::initialize();
   $this->Staffs = TableRegistry::get('staffs');
   $this->Users = TableRegistry::get('users');
   $this->Materials = TableRegistry::get('materials');
   $this->StockEndMaterials = TableRegistry::get('stockEndMaterials');
  }

   public function menu()
   {
   }

   public function materialform()
   {
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

       $Users = $this->Users->find()
       ->where(['username' => $data["username"]])->toArray();

       if(!isset($Users[0])){

         return $this->redirect(['action' => 'csvlogin',
         's' => ['mess' => "社員コードが間違っています。もう一度やり直してください。"]]);

       }

     }

     $username = $data["username"];
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
     ->where(['state' => 0, 'delete_flag' => 0])->toArray();

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

     $StockEndMaterials = $this->StockEndMaterials->find()
     ->where(['state' => 0, 'delete_flag' => 0])->toArray();
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
     $_SESSION['hazaicsvstaffdo'] = $data["username"];
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
     $username = $_SESSION['hazaicsvstaffdo'];

     $this->set('csvStockEndMaterials',$csvStockEndMaterials);

     $arrCsvs = array();//空の配列を作る
     for($k=0; $k<count($csvStockEndMaterials); $k++){

       $arrCsvs[] = ['maisu' => 1, 'layout' => "-", 'lotnum' => $csvStockEndMaterials[$k]['lot_num'],
        'renban' => 1, 'place1' => "栄ライト工業所", 'place2' => "",
        'product_code' => $csvStockEndMaterials[$k]['grade'], 'product_code2' => "", 'product_name' => "",
        'product_name2' => "", 'irisu' => $csvStockEndMaterials[$k]['amount'], 'irisu2' => "", 'unit' => "", 'unit2' => "", 'line_code1' => ""];

     }

     echo "<pre>";
     print_r($arrCsvs);
     echo "</pre>";

   }



}
