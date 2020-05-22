<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Roles Controller
 *
 * @property \App\Model\Table\RolesTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KadousController extends AppController
{

     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');
       $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
       $this->Users = TableRegistry::get('users');

       $this->Auth->allow();
     }

    public function kariindex()
    {
      $this->request->session()->destroy(); // セッションの破棄

			$KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);//
    }

    public function kariform()
    {
      $this->request->session()->destroy(); // セッションの破棄

			$KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);//
			$data = $this->request->getData();//postデータを$dataに
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if(empty($data['formset'])){//最初のフォーム画面
        $dateYMD = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day'];
        $dateYMD1 = strtotime($dateYMD);
        $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
        $dateYMDto = $dayto;
    //    $this->set('dateYMDye',$dateYMDye);
        $dateHI = date("08:00");
        $dateto = $dateYMDto."T".$dateHI;
        $dateye = $dateYMD."T".$dateHI;
        $this->set('dateye',$dateye);
        $this->set('dateto',$dateto);

        for($i=1; $i<=9; $i++){
      		${"tuika".$i} = 0;
      		$this->set('tuika'.$i,${"tuika".$i});//セット
      	}

        //旧DB参照
        $connection = ConnectionManager::get('DB_ikou_test');
        $table = TableRegistry::get('scheduleKoutei');
        $table->setConnection($connection);

         for($j=1; $j<=9; $j++){
           $daytomo = date('Y-m-d', strtotime('+1 day', $dateYMD1));
           $dateYMDs = mb_substr($dateYMD, 0, 10);
           $dateYMDf = mb_substr($daytomo, 0, 10);
           ${"tuika".$j} = 0;
           $this->set('tuika'.$j,${"tuika".$j});//セット

           $sql = "SELECT datetime,seikeiki,product_id,present_kensahyou,product_name FROM schedule_koutei".
                 " where datetime >= '".$dateYMDs."' and datetime <= '".$dateYMDf."' and seikeiki = ".$j." order by datetime asc";
           $connection = ConnectionManager::get('DB_ikou_test');
           $scheduleKoutei = $connection->execute($sql)->fetchAll('assoc');
/*
           echo "<pre>";
           print_r(count($scheduleKoutei));
           echo "</pre>";
*/
              ${"arrP".$j} = array();
              ${"n".$j} = count($scheduleKoutei);
              $this->set('n'.$j,${"n".$j});
               for($i=1; $i<=count($scheduleKoutei); $i++){
                 ${"arrP".$j.$i} = array();
                 if(isset($scheduleKoutei[$i-1])) {
                   ${"ScheduleKoutei_id".$i} = 0;
                   ${"datetime".$i} = $scheduleKoutei[$i-1]["datetime"];
                   $dateYMD = $scheduleKoutei[$i-1]["datetime"];
                   $dateYMD1 = strtotime($dateYMD);
                   $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
                   $dateHI = date("08:00");
                   ${"finishing_tm".$i} = $dayto." ".$dateHI;
                   ${"seikeiki".$i} = $scheduleKoutei[$i-1]["seikeiki"];
                   ${"product_code".$i} = $scheduleKoutei[$i-1]["product_id"];
                   ${"present_kensahyou".$i} = $scheduleKoutei[$i-1]["present_kensahyou"];
                   ${"product_name".$i} = $scheduleKoutei[$i-1]["product_name"];
                   ${"amount_shot".$j.$i} = "";
                   $this->set('amount_shot'.$j.$i,${"amount_shot".$j.$i});
                   ${"cycle_shot".$j.$i} = "";
                   $this->set('cycle_shot'.$j.$i,${"cycle_shot".$j.$i});

                   ${"arrP".$j}[] = ['id' => ${"ScheduleKoutei_id".$i}, 'datetime' => ${"datetime".$i},
                    'product_code' => ${"product_code".$i},'seikeiki' => ${"seikeiki".$i},
                    'present_kensahyou' => ${"present_kensahyou".$i},'product_name' => ${"product_name".$i},
                    'finishing_tm' => ${"finishing_tm".$i}];
                 }
                }
                ${"ScheduleKouteisarry".$j} = array();//空の配列を作る
                foreach ((array)${"arrP".$j} as $key => $value) {//datetimeで並び替え
                     $sort[$key] = $value['datetime'];
                      array_push(${"ScheduleKouteisarry".$j}, ['id' => $value['id'], 'starting_tm' => $value['datetime'],
                       'seikeiki' => $value['seikeiki'], 'product_code' => $value['product_code'],
                        'present_kensahyou' => $value['present_kensahyou'], 'product_name' => $value['product_name'],
                      'finishing_tm' => $value['finishing_tm']]);
                }

                 if(isset(${"ScheduleKouteisarry".$j}[0])){
                    array_multisort(array_map("strtotime", array_column( ${"ScheduleKouteisarry".$j}, "starting_tm" ) ), SORT_ASC, ${"ScheduleKouteisarry".$j});
                for($m=1; $m<=${"n".$j}; $m++){//同じ成型機で製品が作られている個数分
                  ${"arrP".$j.$m}[] = ${"ScheduleKouteisarry".$j}[$m-1];
                  $this->set('arrP'.$j.$m,${"arrP".$j.$m});//セット
                    if($m>=2){//同じ成型機で２つ以上の製品ができているときfinishing_tmを修正
                      $m1 = $m-1 ;
                      ${"arrP".$j.$m1} = array();//m-1の配列を空にする
                      $replacements = array('finishing_tm' => ${"ScheduleKouteisarry".$j}[$m-1]['starting_tm']);//１つ前のfin_tmを後のsta_tmに変更する
                      ${"ScheduleKouteisarry".$j}[$m-2] = array_replace(${"ScheduleKouteisarry".$j}[$m-2], $replacements);
                      ${"arrP".$j.$m1}[] = ${"ScheduleKouteisarry".$j}[$m-2];
                      $this->set('arrP'.$j.$m1,${"arrP".$j.$m1});//セット
                    }
           /*
                    echo "<pre>";
                    print_r($j."---".$m."---");
                    print_r(${"arrP".$j.$m});
                    echo "</pre>";
           */
                }

              }

              for($i=1; $i<=count($scheduleKoutei); $i++){
                ${"product_code".$j.$i} = ${"arrP".$j.$i}[0]['product_code'];
                $this->set('product_code'.$j.$i,${"product_code".$j.$i});
                ${"hyoujistarting_tm".$j.$i} = substr(${"arrP".$j.$i}[0]['starting_tm'], 0, 10)."T".substr(${"arrP".$j.$i}[0]['starting_tm'], 11, 5);
                $this->set('hyoujistarting_tm'.$j.$i,${"hyoujistarting_tm".$j.$i});
                ${"hyoujifinishing_tm".$j.$i} = substr(${"arrP".$j.$i}[0]['finishing_tm'], 0, 10)."T".substr(${"arrP".$j.$i}[0]['finishing_tm'], 11, 5);
                $this->set('hyoujifinishing_tm'.$j.$i,${"hyoujifinishing_tm".$j.$i});
/*
                echo "<pre>";
                print_r($j."---".$i."---");
                print_r(${"product_code".$i});
                echo "</pre>";
*/
              }

            }

        }elseif(isset($data['confirm'])){

          return $this->redirect(['action' => 'kariconfirm',
          's' => ['data' => $data]]);

      	}else{//追加または削除の場合

          for($j=1; $j<=9; $j++){

            $dateye = $data["dateye"];
            $dateto = $data["dateto"];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            if(isset($data["tuika".$j])){
              ${"n".$j} = $data["n".$j] + 1;
            }elseif(isset($data["sakujo".$j])){
              ${"n".$j} = $data["n".$j] - 1;
            }else{
              ${"n".$j} = $data["n".$j];
            }
            $this->set('n'.$j,${"n".$j});

            for($i=1; $i<=${"n".$j}; $i++){

              if(isset($data["product_code".$j.$i])){
                ${"product_code".$j.$i} = $data["product_code".$j.$i];
                $this->set('product_code'.$j.$i,${"product_code".$j.$i});
                ${"hyoujistarting_tm".$j.$i} = $data["starting_tm".$j.$i];
                $this->set('hyoujistarting_tm'.$j.$i,${"hyoujistarting_tm".$j.$i});
                ${"hyoujifinishing_tm".$j.$i} = $data["finishing_tm".$j.$i];
                $this->set('hyoujifinishing_tm'.$j.$i,${"hyoujifinishing_tm".$j.$i});
                ${"amount_shot".$j.$i} = $data["amount_shot".$j.$i];
                $this->set('amount_shot'.$j.$i,${"amount_shot".$j.$i});
                ${"cycle_shot".$j.$i} = $data["cycle_shot".$j.$i];
                $this->set('cycle_shot'.$j.$i,${"cycle_shot".$j.$i});
              }else{
                ${"product_code".$j.$i} = "";
                $this->set('product_code'.$j.$i,${"product_code".$j.$i});
                ${"hyoujistarting_tm".$j.$i} = $data["dateye"];
                $this->set('hyoujistarting_tm'.$j.$i,${"hyoujistarting_tm".$j.$i});
                ${"hyoujifinishing_tm".$j.$i} = $data["dateto"];
                $this->set('hyoujifinishing_tm'.$j.$i,${"hyoujifinishing_tm".$j.$i});
                ${"amount_shot".$j.$i} = "";
                $this->set('amount_shot'.$j.$i,${"amount_shot".$j.$i});
                ${"cycle_shot".$j.$i} = "";
                $this->set('cycle_shot'.$j.$i,${"cycle_shot".$j.$i});
              }

            }
          }

        }
    }

    public function kariconfirm()
    {
      session_start();
      $KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);
      $Data = $this->request->query('s');
/*
      echo "<pre>";
      print_r($Data);
      echo "</pre>";
*/
      for($j=1; $j<=9; $j++){

      ${"n".$j} = $Data["data"]["n".$j];
      $this->set('n'.$j,${"n".$j});

        for($i=1; $i<=${"n".$j}; $i++){

          ${"product_code".$j.$i} = $Data["data"]["product_code".$j.$i];
          $this->set('product_code'.$j.$i,${"product_code".$j.$i});
          ${"amount_shot".$j.$i} = $Data["data"]["amount_shot".$j.$i];
          $this->set('amount_shot'.$j.$i,${"amount_shot".$j.$i});
          ${"cycle_shot".$j.$i} = $Data["data"]["cycle_shot".$j.$i];
          $this->set('cycle_shot'.$j.$i,${"cycle_shot".$j.$i});
          ${"starting_tm".$j.$i} = $Data["data"]["starting_tm".$j.$i];
          $this->set('starting_tm'.$j.$i,${"starting_tm".$j.$i});
          ${"finishing_tm".$j.$i} = $Data["data"]["finishing_tm".$j.$i];
          $this->set('finishing_tm'.$j.$i,${"finishing_tm".$j.$i});

          ${"kadoujikan".$j.$i} = ((strtotime(${"finishing_tm".$j.$i}) - strtotime(${"starting_tm".$j.$i})));
          $this->set('kadoujikan'.$j.$i,${"kadoujikan".$j.$i});
          ${"riron_shot".$j.$i} = round(${"kadoujikan".$j.$i}/${"cycle_shot".$j.$i}, 0);
          $this->set('riron_shot'.$j.$i,${"riron_shot".$j.$i});
          ${"accomp_rate".$j.$i} = round(100*${"amount_shot".$j.$i}/${"riron_shot".$j.$i}, 0);
          $this->set('accomp_rate'.$j.$i,${"accomp_rate".$j.$i});

        }

      }

    }

		public function karipreadd()
		{
      $KariKadouSeikei = $this->KariKadouSeikeis->newEntity();
      $this->set('KariKadouSeikei',$KariKadouSeikei);

      $session = $this->request->getSession();
      $data = $session->read();
/*
      echo "<pre>";
      print_r($data["karikadouseikei"]);
      echo "</pre>";
*/
		}

		public function karilogin()
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
						return $this->redirect(['action' => 'karido']);
					}
				}
		}

    public function karido()
   {
     $KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
     $this->set('KariKadouSeikei',$KariKadouSeikeis);

     $session = $this->request->getSession();
     $data = $session->read();

     $num = count($data["karikadouseikei"]) + 1;

     for($n=1; $n<=$num; $n++){
       if(isset($data['karikadouseikei'][$n])){
         $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
         $data['karikadouseikei'][$n] = array_merge($data['karikadouseikei'][$n],$created_staff);
       }else{
         break;
       }
     }
/*
     echo "<pre>";
     print_r($data["karikadouseikei"]);
     echo "</pre>";
*/

     if ($this->request->is('get')) {
       $KariKadouSeikeis = $this->KariKadouSeikeis->patchEntities($KariKadouSeikeis, $data['karikadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->KariKadouSeikeis->saveMany($KariKadouSeikeis)) {

//旧DBに登録

            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('kari_kadou_seikei');
            $table->setConnection($connection);

            for($k=0; $k<count($arrFp); $k++){
              $connection->insert('kari_kadou_seikei', [
                  'date_order' => $arrFp[$k]["date_order"],
                  'num_order' => $arrFp[$k]["num_order"],
                  'product_id' => $arrFp[$k]["product_code"],
                  'price' => $arrFp[$k]["price"],
                  'date_deliver' => $arrFp[$k]["date_deliver"],
                  'amount' => $arrFp[$k]["amount"],
                  'cs_id' => $arrFp[$k]["customer_code"],
                  'place_deliver_id' => $arrFp[$k]["place_deliver_code"],
                  'place_line' => $arrFp[$k]["place_line"],
                  'line_code' => $arrFp[$k]["line_code"],
                  'check_denpyou' => $arrFp[$k]["check_denpyou"],
                  'delete_flg' => $arrFp[$k]["delete_flag"],
                  'created_at' => date("Y-m-d H:i:s")
              ]);
            }




           $mes = "※登録されました";
           $this->set('mes',$mes);
           $connection->commit();// コミット5

         } else {

           $mes = "※登録されませんでした";
           $this->set('mes',$mes);
           $this->Flash->error(__('The data could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

     }

   }

   public function index()
   {
     $this->request->session()->destroy(); // セッションの破棄

     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);
   }

   public function form()
   {
     session_start();
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);

     $data = $this->request->getData();

     $dateYMD = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day'];
     $dateYMD1 = strtotime($dateYMD);
     $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
     $dateYMDto = $dayto;
     $dateHI = date("08:00");
     $dateYMDs = $dateYMD."T".$dateHI;
     $dateYMDf = $dateYMDto."T".$dateHI;

/*
     echo "<pre>";
     print_r($dateYMDs);
     echo "</pre>";
     echo "<pre>";
     print_r($dateYMDf);
     echo "</pre>";
*/

      for($j=1; $j<=9; $j++){
      $KariKadouSeikei = $this->KariKadouSeikeis->find()->where(['starting_tm >=' => $dateYMDs, 'starting_tm <' => $dateYMDf, 'seikeiki' => $j, 'present_kensahyou' => 0])->toArray();

      ${"n".$j} = 0;
      $this->set('n'.$j,${"n".$j});
         for($i=1; $i<=10; $i++){
           ${"arrP".$j.$i} = array();
           if(isset($KariKadouSeikei[$i-1])) {
             ${"KariKadouSeikei_id".$i} = $KariKadouSeikei[$i-1]->id;
             ${"product_code".$i} = $KariKadouSeikei[$i-1]->product_code;
             ${"seikeiki".$i} = $KariKadouSeikei[$i-1]->seikeiki;
             ${"seikeiki_code".$i} = $KariKadouSeikei[$i-1]->seikeiki_code;
             ${"starting_tm".$i} = $KariKadouSeikei[$i-1]->starting_tm->format('Y-m-d H:i:s');
             ${"finishing_tm".$i} = $KariKadouSeikei[$i-1]->finishing_tm->format('Y-m-d H:i:s');
             ${"cycle_shot".$i} = $KariKadouSeikei[$i-1]->cycle_shot;
             ${"amount_shot".$i} = $KariKadouSeikei[$i-1]->amount_shot;
             ${"accomp_rate".$i} = $KariKadouSeikei[$i-1]->accomp_rate;
             ${"present_kensahyou".$i} = $KariKadouSeikei[$i-1]->present_kensahyou;
             ${"created_at".$i} = $KariKadouSeikei[$i-1]->created_at->format('Y-m-d H:i:s');
             ${"created_staff".$i} = $KariKadouSeikei[$i-1]->created_staff;

             ${"arrP".$j.$i}[] = ['id' => ${"KariKadouSeikei_id".$i}, 'product_code' => ${"product_code".$i},'seikeiki' => ${"seikeiki".$i},
             'seikeiki_code' => ${"seikeiki_code".$i}, 'starting_tm' => ${"starting_tm".$i},
             'finishing_tm' => ${"finishing_tm".$i}, 'cycle_shot' => ${"cycle_shot".$i},
             'amount_shot' => ${"amount_shot".$i}, 'accomp_rate' => ${"accomp_rate".$i},
             'present_kensahyou' => ${"present_kensahyou".$i}, 'created_at' => ${"created_at".$i}, 'created_staff' => ${"created_staff".$i}];

             $this->set('arrP'.$j.$i,${"arrP".$j.$i});//セット
             ${"n".$j} = $i;
             $this->set('n'.$j,${"n".$j});//セット

           }
          }
      }
   }

   public function confirm()
   {
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);//
   }

		public function preadd()
		{
      $KadouSeikei = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikei',$KadouSeikei);
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
						return $this->redirect(['action' => 'do']);
					}
				}
		}

		public function logout()
		{
			$this->request->session()->destroy(); // セッションの破棄
			return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
		}

   public function do()
  {
    $KadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('KadouSeikeis',$KadouSeikeis);

    $session = $this->request->getSession();
    $data = $session->read();

    for($n=1; $n<=100; $n++){
      if(isset($_SESSION['kadouseikei'][$n])){
        $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
        $_SESSION['kadouseikei'][$n] = array_merge($_SESSION['kadouseikei'][$n],$created_staff);
      }else{
        break;
      }
    }

/*
    echo "<pre>";
    print_r($_SESSION['kadouseikei']);
    echo "</pre>";
*/

    if ($this->request->is('get')) {
      $KadouSeikeis = $this->KadouSeikeis->patchEntities($KadouSeikeis, $_SESSION['kadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->KadouSeikeis->saveMany($KadouSeikeis)) {

          //旧DBに登録




          for($n=1; $n<=100; $n++){
            if(isset($_SESSION['kadouseikei'][$n])){

              $KariKadouSeikeiData = $this->KariKadouSeikeis->find()->where(['id' => $_SESSION['kadouseikeiId'][$n]])->toArray();//'present_kensahyou' => 0となるデータをKadouSeikeisテーブルから配列で取得
              $KariKadouSeikeistarting_tm = $KariKadouSeikeiData[0]->starting_tm->format('Y-m-d H:i:s');
        //      $KariKadouSeikeistarting_tm = substr($KariKadouSeikeistarting_tm,0,4)."-".substr($KariKadouSeikeistarting_tm,5,2)."-".substr($KariKadouSeikeistarting_tm,8,2);
              $KariKadouSeikeifinishing_tm = $KariKadouSeikeiData[0]->finishing_tm->format('Y-m-d H:i:s');
        //      $KariKadouSeikeifinishing_tm = substr($KariKadouSeikeifinishing_tm,0,4)."-".substr($KariKadouSeikeifinishing_tm,5,2)."-".substr($KariKadouSeikeifinishing_tm,8,2);
              $KariKadouSeikeicreated_at = $KariKadouSeikeiData[0]->created_at->format('Y-m-d H:i:s');

              $this->KariKadouSeikeis->updateAll(
              ['present_kensahyou' => 1 ,'starting_tm' => $KariKadouSeikeistarting_tm ,'finishing_tm' => $KariKadouSeikeifinishing_tm  ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
              ['id'   => $_SESSION['kadouseikeiId'][$n] ]
              );

//旧DBを更新




            }else{
              break;
            }
          }
          $mes = "※登録されました";
          $this->set('mes',$mes);

          $connection->commit();// コミット5
        } else {
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('The data could not be saved. Please, try again.'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }
  }

    public function edit($id = null)
    {
			$role = $this->Roles->get($id);//選んだidに関するRolesテーブルのデータに$roleと名前を付ける
			$this->set('role',$role);//
			$updated_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$role['updated_staff'] = $updated_staff;//$roleのupdated_staffを$staff_idにする

			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
				$role = $this->Roles->patchEntity($role, $this->request->getData());//106行目でとったもともとの$roleデータを$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Roles->save($role)) {
						$this->Flash->success(__('The role has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The role could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}

    }

}
