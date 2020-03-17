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
/*
      $data = $this->request->getData();
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
      file_put_contents($source_file, mb_convert_encoding(file_get_contents($source_file), 'UTF-8', 'SJIS'));//SJISのファイルをUTF-8に変換する
      $fp1 = fopen($source_file, 'r');//OrderEdisへ登録用
      $fp2 = fopen($source_file, 'r');//DenpyouDnpMinoukannousへ登録用
      $fp3 = fopen($source_file, 'r');//DnpTotalAmountsへ登録用
      $fpcount = fopen($source_file, 'r' );

      for($count = 0; fgets( $fpcount ); $count++ );
      $arrEDI = array();//空の配列を作る
      $arrDenpyouDnpMinoukannous = array();//空の配列を作る
      $arrDnpTotalAmounts = array();//空の配列を作る
      $arrDnpdouitutyuumon = array();//空の配列を作る
      $created_staff = $this->Auth->user('staff_id');

//      $num = 1;//$numを定義する

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
            //ここからDenpyouDnpMinoukannousへ登録用

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
            $denpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntities($denpyouDnpMinoukannous, $arrDenpyouDnpMinoukannous);//patchEntitiesで一括登録
            if ($this->DenpyouDnpMinoukannous->saveMany($denpyouDnpMinoukannous)) {//saveManyで一括登録//ここからDnpTotalAmountsへ登録用

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
                      ['minoukannou' => 0],//これ以降の納期の注文があるため、'minoukannou' => 0にする
                      ['id'  => $DenpyouDnpMinoukannouId]
                      );

                      $this->OrderEdis->updateAll(
                      ['bunnou' => $m],//bunnouを納期順に1,2,3...とうまく更新していく
                      ['id'   => $uniquearrDnpdouitutyuumon[$n][$m-1]['id']]
                      );

                      $this->OrderEdis->updateAll(
                      ['bunnou' => $m+1],//bunnouを納期順に1,2,3...とうまく更新していく
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

              //以下、DnpTotalAmountsにもどる
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

            $i_num = $i;//既に分納されている場合、いくつに分納されているかを$i_numとしてキープ
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
//      $data = $this->request->getData();
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
//      $data = $this->request->getData();
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

//      $session = $this->request->getSession();
//      $data = $session->read();
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


    public function henkou3other()
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
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
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
/*
      echo "<pre>";
      print_r($Data);
      echo "</pre>";
*/
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
/*
            echo "<pre>";
            print_r(${"bunnou".$i});
            echo "</pre>";
*/
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
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
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

}
