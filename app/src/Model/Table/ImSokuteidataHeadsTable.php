<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImSokuteidataHeads Model
 *
 * @property \App\Model\Table\ProductsTable|\Cake\ORM\Association\BelongsTo $Products
 *
 * @method \App\Model\Entity\ImSokuteidataHead get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataHead findOrCreate($search, callable $callback = null, $options = [])
 */
class ImSokuteidataHeadsTable extends Table
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

        $this->setTable('im_sokuteidata_heads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
//            ->scalar('kind_kensa')
            ->maxLength('kind_kensa', 255)
            ->requirePresence('kind_kensa', 'create')
            ->notEmpty('kind_kensa');

        $validator
            ->date('inspec_date')
            ->requirePresence('inspec_date', 'create')
            ->notEmpty('inspec_date');

        $validator
//            ->scalar('lot_num')
            ->maxLength('lot_num', 40)
            ->requirePresence('lot_num', 'create')
            ->notEmpty('lot_num');

        $validator
            ->integer('torikomi')
            ->requirePresence('torikomi', 'create')
            ->notEmpty('torikomi');

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
