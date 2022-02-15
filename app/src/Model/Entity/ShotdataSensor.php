<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShotdataSensor Entity
 *
 * @property \Cake\I18n\FrozenTime $datetime
 * @property string $seikeiki
 * @property int|null $flag_start_finish
 * @property string|null $product_code
 * @property string|null $lot_num
 * @property float|null $shot_cycle
 * @property float|null $temp_coolingwater
 * @property float|null $temp_outside
 * @property float|null $temp_inside
 * @property int|null $mode_qr
 * @property float|null $peak_value
 * @property float|null $peak_value_time
 * @property float|null $peak_value1_0s
 * @property float|null $peak_value1_5s
 * @property float|null $sensor1
 * @property float|null $sensor2
 * @property float|null $sensor3
 * @property float|null $sensor4
 * @property float|null $sensor5
 * @property float|null $sensor6
 * @property float|null $sensor7
 * @property float|null $sensor8
 * @property float|null $sensor9
 * @property float|null $sensor10
 * @property float|null $sensor11
 * @property float|null $sensor_keihou1
 * @property float|null $sensor_keihou2
 * @property float|null $sensor_keihou3
 * @property float|null $sensor_keihou4
 * @property float|null $sensor_keihou5
 * @property float|null $sensor_keihou6
 * @property float|null $sensor_keihou7
 * @property float|null $sensor_keihou8
 * @property float|null $sensor_keihou9
 * @property float|null $sensor_keihou10
 * @property float|null $sensor_keihou11
 */
class ShotdataSensor extends Entity
{

  public static function defaultConnectionName(){
      return 'big_DB';
  }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'flag_start_finish' => true,
        'product_code' => true,
        'lot_num' => true,
        'shot_cycle' => true,
        'temp_coolingwater' => true,
        'temp_outside' => true,
        'temp_inside' => true,
        'mode_qr' => true,
        'peak_value' => true,
        'peak_value_time' => true,
        'peak_value1_0s' => true,
        'peak_value1_5s' => true,
        'sensor1' => true,
        'sensor2' => true,
        'sensor3' => true,
        'sensor4' => true,
        'sensor5' => true,
        'sensor6' => true,
        'sensor7' => true,
        'sensor8' => true,
        'sensor9' => true,
        'sensor10' => true,
        'sensor11' => true,
        'sensor_keihou1' => true,
        'sensor_keihou2' => true,
        'sensor_keihou3' => true,
        'sensor_keihou4' => true,
        'sensor_keihou5' => true,
        'sensor_keihou6' => true,
        'sensor_keihou7' => true,
        'sensor_keihou8' => true,
        'sensor_keihou9' => true,
        'sensor_keihou10' => true,
        'sensor_keihou11' => true
    ];
}
