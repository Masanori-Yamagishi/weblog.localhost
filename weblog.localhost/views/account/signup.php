<?php $this->setPageTitle('title', 'アカウントを作成') ?>
<h2>ユーザーアカウントを作成</h2>
<form action="<?php print $base_url; ?>/account/register"
      method="post">
	<input type="hidden"
         name="_token"
	       value="<?php print $this->escape($_token); ?>" />

  <?php if (isset($errors) && count($errors) > 0): ?>
  <?php print $this->render('errors', array('errors' => $errors)); ?>
  <?php endif; ?>

  <?php print $this->render('account/inputs', array(
    'user_name' => $user_name, 'password' => $password,)); ?>
	<p><input type="submit"
            value="登録" /></p>
</form>