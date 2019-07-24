<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ImKikakus Controller
 *
 * @property \App\Model\Table\ImKikakusTable $ImKikakus
 *
 * @method \App\Model\Entity\ImKikakus[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ImKikakusController extends AppController
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
        $imKikakus = $this->paginate($this->ImKikakus);

        $this->set(compact('imKikakus'));
    }

    /**
     * View method
     *
     * @param string|null $id Im Kikakus id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $imKikakus = $this->ImKikakus->get($id, [
            'contain' => ['ImSokuteidataHeads']
        ]);

        $this->set('imKikakus', $imKikakus);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $imKikakus = $this->ImKikakus->newEntity();
        if ($this->request->is('post')) {
            $imKikakus = $this->ImKikakus->patchEntity($imKikakus, $this->request->getData());
            if ($this->ImKikakus->save($imKikakus)) {
                $this->Flash->success(__('The im kikakus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The im kikakus could not be saved. Please, try again.'));
        }
        $imSokuteidataHeads = $this->ImKikakus->ImSokuteidataHeads->find('list', ['limit' => 200]);
        $this->set(compact('imKikakus', 'imSokuteidataHeads'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Im Kikakus id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $imKikakus = $this->ImKikakus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $imKikakus = $this->ImKikakus->patchEntity($imKikakus, $this->request->getData());
            if ($this->ImKikakus->save($imKikakus)) {
                $this->Flash->success(__('The im kikakus has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The im kikakus could not be saved. Please, try again.'));
        }
        $imSokuteidataHeads = $this->ImKikakus->ImSokuteidataHeads->find('list', ['limit' => 200]);
        $this->set(compact('imKikakus', 'imSokuteidataHeads'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Im Kikakus id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $imKikakus = $this->ImKikakus->get($id);
        if ($this->ImKikakus->delete($imKikakus)) {
            $this->Flash->success(__('The im kikakus has been deleted.'));
        } else {
            $this->Flash->error(__('The im kikakus could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
