<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrderSyoumouShiireFoodersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('order_syoumou_shiire_fooders');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('OrderSyoumouShiireHeaders', [
            'foreignKey' => 'order_syoumou_shiire_header_id',
            'joinType' => 'INNER'
        ]);
    }

}
