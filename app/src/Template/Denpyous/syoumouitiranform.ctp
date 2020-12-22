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
    <?= $this->Form->create($Users, ['url' => ['action' => 'syoumouitiran']]) ?>

    <br><br>

    <table align="left" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tr bgcolor="#E6FFFF" >
      <td align="left" rowspan="2" width="50" bgcolor="#E6FFFF" style="border: none"><div align="right"><?= $this->Form->submit(__('未入荷一覧'), array('name' => 'minyuuka')); ?></div></td>
    </tr>
    </table>

  <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
    <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
      <tr>
        <td width="350" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">業者名</strong></div></td>
        <td width="400" colspan="40" nowrap="nowrap"><div align="center"><strong style="font-size: 13pt; color:blue">日付</strong></div></td>
      </tr>

      <tr>
        <td  rowspan='2'  height='6' colspan='20' style='border-bottom: 1px solid black;border-width: 1px'><?= $this->Form->input("syoumousupplierid", ["type"=>"select","empty"=>"選択してください", "options"=>$arrSyoumouSupplier, 'label'=>false]) ?></td>

        <?php
          $dateYMD = date('Y-m-d');
          $dateYMD1 = strtotime($dateYMD);
          $dayye = date('Y-m-d', strtotime('-1 day', $dateYMD1));

          echo "<td width='50' colspan='3' style='border-bottom: 0px'><div align='center'><strong style='font-size: 13pt; color:blue'>\n";
          echo "開始";
          echo "</strong></div></td>\n";

        ?>

        <td width="400" colspan="40" style="border-bottom: 1px;border-width: 1px"><div align="center"><?= $this->Form->input("date_sta", array('type' => 'date', 'value' => $dayye, 'monthNames' => false, 'label'=>false)); ?></div></td>

        <?php

          echo "</tr>\n";
          echo "<tr style='border-bottom: 0px;border-width: 0px'>\n";
          echo "<td colspan='3'><div align='center'><strong style='font-size: 13pt; color:blue'>\n";
          echo "終了";
          echo "</strong></div></td>\n";

        ?>
        <td width="250" colspan="40" style="border-bottom: solid;border-width: 1px"><div align="center"><?= $this->Form->input("date_fin", array('type' => 'date', 'value' => $dateYMD, 'monthNames' => false, 'label'=>false)); ?></div></td>
      </tr>
      <br>
    <tr bgcolor="#E6FFFF" >
      <td align="left" rowspan="2"  colspan="20" width="250" bgcolor="#E6FFFF" style="border: none"><div align="left"><?= $this->Form->submit(__('検索'), array('name' => 'kensaku')); ?></div></td>
      <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
      <td width="100" colspan="30" nowrap="nowrap" bgcolor="#E6FFFF" style="border: none"><div align="center"><strong style="font-size: 15pt; color:blue"></strong></div></td>
    </tr>
  </table>
  </fieldset>
