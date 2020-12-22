<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用
use Cake\ORM\TableRegistry;//独立したテーブルを扱う
$this->SyoumouSuppliers = TableRegistry::get('syoumouSuppliers');
$this->AccountSyoumouElements = TableRegistry::get('accountSyoumouElements');

?>
        <?php
            $username = $this->request->Session()->read('Auth.User.username');

            $htmlShinkimenu = new htmlShinkimenu();
            $htmlShinkis = $htmlShinkimenu->Shinkimenus();
            $htmldenpyomenus = $htmlShinkimenu->denpyomenus();
        ?>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <?php
               echo $htmldenpyomenus;
          ?>
        </table>
        <hr size="5" style="margin: 0.5rem">
        <table style="margin-bottom:0px" width=85% border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/subTouroku.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumoupreadd')));?></td>
              <td style="padding: 0.1rem 0.1rem; text-align: center"><a href="qr/index.php"><?php echo $this->Html->image('Labelimg/label_ichiran.gif',array('width'=>'85','height'=>'36','url'=>array('action'=>'syoumouitiranform')));?></td>
          </tr>
        </table>
    <?= $this->Flash->render() ?>
    <?= $this->Form->create($Users, ['url' => ['action' => 'syoumousyuuseiview']]) ?>

    <br><br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">発注NO.</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">業者名</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">発注品</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">用途</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">納入日</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">単価</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">数量</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">状況</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue"></strong></div></td>
              </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php for($i=0; $i<count($arrOrderSyoumouShiireFooder); $i++): ?>

                <?php
                $SyoumouSuppliers = $this->SyoumouSuppliers->find()->where(['id' => $arrOrderSyoumouShiireFooder[$i]["syoumou_supplier_id"]])->toArray();
                if(isset($SyoumouSuppliers[0])){
                  $SyoumouSupplier = $SyoumouSuppliers[0]->name;
                }else{
                  $SyoumouSupplier = "";
                }

                $AccountSyoumouElements = $this->AccountSyoumouElements->find()->where(['id' => $arrOrderSyoumouShiireFooder[$i]["element_shiwake"]])->toArray();
                if(isset($AccountSyoumouElements[0])){
                  $AccountSyoumouElement = $AccountSyoumouElements[0]->element;
                }else{
                  $AccountSyoumouElement = "";
                }

                if($arrOrderSyoumouShiireFooder[$i]["kannou"] == 1){
                  $kannou = "完納";
                }else{
                  $kannou = "未納";
                }
                ?>

              <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSyoumouShiireFooder[$i]["num_order"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($SyoumouSupplier) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSyoumouShiireFooder[$i]["order_product_name"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($AccountSyoumouElement) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSyoumouShiireFooder[$i]["date_deliver"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSyoumouShiireFooder[$i]["price"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSyoumouShiireFooder[$i]["amount"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($kannou) ?></font></td>
                <?php
                echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
                echo $this->Form->submit("表示" , ['action'=>'syousai', 'name' => $arrOrderSyoumouShiireFooder[$i]["order_syoumou_shiire_header_id"]]) ;
                echo "</div></td>";
                ?>
              </tr>
            <?php endfor;?>
            </tbody>
        </table>
    <br><br>
  </fieldset>
