<?php
namespace App\myClass\Labelmenus;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlLabelmenu extends AppController
{
     public function initialize()
    {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
    }

     public function Labelmenus()
  	{
        $html =
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/labelhakkoumenu'>\n".
                  "<img src='/img/Labelimg/label_hakkou.gif' width=115 height=40>\n".
                  "</a></td>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/lotmenu'>\n".
                  "<img src='/img/Labelimg/label_lot.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/genzaijoukyoumenu'>\n".
                  "<img src='/img/Labelimg/label_genzai.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/indexShinki'>\n".//ctpの名前は、index_shinki.ctp
                  "<img src='/img/Labelimg/label_shinki.gif' width=115 height=40>\n".
                  "</a>\n";

    		return $html;
    		$this->html = $html;
    		$this->data = $labelmenus;
  	}

    public function LabelLabelsubmenus()
   {
       $html =
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/ikkatsupreadd'>\n".
                 "<img src='/img/Labelimg/label_ikkatsu.gif' width=85 height=36>\n".
                 "</a></td>\n".
      //           "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/kobetujikanform'>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/kobetujikanformpreadd'>\n".
                 "<img src='/img/Labelimg/label_kobetsu_seikei_t.gif' width=85 height=36>\n".
                 "</a>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/kobetuformpreadd'>\n".
                 "<img src='/img/Labelimg/label_kobetsu.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/hasupreadd'>\n".
                 "<img src='/img/Labelimg/label_hasu.gif' width=85 height=36>\n".
                 "</a>\n";

       return $html;
       $this->html = $html;
       $this->data = $labelLabelsubmenus;
   }

   public function LabelLotsubmenus()
  {
      $html =
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/torikomipreadd'>\n".
                "<img src='/img/Labelimg/lot_rireki_torikomi.gif' width=85 height=36>\n".
                "</a></td>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/fushiyouMenu'>\n".
                "<img src='/img/Labelimg/label_fushiyou.gif' width=85 height=36>\n".
                "</a>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/hasulotstafftouroku'>\n".
                "<img src='/img/Labelimg/label_hasu.gif' width=85 height=36>\n".
                "</a>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/misakusei'>\n".
                "<img src='/img/Labelimg/label_syukkateishi.gif' width=85 height=36>\n".
                "</a>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/kensakuform'>\n".
                "<img src='/img/Labelimg/label_kensaku_lot.gif' width=85 height=36>\n".
                "</a>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/doubletourokuform'>\n".
                "<img src='/img/Labelimg/lot_double_kensaku.gif' width=85 height=36>\n".
                /*
                "</a>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Checklots/preadd'>\n".
                "<img src='/img/Labelimg/label_checklots.gif' width=85 height=36>\n".
                */
                "</a>\n";

      return $html;
      $this->html = $html;
      $this->data = $labelLotsubmenus;
  }

  public function Labelshinkisubmenus()
 {
   $html =
             "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/layouttypeform'>\n".
             "<img src='/img/Labelimg/label_layout.gif' width=85 height=36>\n".
             "</a></td>\n".
             "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/placeform'>\n".
             "<img src='/img/Labelimg/label_touroku_place.gif' width=85 height=36>\n".
             "</a>\n".
             "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/unitform'>\n".
             "<img src='/img/Labelimg/label_touroku_unit.gif' width=85 height=36>\n".
             "</a></td>\n".
             "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/insideoutform'>\n".
             "<img src='/img/Labelimg/label_insideout.gif' width=85 height=36>\n".
             "</a>\n".
             "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/setikkatsuform'>\n".
             "<img src='/img/Labelimg/label_setikkatsu.gif' width=85 height=36>\n".
             "</a>\n".
             "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/nashiform'>\n".
             "<img src='/img/Labelimg/label_nashi.gif' width=85 height=36>\n".
             "</a>\n";

     return $html;
     $this->html = $html;
     $this->data = $labelshinkisubmenus;
 }

      public function Labelhasulotmenus()
     {
       $html =
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/hasulotstafftouroku'>\n".
                 "<img src='/img/Labelimg/label_touroku.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/hasukensakuform'>\n".
                 "<img src='/img/Labelimg/label_kensaku.gif' width=85 height=36>\n".
                 "</a>\n";

         return $html;
         $this->html = $html;
         $this->data = $labelshinkisubmenus;
     }


     public function Labelgenzaijoukyoumenus()
    {
      $html =
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/syukkajoukyouform'>\n".
                "<img src='/img/Labelimg/label_jyoukyou.gif' width=85 height=36>\n".
                "</a></td>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Labels/genzaijoukyouform'>\n".
                "<img src='/img/Labelimg/label_kannou.gif' width=85 height=36>\n".
                "</a>\n";

        return $html;
        $this->html = $html;
        $this->data = $labelshinkisubmenus;
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
