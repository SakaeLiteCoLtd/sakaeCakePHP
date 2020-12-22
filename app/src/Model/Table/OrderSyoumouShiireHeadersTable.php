<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrderSyoumouShiireHeadersTable extends Table
{

    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('order_syoumou_shiire_headers');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('SyoumouSuppliers', [
            'foreignKey' => 'syoumou_supplier_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('OrderSyoumouShiireFooders', [
            'foreignKey' => 'order_syoumou_shiire_header_id'
        ]);
    }

}
