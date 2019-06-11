<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Material Entity
 *
 * @property string $id
 * @property string $grade
 * @property string $color
 * @property string $material_type_id
 * @property float $price
 * @property string $tani
 * @property string $lot_low
 * @property string $lot_upper
 * @property string $supplier_id
 * @property string $multiple_sup
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\MaterialType $material_type
 * @property \App\Model\Entity\Supplier $supplier
 */
class Material extends Entity
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
        'grade' => true,
        'color' => true,
        'material_type_id' => true,
//        'price' => true,
        'tani' => true,
//        'lot_low' => true,
//        'lot_upper' => true,
//        'supplier_id' => true,
        'multiple_sup' => true,
        'status' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'material_type' => true,
//        'supplier' => true
    ];
}
