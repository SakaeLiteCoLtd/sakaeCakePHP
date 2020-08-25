<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KensahyouHead Entity
 *
 * @property string $id
 * @property string $product_id
 * @property int $version
 * @property int $type_im
 * @property int $maisu
 * @property float $size_1
 * @property float $upper_1
 * @property float $lower_1
 * @property float $size_2
 * @property float $upper_2
 * @property float $lower_2
 * @property float $size_3
 * @property float $upper_3
 * @property float $lower_3
 * @property float $size_4
 * @property float $upper_4
 * @property float $lower_4
 * @property float $size_5
 * @property float $upper_5
 * @property float $lower_5
 * @property float $size_6
 * @property float $upper_6
 * @property float $lower_6
 * @property float $size_7
 * @property float $upper_7
 * @property float $lower_7
 * @property float $size_8
 * @property float $upper_8
 * @property float $lower_8
 * @property float $size_9
 * @property string $text_10
 * @property string $text_11
 * @property float $size_12
 * @property float $upper_12
 * @property float $lower_12
 * @property float $size_13
 * @property float $upper_13
 * @property float $lower_13
 * @property float $size_14
 * @property float $upper_14
 * @property float $lower_14
 * @property float $size_15
 * @property float $upper_15
 * @property float $lower_15
 * @property float $size_16
 * @property float $upper_16
 * @property float $lower_16
 * @property float $size_17
 * @property float $upper_17
 * @property float $lower_17
 * @property float $size_18
 * @property float $upper_18
 * @property float $lower_18
 * @property float $size_19
 * @property float $upper_19
 * @property float $lower_19
 * @property float $size_20
 * @property float $upper_20
 * @property float $lower_20
 * @property string $bik
 * @property int $status
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 *
 * @property \App\Model\Entity\Product $product
 */
class KensahyouHead extends Entity
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
        'version' => true,
        'type_im' => true,
        'maisu' => true,
        'size_1' => true,
        'upper_1' => true,
        'lower_1' => true,
        'size_2' => true,
        'upper_2' => true,
        'lower_2' => true,
        'size_3' => true,
        'upper_3' => true,
        'lower_3' => true,
        'size_4' => true,
        'upper_4' => true,
        'lower_4' => true,
        'size_5' => true,
        'upper_5' => true,
        'lower_5' => true,
        'size_6' => true,
        'upper_6' => true,
        'lower_6' => true,
        'size_7' => true,
        'upper_7' => true,
        'lower_7' => true,
        'size_8' => true,
        'upper_8' => true,
        'lower_8' => true,
        'size_9' => true,
        'text_10' => true,
        'text_11' => true,
        'size_12' => true,
        'upper_12' => true,
        'lower_12' => true,
        'size_13' => true,
        'upper_13' => true,
        'lower_13' => true,
        'size_14' => true,
        'upper_14' => true,
        'lower_14' => true,
        'size_15' => true,
        'upper_15' => true,
        'lower_15' => true,
        'size_16' => true,
        'upper_16' => true,
        'lower_16' => true,
        'size_17' => true,
        'upper_17' => true,
        'lower_17' => true,
        'size_18' => true,
        'upper_18' => true,
        'lower_18' => true,
        'size_19' => true,
        'upper_19' => true,
        'lower_19' => true,
        'size_20' => true,
        'upper_20' => true,
        'lower_20' => true,
        'bik' => true,
        'status' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'product' => true
    ];
}
