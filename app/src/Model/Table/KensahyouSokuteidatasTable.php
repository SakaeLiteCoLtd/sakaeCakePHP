<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KensahyouSokuteidatas Model
 *
 * @property \App\Model\Table\KensahyouHeadsTable|\Cake\ORM\Association\BelongsTo $KensahyouHeads
 *
 * @method \App\Model\Entity\KensahyouSokuteidata get($primaryKey, $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KensahyouSokuteidata findOrCreate($search, callable $callback = null, $options = [])
 */
class KensahyouSokuteidatasTable extends Table
{
    public function beforeFilter(Event $event)//
    {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
    }

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('kensahyou_sokuteidatas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'created_staff',//
            'joinType' => 'LEFT'//
        ]);

        $this->belongsTo('KensahyouHeads', [
            'foreignKey' => 'kensahyou_heads_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('Products', [
            'foreignKey' => 'product_code',
            'joinType' => 'LEFT'
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
//            ->scalar('product_code')
            ->maxLength('product_code', 255)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->date('manu_date')
            ->requirePresence('manu_date', 'create')
            ->notEmpty('manu_date');

        $validator
            ->date('inspec_date')
            ->requirePresence('inspec_date', 'create')
            ->notEmpty('inspec_date');

        $validator
            ->integer('cavi_num')
            ->requirePresence('cavi_num', 'create')
            ->notEmpty('cavi_num');

        $validator
            ->numeric('result_size_1')
            ->allowEmpty('result_size_1');

        $validator
            ->numeric('result_size_2')
            ->allowEmpty('result_size_2');

        $validator
            ->numeric('result_size_3')
            ->allowEmpty('result_size_3');

        $validator
            ->numeric('result_size_4')
            ->allowEmpty('result_size_4');

        $validator
            ->numeric('result_size_5')
            ->allowEmpty('result_size_5');

        $validator
            ->numeric('result_size_6')
            ->allowEmpty('result_size_6');

        $validator
            ->numeric('result_size_7')
            ->allowEmpty('result_size_7');

        $validator
            ->numeric('result_size_8')
            ->allowEmpty('result_size_8');

        $validator
            ->numeric('result_size_9')
            ->allowEmpty('result_size_9');

        $validator
            ->numeric('result_size_10')
            ->allowEmpty('result_size_10');

        $validator
            ->numeric('result_size_11')
            ->allowEmpty('result_size_11');

        $validator
            ->numeric('result_size_12')
            ->allowEmpty('result_size_12');

        $validator
            ->numeric('result_size_13')
            ->allowEmpty('result_size_13');

        $validator
            ->numeric('result_size_14')
            ->allowEmpty('result_size_14');

        $validator
            ->numeric('result_size_15')
            ->allowEmpty('result_size_15');

        $validator
            ->numeric('result_size_16')
            ->allowEmpty('result_size_16');

        $validator
            ->numeric('result_size_17')
            ->allowEmpty('result_size_17');

        $validator
            ->numeric('result_size_18')
            ->allowEmpty('result_size_18');

        $validator
            ->numeric('result_size_19')
            ->allowEmpty('result_size_19');

        $validator
            ->numeric('result_size_20')
            ->allowEmpty('result_size_20');

        $validator
            ->numeric('result_weight')
            ->allowEmpty('result_weight');

        $validator
//            ->scalar('situation_dist')
            ->maxLength('situation_dist', 20)
            ->allowEmpty('situation_dist');

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

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['kensahyou_heads_id'], 'KensahyouHeads'));

        return $rules;
    }
}
