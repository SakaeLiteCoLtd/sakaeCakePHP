<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

/**
 * MaterialTypes Controller
 *
 * @property \App\Model\Table\MaterialTypesTable $MaterialTypes
 *
 * @method \App\Model\Entity\MaterialType[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MaterialTypesController extends AppController
{

	public $paginate = [//ページネーションを定義（indexで使う）
	        'limit' => 20,//データを1ページに20個ずつ表示する
			'conditions' => ['delete_flag' => '0']//'delete_flag' => '0'を満たすものだけ表示する
	    ];

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->set('materialType', $this->MaterialTypes->find('all'));//テーブルから'delete_flag' => '0'となるものを見つける※ページネーションに条件を追加してある
		$this->set('materialType', $this->paginate());//※ページネーションに必要
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
	$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
	$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット
    }

     public function confirm()
    {
	$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
	$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット
    }

     public function do()
    {
	$materialType = $this->MaterialTypes->newEntity();//newentityに$materialTypeという名前を付ける
	$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット

		if ($this->request->is('post')) {//postの場合
			$supplierSection = $this->MaterialTypes->patchEntity($materialType, $this->request->getData());//$materialTypeデータ（空の行）を$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
			// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->MaterialTypes->save($materialType)) {
					$connection->commit();// コミット5
				} else {
					$this->Flash->error(__('The materialType could not be saved. Please, try again.'));
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
     * @param string|null $id Material Type id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
    $materialType = $this->MaterialTypes->get($id);//選んだidに関するMaterialTypesテーブルのデータに$materialTypeと名前を付ける
	$this->set('materialType',$materialType);//1行上の$materialTypeをctpで使えるようにセット

		if ($this->request->is(['patch', 'post', 'put'])) {//'patch', 'post', 'put'の場合
			$materialType = $this->MaterialTypes->patchEntity($materialType, $this->request->getData());//98行目でとったもともとの$materialTypeデータを$this->request->getData()に更新する
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
				if ($this->MaterialTypes->save($materialType)) {
					$this->Flash->success(__('The materialType has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The materialType could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }

}
