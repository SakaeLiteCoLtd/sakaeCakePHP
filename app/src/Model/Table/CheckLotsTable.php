<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\Rule\IsUnique;

/**
 * CheckLots Model
 *
 * @property \App\Model\Table\PlaceDeliversTable|\Cake\ORM\Association\BelongsTo $PlaceDelivers
 *
 * @method \App\Model\Entity\CheckLot get($primaryKey, $options = [])
 * @method \App\Model\Entity\CheckLot newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\CheckLot[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\CheckLot|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CheckLot|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\CheckLot patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\CheckLot[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\CheckLot findOrCreate($search, callable $callback = null, $options = [])
 */
class CheckLotsTable extends Table
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

        $this->setTable('check_lots');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

//https://qiita.com/chiyoyo/items/7cd4ddf5c8c5c7b99eb7　//id以外のカラムで結合OK

        $this->belongsTo('Products', [
          'bindingKey' => 'product_code',
          'foreignKey' => 'product_code'
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->dateTime('datetime_hakkou')
            ->requirePresence('datetime_hakkou', 'create')
            ->notEmpty('datetime_hakkou');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 255)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->scalar('lot_num')
            ->maxLength('lot_num', 40)
            ->requirePresence('lot_num', 'create')
            ->notEmpty('lot_num');

        $validator
            ->integer('amount')
            ->requirePresence('amount', 'create')
            ->notEmpty('amount');

        $validator
            ->integer('flag_used')
            ->requirePresence('flag_used', 'create')
            ->notEmpty('flag_used');

        $validator
            ->date('date_deliver')
            ->allowEmpty('date_deliver');

        $validator
            ->scalar('cs_name')
            ->maxLength('cs_name', 30)
            ->allowEmpty('cs_name');

        $validator
            ->scalar('operator_deliver')
            ->maxLength('operator_deliver', 20)
            ->allowEmpty('operator_deliver');

        $validator
            ->dateTime('flag_deliver')
            ->allowEmpty('flag_deliver');

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
//        $rules->add($rules->existsIn(['place_deliver_id'], 'PlaceDelivers'));
        $rules->add($rules->isUnique(['product_code','lot_num'], 'バリデーションエラー'));//product_codeとlot_numでバリデーションエラー確認済みOK

        return $rules;
    }

}
