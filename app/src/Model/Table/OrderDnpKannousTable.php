<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderDnpKannous Model
 *
 * @method \App\Model\Entity\OrderDnpKannous get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderDnpKannous newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderDnpKannous[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderDnpKannous|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderDnpKannous patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDnpKannous[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderDnpKannous findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderDnpKannousTable extends Table
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

        $this->setTable('order_dnp_kannous');
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
            ->scalar('code')
            ->maxLength('code', 20)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        $validator
            ->integer('bunnou')
            ->requirePresence('bunnou', 'create')
            ->notEmpty('bunnou');

        $validator
            ->date('date_deliver')
            ->requirePresence('date_deliver', 'create')
            ->notEmpty('date_deliver');

        $validator
            ->integer('amount')
            ->allowEmpty('amount');

        $validator
            ->integer('minoukannou')
            ->allowEmpty('minoukannou');

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
        $rules->add($rules->isUnique(['date_order','num_order','product_code','code','bunnou','date_deliver','delete_flag']));

        return $rules;
    }
}
