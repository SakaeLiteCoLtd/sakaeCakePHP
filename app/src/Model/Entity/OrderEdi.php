<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderEdi Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date_order
 * @property string $num_order
 * @property string $product_code
 * @property float $price
 * @property \Cake\I18n\FrozenDate $date_deliver
 * @property \Cake\I18n\FrozenDate $first_date_deliver
 * @property int $amount
 * @property string $customer_code
 * @property string $place_deliver_code
 * @property string $place_line
 * @property string $line_code
 * @property string $check_denpyou
 * @property string $gaityu
 * @property int $bunnou
 * @property int $kannou
 * @property \Cake\I18n\FrozenDate $date_bunnou
 * @property \Cake\I18n\FrozenTime $check_kannou
 * @property string $delete_flg
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 */
class OrderEdi extends Entity
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
        'product_code' => true,
        'price' => true,
        'date_deliver' => true,
        'first_date_deliver' => true,
        'amount' => true,
        'customer_code' => true,
        'place_deliver_code' => true,
        'place_line' => true,
        'line_code' => true,
        'check_denpyou' => true,
        'gaityu' => true,
        'bunnou' => true,
        'kannou' => true,
        'date_bunnou' => true,
        'check_kannou' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true
    ];
}
