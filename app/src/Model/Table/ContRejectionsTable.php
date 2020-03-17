<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ContRejections Model
 *
 * @property \App\Model\Table\ResultZensuFoodersTable|\Cake\ORM\Association\HasMany $ResultZensuFooders
 *
 * @method \App\Model\Entity\ContRejection get($primaryKey, $options = [])
 * @method \App\Model\Entity\ContRejection newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ContRejection[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ContRejection|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ContRejection patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ContRejection[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ContRejection findOrCreate($search, callable $callback = null, $options = [])
 */
class ContRejectionsTable extends Table
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

        $this->setTable('cont_rejections');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('ResultZensuFooders', [
            'foreignKey' => 'cont_rejection_id'
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
            ->scalar('cont')
            ->maxLength('cont', 128)
            ->requirePresence('cont', 'create')
            ->notEmpty('cont');

        return $validator;
    }
}
