<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション

class SyukkaKensasController extends AppController {

      public function initialize()
    {
     parent::initialize();
     $this->ImSokuteidataHeads = TableRegistry::get('imSokuteidataHeads');//productsテーブルを使う
     $this->ImKikakus = TableRegistry::get('imKikakus');//productsテーブルを使う
     $this->ImSokuteidataResults = TableRegistry::get('imSokuteidataResults');//productsテーブルを使う
     $this->Products = TableRegistry::get('products');//productsテーブルを使う
    }

     public function index()
    {
      $dirName = 'data_IM測定/';//webroot内にアクセスされる

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
                        $countname = 0;//ファイル名のかぶりを防ぐため
                          while(($file = readdir($child_dir)) !== false){//子while
                            $countname += 1;//ファイル名がかぶらないようにカウントしておく
                              if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, -4, 4) == ".csv" ){//csvファイルだけOPEN
                                  if(substr($file, 0, 5) <> "sumi_" ){//sumi_でないファイルだけOPEN

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

                                    //ImSokuteidataHeadsの登録用データをセット
                                    $arrIm_heads = array();//空の配列を作る
                                    $len = mb_strlen($folder);
                                    $product_code = mb_substr($folder,0,$num);
                                    $inspec_date = substr($file,0,4)."-".substr($file,4,2)."-".substr($file,6,2);
                                    $lot_num = $arrFp[4][2];
                                    $kind_kensa = substr($folder,$num+1,$len);

                                  	$ProductData = $this->Products->find()->where(['product_code' => $product_code])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
                                  	$product_id = $ProductData[0]->id;//配列の0番目（0番目しかない）のcustomer_codeとnameをつなげたものに$Productと名前を付ける

                                    $arrIm_heads[] = $product_id;
                                    $arrIm_heads[] = $kind_kensa;
                                    $arrIm_heads[] = $inspec_date;
                                    $arrIm_heads[] = $lot_num;
                                    $arrIm_heads[] = 0;
                                    $arrIm_heads[] = 0;

                                    $name_heads = array('product_id', 'kind_kensa', 'inspec_date', 'lot_num', 'torikomi', 'delete_flag');
                                    $arrIm_heads = array_combine($name_heads, $arrIm_heads);

//                                    echo "<pre>";
//                                    print_r($arrIm_heads);
//                                    echo "<br>";

                                    //ImSokuteidataHeadsデータベースに登録
                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->newEntity();//newentityに$userという名前を付ける

                                    $imSokuteidataHeads = $this->ImSokuteidataHeads->patchEntity($imSokuteidataHeads, $arrIm_heads);
                                    $connection = ConnectionManager::get('default');//トランザクション1
                                    // トランザクション開始2
                                    $connection->begin();//トランザクション3
                                    try {//トランザクション4
                                      if ($this->ImSokuteidataHeads->save($imSokuteidataHeads)) {//ImSokuteidataHeadsをsaveできた時

                                          //ImKikakusの登録用データをセット
                                          $cnt = count($arrFp[1]);
                                          $arrImKikakus = array_slice($arrFp , 1, 3);
                                          for ($k=7; $k<=$cnt-2; $k++) {//
                                            $arrIm_kikaku_data = array();

                                            $size_num = $k-6;
                                            $size = $arrImKikakus[0][$k];
                                            $upper = $arrImKikakus[1][$k];
                                            $lower = $arrImKikakus[2][$k];

                                            $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
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

//                                          echo "<pre>";
//                                         print_r($arrIm_kikaku);
//                                         echo "<br>";

                                          //ImKikakusデータベースに登録
                                          $imKikakus = $this->ImKikakus->newEntity();//newentityに$userという名前を付ける

                                          $imKikakus = $this->ImKikakus->patchEntities($imKikakus, $arrIm_kikaku);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                //          $connection = ConnectionManager::get('default');//トランザクション1
                                //          // トランザクション開始2
                                //          $connection->begin();//トランザクション3
                                //          try {//トランザクション4
                                            if ($this->ImKikakus->saveMany($imKikakus)) {//ImKikakusをsaveできた時（saveManyで一括登録）

                                                //ImSokuteidataResultsの登録用データをセット
                                                $inspec_datetime = substr($arrFp[4][1],0,4)."-".substr($arrFp[4][1],5,2)."-".substr($arrFp[4][1],8,mb_strlen($arrFp[4][1])-8);

                                                 $arrImResults = array_slice($arrFp , 4, $count);
                                                 for ($j=0; $j<=$count-5; $j++) {
                                                    for ($k=7; $k<=$cnt-2; $k++) {
                                                      $arrIm_Result_data = array();

                                                      $serial = $arrImResults[$j][3];
                                                      $size_num = $k-6;
                                                      $result = $arrImResults[$j][$k];
                                                      $status = $arrImResults[$j][4];

                                                      $ImSokuteidataHeadsData = $this->ImSokuteidataHeads->find()->where(['lot_num' => $lot_num])->toArray();//'product_code' => $product_codeとなるデータをProductsテーブルから配列で取得
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

  //                                             echo "<pre>";
  //                                             print_r($arrIm_Result);
  //                                             echo "<br>";

                                                  //ImSokuteidataResultsデータベースに登録
                                                  $imSokuteidataResults = $this->ImSokuteidataResults->newEntity();//newentityに$userという名前を付ける

                                                  $imSokuteidataResults = $this->ImSokuteidataResults->patchEntities($imSokuteidataResults, $arrIm_Result);//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
                                //                  $connection = ConnectionManager::get('default');//トランザクション1
                                //                  // トランザクション開始2
                                //                  $connection->begin();//トランザクション3
                                //                  try {//トランザクション4
                                                    if ($this->ImSokuteidataResults->saveMany($imSokuteidataResults)) {//ImSokuteidataResultsをsaveできた時（saveManyで一括登録）
                                //                      $connection->commit();// コミット5
                                                    } else {
                                                      $this->Flash->error(__('The Users could not be saved. Please, try again.'));
                                                      throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                                    }
                                //                  } catch (Exception $e) {//トランザクション7
                                //                  //ロールバック8
                                //                    $connection->rollback();//トランザクション9
                                //                  }//トランザクション10


                                            } else {
                                              $this->Flash->error(__('The Users could not be saved. Please, try again.'));
                                              throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                            }
                                  //        } catch (Exception $e) {//トランザクション7
                                  //        //ロールバック8
                                  //          $connection->rollback();//トランザクション9
                                  //        }//トランザクション10

                                        $connection->commit();// コミット5
                                      } else {
                                        $this->Flash->error(__('The user could not be saved. Please, try again.'));
                                        throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
                                      }
                                    } catch (Exception $e) {//トランザクション7
                                    //ロールバック8
                                      $connection->rollback();//トランザクション9
                                    }//トランザクション10

/*
                                $datefile = mb_substr($file,0,8);//8文字目までの文字列を$datefileと定義する
              									$toCopyFile = "sumi_".$file;//バックアップ用のファイル名
                                rename($dirName.$folder.'/'.$file, $dirName.$folder.'/'.$toCopyFile);//data_IM測定/$folder/$fileのファイル名を$toCopyFileに変更
//                                print_r($toCopyFile);
//                          			echo "<br>";
                                $open_filename = $dirName.$folder;//$open_filenameを子ディレクトリ名として定義
                                $toDirCopy =  $dirName.$folder;//$toDirCopyを子ディレクトリ名として定義
                                $toCopyFile = $datefile."_".$product_code."_"."backup"."_".$countname;//フォルダ名の変更
                                rename($open_filename, 'backupData_IM測定/'.$toCopyFile);//backupData_IM測定の中にフォルダを作り、移動//エラーが出る
*/
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
    }

}
