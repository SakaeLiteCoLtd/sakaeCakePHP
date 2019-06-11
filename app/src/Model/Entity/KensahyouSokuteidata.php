<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KensahyouSokuteidata Entity
 *
 * @property string $id
 * @property string $kensahyou_heads_id
 * @property string $puroduct_code
 * @property \Cake\I18n\FrozenDate $manu_date
 * @property \Cake\I18n\FrozenDate $inspec_date
 * @property float $result_size_1
 * @property float $result_size_2
 * @property float $result_size_3
 * @property float $result_size_4
 * @property float $result_size_5
 * @property float $result_size_6
 * @property float $result_size_7
 * @property float $result_size_8
 * @property float $result_size_9
 * @property float $result_size_10
 * @property float $result_size_11
 * @property float $result_size_12
 * @property float $result_size_13
 * @property float $result_size_14
 * @property float $result_size_15
 * @property float $result_size_16
 * @property float $result_size_17
 * @property float $result_size_18
 * @property float $result_size_19
 * @property float $result_size_20
 * @property float $result_weight
 * @property string $situation_dist
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\KensahyouHead $kensahyou_head
 */
class KensahyouSokuteidata extends Entity
{

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
        'kensahyou_heads_id' => true,
        'product_code' => true,
        'manu_date' => true,
        'inspec_date' => true,
        'cavi_num' => true,
        'result_size_1' => true,
        'result_size_2' => true,
        'result_size_3' => true,
        'result_size_4' => true,
        'result_size_5' => true,
        'result_size_6' => true,
        'result_size_7' => true,
        'result_size_8' => true,
        'result_size_9' => true,
        'result_size_10' => true,
        'result_size_11' => true,
        'result_size_12' => true,
        'result_size_13' => true,
        'result_size_14' => true,
        'result_size_15' => true,
        'result_size_16' => true,
        'result_size_17' => true,
        'result_size_18' => true,
        'result_size_19' => true,
        'result_size_20' => true,
        'result_weight' => true,
        'situation_dist' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'kensahyou_head' => true
    ];
}
