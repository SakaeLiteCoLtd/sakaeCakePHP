<?php
namespace App\myClass\EDItouroku;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class htmlEDItouroku extends AppController
{
     public function initialize()
    {
        parent::initialize();
        $this->ProductGaityus = TableRegistry::get('productGaityus');
        $this->KariOrderToSuppliers = TableRegistry::get('kariOrderToSuppliers');
        $this->UnitOrderToSuppliers = TableRegistry::get('unitOrderToSuppliers');
        $this->OrderToSuppliers = TableRegistry::get('orderToSuppliers');
        $this->AttachOrderToSuppliers = TableRegistry::get('attachOrderToSuppliers');
    }

    public function htmlgaityutouroku()
   {

    //ここから外注登録（insert into order_to_supplier）
    $KariOrderToSupplier = $this->KariOrderToSuppliers->find()->where(['flag_attach' => 0])->toArray();
    if(count($KariOrderToSupplier) > 0){//KariOrderToSuppliersテーブルの'flag_attach' => 0のデータを取り出す。
/*
      echo "<pre>";
      print_r(count($KariOrderToSupplier));
      echo "</pre>";
*/
      $arrPro = array();//空の配列を作る
      $arrProcode = array();
      for($k=0; $k<count($KariOrderToSupplier); $k++){//外注登録
        $id = $KariOrderToSupplier[$k]->id;
        $id_order = $KariOrderToSupplier[$k]->id_order;
        $product_code = $KariOrderToSupplier[$k]->product_code;
        $date_deliver = $KariOrderToSupplier[$k]->date_deliver->format('Y-m-d');
        $amount = $KariOrderToSupplier[$k]->amount;
        $id_supplier = $KariOrderToSupplier[$k]->id_supplier;

        $ProductGaityu = $this->ProductGaityus->find()->where(['product_code' => $product_code])->toArray();
        $price = $ProductGaityu[0]->price_shiire;

        $_SESSION['KariOrderToSuppliers'][$k] = array(
          'id' => $id,
          'id_order' => $id_order,
          'product_code' => $product_code,
          'date_deliver' => $date_deliver,
          'id_supplier' => $id_supplier,
          'price' => $price,
          'amount' => $amount
        );

        $arrProcode[] = $product_code;

      }

      echo "<pre>";
      print_r($_SESSION['KariOrderToSuppliers']);
      echo "</pre>";

      $arrProcode = array_unique($arrProcode);//品番の重複を削除
      $arrProcode = array_values($arrProcode);//添え字の振り直し
/*
      echo "<pre>";
      print_r($arrProcode);
      echo "</pre>";
*/
      for($k=0; $k<count($arrProcode); $k++){//品番毎に外注登録していく

        $arrKariIds = array();
        $arrAttachnum = array();
/*
        echo "<pre>";
        print_r("ループ".$k);
        echo "</pre>";
*/
        $product_code = $arrProcode[$k];
        $total_amount = 0;//その品番のtotal_amountを計算する

        //その品番のdate_deliverをひとつ取り出す
        $keyIndex = array_search($product_code, array_column($_SESSION['KariOrderToSuppliers'], 'product_code'));
        $arrKariOrderToSuppliers = $_SESSION['KariOrderToSuppliers'][$keyIndex];

        $date_deliver = $arrKariOrderToSuppliers["date_deliver"];


        for($i=0; $i<count($_SESSION['KariOrderToSuppliers']); $i++){//total_amountと最短のdate_deliverを取得する
          if($_SESSION['KariOrderToSuppliers'][$i]['product_code'] === $product_code){//狙った品番の場合
            $id_order = $_SESSION['KariOrderToSuppliers'][$i]['id_order'];
            $id_supplier = $_SESSION['KariOrderToSuppliers'][$i]['id_supplier'];
            $total_amount = $total_amount + $_SESSION['KariOrderToSuppliers'][$i]['amount'];

            if(isset($_SESSION['KariOrderToSuppliers'][$i]['price'])){
              $price = $_SESSION['KariOrderToSuppliers'][$i]['price'];
            }else{
              $price = 0;
            }

            if($date_deliver > $_SESSION['KariOrderToSuppliers'][$i]['date_deliver']){
              $date_deliver = $_SESSION['KariOrderToSuppliers'][$i]['date_deliver'];
            }else{
              $date_deliver = $date_deliver;
            }

            //足し込んだKariOrderToSuppliersテーブルをupdateする　'flag_attach' => 1にする
            //足し込んだKariOrderToSuppliersのデータのidを取っておく
            $arrKariIds[] = $_SESSION['KariOrderToSuppliers'][$i]['id'];

            $this->KariOrderToSuppliers->updateAll(
            ['flag_attach' => 1],['id'  => $_SESSION['KariOrderToSuppliers'][$i]['id']]
            );

            //update KariOrderToSupplierする（旧DB）
            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('kari_order_to_supplier');
            $table->setConnection($connection);

            $updater = "UPDATE kari_order_to_supplier set flag_attach = 1 where product_id ='".$product_code."' and id_order = '".$id_order."' and flag_attach = 0";//もとのDBも更新
            $connection->execute($updater);

            $connection = ConnectionManager::get('default');

          }
        }

        $UnitOrderToSupplier = $this->UnitOrderToSuppliers->find()->where(['product_code' => $product_code])->toArray();
        if(isset($UnitOrderToSupplier[0])){
          $unit_amount = $UnitOrderToSupplier[0]->unit_amount;
        }else{
          $unit_amount =0;
        }
/*
        echo "<pre>";
        print_r($product_code." -unit-".$unit_amount."  -total-".$total_amount."---".$date_deliver);
        echo "</pre>";
*/
            if($unit_amount > 0){//発注単位がある場合

              $unit_count = floor($total_amount/$unit_amount);//発注単位何個分か
              $mod_amount = $total_amount % $unit_amount;//あまりは何個か
              $attach_num = 1;

              for($j=0; $j<=$unit_count; $j++){//発注単位個分

                 if($j<$unit_count){//$j<$unit_countは単位ごとに登録

                   $id_order_attach = $id_order."-".$attach_num;

                   $arrOrderToSuppliers = array();
                   $arrOrderToSuppliers[] = [//OrderToSuppliersへの登録用
                     'id_order' => $id_order_attach,
                     'product_code' => $product_code,
                     'price' => $price,
                     'date_deliver' => $date_deliver,
                     'first_date_deliver' => $date_deliver,
                     'amount' => $unit_amount,
                     'first_amount' => $unit_amount,
                     'id_supplier' => $id_supplier,
                     'tourokubi' => date("Y-m-d"),
                     'maisu_denpyou_bunnou' => 0,
                     'delete_flag' => 0,
                     'created_staff' => $this->Auth->user('staff_id'),
                     'created_at' => date("Y-m-d H:i:s")
                   ];
/*
                   echo "<pre>";
                   print_r("単位");
                   print_r($arrOrderToSuppliers);
                   echo "</pre>";
*/
                   //OrderToSupplierの登録
                   $OrderToSuppliers = $this->OrderToSuppliers->patchEntity($this->OrderToSuppliers->newEntity(), $arrOrderToSuppliers[0]);
                   $this->OrderToSuppliers->save($OrderToSuppliers);

                   //insert into OrderToSupplierする（旧DB）
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('order_to_supplier');
                   $table->setConnection($connection);

                     $connection->insert('order_to_supplier', [
                       'id_order' => $arrOrderToSuppliers[0]['id_order'],
                       'product_id' => $arrOrderToSuppliers[0]['product_code'],
                       'price' => $arrOrderToSuppliers[0]["price"],
                       'date_deliver' => $arrOrderToSuppliers[0]["date_deliver"],
                       'first_date_deliver' => $arrOrderToSuppliers[0]["date_deliver"],
                       'amount' => $arrOrderToSuppliers[0]["amount"],
                       'first_amount' => $arrOrderToSuppliers[0]["amount"],
                       'id_supplier' => $id_supplier,
                       'tourokubi' => date("Y-m-d"),
                       'maisu_denpyou_bunnou' => 0,
                       'delete_flag' => 0,
                       'created_at' => date("Y-m-d H:i:s"),
                       'created_emp_id' => $this->Auth->user('staff_id')
                     ]);

                   $connection = ConnectionManager::get('default');

                   $date_deliver1 = strtotime($date_deliver);
                   $date_deliver = date('Y-m-d', strtotime('+1 day', $date_deliver1));//単位ごとに納期を次の日にする
                   $attach_num = $attach_num + 1;

                   //KariOrderToSuppliersテーブルとOrderToSupplierテーブルを紐づけるためattachテーブルに登録にする
                   //KariOrderToSuppliersのidとOrderToSupplierのid_orderをセットにして登録する
                   $arrAttachnum[] = $id_order_attach;

                 }else{//$j=$unit_countのとき余りを登録

                   $id_order_attach = $id_order."-".$attach_num;

                   $arrOrderToSuppliers = array();
                   $arrOrderToSuppliers[] = [//OrderToSuppliersへの登録用
                     'id_order' => $id_order_attach,
                     'product_code' => $product_code,
                     'price' => $price,
                     'date_deliver' => $date_deliver,
                     'first_date_deliver' => $date_deliver,
                     'amount' => $mod_amount,
                     'first_amount' => $mod_amount,
                     'id_supplier' => $id_supplier,
                     'tourokubi' => date("Y-m-d"),
                     'maisu_denpyou_bunnou' => 0,
                     'delete_flag' => 0,
                     'created_staff' => $this->Auth->user('staff_id'),
                     'created_at' => date("Y-m-d H:i:s")
                   ];
/*
                   echo "<pre>";
                   print_r("あまり");
                   print_r($arrOrderToSuppliers);
                   echo "</pre>";
*/
                   //OrderToSupplierの登録
                   $OrderToSuppliers = $this->OrderToSuppliers->patchEntity($this->OrderToSuppliers->newEntity(), $arrOrderToSuppliers[0]);
                   $this->OrderToSuppliers->save($OrderToSuppliers);

                   //insert into OrderToSupplierする（旧DB）
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('order_to_supplier');
                   $table->setConnection($connection);

                   $connection->insert('order_to_supplier', [
                     'id_order' => $arrOrderToSuppliers[0]['id_order'],
                     'product_id' => $arrOrderToSuppliers[0]['product_code'],
                     'price' => $arrOrderToSuppliers[0]["price"],
                     'date_deliver' => $arrOrderToSuppliers[0]["date_deliver"],
                     'first_date_deliver' => $arrOrderToSuppliers[0]["date_deliver"],
                     'amount' => $arrOrderToSuppliers[0]["amount"],
                     'first_amount' => $arrOrderToSuppliers[0]["amount"],
                     'id_supplier' => $id_supplier,
                     'tourokubi' => date("Y-m-d"),
                     'maisu_denpyou_bunnou' => 0,
                     'delete_flag' => 0,
                     'created_at' => date("Y-m-d H:i:s"),
                     'created_emp_id' => $this->Auth->user('staff_id')
                   ]);

                   $connection = ConnectionManager::get('default');


                   //KariOrderToSuppliersテーブルとOrderToSupplierテーブルを紐づけるためattachテーブルに登録にする
                   //KariOrderToSuppliersのidとOrderToSupplierのid_orderをセットにして登録する
                   $arrAttachnum[] = $id_order_attach;

                 }
              }

            }else{//発注単位がない場合全部発注

              $attach_num = 1;
              $id_order_attach = $id_order."-".$attach_num;

              $arrOrderToSuppliers = array();
              $arrOrderToSuppliers[] = [//OrderToSuppliersへの登録用
                'id_order' => $id_order_attach,
                'product_code' => $product_code,
                'price' => $price,
                'date_deliver' => $date_deliver,
                'first_date_deliver' => $date_deliver,
                'amount' => $total_amount,
                'first_amount' => $total_amount,
                'id_supplier' => $id_supplier,
                'tourokubi' => date("Y-m-d"),
                'maisu_denpyou_bunnou' => 0,
                'delete_flag' => 0,
                'created_staff' => $this->Auth->user('staff_id'),
                'created_at' => date("Y-m-d H:i:s")
              ];
/*
              echo "<pre>";
              print_r("unitなし");
              print_r($arrOrderToSuppliers);
              echo "</pre>";
*/
             //OrderToSupplierの登録
             $OrderToSuppliers = $this->OrderToSuppliers->patchEntity($this->OrderToSuppliers->newEntity(), $arrOrderToSuppliers[0]);
             $this->OrderToSuppliers->save($OrderToSuppliers);

             //insert into OrderToSupplierする（旧DB）
             $connection = ConnectionManager::get('DB_ikou_test');
             $table = TableRegistry::get('order_to_supplier');
             $table->setConnection($connection);

             $connection->insert('order_to_supplier', [
               'id_order' => $arrOrderToSuppliers[0]['id_order'],
               'product_id' => $arrOrderToSuppliers[0]['product_code'],
               'price' => $arrOrderToSuppliers[0]["price"],
               'date_deliver' => $arrOrderToSuppliers[0]["date_deliver"],
               'first_date_deliver' => $arrOrderToSuppliers[0]["date_deliver"],
               'amount' => $arrOrderToSuppliers[0]["amount"],
               'first_amount' => $arrOrderToSuppliers[0]["amount"],
               'id_supplier' => $id_supplier,
               'tourokubi' => date("Y-m-d"),
               'maisu_denpyou_bunnou' => 0,
               'delete_flag' => 0,
               'created_at' => date("Y-m-d H:i:s"),
               'created_emp_id' => $this->Auth->user('staff_id')
             ]);

             $connection = ConnectionManager::get('default');


             //KariOrderToSuppliersテーブルとOrderToSupplierテーブルを紐づけるためattachテーブルに登録にする
             //KariOrderToSuppliersのidとOrderToSupplierのid_orderをセットにして登録する
             $arrAttachnum[] = $id_order_attach;

            }
/*
            echo "<pre>";
            print_r("Kari_id");
            print_r($arrKariIds);
            echo "</pre>";

            echo "<pre>";
            print_r("id_order");
            print_r($arrAttachnum);
            echo "</pre>";
*/
            if(count($arrKariIds) > count($arrAttachnum)){//KariOrderToSuppliersの方がOrderToSupplierより多いとき

              for($m=0; $m<count($arrKariIds); $m++){//$arrKariIds分

                 if(isset($arrAttachnum[$m])){
                   $arrAttach = array();

                   $arrAttach[] = [//attach_order_to_supplierへの登録用
                     'id_order' => $arrAttachnum[$m],
                     'kari_order_to_supplier_id' => $arrKariIds[$m]
                   ];

                   echo "<pre>";
                   print_r("1Attach".$m." ".count($arrKariIds));
                   print_r($arrAttach);
                   echo "</pre>";

                 $AttachOrderToSuppliers = $this->AttachOrderToSuppliers->patchEntity($this->AttachOrderToSuppliers->newEntity(), $arrAttach[0]);
                   $this->AttachOrderToSuppliers->save($AttachOrderToSuppliers);

                   //insert into AttachOrderToSupplierする（旧DB）

                   $KariOrderToSupplier = $this->KariOrderToSuppliers->find()->where(['id' => $arrAttach[0]["kari_order_to_supplier_id"]])->toArray();
                   $product_code = $KariOrderToSupplier[0]->product_code;
                   $id_order = $KariOrderToSupplier[0]->id_order;

                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('attach_order_to_supplier');
                   $table->setConnection($connection);

                   $sql = "SELECT id FROM kari_order_to_supplier".
                         " where product_id ='".$product_code."' and id_order = '".$id_order."'";
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $kari_order_to_supplier_id_moto = $connection->execute($sql)->fetchAll('assoc');

                     $connection->insert('attach_order_to_supplier', [
                         'id_order' => $arrAttach[0]["id_order"],
                         'kari_order_to_supplier_id' => $kari_order_to_supplier_id_moto[0]['id']
                     ]);

                   $connection = ConnectionManager::get('default');

                 }else{
                   $arrAttach = array();

                   $arrAttach[] = [//attach_order_to_supplierへの登録用
                     'id_order' => $arrAttachnum[0]."-".$m,
                     'kari_order_to_supplier_id' => $arrKariIds[$m]
                   ];

                   echo "<pre>";
                   print_r("2Attach".$m." ".count($arrKariIds));
                   print_r($arrAttach);
                   echo "</pre>";

                   $AttachOrderToSuppliers = $this->AttachOrderToSuppliers->patchEntity($this->AttachOrderToSuppliers->newEntity(), $arrAttach[0]);
                   $this->AttachOrderToSuppliers->save($AttachOrderToSuppliers);

                   //insert into AttachOrderToSupplierする（旧DB）

                   $KariOrderToSupplier = $this->KariOrderToSuppliers->find()->where(['id' => $arrAttach[0]["kari_order_to_supplier_id"]])->toArray();
                   $product_code = $KariOrderToSupplier[0]->product_code;
                   $id_order = $KariOrderToSupplier[0]->id_order;

                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('attach_order_to_supplier');
                   $table->setConnection($connection);

                   $sql = "SELECT id FROM kari_order_to_supplier".
                         " where product_id ='".$product_code."' and id_order = '".$id_order."'";
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $kari_order_to_supplier_id_moto = $connection->execute($sql)->fetchAll('assoc');

                     $connection->insert('attach_order_to_supplier', [
                         'id_order' => $arrAttach[0]["id_order"],
                         'kari_order_to_supplier_id' => $kari_order_to_supplier_id_moto[0]['id']
                     ]);

                   $connection = ConnectionManager::get('default');


                 }

              }

            }else{//OrderToSupplierの方がKariOrderToSuppliersより多いとき

              for($m=0; $m<count($arrAttachnum); $m++){//$arrKariIds分

                 if(isset($arrKariIds[$m])){
                   $arrAttach = array();

                   $arrAttach[] = [//attach_order_to_supplierへの登録用
                     'id_order' => $arrAttachnum[$m],
                     'kari_order_to_supplier_id' => $arrKariIds[$m]
                   ];
                   $AttachOrderToSuppliers = $this->AttachOrderToSuppliers->patchEntity($this->AttachOrderToSuppliers->newEntity(), $arrAttach[0]);
                   $this->AttachOrderToSuppliers->save($AttachOrderToSuppliers);//saveManyで一括登録

                   //insert into AttachOrderToSupplierする（旧DB）

                   $KariOrderToSupplier = $this->KariOrderToSuppliers->find()->where(['id' => $arrAttach[0]["kari_order_to_supplier_id"]])->toArray();
                   $product_code = $KariOrderToSupplier[0]->product_code;
                   $id_order = $KariOrderToSupplier[0]->id_order;

                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('attach_order_to_supplier');
                   $table->setConnection($connection);

                   $sql = "SELECT id FROM kari_order_to_supplier".
                         " where product_id ='".$product_code."' and id_order = '".$id_order."'";
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $kari_order_to_supplier_id_moto = $connection->execute($sql)->fetchAll('assoc');

                     $connection->insert('attach_order_to_supplier', [
                         'id_order' => $arrAttach[0]["id_order"],
                         'kari_order_to_supplier_id' => $kari_order_to_supplier_id_moto[0]['id']
                     ]);

                   $connection = ConnectionManager::get('default');


                 }else{
                   $arrAttach = array();

                   $arrAttach[] = [//attach_order_to_supplierへの登録用
                     'id_order' => $arrAttachnum[$m],
                     'kari_order_to_supplier_id' => $arrKariIds[0]
                   ];
/*
                   echo "<pre>";
                   print_r("Attach".$m);
                   print_r($arrAttach);
                   echo "</pre>";
*/
                   $AttachOrderToSuppliers = $this->AttachOrderToSuppliers->patchEntity($this->AttachOrderToSuppliers->newEntity(), $arrAttach[0]);
                   $this->AttachOrderToSuppliers->save($AttachOrderToSuppliers);//saveManyで一括登録

                   //insert into AttachOrderToSupplierする（旧DB）

                   $KariOrderToSupplier = $this->KariOrderToSuppliers->find()->where(['id' => $arrAttach[0]["kari_order_to_supplier_id"]])->toArray();
                   $product_code = $KariOrderToSupplier[0]->product_code;
                   $id_order = $KariOrderToSupplier[0]->id_order;

                   $connection = ConnectionManager::get('DB_ikou_test');
                   $table = TableRegistry::get('attach_order_to_supplier');
                   $table->setConnection($connection);

                   $sql = "SELECT id FROM kari_order_to_supplier".
                         " where product_id ='".$product_code."' and id_order = '".$id_order."'";
                   $connection = ConnectionManager::get('DB_ikou_test');
                   $kari_order_to_supplier_id_moto = $connection->execute($sql)->fetchAll('assoc');

                     $connection->insert('attach_order_to_supplier', [
                         'id_order' => $arrAttach[0]["id_order"],
                         'kari_order_to_supplier_id' => $kari_order_to_supplier_id_moto[0]['id']
                     ]);

                   $connection = ConnectionManager::get('default');


                 }

              }

            }

      }

    }
  //  return $data;
   }

   public function htmlgaityukaritouroku($arrFp)
  {

    for($k=0; $k<count($arrFp); $k++){//外注仮登録

      $ProductGaityu = $this->ProductGaityus->find()->where(['product_code' => $arrFp[$k]['product_code'], 'flag_denpyou' => 1,  'status' => 0])->toArray();
      if(count($ProductGaityu) > 0){//外注製品であればkari_order_to_suppliersに登録

        $datenouki = strtotime($arrFp[$k]["date_deliver"]);
        $datenoukiye = date('Y-m-d', strtotime("-1 day", $datenouki));
        $w = date("w", strtotime($datenoukiye));//納期の前日の曜日を取得
        if($w == 0){//前日が日曜日なら３日前の金曜日に変更
          $kari_datenouki = date('Y-m-d', strtotime("-3 day", $datenouki));
        }elseif($w == 6){//前日が土曜日なら２日前の金曜日に変更
          $kari_datenouki = date('Y-m-d', strtotime("-2 day", $datenouki));
        }else{//前日が平日ならそのまま
          $kari_datenouki = $datenoukiye;
        }
        $kari_w = date("w", strtotime($kari_datenouki));
        $_SESSION['supplier_date_deliver'] = array(
          'date_deliver' => $kari_datenouki
        );

        $ProductGaityu = $this->ProductGaityus->find()->where(['product_code' => $arrFp[$k]['product_code']])->toArray();
        $price = $ProductGaityu[0]->price_shiire;

        $id_supplier = $ProductGaityu[0]->id_supplier;
          $_SESSION['ProductGaityu'] = array(
            'id_order' => $arrFp[$k]['num_order'],
            'product_code' => $arrFp[$k]['product_code'],
            'price' => $price,
            'date_deliver' => $_SESSION['supplier_date_deliver']["date_deliver"],
            'amount' => $arrFp[$k]["amount"],
            'id_supplier' => $id_supplier,
            'tourokubi' => date("Y-m-d"),
            'flag_attach' => 0,
            'delete_flag' => 0,
            'created_at' => date("Y-m-d H:i:s"),
            'created_staff' => $this->Auth->user('staff_id')
          );
/*
          echo "<pre>";
          print_r('KariOrderToSuppliers1');
          print_r($_SESSION['ProductGaityu']);
          echo "</pre>";
*/
          $KariOrderToSuppliers = $this->KariOrderToSuppliers->patchEntity($this->KariOrderToSuppliers->newEntity(), $_SESSION['ProductGaityu']);
          if ($this->KariOrderToSuppliers->save($KariOrderToSuppliers)) {
            $mes = "※登録されました";
            $this->set('mes',$mes);

            //insert into KariOrderToSupplierする（旧DB）
            $connection = ConnectionManager::get('DB_ikou_test');
            $table = TableRegistry::get('kari_order_to_supplier');
            $table->setConnection($connection);

              $connection->insert('kari_order_to_supplier', [
                'id_order' => $arrFp[$k]['num_order'],
                'product_id' => $arrFp[$k]['product_code'],
                'price' => $price,
                'date_deliver' => $_SESSION['supplier_date_deliver']["date_deliver"],
                'amount' => $arrFp[$k]["amount"],
                'id_supplier' => $id_supplier,
                'tourokubi' => date("Y-m-d"),
                'flag_attach' => 0,
                'delete_flag' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'created_emp_id' => $this->Auth->user('staff_id')
              ]);

            $connection = ConnectionManager::get('default');

          }else{
            echo "<pre>";
            print_r("※ ".$arrFp[$k]['product_code']." がkari_order_to_supplierテーブルに登録できませんでした");
            echo "</pre>";
          }

      }

    }

  }

      public function htmlgaityukaritourokuAssemble($arrFp)
     {

       if(isset($arrFp[0][0])){//組み立てのデータを登録できる型に変更する。
         $arrFp[0] = $arrFp[0];
       }else{
         $arrFFp = $arrFp;
         $arrFp = array();
         $arrFp[] = $arrFFp;
       }

       for($k=0; $k<count($arrFp[0]); $k++){//外注仮登録

         $ProductGaityu = $this->ProductGaityus->find()->where(['product_code' => $arrFp[0][$k]['product_code'], 'flag_denpyou' => 1,  'status' => 0])->toArray();
         if(count($ProductGaityu) > 0){//外注製品であればkari_order_to_suppliersに登録

           $datenouki = strtotime($arrFp[0][$k]["date_deliver"]);
           $datenoukiye = date('Y-m-d', strtotime("-1 day", $datenouki));
           $w = date("w", strtotime($datenoukiye));//納期の前日の曜日を取得
           if($w == 0){//前日が日曜日なら３日前の金曜日に変更
             $kari_datenouki = date('Y-m-d', strtotime("-3 day", $datenouki));
           }elseif($w == 6){//前日が土曜日なら２日前の金曜日に変更
             $kari_datenouki = date('Y-m-d', strtotime("-2 day", $datenouki));
           }else{//前日が平日ならそのまま
             $kari_datenouki = $datenoukiye;
           }
           $kari_w = date("w", strtotime($kari_datenouki));
           $_SESSION['supplier_date_deliver'] = array(
             'date_deliver' => $kari_datenouki
           );

           $id_supplier = $ProductGaityu[0]->id_supplier;
             $_SESSION['ProductGaityu'] = array(
               'id_order' => $arrFp[0][$k]['num_order'],
               'product_code' => $arrFp[0][$k]['product_code'],
               'price' => 0,
               'date_deliver' => $_SESSION['supplier_date_deliver']["date_deliver"],
               'amount' => $arrFp[0][$k]["amount"],
               'id_supplier' => $id_supplier,
               'tourokubi' => date("Y-m-d"),
               'flag_attach' => 0,
               'delete_flag' => 0,
               'created_at' => date("Y-m-d H:i:s"),
               'created_staff' => $this->Auth->user('staff_id')
             );

             $KariOrderToSuppliers = $this->KariOrderToSuppliers->patchEntity($this->KariOrderToSuppliers->newEntity(), $_SESSION['ProductGaityu']);
             if ($this->KariOrderToSuppliers->save($KariOrderToSuppliers)) {
               $mes = "※登録されました";
               $this->set('mes',$mes);

               //insert into KariOrderToSupplierする（旧DB）
               $connection = ConnectionManager::get('DB_ikou_test');
               $table = TableRegistry::get('kari_order_to_supplier');
               $table->setConnection($connection);

                 $connection->insert('kari_order_to_supplier', [
                   'id_order' => $arrFp[0][$k]['num_order'],
                   'product_id' => $arrFp[0][$k]['product_code'],
                   'price' => 0,
                   'date_deliver' => $_SESSION['supplier_date_deliver']["date_deliver"],
                   'amount' => $arrFp[0][$k]["amount"],
                   'id_supplier' => $id_supplier,
                   'tourokubi' => date("Y-m-d"),
                   'flag_attach' => 0,
                   'delete_flag' => 0,
                   'created_at' => date("Y-m-d H:i:s"),
                   'created_emp_id' => $this->Auth->user('staff_id')
                 ]);

               $connection = ConnectionManager::get('default');

             }else{
               echo "<pre>";
               print_r("※ ".$arrFp[$k]['product_code']." がkari_order_to_supplierテーブルに登録できませんでした");
               echo "</pre>";
             }

         }

       }

     }

	public function get_rows(){
		return $this->rows;
		}

	public function get_html(){
		return $this->html;
		}

}

?>
