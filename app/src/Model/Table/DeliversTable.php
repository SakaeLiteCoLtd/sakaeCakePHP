<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Delivers Model
 *
 * @property \App\Model\Table\CustomersTable|\Cake\ORM\Association\BelongsTo $Customers
 * @property \App\Model\Table\PlaceDeliversTable|\Cake\ORM\Association\BelongsTo $PlaceDelivers
 *
 * @method \App\Model\Entity\Deliver get($primaryKey, $options = [])
 * @method \App\Model\Entity\Deliver newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Deliver[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Deliver|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Deliver|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Deliver patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Deliver[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Deliver findOrCreate($search, callable $callback = null, $options = [])
 */
class DeliversTable extends Table
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

        $this->setTable('delivers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');


        $this->belongsTo('Staffs', [
            'foreignKey' => 'created_staff',
            'joinType' => 'LEFT'//
        ]);

        $this->belongsTo('Customers', [
            'foreignKey' => 'customer_id',
            'joinType' => 'LEFT'
        ]);
/*        $this->belongsTo('PlaceDelivers', [
            'foreignKey' => 'place_deliver_id',
            'joinType' => 'INNER'
        ]);
*/
        $this->addBehavior('Timestamp', [//����created_at�Ƃ�������,add,edit������
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
//            ->scalar('place_deliver_id')
            ->maxLength('place_deliver_id', 255)
            ->requirePresence('place_deliver_id', 'create')
            ->allowEmpty('place_deliver_id');//allowEmpty�ɕύX

        $validator
//            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
//            ->scalar('zip')
            ->maxLength('zip', 7)
            ->requirePresence('zip', 'create')
            ->notEmpty('zip');

        $validator
//            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
//            ->scalar('tel')
            ->maxLength('tel', 255)
            ->requirePresence('tel', 'create')
            ->notEmpty('tel');

        $validator
//            ->scalar('fax')
            ->maxLength('fax', 255)
            ->requirePresence('fax', 'create')
            ->notEmpty('fax');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['customer_id'], 'Customers'));
//        $rules->add($rules->existsIn(['place_deliver_id'], 'PlaceDelivers'));

        return $rules;
    }
}
