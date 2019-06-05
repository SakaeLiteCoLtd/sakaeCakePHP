<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Materials Model
 *
 * @property \App\Model\Table\MaterialTypesTable|\Cake\ORM\Association\BelongsTo $MaterialTypes
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\BelongsTo $Suppliers
 *
 * @method \App\Model\Entity\Material get($primaryKey, $options = [])
 * @method \App\Model\Entity\Material newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Material[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Material|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Material|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Material patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Material[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Material findOrCreate($search, callable $callback = null, $options = [])
 */
class MaterialsTable extends Table
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

        $this->setTable('materials');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'created_staff',//�ύX
            'joinType' => 'LEFT'//
        ]);
        $this->belongsTo('MaterialTypes', [
            'foreignKey' => 'material_type_id',
            'joinType' => 'INNER'
        ]);
/*        $this->belongsTo('Suppliers', [
            'foreignKey' => 'supplier_id',
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
//            ->scalar('grade')
            ->maxLength('grade', 255)
            ->requirePresence('grade', 'create')
            ->notEmpty('grade');

        $validator
//            ->scalar('color')
            ->maxLength('color', 255)
            ->requirePresence('color', 'create')
            ->notEmpty('color');
/*//sakujo181109pricematerials
        $validator
            ->decimal('price')
            ->requirePresence('price', 'create')
            ->notEmpty('price');
*/
        $validator
//            ->scalar('tani')
            ->maxLength('tani', 255)
//            ->requirePresence('tani', 'create')
//            ->notEmpty('tani');
            ->allowEmpty('tani');//190401
/*//sakujo181109pricematerials
        $validator
            ->scalar('lot_low')
            ->maxLength('lot_low', 255)
            ->requirePresence('lot_low', 'create')
            ->notEmpty('lot_low');

        $validator
            ->scalar('lot_upper')
            ->maxLength('lot_upper', 255)
            ->requirePresence('lot_upper', 'create')
            ->notEmpty('lot_upper');
*/
        $validator
//            ->scalar('multiple_sup')
            ->maxLength('multiple_sup', 1)
//            ->requirePresence('multiple_sup', 'create')
//            ->notEmpty('multiple_sup');
            ->allowEmpty('multiple_sup');//190401

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
        $rules->add($rules->existsIn(['material_type_id'], 'MaterialTypes'));
//        $rules->add($rules->existsIn(['supplier_id'], 'Suppliers'));

        return $rules;
    }
}
