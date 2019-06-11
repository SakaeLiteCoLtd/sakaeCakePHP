<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
          
          echo $this->Form->hidden('CSV' ,['value'=>$_POST['CSV'] ]) ;
?>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0" style="border-bottom: solid;border-width: 1px">
            <td><?= h($this->request->getData('CSV')) ?></td>
    </table>
    
                <?php
                //ファイルをwebrootにダウンロード
                
                
//                    $str = include $this->request->getData('CSV');

                    $fpcount = fopen($this->request->getData('CSV'), 'r' );//行数カウント用
                    for( $count = 0; fgets( $fpcount ); $count++ );
//            	    echo "<pre>";
//                    print_r($count);
//                    echo "<br>";
            	    
                    $fp = fopen($this->request->getData('CSV'), 'r' );//indexcsv.ctpで選択したファイルを開いて$fpと名前を付ける
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
                    print_r($arrFp);
//                    print_r($arrFp[1]['l_name']);
                    echo "<br>";

//                    $lines = file($this->request->getData('CSV'));
                ?>
