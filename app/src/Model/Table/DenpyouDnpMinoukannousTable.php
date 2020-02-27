<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * DenpyouDnpMinoukannous Model
 *
 * @property \App\Model\Table\OrderEdisTable|\Cake\ORM\Association\BelongsTo $OrderEdis
 *
 * @method \App\Model\Entity\DenpyouDnpMinoukannous get($primaryKey, $options = [])
 * @method \App\Model\Entity\DenpyouDnpMinoukannous newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\DenpyouDnpMinoukannous[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\DenpyouDnpMinoukannous|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\DenpyouDnpMinoukannous patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\DenpyouDnpMinoukannous[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\DenpyouDnpMinoukannous findOrCreate($search, callable $callback = null, $options = [])
 */
class DenpyouDnpMinoukannousTable extends Table
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

        $this->setTable('denpyou_dnp_minoukannous');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrderEdis', [
            'foreignKey' => 'order_edi_id',
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
            ->scalar('num_order')
            ->maxLength('num_order', 20)
            ->requirePresence('num_order', 'create')
            ->notEmpty('num_order');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 30)
            ->requirePresence('product_code', 'create')
            ->notEmpty('product_code');

        $validator
            ->scalar('name_order')
            ->maxLength('name_order', 100)
            ->requirePresence('name_order', 'create')
            ->notEmpty('name_order');

        $validator
            ->scalar('code')
            ->maxLength('code', 5)
            ->requirePresence('code', 'create')
            ->notEmpty('code');

        $validator
            ->scalar('place_deliver')
            ->maxLength('place_deliver', 30)
            ->requirePresence('place_deliver', 'create')
            ->notEmpty('place_deliver');

        $validator
            ->scalar('conf_print')
            ->maxLength('conf_print', 2)
            ->requirePresence('conf_print', 'create')
            ->notEmpty('conf_print');

        $validator
            ->date('date_deliver')
            ->requirePresence('date_deliver', 'create')
            ->notEmpty('date_deliver');

            $validator
                ->date('tourokubi')
                ->requirePresence('tourokubi', 'create')
                ->notEmpty('tourokubi');

        $validator
            ->integer('minoukannou')
            ->requirePresence('minoukannou', 'create')
            ->notEmpty('minoukannou');

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
/*    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['order_edi_id'], 'OrderEdis'));

        return $rules;
    }
*/
}
