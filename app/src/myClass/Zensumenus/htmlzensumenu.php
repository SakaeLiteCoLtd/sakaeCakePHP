<?php
namespace App\myClass\Zensumenus;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlzensumenu extends AppController
{
     public function initialize()
    {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
    }

     public function zensumenus()
  	{
        $html =
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Zensukensas/indexsubmenu'>\n".
                  "<img src='/img/Labelimg/rej_zensu.gif' width=115 height=40>\n".
                  "</a>\n";

    		return $html;
  	}

    public function zensussubmenus()
   {
       $html =
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Zensukensas/zensustafftouroku'>\n".
                 "<img src='/img/Labelimg/zensu_kensa.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Zensukensas/misakusei'>\n".
                 "<img src='/img/Labelimg/seihin_touroku.gif' width=85 height=36>\n".
                 "</a></td>\n".
                 "<td style='padding: 0.1rem 0.1rem;'><a href='/Zensukensas/zensukensakuform'>\n".
                 "<img src='/img/Labelimg/sub_touroku_kensaku.gif' width=85 height=36>\n".
                 "</a>\n";

       return $html;
   }

   public function zensustartend()
  {
      $html =
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Zensukensas/zensustafftouroku'>\n".
                "<img src='/img/Labelimg/sub_kensa_start.gif' width=85 height=36>\n".
                "</a></td>\n".
                "<td style='padding: 0.1rem 0.1rem;'><a href='/Zensukensas/zensuendstaff'>\n".
                "<img src='/img/Labelimg/sub_kensa_finish.gif' width=85 height=36>\n".
                "</a>\n";

      return $html;
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
