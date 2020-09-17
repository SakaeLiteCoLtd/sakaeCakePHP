<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Staff[]|\Cake\Collection\CollectionInterface $staffs
 */
?>
<?php
  $username = $this->request->Session()->read('Auth.User.username');

  header('Expires:-1');
  header('Cache-Control:');
  header('Pragma:');
?>

  <br><br><br>
  <form method="post" action="torikomitest" enctype="multipart/form-data">
    <table align="center" border="2" bordercolor="#E6FFFF" cellpadding="0" cellspacing="0">
      <tbody border="2" bordercolor="#E6FFFF" bgcolor="#FFFFCC">
        <tr>
          <td colspan="20" style="border-bottom: solid;border-width: 1px" ><input name="file" type="file" size="80" /></td>
          <td colspan="20" style="border-bottom: solid;border-width: 1px"><input type="submit" name="submit" value="登録" /></td>
        </tr>
    </table>
  </form>
  <br><br><br>
