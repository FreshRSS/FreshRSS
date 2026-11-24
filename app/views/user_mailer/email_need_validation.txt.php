<?php
	declare(strict_types=1);
	/** @var View $this */

use FreshRss\Models\View;

?>
<?= _t('user.mailer.email_need_validation.welcome', $this->username) ?>

<?= _t('user.mailer.email_need_validation.body', $this->site_title) ?>

<?= $this->validation_url ?>
<?php
