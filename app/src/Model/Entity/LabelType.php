<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabelType Entity
 *
 * @property string $id
 * @property string $type_id
 * @property int $row_product
 * @property int $row_place
 * @property int $row_amount
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Type $type
 */
class LabelType extends Entity
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
        'type_id' => true,
        'row_product' => true,
        'row_place' => true,
        'row_amount' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'type' => true
    ];
}
