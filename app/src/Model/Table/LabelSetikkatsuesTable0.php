<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabelSetikkatsues Model
 *
 * @method \App\Model\Entity\LabelSetikkatsue get($primaryKey, $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\LabelSetikkatsue findOrCreate($search, callable $callback = null, $options = [])
 */
class LabelSetikkatsuesTable extends Table
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

        $this->setTable('label_setikkatsues');
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
            ->scalar('product_id1')
            ->maxLength('product_id1', 30)
            ->requirePresence('product_id1', 'create')
            ->notEmpty('product_id1');

        $validator
            ->scalar('product_id2')
            ->maxLength('product_id2', 30)
            ->requirePresence('product_id2', 'create')
            ->notEmpty('product_id2');

            $validator
                ->scalar('product_id3')
                ->maxLength('product_id3', 30)
                ->allowEmpty('updated_staff');

        $validator
            ->date('tourokubi')
            ->requirePresence('tourokubi', 'create')
            ->notEmpty('tourokubi');

            $validator
                ->integer('delete_flag')
                ->requirePresence('delete_flag', 'create')
                ->notEmpty('delete_flag');

                $validator
                    ->integer('kind_set_assemble')
                    ->requirePresence('kind_set_assemble', 'create')
                    ->notEmpty('kind_set_assemble');
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
