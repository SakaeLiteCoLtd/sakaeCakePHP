<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//
use Cake\Datasource\ConnectionManager;//
use Cake\Core\Exception\Exception;//
use Cake\Core\Configure;//

/**
 * Suppliers Controller
 *
 * @property \App\Model\Table\SuppliersTable $Suppliers
 *
 * @method \App\Model\Entity\Supplier[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SuppliersController extends AppController
{
	public $paginate = [//ページネーションを定義（indexで使う）
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	    ];

     public function initialize()
     {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//Staffsテーブルを使う
         $this->SupplierSections = TableRegistry::get('supplierSections');//SupplierSectionsテーブルを使う
     }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('suppliers', $this->Suppliers->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
		$this->set('suppliers', $this->paginate());//定義したページネーションを使用
    }

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
        $this->request->session()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    public function form()
    {
	$supplier = $this->Suppliers->newEntity();//newentityに$supplierという名前を付ける
	$this->set('supplier',$supplier);//1行上の$supplierをctpで使えるようにセット

        $arrSupplierSections = $this->SupplierSections->find('all', ['conditions' => ['delete_flag' => '0']])->order(['account_code' => 'ASC']);//SupplierSectionsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
        $arrSupplierSection = array();//配列の初期化
        foreach ($arrSupplierSections as $value) {//2行上のSupplierSectionsテーブルのデータそれぞれに対して
            $arrSupplierSection[] = array($value->id=>$value->account_code.':'.$value->name);//配列に3行上のSupplierSectionsテーブルのデータそれぞれのaccount_code:name
        }
        $this->set('arrSupplierSection',$arrSupplierSection);//4行上$arrSupplierSectionをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$supplier['created_staff'] = $staff_id;//$supplierのupdated_staffを$staff_idにする
    }

     public function confirm()
    {
	$supplier = $this->Suppliers->newEntity();//newentityに$supplierという名前を付ける
	$this->set('supplier',$supplier);//1行上の$supplierをctpで使えるようにセット
    }

     public function do()
    {
	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
            	    echo "<pre>";
//                    print_r($data);
                    var_dump($data);
                    echo "<br>";

   	$supplier = $this->Suppliers->newEntity();//newentityに$supplierという名前を付ける
	$this->set('supplier',$supplier);//1行上の$supplierをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

		if ($this->request->is('post')) {//postの場合
			$supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());//$supplierデータ（空の行）を$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Suppliers->save($supplier)) {
					$connection->commit();// コミット5
				} else {
					$this->Flash->error(__('The supplier could not be saved. Please, try again.'));
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
	$supplier = $this->Suppliers->newEntity();//newentityに$supplierという名前を付ける
	$this->set('supplier',$supplier);//1行上の$supplierをctpで使えるようにセット
	
    $staff_id = $this->Auth->user('staff_id');
	$this->set('staff_id',$staff_id);//1行上の$supplierをctpで使えるようにセット

    $fp = fopen("supplier.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
                    
    $fpcount = fopen("supplier.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
        $this->set('count',$count);
        
        $arrFp = array();//空の配列を作る
//        $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
        for ($k=1; $k<=$count; $k++) {//行数分
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
                       
            $keys=array_keys($sample);
            $keys[array_search('0',$keys)]='supplier_code';//名前の変更
            $keys[array_search('1',$keys)]='name';
            $keys[array_search('3',$keys)]='address';
            $keys[array_search('4',$keys)]='tel';
            $keys[array_search('5',$keys)]='fax';
            $keys[array_search('6',$keys)]='charge_p';
            $keys[array_search('7',$keys)]='delete_flag';
            $sample = array_combine( $keys, $sample );
                        
            unset($sample['2']);//削除
            unset($sample['8']);//削除

            $arrFp[] = $sample;//配列に追加する
        }
        $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
//            	    echo "<pre>";
//                    print_r($arrFp);
//                    echo "<br>";
    }

     public function docsv()
    {
	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
//            	    echo "<pre>";
//                    print_r($data);
//                    var_dump($data);
//                    echo "<br>";

	$supplier = $this->Suppliers->newEntity();//newentityに$userという名前を付ける
	$this->set('supplier',$supplier);//1行上の$userをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$supplier = $this->Suppliers->patchEntities($supplier, $this->request->getData('supplierdata'));//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->Suppliers->saveMany($supplier)) {//saveManyで一括登録
							$connection->commit();// コミット5
						} else {
							$this->Flash->error(__('The Suppliers could not be saved. Please, try again.'));
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
     * @param string|null $id Supplier id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    $supplier = $this->Suppliers->get($id);//選んだidに関するSuppliersテーブルのデータに$supplierと名前を付ける
	$this->set('supplier',$supplier);//1行上の$supplierをctpで使えるようにセット

	$updated_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$updated_staffという名前を付ける
	$supplier['updated_staff'] = $updated_staff;//$supplierのupdated_staffを$updated_staffにする

		if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
			$supplier = $this->Suppliers->patchEntity($supplier, $this->request->getData());//121行目でとったもともとの$supplierデータを$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
    			// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Suppliers->save($supplier)) {
					$this->Flash->success(__('The supplier has been updated.'));
					$connection->commit();//コミット5
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The supplier could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
    		//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }

}
