<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ZensuProducts Model
 *
 * @property \App\Model\Table\StaffsTable|\Cake\ORM\Association\BelongsTo $Staffs
 *
 * @method \App\Model\Entity\ZensuProduct get($primaryKey, $options = [])
 * @method \App\Model\Entity\ZensuProduct newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ZensuProduct[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ZensuProduct|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ZensuProduct patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ZensuProduct[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ZensuProduct findOrCreate($search, callable $callback = null, $options = [])
 */
class ZensuProductsTable extends Table
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

        $this->setTable('zensu_products');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
/*
        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'joinType' => 'INNER'
        ]);
*/
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
            ->scalar('product_code')
            ->maxLength('product_code', 40)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->integer('shot_cycle')
            ->allowEmpty('shot_cycle');

        $validator
            ->numeric('kijyun')
            ->allowEmpty('kijyun');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

            $validator
                ->integer('staff_code')
                ->requirePresence('staff_code', 'create')
                ->notEmpty('staff_code');

        $validator
            ->dateTime('datetime_touroku')
            ->requirePresence('datetime_touroku', 'create')
            ->notEmpty('datetime_touroku');

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
            ->integer('update_staff')
            ->allowEmpty('update_staff');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
/*    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['staff_id'], 'Staffs'));

        return $rules;
    }
*/
}
