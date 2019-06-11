<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property string $id
 * @property string $product_code
 * @property string $product_name
 * @property string $customer_id
 * @property int $multiple_cs
 * @property string $material_id
 * @property string $weight
 * @property string $torisu
 * @property string $cycle
 * @property int $primary_p
 * @property int $gaityu
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Staff $staff
 * @property \App\Model\Entity\Customer $customer
 * @property \App\Model\Entity\Material $material
 */
class Product extends Entity
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
        'product_name' => true,
        'customer_id' => true,
        'multiple_cs' => true,
        'material_id' => true,
        'weight' => true,
        'torisu' => true,
        'cycle' => true,
        'primary_p' => true,
        'gaityu' => true,
        'status' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'staff' => true,
        'customer' => true,
        'material' => true
    ];
}
