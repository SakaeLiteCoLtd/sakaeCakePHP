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
//use Cake\Http\ServerRequest;

class ApidenpyoudnpsController extends AppController
	{

		public function initialize()
		{
		 parent::initialize();
		 $this->Products = TableRegistry::get('products');
		 $this->OrderEdis = TableRegistry::get('orderEdis');
		 $this->DenpyouDnpMinoukannous = TableRegistry::get('denpyouDnpMinoukannous');
		 $this->Konpous = TableRegistry::get('konpous');
		}

		public function dnpyobidashi()//http://localhost:5000/Apidenpyoudnps/dnpyobidashi/api/2021-11-1.xml
		{
			$data = Router::reverse($this->request, false);//urlを取得
			$urlarr = explode("/",$data);//切り離し
			$dayarr = explode(".",$urlarr[4]);//切り離し
			$date_deliver = $dayarr[0];//日付の取得

			$DenpyouDnpMinoukannous = $this->DenpyouDnpMinoukannous->find()->contain(["OrderEdis"])
			->where(['date_deliver' => $date_deliver, 'DenpyouDnpMinoukannous.delete_flag' => 0, 'OrderEdis.delete_flag' => 0])
			->order(["product_code"=>"ASC"])->toArray();

			$arrDenpyoudnp = array();
			for($k=0; $k<count($DenpyouDnpMinoukannous); $k++){

				$Konpou = $this->Konpous->find()
				->where(['product_code' => $DenpyouDnpMinoukannous[$k]["order_edi"]["product_code"], 'delete_flag' => 0])->toArray();
				$irisu = $Konpou[0]->irisu;
				$num = $k + 1;

				 $arrDenpyoudnp[] = [
					 'num_order' => $DenpyouDnpMinoukannous[$k]["order_edi"]["num_order"],
					 'product_code' => $DenpyouDnpMinoukannous[$k]["order_edi"]["product_code"],
					 'name_order' => $DenpyouDnpMinoukannous[$k]["name_order"],
					 'line_code' => $DenpyouDnpMinoukannous[$k]["order_edi"]["line_code"],
					 'place_line' => $DenpyouDnpMinoukannous[$k]["order_edi"]["place_line"],
					 'date_order' => $DenpyouDnpMinoukannous[$k]["order_edi"]["date_order"]->format('Y/m/d'),
					 'amount' => $DenpyouDnpMinoukannous[$k]["order_edi"]["amount"],
					 'date_deliver' => $DenpyouDnpMinoukannous[$k]["order_edi"]["date_deliver"]->format('Y/m/d'),
					 'minoukannou' => $DenpyouDnpMinoukannous[$k]["minoukannou"],
					 'irisu' => $irisu
	//				 'num' => $num
				];

			}
/*
			echo "<pre>";
			print_r($arrDenpyoudnp);
			echo "</pre>";
*/
			$this->set([
  			 'Denpyoudnp' => $arrDenpyoudnp,
  			 '_serialize' => ['Denpyoudnp']
  		 ]);
		}

		public function dnpyobidashitest()//http://localhost:5000/Apidenpyoudnps/dnpyobidashitest/api/2021-11-1.xml
		{
			echo "<pre>";
			print_r(phpinfo());
			echo "</pre>";
		}

	}
