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
        <br>
         <div align="center"><font color="red" size="2"><?= __($mess) ?></font></div>
         <br>
