<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 *
 * @method \App\Model\Entity\Product[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProductsController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	];

    public function initialize()
    {
			parent::initialize();
			$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
			$this->Customers = TableRegistry::get('customers');//customersテーブルを使う
			$this->Materials = TableRegistry::get('materials');//materialsテーブルを使う
			$this->Users = TableRegistry::get('users');//staffsテーブルを使う
			$this->Konpous = TableRegistry::get('konpous');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
			$this->set('products', $this->Products->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('products', $this->paginate());//定義したページネーションを使用
    }
/*
    public function login()
    {
	if ($this->request->is('post')) {
		$user = $this->Auth->identify();
		if ($user) {
			$this->Auth->setUser($user);
			return $this->redirect($this->Auth->redirectUrl());
		}
		$this->Flash->error(__('Invalid username or password, try again'));
	}
    }

    public function logout()
    {
	$this->request->session()->destroy(); // セッションの破棄
	return $this->redirect($this->Auth->logout()); // ログアウト処理
    }
*/
    public function form()
    {
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット

			$arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
			$arrCustomer = array();//配列の初期化
			foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
				$arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
			}
			$this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

			$arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、grade順に並べる
			$arrMaterial = array();//配列の初期化
			foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
				$arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:color
			}
			$this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$product['created_staff'] = $staff_id;//$productのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット

			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$customer_id = $data['customer_id'];//$dataのcustomer_idに$customer_idという名前を付ける
			$CustomerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $customer_idとなるデータをStaffsテーブルから配列で取得
			$Customer = $CustomerData[0]->customer_code.":".$CustomerData[0]->name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('Customer',$Customer);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			$material_id = $data['material_id'];//$dataのmaterial_idに$material_idという名前を付ける
			$MaterialData = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
			$Material = $MaterialData[0]->grade.":".$MaterialData[0]->color;//配列の0番目（0番目しかない）のnameに$Materialと名前を付ける
			$this->set('Material',$Material);//登録者の表示のため1行上の$Materialをctpで使えるようにセット
    }

		public function preadd()
		{
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット
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
		 return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
	 }

     public function do()
    {
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット

		//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$data['productdata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

			$customer_id = $data['productdata']['customer_id'];//$dataのcustomer_idに$customer_idという名前を付ける
			$CustomerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $customer_idとなるデータをStaffsテーブルから配列で取得
			$Customer = $CustomerData[0]->customer_code.":".$CustomerData[0]->name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('Customer',$Customer);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			$material_id = $data['productdata']['material_id'];//$dataのmaterial_idに$material_idという名前を付ける
			$MaterialData = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
			$Material = $MaterialData[0]->grade.":".$MaterialData[0]->color;//配列の0番目（0番目しかない）のnameに$Materialと名前を付ける
			$this->set('Material',$Material);//登録者の表示のため1行上の$Materialをctpで使えるようにセット

			$created_staff = $data['productdata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
			$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			echo "<pre>";
	    print_r($data['productdata']);
	    echo "</pre>";

			if ($this->request->is('get')) {//postの場合
				$product = $this->Products->patchEntity($product, $data['productdata']);//$productデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Products->save($product)) {
						$mes = "※下記のように登録されました";
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
    }

		public function konpouform()
		{
			$this->request->session()->destroy(); // セッションの破棄
			$product = $this->Products->newEntity();
			$this->set('product',$product);
		}

		public function konpouconfirm()
		{
			$this->request->session()->destroy(); // セッションの破棄
			$product = $this->Products->newEntity();
			$this->set('product',$product);
		}

		public function konpoupreadd()
		{
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット
		}

		 public function konpoulogin()
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
						 return $this->redirect(['action' => 'do']);
					 }
				 }
		 }

		 public function konpoudo()
		{
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット
			$konpou = $this->Konpous->newEntity();//newentityに$productという名前を付ける
			$this->set('konpou',$konpou);//1行上の$productをctpで使えるようにセット

		//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

			$session = $this->request->getSession();
			$data = $session->read();//postデータ取得し、$dataと名前を付ける

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$data['productdata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

			$customer_id = $data['productdata']['customer_id'];//$dataのcustomer_idに$customer_idという名前を付ける
			$CustomerData = $this->Customers->find()->where(['id' => $customer_id])->toArray();//'id' => $customer_idとなるデータをStaffsテーブルから配列で取得
			$Customer = $CustomerData[0]->customer_code.":".$CustomerData[0]->name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('Customer',$Customer);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			$material_id = $data['productdata']['material_id'];//$dataのmaterial_idに$material_idという名前を付ける
			$MaterialData = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
			$Material = $MaterialData[0]->grade.":".$MaterialData[0]->color;//配列の0番目（0番目しかない）のnameに$Materialと名前を付ける
			$this->set('Material',$Material);//登録者の表示のため1行上の$Materialをctpで使えるようにセット

			$created_staff = $data['productdata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
			$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
			$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
			$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

			echo "<pre>";
			print_r($data['productdata']);
			echo "</pre>";

			if ($this->request->is('get')) {//postの場合
				$product = $this->Products->patchEntity($product, $data['productdata']);//$productデータ（空の行）を$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Products->save($product)) {
						$mes = "※下記のように登録されました";
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
		}


     public function confirmcsv()//「出荷検査表登録」確認画面
    {
			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット
    }

     public function docsv()
    {
			$staff_id = $this->Auth->user('staff_id');
			$this->set('staff_id',$staff_id);//1行上の$staff_idをctpで使えるようにセット

			$fp = fopen("product191106.csv", "r");//csvファイルはwebrootに入れる
			$this->set('fp',$fp);

			$fpcount = fopen("product191106.csv", 'r' );
			for( $count = 0; fgets( $fpcount ); $count++ );
			$this->set('count',$count);

			$arrFp = array();//空の配列を作る
			$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目はカラム名なので先に取っておく）
			for ($k=1; $k<=$count-1; $k++) {//行数分
				$line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
				$sample = explode(',',$line);//$lineを","毎に配列に入れる

				array_push($sample, '0', '0', $staff_id);//配列に追加

				$keys=array_keys($sample);
				$keys[array_search('0',$keys)]='product_code';//名前の変更
				$keys[array_search('1',$keys)]='product_name';
				$keys[array_search('2',$keys)]='weight';
				$keys[array_search('4',$keys)]='customer_id';
				$keys[array_search('9',$keys)]='torisu';
				$keys[array_search('10',$keys)]='cycle';
				$keys[array_search('12',$keys)]='primary_p';
				$keys[array_search('13',$keys)]='gaityu';
				$keys[array_search('16',$keys)]='delete_flag';//追加した配列の値(値は0)
				$keys[array_search('17',$keys)]='status';//追加した配列の値(値は0)
				$keys[array_search('18',$keys)]='created_staff';//追加した配列の値(値は$staff_id)

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

				$arrFp[] = $sample;//配列に追加する
			}
			$this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
		//	echo "<pre>";
		//	print_r($arrFp[0]);
		//	print_r($arrFp);
		//	echo "<br>";

			$product = $this->Products->newEntity();//newentityに$productという名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$product = $this->Products->patchEntities($product, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->Products->saveMany($product)) {//saveManyで一括登録
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
    }


    public function edit($id = null)
    {
			$product = $this->Products->get($id);//選んだidに関するProductsテーブルのデータに$productと名前を付ける
			$this->set('product',$product);//1行上の$productをctpで使えるようにセット

			$arrCustomers = $this->Customers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['customer_code' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、customer_code順に並べる
			$arrCustomer = array();//配列の初期化
			foreach ($arrCustomers as $value) {//2行上のCustomersテーブルのデータそれぞれに対して
				$arrCustomer[] = array($value->id=>$value->customer_code.':'.$value->name);//配列に3行上のCustomersテーブルのデータそれぞれのcustomer_code:name
			}
			$this->set('arrCustomer',$arrCustomer);//4行上$arrCustomerをctpで使えるようにセット

			$arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
			$arrMaterial = array();//配列の初期化
			foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
				$arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:color
			}
			$this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット

			$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
			$product['updated_staff'] = $staff_id;//$productのupdated_staffを$staff_idにする

			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
				$product = $this->Products->patchEntity($product, $this->request->getData());//131行目でとったもともとの$priceProductデータを$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Products->save($product)) {
						$this->Flash->success(__('The product has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The product could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}
    }

}
