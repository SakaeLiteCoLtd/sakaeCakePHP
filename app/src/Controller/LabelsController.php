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
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->Customers = TableRegistry::get('customers');//customersテーブルを使う
       $this->Konpous = TableRegistry::get('konpous');
       $this->LabelElementPlaces = TableRegistry::get('labelElementPlaces');
       $this->LabelElementUnits = TableRegistry::get('labelElementUnits');
       $this->LabelInsideouts = TableRegistry::get('labelInsideouts');
       $this->LabelNashies = TableRegistry::get('labelNashies');
       $this->LabelSetikkatsues = TableRegistry::get('labelSetikkatsues');
       $this->LabelTypeProducts = TableRegistry::get('labelTypeProducts');
       $this->LabelTypes = TableRegistry::get('labelTypes');
       $this->Products = TableRegistry::get('products');//productsテーブルを使う
       $this->CheckLots = TableRegistry::get('checkLots');
     }
     public function indexmenu()
     {
       $this->request->session()->destroy(); // セッションの破棄
     }
     public function index0()
     {
       $this->request->session()->destroy(); // セッションの破棄
     }
     public function index1()
     {
       $this->request->session()->destroy(); // セッションの破棄
     }
     public function index2()
     {
       $this->request->session()->destroy(); // セッションの破棄
     }
   public function confirmcsv()
  {
/*    $fp = fopen("label_element_place.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("label_element_place.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=$count-1; $k++) {//最後の行まで
    //  for ($k=1; $k<=1; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
      $keys[array_search('0',$keys)]='place_code';//名前の変更
      $keys[array_search('1',$keys)]='place1';
      $keys[array_search('2',$keys)]='place2';
      $keys[array_search('3',$keys)]='genjyou';
      $keys[array_search('4',$keys)]='delete_flag';
      $keys[array_search('5',$keys)]='created_staff';
      $sample = array_combine( $keys, $sample );
    //  unset($sample['0']);//削除
      unset($sample['6']);//削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $labelElementPlaces = $this->LabelElementPlaces->newEntity();
    $this->set('labelElementPlaces',$labelElementPlaces);
  	if ($this->request->is('get')) {
  		$labelElementPlaces = $this->LabelElementPlaces->patchEntities($labelElementPlaces, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->LabelElementPlaces->saveMany($labelElementPlaces)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
/*    $fp = fopen("label_insideout.csv", "r");//csvファイルはwebrootに入れる
      $this->set('fp',$fp);
      $fpcount = fopen("label_insideout.csv", 'r' );
      for( $count = 0; fgets( $fpcount ); $count++ );
      $this->set('count',$count);
      $arrFp = array();//空の配列を作る
      $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
      for ($k=1; $k<=$count-1; $k++) {//最後の行まで
      //  for ($k=1; $k<=1; $k++) {//最後の行まで
        $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
        $sample = explode(',',$line);//$lineを","毎に配列に入れる
        $keys=array_keys($sample);
        $keys[array_search('0',$keys)]='product_code';//名前の変更
        $keys[array_search('1',$keys)]='num_inside';
        $keys[array_search('2',$keys)]='delete_flag';
        $keys[array_search('3',$keys)]='created_staff';
        $sample = array_combine( $keys, $sample );
      //  unset($sample['0']);//削除
        unset($sample['4']);//最後の改行を削除
        $arrFp[] = $sample;//配列に追加する
      }
      $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
      echo "<pre>";
      print_r($arrFp);
      echo "<br>";
      $labelInsideouts = $this->LabelInsideouts->newEntity();
      $this->set('labelInsideouts',$labelInsideouts);
      if ($this->request->is('get')) {
        $labelInsideouts = $this->LabelInsideouts->patchEntities($labelInsideouts, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
            if ($this->LabelInsideouts->saveMany($labelInsideouts)) {//saveManyで一括登録
              $connection->commit();// コミット5
            } else {
              $this->Flash->error(__('The Products could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10
      }
      */
/*    $fp = fopen("label_nashi.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("label_nashi.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=$count-1; $k++) {//最後の行まで
    //  for ($k=1; $k<=1; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
      $keys[array_search('0',$keys)]='product_code';//名前の変更
      $keys[array_search('1',$keys)]='tourokubi';
      $keys[array_search('2',$keys)]='delete_flag';
      $keys[array_search('3',$keys)]='created_staff';
      $sample = array_combine( $keys, $sample );
    //  unset($sample['0']);//削除
      unset($sample['4']);//最後の改行を削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $labelNashies = $this->LabelNashies->newEntity();
    $this->set('labelNashies',$labelNashies);
  	if ($this->request->is('get')) {
  		$labelNashies = $this->LabelNashies->patchEntities($labelNashies, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->LabelNashies->saveMany($labelNashies)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
/*    $fp = fopen("label_setikkatsu.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("label_setikkatsu.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=$count-1; $k++) {//最後の行まで
    //  for ($k=1; $k<=1; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
      $keys[array_search('0',$keys)]='product_id1';//名前の変更
      $keys[array_search('1',$keys)]='product_id2';//名前の変更
      $keys[array_search('2',$keys)]='tourokubi';
      $keys[array_search('3',$keys)]='delete_flag';
      $keys[array_search('4',$keys)]='created_staff';
      $sample = array_combine( $keys, $sample );
    //  unset($sample['0']);//削除
      unset($sample['5']);//最後の改行を削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
    $this->set('labelSetikkatsues',$labelSetikkatsues);
  	if ($this->request->is('get')) {
  		$labelSetikkatsues = $this->LabelSetikkatsues->patchEntities($labelSetikkatsues, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->LabelSetikkatsues->saveMany($labelSetikkatsues)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
/*    $fp = fopen("label_type_product.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("label_type_product.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=$count-1; $k++) {//最後の行まで
    //  for ($k=1; $k<=1; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
      $keys[array_search('0',$keys)]='product_code';//名前の変更
      $keys[array_search('1',$keys)]='type';//名前の変更
      $keys[array_search('2',$keys)]='place_code';
      $keys[array_search('3',$keys)]='unit';
      $keys[array_search('4',$keys)]='delete_flag';
      $keys[array_search('5',$keys)]='created_staff';
      $sample = array_combine( $keys, $sample );
    //  unset($sample['0']);//削除
      unset($sample['6']);//最後の改行を削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $labelTypeProducts = $this->LabelTypeProducts->newEntity();
    $this->set('labelTypeProducts',$labelTypeProducts);
  	if ($this->request->is('get')) {
  		$labelTypeProducts = $this->LabelTypeProducts->patchEntities($labelTypeProducts, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->LabelTypeProducts->saveMany($labelTypeProducts)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
/*    $fp = fopen("191106product.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("191106product.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=$count-1; $k++) {//最後の行まで
    //  for ($k=1; $k<=1; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
  		$keys[array_search('0',$keys)]='product_code';//名前の変更
  		$keys[array_search('1',$keys)]='product_name';
  		$keys[array_search('2',$keys)]='weight';
  		$keys[array_search('4',$keys)]='customer_id';
  		$keys[array_search('9',$keys)]='torisu';
  		$keys[array_search('10',$keys)]='cycle';
  		$keys[array_search('12',$keys)]='primary_p';
  		$keys[array_search('13',$keys)]='gaityu';
      $keys[array_search('16',$keys)]='status';
      $keys[array_search('17',$keys)]='delete_flag';
      $keys[array_search('18',$keys)]='created_staff';
  		$sample = array_combine($keys, $sample );
  		$Customer = $this->Customers->find()->where(['customer_code' => $sample['customer_id']])->toArray();//'customer_code' => $sample['customer_id']となるデータをCustomersテーブルから配列で取得
  		$customer_id = $Customer[0]->id;//配列の0番目（0番目しかない）のidに$customer_idと名前を付ける
  		$replacements = array('customer_id' => $customer_id);//配列のデータの置き換え（customer_idを$customer_idに変更）
  		$sample = array_replace($sample, $replacements);//配列のデータの置き換え（customer_idを$customer_idに変更）
  		unset($sample['3']);//削除
  		unset($sample['5']);//削除
  		unset($sample['6']);//削除
  		unset($sample['7']);//削除
  		unset($sample['8']);//削除
  		unset($sample['11']);//削除
  		unset($sample['14']);//削除
      unset($sample['15']);//削除
      unset($sample['19']);//削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $products = $this->Products->newEntity();
    $this->set('products',$products);
  	if ($this->request->is('get')) {
  		$products = $this->Products->patchEntities($products, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->Products->saveMany($products)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
/*    $fp = fopen("191106konpou.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("191106konpou.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=$count-1; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
  		$keys[array_search('0',$keys)]='product_code';//名前の変更
  		$keys[array_search('1',$keys)]='irisu';
  		$keys[array_search('2',$keys)]='id_box';
      $keys[array_search('3',$keys)]='delete_flag';
      $keys[array_search('4',$keys)]='created_staff';
  		$sample = array_combine($keys, $sample );
  		unset($sample['5']);//削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $konpous = $this->Konpous->newEntity();
    $this->set('konpous',$konpous);
  	if ($this->request->is('get')) {
  		$konpous = $this->Konpous->patchEntities($konpous, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->Konpous->saveMany($konpous)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
/*    $fp = fopen("191106schedule_koutei.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
    $fpcount = fopen("191106schedule_koutei.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
    $this->set('count',$count);
    $arrFp = array();//空の配列を作る
  	$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
    for ($k=1; $k<=757; $k++) {//最後の行まで
      $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
      $sample = explode(',',$line);//$lineを","毎に配列に入れる
      $keys=array_keys($sample);
  		$keys[array_search('0',$keys)]='datetime';//名前の変更
  		$keys[array_search('1',$keys)]='seikeiki';
  		$keys[array_search('2',$keys)]='product_code';
      $keys[array_search('3',$keys)]='present_kensahyou';
      $keys[array_search('4',$keys)]='product_name';
      $keys[array_search('5',$keys)]='tantou';
      $keys[array_search('6',$keys)]='delete_flag';
      $keys[array_search('7',$keys)]='created_staff';
  		$sample = array_combine($keys, $sample );
  		unset($sample['8']);//削除
      $arrFp[] = $sample;//配列に追加する
    }
    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
    echo "<pre>";
    print_r($arrFp);
    echo "<br>";
    $scheduleKouteis = $this->ScheduleKouteis->newEntity();
    $this->set('scheduleKouteis',$scheduleKouteis);
  	if ($this->request->is('get')) {
  		$scheduleKouteis = $this->ScheduleKouteis->patchEntities($scheduleKouteis, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
  		$connection = ConnectionManager::get('default');//トランザクション1
  		// トランザクション開始2
  		$connection->begin();//トランザクション3
  		try {//トランザクション4
  				if ($this->ScheduleKouteis->saveMany($scheduleKouteis)) {//saveManyで一括登録
  					$connection->commit();// コミット5
  				} else {
  					$this->Flash->error(__('The Products could not be saved. Please, try again.'));
  					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
  				}
  		} catch (Exception $e) {//トランザクション7
  		//ロールバック8
  			$connection->rollback();//トランザクション9
  		}//トランザクション10
  	}
*/
  }
   public function layoutform1()//レイアウト入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
      $arrLabelTypes = $this->LabelTypes->find('all', ['conditions' => ['delete_flag' => '0']])->order(['type_id' => 'ASC']);
     	$arrLabelType = array();//配列の初期化
     	foreach ($arrLabelTypes as $value) {
     		$arrLabelType[] = array($value->type_id=>$value->type_id);
     	}
     	$this->set('arrLabelType',$arrLabelType);
   }
   public function layoutform2()//レイアウト入力
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
     $arrLabelElementUnits = $this->LabelElementUnits->find('all', ['conditions' => ['delete_flag' => '0']])->order(['unit' => 'ASC']);
     $arrLabelElementUnit = array();//配列の初期化
     foreach ($arrLabelElementUnits as $value) {
       $arrLabelElementUnit[] = array($value->unit=>$value->unit);
     }
     $this->set('arrLabelElementUnit',$arrLabelElementUnit);
     $arrLabelElementPlaces = $this->LabelElementPlaces->find('all', ['conditions' => ['delete_flag' => '0']])->order(['place1' => 'ASC']);
     $arrLabelElementPlace = array();//配列の初期化
     foreach ($arrLabelElementPlaces as $value) {
       $arrLabelElementPlace[] = array($value->place_code=>$value->place1." ".$value->place2);
     }
     $this->set('arrLabelElementPlace',$arrLabelElementPlace);
   }
   public function layoutconfirm()//レイアウト確認
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
   }
   public function layoutpreadd()//レイアウトログイン
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
/*
     $session = $this->request->getSession();
     $data = $session->read();
     echo "<pre>";
     print_r($_SESSION['labellayouts']);
     echo "</pre>";
*/
   }
   public function layoutlogin()//レイアウトログイン
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
           return $this->redirect(['action' => 'layoutdo']);
         }
       }
   }
   public function layoutdo()//レイアウト登録
   {
     $labelTypeProducts = $this->LabelTypeProducts->newEntity();
     $this->set('labelTypeProducts',$labelTypeProducts);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labellayouts'] = array_merge($created_staff,$_SESSION['labellayouts']);
/*
     echo "<pre>";
     print_r($_SESSION['labellayouts']);
     echo "</pre>";
*/
     $created_staff = $_SESSION['labellayouts']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelTypeProducts = $this->LabelTypeProducts->patchEntity($labelTypeProducts, $_SESSION['labellayouts']);//$productデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelTypeProducts->save($labelTypeProducts)) {
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
   public function placeform()//納品場所入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
   }
   public function placeconfirm()//納品場所確認
   {
     $PlaceData = $this->LabelElementPlaces->find()->where(['delete_flag' => '0'])->toArray();
     $arrPlaceData = array();//配列の初期化
     foreach ($PlaceData as $value) {
       $arrPlaceData[] = array($value->place_code=>$value->place_code);
     }
     $place_code = max(array_keys($arrPlaceData)) + 2;
     $this->set('place_code',$place_code);
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
   }
   public function placepreadd()//納品場所ログイン
   {
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
     $session = $this->request->getSession();
     $data = $session->read();
/*
     echo "<pre>";
     print_r($_SESSION['labelplaces']);
     echo "</pre>";
*/
   }
   public function placelogin()//納品場所ログイン
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
           return $this->redirect(['action' => 'placedo']);
         }
       }
   }
   public function placedo()//納品場所登録
   {
     $labelElementPlaces = $this->LabelElementPlaces->newEntity();
     $this->set('labelElementPlaces',$labelElementPlaces);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelplaces'] = array_merge($created_staff,$_SESSION['labelplaces']);
     $created_staff = $_SESSION['labelplaces']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelElementPlace = $this->LabelElementPlaces->patchEntity($labelElementPlaces, $_SESSION['labelplaces']);//$productデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelElementPlaces->save($labelElementPlaces)) {
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
   public function nashiform()//ラベル無し入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
   }
   public function nashiconfirm()//セット取り確認
   {
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
   }
   public function nashipreadd()//ラベル無しログイン
   {
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
   }
   public function nashilogin()//ラベル無しログイン
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
           return $this->redirect(['action' => 'nashido']);
         }
       }
   }
   public function nashido()//ラベル無し登録
   {
     $labelNashies = $this->LabelNashies->newEntity();
     $this->set('labelNashies',$labelNashies);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelnashis'] = array_merge($created_staff,$_SESSION['labelnashis']);
     $created_staff = $_SESSION['labelnashis']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelNashie = $this->LabelNashies->patchEntity($labelNashies, $_SESSION['labelnashis']);
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelNashies->save($labelNashies)) {
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
   public function setikkatsuform()//セット取り入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
   }
   public function setikkatsuconfirm()//セット取り確認
   {
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
   }
   public function setikkatsupreadd()//セット取りログイン
   {
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
   }
   public function setikkatsulogin()//セット取りログイン
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
           return $this->redirect(['action' => 'setikkatsudo']);
         }
       }
   }
   public function setikkatsudo()//セット取り登録
   {
     $labelSetikkatsues = $this->LabelSetikkatsues->newEntity();
     $this->set('labelSetikkatsues',$labelSetikkatsues);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelsetikkatsus'] = array_merge($created_staff,$_SESSION['labelsetikkatsus']);
     $created_staff = $_SESSION['labelsetikkatsus']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelSetikkatsue = $this->LabelSetikkatsues->patchEntity($labelSetikkatsues, $_SESSION['labelsetikkatsus']);
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelSetikkatsues->save($labelSetikkatsues)) {
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
   public function insideoutform()//外箱中身入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
   }
   public function insideoutconfirm()//外箱中身確認
   {
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
   }
   public function insideoutpreadd()//外箱中身ログイン
   {
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
   }
   public function insideoutlogin()//外箱中身ログイン
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
           return $this->redirect(['action' => 'insideoutdo']);
         }
       }
   }
   public function insideoutdo()//外箱中身登録
   {
     $labelInsideouts = $this->LabelInsideouts->newEntity();
     $this->set('labelInsideouts',$labelInsideouts);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelinsideouts'] = array_merge($created_staff,$_SESSION['labelinsideouts']);
     $created_staff = $_SESSION['labelinsideouts']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelInsideout = $this->LabelInsideouts->patchEntity($labelInsideouts, $_SESSION['labelinsideouts']);
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelInsideouts->save($labelInsideouts)) {
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
   public function unitform()//数量単位入力
   {
     $this->request->session()->destroy(); // セッションの破棄
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }
   public function unitconfirm()//数量単位確認
   {
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }
   public function unitpreadd()//数量単位ログイン
   {
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
   }
   public function unitlogin()//数量単位ログイン
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
           return $this->redirect(['action' => 'unitdo']);
         }
       }
   }
   public function unitdo()//数量単位登録
   {
     $labelElementUnits = $this->LabelElementUnits->newEntity();
     $this->set('labelElementUnits',$labelElementUnits);
     $session = $this->request->getSession();
     $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
     $_SESSION['labelunits'] = array_merge($created_staff,$_SESSION['labelunits']);
     $created_staff = $_SESSION['labelunits']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
     $Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
     $CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
     $this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット
     if ($this->request->is('get')) {
       $labelElementUnit = $this->LabelElementUnits->patchEntity($labelElementUnits, $_SESSION['labelunits']);//$productデータ（空の行）を$this->request->getData()に更新する
       $connection = ConnectionManager::get('default');//トランザクション1
       // トランザクション開始2
       $connection->begin();//トランザクション3
       try {//トランザクション4
         if ($this->LabelElementUnits->save($labelElementUnits)) {
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
   public function preform()//ラベル発行
   {
     $this->request->session()->destroy(); // セッションの破棄
     $scheduleKouteis = $this->ScheduleKouteis->newEntity();
     $this->set('scheduleKouteis',$scheduleKouteis);
   }
   public function form()//ラベル発行
   {
     session_start();
     $KadouSeikeis = $this->KadouSeikeis->newEntity();
     $this->set('KadouSeikeis',$KadouSeikeis);
     $data = $this->request->getData();//postデータを$dataに
/*
     echo "<pre>";
     print_r($data);
     echo "</pre>";
*/
      if(isset($data['touroku'])){//csv確認おしたとき
        $this->set('touroku',$data['touroku']);
        $session = $this->request->getSession();
/*        echo "<pre>";
        print_r($_SESSION['labeljunbi'][$data['m']]);
        echo "</pre>";
*/
        $dateYMDs = $data['dateYMDs'];
        $dateYMDf = $data['dateYMDf'];
        $this->set('dateYMDs',$dateYMDs);
        $this->set('dateYMDf',$dateYMDf);
        $arrCsv = array();
        for($i=1; $i<=$data['m']; $i++){
          $date = date('Y/m/d H:i:s');
          $datetimeymd = substr($date,0,10);
          $datetimehm = substr($date,11,5);
          $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
          $Product = $this->Products->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($Product[0])){
            $costomerId = $Product[0]->customer_id;
          }else{
            $costomerId = "";
          }
          $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($Konpou[0])){
            $irisu = $Konpou[0]->irisu;
          }else{
            $irisu = "";
          }
          $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
          if(isset($Customer[0])){
            $costomerName = $Customer[0]->name;
          }else{
            $costomerName = "";
          }
/*          if(mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ"){//mb_substrだと文字化けしない
            $Layout = "B";
          }else{
            $Layout = "A";
          }
*/
          $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
          if(isset($LabelTypeProduct[0])){
            $Layout = $LabelTypeProduct[0]->type;
          }else{
            $Layout = "-";
          }
          $arrCsv[] = ['date' => $datetimeymd, 'datetime' => $datetimehm, 'layout' => '現品札_'.$Layout.'.mllay', 'maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'],
           'lotnum' => $lotnum, 'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'],
           'irisu' => $irisu];
           //date…出力した日付、datetime…出力した時間、layout…レイアウト、maisu…予定枚数、lotnum…lotnum、renban…連番、product_code…product_code、irisu…irisu
           $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
           if(isset($Customer[0])){
             $costomerName = $Customer[0]->name;
/*             echo "<pre>";
             print_r(mb_substr($costomerName, 0, 6));
             echo "</pre>";
*/
           }else{
             $costomerName = "";
           }
           if(mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ"){//mb_substrだと文字化けしない
             $lotnumIN = "IN.".$lotnum;
             $Layout = "B";
             $arrCsv[] = ['date' => $datetimeymd, 'datetime' => $datetimehm, 'layout' => '現品札_'.$Layout.'.mllay', 'maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'],
              'lotnum' => $lotnumIN, 'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'],
              'irisu' => $irisu];
           }
        }
        $fp = fopen('labels/labeljunbi.csv', 'w');
        foreach ($arrCsv as $line) {
        	fputcsv($fp, $line);
        }
          fclose($fp);
      }elseif(isset($data['confirm'])){//確認おしたとき
       $this->set('confirm',$data['confirm']);
       $dateYMDs = $data['dateYMDs'];
       $dateYMDf = $data['dateYMDf'];
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
/*
        echo "<pre>";
        print_r($data);
        echo "</pre>";
*/
     }elseif(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
       $data = $this->request->getData();//postデータを$dataに
       $dateYMDs = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 00:00";
       $dateYMDf = $data['manu_date']['year']."-".$data['manu_date']['month']."-".$data['manu_date']['day']." 23:59";
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
       for($i=1; $i<=9; $i++){
        ${"tuika".$i} = 0;
        $this->set('tuika'.$i,${"tuika".$i});//セット
       }
       for($i=1; $i<=9; $i++){
        ${"ntuika".$i} = 0;
        $this->set('ntuika'.$i,${"ntuika".$i});//セット
       }
     }else{
       $dateYMDs = $data['dateYMDs'];
       $dateYMDf = $data['dateYMDf'];
       $this->set('dateYMDs',$dateYMDs);
       $this->set('dateYMDf',$dateYMDf);
       for($i=1; $i<=9; $i++){
         ${"tuika".$i} = $data["tuika".$i];
         $this->set('tuika'.$i,${"tuika".$i});//セット
       }
       for($i=1; $i<=9; $i++){
         if(isset($data["ntuika".$i])) {
             ${"ntuika".$i} = $data["ntuika".$i];
             $this->set('ntuika'.$i,${"ntuika".$i});//セット
        }
      }
     }
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
          foreach ((array)${"arrP".$j} as $key => $value) {//datetimeで並び替え
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
     public function kobetupreform()//個別ラベル発行
     {
       $this->request->session()->destroy(); // セッションの破棄
       $scheduleKouteis = $this->ScheduleKouteis->newEntity();
       $this->set('scheduleKouteis',$scheduleKouteis);
     }
     public function kobetuform()//個別ラベル発行
     {
       session_start();
       $KadouSeikeis = $this->KadouSeikeis->newEntity();
       $this->set('KadouSeikeis',$KadouSeikeis);
       $data = $this->request->getData();//postデータを$dataに
        if(isset($data['touroku'])){//csv確認おしたとき
          $this->set('touroku',$data['touroku']);
          $session = $this->request->getSession();
          $arrCsv = array();
          for($i=1; $i<=$data['m']; $i++){
            $date = date('Y/m/d H:i:s');
            $datetimeymd = substr($date,0,10);
            $datetimehm = substr($date,11,5);
            $lotnum = substr($date,2,2).substr($date,5,2).substr($date,8,2);
            $Product = $this->Products->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($Product[0])){
              $costomerId = $Product[0]->customer_id;
              $product_name = $Product[0]->product_name;
            }else{
              $costomerId = "";
            }
            $Konpou = $this->Konpous->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($Konpou[0])){
              $irisu = $Konpou[0]->irisu;
            }else{
              $irisu = "";
            }
            $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
            if(isset($Customer[0])){
              $costomerName = $Customer[0]->name;
            }else{
              $costomerName = "";
            }
            $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
            if(isset($LabelTypeProduct[0])){
              $Layout = $LabelTypeProduct[0]->type;
            }else{
              $Layout = "-";
            }
/*            $arrCsv[] = ['date' => $datetimeymd, 'datetime' => $datetimehm, 'layout' => '現品札_'.$Layout.'.mllay', 'maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'],
             'lotnum' => $lotnum, 'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'],
             'irisu' => $irisu];
*/
             $arrCsv[] = ['maisu' => $_SESSION['labeljunbi'][$i]['yoteimaisu'], 'layout' => $Layout, 'lotnum' => $lotnum,
              'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'costomer' => $costomerName, '?1' => "",
               'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], '?2' => "", 'product_name' => $product_name,
                '?3' => "", 'irisu' => $irisu, '?4' => "", '?5' => "", '?6' => "", '?7' => ""];
             //date…出力した日付、datetime…出力した時間、layout…レイアウト、maisu…予定枚数、lotnum…lotnum、renban…連番、product_code…product_code、irisu…irisu
             $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
             if(isset($Customer[0])){
               $costomerName = $Customer[0]->name;
             }else{
               $costomerName = "";
             }
             if(mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ"){//mb_substrだと文字化けしない
               $lotnumIN = "IN.".$lotnum;//inの時はirisuを外（irisu）÷内（num_inside）にする（konpouテーブルとinsideoutテーブル）
               //maisu=$_SESSION['labeljunbi'][$i]['yoteimaisu']*num_inside
               $LabelInsideout = $this->LabelInsideouts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
               if(isset($LabelInsideout[0])){
                 $num_inside = $LabelInsideout[0]->num_inside;
               }else{
                 $num_inside = 1;
               }
               $LabelTypeProduct = $this->LabelTypeProducts->find()->where(['product_code' => $_SESSION['labeljunbi'][$i]['product_code']])->toArray();
               if(isset($LabelTypeProduct[0])){
                 $Layout = $LabelTypeProduct[0]->type;
               }else{
                 $Layout = "-";
               }
               $maisu = $_SESSION['labeljunbi'][$i]['yoteimaisu'] * $num_inside;
               $irisu2 = $irisu/$num_inside;
               $arrCsv[] = ['maisu' => $maisu, 'layout' => $Layout, 'lotnum' => $lotnumIN,
                'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'costomer' => $costomerName, '?1' => "",
                 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'], '?2' => "", 'product_name' => $product_name,
                  '?3' => "", 'irisu' => $irisu2, '?4' => "", '?5' => "", '?6' => "", '?7' => ""];
/*               $arrCsv[] = ['date' => $datetimeymd, 'datetime' => $datetimehm, 'layout' => '現品札_'.$Layout.'.mllay', 'maisu' => $maisu,
                'lotnum' => $lotnumIN, 'renban' => $_SESSION['labeljunbi'][$i]['hakoNo'], 'product_code' => $_SESSION['labeljunbi'][$i]['product_code'],
                'irisu' => $irisu2];
  */           }
          }
  //$fp = fopen('/labels/label_hirokawa.csv', 'w');
  $fp = fopen('/home/centosuser/labeltest/label_hirokawa.csv', 'w');
          foreach ($arrCsv as $line) {
          	fputcsv($fp, $line);
          }
            fclose($fp);
        }elseif(isset($data['confirm'])){//確認おしたとき
         $this->set('confirm',$data['confirm']);
         $dateto = $data['dateto'];
         $this->set('dateto',$dateto);
       }elseif(empty($data['formset']) && !isset($data['touroku'])){//最初のフォーム画面
         $dateYMD = date('Y-m-d');
         $dateYMD1 = strtotime($dateYMD);
         $dateHI = date("09:00");
         $dateto = $dateYMD."T".$dateHI;
         $this->set('dateto',$dateto);
         for($i=1; $i<=1; $i++){
          ${"tuika".$i} = 0;
          $this->set('tuika'.$i,${"tuika".$i});//セット
         }
         for($i=1; $i<=1; $i++){
          ${"ntuika".$i} = 0;
          $this->set('ntuika'.$i,${"ntuika".$i});//セット
         }
       }else{
         $dateto = $data['dateto'];
         $this->set('dateto',$dateto);
         for($i=1; $i<=1; $i++){
           ${"tuika".$i} = $data["tuika".$i];
           $this->set('tuika'.$i,${"tuika".$i});//セット
         }
         for($i=1; $i<=1; $i++){
           if(isset($data["ntuika".$i])) {
               ${"ntuika".$i} = $data["ntuika".$i];
               $this->set('ntuika'.$i,${"ntuika".$i});//セット
          }
        }
       }
     }
     public function torikomiselect()//発行履歴取り込み
     {
       $this->request->session()->destroy(); // セッションの破棄
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
     }
     public function torikomipreadd()
 		{
      session_start();
      $checkLots = $this->CheckLots->newEntity();
      $this->set('checkLots',$checkLots);
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
      $file = $data['file'];
      $this->set('file',$file);
/*      $session = $this->request->getSession();
      $_SESSION['file'] = array(
        "file" => $file,
      );
*/
      $session = $this->request->getSession();
      $session->write('labelfiles.file', $file);
/*
      echo "<pre>";
      print_r($_SESSION['labelfiles']['file']);
      echo "</pre>";
*/
 		}
 		public function torikomilogin()
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
 						return $this->redirect(['action' => 'torikomido']);
 					}
 				}
 		}
     public function torikomido()//発行履歴取り込み
     {
       $session = $this->request->getSession();
       $data = $session->read();
       $file = $_SESSION['labelfiles']['file'];
       $this->set('file',$file);
/*
       echo "<pre>";
       print_r($data['file']);
       echo "</pre>";
*/
       $fp = fopen("labels/$file", "r");//csvファイルはwebrootに入れる
       $fpcount = fopen("labels/$file", 'r' );
       for($count = 0; fgets( $fpcount ); $count++ );
       $arrFp = array();//空の配列を作る
       $arrLot = array();//空の配列を作る
       $created_staff = $this->Auth->user('staff_id');
       for ($k=1; $k<=$count; $k++) {//最後の行まで
         $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
         $sample = explode("\t",$line);//$lineを"（スペース）"毎に配列に入れる
         $arrFp[] = $sample;//配列に追加する
         if(isset($arrFp[$k-1][10]) && ($arrFp[$k-1][10] != "")){//product_codeが２つある時
/*           echo "<pre>";
           print_r("if");
           echo "<br>";
*/
           $datetime_hakkou = $arrFp[$k-1][0]." ".$arrFp[$k-1][1];
           for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
             $renban = $arrFp[$k-1][5] + $m;
             $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);
             $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][6], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => 0, 'delete_flag' => 0, 'created_staff' => $created_staff];
           }
           for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
             $renban = $arrFp[$k-1][5] + $m;
             $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);
             $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][7], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => 0, 'delete_flag' => 0, 'created_staff' => $created_staff];
           }
         }else{//product_codeが１つの時
/*           echo "<pre>";
           print_r("else");
           echo "<br>";
*/
           $datetime_hakkou = $arrFp[$k-1][0]." ".$arrFp[$k-1][1];
           for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
             $renban = $arrFp[$k-1][5] + $m;
             $lot_num = $arrFp[$k-1][4]."-".sprintf('%03d', $renban);
             $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][6], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => 0, 'delete_flag' => 0, 'created_staff' => $created_staff];
           }
/*
             $Product = $this->Products->find()->where(['product_code' => $arrFp[$k-1][6]])->toArray();
             if(isset($Product[0])){
               $costomerId = $Product[0]->customer_id;
             }else{
               $costomerId = "";
             }
             $Customer = $this->Customers->find()->where(['id' => $costomerId])->toArray();//(株)ＤＮＰのときは"IN.".$lotnumを追加
             if(isset($Customer[0])){
               $costomerName = $Customer[0]->name;
             }else{
               $costomerName = "";
             }
             if(mb_substr($costomerName, 0, 6) == "(株)ＤＮＰ"){//mb_substrだと文字化けしない
               for ($m=0; $m<=$arrFp[$k-1][3] - 1 ; $m++) {//最後の行まで
                 $renban = $arrFp[$k-1][5] + $m;
                 $lot_num = "IN.".$arrFp[$k-1][4]."-".sprintf('%03d', $renban);
                 $arrLot[] = ['datetime_hakkou' => $datetime_hakkou, 'product_code' => $arrFp[$k-1][6], 'lot_num' => $lot_num, 'amount' => (int)($arrFp[$k-1][8]), 'flag_used' => 0, 'delete_flag' => 0, 'created_staff' => 'f606ea4c-3274-4db6-9c95-52304761b41d'];
               }
             }
*/
         }
       }

       echo "<pre>";
       print_r($arrLot);
       echo "<br>";

       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
        if ($this->request->is('get')) {
          $checkLots = $this->CheckLots->patchEntities($checkLots, $arrLot);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
          $connection = ConnectionManager::get('default');//トランザクション1
          // トランザクション開始2
          $connection->begin();//トランザクション3
          try {//トランザクション4
              if ($this->CheckLots->saveMany($checkLots)) {//saveManyで一括登録
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

     public function kensakuform()//ロット検索
     {
       $this->request->session()->destroy(); // セッションの破棄
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
     }

     public function kensakuview()//ロット検索
     {
       $checkLots = $this->CheckLots->newEntity();
       $this->set('checkLots',$checkLots);
       $data = $this->request->getData();
       $product_code = $data['product_code'];
       $lot_num = $data['lot_num'];
       $date_sta = $data['date_sta'];
       $date_fin = $data['date_fin'];
       if(empty($data['product_code'])){//product_codeの入力がないとき
         $product_code = "no";
         if(empty($data['lot_num'])){//lot_numの入力がないとき　product_code×　lot_num×　date〇
           $lot_num = "no";//日にちだけで絞り込み
           $this->set('checkLots',$this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin]));
         }else{//lot_numの入力があるとき　product_code×　lot_num〇　date〇//ロットと日にちで絞り込み
           $this->set('checkLots',$this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['delete_flag' => '0', 'lot_num like' => '%'.$lot_num.'%', 'datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin]));
         }
       }else{//product_codeの入力があるとき
         if(empty($data['lot_num'])){//lot_numの入力がないとき　product_code〇　lot_num×　date〇
           $lot_num = "no";//プロダクトコードと日にちで絞り込み
           $this->set('checkLots',$this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin, 'product_code' => $product_code]));
         }else{//lot_numの入力があるとき　product_code〇　lot_num〇　date〇//プロダクトコードとロットナンバーと日にちで絞り込み
           $this->set('checkLots',$this->CheckLots->find()//以下の条件を満たすデータをCheckLotsテーブルから見つける
             ->where(['delete_flag' => '0','datetime_hakkou >=' => $date_sta, 'datetime_hakkou <=' => $date_fin, 'lot_num like' => '%'.$lot_num.'%', 'product_code' => $product_code]));
         }
       }
/*
       $KensahyouSokuteidata = $this->KensahyouSokuteidatas->find()->where(['manu_date >=' => $value_start, 'manu_date <=' => $value_end, 'delete_flag' => '0', 'product_code' => $product_code])->toArray();
       $arrP = array();
       foreach ($KensahyouSokuteidata as $value) {
          $product_code= $value->product_code;
          $lot_num = $value->lot_num;
          $manu_date = $value->manu_date->format('Y-m-d H:i:s');
          $manu_date = substr($manu_date,0,10);
          $arrP[] = ['product_code' => $product_code, 'lot_num' => $lot_num, 'manu_date' => $manu_date];
        }
        foreach ((array) $uniquearrP as $key => $value) {
            $sort[$key] = $value['manu_date'];
        }
        array_multisort($sort, SORT_DESC, $uniquearrP);
        $this->set('uniquearrP',$uniquearrP);//セット
*/
     }
}
