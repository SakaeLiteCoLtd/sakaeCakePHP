<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ContRejection Entity
 *
 * @property int $id
 * @property string $cont
 *
 * @property \App\Model\Entity\ResultZensuFooder[] $result_zensu_fooders
 */
class ContRejection extends Entity
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
        'cont' => true,
        'result_zensu_fooders' => true
    ];
}
