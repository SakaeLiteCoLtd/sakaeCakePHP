<?php
namespace App\myClass\KensahyouSokuteidata;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlKensahyouSokuteidata extends AppController
{
     public function initialize()
    {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
         $this->Customers = TableRegistry::get('customers');
         $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
         $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');
         $this->KouteiKensahyouHeads = TableRegistry::get('kouteiKensahyouHeads');
    }

	public function htmlHeaderKensahyouSokuteidata($product_code)
	{
        $html =
                  "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
                  "<td width='100' colspan='4'>&nbsp;</td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>A</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>B</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>C</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>D</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>E</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>F</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>G</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>H</strong></div></td>\n".
                  "<td width='80' nowrap='nowrap' colspan='2'><div align='center'><font size='-3'><strong>ソリ・フレ</strong></font></div></td>\n".
                  "<td width='80' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>\n".
                  "<td width='80' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>\n".
                  "<td width='100' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>単重</strong></font></div></td>\n".
                  "</tr>\n".
                  "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
                  "<td valign='middle' width='50' rowspan='3' nowrap='nowrap' colspan='2' style='valign: middle'><div align='center'><strong>規格</strong></div></td>\n".
                  "<td width='50' nowrap='nowrap' colspan='2'><div align='center'><strong>上限</strong></div></td>\n";

            $KensahyouHeads = $this->KensahyouHeads->find('all', ['conditions' => ['product_code' => $product_code, 'delete_flag' => 0]])->order(['id' => 'ASC']);//
      			foreach ($KensahyouHeads as $value) {
      			}

            for($l=1; $l<=8; $l++){
              if(isset($value)){
                $upper= $value->{"upper_{$l}"};
              }else{
                $upper= "";
              }
      //  		$upper= $value->{"upper_{$l}"};
            $html = $html.
                    "<td colspan='2'><div align='center'>\n";
            $html = $html.$upper;
            $html = $html."</div></td>\n";
            }

        $html = $html.
        "<td colspan='2'><div align='center'></div></td>\n".
        "<td colspan='2'><div align='center'></div></td>\n".
        "<td colspan='2'><div align='center'></div></td>\n".
        "<td rowspan='3' colspan='2'>&nbsp;</td>\n".
          "</tr>\n".
          "<tr>\n".
          "<td nowrap='nowrap' colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><strong>下限</strong></div></td>\n";

            for($l=1; $l<=8; $l++){
              if(isset($value)){
                $lower= $value->{"lower_{$l}"};
              }else{
                $lower= "";
              }
    //    		$lower= $value->{"lower_{$l}"};
                $html = $html.
                        "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><font size='-1'>\n";
                $html = $html.$lower;
                $html = $html."</font></div></td>\n";
            }

        $html = $html.
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "</tr>\n".
          "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
          "<td nowrap='nowrap' colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><strong>寸法</strong></div></td>\n";

            for($l=1; $l<=9; $l++){
              if(isset($value)){
                $size= $value->{"size_{$l}"};
                $text_10 = $value->text_10;
                $text_11 = $value->text_11;
              }else{
                $size= "";
                $text_10= "";
                $text_11= "";
              }
      //  		$size= $value->{"size_{$l}"};
                $html = $html.
                        "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
                $html = $html.$size;
                $html = $html."</div></td>\n";
            }
            $html = $html.
  //          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
  //          "<td colspan='2'><div align='center'></div></td>\n";
            "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
            $html = $html.$text_10;
            $html = $html."</div></td>\n";
            $html = $html.
            "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
            $html = $html.$text_11;
            $html = $html."</div></td>\n";

/*
        $html = $html.
        "</tr>\n".
        "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
          "<td width='24' colspan='4'><div align='center'><strong>検査種類</strong></div></td>\n".
          "<td width='24' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td colspan='2'>&nbsp;</td>\n".
          "<td colspan='2'>&nbsp;</td>\n".
        "</tr>\n";
*/
		return $html;
		$this->html = $html;
		$this->data = $KensahyouHeads;
	}

  public function htmlHeaderkouteidata($product_code)
	{
        $html =
                  "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
                  "<td width='100' colspan='4'>&nbsp;</td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>A</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>B</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>C</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>D</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>E</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>F</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>G</strong></div></td>\n".
                  "<td width='50' colspan='2'><div align='center'><strong>H</strong></div></td>\n".
                  "<td width='80' nowrap='nowrap' colspan='2'><div align='center'><font size='-3'><strong>ソリ・フレ</strong></font></div></td>\n".
                  "<td width='80' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観１</strong></font></div></td>\n".
                  "<td width='80' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>外観２</strong></font></div></td>\n".
                  "<td width='100' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>単重</strong></font></div></td>\n".
                  "</tr>\n".
                  "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
                  "<td valign='middle' width='50' rowspan='3' nowrap='nowrap' colspan='2' style='valign: middle'><div align='center'><strong>規格</strong></div></td>\n".
                  "<td width='50' nowrap='nowrap' colspan='2'><div align='center'><strong>上限</strong></div></td>\n";

            $KensahyouHeads = $this->KouteiKensahyouHeads->find('all', ['conditions' => ['product_code' => $product_code, 'delete_flag' => 0]])->order(['id' => 'ASC']);//
      			foreach ($KensahyouHeads as $value) {
      			}

            for($l=1; $l<=8; $l++){
              if(isset($value)){
                $upper= $value->{"upper_{$l}"};
              }else{
                $upper= "";
              }
      //  		$upper= $value->{"upper_{$l}"};
            $html = $html.
                    "<td colspan='2'><div align='center'>\n";
            $html = $html.$upper;
            $html = $html."</div></td>\n";
            }

        $html = $html.
        "<td colspan='2'><div align='center'></div></td>\n".
        "<td colspan='2'><div align='center'></div></td>\n".
        "<td colspan='2'><div align='center'></div></td>\n".
        "<td rowspan='3' colspan='2'>&nbsp;</td>\n".
          "</tr>\n".
          "<tr>\n".
          "<td nowrap='nowrap' colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><strong>下限</strong></div></td>\n";

            for($l=1; $l<=8; $l++){
              if(isset($value)){
                $lower= $value->{"lower_{$l}"};
              }else{
                $lower= "";
              }
    //    		$lower= $value->{"lower_{$l}"};
                $html = $html.
                        "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><font size='-1'>\n";
                $html = $html.$lower;
                $html = $html."</font></div></td>\n";
            }

        $html = $html.
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "</tr>\n".
          "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
          "<td nowrap='nowrap' colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><strong>寸法</strong></div></td>\n";

            for($l=1; $l<=9; $l++){
              if(isset($value)){
                $size= $value->{"size_{$l}"};
                $text_10 = $value->text_10;
                $text_11 = $value->text_11;
              }else{
                $size= "";
                $text_10= "";
                $text_11= "";
              }
      //  		$size= $value->{"size_{$l}"};
                $html = $html.
                        "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
                $html = $html.$size;
                $html = $html."</div></td>\n";
            }
            $html = $html.
  //          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
  //          "<td colspan='2'><div align='center'></div></td>\n";
            "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
            $html = $html.$text_10;
            $html = $html."</div></td>\n";
            $html = $html.
            "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
            $html = $html.$text_11;
            $html = $html."</div></td>\n";

/*
        $html = $html.
        "</tr>\n".
        "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
          "<td width='24' colspan='4'><div align='center'><strong>検査種類</strong></div></td>\n".
          "<td width='24' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td width='38' colspan='2'><div align='center'><strong>ノギス</strong></div></td>\n".
          "<td colspan='2'>&nbsp;</td>\n".
          "<td colspan='2'>&nbsp;</td>\n".
        "</tr>\n";
*/
		return $html;
		$this->html = $html;
		$this->data = $KensahyouHeads;
	}

  public function Pana0()
 {
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

   return $arrProduct;
 }

 public function Pana1()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    if(0 === strpos($product_code, "P1")){
      $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code, 'customer_id' => 1]])->toArray();
      if(isset($Products[0])){
        $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
      }
    }
  }

  return $arrProduct;
}

public function Pana2()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    if(0 !== strpos($product_code, "P0") && 0 !== strpos($product_code, "P1") && 0 !== strpos($product_code, "W") && 0 !== strpos($product_code, "H") && 0 !== strpos($product_code, "RE")){
      $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code, 'customer_id' => 1]])->toArray();
      if(isset($Products[0])){
        $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
      }
    }
  }

 return $arrProduct;
}

public function PanaW()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    if(false !== strpos($product_code, "W")){
      $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code, 'customer_id' => 2]])->toArray();
      if(isset($Products[0])){
        $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
      }
    }
  }

 return $arrProduct;
}

public function PanaH()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    if(0 === strpos($product_code, "H")){
      $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code, 'customer_id' => 2]])->toArray();
      if(isset($Products[0])){
        $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
      }
    }
  }

 return $arrProduct;
}

public function PanaRE()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    if(0 === strpos($product_code, "R")){
      $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code, 'customer_id' => 3]])->toArray();
      if(isset($Products[0])){
        $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
      }
    }
  }

 return $arrProduct;
}

public function Dnp()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code,
    'OR' => [['customer_id' => 11], ['customer_id' => 12], ['customer_id' => 13], ['customer_id' => 14]]]])->toArray();
    if(isset($Products[0])){
      $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
    }
  }

 return $arrProduct;
}

public function Others()
{
  $Sokuteidataproduct_code = $this->KensahyouSokuteidatas->find()
  ->select(['product_code','delete_flag' => '0'])
  ->group('product_code')->toArray();

  $count = count($Sokuteidataproduct_code);

  $arrProduct = array();

  for ($k=0; $k<$count; $k++) {
    $product_code = $Sokuteidataproduct_code[$k]["product_code"];
    $Products = $this->Products->find('all', ['conditions' => ['product_code' => $product_code]])->toArray();
    if(isset($Products[0])){
      $customer_id = $Products[0]->customer_id;
      $Customers = $this->Customers->find('all', ['conditions' => ['id' => $customer_id]])->toArray();
      $customer_code = $Customers[0]->customer_code;
      if(0 !== strpos($customer_code, "1") && 0 !== strpos($customer_code, "2")){
        $arrProduct[] = ["product_code" => $Products[0]["product_code"], "product_name" => $Products[0]["product_name"]];
      }
    }
  }

 return $arrProduct;
}

	public function get_rows(){
		return $this->rows;
		}

	public function get_html(){
		return $this->html;
		}

}

?>
