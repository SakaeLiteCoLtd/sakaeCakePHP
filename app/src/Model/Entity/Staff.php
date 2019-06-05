<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Staff Entity
 *
 * @property string $id
 * @property string $emp_code
 * @property string $f_name
 * @property string $l_name
 * @property string $sex
 * @property \Cake\I18n\FrozenDate $birth
 * @property string $mail
 * @property string $tel
 * @property string $address
 * @property int $status
 * @property \Cake\I18n\FrozenDate $date_start
 * @property \Cake\I18n\FrozenDate $date_finish
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 */
class Staff extends Entity
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
        'staff_code' => true,
        'f_name' => true,
        'l_name' => true,
        'sex' => true,
        'birth' => true,
        'mail' => true,
        'tel' => true,
        'address' => true,
        'status' => true,
        'date_start' => true,
        'date_finish' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true
    ];
}
