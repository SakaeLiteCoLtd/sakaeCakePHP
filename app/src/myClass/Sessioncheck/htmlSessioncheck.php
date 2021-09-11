<?php
namespace App\myClass\Sessioncheck;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlSessioncheck extends AppController
{

    public function check($session_names)
   {
     $arrsessions = explode(',', $session_names);

     $sessionget = $this->request->getSession();
     $sessiongetdata = $sessionget->read();

     $num = 1;

     for($i=0; $i<count($arrsessions); $i++){

       if(!isset($sessiongetdata[$arrsessions[$i]])){

         $num = $num + 1;

       }

     }

     $arr_session_flag = [
       "num" => $num,
       "mess" => "セッションが切れました。この画面からやり直してください。"
     ];

      return $arr_session_flag;
   }

}

?>
