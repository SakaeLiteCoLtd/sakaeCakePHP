<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PriceMaterial Entity
 *
 * @property string $id
 * @property string $material_id
 * @property string $supplier_id
 * @property float $price
 * @property \Cake\I18n\FrozenDate $start
 * @property \Cake\I18n\FrozenDate $finish
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Material $material
 * @property \App\Model\Entity\Supplier $supplier
 */
class PriceMaterial extends Entity
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
        'material_id' => true,
        'supplier_id' => true,
        'lot_low' => true,//tuika181109
        'lot_upper' => true,//tuika181109
        'price' => true,
        'start' => true,
        'finish' => true,
        'status' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'material' => true,
        'supplier' => true
    ];
}
