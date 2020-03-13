<?php
namespace App\myClass\Logins;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlLogin extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->Users = TableRegistry::get('users');
    }

     public function Prelogin()
  	{
        $html =
                "<legend align='center'><strong style='font-size: 11pt; color:blue'><?= __('社員ID登録') ?></strong></legend>\n".
                "<fieldset><table align='center' border='2' bordercolor='#E6FFFF' cellpadding='0' cellspacing='0' style='border-bottom: solid;border-width: 1px'>\n"./////////////////////////////////////////////
                "<tr><td bgcolor='#FFFFCC' style='font-size: 12pt'><strong style='font-size: 11pt; color:blue'>QRコードを読み込んでください</strong></td>\n".
        		    "<td bgcolor='#FFFFCC'style='font-size: 12pt;'><input type='text' name=username size='6'/></td></tr></table></fieldset>\n";

    		return $html;
    		$this->html = $html;
    		$this->data = $prelogin;
  	}

    public function htmllogin($userdata)
   {
       $data = $userdata;//postデータ取得し、$dataと名前を付ける
       $ary = explode(',', $userdata);//$strを配列に変換
       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;
         }
           $user = $this->Auth->identify();
           $arraylogindate = array();
           $arraylogindate[] = $username;
           $arraylogindate[] = $delete_flag;

           return $arraylogindate;
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
