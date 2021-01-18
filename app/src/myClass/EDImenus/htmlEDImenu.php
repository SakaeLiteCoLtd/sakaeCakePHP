<?php
namespace App\myClass\EDImenus;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlEDImenu extends AppController
{
     public function initialize()
    {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
    }

     public function EDImenus()//ピンクのメニュー
  	{
        $html =
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/indexmenu'>\n".
                  "<img src='/img/Labelimg/edi_sub_order.gif' width=115 height=40>\n".
                  "</a></td>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/StockProducts/yobidashicustomer'>\n".
                  "<img src='/img/Labelimg/edi_sub_touroku.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/henkoutop'>\n".
                  "<img src='/img/Labelimg/edi_sub_henkou.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/index'>\n".
                  "<img src='/img/Labelimg/edi_sub_syuyou.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/index0'>\n".
                  "<img src='/img/Labelimg/edi_sub_productions.gif' width=115 height=40>\n".
                  "</a>\n";

    		return $html;
    		$this->html = $html;
    		$this->data = $EDImenus;
  	}

    public function EDIsubmenus()//黄色のメニュー
   {
       $html =
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/hattyucsvpreadd'>\n".
                 "<img src='/img/Labelimg/edi_csv.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/dnpcsvpreadd'>\n".
                 "<img src='/img/Labelimg/dnp_csv.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/keikakucsvpreadd'>\n".
                 "<img src='/img/Labelimg/keikaku_csv.gif' width=85 height=36>\n".
                 "</a>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/chokusetsuformpro'>\n".
                 "<img src='/img/Labelimg/touroku_tyokusetsu.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/OrderEdis/hasuform'>\n".
                 "<img src='/img/Labelimg/another_ryousan.gif' width=85 height=36>\n".
                 "</a>\n";

       return $html;
       $this->html = $html;
       $this->data = $EDIsubmenus;
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
