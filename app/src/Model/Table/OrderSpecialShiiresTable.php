<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderSpecialShiires Model
 *
 * @property \App\Model\Table\ProductSuppliersTable|\Cake\ORM\Association\BelongsTo $ProductSuppliers
 *
 * @method \App\Model\Entity\OrderSpecialShiire get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderSpecialShiire newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderSpecialShiire[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderSpecialShiire|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderSpecialShiire patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderSpecialShiire[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderSpecialShiire findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderSpecialShiiresTable extends Table
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

        $this->setTable('order_special_shiires');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ProductSuppliers', [
            'foreignKey' => 'product_supplier_id',
            'joinType' => 'INNER'
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
            ->integer('from_order')
            ->allowEmpty('from_order');

        $validator
            ->scalar('num_order')
            ->maxLength('num_order', 20)
            ->requirePresence('num_order', 'create')
            ->notEmpty('num_order');

        $validator
            ->scalar('order_name')
            ->maxLength('order_name', 50)
            ->requirePresence('order_name', 'create')
            ->notEmpty('order_name');

        $validator
            ->numeric('price')
            ->allowEmpty('price');

        $validator
            ->date('date_deliver')
            ->requirePresence('date_deliver', 'create')
            ->notEmpty('date_deliver');

        $validator
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->integer('kannou')
            ->requirePresence('kannou', 'create')
            ->notEmpty('kannou');

        $validator
            ->dateTime('check_kannou')
            ->allowEmpty('check_kannou');

        $validator
            ->integer('delete_flag')
            ->requirePresence('delete_flag', 'create')
            ->notEmpty('delete_flag');

        $validator
            ->integer('created_staff')
            ->allowEmpty('created_staff');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->integer('updated_staff')
            ->allowEmpty('updated_staff');

        $validator
            ->dateTime('updated_at')
            ->allowEmpty('updated_at');

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
        $rules->add($rules->existsIn(['product_supplier_id'], 'ProductSuppliers'));

        return $rules;
    }
}
