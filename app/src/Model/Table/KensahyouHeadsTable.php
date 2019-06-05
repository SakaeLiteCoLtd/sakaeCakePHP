<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KensahyouHeads Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\KensahyouHead get($primaryKey, $options = [])
 * @method \App\Model\Entity\KensahyouHead newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KensahyouHead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KensahyouHead|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KensahyouHead|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KensahyouHead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KensahyouHead[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KensahyouHead findOrCreate($search, callable $callback = null, $options = [])
 */
class KensahyouHeadsTable extends Table
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

        $this->setTable('kensahyou_heads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'created_staff',//
            'joinType' => 'LEFT'//
        ]);

        $this->belongsTo('Products', [
            'foreignKey' => 'product_id',
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
            ->uuid('id')
            ->allowEmpty('id', 'create');

        $validator
            ->integer('version')
            ->requirePresence('version', 'create')
            ->notEmpty('version');

        $validator
            ->integer('type_im')
            ->requirePresence('type_im', 'create')
            ->notEmpty('type_im');

        $validator
            ->integer('maisu')
            ->allowEmpty('maisu');

        $validator
            ->numeric('size_1')
            ->allowEmpty('size_1');

        $validator
            ->numeric('upper_1')
            ->allowEmpty('upper_1');

        $validator
            ->numeric('lower_1')
            ->allowEmpty('lower_1');

        $validator
            ->numeric('size_2')
            ->allowEmpty('size_2');

        $validator
            ->numeric('upper_2')
            ->allowEmpty('upper_2');

        $validator
            ->numeric('lower_2')
            ->allowEmpty('lower_2');

        $validator
            ->numeric('size_3')
            ->allowEmpty('size_3');

        $validator
            ->numeric('upper_3')
            ->allowEmpty('upper_3');

        $validator
            ->numeric('lower_3')
            ->allowEmpty('lower_3');

        $validator
            ->numeric('size_4')
            ->allowEmpty('size_4');

        $validator
            ->numeric('upper_4')
            ->allowEmpty('upper_4');

        $validator
            ->numeric('lower_4')
            ->allowEmpty('lower_4');

        $validator
            ->numeric('size_5')
            ->allowEmpty('size_5');

        $validator
            ->numeric('upper_5')
            ->allowEmpty('upper_5');

        $validator
            ->numeric('lower_5')
            ->allowEmpty('lower_5');

        $validator
            ->numeric('size_6')
            ->allowEmpty('size_6');

        $validator
            ->numeric('upper_6')
            ->allowEmpty('upper_6');

        $validator
            ->numeric('lower_6')
            ->allowEmpty('lower_6');

        $validator
            ->numeric('size_7')
            ->allowEmpty('size_7');

        $validator
            ->numeric('upper_7')
            ->allowEmpty('upper_7');

        $validator
            ->numeric('lower_7')
            ->allowEmpty('lower_7');

        $validator
            ->numeric('size_8')
            ->allowEmpty('size_8');

        $validator
            ->numeric('upper_8')
            ->allowEmpty('upper_8');

        $validator
            ->numeric('lower_8')
            ->allowEmpty('lower_8');

        $validator
            ->numeric('size_9')
            ->allowEmpty('size_9');

        $validator
//            ->scalar('text_10')
            ->maxLength('text_10', 20)
            ->allowEmpty('text_10');

        $validator
//            ->scalar('text_11')
            ->maxLength('text_11', 20)
            ->allowEmpty('text_11');

        $validator
            ->numeric('size_12')
            ->allowEmpty('size_12');

        $validator
            ->numeric('upper_12')
            ->allowEmpty('upper_12');

        $validator
            ->numeric('lower_12')
            ->allowEmpty('lower_12');

        $validator
            ->numeric('size_13')
            ->allowEmpty('size_13');

        $validator
            ->numeric('upper_13')
            ->allowEmpty('upper_13');

        $validator
            ->numeric('lower_13')
            ->allowEmpty('lower_13');

        $validator
            ->numeric('size_14')
            ->allowEmpty('size_14');

        $validator
            ->numeric('upper_14')
            ->allowEmpty('upper_14');

        $validator
            ->numeric('lower_14')
            ->allowEmpty('lower_14');

        $validator
            ->numeric('size_15')
            ->allowEmpty('size_15');

        $validator
            ->numeric('upper_15')
            ->allowEmpty('upper_15');

        $validator
            ->numeric('lower_15')
            ->allowEmpty('lower_15');

        $validator
            ->numeric('size_16')
            ->allowEmpty('size_16');

        $validator
            ->numeric('upper_16')
            ->allowEmpty('upper_16');

        $validator
            ->numeric('lower_16')
            ->allowEmpty('lower_16');

        $validator
            ->numeric('size_17')
            ->allowEmpty('size_17');

        $validator
            ->numeric('upper_17')
            ->allowEmpty('upper_17');

        $validator
            ->numeric('lower_17')
            ->allowEmpty('lower_17');

        $validator
            ->numeric('size_18')
            ->allowEmpty('size_18');

        $validator
            ->numeric('upper_18')
            ->allowEmpty('upper_18');

        $validator
            ->numeric('lower_18')
            ->allowEmpty('lower_18');

        $validator
            ->numeric('size_19')
            ->allowEmpty('size_19');

        $validator
            ->numeric('upper_19')
            ->allowEmpty('upper_19');

        $validator
            ->numeric('lower_19')
            ->allowEmpty('lower_19');

        $validator
            ->numeric('size_20')
            ->allowEmpty('size_20');

        $validator
            ->numeric('upper_20')
            ->allowEmpty('upper_20');

        $validator
            ->numeric('lower_20')
            ->allowEmpty('lower_20');

        $validator
//            ->scalar('bik')
            ->allowEmpty('bik');

        $validator
            ->integer('status')
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['product_id'], 'Products'));

        return $rules;
    }
}
