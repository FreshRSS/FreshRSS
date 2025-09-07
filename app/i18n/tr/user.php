<?php

/******************************************************************************/
/* Each entry of that file can be associated with a comment to indicate its   */
/* state. When there is no comment, it means the entry is fully translated.   */
/* The recognized comments are (comment matching is case-insensitive):        */
/*   + TODO: the entry has never been translated.                             */
/*   + DIRTY: the entry has been translated but needs to be updated.          */
/*   + IGNORE: the entry does not need to be translated.                      */
/* When a comment is not recognized, it is discarded.                         */
/******************************************************************************/

return array(
	'email' => array(
		'feedback' => array(
			'invalid' => 'Bu e-posta adresi geçersiz.',
			'required' => 'Bir e-posta adresi gerekli.',
		),
		'validation' => array(
			'change_email' => 'E-posta adresinizi <a href="%s">profil sayfasından</a> değiştirebilirsiniz.',
			'email_sent_to' => 'Size <strong>%s</strong> adresine bir e-posta gönderdik. Lütfen adresinizi doğrulamak için talimatları takip edin.',
			'feedback' => array(
				'email_failed' => 'Sunucu yapılandırma hatası nedeniyle size e-posta gönderemedik.',
				'email_sent' => 'E-posta adresinize bir mesaj gönderildi.',
				'error' => 'E-posta adresi doğrulama başarısız oldu.',
				'ok' => 'Bu e-posta adresi doğrulandı.',
				'unnecessary' => 'Bu e-posta adresi zaten doğrulanmıştı.',
				'wrong_token' => 'Yanlış bir token nedeniyle bu e-posta adresi doğrulanamadı.',
			),
			'need_to' => '%s kullanabilmek için önce e-posta adresinizi doğrulamanız gerekiyor.',
			'resend_email' => 'E-postayı yeniden gönder',
			'title' => 'E-posta adresi doğrulama',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '%s sitesine yeni kaydoldunuz, ancak e-posta adresinizi hâlâ doğrulamanız gerekiyor. Bunun için şu bağlantıyı takip etmeniz yeterli:',
			'title' => 'Hesabınızı doğrulamanız gerekiyor',
			'welcome' => 'Hoş geldiniz %s,',
		),
	),
	'password' => array(
		'invalid' => 'Parola geçersiz.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Kayıt olabilmek için Hizmet Şartları’nı kabul etmeniz gerekiyor.',
		),
	),
	'username' => array(
		'invalid' => 'Bu kullanıcı adı geçersiz.',
		'taken' => 'Bu kullanıcı adı, %s, zaten alınmış.',
	),
);
