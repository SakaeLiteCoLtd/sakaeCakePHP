<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * AttachOrderToSupplier Entity
 *
 * @property int $id
 * @property string $id_order
 * @property int $kari_order_to_supplier_id
 *
 * @property \App\Model\Entity\KariOrderToSupplier $kari_order_to_supplier
 */
class AttachOrderToSupplier extends Entity
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
        'id_order' => true,
        'kari_order_to_supplier_id' => true,
        'kari_order_to_supplier' => true
    ];
}
