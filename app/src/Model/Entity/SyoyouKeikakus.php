<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SyoyouKeikakus Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenDate $date_keikaku
 * @property string $num_keikaku
 * @property string $product_code
 * @property \Cake\I18n\FrozenDate $date_deliver
 * @property int $amount
 */
class SyoyouKeikakus extends Entity
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
        'date_keikaku' => true,
        'num_keikaku' => true,
        'product_code' => true,
        'date_deliver' => true,
        'amount' => true
    ];
}
