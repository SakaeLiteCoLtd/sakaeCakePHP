<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ShotdataSensors Model
 *
 * @method \App\Model\Entity\ShotdataSensor get($primaryKey, $options = [])
 * @method \App\Model\Entity\ShotdataSensor newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\ShotdataSensor[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\ShotdataSensor|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShotdataSensor|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\ShotdataSensor patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\ShotdataSensor[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\ShotdataSensor findOrCreate($search, callable $callback = null, $options = [])
 */
class ShotdataSensorsTable extends Table
{

  public static function defaultConnectionName(){
      return 'big_DB';
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

        $this->setTable('shotdata_sensors');
        $this->setDisplayField('datetime');
        $this->setPrimaryKey(['datetime', 'seikeiki']);
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
            ->dateTime('datetime')
            ->allowEmpty('datetime', 'create');

        $validator
            ->scalar('seikeiki')
            ->maxLength('seikeiki', 2)
            ->allowEmpty('seikeiki', 'create');

        $validator
            ->integer('flag_start_finish')
            ->allowEmpty('flag_start_finish');

        $validator
            ->scalar('product_code')
            ->maxLength('product_code', 128)
            ->allowEmpty('product_code');

        $validator
            ->scalar('lot_num')
            ->maxLength('lot_num', 20)
            ->allowEmpty('lot_num');

        $validator
            ->numeric('shot_cycle')
            ->allowEmpty('shot_cycle');

        $validator
            ->numeric('temp_coolingwater')
            ->allowEmpty('temp_coolingwater');

        $validator
            ->numeric('temp_outside')
            ->allowEmpty('temp_outside');

        $validator
            ->numeric('temp_inside')
            ->allowEmpty('temp_inside');

        $validator
            ->integer('mode_qr')
            ->allowEmpty('mode_qr');

        $validator
            ->numeric('peak_value')
            ->allowEmpty('peak_value');

        $validator
            ->numeric('peak_value_time')
            ->allowEmpty('peak_value_time');

        $validator
            ->numeric('peak_value1_0s')
            ->allowEmpty('peak_value1_0s');

        $validator
            ->numeric('peak_value1_5s')
            ->allowEmpty('peak_value1_5s');

        $validator
            ->numeric('sensor1')
            ->allowEmpty('sensor1');

        $validator
            ->numeric('sensor2')
            ->allowEmpty('sensor2');

        $validator
            ->numeric('sensor3')
            ->allowEmpty('sensor3');

        $validator
            ->numeric('sensor4')
            ->allowEmpty('sensor4');

        $validator
            ->numeric('sensor5')
            ->allowEmpty('sensor5');

        $validator
            ->numeric('sensor6')
            ->allowEmpty('sensor6');

        $validator
            ->numeric('sensor7')
            ->allowEmpty('sensor7');

        $validator
            ->numeric('sensor8')
            ->allowEmpty('sensor8');

        $validator
            ->numeric('sensor9')
            ->allowEmpty('sensor9');

        $validator
            ->numeric('sensor10')
            ->allowEmpty('sensor10');

        $validator
            ->numeric('sensor11')
            ->allowEmpty('sensor11');

        $validator
            ->numeric('sensor_keihou1')
            ->allowEmpty('sensor_keihou1');

        $validator
            ->numeric('sensor_keihou2')
            ->allowEmpty('sensor_keihou2');

        $validator
            ->numeric('sensor_keihou3')
            ->allowEmpty('sensor_keihou3');

        $validator
            ->numeric('sensor_keihou4')
            ->allowEmpty('sensor_keihou4');

        $validator
            ->numeric('sensor_keihou5')
            ->allowEmpty('sensor_keihou5');

        $validator
            ->numeric('sensor_keihou6')
            ->allowEmpty('sensor_keihou6');

        $validator
            ->numeric('sensor_keihou7')
            ->allowEmpty('sensor_keihou7');

        $validator
            ->numeric('sensor_keihou8')
            ->allowEmpty('sensor_keihou8');

        $validator
            ->numeric('sensor_keihou9')
            ->allowEmpty('sensor_keihou9');

        $validator
            ->numeric('sensor_keihou10')
            ->allowEmpty('sensor_keihou10');

        $validator
            ->numeric('sensor_keihou11')
            ->allowEmpty('sensor_keihou11');

        return $validator;
    }
}
