<?php $this->extend('admin/static/base'); ?>


<?php $this->section('content'); ?>

<h1>Activation Process</h1>
<?php if(isset($errors)):?>
<div>
<h1><?=$errors; ?></h1>
</div>
<?php endif; ?>



<?php $this->endSection(); ?>