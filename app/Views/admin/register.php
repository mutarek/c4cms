<?php $this->extend('admin/static/base'); 
$session = \Config\Services::session();
?>


<?php $this->section('content'); ?>
<div>
<?= form_open(); ?>
<div class="imgcontainer">
    <img src="<?= base_url(); ?>/public/assets/logo.png" alt="Avatar" height="100px" width="100px">
  </div>

  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" value="<?= set_value('uname'); ?>">
    <span class="danger"><?= display_error($validators,'uname'); ?></span>
    <br>

    <label for="psw"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" value="<?= set_value('email'); ?>" >
    <span class="danger"><?= display_error($validators,'email'); ?></span>
    <br>

    <label for="psw"><b>Password</b></label>
    <input type="text" placeholder="Enter Password" name="psw" value="<?= set_value('psw'); ?>" >
    <span class="danger"><?= display_error($validators,'psw'); ?></span>
    <br>

    <label for="psw"><b>Mobile</b></label>
    <input type="text" placeholder="Enter Mobile" name="number" value="<?= set_value('number'); ?>" >
    <span class="danger"><?= display_error($validators,'number'); ?></span>
    <br>

    <button type="submit">Create Account</button>
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn">Cancel</button>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
<?= form_close(); ?>
</div>
<?php if($session->getTempData('smsg')): ?>
<h1><?= $session->getTempdata('smsg'); ?></h1>
  <?php endif; ?>


<?php $this->endSection(); ?>