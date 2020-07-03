<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
 use Cake\ORM\TableRegistry;//独立したテーブルを扱う
 $this->Products = TableRegistry::get('products');//productsテーブルを使う
 $this->NameLotFlagUseds = TableRegistry::get('nameLotFlagUseds');
?>
        <?php
          $username = $this->request->Session()->read('Auth.User.username');

          header('Expires:-1');
          header('Cache-Control:');
          header('Pragma:');
        ?>

        <?php
         use App\myClass\Kadous\htmlKadoumenu;//myClassフォルダに配置したクラスを使用
         $htmlKadoumenu = new htmlKadoumenu();
         $htmlKadoumenus = $htmlKadoumenu->Kadoumenus();
         ?>
         <hr size="5" style="margin: 0.5rem">
         <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
         <?php
            echo $htmlKadoumenus;
         ?>
         </table>
         <hr size="5" style="margin: 0.5rem">

<br><br>
<table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
  <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
        <thead>
            <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <td width="80" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#FF66FF">成型機</strong></div></td>
              <td width="180" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#FF66FF">品番</strong></div></td>
              <td width="180" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#FF66FF">品名</strong></div></td>
              <td width="300" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#FF66FF">ロットコード</strong></div></td>
            </tr>
        </thead>
        <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
          <tr style="border-bottom: solid;border-width: 1px">
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($seikeiki." 号機") ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($product_code) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($product_name) ?></font></td>
            <td colspan="20" nowrap="nowrap"><font color="blue"><?= h($lot_code) ?></font></td>
          </tr>
        </tbody>
    </table>

    <br><br>
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
                <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#FF0000">開始ロット</strong></div></td>
                  <td width="150" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#FF0000">終了ロット</strong></div></td>
                </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><font><?= h($first_lot_num) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($last_lot_num) ?></font></td>
              </tr>
            </tbody>
        </table>

        <br><br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
                <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#228B22">日報開始時刻</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#228B22">日報終了時刻</strong></div></td>
                  <td width="180" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#228B22">日報ショット数</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#228B22">日報ショットサイクル</strong></div></td>
                </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><font><?= h($starting_tm_nippou) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($finishing_tm_nippou) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($amount_nippou) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($shot_cycle_nippou) ?></font></td>
              </tr>
            </tbody>
    </table>

    <br><br>

    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC" style="border-bottom: solid;border-width: 1px">
            <thead>
                <tr border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#5507FF">プログラム探索開始時刻</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 11pt; color:#5507FF">プログラム探索終了時刻</strong></div></td>
                  <td width="180" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 9pt; color:#5507FF">プログラム計算ショット数</strong></div></td>
                  <td width="200" height="30" colspan="20" nowrap="nowrap"><div align="center"><strong style="font-size: 10pt; color:#5507FF">プログラムショットサイクル</strong></div></td>
                </tr>
            </thead>
            <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
              <tr style="border-bottom: solid;border-width: 1px">
                <td colspan="20" nowrap="nowrap"><font><?= h($starting_tm_program) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($finishing_tm_program) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($amount_programming) ?></font></td>
                <td colspan="20" nowrap="nowrap"><font><?= h($shot_cycle_mode) ?></font></td>
              </tr>
            </tbody>
    </table>
<br><br><br><br><br><br>
