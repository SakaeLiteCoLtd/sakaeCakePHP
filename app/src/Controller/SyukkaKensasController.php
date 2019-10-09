<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use App\myClass\KensahyouSokuteidata\htmlKensahyouSokuteidata;//myClassフォルダに配置したクラスを使用

class SyukkaKensasController extends AppController {

      public function initialize()
    {
     parent::initialize();
     $this->ImKikakuTaious = TableRegistry::get('imKikakuTaious');//ImKikakuTaiousテーブルを使う
     $this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//productsテーブルを使う
     $this->ImKikakus = TableRegistry::get('imKikakus');//productsテーブルを使う
     $this->ImSokuteidataResults = TableRegistry::get('imSokuteidataResults');//productsテーブルを使う
     $this->Products = TableRegistry::get('products');//productsテーブルを使う
     $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
     $this->KensahyouSokuteidatas = TableRegistry::get('kensahyouSokuteidatas');//kensahyouHeadsテーブルを使う
     $this->Users = TableRegistry::get('users');//Usersテーブルを使う
    }

    public function index()
    {
      //メニュー画面


    }

    public function index1()//IMtaiou
    {
    	$this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
    }


    public function imtaiouform()//IMtaiou
    {
    	$this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

/*      echo "<pre>";
 		  print_r($data["product_code"]);
 	  	echo "<br>";
*/
      $product_code = $data["product_code"];
      $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
      $Product = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    	$product_id = $Product[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
      $this->set('product_id',$product_id);//セット

      $ImKikakuex = $this->ImKikakuTaious->find()->where(['product_id' => $product_id])->toArray();//'product_id' => $product_idを満たすデータを$KensaProductにセット
      $this->set('ImKikakuex',$ImKikakuex);//セット
/*
      if(isset($ImKikakuex[0])){
        echo "<pre>";
        print_r($ImKikakuex[0]['product_id']);
        echo "<br>";
      } else {
        echo "<pre>";
        print_r("else");
        echo "<br>";
     }
*/
      $Productname = $Product[0]->product_name;
      $this->set('Productname',$Productname);//セット

      $ImSokuteidataHeads = $this->ImSokuteidataHeads->find()//KensahyouSokuteidatasテーブルの中で
    	->where(['product_id' => $product_id])->toArray();
      $kind_kensa = $ImSokuteidataHeads[0]->kind_kensa;

      $arrKindKensa = array("","ノギス");//配列の初期化
    	 	foreach ($ImSokuteidataHeads as $value) {//それぞれに対して
    			$arrKindKensa[] = $value->kind_kensa;//配列に追加
    		}
        $arrKindKensa = array_unique($arrKindKensa);
      $this->set('ImSokuteidataHeads',$ImSokuteidataHeads);//セット
      $this->set('arrKindKensa',$arrKindKensa);//セット

/*
      echo "<pre>";
 		  print_r($arrKindKensa);
 	  	echo "<br>";
*/
      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

    	 foreach ($Products as $value) {//$Productsそれぞれに対し
    		$product_id= $value->id;//idに$product_idと名前を付ける
    	}
    	$this->set('product_id',$product_id);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    	$Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_id' => $Productid])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

    	for($i=1; $i<=9; $i++){//size_1～9までセット
    		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
    		$this->set('size_'.$i,${"size_".$i});//セット
    	}

    	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
    		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
    		$this->set('upper_'.$j,${"upper_".$j});//セット
    		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
    		$this->set('lower_'.$j,${"lower_".$j});//セット
    	}

    }

    public function imtaiouconfirm()//IMtaiou
    {
/*      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける
      $data = $sessiondata['kikakudata'];

      echo "<pre>";
      print_r($data);
      echo "</pre>";

     $product_id = $sessiondata['kikakudata'][1]['product_id'];//$dataの'product_code'を$product_codeに
*/
     $data = $this->request->getData();
     $product_id = $data['product_id'];
     $this->set('product_id',$product_id);//セット
     $Product = $this->Products->find()->where(['id' => $product_id])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
     $product_code = $Product[0]->product_code;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
     $this->set('product_code',$product_code);//セット
     $Productname = $Product[0]->product_name;
     $this->set('Productname',$Productname);//セット

     $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
       'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
     ]);
     foreach ($Products as $value) {//上で見つけた$Productsに対して
       $product_id= $value->id;//$Productsのidに$product_idと名前を付ける
     }
     $this->set('product_id',$product_id);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//myClassフォルダに配置したクラスを使う
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る
    }

    public function impreadd()
    {
      $this->set('entity',$this->ImKikakuTaious->newEntity());//newEntity・テーブルに空の行を作る

     $session = $this->request->getSession();
     $data = $session->read();//postデータ取得し、$dataと名前を付ける
/*
     echo "<pre>";
     print_r($data['kikakudata']);
     echo "</pre>";
*/    }

   public function imlogin()
   {
     if ($this->request->is('post')) {
       $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
       $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
       $ary = explode(',', $str);//$strを配列に変換

       $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
       //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
       $this->set('username', $username);
       $Userdata = $this->Users->find()->where(['username' => $username])->toArray();

         if(empty($Userdata)){
           $delete_flag = "";
         }else{
           $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
           $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
         }
           $user = $this->Auth->identify();
         if ($user) {
           $this->Auth->setUser($user);
           return $this->redirect(['action' => 'imtaioudo']);
         }
       }
   }


    public function imtaioudo()//IMtaiou
    {
   //   $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
   $session = $this->request->getSession();
   $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける
   $data = $sessiondata['kikakudata'];
/*
   echo "<pre>";
   print_r($data);
   echo "</pre>";
*/
   $product_id = $sessiondata['kikakudata'][1]['product_id'];//$dataの'product_code'を$product_codeに
   $this->set('product_id',$product_id);//セット
   $Product = $this->Products->find()->where(['id' => $product_id])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
   $product_code = $Product[0]->product_code;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
   $this->set('product_code',$product_code);//セット
   $Productname = $Product[0]->product_name;
   $this->set('Productname',$Productname);//セット

   $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
     'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
   ]);
   foreach ($Products as $value) {//上で見つけた$Productsに対して
     $product_id= $value->id;//$Productsのidに$product_idと名前を付ける
   }
   $this->set('product_id',$product_id);//セット

   $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//myClassフォルダに配置したクラスを使う
   $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
   $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

   $ImKikakuTaiou = $this->ImKikakuTaious->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
   $this->set('ImKikakuTaiou',$ImKikakuTaiou);//セット

      if ($this->request->is('get')) {//getなら登録
        $ImKikakuTaiou = $this->ImKikakuTaious->patchEntities($ImKikakuTaiou, $data);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
        $connection = ConnectionManager::get('default');//トランザクション1
        // トランザクション開始2
        $connection->begin();//トランザクション3
        try {//トランザクション4
            if ($this->ImKikakuTaious->saveMany($ImKikakuTaiou)) {//saveManyで一括登録
              $connection->commit();// コミット5
            } else {
              $this->Flash->error(__('The KensahyouSokuteidatasimdo could not be saved. Please, try again.'));
              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
            }
        } catch (Exception $e) {//トランザクション7
        //ロールバック8
          $connection->rollback();//トランザクション9
        }//トランザクション10
      }
    }

    public function index2()//取り込み画面
    {
      $imKikakus = $this->ImKikakus->newEntity();
      $this->set('imKikakus', $imKikakus);

        $dirName = 'data_IM測定/';//webroot内のフォルダ
        $countname = 0;

      if(is_dir($dirName)){//ファイルがディレクトリかどうかを調べる(ディレクトリであるので次へ)
    	  if($dir = opendir($dirName)){//opendir でディレクトリ・ハンドルをオープンし、readdir でディレクトリ（フォルダ）内のファイル一覧を取得する。（という定石）
    	    while(($folder = readdir($dir)) !== false){//親while（ディレクトリ内のファイル一覧を取得する）
    	      if($folder != '.' && $folder != '..'){//フォルダーなら("."が無いならフォルダーという認識)
    	        if(strpos($folder,'.',0)==''){//$folderが'.'を含まなかった時
    	          if(is_dir($dirName.$folder)){//$dirName.$folderがディレクトリかどうかを調べる
    	            if($child_dir = opendir($dirName.$folder)){//opendir で$dirName.$folderの子ディレクトリをオープン
              			$folder_check = 0;//$folder_checkを定義
                			if(strpos($folder,'_',0)==''){//$folderが'_'を含まなかった時
                				$folder_check = 1;//$folder_check=1にする
                			}else{//$folderが'_'を含む時
                				$num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                				$product_code = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する
                          while(($file = readdir($child_dir)) !== false){//子while
                               if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN
                                   if(substr($file, 0, 5) != "sumi_" ){//sumi_でないファイルだけOPEN
                                    $countname += 1;//ファイル名がかぶらないようにカウントしておく
                                    $num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                            				${"product_code".$countname} = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する
                                    ${"ProductData".$countname} = $this->Products->find()->where(['product_code' => ${"product_code".$countname}])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                  	${"product_name".$countname} = ${"ProductData".$countname}[0]->product_name;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける
                                    ${"inspec_date".$countname} = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);

                                    $this->set('product_code'.$countname,${"product_code".$countname});//セット
                                    $this->set('product_name'.$countname,${"product_name".$countname});//セット
                                    $this->set('inspec_date'.$countname,${"inspec_date".$countname});//セット
                                    $this->set('countname',$countname);//セット

                                    $session = $this->request->session();
                                    $session->write('product_code', ${"product_code".$countname});
                                    $session->write('product_name', ${"product_name".$countname});
                                  }
                               }
                             }else{
                              $this->set('countname',$countname);//セット
                            }
                          }
                 			}
       	            }
     	          }//if(ファイルでなくフォルダーであるなら)の終わり
     	        }//フォルダーであるなら
     	      }
    	    }//親whileの終わり

    	  }
     }

     $dirName = 'backupData_IM測定/';//webroot内のフォルダ
     $countnameb = 0;
     $this->set('countnameb',$countnameb);//セット

     if(is_dir($dirName)){//ファイルがディレクトリかどうかを調べる(ディレクトリであるので次へ)
      if($dir = opendir($dirName)){//opendir でディレクトリ・ハンドルをオープンし、readdir でディレクトリ（フォルダ）内のファイル一覧を取得する。（という定石）
        while(($folder = readdir($dir)) !== false){//親while（ディレクトリ内のファイル一覧を取得する）
          if($folder != '.' && $folder != '..'){//フォルダーなら("."が無いならフォルダーという認識)
            if(strpos($folder,'.',0)==''){//$folderが'.'を含まなかった時
              if(is_dir($dirName.$folder)){//$dirName.$folderがディレクトリかどうかを調べる
                if($child_dir = opendir($dirName.$folder)){//opendir で$dirName.$folderの子ディレクトリをオープン
                  $folder_check = 0;//$folder_checkを定義
                    if(strpos($folder,'_',0)==''){//$folderが'_'を含まなかった時
                      $folder_check = 1;//$folder_check=1にする
                    }else{//$folderが'_'を含む時
                      $num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                      $product_code = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する
                         while(($file = readdir($child_dir)) !== false){//子while
                              if($file != "." && $file != ".."){//ファイルなら
                               if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN
                                  if(substr($file, 0, 5) == "sumi_" ){//sumi_ファイルだけOPEN
                                   $countnameb += 1;//ファイル名がかぶらないようにカウントしておく
                                   $num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                                  ${"product_codeb".$countnameb} = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する
                                   ${"ProductDatab".$countnameb} = $this->Products->find()->where(['product_code' => ${"product_codeb".$countnameb}])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                  ${"product_nameb".$countnameb} = ${"ProductDatab".$countnameb}[0]->product_name;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける
                                   ${"inspec_dateb".$countnameb} = substr($file,7,4)."-".substr($file,11,2)."-".substr($file,13,2);

                                   $this->set('product_codeb'.$countnameb,${"product_codeb".$countnameb});//セット
                                   $this->set('product_nameb'.$countnameb,${"product_nameb".$countnameb});//セット
                                   $this->set('inspec_dateb'.$countnameb,${"inspec_dateb".$countnameb});//セット
                                   $this->set('countnameb',$countnameb);//セット

                                   $session = $this->request->session();
                                   $session->write('product_codeb', ${"product_codeb".$countnameb});
                                   $session->write('product_nameb', ${"product_nameb".$countnameb});
                                 }
                              }
                            }else{
                             $this->set('countnameb',$countnameb);//セット
                           }
                         }
                      }
                    }
                }//if(ファイルでなくフォルダーであるなら)の終わり
              }//フォルダーであるなら
            }
        }//親whileの終わり
      }
    }
    }


     public function torikomi()//取り込み（画面なし自動で次のページへ）
    {
      $dirName = 'data_IM測定/';//webroot内のフォルダ
      $countname = 0;//ファイル名のかぶりを防ぐため

      if(is_dir($dirName)){//ファイルがディレクトリかどうかを調べる(ディレクトリであるので次へ)
    	  if($dir = opendir($dirName)){//opendir でディレクトリ・ハンドルをオープンし、readdir でディレクトリ（フォルダ）内のファイル一覧を取得する。（という定石）
    	    while(($folder = readdir($dir)) !== false){//親while（ディレクトリ内のファイル一覧を取得する）
    	      if($folder != '.' && $folder != '..'){//フォルダーなら("."が無いならフォルダーという認識)
    	        if(strpos($folder,'.',0)==''){//$folderが'.'を含まなかった時
    	          if(is_dir($dirName.$folder)){//$dirName.$folderがディレクトリかどうかを調べる
    	            if($child_dir = opendir($dirName.$folder)){//opendir で$dirName.$folderの子ディレクトリをオープン
              			$folder_check = 0;//$folder_checkを定義
                			if(strpos($folder,'_',0)==''){//$folderが'_'を含まなかった時
                				$folder_check = 1;//$folder_check=1にする
                			}else{//$folderが'_'を含む時
                				$num = strpos($folder,'_',0);//$numを最初に'_'が現れた位置として定義
                				$product_code = mb_substr($folder,0,$num);//'_'までの文字列を$product_idと定義する
                          while(($file = readdir($child_dir)) !== false){//子while
                               if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN
                                   if(substr($file, 0, 5) != "sumi_" ){//sumi_でないファイルだけOPEN
                                    $countname += 1;//ファイル名がかぶらないようにカウントしておく

                                    $fp = fopen('data_IM測定/'.$folder.'/'.$file, "r");//csvファイルはwebrootに入れる
                              			$this->set('fp',$fp);

                              			$fpcount = fopen('data_IM測定/'.$folder.'/'.$file, 'r' );
                              			for( $count = 0; fgets( $fpcount ); $count++ );

                              			$arrFp = array();//空の配列を作る
                                    for ($k=1; $k<=$count; $k++) {
                                        $line = fgets($fp);//ファイル$fpの上の１行を取る
                                        $ImData = explode(',',$line);//$lineを","毎に配列に入れる
                                        $keys=array_keys($ImData);
                                        $ImData = array_combine( $keys, $ImData );
                                				$arrFp[] = $ImData;//配列に追加する
                                    }


                                    $arrLot_nums = array();//lot_numの重複チェック
                                    for ($k=4; $k<=$count-1; $k++) {
                                      ${"arrLot_nums".$countname}[] = $arrFp[$k][2];
                                    }
                                    $arruniLot_num = array_unique(${"arrLot_nums".$countname});//lot_numの重複削除
                                    ${"arruniLot_num".$countname} = array_values($arruniLot_num);//配列の添字を振り直し
                                    $cntLot = count(${"arruniLot_num".$countname});//配列の要素数確認


                                    //ImSokuteidataHeadsの登録用データをセット
                                    $arrIm_head = array();//空の配列を作る
                                    for ($k=1; $k<=$cntLot; $k++) {
                                      $arrIm_heads = array();//空の配列を作る
                                      $len = mb_strlen($folder);
                                      $product_code = mb_substr($folder,0,$num);
                                      $inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);
                                      $kind_kensa = substr($folder,$num+1,$len);

                                      $session = $this->request->session();
                                      $session->write('kind_kensa', $kind_kensa);

                                    	$ProductData = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                    	$product_id = $ProductData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

                                      $arrIm_heads[] = $product_id;
                                      $arrIm_heads[] = $kind_kensa;
                                      $arrIm_heads[] = $inspec_date;
                                      $arrIm_heads[] = ${"arruniLot_num".$countname}[$k-1];
                                      $arrIm_heads[] = 0;
                                      $arrIm_heads[] = 0;

                                      $name_heads = array('product_id', 'kind_kensa', 'inspec_date', 'lot_num', 'torikomi', 'delete_flag');
                                      $arrIm_heads = array_combine($name_heads, $arrIm_heads);
                                      $arrIm_head[] = $arrIm_heads;
                                    }
                        //            echo "<pre>";
                        //            print_r($arrIm_head);
                        //            echo "<br>";

                                     //ImSokuteidataHeadsデータベースに登録
                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->newEntity();//newentityに$userという名前を付ける

                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->patchEntities($imSokuteidataHeads, $arrIm_head);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                    $connection = ConnectionManager::get('default');//トランザクション1
                                    // トランザクション開始2
                                    $connection->begin();//トランザクション3
                                    try {//トランザクション4
                                      if ($this->ImSokuteidataHeads->saveMany($imSokuteidataHeads)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                          //ImKikakusの登録用データをセット
                                          $cnt = count($arrFp[1]);
                                          $arrImKikakus = array_slice($arrFp , 1, 3);
                                          $arrIm_kikaku = array();

                                        for ($m=1; $m<=$cntLot; $m++) {
                                          for ($k=7; $k<=$cnt-2; $k++) {//

                                            $arrIm_kikaku_data = array();

                                            $size_num = $k-6;
                                            $size = $arrImKikakus[0][$k];
                                            $upper = $arrImKikakus[1][$k];
                                            $lower = $arrImKikakus[2][$k];

                                            $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => ${"arruniLot_num".$countname}[$m-1]])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                            $im_sokuteidata_head_id = $ImSokuteidataHeadsData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

                                            $arrIm_kikaku_data[] = $im_sokuteidata_head_id;//配列に追加する
                                            $arrIm_kikaku_data[] = $size_num;//配列に追加する
                                            $arrIm_kikaku_data[] = $size;//配列に追加する
                                            $arrIm_kikaku_data[] = $upper;//配列に追加する
                                            $arrIm_kikaku_data[] = $lower;//配列に追加する
                                            $name_kikaku = array('im_sokuteidata_head_id', 'size_num', 'size', 'upper', 'lower');
                                            $arrIm_kikaku_data = array_combine($name_kikaku, $arrIm_kikaku_data);
                                            $arrIm_kikaku[] = $arrIm_kikaku_data;

                                          }
                                        }
                                //        echo "<pre>";
                                //        print_r($arrIm_kikaku);
                              //          echo "<br>";

                                           //ImKikakusデータベースに登録
                                          $imKikakus = $this->ImKikakus->newEntity();//newentityに$userという名前を付ける

                                          $imKikakus = $this->ImKikakus->patchEntities($imKikakus, $arrIm_kikaku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                             if ($this->ImKikakus->saveMany($imKikakus)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                                //ImSokuteidataResultsの登録用データをセット
                                                $inspec_datetime = substr($arrFp[4][1],0,4)."-".substr($arrFp[4][1],5,2)."-".substr($arrFp[4][1],8,mb_strlen($arrFp[4][1])-8);
                                                $arrIm_Result = array();

                                                 $arrImResults = array_slice($arrFp , 4, $count);
                                                 for ($j=0; $j<=$count-5; $j++) {
                                                    for ($k=7; $k<=$cnt-2; $k++) {
                                                      $arrIm_Result_data = array();

                                                      $serial = $arrImResults[$j][3];
                                                      $size_num = $k-6;
                                                      $result = $arrImResults[$j][$k];
                                                      $status = $arrImResults[$j][4];

                                              //        echo "<pre>";
                                              //        print_r($arrFp[$j+4][2]);
                                              //        echo "<br>";

                                                      $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => $arrFp[$j+4][2]])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                                      $im_sokuteidata_head_id = $ImSokuteidataHeadsData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

                                                      $arrIm_Result_data[] = $im_sokuteidata_head_id;//配列に追加する
                                                      $arrIm_Result_data[] = $inspec_datetime;//配列に追加する
                                                      $arrIm_Result_data[] = $serial;//配列に追加する
                                                      $arrIm_Result_data[] = $size_num;//配列に追加する
                                                      $arrIm_Result_data[] = $result;//配列に追加する
                                                      $arrIm_Result_data[] = $status;//配列に追加する
                                                      $name_Result = array('im_sokuteidata_head_id', 'inspec_datetime', 'serial', 'size_num', 'result', 'status');
                                                      $arrIm_Result_data = array_combine($name_Result, $arrIm_Result_data);

                                                      $arrIm_Result[] = $arrIm_Result_data;
                                                  }
                                                 }
                                          //       echo "<pre>";
                                          //       print_r($arrIm_Result);
                                          //       echo "<br>";

                                                  //ImSokuteidataResultsデータベースに登録
                                                  $imSokuteidataResults = $this->ImSokuteidataResults->newEntity();//newentityに$userという名前を付ける

                                                  $imSokuteidataResults = $this->ImSokuteidataResults->patchEntities($imSokuteidataResults, $arrIm_Result);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                                  if ($this->ImSokuteidataResults->saveMany($imSokuteidataResults)) {//ImSokuteidataResultsをsaveできた時（saveManyで一括登録）
                                                    } else {
                                                      $this->Flash->error(__('This data1 could not be saved. Please, try again.'));
                                                      throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                                  }

                                            } else {
                                              $this->Flash->error(__('This data2 could not be saved. Please, try again.'));
                                              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                            }
                                            $connection->commit();// コミット5
                                      } else {
                                        $this->Flash->error(__('This data3 could not be saved. Please, try again.'));
                                        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                      }
                                    } catch (Exception $e) {//トランザクション7
                                    //ロールバック8
                                      $connection->rollback();//トランザクション9
                                  }//トランザクション10

                                  }else{
                                   print_r('else ');
                                  }

                                $output_dir = 'backupData_IM測定/'.$folder;
                                  if (! file_exists($output_dir)) {//backupData_IM測定の中に$folderがないとき
                                   if (mkdir($output_dir)) {
                                      $Filebi2 = mb_substr($file,0,-4);
                                      if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."005.bi2", $output_dir.'/'.$Filebi2."005.bi2")) {
                                        $toCopyFile = "sumi_".$countname."_".$file;
                                          if (rename($output_dir.'/'.$file, $output_dir.'/'.$toCopyFile)) {//ファイル名変更
                                            unlink($dirName.$folder.'/'.$file);
                                            unlink($dirName.$folder.'/'.$Filebi2."005.bi2");
                                          }
                                      }
                                    }

                                  } else {//backupData_IM測定の中に$folderがあるとき
                                    $Filebi2 = mb_substr($file,0,-4);
                                    if (copy($dirName.$folder.'/'.$file, $output_dir.'/'.$file) && copy($dirName.$folder.'/'.$Filebi2."005.bi2", $output_dir.'/'.$Filebi2."005.bi2")) {
                                      $toCopyFile = "sumi_".$countname."_".$file;
                                        if (rename($output_dir.'/'.$file, $output_dir.'/'.$toCopyFile)) {//ファイル名変更
                                          unlink($dirName.$folder.'/'.$file);
                                          unlink($dirName.$folder.'/'.$Filebi2."005.bi2");
                                        }
                                    }
                                  }
                               }
                             }
                          }
                	 		}
       	            }
    	           }//if(ファイルでなくフォルダーであるなら)の終わり
    	        }//フォルダーであるなら
     	      }
     	    }//親whileの終わり
    	  }
    	}
      return $this->redirect(['action' => 'index2']);
    }

    public function preform()//「出荷検査表登録」ページで検査結果を入力
    {
/*      $session = $this->request->session();

      $product_code = $session->read('product_code');
      $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
      $product_name = $session->read('product_name');
      $this->set('Productname',$product_name);//セット
      $kind_kensa = $session->read('kind_kensa');
      $this->set('kind_kensa',$kind_kensa);//セット
*/
      $data = array_values($this->request->query);//getで取り出した配列の値を取り出す
/*
      echo "<pre>";
      print_r($data);
      echo "</pre>";
*/
      $product_code = $data[1];
      $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
      $product_name = $data[2];
      $this->set('Productname',$product_name);//セット

    	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
    	->select(['product_id','delete_flag' => '0'])
    	->group('product_id');

    	$staff_id = $this->Auth->user('staff_id');//created_staffの登録用
    	$this->set('staff_id',$staff_id);//セット

      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

    	 foreach ($Products as $value) {//$Productsそれぞれに対し
    		$product_id= $value->id;//idに$product_idと名前を付ける
    	}
    	$this->set('product_id',$product_id);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    	$Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_id' => $Productid])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

    	for($i=1; $i<=9; $i++){//size_1～9までセット
    		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
    		$this->set('size_'.$i,${"size_".$i});//セット
    	}

    	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
    		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
    		$this->set('upper_'.$j,${"upper_".$j});//セット
    		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
    		$this->set('lower_'.$j,${"lower_".$j});//セット
    	}

      $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

    }

    public function form()//「出荷検査表登録」ページで検査結果を入力
    {
      $data = $this->request->getData();//postデータを$dataに
/*
      echo "<pre>";
    	print_r($data);
    	echo "</pre>";
*/
        $product_code = $data['product_code1'];
        $this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
        $product_name = $data['product_name1'];
        $this->set('Productname',$product_name);//セット
        $lot_num = $data['lot_num'];
        $this->set('lot_num',$lot_num);//セット
//        $kind_kensa = $data['kind_kensa'];
//        $this->set('kind_kensa',$kind_kensa);//セット

      	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
      	->select(['product_id','delete_flag' => '0'])
      	->group('product_id');

    	$staff_id = $this->Auth->user('staff_id');//created_staffの登録用
    	$this->set('staff_id',$staff_id);//セット

      $this->loadModel("KensahyouSokuteidatas");
      $kensahyouSokuteidatas = $this->KensahyouSokuteidatas->newEntity();//newentityに$userという名前を付ける
    	$this->set('kensahyouSokuteidata',$kensahyouSokuteidatas);//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

    	$Products = $this->Products->find('all',[
    		'conditions' => ['product_code =' => $product_code]//Productsテーブルの'product_code' = $product_codeとなるものを$Productsとする
    	]);

    	 foreach ($Products as $value) {//$Productsそれぞれに対し
    		$product_id= $value->id;//idに$product_idと名前を付ける
    	}
    	$this->set('product_id',$product_id);//セット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.phpを使う　newオブジェクトを生成
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

    	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    	$Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
    	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_id' => $Productid])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
    	$this->set('KensahyouHead',$KensahyouHead);//セット

    	$KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
    	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

    	$KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

      $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
      $ImSokuteidataHead_id = $ImSokuteidataHead[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
      $ImKikaku = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHead_id])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
      for($i=1; $i<=5; $i++){//size_1～9までセット
        if(isset($ImSokuteidataHead[$i])){
          ${"ImSokuteidataHead_id_".$i} = $ImSokuteidataHead[$i]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
          $ImKikakutuika = $this->ImKikakus->find()->where(['im_sokuteidata_head_id' => ${"ImSokuteidataHead_id_".$i}])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
          $ImKikaku = array_merge($ImKikaku, $ImKikakutuika);
        }
      }
      $ImSokuteidataHead_id = $ImKikaku[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
      $ImSokuteidataHeadId = $ImKikaku[0]->im_sokuteidata_head_id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
      $ImSokuteidataResult = $this->ImSokuteidataResults->find()->where(['im_sokuteidata_head_id' => $ImSokuteidataHeadId ])->toArray();

    	for($i=1; $i<=9; $i++){//size_1～9までセット
        ${"kind_kensa".$i} = "ノギス";
        $this->set('kind_kensa'.$i,${"kind_kensa".$i});//セット
    		${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
    		$this->set('size_'.$i,${"size_".$i});//セット
        for($j=0; $j<=20; $j++){//size_1～9までセット
          if(isset($ImKikaku[$j])){//
            if(${"size_".$i} == $ImKikaku[$j]['size'] and ${"size_".$i} != 0){//KensahyouHeadのsize$iと$ImKikaku[$j]['size']が同じ場合
              $ImSokuteidataHead = $this->ImSokuteidataHeads->find()->where(['id' => $ImKikaku[$j]['im_sokuteidata_head_id']])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
              ${"kind_kensa".$i} = $ImSokuteidataHead[0]->kind_kensa;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける

              $this->set('kind_kensa'.$i,${"kind_kensa".$i});//セット
              $ImSokuteidataResult = $this->ImSokuteidataResults->find()->where(['im_sokuteidata_head_id' => $ImKikaku[$j]['im_sokuteidata_head_id'] , 'size_num' => $ImKikaku[$j]['size_num']])->toArray();

              $ImSokuteidataResultarry = array();//空の配列を作る

              foreach ((array)$ImSokuteidataResult as $key => $value) {//serialで並び替え
                   $sort[$key] = $value['serial'];
                    array_push($ImSokuteidataResultarry, [$value['serial'], $value['result']]);
               }
             if(isset($ImSokuteidataResultarry[0])){
                array_multisort($ImSokuteidataResultarry, SORT_ASC, $ImSokuteidataResultarry);
                $cnt = count($ImSokuteidataResultarry);
/*
                echo "<pre>";
                print_r($ImSokuteidataResultarry);
                echo "</pre>";
*/
                for($r=1; $r<=$cnt; $r++){
                  $r1 = $r-1;
                  ${"ImSokuteidata_result_".$i."_".$r} = $ImSokuteidataResultarry[$r1][1];
                  ${"ImSokuteidata_result_".$i."_".$r} = round(${"ImSokuteidata_result_".$i."_".$r},2);
                  $this->set('ImSokuteidata_result_'.$i.'_'.$r,${"ImSokuteidata_result_".$i."_".$r});//セット
                 }
               }
            }
          }
        }
    	}

    	for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
    		${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
    		$this->set('upper_'.$j,${"upper_".$j});//セット
    		${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
    		$this->set('lower_'.$j,${"lower_".$j});//セット
    	}

      $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
      $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

    }


    public function confirm()//「出荷検査表登録」確認画面
   {
/*      $session = $this->request->getSession();
      $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける
      $data = $sessiondata['sokuteidata'];
*/
//      echo "<pre>";
//      print_r($data);
//      echo "</pre>";
      $data = $this->request->getData();
      $product_code = $data['product_code'];

//     $product_code = $sessiondata['sokuteidata'][1]['product_code'];//$dataの'product_code'を$product_codeに
     $this->set('product_code',$product_code);//セット
     $lot_num = $data['lot_num'];
     $this->set('lot_num',$lot_num);//セット

     $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
       'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
     ]);
     foreach ($Products as $value) {//上で見つけた$Productsに対して
       $product_id= $value->id;//$Productsのidに$product_idと名前を付ける
     }
     $this->set('product_id',$product_id);//セット

     $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//myClassフォルダに配置したクラスを使う
     $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
     $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

     $kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

     $KensahyouHeadid = $data['kensahyou_heads_id'];
     $this->set('KensahyouHeadid',$KensahyouHeadid);//セット
//     $lot_num = $data[1]['lot_num'];
//     $this->set('lot_num',$lot_num);//セット

//     $datakind = $this->request->getData();
//     $kind_kensa = $datakind['kind_kensa'];
//     $this->set('kind_kensa',$kind_kensa);//セット

     $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
     $Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
     $KensahyouHead = $this->KensahyouHeads->find()->where(['product_id' => $Productid])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
     $this->set('KensahyouHead',$KensahyouHead);//セット
     $Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
     $this->set('Productname',$Productname);//セット

     $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
     $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

     $KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
     $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

     for($i=1; $i<=9; $i++){//size_1～9までセット
       ${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
       $this->set('size_'.$i,${"size_".$i});//セット
     }

     for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
       ${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
       $this->set('upper_'.$j,${"upper_".$j});//セット
       ${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
       $this->set('lower_'.$j,${"lower_".$j});//セット
     }

     $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
     $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

   }


   public function preadd()
   {
     $kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
     $this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

    $session = $this->request->getSession();
    $data = $session->read();//postデータ取得し、$dataと名前を付ける
/*
    echo "<pre>";
    print_r($data['sokuteidata']);
    echo "</pre>";
*/   }

  public function login()
  {
    if ($this->request->is('post')) {
      $data = $this->request->getData();//postデータ取得し、$dataと名前を付ける
      $str = implode(',', $data);//preadd.ctpで入力したデータをカンマ区切りの文字列にする
      $ary = explode(',', $str);//$strを配列に変換

      $username = $ary[0];//入力したデータをカンマ区切りの最初のデータを$usernameとする
      //※staff_codeをusernameに変換？・・・userが一人に決まらないから無理
      $this->set('username', $username);
      $Userdata = $this->Users->find()->where(['username' => $username])->toArray();

      $staff_id = $this->Auth->user('staff_id');//created_staffの登録用
    	$this->set('staff_id',$staff_id);//セット

        if(empty($Userdata)){
          $delete_flag = "";
        }else{
          $delete_flag = $Userdata[0]->delete_flag;//配列の0番目（0番目しかない）のnameに$Roleと名前を付ける
          $this->set('delete_flag',$delete_flag);//登録者の表示のため1行上の$Roleをctpで使えるようにセット
        }
          $user = $this->Auth->identify();
        if ($user) {
          $this->Auth->setUser($user);
          return $this->redirect(['action' => 'do']);
        }
      }
  }

  public function logout()
  {
    $this->request->session()->destroy(); // セッションの破棄
//    return $this->redirect(['controller' => 'Shinkies', 'action' => 'index']);//ログアウト後に移るページ
  }

  public function do()//「出荷検査表登録」登録画面
 {
  $session = $this->request->getSession();
  $sessiondata = $session->read();//postデータ取得し、$dataと名前を付ける

  for($n=1; $n<=8; $n++){
    $created_staff = array('created_staff'=>$this->Auth->user('staff_id'));
    $_SESSION['sokuteidata'][$n] = array_merge($created_staff,$_SESSION['sokuteidata'][$n]);
  }
/*
  echo "<pre>";
  print_r($_SESSION['sokuteidata']);
  echo "<br>";
*/
  $data = $_SESSION['sokuteidata'];

  $product_code = $data[1]['product_code'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
  $this->set('product_code',$product_code);//セット

  $lot_num = $data[1]['lot_num'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
  $this->set('lot_num',$lot_num);//セット

    $manu_date = $data[1]['manu_date'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
    $this->set('manu_date',$manu_date);//セット

    $inspec_date = $data[1]['inspec_date'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
    $this->set('inspec_date',$inspec_date);//セット

    $ImKikakuid_1 = "ノギス";
    $this->set('ImKikakuid_1',$ImKikakuid_1);
    $ImKikakuid_2 = "ノギス";
    $this->set('ImKikakuid_2',$ImKikakuid_2);
    $ImKikakuid_3 = "ノギス";
    $this->set('ImKikakuid_3',$ImKikakuid_3);
    $ImKikakuid_4 = "ノギス";
    $this->set('ImKikakuid_4',$ImKikakuid_4);
    $ImKikakuid_5 = "ノギス";
    $this->set('ImKikakuid_5',$ImKikakuid_5);
    $ImKikakuid_6 = "ノギス";
    $this->set('ImKikakuid_6',$ImKikakuid_6);
    $ImKikakuid_7 = "ノギス";
    $this->set('ImKikakuid_7',$ImKikakuid_7);
    $ImKikakuid_8 = "ノギス";
    $this->set('ImKikakuid_8',$ImKikakuid_8);
    $ImKikakuid_9 = "ノギス";
    $this->set('ImKikakuid_9',$ImKikakuid_9);

    $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
    $Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
    $ImKikakus = $this->ImKikakuTaious->find()->where(['product_id' => $Productid])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得（プルダウン）
    foreach ((array)$ImKikakus as $key => $value) {
         $sort[$key] = $value['kensahyuo_num'];
     }
     if(isset($ImKikakus[0])){
      array_multisort($sort, SORT_ASC, $ImKikakus);
    }

    for($i=0; $i<=8; $i++){
      $j = $i + 1;
      if(isset($ImKikakus[$i])) {
        if($ImKikakus[$i]['kind_kensa'] != "") {
          ${"ImKikakuid_".$j} = $ImKikakus[$i]['kind_kensa'];//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける（プルダウン）
          $this->set('ImKikakuid_'.$j,${"ImKikakuid_".$j});//セット
        }else{
        }
      }else{
        ${"ImKikakuid_".$j} = "ノギス";//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける（プルダウン）
        $this->set('ImKikakuid_'.$j,${"ImKikakuid_".$j});//セット
      }
    }

    for($q=1; $q<=8; $q++){
      ${"result_weight_".$q} = $data["{$q}"]["result_weight"];
      $this->set('result_weight_'.$q,${"result_weight_".$q});//セット
      for($r=1; $r<=8; $r++){
        ${"result_size_".$q."_".$r} = $data["{$q}"]["result_size_{$r}"];
        $this->set('result_size_'.$q.'_'.$r,${"result_size_".$q."_".$r});//セット
      }
    }

   $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
     'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
   ]);

   foreach ($Products as $value) {//上で見つけた$Productsに対して
     $product_id= $value->id;//$Productsのidに$product_idと名前を付ける
   }
   $this->set('product_id',$product_id);//セット

   $kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
   $this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット

   $htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//表示用
   $htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
   $this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット

   $Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルからproduct_code＝$product_codeとなるデータを見つけ、$Productiと名前を付ける
   $Productid = $Producti[0]->id;//$Productiの0番目のデータ（0番目のデータしかない）のidに$Productidと名前を付ける
   $KensahyouHead = $this->KensahyouHeads->find()->where(['product_id' => $Productid])->toArray();//KensahyouHeadsテーブルからproduct_id＝$Productidとなるデータを見つけ、$KensahyouHeadと名前を付ける
   $this->set('KensahyouHead',$KensahyouHead);//セット
   $Productname = $Producti[0]->product_name;//$Productiの0番目のデータ（0番目のデータしかない）のproduct_nameに$Productnameと名前を付ける
   $this->set('Productname',$Productname);//セット

   $KensahyouHeadver = $KensahyouHead[0]->version+1;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
   $this->set('KensahyouHeadver',$KensahyouHeadver);//セット

   $KensahyouHeadid = $KensahyouHead[0]->id;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のidに$KensahyouHeadidと名前を付ける
   $this->set('KensahyouHeadid',$KensahyouHeadid);//セット

   for($i=1; $i<=9; $i++){//size_1～9までセット
     ${"size_".$i} = $KensahyouHead[0]->{"size_{$i}"};//KensahyouHeadのsize_1～9まで
     $this->set('size_'.$i,${"size_".$i});//セット
   }

   for($j=1; $j<=8; $j++){//upper_1～8,lowerr_1～8までセット
     ${"upper_".$j} = $KensahyouHead[0]->{"upper_{$j}"};//KensahyouHeadのupper_1～8まで
     $this->set('upper_'.$j,${"upper_".$j});//セット
     ${"lower_".$j} = $KensahyouHead[0]->{"lower_{$j}"};//KensahyouHeadのlowerr_1～8まで
     $this->set('lower_'.$j,${"lower_".$j});//セット
   }

   $KensahyouHeadbik = $KensahyouHead[0]->bik;//$KensahyouHeadの0番目のデータ（0番目のデータしかない）のversionに1を足したものに$KensahyouHeadverと名前を付ける
   $this->set('KensahyouHeadbik',$KensahyouHeadbik);//セット

   if ($this->request->is('get')) {//postなら登録
     $kensahyouSokuteidata = $this->KensahyouSokuteidatas->patchEntities($kensahyouSokuteidata, $data);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
     $connection = ConnectionManager::get('default');//トランザクション1
     // トランザクション開始2
     $connection->begin();//トランザクション3
     try {//トランザクション4
         if ($this->KensahyouSokuteidatas->saveMany($kensahyouSokuteidata)) {//saveManyで一括登録
//           $this->request->session()->destroy(); // セッションの破棄
           $connection->commit();// コミット5
         } else {
           $this->Flash->error(__('The KensahyouSokuteidatasdo could not be saved. Please, try again.'));
           throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
         }
     } catch (Exception $e) {//トランザクション7
     //ロールバック8
       $connection->rollback();//トランザクション9
     }//トランザクション10
   }
 }

}
