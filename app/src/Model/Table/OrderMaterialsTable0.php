<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * OrderMaterials Model
 *
 * @property \App\Model\Table\SupsTable|\Cake\ORM\Association\BelongsTo $Sups
 *
 * @method \App\Model\Entity\OrderMaterial get($primaryKey, $options = [])
 * @method \App\Model\Entity\OrderMaterial newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\OrderMaterial[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\OrderMaterial|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\OrderMaterial patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\OrderMaterial[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\OrderMaterial findOrCreate($search, callable $callback = null, $options = [])
 */
class OrderMaterialsTable extends Table
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

        $this->setTable('order_materials');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Sups', [
            'foreignKey' => 'sup_id'
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
            ->scalar('id_order')
            ->maxLength('id_order', 12)
            ->requirePresence('id_order', 'create')
            ->notEmpty('id_order');

        $validator
            ->scalar('grade')
            ->maxLength('grade', 20)
            ->requirePresence('grade', 'create')
            ->notEmpty('grade');

        $validator
            ->scalar('color')
            ->maxLength('color', 20)
            ->requirePresence('color', 'create')
            ->notEmpty('color');

        $validator
            ->date('date_order')
            ->requirePresence('date_order', 'create')
            ->notEmpty('date_order');

        $validator
            ->date('date_stored')
            ->requirePresence('date_stored', 'create')
            ->notEmpty('date_stored');

        $validator
            ->numeric('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->scalar('deliv_cp')
            ->maxLength('deliv_cp', 4)
            ->requirePresence('deliv_cp', 'create')
            ->notEmpty('deliv_cp');

        $validator
            ->scalar('purchaser')
            ->maxLength('purchaser', 8)
            ->requirePresence('purchaser', 'create')
            ->notEmpty('purchaser');

        $validator
            ->integer('check_flag')
            ->requirePresence('check_flag', 'create')
            ->notEmpty('check_flag');

        $validator
            ->scalar('flg')
            ->maxLength('flg', 2)
            ->requirePresence('flg', 'create')
            ->notEmpty('flg');

        $validator
            ->date('first_date_st')
            ->allowEmpty('first_date_st');

        $validator
            ->date('real_date_st')
            ->allowEmpty('real_date_st');

        $validator
            ->scalar('num_lot')
            ->maxLength('num_lot', 30)
            ->allowEmpty('num_lot');

        $validator
            ->numeric('price')
            ->allowEmpty('price');

        $validator
            ->integer('delete_flag')
            ->requirePresence('delete_flag', 'create')
            ->notEmpty('delete_flag');

        $validator
            ->dateTime('created_at')
            ->allowEmpty('created_at');

        $validator
            ->integer('created_staff')
            ->allowEmpty('created_staff');

        $validator
            ->dateTime('updated_at')
            ->allowEmpty('updated_at');

        $validator
            ->integer('updated_staff')
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
//        $rules->add($rules->existsIn(['sup_id'], 'Sups'));
        $rules->add($rules->isUnique(['id_order']));

        return $rules;
    }
}
