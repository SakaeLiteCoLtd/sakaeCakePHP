<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MotoLot Entity
 *
 * @property int $id
 * @property string $hasu_lot
 * @property int $moto_lot
 * @property int $moto_lot_amount
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 */
class MotoLot extends Entity
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
      'hasu_lot' => true,
      'product_code' => true,
      'moto_lot' => true,
      'moto_lot_amount' => true,
      'delete_flag' => true,
      'created_at' => true,
      'created_staff' => true,
      'updated_at' => true,
      'updated_staff' => true
    ];
}
