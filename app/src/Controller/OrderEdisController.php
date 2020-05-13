<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
/*
$htmllogin = new htmlLogin();
$htmllogin = $htmllogin->htmllogin();
*/
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
       $this->PlaceDelivers = TableRegistry::get('placeDelivers');
       $this->AssembleProducts = TableRegistry::get('assembleProducts');
       $this->ProductGaityu = TableRegistry::get('productGaityu');
       $this->KariOrderToSuppliers = TableRegistry::get('kariOrderToSuppliers');
       $this->OrderToSupplier = TableRegistry::get('orderToSupplier');
       $this->AttachOrderToSupplier = TableRegistry::get('attachOrderToSupplier');
     }

     public function indexmenu()
     {
       $this->request->session()->destroy();// セッションの破棄
     }

     public function hattyucsv()//発注CSV
     {
       $orderEdis = $this->OrderEdis->newEntity();
       $this->set('orderEdis',$orderEdis);

       if ($this->request->is('post')) {
       $source_file = $_FILES['file']['tmp_name'];//ファイルを選択、そのファイルが一時的に作られる（$source_fileと名付ける）
//文字変換（不要）     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));
       $fp = fopen($source_file, 'r');//ファイルを開き、$fpと名付ける
       $fpcount = fopen($source_file, 'r' );//ファイルを開き、$fpcountと名付ける

        for($count = 0; fgets( $fpcount ); $count++ );//$fpcountの行数を数え、$countと名付ける
        $arrFp = array();//空の配列を作る
        $created_staff = $this->Auth->user('staff_id');
        for ($k=1; $k<=$count-1; $k++) {//最後の行まで
          $line = fgets($fp);//ファイル$fpの上の１行（カラム名が並んでいるため）を取る（２行目から読み込み開始）
          $sample = explode(',',$line);//$lineを','毎に配列に入れる

           $keys=array_keys($sample);
           $keys[array_search('3',$keys)]='place_deliver_code';//名前の変更（3➝place_deliver_code）
           $keys[array_search('10',$keys)]='date_order';
           $keys[array_search('12',$keys)]='price';
           $keys[array_search('14',$keys)]='amount';
           $keys[array_search('23',$keys)]='product_code';
           $keys[array_search('27',$keys)]='line_code';
           $keys[array_search('30',$keys)]='date_deliver';
           $keys[array_search('32',$keys)]='num_order';
           $keys[array_search('50',$keys)]='place_line';
           $sample = array_combine( $keys, $sample );//配列を作成

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
           unset($sample['128'],$sample['129']);//不要な行を削除、最後の改行も削除（改行が読み込まれるとエラーが出るため）

           if($k>=2){
             $arrFp[] = $sample;//$sampleを配列に追加する
           }
        }

        for($n=0; $n<=10000; $n++){
          if(isset($arrFp[$n])){//$arrFp[$n]が存在する時、対応するcustomer_code等を配列に追加する
            $Product = $this->Products->find()->where(['product_code' => $arrFp[$n]['product_code']])->toArray();
            if(isset($Product[0])){
              $customer_id = $Product[0]->customer_id;
            }else{
              echo "<pre>";
              print_r($arrFp[$n]['product_code']."が登録されていません");
              echo "</pre>";
            }
    				$customer_id = $Product[0]->customer_id;
            $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
    				$customer_code = $Customer[0]->customer_code;
            $arrFp[$n] = array_merge($arrFp[$n],array('customer_code'=>$customer_code));

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
       echo "</pre>";
*/
           $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrFp);//patchEntitiesで一括登録
           $connection = ConnectionManager::get('default');//トランザクション1
           // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
               if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録

                 for($k=0; $k<count($arrFp); $k++){//組み立て品登録
                   $AssembleProduct = $this->AssembleProducts->find()->where(['product_id' => $arrFp[$k]['product_code']])->toArray();
                   if(count($AssembleProduct) > 0){
                     for($n=0; $n<count($AssembleProduct); $n++){
                       $child_pid = $AssembleProduct[$n]->child_pid;
                       $_SESSION['order_edi_kumitate'][$n] = array(
                         'place_deliver_code' => "00000",
                         'date_order' => $arrFp[$k]["date_order"],
                         'price' => 0,
                         'amount' => $arrFp[$k]["amount"],
                         'product_code' => $child_pid,
                         'line_code' => $arrFp[$k]["line_code"],
                         'date_deliver' => $arrFp[$k]["date_deliver"],
                         'num_order' => $arrFp[$k]["num_order"],
              //           'first_date_deliver' => $data['order_edi']["first_date_deliver"],
                         'customer_code' => $arrFp[$k]["customer_code"],
                         'place_line' => $arrFp[$k]["place_line"],
                         'check_denpyou' => 0,
                         'bunnou' => $arrFp[$k]["bunnou"],
                         'kannou' => $arrFp[$k]["kannou"],
                         'delete_flag' => 0,
                         'created_staff' => $this->Auth->user('staff_id')
                       );
                     }
                     $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $_SESSION['order_edi_kumitate']);
                     $this->OrderEdis->saveMany($orderEdis);
                  }
               }

                 $mes = "※登録されました";
                 $this->set('mes',$mes);
                 $connection->commit();// コミット5

                 //insert into order_ediする
                 $connection = ConnectionManager::get('DB_ikou_test');
                 $table = TableRegistry::get('order_edi');
                 $table->setConnection($connection);
/*
                 echo "<pre>";
                 print_r($arrFp);
                 echo "</pre>";
*/
                 for($k=0; $k<count($arrFp); $k++){
                   $connection->insert('order_edi', [
                       'date_order' => $arrFp[$k]["date_order"],
                       'num_order' => $arrFp[$k]["num_order"],
                       'product_id' => $arrFp[$k]["product_code"],
                       'price' => $arrFp[$k]["price"],
                       'date_deliver' => $arrFp[$k]["date_deliver"],
                    //   'first_date_deliver' => $arrFp[$k]["first_date_deliver"],
                       'amount' => $arrFp[$k]["amount"],
                       'cs_id' => $arrFp[$k]["customer_code"],
                       'place_deliver_id' => $arrFp[$k]["place_deliver_code"],
                       'place_line' => $arrFp[$k]["place_line"],
                       'line_code' => $arrFp[$k]["line_code"],
                       'check_denpyou' => $arrFp[$k]["check_denpyou"],
                    //   'gaityu' => $arrFp[$k]["gaityu"],
                       'bunnou' => $arrFp[$k]["bunnou"],
                       'kannou' => $arrFp[$k]["kannou"],
                    //   'date_bunnou' => $arrFp[$k]["date_bunnou"],
                    //   'check_kannou' => $arrFp[$k]["check_kannou"],
                       'delete_flg' => $arrFp[$k]["delete_flag"],
                       'created_at' => date("Y-m-d H:i:s")
                   ]);
                 }


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

     public function hattyucsvpreadd()
 		{
      session_start();//セッションの開始
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
 		}

 		public function hattyucsvlogin()
 		{
 			if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();//クラスを使用
        $arraylogindate = $htmllogin->htmllogin($userdata);//クラスを使用（$userdataを持っていき、$arraylogindateを持って帰る）

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

 					if ($user) {
 						$this->Auth->setUser($user);
            return $this->redirect(['action' => 'hattyucsv']);//hattyucsvへ移動
 					}
 				}
 		}

    public function dnpcsvpreadd()
    {
     session_start();
     $orderEdis = $this->OrderEdis->newEntity();
     $this->set('orderEdis',$orderEdis);
     $data = $this->request->getData();
    }

    public function dnpcsvlogin()
    {
       if ($this->request->is('post')) {
         $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
         $this->set('data',$data);//セット
         $userdata = $data['username'];
         $this->set('userdata',$userdata);//セット

         $htmllogin = new htmlLogin();
         $arraylogindate = $htmllogin->htmllogin($userdata);

         $username = $arraylogindate[0];
         $delete_flag = $arraylogindate[1];
         $this->set('username',$username);
         $this->set('delete_flag',$delete_flag);

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
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->newEntity();
      $this->set('denpyouDnpMinoukannous',$denpyouDnpMinoukannous);
      $dnpTotalAmounts = $this->DnpTotalAmounts->newEntity();
      $this->set('dnpTotalAmounts',$dnpTotalAmounts);

      $source_file = $_FILES['file']['tmp_name'];
      file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));//SJISのファイルをUTF-8に変換する
      $fpmoto = fopen($source_file, 'r');//motoDBへ登録用
      $fp1 = fopen($source_file, 'r');//OrderEdisへ登録用
      $fp2 = fopen($source_file, 'r');//DenpyouDnpMinoukannousへ登録用
      $fp3 = fopen($source_file, 'r');//DnpTotalAmountsへ登録用
      $fpcount = fopen($source_file, 'r' );

//ここからmotoDBへ登録用
      for($count = 0; fgets( $fpcount ); $count++ );
      $arrEDImotodenpyoudnp = array();//空の配列を作る
      $arrDenpyouDnpMinoukannous = array();//空の配列を作る
      $arrDnpTotalAmounts = array();//空の配列を作る
      $arrDnpdouitutyuumon = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');

        for ($k=1; $k<=$count-1; $k++) {//最後の行まで
          $line = fgets($fpmoto);//ファイル$fpの上の１行を取る（２行目から）
          $sample = explode(',',$line);//$lineを','毎に配列に入れる

           $keys=array_keys($sample);
           $keys[array_search('2',$keys)]='num_order';//名前の変更
           $keys[array_search('3',$keys)]='name_order';
           $keys[array_search('4',$keys)]='line_code';
           $keys[array_search('7',$keys)]='product_code';
           $keys[array_search('15',$keys)]='place_deliver';
           $sample = array_combine( $keys, $sample );

           unset($sample['0'],$sample['1'],$sample['4'],$sample['5'],$sample['6'],$sample['8']);
           unset($sample['9'],$sample['10'],$sample['11'],$sample['13'],$sample['14']);
           unset($sample['12'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

           if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき（カンマのみの行が出てきたら配列への追加を終了）
             $arrEDImotodenpyoudnp[] = $sample;//配列に追加する
           }
        }

        for($n=0; $n<=10000; $n++){
          if(isset($arrEDImotodenpyoudnp[$n])){//$arrEDImotodenpyoudnp[$n]が存在する時、対応するcustomer_code等を配列に追加する
            $Product = $this->Products->find()->where(['product_code' => $arrEDImotodenpyoudnp[$n]['product_code']])->toArray();
    				$customer_id = $Product[0]->customer_id;
            $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
    				$customer_code = $Customer[0]->customer_code;

            $arrEDImotodenpyoudnp[$n] = array_merge($arrEDImotodenpyoudnp[$n],array('customer_code'=>$customer_code));
          }else{
            break;
          }
        }
//ここまでmotoDBへ登録用
/*
echo "<pre>";
print_r("arrEDImotodenpyoudnp");
print_r($arrEDImotodenpyoudnp);
echo "</pre>";
*/
  //    for($count = 0; fgets( $fpcount ); $count++ );//motoDBへ登録用を消したら必要
      $arrEDI = array();//空の配列を作る
      $arrDenpyouDnpMinoukannous = array();//空の配列を作る
      $arrDnpTotalAmounts = array();//空の配列を作る
      $arrDnpdouitutyuumon = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');

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
           $sample = array_combine( $keys, $sample );

           unset($sample['0'],$sample['1'],$sample['4'],$sample['5'],$sample['6'],$sample['8']);
           unset($sample['12'],$sample['15'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

           if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき（カンマのみの行が出てきたら配列への追加を終了）
             $arrEDI[] = $sample;//配列に追加する
           }
        }

        for($n=0; $n<=10000; $n++){
          if(isset($arrEDI[$n])){//$arrEDI[$n]が存在する時、対応するcustomer_code等を配列に追加する
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
      $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrEDI);//patchEntitiesで一括登録
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
          if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録

            for($k=0; $k<count($arrEDI); $k++){//組み立て品登録
              $AssembleProduct = $this->AssembleProducts->find()->where(['product_id' => $arrEDI[$k]['product_code']])->toArray();
              if(count($AssembleProduct) > 0){
                for($n=0; $n<count($AssembleProduct); $n++){
                  $child_pid = $AssembleProduct[$n]->child_pid;
                  $_SESSION['order_edi_kumitate'][$n] = array(
                    'place_deliver_code' => "00000",
                    'date_order' => $arrEDI[$k]["date_order"],
                    'price' => 0,
                    'amount' => $arrEDI[$k]["amount"],
                    'product_code' => $child_pid,
                    'line_code' => $arrEDI[$k]["line_code"],
                    'date_deliver' => $arrEDI[$k]["date_deliver"],
                    'num_order' => $arrEDI[$k]["num_order"],
         //           'first_date_deliver' => $data['order_edi']["first_date_deliver"],
                    'customer_code' => $arrEDI[$k]["customer_code"],
                    'place_line' => $arrEDI[$k]["place_line"],
                    'check_denpyou' => 0,
                    'bunnou' => $arrEDI[$k]["bunnou"],
                    'kannou' => $arrEDI[$k]["kannou"],
                    'delete_flag' => 0,
                    'created_staff' => $this->Auth->user('staff_id')
                  );
                }
                $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $_SESSION['order_edi_kumitate']);
                $this->OrderEdis->saveMany($orderEdis);
             }
          }

//ここからDenpyouDnpMinoukannousへ登録用

            //insert into order_ediする
            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('order_edi');
            $table->setConnection($connection);

            for($k=0; $k<count($arrEDI); $k++){
              $connection->insert('order_edi', [
                  'date_order' => $arrEDI[$k]["date_order"],
                  'num_order' => $arrEDI[$k]["num_order"],
                  'product_id' => $arrEDI[$k]["product_code"],
                  'price' => $arrEDI[$k]["price"],
                  'date_deliver' => $arrEDI[$k]["date_deliver"],
                  'amount' => $arrEDI[$k]["amount"],
                  'cs_id' => $arrEDI[$k]["customer_code"],
                  'place_deliver_id' => $arrEDI[$k]["place_deliver_code"],
                  'place_line' => $arrEDI[$k]["place_line"],
                  'line_code' => $arrEDI[$k]["line_code"],
                  'check_denpyou' => $arrEDI[$k]["check_denpyou"],
                  'bunnou' => $arrEDI[$k]["bunnou"],
                  'kannou' => $arrEDI[$k]["kannou"],
                  'delete_flg' => $arrEDI[$k]["delete_flag"],
                  'created_at' => date("Y-m-d H:i:s")
              ]);
            }

            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('denpyou_dnp');
            $table->setConnection($connection);

            for($k=0; $k<count($arrEDImotodenpyoudnp); $k++){
              if(mb_substr($arrEDImotodenpyoudnp[$k]["place_deliver"], 0, 1) === "弊"){
                $place_deliver = str_replace("弊社","",$arrEDImotodenpyoudnp[$k]["place_deliver"]);
              }else{
                $place_deliver = $arrEDImotodenpyoudnp[$k]["place_deliver"];
            }

              $connection->insert('denpyou_dnp', [
                  'num_order' => $arrEDImotodenpyoudnp[$k]["num_order"],
                  'product_id' => $arrEDImotodenpyoudnp[$k]["product_code"],
                  'name_order' => $arrEDImotodenpyoudnp[$k]["name_order"],
                  'place_deliver' => $place_deliver,
                  'code' => $arrEDImotodenpyoudnp[$k]["line_code"],
                  'conf_print' => 0,
                  'tourokubi' => date("Y-m-d"),
                  'created_at' => date("Y-m-d H:i:s")
              ]);
            }

            $connection = ConnectionManager::get('default');
//新DBに戻す

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
                $OrderEdi = $this->OrderEdis->find()->where(['num_order' => $arrDenpyouDnpMinoukannous[$n]['num_order'], 'line_code' => $arrDenpyouDnpMinoukannous[$n]['code'],
                 'product_code' => $arrDenpyouDnpMinoukannous[$n]['product_code'], 'date_order' => $arrDenpyouDnpMinoukannous[$n]['tourokubi'], 'date_deliver' => $arrDenpyouDnpMinoukannous[$n]['date_deliver']])->toArray();
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
            $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntities($denpyouDnpMinoukannous, $arrDenpyouDnpMinoukannous);//patchEntitiesで一括登録
            if ($this->DenpyouDnpMinoukannous->saveMany($denpyouDnpMinoukannous)) {//saveManyで一括登録//ここからDnpTotalAmountsへ登録用

//旧DB
              for($k=0; $k<count($arrDenpyouDnpMinoukannous); $k++){
              $connection = ConnectionManager::get('default');

              $OrderEdi = $this->OrderEdis->find()->where(['id' => $arrDenpyouDnpMinoukannous[$k]['order_edi_id']])->toArray();
              $OrderEdi_id = $OrderEdi[0]->id;
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];
              $mikandate_deliver = $OrderEdi[0]['date_deliver'];
              $mikanamount = $OrderEdi[0]['amount'];
              $mikanminoukannou = 0;

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_dnp_kannous');
              $table->setConnection($connection);

                $connection->insert('order_dnp_kannous', [
                    'date_order' => $mikandate_order,
                    'num_order' => $mikannum_order,
                    'product_id' => $mikanproduct_code,
                    'code' => $mikanline_code,
                    'date_deliver' => $mikandate_deliver,
                    'amount' => $mikanamount,
                    'minoukannou' => 1,
                    'delete_flg' => 0,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
              }
              $connection = ConnectionManager::get('default');
              //旧DBここまで

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
                   $OrderEdi = $this->OrderEdis->find()->where(['line_code' => $sample['line_code'], 'num_order' => $sample['num_order'], 'product_code' => $sample['product_code'], 'date_order' => $sample['date_order']])->toArray();//同一の注文
                   $total_amount = $OrderEdi[0]['amount'];
                   $date_deliver = $OrderEdi[0]['date_deliver'];
                   ${"arrDnpdouitutyuumon".($k-2)} = array();//空の配列を作る

                     for($n=0; $n<=10000; $n++){
                       if(isset($OrderEdi[$n])){//同一注文について（一つの場合と複数の場合がある）
                         if(isset($OrderEdi[$n+1])){//同じ注番のものが既に分納され、複数存在する時・・・amountを合計し、DenpyouDnpMinoukannousのminoukannouを更新する（date_deliverが小さい方を０に）
                           $total_amount = $total_amount + $OrderEdi[$n+1]['amount'];//amountを合計
                           $orderedi_id = $OrderEdi[$n]['id'];
                           $date_deliver = $OrderEdi[$n]['date_deliver'];
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['id'] = $orderedi_id;//DenpyouDnpMinoukannousのminoukannouを更新するため（date_deliverが小さい方を０に）
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['date_deliver'] = $date_deliver->format('Y-m-d');//DenpyouDnpMinoukannousのminoukannouを更新するため（date_deliverが小さい方を０に）
                         }else{//同一注文が単一の時
                           $orderedi_id = $OrderEdi[$n]['id'];
                           $date_deliver = $OrderEdi[$n]['date_deliver'];
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['id'] = $orderedi_id;//DenpyouDnpMinoukannousのminoukannouを更新するため（date_deliverが小さい方を０に）
                           ${"arrDnpdouitutyuumon".($k-2)}[$n]['date_deliver'] = $date_deliver->format('Y-m-d');//DenpyouDnpMinoukannousのminoukannouを更新するため（date_deliverが小さい方を０に）
                         }
                       }else{
                         break;
                       }
                     }

                      foreach (${"arrDnpdouitutyuumon".($k-2)} as $key => $value) {//同一注文をdate_deliver順に並べ直す
                          $sort[$key] = $value['date_deliver'];
                      }
                      array_multisort( array_map( "strtotime", array_column( ${"arrDnpdouitutyuumon".($k-2)}, "date_deliver" ) ), SORT_ASC, ${"arrDnpdouitutyuumon".($k-2)} ) ;//並び替え

                     $arrDnpdouitutyuumon[] = ${"arrDnpdouitutyuumon".($k-2)};
                     //以下、DnpTotalAmounts登録用
                     $arrDnpTotalAmounts[$k-2]['num_order'] = $sample['num_order'];//配列に追加する
                     $arrDnpTotalAmounts[$k-2]['name_order'] = $sample['name_order'];
                     $arrDnpTotalAmounts[$k-2]['line_code'] = $sample['line_code'];
                     $arrDnpTotalAmounts[$k-2]['product_code'] = $sample['product_code'];
                     $arrDnpTotalAmounts[$k-2]['date_order'] = $sample['date_order'];
                     $arrDnpTotalAmounts[$k-2]['amount'] = $total_amount;
                     $arrDnpTotalAmounts[$k-2]['date_deliver'] = $date_deliver->format('Y-m-d');
                 }
              }

              $uniquearrDnpdouitutyuumon = array_unique($arrDnpdouitutyuumon, SORT_REGULAR);//重複削除
              $uniquearrDnpdouitutyuumon = array_values($uniquearrDnpdouitutyuumon);
/*
              echo "<pre>";
              print_r($uniquearrDnpdouitutyuumon);
              echo "</pre>";
*/
//$uniquearrDnpdouitutyuumonを使って、order_ediテーブルのbunnnouを更新、dnp_minoukannouテーブルのminoukannouを更新

              for($n=0; $n<=10000; $n++){
                if(isset($uniquearrDnpdouitutyuumon[$n])){
                  for($m=1; $m<=10000; $m++){
                    if(isset($uniquearrDnpdouitutyuumon[$n][$m])){//id = $uniquearrDnpdouitutyuumon[$n][$m-1]['id']　のDenpyouDnpMinoukannousデータを更新
                      $DenpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $uniquearrDnpdouitutyuumon[$n][$m-1]['id']])->toArray();
                      $DenpyouDnpMinoukannouId = $DenpyouDnpMinoukannou[0]->id;
                      $this->DenpyouDnpMinoukannous->updateAll(
                      ['minoukannou' => 0, 'updated_at' => date('Y-m-d H:i:s')],//これ以降の納期の注文があるため、'minoukannou' => 0にする
                      ['id'  => $DenpyouDnpMinoukannouId]
                      );

                      //ここから、旧DBへの登録用
                      $order_edi_id = $uniquearrDnpdouitutyuumon[$n][$m-1]['id'];
                      $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                      $mikandate_order = $OrderEdi[0]['date_order'];
                      $mikannum_order = $OrderEdi[0]['num_order'];
                      $mikanproduct_code = $OrderEdi[0]['product_code'];
                      $mikanline_code = $OrderEdi[0]['line_code'];
                      $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                      $mikanamount = $OrderEdi[0]['amount'];
                      $mikanminoukannou = 0;

                      $connection = ConnectionManager::get('DB_ikou_test');
                      $table = TableRegistry::get('order_dnp_kannous');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_dnp_kannous set minoukannou = 0, bunnou = '".$m."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('default');
                      //ここまで


                      $this->OrderEdis->updateAll(
                      ['bunnou' => $m, 'updated_at' => date('Y-m-d H:i:s')],//bunnouを納期順に1,2,3...とうまく更新していく
                      ['id'   => $uniquearrDnpdouitutyuumon[$n][$m-1]['id']]
                      );

                      //ここから、旧DBへの更新
                      $order_edi_id = $uniquearrDnpdouitutyuumon[$n][$m-1]['id'];
                      $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                      $mikandate_order = $OrderEdi[0]['date_order'];
                      $mikannum_order = $OrderEdi[0]['num_order'];
                      $mikanproduct_code = $OrderEdi[0]['product_code'];
                      $mikanline_code = $OrderEdi[0]['line_code'];
                      $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                      $mikanamount = $OrderEdi[0]['amount'];

                      $connection = ConnectionManager::get('DB_ikou_test');
                      $table = TableRegistry::get('order_edi');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_edi set bunnou = '".$m."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('default');
                      //ここまで

                      $this->OrderEdis->updateAll(
                      ['bunnou' => $m+1, 'updated_at' => date('Y-m-d H:i:s')],//bunnouを納期順に1,2,3...とうまく更新していく
                      ['id'   => $uniquearrDnpdouitutyuumon[$n][$m]['id']]
                      );
                      //ここから、旧DBへの更新
                      $order_edi_id = $uniquearrDnpdouitutyuumon[$n][$m]['id'];
                      $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                      $mikandate_order = $OrderEdi[0]['date_order'];
                      $mikannum_order = $OrderEdi[0]['num_order'];
                      $mikanproduct_code = $OrderEdi[0]['product_code'];
                      $mikanline_code = $OrderEdi[0]['line_code'];
                      $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                      $mikanamount = $OrderEdi[0]['amount'];
                      $m1 = $m + 1;

                      $connection = ConnectionManager::get('DB_ikou_test');
                      $table = TableRegistry::get('order_edi');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_edi set bunnou = '".$m1."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('DB_ikou_test');
                      $table = TableRegistry::get('order_dnp_kannous');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_dnp_kannous set bunnou = '".$m1."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('default');
                      //ここまで

                    }else{
                      break;
                    }
                  }
                }else{
                  break;
                }
              }

              //以下、DnpTotalAmountsにもどる
              for($n=0; $n<=10000; $n++){
                if(isset($arrDnpTotalAmounts[$n])){
                  $arrDnpTotalAmounts[$n] = array_merge($arrDnpTotalAmounts[$n],array('delete_flag'=>0));
                  $arrDnpTotalAmounts[$n] = array_merge($arrDnpTotalAmounts[$n],array('created_staff'=>$created_staff));
                }else{
                  break;
                }
              }
              $uniquearrDnpTotalAmounts = array_unique($arrDnpTotalAmounts, SORT_REGULAR);//重複削除
/*
              echo "<pre>";
              print_r("uniquearrDnpTotalAmounts");
              print_r($uniquearrDnpTotalAmounts);
              echo "</pre>";
*/
               $dnpTotalAmounts = $this->DnpTotalAmounts->patchEntities($dnpTotalAmounts, $uniquearrDnpTotalAmounts);//patchEntitiesで一括登録
                   if ($this->DnpTotalAmounts->saveMany($dnpTotalAmounts)) {//saveManyで一括登録
                     $mes = "※登録されました";
                     $this->set('mes',$mes);
/*
                     //insert into order_ediする
                     $connection = ConnectionManager::get('DB_ikou_test');
                     $table = TableRegistry::get('order_edi');
                     $table->setConnection($connection);

                     echo "<pre>";
                     print_r($uniquearrDnpTotalAmounts);
                     echo "</pre>";

                     for($k=0; $k<count($arrEDI); $k++){
                       $connection->insert('order_edi', [
                           'date_order' => $uniquearrDnpTotalAmounts[$k]["date_order"],
                           'num_order' => $uniquearrDnpTotalAmounts[$k]["num_order"],
                           'product_id' => $uniquearrDnpTotalAmounts[$k]["product_code"],
                           'price' => $uniquearrDnpTotalAmounts[$k]["price"],
                           'date_deliver' => $uniquearrDnpTotalAmounts[$k]["date_deliver"],
                           'amount' => $uniquearrDnpTotalAmounts[$k]["amount"],
                           'cs_id' => $uniquearrDnpTotalAmounts[$k]["customer_code"],
                           'place_deliver_id' => $uniquearrDnpTotalAmounts[$k]["place_deliver_code"],
                           'place_line' => $uniquearrDnpTotalAmounts[$k]["place_line"],
                           'line_code' => $uniquearrDnpTotalAmounts[$k]["line_code"],
                           'check_denpyou' => $uniquearrDnpTotalAmounts[$k]["check_denpyou"],
                           'bunnou' => $uniquearrDnpTotalAmounts[$k]["bunnou"],
                           'kannou' => $uniquearrDnpTotalAmounts[$k]["kannou"],
                           'delete_flg' => $uniquearrDnpTotalAmounts[$k]["delete_flag"],
                           'created_at' => $uniquearrDnpTotalAmounts("Y-m-d H:i:s")
                       ]);
                     }
*/

                   } else {
                     $mes = "※登録されませんでした";
                     $this->set('mes',$mes);
                     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));//UTF-8に変換したファイルをSJISに戻す
                     $this->Flash->error(__('The dnpTotalAmounts could not be saved. Please, try again.'));
                     throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                   }
              } else {
                $mes = "※登録されませんでした";
                $this->set('mes',$mes);
                file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));//UTF-8に変換したファイルをSJISに戻す
                $this->Flash->error(__('This denpyouDnpMinoukannous could not be saved. Please, try again.'));
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }
              file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));//UTF-8に変換したファイルをSJISに戻す
              $connection->commit();// コミット5
        } else {
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);
          file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));//UTF-8に変換したファイルをSJISに戻す
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
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $syoyouKeikakus = $this->SyoyouKeikakus->newEntity();
      $this->set('syoyouKeikakus',$syoyouKeikakus);
      $countP = 0;
      $countW = 0;
      $countR = 0;

      if ($this->request->is('post')) {
      $data = $this->request->getData();

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

         $syoyouKeikakus = $this->SyoyouKeikakus->patchEntities($syoyouKeikakus, $arrSyoyouKeikaku);//patchEntitiesで一括登録
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
             if ($this->SyoyouKeikakus->saveMany($syoyouKeikakus)) {//saveManyで一括登録
               $mes = "※登録されました";
               $this->set('mes',$mes);
    //           file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
               $connection->commit();// コミット5

               //insert into label_csvする
               $connection = ConnectionManager::get('DB_ikou_test');
               $table = TableRegistry::get('syoyou_keikaku');
               $table->setConnection($connection);
/*
               echo "<pre>";
               print_r($arrSyoyouKeikaku);
               echo "</pre>";
*/
               for($k=0; $k<count($arrSyoyouKeikaku); $k++){
                 $connection->insert('syoyou_keikaku', [
                     'date_keikaku' => $arrSyoyouKeikaku[$k]["date_keikaku"],
                     'num_keikaku' => $arrSyoyouKeikaku[$k]["num_keikaku"],
                     'product_id' => $arrSyoyouKeikaku[$k]["product_code"],
                     'date_deliver' => $arrSyoyouKeikaku[$k]["date_deliver"],
                     'amount' => $arrSyoyouKeikaku[$k]["amount"]
                 ]);
               }

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
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'keikakucsv']);
          }
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
      $Data = $this->request->query('s');//1度henkou5panaへ行って戻ってきたとき（検索を押したとき）
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

      if($Pro == "W"){//Wのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'customer_code' => '10002', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => '%'.$Pro.'%']
            ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => '%'.$Pro.'%']
            ));//対象の製品を絞り込む
        }
      }elseif($Pro == "P"){//Pのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0', 'customer_code' => '10001',  'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => $Pro.'%']
          ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }elseif($Pro == "H"){//Hのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0', 'customer_code' => '10002',  'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => $Pro.'%']
          ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }else{//Rのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0', 'customer_code' => '10003',  'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => $Pro.'%']
          ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }
    }

    public function henkou5pana()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){//もう一度検索（絞り込み）をした場合
        return $this->redirect(['action' => 'henkou4pana',//以下のデータを持ってhenkou4panaに移動
        's' => ['product_code' => $data['product_code'],'Pro' => $data['Pro'],'date_sta' => $data['date_sta'],'date_fin' => $data['date_fin']]]);
      }

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

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

        if($checknum > 1){//複数のチェックがあった場合
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
            ${"bunnou".$i} = ${"orderEdis".$i}[0]->bunnou;
            $this->set('bunnou'.$i,${"bunnou".$i});

            $i_num = $i;//選択した個数をキープ
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
        $Dnpdate_deliver = $orderEdis0[0]->date_deliver->format('Y-m-d');
        $orderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0','num_order' => $num_order0,'product_code' => $product_code0])->toArray();
        for($n=0; $n<=100; $n++){
          if(isset($orderEdis[$n])){
            ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $orderEdis[$n]->id])->toArray();
            $this->set('orderEdis'.$n,${"orderEdis".$n});

            ${"id".$n} = ${"orderEdis".$n}[0]->id;
            $this->set('id'.$n,${"id".$n});

            ${"date_deliver".$n} = ${"orderEdis".$n}[0]->date_deliver->format('Y-m-d');
            $this->set('date_deliver'.$n,${"date_deliver".$n});

            if($n==0){
              $Dnpdate_deliver = ${"date_deliver".$n};
              $this->set("Dnpdate_deliver",$Dnpdate_deliver);
            }elseif($Dnpdate_deliver > ${"date_deliver".$n}){
              $Dnpdate_deliver = $Dnpdate_deliver;
              $this->set("Dnpdate_deliver",$Dnpdate_deliver);
            }else{
              $Dnpdate_deliver = ${"date_deliver".$n};
              $this->set("Dnpdate_deliver",$Dnpdate_deliver);
            }

            ${"amount".$n} = ${"orderEdis".$n}[0]->amount;
            $this->set('amount'.$n,${"amount".$n});

            $Totalamount = $Totalamount + ${"amount".$n};
            $this->set("Totalamount",$Totalamount);

            ${"kannou".$n} = ${"orderEdis".$n}[0]->kannou;
            $this->set('kannou'.$n,${"kannou".$n});

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

      $Dnpdate_deliver = $data['Dnpdate_deliver'];
      $this->set("Dnpdate_deliver",$Dnpdate_deliver);
      $Totalamount = $data['Totalamount'];
      $this->set("Totalamount",$Totalamount);
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
          ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $data["orderEdis_{$n}"]])->toArray();
          $this->set('orderEdis'.$n,${"orderEdis".$n});
        }else{
          break;
        }
      }

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
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'henkoupanado']);
          }
        }
    }

    public function henkoupanado()//日付更新
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data['orderEdis']);//配列（更新するカラム）の個数

      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        for($n=0; $n<=$cnt; $n++){
         if(isset($data['orderEdis'][$n])){
          if ($this->OrderEdis->updateAll(['date_deliver' => $data['orderEdis'][$n]['date_deliver'] ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],['id' => $data['orderEdis'][$n]['id']])) {
          //旧DB更新
          $newdate_deliver = $data['orderEdis'][$n]['date_deliver'];
          $order_edi_id = $data['orderEdis'][$n]['id'];
          $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
          $mikandate_order = $OrderEdi[0]['date_order'];
          $mikannum_order = $OrderEdi[0]['num_order'];
          $mikanproduct_code = $OrderEdi[0]['product_code'];
          $mikanline_code = $OrderEdi[0]['line_code'];
          //$mikandate_deliver = $OrderEdi[0]['date_deliver'];

          $connection = ConnectionManager::get('DB_ikou_test');
          $table = TableRegistry::get('order_edi');
          $table->setConnection($connection);

          $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
          $connection->execute($updater);
          $connection = ConnectionManager::get('default');
          //ここまで
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
    }

    public function henkoupanabunnnoulogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'henkoupanabunnnoudo']);
          }
        }
    }

    public function henkoupanabunnnoudo()//分納
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data);//配列（更新するカラム）の個数
      $p = 0;

      for($n=0; $n<=count($_SESSION['orderEdis'])+1; $n++){
        if(isset($_SESSION['orderEdis'][$n])){
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$created_staff);
          $arrOrderEdis[] = $_SESSION['orderEdis'][$n];
        }else{
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          break;
        }
      }

//orderEdisを分納するときidがすでにあれば更新、なければ新規登録
//amount=0 or 1 で場合分け（amount=0ならdelete_flag=1にする）
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

              //旧DB更新
              $newdate_deliver = $_SESSION['orderEdis'][$n]['date_deliver'];
              $newamount = $_SESSION['orderEdis'][$n]['amount'];
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , amount = '".$newamount."' , bunnou = '".$bunnnou."' , date_bunnou = '".date('Y-m-d')."' , updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
              $connection->execute($updater);
              $connection = ConnectionManager::get('default');
              //ここまで

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

              //旧DB更新
              $newdate_deliver = $_SESSION['orderEdis'][$n]['date_deliver'];
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , amount = 0 , bunnou = 0 , date_bunnou = '".date('Y-m-d')."' , updated_at = '".date('Y-m-d H:i:s')."' , delete_flg = 1
              where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
              $connection->execute($updater);
              $connection = ConnectionManager::get('default');
              //ここまで

              $mes = "※更新されました";
              $this->set('mes',$mes);
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }elseif(isset($_SESSION['orderEdis'][$n])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $bunnnou = $bunnnou +1;//$bunnnouを振り直す
            $bunnou = array('bunnou'=>$bunnnou);
            $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$bunnou);
            $arrOrderEdisnew[] = $_SESSION['orderEdis'][$n];
            $arrBunnnou[] = $bunnnou;
            $num_order = $_SESSION['orderEdis'][$n]['num_order'];
            $product_code = $_SESSION['orderEdis'][$n]['product_code'];
            $line_code = $_SESSION['orderEdis'][$n]['line_code'];
          }elseif(isset($arrOrderEdisnew[0])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $arrOrderEdisnew);
            if ($this->OrderEdis->saveMany($OrderEdis)) {//minoukannouテーブルにも保存するかつ、同じやつを引っ張り出してdate_deliverが一番遅いやつのminoukannouだけ1にする

              //旧DB更新
              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              for($k=0; $k<count($arrOrderEdisnew); $k++){
                $connection->insert('order_edi', [
                    'date_order' => $arrOrderEdisnew[$k]["date_order"],
                    'num_order' => $arrOrderEdisnew[$k]["num_order"],
                    'product_id' => $arrOrderEdisnew[$k]["product_code"],
                    'price' => $arrOrderEdisnew[$k]["price"],
                    'date_deliver' => $arrOrderEdisnew[$k]["date_deliver"],
                    'amount' => $arrOrderEdisnew[$k]["amount"],
                    'cs_id' => $arrOrderEdisnew[$k]["customer_code"],
                    'place_deliver_id' => $arrOrderEdisnew[$k]["place_deliver_code"],
                    'place_line' => $arrOrderEdisnew[$k]["place_line"],
                    'line_code' => $arrOrderEdisnew[$k]["line_code"],
                    'check_denpyou' => $arrOrderEdisnew[$k]["check_denpyou"],
                    'bunnou' => $arrOrderEdisnew[$k]["bunnou"],
                    'kannou' => $arrOrderEdisnew[$k]["kannou"],
                    'delete_flg' => $arrOrderEdisnew[$k]["delete_flag"],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
              }
              $connection = ConnectionManager::get('default');
              //ここまで

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
          }else{//終了
            $connection->commit();// コミット5
            break;
          }
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10
    }

    public function henkou2dnp()
    {
      $this->request->session()->destroy();// セッションの破棄
    }

    public function henkou3dnp()
    {
      $this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkou4dnp()
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

      if($Pro == "BON"){//BONのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0', 'customer_code' => '20001', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => '%'.$Pro.'%']
            ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }elseif($Pro == "CAS"){//CASのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0', 'customer_code' => '20001', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => $Pro.'%']
          ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }else{//MLDのとき
        if(empty($product_code)){//product_codeの入力がないとき
          $product_code = "no";
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
          ->where(['delete_flag' => '0', 'customer_code' => '20001', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,'product_code like' => $Pro.'%']
          ));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,'product_code like' => $Pro.'%']
            ));//対象の製品を絞り込む
        }
      }
    }

    public function henkou5dnp()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){
        return $this->redirect(['action' => 'henkou4dnp',//以下のデータを持ってhenkou4dnpに移動
        's' => ['product_code' => $data['product_code'],'Pro' => $data['Pro'],'date_sta' => $data['date_sta'],'date_fin' => $data['date_fin']]]);
      }

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

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
            ${"bunnou".$i} = ${"orderEdis".$i}[0]->bunnou;
            $this->set('bunnou'.$i,${"bunnou".$i});

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

            ${"kannou".$n} = ${"orderEdis".$n}[0]->kannou;
            $this->set('kannou'.$n,${"kannou".$n});

            $bunnou_num = $n+1;
            $this->set('bunnou_num',$bunnou_num);
          }else{
            break;
          }
        }
      }
    }

    public function henkou5dnpbunnou()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();

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
          ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $data["orderEdis_{$n}"]])->toArray();
          $this->set('orderEdis'.$n,${"orderEdis".$n});
        }else{
          break;
        }
      }

        if(isset($data['tsuika'])){
          $tsuikanum = $data['tsuikanum'] + 1;
          $this->set('tsuikanum',$tsuikanum);
        }elseif(isset($data['sakujo'])){
          $tsuikanum = $data['tsuikanum'] - 1;
          $this->set('tsuikanum',$tsuikanum);
        }

    }

    public function henkou6dnp()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkoudnppreadd()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkoudnplogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'henkoudnpdo']);
          }
        }
    }

    public function henkoudnpdo()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data['orderEdis']);//配列（更新するカラム）の個数

      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        for($n=0; $n<=$cnt; $n++){
         if(isset($data['orderEdis'][$n])){
          if ($this->OrderEdis->updateAll(['date_deliver' => $data['orderEdis'][$n]['date_deliver'] ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],['id' => $data['orderEdis'][$n]['id']])) {
            //旧DB更新
            $newdate_deliver = $data['orderEdis'][$n]['date_deliver'];
            $order_edi_id = $data['orderEdis'][$n]['id'];
            $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
            $mikandate_order = $OrderEdi[0]['date_order'];
            $mikannum_order = $OrderEdi[0]['num_order'];
            $mikanproduct_code = $OrderEdi[0]['product_code'];
            $mikanline_code = $OrderEdi[0]['line_code'];
            //$mikandate_deliver = $OrderEdi[0]['date_deliver'];

            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('order_edi');
            $table->setConnection($connection);

            $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
            $connection->execute($updater);
            $connection = ConnectionManager::get('default');
            //ここまで
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

    public function henkoudnpbunnnoupreadd()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkoudnpbunnnoulogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'henkoudnpbunnnoudo']);
          }
        }
    }

    public function henkoudnpbunnnoudo()//DNP分納
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data);//配列（更新するカラム）の個数
      $p = 0;

      for($n=0; $n<=count($_SESSION['orderEdis'])+1; $n++){
        if(isset($_SESSION['orderEdis'][$n])){//$_SESSION['orderEdis'][$n]に$created_staffを追加
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$created_staff);
          $arrOrderEdis[] = $_SESSION['orderEdis'][$n];
        }else{//$_SESSION['minoukannou']に$created_staffを追加
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['minoukannou'] = array_merge($_SESSION['minoukannou'],$created_staff);
          break;
        }
      }

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
            $bunnnou = $bunnnou +1;//登録するものの$bunnnouを振り直し
            if ($this->OrderEdis->updateAll(['date_deliver' => $_SESSION['orderEdis'][$n]['date_deliver'] ,'amount' => $_SESSION['orderEdis'][$n]['amount']
            ,'bunnou' => $bunnnou ,'date_bunnou' => date('Y-m-d') ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
            ,['id' => $_SESSION['orderEdis'][$n]['id']])) {

              //ここから、旧DBへの更新
              $newdate_deliver = $_SESSION['orderEdis'][$n]['date_deliver'];
              $newamount = $_SESSION['orderEdis'][$n]['amount'];
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];
              $mikandate_deliver = $OrderEdi[0]['date_deliver'];

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."', amount = '".$newamount."', bunnou = '".$bunnnou."' , date_bunnou = '".date('Y-m-d')."' ,
               updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";//もとのDBも更新
              $connection->execute($updater);

              $connection = ConnectionManager::get('default');
              //ここまで

              $mes = "※更新されました";
              $this->set('mes',$mes);
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }elseif(isset($_SESSION['orderEdis'][$n]['id'])){//amount=0 or nullの時//minoukannouテーブルも更新（'delete_flag' => 1 にする）
            if ($this->OrderEdis->updateAll(['date_deliver' => $_SESSION['orderEdis'][$n]['date_deliver'] ,'amount' => 0
            ,'bunnou' => 0 ,'date_bunnou' => date('Y-m-d') ,'delete_flag' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
            ,['id' => $_SESSION['orderEdis'][$n]['id']])) {

              //ここから、旧DBへの更新
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];
              $mikandate_deliver = $OrderEdi[0]['date_deliver'];
              $mikanamount = $OrderEdi[0]['amount'];

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set bunnou = 0 , date_bunnou = '".date('Y-m-d')."' , updated_at = '".date('Y-m-d H:i:s')."' ,delete_flg = 1  where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
              $connection->execute($updater);

              $connection = ConnectionManager::get('default');
              //ここまで

              $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $_SESSION['orderEdis'][$n]['id']])->toArray();//以下の条件を満たすデータをOrderEdisテーブルから見つける
              $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
              $this->DenpyouDnpMinoukannous->updateAll(['delete_flag' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
              ,['id' => $denpyouDnpMinoukannouId]);

              //ここから、旧DBへの登録用
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];
              $mikandate_deliver = $OrderEdi[0]['date_deliver'];
              $mikanamount = $OrderEdi[0]['amount'];
              $mikanminoukannou = 0;

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_dnp_kannous');
              $table->setConnection($connection);

              $updater = "UPDATE order_dnp_kannous set amount = $mikanamount, delete_flg = 1 , updated_at = '".date('Y-m-d H:i:s')."' 　where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
              $connection->execute($updater);

              $connection = ConnectionManager::get('default');
              //ここまで

              $mes = "※更新されました";
              $this->set('mes',$mes);
            }else{
              $mes = "※更新されませんでした";
              $this->set('mes',$mes);
              $this->Flash->error(__('The data could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }elseif(isset($_SESSION['orderEdis'][$n])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $bunnnou = $bunnnou +1;//$bunnnouを振り直し
            $bunnou = array('bunnou'=>$bunnnou);
            $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$bunnou);
            $arrOrderEdisnew[] = $_SESSION['orderEdis'][$n];//新しいOrderEdiデータを$arrOrderEdisnewという配列に追加
            $arrDenpyouDnpMinoukannousnew[] = $_SESSION['minoukannou'];//新しいDenpyouDnpMinoukannousデータを$arrDenpyouDnpMinoukannousnewという配列に追加
            $arrBunnnou[] = $bunnnou;//新しいOrderEdiデータのためのbunnouを$arrBunnnouという配列に追加
            $num_order = $_SESSION['orderEdis'][$n]['num_order'];
            $product_code = $_SESSION['orderEdis'][$n]['product_code'];
            $line_code = $_SESSION['orderEdis'][$n]['line_code'];
          }elseif(isset($arrOrderEdisnew[0])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $arrOrderEdisnew);//$arrOrderEdisnewを登録
            if ($this->OrderEdis->saveMany($OrderEdis)) {//minoukannouテーブルにも保存するかつ、同じやつを引っ張り出してdate_deliverが一番遅いやつのminoukannouだけ1にする

              //旧DB更新
              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              for($k=0; $k<count($arrOrderEdisnew); $k++){
                $connection->insert('order_edi', [
                    'date_order' => $arrOrderEdisnew[$k]["date_order"],
                    'num_order' => $arrOrderEdisnew[$k]["num_order"],
                    'product_id' => $arrOrderEdisnew[$k]["product_code"],
                    'price' => $arrOrderEdisnew[$k]["price"],
                    'date_deliver' => $arrOrderEdisnew[$k]["date_deliver"],
                    'amount' => $arrOrderEdisnew[$k]["amount"],
                    'cs_id' => $arrOrderEdisnew[$k]["customer_code"],
                    'place_deliver_id' => $arrOrderEdisnew[$k]["place_deliver_code"],
                    'place_line' => $arrOrderEdisnew[$k]["place_line"],
                    'line_code' => $arrOrderEdisnew[$k]["line_code"],
                    'check_denpyou' => $arrOrderEdisnew[$k]["check_denpyou"],
                    'bunnou' => $arrOrderEdisnew[$k]["bunnou"],
                    'kannou' => $arrOrderEdisnew[$k]["kannou"],
                    'delete_flg' => $arrOrderEdisnew[$k]["delete_flag"],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
              }
              $connection = ConnectionManager::get('default');
              //ここまで

              for($m=0; $m<=100; $m++){
                if(isset($arrBunnnou[$m])){//登録するOrderEdiデータ（amount>0）が存在する場合
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
                  $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntities($this->DenpyouDnpMinoukannous->newEntity(), $arrDenpyouDnpMinoukannousnew);//patchEntitiesで一括登録
                  $this->DenpyouDnpMinoukannous->saveMany($denpyouDnpMinoukannous);//saveManyで一括登録

                  //旧DB
                  for($k=0; $k<count($arrDenpyouDnpMinoukannousnew); $k++){
                  $connection = ConnectionManager::get('default');

                  $OrderEdi = $this->OrderEdis->find()->where(['id' => $arrDenpyouDnpMinoukannousnew[$k]['order_edi_id']])->toArray();
                  $OrderEdi_id = $OrderEdi[0]->id;
                  $mikandate_order = $OrderEdi[0]['date_order'];
                  $mikannum_order = $OrderEdi[0]['num_order'];
                  $mikanproduct_code = $OrderEdi[0]['product_code'];
                  $mikanline_code = $OrderEdi[0]['line_code'];
                  $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                  $mikanamount = $OrderEdi[0]['amount'];
                  $mikanminoukannou = 0;

                  $connection = ConnectionManager::get('DB_ikou_test');
                  $table = TableRegistry::get('order_dnp_kannous');
                  $table->setConnection($connection);

                    $connection->insert('order_dnp_kannous', [
                        'date_order' => $mikandate_order,
                        'num_order' => $mikannum_order,
                        'product_id' => $mikanproduct_code,
                        'code' => $mikanline_code,
                        'date_deliver' => $mikandate_deliver,
                        'amount' => $mikanamount,
                        'minoukannou' => 1,
                        'delete_flg' => 0,
                        'created_at' => date("Y-m-d H:i:s")
                    ]);
                  }
                  $connection = ConnectionManager::get('default');
                  //旧DBここまで


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

                      //ここから、旧DBへの登録用
                      $order_edi_id = $arrDnpdouitutyuumonSort[0][$m]['id'];
                      $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                      $mikandate_order = $OrderEdi[0]['date_order'];
                      $mikannum_order = $OrderEdi[0]['num_order'];
                      $mikanproduct_code = $OrderEdi[0]['product_code'];
                      $mikanline_code = $OrderEdi[0]['line_code'];
                      $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                      $mikanamount = $OrderEdi[0]['amount'];
                      $mikanminoukannou = 0;

                      $connection = ConnectionManager::get('DB_ikou_test');
                      $table = TableRegistry::get('order_dnp_kannous');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_dnp_kannous set minoukannou = 0, updated_at = '".date('Y-m-d H:i:s')."', amount = $mikanamount
                      where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('default');
                      //ここまで

                    }else{
                      $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $arrDnpdouitutyuumonSort[0][$m]['id']])->toArray();
                      $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
                      $this->DenpyouDnpMinoukannous->updateAll(['minoukannou' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
                      ,['id' => $denpyouDnpMinoukannouId]);

                      //ここから、旧DBへの登録用
                      $order_edi_id = $arrDnpdouitutyuumonSort[0][$m]['id'];
                      $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                      $mikandate_order = $OrderEdi[0]['date_order'];
                      $mikannum_order = $OrderEdi[0]['num_order'];
                      $mikanproduct_code = $OrderEdi[0]['product_code'];
                      $mikanline_code = $OrderEdi[0]['line_code'];
                      $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                      $mikanamount = $OrderEdi[0]['amount'];
                      $mikanminoukannou = 0;

                      $connection = ConnectionManager::get('DB_ikou_test');
                      $table = TableRegistry::get('order_dnp_kannous');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_dnp_kannous set minoukannou = 1, updated_at = '".date('Y-m-d H:i:s')."', amount = $mikanamount
                       where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('default');
                      //ここまで
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

                //ここから、旧DBへの登録用
                $order_edi_id = $arrDnpdouitutyuumonSort[0][$m]['id'];
                $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                $mikandate_order = $OrderEdi[0]['date_order'];
                $mikannum_order = $OrderEdi[0]['num_order'];
                $mikanproduct_code = $OrderEdi[0]['product_code'];
                $mikanline_code = $OrderEdi[0]['line_code'];
                $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                $mikanamount = $OrderEdi[0]['amount'];
                $mikanminoukannou = 0;

                $connection = ConnectionManager::get('DB_ikou_test');
                $table = TableRegistry::get('order_dnp_kannous');
                $table->setConnection($connection);

                $updater = "UPDATE order_dnp_kannous set minoukannou = 0, updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."'";//もとのDBも更新
                $connection->execute($updater);

                $connection = ConnectionManager::get('default');
                //ここまで

              }else{
                $denpyouDnpMinoukannou = $this->DenpyouDnpMinoukannous->find()->where(['order_edi_id' => $arrDnpdouitutyuumonSort[0][$m]['id']])->toArray();
                $denpyouDnpMinoukannouId = $denpyouDnpMinoukannou[0]->id;
                $this->DenpyouDnpMinoukannous->updateAll(['minoukannou' => 1 ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')]
                ,['id' => $denpyouDnpMinoukannouId]);

                //ここから、旧DBへの登録用
                $order_edi_id = $arrDnpdouitutyuumonSort[0][$m]['id'];
                $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
                $mikandate_order = $OrderEdi[0]['date_order'];
                $mikannum_order = $OrderEdi[0]['num_order'];
                $mikanproduct_code = $OrderEdi[0]['product_code'];
                $mikanline_code = $OrderEdi[0]['line_code'];
                $mikandate_deliver = $OrderEdi[0]['date_deliver'];
                $mikanamount = $OrderEdi[0]['amount'];
                $mikanminoukannou = 0;

                $connection = ConnectionManager::get('DB_ikou_test');
                $table = TableRegistry::get('order_dnp_kannous');
                $table->setConnection($connection);

                $updater = "UPDATE order_dnp_kannous set minoukannou = 1, updated_at = '".date('Y-m-d H:i:s')."'
                 where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                $connection->execute($updater);

                $connection = ConnectionManager::get('default');
                //ここまで

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


    public function henkou3other()
    {
      $this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkou4other()
    {
      $this->request->session()->destroy();//セッションの破棄
      $data = $this->request->getData();

      $Data=$this->request->query('s');//1度henkou5otherへ行って戻ってきたとき（検索を押したとき）
      if(isset($Data)){
        $product_code = $Data['product_code'];
        $date_sta = $Data['date_sta'];
        $date_fin = $Data['date_fin'];
      }else{
        $product_code = $data['product_code'];
        $date_sta = $data['date_sta'];
        $date_fin = $data['date_fin'];
      }

      if(empty($product_code)){//product_codeの入力がないとき
        $product_code = "no";
        $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
        ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,
        'AND' => [['customer_code !=' => '10001'], ['customer_code !=' => '10002'], ['customer_code !=' => '10003'], ['customer_code !=' => '20001']]]));
      }else{//product_codeの入力があるとき
        $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
        ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code,
        'AND' => [['customer_code !=' => '10001'], ['customer_code !=' => '10002'], ['customer_code !=' => '10003'], ['customer_code !=' => '20001']]]));
      }
    }

    public function henkou5other()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){
        return $this->redirect(['action' => 'henkou4other',//以下のデータを持ってhenkou4otherに移動
        's' => ['product_code' => $data['product_code'],'date_sta' => $data['date_sta'],'date_fin' => $data['date_fin']]]);
      }

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

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
            ${"bunnou".$i} = ${"orderEdis".$i}[0]->bunnou;
            $this->set('bunnou'.$i,${"bunnou".$i});
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
        $Dnpdate_deliver = $orderEdis0[0]->date_deliver->format('Y-m-d');
        $orderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0','num_order' => $num_order0,'product_code' => $product_code0])->toArray();
        for($n=0; $n<=100; $n++){
          if(isset($orderEdis[$n])){
            ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $orderEdis[$n]->id])->toArray();
            $this->set('orderEdis'.$n,${"orderEdis".$n});

            ${"id".$n} = ${"orderEdis".$n}[0]->id;
            $this->set('id'.$n,${"id".$n});

            ${"date_deliver".$n} = ${"orderEdis".$n}[0]->date_deliver->format('Y-m-d');
            $this->set('date_deliver'.$n,${"date_deliver".$n});

            if($n==0){
              $Dnpdate_deliver = ${"date_deliver".$n};
              $this->set("Dnpdate_deliver",$Dnpdate_deliver);
            }elseif($Dnpdate_deliver > ${"date_deliver".$n}){
              $Dnpdate_deliver = $Dnpdate_deliver;
              $this->set("Dnpdate_deliver",$Dnpdate_deliver);
            }else{
              $Dnpdate_deliver = ${"date_deliver".$n};
              $this->set("Dnpdate_deliver",$Dnpdate_deliver);
            }

            ${"amount".$n} = ${"orderEdis".$n}[0]->amount;
            $this->set('amount'.$n,${"amount".$n});
            $Totalamount = $Totalamount + ${"amount".$n};
            $this->set("Totalamount",$Totalamount);

            $bunnou_num = $n+1;
            $this->set('bunnou_num',$bunnou_num);

          }else{
            break;
          }
        }
      }
    }

    public function henkou5otherbunnou()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();

      $Dnpdate_deliver = $data['Dnpdate_deliver'];
      $this->set("Dnpdate_deliver",$Dnpdate_deliver);
      $Totalamount = $data['Totalamount'];
      $this->set("Totalamount",$Totalamount);
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
          ${"orderEdis".$n} = $this->OrderEdis->find()->where(['delete_flag' => '0','id' => $data["orderEdis_{$n}"]])->toArray();
          $this->set('orderEdis'.$n,${"orderEdis".$n});
        }else{
          break;
        }
      }

        if(isset($data['tsuika'])){
          $tsuikanum = $data['tsuikanum'] + 1;
          $this->set('tsuikanum',$tsuikanum);
        }elseif(isset($data['sakujo'])){
          $tsuikanum = $data['tsuikanum'] - 1;
          $this->set('tsuikanum',$tsuikanum);
        }
    }

    public function henkou6other()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();
    }

    public function henkouotherpreadd()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkouotherlogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'henkouotherdo']);
          }
        }
    }

    public function henkouotherdo()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data['orderEdis']);//配列（更新するカラム）の個数

      $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        for($n=0; $n<=$cnt; $n++){
         if(isset($data['orderEdis'][$n])){
          if ($this->OrderEdis->updateAll(['date_deliver' => $data['orderEdis'][$n]['date_deliver'] ,'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],['id' => $data['orderEdis'][$n]['id']])) {

            //旧DB更新
            $newdate_deliver = $data['orderEdis'][$n]['date_deliver'];
            $order_edi_id = $data['orderEdis'][$n]['id'];
            $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
            $mikandate_order = $OrderEdi[0]['date_order'];
            $mikannum_order = $OrderEdi[0]['num_order'];
            $mikanproduct_code = $OrderEdi[0]['product_code'];
            $mikanline_code = $OrderEdi[0]['line_code'];
            //$mikandate_deliver = $OrderEdi[0]['date_deliver'];

            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('order_edi');
            $table->setConnection($connection);

            $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
            $connection->execute($updater);
            $connection = ConnectionManager::get('default');
            //ここまで

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

    public function henkouotherbunnnoupreadd()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $session = $this->request->getSession();
      $data = $session->read();
    }

    public function henkouotherbunnnoulogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'henkouotherbunnnoudo']);
          }
        }
    }

    public function henkouotherbunnnoudo()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $session = $this->request->getSession();
      $data = $session->read();
      $cnt = count($data);//配列（更新するカラム）の個数
      $p = 0;

      for($n=0; $n<=count($_SESSION['orderEdis'])+1; $n++){
        if(isset($_SESSION['orderEdis'][$n])){
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          $_SESSION['orderEdis'][$n] = array_merge($_SESSION['orderEdis'][$n],$created_staff);
          $arrOrderEdis[] = $_SESSION['orderEdis'][$n];
        }else{
          $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
          break;
        }
      }

//orderEdisを分納するときidがすでにあれば更新、なければ新規登録ok
//amount=0 or 1 で場合分け（amount=0ならdelete_flag=1にする）ok
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

              //旧DB更新
              $newdate_deliver = $_SESSION['orderEdis'][$n]['date_deliver'];
              $newamount = $_SESSION['orderEdis'][$n]['amount'];
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , amount = '".$newamount."' , bunnou = '".$bunnnou."' ,
               date_bunnou = '".date('Y-m-d')."' , updated_at = '".date('Y-m-d H:i:s')."'
                where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
              $connection->execute($updater);
              $connection = ConnectionManager::get('default');
              //ここまで

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

              //旧DB更新
              $newdate_deliver = $_SESSION['orderEdis'][$n]['date_deliver'];
              $order_edi_id = $_SESSION['orderEdis'][$n]['id'];
              $OrderEdi = $this->OrderEdis->find()->where(['id' => $order_edi_id])->toArray();//同一の注文
              $mikandate_order = $OrderEdi[0]['date_order'];
              $mikannum_order = $OrderEdi[0]['num_order'];
              $mikanproduct_code = $OrderEdi[0]['product_code'];
              $mikanline_code = $OrderEdi[0]['line_code'];

              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , amount = 0 , bunnou = 0 , date_bunnou = '".date('Y-m-d')."' , updated_at = '".date('Y-m-d H:i:s')."' , delete_flg = 1
              where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
              $connection->execute($updater);
              $connection = ConnectionManager::get('default');
              //ここまで

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
            $arrBunnnou[] = $bunnnou;
            $num_order = $_SESSION['orderEdis'][$n]['num_order'];
            $product_code = $_SESSION['orderEdis'][$n]['product_code'];
            $line_code = $_SESSION['orderEdis'][$n]['line_code'];
          }elseif(isset($arrOrderEdisnew[0])){//新しいデータをorderediテーブルに保存する場合（複数ある可能性あり）
            $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $arrOrderEdisnew);
            if ($this->OrderEdis->saveMany($OrderEdis)) {//minoukannouテーブルにも保存するかつ、同じやつを引っ張り出してdate_deliverが一番遅いやつのminoukannouだけ1にする

              //旧DB更新
              $connection = ConnectionManager::get('DB_ikou_test');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              for($k=0; $k<count($arrOrderEdisnew); $k++){
                $connection->insert('order_edi', [
                    'date_order' => $arrOrderEdisnew[$k]["date_order"],
                    'num_order' => $arrOrderEdisnew[$k]["num_order"],
                    'product_id' => $arrOrderEdisnew[$k]["product_code"],
                    'price' => $arrOrderEdisnew[$k]["price"],
                    'date_deliver' => $arrOrderEdisnew[$k]["date_deliver"],
                    'amount' => $arrOrderEdisnew[$k]["amount"],
                    'cs_id' => $arrOrderEdisnew[$k]["customer_code"],
                    'place_deliver_id' => $arrOrderEdisnew[$k]["place_deliver_code"],
                    'place_line' => $arrOrderEdisnew[$k]["place_line"],
                    'line_code' => $arrOrderEdisnew[$k]["line_code"],
                    'check_denpyou' => $arrOrderEdisnew[$k]["check_denpyou"],
                    'bunnou' => $arrOrderEdisnew[$k]["bunnou"],
                    'kannou' => $arrOrderEdisnew[$k]["kannou"],
                    'delete_flg' => $arrOrderEdisnew[$k]["delete_flag"],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
              }
              $connection = ConnectionManager::get('default');
              //ここまで

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
          }else{//終了
            $connection->commit();// コミット5
            break;
          }
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10
    }

    public function chokusetsuformpro()
    {
      $this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      if(isset($data["syousai"])){
        $Product = $this->Products->find()->where(['product_code' => $data['product_code']])->toArray();
        $customer_id = $Product[0]->customer_id;
        $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
        $customer_code = $Customer[0]->customer_code;
        if($customer_code == "20001" || $customer_code == "20002" || $customer_code == "20003" || $customer_code == "20004"){
          return $this->redirect(['action' => 'chokusetsuformalldnp',//以下のデータを持ってhenkou4panaに移動
          's' => ['product_code' => $data['product_code']]]);
        }else{
          return $this->redirect(['action' => 'chokusetsuformallpana',//以下のデータを持ってhenkou4panaに移動
          's' => ['product_code' => $data['product_code']]]);
        }
      }

    }

    public function chokusetsuformallpana()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $Data=$this->request->query('s');
      $data = $Data;
      $product_code = $data["product_code"];
      $this->set("product_code",$product_code);
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Product[0]->product_name;
      $this->set("product_name",$product_name);
/*
      $ProductGaityu = $this->ProductGaityu->find()->where(['product_id' => $product_code, 'flag_denpyou' => 1,  'status' => 0])->toArray();
      $productGaityu = $ProductGaityu[0]->product_id;
      echo "<pre>";
      print_r($productGaityu);
      echo "</pre>";
*/
      $PlaceDelivers = $this->PlaceDelivers->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
        ->where(['cs_id not like' => '%'."20".'%'])->toArray();
        $arrPlaceDeliver = array();//配列の初期化
      	foreach ($PlaceDelivers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
      		$arrPlaceDeliver[] = array($value->id=>$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
      	}
      	$this->set('arrPlaceDeliver',$arrPlaceDeliver);//4行上$arrCustomerをctpで使えるようにセット
    }

    public function chokusetsuconfirmpana()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      $date_order = $data["date_order"]["year"]."-".$data["date_order"]["month"]."-".$data["date_order"]["day"];
      $this->set('date_order',$date_order);
      $num_order = $data["num_order"];
      $this->set('num_order',$num_order);
      $place_deliver = $data["place_deliver"];
      $PlaceDeliver = $this->PlaceDelivers->find()->where(['id' => $place_deliver])->toArray();
      $place_deliver_name = $PlaceDeliver[0]->name;
      $this->set('place_deliver_name',$place_deliver_name);
      $place_deliver_code = $PlaceDeliver[0]->id_from_order;
      $this->set('place_deliver_code',$place_deliver_code);
      $line_code = $data["line_code"];
      $this->set('line_code',$line_code);
      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);
      $product_name = $data["product_name"];
      $this->set('product_name',$product_name);
      $amount = $data["amount"];
      $this->set('amount',$amount);
      $date_deliver = $data["date_deliver"]["year"]."-".$data["date_deliver"]["month"]."-".$data["date_deliver"]["day"];
      $this->set('date_deliver',$date_deliver);
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $customer_id = $Product[0]->customer_id;
      $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
      $customer_code = $Customer[0]->customer_code;
      $this->set("customer_code",$customer_code);
    }

    public function chokusetsupanapreadd()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $data = $this->request->getData();

      $_SESSION['order_edi'] = array(
        'place_deliver_code' => $data["place_deliver_code"],
        'date_order' => $data["date_order"],
        'price' => $data["price"],
        'amount' => $data["amount"],
        'product_code' => $data["product_code"],
        'line_code' => $data["line_code"],
        'date_deliver' => $data["date_deliver"],
        'num_order' => $data["num_order"],
        'first_date_deliver' => $data["first_date_deliver"],
        'customer_code' => $data["customer_code"],
        'place_line' => $data["place_line"],
        'check_denpyou' => 0,
        'bunnou' => 0,
        'kannou' => 0,
        'delete_flag' => 0
      );

      $datenouki = strtotime($data["date_deliver"]);
      $datenoukiye = date('Y-m-d', strtotime("-1 day", $datenouki));
      $w = date("w", strtotime($datenoukiye));//納期の前日の曜日を取得
      if($w == 0){//前日が日曜日なら３日前の金曜日に変更
        $kari_datenouki = date('Y-m-d', strtotime("-3 day", $datenouki));
      }elseif($w == 6){//前日が土曜日なら２日前の金曜日に変更
        $kari_datenouki = date('Y-m-d', strtotime("-2 day", $datenouki));
      }else{//前日が平日ならそのまま
        $kari_datenouki = $datenoukiye;
      }
      $kari_w = date("w", strtotime($kari_datenouki));
      $_SESSION['supplier_date_deliver'] = array(
        'date_deliver' => $kari_datenouki
      );

    }

    public function chokusetsupanalogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);

        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'chokusetsupanado']);
          }
        }
    }

    public function chokusetsupanado()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
      $_SESSION['order_edi'] = array_merge($_SESSION['order_edi'],$created_staff);

      $session = $this->request->getSession();
      $data = $session->read();

      //外注の対応
      $ProductGaityu = $this->ProductGaityu->find()->where(['product_id' => $data['order_edi']['product_code'], 'flag_denpyou' => 1,  'status' => 0])->toArray();
      if(count($ProductGaityu) > 0){
      $id_supplier = $ProductGaityu[0]->id_supplier;
        $_SESSION['ProductGaityu'] = array(
          'id_order' => $data['order_edi']["num_order"],
          'product_code' => $data['order_edi']['product_code'],
          'price' => $data['order_edi']["price"],
          'date_deliver' => $_SESSION['supplier_date_deliver']["date_deliver"],
          'amount' => $data['order_edi']["amount"],
          'id_supplier' => $id_supplier,
          'tourokubi' => date("Y-m-d"),
          'flag_attach' => 0,
          'delete_flag' => 0,
          'created_at' => date("Y-m-d H:i:s"),
          'created_staff' => $this->Auth->user('staff_id')
          );

        }

      $AssembleProduct = $this->AssembleProducts->find()->where(['product_id' => $data['order_edi']['product_code']])->toArray();
      if(count($AssembleProduct) > 0){
        for($n=0; $n<count($AssembleProduct); $n++){
          $child_pid = $AssembleProduct[$n]->child_pid;

          $_SESSION['order_edi_kumitate'][$n] = array(
            'place_deliver_code' => "00000",
            'date_order' => $data['order_edi']["date_order"],
            'price' => 0,
            'amount' => $data['order_edi']["amount"],
            'product_code' => $child_pid,
            'line_code' => $data['order_edi']["line_code"],
            'date_deliver' => $data['order_edi']["date_deliver"],
            'num_order' => $data['order_edi']["num_order"],
            'first_date_deliver' => $data['order_edi']["first_date_deliver"],
            'customer_code' => $data['order_edi']["customer_code"],
            'place_line' => $data['order_edi']["place_line"],
            'check_denpyou' => 0,
            'bunnou' => 0,
            'kannou' => 0,
            'delete_flag' => 0,
            'created_staff' => $this->Auth->user('staff_id')
          );

          //外注の対応（組み立て）
          $ProductGaityukumitate = $this->ProductGaityu->find()->where(['product_id' => $child_pid, 'flag_denpyou' => 1,  'status' => 0])->toArray();
          if(count($ProductGaityukumitate) > 0){
            $id_supplier = $ProductGaityu[0]->id_supplier;
              $_SESSION['ProductGaityu_kumitate'] = array(
                'id_order' => "00000",
                'product_code' => $child_pid,
                'price' => 0,
                'date_deliver' => $_SESSION['supplier_date_deliver']["date_deliver"],
                'amount' => $data['order_edi']["amount"],
                'id_supplier' => $id_supplier,
                'tourokubi' => date("Y-m-d"),
                'flag_attach' => 0,
                'delete_flag' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_staff' => $this->Auth->user('staff_id')
              );
/*
              echo "<pre>";
              print_r('ProductGaityu_kumitate');
              print_r(count($_SESSION['ProductGaityu_kumitate']));
              echo "</pre>";
*/
          }
        }
      }

      $orderEdis = $this->OrderEdis->patchEntity($orderEdis, $data['order_edi']);//$productデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->OrderEdis->save($orderEdis)) {
          if(isset($_SESSION['ProductGaityu'])){//外注がある場合はKariOrderToSuppliersに登録
            $KariOrderToSuppliers = $this->KariOrderToSuppliers->patchEntity($this->KariOrderToSuppliers->newEntity(), $_SESSION['ProductGaityu']);
            if ($this->KariOrderToSuppliers->save($KariOrderToSuppliers)) {
              $mes = "※登録されました";
              $this->set('mes',$mes);
            }else{
              $mes = "※KariOrderToSuppliersに登録できませんでした";
              $this->set('mes',$mes);
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
          }

          $mes = "※登録されました";
          $this->set('mes',$mes);
            if(count($AssembleProduct) > 0){//組み立て製品の場合はそちらも登録
              $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $_SESSION['order_edi_kumitate']);
              if ($this->OrderEdis->saveMany($OrderEdis)) {

                if(isset($_SESSION['ProductGaityu_kumitate'])){//組み立て製品に外注がある場合はKariOrderToSuppliersに登録
                  $KariOrderToSuppliers = $this->KariOrderToSuppliers->patchEntity($this->KariOrderToSuppliers->newEntity(), $_SESSION['ProductGaityu_kumitate']);
                  if ($this->KariOrderToSuppliers->save($KariOrderToSuppliers)) {
                    $mes = "※登録されました";
                    $this->set('mes',$mes);
                  }else{
                    $mes = "※KariOrderToSuppliersに登録できませんでした";
                    $this->set('mes',$mes);
                    throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                  }
                }

                $mes = "※登録されました（組み立て品も登録されました）";
                $this->set('mes',$mes);
                $connection->commit();// コミット5
              }else{
                $mes = "※登録されました（組み立て品は登録できませんでした）";
                $this->set('mes',$mes);
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }
            }
          $connection->commit();// コミット5
        } else {
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10


    }

    public function chokusetsuformalldnp()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $Data=$this->request->query('s');
      $data = $Data;
      $product_code = $data["product_code"];
      $this->set("product_code",$product_code);
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Product[0]->product_name;
      $this->set("product_name",$product_name);

      $PlaceDelivers = $this->PlaceDelivers->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
        ->where(['cs_id like' => '%'."20".'%'])->toArray();
        $arrPlaceDeliver = array();//配列の初期化
      	foreach ($PlaceDelivers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
      		$arrPlaceDeliver[] = array($value->id=>$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
      	}
      	$this->set('arrPlaceDeliver',$arrPlaceDeliver);//4行上$arrCustomerをctpで使えるようにセット
    }

    public function chokusetsuconfirmdnp()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $date_order = $data["date_order"]["year"]."-".$data["date_order"]["month"]."-".$data["date_order"]["day"];
      $this->set('date_order',$date_order);
      $num_order = $data["num_order"];
      $this->set('num_order',$num_order);
      $place_deliver = $data["place_deliver"];
      $PlaceDeliver = $this->PlaceDelivers->find()->where(['id' => $place_deliver])->toArray();
      $place_deliver_name = $PlaceDeliver[0]->name;
      $this->set('place_deliver_name',$place_deliver_name);
      $place_deliver_code = $PlaceDeliver[0]->id_from_order;
      $this->set('place_deliver_code',$place_deliver_code);
      $line_code = $data["line_code"];
      $this->set('line_code',$line_code);
      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);
      $product_name = $data["product_name"];
      $this->set('product_name',$product_name);
      $amount = $data["amount"];
      $this->set('amount',$amount);
      $date_deliver = $data["date_deliver"]["year"]."-".$data["date_deliver"]["month"]."-".$data["date_deliver"]["day"];
      $this->set('date_deliver',$date_deliver);
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $customer_id = $Product[0]->customer_id;
      $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
      $customer_code = $Customer[0]->customer_code;
      $this->set("customer_code",$customer_code);
      $pro_order = $data["pro_order"];
      $this->set("pro_order",$pro_order);
      $mikan = $data["kannou"];
      if($mikan == 0){
        $hyoujikannou = "分納（未了）";
        $kannou = 0;
      }else{
        $hyoujikannou = "完納（完了）";
        $kannou = 1;
      }
      $this->set("hyoujikannou",$hyoujikannou);
      $this->set("kannou",$kannou);
    }

    public function chokusetsudnppreadd()
    {
      session_start();
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $data = $this->request->getData();

      $_SESSION['order_edi'] = array(
        'place_deliver_code' => $data["place_deliver_code"],
        'date_order' => $data["date_order"],
        'price' => $data["price"],
        'amount' => $data["amount"],
        'product_code' => $data["product_code"],
        'line_code' => $data["line_code"],
        'date_deliver' => $data["date_deliver"],
        'num_order' => $data["num_order"],
        'first_date_deliver' => $data["first_date_deliver"],
        'customer_code' => $data["customer_code"],
        'place_line' => $data["place_line"],
        'check_denpyou' => 0,
        'bunnou' => 0,
        'kannou' => $data["kannou"],
        'delete_flag' => 0
      );

      $_SESSION['denpyouDnpMinoukannous'] = array(
        'name_order' => $data["name_order"],
        'place_deliver' => $data["place_deliver_code"],
        'conf_print' => 0,
        'minoukannou' => $data["kannou"],
        'delete_flag' => 0,
        'created_at' => date("Y-m-d H:i:s")
      );

      $_SESSION['dnpTotalAmounts'] = array(
        'name_order' => $data["name_order"],
        'date_order' => $data["date_order"],
        'price' => $data["price"],
        'amount' => $data["amount"],
        'product_code' => $data["product_code"],
        'line_code' => $data["line_code"],
        'date_deliver' => $data["date_deliver"],
        'num_order' => $data["num_order"],
        'delete_flag' => 0
      );
    }

    public function chokusetsudnplogin()
    {
      if ($this->request->is('post')) {
        $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
        $this->set('data',$data);//セット
        $userdata = $data['username'];
        $this->set('userdata',$userdata);//セット

        $htmllogin = new htmlLogin();
        $arraylogindate = $htmllogin->htmllogin($userdata);
/*
        echo "<pre>";
        print_r($arraylogindate);
        echo "</pre>";
*/
        $username = $arraylogindate[0];
        $delete_flag = $arraylogindate[1];
        $this->set('username',$username);
        $this->set('delete_flag',$delete_flag);

        $user = $this->Auth->identify();

          if ($user) {
            $this->Auth->setUser($user);
            return $this->redirect(['action' => 'chokusetsudnpdo']);
          }
        }
    }

    public function chokusetsudnpdo()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
      $_SESSION['order_edi'] = array_merge($_SESSION['order_edi'],$created_staff);
      $_SESSION['denpyouDnpMinoukannous'] = array_merge($_SESSION['denpyouDnpMinoukannous'],$created_staff);
      $_SESSION['dnpTotalAmounts'] = array_merge($_SESSION['dnpTotalAmounts'],$created_staff);

      $session = $this->request->getSession();
      $data = $session->read();

      $AssembleProduct = $this->AssembleProducts->find()->where(['product_id' => $data['order_edi']['product_code']])->toArray();
      if(count($AssembleProduct) > 0){
        for($n=0; $n<count($AssembleProduct); $n++){
          $child_pid = $AssembleProduct[$n]->child_pid;

          $_SESSION['order_edi_kumitate'][$n] = array(
            'place_deliver_code' => "00000",
            'date_order' => $data['order_edi']["date_order"],
            'price' => 0,
            'amount' => $data['order_edi']["amount"],
            'product_code' => $child_pid,
            'line_code' => $data['order_edi']["line_code"],
            'date_deliver' => $data['order_edi']["date_deliver"],
            'num_order' => $data['order_edi']["num_order"],
            'first_date_deliver' => $data['order_edi']["first_date_deliver"],
            'customer_code' => $data['order_edi']["customer_code"],
            'place_line' => $data['order_edi']["place_line"],
            'check_denpyou' => 0,
            'bunnou' => 0,
            'kannou' => $data['order_edi']["kannou"],
            'delete_flag' => 0,
            'created_staff' => $this->Auth->user('staff_id')
          );
        }
      }

      $orderEdis = $this->OrderEdis->patchEntity($orderEdis, $data['order_edi']);//$productデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->OrderEdis->save($orderEdis)) {

          $OrderEdi = $this->OrderEdis->find()->where(['num_order' => $_SESSION['order_edi']['num_order'], 'product_code' => $_SESSION['order_edi']['product_code'], 'date_order' => $_SESSION['order_edi']['date_order'], 'date_deliver' => $_SESSION['order_edi']['date_deliver']])->toArray();
          $OrderEdi_id = $OrderEdi[0]->id;

          $arrid = array('order_edi_id'=>$OrderEdi_id);
          $_SESSION['denpyouDnpMinoukannous'] = array_merge($_SESSION['denpyouDnpMinoukannous'],$arrid);

          $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntity($this->DenpyouDnpMinoukannous->newEntity(), $_SESSION['denpyouDnpMinoukannous']);
          $this->DenpyouDnpMinoukannous->save($denpyouDnpMinoukannous);
    /*      if ($this->DenpyouDnpMinoukannous->save($denpyouDnpMinoukannous)) {
            echo "<pre>";
            print_r("ok");
            echo "</pre>";
          }else{
            echo "<pre>";
            print_r("no");
            echo "</pre>";
          }
*/
          $dnpTotalAmounts = $this->DnpTotalAmounts->patchEntity($this->DnpTotalAmounts->newEntity(), $data['dnpTotalAmounts']);
          $this->DnpTotalAmounts->save($dnpTotalAmounts);

          $mes = "※登録されました";
          $this->set('mes',$mes);
            if(count($AssembleProduct) > 0){//組み立て製品の場合はそちらも登録
              $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $_SESSION['order_edi_kumitate']);
              if ($this->OrderEdis->saveMany($OrderEdis)) {
                $mes = "※登録されました（組み立て品も登録されました）";
                $this->set('mes',$mes);
                $connection->commit();// コミット5
              }else{
                $mes = "※登録されました（組み立て品は登録できませんでした）";
                $this->set('mes',$mes);
                throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
              }
            }

          $connection->commit();// コミット5
        } else {
          $mes = "※登録されませんでした";
          $this->set('mes',$mes);
          throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
        }
      } catch (Exception $e) {//トランザクション7
      //ロールバック8
        $connection->rollback();//トランザクション9
      }//トランザクション10
    }


}
