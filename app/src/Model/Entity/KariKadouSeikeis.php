<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KariKadouSeikei Entity
 *
 * @property string $id
 * @property string $product_code
 * @property int $seikeiki
 * @property string $seikeiki_code
 * @property \Cake\I18n\FrozenTime $starting_tm
 * @property \Cake\I18n\FrozenTime $finishing_tm
 * @property float $cycle_shot
 * @property int $amount_shot
 * @property float $accomp_rate
 * @property string $present_kensahyou
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
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
        'updated_staff' => true
    ];
}
