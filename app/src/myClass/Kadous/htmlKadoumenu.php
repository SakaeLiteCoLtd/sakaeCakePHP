<?php
namespace App\myClass\Kadous;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlKadoumenu extends AppController
{
     public function initialize()
    {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
    }

     public function Kadoumenus()
  	{
        $html =
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Kadous/kariindex'>\n".
                  "<img src='/img/Labelimg/nippou_kari_touroku.gif' width=115 height=40>\n".
                  "</a></td>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Kadous/kensakuform'>\n".
                  "<img src='/img/Labelimg/nippou_yobidashi.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Kadous/syuuseiday'>\n".
                  "<img src='/img/Labelimg/nippou_syusei.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/Kadous/index'>\n".
                  "<img src='/img/Labelimg/nippou_saisyu_touroku.gif' width=115 height=40>\n".
                  "</a>\n";

    		return $html;
    		$this->html = $html;
    		$this->data = $Kadoumenus;
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
