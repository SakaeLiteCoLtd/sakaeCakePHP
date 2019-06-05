<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * Materials Controller
 *
 * @property \App\Model\Table\MaterialsTable $Materials
 *
 * @method \App\Model\Entity\Material[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MaterialsController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	    ];

     public function initialize()
     {
	parent::initialize();
	$this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
	$this->Suppliers = TableRegistry::get('suppliers');//suppliersテーブルを使う
	$this->MaterialTypes = TableRegistry::get('materialTypes');//materialTypesテーブルを使う
     }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
		$this->set('entity',$this->Materials->newEntity());//newentityをentityという名前でセット
		if ($this->request->is('post')) {//postだったら次の処理へ
			$data = $this->request->getData();//indexのフォームからの全POSTデータ取得
			$gradeSearch = $data['grade'];//$dataの中のgradeに$gradeSearchと名前を付ける
			$colorSearch = $data['color'];//$dataの中のcolorに$colorSearchと名前を付ける
	
			$this->set('materials',$this->Materials->find()//Materialsテーブルの中で次の条件を満たすものをmaterialsにセットする
				->where(['delete_flag' => '0',//'delete_flag' => '0'である
				'OR' => [['grade like' => '%'.$gradeSearch.'%'], ['color like' => '%'.$colorSearch.'%']]]));//gradeに$gradeSearchが含まれるまたはcolorに$colorSearchが含まれる
	
		} else {//postじゃなかったら
			$this->set('materials', $this->Materials->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('materials', $this->paginate());//定義したページネーションを使用
		}
			$materials = $this->paginate($this->Materials);//
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

    public function form()
    {
		$material = $this->Materials->newEntity();//newentityに$materialという名前を付ける
		$this->set('material',$material);//1行上の$materialをctpで使えるようにセット
	
		$arrMaterialTypes = $this->MaterialTypes->find('all', ['conditions' => ['delete_flag' => '0']])->order(['name' => 'ASC']);//MaterialTypesテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
		$arrMaterialType = array();//配列の初期化
		foreach ($arrMaterialTypes as $value) {//2行上のMaterialTypesテーブルのデータそれぞれに対して
			$arrMaterialType[] = array($value->id=>$value->name);//配列に3行上のMaterialTypesテーブルのデータそれぞれのname
		}
		$this->set('arrMaterialType',$arrMaterialType);//4行上$arrMaterialTypeをctpで使えるようにセット
	
		$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
		$material['created_staff'] = $staff_id;//$materialのupdated_staffを$staff_idにする
    }

     public function confirm()
    {
	$material = $this->Materials->newEntity();//newentityに$materialという名前を付ける
	$this->set('material',$material);//1行上の$materialをctpで使えるようにセット
    }

     public function do()
    {
	$material = $this->Materials->newEntity();//newentityに$materialという名前を付ける
	$this->set('material',$material);//1行上の$materialをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

		if ($this->request->is('post')) {//postの場合
			$material = $this->Materials->patchEntity($material, $this->request->getData());//$materialデータ（空の行）を$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Materials->save($material)) {
					$connection->commit();// コミット5
				} else {
					$this->Flash->error(__('The materials could not be saved. Please, try again.'));
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
	$material = $this->Materials->newEntity();//newentityに$materialという名前を付ける
	$this->set('material',$material);//1行上の$materialをctpで使えるようにセット
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
        for ($k=1; $k<=$count-1; $k++) {//行数分
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
            
            array_push($sample, '0', $staff_id, $sample[1].$sample[2]);//配列に追加
            
            $keys=array_keys($sample);
//            $keys[array_search('0',$keys)]='material_id';//名前の変更
            $keys[array_search('1',$keys)]='grade';//名前の変更
            $keys[array_search('2',$keys)]='color';
            $keys[array_search('5',$keys)]='tani';//245行目がnull
            $keys[array_search('10',$keys)]='delete_flag';//追加した配列の値
            $keys[array_search('13',$keys)]='status';//追加した配列の値
            $keys[array_search('14',$keys)]='created_staff';//追加した配列の値
            $keys[array_search('15',$keys)]='unique';//追加した配列の値

            $sample = array_combine($keys, $sample );
            
            unset($sample['0']);//削除
            unset($sample['3']);//削除
            unset($sample['4']);//削除
            unset($sample['6']);//削除
            unset($sample['7']);//削除
            unset($sample['8']);//削除
            unset($sample['9']);//削除
            unset($sample['11']);//削除
            unset($sample['12']);//削除

            $arrFp[] = $sample;//配列に追加する
        }
        //以下grade.colorが重複しているものを削除する（delete_flag=1になるものも削除）
        $arrFpU = array();
        $array_unique = array();
		foreach( $arrFp as $key => $value ){
//			  if( $value['delete_flag']==0 & !in_array( $value['unique'], $arrFpU ) ) {// delete_flag=0　かつ　配列に値が見つからなければ$arrFpに格納
			  if( !in_array( $value['unique'], $arrFpU ) ) {
			   $arrFpU[] = $value['unique'];
	           unset($value['unique']);//uniqueを削除
			   $array_unique[] = $value;
			  }
		 }

        $this->set('array_unique',$array_unique);//$arrFpをctpで使用できるようセット
//            	    echo "<pre>";
//                    print_r($array_unique);
//                    echo "<br>";

	$material = $this->Materials->newEntity();//newentityに$materialという名前を付ける
	$this->set('material',$material);//1行上の$materialをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$material = $this->Materials->patchEntities($material, $array_unique);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->Materials->saveMany($material)) {//saveManyで一括登録
							$connection->commit();// コミット5
						} else {
							$this->Flash->error(__('The Materials could not be saved. Please, try again.'));
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
     * @param string|null $id Material id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
		$material = $this->Materials->get($id);//選んだidに関するMaterialsテーブルのデータに$materialと名前を付ける
		$this->set('material',$material);//1行上の$materialをctpで使えるようにセット
		
		$arrMaterialTypes = $this->MaterialTypes->find('all', ['conditions' => ['delete_flag' => '0']])->order(['name' => 'ASC']);//Customersテーブルの'delete_flag' => '0'となるものを見つけ、id順に並べる
		$arrMaterialType = array();//配列の初期化
		foreach ($arrMaterialTypes as $value) {//2行上のMaterialTypesテーブルのデータそれぞれに対して
			$arrMaterialType[] = array($value->id=>$value->name);//配列に3行上のMaterialTypesテーブルのデータそれぞれのname
		}
		$this->set('arrMaterialType',$arrMaterialType);//4行上$arrMaterialTypeをctpで使えるようにセット
	
		$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
		$material['updated_staff'] = $staff_id;//$materialのupdated_staffを$staff_idにする
	
			if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
				$material = $this->Materials->patchEntity($material, $this->request->getData());//110行目でとったもともとの$materialデータを$this->request->getData()に更新する
				$connection = ConnectionManager::get('default');//トランザクション1
					// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
					if ($this->Materials->save($material)) {
						$this->Flash->success(__('The material has been updated.'));
						$connection->commit();// コミット5
						return $this->redirect(['action' => 'index']);
					} else {
						$this->Flash->error(__('The material could not be updated. Please, try again.'));
						throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
					}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}
    }

}
