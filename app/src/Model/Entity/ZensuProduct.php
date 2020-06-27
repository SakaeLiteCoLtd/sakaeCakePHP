<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ZensuProduct Entity
 *
 * @property int $id
 * @property string $product_code
 * @property int $shot_cycle
 * @property float $kijyun
 * @property int $status
 * @property int $staff_id
 * @property \Cake\I18n\FrozenTime $datetime_touroku
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property int $update_staff
 * @property \Cake\I18n\FrozenTime $update_at
 *
 * @property \App\Model\Entity\Staff $staff
 */
class ZensuProduct extends Entity
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
        'product_code' => true,
        'shot_cycle' => true,
        'kijyun' => true,
        'status' => true,
        'staff_code' => true,
        'datetime_touroku' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'update_staff' => true,
        'update_at' => true,
        'staff' => true
    ];
}
