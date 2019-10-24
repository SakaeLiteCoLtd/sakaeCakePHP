<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ScheduleKouteis Model
 *
 * @method \App\Model\Entity\ScheduleKoutei get($primaryKey, $options = [])
 * @method \App\Model\Entity\ScheduleKoutei newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ScheduleKoutei[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ScheduleKoutei|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScheduleKoutei|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ScheduleKoutei patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ScheduleKoutei[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ScheduleKoutei findOrCreate($search, callable $callback = null, $options = [])
 */
class ScheduleKouteisTable extends Table
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

        $this->setTable('schedule_kouteis');
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('datetime')
            ->requirePresence('datetime', 'create')
            ->notEmpty('datetime');

        $validator
            ->integer('seikeiki')
            ->allowEmpty('seikeiki');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 255)
            ->allowEmpty('product_code');

        $validator
            ->scalar('present_kensahyou')
            ->maxLength('present_kensahyou', 2)
            ->allowEmpty('present_kensahyou');

        $validator
            ->scalar('product_name')
            ->maxLength('product_name', 255)
            ->allowEmpty('product_name');

        $validator
            ->scalar('tantou')
            ->maxLength('tantou', 255)
            ->allowEmpty('tantou');

        return $validator;
    }
}
