<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//他のテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 *
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KensahyouHeadsController  extends AppController
{
     public function initialize()
     {
	parent::initialize();
  $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
  $this->Users = TableRegistry::get('users');//Usersテーブルを使う
	$this->Products = TableRegistry::get('products');//productsテーブルを使う
     }

    public function index1()//検査表ヘッダー登録画面
    {
	$this->set('entity',$this->KensahyouHeads->newEntity());//newEntity・テーブルに空の行を作る
  //      $this->request->session()->destroy(); // セッションの破棄

	$arrProducts = $this->Products->find('all', ['conditions' => ['delete_flag' => '0']])->order(['product_code' => 'ASC']);//Productsテーブルの、'delete_flag' => '0'となるデータをid順に並べる
	$arrProduct = array();//配列の初期化
	foreach ($arrProducts as $value) {//配列に追加
		$arrProduct[] = array($value->id=>$value->product_code.':'.$value->product_name);//idごとにproduct_code:product_nameでセット
	}
	$this->set('arrProduct',$arrProduct);//セット

    }

    public function version()//新規登録画面またはバージョン画面
    {
    	$data = $this->request->getData();//postで送られた全データを取得
      $product_code = $data['product_code'];//product_idという名前のデータに$product_idと名前を付ける
      $this->set('Productcode',$product_code);//セット

      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'id' => $product_idを満たすものを$Productとする
    	$product_id = $Product[0]->id;//$Productのproduct_codeに$Productcodeと名前を付ける

    //	$product_id = $data['product_id'];//product_idという名前のデータに$product_idと名前を付ける
    	$this->set('product_id',$product_id);//セット

    	$staff_id = $this->Auth->user('staff_id');//ログインしているuserのstaff_idに$staff_idと名前を付ける
    	$this->set('staff_id',$staff_id);//セット

    	$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・・・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

    	$KensaProduct = $this->KensahyouHeads->find()->where(['product_id' => $product_id, 'delete_flag' => '0'])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
    	$this->set('KensaProduct',$KensaProduct);//セット

    //	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Productとする
    //	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
    //	$this->set('Productcode',$Productcode);//セット

    //	$Productn = $this->Products->find()->where(['id' => $product_id])->toArray();//
    	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
    	$this->set('Productname',$Productname);//セット

    	$this->set('kensahyouHeads',$this->KensahyouHeads->find()//KensahyouHeadsテーブルから
    		->where(['delete_flag' => '0','product_id' => $product_id]));//'delete_flag' => '0'、'product_id' => $product_idを満たすデータをkensahyouHeadsにセット
    }

     public function confirm()
    {
	$data = $this->request->getData();//postで送られた全データを取得

	$product_id = $data['product_id'];//product_idという名前のデータに$product_idと名前を付ける
	$this->set('product_id',$product_id);//セット

	$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
	$this->set('kensahyouHead',$kensahyouHead);//セット

//	$KensaProduct = $this->KensahyouHeads->find()->where(['product_id' => $product_id])->toArray();//

	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Product
	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
	$this->set('Productcode',$Productcode);//セット

//	$Productn = $this->Products->find()->where(['id' => $product_id])->toArray();//
	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
	$this->set('Productname',$Productname);//セット

	$staff_id = $this->Auth->user('staff_id');//ログインしているuserのstaff_idに$staff_idと名前を付ける
	$kensahyouHead['created_staff'] = $staff_id;//$kensahyouHeadのcreated_staffのデータを$staff_idにする
    }

    public function preadd()//do postをgetに変更
    {
      $kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
    	$this->set('kensahyouHead',$kensahyouHead);//セット

     $session = $this->request->getSession();
     $data = $session->read();//postデータ取得し、$dataと名前を付ける
/*
     echo "<pre>";
     print_r($data['sokuteidata']);
     echo "</pre>";
*/    }

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

       $staff_id = $this->Auth->user('staff_id');//created_staffの登録用
     	$this->set('staff_id',$staff_id);//セット

         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
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
 //    return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
   }

     public function do()//getに変更
    {
	$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
	$this->set('kensahyouHead',$kensahyouHead);//セット

  $session = $this->request->getSession();
  $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

  $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
  $_SESSION['sokuteidata'] = array_merge($created_staff,$_SESSION['sokuteidata']);

  $data = $_SESSION['sokuteidata'];
/*
  echo "<pre>";
  print_r($data);
  echo "</pre>";
*/
	$product_id = $data['product_id'];//product_idという名前のデータに$product_idと名前を付ける
	$this->set('product_id',$product_id);//セット

	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Product
	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
	$this->set('Productcode',$Productcode);//セット

	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
	$this->set('Productname',$Productname);//セット

	if ($this->request->is('get')) {//postでこのページに来た場合の処理
		$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $data);//$kensahyouHeadデータ（空の行）を$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
		// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->KensahyouHeads->save($kensahyouHead)) {//saveできた時
				$connection->commit();// コミット5
			} else {//saveできなかった時
				$this->Flash->error(__('The KensahyouHeads could not be saved. Please, try again.'));
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
	$kensahyouHead = $this->KensahyouHeads->get($id);
	$this->set('kensahyouHead', $kensahyouHead);//$kensahyouHeadをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');
	$kensahyouHead['updated_staff'] = $staff_id;

	$product_id = $kensahyouHead['product_id'];//product_idという名前のデータに$product_idと名前を付ける
	$this->set('product_id',$product_id);//セット

	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Product
	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
	$this->set('Productcode',$Productcode);//セット

	$Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
	$this->set('Productname',$Productname);//セット

//	echo "<pre>";
//	print_r(array($kensahyouHead));
//	print_r($kensahyouHead['id']);
//	echo "</pre>";

	if ($this->request->is(['patch', 'post', 'put'])) {
		$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());
		$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->KensahyouHeads->save($kensahyouHead)) {
				$this->Flash->success(__('The KensahyouHeads has been updated.'));
				$connection->commit();// コミット5
				return $this->redirect(['action' => 'index1']);
			} else {
				$this->Flash->error(__('The KensahyouHeads could not be updated. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10
	}
    }

}
