<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ResultZensuFooders Model
 *
 * @property \App\Model\Table\ResultZensuHeadsTable|\Cake\ORM\Association\BelongsTo $ResultZensuHeads
 * @property \App\Model\Table\ContRejectionsTable|\Cake\ORM\Association\BelongsTo $ContRejections
 *
 * @method \App\Model\Entity\ResultZensuFooder get($primaryKey, $options = [])
 * @method \App\Model\Entity\ResultZensuFooder newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ResultZensuFooder[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ResultZensuFooder|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ResultZensuFooder patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ResultZensuFooder[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ResultZensuFooder findOrCreate($search, callable $callback = null, $options = [])
 */
class ResultZensuFoodersTable extends Table
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

        $this->setTable('result_zensu_fooders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ResultZensuHeads', [
            'foreignKey' => 'result_zensu_head_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('ContRejections', [
            'foreignKey' => 'cont_rejection_id',
            'joinType' => 'INNER'
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
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->scalar('bik')
            ->maxLength('bik', 256)
    //        ->requirePresence('bik', 'create')
            ->allowEmpty('bik');

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
        $rules->add($rules->existsIn(['result_zensu_head_id'], 'ResultZensuHeads'));
        $rules->add($rules->existsIn(['cont_rejection_id'], 'ContRejections'));

        return $rules;
    }
}
