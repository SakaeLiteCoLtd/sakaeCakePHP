<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImSokuteidataResults Model
 *
 * @property \App\Model\Table\ImSokuteidataHeadsTable|\Cake\ORM\Association\BelongsTo $ImSokuteidataHeads
 *
 * @method \App\Model\Entity\ImSokuteidataResult get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImSokuteidataResult findOrCreate($search, callable $callback = null, $options = [])
 */
class ImSokuteidataResultsTable extends Table
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

        $this->setTable('im_sokuteidata_results');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ImSokuteidataHeads', [
            'foreignKey' => 'im_sokuteidata_head_id',
            'joinType' => 'INNER'
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
            ->dateTime('inspec_datetime')
            ->requirePresence('inspec_datetime', 'create')
            ->notEmpty('inspec_datetime');

        $validator
            ->scalar('serial')
            ->maxLength('serial', 20)
            ->requirePresence('serial', 'create')
            ->notEmpty('serial');

        $validator
            ->integer('size_num')
            ->requirePresence('size_num', 'create')
            ->notEmpty('size_num');

        $validator
            ->decimal('result')
            ->requirePresence('result', 'create')
            ->notEmpty('result');

        $validator
            ->scalar('status')
            ->maxLength('status', 20)
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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
        $rules->add($rules->existsIn(['im_sokuteidata_head_id'], 'ImSokuteidataHeads'));

        return $rules;
    }
}
