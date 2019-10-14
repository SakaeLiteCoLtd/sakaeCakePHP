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
 * @property \App\Model\Entity\KariKadouSeikei $product
 */
class KariKadouSeikei extends Entity
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
        'seikeiki' => true,
        'seikeiki_code' => true,
        'starting_tm' => true,
        'finishing_tm' => true,
        'cycle_shot' => true,
        'amount_shot' => true,
        'accomp_rate' => true,
        'present_kensahyou' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
    ];
}
