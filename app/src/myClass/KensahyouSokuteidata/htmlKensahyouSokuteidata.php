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
         $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
    }

	public function htmlHeaderKensahyouSokuteidata($product_id)
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
                  "<td width='100' nowrap='nowrap' colspan='2'><div align='center'><font size='-1'><strong>単重</strong></font></div></td>\n".
                "</tr>\n".
                "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
                  "<td valign='middle' width='50' rowspan='3' nowrap='nowrap' colspan='2' style='valign: middle'><div align='center'><strong>規格</strong></div></td>\n".
                  "<td width='50' nowrap='nowrap' colspan='2'><div align='center'><strong>上限</strong></div></td>\n";

            $KensahyouHeads = $this->KensahyouHeads->find('all', ['conditions' => ['product_id' => $product_id]])->order(['id' => 'ASC']);//
			foreach ($KensahyouHeads as $value) {
			}

            for($l=1; $l<=8; $l++){
        		$upper= $value->{"upper_{$l}"};//
                $html = $html.
                        "<td colspan='2'><div align='center'>\n";
                $html = $html.$upper;
                $html = $html."</div></td>\n";
            }

        $html = $html.
          "<td colspan='2'><div align='center'></div></td>\n".
          "<td rowspan='3' colspan='2'>&nbsp;</td>\n".
          "</tr>\n".
          "<tr>\n".
          "<td nowrap='nowrap' colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><strong>下限</strong></div></td>\n";

            for($l=1; $l<=8; $l++){
        		$lower= $value->{"lower_{$l}"};//
                $html = $html.
                        "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
                $html = $html.$lower;
                $html = $html."</div></td>\n";
            }

        $html = $html.
          "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'></div></td>\n".
          "</tr>\n".
          "<tr style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'>\n".
          "<td nowrap='nowrap' colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'><strong>寸法</strong></div></td>\n";

            for($l=1; $l<=9; $l++){
        		$size= $value->{"size_{$l}"};//
                $html = $html.
                        "<td colspan='2' style='background-color: #FFFFFF;border-bottom: solid;border-width: 1px'><div align='center'>\n";
                $html = $html.$size;
                $html = $html."</div></td>\n";
            }

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

		return $html;
		$this->html = $html;
		$this->data = $KensahyouHeads;
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