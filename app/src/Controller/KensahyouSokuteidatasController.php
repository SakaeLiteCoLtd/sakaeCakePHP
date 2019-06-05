<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;//他のテーブルを扱う
use Cake\Datasource\ConnectionManager;//トランザクション
use Cake\Core\Exception\Exception;//トランザクション
use Cake\Core\Configure;//トランザクション
use App\myClass\KensahyouSokuteidata\htmlKensahyouSokuteidata;//myClassフォルダに配置したクラスを使用

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 *
 * @method \App\Model\Entity\Staff[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class KensahyouSokuteidatasController  extends AppController
{
     public function initialize()
     {
        parent::initialize();
         $this->Staffs = TableRegistry::get('staffs');//staffsテーブルを使う
         $this->Products = TableRegistry::get('products');//productsテーブルを使う
		 $this->KensahyouHeads = TableRegistry::get('kensahyouHeads');//kensahyouHeadsテーブルを使う
     }

    public function index()//「出荷検査用呼出」ページトップ
    {
		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()//KensahyouSokuteidatasテーブルの中で
		->select(['product_code','delete_flag' => '0'])
		->group('product_code')
		);
/*		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find('all', Array(//KensahyouSokuteidatasテーブルの中で
		    'conditions' => Array('delete_flag' => '0'),//'delete_flag' = '0'という条件を満たすデータを探す
		    'group' => array('product_code'),//product_codeの種類でひとまとまりにする
		)));
*///195015変更
    }

    public function indexcsv()//csvテスト用
    {
	    			$this->set('kensahyouSokuteidata',$this->KensahyouSokuteidatas->newEntity());//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

                    $fp = fopen("employee.csv", "r");//csvファイルはwebrootに入れる
                    $this->set('fp',$fp);
                    
                    $fpcount = fopen("employee.csv", 'r' );
//                    for( $count = 0; fgets( $fpcount ); $count++ );
/*            	    echo "<pre>";
                    print_r($count);
                    echo "<br>";
*/                    
/*                    $arrFp = array();//空の配列を作る
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
                    $this->set('arrFp',$arrFp);//$arrFpをctpで使用できるようセット

            	    echo "<pre>";
                    print_r($arrFp);
                    echo "<br>";
*/
            	    echo "<pre>";
                    print_r('csv_test');
            	    echo "</pre>";
    }

    public function indexcsvconfilm()//csvテスト用
    {
		$data = $this->request->getData();//postデータを$dataに
            	    echo "<pre>";
                    print_r('indexcsvconfilm');
            	    echo "</pre>";
//            	    echo "<pre>";
//                    print_r($data);
//            	    echo "</pre>";
            	    
            	    
    }

    public function search()//「出荷検査用呼出」の日付で絞り込むページ
    {
	$data = array_values($this->request->getData());//配列の値を取り出す
	$product_code = $data[0];//0番目の値
	$this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

        if ($this->request->is('post')) {//データがpostで送られたとき（日付を選んだ場合）
        	
            $data = $this->request->data;//postで送られたデータの呼び出し
            
            $value1s = $data['start']['year'];//startのyearに$value1sと名前をつける
            $value2s = $data['start']['month'];//startのmonthに$value2sと名前をつける
            $value3s = $data['start']['day'];//startのdayに$value3sと名前をつける
            $value123s = array($value1s,$value2s,$value3s);//$value1s,$value2s,$value3sの配列に$value123s
            $value_start = implode("-",$value123s);//$value1s,$value2s,$value3sを「-」でつなぐ
            $this->set('value_start',$value_start);//$value_startをctpで使用できるようセット

            $value1e = $data['end']['year'];//endのyearに$value1eと名前をつける
            $value2e = $data['end']['month'];//endのyearに$value2eと名前をつける
            $value3e = $data['end']['day'];//endのyearに$value3eと名前をつける
            $value123e = array($value1e,$value2e,$value3e);//$value1e,$value2e,$value3eの配列に$value123e
            $value_end = implode("-",$value123e);//$value1e,$value2e,$value3eを「-」でつなぐ
            $this->set('value_end',$value_end);//$value_endをctpで使用できるようセット

			$data2 = array_values($this->request->getData());//postで取り出した配列の値を取り出す
			$product_code = $data2[2];//2番目の値が$product_code
		    $this->set('product_code',$product_code);//$product_codeをctpで使用できるようセット

	        $mes = '検索結果';//$mesを「検索結果」とする
	        $this->set('mes',$mes);//$mesをctpで使用できるようセット

/*		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find('all', Array(
		    'conditions' => Array('manu_date >=' => $value_start,'manu_date <=' => $value_end,//条件$value_start>=manu_date<=$value_end
		    'delete_flag' => '0',//条件'delete_flag' = '0'
		    'product_code' => $product_code),//条件'product_code' = $product_code
		    'group' => array('manu_date'),//manu_dateが同じものをまとめる
		    'order' => array('manu_date DESC')//manu_dateを新しい順にまとめる
		)));
*/		
		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()//KensahyouSokuteidatasテーブルの中で
		->select(['all','manu_date >=' => $value_start, 'manu_date <=' => $value_end, 'delete_flag' => '0', 'product_code' => $product_code])
		->group('manu_date')
		->order('manu_date DESC')
		);//190515追加

        } else {//post以外（get）でデータが送信された場合

        $mes = '＊最新の上位３つの検査表です。';//$mesを「＊最新の上位３つの検査表です。」とする
        $this->set('mes',$mes);//$mesをctpで使用できるようセット
        
/*		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find('all', Array(//次の条件を満たすものをkensahyouSokuteidatasとしてctpで使用できるようセット
		    'conditions' => Array('delete_flag' => '0','product_code' => $product_code),//'delete_flag' = '0','product_code' = $product_code
		    'limit'=>'3',//上から３つのみ表示
		    'group' => array('manu_date'),//manu_dateが同じものをまとめる
		    'order' => array('manu_date DESC')//manu_dateを新しい順にまとめる
		)));
*/
		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find()//KensahyouSokuteidatasテーブルの中で
		->select(['manu_date','delete_flag' => '0', 'product_code' => $product_code])
		->limit('3')
		->group('manu_date')
		->order('manu_date DESC')
		);//190515追加
        }
    }

    public function view()//「出荷検査用呼出」詳細表示用
    {
		$data = array_values($this->request->query);//getで取り出した配列の値を取り出す
/*
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
*/
		$product_code = $data[0];//配列の0番目（product_code）に$product_codeと名前を付ける
		$this->set('product_code',$product_code);//$product_codeをセット

        $Products = $this->Products->find('all',[
        		'conditions' => ['product_code =' => $product_code]//条件'product_code' = $product_code
        	]); 
	 	foreach ($Products as $value) {//
			$product_id= $value->id;//$product_id
		}
		$this->set('product_id',$product_id);//$product_idをセット

    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//src/myClass/KensahyouSokuteidata/htmlKensahyouSokuteidata.php
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//$htmlKensahyouHeaderをセット

        	$Producti = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルの'product_code' = $product_codeとなるものを配列で取り出す
        	$Productid = $Producti[0]->id;//配列の0番目のidに$Productidと名前を付ける
        	$KensahyouHead = $this->KensahyouHeads->find()->where(['product_id' => $Productid])->toArray();//KensahyouHeadsテーブルの'product_id' = $Productidとなるものを配列で取り出す
        	$this->set('KensahyouHead',$KensahyouHead);//セット

        	$KensahyouHeadver = $KensahyouHead[0]->version+1;//新しいバージョンをセット
        	$this->set('KensahyouHeadver',$KensahyouHeadver);//セット

        	$KensahyouHeadid = $KensahyouHead[0]->id;//idをセット
        	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット

        	$KensahyouHead_manu_date = substr($data[1]['date'],0,10);//配列の10文字だけ抜き取りセット（manu_dateの表示のため）
        
        	$this->set('KensahyouHead_manu_date',$KensahyouHead_manu_date);//セット

//manu_dateが同じ

//        	$KensahyouHead_inspec_date = substr($data[2]['date'],0,10);//配列の10文字だけ抜き取り（inspec_dateの表示のため）
//        	$KensahyouHead_inspec_date = substr($data[2]['date'],0,10);//配列の10文字だけ抜き取り（inspec_dateの表示のため）
//        	$this->set('KensahyouHead_inspec_date',$KensahyouHead_inspec_date);//セット

        	$Kensahyou_inspec_date = $this->KensahyouSokuteidatas->find()->where(['product_code' => $product_code,'manu_date' => $KensahyouHead_manu_date])->toArray();//KensahyouSokuteidatasテーブルの'product_code' => $product_code,'manu_date' => $KensahyouHead_manu_dateとなるものを配列で取り出す（object型ででてくる）
        	$Kensahyou_inspec_date = (array)$Kensahyou_inspec_date[0]['inspec_date'];//1行下でsubstrを使うため、objectをarrayに変換
        	$KensahyouHead_inspec_date = substr($Kensahyou_inspec_date['date'],0,10);//配列の10文字だけ抜き取りセット（inspec_dateの表示のため）	
        	$this->set('KensahyouHead_inspec_date',$KensahyouHead_inspec_date);//セット
/*
        echo "<pre>";
        var_dump($KensahyouHead_inspec_date);
        echo "</pre>";
*/
		$Productn = $this->Products->find()->where(['product_code' => $product_code])->toArray();//Productsテーブルの'product_code' = $product_codeとなるものを配列で取り出す
        	$Productname = $Productn[0]->product_name;//配列の0番目のproduct_nameに$Productnameと名前を付ける
        	$this->set('Productname',$Productname);//セット

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

		$this->set('kensahyouSokuteidatas', $this->KensahyouSokuteidatas->find('all', Array(//セット
		    'conditions' => Array('product_code' => $product_code,'delete_flag' => '0','manu_date' => $data[1]['date']),//条件$data[1]['date']はgetで送られたmanu_date
		    'order' => array('cavi_num ASC')//cavi_numの小さい順
		)));
    }

    public function index1()//「出荷検査表登録」ページトップ
    {
        $this->set('entity',$this->KensahyouSokuteidatas->newEntity());//空のカラムにentityと名前を付け、ctpで使えるようにセット
		
/*        $KensahyouHeads = $this->KensahyouHeads->find('all',[
        		'conditions' => ['delete_flag' => '0'],//条件'delete_flag' => '0'
			'group' => array('product_id'),//product_idが同じものをまとめる
        	]);
*/
		$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
		->select(['product_id','delete_flag' => '0'])
		->group('product_id');

	    $arrProductcode = array();//配列の初期化
	 	foreach ($KensahyouHeads as $value) {//$KensahyouHeadsのそれぞれに対して
			$product_id = $value->product_id;//$KensahyouHeadsのproduct_idに$product_idと名前を付ける
			$product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得
			$product_code = $product[0]->product_code;//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける
	        $arrProductcode[] = $product_code;//$product_codeを配列に追加
		}
		sort($arrProductcode);//配列$arrProductcodeのデータを昇順に並び替え
	    $this->set('arrProductcode',$arrProductcode);//セット
	    
/*        echo "<pre>";
        print_r($arrProductcode[3]);
        echo "</pre>";
*/
	}

    public function form()//「出荷検査表登録」ページで検査結果を入力
    {
		$data = $this->request->getData();//postデータを$dataに
		$product_code_num = $data['product_code_num'];//$dataのproduct_code_num（ctpで選択した$arrProductcode）に$product_code_numという名前を付ける
/*        echo "<pre>";
        print_r($product_code_num);
        echo "</pre>";
*/        
/*        $KensahyouHeads = $this->KensahyouHeads->find('all',[
        		'conditions' => ['delete_flag' => '0'],//条件'delete_flag' => '0'
			    'group' => array('product_id'),//product_idが同じものをまとめる
        	]);
*/
	$KensahyouHeads = $this->KensahyouHeads->find()//KensahyouSokuteidatasテーブルの中で
	->select(['product_id','delete_flag' => '0'])
	->group('product_id');

	    $arrProductcode = array();//配列の初期化
	 	foreach ($KensahyouHeads as $value) {//$KensahyouHeadsのそれぞれに対して
			$product_id = $value->product_id;//$KensahyouHeadsのproduct_idに$product_idと名前を付ける
			$product = $this->Products->find()->where(['id' => $product_id])->toArray();//'id' => $product_code_idとなるデータをProductsテーブルから配列で取得（プルダウン）
			$product_code = $product[0]->product_code;//配列の0番目（0番目しかない）のproduct_codeに$product_codeと名前を付ける（プルダウン）
	        $arrProductcode[] = $product_code;//$product_codeを配列に追加
		}
		sort($arrProductcode);//配列$arrProductcodeのデータを昇順に並び替え
        $product_code = $arrProductcode[$product_code_num];

		$this->set('product_code',$product_code);//部品番号の表示のため1行上の$product_codeをctpで使えるようにセット
		
		$staff_id = $this->Auth->user('staff_id');//created_staffの登録用
		$this->set('staff_id',$staff_id);//セット

	    $this->set('kensahyouSokuteidata',$this->KensahyouSokuteidatas->newEntity());//空のカラムに$KensahyouSokuteidataと名前を付け、ctpで使えるようにセット

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
    }

     public function confirm()//「出荷検査表登録」確認画面
    {
    	$data = $this->request->getData();//postデータを$dataに

		$product_code = $data['product_code'];//$dataの'product_code'を$product_codeに
		$this->set('product_code',$product_code);//セット
		
        $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
        		'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
        	]);
	 	foreach ($Products as $value) {//$Productsのそれぞれに対して
			$product_id= $value->id;//$Productsのidに$product_idと名前を付ける
		}
		$this->set('product_id',$product_id);//セット
        
    	$htmlKensahyouSokuteidata = new htmlKensahyouSokuteidata();//myClassフォルダに配置したクラスを使う
    	$htmlKensahyouHeader = $htmlKensahyouSokuteidata->htmlHeaderKensahyouSokuteidata($product_id);//
    	$this->set('htmlKensahyouHeader',$htmlKensahyouHeader);//セット
    	
		$kensahyouSokuteidata = $this->KensahyouSokuteidatas->newEntity();//空のカラムに$KensahyouSokuteidataと名前を付け、次の行でctpで使えるようにセット
		$this->set('kensahyouSokuteidata',$kensahyouSokuteidata);//セット
		
            $KensahyouHeadid = $data['kensahyou_heads_id'];//$dataのkensahyou_heads_idに$kensahyou_heads_idと名前を付ける
	    	$this->set('KensahyouHeadid',$KensahyouHeadid);//セット
			
            $manu_dateY = $data['manu_date']['year'];//manu_dateのyearに$manu_dateYと名前を付ける
            $manu_dateM = $data['manu_date']['month'];//manu_dateのmonthに$manu_dateMと名前を付ける
            $manu_dateD = $data['manu_date']['day'];//manu_dateのdayに$manu_dateDと名前を付ける
            $manu_dateYMD = array($manu_dateY,$manu_dateM,$manu_dateD);//$manu_dateY,$manu_dateM,$manu_dateDの配列に$manu_dateYMD
            $manu_date = implode("-",$manu_dateYMD);//$manu_dateY,$manu_dateM,$manu_dateDを「-」でつなぐ
	    	$this->set('manu_date',$manu_date);//セット
	    	
            $inspec_dateY = $data['inspec_date']['year'];//inspec_dateのyearに$inspec_dateYと名前を付ける
            $inspec_dateM = $data['inspec_date']['month'];//inspec_dateのmonthに$inspec_dateMと名前を付ける
            $inspec_dateD = $data['inspec_date']['day'];//inspec_dateのdayに$inspec_dateDと名前を付ける
            $inspec_dateYMD = array($inspec_dateY,$inspec_dateM,$inspec_dateD);//$inspec_dateY,$inspec_dateM,$inspec_dateDの配列に$manu_dateYMD
            $inspec_date = implode("-",$inspec_dateYMD);//$inspec_dateY,$inspec_dateM,$inspec_dateDを「-」でつなぐ
	    	$this->set('inspec_date',$inspec_date);//セット

            $delete_flag = $data['delete_flag'];//$dataのdelete_flagに$delete_flagと名前を付ける
	    	$this->set('delete_flag',$delete_flag);//セット

            $created_staff = $data['created_staff'];//$dataのcreated_staffに$created_staffと名前を付ける
	    	$this->set('created_staff',$created_staff);//セット
		
            $updated_staff = $data['updated_staff'];//$dataのupdated_staffに$updated_staffと名前を付ける
	    	$this->set('updated_staff',$updated_staff);//セット

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
	}

     public function do()//「出荷検査表登録」登録画面
    {
		$data = $this->request->getData();//postデータ取得し、$dataと名前を付ける

//            	    echo "<pre>";
//                    print_r($data);
//                    var_dump($data);
//                    echo "<br>";

        $product_code = $this->request->getData()['sokuteidata'][1]['product_code'];//sokuteidata（全部で8つ）の1番目の配列のproduct_codeをとる（product_codeはどれも同じ）
		$this->set('product_code',$product_code);//セット
		
        $Products = $this->Products->find('all',[//Productsテーブルから'product_code =' => $product_codeとなるものを見つける
        		'conditions' => ['product_code =' => $product_code]//条件'product_code =' => $product_code
        	]);
	 	foreach ($Products as $value) {//$Productsのそれぞれに対して
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

			if ($this->request->is('post')) {//postなら登録
				$kensahyouSokuteidata = $this->KensahyouSokuteidatas->patchEntities($kensahyouSokuteidata, $this->request->getData('sokuteidata'));//patchEntitiesで一括登録…https://qiita.com/tsukabo/items/f9dd1bc0b9a4795fb66a
				$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
				$connection->begin();//トランザクション3
				try {//トランザクション4
						if ($this->KensahyouSokuteidatas->saveMany($kensahyouSokuteidata)) {//saveManyで一括登録
							$connection->commit();// コミット5
						} else {
							$this->Flash->error(__('The KensahyouSokuteidatas could not be saved. Please, try again.'));
							throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
						}
				} catch (Exception $e) {//トランザクション7
				//ロールバック8
					$connection->rollback();//トランザクション9
				}//トランザクション10
			}
    }

    public function edit($id = null)//edit未完成
    {
	$kensahyouSokuteidata = $this->KensahyouSokuteidatas->get($id);
	$this->set('kensahyouSokuteidata',$kensahyouSokuteidata);
	
	$staff_id = $this->Auth->user('staff_id');
	$kensahyouHead['updated_staff'] = $staff_id;

		if ($this->request->is(['patch', 'post', 'put'])) {
			$kensahyouHead = $this->KensahyouHeads->patchEntity($kensahyouHead, $this->request->getData());
	
			$connection = ConnectionManager::get('default');//トランザクション1
				// トランザクション開始2
			$connection->begin();//トランザクション3
			try {//トランザクション4
	
				if ($this->KensahyouHeads->save($kensahyouHead)) {
					$this->Flash->success(__('The KensahyouHeads has been updated.'));
					$connection->commit();// コミット5
					return $this->redirect(['action' => 'index']);
				} else {
					$this->Flash->error(__('The KensahyouHeads could not be updated. Please, try again.'));
					throw new Exception(Configure::read("M.ERROR.INVALID"));//失敗6
				}
			} catch (Exception $e) {//トランザクション7
			//ロールバック8
				$connection->rollback();//トランザクション9
			}//トランザクション10
		}
    }

}
