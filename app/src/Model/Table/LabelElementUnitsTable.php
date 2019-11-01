<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabelElementUnits Model
 *
 * @method \App\Model\Entity\LabelElementUnit get($primaryKey, $options = [])
 * @method \App\Model\Entity\LabelElementUnit newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LabelElementUnit[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LabelElementUnit|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelElementUnit|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelElementUnit patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LabelElementUnit[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LabelElementUnit findOrCreate($search, callable $callback = null, $options = [])
 */
class LabelElementUnitsTable extends Table
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

        $this->setTable('label_element_units');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->scalar('unit')
            ->maxLength('unit', 10)
            ->requirePresence('unit', 'create')
            ->notEmpty('unit');

        $validator
            ->scalar('genjyou')
            ->maxLength('genjyou', 2)
            ->requirePresence('genjyou', 'create')
            ->notEmpty('genjyou');

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
}
