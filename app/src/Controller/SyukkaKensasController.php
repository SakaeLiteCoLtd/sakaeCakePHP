<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class SyukkaKensasController extends AppController {

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
                        $count = 0;//ファイル名のかぶりを防ぐため
                          while(($file = readdir($child_dir)) !== false){//子while
                            $count += 1;//ファイル名がかぶらないようにカウントしておく
                              if($file != "." && $file != ".."){//ファイルなら
                                if(substr($file, 0, 5) <> "sumi_" ){//sumi_でないファイルだけOPEN

                                //ファイルを開いて配列に入れる//一括保存へ

                                $fp = fopen($file, "r");//csvファイルはwebrootに入れる
                          			for( $count = 0; fgets( $fp ); $count++ );

                          			$arrFp = array();//空の配列を作る

                          			for ($k=1; $k<=$count; $k++) {//行数分
                          				$line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
                          				$im_data = explode(',',$line);//$lineを","毎に配列に入れる

                          				$keys=array_keys($im_data);
                                  $keys[array_search('',$keys)]='lot_num';//名前の変更
                          				$keys[array_search('',$keys)]='product_id';
                                  $keys[array_search('',$keys)]='kind_kensa';
                                  $keys[array_search('',$keys)]='serial';
//                                  $keys[array_search('',$keys)]="result{$i}";
                                  $keys[array_search('',$keys)]="result1";
                                  $keys[array_search('',$keys)]="result2";                                  
                          				$imdata = array_combine( $keys, $im_data );

                          				unset($im_data['1']);//削除
                          				unset($im_data['2']);//削除

                          				$arrFp[] = $im_data;//配列に追加する
                          			}

/*
                                $datefile = mb_substr($file,0,8);//'_'までの文字列を$datefileと定義する
              									$toCopyFile = "sumi_".$file;//バックアップ用のファイル名
                                rename($dirName.$folder.'/'.$file, $dirName.$folder.'/'.$toCopyFile);//data_IM測定/$folder/$fileのファイル名を$toCopyFileに変更
//                              print_r($number);
//                        			echo "<br>";
                                $open_filename = $dirName.$folder;//$open_filenameを子ディレクトリ名として定義
                                $toDirCopy =  'data_IM測定/'.$folder;//$toDirCopyを子ディレクトリ名として定義
                                $toCopyFile = $datefile."_".$product_code."_"."backup"."_".$count;//フォルダ名の変更
                                rename($open_filename, 'backupData_IM測定/'.$toCopyFile);//backupData_IM測定の中にフォルダを作り、移動//エラーが出る
*/
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
