<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CheckLot Entity
 *
 * @property string $id
 * @property \Cake\I18n\FrozenTime $datetime_hakkou
 * @property string $product_code
 * @property string $lot_num
 * @property int $amount
 * @property int $flag_used
 * @property \Cake\I18n\FrozenDate $date_deliver
 * @property string $place_deliver_id
 * @property string $cs_name
 * @property string $operator_deliver
 * @property \Cake\I18n\FrozenTime $flag_deliver
 * @property int $delete_flg
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\PlaceDeliver $place_deliver
 */
class CheckLot extends Entity
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
        'datetime_hakkou' => true,
        'product_code' => true,
        'lot_num' => true,
        'amount' => true,
        'flag_used' => true,
        'date_deliver' => true,
        'place_deliver_id' => true,
        'cs_name' => true,
        'operator_deliver' => true,
        'flag_deliver' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'place_deliver' => true
    ];
}
