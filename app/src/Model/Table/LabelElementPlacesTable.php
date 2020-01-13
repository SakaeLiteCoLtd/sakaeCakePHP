<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabelElementPlaces Model
 *
 * @method \App\Model\Entity\LabelElementPlace get($primaryKey, $options = [])
 * @method \App\Model\Entity\LabelElementPlace newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LabelElementPlace[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LabelElementPlace|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelElementPlace|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelElementPlace patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LabelElementPlace[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LabelElementPlace findOrCreate($search, callable $callback = null, $options = [])
 */
class LabelElementPlacesTable extends Table
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

        $this->setTable('label_element_places');
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
          ->integer('place_code')
          ->allowEmpty('place_code');

        $validator
            ->scalar('place1')
            ->maxLength('place1', 100)
            ->requirePresence('place1', 'create')
            ->notEmpty('place1');

        $validator
            ->scalar('place2')
            ->maxLength('place2', 100)
            ->allowEmpty('place2');

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
}
