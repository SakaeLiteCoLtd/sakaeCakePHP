<?php
namespace App\myClass\Syukkakensa;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlSyukkakensamenu extends AppController
{

     public function Syukkakensamenu()
  	{
        $html =
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/KensahyouSokuteidatas/kensahyouproductform'>\n".
                  "<img src='/img/ShinkiTourokuMenu/kensahyou_touroku.gif' width=115 height=40>\n".
                  "</a></td>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/kensahyouHeads/kensahyouheadproductform'>\n".
                  "<img src='/img/ShinkiTourokuMenu/kensahyou_head.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/SyukkaKensas/improductform'>\n".
                  "<img src='/img/ShinkiTourokuMenu/im_taiou_touroku.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/KensahyouSokuteidatas/yobidashicustomer'>\n".
                  "<img src='/img/ShinkiTourokuMenu/kensahyou_yobidashi.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/kensahyouHeads/misakusei'>\n".
                  "<img src='/img/ShinkiTourokuMenu/analyze_dist.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/kensahyouHeads/misakusei'>\n".
                  "<img src='/img/ShinkiTourokuMenu/kensa_jyunbi_insatsu.gif' width=115 height=40>\n".
                  "</a>\n".
                  "<td style='padding: 0.1rem 0.1rem;'><a href='/SyukkaKensas/torikomitest'>\n".
                  "<img src='/img/ShinkiTourokuMenu/syukka_qr.gif' width=100 height=40>\n".
                  "</a>\n";

    		return $html;
    		$this->html = $html;
    		$this->data = $Kadoumenus;
  	}

}

?>
