<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MotoLots Model
 *
 * @method \App\Model\Entity\MotoLot get($primaryKey, $options = [])
 * @method \App\Model\Entity\MotoLot newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MotoLot[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MotoLot|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MotoLot patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MotoLot[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MotoLot findOrCreate($search, callable $callback = null, $options = [])
 */
class MotoLotsTable extends Table
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

        $this->setTable('moto_lots');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('hasu_lot')
            ->maxLength('hasu_lot', 40)
            ->requirePresence('hasu_lot', 'create')
            ->notEmpty('hasu_lot');

            $validator
                ->scalar('product_code')
                ->maxLength('product_code', 40)
                ->requirePresence('product_code', 'create')
                ->notEmpty('product_code');

        $validator
            ->scalar('moto_lot')
            ->maxLength('moto_lot', 40)
            ->requirePresence('moto_lot', 'create')
            ->notEmpty('moto_lot');

        $validator
            ->integer('moto_lot_amount')
            ->requirePresence('moto_lot_amount', 'create')
            ->notEmpty('moto_lot_amount');

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
