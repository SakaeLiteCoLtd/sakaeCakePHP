<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImKikakus Entity
 *
 * @property string $id
 * @property string $im_sokuteidata_head_id
 * @property int $size_num
 * @property float $size
 * @property float $upper
 * @property float $lower
 *
 * @property \App\Model\Entity\ImSokuteidataHead $im_sokuteidata_head
 */
class ImKikakuTaious extends Entity
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
      'kensahyuo_num' => true,
      'kind_kensa' => true,
      'size_num' => true,
    ];
}
