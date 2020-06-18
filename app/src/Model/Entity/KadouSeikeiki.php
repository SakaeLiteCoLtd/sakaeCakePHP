<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * KadouSeikeiki Entity
 *
 * @property int $id
 * @property int $seikeiki_id
 * @property string $product_code
 * @property \Cake\I18n\FrozenTime $starting_tm
 * @property \Cake\I18n\FrozenTime $finishing_tm
 * @property \Cake\I18n\FrozenTime $deleted_at
 * @property \Cake\I18n\FrozenTime $created_at
 * @property \Cake\I18n\FrozenTime $updated_at
 *
 * @property \App\Model\Entity\Seikeiki $seikeiki
 */
class KadouSeikeiki extends Entity
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
        'seikeiki_id' => true,
        'product_code' => true,
        'starting_tm' => true,
        'finishing_tm' => true,
        'deleted_at' => true,
        'created_at' => true,
        'updated_at' => true,
        'seikeiki' => true
    ];
}
