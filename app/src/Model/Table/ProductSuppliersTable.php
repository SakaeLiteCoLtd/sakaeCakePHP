<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProductSuppliers Model
 *
 * @property \App\Model\Table\HandiesTable|\Cake\ORM\Association\BelongsTo $Handies
 * @property \App\Model\Table\OrderSpecialShiiresTable|\Cake\ORM\Association\HasMany $OrderSpecialShiires
 *
 * @method \App\Model\Entity\ProductSupplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\ProductSupplier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ProductSupplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ProductSupplier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ProductSupplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ProductSupplier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ProductSupplier findOrCreate($search, callable $callback = null, $options = [])
 */
class ProductSuppliersTable extends Table
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

        $this->setTable('product_suppliers');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Handies', [
            'foreignKey' => 'handy_id'
        ]);
        $this->hasMany('OrderSpecialShiires', [
            'foreignKey' => 'product_supplier_id'
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
            ->scalar('customer_code')
            ->maxLength('customer_code', 10)
            ->allowEmpty('customer_code');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('address')
            ->maxLength('address', 100)
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->integer('flag_denpyou')
            ->requirePresence('flag_denpyou', 'create')
            ->notEmpty('flag_denpyou');

        $validator
            ->integer('delete_flag')
            ->requirePresence('delete_flag', 'create')
            ->notEmpty('delete_flag');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->integer('created_staff')
            ->requirePresence('created_staff', 'create')
            ->notEmpty('created_staff');

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
        $rules->add($rules->existsIn(['handy_id'], 'Handies'));

        return $rules;
    }
}
