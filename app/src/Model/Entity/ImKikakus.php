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
class ImKikakus extends Entity
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
        'im_sokuteidata_head_id' => true,
        'size_num' => true,
        'size' => true,
        'upper' => true,
        'lower' => true,
        'im_sokuteidata_head' => true
    ];
}
