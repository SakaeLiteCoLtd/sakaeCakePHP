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

class KouteisController extends AppController {

      public function initialize()
    {
     parent::initialize();
     $this->Products = TableRegistry::get('products');//productsテーブルを使う
     $this->Customers = TableRegistry::get('customers');
     $this->Users = TableRegistry::get('users');
     $this->KouteiImSokuteidataHeads = TableRegistry::get('kouteiImSokuteidataHeads');
     $this->KouteiImKikakus = TableRegistry::get('kouteiImKikakus');
     $this->KouteiImSokuteidataResults = TableRegistry::get('kouteiImSokuteidataResults');
     $this->KouteiImKikakuTaious = TableRegistry::get('kouteiImKikakuTaious');
     $this->KouteiKensahyouHeads = TableRegistry::get('kouteiKensahyouHeads');
     $this->KouteiFileCopyChecks = TableRegistry::get('kouteiFileCopyChecks');
     $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
     $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouSokuteidatasテーブルを使う
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

    public function headyobidashicustomer()//「出荷検査用呼出」ページトップ
    {
      $KensahyouHeads = $this->KensahyouHeads->newEntity();
      $this->set('KensahyouHeads',$KensahyouHeads);
    }

    public function tourokuyobidashicustomer()//「出荷検査用呼出」ページトップ
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

    public function headyobidashipana()
    {
      $this->set('products', $this->Products->find()
       ->select(['product_code','delete_flag' => '0'])
       );
    }

    public function tourokuyobidashipana()
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

    public function headyobidashipanap0()
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

    public function tourokuyobidashipanap0()
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

    public function headyobidashipanap1()
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

    public function tourokuyobidashipanap1()
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

    public function headyobidashipanap2()
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

    public function tourokuyobidashipanap2()
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

    public function headyobidashipanaw()
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

    public function tourokuyobidashipanaw()
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

    public function headyobidashipanah()
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

    public function tourokuyobidashipanah()
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

    public function headyobidashipanare()
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

    public function tourokuyobidashipanare()
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

    public function headyobidashidnp()
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

    public function tourokuyobidashidnp()
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

    public function headyobidashiothers()
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

    public function tourokuyobidashiothers()
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

    public function version()
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

    	$KouteiKensahyouHeads = $this->KouteiKensahyouHeads->newEntity();//newEntity・・・テーブルに空の行を作る
    	$this->set('KouteiKensahyouHeads',$KouteiKensahyouHeads);//セット

    	$KensaProduct = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code, 'delete_flag' => '0'])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
    	$this->set('KensaProduct',$KensaProduct);//セット

    	$Productn = $this->Products->find()->where(['product_code' => $product_code])->toArray();//
    	$Productname = $Productn[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	$this->set('KouteiKensahyouHeads',$this->KouteiKensahyouHeads->find()//KensahyouHeadsテーブルから
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

   public function kouteiheadview()
   {
     $data = $this->request->query();

     if(isset($data["name"])){
       $product_code = $data["name"];
     }else{
       $data = $this->request->getData();
       $product_code = $data["product_code"];
     }
     $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

     $this->set('entity',$this->KouteiImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

     $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();

     $ImKikakuex = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => 0])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
     $this->set('ImKikakuex',$ImKikakuex);//セット

     $Productname = $Product[0]->product_name;
     $this->set('Productname',$Productname);//セット

     $ImSokuteidataHeads = $this->KouteiImSokuteidataHeads->find()
     ->where(['product_code' => $product_code])->toArray();

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
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $KouteiKensahyouHead = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->order(["version"=>"desc"])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
     $this->set('KouteiKensahyouHead',$KouteiKensahyouHead);//セット

     if(isset($KouteiKensahyouHead[0])){
       $KensahyouHeadver = $KouteiKensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
       $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

       $KensahyouHeadid = $KouteiKensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
       $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

       for($i=1; $i<=9; $i++){//size_1～9までセット
         ${"size_".$i} = $KouteiKensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
         $this->set('size_'.$i,${"size_".$i});//セット
       }

       for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
         ${"upper_".$j} = $KouteiKensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
         $this->set('upper_'.$j,${"upper_".$j});//セット
         ${"lower_".$j} = $KouteiKensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
         $this->set('lower_'.$j,${"lower_".$j});//セット
       }
     }

     if(isset($KouteiKensahyouHead[0])){
       $KensahyouHeadbik = $KouteiKensahyouHead[0]->bik;
       $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット
     }else{
       $KensahyouHeadbik = "";
       $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット
     }

   }

    public function imtaiouform()//IM検査表対応登録
    {
      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
      $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    	$this->set('entity',$this->KouteiImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();

      $ImKikakuex = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
      $this->set('ImKikakuex',$ImKikakuex);//セット

      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $ImSokuteidataHeads = $this->KouteiImSokuteidataHeads->find()
    	->where(['product_code' => $product_code])->toArray();

      $arrKindKensa = array("","ノギス");//配列の初期化
    	 	foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
          $arrKindKensa[] = $value->kind_kensa;//配列に追加
    		}
        $arrKindKensa = array_unique($arrKindKensa);

        $arr_shape_detection = [
          null => '',
          '0' => '寸法',
  				'1' => 'IM形状'
  							];
  			$this->set('arr_shape_detection',$arr_shape_detection);

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
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$KouteiKensahyouHead = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KouteiKensahyouHead',$KouteiKensahyouHead);//セット

      if(isset($KouteiKensahyouHead[0])){
        $KensahyouHeadver = $KouteiKensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

      	$KensahyouHeadid = $KouteiKensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
      	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      	for($i=1; $i<=9; $i++){//size_1～9までセット
      		${"size_".$i} = $KouteiKensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
      		$this->set('size_'.$i,${"size_".$i});//セット
      	}

      	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
      		${"upper_".$j} = $KouteiKensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
      		$this->set('upper_'.$j,${"upper_".$j});//セット
      		${"lower_".$j} = $KouteiKensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
      		$this->set('lower_'.$j,${"lower_".$j});//セット
      	}
      }

    }

    public function typeimtaiouform()//IMtaiou
    {
  //    $this->request->session()->destroy();// セッションの破棄

      if(!isset($_SESSION)){
      session_start();
      }
      $_SESSION['imdatanew'] = array();

      $data = $this->request->query();

      if(isset($data["name"])){
        $product_code = $data["name"];
      }else{
        $data = $this->request->getData();
        $product_code = $data["product_code"];
      }
      $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

    	$this->set('KouteiKensahyouHeads',$this->KouteiKensahyouHeads->newEntity());

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);

      $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->order(["version"=>"desc"])->toArray();//versionが大きいものから順に呼出
/*
      echo "<pre>";
      print_r(count($KouteiKensahyouHeads));
      echo "</pre>";
*/
      if(isset($KouteiKensahyouHeads[0])){
        $id = $KouteiKensahyouHeads[0]->id;
        $this->set('id',$id);
        $versionnow = $KouteiKensahyouHeads[0]->version;
        $this->set('versionnow',$versionnow);
        $typenow = $KouteiKensahyouHeads[0]->type_im;
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

    public function imtaiouconfirm()
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
    $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
    $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $this->set('entity',$this->KouteiImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
    }

    public function impreadd()
    {
      $this->set('entity',$this->KouteiImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

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
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $KouteiImKikakuTaious = $this->KouteiImKikakuTaious->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('KouteiImKikakuTaious',$KouteiImKikakuTaious);//セット

     $count = count($data);
     for($k=1; $k<=$count; $k++){

       if(!empty($data[$k]["kind_kensa"]) && !empty($data[$k]["im_size_num"])){

         $staff_id = $sessiondata['Auth']['User']['staff_id'];//ログイン中のuserのstaff_idに$staff_idという名前を付ける
         $data[$k]['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

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
        $KouteiImKikakuTaiou = $this->KouteiImKikakuTaious->patchEntities($KouteiImKikakuTaious, $data);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
            if ($this->KouteiImKikakuTaious->saveMany($KouteiImKikakuTaiou)) {//saveManyで一括登録

            //旧DB更新
            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('koutei_im_kikaku_taiou');
            $table->setConnection($connection);

            for($k=0; $k<count($data); $k++){
              $connection->insert('koutei_im_kikaku_taiou', [
                'product_id' => $data[$k]["product_code"],
                'kensahyou_size' => $data[$k]["kensahyou_size"],
                'kind_kensa' => $data[$k]["kind_kensa"],
                'im_size_num' => $data[$k]["im_size_num"],
                'shape_detection' => $data[$k]["shape_detection"],
                'status' => $data[$k]["status"],
                'created_at' => $data[$k]["created_at"],
                'created_emp_id' => $data[$k]["created_staff"]
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

      $this->set('KouteiKensahyouHeads',$this->KouteiKensahyouHeads->newEntity());

      $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->find()->where(['id' => $data["imdatanew"][0]['id']])->toArray();
      $product_code = $KouteiKensahyouHeads[0]->product_code;
      $tourokuData = [
        'product_code' => $product_code,
        'version' => $data["imdatanew"][0]['version'],
        'type_im' => $data["imdatanew"][0]['type_im'],
        'size_1' => $KouteiKensahyouHeads[0]->size_1,
        'upper_1' => $KouteiKensahyouHeads[0]->upper_1,
        'lower_1' => $KouteiKensahyouHeads[0]->lower_1,
        'size_2' => $KouteiKensahyouHeads[0]->size_2,
        'upper_2' => $KouteiKensahyouHeads[0]->upper_2,
        'lower_2' => $KouteiKensahyouHeads[0]->lower_2,
        'size_3' => $KouteiKensahyouHeads[0]->size_3,
        'upper_3' => $KouteiKensahyouHeads[0]->upper_3,
        'lower_3' => $KouteiKensahyouHeads[0]->lower_3,
        'size_4' => $KouteiKensahyouHeads[0]->size_4,
        'upper_4' => $KouteiKensahyouHeads[0]->upper_4,
        'lower_4' => $KouteiKensahyouHeads[0]->lower_4,
        'size_5' => $KouteiKensahyouHeads[0]->size_5,
        'upper_5' => $KouteiKensahyouHeads[0]->upper_5,
        'lower_5' => $KouteiKensahyouHeads[0]->lower_5,
        'size_6' => $KouteiKensahyouHeads[0]->size_6,
        'upper_6' => $KouteiKensahyouHeads[0]->upper_6,
        'lower_6' => $KouteiKensahyouHeads[0]->lower_6,
        'size_7' => $KouteiKensahyouHeads[0]->size_7,
        'upper_7' => $KouteiKensahyouHeads[0]->upper_7,
        'lower_7' => $KouteiKensahyouHeads[0]->lower_7,
        'size_8' => $KouteiKensahyouHeads[0]->size_8,
        'upper_8' => $KouteiKensahyouHeads[0]->upper_8,
        'lower_8' => $KouteiKensahyouHeads[0]->lower_8,
        'size_9' => $KouteiKensahyouHeads[0]->size_9,
        'text_10' => $KouteiKensahyouHeads[0]->text_10,
        'text_11' => $KouteiKensahyouHeads[0]->text_11,
        'bik' => $KouteiKensahyouHeads[0]->bik,
        'status' => 0,
        'created_at' => date('Y-m-d H:i:s'),
        'created_staff' => $data["imdatanew"][0]['updated_staff']
      ];
/*
      echo "<pre>";
      print_r($tourokuData);
      echo "</pre>";
*/
      if ($this->request->is('get')) {//getなら登録
        $KouteiKensahyouHead = $this->KouteiKensahyouHeads->patchEntities($this->KouteiKensahyouHeads->newEntity(), $data["imdatanew"][0]);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->KouteiKensahyouHeads->updateAll(
        //    ['version' => $data["imdatanew"][0]['version'], 'type_im' => $data["imdatanew"][0]['type_im'], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data["imdatanew"][0]['updated_staff']],
            ['status' => 1, 'delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data["imdatanew"][0]['updated_staff']],
            ['id'  => $data["imdatanew"][0]['id']]
            )){

              $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->patchEntity($this->KouteiKensahyouHeads->newEntity(), $tourokuData);
  						$this->KouteiKensahyouHeads->save($KouteiKensahyouHeads);

              $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->find()->where(['id' => $data["imdatanew"][0]['id']])->toArray();

              //旧DBに登録
  						$connection = ConnectionManager::get('DB_ikou_test');
  						$table = TableRegistry::get('koutei_kensahyou_head');
  						$table->setConnection($connection);

              $delete_flag = 1;
              $versionmoto = $data["imdatanew"][0]['version'] - 1;
              $updater = "UPDATE koutei_kensahyou_head set status ='".$delete_flag."' ,
               updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$data["imdatanew"][0]['updated_staff']."'
              where product_id ='".$product_code."' and version ='".$versionmoto."'";
              $connection->execute($updater);

  							$connection->insert('koutei_kensahyou_head', [
                  'product_id' => $product_code,
                  'version' => $data["imdatanew"][0]['version'],
                  'type_im' => $data["imdatanew"][0]['type_im'],
                  'size_1' => $KouteiKensahyouHeads[0]->size_1,
                  'upper_1' => $KouteiKensahyouHeads[0]->upper_1,
                  'lower_1' => $KouteiKensahyouHeads[0]->lower_1,
                  'size_2' => $KouteiKensahyouHeads[0]->size_2,
                  'upper_2' => $KouteiKensahyouHeads[0]->upper_2,
                  'lower_2' => $KouteiKensahyouHeads[0]->lower_2,
                  'size_3' => $KouteiKensahyouHeads[0]->size_3,
                  'upper_3' => $KouteiKensahyouHeads[0]->upper_3,
                  'lower_3' => $KouteiKensahyouHeads[0]->lower_3,
                  'size_4' => $KouteiKensahyouHeads[0]->size_4,
                  'upper_4' => $KouteiKensahyouHeads[0]->upper_4,
                  'lower_4' => $KouteiKensahyouHeads[0]->lower_4,
                  'size_5' => $KouteiKensahyouHeads[0]->size_5,
                  'upper_5' => $KouteiKensahyouHeads[0]->upper_5,
                  'lower_5' => $KouteiKensahyouHeads[0]->lower_5,
                  'size_6' => $KouteiKensahyouHeads[0]->size_6,
                  'upper_6' => $KouteiKensahyouHeads[0]->upper_6,
                  'lower_6' => $KouteiKensahyouHeads[0]->lower_6,
                  'size_7' => $KouteiKensahyouHeads[0]->size_7,
                  'upper_7' => $KouteiKensahyouHeads[0]->upper_7,
                  'lower_7' => $KouteiKensahyouHeads[0]->lower_7,
                  'size_8' => $KouteiKensahyouHeads[0]->size_8,
                  'upper_8' => $KouteiKensahyouHeads[0]->upper_8,
                  'lower_8' => $KouteiKensahyouHeads[0]->lower_8,
                  'size_9' => $KouteiKensahyouHeads[0]->size_9,
                  'text_10' => $KouteiKensahyouHeads[0]->text_10,
                  'text_11' => $KouteiKensahyouHeads[0]->text_11,
                  'bik' => $KouteiKensahyouHeads[0]->bik,
                  'status' => 0,
                  'created_at' => date('Y-m-d H:i:s'),
                  'created_emp_id' => $data["imdatanew"][0]['updated_staff']
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
//      $this->request->session()->destroy(); // セッションの破棄

      if(!isset($_SESSION)){
      session_start();
      }
      $_SESSION['kikakudata'] = array();
      $_SESSION['sokuteidata'] = array();
      $_SESSION['kousinn_flag'] = array();
      $_SESSION['imdatanew'] = array();

      $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->newEntity();
      $this->set('KouteiKensahyouHeads', $KouteiKensahyouHeads);
    }

/*
     public function torikomi()//取り込み（画面なし自動で次のページへ）
    {

      $dirName = 'data_工程_IMデータ/';//webroot内のフォルダ
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

                        $foldername = explode("_",$folder);

                        $product_code = $foldername[1];
                        $kind_kensa = $foldername[2];

                          while(($file = readdir($child_dir)) !== false){//子while
                               if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN

                                  $fp = fopen('data_工程_IMデータ/'.$folder.'/'.$file, "r");//kesuyatu

                                   if(substr($file, 0, 5) != "sumi_" ){//sumi_でないファイルだけOPEN
                                    $countname += 1;//ファイル名がかぶらないようにカウントしておく

                                    $fp = fopen('data_工程_IMデータ/'.$folder.'/'.$file, "r");//csvファイルはwebrootに入れる
                              			$this->set('fp',$fp);

                              			$fpcount = fopen('data_工程_IMデータ/'.$folder.'/'.$file, 'r' );
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
                                      $inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);

                                      $session = $this->request->session();
                                      $session->write('kind_kensa', $kind_kensa);

                                      $arrIm_heads[] = $product_code;
                                      $arrIm_heads[] = $kind_kensa;
                                      $arrIm_heads[] = $inspec_date;
                                      $arrIm_heads[] = ${"arruniLot_num".$countname}[$k-1];
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = date('Y-m-d H:i:s');

                                      $name_heads = array('product_code', 'kind_kensa', 'inspec_date', 'lot_num', 'torikomi', 'delete_flag', 'created_at');
                                      $arrIm_heads = array_combine($name_heads, $arrIm_heads);
                                      $arrIm_head[] = $arrIm_heads;
                                    }


                                    $KouteiImSokuteidataHead = $this->KouteiImSokuteidataHeads->patchEntities($this->KouteiImSokuteidataHeads->newEntity(), $arrIm_head);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                    $connection = ConnectionManager::get('default');//トランザクション1
                                    // トランザクション開始2
                                    $connection->begin();//トランザクション3
                                    try {//トランザクション4
                                      if ($this->KouteiImSokuteidataHeads->saveMany($KouteiImSokuteidataHead)) {

                                        $connection = ConnectionManager::get('DB_ikou_test');
                                        $table = TableRegistry::get('koutei_im_sokuteidata_head');
                                        $table->setConnection($connection);

                                        $connection->insert('koutei_im_sokuteidata_head', [
                                            'product_id' => $arrIm_head[0]['product_code'],
                                            'kind_kensa' => $arrIm_head[0]['kind_kensa'],
                                            'version' => 0,
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

                                            $KouteiImSokuteidataHeadsData = $this->KouteiImSokuteidataHeads->find()->where(['lot_num' => ${"arruniLot_num".$countname}[$m-1], 'kind_kensa' => $kind_kensa])->toArray();
                                            $im_sokuteidata_head_id = $KouteiImSokuteidataHeadsData[0]->id;

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
                                          $KouteiImKikakus = $this->KouteiImKikakus->newEntity();//newentityに$userという名前を付ける

                                          $KouteiImKikakus = $this->KouteiImKikakus->patchEntities($KouteiImKikakus, $arrIm_kikaku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                             if ($this->KouteiImKikakus->saveMany($KouteiImKikakus)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $table = TableRegistry::get('koutei_im_kikaku');
                                               $table->setConnection($connection);

                                               $sql = "SELECT id FROM koutei_im_sokuteidata_head".
                                               " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                 order by id desc limit 1";
                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                               for($k=0; $k<count($arrIm_kikaku); $k++){
                                                 $connection->insert('koutei_im_kikaku', [
                                                     'id' => $im_sokuteidata_head_id[0]["id"],
                                                     'size_num' => $arrIm_kikaku[$k]["size_num"],
                                                     'size' => $arrIm_kikaku[$k]["size"],
                                                     'upper' => $arrIm_kikaku[$k]["upper"],
                                                     'lower' => $arrIm_kikaku[$k]["lower"]
                                                 ]);
                                               }

                                               $connection = ConnectionManager::get('default');

                                                //KouteiImSokuteidataResultsの登録用データをセット
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

                                                      $KouteiImSokuteidataHeadsData = $this->KouteiImSokuteidataHeads->find()->where(['lot_num' => $arrFp[$j+4][2], 'kind_kensa' => $kind_kensa])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                                      $im_sokuteidata_head_id = $KouteiImSokuteidataHeadsData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

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
                                                  $KouteiImSokuteidataResults = $this->KouteiImSokuteidataResults->newEntity();//newentityに$userという名前を付ける
                                                  $KouteiImSokuteidataResults = $this->KouteiImSokuteidataResults->patchEntities($KouteiImSokuteidataResults, $arrIm_Result);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                                  if ($this->KouteiImSokuteidataResults->saveMany($KouteiImSokuteidataResults)) {//ImSokuteidataResultsをsaveできた時（saveManyで一括登録）

                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $table = TableRegistry::get('koutei_im_sokuteidata_result');
                                                    $table->setConnection($connection);

                                                    $sql = "SELECT id FROM koutei_im_sokuteidata_head".
                                                    " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                     and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                      order by id desc limit 1";
                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                                    for($k=0; $k<count($arrIm_Result); $k++){

                                                      $sql = "SELECT id FROM koutei_im_sokuteidata_result".
                                                      " where id = '".$im_sokuteidata_head_id[0]["id"]."' and inspec_datetime = '".$arrIm_Result[$k]["inspec_datetime"]."'
                                                       and serial = '".$arrIm_Result[$k]["serial"]."' and size_num = '".$arrIm_Result[$k]["size_num"]."'
                                                        order by id desc limit 1";
                                                      $connection = ConnectionManager::get('DB_ikou_test');
                                                      $koutei_im_sokuteidata_result = $connection->execute($sql)->fetchAll('assoc');

                                                      if(!isset($koutei_im_sokuteidata_result[0])){

                                                        $connection->insert('koutei_im_sokuteidata_result', [
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

                                  }else{
                                   print_r('else ');
                                  }



                                $output_dir = 'backupData_工程_IMデータ/'.$folder;

                                  if (! file_exists($output_dir)) {//backupData_IM測定の中に$folderがないとき
                                   if (mkdir($output_dir)) {
                                      $Filebi2 = mb_substr($file,0,-4);
                                      if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."005.bi2", $output_dir.'/'.$Filebi2."005.bi2")) {
                                        //DBに登録KouteiFileCopyChecks

                                        $arrfiledate = [
                                  				'name_folder' => $folder,
                                  				'name_file' => $file,
                                  				'created_at' => date('Y-m-d H:i:s')
                                        ];

                                        $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->newEntity();
                                        $fileCopyCheck = $this->KouteiFileCopyChecks->patchEntity($KouteiFileCopyChecks, $arrfiledate);
                                        $this->KouteiFileCopyChecks->save($fileCopyCheck);

                                        fclose($fp);
                                        $fp = fopen('data_工程_IMデータ/'.$folder.'/'.$file, "r");
                                        $fpcount = fopen('data_工程_IMデータ/'.$folder.'/'.$file, 'r' );
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
                                          $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $KouteiFileCopyChecks[0]->id;

                                          $this->KouteiFileCopyChecks->updateAll(
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
                                          $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $KouteiFileCopyChecks[0]->id;

                                          $this->KouteiFileCopyChecks->updateAll(
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

                                      $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->newEntity();
                                      $fileCopyCheck = $this->KouteiFileCopyChecks->patchEntity($KouteiFileCopyChecks, $arrfiledate);
                                      $this->KouteiFileCopyChecks->save($fileCopyCheck);//KouteiFileCopyChecksテーブルに登録

                                      fclose($fp);
                                      $fp = fopen('data_工程_IMデータ/'.$folder.'/'.$file, "r");
                                      $fpcount = fopen('data_工程_IMデータ/'.$folder.'/'.$file, 'r' );
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
                                        $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $KouteiFileCopyChecks[0]->id;

                                        $this->KouteiFileCopyChecks->updateAll(//KouteiFileCopyChecksテーブルのcopy_statusを１に更新
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
                                        $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $KouteiFileCopyChecks[0]->id;

                                        $this->KouteiFileCopyChecks->updateAll(//KouteiFileCopyChecksテーブルのcopy_statusを９に更新
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


      $dirName = 'data_工程_2_IMデータ/';//webroot内のフォルダ

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

                        $product_code = $foldername[2];
                        $kind_kensa = $foldername[3];

                          while(($file = readdir($child_dir)) !== false){//子while
                               if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN

                                  $fp = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, "r");//kesuyatu

                                   if(substr($file, 0, 5) != "sumi_" ){//sumi_でないファイルだけOPEN
                                    $countname += 1;//ファイル名がかぶらないようにカウントしておく

                                    $fp = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, "r");//csvファイルはwebrootに入れる
                              			$this->set('fp',$fp);

                              			$fpcount = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, 'r' );
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
                                      $inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);

                                      $session = $this->request->session();
                                      $session->write('kind_kensa', $kind_kensa);

                                      $arrIm_heads[] = $product_code;
                                      $arrIm_heads[] = $kind_kensa;
                                      $arrIm_heads[] = $inspec_date;
                                      $arrIm_heads[] = ${"arruniLot_num".$countname}[$k-1];
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = date('Y-m-d H:i:s');

                                      $name_heads = array('product_code', 'kind_kensa', 'inspec_date', 'lot_num', 'torikomi', 'delete_flag', 'created_at');
                                      $arrIm_heads = array_combine($name_heads, $arrIm_heads);
                                      $arrIm_head[] = $arrIm_heads;
                                    }

                                    $KouteiImSokuteidataHead = $this->KouteiImSokuteidataHeads->patchEntities($this->KouteiImSokuteidataHeads->newEntity(), $arrIm_head);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                    $connection = ConnectionManager::get('default');//トランザクション1
                                    // トランザクション開始2
                                    $connection->begin();//トランザクション3
                                    try {//トランザクション4
                                      if ($this->KouteiImSokuteidataHeads->saveMany($KouteiImSokuteidataHead)) {

                                        $connection = ConnectionManager::get('DB_ikou_test');
                                        $table = TableRegistry::get('koutei_im_sokuteidata_head');
                                        $table->setConnection($connection);

                                        $connection->insert('koutei_im_sokuteidata_head', [
                                            'product_id' => $arrIm_head[0]['product_code'],
                                            'kind_kensa' => $arrIm_head[0]['kind_kensa'],
                                            'version' => 0,
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

                                            $KouteiImSokuteidataHeadsData = $this->KouteiImSokuteidataHeads->find()->where(['lot_num' => ${"arruniLot_num".$countname}[$m-1], 'kind_kensa' => $kind_kensa])->toArray();
                                            $im_sokuteidata_head_id = $KouteiImSokuteidataHeadsData[0]->id;

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
                                          $KouteiImKikakus = $this->KouteiImKikakus->newEntity();//newentityに$userという名前を付ける

                                          $KouteiImKikakus = $this->KouteiImKikakus->patchEntities($KouteiImKikakus, $arrIm_kikaku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                             if ($this->KouteiImKikakus->saveMany($KouteiImKikakus)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $table = TableRegistry::get('koutei_im_kikaku');
                                               $table->setConnection($connection);

                                               $sql = "SELECT id FROM koutei_im_sokuteidata_head".
                                               " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                 order by id desc limit 1";
                                               $connection = ConnectionManager::get('DB_ikou_test');
                                               $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                               for($k=0; $k<count($arrIm_kikaku); $k++){
                                                 $connection->insert('koutei_im_kikaku', [
                                                     'id' => $im_sokuteidata_head_id[0]["id"],
                                                     'size_num' => $arrIm_kikaku[$k]["size_num"],
                                                     'size' => $arrIm_kikaku[$k]["size"],
                                                     'upper' => $arrIm_kikaku[$k]["upper"],
                                                     'lower' => $arrIm_kikaku[$k]["lower"]
                                                 ]);
                                               }

                                               $connection = ConnectionManager::get('default');

                                                //KouteiImSokuteidataResultsの登録用データをセット
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

                                                      $KouteiImSokuteidataHeadsData = $this->KouteiImSokuteidataHeads->find()->where(['lot_num' => $arrFp[$j+4][2], 'kind_kensa' => $kind_kensa])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                                      $im_sokuteidata_head_id = $KouteiImSokuteidataHeadsData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

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
                                                  $KouteiImSokuteidataResults = $this->KouteiImSokuteidataResults->newEntity();//newentityに$userという名前を付ける

                                                  $KouteiImSokuteidataResults = $this->KouteiImSokuteidataResults->patchEntities($KouteiImSokuteidataResults, $arrIm_Result);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                                  if ($this->KouteiImSokuteidataResults->saveMany($KouteiImSokuteidataResults)) {//ImSokuteidataResultsをsaveできた時（saveManyで一括登録）

                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $table = TableRegistry::get('koutei_im_sokuteidata_result');
                                                    $table->setConnection($connection);

                                                    $sql = "SELECT id FROM koutei_im_sokuteidata_head".
                                                    " where product_id = '".$arrIm_head[0]["product_code"]."' and kind_kensa = '".$arrIm_head[0]["kind_kensa"]."'
                                                     and inspec_date = '".$arrIm_head[0]["inspec_date"]."' and lot_num = '".$arrIm_head[0]["lot_num"]."'
                                                      order by id desc limit 1";
                                                    $connection = ConnectionManager::get('DB_ikou_test');
                                                    $im_sokuteidata_head_id = $connection->execute($sql)->fetchAll('assoc');

                                                    for($k=0; $k<count($arrIm_Result); $k++){

                                                      $sql = "SELECT id FROM koutei_im_sokuteidata_result".
                                                      " where id = '".$im_sokuteidata_head_id[0]["id"]."' and inspec_datetime = '".$arrIm_Result[$k]["inspec_datetime"]."'
                                                       and serial = '".$arrIm_Result[$k]["serial"]."' and size_num = '".$arrIm_Result[$k]["size_num"]."'
                                                        order by id desc limit 1";
                                                      $connection = ConnectionManager::get('DB_ikou_test');
                                                      $koutei_im_sokuteidata_result = $connection->execute($sql)->fetchAll('assoc');

                                                      if(!isset($koutei_im_sokuteidata_result[0])){

                                                        $connection->insert('koutei_im_sokuteidata_result', [
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

                                  }else{
                                   print_r('else ');
                                  }


                                $output_dir = 'backupData_工程_2_IMデータ/'.$folder;

                                  if (! file_exists($output_dir)) {//backupData_IM測定の中に$folderがないとき
                                   if (mkdir($output_dir)) {
                                      $Filebi2 = mb_substr($file,0,-4);
                                      if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."110.bi3", $output_dir.'/'.$Filebi2."110.bi3")) {
                                        //DBに登録KouteiFileCopyChecks

                                        $arrfiledate = [
                                  				'name_folder' => $folder,
                                  				'name_file' => $file,
                                  				'created_at' => date('Y-m-d H:i:s')
                                        ];

                                        $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->newEntity();
                                        $fileCopyCheck = $this->KouteiFileCopyChecks->patchEntity($KouteiFileCopyChecks, $arrfiledate);
                                        $this->KouteiFileCopyChecks->save($fileCopyCheck);

                                        fclose($fp);
                                        $fp = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, "r");
                                        $fpcount = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, 'r' );
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
                                          $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $KouteiFileCopyChecks[0]->id;

                                          $this->KouteiFileCopyChecks->updateAll(
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
                                          $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                          $id = $KouteiFileCopyChecks[0]->id;

                                          $this->KouteiFileCopyChecks->updateAll(
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

                                      $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->newEntity();
                                      $fileCopyCheck = $this->KouteiFileCopyChecks->patchEntity($KouteiFileCopyChecks, $arrfiledate);
                                      $this->KouteiFileCopyChecks->save($fileCopyCheck);//KouteiFileCopyChecksテーブルに登録

                                      fclose($fp);
                                      $fp = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, "r");
                                      $fpcount = fopen('data_工程_2_IMデータ/'.$folder.'/'.$file, 'r' );
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
                                        $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $KouteiFileCopyChecks[0]->id;

                                        $this->KouteiFileCopyChecks->updateAll(//KouteiFileCopyChecksテーブルのcopy_statusを１に更新
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
                                        $KouteiFileCopyChecks = $this->KouteiFileCopyChecks->find()->where(['name_folder' => $folder, 'name_file' => $file, 'copy_status' => 0])->toArray();
                                        $id = $KouteiFileCopyChecks[0]->id;

                                        $this->KouteiFileCopyChecks->updateAll(//KouteiFileCopyChecksテーブルのcopy_statusを９に更新
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
*/

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

   public function preadd()
   {
     $this->set('KouteiKensahyouHeads',$this->KouteiKensahyouHeads->newEntity());
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
//    $this->request->session()->destroy(); // セッションの破棄
  }

      public function do()
     {
       $this->set('KouteiKensahyouHeads',$this->KouteiKensahyouHeads->newEntity());

       $session = $this->request->getSession();
       $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

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
         $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->patchEntity($this->KouteiKensahyouHeads->newEntity(), $data);//$kensahyouHeadデータ（空の行）を$this->request->getData()に更新する
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
           if ($this->KouteiKensahyouHeads->save($KouteiKensahyouHeads)) {//saveできた時

             //旧DBに登録
             $connection = ConnectionManager::get('DB_ikou_test');
             $table = TableRegistry::get('koutei_kensahyou_head');
             $table->setConnection($connection);

               $connection->insert('koutei_kensahyou_head', [
                 'product_id' => $data['product_code'],
                 'version' => $data['version'],
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
                 'created_emp_id' => $data['created_staff'],
               ]);

               $connection = ConnectionManager::get('default');//新DBに戻る
               $table->setConnection($connection);

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
//       $this->request->session()->destroy(); // セッションの破棄

       $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->get($id);
       $this->set('KouteiKensahyouHeads', $KouteiKensahyouHeads);//$kensahyouHeadをctpで使えるようにセット

       $product_code = $KouteiKensahyouHeads['product_code'];//product_idという名前のデータに$product_idと名前を付ける
       $this->set('product_code',$product_code);//セット
       $this->set('Productcode',$product_code);//セット

       $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
      	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
      	$this->set('Productname',$Productname);//セット

       $KensaProduct = $this->KouteiKensahyouHeads->find()->where(['product_code' => $product_code ,'delete_flag' => '0'])->order(["version"=>"desc"])->toArray();
       $KensaProductV = $KensaProduct[0]->version;
       $newversion = $KensaProductV + 1;
       $this->set('newversion',$newversion);

       $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
       $this->set('arrType',$arrType);
     }

     public function imtaiouedit($id = null)
     {
    //   $this->request->session()->destroy(); // セッションの破棄

       if(!isset($_SESSION)){
       session_start();
       }
       $_SESSION['kikakudata'] = array();

       $KouteiImKikakuTaious = $this->KouteiImKikakuTaious->get($id);
       $this->set('KouteiImKikakuTaious', $KouteiImKikakuTaious);//$kensahyouHeadをctpで使えるようにセット

       $KouteiKensahyouHeadid = $KouteiImKikakuTaious['id'];//product_idという名前のデータに$product_idと名前を付ける
       $this->set('KouteiKensahyouHeadid',$KouteiKensahyouHeadid);//セット
/*
       echo "<pre>";
       print_r($KouteiKensahyouHeadid);
       echo "</pre>";
*/
       $product_code = $KouteiImKikakuTaious['product_code'];//product_idという名前のデータに$product_idと名前を付ける
       $this->set('product_code',$product_code);//セット
       $this->set('Productcode',$product_code);//セット

       $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
       $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
       $this->set('Productname',$Productname);//セット

       $newversion = $KouteiImKikakuTaious['version'] + 1;
       $this->set('newversion',$newversion);

       $arrType = ['0' => 'IM6120(1号機)', '1' => 'IM7000(2号機)'];
       $this->set('arrType',$arrType);

       $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
       $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
       $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

       $KouteiImSokuteidataHeads = $this->KouteiImSokuteidataHeads->find()
      ->where(['product_code' => $product_code])->toArray();

       $arrKindKensa = array("","ノギス");//配列の初期化
        foreach ($KouteiImSokuteidataHeads as $value) {//それぞれに対して
           $arrKindKensa[] = $value->kind_kensa;//配列に追加
        }
         $arrKindKensa = array_unique($arrKindKensa);

         $arr_shape_detection = [
           null => '',
           '0' => '寸法',
           '1' => 'IM形状'
                ];
        $this->set('arr_shape_detection',$arr_shape_detection);
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
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

      $this->set('entity',$this->KouteiImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
     }

     public function editconfirm()
    {
      $data = $this->request->getData();//postで送られた全データを取得

      $id = $data['id'];
      $this->set('id',$id);//セット

      $product_code = $data['product_code'];//product_idという名前のデータに$product_idと名前を付ける
      $this->set('product_code',$product_code);//セット

      $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
      $this->set('KouteiKensahyouHeads',$KouteiKensahyouHeads);//セット

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Product
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
 	}

      public function imtaioueditpreadd()
      {
        $this->set('entity',$this->KouteiImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

        $session = $this->request->getSession();
        $data = $session->read();//postデータ取得し、$dataと名前を付ける
      }

 		public function editlogin()
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
            return $this->redirect(['action' => 'editdo']);
          }
        }
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


   public function editdo()
  {
    $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
    $this->set('KouteiKensahyouHeads',$KouteiKensahyouHeads);//セット

    $session = $this->request->getSession();
    $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

    $created_staff = array('updated_staff'=>$this->Auth->user('staff_id'));
    $_SESSION['sokuteidata'] = array_merge($created_staff,$_SESSION['sokuteidata']);

    $data = $_SESSION['sokuteidata'];
    $kousinn_flag = $_SESSION['kousinn_flag']['kousinn_flag'];
/*
    echo "<pre>";
    print_r($kousinn_flag);
    echo "</pre>";
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

    for($i=1; $i<=9; $i++){
      if(empty($data["size_".$i])){
        $data["size_".$i] = null;
      }
   }

   for($j=1; $j<=8; $j++){
      if(empty($data["upper_".$j])){
        $data["upper_".$j] = null;
      }
      if(empty($data["lower_".$j])){
        $data["lower_".$j] = null;
      }
   }

    for($i=10; $i<=11; $i++){
      if(empty($data["text_".$i])){
        $data["text_".$i] = null;
      }
   }

   $Productcode = $data["product_code"];
   $this->set('Productcode',$Productcode);//セット
   $Product = $this->Products->find()->where(['product_code' => $Productcode])->toArray();
   $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
   $this->set('Productname',$Productname);//セット

       if ($kousinn_flag == 1) {
        $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->patchEntity($KouteiKensahyouHeads, $this->request->getData());
        $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->KouteiKensahyouHeads->updateAll(//
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
           $connection = ConnectionManager::get('DB_ikou_test');
           $table = TableRegistry::get('koutei_kensahyou_head');
           $table->setConnection($connection);

           $versionmoto = $data['version'] - 1;

           for($i=1; $i<=9; $i++){
             if(!empty($data["size_".$i])){
               $updater = "UPDATE koutei_kensahyou_head set size_$i ='".$data["size_".$i]."'
               where product_id ='".$Productcode."' and version ='".$versionmoto."'";
               $connection->execute($updater);
             }
          }

          for($i=1; $i<=9; $i++){
            if(!empty($data["upper_".$i])){
              $updater = "UPDATE koutei_kensahyou_head set upper_$i ='".$data["upper_".$i]."'
              where product_id ='".$Productcode."' and version ='".$versionmoto."'";
              $connection->execute($updater);
            }
         }

         for($i=1; $i<=9; $i++){
           if(!empty($data["lower_".$i])){
             $updater = "UPDATE koutei_kensahyou_head set lower_$i ='".$data["lower_".$i]."'
             where product_id ='".$Productcode."' and version ='".$versionmoto."'";
             $connection->execute($updater);
           }
        }

        for($i=10; $i<=11; $i++){
          if(empty($data["text_".$i])){
            $updater = "UPDATE koutei_kensahyou_head set text_$i ='".$data["text_".$i]."'
            where product_id ='".$Productcode."' and version ='".$versionmoto."'";
            $connection->execute($updater);
          }
       }

           $updater = "UPDATE koutei_kensahyou_head set type_im ='".$data['type_im']."',
           bik ='".$data['bik']."', updated_at ='".date('Y-m-d H:i:s')."', updated_emp_id ='".$data['updated_staff']."'
           where product_id ='".$Productcode."' and version ='".$versionmoto."'";
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

        $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->patchEntity($KouteiKensahyouHeads, $this->request->getData());
        $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
          if ($this->KouteiKensahyouHeads->updateAll(
           ['status' => 1, 'delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data['updated_staff']],
           ['id'  => $data['id']]
         )){

           $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->patchEntity($this->KouteiKensahyouHeads->newEntity(), $tourokuData);
           $this->KouteiKensahyouHeads->save($KouteiKensahyouHeads);

           $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->find()->where(['id' => $data['id']])->toArray();

           //旧DBに登録
           $connection = ConnectionManager::get('DB_ikou_test');
           $table = TableRegistry::get('koutei_kensahyou_head');
           $table->setConnection($connection);

           $delete_flag = 1;
           $versionmoto = $data['version'] - 1;
           $updater = "UPDATE koutei_kensahyou_head set status ='".$delete_flag."'
           where product_id ='".$Productcode."' and version ='".$versionmoto."'";
           $connection->execute($updater);

             $connection->insert('koutei_kensahyou_head', [
               'product_id' => $Productcode,
               'version' => $data['version'],
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
               'status' => 0,
               'created_at' => date('Y-m-d H:i:s'),
               'created_emp_id' => $data['updated_staff']
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

      public function imtaioueditdo()
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
      $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderkouteidata($product_code);//
      $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

      $KouteiImKikakuTaious = $this->KouteiImKikakuTaious->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
      $this->set('KouteiImKikakuTaious',$KouteiImKikakuTaious);//セット

      $count = count($data);
      for($k=1; $k<=$count; $k++){

        if(!empty($data[$k]["kind_kensa"]) && !empty($data[$k]["im_size_num"])){

          $staff_id = $sessiondata['Auth']['User']['staff_id'];//ログイン中のuserのstaff_idに$staff_idという名前を付ける
          $data[$k]['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

          if($data["{$k}"]["shape_detection"] == 0){
            ${"shape_detection_".$k} = "寸法";
            $this->set('shape_detection_'.$k,${"shape_detection_".$k});//セット
          }elseif($data["{$k}"]["shape_detection"] == 1){
            ${"shape_detection_".$k} = "IM形状";
            $this->set('shape_detection_'.$k,${"shape_detection_".$k});//セット
          }

        }else{
          unset($data[$k]);
          ${"shape_detection_".$k} = "";
          $this->set('shape_detection_'.$k,${"shape_detection_".$k});//セット

        }

      }

      $data = array_values($data);
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
          if ($data[0]['status'] == 1) {
/*
           $KouteiKensahyouHeads = $this->KouteiKensahyouHeads->patchEntity($KouteiKensahyouHeads, $this->request->getData());
           $connection = ConnectionManager::get('default');//トランザクション1
             // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
             if ($this->KouteiKensahyouHeads->updateAll(//検査終了時間の更新
              ['delete_flag' => $data['delete_flag'],'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data['updated_staff']],
              ['id'  => $data['id']]
            )){
               $mes = "※削除しました";
                $this->set('mes',$mes);
                $connection->commit();// コミット5
             } else {
               $mes = "※削除されませんでした";
                $this->set('mes',$mes);
                $this->Flash->error(__('The product could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
             }
           } catch (Exception $e) {//トランザクション7
           //ロールバック8
             $connection->rollback();//トランザクション9
           }//トランザクション10

*/
         }else{

           $KouteiKensahyouHeads = $this->KouteiImKikakuTaious->patchEntity($KouteiImKikakuTaious, $this->request->getData());
           $connection = ConnectionManager::get('default');//トランザクション1
             // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4

             $KouteiImKikakuTaiou = $this->KouteiImKikakuTaious->find()->where(['product_code' => $product_code, 'status' => '0'])->toArray();

             for($k=0; $k<count($KouteiImKikakuTaiou); $k++){

               ${"id".$k} = $KouteiImKikakuTaiou[$k]->id;

               $this->KouteiImKikakuTaious->updateAll(
                 ['status' => 1, 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $data[0]['created_staff']],
                 ['id'  => ${"id".$k}]
               );

             }

              $KouteiImKikakuTaious = $this->KouteiImKikakuTaious->patchEntities($this->KouteiKensahyouHeads->newEntity(), $data);
              $this->KouteiImKikakuTaious->saveMany($KouteiImKikakuTaious);

              //旧DB更新
              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('koutei_im_kikaku_taiou');
              $table->setConnection($connection);

              $statusmoto = 0;
              $status = 1;
              $updater = "UPDATE koutei_im_kikaku_taiou set status = '".$status."'
              , updated_at = '".date('Y-m-d H:i:s')."' , updated_emp_id = '".$data[0]['created_staff']."'
              where product_id ='".$product_code."' and status ='".$statusmoto."'";
              $connection->execute($updater);

              for($k=0; $k<count($data); $k++){
                $connection->insert('koutei_im_kikaku_taiou', [
                  'product_id' => $data[$k]["product_code"],
                  'version' => $data[$k]["version"],
                  'kensahyou_size' => $data[$k]["kensahyou_size"],
                  'kind_kensa' => $data[$k]["kind_kensa"],
                  'im_size_num' => $data[$k]["im_size_num"],
                  'shape_detection' => $data[$k]["shape_detection"],
                  'status' => $data[$k]["status"],
                  'created_at' => date('Y-m-d H:i:s'),
                  'created_emp_id' => $data[$k]["created_staff"]
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
