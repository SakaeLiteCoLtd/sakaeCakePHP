<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Konpous Model
 *
 * @method \App\Model\Entity\Konpous get($primaryKey, $options = [])
 * @method \App\Model\Entity\Konpous newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Konpous[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Konpous|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Konpous|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Konpous patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Konpous[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Konpous findOrCreate($search, callable $callback = null, $options = [])
 */
class KonpousTable extends Table
{
  public function beforeFilter(Event $event)//
  {
      parent::beforeFilter($event);
      $this->Auth->allow(['add', 'logout']);
  }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('konpous');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp', [
          'events' => [
            'Model.beforeSave' => [
              'created_at' => 'new',
              'updated_at' => 'existing'
            ]
          ]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 30)
            ->allowEmpty('product_code', 'create');

        $validator
            ->integer('irisu')
            ->requirePresence('irisu', 'create')
            ->notEmpty('irisu');

        $validator
            ->scalar('id_box')
            ->maxLength('id_box', 5)
            ->requirePresence('id_box', 'create')
            ->notEmpty('id_box');

        $validator
            ->integer('delete_flag')
            ->requirePresence('delete_flag', 'create')
            ->notEmpty('delete_flag');
            /*
                    $validator
                        ->dateTime('created_at')
                        ->requirePresence('created_at', 'create')
                        ->notEmpty('created_at');
            */
        $validator
            ->uuid('created_staff')
            ->requirePresence('created_staff', 'create')
            ->notEmpty('created_staff');
            /*
                    $validator
                        ->dateTime('updated_at')
                        ->allowEmpty('updated_at');
            */
        $validator
            ->uuid('updated_staff')
            ->allowEmpty('updated_staff');

        return $validator;
    }
}
