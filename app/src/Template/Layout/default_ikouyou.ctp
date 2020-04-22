<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>

        <?php
            $username = $this->request->Session()->read('Auth.User.username');

	if($username == null){
	$user = 'logout now';
	} else {
	$user = 'login : '.$username;
	}
        ?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base1.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
<table border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#E6FFFF">
  <tr style="background-color: #E6FFFF">
    <td >
        <table border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="border-style: none; background-color: #E6FFFF">
            <td bgcolor="#E6FFFF">
              <div style="float:right">
                <?php echo $user; ?>
              <?php
                if ($user == 'logout now') {
                    // ログインしているとき
                    // ログアウトへのリンクをだす
//                    echo $this->Html->link('　ログイン', array('controller'=>'users','action'=>'preadd'));
                } else {
                    // ログインしていないとき
                    // ログインへのリンクをだす
//                    echo $this->Html->link('　ログアウト', array('controller'=>'users','action'=>'logout'));
                }
              ?>
              </div>
              <div align="left"><p><?php echo $this->Html->image('logo.gif',array('width'=>'130','height'=>'20'));?></p></div>
              <table style="margin-bottom:0px" width="700" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
				<tr width="600">
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/qr/index.php'><img src='http://192.168.4.1/img/menu_qr.gif' width='150' height='60' alt='menu_qua' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/kadou/index.php'><img src='http://192.168.4.1/img/menu_nouki.gif' width='150' height='60' alt='menu_nouki' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/formcsv/index.php'><img src='http://192.168.4.1/img/menu_kadou.gif' width='150' height='60' alt='menu_kadou' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/syukka_kensa/index.php'><img src='http://192.168.4.1/img/menu_setubi.gif' width='150' height='60' alt='menu_setubi' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/seipro/index.php'><img src='http://192.168.4.1/img/menu_sisaku.gif' width='150' height='60' alt='menu_sisaku' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/analy_mtp/index.php'><img src='http://192.168.4.1/img/menu_sonota.gif' width='150' height='60' alt='menu_sonota' border='0' /></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/genryou/index.php'><img src='http://192.168.4.1/img/menu_kensaku.gif' width='150' height='60' alt='menu_kensaku' border='0' /></a></td>
				</tr>
				<tr width="600">
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/shinki_touroku/index.php'><img src='http://192.168.4.1/img/shinki_touroku.gif' width='150' height='60' alt='shinki_touroku' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/edi/index.php'><img src='http://192.168.4.1/img/menu_edi.gif' width='150' height='60' alt='menu_edi' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/rejection/index.php'><img src='http://192.168.4.1/img/menu_rejection.gif' width='150' height='60' alt='menu_rejection' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/denpyou/index.php'><img src='http://192.168.4.1/img/menu_denpyou.gif' width='150' height='60' alt='menu_denpyou' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/import_csv/index.php'><img src='http://192.168.4.1/img/menu_csv.gif' width='150' height='60' alt='menu_csv' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/koutei_kensa/index.php'><img src='http://192.168.4.1/img/menu_kouteikensa.gif' width='150' height='60' alt='menu_kouteikensa' border='0'/></a></td>
				<td style="padding: 0.1rem 0.2rem;"><a href='http://192.168.4.1/label/index.php'><img src='http://192.168.4.1/img/menu_label.gif' width='150' height='60' alt='menu_label' border='0'/></a></td>
				</tr>
              </table>
            </td>
          </tr>
        </table>
        		<?php echo $this->element('SubHeader');?>
            <?= $this->Flash->render() ?>
            <div class="container clearfix">
                <?= $this->fetch('content') ?>
            </div>
            <footer>
            </footer>
    </td>
  </tr>
</table>
</body>
</html>
