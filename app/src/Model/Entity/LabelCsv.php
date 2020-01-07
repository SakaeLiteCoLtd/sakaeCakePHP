<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * LabelCsv Entity
 *
 * @property string $id
 * @property int $number_sheet
 * @property string $hanbetsu
 * @property string $place1
 * @property string $place2
 * @property string $product1
 * @property string $product2
 * @property string $name_pro1
 * @property string $name_pro2
 * @property string $irisu1
 * @property string $irisu2
 * @property string $unit1
 * @property string $unit2
 * @property string $line_code
 * @property string $date
 * @property string $start_lot
 * @property int $delete_flag
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string $created_staff
 * @property \Cake\I18n\FrozenTime $updated_at
 * @property string $updated_staff
 */
class LabelCsv extends Entity
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
        'number_sheet' => true,
        'hanbetsu' => true,
        'place1' => true,
        'place2' => true,
        'product1' => true,
        'product2' => true,
        'name_pro1' => true,
        'name_pro2' => true,
        'irisu1' => true,
        'irisu2' => true,
        'unit1' => true,
        'unit2' => true,
        'line_code' => true,
        'date' => true,
        'start_lot' => true,
        'delete_flag' => true,
        'created_at' => true,
        'created_staff' => true,
        'updated_at' => true,
        'updated_staff' => true
    ];
}
