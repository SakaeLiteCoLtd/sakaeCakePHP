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
 * @property \App\Model\Table\OrderEdisTable $Roles
 *
 * @method \App\Model\Entity\Role[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class OrderEdisController extends AppController
{
     public function initialize()
     {
			 parent::initialize();
       $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
       $this->Users = TableRegistry::get('users');
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->OrderEdis = TableRegistry::get('orderEdis');//productsテーブルを使う
     }

     public function indexmenu()
     {
       $this->request->session()->destroy();// セッションの破棄
     }

     public function hattyucsv()
     {
       $this->request->session()->destroy();// セッションの破棄
       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);
     }

     public function hattyucsvpreadd()
 		{
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
      $file = $data['file'];
      $this->set('file',$file);

      $session = $this->request->getSession();
      $session->write('hattyucsvs.file', $file);
 		}

 		public function hattyucsvlogin()
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
 						return $this->redirect(['action' => 'hattyucsvdo']);
 					}
 				}
 		}

     public function hattyucsvdo()
     {
       $session = $this->request->getSession();
       $data = $session->read();
       $file = $_SESSION['hattyucsvs']['file'];
       $this->set('file',$file);

       $fp = fopen("EDI/$file", "r");//csvファイルはwebrootに入れる
       $fpcount = fopen("EDI/$file", 'r' );
       for($count = 0; fgets( $fpcount ); $count++ );
       $arrFp = array();//空の配列を作る
       $created_staff = $this->Auth->user('staff_id');
       for ($k=1; $k<=$count-1; $k++) {//最後の行まで
         $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
         $sample = explode(',',$line);//$lineを','毎に配列に入れる

          $keys=array_keys($sample);
          $keys[array_search('3',$keys)]='place_deliver_code';
   				$keys[array_search('10',$keys)]='date_order';
          $keys[array_search('12',$keys)]='price';
          $keys[array_search('14',$keys)]='amount';
          $keys[array_search('23',$keys)]='product_code';
          $keys[array_search('27',$keys)]='line_code';
          $keys[array_search('30',$keys)]='date_deliver';
          $keys[array_search('32',$keys)]='num_order';//名前の変更
          $keys[array_search('50',$keys)]='place_line';
   				$sample = array_combine( $keys, $sample );

          unset($sample['0'],$sample['1'],$sample['2'],$sample['4'],$sample['5'],$sample['6'],$sample['7'],$sample['8']);
          unset($sample['9'],$sample['11'],$sample['13'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);
          unset($sample['19'],$sample['20'],$sample['21'],$sample['22'],$sample['24'],$sample['25'],$sample['26']);
          unset($sample['28'],$sample['29'],$sample['30'],$sample['31'],$sample['33'],$sample['34'],$sample['35']);
          unset($sample['36'],$sample['37'],$sample['38'],$sample['39'],$sample['40'],$sample['41'],$sample['42']);
          unset($sample['43'],$sample['44'],$sample['45'],$sample['46'],$sample['47'],$sample['48'],$sample['49']);
          unset($sample['51'],$sample['52'],$sample['53'],$sample['54'],$sample['55'],$sample['56'],$sample['57']);
          unset($sample['58'],$sample['59'],$sample['60'],$sample['61'],$sample['62'],$sample['63'],$sample['64']);
          unset($sample['65'],$sample['66'],$sample['67'],$sample['68'],$sample['69'],$sample['70'],$sample['71']);
          unset($sample['72'],$sample['73'],$sample['74'],$sample['75'],$sample['76'],$sample['77'],$sample['78']);
          unset($sample['79'],$sample['80'],$sample['81'],$sample['82'],$sample['83'],$sample['84'],$sample['85']);
          unset($sample['86'],$sample['87'],$sample['88'],$sample['89'],$sample['90'],$sample['91'],$sample['92']);
          unset($sample['93'],$sample['94'],$sample['95'],$sample['96'],$sample['97'],$sample['98'],$sample['99']);
          unset($sample['100'],$sample['101'],$sample['102'],$sample['103'],$sample['104'],$sample['105'],$sample['106']);
          unset($sample['107'],$sample['108'],$sample['109'],$sample['110'],$sample['111'],$sample['112'],$sample['113']);
          unset($sample['114'],$sample['115'],$sample['116'],$sample['117'],$sample['118'],$sample['119'],$sample['120']);
          unset($sample['121'],$sample['122'],$sample['123'],$sample['124'],$sample['125'],$sample['126'],$sample['127']);
          unset($sample['128'],$sample['129']);//最後の改行を削除

          if($k>=2){
            $arrFp[] = $sample;//配列に追加する
 					}
       }

       for($n=0; $n<=1000; $n++){
         if(isset($arrFp[$n])){
           $arrFp[$n] = array_merge($arrFp[$n],array('check_denpyou'=>0));
           $arrFp[$n] = array_merge($arrFp[$n],array('bunnou'=>0));
           $arrFp[$n] = array_merge($arrFp[$n],array('kannou'=>0));
           $arrFp[$n] = array_merge($arrFp[$n],array('delete_flag'=>0));
           $arrFp[$n] = array_merge($arrFp[$n],array('created_staff'=>$created_staff));
         }else{
           break;
         }
       }

       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);
        if ($this->request->is('get')) {
          $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
          $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
          $connection->begin();//トランザクション3
          try {//トランザクション4
              if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録
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

    public function dnpcsv()
    {
      $this->request->session()->destroy(); // セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function dnpcsvpreadd()
    {
     session_start();
     $orderEdis = $this->OrderEdis->newEntity();
     $this->set('orderEdis',$orderEdis);
     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
     $file = $data['file'];
     $this->set('file',$file);
    /*      $session = $this->request->getSession();
     $_SESSION['file'] = array(
       "file" => $file,
     );
    */
     $session = $this->request->getSession();
     $session->write('dnpcsvs.file', $file);
    /*
     echo "<pre>";
     print_r($_SESSION['hattyucsvs']['file']);
     echo "</pre>";
    */
    }

    public function dnpcsvlogin()
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
           return $this->redirect(['action' => 'dnpcsvdo']);
         }
       }
    }

    public function dnpcsvdo()
    {
      $session = $this->request->getSession();
      $data = $session->read();
      $file = $_SESSION['dnpcsvs']['file'];
      $this->set('file',$file);

      $fp = fopen("EDI/$file", "r");//csvファイルはwebrootに入れる
      $fpcount = fopen("EDI/$file", 'r' );
      for($count = 0; fgets( $fpcount ); $count++ );
      $arrFp = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');
      for ($k=1; $k<=$count-1; $k++) {//最後の行まで
        $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
        $sample = explode(',',$line);//$lineを','毎に配列に入れる

         $keys=array_keys($sample);
         $keys[array_search('2',$keys)]='num_order';//名前の変更
         $keys[array_search('7',$keys)]='product_code';
         $keys[array_search('10',$keys)]='amount';
         $keys[array_search('11',$keys)]='price';
         $keys[array_search('13',$keys)]='date_deliver';
         $keys[array_search('14',$keys)]='place_deliver_code';
         $sample = array_combine( $keys, $sample );

         unset($sample['0'],$sample['1'],$sample['3'],$sample['4'],$sample['5'],$sample['6'],$sample['8'],$sample['9']);
         unset($sample['12'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);//最後の改行を削除

         if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき
           $arrFp[] = $sample;//配列に追加する
         }
      }

      for($n=0; $n<=1000; $n++){
        if(isset($arrFp[$n])){
          $arrFp[$n] = array_merge($arrFp[$n],array('place_line'=>date("-")));
          $arrFp[$n] = array_merge($arrFp[$n],array('date_order'=>date("Y-m-d")));
          $arrFp[$n] = array_merge($arrFp[$n],array('check_denpyou'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('bunnou'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('kannou'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('delete_flag'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('created_staff'=>$created_staff));
        }else{
          break;
        }
      }

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
       if ($this->request->is('get')) {
         $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
             if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録
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

    public function keikakucsv()
    {
      $this->request->session()->destroy(); // セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function keikakucsvpreadd()
    {
     session_start();
     $orderEdis = $this->OrderEdis->newEntity();
     $this->set('orderEdis',$orderEdis);
     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
     $file = $data['file'];
     $this->set('file',$file);
    /*      $session = $this->request->getSession();
     $_SESSION['file'] = array(
       "file" => $file,
     );
    */
     $session = $this->request->getSession();
     $session->write('keikakucsvs.file', $file);
    /*
     echo "<pre>";
     print_r($_SESSION['hattyucsvs']['file']);
     echo "</pre>";
    */
    }

    public function keikakucsvlogin()
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
            return $this->redirect(['action' => 'keikakucsvdo']);
          }
        }
    }

    public function keikakucsvdo()
    {
      $session = $this->request->getSession();
      $data = $session->read();
      $file = $_SESSION['keikakucsvs']['file'];
      $this->set('file',$file);

      $fp = fopen("EDI/$file", "r");//csvファイルはwebrootに入れる
      $fpcount = fopen("EDI/$file", 'r' );
      for($count = 0; fgets( $fpcount ); $count++ );
      $arrFp = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');
      for ($k=1; $k<=$count-1; $k++) {//最後の行まで
        $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
        $sample = explode(',',$line);//$lineを','毎に配列に入れる

         $keys=array_keys($sample);
         $keys[array_search('3',$keys)]='place_deliver_code';
          $keys[array_search('10',$keys)]='date_order';
         $keys[array_search('12',$keys)]='price';
         $keys[array_search('14',$keys)]='amount';
         $keys[array_search('23',$keys)]='product_code';
         $keys[array_search('27',$keys)]='line_code';
         $keys[array_search('30',$keys)]='date_deliver';
         $keys[array_search('32',$keys)]='num_order';//名前の変更
         $keys[array_search('50',$keys)]='place_line';
          $sample = array_combine( $keys, $sample );

         unset($sample['0'],$sample['1'],$sample['2'],$sample['4'],$sample['5'],$sample['6'],$sample['7'],$sample['8']);
         unset($sample['9'],$sample['11'],$sample['13'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);
         unset($sample['19'],$sample['20'],$sample['21'],$sample['22'],$sample['24'],$sample['25'],$sample['26']);
         unset($sample['28'],$sample['29'],$sample['30'],$sample['31'],$sample['33'],$sample['34'],$sample['35']);
         unset($sample['36'],$sample['37'],$sample['38'],$sample['39'],$sample['40'],$sample['41'],$sample['42']);
         unset($sample['43'],$sample['44'],$sample['45'],$sample['46'],$sample['47'],$sample['48'],$sample['49']);
         unset($sample['51'],$sample['52'],$sample['53'],$sample['54'],$sample['55'],$sample['56'],$sample['57']);
         unset($sample['58'],$sample['59'],$sample['60'],$sample['61'],$sample['62'],$sample['63'],$sample['64']);
         unset($sample['65'],$sample['66'],$sample['67'],$sample['68'],$sample['69'],$sample['70'],$sample['71']);
         unset($sample['72'],$sample['73'],$sample['74'],$sample['75'],$sample['76'],$sample['77'],$sample['78']);
         unset($sample['79'],$sample['80'],$sample['81'],$sample['82'],$sample['83'],$sample['84'],$sample['85']);
         unset($sample['86'],$sample['87'],$sample['88'],$sample['89'],$sample['90'],$sample['91'],$sample['92']);
         unset($sample['93'],$sample['94'],$sample['95'],$sample['96'],$sample['97'],$sample['98'],$sample['99']);
         unset($sample['100'],$sample['101'],$sample['102'],$sample['103'],$sample['104'],$sample['105'],$sample['106']);
         unset($sample['107'],$sample['108'],$sample['109'],$sample['110'],$sample['111'],$sample['112'],$sample['113']);
         unset($sample['114'],$sample['115'],$sample['116'],$sample['117'],$sample['118'],$sample['119'],$sample['120']);
         unset($sample['121'],$sample['122'],$sample['123'],$sample['124'],$sample['125'],$sample['126'],$sample['127']);
         unset($sample['128'],$sample['129']);//最後の改行を削除

         if($k>=2){
           $arrFp[] = $sample;//配列に追加する
          }
      }

      for($n=0; $n<=1000; $n++){
        if(isset($arrFp[$n])){
          $arrFp[$n] = array_merge($arrFp[$n],array('check_denpyou'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('bunnou'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('kannou'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('delete_flag'=>0));
          $arrFp[$n] = array_merge($arrFp[$n],array('created_staff'=>$created_staff));
        }else{
          break;
        }
      }
    /*
      echo "<pre>";
      print_r($arrFp);
      echo "<br>";
    */
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
       if ($this->request->is('get')) {
         $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
             if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録
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

}
