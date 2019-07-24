<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImSokuteidataHead Entity
 *
 * @property string $id
 * @property string $product_id
 * @property string $kind_kensa
 * @property \Cake\I18n\FrozenDate $inspec_date
 * @property string $lot_num
 * @property int $torikomi
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Product $product
 */
class ImSokuteidataHead extends Entity
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
        'product_id' => true,
        'kind_kensa' => true,
        'inspec_date' => true,
        'lot_num' => true,
        'torikomi' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'product' => true
    ];
}
