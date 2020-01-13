<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabelCsvs Model
 *
 * @method \App\Model\Entity\LabelCsv get($primaryKey, $options = [])
 * @method \App\Model\Entity\LabelCsv newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LabelCsv[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LabelCsv|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelCsv patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LabelCsv[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LabelCsv findOrCreate($search, callable $callback = null, $options = [])
 */
class LabelCsvsTable extends Table
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

        $this->setTable('label_csvs');
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
            ->integer('number_sheet')
            ->requirePresence('number_sheet', 'create')
            ->notEmpty('number_sheet');

        $validator
            ->scalar('hanbetsu')
            ->maxLength('hanbetsu', 2)
            ->requirePresence('hanbetsu', 'create')
            ->notEmpty('hanbetsu');

        $validator
            ->scalar('place1')
            ->maxLength('place1', 40)
            ->requirePresence('place1', 'create')
            ->notEmpty('place1');

        $validator
            ->scalar('place2')
            ->maxLength('place2', 40)
            ->allowEmpty('place2');

        $validator
            ->scalar('product1')
            ->maxLength('product1', 20)
            ->requirePresence('product1', 'create')
            ->notEmpty('product1');

        $validator
            ->scalar('product2')
            ->maxLength('product2', 20)
            ->allowEmpty('product2');

        $validator
            ->scalar('name_pro1')
            ->maxLength('name_pro1', 40)
            ->requirePresence('name_pro1', 'create')
            ->notEmpty('name_pro1');

        $validator
            ->scalar('name_pro2')
            ->maxLength('name_pro2', 40)
            ->allowEmpty('name_pro2');

        $validator
            ->scalar('irisu1')
            ->maxLength('irisu1', 5)
            ->requirePresence('irisu1', 'create')
            ->notEmpty('irisu1');

        $validator
            ->scalar('irisu2')
            ->maxLength('irisu2', 5)
            ->allowEmpty('irisu2');

        $validator
            ->scalar('unit1')
            ->maxLength('unit1', 10)
            ->allowEmpty('unit1');

        $validator
            ->scalar('unit2')
            ->maxLength('unit2', 10)
            ->allowEmpty('unit2');

        $validator
            ->scalar('line_code')
            ->maxLength('line_code', 20)
            ->allowEmpty('line_code');

        $validator
            ->scalar('date')
            ->maxLength('date', 20)
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->scalar('start_lot')
            ->maxLength('start_lot', 10)
            ->requirePresence('start_lot', 'create')
            ->notEmpty('start_lot');

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
//            ->requirePresence('created_staff', 'create')
            ->allowEmpty('created_staff');
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
