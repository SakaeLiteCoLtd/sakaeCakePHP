<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用

class OrderdeliversController extends AppController
{

    public function initialize()
    {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');
			$this->Users = TableRegistry::get('users');
      $this->OrderEdis = TableRegistry::get('orderEdis');
      $this->PlaceDelivers = TableRegistry::get('placeDelivers');
    }

    public function kensakuform()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);
    }

    public function kensakuselect()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);
    }

    public function editform()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $data = $this->request->getData();
        $mess = "";
        $this->set('mess',$mess);
      }

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function editconfirm()
    {
      $data = $this->request->getData();

      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $mess = "以下のように更新します。よろしければ「決定」ボタンを押してください。";
      $delete_flag = 0;

      $this->set('mess', $mess);
      $this->set('delete_flag', $delete_flag);

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function preadd()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);
    }

    public function login()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
        $ary = explode(',', $str);//$strを配列に変換
        $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
        //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
        $this->set('username', $username);
        $Userdata = $this->Users->find()->where(['username' => $username])->toArray();
          if(empty($Userdata)){
            $delete_flag = "";
          }else{
            $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
            $this->set('delete_flag',$delete_flag);//登録者の表示のため
          }
            $user = $this->Auth->identify();
          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'editdo']);
          }
        }
    }

    public function editdo()
    {
      $data = $this->request->getData();
      $this->set('name',$data["name"]);
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
			$OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $OrderEdis = $this->OrderEdis->patchEntity($this->OrderEdis->newEntity(), $data);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4

         if ($this->OrderEdis->updateAll(
           ['name' => $data["name"], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $sessionData['login']['staff_id']],
           ['id'  => $data["MaterialTypeId"]]
         )){

           $mes = "※更新されました";
           $this->set('mes',$mes);
           $connection->commit();// コミット5

         } else {

           $mes = "※更新されませんでした";
           $this->set('mes',$mes);
           $this->Flash->error(__('The product could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

         }

       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

    }

}
