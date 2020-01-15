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
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/staffs/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/shinki_staff.gif' width=105 height=36>\n".
                  "</a></td>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/users/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/shinki_user.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/customers/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/TourokuCustomer.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/delivers/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/teikyougif.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/customers-handy/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/kanikakyaku.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/suppliers/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/touroku_supplier.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/supplier-sections/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/gaityuukubungif.gif' width=105 height=36>\n".
                  "</a></tr>\n".
                  "<tr style='background-color: #E6FFFF'>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/material-types/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/genryoutaipu.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/materials/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/touroku_genryou.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/price-materials/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/genryoukakaku.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/products/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/seihinntouroku.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/price-products/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/seihinnkakaku.gif' width=105 height=36>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/roles/index'>\n".
                  "<img src='/img/ShinkiTourokuMenu/kenngenntouroku.gif' width=105 height=36>\n".
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
