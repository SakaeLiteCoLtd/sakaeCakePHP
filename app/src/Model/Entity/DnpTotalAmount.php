<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DnpTotalAmount Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $date_order
 * @property string $num_order
 * @property string $product_code
 * @property string $line_code
 * @property \Cake\I18n\FrozenTime $date_deliver
 * @property int $amount
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 */
class DnpTotalAmount extends Entity
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
        'date_order' => true,
        'num_order' => true,
        'name_order' => true,
        'product_code' => true,
        'line_code' => true,
        'date_deliver' => true,
        'amount' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true
    ];
}
