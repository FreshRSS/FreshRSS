<?= _t('user.mailer.email_need_validation.welcome', $this->username) /** @phpstan-ignore-line */ ?>

<?= _t('user.mailer.email_need_validation.body', $this->site_title) /** @phpstan-ignore-line */ ?>

<?= $this->validation_url /** @phpstan-ignore-line */ ?>
