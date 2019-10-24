<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ScheduleKoutei Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenTime $datetime
 * @property int $seikeiki
 * @property string $product_code
 * @property string $present_kensahyou
 * @property string $product_name
 * @property string $tantou
 */
class ScheduleKoutei extends Entity
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
        'datetime' => true,
        'seikeiki' => true,
        'product_code' => true,
        'present_kensahyou' => true,
        'product_name' => true,
        'tantou' => true
    ];
}
