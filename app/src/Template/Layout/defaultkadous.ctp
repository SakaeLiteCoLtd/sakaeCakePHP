<?php
$cakeDescription = 'CakePHP: the rapid development php framework';
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
                  <legend align="center"><font color="red"><?= __("グラフを呼び出しています") ?></font></legend>
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
