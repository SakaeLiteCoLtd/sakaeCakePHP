<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Suppliers Model
 *
 * @method \App\Model\Entity\Supplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\Supplier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Supplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier findOrCreate($search, callable $callback = null, $options = [])
 */
class SuppliersTable extends Table
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

        $this->setTable('suppliers');
//        $this->setDisplayField('name');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'created_staff',
            'joinType' => 'LEFT'//
        ]);

        $this->belongsTo('SupplierSections', [
            'foreignKey' => 'supplier_section_id',
            'joinType' => 'LEFT'//
        ]);

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
//            ->scalar('supplier_code')
            ->maxLength('supplier_section_id', 255)
            ->requirePresence('supplier_section_id', 'create')
            ->notEmpty('supplier_section_id');

        $validator
//            ->scalar('supplier_code')
            ->maxLength('supplier_code', 255)
            ->requirePresence('supplier_code', 'create')
            ->notEmpty('supplier_code');

        $validator
//            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
//            ->scalar('zip')
            ->maxLength('zip', 7)
//            ->requirePresence('zip', 'create')
//            ->notEmpty('zip');
            ->allowEmpty('zip');

        $validator
//            ->scalar('address')
            ->maxLength('address', 255)
            ->requirePresence('address', 'create')
//            ->notEmpty('address');
            ->allowEmpty('address');

        $validator
//            ->scalar('tel')
            ->maxLength('tel', 255)
            ->requirePresence('tel', 'create')
//            ->notEmpty('tel');
            ->allowEmpty('tel');

        $validator
//            ->scalar('fax')
            ->maxLength('fax', 255)
            ->requirePresence('fax', 'create')
//            ->notEmpty('fax');
            ->allowEmpty('fax');

        $validator
//            ->scalar('charge_p')
            ->maxLength('charge_p', 255)
            ->requirePresence('charge_p', 'create')
            ->notEmpty('charge_p');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
//            ->notEmpty('status');
            ->allowEmpty('status');

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

    public function buildRules(RulesChecker $rules)
    {
//        $rules->add($rules->isUnique(['username']));
        $rules->add($rules->existsIn(['supplier_section_id'], 'SupplierSections'));

        return $rules;
    }

}
