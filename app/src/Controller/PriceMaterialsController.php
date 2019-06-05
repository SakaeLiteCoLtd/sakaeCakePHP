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

    public function form1()
    {
    	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$materialという名前を付ける
        $this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

            $arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
            $arrMaterial = array();//配列の初期化
            foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
                $arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:colorで追加
            }
            $this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット
    
            $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['supplier_code' => 'ASC']);//Suppliersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
            $arrSupplier = array();//配列の初期化
            foreach ($arrSuppliers as $value) {//2行上のSuppliersテーブルのデータそれぞれに対して
                $arrSupplier[] = array($value->id=>$value->supplier_code.':'.$value->name);//配列に3行上のSuppliersテーブルのデータそれぞれのsupplier_code:nameで追加
            }
            $this->set('arrSupplier',$arrSupplier);//4行上$arrSupplierをctpで使えるようにセット
    
    	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
    	$priceMaterial['created_staff'] = $staff_id;//$priceMaterialのupdated_staffを$staff_idにする
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
    
            $arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
            $arrMaterial = array();//配列の初期化
            foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
                $arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:colorで追加
            }
            $this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット
    
            $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['supplier_code' => 'ASC']);//Suppliersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
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
    }

     public function do()
    {
	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
    $this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

    	if ($this->request->is('post')) {//postの場合
    		$priceMaterial = $this->PriceMaterials->patchEntity($priceMaterial, $this->request->getData());//$priceMaterialデータ（空の行）を$this->request->getData()に更新する
    		$connection = ConnectionManager::get('default');//トランザクション1
    		// トランザクション開始2
    		$connection->begin();//トランザクション3
    		try {//トランザクション4
    			if ($this->PriceMaterials->save($priceMaterial)) {
    				$connection->commit();// コミット5
    			} else {
    				$this->Flash->error(__('The priceMaterial could not be saved. Please, try again.'));
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
	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
    $this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット
    }

     public function docsv()
    {
    $staff_id = $this->Auth->user('staff_id');
	$this->set('staff_id',$staff_id);//1行上の$supplierをctpで使えるようにセット

    $fp = fopen("price_material.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
                    
    $fpcount = fopen("price_material.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
        $this->set('count',$count);
        
        $arrFp = array();//空の配列を作る
        $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目はカラム名なので先に取っておく）
        for ($k=1; $k<=$count-1; $k++) {//行数分160~170あたりにいけないのがある
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
            
            array_push($sample, '0', $staff_id);//配列に追加
            
            $keys=array_keys($sample);
            $keys[array_search('0',$keys)]='material_id';//名前の変更
            $keys[array_search('3',$keys)]='start';//名前の変更
            $keys[array_search('4',$keys)]='price';
            $keys[array_search('6',$keys)]='lot_low';
            $keys[array_search('7',$keys)]='lot_upper';
            $keys[array_search('8',$keys)]='supplier_id';//supplier_id=9999となるデータが入っていなかったので、「仮登録」というデータを入れておいた
            $keys[array_search('10',$keys)]='delete_flag';//追加した配列の値
            $keys[array_search('13',$keys)]='status';//追加した配列の値
            $keys[array_search('14',$keys)]='created_staff';//追加した配列の値

            $sample = array_combine($keys, $sample );
            
            $Material = $this->Materials->find()->where([['grade' => $sample[1]], ['color' => $sample[2]]])->toArray();//'role_code' => $sample5となるデータをRolesテーブルから配列で取得
            $material_id = $Material[0]->id;//配列の0番目（0番目しかない）のidに$role_idと名前を付ける
            
            $replacements = array('material_id' => $material_id);//配列のデータの置き換え（customer_codeを$customer_idに変更）
            $sample = array_replace($sample, $replacements);//配列のデータの置き換え（customer_codeを$customer_idに変更）
            
            $Supplier = $this->Suppliers->find()->where(['supplier_code' => $sample['supplier_id']])->toArray();//'role_code' => $sample5となるデータをRolesテーブルから配列で取得
            $supplier_id = $Supplier[0]->id;//配列の0番目（0番目しかない）のidに$role_idと名前を付ける
            
            $replacements = array('supplier_id' => $supplier_id);//配列のデータの置き換え（customer_codeを$customer_idに変更）
            $sample = array_replace($sample, $replacements);//配列のデータの置き換え（customer_codeを$customer_idに変更）
            
            unset($sample['1']);//削除
            unset($sample['2']);//削除
            unset($sample['5']);//削除
            unset($sample['8']);//削除
            unset($sample['9']);//削除
            unset($sample['11']);//削除
            unset($sample['12']);//削除

            $arrFp[] = $sample;//配列に追加する
        }
        $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット
//            	    echo "<pre>";
//                    print_r($arrFp[0]);
//                    print_r($arrFp);
//                    echo "<br>";

	$priceMaterial = $this->PriceMaterials->newEntity();//newentityに$priceMaterialという名前を付ける
    $this->set('priceMaterial',$priceMaterial);//1行上の$priceMaterialをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$priceMaterial = $this->PriceMaterials->patchEntities($priceMaterial, $arrFp);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->PriceMaterials->saveMany($priceMaterial)) {//saveManyで一括登録
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

            $arrMaterials = $this->Materials->find('all', ['conditions' => ['delete_flag' => '0']])->order(['grade' => 'ASC']);//Materialsテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
            $arrMaterial = array();//配列の初期化
            foreach ($arrMaterials as $value) {//2行上のMaterialsテーブルのデータそれぞれに対して
                $arrMaterial[] = array($value->id=>$value->grade.':'.$value->color);//配列に3行上のMaterialsテーブルのデータそれぞれのgrade:colorで追加
            }
            $this->set('arrMaterial',$arrMaterial);//4行上$arrMaterialをctpで使えるようにセット
    
            $arrSuppliers = $this->Suppliers->find('all', ['conditions' => ['delete_flag' => '0']])->order(['supplier_code' => 'ASC']);//Suppliersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
            $arrSupplier = array();//配列の初期化
            foreach ($arrSuppliers as $value) {//2行上のSuppliersテーブルのデータそれぞれに対して
                $arrSupplier[] = array($value->id=>$value->supplier_code.':'.$value->name);//配列に3行上のSuppliersテーブルのデータそれぞれのsupplier_code
            }
            $this->set('arrSupplier',$arrSupplier);//4行上$arrSupplierをctpで使えるようにセット

    	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
    	$priceMaterial['created_staff'] = $staff_id;//$priceMaterialのupdated_staffを$staff_idにする

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
