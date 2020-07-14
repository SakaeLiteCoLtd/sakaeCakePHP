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

  public function denpyomenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/orderEdis/denpyouhattyu'>\n".
        "<img src='/img/Labelimg/order.gif' width=105 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function accountmenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/urikakemenu'>\n".
        "<img src='/img/Labelimg/account_menu_urikake.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/productkaikakemenu'>\n".
        "<img src='/img/Labelimg/accountMenuProductKaikake.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/materialkaikakemenu'>\n".
        "<img src='/img/Labelimg/accountMenuMaterialKaikake.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yusyouzaimenu'>\n".
        "<img src='/img/Labelimg/accountMenuYusyouzai.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/soukomenu'>\n".
        "<img src='/img/Labelimg/accountMenuSouko.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/pricemenu'>\n".
        "<img src='/img/Labelimg/accountMenuPrice.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function urikakemenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/urikakeform'>\n".
        "<img src='/img/Labelimg/account_urikake_touroku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/urikakekensakuform'>\n".
        "<img src='/img/Labelimg/account_urikake_kensaku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/materialurikakeform'>\n".
        "<img src='/img/Labelimg/accountGenryouUrikake.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/materialurikakekensakuform'>\n".
        "<img src='/img/Labelimg/accountGenryouKensaku.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function kaikakemenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/productkaikakeform'>\n".
        "<img src='/img/Labelimg/accountProductKaikakeTouroku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/productkaikakekensakuform'>\n".
        "<img src='/img/Labelimg/accountProductKaikakeKensaku.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function materialkaikakemenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/materialkaikakeform'>\n".
        "<img src='/img/Labelimg/accountMaterialKaikakeTouroku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/materialkaikakekensakuform'>\n".
        "<img src='/img/Labelimg/accountMaterialKaikakeKensaku.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function yusyouzaimenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountYusyouzaiUkeire.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountYusyouzaiUkeireKensaku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountYusyouzaiMaster.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountYusyouzaiMasterKensaku.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/deliverform'>\n".
        "<img src='/img/Labelimg/accountYusyouzaiGaityu.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function soukomenus()
	{
        $html =
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/deliverform'>\n".
        "<img src='/img/Labelimg/subSubKensaku.gif' width=85 height=36>\n".
        "</a>\n";

		return $html;
		$this->html = $html;
		$this->data = $shinkimenus;
	}

  public function pricemenus()
	{
        $html =
/*        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountProductPriceMaster.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountProductPriceOrder.gif' width=85 height=36>\n".
        "</a>\n".
*/
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/yobidashi'>\n".
        "<img src='/img/Labelimg/accountMaterialPriceMaster.gif' width=85 height=36>\n".
        "</a>\n".
        "<td style='padding: 0.1rem 0.1rem;'><a href='/accounts/deliverform'>\n".
        "<img src='/img/Labelimg/accountMaterialPriceOrder.gif' width=85 height=36>\n".
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
