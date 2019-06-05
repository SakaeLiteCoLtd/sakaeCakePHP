<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

?>

<?=$this->Form->create($kensahyouSokuteidata, ['url' => ['action' => 'indexcsvconfilm']])?>
<br>
<table align="center" cellpadding="0" cellspacing="0">
<td><?=$this->Form->input('CSV', array('type'=>'file' , 'label'=>false)); ?></td>
<td><?=$this->Form->submit('登録') ?></td>
</table>
<br>
<br>
                <?php
/*//実験１csvファイルを配列として表示
                    $file = fopen("employee.csv", "r");
                     
                    //CSVファイルを配列へ
                    if( $file ){
                      while( !feof($file) ){
//                        var_dump( fgetcsv($file) );
                        print_r( fgetcsv($file) );
                      }
                    }
                     
                    //ファイルポインタをクローズ
                    fclose($file);
*///実験１ここまで

/*//実験２csvファイルを配列にする
                    $line = fgets($fp);//ファイル$fpの上の１行を取る
                    $sample=explode(',',$line);//$lineを","毎に配列に入れる
            	    echo "<pre>";
                    print_r($sample);
//                    print_r($sample[0]);
                    echo "<br>";
            	    
                    $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目になる）
                    $sample=explode(',',$line);//$lineを","毎に配列に入れる
                    print_r($sample);
                    print_r($sample[0]);
                    echo "<br>";
*///実験２ここまで

/*//実験５配列にカラム名を付ける
                    $keys=array_keys($arrFp);
                    $keys[array_search('0',$keys)]='staff_code';
                    $arrFp = array_combine( $keys, $arrFp );
                    
            	    echo "<pre>";
                    print_r($arrFp);
                    echo "<br>";
*///実験５ここまで

/*
//実験３行数カウント
                    $fpcount = fopen("employee.csv", 'r' );
                    for( $count = 0; fgets( $fpcount ); $count++ );
//            	    echo "<pre>";
//                    print_r($count);
//                    echo "<br>";
//実験３ここまで

//実験４csvファイルを配列として表示
                    $arrFp = array();//空の配列を作る
                    $line = fgets($fp);//ファイル$fpの上の１行を取る（１行目）
                    for ($k=1; $k<=$count-1; $k++) {//行数分
                    $line = fgets($fp);//ファイル$fpの上の１行を取る（２行目から）
                    $sample = explode(',',$line);//$lineを","毎に配列に入れる
                    
                    $keys=array_keys($sample);
                    $keys[array_search('0',$keys)]='staff_code';//名前の変更
                    $keys[array_search('1',$keys)]='f_name';
                    $keys[array_search('2',$keys)]='l_name';
                    $keys[array_search('3',$keys)]='mail';
                    $keys[array_search('5',$keys)]='status';
                    $sample = array_combine( $keys, $sample );
                    
                    unset($sample['4']);//status_leaderを削除
                    
                    $arrFp[] = $sample;//配列に追加する
                    }
            	    echo "<pre>";
//                    print_r($arrFp);
                    print_r($arrFp[1]['l_name']);
                    echo "<br>";
//実験４ここまで


              for($n=0; $n<=10; $n++){
                      $resultArray = Array();
                          $sample0 = $arrFp["{$n}"]['staff_code'];
                          echo "<input type='hidden' name=sokuteidata[$n][staff_code] value='$sample0' />\n";
                          $sample1 = $arrFp["{$n}"]['f_name'];
                          echo "<input type='hidden' name=sokuteidata[$n][f_name] value='$sample1' />\n";
                          $sample2 = $arrFp["{$n}"]['l_name'];
                          echo "<input type='hidden' name=sokuteidata[$n][l_name] value='$sample2' size='6'/>\n";
                          $sample3 = $arrFp["{$n}"]['mail'];
                          echo "<input type='hidden' name=sokuteidata[$n][mail] value='$sample3' size='6'/>\n";
                          $sample5 = $arrFp["{$n}"]['status'];
                          echo "<input type='hidden' name=sokuteidata[$n][status] value='$sample5' size='6'/>\n";
              }
*/
//実験外部ファイルをwobrootに保存
    
    
    
                ?>
<?=$this->Form->end() ?>
