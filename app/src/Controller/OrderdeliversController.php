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
      $this->Customers = TableRegistry::get('customers');
      $this->PlaceDelivers = TableRegistry::get('placeDelivers');
      $this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
    }

    public function kensakuform()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $dateYMD = date('Y-m-d');
      $dateYMD1 = strtotime($dateYMD);
      $dayyey = date('Y', strtotime('-1 day', $dateYMD1));
      $arrYears = array();
      for ($k=2010; $k<=$dayyey; $k++){
        $arrYears[$k]=$k;
      }
      $this->set('arrYears',$arrYears);

      $arrMonths = array();
        for ($k=1; $k<=12; $k++){
          $arrMonths[$k] =$k;
        }
      $this->set('arrMonths',$arrMonths);

      $arrDays = array();
        for ($k=1; $k<=31; $k++){
          $arrDays[$k] =$k;
        }
      $this->set('arrDays',$arrDays);

    }

    public function kensakuselect()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $data = $this->request->getData();

      $date_sta = $data['date_sta_year']."-".$data['date_sta_month']."-".$data['date_sta_date'];
      $date_fin = $data['date_fin_year']."-".$data['date_fin_month']."-".$data['date_fin_date'];
      $product_code = $data['product_code'];
      $num_order = $data['num_order'];

      $orderEdis = $this->OrderEdis->find()
      ->where(['date_deliver >=' => $date_sta, 'date_deliver <' => $date_fin])->order(["product_code"=>"ASC"])->toArray();
      $this->set('orderEdis',$orderEdis);
/*
      echo "<pre>";
      print_r($orderEdis);
      echo "</pre>";
*/
    }

    public function editform()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $data = $this->request->getData();

      $array = array();
      $checknum = 0;
      if(isset($data["nummax"])){
        for ($k=2; $k<=$data["nummax"]; $k++){
          if(isset($data["subete"])){
            $array[] = $data["$k"];
          }elseif(isset($data["check".$k])){//checkがついているもののidをキープ
            $array[] = $data["$k"];
            $checknum = $checknum + 1;
          }else{
          }
        }

        for ($i=0; $i<=$data["nummax"]; $i++){
          if(isset($array[$i])){//checkがついているもののidと同じidのデータを取り出す
            ${"orderEdis".$i} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $array[$i]])->toArray();
            $this->set('orderEdis'.$i,${"orderEdis".$i});
            ${"bunnou".$i} = ${"orderEdis".$i}[0]->bunnou;
            $this->set('bunnou'.$i,${"bunnou".$i});

            $i_num = $i;//選択した個数をキープ
            $this->set('i_num',$i_num);
          }else{
            break;
          }
        }

        $num_order0 = $orderEdis0[0]->num_order;
        $product_code0 = $orderEdis0[0]->product_code;
        $Dnpdate_deliver = $orderEdis0[0]->date_deliver->format('Y-m-d');
        $orderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0','num_order' => $num_order0,'product_code' => $product_code0])->toArray();
        for($n=0; $n<=100; $n++){
          if(isset($orderEdis[$n])){
            ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $orderEdis[$n]->id])->toArray();
            $this->set('orderEdis'.$n,${"orderEdis".$n});
          }else{
            break;
          }
        }
      }

      $arrPlaceDelivers = $this->PlaceDelivers->find('all')->order(['id_from_order' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
			$arrPlaceDeliver = array();//配列の初期化
			foreach ($arrPlaceDelivers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
				$arrPlaceDeliver[] = array($value->id_from_order=>$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
			}
			$this->set('arrPlaceDeliver',$arrPlaceDeliver);//4行上$arrCustomerをctpで使えるようにセット

      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }

    }

    public function editconfirm()
    {
      if(!isset($_SESSION)){
        session_start();
        header('Expires:-1');
        header('Cache-Control:');
        header('Pragma:');
      }
      $_SESSION['place_deliver_data'] = array();

      $data = $this->request->getData();
      /*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $count = $data["i_count"];
      $this->set('count', $count);

      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $mess = "以下のように更新します。よろしければ「決定」ボタンを押してください。";
      $this->set('mess', $mess);

      for($i=0; $i<=$data["i_count"]; $i++){

        ${"orderEdis".$i} = $this->OrderEdis->find()->where(['id' => $data["orderEdis_".$i]])->toArray();
        $this->set('orderEdis'.$i,${"orderEdis".$i});

        if(isset($data["ikkatsu"])){//一括変更の場合

          $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $data["PlaceDeliverikkatsu"]])->toArray();
          if(isset($PlaceDeliver[0])){
            ${"PlaceDelivername".$i} = $PlaceDeliver[0]->name;
          }else{
            ${"PlaceDelivername".$i} = "";
          }
          $this->set('PlaceDelivername'.$i,${"PlaceDelivername".$i});
          ${"place_deliver_code".$i} = $data["PlaceDeliverikkatsu"];
          $this->set('place_deliver_code'.$i,$data["place_deliver_code".$i]);

          ${"place_line".$i} = $data["place_lineikkatsu"];
          $this->set('place_line'.$i,${"place_line".$i});

        }else{

          $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $data["place_deliver_code".$i]])->toArray();
          if(isset($PlaceDeliver[0])){
            ${"PlaceDelivername".$i} = $PlaceDeliver[0]->name;
          }else{
            ${"PlaceDelivername".$i} = "";
          }
          $this->set('PlaceDelivername'.$i,${"PlaceDelivername".$i});
          ${"place_deliver_code".$i} = $data["place_deliver_code".$i];
          $this->set('place_deliver_code'.$i,$data["place_deliver_code".$i]);

          ${"place_line".$i} = $data["place_line".$i];
          $this->set('place_line'.$i,${"place_line".$i});

        }

        $_SESSION['place_deliver_data'][] = [
          "id" => $data["orderEdis_".$i],
          "place_deliver_code" => $data["place_deliver_code".$i],
          "PlaceDelivername" => ${"PlaceDelivername".$i},
          "place_line" => ${"place_line".$i}
        ];

      }

    }

    public function preadd()
    {
      $OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }

    }

    public function login()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

        $userdata = $data['username'];

        if(isset($data['prelogin'])){

          $htmllogin = new htmlLogin();
          $qrcheck = $htmllogin->qrcheckprogram($userdata);

          if($qrcheck > 0){
            return $this->redirect(['action' => 'preadd',
            's' => ['mess' => "QRコードを読み込んでください。"]]);
          }

        }

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmlloginprogram($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();//$delete_flag = 0だとログインできない

        if ($user) {
          $this->Auth->setUser($user);
          return $this->redirect(['action' => 'editdo']);
        }
      }
    }

    public function editdo()
    {
      $session = $this->request->getSession();
      $sessiondata = $session->read();

			$OrderEdis = $this->OrderEdis->newEntity();
      $this->set('OrderEdis',$OrderEdis);

      $count = count($sessiondata["place_deliver_data"]);
      $this->set('count', $count);

      for($i=0; $i<count($sessiondata["place_deliver_data"]); $i++){

        ${"orderEdis".$i} = $this->OrderEdis->find()->where(['id' => $sessiondata["place_deliver_data"][$i]["id"]])->toArray();
        $this->set('orderEdis'.$i,${"orderEdis".$i});

        ${"PlaceDelivername".$i} = $sessiondata["place_deliver_data"][$i]["PlaceDelivername"];
        $this->set('PlaceDelivername'.$i,${"PlaceDelivername".$i});
        ${"place_deliver_code".$i} = $sessiondata["place_deliver_data"][$i]["place_deliver_code"];
        $this->set('place_deliver_code'.$i,${"place_deliver_code".$i});
        ${"place_line".$i} = $sessiondata["place_deliver_data"][$i]["place_line"];
        $this->set('place_line'.$i,${"place_line".$i});

      }

      $OrderEdis = $this->OrderEdis->patchEntity($this->OrderEdis->newEntity(), $sessiondata["place_deliver_data"]);
      $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4

         for($i=0; $i<count($sessiondata["place_deliver_data"]); $i++){

           $PlaceDeliver = $this->PlaceDelivers->find()
           ->where(['id_from_order' => $sessiondata["place_deliver_data"][$i]["place_deliver_code"]])->toArray();
           $customer_code = $PlaceDeliver[0]["cs_code"];

           if ($this->OrderEdis->updateAll(
             ['place_deliver_code' => $sessiondata["place_deliver_data"][$i]["place_deliver_code"],
              'place_line' => $sessiondata["place_deliver_data"][$i]["place_line"],
              'customer_code' => $customer_code,
              'updated_at' => date('Y-m-d H:i:s'),
              'updated_staff' => $sessiondata['Auth']['User']['staff_id']],
             ['id' => $sessiondata["place_deliver_data"][$i]["id"]]
           )){

             $DenpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->find()
             ->where(['order_edi_id' => $sessiondata["place_deliver_data"][$i]["id"]])->toArray();
             if(isset($DenpyouDnpMinoukannous[0])){

               if ($this->DenpyouDnpMinoukannous->updateAll(
                 ['place_deliver' => $sessiondata["place_deliver_data"][$i]["PlaceDelivername"],
                  'updated_at' => date('Y-m-d H:i:s'),
                  'updated_staff' => $sessiondata['Auth']['User']['staff_id']],
                 ['id' => $DenpyouDnpMinoukannous[0]["id"]]
               )){

               } else {

                 $mes = "※更新されませんでした";
                 $this->set('mes',$mes);
                 $this->Flash->error(__('The product could not be saved. Please, try again.'));
                 throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

               }

             }

           } else {

             $mes = "※更新されませんでした";
             $this->set('mes',$mes);
             $this->Flash->error(__('The product could not be saved. Please, try again.'));
             throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

           }

           if($i == count($sessiondata["place_deliver_data"]) - 1){

             $mes = "※更新されました";
             $this->set('mes',$mes);
             $connection->commit();// コミット5

           }

         }

       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

    }

}
