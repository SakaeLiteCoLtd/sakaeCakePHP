<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabelTypeProduct Entity
 *
 * @property string $id
 * @property string $product_code
 * @property string $type_id
 * @property int $place_id
 * @property int $unit_id
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Type $type
 * @property \App\Model\Entity\Place $place
 * @property \App\Model\Entity\Unit $unit
 */
class LabelTypeProduct extends Entity
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
        'type_id' => true,
        'place_id' => true,
        'unit_id' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'type' => true,
        'place' => true,
        'unit' => true
    ];
}
