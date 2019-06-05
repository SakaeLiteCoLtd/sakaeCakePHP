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
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
     }
     
    public function index1()
    {
        $this->set('entity',$this->KensahyouHeads->newEntity());//newEntity・テーブルに空の行を作る

	    $arrProducts = $this->Products->find('all', ['conditions' => ['delete_flag' => '0']])->order(['product_code' => 'ASC']);//Productsテーブルの、'delete_flag' => '0'となるデータをid順に並べる
	    $arrProduct = array();//配列の初期化
	    foreach ($arrProducts as $value) {//配列に追加
	        $arrProduct[] = array($value->id=>$value->product_code.':'.$value->product_name);//idごとにproduct_code:product_nameでセット
	    }
	    $this->set('arrProduct',$arrProduct);//セット
    }

    public function version()
    {
		$data = $this->request->getData();//postで送られた全データを取得
		
		$product_id = $data['product_id'];//product_idという名前のデータに$product_idと名前を付ける
		$this->set('product_id',$product_id);//セット
		
		$staff_id = $this->Auth->user('staff_id');//ログインしているuserのstaff_idに$staff_idと名前を付ける
		$this->set('staff_id',$staff_id);//セット
	
		$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
       	$this->set('kensahyouHead',$kensahyouHead);//セット

       	$KensaProduct = $this->KensahyouHeads->find()->where(['product_id' => $product_id])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
       	$this->set('KensaProduct',$KensaProduct);//セット

       	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Product
       	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
       	$this->set('Productcode',$Productcode);//セット

//        $Productn = $this->Products->find()->where(['id' => $product_id])->toArray();//
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
	
//       	$KensaProduct = $this->KensahyouHeads->find()->where(['product_id' => $product_id])->toArray();//
  
       	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Product
       	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
       	$this->set('Productcode',$Productcode);//セット

//        $Productn = $this->Products->find()->where(['id' => $product_id])->toArray();//
        $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
        $this->set('Productname',$Productname);//セット

		$staff_id = $this->Auth->user('staff_id');//ログインしているuserのstaff_idに$staff_idと名前を付ける
		$kensahyouHead['created_staff'] = $staff_id;//$kensahyouHeadのcreated_staffのデータを$staff_idにする
    }

     public function do()
    {
		$kensahyouHead = $this->KensahyouHeads->newEntity();//newEntity・テーブルに空の行を作る
       	$this->set('kensahyouHead',$kensahyouHead);//セット
		
		$data = $this->request->getData();//postで送られた全データを取得
		$product_id = $data['product_id'];//product_idという名前のデータに$product_idと名前を付ける
		$this->set('product_id',$product_id);//セット

       	$Product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_idを満たすものを$Product
       	$Productcode = $Product[0]->product_code;//$Productのproduct_codeに$Productcodeと名前を付ける
       	$this->set('Productcode',$Productcode);//セット

        $Productname = $Product[0]->product_name;//$Productのproduct_nameに$Productnameと名前を付ける
        $this->set('Productname',$Productname);//セット

		if ($this->request->is('post')) {//postでこのページに来た場合の処理
			$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());//$kensahyouHeadデータ（空の行）を$this->request->getData()に更新する
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

    public function edit($id = null)//edit未完成
    {
	$kensahyouHead = $this->KensahyouHeads->get($id);
	$this->set(compact('kensahyouHead'));
	$staff_id = $this->Auth->user('staff_id');
	$kensahyouHead['updated_staff'] = $staff_id;

/*	$kensahyouHead = $this->KensahyouHeads->newEntity();
	$data = $this->request->getData();

            echo "<pre>";
            print_r($data);
            echo "</pre>";
*/

		if ($this->request->is(['patch', 'post', 'put'])) {
			$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->KensahyouHeads->save($kensahyouHead)) {
					$this->Flash->success(__('The KensahyouHeads has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);
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
