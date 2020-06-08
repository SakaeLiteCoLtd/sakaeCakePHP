<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * PriceMaterials Controller
 *
 * @property \App\Model\Table\PriceMaterialsTable $PriceMaterials
 *
 * @method \App\Model\Entity\PriceMaterial[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PriceMaterialsController extends AppController
{
	public $paginate = [//ページネーションを定義（indexで使う）
		'limit' => 20,//データを1ページに20個ずつ表示する
		'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	];


	     public function initialize()
	     {
				 parent::initialize();
			 	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
			 	$this->Materials = TableRegistry::get('materials');//materialsテーブルを使う
			 	$this->Suppliers = TableRegistry::get('suppliers');//suppliersテーブルを使う
				$this->Users = TableRegistry::get('users');//staffsテーブルを使う
				$this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
				$this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
				$this->DnpTotalAmounts = TableRegistry::get('dnpTotalAmounts');
				$this->OrderEdis = TableRegistry::get('orderEdis');
				$this->PlaceDelivers = TableRegistry::get('placeDelivers');
	     }

	     public function confirmcsv()
	    {
				$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
				$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット
	    }

	     public function docsv()
	    {
				$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
				$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

		//		$fp = fopen("price_material.csv", "r");//csvファイルはwebrootに入れる
				$fp = fopen("minoukannou2020~.csv", "r");//csvファイルはwebrootに入れる
				$this->set('fp',$fp);

		//		$fpcount = fopen("order_edis_2019~.csv", 'r' );
				$fpcount = fopen("minoukannou2020~.csv", 'r' );
				for( $count = 0; fgets( $fpcount ); $count++ );
				$this->set('count',$count);

				$arrFp = array();//空の配列を作る
		//		$arrTotal = array();//空の配列を作る
				$line = fgets($fp);//ファイル$fpの上の１行を取る（１行目はカラム名なので先に取っておく）
				for ($k=1; $k<=$count-1; $k++) {
					$line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
					$sample = explode(',',$line);//$lineを","毎に配列に入れる
/*
					$keys=array_keys($sample);
					$keys[array_search('0',$keys)]='id';
					$keys[array_search('1',$keys)]='place_deliver_code';
					$keys[array_search('2',$keys)]='date_order';
		//			$keys[array_search('3',$keys)]='price';
					$keys[array_search('3',$keys)]='name_order';
					$keys[array_search('4',$keys)]='amount';
					$keys[array_search('5',$keys)]='product_code';
					$keys[array_search('6',$keys)]='line_code';
					$keys[array_search('7',$keys)]='date_deliver';
					$keys[array_search('8',$keys)]='num_order';
					$keys[array_search('9',$keys)]='first_date_deliver';
					$keys[array_search('10',$keys)]='customer_code';
					$keys[array_search('11',$keys)]='place_line';
					$keys[array_search('12',$keys)]='check_denpyou';
					$keys[array_search('13',$keys)]='gaityu';
					$keys[array_search('14',$keys)]='bunnou';
					$keys[array_search('15',$keys)]='kannou';
					$keys[array_search('16',$keys)]='date_bunnou';
					$keys[array_search('17',$keys)]='check_kannou';
					$keys[array_search('18',$keys)]='delete_flag';
					$keys[array_search('19',$keys)]='created_at';
					$keys[array_search('20',$keys)]='created_staff';
					$keys[array_search('21',$keys)]='updated_at';
					$keys[array_search('22',$keys)]='updated_staff';
*/

					$keys=array_keys($sample);
					$keys[array_search('0',$keys)]='order_edi_id';//もともとdate_order
					$keys[array_search('1',$keys)]='num_order';
					$keys[array_search('2',$keys)]='product_code';
					$keys[array_search('3',$keys)]='code';
					$keys[array_search('4',$keys)]='place_deliver';
					$keys[array_search('5',$keys)]='date_deliver';
					$keys[array_search('6',$keys)]='amount';
					$keys[array_search('7',$keys)]='minoukannou';
					$keys[array_search('8',$keys)]='delete_flag';
					$keys[array_search('9',$keys)]='created_at';
					$keys[array_search('10',$keys)]='updated_at';

					$sample = array_combine($keys, $sample);

					${"orderEdis".$k} = $this->OrderEdis->find()->where(['line_code' => $sample['code'], 'num_order' => $sample['num_order'],
					 'product_code' => $sample['product_code'], 'date_order' => $sample['order_edi_id']])->toArray();//同一の注文

					if(isset(${"orderEdis".$k}[0])){

						$order_edi_id = ${"orderEdis".$k}[0]->id;

						$replacements = array('order_edi_id' => $order_edi_id);//配列のデータの置き換え
						$sample = array_replace($sample, $replacements);//配列のデータの置き換え

						$place_code = ${"orderEdis".$k}[0]->place_deliver_code;

						${"PlaceDeliver".$k} = $this->PlaceDelivers->find()->where(['id_from_order' => $place_code])->toArray();

						$place_deliver = ${"PlaceDeliver".$k}[0]->name;

						$replacements = array('place_deliver' => $place_deliver);//配列のデータの置き換え
						$sample = array_replace($sample, $replacements);//配列のデータの置き換え

					}else{

						$order_edi_id = "-";

						$replacements = array('order_edi_id' => $order_edi_id);//配列のデータの置き換え
						$sample = array_replace($sample, $replacements);//配列のデータの置き換え

						$place_deliver = "-";

						$replacements = array('place_deliver' => $place_deliver);//配列のデータの置き換え
						$sample = array_replace($sample, $replacements);//配列のデータの置き換え

					}


					$connection = ConnectionManager::get('DB_ikou_test');
					$table = TableRegistry::get('denpyou_dnp');
					$table->setConnection($connection);

					$sql = "SELECT name_order FROM denpyou_dnp".
								" where product_id ='".$sample['product_code']."' and num_order = '".$sample['num_order']."'";
					$connection = ConnectionManager::get('DB_ikou_test');
					${"denpyou_dnp_moto".$k} = $connection->execute($sql)->fetchAll('assoc');

					if(isset(${"denpyou_dnp_moto".$k}[0]['name_order'])){

						${"name_order".$k} = ${"denpyou_dnp_moto".$k}[0]['name_order'];

					}else{

						${"name_order".$k} = "-";

					}

					$connection = ConnectionManager::get('default');//新DBに戻る
					$table->setConnection($connection);

					$replacements = array('name_order' => ${"name_order".$k});//配列のデータの置き換え
					$sample = array_replace($sample, $replacements);//配列のデータの置き換え
/*
					$replacements = array('place_deliver' => $place_deliver);//配列のデータの置き換え
					$sample = array_replace($sample, $replacements);//配列のデータの置き換え

					$replacements = array('place_deliver' => $place_deliver);//配列のデータの置き換え
					$sample = array_replace($sample, $replacements);//配列のデータの置き換え
*/
					unset($sample['updated_at']);//削除

					$arrFp[] = $sample;//配列に追加する

/*
					unset($sample['id']);//削除
					unset($sample['place_deliver_code']);//削除
		//			unset($sample['price']);//削除
					unset($sample['first_date_deliver']);//削除
					unset($sample['customer_code']);//削除
					unset($sample['place_line']);//削除
					unset($sample['check_denpyou']);//削除
					unset($sample['bunnou']);//削除
					unset($sample['gaityu']);//削除
					unset($sample['kannou']);//削除
					unset($sample['date_bunnou']);//削除
					unset($sample['check_kannou']);//削除
					unset($sample['updated_at']);//削除
					unset($sample['updated_at']);//削除
					unset($sample['updated_staff']);//削除

					if($sample['delete_flag'] == 0){
						$arrFp[] = $sample;//配列に追加する
					}
					*/
				}

				$this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
				echo "<pre>";
				print_r($arrFp[0]);
				echo "<br>";
				echo "<pre>";
				print_r($arrFp);
				echo "<br>";
/*
				echo "<pre>";
				print_r($arrFp);
				echo "<br>";
*/


/*
				if ($this->request->is('post')) {//postなら登録
					$DenpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->patchEntities($this->DenpyouDnpMinoukannous->newEntity(), $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
					$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
					$connection->begin();//トランザクション3
					try {//トランザクション4
							if ($this->PriceMaterials->saveMany($DenpyouDnpMinoukannous)) {//saveManyで一括登録
								$connection->commit();// コミット5
							} else {
								$this->Flash->error(__('The PriceMaterials could not be saved. Please, try again.'));
								throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
							}
					} catch (Exception $e) {//トランザクション7
					//ロールバック8
						$connection->rollback();//トランザクション9
					}//トランザクション10
				}
*/
	    }


    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
			$this->set('priceMaterials', $this->PriceMaterials->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('priceMaterials', $this->paginate());//定義したページネーションを使用
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
    public function form1()
    {
	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
	$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

	$arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、grade順に並べる
	$arrMaterial = array();//配列の初期化
	foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
		$arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:colorで追加
	}
	$this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット

	$arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['supplier_code' => 'ASC']);//Suppliersテーブルの'delete_flag' => '0'となるものを見つけ、supplier_code順に並べる
	$arrSupplier = array();//配列の初期化
	foreach ($arrSuppliers as $value) {//2行上のSuppliersテーブルのデータそれぞれに対して
		$arrSupplier[] = array($value->id=>$value->supplier_code.':'.$value->name);//配列に3行上のSuppliersテーブルのデータそれぞれのsupplier_code:nameで追加
	}
	$this->set('arrSupplier',$arrSupplier);//4行上$arrSupplierをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$priceMaterial['created_staff'] = $staff_id;//$priceMaterialのcreated_staffを$staff_idにする
    }

    public function form2()
    {
	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
	$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

	$material_id = $data['material_id'];//$dataのmaterial_idに$material_idという名前を付ける
	$materialgrade1 = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
	$materialgrade2 = $materialgrade1[0]->grade;//配列の0番目（0番目しかない）のgradeに$materialgrade2と名前を付ける
	$this->set('materialgrade2',$materialgrade2);//1行上の$materialgrade2をctpで使えるようにセット

	$arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、grade順に並べる
	$arrMaterial = array();//配列の初期化
	foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
		$arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:colorで追加
	}
	$this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット

	$arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['supplier_code' => 'ASC']);//Suppliersテーブルの'delete_flag' => '0'となるものを見つけ、supplier_code順に並べる
	$arrSupplier = array();//配列の初期化
	foreach ($arrSuppliers as $value) {//2行上のSuppliersテーブルのデータそれぞれに対して
		$arrSupplier[] = array($value->id=>$value->supplier_code.':'.$value->name);//配列に3行上のSuppliersテーブルのデータそれぞれのsupplier_code
	}
	$this->set('arrSupplier',$arrSupplier);//4行上$arrSupplierをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$priceMaterial['created_staff'] = $staff_id;//$priceMaterialのupdated_staffを$staff_idにする
    }

     public function confirm()
    {
	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
	$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

	$material_id = $data['material_id'];//$dataのmaterial_idに$material_idという名前を付ける
	$materialgrade1 = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
	$materialgrade2 = $materialgrade1[0]->grade;//配列の0番目（0番目しかない）のgradeに$materialgrade2と名前を付ける
	$this->set('materialgrade2',$materialgrade2);//1行上の$materialgrade2をctpで使えるようにセット

	$supplier_id = $data['supplier_id'];//$dataのsupplier_idに$supplier_idという名前を付ける
	$SupplierData = $this->Suppliers->find()->where(['id' => $supplier_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
	$Supplier = $SupplierData[0]->name;//配列の0番目（0番目しかない）のgradeに$materialgrade2と名前を付ける
	$this->set('Supplier',$Supplier);//1行上の$materialgrade2をctpで使えるようにセット
    }

		public function preadd()
		{
			$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
			$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット
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
	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
	$this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

//	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$session = $this->request->getSession();
	$data = $session->read();//postデータ取得し、$dataと名前を付ける

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$data['priceMaterialdata']['created_staff'] = $staff_id;//$userのcreated_staffを$staff_idにする

	$material_id = $data['priceMaterialdata']['material_id'];//$dataのmaterial_idに$material_idという名前を付ける
	$materialgrade1 = $this->Materials->find()->where(['id' => $material_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
	$materialgrade2 = $materialgrade1[0]->grade;//配列の0番目（0番目しかない）のgradeに$materialgrade2と名前を付ける
	$this->set('materialgrade2',$materialgrade2);//1行上の$materialgrade2をctpで使えるようにセット

	$supplier_id = $data['priceMaterialdata']['supplier_id'];//$dataのsupplier_idに$supplier_idという名前を付ける
	$SupplierData = $this->Suppliers->find()->where(['id' => $supplier_id])->toArray();//'id' => $material_idとなるデータをMaterialsテーブルから配列で取得
	$Supplier = $SupplierData[0]->name;//配列の0番目（0番目しかない）のgradeに$materialgrade2と名前を付ける
	$this->set('Supplier',$Supplier);//1行上の$materialgrade2をctpで使えるようにセット

	$created_staff = $data['priceMaterialdata']['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

	if ($this->request->is('get')) {//postの場合
		$priceMaterial = $this->PriceMaterials->patchEntity($priceMaterial, $data['priceMaterialdata']);//$priceMaterialデータ（空の行）を$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
		// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->PriceMaterials->save($priceMaterial)) {
				$mes = "※下記のように登録されました";
				$this->set('mes',$mes);
				$connection->commit();// コミット5
			} else {
				$mes = "※登録されませんでした";
				$this->set('mes',$mes);
				$this->Flash->error(__('The priceMaterial could not be saved. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10
	}
    }




    /**
     * Edit method
     *
     * @param string|null $id Price Material id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
	$priceMaterial = $this->PriceMaterials->get($id);//選んだidに関するPriceMaterialsテーブルのデータに$priceMaterialと名前を付ける
	$this->set('priceMaterial',$priceMaterial);//1行上の$materialをctpで使えるようにセット

	$arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、grade順に並べる
	$arrMaterial = array();//配列の初期化
	foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
		$arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:colorで追加
	}
	$this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット

	$arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['supplier_code' => 'ASC']);//Suppliersテーブルの'delete_flag' => '0'となるものを見つけ、supplier_code順に並べる
	$arrSupplier = array();//配列の初期化
	foreach ($arrSuppliers as $value) {//2行上のSuppliersテーブルのデータそれぞれに対して
		$arrSupplier[] = array($value->id=>$value->supplier_code.':'.$value->name);//配列に3行上のSuppliersテーブルのデータそれぞれのsupplier_code
	}
	$this->set('arrSupplier',$arrSupplier);//4行上$arrSupplierをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$priceMaterial['updated_staff'] = $staff_id;//$priceMaterialのupdated_staffを$staff_idにする

	if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
		$priceMaterial = $this->PriceMaterials->patchEntity($priceMaterial, $this->request->getData());//158行目でとったもともとの$materialデータを$this->request->getData()に更新する
		$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
		$connection->begin();//トランザクション3
		try {//トランザクション4
			if ($this->PriceMaterials->save($priceMaterial)) {
				$this->Flash->success(__('The priceMaterial has been updated.'));
				$connection->commit();// コミット5
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('The priceMaterial could not be updated. Please, try again.'));
				throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
			}
		} catch (Exception $e) {//トランザクション7
		//ロールバック8
			$connection->rollback();//トランザクション9
		}//トランザクション10
	}
    }
}
