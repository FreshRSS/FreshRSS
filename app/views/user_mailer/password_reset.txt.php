<?php
	declare(strict_types=1);
	/** @var FreshRSS_View $this */
?>
<?= _t('user.mailer.password_reset.welcome', $this->username) ?>

<?= _t('user.mailer.password_reset.body', $this->site_title) ?>

<?= $this->reset_url ?>

<?= _t('user.mailer.password_reset.expiry', $this->expiry_minutes) ?>

<?= _t('user.mailer.password_reset.ignore') ?>
<?php
