<?php
namespace App\Model\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KariKadouSeikeis Model
 *
 * @method \App\Model\Entity\KariKadouSeikei get($primaryKey, $options = [])
 * @method \App\Model\Entity\KariKadouSeikei newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KariKadouSeikei[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KariKadouSeikei|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KariKadouSeikei|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KariKadouSeikei patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KariKadouSeikei[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KariKadouSeikei findOrCreate($search, callable $callback = null, $options = [])
 */
class KariKadouSeikeisTable extends Table
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

        $this->setTable('kari_kadou_seikeis');
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
            ->maxLength('product_code', 255)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');
        $validator
            ->integer('seikeiki')
            ->requirePresence('seikeiki', 'create')
            ->notEmpty('seikeiki');
        $validator
            ->maxLength('seikeiki_code', 8)
            ->allowEmpty('seikeiki_code');
        $validator
            ->datetime('starting_tm')
            ->requirePresence('starting_tm', 'create')
            ->notEmpty('starting_tm');
        $validator
            ->datetime('finishing_tm')
            ->requirePresence('finishing_tm', 'create')
            ->notEmpty('finishing_tm');
        $validator
            ->numeric('cycle_shot')
            ->requirePresence('cycle_shot', 'create')
            ->notEmpty('cycle_shot');
        $validator
            ->maxLength('amount_shot', 11)
            ->requirePresence('amount_shot', 'create')
            ->notEmpty('amount_shot');
        $validator
            ->numeric('accomp_rate')
            ->requirePresence('accomp_rate', 'create')
            ->notEmpty('accomp_rate');
        $validator
            ->integer('present_kensahyou')
            ->requirePresence('present_kensahyou', 'create')
            ->notEmpty('present_kensahyou');
/*
        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');
*/
        $validator
            ->integer('created_staff')
//            ->requirePresence('created_staff', 'create')
//            ->notEmpty('created_staff');
            ->allowEmpty('updated_staff');
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

    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['product_code','seikeiki','starting_tm']));

        return $rules;
    }

}
