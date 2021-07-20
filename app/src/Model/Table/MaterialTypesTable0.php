<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MaterialTypes Model
 *
 * @method \App\Model\Entity\MaterialType get($primaryKey, $options = [])
 * @method \App\Model\Entity\MaterialType newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MaterialType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MaterialType|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MaterialType|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MaterialType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MaterialType[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MaterialType findOrCreate($search, callable $callback = null, $options = [])
 */
class MaterialTypesTable extends Table
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

        $this->setTable('material_types');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Staffs', [
            'foreignKey' => 'created_staff',
            'joinType' => 'LEFT'
        ]);

    }
/*
    public static function defaultConnectionName()// DB切替（ずっとこれを使う場合）
    {
//      return 'default';//defaultのデータベース
      return 'DB_sakae';//192.168.4.246のデータベースを使用
//      return 'test_desktop';//test_desktopのデータベースを使用
                        //mysqlへリモートアクセスの許可が必要https://qiita.com/n0bisuke/items/bd86dd3a79cd7cbcd92e
    }
*/
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
//            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->integer('delete_flag')
            ->requirePresence('delete_flag', 'create')
            ->notEmpty('delete_flag');

        return $validator;
    }
}
