<?php
/**
 * AuthHelper: Authの変数にアクセスできる
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
            $username = $this->request->getSession()->read('Auth.User.username');

	if($username == null){
	$user = 'logout now';
	} else {
	$user = 'login : '.$username ;
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

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#E6FFFF">
  <tr>
    <td>

        <table width="1500" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
          <tr>
            <td bgcolor="#E6FFFF">

              <div style="float:right"><?php echo $user; ?></div>

              <table style="margin-bottom:0px" width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC">
              <p style="padding-left: 350px;"><?php echo $this->Html->image('logo.gif',array('width'=>'157','height'=>'22'));?></p>
                        <tr>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_qr.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Customers','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_nouki.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'CustomersHandy','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_kadou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Delivers','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_setubi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Materials','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_seipro.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'MaterialTypes','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_material.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'PriceProducts','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_material.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'PriceProducts','action'=>'index')));?></td>
                        </tr>
                        <tr>
                          <td><a href=<?php echo $this->Url->build(['controller'=>'Shinkies', 'action'=>'index', 'taskId' => 77]); ?>"><?php echo $this->Html->image('HeaderMenu/menu_shinki.gif',array('width'=>'105','height'=>'36'));?></a></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_edi.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Products','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_rejection.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Staffs','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_denpyou.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Suppliers','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_csv.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'SupplierSections','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_kouteikensa.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Users','action'=>'index')));?></td>
                          <td><?php echo $this->Html->image('HeaderMenu/menu_label.gif',array('width'=>'105','height'=>'36','url'=>array('controller'=>'Users','action'=>'index')));?></td>
                        </tr>
              </table>
<hr size="5">
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
    </td> 
  </tr>
</table>
<?=$this->request->session()->read('Auth.User.name')?>
</body>
</html>

