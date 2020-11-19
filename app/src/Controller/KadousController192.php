<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

 use App\myClass\Productcheck\htmlProductcheck;


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
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->Konpous = TableRegistry::get('konpous');//productsテーブルを使う
       $this->GenjyouSeikeikis = TableRegistry::get('genjyouSeikeikis');
       $this->KadouritsuSeikeikis = TableRegistry::get('kadouritsuSeikeikis');

       $this->Auth->allow();
     }

    public function kariindex()
    {
      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }

      $this->request->session()->destroy(); // セッションの破棄

			$KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);//
    }

    public function kariform()
    {
      $Data=$this->request->query('s');
      if(isset($Data["mess"])){
        $mess = $Data["mess"];
        $this->set('mess',$mess);
      }else{
        $mess = "";
        $this->set('mess',$mess);
      }

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
        $connection = ConnectionManager::get('sakaeMotoDB');
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
           $connection = ConnectionManager::get('sakaeMotoDB');
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
      $this->request->session()->destroy(); // セッションの破棄
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

          $htmlProductcheck = new htmlProductcheck();//クラスを使用
          $product_code_check = $htmlProductcheck->Productcheck(${"product_code".$j.$i});
          if($product_code_check == 1){
            return $this->redirect(
             ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => ${"product_code".$j.$i}]]
            );
          }else{
            $product_code_check = $product_code_check;
          }

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
     $this->set('data',$data);

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

      $_SESSION['hyoujitourokudata'] = $data['karikadouseikei'];

     if ($this->request->is('get')) {
       $KariKadouSeikeis = $this->KariKadouSeikeis->patchEntities($this->KariKadouSeikeis->newEntity(), $data['karikadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->KariKadouSeikeis->saveMany($KariKadouSeikeis)) {
           $connection->commit();// コミット5

            //旧DBに登録
            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('kari_kadou_seikei');
            $table->setConnection($connection);

            for($k=1; $k<=count($data['karikadouseikei']); $k++){
              $connection->insert('kari_kadou_seikei', [
                'product_id' => $data['karikadouseikei'][$k]["product_code"],
                'seikeiki_id' => $data['karikadouseikei'][$k]["seikeiki"],
                'starting_tm' => $data['karikadouseikei'][$k]["starting_tm"],
                'finishing_tm' => $data['karikadouseikei'][$k]["finishing_tm"],
                'cycle_shot' => $data['karikadouseikei'][$k]["cycle_shot"],
                'amount_shot' => $data['karikadouseikei'][$k]["amount_shot"],
                'present_kensahyou' => $data['karikadouseikei'][$k]["present_kensahyou"],
                'first_lot_num' => $data['karikadouseikei'][$k]["first_lot_num"],
                'last_lot_num' => $data['karikadouseikei'][$k]["last_lot_num"],
              ]);
            }

            $connection = ConnectionManager::get('default');
            $table->setConnection($connection);

           $mes = "※登録されました";
           $this->set('mes',$mes);

         } else {

           $mes = "※登録されませんでした";
           $this->set('mes',$mes);
           $this->Flash->error(__('データベースに登録できません。登録済のデータでないか確認してください。'));
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
     $this->request->session()->destroy(); // セッションの破棄

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
      $GenjyouSeikeiki= $this->GenjyouSeikeikis->find()->where(['seikeiki' => $j])->toArray();
      $seikeiki_code = $GenjyouSeikeiki[0]->seikeiki_code;

      ${"n".$j} = 0;
      $this->set('n'.$j,${"n".$j});
         for($i=1; $i<=10; $i++){
           ${"arrP".$j.$i} = array();
           if(isset($KariKadouSeikei[$i-1])) {
             ${"KariKadouSeikei_id".$i} = $KariKadouSeikei[$i-1]->id;
             ${"product_code".$i} = $KariKadouSeikei[$i-1]->product_code;
             ${"seikeiki".$i} = $KariKadouSeikei[$i-1]->seikeiki;
             ${"seikeiki_code".$i} = $seikeiki_code;
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
     $this->request->session()->destroy(); // セッションの破棄
     session_start();
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);//
   }

		public function preadd()
		{
      $KadouSeikei = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikei',$KadouSeikei);
/*
      $session = $this->request->getSession();
      $data = $session->read();
      echo "<pre>";
      print_r($_SESSION['kadouseikei']);
      echo "</pre>";
*/
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
        //    return $this->redirect(['action' => 'docsvtest']);
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
          $connection = ConnectionManager::get('sakaeMotoDB');
          $table = TableRegistry::get('kadou_seikei');
          $table->setConnection($connection);

          for($k=1; $k<=count($_SESSION['kadouseikei']); $k++){
            $connection->insert('kadou_seikei', [
              'pro_num' => $_SESSION['kadouseikei'][$k]["product_code"],
              'seikeiki' => $_SESSION['kadouseikei'][$k]["seikeiki"],
              'seikeiki_id' => $_SESSION['kadouseikei'][$k]["seikeiki_code"],
              'starting_tm' => $_SESSION['kadouseikei'][$k]["starting_tm"],
              'finishing_tm' => $_SESSION['kadouseikei'][$k]["finishing_tm"],
              'cycle_shot' => $_SESSION['kadouseikei'][$k]["cycle_shot"],
              'amount_shot' => $_SESSION['kadouseikei'][$k]["amount_shot"],
              'accomp_rate' => $_SESSION['kadouseikei'][$k]["accomp_rate"],
              'present_kensahyou' => 0,
              'first_lot_num' => $_SESSION['kadouseikei'][$k]["first_lot_num"],
              'last_lot_num' => $_SESSION['kadouseikei'][$k]["last_lot_num"],
              'sum_predict_lot_num' => $_SESSION['kadouseikei'][$k]["sum_predict_lot_num"],
            ]);
          }

          $connection = ConnectionManager::get('default');
          $table->setConnection($connection);

          //big_DBに登録
          $connection = ConnectionManager::get('big_DB');
          $table = TableRegistry::get('ruby_kadou_seikeikis');
          $table->setConnection($connection);

            for($k=1; $k<=count($_SESSION['kadouseikei']); $k++){

              $sql = "SELECT product_code FROM ruby_kadou_seikeikis".
                    " where seikeiki = '".$_SESSION['kadouseikei'][$k]["seikeiki"]."' and starting_tm = '".$_SESSION['kadouseikei'][$k]["starting_tm"]."'";
              $connection = ConnectionManager::get('big_DB');
              $bigkadouSeikei = $connection->execute($sql)->fetchAll('assoc');

              if(isset($bigkadouSeikei[0])){//既に存在するデータの場合は登録しない

                $k = $k;

              }else{

                $connection->insert('ruby_kadou_seikeikis', [
                  'seikeiki' => $_SESSION['kadouseikei'][$k]["seikeiki"],
                  'product_code' => $_SESSION['kadouseikei'][$k]["product_code"],
                  'starting_tm' => $_SESSION['kadouseikei'][$k]["starting_tm"],
                  'finishing_tm' => $_SESSION['kadouseikei'][$k]["finishing_tm"],
                  'delete_flag' => 0
                ]);

              }

            }

          $connection = ConnectionManager::get('default');
          $table->setConnection($connection);

          for($n=1; $n<=100; $n++){
            if(isset($_SESSION['kadouseikei'][$n])){

              $KariKadouSeikeiData = $this->KariKadouSeikeis->find()->where(['id' => $_SESSION['kadouseikeiId'][$n]])->toArray();//'present_kensahyou' => 0となるデータをKadouSeikeisテーブルから配列で取得

              $this->KariKadouSeikeis->updateAll(
              ['present_kensahyou' => 1 , 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
              ['id'   => $_SESSION['kadouseikeiId'][$n] ]
              );

//旧DBを更新
              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('kari_kadou_seikei');
              $table->setConnection($connection);

              $product_id = $_SESSION['kadouseikei'][$n]["product_code"];
              $seikeiki = $_SESSION['kadouseikei'][$n]["seikeiki"];
              $starting_tm = $_SESSION['kadouseikei'][$n]["starting_tm"];

              $updater = "UPDATE kari_kadou_seikei set present_kensahyou = 1 where product_id ='".$product_id."' and seikeiki_id = '".$seikeiki."' and starting_tm = '".$starting_tm."'";//もとのDBも更新
              $connection->execute($updater);

              $connection = ConnectionManager::get('default');
              $table->setConnection($connection);

            }else{
              break;
            }
          }
          $mes = "※登録されました（/home/centosuser/kadouseikei_csvにCSVファイルが出力されました）";
          $this->set('mes',$mes);

          $connection->commit();// コミット5
        } else {
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);
          $this->Flash->error(__('データベースに登録できません。登録済のデータでないか確認してください。'));
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

//csv出力
    $arrkadouseikei_csv[] = ['product_code' => "product_code", 'seikeiki' => "seikeiki",
    'seikeiki_code' => "seikeiki_id", 'starting_tm' => "starting_tm", 'finishing_tm' => "finishing_tm",
    'cycle_shot' => "cycle_shot", 'amount_shot' => "amount_shot", 'accomp_rate' => "accomp_rate"];

    for($k=1; $k<=count($_SESSION['kadouseikei']); $k++){
      ${"starting_tm".$k} = $_SESSION['kadouseikei'][$k]["starting_tm"].":00";
      ${"finishing_tm".$k} = $_SESSION['kadouseikei'][$k]["finishing_tm"].":00";
      $day = mb_substr($_SESSION['kadouseikei'][1]["starting_tm"], 0, 10);

      $arrkadouseikei_csv[] = ['product_code' => $_SESSION['kadouseikei'][$k]["product_code"], 'seikeiki' => $_SESSION['kadouseikei'][$k]["seikeiki"],
      'seikeiki_code' => $_SESSION['kadouseikei'][$k]["seikeiki_code"], 'starting_tm' => ${"starting_tm".$k}, 'finishing_tm' => ${"finishing_tm".$k},
      'cycle_shot' => $_SESSION['kadouseikei'][$k]["cycle_shot"], 'amount_shot' => $_SESSION['kadouseikei'][$k]["amount_shot"], 'accomp_rate' => sprintf('%.2f',$_SESSION['kadouseikei'][$k]["accomp_rate"])];
    }

    $day = date('Y-n-j',strtotime($day));
    $file_name = "kadou_seikeis".$day.".csv";

    $fp = fopen('/home/centosuser/kadouseikei_csv/'.$file_name, 'w');
  //  $fp = fopen('kadouseikei_csv/'.$file_name, 'w');
      foreach ($arrkadouseikei_csv as $line) {
        $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
        fputcsv($fp, $line);
      }
      fclose($fp);

  }

  public function docsvtest()
 {
   $KadouSeikeis = $this->KadouSeikeis->newEntity();
   $this->set('KadouSeikeis',$KadouSeikeis);

   $mes = "※CSV出力テスト";
   $this->set('mes',$mes);

   $session = $this->request->getSession();
   $data = $session->read();
/*
   echo "<pre>";
   print_r($_SESSION['kadouseikei']);
   echo "</pre>";
*/
   for($n=1; $n<=100; $n++){
     if(isset($_SESSION['kadouseikei'][$n])){
       $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
       $_SESSION['kadouseikei'][$n] = array_merge($_SESSION['kadouseikei'][$n],$created_staff);
     }else{
       break;
     }
   }

//csv出力
    $arrkadouseikei_csv[] = ['product_code' => "product_code", 'seikeiki' => "seikeiki",
    'seikeiki_code' => "seikeiki_id", 'starting_tm' => "starting_tm", 'finishing_tm' => "finishing_tm",
    'cycle_shot' => "cycle_shot", 'amount_shot' => "amount_shot", 'accomp_rate' => "accomp_rate"];

   for($k=1; $k<=count($_SESSION['kadouseikei']); $k++){
     ${"starting_tm".$k} = $_SESSION['kadouseikei'][$k]["starting_tm"].":00";
     ${"finishing_tm".$k} = $_SESSION['kadouseikei'][$k]["finishing_tm"].":00";
     $day = mb_substr($_SESSION['kadouseikei'][1]["starting_tm"], 0, 10);

     $arrkadouseikei_csv[] = ['product_code' => $_SESSION['kadouseikei'][$k]["product_code"], 'seikeiki' => $_SESSION['kadouseikei'][$k]["seikeiki"],
     'seikeiki_code' => $_SESSION['kadouseikei'][$k]["seikeiki_code"], 'starting_tm' => "${"starting_tm".$k}", 'finishing_tm' => ${"finishing_tm".$k},
     'cycle_shot' => $_SESSION['kadouseikei'][$k]["cycle_shot"], 'amount_shot' => $_SESSION['kadouseikei'][$k]["amount_shot"], 'accomp_rate' => sprintf('%.2f',$_SESSION['kadouseikei'][$k]["accomp_rate"])];
   }

   echo "<pre>";
   print_r($arrkadouseikei_csv);
   echo "</pre>";

   $day = date('Y-n-j',strtotime($day));

   echo "<pre>";
   print_r($day);
   echo "</pre>";

   $file_name = "kadou_seikeis".$day.".csv";

  // $fp = fopen('/home/centosuser/kadouseikei_csv/'.$file_name, 'w');
   $fp = fopen('kadouseikei_csv/'.$file_name, 'w');
     foreach ($arrkadouseikei_csv as $line) {
       $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
       fputcsv($fp, $line);
     }
     fclose($fp);

/*
   $today = $_SESSION['kadouseikei'][$k]["seikeiki_code"];
//   $file_name_moto = "kadou_seikeis.csv";
   $file_name = "kadou_seikeis".$today.".csv";

//    $fp = fopen('/home/centosuser/kadouseikei_csv/kadou_test0622.csv', 'w');//OK（centosuser）
     $fp_moto = fopen('kadouseikei_csv/'.$file_name_moto, 'w');//OK(local)'data_IM測定/'.$folder.'/'.$file
       foreach ($arrkadouseikei_csv as $line) {
      //   $line = mb_convert_encoding($line, 'SJIS-win', 'UTF-8');//UTF-8の文字列をSJIS-winに変更する※文字列に使用、ファイルごとはできない
      //   $data = implode(",",$line);
      //      echo "<pre>";
      //      print_r($data);
      //      echo "</pre>";

         fputcsv($fp_moto, $line);
       }
       fclose($fp_moto);

       $fp2 = fopen('kadouseikei_csv/'.$file_name_moto, 'r');
        while (($data = fgetcsv($fp2)) !== FALSE) {
          $line_moto = $data[0].",".$data[1].",".$data[2].",".$data[3].",".$data[4].",".$data[5].",".$data[6].",".$data[7];

          $arrkadouseikei_csv_touroku[] = ['line' => $line_moto];

        }
        fclose($fp2);

        echo "<pre>";
        print_r($arrkadouseikei_csv_touroku);
        echo "</pre>";

        $fp = fopen('kadouseikei_csv/'.$file_name, 'w');//OK(local)'data_IM測定/'.$folder.'/'.$file
        foreach ($arrkadouseikei_csv_touroku as $line) {
          fputcsv($fp, $line);
        }
        fclose($fp);
*/
//スペースで分けて、３つにして、区切り文字をスペースにする

 }

  public function syuuseiday()//ロット検索
  {
    $this->request->session()->destroy(); // セッションの破棄
    $KadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('KadouSeikeis',$KadouSeikeis);
  }

  public function syuuseiichiran()//ロット検索
  {
    $KadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('KadouSeikeis',$KadouSeikeis);
    $data = $this->request->getData();

    $date_sta = $data['date_sta'];
    $date_fin = $data['date_fin'];

    $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
    $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];

    $product_code = $data['product_code'];
    $seikeiki = $data['seikeiki'];
//    $date_sta = $data['date_sta'];
//    $date_fin = $data['date_fin'];
    $date_fin = strtotime($date_fin);
    $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

    if(empty($data['product_code'])){//product_codeの入力がないとき
      $product_code = "no";
      if(empty($data['seikeiki'])){//seikeikiの入力がないとき　product_code×　seikeiki×　date〇
        $seikeiki = "no";//日にちだけで絞り込み
        $KadouSeikeis = $this->KadouSeikeis->find()
  //      ->where(['starting_tm >=' => $date_sta, 'starting_tm <=' => $date_fin, 'present_kensahyou' => 0])->order(["product_code"=>"ASC"]);//品番順に並び変える
        ->where(['starting_tm >=' => $date_sta, 'starting_tm <=' => $date_fin])->order(["product_code"=>"ASC"]);//品番順に並び変える
        $this->set('KadouSeikeis',$KadouSeikeis);

      }else{//seikeikiの入力があるとき　product_code×　seikeiki〇　date〇//seikeikiと日にちで絞り込み
        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $date_sta, 'starting_tm <=' => $date_fin, 'seikeiki' => $seikeiki])->order(["product_code"=>"ASC"]);
        $this->set('KadouSeikeis',$KadouSeikeis);

      }
    }else{//product_codeの入力があるとき
      if(empty($data['seikeiki'])){//seikeikiの入力がないとき　product_code〇　seikeiki×　date〇
        $seikeiki = "no";//プロダクトコードと日にちで絞り込み
        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $date_sta, 'starting_tm <=' => $date_fin, 'product_code' => $product_code])->order(["product_code"=>"ASC"]);
        $this->set('KadouSeikeis',$KadouSeikeis);

      }else{//seikeikiの入力があるとき　product_code〇　seikeiki〇　date〇//プロダクトコードとseikeikiと日にちで絞り込み
        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $date_sta, 'starting_tm <=' => $date_fin, 'seikeiki' => $seikeiki, 'product_code' => $product_code])->order(["product_code"=>"ASC"]);
        $this->set('KadouSeikeis',$KadouSeikeis);

      }
    }
  }

  public function kensakuform()//ロット検索
  {
    $this->request->session()->destroy(); // セッションの破棄
    $KadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('KadouSeikeis',$KadouSeikeis);

    $Data=$this->request->query('s');
    if(isset($Data["mess"])){
      $mess = $Data["mess"];
      $this->set('mess',$mess);
    }else{
      $mess = "";
      $this->set('mess',$mess);
    }

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

  public function kensakuview()//検索
  {
    $kadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('kadouSeikeis',$kadouSeikeis);
    $data = $this->request->getData();
/*
    echo "<pre>";
    print_r($data);
    echo "</pre>";
*/

    $date_sta = $data['date_sta_year']."-".$data['date_sta_month']."-".$data['date_sta_date'];
    $date_fin = $data['date_fin_year']."-".$data['date_fin_month']."-".$data['date_fin_date'];

    $product_code = $data['product_code'];
    $seikeiki = $data['seikeiki'];

    $date_fin = strtotime($date_fin);
    $date_fin = date('Y-m-d', strtotime('+1 day', $date_fin));

//    $starting_tm_search = substr($KadouSeikeis[$n]['starting_tm'], 0, 10);
    $starting_tm_search = $date_sta." 08:00:00";
    $finishing_tm_search = strtotime($starting_tm_search);
    $finishing_tm_search = date('Y/m/d H:i:s', strtotime('+1 day', $finishing_tm_search));
/*
    echo "<pre>";
    print_r($starting_tm_search." ~ ".$finishing_tm_search);
    echo "</pre>";
*/
    $check_product = 0;
    if(empty($data['product_code'])){//product_codeの入力がないとき
      $product_code = "no";
      if(empty($data['seikeiki'])){//seikeikiの入力がないとき　product_code×　seikeiki×　date〇
        $seikeiki = "no";//日にちだけで絞り込み

        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $starting_tm_search, 'starting_tm <' => $finishing_tm_search])->order(["seikeiki"=>"ASC"])->toArray();
        $this->set('KadouSeikeis',$KadouSeikeis);

      }else{//seikeikiの入力があるとき　product_code×　seikeiki〇　date〇//seikeikiと日にちで絞り込み

        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $starting_tm_search, 'starting_tm <' => $finishing_tm_search, 'seikeiki' => $seikeiki])->order(["seikeiki"=>"ASC"])->toArray();
        $this->set('KadouSeikeis',$KadouSeikeis);

      }
    }else{//product_codeの入力があるとき
      $check_product = 1;

      if(empty($data['seikeiki'])){//seikeikiの入力がないとき　product_code〇　seikeiki×　date〇
        $seikeiki = "no";//プロダクトコードと日にちで絞り込み

        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $starting_tm_search, 'starting_tm <' => $finishing_tm_search, 'product_code like' => '%'.$product_code.'%'])->order(["seikeiki"=>"ASC"])->toArray();
        $this->set('KadouSeikeis',$KadouSeikeis);

      }else{//seikeikiの入力があるとき　product_code〇　seikeiki〇　date〇//プロダクトコードとseikeikiと日にちで絞り込み

        $KadouSeikeis = $this->KadouSeikeis->find()
        ->where(['starting_tm >=' => $starting_tm_search, 'starting_tm <' => $finishing_tm_search, 'seikeiki' => $seikeiki, 'product_code like' => '%'.$product_code.'%'])->order(["seikeiki"=>"ASC"])->toArray();
        $this->set('KadouSeikeis',$KadouSeikeis);

      }

    }

    $this->set('check_product',$check_product);
/*
    echo "<pre>";
    print_r($KadouSeikeis);
    echo "</pre>";
*/
    if($check_product == 0 && count($KadouSeikeis) > 0){//品番で絞り込んでいない場合

      if(isset($KadouSeikeis[0])){

        foreach( $KadouSeikeis as $key => $row ) {
          $tmp_seikeiki[$key] = $row["seikeiki"];
          $tmp_starting_tm[$key] = $row["starting_tm"];
        }

        array_multisort( $tmp_seikeiki, SORT_ASC, $tmp_starting_tm, SORT_ASC, $KadouSeikeis);

        for ($k=0; $k<count($KadouSeikeis); $k++){

          $connection = ConnectionManager::get('big_DB');//旧DBを参照
          $table = TableRegistry::get('log_confirm_kadou_seikeikis');
          $table->setConnection($connection);

          $sql = "SELECT amount_programming FROM log_confirm_kadou_seikeikis".
          " where starting_tm_nippou = '".$KadouSeikeis[$k]["starting_tm"]."' and product_code = '".$KadouSeikeis[$k]["product_code"]."' and seikeiki = '".$KadouSeikeis[$k]["seikeiki"]."' order by product_code asc";
          $connection = ConnectionManager::get('big_DB');
          $log_confirm_kadou_seikeikis = $connection->execute($sql)->fetchAll('assoc');

          if(isset($log_confirm_kadou_seikeikis[0])){
            $amount_programming = $log_confirm_kadou_seikeikis[0]["amount_programming"];
          }else{
            $amount_programming = "データベースに存在しません";
          }

          $connection = ConnectionManager::get('default');
          $table->setConnection($connection);

          $arramount_programming = array('amount_programming'=>$amount_programming);
          $KadouSeikeis[$k] = array_merge($KadouSeikeis[$k]->toArray(), $arramount_programming);

          if($KadouSeikeis[$k]["product_code"] === "W002"){

            $KadouSeikeis[$k]['amount_shot'] = $KadouSeikeis[$k]['amount_shot'] * 2;

          }

        }

      }

      $this->set('countkadouSeikei',count($KadouSeikeis));
/*
      echo "<pre>";
      print_r($KadouSeikeis);
      echo "</pre>";
*/

//以下稼働率を各成形機ごとに計算

      $day1 = strtotime($date_sta);
      $day2 = strtotime($date_fin);
      $diff = ($day2 - $day1) / (60 * 60 * 24);

      //開始時時間と終了時間を持ってくる
      $arrStartTime = array();
      $arrFinishTime = array();
      for($n=0; $n<count($KadouSeikeis); $n++){

        $starting_tm = substr($KadouSeikeis[$n]['starting_tm'], 0, 10);
        $starting_tm = $starting_tm." 08:00:00";
        $finishing_tm = strtotime($starting_tm);
        $finishing_tm = date('Y/m/d H:i:s', strtotime('+1 day', $finishing_tm));

        $flag_start = 1;
        $flag_finish = 2;
        $connection = ConnectionManager::get('big_DB');//旧DBを参照
        $table = TableRegistry::get('log_confirm_kadou_seikeikis');
        $table->setConnection($connection);

        $sql = "SELECT datetime,seikeiki,product_code,shot_cycle,flag_start_finish
        FROM shotdata_sensors".
        " where datetime >= '".$starting_tm."' and datetime < '".$finishing_tm."'
         and seikeiki = '".$KadouSeikeis[$n]["seikeiki"]."' and flag_start_finish = '".$flag_start."' order by datetime asc";
        $connection = ConnectionManager::get('big_DB');
        $arrFlag_start = $connection->execute($sql)->fetchAll('assoc');

        $sql = "SELECT datetime,seikeiki,product_code,shot_cycle,flag_start_finish
        FROM shotdata_sensors".
        " where datetime >= '".$starting_tm."' and datetime < '".$finishing_tm."'
         and seikeiki = '".$KadouSeikeis[$n]["seikeiki"]."' and flag_start_finish = '".$flag_finish."' order by datetime asc";
        $connection = ConnectionManager::get('big_DB');
        $arrFlag_finish = $connection->execute($sql)->fetchAll('assoc');

        $connection = ConnectionManager::get('default');
        $table->setConnection($connection);

        if(count($arrFlag_start) < count($arrFlag_finish)){
          $countbig = count($arrFlag_finish);
        }else{
          $countbig = count($arrFlag_start);
        }

        for($m=0; $m<$countbig; $m++){

          if(!isset($arrFlag_start[$m])){
            $arrFlag_start[] = [
              'datetime' => $starting_tm,
              'seikeiki' => $KadouSeikeis[$n]["seikeiki"]
            ];
          }
          if(!isset($arrFlag_finish[$m])){
            $arrFlag_finish[] = [
              'datetime' => $finishing_tm,
              'seikeiki' => $KadouSeikeis[$n]["seikeiki"]
            ];
          }

        }
/*
        echo "<pre>";
        print_r($n);
        echo "</pre>";
        echo "<pre>";
        print_r($arrFlag_start);
        echo "</pre>";
        echo "<pre>";
        print_r($arrFlag_finish);
        echo "</pre>";
*/
        for($m=0; $m<count($arrFlag_start); $m++){
          $arrStartTime[] = $arrFlag_start[$m];
        }
        for($m=0; $m<count($arrFlag_finish); $m++){
          $arrFinishTime[] = $arrFlag_finish[$m];
        }

      }

      $arrStartTime = array_unique($arrStartTime, SORT_REGULAR);
      $arrStartTime = array_values($arrStartTime);
      $arrFinishTime = array_unique($arrFinishTime, SORT_REGULAR);
      $arrFinishTime = array_values($arrFinishTime);

      $count = count($arrStartTime);
      $countFinishTime = count($arrFinishTime);

      for($l=0; $l<$count; $l++){

        if(!isset($arrFinishTime[$l]['datetime'])){
          $FinishTime = $finishing_tm;
        }else{
          $FinishTime = $arrFinishTime[$l]['datetime'];
        }

        $arrStartTimestuika = array('program_starting_tm'=>$arrStartTime[$l]['datetime']);
        $KadouSeikeis[$l] = array_merge($KadouSeikeis[$l], $arrStartTimestuika);

        $arrFinishTimestuika = array('program_finishing_tm'=>$FinishTime);
        $KadouSeikeis[$l] = array_merge($KadouSeikeis[$l], $arrFinishTimestuika);

      }
/*
      echo "<pre>";
      print_r($n." ".$count." ".$countFinishTime);
      echo "</pre>";

      echo "<pre>";
      print_r($arrStartTime);
      echo "</pre>";
      echo "<pre>";
      print_r($arrFinishTime);
      echo "</pre>";
*/
      $numkadouritu = 0;

      for($n=0; $n<=count($KadouSeikeis); $n++){//絞り込んだデータそれぞれに対して
  //      for($n=0; $n<=4; $n++){//絞り込んだデータそれぞれに対して

        for($m=1; $m<10; $m++){//成形機1～9に対して

          for($l=0; $l<$diff; $l++){//それぞれの日付に対して

            $groupday = strtotime("+$l day " . $date_sta);
            $groupday = date("Y-m-d", $groupday);
            $p = $l + 1;
            $groupdayto = strtotime("+$p day " . $date_sta);
            $groupdayto = date("Y-m-d", $groupdayto);

            if((($n < count($KadouSeikeis)) && ($KadouSeikeis[$n]["seikeiki"] == $m) && (strtotime($KadouSeikeis[$n]["starting_tm"]) > strtotime($groupday)) && (strtotime($KadouSeikeis[$n]["starting_tm"]) < strtotime($groupdayto)))){//同じ日の同じ成形機の仲間

              $n1 = $n - 1;

              if(isset($KadouSeikeis[$n1])){//1つ前のデータが存在する時

                $connection = ConnectionManager::get('big_DB');//旧DBを参照
                $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                $table->setConnection($connection);

                $sql = "SELECT lot_code,starting_tm_nippou,starting_tm_program,finishing_tm_nippou,
                finishing_tm_program,shot_cycle_nippou,shot_cycle_mode,amount_nippou,amount_programming,status_shot_cycle,non_production_time
                FROM log_confirm_kadou_seikeikis".
                " where starting_tm_nippou = '".$KadouSeikeis[$n1]["starting_tm"]."' and product_code = '".$KadouSeikeis[$n1]["product_code"]."' and seikeiki = '".$KadouSeikeis[$n1]["seikeiki"]."'";
                $connection = ConnectionManager::get('big_DB');
                $log_confirm_kadou_seikeikis = $connection->execute($sql)->fetchAll('assoc');

                $sql = "SELECT datetime,seikeiki,shot_cycle
                FROM shotdata_sensors".
                " where datetime >= '".$KadouSeikeis[$n1]["program_starting_tm"]."' and datetime <= '".$KadouSeikeis[$n1]["program_finishing_tm"]."'  and seikeiki = '".$KadouSeikeis[$n1]["seikeiki"]."'";
                $connection = ConnectionManager::get('big_DB');
                $shotdata_sensors = $connection->execute($sql)->fetchAll('assoc');

                $connection = ConnectionManager::get('default');
                $table->setConnection($connection);
/*
                echo "<pre>";
                print_r($n);
                echo "</pre>";
                echo "<pre>";
                print_r(count($log_confirm_kadou_seikeikis));
                echo "</pre>";
*/
                if(count($log_confirm_kadou_seikeikis) > 0){//log_confirm_kadou_seikeikisテーブルに存在する時

                  if($log_confirm_kadou_seikeikis[0]["status_shot_cycle"] == 1){//status_shot_cycle=1の場合は計算せず$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]を使う

                    $shot_cycle = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];

                  }else{//status_shot_cycle!=1の場合は計算,status_shot_cycleを1にアップデート

                    $countshot_cycle_mode = 0;
                    $totalshot_cycle_mode = 0;
                    $shot_cycle = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];
                    for($k=0; $k<count($shotdata_sensors); $k++){
                      if(($shotdata_sensors[$k]["shot_cycle"] <= $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"] + 1) && ($shotdata_sensors[$k]["shot_cycle"] >= $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"] - 1)){
                        $countshot_cycle_mode = $countshot_cycle_mode + 1;
                        $totalshot_cycle_mode = $totalshot_cycle_mode + $shotdata_sensors[$k]["shot_cycle"];
                        $shot_cycle = round($totalshot_cycle_mode/$countshot_cycle_mode, 1);//小数点以下1桁
                      }
                    }

                    $status = 1;
                    //big_DB
                    $connection = ConnectionManager::get('big_DB');//big_DBを参照
                    $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                    $table->setConnection($connection);

                    $updater = "UPDATE log_confirm_kadou_seikeikis set status_shot_cycle = '".$status."', shot_cycle_mode = '".$shot_cycle."', updated_at ='".date('Y-m-d H:i:s')."'
                    where starting_tm_program ='".$KadouSeikeis[$n1]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n1]["product_code"]."'";
                    $connection->execute($updater);

                    $connection = ConnectionManager::get('default');//新DBに戻る
                    $table->setConnection($connection);

                  }

          //        $starting_tm_program = $log_confirm_kadou_seikeikis[0]["starting_tm_program"];
          //        $finishing_tm_program = $log_confirm_kadou_seikeikis[0]["finishing_tm_program"];

                  $starting_tm_program = $KadouSeikeis[$n1]["program_starting_tm"];
                  $finishing_tm_program = $KadouSeikeis[$n1]["program_finishing_tm"];

                  $start_program = strtotime($starting_tm_program);
                  $finish_program = strtotime($finishing_tm_program);
                  $diff_program = ($finish_program - $start_program);//生産時間
                  $riron_shot_amount = round($diff_program/$shot_cycle);//理論ショット数

                  $accomp_rate_program = round($KadouSeikeis[$n1]['amount_programming'] / $riron_shot_amount, 3);
                  if($accomp_rate_program > 1){
                    $accomp_rate_program = 1;
                  }
                  $arraccomp_rate_program = array('accomp_rate_program'=>$accomp_rate_program);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arraccomp_rate_program);

                  $riron_loss_shot = $riron_shot_amount - $log_confirm_kadou_seikeikis[0]["amount_programming"];
                  if($riron_loss_shot > 0){//ロスがある場合
                    $riron_loss_time = $riron_loss_shot * $shot_cycle;
                  }else{
                    $riron_loss_time = 0;
                  }
  /*
                  echo "<pre>";
                  print_r($riron_loss_shot." = ".$riron_shot_amount." - ".$log_confirm_kadou_seikeikis[0]["amount_programming"]);
                  echo "</pre>";
  */
                  $kobetu_loss_time = round($riron_loss_time/60 ,1);

                  if(!empty($log_confirm_kadou_seikeikis[0]["non_production_time"])){//non_production_timeが登録されているとき

                    $kobetu_loss_time = round($riron_loss_time/60 ,1);

                  }else{//non_production_timeが登録されていないとき

                    //big_DB
                    $connection = ConnectionManager::get('big_DB');//big_DBを参照
                    $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                    $table->setConnection($connection);

                    $updater = "UPDATE log_confirm_kadou_seikeikis set non_production_time = '".$kobetu_loss_time."', rate_achievement = '".$accomp_rate_program."', updated_at ='".date('Y-m-d H:i:s')."'
                    where starting_tm_program ='".$KadouSeikeis[$n1]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n1]["product_code"]."'";
                    $connection->execute($updater);

                    $connection = ConnectionManager::get('default');//新DBに戻る
                    $table->setConnection($connection);

                  }

                  $arrkobetu_loss_time = array('kobetu_loss_time'=>$kobetu_loss_time);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrkobetu_loss_time);

                  $riron_seisan_time = ($diff_program - $riron_loss_time)*60;
                  $arrriron_seisan_time = array('riron_seisan_time'=>$riron_seisan_time);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_seisan_time);

                  $arrriron_loss_time = array('riron_loss_time'=>$riron_loss_time);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_loss_time);

                  $arrriron_shot_amount = array('riron_shot_amount'=>$riron_shot_amount);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_shot_amount);

                  $arrshot_cycle = array('shot_cycle'=>$shot_cycle);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle);

                  $arrshot_cycle_mode = array('shot_cycle_mode'=>$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle_mode);

                  $arrnumkadouritu = array('numkadouritu'=>$numkadouritu);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrnumkadouritu);

                }else{//log_confirm_kadou_seikeikisテーブルにデータが存在しない時

                  $arrshot_cycle = array('shot_cycle'=>"データベースに存在しません");
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle);
                  $arraccomp_rate_program = array('accomp_rate_program'=>0);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arraccomp_rate_program);
                  $arrkobetu_loss_time = array('kobetu_loss_time'=>0);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrkobetu_loss_time);
                  $arrnumkadouritu = array('numkadouritu'=>$numkadouritu);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrnumkadouritu);
                  $arrriron_loss_time = array('riron_loss_time'=>0);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_loss_time);

                }

              }


              if(($n > 0) && ($KadouSeikeis[$n-1]['seikeiki'] == $KadouSeikeis[$n]['seikeiki']) && ($KadouSeikeis[$n-1]['starting_tm']->format('Y-m-d') == $KadouSeikeis[$n]['starting_tm']->format('Y-m-d'))){

                $numkadouritu = $numkadouritu;

              }else{

                $numkadouritu = $numkadouritu + 1;

              }

            }elseif($n == count($KadouSeikeis)){//最後の行の時,前の行と同じ仲間かチェック

              $n1 = $n - 1;

              //前の行と同じ仲間の場合
              if(isset($KadouSeikeis[$n1-1]['seikeiki']) && ($KadouSeikeis[$n1-1]['seikeiki'] == $KadouSeikeis[$n1]['seikeiki']) && ($KadouSeikeis[$n1-1]['starting_tm']->format('Y-m-d') == $KadouSeikeis[$n1]['starting_tm']->format('Y-m-d'))){

                $connection = ConnectionManager::get('big_DB');//旧DBを参照
                $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                $table->setConnection($connection);

                $sql = "SELECT lot_code,starting_tm_nippou,starting_tm_program,finishing_tm_nippou,
                finishing_tm_program,shot_cycle_nippou,shot_cycle_mode,amount_nippou,amount_programming,status_shot_cycle
                FROM log_confirm_kadou_seikeikis".
                " where starting_tm_nippou = '".$KadouSeikeis[$n1]["starting_tm"]."' and product_code = '".$KadouSeikeis[$n1]["product_code"]."' and seikeiki = '".$KadouSeikeis[$n1]["seikeiki"]."'";
                $connection = ConnectionManager::get('big_DB');
                $log_confirm_kadou_seikeikis = $connection->execute($sql)->fetchAll('assoc');

                $sql = "SELECT datetime,seikeiki,shot_cycle
                FROM shotdata_sensors".
                " where datetime >= '".$KadouSeikeis[$n1]["program_starting_tm"]."' and datetime <= '".$KadouSeikeis[$n1]["program_finishing_tm"]."'  and seikeiki = '".$KadouSeikeis[$n1]["seikeiki"]."'";
                $connection = ConnectionManager::get('big_DB');
                $shotdata_sensors = $connection->execute($sql)->fetchAll('assoc');

                $connection = ConnectionManager::get('default');
                $table->setConnection($connection);

              if(count($log_confirm_kadou_seikeikis) > 0){//log_confirm_kadou_seikeikisテーブルに存在する時

                //status_shot_cycle=1の場合は計算せず$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]を使う
                if($log_confirm_kadou_seikeikis[0]["status_shot_cycle"] == 1){//status_shot_cycle=1の場合は計算せず$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]を使う

                  $shot_cycle = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];

                }else{//status_shot_cycle!=1の場合は計算,status_shot_cycleを1にアップデート

                  $countshot_cycle_mode = 0;
                  $totalshot_cycle_mode = 0;
                  $shot_cycle = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];
                  for($k=0; $k<count($shotdata_sensors); $k++){
                    if(($shotdata_sensors[$k]["shot_cycle"] <= $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"] + 1) && ($shotdata_sensors[$k]["shot_cycle"] >= $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"] - 1)){
                      $countshot_cycle_mode = $countshot_cycle_mode + 1;
                      $totalshot_cycle_mode = $totalshot_cycle_mode + $shotdata_sensors[$k]["shot_cycle"];
                      $shot_cycle = round($totalshot_cycle_mode/$countshot_cycle_mode, 1);//小数点以下1桁
                    }
                  }

                  $status = 1;
                  //big_DB
                  $connection = ConnectionManager::get('big_DB');//big_DBを参照
                  $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                  $table->setConnection($connection);

                  $updater = "UPDATE log_confirm_kadou_seikeikis set status_shot_cycle = '".$status."', shot_cycle_mode = '".$shot_cycle."', updated_at ='".date('Y-m-d H:i:s')."'
                  where starting_tm_program ='".$KadouSeikeis[$n1]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n1]["product_code"]."'";
                  $connection->execute($updater);

                  $connection = ConnectionManager::get('default');//新DBに戻る
                  $table->setConnection($connection);

                }

                //        $starting_tm_program = $log_confirm_kadou_seikeikis[0]["starting_tm_program"];
                //        $finishing_tm_program = $log_confirm_kadou_seikeikis[0]["finishing_tm_program"];

                $starting_tm_program = $KadouSeikeis[$n1]["program_starting_tm"];
                $finishing_tm_program = $KadouSeikeis[$n1]["program_finishing_tm"];

                $start_program = strtotime($starting_tm_program);
                $finish_program = strtotime($finishing_tm_program);
                $diff_program = ($finish_program - $start_program);//生産時間
                $riron_shot_amount = round($diff_program/$shot_cycle);//理論ショット数

                $accomp_rate_program = round($KadouSeikeis[$n1]['amount_programming'] / $riron_shot_amount, 3);
                if($accomp_rate_program > 1){
                  $accomp_rate_program = 1;
                }
                $arraccomp_rate_program = array('accomp_rate_program'=>$accomp_rate_program);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arraccomp_rate_program);

                $riron_loss_shot = $riron_shot_amount - $log_confirm_kadou_seikeikis[0]["amount_programming"];
                if($riron_loss_shot > 0){//ロスがある場合
                  $riron_loss_time = $riron_loss_shot * $shot_cycle;
                }else{
                  $riron_loss_time = 0;
                }

                $kobetu_loss_time = round($riron_loss_time/60 ,1);

                if(!empty($log_confirm_kadou_seikeikis[0]["non_production_time"])){//non_production_timeが登録されているとき

                  $kobetu_loss_time = round($riron_loss_time/60 ,1);

                }else{//non_production_timeが登録されていないとき

                  //big_DB
                  $connection = ConnectionManager::get('big_DB');//big_DBを参照
                  $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                  $table->setConnection($connection);

                  $updater = "UPDATE log_confirm_kadou_seikeikis set non_production_time = '".$kobetu_loss_time."', rate_achievement = '".$accomp_rate_program."', updated_at ='".date('Y-m-d H:i:s')."'
                  where starting_tm_program ='".$KadouSeikeis[$n1]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n1]["product_code"]."'";
                  $connection->execute($updater);

                  $connection = ConnectionManager::get('default');//新DBに戻る
                  $table->setConnection($connection);

                }

                $arrkobetu_loss_time = array('kobetu_loss_time'=>$kobetu_loss_time);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrkobetu_loss_time);

                $riron_seisan_time = ($diff_program - $riron_loss_time)*60;
                $arrriron_seisan_time = array('riron_seisan_time'=>$riron_seisan_time);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_seisan_time);

                $arrriron_loss_time = array('riron_loss_time'=>$riron_loss_time);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_loss_time);

                $arrriron_shot_amount = array('riron_shot_amount'=>$riron_shot_amount);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_shot_amount);

                $arrshot_cycle = array('shot_cycle'=>$shot_cycle);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle);

                $arrshot_cycle_mode = array('shot_cycle_mode'=>$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle_mode);

                $arrnumkadouritu = array('numkadouritu'=>$numkadouritu);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrnumkadouritu);

              }else{//log_confirm_kadou_seikeikisテーブルにデータが存在しない時

                $arrshot_cycle = array('shot_cycle'=>"データベースに存在しません");
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle);
                $arraccomp_rate_program = array('accomp_rate_program'=>0);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arraccomp_rate_program);
                $arrkobetu_loss_time = array('kobetu_loss_time'=>0);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrkobetu_loss_time);
                $arrnumkadouritu = array('numkadouritu'=>$numkadouritu);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrnumkadouritu);
                $arrriron_loss_time = array('riron_loss_time'=>0);
                $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_loss_time);

              }


              }else{//前の行と同じ仲間ではない場合

                $connection = ConnectionManager::get('big_DB');//旧DBを参照
                $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                $table->setConnection($connection);

                $sql = "SELECT lot_code,starting_tm_nippou,starting_tm_program,finishing_tm_nippou,
                finishing_tm_program,shot_cycle_nippou,shot_cycle_mode,amount_nippou,amount_programming,status_shot_cycle,non_production_time
                FROM log_confirm_kadou_seikeikis".
                " where starting_tm_nippou = '".$KadouSeikeis[$n1]["starting_tm"]."' and product_code = '".$KadouSeikeis[$n1]["product_code"]."' and seikeiki = '".$KadouSeikeis[$n1]["seikeiki"]."'";
                $connection = ConnectionManager::get('big_DB');
                $log_confirm_kadou_seikeikis = $connection->execute($sql)->fetchAll('assoc');

                $sql = "SELECT datetime,seikeiki,product_code,shot_cycle
                FROM shotdata_sensors".
                " where datetime >= '".$groupday."' and datetime <= '".$groupdayto."' and product_code = '".$KadouSeikeis[$n1]["product_code"]."' and seikeiki = '".$KadouSeikeis[$n1]["seikeiki"]."'";
                $connection = ConnectionManager::get('big_DB');
                $shotdata_sensors = $connection->execute($sql)->fetchAll('assoc');

                $connection = ConnectionManager::get('default');
                $table->setConnection($connection);

                if(count($log_confirm_kadou_seikeikis) > 0){//log_confirm_kadou_seikeikisテーブルに存在する時

                  if($log_confirm_kadou_seikeikis[0]["status_shot_cycle"] == 1){//status_shot_cycle=1の場合は計算せず$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]を使う

                    $shot_cycle = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];

                  }else{//status_shot_cycle!=1の場合は計算,status_shot_cycleを1にアップデート

                    $countshot_cycle_mode = 0;
                    $totalshot_cycle_mode = 0;
                    $shot_cycle = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];
                    for($k=0; $k<count($shotdata_sensors); $k++){
                      if(($shotdata_sensors[$k]["shot_cycle"] <= $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"] + 1) && ($shotdata_sensors[$k]["shot_cycle"] >= $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"] - 1)){
                        $countshot_cycle_mode = $countshot_cycle_mode + 1;
                        $totalshot_cycle_mode = $totalshot_cycle_mode + $shotdata_sensors[$k]["shot_cycle"];
                        $shot_cycle = round($totalshot_cycle_mode/$countshot_cycle_mode, 1);//小数点以下1桁
                      }
                    }

                    $status = 1;
                    //big_DB
                    $connection = ConnectionManager::get('big_DB');//big_DBを参照
                    $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                    $table->setConnection($connection);

                    $updater = "UPDATE log_confirm_kadou_seikeikis set status_shot_cycle = '".$status."', shot_cycle_mode = '".$shot_cycle."', updated_at ='".date('Y-m-d H:i:s')."'
                    where starting_tm_program ='".$KadouSeikeis[$n1]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n1]["product_code"]."'";
                    $connection->execute($updater);

                    $connection = ConnectionManager::get('default');//新DBに戻る
                    $table->setConnection($connection);

                  }

                  //        $starting_tm_program = $log_confirm_kadou_seikeikis[0]["starting_tm_program"];
                  //        $finishing_tm_program = $log_confirm_kadou_seikeikis[0]["finishing_tm_program"];

                  $starting_tm_program = $KadouSeikeis[$n1]["program_starting_tm"];
                  $finishing_tm_program = $KadouSeikeis[$n1]["program_finishing_tm"];

                  $start_program = strtotime($starting_tm_program);
                  $finish_program = strtotime($finishing_tm_program);
                  $diff_program = ($finish_program - $start_program);//生産時間
                  $riron_shot_amount = round($diff_program/$shot_cycle);//理論ショット数

                  $accomp_rate_program = round($KadouSeikeis[$n1]['amount_programming'] / $riron_shot_amount, 3);
                  if($accomp_rate_program > 1){
                    $accomp_rate_program = 1;
                  }
                  $arraccomp_rate_program = array('accomp_rate_program'=>$accomp_rate_program);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arraccomp_rate_program);

                  $riron_loss_shot = $riron_shot_amount - $log_confirm_kadou_seikeikis[0]["amount_programming"];
                  if($riron_loss_shot > 0){//ロスがある場合
                    $riron_loss_time = $riron_loss_shot * $shot_cycle;
                  }else{
                    $riron_loss_time = 0;
                  }

                  $riron_seisan_time = ($diff_program - $riron_loss_time)*60;
                  $arrriron_seisan_time = array('riron_seisan_time'=>$riron_seisan_time);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_seisan_time);

                  $kobetu_loss_time = round($riron_loss_time/60 ,1);

                  if(!empty($log_confirm_kadou_seikeikis[0]["non_production_time"])){//non_production_timeが登録されているとき

                    $kobetu_loss_time = round($riron_loss_time/60 ,1);

                  }else{//non_production_timeが登録されていないとき

                    //big_DB
                    $connection = ConnectionManager::get('big_DB');//big_DBを参照
                    $table = TableRegistry::get('log_confirm_kadou_seikeikis');
                    $table->setConnection($connection);

                    $updater = "UPDATE log_confirm_kadou_seikeikis set non_production_time = '".$kobetu_loss_time."', rate_achievement = '".$accomp_rate_program."', updated_at ='".date('Y-m-d H:i:s')."'
                    where starting_tm_program ='".$KadouSeikeis[$n1]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n1]["product_code"]."'";
                    $connection->execute($updater);

                    $connection = ConnectionManager::get('default');//新DBに戻る
                    $table->setConnection($connection);

                  }

                  $arrkobetu_loss_time = array('kobetu_loss_time'=>$kobetu_loss_time);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrkobetu_loss_time);

                  $arrriron_loss_time = array('riron_loss_time'=>$riron_loss_time);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_loss_time);

                  $arrriron_shot_amount = array('riron_shot_amount'=>$riron_shot_amount);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_shot_amount);

                  $arrshot_cycle = array('shot_cycle'=>$shot_cycle);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle);

                  $arrshot_cycle_mode = array('shot_cycle_mode'=>$log_confirm_kadou_seikeikis[0]["shot_cycle_mode"]);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle_mode);

                  $arrnumkadouritu = array('numkadouritu'=>$numkadouritu);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrnumkadouritu);

                }else{//log_confirm_kadou_seikeikisテーブルにデータが存在しない時

                  $arrshot_cycle = array('shot_cycle'=>"データベースに存在しません");
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrshot_cycle);
                  $arraccomp_rate_program = array('accomp_rate_program'=>0);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arraccomp_rate_program);
                  $arrkobetu_loss_time = array('kobetu_loss_time'=>0);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrkobetu_loss_time);
                  $arrnumkadouritu = array('numkadouritu'=>$numkadouritu);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrnumkadouritu);
                  $arrriron_loss_time = array('riron_loss_time'=>0);
                  $KadouSeikeis[$n1] = array_merge($KadouSeikeis[$n1], $arrriron_loss_time);

                }

              }

            }

          }

        }

      }

//型替え時間を計算

$katagae_time = 0;
$seisan_time = 0;
for($n=0; $n<count($KadouSeikeis); $n++){

    if(($n > 0) && ($KadouSeikeis[$n]["numkadouritu"] == $KadouSeikeis[$n-1]["numkadouritu"])){

//      $starting_tm_kadou = strtotime($KadouSeikeis[$n]["starting_tm"]);
//      $finishing_tm_kadou = strtotime($KadouSeikeis[$n-1]["finishing_tm"]);

      $starting_tm_kadou = strtotime($KadouSeikeis[$n]["program_starting_tm"]);
      $finishing_tm_kadou = strtotime($KadouSeikeis[$n-1]["program_finishing_tm"]);

      $connection = ConnectionManager::get('big_DB');//旧DBを参照
      $table = TableRegistry::get('log_confirm_kadou_seikeikis');
      $table->setConnection($connection);

      $sql = "SELECT time_mold_change,before_product_code
      FROM log_confirm_kadou_seikeikis".
      " where starting_tm_program ='".$KadouSeikeis[$n]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n]["product_code"]."'";
      $connection = ConnectionManager::get('big_DB');
      $log_confirm_time_mold_change = $connection->execute($sql)->fetchAll('assoc');

      $connection = ConnectionManager::get('default');
      $table->setConnection($connection);
/*
      echo "<pre>";
      print_r($log_confirm_time_mold_change[0]["time_mold_change"]);
      echo "</pre>";
*/
      if(!empty($log_confirm_time_mold_change[0]["time_mold_change"])){//登録されている場合

        $katagae_time = round(($log_confirm_time_mold_change[0]["time_mold_change"]) / 60 , 1);//生産時間（分）

        $arrkatagae_time = array('katagae_time'=>$katagae_time);
        $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrkatagae_time);

      }else{

        $katagae_time = round($katagae_time + ($starting_tm_kadou - $finishing_tm_kadou) / 60 , 1);//生産時間（分）

        $arrkatagae_time = array('katagae_time'=>$katagae_time);
        $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrkatagae_time);

      }

  //    $katagae_time = round($katagae_time + ($starting_tm_kadou - $finishing_tm_kadou) / 60 , 1);//生産時間（分）

  //    $arrkatagae_time = array('katagae_time'=>$katagae_time);
  //    $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrkatagae_time);

      $total_loss_time = round($katagae_time + ($KadouSeikeis[$n]["riron_loss_time"] / 60) , 1);

      $arrtotal_loss_time = array('total_loss_time'=>$total_loss_time);
      $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrtotal_loss_time);

      $kadouritsu = round(1 - (($total_loss_time * 60) / 86400), 3);
      $arrkadouritsu = array('kadouritsu'=>$kadouritsu);
      $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrkadouritsu);

      $katagae_time_touroku = $katagae_time * 60 ;
/*
      echo "<pre>";
      print_r("before  ".$katagae_time_touroku." ".$KadouSeikeis[$n-1]["product_code"]." ".$KadouSeikeis[$n]["product_code"]." ".$KadouSeikeis[$n]["program_starting_tm"]);
      echo "</pre>";
*/
      if(!empty($log_confirm_time_mold_change[0]["time_mold_change"])){//既に登録されている場合

        $katagae_time = 0;
        $seisan_time = 0;

      }else{

        //big_DB
        $connection = ConnectionManager::get('big_DB');//big_DBを参照
        $table = TableRegistry::get('log_confirm_kadou_seikeikis');
        $table->setConnection($connection);

        $updater = "UPDATE log_confirm_kadou_seikeikis set time_mold_change = '".$katagae_time_touroku."' ,before_product_code = '".$KadouSeikeis[$n-1]["product_code"]."' , updated_at ='".date('Y-m-d H:i:s')."'
        where starting_tm_program ='".$KadouSeikeis[$n]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n]["product_code"]."'";
        $connection->execute($updater);

        $connection = ConnectionManager::get('default');//新DBに戻る
        $table->setConnection($connection);

        $katagae_time = 0;
        $seisan_time = 0;

      }

    }else{

      $arrkatagae_time = array('katagae_time'=>0);
      $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrkatagae_time);

      $total_loss_time = round($KadouSeikeis[$n]["riron_loss_time"] / 60 , 1);
      $arrtotal_loss_time = array('total_loss_time'=>$total_loss_time);
      $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrtotal_loss_time);

      $kadouritsu = round(1 - (($total_loss_time * 60) / 86400), 3);
      $arrkadouritsu = array('kadouritsu'=>$kadouritsu);
      $KadouSeikeis[$n] = array_merge($KadouSeikeis[$n], $arrkadouritsu);

      $katagae_time = 0;
      $seisan_time = 0;

      //big_DBに単価登録
      $connection = ConnectionManager::get('big_DB');//旧DBを参照
      $table = TableRegistry::get('log_confirm_kadou_seikeikis');
      $table->setConnection($connection);

      $none = "none";
      $updater = "UPDATE log_confirm_kadou_seikeikis set before_product_code = '".$none."' , updated_at ='".date('Y-m-d H:i:s')."'
      where starting_tm_program ='".$KadouSeikeis[$n]["program_starting_tm"]."' and product_code ='".$KadouSeikeis[$n]["product_code"]."'";
      $connection->execute($updater);

      $connection = ConnectionManager::get('default');//新DBに戻る
      $table->setConnection($connection);

    }

}

      session_start();
      for($n=0; $n<count($KadouSeikeis); $n++){
        $_SESSION['imgdata'][$n] = array(
          'id' => $KadouSeikeis[$n]['id'],
          'pro_num' => $KadouSeikeis[$n]['product_code'],
          'starting_tm_nippou' => substr($KadouSeikeis[$n]['starting_tm'], 0, 19),
          'starting_tm' => substr($KadouSeikeis[$n]['starting_tm'], 0, 10),
          'shot_cycle' => $KadouSeikeis[$n]['shot_cycle'],
          'seikeiki' => $KadouSeikeis[$n]['seikeiki']
        );
      }

      for($n=0; $n<count($KadouSeikeis); $n++){

        $arrGroup[] = $KadouSeikeis[$n]["numkadouritu"];

      }

      $arrGroupcount = array_count_values($arrGroup);
      $this->set('arrGroupcount',$arrGroupcount);

      //終了時間から翌8:00までの時間をロスタイムに追加
      //データベースに登録用の配列を作成
      $countfin = 0;
      $arrTouroku = array();
      for($n=1; $n<=count($arrGroupcount); $n++){

        $countfin = $countfin + $arrGroupcount[$n];

        $start = substr($KadouSeikeis[$countfin-1]['starting_tm'], 0, 10);
        $start = $start." 08:00:00";
        $finish = strtotime($start);
        $finish = date('Y/m/d H:i:s', strtotime('+1 day', $finish));

        $program_finishing_tm = strtotime($KadouSeikeis[$countfin-1]['program_finishing_tm']);
        $finish = strtotime($finish);

        $loss_time = round(($finish - $program_finishing_tm) / 60 , 1);//生産時間（分）
/*
        echo "<pre>";
        print_r($loss_time." + ".$KadouSeikeis[$countfin-1]['total_loss_time']);
        echo "</pre>";
*/
        $total_loss_time = $KadouSeikeis[$countfin-1]['total_loss_time'] + $loss_time;

        $arrtotal_loss_time = array('total_loss_time'=>$total_loss_time);
        $KadouSeikeis[$countfin-1] = array_merge($KadouSeikeis[$countfin-1], $arrtotal_loss_time);

        $KadouritsuSeikeikidata = $this->KadouritsuSeikeikis->find()
        ->where(['seikeiki' => $KadouSeikeis[$countfin-1]['seikeiki'], 'date' => substr($KadouSeikeis[$countfin-1]['starting_tm'], 0, 10)])->toArray();

        if(isset($KadouritsuSeikeikidata[0])){//既にデータが存在する場合

          $kadouritsu = $KadouritsuSeikeikidata[0]["kadouritus"];

        }else{

          $kadouritsu = round(1 - (($KadouSeikeis[$countfin-1]['total_loss_time'] * 60) / 86400), 3);

        }

        $arrkadouritsu = array('kadouritsu'=>$kadouritsu);
        $KadouSeikeis[$countfin-1] = array_merge($KadouSeikeis[$countfin-1], $arrkadouritsu);

        $arrTouroku[] = [
          'seikeiki' => $KadouSeikeis[$countfin-1]["seikeiki"],
          'date' => substr($KadouSeikeis[$countfin-1]['starting_tm'], 0, 10),
          'kadouritus' => $KadouSeikeis[$countfin-1]["kadouritsu"],
          'delete_flag' => 0,
          'created_at' => date('Y-m-d H:i:s'),
          'created_staff' => $KadouSeikeis[$countfin-1]["created_staff"]
        ];

      }

      $this->set('KadouSeikeis',$KadouSeikeis);
/*
      echo "<pre>";
      print_r($KadouSeikeis);
      echo "</pre>";
*/
      for($n=0; $n<count($arrTouroku); $n++){

        $KadouritsuSeikeiki = $this->KadouritsuSeikeikis->find()->where(['seikeiki' => $arrTouroku[$n]['seikeiki'], 'date' => $arrTouroku[$n]['date']])->toArray();

        if(!isset($KadouritsuSeikeiki[0])){
          $KadouritsuSeikeikis = $this->KadouritsuSeikeikis->patchEntity($this->KadouritsuSeikeikis->newEntity(), $arrTouroku[$n]);
          $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
          $connection->begin();//トランザクション3
          try {//トランザクション4
            if ($this->KadouritsuSeikeikis->save($KadouritsuSeikeikis)) {

              $connection->commit();// コミット5

            } else {

              $this->Flash->error(__('The product could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

            }

          } catch (Exception $e) {//トランザクション7
          //ロールバック8
            $connection->rollback();//トランザクション9
          }//トランザクション10

        }

      }

    }else{//品番で絞り込んでいる場合またはデータが1つもない場合

      $this->set('countkadouSeikei',count($KadouSeikeis));

      session_start();
      for($n=0; $n<count($KadouSeikeis); $n++){
        $_SESSION['imgdata'][$n] = array(
          'id' => $KadouSeikeis[$n]['id'],
          'pro_num' => $KadouSeikeis[$n]['product_code'],
          'starting_tm_nippou' => substr($KadouSeikeis[$n]['starting_tm'], 0, 19),
          'starting_tm' => substr($KadouSeikeis[$n]['starting_tm'], 0, 10),
          'shot_cycle' => $KadouSeikeis[$n]['shot_cycle'],
          'seikeiki' => $KadouSeikeis[$n]['seikeiki']
        );
      }

    }

  }

  public function kensakusyousai()
  {
    $session = $this->request->getSession();
    $datasession = $session->read();

    if(!isset($datasession["imgdata"])){
      return $this->redirect(['action' => 'kariindex',
      's' => ['mess' => "セッションが切れました。日報呼出ボタンからやり直してください。"]]);
    }

    $arrdatasession = $datasession["imgdata"];

    $KadouSeikeis = $this->KadouSeikeis->newEntity();
    $this->set('KadouSeikeis',$KadouSeikeis);

    $Data=$this->request->query('s');
    if(isset($Data["returndata"])){

      $imgdatas = explode("_",$Data["returndata"]);//切り離し

    }else{

      $data = $this->request->getData();
      $data = array_keys($data, '詳細');
      $imgdatas = explode("_",$data[0]);//切り離し

    }
/*
    echo "<pre>";
    print_r($imgdatas);
    echo "</pre>";
*/

    if($imgdatas[2] == "-"){

      $accomp_rate_program = "-";
      $this->set('accomp_rate_program',$accomp_rate_program);
      $kobetu_loss_time = "-";
      $this->set('kobetu_loss_time',$kobetu_loss_time);
      $katagae_time = "-";
      $this->set('katagae_time',$katagae_time);
      $shot_cycle_heikin = "-";
      $this->set('shot_cycle_heikin',$shot_cycle_heikin);

    }else{

      $accomp_rate_program = $imgdatas[2] / 10;
      $this->set('accomp_rate_program',$accomp_rate_program);
      $kobetu_loss_time = $imgdatas[3] / 1000;
      $this->set('kobetu_loss_time',$kobetu_loss_time);
      $katagae_time = $imgdatas[4] / 1000;
      $this->set('katagae_time',$katagae_time);
      $shot_cycle_heikin = $arrdatasession[$imgdatas[0]]["shot_cycle"];
      $this->set('shot_cycle_heikin',$shot_cycle_heikin);

    }

      $_SESSION['imgnum'] = array(
        'num' => $imgdatas[0]
      );

      $KadouSeikeis = $this->KadouSeikeis->find()->where(['id' => $imgdatas[1]])->toArray();

      $date_sta = $KadouSeikeis[0]["starting_tm"]->format('Y-m-d H:i:s');

      $product_code = $KadouSeikeis[0]["product_code"];
      $this->set('product_code',$product_code);

      $Products = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Products[0]->product_name ;
      $this->set('product_name',$product_name);

      $seikeiki = $KadouSeikeis[0]["seikeiki"];
      $this->set('seikeiki',$seikeiki);
      $first_lot_num = $KadouSeikeis[0]["first_lot_num"];
      $this->set('first_lot_num',$first_lot_num);
      $last_lot_num = $KadouSeikeis[0]["last_lot_num"];
      $this->set('last_lot_num',$last_lot_num);
/*
      echo "<pre>";
      print_r($product_name);
      echo "</pre>";
*/
      $connection = ConnectionManager::get('big_DB');//旧DBを参照
      $table = TableRegistry::get('log_confirm_kadou_seikeikis');
      $table->setConnection($connection);

      $sql = "SELECT lot_code,starting_tm_nippou,starting_tm_program,finishing_tm_nippou,
      finishing_tm_program,shot_cycle_nippou,shot_cycle_mode,amount_nippou,amount_programming,bik
      FROM log_confirm_kadou_seikeikis".
      " where starting_tm_nippou = '".$date_sta."' and product_code = '".$product_code."' and seikeiki = '".$seikeiki."' order by product_code asc";
      $connection = ConnectionManager::get('big_DB');
      $log_confirm_kadou_seikeikis = $connection->execute($sql)->fetchAll('assoc');

      $connection = ConnectionManager::get('default');
      $table->setConnection($connection);
/*
      echo "<pre>";
      print_r($log_confirm_kadou_seikeikis[0]);
      echo "</pre>";
*/

      if(isset($log_confirm_kadou_seikeikis[0])){

        $lot_code = $log_confirm_kadou_seikeikis[0]["lot_code"];
        $this->set('lot_code',$lot_code);
        $starting_tm_nippou = $log_confirm_kadou_seikeikis[0]["starting_tm_nippou"];
        $this->set('starting_tm_nippou',$starting_tm_nippou);
        $starting_tm_program = $log_confirm_kadou_seikeikis[0]["starting_tm_program"];
        $this->set('starting_tm_program',$starting_tm_program);
        $finishing_tm_nippou = $log_confirm_kadou_seikeikis[0]["finishing_tm_nippou"];
        $this->set('finishing_tm_nippou',$finishing_tm_nippou);
        $finishing_tm_program = $log_confirm_kadou_seikeikis[0]["finishing_tm_program"];
        $this->set('finishing_tm_program',$finishing_tm_program);
        $shot_cycle_nippou = $log_confirm_kadou_seikeikis[0]["shot_cycle_nippou"];
        $this->set('shot_cycle_nippou',$shot_cycle_nippou);

        if($product_code === "W002"){

          $log_confirm_kadou_seikeikis[0]["amount_nippou"] = $log_confirm_kadou_seikeikis[0]["amount_nippou"] * 2;

        }

        $amount_nippou = $log_confirm_kadou_seikeikis[0]["amount_nippou"];
        $this->set('amount_nippou',$amount_nippou);
        $shot_cycle_mode = $log_confirm_kadou_seikeikis[0]["shot_cycle_mode"];
        $this->set('shot_cycle_mode',$shot_cycle_mode);
        $amount_programming = $log_confirm_kadou_seikeikis[0]["amount_programming"];
        $this->set('amount_programming',$amount_programming);
        $bik = $log_confirm_kadou_seikeikis[0]["bik"];
        $this->set('bik',$bik);

      }else{

        $lot_code = "";
        $this->set('lot_code',$lot_code);
        $starting_tm_nippou = "";
        $this->set('starting_tm_nippou',$starting_tm_nippou);
        $starting_tm_program = "";
        $this->set('starting_tm_program',$starting_tm_program);
        $finishing_tm_nippou = "";
        $this->set('finishing_tm_nippou',$finishing_tm_nippou);
        $finishing_tm_program = "";
        $this->set('finishing_tm_program',$finishing_tm_program);
        $shot_cycle_nippou = "";
        $this->set('shot_cycle_nippou',$shot_cycle_nippou);
        $amount_nippou = "";
        $this->set('amount_nippou',$amount_nippou);
        $shot_cycle_mode = "";
        $this->set('shot_cycle_mode',$shot_cycle_mode);
        $amount_programming = "";
        $this->set('amount_programming',$amount_programming);
        $bik = "";
        $this->set('bik',$bik);

      }

    }


    public function syuuseiform()//ロット検索
    {
      $this->request->session()->destroy(); // セッションの破棄
      $KadouSeikeis = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikeis',$KadouSeikeis);

      $data = array_values($this->request->query);//getで取り出した配列の値を取り出す

      $id = $data[1];
      $this->set('id',$id);
      $KadouSeikeis = $this->KadouSeikeis->find()->where(['id' => $id])->toArray();
      $product_code = $KadouSeikeis[0]->product_code;
      $this->set('product_code',$product_code);
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Product[0]->product_name;
      $this->set('product_name',$product_name);
      $seikeiki = $KadouSeikeis[0]->seikeiki;
      $this->set('seikeiki',$seikeiki);
      $starting_tm = $KadouSeikeis[0]->starting_tm->format('Y-m-d H:i:s');
      $starting_tm = substr($starting_tm,0,10)."T".substr($starting_tm,11,5);
      $this->set('starting_tm',$starting_tm);
      $finishing_tm = $KadouSeikeis[0]->finishing_tm->format('Y-m-d H:i:s');
      $finishing_tm = substr($finishing_tm,0,10)."T".substr($finishing_tm,11,5);
      $this->set('finishing_tm',$finishing_tm);
      $cycle_shot = $KadouSeikeis[0]->cycle_shot;
      $this->set('cycle_shot',$cycle_shot);
      $amount_shot = $KadouSeikeis[0]->amount_shot;
      $this->set('amount_shot',$amount_shot);

      $first_lot_num = $KadouSeikeis[0]->first_lot_num;
      $this->set('first_lot_num',$first_lot_num);
      $last_lot_num = $KadouSeikeis[0]->last_lot_num;
      $this->set('last_lot_num',$last_lot_num);

    }

    public function syuuseiconfirm()//ロット検索
    {
      $this->request->session()->destroy(); // セッションの破棄
      session_start();

      $KadouSeikeis = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikeis',$KadouSeikeis);

      $data = $this->request->getData();

      $id = $data["id"];
      $this->set('id',$id);
      $starting_tm_moto = $data["starting_tm_moto"];
      $starting_tm_moto = substr($starting_tm_moto, 0, 10)." ".substr($starting_tm_moto, 11, 5);
      $this->set('starting_tm_moto',$starting_tm_moto);
      $seikeiki = $data["seikeiki"];
      $this->set('seikeiki',$seikeiki);
      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Product[0]->product_name;
      $this->set('product_name',$product_name);
      $starting_tm = $data["starting_tm"];
      $starting_tm = substr($starting_tm, 0, 10)." ".substr($starting_tm, 11, 5);
      $this->set('starting_tm',$starting_tm);
      $finishing_tm = $data["finishing_tm"];
      $finishing_tm = substr($finishing_tm, 0, 10)." ".substr($finishing_tm, 11, 5);
      $this->set('finishing_tm',$finishing_tm);
      $cycle_shot = $data["cycle_shot"];
      $this->set('cycle_shot',$cycle_shot);
      $amount_shot = $data["amount_shot"];
      $this->set('amount_shot',$amount_shot);
      $first_lot_num = $data["first_lot_num"];
      $this->set('first_lot_num',$first_lot_num);
      $last_lot_num = $data["last_lot_num"];
      $this->set('last_lot_num',$last_lot_num);

      $kadoujikan = ((strtotime($finishing_tm) - strtotime($starting_tm)));
      $riron_shot = round($kadoujikan/$cycle_shot, 0);
      $accomp_rate = round(100*$amount_shot/$riron_shot, 0);

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      if(($Product[0]->torisu) > 0){

        $torisu = $Product[0]->torisu;
        $Konpou = $this->Konpous->find()->where(['product_code' => $product_code])->toArray();

          if(($Konpou[0]->irisu) > 0){

            $irisu = $Konpou[0]->irisu;

            $sum_predict_lot_num = ceil(($amount_shot * $torisu) / $irisu);

          }else{

            echo "<pre>";
            print_r($product_code."のirisuがKonpousテーブルに登録されていません");
            echo "</pre>";

          }

      }else{

        echo "<pre>";
        print_r($product_code."のtorisuがProductsテーブルに登録されていません");
        echo "</pre>";

        $sum_predict_lot_num = "";

      }

      $this->set('sum_predict_lot_num',$sum_predict_lot_num);


      $_SESSION['kadouseikeisyuusei'] = array(
        'product_code' => $product_code,
        'seikeiki' => $seikeiki,
        'starting_tm' => $starting_tm,
        'finishing_tm' => $finishing_tm,
        'cycle_shot' => $cycle_shot,
        'amount_shot' => $amount_shot,
        'accomp_rate' => $accomp_rate,
        "first_lot_num" => $first_lot_num,
        "last_lot_num" => $last_lot_num,
        "sum_predict_lot_num" => $sum_predict_lot_num,
      );

      $_SESSION['kadouseikeiid'] = array(
        "id" => $id,
        'starting_tm_moto' => $starting_tm_moto
      );
/*
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";
*/
    }

    public function syuuseipreadd()
		{
      $KadouSeikei = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikei',$KadouSeikei);
		}

		public function syuuseilogin()
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
						return $this->redirect(['action' => 'syuuseido']);
					}
				}
		}

    public function syuuseido()
   {
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);

     $session = $this->request->getSession();
     $data = $session->read();

     if ($this->request->is('get')) {

       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3

       try {//トランザクション4
         if ($this->KadouSeikeis->updateAll(
         ['starting_tm' => $_SESSION['kadouseikeisyuusei']['starting_tm'] ,'finishing_tm' => $_SESSION['kadouseikeisyuusei']['finishing_tm'] ,
         'cycle_shot' => $_SESSION['kadouseikeisyuusei']['cycle_shot'] ,'amount_shot' => $_SESSION['kadouseikeisyuusei']['amount_shot'] ,
         'accomp_rate' => $_SESSION['kadouseikeisyuusei']['accomp_rate'] ,'first_lot_num' => $_SESSION['kadouseikeisyuusei']['first_lot_num'] ,
         'last_lot_num' => $_SESSION['kadouseikeisyuusei']['last_lot_num'] ,'sum_predict_lot_num' => $_SESSION['kadouseikeisyuusei']['sum_predict_lot_num'] ,
         'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
         ['id'   => $_SESSION['kadouseikeiid']['id'] ]
         )) {

           $connection->commit();// コミット5

           //旧DBも更新
           $connection = ConnectionManager::get('sakaeMotoDB');
           $table = TableRegistry::get('kadou_seikei');
           $table->setConnection($connection);

           $updater = "UPDATE kadou_seikei set starting_tm = '".$_SESSION['kadouseikeisyuusei']['starting_tm']."', finishing_tm = '".$_SESSION['kadouseikeisyuusei']['finishing_tm']."'
           , cycle_shot = '".$_SESSION['kadouseikeisyuusei']['cycle_shot']."', amount_shot = '".$_SESSION['kadouseikeisyuusei']['cycle_shot']."', accomp_rate = '".$_SESSION['kadouseikeisyuusei']['accomp_rate']."'
           , first_lot_num = '".$_SESSION['kadouseikeisyuusei']['first_lot_num']."', last_lot_num = '".$_SESSION['kadouseikeisyuusei']['last_lot_num']."', sum_predict_lot_num = '".$_SESSION['kadouseikeisyuusei']['sum_predict_lot_num']."'
           where pro_num ='".$_SESSION['kadouseikeisyuusei']['product_code']."' and seikeiki ='".$_SESSION['kadouseikeisyuusei']['seikeiki']."' and starting_tm ='".$_SESSION['kadouseikeiid']['starting_tm_moto']."'";//もとのDBも更新
           $connection->execute($updater);

           $connection = ConnectionManager::get('default');
           $table->setConnection($connection);

           //big_DBも更新
           $connection = ConnectionManager::get('big_DB');
           $table = TableRegistry::get('kadou_seikeikis');
           $table->setConnection($connection);

           $updater = "UPDATE kadou_seikeikis set starting_tm = '".$_SESSION['kadouseikeisyuusei']['starting_tm']."', finishing_tm = '".$_SESSION['kadouseikeisyuusei']['finishing_tm']."', updated_at = '".date('Y-m-d H:i:s')."'
           where product_code ='".$_SESSION['kadouseikeisyuusei']['product_code']."' and seikeiki ='".$_SESSION['kadouseikeisyuusei']['seikeiki']."' and starting_tm ='".$_SESSION['kadouseikeiid']['starting_tm_moto']."'";
           $connection->execute($updater);

           $connection = ConnectionManager::get('default');
           $table->setConnection($connection);


           $mes = "※登録されました";
           $this->set('mes',$mes);

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

   public function imgkensakuform()
   {
     $KadouSeikei = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikei',$KadouSeikei);

     $session = $this->request->getSession();
     $datasession = $session->read();

     if(!isset($datasession["imgnum"])){
       return $this->redirect(['action' => 'kariindex',
       's' => ['mess' => "セッションが切れました。日報呼出ボタンからやり直してください。"]]);
     }

     $imgdatanum = $datasession["imgnum"]["num"];
     $imgdatanummax = count($datasession["imgdata"]) - 1;

     $date_sta = $datasession["imgdata"][$imgdatanum]["starting_tm"];
     $this->set('date_sta',$date_sta);

     $starting_tm_nippou = $datasession["imgdata"][$imgdatanum]["starting_tm_nippou"];
     $pro_num = $datasession["imgdata"][$imgdatanum]["pro_num"];
     $seikeiki = $datasession["imgdata"][$imgdatanum]["seikeiki"];

     $data = $this->request->getData();

     if(isset($data["bikou"])){

       $connection = ConnectionManager::get('big_DB');//旧DBを参照
       $table = TableRegistry::get('log_confirm_kadou_seikeikis');
       $table->setConnection($connection);

       $sql = "SELECT lot_code,starting_tm_nippou,starting_tm_program,finishing_tm_nippou,
       finishing_tm_program,shot_cycle_nippou,shot_cycle_mode,amount_nippou,amount_programming,bik
       FROM log_confirm_kadou_seikeikis".
       " where starting_tm_nippou = '".$starting_tm_nippou."' and product_code = '".$pro_num."' and seikeiki = '".$seikeiki."' order by product_code asc";
       $connection = ConnectionManager::get('big_DB');
       $log_confirm_kadou_seikeikis = $connection->execute($sql)->fetchAll('assoc');

       $datetouroku = date("ymd");
       if(!empty($log_confirm_kadou_seikeikis[0]["bik"])){
         $bikou = $log_confirm_kadou_seikeikis[0]["bik"]." ".$datetouroku."-".$data["bik"];
       }else{
         $bikou = $datetouroku."-".$data["bik"];
       }

       $updater = "UPDATE log_confirm_kadou_seikeikis set bik = '".$bikou."', updated_at ='".date('Y-m-d H:i:s')."'
       where starting_tm_nippou ='".$starting_tm_nippou."' and product_code ='".$pro_num."' and seikeiki = '".$seikeiki."'";
       $connection->execute($updater);

       $connection = ConnectionManager::get('default');
       $table->setConnection($connection);

       $returndata = $imgdatanum."_".$datasession["imgdata"][$imgdatanum]["id"];

       return $this->redirect(['action' => 'kensakusyousai',
       's' => ['returndata' => $returndata]]);

     }

     if(isset($data["neg"])){
       $imgdatanum = $imgdatanum - 1;

       if($imgdatanum < 0){
         $imgdatanum = $imgdatanummax;
       }else{
         $imgdatanum = $imgdatanum % $imgdatanummax;
       }

       $_SESSION['imgnum'] = array(
         'num' => $imgdatanum
       );

       $product_code = $datasession["imgdata"][$imgdatanum]["pro_num"];
       $this->set('product_code',$product_code);
       $seikeiki = $datasession["imgdata"][$imgdatanum]["seikeiki"];
       $this->set('seikeiki',$seikeiki);
       $date_sta = $datasession["imgdata"][$imgdatanum]["starting_tm"];
       $this->set('date_sta',$date_sta);

     }elseif(isset($data["poj"])){
       $imgdatanum = $imgdatanum + 1;

       if($imgdatanum > $imgdatanummax){//初めに戻る
         $imgdatanum = 0;
       }

       $_SESSION['imgnum'] = array(
         'num' => $imgdatanum
       );

       $product_code = $datasession["imgdata"][$imgdatanum]["pro_num"];
       $this->set('product_code',$product_code);
       $seikeiki = $datasession["imgdata"][$imgdatanum]["seikeiki"];
       $this->set('seikeiki',$seikeiki);
       $date_sta = $datasession["imgdata"][$imgdatanum]["starting_tm"];
       $this->set('date_sta',$date_sta);

     }elseif(isset($data["yobidasi"])){//グラフ呼び出しボタンを押したとき

       return $this->redirect(['action' => 'imgkensakuichiran',
       's' => ['data' => $data]]);

     }else{//初めてこのページに来た時
       $product_code = $data['product'];
       $this->set('product_code',$product_code);
       $seikeiki = $data['seikeiki'];
       $this->set('seikeiki',$seikeiki);
     }

     $date_y = substr($date_sta, 0, 4);
     $date_m = substr($date_sta, 5, 2);
     $date_d = substr($date_sta, 8, 2);

     $date_t = strtotime($date_sta);
     $date_to = date('Y-m-d', strtotime('+1 day', $date_t));

     $arrImgtype = ['1' => '選択なし','hist_place_cushion' => 'hist_place_cushion','hist_time_injection' => 'hist_time_injection',
     'hist_time_measure' => 'hist_time_measure','hist_pressure_injection' => 'hist_pressure_injection',
      'plot_place_cushion' => 'plot_place_cushion','plot_time_injection' => 'plot_time_injection',
      'plot_time_measure' => 'plot_time_measure','plot_pressure_injection' => 'plot_pressure_injection'];
     $this->set('arrImgtype',$arrImgtype);

     $arrImgpriority = ['1' => '主要グラフ','2' => 'その他'];
     $this->set('arrImgpriority',$arrImgpriority);

     $pro_num = $datasession["imgdata"][$imgdatanum]["pro_num"];
     $seikeiki = $datasession["imgdata"][$imgdatanum]["seikeiki"];
     $starting_tm_nippou = $datasession["imgdata"][$imgdatanum]["starting_tm_nippou"];

     $connection = ConnectionManager::get('big_DB');//旧DBを参照
     $table = TableRegistry::get('log_confirm_kadou_seikeikis');
     $table->setConnection($connection);

     $sql = "SELECT status_making_graph, lot_code
     FROM log_confirm_kadou_seikeikis".
     " where starting_tm_nippou = '".$starting_tm_nippou."' and product_code = '".$pro_num."' and seikeiki = '".$seikeiki."'";
     $connection = ConnectionManager::get('big_DB');
     $status_making_graphs = $connection->execute($sql)->fetchAll('assoc');

     $connection = ConnectionManager::get('default');
     $table->setConnection($connection);
/*
     echo "<pre>";
     print_r($status_making_graphs);
     echo "</pre>";
*/
     $arrAll = glob("img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/*");//webrootフォルダにファイルが存在するか確認
     $countfile = count($arrAll);

     $mes = "";
     $this->set('mes',$mes);

     if($countfile > 0){//webrootフォルダにファイルが存在しているときはそのまま表示する

       $graphcheck = 1;
       $this->set('graphcheck',$graphcheck);

     }else{//webrootフォルダにファイルが存在していないとき

       if(isset($status_making_graphs[0])){//①そもそもそのグラフが存在するか確認して、存在する場合

         if($status_making_graphs[0]["status_making_graph"] == 1){//②グラフ作成が終わっている場合、グラフのコピーへ
/*
           echo "<pre>";
           print_r($seikeiki." --- ".$pro_num." --- ".$starting_tm_nippou);
           echo "</pre>";
*/
           $dirName = "img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/";
           if(is_dir($dirName)){//フォルダ自体はwebrootに存在する場合
             $dirName = $dirName;
           }else{//フォルダがwebrootに存在しない場合
             mkdir($dirName, 0777, TRUE);//フォルダ作成　※２階層以上の深さを一度に作成するときには、第３引数にTRUEを付ける
           }

           $arrAllfiles = glob("/data/share/mkNewDir/$product_code/$date_y/$date_m/$date_d/前回比較/*");//192
    //       $arrAllfiles = glob("img/kadouimgcopy/$product_code/$date_y/$date_m/$date_d/前回比較/*");

           $countfile = count($arrAllfiles);

           $arrAllfilesmoto = array();

           for($k=0; $k<$countfile; $k++){

             ${"file".$k} = explode("/",$arrAllfiles[$k]);

      //       $arrPngfiles[] = ${"file".$k}[7];//ローカル
             $arrPngfiles[] = ${"file".$k}[9];//192
             $this->set('arrPngfiles',$arrPngfiles);

      //       $file_name = ${"file".$k}[7];//ローカル
             $file_name = ${"file".$k}[9];//192

              copy("/data/share/mkNewDir/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name", "img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name");//192.168.4.246
        //      copy("img/kadouimgcopy/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name", "img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name");//ローカル

             $arrAllfilesmoto[] = $file_name;

           }

           $arrAllfilesWebroot = glob("img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/*");
           $countfileWebroot = count($arrAllfilesWebroot);
           $arrAllfilesafter = array();

           for($k=0; $k<$countfileWebroot; $k++){
      //       $file_name = ${"file".$k}[7];//ローカル
             $file_name = ${"file".$k}[9];//192
             $arrAllfilesafter[] = $file_name;
           }

           if($countfileWebroot == 0){//フォルダが空の場合

             $mes = "品番：".$product_code."　日付：".$date_sta." のグラフデータはありません。";
             $this->set('mes',$mes);

           }

           if(count(array_diff($arrAllfilesmoto, $arrAllfilesafter)) > 0){//一部のファイルがコピーできていない

             echo "<pre>";
             print_r("以下のファイルが正しくコピーできていません。");
             echo "</pre>";
             echo "<pre>";
             print_r(array_diff($arrAllfilesmoto, $arrAllfilesafter));
             echo "</pre>";

             $mes = "グラフのコピー中に異常が発生しました。管理者に報告してください。";
             $this->set('mes',$mes);

             $graphcheck = 2;
             $this->set('graphcheck',$graphcheck);

             $connection = ConnectionManager::get('big_DB');
             $table = TableRegistry::get('log_confirm_kadou_seikeikis');
             $table->setConnection($connection);

             $statusnum = 9;

             $updater = "UPDATE log_confirm_kadou_seikeikis set status_making_graph = '".$statusnum."'
             where starting_tm_nippou ='".$starting_tm_nippou."' and product_code ='".$pro_num."' and seikeiki ='".$seikeiki."'";
             $connection->execute($updater);

             $connection = ConnectionManager::get('default');
             $table->setConnection($connection);

           }else{//ちゃんとコピーされている場合そのまま出力

             $graphcheck = 1;
             $this->set('graphcheck',$graphcheck);

           }

         }else{//②グラフ作成が終わっていない

           $mes = "グラフ作成中です。しばらくたってからやり直してください。";
           $this->set('mes',$mes);

           $graphcheck = 3;
           $this->set('graphcheck',$graphcheck);

         }

       }else{//①そもそもそのグラフが存在しない
/*
         echo "<pre>";
         print_r("グラフが存在しません");
         echo "</pre>";
*/
         $mes = "品番：".$product_code."　日付：".$date_sta." のグラフデータはありません。";
         $this->set('mes',$mes);

         $graphcheck = 4;
         $this->set('graphcheck',$graphcheck);

       }

    }

     $primary_num = 0;
     $connection = ConnectionManager::get('big_DB');//旧DBを参照
     $table = TableRegistry::get('graph_primary_columns');
     $table->setConnection($connection);

     $sql = "SELECT id,column_name,column_japanese FROM graph_primary_columns".
     " where primary_num = ".$primary_num."";
     $connection = ConnectionManager::get('big_DB');
     $arrColumns = $connection->execute($sql)->fetchAll('assoc');

     $sql = "SELECT lot_code FROM log_confirm_kadou_seikeikis".
     " where starting_tm_nippou <= '".$date_to."' and product_code = '".$product_code."' and seikeiki = '".$seikeiki."' order by starting_tm_nippou desc limit 50";
     $connection = ConnectionManager::get('big_DB');
     $lot_codes = $connection->execute($sql)->fetchAll('assoc');

     $lot_codes = array_unique($lot_codes, SORT_REGULAR);//重複削除
     $lot_codes = array_values($lot_codes);

     if(isset($lot_codes[0])){
       $lot_codes1 = $lot_codes[0]["lot_code"];
     }else{
       $lot_codes1 = "";
     }
     $this->set('lot_codes1',$lot_codes1);

     if(isset($lot_codes[1])){
       $lot_codes2 = $lot_codes[1]["lot_code"];
     }else{
       $lot_codes2 = "";
     }
     $this->set('lot_codes2',$lot_codes2);

     if(isset($lot_codes[2])){
       $lot_codes3 = $lot_codes[2]["lot_code"];
     }else{
       $lot_codes3 = "";
     }
     $this->set('lot_codes3',$lot_codes3);

     $connection = ConnectionManager::get('default');
     $table->setConnection($connection);

     $file_name1 = $seikeiki."_hist_peak_value.png";
     $file_name2 = $seikeiki."_hist_time_injection.png";
     $file_name3 = $seikeiki."_hist_time_measure.png";
     $file_name4 = $seikeiki."_hist_place_cushion.png";
     $file_name5 = $seikeiki."_plot_peak_value.png";
     $file_name6 = $seikeiki."_plot_time_injection.png";
     $file_name7 = $seikeiki."_plot_time_measure.png";
     $file_name8 = $seikeiki."_plot_place_cushion.png";

     $gif1 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name1";
     $this->set('gif1',$gif1);
     $gif2 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name2";
     $this->set('gif2',$gif2);
     $gif3 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name3";
     $this->set('gif3',$gif3);
     $gif4 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name4";
     $this->set('gif4',$gif4);
     $gif5 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name5";
     $this->set('gif5',$gif5);
     $gif6 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name6";
     $this->set('gif6',$gif6);
     $gif7 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name7";
     $this->set('gif7',$gif7);
     $gif8 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name8";
     $this->set('gif8',$gif8);

   }

   public function imgkensakuichiran()
   {
     $KadouSeikei = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikei',$KadouSeikei);
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
      $session = $this->request->getSession();
      $datasession = $session->read();

      if(!isset($datasession["imgnum"])){
        return $this->redirect(['action' => 'kariindex',
        's' => ['mess' => "セッションが切れました。日報呼出ボタンからやり直してください。"]]);
      }

      $imgdatanum = $datasession["imgnum"]["num"];
      $product_code = $datasession["imgdata"][$imgdatanum]["pro_num"];
      $this->set('product_code',$product_code);
      $seikeiki = $datasession["imgdata"][$imgdatanum]["seikeiki"];
      $this->set('seikeiki',$seikeiki);
      $date_sta = $datasession["imgdata"][$imgdatanum]["starting_tm"];
      $this->set('date_sta',$date_sta);
      $date_y = substr($date_sta, 0, 4);
      $date_m = substr($date_sta, 5, 2);
      $date_d = substr($date_sta, 8, 2);

      $Data = $this->request->query('s');
      $data = $Data['data'];//postデータ取得し、$dataと名前を付ける

     $priority = $data['priority'];
     $type = $data['type'];
     $this->set('type',$type);

     $arrImgtype = ['1' => '選択なし','hist_place_cushion' => 'hist_place_cushion','hist_time_injection' => 'hist_time_injection',
      'hist_time_measure' => 'hist_time_measure','hist_pressure_injection' => 'hist_pressure_injection',
      'plot_place_cushion' => 'plot_place_cushion','plot_time_injection' => 'plot_time_injection',
      'plot_time_measure' => 'plot_time_measure','plot_pressure_injection' => 'plot_pressure_injection'];
     $this->set('arrImgtype',$arrImgtype);

     $arrImgpriority = ['1' => '主要グラフ', '2' => 'その他'];
     $this->set('arrImgpriority',$arrImgpriority);

     if($priority == 2){//その他を選択した場合

       $typecheck = 1;
       $this->set('typecheck',$typecheck);

       $arrAllfiles = glob("img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/*");//ローカル
       $countfile = count($arrAllfiles);

       $arrPngfiles = array();
       if($countfile == 0){
         $this->set('arrPngfiles',$arrPngfiles);
       }

       for($k=0; $k<$countfile; $k++){

         ${"file".$k} = explode("/",$arrAllfiles[$k]);

         $arrPngfiles[] = ${"file".$k}[7];//ローカル
  //       $arrPngfiles[] = ${"file".$k}[9];
         $this->set('arrPngfiles',$arrPngfiles);

         $file_name = ${"file".$k}[7];//ローカル
  //       $file_name = ${"file".$k}[9];

         ${"gif".$k} = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name";
         $this->set('gif'.$k,${"gif".$k});

       }

     }elseif($type == 1){//$priority=主要グラフで、種類を選択していない場合

       $typecheck = 2;
       $this->set('typecheck',$typecheck);

       $file_name1 = $seikeiki."_hist_peak_value.png";
       $file_name2 = $seikeiki."_hist_time_injection.png";
       $file_name3 = $seikeiki."_hist_time_measure.png";
       $file_name4 = $seikeiki."_hist_place_cushion.png";
       $file_name5 = $seikeiki."_plot_peak_value.png";
       $file_name6 = $seikeiki."_plot_time_injection.png";
       $file_name7 = $seikeiki."_plot_time_measure.png";
       $file_name8 = $seikeiki."_plot_place_cushion.png";

       $gif1 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name1";
       $this->set('gif1',$gif1);
       $gif2 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name2";
       $this->set('gif2',$gif2);
       $gif3 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name3";
       $this->set('gif3',$gif3);
       $gif4 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name4";
       $this->set('gif4',$gif4);
       $gif5 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name5";
       $this->set('gif5',$gif5);
       $gif6 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name6";
       $this->set('gif6',$gif6);
       $gif7 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name7";
       $this->set('gif7',$gif7);
       $gif8 = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name8";
       $this->set('gif8',$gif8);

     }else{//$priority=主要グラフで、種類を選択している場合

       $typecheck = 3;
       $this->set('typecheck',$typecheck);

        $file_name = $seikeiki."_".$type.".png";

        $gif = "shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/$file_name";
        $this->set('gif',$gif);

     }

     $arrAllfiles = glob("img/shotgraphs/$product_code/$date_y/$date_m/$date_d/前回比較/*");//ローカル
     $countfile = count($arrAllfiles);

     if($countfile == 0){//フォルダが空の場合
       $mes = "品番：".$product_code."　日付：".$date_sta." のグラフデータはありません。";
       $this->set('mes',$mes);
     }else{
       $mes = "";
       $this->set('mes',$mes);
     }

   }

}
