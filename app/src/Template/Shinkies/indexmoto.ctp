<table style="margin-bottom:0px" width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#E6FFFF">
<tr>
<?php $i = 0; ?>
<?php foreach ($imgSubObj as $key => $val): ?>
          <?php if($i == 6){echo "</tr>\n<tr>\n";} ?>
          <td align="center"><a href="<?= $val ?>"><img src="/img/<?= $key ?>" width="120" height="36" alt="<?= $val ?>"></a></td>
      <?php $i++; ?>
<?php endforeach; ?>
</tr>
</table>
<br>
