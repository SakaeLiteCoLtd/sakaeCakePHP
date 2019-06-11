<?php
namespace App\Controller;

use App\Controller\AppController;
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
class StaffsController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	    ];

    public function index()
    {
		if ($this->request->is('post')) {//postの場合
			$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
			$idSearch = $data['staff_code'];//$dataのstaff_codeに$idSearchという名前を付ける
			$f_nameSearch = $data['f_name'];//$dataのnameに$nameSearchという名前を付ける
			$l_nameSearch = $data['l_name'];//$dataのnameに$nameSearchという名前を付ける
	
			$this->set('staffs',$this->Staffs->find()//以下の条件を満たすデータをStaffsテーブルから見つける
				->where(['delete_flag' => '0', //'delete_flag' => '0'である
				'OR' => [['staff_code like' => '%'.$idSearch.'%'], ['f_name like' => '%'.$f_nameSearch.'%'], ['l_name like' => '%'.$l_nameSearch.'%']]]));//staff_codeに$idSearchが含まれるまたはf_nameに$nameSearchが含まれるまたはl_nameに$nameSearchが含まれる
		} else {
			$this->set('staffs', $this->Staffs->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
			$this->set('staffs', $this->paginate());//定義したページネーションを使用
		}
			$staffs = $this->paginate($this->Staffs);
			$this->set('entity',$this->Staffs->newEntity());//newentityにentityという名前を付け、ctpで使えるようにセット
    }

    public function form()
    {
	$staff = $this->Staffs->newEntity();//newentityに$staffという名前を付ける
	$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット

	$staff_id = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$staff_idという名前を付ける
	$staff['created_staff'] = $staff_id;//$staffのcreated_staffを$staff_idにする
    }

     public function confirm()
    {
	$staff = $this->Staffs->newEntity();//newentityに$staffという名前を付ける
	$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット
    }

     public function do()
    {
	$staff = $this->Staffs->newEntity();//newentityに$staffという名前を付ける
	$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット

	$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
	$created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffという名前を付ける
	$Created = $this->Staffs->find()->where(['id' => $created_staff])->toArray();//'id' => $created_staffとなるデータをStaffsテーブルから配列で取得
	$CreatedStaff = $Created[0]->f_name.$Created[0]->l_name;//配列の0番目（0番目しかない）のf_nameとl_nameをつなげたものに$CreatedStaffと名前を付ける
	$this->set('CreatedStaff',$CreatedStaff);//登録者の表示のため1行上の$CreatedStaffをctpで使えるようにセット

		if ($this->request->is('post')) {//postの場合
			$staff = $this->Staffs->patchEntity($staff, $this->request->getData());//$staffデータ（空の行）を$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Staffs->save($staff)) {
					$connection->commit();// コミット5
				} else {
					$this->Flash->error(__('The staff could not be saved. Please, try again.'));
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
	$staff = $this->Staffs->newEntity();//newentityに$staffという名前を付ける
	$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット

    $fp = fopen("employee.csv", "r");//csvファイルはwebrootに入れる
    $this->set('fp',$fp);
                    
    $fpcount = fopen("employee.csv", 'r' );
    for( $count = 0; fgets( $fpcount ); $count++ );
        $this->set('count',$count);
        
        $arrFp = array();//空の配列を作る
//        $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
        for ($k=1; $k<=$count; $k++) {//行数分
            $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
            $sample = explode(',',$line);//$lineを","毎に配列に入れる
                        
            $keys=array_keys($sample);
            $keys[array_search('0',$keys)]='staff_code';//名前の変更
            $keys[array_search('1',$keys)]='f_name';
            $keys[array_search('2',$keys)]='l_name';
            $keys[array_search('3',$keys)]='mail';
            $keys[array_search('5',$keys)]='status';
            $sample = array_combine( $keys, $sample );
                        
            unset($sample['4']);//status_leaderを削除
                        
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
            	    echo "<pre>";
//                    print_r($data);
                    var_dump($data);
                    echo "<br>";

	$staff = $this->Staffs->newEntity();//newentityに$staffという名前を付ける
	$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット

			if ($this->request->is('post')) {//postなら登録
				$staff = $this->Staffs->patchEntities($staff, $this->request->getData('staffdata'));//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->Staffs->saveMany($staff)) {//saveManyで一括登録
							$connection->commit();// コミット5
						} else {
							$this->Flash->error(__('The Staffs could not be saved. Please, try again.'));
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
     * @param string|null $id Staff id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)//edit以外の名前でもupdateされる
    {
    $staff = $this->Staffs->get($id);//選んだidに関するStaffsテーブルのデータに$staffと名前を付ける
	$this->set('staff',$staff);//1行上の$staffをctpで使えるようにセット
	$updated_staff = $this->Auth->user('staff_id');//ログイン中のuserのstaff_idに$updated_staffという名前を付ける
	$staff['updated_staff'] = $updated_staff;//$staffのupdated_staffを$updated_staffにする

		if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
			$staff = $this->Staffs->patchEntity($staff, $this->request->getData());//96行目でとったもともとの$roleデータを$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->Staffs->save($staff)) {
					$this->Flash->success(__('The staff has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The staff could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }

}
