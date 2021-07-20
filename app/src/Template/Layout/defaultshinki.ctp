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
                    echo $this->Html->link('　ログアウト', array('controller'=>'Shinkies','action'=>'index','alink'=>'#E6FFFF'));
                }
              ?>
              </div>
            </body>
              <div align="left"><p><?php echo $this->Html->image('logo.gif',array('width'=>'157','height'=>'22'));?></p></div>
            </td>
          </tr>
        </table>

        <table style="margin-bottom:0px" width="750" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr style="border-style: none; background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_qr.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'user','action'=>'index')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_nouki.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Kadous','action'=>'kariindex')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href=<?php echo $this->Url->build(['controller'=>'Kadous', 'action'=>'index', 'taskId' => 77]); ?>"><?php echo $this->Html->image('HeaderMenu/menu_kadou.gif',array('width'=>'105','height'=>'36'));?></a></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_setubi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'SyukkaKensas','action'=>'indexhome')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href=<?php echo $this->Url->build(['controller'=>'KensahyouSokuteidatas', 'action'=>'index', 'taskId' => 77]); ?>"><?php echo $this->Html->image('HeaderMenu/menu_seipro.gif',array('width'=>'105','height'=>'36'));?></a></td>
            <td style="padding: 0.1rem 0.1rem;"><a href=<?php echo $this->Url->build(['controller'=>'KensahyouSokuteidatas', 'action'=>'index1', 'taskId' => 77]); ?>"><?php echo $this->Html->image('HeaderMenu/menu_setubi.gif',array('width'=>'105','height'=>'36'));?></a></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_material.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Genryous','action'=>'menu')));?></td>
          </tr>
          <tr style="padding: 0; border-style: none;background-color: #E6FFFF">
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_shinki.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Shinkies','action'=>'index')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_edi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'indexmenu')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_rejection.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Zensukensas','action'=>'indexmenu')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_denpyou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'orderEdis','action'=>'denpyouindex')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href=<?php echo $this->Url->build(['controller'=>'PriceMaterials', 'action'=>'confirmcsv', 'taskId' => 77]); ?>"><?php echo $this->Html->image('HeaderMenu/menu_csv.gif',array('width'=>'105','height'=>'36'));?></a></td>
            <td style="padding: 0.1rem 0.1rem;"><?php echo $this->Html->image('HeaderMenu/menu_kouteikensa.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Kouteis','action'=>'indexhome')));?></td>
            <td style="padding: 0.1rem 0.1rem;"><a href=<?php echo $this->Url->build(['controller'=>'Labels', 'action'=>'indexMenu', 'taskId' => 77]); ?>"><?php echo $this->Html->image('HeaderMenu/menu_label.gif',array('width'=>'105','height'=>'36'));?></a></td>
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
