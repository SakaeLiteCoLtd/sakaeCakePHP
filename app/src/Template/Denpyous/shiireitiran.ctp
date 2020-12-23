<?php
/**
 * AuthHelper: Authの変数にアクセスできる
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Customer $customer
 */
use App\myClass\Shinkimenus\htmlShinkimenu;//myClassフォルダに配置したクラスを使用

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
    <?= $this->Form->create($Users, ['url' => ['action' => 'shiiresyuuseipreadd']]) ?>

    <br><br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
              <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">会社名</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">発注名</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">受入日</strong></div></td>
                <td width="100" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">単価</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">数量</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:blue">状況</strong></div></td>
                <td width="50" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:blue"></strong></div></td>
              </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <?php for($i=0; $i<count($arrOrderSpecialShiire); $i++): ?>
              <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSpecialShiire[$i]["ProductSuppliername"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSpecialShiire[$i]["order_name"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSpecialShiire[$i]["date_order"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSpecialShiire[$i]["price"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSpecialShiire[$i]["amount"]) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($arrOrderSpecialShiire[$i]["kannouhyouji"]) ?></font></td>
                <?php
                echo "<td colspan='20' nowrap='nowrap'><div align='center'>";
                echo $this->Form->submit("編集" , ['action'=>'syousai', 'name' => $arrOrderSpecialShiire[$i]["id"]]) ;
                echo "</div></td>";
                ?>
              </tr>
            <?php endfor;?>
            </tbody>
        </table>
    <br><br>
  </fieldset>
