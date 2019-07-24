<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ImSokuteidataResults Controller
 *
 * @property \App\Model\Table\ImSokuteidataResultsTable $ImSokuteidataResults
 *
 * @method \App\Model\Entity\ImSokuteidataResult[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImSokuteidataResultsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ImSokuteidataHeads']
        ];
        $imSokuteidataResults = $this->paginate($this->ImSokuteidataResults);

        $this->set(compact('imSokuteidataResults'));
    }

    /**
     * View method
     *
     * @param string|null $id Im Sokuteidata Result id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $imSokuteidataResult = $this->ImSokuteidataResults->get($id, [
            'contain' => ['ImSokuteidataHeads']
        ]);

        $this->set('imSokuteidataResult', $imSokuteidataResult);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $imSokuteidataResult = $this->ImSokuteidataResults->newEntity();
        if ($this->request->is('post')) {
            $imSokuteidataResult = $this->ImSokuteidataResults->patchEntity($imSokuteidataResult, $this->request->getData());
            if ($this->ImSokuteidataResults->save($imSokuteidataResult)) {
                $this->Flash->success(__('The im sokuteidata result has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The im sokuteidata result could not be saved. Please, try again.'));
        }
        $imSokuteidataHeads = $this->ImSokuteidataResults->ImSokuteidataHeads->find('list', ['limit' => 200]);
        $this->set(compact('imSokuteidataResult', 'imSokuteidataHeads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Im Sokuteidata Result id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $imSokuteidataResult = $this->ImSokuteidataResults->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $imSokuteidataResult = $this->ImSokuteidataResults->patchEntity($imSokuteidataResult, $this->request->getData());
            if ($this->ImSokuteidataResults->save($imSokuteidataResult)) {
                $this->Flash->success(__('The im sokuteidata result has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The im sokuteidata result could not be saved. Please, try again.'));
        }
        $imSokuteidataHeads = $this->ImSokuteidataResults->ImSokuteidataHeads->find('list', ['limit' => 200]);
        $this->set(compact('imSokuteidataResult', 'imSokuteidataHeads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Im Sokuteidata Result id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $imSokuteidataResult = $this->ImSokuteidataResults->get($id);
        if ($this->ImSokuteidataResults->delete($imSokuteidataResult)) {
            $this->Flash->success(__('The im sokuteidata result has been deleted.'));
        } else {
            $this->Flash->error(__('The im sokuteidata result could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
