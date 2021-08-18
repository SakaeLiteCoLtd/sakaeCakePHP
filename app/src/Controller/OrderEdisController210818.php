<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use App\myClass\Logins\htmlLogin;//myClassフォルダに配置したクラスを使用
use App\myClass\EDItouroku\htmlEDItouroku;//myClassフォルダに配置したクラスを使用
use App\myClass\Productcheck\htmlProductcheck;
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
       $this->ProductGaityus = TableRegistry::get('productGaityus');
       $this->KariOrderToSuppliers = TableRegistry::get('kariOrderToSuppliers');
       $this->UnitOrderToSuppliers = TableRegistry::get('unitOrderToSuppliers');
       $this->OrderToSuppliers = TableRegistry::get('orderToSuppliers');
       $this->AttachOrderToSuppliers = TableRegistry::get('attachOrderToSuppliers');
       $this->AccountPriceProducts = TableRegistry::get('accountPriceProducts');
       $this->ProductSuppliers = TableRegistry::get('productSuppliers');
       $this->OrderYobistockSuppliers = TableRegistry::get('orderYobistockSuppliers');
       $this->ProductChokusous = TableRegistry::get('productChokusous');
     }

     public function indexmenu()
     {
       //$this->request->session()->destroy();// セッションの破棄
     }

     public function hattyucsv()//発注CSV
     {
       if(!isset($_SESSION)){//sessionsyuuseituika
       session_start();
       }
       $_SESSION['order_edi_kumitate'] = array();

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
        for ($k=1; $k<=$count; $k++) {//最後の行まで
          $line = fgets($fp);//ファイル$fpの上の１行（カラム名が並んでいるため）を取る（２行目から読み込み開始）
          $sample = explode(',',$line);//$lineを','毎に配列に入れる

           $keys=array_keys($sample);
           $keys[array_search('3',$keys)]='place_deliver_code';//名前の変更（3?place_deliver_code）
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

           if($k>=2 && !empty($sample['num_order'])){//$sample['num_order']が空でないとき（カンマのみの行が出てきたら配列への追加を終了）
             $arrFp[] = $sample;//配列に追加する
           }
    //       if($k>=2){
    //         $arrFp[] = $sample;//$sampleを配列に追加する
    //       }
        }

        for($n=0; $n<count($arrFp); $n++){
          if(isset($arrFp[$n])){//$arrFp[$n]が存在する時、対応するcustomer_code等を配列に追加する
            $Product = $this->Products->find()->where(['product_code' => $arrFp[$n]['product_code']])->toArray();
            if(isset($Product[0])){
              $customer_id = $Product[0]->customer_id;
            }else{
              echo "<pre>";
              print_r($arrFp[$n]['product_code']."が登録されていません");
              echo "</pre>";
            }

            $ProductChokusous = $this->ProductChokusous->find()->where(['product_code' => $arrFp[$n]['product_code'], 'status'=>0])->toArray();
            if(isset($ProductChokusous[0])){//直送製品の場合 place_deliver_code => line_codeに変更
              $tyokusou_line_code = $arrFp[$n]["line_code"];
              $arrFp[$n] = array_merge($arrFp[$n],array('place_deliver_code'=>$tyokusou_line_code));
            }

    				$customer_id = $Product[0]->customer_id;
            $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
    				$customer_code = $Customer[0]->customer_code;
            $arrFp[$n] = array_merge($arrFp[$n],array('customer_code'=>$customer_code));
/*
            list($youso1,$place_line,$youso3)=explode("/", $arrFp[$n]['place_line']);
            if(!empty($place_line)){
              $place_line = $place_line;
            }else{
              $place_line = $arrFp[$n]['place_line'];
            }
            unset($arrFp[$n]['place_line']);
            $arrFp[$n] = array_merge($arrFp[$n],array('place_line'=>$place_line));
*/
            $arrFp[$n] = array_merge($arrFp[$n],array('check_denpyou'=>0));
            $arrFp[$n] = array_merge($arrFp[$n],array('bunnou'=>0));
            $arrFp[$n] = array_merge($arrFp[$n],array('kannou'=>0));
            $arrFp[$n] = array_merge($arrFp[$n],array('delete_flag'=>0));
            $arrFp[$n] = array_merge($arrFp[$n],array('created_staff'=>$created_staff));
          }else{
            break;
          }
        }

        //同じcsvを入れようとした場合
        $EDInum = count($arrFp);
        for($k=0; $k<$EDInum; $k++){//組み立て品登録

          $OrderEdi= $this->OrderEdis->find()->where(['date_order' => $arrFp[$k]['date_order'], 'date_deliver' => $arrFp[$k]['date_deliver'], 'num_order' => $arrFp[$k]['num_order'],
          'product_code' => $arrFp[$k]['product_code'], 'delete_flag' => $arrFp[$k]['delete_flag']])->toArray();

          if(isset($OrderEdi[0])){
            unset($arrFp[$k]);
          }

        }

        if(count($arrFp) == 0){
          echo "<pre>";
          print_r("同じcsvを読み込んでいないか確認してください");
          echo "</pre>";
        }

        $arrFp = array_values($arrFp);//添え字の振り直し
        $arrFpold = $arrFp;//添え字の振り直し
/*
        echo "<pre>";
        print_r("登録内容表示");
        print_r($arrFp);
        echo "</pre>";
*/
           $orderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $arrFp);//patchEntitiesで一括登録
           $connection = ConnectionManager::get('default');//トランザクション1
           // トランザクション開始2
           $connection->begin();//トランザクション3
           try {//トランザクション4
               if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録

                 //外注仮登録クラス
                 $htmlgaityukaritouroku = new htmlEDItouroku();
                 $data = $htmlgaityukaritouroku->htmlgaityukaritouroku($arrFp);

                 //外注登録クラス（紐づけ、kari_orderの更新も）
                 $htmlgaityutouroku = new htmlEDItouroku();
                 $data = $htmlgaityutouroku->htmlgaityutouroku();

                 $num = 0;
                 for($k=0; $k<count($arrFp); $k++){//組み立て品登録
                   $num = $num + 1;

                   $AssembleProduct = $this->AssembleProducts->find()->where(['product_code' => $arrFp[$k]['product_code']])->toArray();
                   if(count($AssembleProduct) > 0){
                     for($n=0; $n<count($AssembleProduct); $n++){
                       $num = $num + 1;
                       $child_pid = $AssembleProduct[$n]->child_pid;

                       $_SESSION['order_edi_kumitate'][$num] = array(
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

                   }

                 }

                 if(isset($_SESSION['order_edi_kumitate'])){

                   $_SESSION['order_edi_kumitate'] = array_values($_SESSION['order_edi_kumitate']);//添え字の振り直し

                 }

               if(isset($_SESSION['order_edi_kumitate'][0])){
                 $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $_SESSION['order_edi_kumitate']);
                 if($this->OrderEdis->saveMany($orderEdis)){

                   $arrFp = array();//空の配列を作る
                   $arrFp = $_SESSION['order_edi_kumitate'];

                   //insert into order_ediする（旧DB）
                   $connection = ConnectionManager::get('sakaeMotoDB');
                   $table = TableRegistry::get('order_edi');
                   $table->setConnection($connection);

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
                   $connection = ConnectionManager::get('default');
                   $table->setConnection($connection);

                   //組み立て外注仮登録クラス
                   $htmlgaityukaritouroku = new htmlEDItouroku();
                   $data = $htmlgaityukaritouroku->htmlgaityukaritourokuAssemble($arrFp);

                   //組み立て外注登録クラス（紐づけ、kari_orderの更新も）
                   $htmlgaityutouroku = new htmlEDItouroku();
                   $data = $htmlgaityutouroku->htmlgaityutouroku();

                 }

               }

                 $mes = "※登録されました";
                 $this->set('mes',$mes);
                 $connection->commit();// コミット5

                 //insert into order_ediする（旧DB）
                 $connection = ConnectionManager::get('sakaeMotoDB');
                 $table = TableRegistry::get('order_edi');
                 $table->setConnection($connection);

                 for($k=0; $k<count($arrFpold); $k++){
                   $connection->insert('order_edi', [
                       'date_order' => $arrFpold[$k]["date_order"],
                       'num_order' => $arrFpold[$k]["num_order"],
                       'product_id' => $arrFpold[$k]["product_code"],
                       'price' => $arrFpold[$k]["price"],
                       'date_deliver' => $arrFpold[$k]["date_deliver"],
                    //   'first_date_deliver' => $arrFp[$k]["first_date_deliver"],
                       'amount' => $arrFpold[$k]["amount"],
                       'cs_id' => $arrFpold[$k]["customer_code"],
                       'place_deliver_id' => $arrFpold[$k]["place_deliver_code"],
                       'place_line' => $arrFpold[$k]["place_line"],
                       'line_code' => $arrFpold[$k]["line_code"],
                       'check_denpyou' => $arrFpold[$k]["check_denpyou"],
                    //   'gaityu' => $arrFp[$k]["gaityu"],
                       'bunnou' => $arrFpold[$k]["bunnou"],
                       'kannou' => $arrFpold[$k]["kannou"],
                    //   'date_bunnou' => $arrFp[$k]["date_bunnou"],
                    //   'check_kannou' => $arrFp[$k]["check_kannou"],
                       'delete_flg' => $arrFpold[$k]["delete_flag"],
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
      //$this->request->session()->destroy();// セッションの破棄
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
      //$this->request->session()->destroy();// セッションの破棄
      session_start();//セッションの開始
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

        for ($k=1; $k<=$count; $k++) {//最後の行まで
          $line = fgets($fpmoto);//ファイル$fpの上の１行を取る（２行目から）
          $sample = explode(',',$line);//$lineを','毎に配列に入れる

           $keys=array_keys($sample);
           $keys[array_search('2',$keys)]='num_order';//名前の変更
           $keys[array_search('3',$keys)]='name_order';
           $keys[array_search('4',$keys)]='line_code';
           $keys[array_search('7',$keys)]='product_code';
           $keys[array_search('9',$keys)]='date_order';
           $keys[array_search('15',$keys)]='place_deliver';
           $sample = array_combine( $keys, $sample );

           unset($sample['0'],$sample['1'],$sample['4'],$sample['5'],$sample['6'],$sample['8']);
           unset($sample['10'],$sample['11'],$sample['13'],$sample['14']);
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

        for ($k=1; $k<=$count; $k++) {//最後の行まで
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
           $keys[array_search('15',$keys)]='place_deliver';
           $sample = array_combine( $keys, $sample );

           unset($sample['0'],$sample['1'],$sample['4'],$sample['5'],$sample['6'],$sample['8']);
           unset($sample['12'],$sample['16'],$sample['17'],$sample['18']);//最後の改行も削除

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

            if(mb_substr($arrEDI[$n]["place_deliver"], 0, 1) === "弊"){
              $place_deliver = str_replace("弊社","",$arrEDI[$n]["place_deliver"]);
            }else{
              $place_deliver = $arrEDI[$n]["place_deliver"];
            }
            unset($arrEDI[$n]['place_deliver']);

            $arrEDI[$n] = array_merge($arrEDI[$n],array('place_line'=>$place_deliver));
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

        //同じcsvを入れようとした場合
        $EDInum = count($arrEDI);
        for($k=0; $k<$EDInum; $k++){//組み立て品登録

          $OrderEdi= $this->OrderEdis->find()->where(['date_order' => $arrEDI[$k]['date_order'], 'date_deliver' => $arrEDI[$k]['date_deliver'], 'num_order' => $arrEDI[$k]['num_order'],
          'product_code' => $arrEDI[$k]['product_code'], 'delete_flag' => $arrEDI[$k]['delete_flag']])->toArray();

          if(isset($OrderEdi[0])){
            unset($arrEDI[$k]);
          }

        }

        if(count($arrEDI) == 0){
          echo "<pre>";
          print_r("同じcsvを読み込んでいないか確認してください");
          echo "</pre>";
        }

        $arrEDI = array_values($arrEDI);//添え字の振り直し
/*
      echo "<pre>";
      print_r("arrEDI");
      print_r($arrEDI);
      echo "</pre>";
  */
  //    $_SESSION['order_edi_kumitate'] = array();//空の配列を作る

      $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $arrEDI);//patchEntitiesで一括登録
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
          if ($this->OrderEdis->saveMany($orderEdis)) {//saveManyで一括登録

            $arrFp = array();//空の配列を作る
            $arrFp = $arrEDI;

            //外注仮登録クラス
            $htmlgaityukaritouroku = new htmlEDItouroku();
            $data = $htmlgaityukaritouroku->htmlgaityukaritouroku($arrFp);

            //外注登録クラス（紐づけ、kari_orderの更新も）
            $htmlgaityutouroku = new htmlEDItouroku();
            $data = $htmlgaityutouroku->htmlgaityutouroku();

                $num = 0;
                for($k=0; $k<count($arrEDI); $k++){//組み立て品登録
                  $num = $num + 1;
                  $AssembleProduct = $this->AssembleProducts->find()->where(['product_code' => $arrEDI[$k]['product_code']])->toArray();
                  if(count($AssembleProduct) > 0){
                    for($n=0; $n<count($AssembleProduct); $n++){
                      $num = $num + 1;
                      $child_pid = $AssembleProduct[$n]->child_pid;
/*
                      echo "<pre>";
                      print_r("count");
                      print_r(count($AssembleProduct));
                      echo "</pre>";
*/
                      $_SESSION['order_edi_kumitate'][$num] = array(
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

                  }

                }

                if(isset($_SESSION['order_edi_kumitate'])){

                  $_SESSION['order_edi_kumitate'] = array_values($_SESSION['order_edi_kumitate']);//添え字の振り直し

                }

              if(isset($_SESSION['order_edi_kumitate'][0])){
                $orderEdis = $this->OrderEdis->patchEntities($orderEdis, $_SESSION['order_edi_kumitate']);
                if($this->OrderEdis->saveMany($orderEdis)){

                  $arrFp = array();//空の配列を作る
                  $arrFp = $_SESSION['order_edi_kumitate'];

                  //insert into order_ediする（旧DB）
                  $connection = ConnectionManager::get('sakaeMotoDB');
                  $table = TableRegistry::get('order_edi');
                  $table->setConnection($connection);

                  for($m=0; $m<count($arrFp); $m++){

                    $sql = "SELECT bunnou FROM order_edi".//
                          " where date_order ='".$arrFp[$m]["date_order"]."' and num_order = '".$arrFp[$m]["num_order"]."'
                           and product_id = '".$arrFp[$m]["product_code"]."' order by bunnou desc limit 1";//
                    $connection = ConnectionManager::get('sakaeMotoDB');//
                    $bunnoumoto = $connection->execute($sql)->fetchAll('assoc');//
      //
                    if(isset($bunnoumoto[0]["bunnou"])){//
                      $bunnou = $bunnoumoto[0]["bunnou"] + 1;//
                    }else{//
                      $bunnou = $arrFp[$m]["bunnou"];//
                    }//

                    $connection->insert('order_edi', [
                        'date_order' => $arrFp[$m]["date_order"],
                        'num_order' => $arrFp[$m]["num_order"],
                        'product_id' => $arrFp[$m]["product_code"],
                        'price' => $arrFp[$m]["price"],
                        'date_deliver' => $arrFp[$m]["date_deliver"],
                        'amount' => $arrFp[$m]["amount"],
                        'cs_id' => $arrFp[$m]["customer_code"],
                        'place_deliver_id' => $arrFp[$m]["place_deliver_code"],
                        'place_line' => $arrFp[$m]["place_line"],
                        'line_code' => $arrFp[$m]["line_code"],
                        'check_denpyou' => $arrFp[$m]["check_denpyou"],
                        'bunnou' => $bunnou,
                        'kannou' => $arrFp[$m]["kannou"],
                        'delete_flg' => $arrFp[$m]["delete_flag"],
                        'created_at' => date("Y-m-d H:i:s")
                    ]);
                  }
                  $connection = ConnectionManager::get('default');
                  $table->setConnection($connection);

                  //組み立て外注仮登録クラス
                  $htmlgaityukaritouroku = new htmlEDItouroku();
                  $data = $htmlgaityukaritouroku->htmlgaityukaritourokuAssemble($arrFp);

                  //組み立て外注登録クラス（紐づけ、kari_orderの更新も）
                  $htmlgaityutouroku = new htmlEDItouroku();
                  $data = $htmlgaityutouroku->htmlgaityutouroku();

                }

              }


//ここからDenpyouDnpMinoukannousへ登録用

            //insert into order_ediする（旧DB）
            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('order_edi');
            $table->setConnection($connection);

            for($k=0; $k<count($arrEDI); $k++){

              $sql = "SELECT bunnou FROM order_edi".//
                    " where date_order ='".$arrEDI[$k]["date_order"]."' and num_order = '".$arrEDI[$k]["num_order"]."'
                     and product_id = '".$arrEDI[$k]["product_code"]."' order by bunnou desc limit 1";//
              $connection = ConnectionManager::get('sakaeMotoDB');//
              $bunnoumoto = $connection->execute($sql)->fetchAll('assoc');//
//
              if(isset($bunnoumoto[0]["bunnou"])){//
                $bunnou = $bunnoumoto[0]["bunnou"] + 1;//
              }else{//
                $bunnou = $arrEDI[$k]["bunnou"];//
              }//

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
                  'bunnou' => $bunnou,
                  'kannou' => $arrEDI[$k]["kannou"],
                  'delete_flg' => $arrEDI[$k]["delete_flag"],
                  'created_at' => date("Y-m-d H:i:s")
              ]);
            }

            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('denpyou_dnp');
            $table->setConnection($connection);

            for($k=0; $k<count($arrEDImotodenpyoudnp); $k++){
              if(mb_substr($arrEDImotodenpyoudnp[$k]["place_deliver"], 0, 1) === "弊"){
                $place_deliver = str_replace("弊社","",$arrEDImotodenpyoudnp[$k]["place_deliver"]);
              }else{
                $place_deliver = $arrEDImotodenpyoudnp[$k]["place_deliver"];
              }


              $sql = "SELECT num_order FROM denpyou_dnp".//
                    " where num_order ='".$arrEDImotodenpyoudnp[$k]["num_order"]."' and product_id = '".$arrEDImotodenpyoudnp[$k]["product_code"]."'
                     and tourokubi = '".$arrEDImotodenpyoudnp[$k]["date_order"]."'";//
              $connection = ConnectionManager::get('sakaeMotoDB');//
              $denpyou_dnpcheck = $connection->execute($sql)->fetchAll('assoc');//

              if(isset($denpyou_dnpcheck[0]["num_order"])){//

              }else{//
                $connection->insert('denpyou_dnp', [
                    'num_order' => $arrEDImotodenpyoudnp[$k]["num_order"],
                    'product_id' => $arrEDImotodenpyoudnp[$k]["product_code"],
                    'name_order' => $arrEDImotodenpyoudnp[$k]["name_order"],
                    'place_deliver' => $place_deliver,
                    'code' => $arrEDImotodenpyoudnp[$k]["line_code"],
                    'conf_print' => 0,
                    'tourokubi' => $arrEDImotodenpyoudnp[$k]["date_order"],
                    'created_at' => date("Y-m-d H:i:s")
                ]);
              }//
            }

            $connection = ConnectionManager::get('default');
//新DBに戻す

            for ($k=1; $k<=$count; $k++) {//最後の行まで
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
              $mikanbunnou = $OrderEdi[0]['bunnou'];//
              $mikanminoukannou = 0;

              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('order_dnp_kannous');
              $table->setConnection($connection);

                $connection->insert('order_dnp_kannous', [
                    'date_order' => $mikandate_order,
                    'num_order' => $mikannum_order,
                    'product_id' => $mikanproduct_code,
                    'code' => $mikanline_code,
                    'date_deliver' => $mikandate_deliver,
                    'amount' => $mikanamount,
                    'bunnou' => $mikanbunnou,//
                    'minoukannou' => 1,
                    'delete_flg' => 0,
                    'created_at' => date("Y-m-d H:i:s")
                ]);
              }
              $connection = ConnectionManager::get('default');
              //旧DBここまで

              for ($k=1; $k<=$count; $k++) {//最後の行まで
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

                      $connection = ConnectionManager::get('sakaeMotoDB');
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

                      $connection = ConnectionManager::get('sakaeMotoDB');
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

                      $connection = ConnectionManager::get('sakaeMotoDB');
                      $table = TableRegistry::get('order_edi');
                      $table->setConnection($connection);

                      $updater = "UPDATE order_edi set bunnou = '".$m1."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
                      $connection->execute($updater);

                      $connection = ConnectionManager::get('sakaeMotoDB');
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

               $dnpTotalAmounts = $this->DnpTotalAmounts->patchEntities($dnpTotalAmounts, $uniquearrDnpTotalAmounts);//patchEntitiesで一括登録
                   if ($this->DnpTotalAmounts->saveMany($dnpTotalAmounts)) {//saveManyで一括登録
                     $mes = "※登録されました";
                     $this->set('mes',$mes);

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

          if(count($arrEDI) == 0){
            $mes = "※登録される新規データはありません。登録済みのcsvを読み込んでいないか確認してください";
          }else{
            $mes = "※登録されませんでした。ファイル内の製品名や金額等のデータにカンマが含まれていないか確認してください。";
          }
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

      $_SESSION['order_edi_kumitate'] = array();//空の配列を作る

    }

    public function keikakucsv()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $syoyouKeikakus = $this->SyoyouKeikakus->newEntity();
      $this->set('syoyouKeikakus',$syoyouKeikakus);
/*
      $countP = 0;
      $countW = 0;
      $countR = 0;
*/
      if ($this->request->is('post')) {
      $data = $this->request->getData();

      $source_file = $_FILES['file']['tmp_name'];
//文字変換（不要）     file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));
      $fp = fopen($source_file, "r");
      $fpcount = fopen($source_file, 'r' );

      for($count = 0; fgets( $fpcount ); $count++ );
      $arrSyoyouKeikaku = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');
      for ($k=1; $k<=$count; $k++) {//最後の行まで
        $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
        $sample = explode(',',$line);//$lineを','毎に配列に入れる

         $keys=array_keys($sample);
         $keys[array_search('2',$keys)]='date_keikaku';//名前の変更
         $keys[array_search('17',$keys)]='product_code';
         $keys[array_search('19',$keys)]='date_deliver';
         $keys[array_search('20',$keys)]='amount';
         $keys[array_search('22',$keys)]='num_keikaku';
         $sample = array_combine( $keys, $sample );
         $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
         $created_at = array('created_at'=>date('Y-m-d H:i:s'));
         $sample = array_merge($sample,$created_staff);
         $sample = array_merge($sample,$created_at);

         unset($sample['0'],$sample['1'],$sample['4'],$sample['3'],$sample['5'],$sample['6'],$sample['7'],$sample['8']);
         unset($sample['9'],$sample['10'],$sample['11'],$sample['12'],$sample['13'],$sample['14'],$sample['15']);
         unset($sample['16'],$sample['18'],$sample['21'],$sample['23'],$sample['24'],$sample['25'],$sample['26']);
         unset($sample['27'],$sample['28'],$sample['29'],$sample['30'],$sample['31'],$sample['32'],$sample['33'],$sample['34']);
         unset($sample['35'],$sample['36'],$sample['37'],$sample['38'],$sample['39'],$sample['40'],$sample['41']);//最後の改行も削除

         if($k>=2 && !empty($sample['product_code'])){
             $arrSyoyouKeikaku[] = $sample;//配列に追加する
  //           $this->SyoyouKeikakus->deleteAll(['product_code' => $sample['product_code']]);//格納した品番の所要計画データは一旦削除
/*
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
*/
          }
      }
/*
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
*/

//      echo "<pre>";
//      print_r($arrSyoyouKeikaku);
//      echo "</pre>";

//         rename($source_file,$source_file."test");

         $syoyouKeikakus = $this->SyoyouKeikakus->patchEntities($syoyouKeikakus, $arrSyoyouKeikaku);//patchEntitiesで一括登録
         $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4

           //同じ品番で登録済みのものは全て新しい情報に置き換えるため、削除する
           for($k=0; $k<count($arrSyoyouKeikaku); $k++){

             $SyoyouKeikaku= $this->SyoyouKeikakus->find()->where(['product_code' => $arrSyoyouKeikaku[$k]['product_code']])->toArray();

        //     if(isset($SyoyouKeikaku[0])){
        //       $this->SyoyouKeikakus->deleteAll(['product_code' => $arrSyoyouKeikaku[$k]['product_code']]);
        //     }

             $this->SyoyouKeikakus->updateAll(
             ['delete_flag' => 1, 'updated_at' => date('Y-m-d H:i:s'),'updated_staff' => $this->Auth->user('staff_id')],
             ['product_code' => $arrSyoyouKeikaku[$k]['product_code']]
             );

             $connection = ConnectionManager::get('sakaeMotoDB');
             $table = TableRegistry::get('syoyou_keikaku');
             $table->setConnection($connection);

             $delete_keikaku = "DELETE FROM syoyou_keikaku where product_id = '".$arrSyoyouKeikaku[$k]['product_code']."'";
             $connection->execute($delete_keikaku);

             $connection = ConnectionManager::get('default');//新DBに戻る
             $table->setConnection($connection);

           }

             if ($this->SyoyouKeikakus->saveMany($syoyouKeikakus)) {//saveManyで一括登録
               $mes = "※登録されました";
               $this->set('mes',$mes);
    //           file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'SJIS', 'UTF-8'));
               $connection->commit();// コミット5

               //insert into label_csvする（旧DB）
               $connection = ConnectionManager::get('sakaeMotoDB');
               $table = TableRegistry::get('syoyou_keikaku');
               $table->setConnection($connection);

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
      //$this->request->session()->destroy();// セッションの破棄
      session_start();//セッションの開始
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

    public function henkoutop()//登録呼出変更のトップ
    {
      //$this->request->session()->destroy();// セッションの破棄
    }

    public function henkousentakucustomer()//登録呼出変更のpana,dnp,others選択画面
    {
      //$this->request->session()->destroy();// セッションの破棄
    }

    public function henkoupanaselectproduct()//登録呼出変更のpanaの、p関係とかの選択
    {
      //$this->request->session()->destroy();// セッションの破棄
    }

    public function henkoupanasearch()//登録呼出変更のpanaの、納期絞り込み
    {
      //$this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkoupanaichiran()
    {
      //$this->request->session()->destroy();//セッションの破棄
      $data = $this->request->getData();
      $Data = $this->request->query('s');//1度henkoupanaformへ行って戻ってきたとき（検索を押したとき）
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

    public function henkoupanaform()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){//もう一度検索（絞り込み）をした場合
        return $this->redirect(['action' => 'henkoupanaichiran',//以下のデータを持ってhenkoupanaichiranに移動
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

    public function henkoupanabunnou()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderEdis'] = array();

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

    public function henkoupanaconfirm()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderEdis'] = array();

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

          $connection = ConnectionManager::get('sakaeMotoDB');
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

    public function henkoupanabunnnoudo()//パナ分納
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
            $OrderEdi = $this->OrderEdis->find()->where(['id' => $_SESSION['orderEdis'][$n]['id']])->toArray();
            $motodate_deliver = $OrderEdi[0]['date_deliver'];

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

              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , amount = '".$newamount."' , bunnou = '".$bunnnou."' , date_bunnou = '".date('Y-m-d')."' , updated_at = '".date('Y-m-d H:i:s')."'
                where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."' and date_deliver = '".$motodate_deliver."'";
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

              $connection = ConnectionManager::get('sakaeMotoDB');
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

              $arrFp = array();//空の配列を作る
              $arrFp = $arrOrderEdisnew;

              //旧DB更新
              $connection = ConnectionManager::get('sakaeMotoDB');
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

    public function henkoudnpselectproduct()
    {
      //$this->request->session()->destroy();// セッションの破棄
    }

    public function henkoudnpsearch()
    {
      //$this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkoudnpichiran()
    {
      //$this->request->session()->destroy();//セッションの破棄
      $data = $this->request->getData();
      $Data=$this->request->query('s');//1度henkoupanaformへ行って戻ってきたとき（検索を押したとき）
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
          ->where(['delete_flag' => '0', 'customer_code' => '20001', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin,
          'OR' => [['product_code like' => $Pro.'%'], ['product_code like' => "SPR".'%']]]));//対象の製品を絞り込む
        }else{//product_codeの入力があるとき
          $this->set('orderEdis',$this->OrderEdis->find()//以下の条件を満たすデータをOrderEdisテーブルから見つける
            ->where(['delete_flag' => '0','date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code]
            ));//対象の製品を絞り込む
        }
      }
    }

    public function henkoudnpform()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){
        return $this->redirect(['action' => 'henkoudnpichiran',//以下のデータを持ってhenkoudnpichiranに移動
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
        $line_code0 = $orderEdis0[0]->line_code;
        $product_code0 = $orderEdis0[0]->product_code;

        $orderEdis = $this->OrderEdis->find()->where(['delete_flag' => '0','num_order' => $num_order0,'line_code' => $line_code0,'product_code' => $product_code0])->toArray();
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

    public function henkoudnpbunnou()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderEdis'] = array();

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

    public function henkoudnpconfirm()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderEdis'] = array();

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

            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('order_edi');
            $table->setConnection($connection);

            $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."' , updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";
            $connection->execute($updater);

            $table = TableRegistry::get('order_dnp_kannous');
            $table->setConnection($connection);

            $updater = "UPDATE order_dnp_kannous set updated_at = '".date('Y-m-d H:i:s')."', date_deliver = '".$newdate_deliver."'
            where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."'";//もとのDBも更新
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

            $arrOrderEdis = $this->OrderEdis->find()->where(['id' => $_SESSION['orderEdis'][$n]['id']])->toArray();

            $bunnnoumoto = $arrOrderEdis[0]->bunnou;
            $date_delivermoto = $arrOrderEdis[0]->date_deliver;

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

              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('order_edi');
              $table->setConnection($connection);

              $updater = "UPDATE order_edi set date_deliver = '".$newdate_deliver."', amount = '".$newamount."', bunnou = '".$bunnnou."' , date_bunnou = '".date('Y-m-d')."' ,
               updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and bunnou = '".$bunnnoumoto."' and date_order = '".$mikandate_order."' and line_code = '".$mikanline_code."'";//もとのDBも更新
              $connection->execute($updater);

              $table = TableRegistry::get('order_dnp_kannous');
              $table->setConnection($connection);

              $updater = "UPDATE order_dnp_kannous set updated_at = '".date('Y-m-d H:i:s')."', amount = $newamount, date_deliver = '".$newdate_deliver."'
              where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$date_delivermoto."'";//もとのDBも更新
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

              $connection = ConnectionManager::get('sakaeMotoDB');
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

              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('order_dnp_kannous');
              $table->setConnection($connection);

              $updater = "UPDATE order_dnp_kannous set amount = $mikanamount, delete_flg = 1 , updated_at = '".date('Y-m-d H:i:s')."' where product_id ='".$mikanproduct_code."' and num_order = '".$mikannum_order."' and date_order = '".$mikandate_order."' and code = '".$mikanline_code."' and date_deliver = '".$mikandate_deliver."'";//もとのDBも更新
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

              $arrFp = array();//空の配列を作る
              $arrFp = $arrOrderEdisnew;

              //旧DB更新
              $connection = ConnectionManager::get('sakaeMotoDB');
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

                  $connection = ConnectionManager::get('sakaeMotoDB');
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

                      $connection = ConnectionManager::get('sakaeMotoDB');
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

                      $connection = ConnectionManager::get('sakaeMotoDB');
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

                $connection = ConnectionManager::get('sakaeMotoDB');
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

                $connection = ConnectionManager::get('sakaeMotoDB');
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


    public function henkouothersearch()
    {
      //$this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
    }

    public function henkouotherichiran()
    {
      //$this->request->session()->destroy();//セッションの破棄
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
        ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code
    //    'AND' => [['customer_code !=' => '10001'], ['customer_code !=' => '10002'], ['customer_code !=' => '10003'], ['customer_code !=' => '20001']]
        ]));
      }
    }

    public function henkouotherform()
    {
      $data = $this->request->getData();

      if(isset($data['kensaku'])){
        return $this->redirect(['action' => 'henkouotherichiran',//以下のデータを持ってhenkouotherichiranに移動
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

    public function henkouotherbunnou()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderEdis'] = array();

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

    public function henkouotherconfirm()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderEdis'] = array();

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

            $connection = ConnectionManager::get('sakaeMotoDB');
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

              $connection = ConnectionManager::get('sakaeMotoDB');
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

              $connection = ConnectionManager::get('sakaeMotoDB');
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

              $arrFp = array();//空の配列を作る
              $arrFp = $arrOrderEdisnew;

              //旧DB更新
              $connection = ConnectionManager::get('sakaeMotoDB');
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
      //$this->request->session()->destroy();// セッションの破棄
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      if(isset($data["syousai"])){

        $product_code = $data['product_code'];

        $htmlProductcheck = new htmlProductcheck();//クラスを使用
        $product_code_check = $htmlProductcheck->Productcheck($product_code);
        if($product_code_check == 1){
          return $this->redirect(
           ['controller' => 'Products', 'action' => 'producterror', 's' => ['product_code' => $product_code]]
          );
        }

        $Product = $this->Products->find()->where(['product_code' => $data['product_code']])->toArray();
        $customer_id = $Product[0]->customer_id;
        $Customer = $this->Customers->find()->where(['id' => $customer_id])->toArray();
        $customer_code = $Customer[0]->customer_code;
        if($customer_code == "20001" || $customer_code == "20002" || $customer_code == "20003" || $customer_code == "20004"){
          return $this->redirect(['action' => 'chokusetsuformalldnp',
          's' => ['product_code' => $data['product_code']]]);
        }else{
          return $this->redirect(['action' => 'chokusetsuformallpana',
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
      $PlaceDelivers = $this->PlaceDelivers->find()
        ->where(['cs_code not like' => '%'."200".'%'])->toArray();
        $arrPlaceDeliver = array();//配列の初期化
      	foreach ($PlaceDelivers as $value) {
      		$arrPlaceDeliver[] = array($value->id=>$value->name);
      	}
      	$this->set('arrPlaceDeliver',$arrPlaceDeliver);
    }

    public function chokusetsuconfirmpana()
    {
      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);

      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

      if(preg_match('/㈱/',$data["line_code"])){//$subjectのなかに㈱が含まれている場合
        $line_code = "入力し直してください";
        $line_code_check = 1;
        $this->set('line_code_check',$line_code_check);
      }else{
        $line_code = $data["line_code"];
        $line_code_check = 2;
        $this->set('line_code_check',$line_code_check);
      }

      $date_order = $data["date_order"]["year"]."-".$data["date_order"]["month"]."-".$data["date_order"]["day"];
      $this->set('date_order',$date_order);
      $num_order = $data["num_order"];
      $this->set('num_order',$num_order);
      $place_deliver = $data["place_deliver"];
      $PlaceDeliver = $this->PlaceDelivers->find()->where(['id' => $place_deliver])->toArray();
      $place_deliver_name = $PlaceDeliver[0]->name;
      $this->set('place_deliver_name',$place_deliver_name);

      $ProductChokusous = $this->ProductChokusous->find()->where(['product_code' => $data["product_code"], 'status'=>0])->toArray();
      if(isset($ProductChokusous[0])){//直送製品の場合 place_deliver_code => line_codeに変更
        $place_deliver_code = $line_code;
      }else{
        $place_deliver_code = $PlaceDeliver[0]->id_from_order;
      }

      $this->set('place_deliver_code',$place_deliver_code);

//      $place_deliver_code = $PlaceDeliver[0]->id_from_order;
//      $this->set('place_deliver_code',$place_deliver_code);
  //    $line_code = $data["line_code"];
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

//単価の表示をするかチェック
      $PlaceDeliver = $this->PlaceDelivers->find()->where(['id' => $place_deliver])->toArray();
      $place_deliver_cs_code = $PlaceDeliver[0]->cs_code;

      if($place_deliver_cs_code == $customer_code){
        $AccountPriceProduct = $this->AccountPriceProducts->find()->where(['product_code' => $product_code, 'delete_flag' => 0])->order(["date_koushin"=>"DESC"])->toArray();

        if(isset($AccountPriceProduct[0])){
          $price_check = 0;
          $this->set("price_check",$price_check);
          $price = $AccountPriceProduct[0]->price;
          $this->set("price",$price);
        }else{
          echo "<pre>";
          print_r("AccountPriceProductsテーブルに単価が登録されていません");
          echo "</pre>";
          $price_check = 1;
          $this->set("price_check",$price_check);
        }

      }else{
        $price_check = 1;
        $this->set("price_check",$price_check);

      }

    }

    public function chokusetsupanapreadd()
    {
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['order_edi'] = array();

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
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['ProductGaityu'] = array();
      $_SESSION['order_edi_kumitate'] = array();
      $_SESSION['ProductGaityu_kumitate'] = array();

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
      $_SESSION['order_edi'] = array_merge($_SESSION['order_edi'],$created_staff);

      $session = $this->request->getSession();
      $data = $session->read();

      //外注の対応
      $ProductGaityu = $this->ProductGaityus->find()->where(['product_code' => $data['order_edi']['product_code'], 'flag_denpyou' => 1,  'status' => 0])->toArray();
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

      $AssembleProduct = $this->AssembleProducts->find()->where(['product_code' => $data['order_edi']['product_code'], 'flag' => 0])->toArray();
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
          $ProductGaityukumitate = $this->ProductGaityus->find()->where(['product_code' => $child_pid, 'flag_denpyou' => 1,  'status' => 0])->toArray();
          if(count($ProductGaityukumitate) > 0){
            $id_supplier = $ProductGaityukumitate[0]->id_supplier;
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

          }

        }

      }

      $_SESSION['hyoujitourokudata'] = $data['order_edi'];

      $orderEdis = $this->OrderEdis->patchEntity($orderEdis, $data['order_edi']);//$productデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->OrderEdis->save($orderEdis)) {
/*
          echo "<pre>";
          print_r('旧DB登録');
          print_r($data['order_edi']);
          echo "</pre>";
*/
          //旧DB登録
          $connection = ConnectionManager::get('sakaeMotoDB');
          $table = TableRegistry::get('order_edi');
          $table->setConnection($connection);

            $connection->insert('order_edi', [
                'date_order' => $data['order_edi']["date_order"],
                'num_order' => $data['order_edi']["num_order"],
                'product_id' => $data['order_edi']["product_code"],
                'price' => $data['order_edi']["price"],
                'date_deliver' => $data['order_edi']["date_deliver"],
                'amount' => $data['order_edi']["amount"],
                'cs_id' => $data['order_edi']["customer_code"],
                'place_deliver_id' => $data['order_edi']["place_deliver_code"],
                'place_line' => $data['order_edi']["place_line"],
                'line_code' => $data['order_edi']["line_code"],
                'check_denpyou' => $data['order_edi']["check_denpyou"],
                'bunnou' => $data['order_edi']["bunnou"],
                'kannou' => $data['order_edi']["kannou"],
                'delete_flg' => $data['order_edi']["delete_flag"],
                'created_at' => date("Y-m-d H:i:s")
            ]);
          $connection = ConnectionManager::get('default');
          //ここまで

          if(isset($_SESSION['ProductGaityu'])){//外注がある場合はKariOrderToSuppliersに登録

              $arrFp = array();//空の配列を作る
              $arrFp[] = $data['order_edi'];

              //外注仮登録クラス
              $htmlgaityukaritouroku = new htmlEDItouroku();
              $data = $htmlgaityukaritouroku->htmlgaityukaritouroku($arrFp);

              //外注登録クラス（紐づけ、kari_orderの更新も）
              $htmlgaityutouroku = new htmlEDItouroku();
              $data = $htmlgaityutouroku->htmlgaityutouroku();

          }

          $mes = "※登録されました";
          $this->set('mes',$mes);
            if(count($AssembleProduct) > 0){//組み立て製品の場合はそちらも登録
              $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $_SESSION['order_edi_kumitate']);
              if ($this->OrderEdis->saveMany($OrderEdis)) {

                for($n=0; $n<count($_SESSION['order_edi_kumitate']); $n++){

                //旧DB登録
                $connection = ConnectionManager::get('sakaeMotoDB');
                $table = TableRegistry::get('order_edi');
                $table->setConnection($connection);

                  $connection->insert('order_edi', [
                      'date_order' => $_SESSION['order_edi_kumitate'][$n]["date_order"],
                      'num_order' => $_SESSION['order_edi_kumitate'][$n]["num_order"],
                      'product_id' => $_SESSION['order_edi_kumitate'][$n]["product_code"],
                      'price' => $_SESSION['order_edi_kumitate'][$n]["price"],
                      'date_deliver' => $_SESSION['order_edi_kumitate'][$n]["date_deliver"],
                      'amount' => $_SESSION['order_edi_kumitate'][$n]["amount"],
                      'cs_id' => $_SESSION['order_edi_kumitate'][$n]["customer_code"],
                      'place_deliver_id' => $_SESSION['order_edi_kumitate'][$n]["place_deliver_code"],
                      'place_line' => $_SESSION['order_edi_kumitate'][$n]["place_line"],
                      'line_code' => $_SESSION['order_edi_kumitate'][$n]["line_code"],
                      'check_denpyou' => $_SESSION['order_edi_kumitate'][$n]["check_denpyou"],
                      'bunnou' => $_SESSION['order_edi_kumitate'][$n]["bunnou"],
                      'kannou' => $_SESSION['order_edi_kumitate'][$n]["kannou"],
                      'delete_flg' => $_SESSION['order_edi_kumitate'][$n]["delete_flag"],
                      'created_at' => date("Y-m-d H:i:s")
                  ]);
                $connection = ConnectionManager::get('default');
                //ここまで

                }

                $arrFp = array();//空の配列を作る
                $arrFp[] = $_SESSION['order_edi_kumitate'];

                //組み立て外注仮登録クラス
                $htmlgaityukaritouroku = new htmlEDItouroku();
                $data = $htmlgaityukaritouroku->htmlgaityukaritourokuAssemble($arrFp);

                //組み立て外注登録クラス（紐づけ、kari_orderの更新も）
                $htmlgaityutouroku = new htmlEDItouroku();
                $data = $htmlgaityutouroku->htmlgaityutouroku();

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
        ->where(['cs_code like' => '%'."200".'%'])->toArray();
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

      //単価の表示をするかチェック
      $PlaceDeliver = $this->PlaceDelivers->find()->where(['id' => $place_deliver])->toArray();
      $place_deliver_cs_code = $PlaceDeliver[0]->cs_code;

      if($place_deliver_cs_code == $customer_code){
        $AccountPriceProduct = $this->AccountPriceProducts->find()->where(['product_code' => $product_code])->toArray();

        if(isset($AccountPriceProduct[0])){
          $price_check = 0;
          $this->set("price_check",$price_check);
          $price = $AccountPriceProduct[0]->price;
          $this->set("price",$price);
        }else{
          echo "<pre>";
          print_r("AccountPriceProductsテーブルに単価が登録されていません");
          echo "</pre>";
          $price_check = 1;
          $this->set("price_check",$price_check);
        }

      }else{
        $price_check = 1;
        $this->set("price_check",$price_check);

      }

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
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['order_edi_kumitate'] = array();

      $orderEdis = $this->OrderEdis->newEntity();
      $this->set('orderEdis',$orderEdis);
      $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
      $_SESSION['order_edi'] = array_merge($_SESSION['order_edi'],$created_staff);
      $_SESSION['denpyouDnpMinoukannous'] = array_merge($_SESSION['denpyouDnpMinoukannous'],$created_staff);
      $_SESSION['dnpTotalAmounts'] = array_merge($_SESSION['dnpTotalAmounts'],$created_staff);

      $session = $this->request->getSession();
      $data = $session->read();

      $AssembleProduct = $this->AssembleProducts->find()->where(['product_code' => $data['order_edi']['product_code']])->toArray();
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

      $_SESSION['hyoujitourokudata'] = $data['order_edi'];

      $orderEdis = $this->OrderEdis->patchEntity($orderEdis, $data['order_edi']);//$productデータ（空の行）を$this->request->getData()に更新する
      $connection = ConnectionManager::get('default');//トランザクション1
      // トランザクション開始2
      $connection->begin();//トランザクション3
      try {//トランザクション4
        if ($this->OrderEdis->save($orderEdis)) {
/*
          echo "<pre>";
          print_r('旧DB登録');
          print_r($data['order_edi']);
          echo "</pre>";
  */
          //旧DB登録
          $connection = ConnectionManager::get('sakaeMotoDB');
          $table = TableRegistry::get('order_edi');
          $table->setConnection($connection);

            $connection->insert('order_edi', [
                'date_order' => $data['order_edi']["date_order"],
                'num_order' => $data['order_edi']["num_order"],
                'product_id' => $data['order_edi']["product_code"],
                'price' => $data['order_edi']["price"],
                'date_deliver' => $data['order_edi']["date_deliver"],
                'amount' => $data['order_edi']["amount"],
                'cs_id' => $data['order_edi']["customer_code"],
                'place_deliver_id' => $data['order_edi']["place_deliver_code"],
                'place_line' => $data['order_edi']["place_line"],
                'line_code' => $data['order_edi']["line_code"],
                'check_denpyou' => $data['order_edi']["check_denpyou"],
                'bunnou' => $data['order_edi']["bunnou"],
                'kannou' => $data['order_edi']["kannou"],
                'delete_flg' => $data['order_edi']["delete_flag"],
                'created_at' => date("Y-m-d H:i:s")
            ]);

            $connection = ConnectionManager::get('sakaeMotoDB');
            $table = TableRegistry::get('order_dnp_kannous');
            $table->setConnection($connection);

              $connection->insert('order_dnp_kannous', [
                  'date_order' => $data['order_edi']["date_order"],
                  'num_order' => $data['order_edi']["num_order"],
                  'product_id' => $data['order_edi']["product_code"],
                  'code' => $data['order_edi']["line_code"],
                  'date_deliver' => $data['order_edi']["date_deliver"],
                  'amount' => $data['order_edi']["amount"],
                  'minoukannou' => $data['order_edi']["kannou"],
                  'delete_flg' => 0,
                  'created_at' => date("Y-m-d H:i:s")
              ]);

              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('denpyou_dnp');
              $table->setConnection($connection);

              $PlaceDeliver = $this->PlaceDelivers->find()->where(['id_from_order' => $data['order_edi']["place_deliver_code"]])->toArray();
              $place_deliver = $PlaceDeliver[0]->name;
              /*
              echo "<pre>";
              print_r($data['order_edi']["place_deliver_code"]);
              print_r($place_deliver);
              echo "</pre>";
*/
                $connection->insert('denpyou_dnp', [
                    'num_order' => $data['order_edi']["num_order"],
                    'product_id' => $data['order_edi']["product_code"],
                    'name_order' => $_SESSION['denpyouDnpMinoukannous']["name_order"],
                    'place_deliver' => $place_deliver,
                    'code' => $data['order_edi']["line_code"],
                    'conf_print' => 0,
                    'tourokubi' => $data['order_edi']["date_order"],
                    'created_at' => date("Y-m-d H:i:s")
                ]);

              $connection = ConnectionManager::get('default');
              //旧DBここまで

          $arrFp = array();//空の配列を作る
          $arrFp[] = $data['order_edi'];
/*
          echo "<pre>";
          print_r($arrFp);
          echo "</pre>";
*/
          //外注仮登録クラス
          $htmlgaityukaritouroku = new htmlEDItouroku();
          $data = $htmlgaityukaritouroku->htmlgaityukaritouroku($arrFp);

          //外注登録クラス（紐づけ、kari_orderの更新も）
          $htmlgaityutouroku = new htmlEDItouroku();
          $data = $htmlgaityutouroku->htmlgaityutouroku();

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
/*
echo "<pre>";
print_r($_SESSION['dnpTotalAmounts']);
echo "</pre>";
*/
          $dnpTotalAmounts = $this->DnpTotalAmounts->patchEntity($this->DnpTotalAmounts->newEntity(), $_SESSION['dnpTotalAmounts']);
          $this->DnpTotalAmounts->save($dnpTotalAmounts);


          $mes = "※登録されました";
          $this->set('mes',$mes);

            if(count($AssembleProduct) > 0){//組み立て製品の場合はそちらも登録
              $OrderEdis = $this->OrderEdis->patchEntities($this->OrderEdis->newEntity(), $_SESSION['order_edi_kumitate']);
              if ($this->OrderEdis->saveMany($OrderEdis)) {

                for($n=0; $n<count($_SESSION['order_edi_kumitate']); $n++){

                //旧DB登録
                $connection = ConnectionManager::get('sakaeMotoDB');
                $table = TableRegistry::get('order_edi');
                $table->setConnection($connection);

                  $connection->insert('order_edi', [
                      'date_order' => $_SESSION['order_edi_kumitate'][$n]["date_order"],
                      'num_order' => $_SESSION['order_edi_kumitate'][$n]["num_order"],
                      'product_id' => $_SESSION['order_edi_kumitate'][$n]["product_code"],
                      'price' => $_SESSION['order_edi_kumitate'][$n]["price"],
                      'date_deliver' => $_SESSION['order_edi_kumitate'][$n]["date_deliver"],
                      'amount' => $_SESSION['order_edi_kumitate'][$n]["amount"],
                      'cs_id' => $_SESSION['order_edi_kumitate'][$n]["customer_code"],
                      'place_deliver_id' => $_SESSION['order_edi_kumitate'][$n]["place_deliver_code"],
                      'place_line' => $_SESSION['order_edi_kumitate'][$n]["place_line"],
                      'line_code' => $_SESSION['order_edi_kumitate'][$n]["line_code"],
                      'check_denpyou' => $_SESSION['order_edi_kumitate'][$n]["check_denpyou"],
                      'bunnou' => $_SESSION['order_edi_kumitate'][$n]["bunnou"],
                      'kannou' => $_SESSION['order_edi_kumitate'][$n]["kannou"],
                      'delete_flg' => $_SESSION['order_edi_kumitate'][$n]["delete_flag"],
                      'created_at' => date("Y-m-d H:i:s")
                  ]);
                $connection = ConnectionManager::get('default');
                //ここまで

              }

                $arrFp = array();//空の配列を作る
                $arrFp[] = $_SESSION['order_edi_kumitate'];
/*
                echo "<pre>";
                print_r($arrFp);
                echo "</pre>";
*/
                //組み立て外注仮登録クラス
                $htmlgaityukaritouroku = new htmlEDItouroku();
                $data = $htmlgaityukaritouroku->htmlgaityukaritourokuAssemble($arrFp);

                //組み立て外注登録クラス（紐づけ、kari_orderの更新も）
                $htmlgaityutouroku = new htmlEDItouroku();
                $data = $htmlgaityutouroku->htmlgaityutouroku();

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

    public function denpyouindex()
    {
      //$this->request->session()->destroy(); // セッションの破棄
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function denpyouhattyu()
    {
      //$this->request->session()->destroy(); // セッションの破棄
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function denpyouhenkoukensaku()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function denpyouhenkouichiran()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];
      $product_code = $data['product_code'];
/*
      echo "<pre>";
      print_r($date_sta."---".$date_fin);
      echo "</pre>";
*/
      if(empty($product_code)){//product_codeの入力がないとき
        $product_code = "no";
        $this->set('OrderToSuppliers',$this->OrderToSuppliers->find()
          ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin]
          ));//対象の製品を絞り込む
      }else{//product_codeの入力があるとき
        $this->set('OrderToSuppliers',$this->OrderToSuppliers->find()
          ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code]
          ));//対象の製品を絞り込む
      }

    }

    public function denpyouhenkouform()
    {
      //$this->request->session()->destroy(); // セッションの破棄

      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $array = array();
      $checknum = 0;
      for ($k=1; $k<=$data["nummax"]; $k++){
        if(isset($data["subete"])){
          $array[] = $data["$k"];
        }elseif(isset($data["check".$k])){//checkがついているもののidをキープ
          $array[] = $data["$k"];
          $checknum = $checknum + 1;
        }else{
        }
      }

      $count = count($array);
      $this->set('count',$count);

      $arrOrderToSupplier = array();
      for ($k=0; $k<$count; $k++){
        $OrderToSuppliers = $this->OrderToSuppliers->find()->where(['id' => $array[$k]])->toArray();
        $id = $OrderToSuppliers[0]->id;
        $id_order = $OrderToSuppliers[0]->id_order;
        $product_code = $OrderToSuppliers[0]->product_code;

        $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
        $product_name = $Product[0]->product_name;

        $date_deliver = $OrderToSuppliers[0]->date_deliver;
        $amount = $OrderToSuppliers[0]->amount;
        $id_supplier = $OrderToSuppliers[0]->id_supplier;

        $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $id_supplier])->toArray();
        $Supplier = $ProductSuppliers[0]->name;

        $arrOrderToSupplier[] = ["id" => $id, "id_order" => $id_order, "product_code" => $product_code, "product_name" => $product_name,
        "date_deliver" => $date_deliver, "amount" => $amount, "Supplier" => $Supplier];
      }

      $this->set('arrOrderToSupplier',$arrOrderToSupplier);

    }

    public function denpyouhenkouconfirm()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();

      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderToSuppliers'] = array();

      for($k=0; $k<$data["num"]; $k++){
        $_SESSION['orderToSuppliers'][$k] = array(
          'id' => $data["id{$k}"],
          'amount' => $data["amount_{$k}"],
          'date_deliver' => $data["date_deliver_{$k}"]
        );
      }
      $this->set('count',$data["num"]);
/*
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";
*/
      for ($k=0; $k<$data["num"]; $k++){
        $OrderToSuppliers = $this->OrderToSuppliers->find()->where(['id' => $data["id{$k}"]])->toArray();
        $id = $OrderToSuppliers[0]->id;
        $id_order = $OrderToSuppliers[0]->id_order;
        $product_code = $OrderToSuppliers[0]->product_code;

        $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
        $product_name = $Product[0]->product_name;

        $date_deliver = $data["date_deliver_{$k}"];
        $amount = $data["amount_{$k}"];
        $id_supplier = $OrderToSuppliers[0]->id_supplier;

        $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $id_supplier])->toArray();
        $Supplier = $ProductSuppliers[0]->name;

        $arrOrderToSupplier[] = ["id" => $id, "id_order" => $id_order, "product_code" => $product_code, "product_name" => $product_name,
        "date_deliver" => $date_deliver, "amount" => $amount, "Supplier" => $Supplier];
      }
      $this->set('arrOrderToSupplier',$arrOrderToSupplier);

    }

    public function denpyouhenkoupreadd()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function denpyouhenkoulogin()
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
 					 $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
 				 }
 					 $user = $this->Auth->identify();
 				 if ($user) {
 					 $this->Auth->setUser($user);
 					 return $this->redirect(['action' => 'denpyouhenkoudo']);
 				 }
 			 }
    }

    public function denpyouhenkoudo()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
/*
      echo "<pre>";
	    print_r($data);
	    echo "</pre>";
*/
      if ($this->request->is('get')) {
        $OrderToSuppliers = $this->OrderToSuppliers->patchEntity($OrderToSuppliers, $data['orderToSuppliers']);
        $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
           for($k=0; $k<count($data['orderToSuppliers']); $k++){

               if ($this->OrderToSuppliers->updateAll(//検査終了時間の更新
                 ['amount' => $data['orderToSuppliers'][$k]['amount'], 'date_deliver' => $data['orderToSuppliers'][$k]['date_deliver'], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
                 ['id'  => $data['orderToSuppliers'][$k]['id']]
               )){

                 $OrderToSuppliers = $this->OrderToSuppliers->find()->where(['id' => $data['orderToSuppliers'][$k]['id']])->toArray();
                 $id_order = $OrderToSuppliers[0]->id_order;
                 $product_code = $OrderToSuppliers[0]->product_code;

                 //旧DBに単価登録
                 $connection = ConnectionManager::get('sakaeMotoDB');
                 $table = TableRegistry::get('order_to_supplier');
                 $table->setConnection($connection);

                 $updater = "UPDATE order_to_supplier set amount = '".$data['orderToSuppliers'][$k]['amount']."' , date_deliver ='".$data['orderToSuppliers'][$k]['date_deliver']."'
                 , updated_at = '".date('Y-m-d H:i:s')."' , updated_emp_id = '".$staff_id."'
                 where product_id ='".$product_code."' and id_order = '".$id_order."'";
                 $connection->execute($updater);

                 $connection = ConnectionManager::get('default');//新DBに戻る
                 $table->setConnection($connection);

               $mes = "※更新されました";
               $this->set('mes',$mes);
               $connection->commit();// コミット5

             } else {

               $mes = "※更新されませんでした";
               $this->set('mes',$mes);
               $this->Flash->error(__('The product could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

             }

           }

       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

     }


    }

    public function yobizaikopreadd()
    {
      //$this->request->session()->destroy(); // セッションの破棄
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function yobizaikologin()
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
 					 $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
 				 }
 					 $user = $this->Auth->identify();
 				 if ($user) {
 					 $this->Auth->setUser($user);
 					 return $this->redirect(['action' => 'yobizaikoproduct']);
 				 }
 			 }
    }

    public function yobizaikoproduct()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function yobizaikoform()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
      $this->set('staff_id',$staff_id);

      $data = $this->request->getData();

      $staffData = $this->Staffs->find()->where(['id' => $staff_id])->toArray();
      $Staff = $staffData[0]->staff_code." : ".$staffData[0]->f_name." ".$staffData[0]->l_name;
      $this->set('Staff',$Staff);

      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
      $product_name = $Product[0]->product_name;
      $this->set('product_name',$product_name);

      $ProductGaityus = $this->ProductGaityus->find()->where(['product_code' => $product_code])->toArray();
      if(isset($ProductGaityus[0])){
        $id_supplier = $ProductGaityus[0]->id_supplier;
        $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $id_supplier])->toArray();
        $Supplier = $ProductSuppliers[0]->name;
        $this->set('Supplier',$Supplier);
      }else{
        $Supplier = "ProductGaityusテーブルに登録されていません";
        $this->set('Supplier',$Supplier);
        echo "<pre>";
        print_r("ProductGaityusテーブルに登録してから再度登録してください。");
        echo "</pre>";
      }

    }

    public function yobizaikoformtuika()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();

      $staff_id = $data['staff_id'];
      $this->set('staff_id',$staff_id);

      $Staff = $data["Staff"];
      $this->set('Staff',$Staff);

      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);

      $product_name = $data["product_name"];
      $this->set('product_name',$product_name);

      $Supplier = $data["Supplier"];
      $this->set('Supplier',$Supplier);

      if(isset($data['tuika'])){
        $tuika = $data['num'] + 1;
        $this->set('tuika',$tuika);
      }elseif(isset($data['sakujo'])){
        if($data['num'] == 0){
          $tuika = 0;
          $this->set('tuika',$tuika);
        }else{
          $tuika = $data['num'] - 1;
          $this->set('tuika',$tuika);
        }
      }elseif(isset($data['kakunin'])){
        $tuika = $data['num'];
        $this->set('tuika',$tuika);
        return $this->redirect(['action' => 'yobizaikoconfirm',//以下のデータを持ってzensufinishconfirmに移動
        's' => ['data' => $data]]);//登録するデータを全部配列に入れておく
      }

    }

    public function yobizaikoconfirm()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $Data = $this->request->query('s');
      $data = $Data['data'];//postデータ取得し、$dataと名前を付ける

      $this->set('data',$data);
      $tuika = $data['num'];
      $this->set('tuika',$tuika);
      $Staff = $data['Staff'];
      $this->set('Staff',$Staff);
      $staff_id = $data['staff_id'];
      $this->set('staff_id',$staff_id);
      $Supplier = $data['Supplier'];
      $this->set('Supplier',$Supplier);
      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);
      $product_name = $data["product_name"];
      $this->set('product_name',$product_name);
/*
      echo "<pre>";
	    print_r($data);
	    echo "</pre>";
*/
      for ($k=0; $k<=$data["num"]; $k++){
        $date_deliver = $data["date_deliver{$k}"]['year']."-".$data["date_deliver{$k}"]['month']."-".$data["date_deliver{$k}"]['day'];
        $amount = $data["amount{$k}"];

        $ProductGaityus = $this->ProductGaityus->find()->where(['product_code' => $product_code])->toArray();
        $id_supplier = $ProductGaityus[0]->id_supplier;

        $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $id_supplier])->toArray();
        $Supplier = $ProductSuppliers[0]->name;

        $ProductGaityu = $this->ProductGaityus->find()->where(['product_code' => $product_code])->toArray();
        $price = $ProductGaityu[0]->price_shiire;

        $k1 = $k+1;
        $arrOrderToSupplier[] = ["num_order" => $k1, "product_code" => $product_code, "price" => $price,
        "id_supplier" => $id_supplier, "date_deliver" => $date_deliver, "amount" => $amount, "date_order" => date('Y-m-d'),
        "first_date_deliver" => $date_deliver, "first_amount" => $amount,
        "kanou_flag" => 0, "delete_flag" => 0, "created_staff" => $staff_id, "created_at" => date('Y-m-d H:i:s')];
      }
      $this->set('arrOrderToSupplier',$arrOrderToSupplier);

      //$this->request->session()->destroy(); // セッションの破棄
      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['orderyobistock'] = array();
      $_SESSION['orderyobistock'] = $arrOrderToSupplier;
/*
      echo "<pre>";
	    print_r($_SESSION['orderToSuppliers']);
	    echo "</pre>";
*/
    }

    public function yobizaikodo()
    {
      $OrderYobistockSuppliers = $this->OrderYobistockSuppliers->newEntity();
      $this->set('OrderYobistockSuppliers',$OrderYobistockSuppliers);

      $session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

        $OrderYobistockSuppliers = $this->OrderYobistockSuppliers->patchEntities($OrderYobistockSuppliers, $data['orderyobistock']);
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
            if ($this->OrderYobistockSuppliers->saveMany($OrderYobistockSuppliers)) {//saveManyで一括登録

              //旧DBに単価登録
              $connection = ConnectionManager::get('sakaeMotoDB');
              $table = TableRegistry::get('order_yobistock_suppliers');
              $table->setConnection($connection);

              for($k=0; $k<count($data['orderyobistock']); $k++){
                $connection->insert('order_yobistock_suppliers', [
                    'product_id' => $data['orderyobistock'][$k]["product_code"],
                    'num_order' => $data['orderyobistock'][$k]["num_order"],
                    'price' => $data['orderyobistock'][$k]["price"],
                    'first_date_deliver' => $data['orderyobistock'][$k]["date_deliver"],
                    'date_deliver' => $data['orderyobistock'][$k]["date_deliver"],
                    'first_amount' => $data['orderyobistock'][$k]["amount"],
                    'amount' => $data['orderyobistock'][$k]["amount"],
                    'supplier_id' => $data['orderyobistock'][$k]["id_supplier"],
                    'date_order' => $data['orderyobistock'][$k]["date_order"],
                    'kanou_flag' => $data['orderyobistock'][$k]["kanou_flag"],
                    'delete_flag' => $data['orderyobistock'][$k]["delete_flag"],
                    'created_emp_id' => $data['orderyobistock'][$k]["created_staff"],
                    'created_at' => $data['orderyobistock'][$k]["created_at"]
                ]);
              }

              $connection = ConnectionManager::get('default');//新DBに戻る
              $table->setConnection($connection);

              $mes = "※登録されました";
              $this->set('mes',$mes);
              $connection->commit();// コミット5

             } else {

               $mes = "※登録されませんでした";
               $this->set('mes',$mes);
               $this->Flash->error(__('The product could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

             }

       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

    }

    public function yobidenpyouhenkoukensaku()
    {
      $OrderYobistockSuppliers = $this->OrderYobistockSuppliers->newEntity();
      $this->set('OrderYobistockSuppliers',$OrderYobistockSuppliers);
    }

    public function yobidenpyouhenkouichiran()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();

      $date_sta = $data['date_sta']['year']."-".$data['date_sta']['month']."-".$data['date_sta']['day'];
      $date_fin = $data['date_fin']['year']."-".$data['date_fin']['month']."-".$data['date_fin']['day'];
      $product_code = $data['product_code'];

      if(empty($product_code)){//product_codeの入力がないとき
        $product_code = "no";

        $OrderToSuppliers = $this->OrderYobistockSuppliers->find()
          ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin])->toArray();
        $this->set('OrderToSuppliers',$OrderToSuppliers);

      }else{//product_codeの入力があるとき
          $OrderToSuppliers = $this->OrderYobistockSuppliers->find()
          ->where(['delete_flag' => '0', 'date_deliver >=' => $date_sta, 'date_deliver <=' => $date_fin, 'product_code' => $product_code])->toArray();//対象の製品を絞り込む
            $this->set('OrderToSuppliers',$OrderToSuppliers);

      }

    }

    public function yobidenpyouhenkouform()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();

      $array = array();
      $checknum = 0;
      for ($k=1; $k<=$data["nummax"]; $k++){
        if(isset($data["subete"])){
          $array[] = $data["$k"];
        }elseif(isset($data["check".$k])){//checkがついているもののidをキープ
          $array[] = $data["$k"];
          $checknum = $checknum + 1;
        }else{
        }
      }

      $count = count($array);
      $this->set('count',$count);

      $arrOrderToSupplier = array();
      for ($k=0; $k<$count; $k++){
        $OrderToSuppliers = $this->OrderYobistockSuppliers->find()->where(['id' => $array[$k]])->toArray();
        $id = $OrderToSuppliers[0]->id;
        $id_order = $OrderToSuppliers[0]->id_order;
        $product_code = $OrderToSuppliers[0]->product_code;

        $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
        $product_name = $Product[0]->product_name;

        $date_deliver = $OrderToSuppliers[0]->date_deliver;
        $amount = $OrderToSuppliers[0]->amount;
        $id_supplier = $OrderToSuppliers[0]->id_supplier;

        $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $id_supplier])->toArray();
        $Supplier = $ProductSuppliers[0]->name;

        $arrOrderToSupplier[] = ["id" => $id, "product_code" => $product_code, "product_name" => $product_name,
        "date_deliver" => $date_deliver, "amount" => $amount, "Supplier" => $Supplier];
      }

      $this->set('arrOrderToSupplier',$arrOrderToSupplier);

    }

    public function yobidenpyouhenkouconfirm()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);

      $data = $this->request->getData();

      if(!isset($_SESSION)){//sessionsyuuseituika
      session_start();
      }
      $_SESSION['OrderYobistockSuppliers'] = array();

      for($k=0; $k<$data["num"]; $k++){
        $_SESSION['OrderYobistockSuppliers'][$k] = array(
          'id' => $data["id{$k}"],
          'amount' => $data["amount_{$k}"],
          'date_deliver' => $data["date_deliver_{$k}"]
        );
      }
      $this->set('count',$data["num"]);
/*
      echo "<pre>";
      print_r($_SESSION);
      echo "</pre>";
*/
      for ($k=0; $k<$data["num"]; $k++){
        $OrderToSuppliers = $this->OrderYobistockSuppliers->find()->where(['id' => $data["id{$k}"]])->toArray();
        $id = $OrderToSuppliers[0]->id;
        $id_order = $OrderToSuppliers[0]->id_order;
        $product_code = $OrderToSuppliers[0]->product_code;

        $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();
        $product_name = $Product[0]->product_name;

        $date_deliver = $data["date_deliver_{$k}"];
        $amount = $data["amount_{$k}"];
        $id_supplier = $OrderToSuppliers[0]->id_supplier;

        $ProductSuppliers = $this->ProductSuppliers->find()->where(['id' => $id_supplier])->toArray();
        $Supplier = $ProductSuppliers[0]->name;

        $arrOrderToSupplier[] = ["id" => $id, "product_code" => $product_code, "product_name" => $product_name,
        "date_deliver" => $date_deliver, "amount" => $amount, "Supplier" => $Supplier];
      }
      $this->set('arrOrderToSupplier',$arrOrderToSupplier);

    }

    public function yobidenpyouhenkoupreadd()
    {
      $OrderToSuppliers = $this->OrderToSuppliers->newEntity();
      $this->set('OrderToSuppliers',$OrderToSuppliers);
    }

    public function yobidenpyouhenkoulogin()
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
 					 $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
 				 }
 					 $user = $this->Auth->identify();
 				 if ($user) {
 					 $this->Auth->setUser($user);
 					 return $this->redirect(['action' => 'yobidenpyouhenkoudo']);
 				 }
 			 }
    }

    public function yobidenpyouhenkoudo()
    {
      $OrderYobistockSuppliers = $this->OrderYobistockSuppliers->newEntity();
      $this->set('OrderYobistockSuppliers',$OrderYobistockSuppliers);

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
/*
      echo "<pre>";
	    print_r($data);
	    echo "</pre>";
*/
      if ($this->request->is('get')) {
        $OrderYobistockSuppliers = $this->OrderYobistockSuppliers->patchEntity($OrderYobistockSuppliers, $data['OrderYobistockSuppliers']);
        $connection = ConnectionManager::get('default');//トランザクション1
         // トランザクション開始2
         $connection->begin();//トランザクション3
         try {//トランザクション4
           for($k=0; $k<count($data['OrderYobistockSuppliers']); $k++){

               if ($this->OrderYobistockSuppliers->updateAll(//検査終了時間の更新
                 ['amount' => $data['OrderYobistockSuppliers'][$k]['amount'], 'date_deliver' => $data['OrderYobistockSuppliers'][$k]['date_deliver'], 'updated_at' => date('Y-m-d H:i:s'), 'updated_staff' => $staff_id],
                 ['id'  => $data['OrderYobistockSuppliers'][$k]['id']]
               )){

                 $OrderToSuppliers = $this->OrderYobistockSuppliers->find()->where(['id' => $data['OrderYobistockSuppliers'][$k]['id']])->toArray();
                 $date_order = $OrderToSuppliers[0]->date_order;
                 $product_code = $OrderToSuppliers[0]->product_code;

                 //旧DBに単価登録
                 $connection = ConnectionManager::get('sakaeMotoDB');
                 $table = TableRegistry::get('order_yobistock_suppliers');
                 $table->setConnection($connection);

                 $updater = "UPDATE order_yobistock_suppliers set amount = '".$data['OrderYobistockSuppliers'][$k]['amount']."' , date_deliver ='".$data['OrderYobistockSuppliers'][$k]['date_deliver']."'
                 , updated_at = '".date('Y-m-d H:i:s')."' , updated_emp_id = '".$staff_id."'
                 where product_id ='".$product_code."' and date_order = '".$date_order."'";
                 $connection->execute($updater);

                 $connection = ConnectionManager::get('default');//新DBに戻る
                 $table->setConnection($connection);

               $mes = "※更新されました";
               $this->set('mes',$mes);
               $connection->commit();// コミット5

             } else {

               $mes = "※更新されませんでした";
               $this->set('mes',$mes);
               $this->Flash->error(__('The product could not be saved. Please, try again.'));
               throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6

             }

           }

       } catch (Exception $e) {//トランザクション7
       //ロールバック8
         $connection->rollback();//トランザクション9
       }//トランザクション10

     }

    }

}
