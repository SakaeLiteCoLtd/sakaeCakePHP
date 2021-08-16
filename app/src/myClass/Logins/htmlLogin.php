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
                "<tr><td bgcolor='#FFFFCC' style='font-size: 12pt'><strong style='font-size: 11pt; color:blue'>社員ID</strong></td>\n".
        		    "<td  width='150' bgcolor='#FFFFCC'style='font-size: 12pt;'><input type='text' name=username size='6' autocomplete='off' autofocus/></td></tr></table></fieldset>\n";

    		return $html;
    		$this->html = $html;
    		$this->data = $prelogin;
  	}

    public function Preloginview()//210802更新
   {
       $html =
               "<br><legend align='center'><strong style='font-size: 11pt; color:blue'><?= __('社員ID登録') ?></strong></legend>\n".
               "<fieldset><table align='center' border='2' bordercolor='#E6FFFF' cellpadding='0' cellspacing='0' style='border-bottom: solid;border-width: 1px'>\n"./////////////////////////////////////////////
               "<tr><td bgcolor='#FFFFCC' style='font-size: 12pt'><strong style='font-size: 11pt; color:blue'>社員ID</strong></td>\n".
               "<td  width='150' bgcolor='#FFFFCC'style='font-size: 12pt;'><input type='text' name=username size='6' autocomplete='off' autofocus/></td></tr></table></fieldset>\n".
               "<table align='center' border='2' bordercolor='#E6FFFF' cellpadding='0' cellspacing='0'>\n".
               "<tr>\n".
               "<td style='border-style: none;'><div align='center'>\n".
               "<input type='submit' value='ログイン'>\n".
               "</div></td>\n".
               "<input type='hidden' name=prelogin value=1>\n".
               "</tr></table><br>\n";

       return $html;
       $this->html = $html;
       $this->data = $prelogin;
   }

    public function htmllogin($userdata)
   {
       $data = $userdata;//postデータ取得し、$dataと名前を付ける
       /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
    */
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

   public function htmlloginprogram($userdata)//210802更新
  {
      $ary = explode(',', $userdata);
      $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
      $Userdata = $this->Users->find()->where(['username' => $username])->toArray();

      if(empty($Userdata)){
        $delete_flag = "";
      }else{
        $delete_flag = $Userdata[0]->delete_flag;
      }

      $arraylogindate = array();
      $arraylogindate[] = $username;
      $arraylogindate[] = $delete_flag;

      return $arraylogindate;
    }

    public function qrcheckprogram($userdata)//210802更新
   {
     $ary = explode(',', $userdata);

     if(isset($ary[1])){//QRを読んでいる場合
       $qrcheck = 0;
     }else{
       $qrcheck = 1;
     }

     return $qrcheck;
   }

   public function Loginview($arrusername)//210802更新
  {
    $username = $arrusername[0];
    $delete_flag = $arrusername[1];

    if($username != "" && strlen($delete_flag) > 0){//okのとき

      $html =
      "<body oncontextmenu='return false' onload='document.all.OK.click();' >\n".
      "<fieldset><input type='hidden' name=username value=$username>\n".
      "<input type='hidden' name=delete_flag value=$delete_flag></fieldset>\n".
      "<center><input type='submit' value='登録しています…' name='OK' style='background-color:#E6FFFF; border-width: 0px'></center>\n".
      "<br><br><br></body>\n";

    }elseif($username != "" && strlen($delete_flag) < 1){//ユーザー名がちがうとき

      $html =
      "<fieldset><table align='center' border='2' bordercolor='#E6FFFF' cellpadding='0' cellspacing='0' style='border:none;'>\n"./////////////////////////////////////////////
      "<tbody style='border:none;'><tr style='border:none;'><td style='border:none;'>\n".
      "<strong style='font-size: 11pt; color:red'>※ユーザー名が登録されていません。</strong></td>\n".
      "</tr></tbody></table></fieldset>\n";

    }else{//直接urlをたたかれたとき

      $html =
      "<fieldset><table align='center' border='2' bordercolor='#E6FFFF' cellpadding='0' cellspacing='0' style='border:none;'>\n"./////////////////////////////////////////////
      "<tbody style='border:none;'><tr style='border:none;'><td style='border:none;'>\n".
      "<strong style='font-size: 11pt; color:red'>※ログインしてください</strong></td>\n".
      "</tr></tbody></table></fieldset>\n";

    }

      return $html;
      $this->html = $html;
      $this->data = $prelogin;

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
