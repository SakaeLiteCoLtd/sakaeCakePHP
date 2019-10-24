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
class LabelsController extends AppController
{

     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->KariKadouSeikeis = TableRegistry::get('kariKadouSeikeis');
       $this->KadouSeikeis = TableRegistry::get('kadouSeikeis');
       $this->ScheduleKouteis = TableRegistry::get('scheduleKouteis');
       $this->Users = TableRegistry::get('users');
     }

    public function kariform()
    {
			$KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
			$this->set('KariKadouSeikeis',$KariKadouSeikeis);//
			$data = $this->request->getData();//postデータを$dataに
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
        session_start();
        $dateYMD = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day'];
        $dateYMD1 = strtotime($dateYMD);
        $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));
        $this->set('dateYMD',$dateYMD);
        $dateYMDye = $dayye;
        $this->set('dateYMDye',$dateYMDye);
        $dateHI = date("08:00");
        $dateye = $dateYMDye."T".$dateHI;
        $dateto = $dateYMD."T".$dateHI;
        $this->set('dateye',$dateye);
        $this->set('dateto',$dateto);
/*
        echo "<pre>";
        print_r($dayye);
        echo "</pre>";
*/
        for($i=1; $i<=9; $i++){
      		${"tuika".$i} = 0;
      		$this->set('tuika'.$i,${"tuika".$i});//セット
      	}

      }else{

        if (isset($data['tuika11']) && empty($data['sakujo11'])) {//1goukituika
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          for($i=1; $i<=9; $i++){
        		${"tuika".$i} = $data["tuika".$i];
        		$this->set('tuika'.$i,${"tuika".$i});//セット
        	}

          $tuika1 = $data['tuika1'] + 1;
  				$this->set('tuika1',$tuika1);//
/*          $tuika2 = $data['tuika2'];
          $this->set('tuika2',$tuika2);//
          $tuika3 = $data['tuika3'];
          $this->set('tuika3',$tuika3);//
          $tuika4 = $data['tuika4'];
          $this->set('tuika4',$tuika4);//
*/

}elseif(isset($data['sakujo11']) && $data['tuika1'] > 0){//1goukisakujo
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          for($i=1; $i<=9; $i++){
        		${"tuika".$i} = $data["tuika".$i];
        		$this->set('tuika'.$i,${"tuika".$i});//セット
        	}

  				$tuika1 = $data['tuika1'] - 1;
  				$this->set('tuika1',$tuika1);//

        }elseif(isset($data['sakujo11']) && $data['tuika1'] == 0){//1goukisakujo0
  /*				echo "<pre>";
  				print_r($data['sakujo1']);
  				echo "</pre>";
  */
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          for($i=1; $i<=9; $i++){
        		${"tuika".$i} = $data["tuika".$i];
        		$this->set('tuika'.$i,${"tuika".$i});//セット
        	}

        }elseif(isset($data['confirm']) && !isset($data['touroku'])){//?これがないとエラーが出る
          $this->set('confirm',$data['confirm']);//
/*
          echo "<pre>";
          print_r($data['confirm']);
          echo "</pre>";
*/

          for($i=1; $i<=9; $i++){
            ${"tuika".$i} = $data["tuika".$i];
            $this->set('tuika'.$i,${"tuika".$i});//セット
          }

        }

        elseif (isset($data['tuika22']) && empty($data['sakujo22'])) {//2goukituika
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          for($i=1; $i<=9; $i++){
        		${"tuika".$i} = $data["tuika".$i];
        		$this->set('tuika'.$i,${"tuika".$i});//セット
        	}

  				$tuika2 = $data['tuika2'] + 1;
  				$this->set('tuika2',$tuika2);//

        }elseif(isset($data['sakujo22']) && $data['tuika2'] > 0){//2goukisakujo
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          for($i=1; $i<=9; $i++){
        		${"tuika".$i} = $data["tuika".$i];
        		$this->set('tuika'.$i,${"tuika".$i});//セット
        	}

  				$tuika2 = $data['tuika2'] - 1;
  				$this->set('tuika2',$tuika2);//

        }elseif(isset($data['sakujo22']) && $data['tuika2'] == 0){//2goukisakujo0
          $dateye = $data['dateye'];
          $dateto = $data['dateto'];
          $this->set('dateye',$dateye);
          $this->set('dateto',$dateto);

          for($i=1; $i<=9; $i++){
        		${"tuika".$i} = $data["tuika".$i];
        		$this->set('tuika'.$i,${"tuika".$i});//セット
        	}

        }elseif (isset($data['tuika33']) && empty($data['sakujo33'])) {//3goukituika
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            for($i=1; $i<=9; $i++){
          		${"tuika".$i} = $data["tuika".$i];
          		$this->set('tuika'.$i,${"tuika".$i});//セット
          	}
    				$tuika3 = $data['tuika3'] + 1;
    				$this->set('tuika3',$tuika3);//

          }elseif(isset($data['sakujo33']) && $data['tuika3'] > 0){//3goukisakujo
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            for($i=1; $i<=9; $i++){
          		${"tuika".$i} = $data["tuika".$i];
          		$this->set('tuika'.$i,${"tuika".$i});//セット
          	}
    				$tuika3 = $data['tuika3'] - 1;
    				$this->set('tuika3',$tuika3);//

          }elseif(isset($data['sakujo33']) && $data['tuika3'] == 0){//3goukisakujo0
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            for($i=1; $i<=9; $i++){
          		${"tuika".$i} = $data["tuika".$i];
          		$this->set('tuika'.$i,${"tuika".$i});//セット
          	}

          }elseif (isset($data['tuika44']) && empty($data['sakujo44'])) {//4goukituika
              $dateye = $data['dateye'];
              $dateto = $data['dateto'];
              $this->set('dateye',$dateye);
              $this->set('dateto',$dateto);

              for($i=1; $i<=9; $i++){
            		${"tuika".$i} = $data["tuika".$i];
            		$this->set('tuika'.$i,${"tuika".$i});//セット
            	}
      				$tuika4 = $data['tuika4'] + 1;
      				$this->set('tuika4',$tuika4);//

            }elseif(isset($data['sakujo44']) && $data['tuika4'] > 0){//4goukisakujo
              $dateye = $data['dateye'];
              $dateto = $data['dateto'];
              $this->set('dateye',$dateye);
              $this->set('dateto',$dateto);

              for($i=1; $i<=9; $i++){
            		${"tuika".$i} = $data["tuika".$i];
            		$this->set('tuika'.$i,${"tuika".$i});//セット
            	}
      				$tuika4 = $data['tuika4'] - 1;
      				$this->set('tuika4',$tuika4);//

            }elseif(isset($data['sakujo44']) && $data['tuika4'] == 0){//4goukisakujo0
              $dateye = $data['dateye'];
              $dateto = $data['dateto'];
              $this->set('dateye',$dateye);
              $this->set('dateto',$dateto);

              for($i=1; $i<=9; $i++){
            		${"tuika".$i} = $data["tuika".$i];
            		$this->set('tuika'.$i,${"tuika".$i});//セット
            	}

            }elseif (isset($data['tuika55']) && empty($data['sakujo55'])) {//5goukituika
                $dateye = $data['dateye'];
                $dateto = $data['dateto'];
                $this->set('dateye',$dateye);
                $this->set('dateto',$dateto);

                for($i=1; $i<=9; $i++){
                  ${"tuika".$i} = $data["tuika".$i];
                  $this->set('tuika'.$i,${"tuika".$i});//セット
                }
                $tuika5 = $data['tuika5'] + 1;
                $this->set('tuika5',$tuika5);//

            }elseif(isset($data['sakujo55']) && $data['tuika5'] > 0){//5goukisakujo
                $dateye = $data['dateye'];
                $dateto = $data['dateto'];
                $this->set('dateye',$dateye);
                $this->set('dateto',$dateto);

                for($i=1; $i<=9; $i++){
                  ${"tuika".$i} = $data["tuika".$i];
                  $this->set('tuika'.$i,${"tuika".$i});//セット
                }
                $tuika5 = $data['tuika5'] - 1;
                $this->set('tuika5',$tuika5);//

            }elseif(isset($data['sakujo55']) && $data['tuika5'] == 0){//5goukisakujo0
                $dateye = $data['dateye'];
                $dateto = $data['dateto'];
                $this->set('dateye',$dateye);
                $this->set('dateto',$dateto);

                for($i=1; $i<=9; $i++){
                  ${"tuika".$i} = $data["tuika".$i];
                  $this->set('tuika'.$i,${"tuika".$i});//セット
                }

        }elseif (isset($data['tuika66']) && empty($data['sakujo66'])) {//6goukituika
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            for($i=1; $i<=9; $i++){
              ${"tuika".$i} = $data["tuika".$i];
              $this->set('tuika'.$i,${"tuika".$i});//セット
            }
            $tuika6 = $data['tuika6'] + 1;
            $this->set('tuika6',$tuika6);//

      }elseif(isset($data['sakujo66']) && $data['tuika6'] > 0){//6goukisakujo
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            for($i=1; $i<=9; $i++){
              ${"tuika".$i} = $data["tuika".$i];
              $this->set('tuika'.$i,${"tuika".$i});//セット
            }
            $tuika6 = $data['tuika6'] - 1;
            $this->set('tuika6',$tuika6);//

      }elseif(isset($data['sakujo66']) && $data['tuika6'] == 0){//6goukisakujo0
            $dateye = $data['dateye'];
            $dateto = $data['dateto'];
            $this->set('dateye',$dateye);
            $this->set('dateto',$dateto);

            for($i=1; $i<=9; $i++){
              ${"tuika".$i} = $data["tuika".$i];
              $this->set('tuika'.$i,${"tuika".$i});//セット
            }

          }elseif (isset($data['tuika77']) && empty($data['sakujo77'])) {//7goukituika
              $dateye = $data['dateye'];
              $dateto = $data['dateto'];
              $this->set('dateye',$dateye);
              $this->set('dateto',$dateto);

              for($i=1; $i<=9; $i++){
                ${"tuika".$i} = $data["tuika".$i];
                $this->set('tuika'.$i,${"tuika".$i});//セット
              }
              $tuika7 = $data['tuika7'] + 1;
              $this->set('tuika7',$tuika7);//

        }elseif(isset($data['sakujo77']) && $data['tuika7'] > 0){//7goukisakujo
              $dateye = $data['dateye'];
              $dateto = $data['dateto'];
              $this->set('dateye',$dateye);
              $this->set('dateto',$dateto);

              for($i=1; $i<=9; $i++){
                ${"tuika".$i} = $data["tuika".$i];
                $this->set('tuika'.$i,${"tuika".$i});//セット
              }
              $tuika7 = $data['tuika7'] - 1;
              $this->set('tuika7',$tuika7);//

        }elseif(isset($data['sakujo77']) && $data['tuika7'] == 0){//7goukisakujo0
              $dateye = $data['dateye'];
              $dateto = $data['dateto'];
              $this->set('dateye',$dateye);
              $this->set('dateto',$dateto);

              for($i=1; $i<=9; $i++){
                ${"tuika".$i} = $data["tuika".$i];
                $this->set('tuika'.$i,${"tuika".$i});//セット
              }

            }elseif (isset($data['tuika88']) && empty($data['sakujo88'])) {//8goukituika
                $dateye = $data['dateye'];
                $dateto = $data['dateto'];
                $this->set('dateye',$dateye);
                $this->set('dateto',$dateto);

                for($i=1; $i<=9; $i++){
                  ${"tuika".$i} = $data["tuika".$i];
                  $this->set('tuika'.$i,${"tuika".$i});//セット
                }
                $tuika8 = $data['tuika8'] + 1;
                $this->set('tuika8',$tuika8);//

          }elseif(isset($data['sakujo88']) && $data['tuika8'] > 0){//8goukisakujo
                $dateye = $data['dateye'];
                $dateto = $data['dateto'];
                $this->set('dateye',$dateye);
                $this->set('dateto',$dateto);

                for($i=1; $i<=9; $i++){
                  ${"tuika".$i} = $data["tuika".$i];
                  $this->set('tuika'.$i,${"tuika".$i});//セット
                }
                $tuika8 = $data['tuika8'] - 1;
                $this->set('tuika8',$tuika8);//

          }elseif(isset($data['sakujo88']) && $data['tuika8'] == 0){//8goukisakujo0
                $dateye = $data['dateye'];
                $dateto = $data['dateto'];
                $this->set('dateye',$dateye);
                $this->set('dateto',$dateto);

                for($i=1; $i<=9; $i++){
                  ${"tuika".$i} = $data["tuika".$i];
                  $this->set('tuika'.$i,${"tuika".$i});//セット
                }

              }elseif (isset($data['tuika99']) && empty($data['sakujo99'])) {//9goukituika
                  $dateye = $data['dateye'];
                  $dateto = $data['dateto'];
                  $this->set('dateye',$dateye);
                  $this->set('dateto',$dateto);

                  for($i=1; $i<=9; $i++){
                    ${"tuika".$i} = $data["tuika".$i];
                    $this->set('tuika'.$i,${"tuika".$i});//セット
                  }
                  $tuika9 = $data['tuika9'] + 1;
                  $this->set('tuika9',$tuika9);//

            }elseif(isset($data['sakujo99']) && $data['tuika9'] > 0){//9goukisakujo
                  $dateye = $data['dateye'];
                  $dateto = $data['dateto'];
                  $this->set('dateye',$dateye);
                  $this->set('dateto',$dateto);

                  for($i=1; $i<=9; $i++){
                    ${"tuika".$i} = $data["tuika".$i];
                    $this->set('tuika'.$i,${"tuika".$i});//セット
                  }
                  $tuika9 = $data['tuika9'] - 1;
                  $this->set('tuika9',$tuika9);//

            }elseif(isset($data['sakujo99']) && $data['tuika9'] == 0){//9goukisakujo0
                  $dateye = $data['dateye'];
                  $dateto = $data['dateto'];
                  $this->set('dateye',$dateye);
                  $this->set('dateto',$dateto);

                  for($i=1; $i<=9; $i++){
                    ${"tuika".$i} = $data["tuika".$i];
                    $this->set('tuika'.$i,${"tuika".$i});//セット
                  }

  			}else{
          return $this->redirect(['action' => 'karipreadd']);
      	}
      }
    }
/*
		public function karipreadd()
		{
      $KariKadouSeikei = $this->KariKadouSeikeis->newEntity();
      $this->set('KariKadouSeikei',$KariKadouSeikei);

      $session = $this->request->getSession();
      $data = $session->read();
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

		public function karilogout()
		{
			$this->request->session()->destroy(); // セッションの破棄
			return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
		}

    public function karido()
   {
     $KariKadouSeikeis = $this->KariKadouSeikeis->newEntity();
     $this->set('KariKadouSeikei',$KariKadouSeikeis);

     $session = $this->request->getSession();
     $data = $session->read();

     for($n=1; $n<=100; $n++){
       if(isset($_SESSION['karikadouseikei'][$n])){
         $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
         $_SESSION['karikadouseikei'][$n] = array_merge($_SESSION['karikadouseikei'][$n],$created_staff);
       }else{
         break;
       }
     }

     echo "<pre>";
     print_r($_SESSION['karikadouseikei']);
     echo "</pre>";

     if ($this->request->is('get')) {
       $KariKadouSeikeis = $this->KariKadouSeikeis->patchEntities($KariKadouSeikeis, $_SESSION['karikadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->KariKadouSeikeis->saveMany($KariKadouSeikeis)) {
           $connection->commit();// コミット5
         } else {
           $this->Flash->error(__('The data could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

     }
   }
*/
   public function index()
   {
     $this->request->session()->destroy(); // セッションの破棄

     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);
   }

   public function preform()
   {
     $this->request->session()->destroy(); // セッションの破棄

     $scheduleKouteis = $this->ScheduleKouteis->newEntity();
     $this->set('scheduleKouteis',$scheduleKouteis);
   }

   public function form()
   {
     session_start();
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);

     $data = $this->request->getData();//postデータを$dataに
     $dateYMDs = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 00:00";
     $dateYMDf = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 23:59";

     $ScheduleKoutei = $this->ScheduleKouteis->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'present_kensahyou' => 0])->toArray();
     $ScheduleKoutei_product_code = $ScheduleKoutei[0]->product_code;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける

      for($j=1; $j<=9; $j++){
      $ScheduleKoutei = $this->ScheduleKouteis->find()->where(['datetime >=' => $dateYMDs, 'datetime <=' => $dateYMDf, 'seikeiki' => $j, 'present_kensahyou' => 0])->toArray();

      ${"arrP".$j} = array();
      ${"n".$j} = 0;
      $this->set('n'.$j,${"n".$j});
         for($i=1; $i<=10; $i++){
           ${"arrP".$j.$i} = array();
           if(isset($ScheduleKoutei[$i-1])) {
             ${"ScheduleKoutei_id".$i} = $ScheduleKoutei[$i-1]->id;
             ${"datetime".$i} = $ScheduleKoutei[$i-1]->datetime->format('Y-m-d H:i:s');
             $dateYMD = $ScheduleKoutei[$i-1]->datetime->format('Y-m-d');
             $dateYMD1 = strtotime($dateYMD);
             $dayto = date('Y-m-d', strtotime('+1 day', $dateYMD1));
             $dateHI = date("08:00");
             ${"finishing_tm".$i} = $dayto." ".$dateHI;
             ${"seikeiki".$i} = $ScheduleKoutei[$i-1]->seikeiki;
             ${"product_code".$i} = $ScheduleKoutei[$i-1]->product_code;
             ${"present_kensahyou".$i} = $ScheduleKoutei[$i-1]->present_kensahyou;
             ${"product_name".$i} = $ScheduleKoutei[$i-1]->product_name;

             ${"arrP".$j}[] = ['id' => ${"ScheduleKoutei_id".$i}, 'datetime' => ${"datetime".$i},
              'product_code' => ${"product_code".$i},'seikeiki' => ${"seikeiki".$i},
              'present_kensahyou' => ${"present_kensahyou".$i},'product_name' => ${"product_name".$i},
              'finishing_tm' => ${"finishing_tm".$i}];

             ${"n".$j} = $i;
             $this->set('n'.$j,${"n".$j});//セット

           }
          }

          ${"ScheduleKouteisarry".$j} = array();//空の配列を作る

          foreach ((array)${"arrP".$j} as $key => $value) {//serialで並び替え
               $sort[$key] = $value['datetime'];
                array_push(${"ScheduleKouteisarry".$j}, ['id' => $value['id'], 'starting_tm' => $value['datetime'],
                 'seikeiki' => $value['seikeiki'], 'product_code' => $value['product_code'],
                  'present_kensahyou' => $value['present_kensahyou'], 'product_name' => $value['product_name'],
                'finishing_tm' => $value['finishing_tm']]);
          }
           if(isset(${"ScheduleKouteisarry".$j}[0])){
              array_multisort(array_map("strtotime", array_column( ${"ScheduleKouteisarry".$j}, "starting_tm" ) ), SORT_ASC, ${"ScheduleKouteisarry".$j});

      //    echo "<pre>";
      //    print_r(${"ScheduleKouteisarry".$j});
      //    echo "</pre>";

          for($m=1; $m<=${"n".$j}; $m++){//同じ成型機で製品が作られている個数分
            ${"arrP".$j.$m}[] = ${"ScheduleKouteisarry".$j}[$m-1];
            $this->set('arrP'.$j.$m,${"arrP".$j.$m});//セット
              if($m>=2){//同じ成型機で２つ以上の製品ができているとき
                $m1 = $m-1 ;
                ${"arrP".$j.$m1} = array();//m-1の配列を空にする
                $replacements = array('finishing_tm' => ${"ScheduleKouteisarry".$j}[$m-1]['starting_tm']);//１つ前のfin_tmを後のsta_tmに変更する
                ${"ScheduleKouteisarry".$j}[$m-2] = array_replace(${"ScheduleKouteisarry".$j}[$m-2], $replacements);
                ${"arrP".$j.$m1}[] = ${"ScheduleKouteisarry".$j}[$m-2];
                $this->set('arrP'.$j.$m1,${"arrP".$j.$m1});//セット
/*
                echo "<pre>";
                print_r($j."henkou".$m);
                print_r(${"arrP".$j.$m1});
                echo "</pre>";
                */
              }
/*
            echo "<pre>";
            print_r($j."--".$m);
            print_r(${"arrP".$j.$m});
            echo "</pre>";
*/
          }
        }
      }
   }

   public function confirm()
   {
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);//
/*
     $data = $this->request->getData();//postデータを$dataに
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
   }

		public function preadd()
		{
      $KadouSeikei = $this->KadouSeikeis->newEntity();
      $this->set('KadouSeikei',$KadouSeikei);
/*
      $session = $this->request->getSession();
      $data = $session->read();

      echo "<pre>";
      print_r($_SESSION['kadouseikeiId']);
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
    if ($this->request->is('get')) {
    echo "<pre>";
    print_r($_SESSION['kadouseikei']);
    echo "</pre>";
  }
*/

    if ($this->request->is('get')) {
      $KadouSeikeis = $this->KadouSeikeis->patchEntities($KadouSeikeis, $_SESSION['kadouseikei']);//$roleデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->KadouSeikeis->saveMany($KadouSeikeis)) {

          for($n=1; $n<=100; $n++){
            if(isset($_SESSION['kadouseikei'][$n])){

              $KariKadouSeikeiData = $this->KariKadouSeikeis->find()->where(['id' => $_SESSION['kadouseikeiId'][$n]])->toArray();//'present_kensahyou' => 0となるデータをKadouSeikeisテーブルから配列で取得
              $KariKadouSeikeistarting_tm = $KariKadouSeikeiData[0]->starting_tm->format('Y-m-d H:i:s');
        //      $KariKadouSeikeistarting_tm = substr($KariKadouSeikeistarting_tm,0,4)."-".substr($KariKadouSeikeistarting_tm,5,2)."-".substr($KariKadouSeikeistarting_tm,8,2);
              $KariKadouSeikeifinishing_tm = $KariKadouSeikeiData[0]->finishing_tm->format('Y-m-d H:i:s');
        //      $KariKadouSeikeifinishing_tm = substr($KariKadouSeikeifinishing_tm,0,4)."-".substr($KariKadouSeikeifinishing_tm,5,2)."-".substr($KariKadouSeikeifinishing_tm,8,2);
              $KariKadouSeikeicreated_at = $KariKadouSeikeiData[0]->created_at->format('Y-m-d H:i:s');

              $this->KariKadouSeikeis->updateAll(
              ['present_kensahyou' => 1 ,'starting_tm' => $KariKadouSeikeistarting_tm ,'finishing_tm' => $KariKadouSeikeifinishing_tm ,'created_at' => $KariKadouSeikeicreated_at ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
              ['id'   => $_SESSION['kadouseikeiId'][$n] ]
              );
            }else{
              break;
            }
          }

          $connection->commit();// コミット5
        } else {
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
