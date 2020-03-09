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
       $this->Staffs = TableRegistry::get('staffs');
       $this->Users = TableRegistry::get('users');
       $this->Products = TableRegistry::get('products');
       $this->Customers = TableRegistry::get('customers');
       $this->OrderEdis = TableRegistry::get('orderEdis');
       $this->DenpyouDnps = TableRegistry::get('denpyouDnps');
       $this->OrderDnpKannous = TableRegistry::get('orderDnpKannous');
       $this->SyoyouKeikakus = TableRegistry::get('syoyouKeikakus');
       $this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
       $this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
     }

     public function indexmenu()
     {
       $this->request->session()->destroy();// セッションの破棄
     }

     public function hattyucsv()
     {
       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);

       if ($this->request->is('post')) {
       $source_file = $_FILES['file']['tmp_name'];
//文字変換（不要）     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));
       $fp = fopen($source_file, 'r');
       $fpcount = fopen($source_file, 'r' );

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
           unset($sample['128'],$sample['129']);//最後の改行も削除

           if($k>=2){
             $arrFp[] = $sample;//配列に追加する
           }
        }

        for($n=0; $n<=10000; $n++){
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

       echo "<pre>";
       print_r($arrFp);
       echo "</pre>";

           $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
           $connection = ConnectionManager::get('default');//トランザクション1
           // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
               if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録
                 $mes = "※登録されました";
                 $this->set('mes',$mes);
//文字変換（不要）                      file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
                 $connection->commit();// コミット5
               } else {
//文字変換（不要）                      file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
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

     public function hattyucsvpreadd()
 		{
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
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
 						$delete_flag = $Userdata[0]->delete_flag;
 						$this->set('delete_flag',$delete_flag);
 					}
 						$user = $this->Auth->identify();
 					if ($user) {
 						$this->Auth->setUser($user);
            return $this->redirect(['action' => 'hattyucsv']);
 					}
 				}
 		}

     public function hattyucsvdo()//不使用
     {
       $session = $this->request->getSession();
       $data = $session->read();
       $file = $_SESSION['hattyucsvs']['file']['tmp_name'];
       $this->set('file',$file);

       echo "<pre>";
       print_r($file);
       echo "</pre>";

  //文字変換（不要）    file_put_contents("/home/centosuser/EDI/$file", mb_convert_encoding(file_get_contents("/home/centosuser/EDI/$file"), 'UTF-8', 'SJIS'));
      $fp = fopen($file, 'r');
      $fpcount = fopen($file, 'r' );
/*
//文字変換（不要）      file_put_contents("EDI/$file", mb_convert_encoding(file_get_contents("EDI/$file"), 'UTF-8', 'SJIS'));
      $fp = fopen("EDI/$file", "r");//csvファイルはwebrootに入れる
      $fpcount = fopen("EDI/$file", 'r' );
*/       for($count = 0; fgets( $fpcount ); $count++ );
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
          unset($sample['128'],$sample['129']);//最後の改行も削除

          if($k>=2){
            $arrFp[] = $sample;//配列に追加する
 					}
       }

       for($n=0; $n<=10000; $n++){
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

      echo "<pre>";
      print_r($arrFp);
      echo "</pre>";

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
            //    file_put_contents("EDI/$file", mb_convert_encoding(file_get_contents("EDI/$file"), 'SJIS', 'UTF-8'));
    //            file_put_contents("/home/centosuser/EDI/$file", mb_convert_encoding(file_get_contents("/home/centosuser/EDI/$file"), 'SJIS', 'UTF-8'));
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

    public function dnpcsvpreadd()
    {
     session_start();
     $orderEdis = $this->OrderEdis->newEntity();
     $this->set('orderEdis',$orderEdis);
     $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
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
           $delete_flag = $Userdata[0]->delete_flag;
           $this->set('delete_flag',$delete_flag);
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'dnpcsv']);
         }
       }
    }

    public function dnpcsv()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      if ($this->request->is('post')) {
/*      $data = $this->request->getData();
      echo "<pre>";
      print_r($_FILES['file']['tmp_name']);
      echo "</pre>";
*/
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->newEntity();
      $this->set('denpyouDnpMinoukannous',$denpyouDnpMinoukannous);
      $dnpTotalAmounts = $this->DnpTotalAmounts->newEntity();
      $this->set('dnpTotalAmounts',$dnpTotalAmounts);

      $source_file = $_FILES['file']['tmp_name'];
      file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));
      $fp1 = fopen($source_file, 'r');
      $fp2 = fopen($source_file, 'r');
      $fp3 = fopen($source_file, 'r');
      $fpcount = fopen($source_file, 'r' );

      for($count = 0; fgets( $fpcount ); $count++ );
      $arrEDI = array();//空の配列を作る
      $arrDenpyouDnpMinoukannous = array();//空の配列を作る
      $arrDnpTotalAmounts = array();//空の配列を作る
      $arrDnpdouitutyuumon = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');

      $num = 1;

        for ($k=1; $k<=$count-1; $k++) {//最後の行まで
          $line = fgets($fp1);//ファイル$fpの上の１行を取る（２行目から）
          $sample = explode(',',$line);//$lineを','毎に配列に入れる

           $keys=array_keys($sample);
           $keys[array_search('2',$keys)]='num_order';//名前の変更
           $keys[array_search('3',$keys)]='name_order';
           $keys[array_search('4',$keys)]='line_code';
           $keys[array_search('7',$keys)]='product_code';
           $keys[array_search('9',$keys)]='date_order';
           $keys[array_search('10',$keys)]='amount';
           $keys[array_search('11',$keys)]='price';
           $keys[array_search('13',$keys)]='date_deliver';
           $keys[array_search('14',$keys)]='place_deliver_code';
  //         $keys[array_search('15',$keys)]='place_deliver_name';
           $sample = array_combine( $keys, $sample );

           unset($sample['0'],$sample['1'],$sample['4'],$sample['5'],$sample['6'],$sample['8']);
           unset($sample['12'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

           if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき
             $arrEDI[] = $sample;//配列に追加する
           }
        }

        for($n=0; $n<=10000; $n++){
          if(isset($arrEDI[$n])){
            $Product = $this->Products->find()->where(['product_code' => $arrEDI[$n]['product_code']])->toArray();
    				$customer_id = $Product[0]->customer_id;
            $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
    				$customer_code = $Customer[0]->customer_code;

            $arrEDI[$n] = array_merge($arrEDI[$n],array('place_line'=>"-"));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('check_denpyou'=>0));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('customer_code'=>$customer_code));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('first_date_deliver'=>$arrEDI[$n]['date_deliver']));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('gaityu'=>0));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('bunnou'=>0));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('kannou'=>0));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('delete_flag'=>0));
            $arrEDI[$n] = array_merge($arrEDI[$n],array('created_staff'=>$created_staff));
          }else{
            break;
          }
        }
/*
      echo "<pre>";
      print_r("arrEDI");
      print_r($arrEDI);
      echo "</pre>";
*/
      $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrEDI);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
          if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録

            for ($k=1; $k<=$count-1; $k++) {//最後の行まで
              $line = fgets($fp2);//ファイル$fpの上の１行を取る（２行目から）
              $sample = explode(',',$line);//$lineを','毎に配列に入れる

               $keys=array_keys($sample);
               $keys[array_search('2',$keys)]='num_order';//名前の変更
               $keys[array_search('3',$keys)]='name_order';
               $keys[array_search('4',$keys)]='code';
               $keys[array_search('7',$keys)]='product_code';
               $keys[array_search('9',$keys)]='tourokubi';
               $keys[array_search('13',$keys)]='date_deliver';
               $keys[array_search('15',$keys)]='place_deliver';
               $sample = array_combine( $keys, $sample );

               unset($sample['0'],$sample['1'],$sample['5'],$sample['6'],$sample['8'],$sample['10']);
               unset($sample['11'],$sample['12'],$sample['13'],$sample['14'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

               if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき
                 $arrDenpyouDnpMinoukannous[] = $sample;//配列に追加する
               }
            }

            for($n=0; $n<=10000; $n++){
              if(isset($arrDenpyouDnpMinoukannous[$n])){
                $OrderEdi = $this->OrderEdis->find()->where(['num_order' => $arrDenpyouDnpMinoukannous[$n]['num_order'], 'product_code' => $arrDenpyouDnpMinoukannous[$n]['product_code'], 'date_order' => $arrDenpyouDnpMinoukannous[$n]['tourokubi'], 'date_deliver' => $arrDenpyouDnpMinoukannous[$n]['date_deliver']])->toArray();
        				$OrderEdi_id = $OrderEdi[0]->id;

                unset($arrDenpyouDnpMinoukannous[$n]['num_order']);
                unset($arrDenpyouDnpMinoukannous[$n]['code']);
                unset($arrDenpyouDnpMinoukannous[$n]['date_deliver']);
                unset($arrDenpyouDnpMinoukannous[$n]['product_code']);
                unset($arrDenpyouDnpMinoukannous[$n]['tourokubi']);

                $arrDenpyouDnpMinoukannous[$n] = array_merge($arrDenpyouDnpMinoukannous[$n],array('order_edi_id'=>$OrderEdi_id));
                $arrDenpyouDnpMinoukannous[$n] = array_merge($arrDenpyouDnpMinoukannous[$n],array('conf_print'=>0));
                $arrDenpyouDnpMinoukannous[$n] = array_merge($arrDenpyouDnpMinoukannous[$n],array('minoukannou'=>1));
                $arrDenpyouDnpMinoukannous[$n] = array_merge($arrDenpyouDnpMinoukannous[$n],array('delete_flag'=>0));
                $arrDenpyouDnpMinoukannous[$n] = array_merge($arrDenpyouDnpMinoukannous[$n],array('created_staff'=>$created_staff));
              }else{
                break;
              }
            }
/*
            echo "<pre>";
            print_r("arrDenpyouDnpMinoukannous");
            print_r($arrDenpyouDnpMinoukannous);
            echo "</pre>";
*/
            $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntities($denpyouDnpMinoukannous, $arrDenpyouDnpMinoukannous);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
            if ($this->DenpyouDnpMinoukannous->saveMany($denpyouDnpMinoukannous)) {//saveManyで一括登録

              for ($k=1; $k<=$count-1; $k++) {//最後の行まで
                $line = fgets($fp3);//ファイル$fpの上の１行を取る（２行目から）
                $sample = explode(',',$line);//$lineを','毎に配列に入れる

                 $keys=array_keys($sample);
                 $keys[array_search('2',$keys)]='num_order';//名前の変更
                 $keys[array_search('3',$keys)]='name_order';
                 $keys[array_search('4',$keys)]='line_code';
                 $keys[array_search('7',$keys)]='product_code';
                 $keys[array_search('9',$keys)]='date_order';
                 $keys[array_search('10',$keys)]='amount';
                 $keys[array_search('13',$keys)]='date_deliver';
                 $sample = array_combine( $keys, $sample );

                 unset($sample['0'],$sample['1'],$sample['3'],$sample['5'],$sample['6'],$sample['8']);
                 unset($sample['11'],$sample['12'],$sample['14'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

                 if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき
                   $OrderEdi = $this->OrderEdis->find()->where(['line_code' => $sample['line_code'], 'num_order' => $sample['num_order'], 'product_code' => $sample['product_code'], 'date_order' => $sample['date_order']])->toArray();//
                   $total_amount = $OrderEdi[0]['amount'];
                   $date_deliver = $OrderEdi[0]['date_deliver'];
                   ${"arrDnpdouitutyuumon".($k-2)} = array();//空の配列を作る

                     for($n=0; $n<=10000; $n++){
                       if(isset($OrderEdi[$n])){//同じ注番のものが既に分納されているとき
                         if(isset($OrderEdi[$n+1])){
                           $total_amount = $total_amount + $OrderEdi[$n+1]['amount'];//amountを合計する、DenpyouDnpMinoukannousのminoukannouを更新する（date_deliverが小さい方を０に）
                           $orderedi_id = $OrderEdi[$n]['id'];
                           $date_deliver = $OrderEdi[$n]['date_deliver'];
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['id'] = $orderedi_id;
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['date_deliver'] = $date_deliver->format('Y-m-d');
                         }else{
                           $orderedi_id = $OrderEdi[$n]['id'];
                           $date_deliver = $OrderEdi[$n]['date_deliver'];
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['id'] = $orderedi_id;
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['date_deliver'] = $date_deliver->format('Y-m-d');
                         }
                       }else{
                         break;
                       }
                     }

                      foreach (${"arrDnpdouitutyuumon".($k-2)} as $key => $value) {
                          $sort[$key] = $value['date_deliver'];
                      }
                      array_multisort( array_map( "strtotime", array_column( ${"arrDnpdouitutyuumon".($k-2)}, "date_deliver" ) ), SORT_ASC, ${"arrDnpdouitutyuumon".($k-2)} ) ;//時間で並び替え

                      $arrDnpdouitutyuumon[] = ${"arrDnpdouitutyuumon".($k-2)};
/*
                     for($n=1; $n<=10000; $n++){
                       if(isset($OrderEdi[$n])){//同じ注番のものが既に分納されているとき
//                         echo "<pre>";
//                         print_r($n."---".$OrderEdi[$n]['num_order']."---".$sample['num_order'].">>>".$OrderEdi[$n]['product_code']."---".$sample['product_code'].">>>".$OrderEdi[$n]['date_order']."---".$sample['date_order']);
//                         echo "</pre>";
                         $total_amount = $total_amount + $OrderEdi[$n]['amount'];//amountを合計する、DenpyouDnpMinoukannousのminoukannouを更新する（date_deliverが小さい方を０に）
                         if($sample['date_deliver'] > $OrderEdi[$n]['date_deliver']){
                           $date_deliver = $sample['date_deliver'];

                           $DenpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['num_order' => $sample['num_order'], 'product_code' => $sample['product_code'], 'date_deliver' => $OrderEdi[$n]['date_deliver']])->toArray();//
                           $DenpyouDnpMinoukannouId = $DenpyouDnpMinoukannou[0]->id;
                           $this->DenpyouDnpMinoukannous->updateAll(
                           ['minoukannou' => 0],//updated_atは自動更新されない
                           ['id'   => $DenpyouDnpMinoukannouId]
                           );

                          }elseif($sample['date_deliver'] < $OrderEdi[$n]['date_deliver']){
                            $date_deliver = $OrderEdi[$n]['date_deliver'];
                            $DenpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['num_order' => $sample['num_order'], 'product_code' => $sample['product_code'], 'date_deliver' => $sample['date_deliver']])->toArray();//
                            $DenpyouDnpMinoukannouId = $DenpyouDnpMinoukannou[0]->id;
                            $this->DenpyouDnpMinoukannous->updateAll(
                            ['minoukannou' => 0],//updated_atは自動更新されない
                            ['id'   => $DenpyouDnpMinoukannouId]
                            );

                         }else{
                           $date_deliver = $OrderEdi[$n]['date_deliver'];
                         }
                       }
                     }
*/
                     $arrDnpTotalAmounts[$k-2]['num_order'] = $sample['num_order'];//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['name_order'] = $sample['name_order'];//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['line_code'] = $sample['line_code'];//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['product_code'] = $sample['product_code'];//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['date_order'] = $sample['date_order'];//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['amount'] = $total_amount;//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['date_deliver'] = $date_deliver->format('Y-m-d');//配列に追加する
                 }
              }

              $uniquearrDnpdouitutyuumon = array_unique($arrDnpdouitutyuumon, SORT_REGULAR);//重複削除
              $uniquearrDnpdouitutyuumon = array_values($uniquearrDnpdouitutyuumon);
/*
              echo "<pre>";
              print_r($uniquearrDnpdouitutyuumon);
              echo "</pre>";
*/
              //これを使って、１order_ediテーブルのbunnnouを更新、２dnp_minoukannouテーブルのminoukannouを更新

              for($n=0; $n<=10000; $n++){
                if(isset($uniquearrDnpdouitutyuumon[$n])){
                  for($m=1; $m<=10000; $m++){
                    if(isset($uniquearrDnpdouitutyuumon[$n][$m])){//id = $uniquearrDnpdouitutyuumon[$n][$m-1]['id']　のDenpyouDnpMinoukannousデータを更新
                      $DenpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $uniquearrDnpdouitutyuumon[$n][$m-1]['id']])->toArray();//
                      $DenpyouDnpMinoukannouId = $DenpyouDnpMinoukannou[0]->id;
                      $this->DenpyouDnpMinoukannous->updateAll(
                      ['minoukannou' => 0],//updated_atは自動更新されない
                      ['id'  => $DenpyouDnpMinoukannouId]
                      );
/*
                      echo "<pre>";
                      print_r($n."--".$m."--".$DenpyouDnpMinoukannouId);
                      echo "</pre>";
*/
                      $this->OrderEdis->updateAll(
                      ['bunnou' => $m],//updated_atは自動更新されない
                      ['id'   => $uniquearrDnpdouitutyuumon[$n][$m-1]['id']]
                      );
                      $this->OrderEdis->updateAll(
                      ['bunnou' => $m+1],//updated_atは自動更新されない
                      ['id'   => $uniquearrDnpdouitutyuumon[$n][$m]['id']]
                      );
                    }else{
                      break;
                    }
                  }
                }else{
                  break;
                }
              }

              for($n=0; $n<=10000; $n++){
                if(isset($arrDnpTotalAmounts[$n])){
                  $arrDnpTotalAmounts[$n] = array_merge($arrDnpTotalAmounts[$n],array('delete_flag'=>0));
                  $arrDnpTotalAmounts[$n] = array_merge($arrDnpTotalAmounts[$n],array('created_staff'=>$created_staff));
                }else{
                  break;
                }
              }
/*
              echo "<pre>";
              print_r("arrDnpTotalAmounts");
              print_r($arrDnpTotalAmounts);
              echo "</pre>";
*/
              $uniquearrDnpTotalAmounts = array_unique($arrDnpTotalAmounts, SORT_REGULAR);//重複削除
/*
              echo "<pre>";
              print_r("uniquearrDnpTotalAmounts");
              print_r($uniquearrDnpTotalAmounts);
              echo "</pre>";
*/
               $dnpTotalAmounts = $this->DnpTotalAmounts->patchEntities($dnpTotalAmounts, $uniquearrDnpTotalAmounts);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                   if ($this->DnpTotalAmounts->saveMany($dnpTotalAmounts)) {//saveManyで一括登録
                     $mes = "※登録されました";
                     $this->set('mes',$mes);
                   } else {
                     $mes = "※登録されませんでした";
                     $this->set('mes',$mes);
                     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
                     $this->Flash->error(__('The dnpTotalAmounts could not be saved. Please, try again.'));
                     throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                   }
              } else {
                $mes = "※登録されませんでした";
                $this->set('mes',$mes);
                file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
                $this->Flash->error(__('This denpyouDnpMinoukannous could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }
              file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
              $connection->commit();// コミット5
        } else {
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);
          file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
          $this->Flash->error(__('This orderEdis could not be saved. Please, try again.'));
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
//      $this->request->session()->destroy(); // セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $syoyouKeikakus = $this->SyoyouKeikakus->newEntity();
      $this->set('syoyouKeikakus',$syoyouKeikakus);
      $countP = 0;
      $countW = 0;
      $countR = 0;

      if ($this->request->is('post')) {
      $data = $this->request->getData();
/*      echo "<pre>";
      print_r($_FILES['file']['tmp_name']);
      echo "</pre>";
*/
      $source_file = $_FILES['file']['tmp_name'];
//文字変換（不要）     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));
      $fp = fopen($source_file, "r");
      $fpcount = fopen($source_file, 'r' );

      for($count = 0; fgets( $fpcount ); $count++ );
      $arrSyoyouKeikaku = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');
      for ($k=1; $k<=$count-1; $k++) {//最後の行まで
        $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
        $sample = explode(',',$line);//$lineを','毎に配列に入れる

         $keys=array_keys($sample);
         $keys[array_search('2',$keys)]='date_keikaku';//名前の変更
         $keys[array_search('17',$keys)]='product_code';
         $keys[array_search('19',$keys)]='date_deliver';
         $keys[array_search('20',$keys)]='amount';
         $keys[array_search('22',$keys)]='num_keikaku';
         $sample = array_combine( $keys, $sample );

         unset($sample['0'],$sample['1'],$sample['4'],$sample['3'],$sample['5'],$sample['6'],$sample['7'],$sample['8']);
         unset($sample['9'],$sample['10'],$sample['11'],$sample['12'],$sample['13'],$sample['14'],$sample['15']);
         unset($sample['16'],$sample['18'],$sample['21'],$sample['23'],$sample['24'],$sample['25'],$sample['26']);
         unset($sample['27'],$sample['28'],$sample['29'],$sample['30'],$sample['31'],$sample['32'],$sample['33'],$sample['34']);
         unset($sample['35'],$sample['36'],$sample['37'],$sample['38'],$sample['39'],$sample['40'],$sample['41']);//最後の改行も削除

         if($k>=2 && !empty($sample['product_code'])){
             $arrSyoyouKeikaku[] = $sample;//配列に追加する
             $this->SyoyouKeikakus->deleteAll(['product_code' => $sample['product_code']]);//格納した品番の所要計画データは一旦削除
             if(substr($sample['product_code'],0,1) == "P"){
               $countP = $countP + 1;
             }elseif(substr($sample['product_code'],0,1) == "w"){
               $countW = $countW + 1;
             }elseif(substr($sample['product_code'],0,1) == "R"){
               $countR = $countR + 1;
             }else{
               $countP = $countP;
               $countW = $countW;
               $countR = $countR;
             }
          }
      }

      if($countP >= 10){//この場合、customer_id=1（customer_code=10001）パナソニック(株)HA社キッチンアプライアンス（事）草津工場の製品をSyoyouKeikakusテーブルから削除
        $Products_P = $this->Products->find()->where(['customer_id' => '1']);
        foreach ($Products_P as $value) {
          $product_code= $value->product_code;
          $this->SyoyouKeikakus->deleteAll(['product_code' => $product_code]);
        }
      }

      if($countW >= 5){//customer_id=2（customer_code=10002）パナソニック(株)HA社ランドリークリーナー（事）静岡工場の製品をSyoyouKeikakusテーブルから削除
        $Products_W = $this->Products->find()->where(['customer_id' => '2']);
        foreach ($Products_W as $value) {
          $product_code= $value->product_code;
          $this->SyoyouKeikakus->deleteAll(['product_code' => $product_code]);
        }
      }

      if($countR >= 5){//customer_id=3（customer_code=10003）パナソニック(株)HA社キッチンアプライアンス（事）加東工場の製品をSyoyouKeikakusテーブルから削除
        $Products_R = $this->Products->find()->where(['customer_id' => '3']);
        foreach ($Products_R as $value) {
          $product_code= $value->product_code;
          $this->SyoyouKeikakus->deleteAll(['product_code' => $product_code]);
        }
      }
/*
      echo "<pre>";
      print_r($arrSyoyouKeikaku);
      echo "</pre>";
*/
          rename($source_file,$source_file."test");

//       if ($this->request->is('get')) {
         $syoyouKeikakus = $this->SyoyouKeikakus->patchEntities($syoyouKeikakus, $arrSyoyouKeikaku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
             if ($this->SyoyouKeikakus->saveMany($syoyouKeikakus)) {//saveManyで一括登録
               $mes = "※登録されました";
               $this->set('mes',$mes);
    //           file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
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
//       }
     }
    }

    public function keikakucsvpreadd()
    {
     session_start();
     $orderEdis = $this->OrderEdis->newEntity();
     $this->set('orderEdis',$orderEdis);
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
            $delete_flag = $Userdata[0]->delete_flag;
            $this->set('delete_flag',$delete_flag);
          }
            $user = $this->Auth->identify();
          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'keikakucsv']);
          }
        }
    }

    public function keikakucsvdo()//不使用
    {
      $session = $this->request->getSession();
      $data = $session->read();
      $file = $_SESSION['keikakucsvs']['file'];
      $this->set('file',$file);
      $syoyouKeikakus = $this->SyoyouKeikakus->newEntity();
      $this->set('syoyouKeikakus',$syoyouKeikakus);
      $countP = 0;
      $countW = 0;
      $countR = 0;
/*
    //文字変換（不要）  file_put_contents("EDI/$file", mb_convert_encoding(file_get_contents("EDI/$file"), 'UTF-8', 'SJIS'));//
      $fp = fopen("EDI/$file", "r");//csvファイルはwebrootに入れる
      $fpcount = fopen("EDI/$file", 'r' );
*/
//文字変換（不要）     file_put_contents("/home/centosuser/EDI/$file", mb_convert_encoding(file_get_contents("/home/centosuser/EDI/$file"), 'UTF-8', 'SJIS'));
      $fp = fopen("/home/centosuser/EDI/$file", "r");
      $fpcount = fopen("/home/centosuser/EDI/$file", 'r' );

      for($count = 0; fgets( $fpcount ); $count++ );
      $arrSyoyouKeikaku = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');
      for ($k=1; $k<=$count-1; $k++) {//最後の行まで
        $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
        $sample = explode(',',$line);//$lineを','毎に配列に入れる

         $keys=array_keys($sample);
         $keys[array_search('2',$keys)]='date_keikaku';//名前の変更
         $keys[array_search('17',$keys)]='product_code';
         $keys[array_search('19',$keys)]='date_deliver';
         $keys[array_search('20',$keys)]='amount';
         $keys[array_search('22',$keys)]='num_keikaku';
         $sample = array_combine( $keys, $sample );

         unset($sample['0'],$sample['1'],$sample['4'],$sample['3'],$sample['5'],$sample['6'],$sample['7'],$sample['8']);
         unset($sample['9'],$sample['10'],$sample['11'],$sample['12'],$sample['13'],$sample['14'],$sample['15']);
         unset($sample['16'],$sample['18'],$sample['21'],$sample['23'],$sample['24'],$sample['25'],$sample['26']);
         unset($sample['27'],$sample['28'],$sample['29'],$sample['30'],$sample['31'],$sample['32'],$sample['33'],$sample['34']);
         unset($sample['35'],$sample['36'],$sample['37'],$sample['38'],$sample['39'],$sample['40'],$sample['41']);//最後の改行も削除

         if($k>=2 && !empty($sample['product_code'])){
             $arrSyoyouKeikaku[] = $sample;//配列に追加する
             $this->SyoyouKeikakus->deleteAll(['product_code' => $sample['product_code']]);//格納した品番の所要計画データは一旦削除
             if(substr($sample['product_code'],0,1) == "P"){
               $countP = $countP + 1;
             }elseif(substr($sample['product_code'],0,1) == "w"){
               $countW = $countW + 1;
             }elseif(substr($sample['product_code'],0,1) == "R"){
               $countR = $countR + 1;
             }else{
               $countP = $countP;
               $countW = $countW;
               $countR = $countR;
             }
          }
      }

      if($countP >= 10){//この場合、customer_id=1（customer_code=10001）パナソニック(株)HA社キッチンアプライアンス（事）草津工場の製品をSyoyouKeikakusテーブルから削除
        $Products_P = $this->Products->find()->where(['customer_id' => '1']);
        foreach ($Products_P as $value) {
          $product_code= $value->product_code;
          $this->SyoyouKeikakus->deleteAll(['product_code' => $product_code]);
        }
      }

      if($countW >= 5){//customer_id=2（customer_code=10002）パナソニック(株)HA社ランドリークリーナー（事）静岡工場の製品をSyoyouKeikakusテーブルから削除
        $Products_W = $this->Products->find()->where(['customer_id' => '2']);
        foreach ($Products_W as $value) {
          $product_code= $value->product_code;
          $this->SyoyouKeikakus->deleteAll(['product_code' => $product_code]);
        }
      }

      if($countR >= 5){//customer_id=3（customer_code=10003）パナソニック(株)HA社キッチンアプライアンス（事）加東工場の製品をSyoyouKeikakusテーブルから削除
        $Products_R = $this->Products->find()->where(['customer_id' => '3']);
        foreach ($Products_R as $value) {
          $product_code= $value->product_code;
          $this->SyoyouKeikakus->deleteAll(['product_code' => $product_code]);
        }
      }
/*
      echo "<pre>";
      print_r($arrSyoyouKeikaku);
      echo "</pre>";
*/
       if ($this->request->is('get')) {
         $syoyouKeikakus = $this->SyoyouKeikakus->patchEntities($syoyouKeikakus, $arrSyoyouKeikaku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
             if ($this->SyoyouKeikakus->saveMany($syoyouKeikakus)) {//saveManyで一括登録
               $mes = "※登録されました";
               $this->set('mes',$mes);
    //           file_put_contents("EDI/$file", mb_convert_encoding(file_get_contents("EDI/$file"), 'SJIS', 'UTF-8'));
            //    file_put_contents("/home/centosuser/EDI/$file", mb_convert_encoding(file_get_contents("/home/centosuser/EDI/$file"), 'SJIS', 'UTF-8'));
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

    public function henkou1top()
    {
      $this->request->session()->destroy();// セッションの破棄
    }

    public function henkou1sentaku()
    {
      $this->request->session()->destroy();// セッションの破棄
    }

    public function henkou2pana()
    {
      $this->request->session()->destroy();// セッションの破棄
    }

    public function henkou3pana()
    {
      $this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
/*
      $Data=$this->request->query();
      echo "<pre>";
      print_r($Data);
      echo "</pre>";
*/
    }

    public function henkou4pana()
    {
      $this->request->session()->destroy();//セッションの破棄
      $data = $this->request->getData();
      $Data=$this->request->query('s');//1度henkou5panaへ行って戻ってきたとき（検索を押したとき）
      if(isset($Data)){
        $product_code = $Data['product_code'];
        $date_sta = $Data['date_sta'];
        $date_fin = $Data['date_fin'];
        $Pro = $Data['Pro'];
      }else{
        $product_code = $data['product_code'];
        $date_sta = $data['date_sta'];
        $date_fin = $data['date_fin'];
        $Pro = $data['Pro'];
      }
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      if($Pro == "W"){//Wのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => '%'.$Pro.'%']
            ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => '%'.$Pro.'%']
            ));//対象の製品を絞り込む
        }
      }else{//P,H,Rのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
    //      ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => $Pro.'%']
          ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => "M".'%']//DNP実験
          //role_code順に並べる
          ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }
/*
      echo "<pre>";
      print_r($Data);
      echo "</pre>";
*/
    }

    public function henkou5pana()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){
        return $this->redirect(['action' => 'henkou4pana',
        's' => ['product_code' => $data['product_code'],'Pro' => $data['Pro'],'date_sta' => $data['date_sta'],'date_fin' => $data['date_fin']]]);
      }

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
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

        if($checknum > 1){
          $meschecknum = "※複数行の選択がありました。先頭の行のみ表示しています。";
          $this->set('meschecknum',$meschecknum);
        }else{
          $meschecknum = " ";
          $this->set('meschecknum',$meschecknum);
        }

        for ($i=0; $i<=$data["nummax"]; $i++){
          if(isset($array[$i])){//checkがついているもののidと同じidのデータを取り出す
            ${"orderEdis".$i} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $array[$i]])->toArray();
            $this->set('orderEdis'.$i,${"orderEdis".$i});
            $i_num = $i;
            $this->set('i_num',$i_num);
          }else{
            break;
          }
        }

        $bunnou_num = 1;
        $Totalamount = 0;
        $this->set('bunnou_num',$bunnou_num);
        $num_order0 = $orderEdis0[0]->num_order;
        $product_code0 = $orderEdis0[0]->product_code;
        $orderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0','num_order' => $num_order0,'product_code' => $product_code0])->toArray();
        for($n=0; $n<=100; $n++){
          if(isset($orderEdis[$n])){
            ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $orderEdis[$n]->id])->toArray();
            $this->set('orderEdis'.$n,${"orderEdis".$n});

            ${"id".$n} = ${"orderEdis".$n}[0]->id;
            $this->set('id'.$n,${"id".$n});

            ${"date_deliver".$n} = ${"orderEdis".$n}[0]->date_deliver->format('Y-m-d');
            $this->set('date_deliver'.$n,${"date_deliver".$n});

            ${"amount".$n} = ${"orderEdis".$n}[0]->amount;
            $this->set('amount'.$n,${"amount".$n});

            $bunnou_num = $n+1;
            $this->set('bunnou_num',$bunnou_num);
          }else{
            break;
          }
        }
      }
    }

    public function henkou5panabunnou()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $orderEdis0 = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $data['orderEdis_0']])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
      $num_order0 = $orderEdis0[0]->num_order;
      $product_code0 = $orderEdis0[0]->product_code;
      $orderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0','num_order' => $num_order0,'product_code' => $product_code0])->toArray();
      for($n=0; $n<=100; $n++){
        if(isset($orderEdis[$n])){
          $num = $n;
          $this->set('num',$num);//既に分納している場合１以上になる
        }else{
          break;
        }
      }

      for($n=0; $n<=100; $n++){
        if(isset($orderEdis[$n])){
  //      if(isset($orderEdis[$n])){
          ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $data["orderEdis_{$n}"]])->toArray();
          $this->set('orderEdis'.$n,${"orderEdis".$n});
        }else{
          break;
        }
      }

//      $orderEdis0 = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $data['orderEdis_0']])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
//      $i = 0;
//      $this->set('orderEdis'.$i,${"orderEdis".$i});

        if(isset($data['tsuika'])){
          $tsuikanum = $data['tsuikanum'] + 1;
          $this->set('tsuikanum',$tsuikanum);
        }elseif(isset($data['sakujo'])){
          $tsuikanum = $data['tsuikanum'] - 1;
          $this->set('tsuikanum',$tsuikanum);
        }


    }

    public function henkou6pana()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
    }

    public function henkoupanapreadd()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkoupanalogin()
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
            return $this->redirect(['action' => 'henkoupanado']);
          }
        }
    }

    public function henkoupanado()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data['orderEdis']);//配列（更新するカラム）の個数
      /*
      echo "<pre>";
      print_r($cnt);
      print_r($data['orderEdis']);
      echo "</pre>";
      /*
      for($n=0; $n<=$cnt; $n++){
        if(isset($data['orderEdis'][$n])){
          $this->OrderEdis->updateAll(
          ['date_deliver' => $data['orderEdis'][$n]['date_deliver'] ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],//この方法だとupdated_atは自動更新されない
          ['id'   => $data['orderEdis'][$n]['id'] ]
          );
        }else{
          break;
        }
      }
*/
      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        for($n=0; $n<=$cnt; $n++){
         if(isset($data['orderEdis'][$n])){
          if ($this->OrderEdis->updateAll(['date_deliver' => $data['orderEdis'][$n]['date_deliver'] ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],['id' => $data['orderEdis'][$n]['id']])) {
          }else{
            $mes = "※更新されませんでした";
            $this->set('mes',$mes);
            $this->Flash->error(__('The data could not be saved. Please, try again.'));
            throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            break;
          }
         }else{
           $mes = "※更新されました";
           $this->set('mes',$mes);
           $connection->commit();// コミット5
           break;
         }
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10
    }

    public function henkoupanabunnnoupreadd()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $session = $this->request->getSession();
      $data = $session->read();
/*
      echo "<pre>";
      print_r($_SESSION['orderEdis']);
      echo "</pre>";
*/
    }

    public function henkoupanabunnnoulogin()
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
            return $this->redirect(['action' => 'henkoupanabunnnoudo']);
          }
        }
    }

    public function henkoupanabunnnoudo()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data);//配列（更新するカラム）の個数
      $p = 0;

//      $updated_staff = array('updated_staff'=>$this->Auth->user('staff_id'));
//      $_SESSION['orderEdis'][0] = array_merge($_SESSION['orderEdis'][0],$updated_staff);
      for($n=0; $n<=count($_SESSION['orderEdis'])+1; $n++){
        if(isset($_SESSION['orderEdis'][$n])){
  //        $bunnou = array('bunnou'=>$n+1);
    //      $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$bunnou);
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$created_staff);
          $arrOrderEdis[] = $_SESSION['orderEdis'][$n];
        }else{
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['minoukannou'] = array_merge($_SESSION['minoukannou'],$created_staff);
          break;
        }
      }
/*
      echo "<pre>";
      print_r($_SESSION['orderEdis']);
      echo "</pre>";
       echo "<pre>";
      print_r($data);
      echo "</pre>";
      */

//orderEdisを分納するときidがすでにあれば更新、なければ新規登録ok
//amount=0 or 1 で場合分け（amount=0ならdelete_flag=1にする）ok
//mikanのテーブルも更新（date_deliverが一番遅いやつのminoukannouの更新）

      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        $arrOrderEdisnew = array();
        $arrBunnnou = array();
        $arrDenpyouDnpMinoukannousnew = array();
        $bunnnou = 0;
        for($n=0; $n<=count($_SESSION['orderEdis'])+100; $n++){
          if(isset($_SESSION['orderEdis'][$n]['id']) && ($_SESSION['orderEdis'][$n]['amount'] > 0)){//amount>0の時
            $bunnnou = $bunnnou +1;
            if ($this->OrderEdis->updateAll(['date_deliver' => $_SESSION['orderEdis'][$n]['date_deliver'] ,'amount' => $_SESSION['orderEdis'][$n]['amount']
            ,'bunnou' => $bunnnou ,'date_bunnou' => date('Y-m-d') ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
            ,['id' => $_SESSION['orderEdis'][$n]['id']])) {
              $mes = "※更新されました";
              $this->set('mes',$mes);
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }elseif(isset($_SESSION['orderEdis'][$n]['id'])){//amount=0 or nullの時//minoukannouテーブルも更新
            if ($this->OrderEdis->updateAll(['date_deliver' => $_SESSION['orderEdis'][$n]['date_deliver'] ,'amount' => 0
            ,'bunnou' => 0 ,'date_bunnou' => date('Y-m-d') ,'delete_flag' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
            ,['id' => $_SESSION['orderEdis'][$n]['id']])) {

              $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $_SESSION['orderEdis'][$n]['id']])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
              $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
              $this->DenpyouDnpMinoukannous->updateAll(['delete_flag' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
              ,['id' => $denpyouDnpMinoukannouId]);

              $mes = "※更新されました";
              $this->set('mes',$mes);
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }elseif(isset($_SESSION['orderEdis'][$n])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $bunnnou = $bunnnou +1;
            $bunnou = array('bunnou'=>$bunnnou);
            $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$bunnou);
            $arrOrderEdisnew[] = $_SESSION['orderEdis'][$n];
            $arrDenpyouDnpMinoukannousnew[] = $_SESSION['minoukannou'];
            $arrBunnnou[] = $bunnnou;
            $num_order = $_SESSION['orderEdis'][$n]['num_order'];
            $product_code = $_SESSION['orderEdis'][$n]['product_code'];
            $line_code = $_SESSION['orderEdis'][$n]['line_code'];
          }elseif(isset($arrOrderEdisnew[0])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $arrOrderEdisnew);
            if ($this->OrderEdis->saveMany($OrderEdis)) {//minoukannouテーブルにも保存するかつ、同じやつを引っ張り出してdate_deliverが一番遅いやつのminoukannouだけ1にする
              for($m=0; $m<=100; $m++){
                if(isset($arrBunnnou[$m])){
                  $orderEdi = $this->OrderEdis->find()->where(['delete_flag' => '0', 'num_order' => $num_order, 'product_code' => $product_code, 'bunnou' => $arrBunnnou[$m]])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
                  $orderEdiId = $orderEdi[0]->id;
                  $arrorderEdiId = array('order_edi_id'=>$orderEdiId);
                  $arrDenpyouDnpMinoukannousnew[$m] = array_merge($arrDenpyouDnpMinoukannousnew[$m],$arrorderEdiId);
                }else{
/*
                  echo "<pre>";
                  print_r($arrDenpyouDnpMinoukannousnew);
                  echo "</pre>";
*/
                  $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntities($this->DenpyouDnpMinoukannous->newEntity(), $arrDenpyouDnpMinoukannousnew);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                  $this->DenpyouDnpMinoukannous->saveMany($denpyouDnpMinoukannous);//saveManyで一括登録

                  //minoukannouテーブルにも保存するかつ、同じやつを引っ張り出してdate_deliverが一番遅いやつのminoukannouだけ1にする
                  $orderedi_id = $_SESSION['orderEdis'][0]['id'];
                  $orderEdi = $this->OrderEdis->find()->where(['id' => $orderedi_id])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
                  $num_order = $orderEdi[0]['num_order'];
                  $product_code = $orderEdi[0]['product_code'];
                  $line_code = $orderEdi[0]['line_code'];
                  $arrDnpdouitutyuumon = array();//空の配列を作る
                  $arrDnpdouitutyuumonSort = array();//空の配列を作る

                  $orderEdidouitu = $this->OrderEdis->find()->where(['delete_flag' => '0', 'num_order' => $num_order, 'product_code' => $product_code, 'line_code' => $line_code])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
                  for($m=0; $m<=100; $m++){//orderedisテーブルから同一注文のid,date_deliverを取出し配列に追加
                    if(isset($orderEdidouitu[$m])){
                      $date_deliver = $orderEdidouitu[$m]['date_deliver'];
                      $arrDnpdouitutyuumon[$m]['id'] = $orderEdidouitu[$m]['id'];
                      $arrDnpdouitutyuumon[$m]['date_deliver'] = $date_deliver->format('Y-m-d');
                    }else{
                      break;
                    }
                  }

                  foreach ($arrDnpdouitutyuumon as $key => $value) {
                      $sort[$key] = $value['date_deliver'];
                  }
                  array_multisort( array_map( "strtotime", array_column( $arrDnpdouitutyuumon, "date_deliver" ) ), SORT_ASC, $arrDnpdouitutyuumon ) ;//時間で並び替え
                  $arrDnpdouitutyuumonSort[] = $arrDnpdouitutyuumon;

                  for($m=0; $m<count($arrDnpdouitutyuumonSort[0]); $m++){
                    if($m< (count($arrDnpdouitutyuumonSort[0])-1) ){
                      $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $arrDnpdouitutyuumonSort[0][$m]['id']])->toArray();
                      $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
                      $this->DenpyouDnpMinoukannous->updateAll(['minoukannou' => 0 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
                      ,['id' => $denpyouDnpMinoukannouId]);
                    }else{
                      $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $arrDnpdouitutyuumonSort[0][$m]['id']])->toArray();
                      $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
                      $this->DenpyouDnpMinoukannous->updateAll(['minoukannou' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
                      ,['id' => $denpyouDnpMinoukannouId]);
                    }
                  }
                  break;
                }
              }

              $mes = "※更新されました";
              $this->set('mes',$mes);
              $connection->commit();// コミット5
              break;
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              break;
            }
          }else{//分納追加はせずに納期や数量を変更した場合//minoukannouテーブルのdate_deliverが一番遅いやつのminoukannouだけ1にする

            //minoukannouテーブルにも保存するかつ、同じやつを引っ張り出してdate_deliverが一番遅いやつのminoukannouだけ1にする
            $orderedi_id = $_SESSION['orderEdis'][0]['id'];
            $orderEdi = $this->OrderEdis->find()->where(['id' => $orderedi_id])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
            $num_order = $orderEdi[0]['num_order'];
            $product_code = $orderEdi[0]['product_code'];
            $line_code = $orderEdi[0]['line_code'];
            $arrDnpdouitutyuumon = array();//空の配列を作る
            $arrDnpdouitutyuumonSort = array();//空の配列を作る

            $orderEdidouitu = $this->OrderEdis->find()->where(['delete_flag' => '0', 'num_order' => $num_order, 'product_code' => $product_code, 'line_code' => $line_code])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
            for($m=0; $m<=100; $m++){//orderedisテーブルから同一注文のid,date_deliverを取出し配列に追加
              if(isset($orderEdidouitu[$m])){
                $date_deliver = $orderEdidouitu[$m]['date_deliver'];
                $arrDnpdouitutyuumon[$m]['id'] = $orderEdidouitu[$m]['id'];
                $arrDnpdouitutyuumon[$m]['date_deliver'] = $date_deliver->format('Y-m-d');
              }else{
                break;
              }
            }

            foreach ($arrDnpdouitutyuumon as $key => $value) {
                $sort[$key] = $value['date_deliver'];
            }
            array_multisort( array_map( "strtotime", array_column( $arrDnpdouitutyuumon, "date_deliver" ) ), SORT_ASC, $arrDnpdouitutyuumon ) ;//時間で並び替え
            $arrDnpdouitutyuumonSort[] = $arrDnpdouitutyuumon;
/*
            echo "<pre>";
            print_r($arrDnpdouitutyuumonSort);
            echo "</pre>";
*/
            for($m=0; $m<count($arrDnpdouitutyuumonSort[0]); $m++){
              if($m< (count($arrDnpdouitutyuumonSort[0])-1) ){
                $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $arrDnpdouitutyuumonSort[0][$m]['id']])->toArray();
                $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
                $this->DenpyouDnpMinoukannous->updateAll(['minoukannou' => 0 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
                ,['id' => $denpyouDnpMinoukannouId]);
              }else{
                $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $arrDnpdouitutyuumonSort[0][$m]['id']])->toArray();
                $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
                $this->DenpyouDnpMinoukannous->updateAll(['minoukannou' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
                ,['id' => $denpyouDnpMinoukannouId]);
              }
            }
            $connection->commit();// コミット5
            break;
          }
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10
    }

}
