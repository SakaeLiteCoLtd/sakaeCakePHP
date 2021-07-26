<?php
namespace App\myClass\hazaiploglam;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlhazaicheck extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->Products = TableRegistry::get('products');
        $this->PriceMaterials = TableRegistry::get('priceMaterials');
    }

    public function productcheck($product_code)
   {
     $Products = $this->Products->find()
     ->where(['product_code' => $product_code, 'delete_flag' => 0])->toArray();

     $materialgrade_color = "";
     $price_material_id = "";

     if(isset($Products[0])){

       $productcheck = 0;
       $materialgrade_color = $Products[0]["m_grade"]."_".$Products[0]["col_num"];
       $PriceMaterials = $this->PriceMaterials->find()
       ->where(['grade' => $Products[0]["m_grade"], 'color' => $Products[0]["col_num"], 'delete_flag' => 0])->toArray();

       if(isset($PriceMaterials[0])){

         $price_material_id = $PriceMaterials[0]["id"];

       }else{

         $productcheck = 2;

       }

     }else{

       $productcheck = 1;

     }

     $arrhazaicheckproduct = [
       "productcheck" => $productcheck,
       "materialgrade_color" => $materialgrade_color,
       "price_material_id" => $price_material_id
     ];
     return $arrhazaicheckproduct;

   }

   public function materialcheck($grade_color)
  {
    $materialcheck = 0;
    $price_material_id = "";

    $grade = $grade_color[0];
    if(isset($grade_color[1])){

      $color = $grade_color[1];

      $PriceMaterials = $this->PriceMaterials->find()
      ->where(['grade' => $grade, 'color' => $color, 'delete_flag' => 0])->toArray();

      if(isset($PriceMaterials[0])){

        $price_material_id = $PriceMaterials[0]["id"];

      }else{

        $materialcheck = 1;

      }

    }else{

      $materialcheck = 2;

    }

    $arrhazaicheckmaterial = [
      "materialcheck" => $materialcheck,
      "price_material_id" => $price_material_id
    ];
    return $arrhazaicheckmaterial;

  }

  public function amountcheck($amount)
 {

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

   return $amount;

 }

    public function sankou($product_code)
   {
     if($product_code != null){
       $product_code = $product_code;
       $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
       if(isset($Product[0])){
         $product_code = $product_code;
         $product_code_check = 0;
       }else{
    //     echo "<pre>";
    //     print_r("製品「".$product_code."」はproductテーブルに登録されていません。製品登録からやり直してください。");
    //     echo "</pre>";
         $product_code_check = 1;
       }
     }
      return $product_code_check;
   }


}

?>
