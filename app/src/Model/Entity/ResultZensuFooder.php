<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ResultZensuFooder Entity
 *
 * @property int $id
 * @property int $result_zensu_head_id
 * @property int $cont_rejection_id
 * @property int $amount
 * @property string $bik
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property int $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property int $updated_staff
 *
 * @property \App\Model\Entity\ResultZensuHead $result_zensu_head
 * @property \App\Model\Entity\ContRejection $cont_rejection
 */
class ResultZensuFooder extends Entity
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
        'result_zensu_head_id' => true,
        'cont_rejection_id' => true,
        'amount' => true,
        'bik' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true,
        'result_zensu_head' => true,
        'cont_rejection' => true
    ];
}
