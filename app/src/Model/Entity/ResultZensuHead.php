<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResultZensuHead Entity
 *
 * @property int $id
 * @property string $product_code
 * @property string $lot_num
 * @property int $staff_id
 * @property \Cake\I18n\FrozenTime $datetime_start
 * @property \Cake\I18n\FrozenTime $datetime_finish
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 *
 * @property \App\Model\Entity\Staff $staff
 * @property \App\Model\Entity\ResultZensuFooder[] $result_zensu_fooders
 */
class ResultZensuHead extends Entity
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
        'lot_num' => true,
        'count_inspection' => true,
        'staff_id' => true,
        'datetime_start' => true,
        'datetime_finish' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'staff' => true,
        'result_zensu_fooders' => true
    ];
}
