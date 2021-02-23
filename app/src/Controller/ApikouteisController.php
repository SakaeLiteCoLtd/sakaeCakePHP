<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

use Cake\Utility\Xml;//xmlのファイルを読み込みために必要
use Cake\Utility\Text;
use Cake\Routing\Router;//urlの取得
use Cake\Http\Client;//httpの読取に必要

class ApigenryousController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->Users = TableRegistry::get('users');
		 $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
		 $this->OrderMaterials = TableRegistry::get('orderMaterials');
		 $this->OrderSpecials = TableRegistry::get('orderSpecials');
		 $this->PriceMaterials = TableRegistry::get('priceMaterials');
		 $this->DeliverCompanies = TableRegistry::get('deliverCompanies');
		 $this->Suppliers = TableRegistry::get('suppliers');

		 $this->ScheduleKouteisTests = TableRegistry::get('scheduleKouteisTests');

		}



	}
