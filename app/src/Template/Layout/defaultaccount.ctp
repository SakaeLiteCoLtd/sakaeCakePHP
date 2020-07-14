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
    $session = $this->request->getSession();
    $data = $session->read();
    if(isset($data['login']['staffname'])){
      $user = $data['login']['staffname'].'さん、こんにちは。';
    }else{
      $user = "ログインしてください。";
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
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#E6FFFF">
  <tr style="background-color: #E6FFFF">
    <td>
        <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="border-style: none; background-color: #E6FFFF">
            <td bgcolor="#E6FFFF">
              <div style="float:right">
                <body link="#ff0000" vlink="#ff0000" alink="#ff0000">
                <?php echo $user; ?>
              <?php
                if ($user == 'ログインしてください。') {
                    // ログインしているとき
                    // ログアウトへのリンクをだす
            //        echo $this->Html->link('　ログイン', array('controller'=>'accounts','action'=>'index'));
                } else {
                    // ログインしていないとき
                    // ログインへのリンクをだす
                    echo $this->Html->link('　ログアウト', array('controller'=>'accounts','action'=>'index','alink'=>'#E6FFFF'));
                }
              ?>
              </div>
            </body>
              <div align="left"><p><?php echo $this->Html->image('logo.gif',array('width'=>'157','height'=>'22'));?></p></div>
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
