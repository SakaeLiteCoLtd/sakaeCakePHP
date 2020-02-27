<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * DenpyouDnpMinoukannous Entity
 *
 * @property int $id
 * @property int $order_edi_id
 * @property string $num_order
 * @property string $product_code
 * @property string $name_order
 * @property string $code
 * @property string $place_deliver
 * @property string $conf_print
 * @property \Cake\I18n\FrozenDate $tourokubi
 * @property int $minoukannou
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 *
 * @property \App\Model\Entity\OrderEdi $order_edi
 */
class DenpyouDnpMinoukannous extends Entity
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
        'order_edi_id' => true,
        'num_order' => true,
        'product_code' => true,
        'name_order' => true,
        'code' => true,
        'place_deliver' => true,
        'conf_print' => true,
        'date_deliver' => true,
        'tourokubi' => true,
        'minoukannou' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'order_edi' => true
    ];
}
