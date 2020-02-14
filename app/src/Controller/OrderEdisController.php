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
      $denpyouDnps = $this->DenpyouDnps->newEntity();
      $this->set('denpyouDnps',$denpyouDnps);
      $orderDnpKannous = $this->OrderDnpKannous->newEntity();
      $this->set('orderDnpKannous',$orderDnpKannous);

      $source_file = $_FILES['file']['tmp_name'];
      file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));
      $fp1 = fopen($source_file, 'r');
      $fp2 = fopen($source_file, 'r');
      $fp3 = fopen($source_file, 'r');
      $fpcount = fopen($source_file, 'r' );

      for($count = 0; fgets( $fpcount ); $count++ );
      $arrEDI = array();//空の配列を作る
      $arrDenpyou = array();//空の配列を作る
      $arrKannou = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');

      $num = 1;

        for ($k=1; $k<=$count-1; $k++) {//最後の行まで
          $line = fgets($fp1);//ファイル$fpの上の１行を取る（２行目から）
          $sample = explode(',',$line);//$lineを','毎に配列に入れる

           $keys=array_keys($sample);
           $keys[array_search('2',$keys)]='num_order';//名前の変更
           $keys[array_search('3',$keys)]='name_order';
  //         $keys[array_search('4',$keys)]='code';
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

      echo "<pre>";
      print_r("arrEDI");
      print_r($arrEDI);
      echo "</pre>";

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
               $keys[array_search('15',$keys)]='place_deliver';
               $sample = array_combine( $keys, $sample );

               unset($sample['0'],$sample['1'],$sample['5'],$sample['6'],$sample['8'],$sample['10']);
               unset($sample['11'],$sample['12'],$sample['13'],$sample['14'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

               if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき
                 $arrDenpyou[] = $sample;//配列に追加する
               }
            }

            for($n=0; $n<=10000; $n++){
              if(isset($arrDenpyou[$n])){
                $arrDenpyou[$n] = array_merge($arrDenpyou[$n],array('conf_print'=>0));
                $arrDenpyou[$n] = array_merge($arrDenpyou[$n],array('delete_flag'=>0));
                $arrDenpyou[$n] = array_merge($arrDenpyou[$n],array('created_staff'=>$created_staff));
              }else{
                break;
              }
            }

            echo "<pre>";
            print_r("arrDenpyou");
            print_r($arrDenpyou);
            echo "</pre>";

            $denpyouDnps = $this->DenpyouDnps->patchEntities($denpyouDnps, $arrDenpyou);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
            if ($this->DenpyouDnps->saveMany($denpyouDnps)) {//saveManyで一括登録

              for ($k=1; $k<=$count-1; $k++) {//最後の行まで
                $line = fgets($fp3);//ファイル$fpの上の１行を取る（２行目から）
                $sample = explode(',',$line);//$lineを','毎に配列に入れる

                 $keys=array_keys($sample);
                 $keys[array_search('2',$keys)]='num_order';//名前の変更
                 $keys[array_search('4',$keys)]='code';
                 $keys[array_search('7',$keys)]='product_code';
                 $keys[array_search('9',$keys)]='date_order';
                 $keys[array_search('10',$keys)]='amount';
                 $keys[array_search('13',$keys)]='date_deliver';
                 $sample = array_combine( $keys, $sample );

                 unset($sample['0'],$sample['1'],$sample['3'],$sample['5'],$sample['6'],$sample['8']);
                 unset($sample['11'],$sample['12'],$sample['14'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

                 if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき
                   $arrKannou[] = $sample;//配列に追加する
                 }
              }

              for($n=0; $n<=10000; $n++){
                if(isset($arrKannou[$n])){
                  $arrKannou[$n] = array_merge($arrKannou[$n],array('bunnou'=>0));
                  $arrKannou[$n] = array_merge($arrKannou[$n],array('delete_flag'=>0));
                  $arrKannou[$n] = array_merge($arrKannou[$n],array('created_staff'=>$created_staff));
                }else{
                  break;
                }
              }
              //$arrKannouの、date_order、num_order、product_code、codeが同じものを集めてdate_deliverの一番遅いもののminoukannouを1にする
              for($n=0; $n<=10000; $n++){
                if(isset($arrKannou[$n])){
                  $num_order = $arrKannou[$n]['num_order'];
                  $code = $arrKannou[$n]['code'];
                  $product_code = $arrKannou[$n]['product_code'];
                  $date_order = $arrKannou[$n]['date_order'];
                  ${"kannnou".$n} = $num_order.$code.$product_code.$date_order;
                  echo "<pre>";
                  print_r(${"kannnou".$n});
                  echo "</pre>";
                    for($m=0; $m<=$n; $m++){
                      if((${"kannnou".$n} == ${"kannnou".$m})){//$num_order.$code.$product_code.$date_orderが同じとき
                        if($arrKannou[$n]['date_deliver'] > $arrKannou[$m]['date_deliver']){//この場合$arrKannou[$m]は未納（'minoukannou'=>0）
                          $arrKannou[$m] = array_merge($arrKannou[$m],array('minoukannou'=>0));
                        }else{//この場合$arrKannou[$m]は完納（'minoukannou'=>1）
                          $arrKannou[$m] = array_merge($arrKannou[$m],array('minoukannou'=>1));
                        }
                      }else{
                      }
                    }
                }else{
                  break;
                }
              }

              echo "<pre>";
              print_r("arrKannou");
              print_r($arrKannou);
              echo "</pre>";

               $orderDnpKannous = $this->OrderDnpKannous->patchEntities($orderDnpKannous, $arrKannou);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                   if ($this->OrderDnpKannous->saveMany($orderDnpKannous)) {//saveManyで一括登録
                     $mes = "※登録されました";
                     $this->set('mes',$mes);
                   } else {
                     $mes = "※登録されませんでした";
                     $this->set('mes',$mes);
                     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
                     $this->Flash->error(__('The orderDnpKannous could not be saved. Please, try again.'));
                     throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                   }
              } else {
                $mes = "※登録されませんでした";
                $this->set('mes',$mes);
                file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
                $this->Flash->error(__('This denpyouDnps could not be saved. Please, try again.'));
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
    }

    public function henkou4pana()
    {
      $this->request->session()->destroy();//セッションの破棄
      $data = $this->request->getData();
      $product_code = $data['product_code'];
      $date_sta = $data['date_sta'];
      $date_fin = $data['date_fin'];
      if(empty($data['product_code'])){//product_codeの入力がないとき
        $product_code = "no";
        $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin]));
      }else{//product_codeの入力があるとき
        $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code]));
      }
    }

    public function henkou5pana()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $array = array();
      if(isset($data["nummax"])){
        for ($k=2; $k<=$data["nummax"]; $k++){
          if(isset($data["check".$k])){
            $array[] = $data["$k"];
          }else{
          }
        }
/*      echo "<pre>";
      print_r($array);
      echo "</pre>";
*/
        for ($i=0; $i<=$data["nummax"]; $i++){
          if(isset($array[$i])){
            $this->set('orderEdis'.$i,$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
              ->where(['id' => $array[$i]]));
            $i_num = $i;
            $this->set('i_num',$i_num);
          }else{
            break;
          }
        }
      }

/*      echo "<pre>";
      print_r($i_num);
      echo "</pre>";
*/
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
      $i = 0;
      $this->set('orderEdis'.$i,$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
        ->where(['id' => $data['orderEdis_0']]));

        if(isset($data['tsuika'])){
          $tsuikanum = $data['tsuikanum'] + 1;
          $this->set('tsuikanum',$tsuikanum);
/*          echo "<pre>";
          print_r("tsuika");
          echo "</pre>";
          echo "<pre>";
          print_r($tsuikanum);
          echo "</pre>";
*/
        }elseif(isset($data['sakujo'])){
          $tsuikanum = $data['tsuikanum'] - 1;
          $this->set('tsuikanum',$tsuikanum);
/*          echo "<pre>";
          print_r("sakujo");
          echo "</pre>";
          echo "<pre>";
          print_r($tsuikanum);
          echo "</pre>";
*/
        }


    }

    public function henkou6pana()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();

      echo "<pre>";
      print_r($data);
      echo "</pre>";

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
      $cnt = count($data);//配列（更新するカラム）の個数
/*
      echo "<pre>";
      print_r($cnt);
      print_r($data['orderEdis'][0]['id']);
      echo "</pre>";

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

      $updated_staff = array('updated_staff'=>$this->Auth->user('staff_id'));
      $_SESSION['orderEdis'][0] = array_merge($_SESSION['orderEdis'][0],$updated_staff);
      for($n=1; $n<=count($_SESSION['orderEdis']); $n++){
        if(isset($_SESSION['orderEdis'][$n])){
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$created_staff);
          $arrOrderEdis[] = $_SESSION['orderEdis'][$n];
        }else{
          break;
        }
      }
/*
      echo "<pre>";
      print_r($_SESSION['orderEdis'][0]);
      echo "</pre>";
      echo "<pre>";
      print_r($arrOrderEdis);
      echo "</pre>";
*/

      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
         if(isset($_SESSION['orderEdis'][0])){
          if ($this->OrderEdis->updateAll(['date_deliver' => $_SESSION['orderEdis'][0]['date_deliver'] ,'amount' => $_SESSION['orderEdis'][0]['amount'] ,'bunnou' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],['id' => $_SESSION['orderEdis'][0]['id']])) {
            $OrderEdis = $this->OrderEdis->patchEntities($OrderEdis, $arrOrderEdis);
            if ($this->OrderEdis->saveMany($OrderEdis)) {
              $mes = "※更新されました";
              $this->set('mes',$mes);
              $connection->commit();// コミット5
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }
         }else{
           $mes = "※更新されませんでした";
           $this->set('mes',$mes);
           $connection->commit();// コミット5
         }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10

    }

}
