<h1>Regist user</h1>
<?php
echo $this->Form->create();
echo $this->Form->control('email');
echo $this->Form->control('name');
echo $this->Form->control('password');
echo $this->Form->button(__('Đăng ký'));
echo $this->Form->end();
?>
<a href="<?= $this->Url->build('/user/login') ?>"><span>Đăng ký tài khoản</span></a>