<?php /** @var Minz_View $this */ ?>
<?= _t('user.mailer.email_need_validation.welcome', $this->username) ?>

<?= _t('user.mailer.email_need_validation.body', $this->site_title) ?>

<?= $this->validation_url ?>
