<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * KadouSeikeikis Model
 *
 * @property \App\Model\Table\SeikeikisTable|\Cake\ORM\Association\BelongsTo $Seikeikis
 *
 * @method \App\Model\Entity\KadouSeikeiki get($primaryKey, $options = [])
 * @method \App\Model\Entity\KadouSeikeiki newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\KadouSeikeiki[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\KadouSeikeiki|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\KadouSeikeiki patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\KadouSeikeiki[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\KadouSeikeiki findOrCreate($search, callable $callback = null, $options = [])
 */
class KadouSeikeikisTable extends Table
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

        $this->setTable('kadou_seikeikis');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
/*
        $this->belongsTo('Seikeikis', [
            'foreignKey' => 'seikeiki_id',
            'joinType' => 'INNER'
        ]);
  */
    }

    public static function defaultConnectionName()// DB切替
    {
      return 'big_DB';
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
/*    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

            $validator
                ->integer('seikeiki_id')
                ->requirePresence('seikeiki_id', 'create')
                ->notEmpty('seikeiki_id');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 128)
            ->allowEmpty('product_code');

        $validator
            ->dateTime('starting_tm')
            ->requirePresence('starting_tm', 'create')
            ->notEmpty('starting_tm');

        $validator
            ->dateTime('finishing_tm')
            ->requirePresence('finishing_tm', 'create')
            ->notEmpty('finishing_tm');

        $validator
            ->dateTime('deleted_at')
            ->allowEmpty('deleted_at');

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->notEmpty('created_at');

        $validator
            ->dateTime('updated_at')
            ->requirePresence('updated_at', 'create')
            ->notEmpty('updated_at');

        return $validator;
    }
*/
    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {

      //  $rules->add($rules->existsIn(['seikeiki_id'], 'Seikeikis'));
        $rules->add($rules->isUnique(['seikeiki_id','starting_tm']));

        return $rules;
    }
}
