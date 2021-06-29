<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResultZensuHeads Model
 *
 * @property \App\Model\Table\StaffsTable|\Cake\ORM\Association\BelongsTo $Staffs
 * @property \App\Model\Table\ResultZensuFoodersTable|\Cake\ORM\Association\HasMany $ResultZensuFooders
 *
 * @method \App\Model\Entity\ResultZensuHead get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResultZensuHead newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResultZensuHead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResultZensuHead|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResultZensuHead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResultZensuHead[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResultZensuHead findOrCreate($search, callable $callback = null, $options = [])
 */
class ResultZensuHeadsTable extends Table
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

        $this->setTable('result_zensu_heads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'staff_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('ResultZensuFooders', [
            'foreignKey' => 'result_zensu_head_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 30)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->scalar('lot_num')
            ->maxLength('lot_num', 20)
            ->requirePresence('lot_num', 'create')
            ->notEmpty('lot_num');

            $validator
                ->integer('count_inspection')
                ->requirePresence('count_inspection', 'create')
                ->notEmpty('count_inspection');

        $validator
            ->dateTime('datetime_start')
            ->requirePresence('datetime_start', 'create')
            ->notEmpty('datetime_start');

        $validator
            ->dateTime('datetime_finish')
            ->allowEmpty('datetime_finish');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
  //      $rules->add($rules->existsIn(['staff_id'], 'Staffs'));
        $rules->add($rules->isUnique(['product_code','lot_num','count_inspection']));

        return $rules;
    }
}
