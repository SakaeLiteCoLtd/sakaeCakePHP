<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SyoyouKeikakus Model
 *
 * @method \App\Model\Entity\SyoyouKeikakus get($primaryKey, $options = [])
 * @method \App\Model\Entity\SyoyouKeikakus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SyoyouKeikakus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SyoyouKeikakus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SyoyouKeikakus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SyoyouKeikakus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SyoyouKeikakus findOrCreate($search, callable $callback = null, $options = [])
 */
class SyoyouKeikakusTable extends Table
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

        $this->setTable('syoyou_keikakus');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->date('date_keikaku')
            ->requirePresence('date_keikaku', 'create')
            ->notEmpty('date_keikaku');

        $validator
            ->scalar('num_keikaku')
            ->maxLength('num_keikaku', 20)
            ->requirePresence('num_keikaku', 'create')
            ->notEmpty('num_keikaku');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 30)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->date('date_deliver')
            ->requirePresence('date_deliver', 'create')
            ->notEmpty('date_deliver');

        $validator
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['date_keikaku','num_keikaku','product_code']));

        return $rules;
    }
}
