<?php
namespace App\myClass\Productcheck;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlProductcheck extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->Products = TableRegistry::get('products');
    }

    public function Productcheck($product_code)
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

	public function get_data(){
		return $this->data;
		}

	public function get_rows(){
		return $this->rows;
		}

	public function get_html(){
		return $this->html;
		}

}

?>
