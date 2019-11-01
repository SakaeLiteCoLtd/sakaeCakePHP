<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabelElementPlace Entity
 *
 * @property string $id
 * @property string $place1
 * @property string $place2
 * @property string $genjyou
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 */
class LabelElementPlace extends Entity
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
        'place1' => true,
        'place2' => true,
        'genjyou' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true
    ];
}
