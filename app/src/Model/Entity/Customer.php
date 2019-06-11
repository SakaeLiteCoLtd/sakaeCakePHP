<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Customer Entity
 *
 * @property string $id
 * @property string $customer_code
 * @property string $name
 * @property string $zip
 * @property string $address
 * @property string $tel
 * @property string $fax
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Staff $staff
 */
class Customer extends Entity
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
        'customer_code' => true,
        'name' => true,
        'zip' => true,
        'address' => true,
        'tel' => true,
        'fax' => true,
        'status' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'staff' => true
    ];
}
