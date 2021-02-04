<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ImKikakus Model
 *
 * @property \App\Model\Table\ImSokuteidataHeadsTable|\Cake\ORM\Association\BelongsTo $ImSokuteidataHeads
 *
 * @method \App\Model\Entity\ImKikakus get($primaryKey, $options = [])
 * @method \App\Model\Entity\ImKikakus newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ImKikakus[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ImKikakus|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImKikakus|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ImKikakus patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ImKikakus[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ImKikakus findOrCreate($search, callable $callback = null, $options = [])
 */
class ImKikakusTable extends Table
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

        $this->setTable('im_kikakus');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('ImSokuteidataHeads', [
            'foreignKey' => 'im_sokuteidata_head_id',
            'joinType' => 'LEFT'
        ]);

        $this->belongsTo('ImSokuteidataResults', [
            'foreignKey' => 'im_sokuteidata_head_id',
            'joinType' => 'LEFT'
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
            ->integer('size_num')
            ->requirePresence('size_num', 'create')
            ->notEmpty('size_num');

        $validator
            ->decimal('size')
            ->requirePresence('size', 'create')
            ->notEmpty('size');

        $validator
            ->decimal('upper')
            ->requirePresence('upper', 'create')
            ->notEmpty('upper');

        $validator
            ->decimal('lower')
            ->allowEmpty('lower');

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
        $rules->add($rules->existsIn(['im_sokuteidata_head_id'], 'ImSokuteidataResults'));

        return $rules;
    }
}
