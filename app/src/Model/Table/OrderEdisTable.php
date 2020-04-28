<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderEdis Model
 *
 * @method \App\Model\Entity\OrderEdi get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderEdi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderEdi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderEdi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderEdi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderEdi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderEdi findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderEdisTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('order_edis');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->date('date_order')
            ->requirePresence('date_order', 'create')
            ->notEmpty('date_order');

        $validator
            ->scalar('num_order')
            ->maxLength('num_order', 20)
            ->requirePresence('num_order', 'create')
            ->notEmpty('num_order');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 30)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->numeric('price')
            ->allowEmpty('price');

        $validator
            ->date('date_deliver')
            ->requirePresence('date_deliver', 'create')
            ->notEmpty('date_deliver');

        $validator
            ->date('first_date_deliver')
            ->allowEmpty('first_date_deliver');

        $validator
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->scalar('customer_code')
            ->maxLength('customer_code', 20)
            ->allowEmpty('customer_code');

        $validator
            ->scalar('place_deliver_code')
            ->maxLength('place_deliver_code', 20)
            ->allowEmpty('place_deliver_code');

        $validator
            ->scalar('place_line')
            ->maxLength('place_line', 30)
            ->requirePresence('place_line', 'create')
            ->notEmpty('place_line');

        $validator
            ->scalar('line_code')
            ->maxLength('line_code', 30)
            ->allowEmpty('line_code');

        $validator
            ->scalar('check_denpyou')
            ->maxLength('check_denpyou', 2)
            ->requirePresence('check_denpyou', 'create')
            ->notEmpty('check_denpyou');
/*
        $validator
            ->scalar('gaityu')
            ->maxLength('gaityu', 2)
            ->allowEmpty('gaityu');
*/
        $validator
            ->integer('bunnou')
            ->requirePresence('bunnou', 'create')
            ->notEmpty('bunnou');

        $validator
            ->integer('kannou')
            ->requirePresence('kannou', 'create')
            ->notEmpty('kannou');

        $validator
            ->date('date_bunnou')
            ->allowEmpty('date_bunnou');

        $validator
            ->dateTime('check_kannou')
            ->allowEmpty('check_kannou');

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
            ->integer('created_staff')
            ->requirePresence('created_staff', 'create')
            ->notEmpty('created_staff');
/*
        $validator
            ->dateTime('updated_at')
            ->allowEmpty('updated_at');
*/
        $validator
            ->integer('updated_staff')
            ->allowEmpty('updated_staff');

        return $validator;
    }

        public function buildRules(RulesChecker $rules)
        {
    //    $rules->add($rules->isUnique(['date_deliver','place_deliver_code','product_code','amount','delete_flag']));
        $rules->add($rules->isUnique(['date_order','date_deliver','num_order','line_code','product_code','delete_flag']));

            return $rules;
        }

}
