<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * OrderMaterial Entity
 *
 * @property int $id
 * @property string $id_order
 * @property string $grade
 * @property string $color
 * @property \Cake\I18n\FrozenDate $date_order
 * @property \Cake\I18n\FrozenDate $date_stored
 * @property float $amount
 * @property string $sup_id
 * @property string $deliv_cp
 * @property string $purchaser
 * @property int $check_flag
 * @property string $flg
 * @property \Cake\I18n\FrozenDate $first_date_st
 * @property \Cake\I18n\FrozenDate $real_date_st
 * @property string $num_lot
 * @property float $price
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 *
 * @property \App\Model\Entity\Sup $sup
 */
class OrderMaterial extends Entity
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
        'grade' => true,
        'color' => true,
        'date_order' => true,
        'date_stored' => true,
        'amount' => true,
        'sup_id' => true,
        'deliv_cp' => true,
        'purchaser' => true,
        'check_flag' => true,
        'flg' => true,
        'first_date_st' => true,
        'real_date_st' => true,
        'num_lot' => true,
        'price' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'sup' => true
    ];
}
