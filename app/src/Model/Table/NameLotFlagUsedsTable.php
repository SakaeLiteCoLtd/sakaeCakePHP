<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NameLotFlagUseds Model
 *
 * @method \App\Model\Entity\NameLotFlagUsed get($primaryKey, $options = [])
 * @method \App\Model\Entity\NameLotFlagUsed newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\NameLotFlagUsed[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\NameLotFlagUsed|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\NameLotFlagUsed patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\NameLotFlagUsed[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\NameLotFlagUsed findOrCreate($search, callable $callback = null, $options = [])
 */
class NameLotFlagUsedsTable extends Table
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

        $this->setTable('name_lot_flag_useds');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->scalar('name')
            ->maxLength('name', 20)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        return $validator;
    }
}
