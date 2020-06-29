<?php
namespace App\myClass\Shinkimenus;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlShinkimenu extends AppController
{
     public function initialize()
    {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
         $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
    }

	public function Shinkimenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/customers/form'>\n".
        "<img src='/img/ShinkiTourokuMenu/TourokuCustomer.gif' width=105 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/products/form'>\n".
        "<img src='/img/ShinkiTourokuMenu/seihinntouroku.gif' width=105 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/products/productyobidasiform'>\n".
        "<img src='/img/ShinkiTourokuMenu/yobidashi_seihin.gif' width=105 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/products/konpouyobidasiform'>\n".
        "<img src='/img/ShinkiTourokuMenu/konpou_irisu.gif' width=105 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/products/priceyobidasiform'>\n".
        "<img src='/img/ShinkiTourokuMenu/shinki_tanka.gif' width=105 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function customermenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/customers/form'>\n".
        "<img src='/img/Labelimg/subTouroku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/customers/yobidashi'>\n".
        "<img src='/img/Labelimg/subYobidashi.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/customers/deliverform'>\n".
        "<img src='/img/Labelimg/subDeliverToutoku.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
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
