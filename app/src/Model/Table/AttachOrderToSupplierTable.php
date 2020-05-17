<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AttachOrderToSupplier Model
 *
 * @property \App\Model\Table\KariOrderToSuppliersTable|\Cake\ORM\Association\BelongsTo $KariOrderToSuppliers
 *
 * @method \App\Model\Entity\AttachOrderToSupplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\AttachOrderToSupplier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AttachOrderToSupplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AttachOrderToSupplier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AttachOrderToSupplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AttachOrderToSupplier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AttachOrderToSupplier findOrCreate($search, callable $callback = null, $options = [])
 */
class AttachOrderToSupplierTable extends Table
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

        $this->setTable('attach_order_to_supplier');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('KariOrderToSuppliers', [
            'foreignKey' => 'kari_order_to_supplier_id',
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
            ->scalar('id_order')
            ->maxLength('id_order', 255)
            ->requirePresence('id_order', 'create')
            ->notEmpty('id_order');

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
        $rules->add($rules->existsIn(['kari_order_to_supplier_id'], 'KariOrderToSuppliers'));

        return $rules;
    }
}
