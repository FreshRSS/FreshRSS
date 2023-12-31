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
			'invalid' => 'Bu email adresi geçersiz.',
			'required' => 'Bir email adresi gerekmektedir.',
		),
		'validation' => array(
			'change_email' => '<a href="%s">Profil sayfasından</a> email adresinizi değiştirebilirsiniz.',
			'email_sent_to' => '<strong>%s</strong> adresine doğrulama postası gönderdik. Lütfen yönergelere uyarak email adresinizi doğrulayın.',
			'feedback' => array(
				'email_failed' => 'Sunucu hatasından dolayı email adresinize posta gönderilemedi.',
				'email_sent' => 'Email adresinize posta gönderildi.',
				'error' => 'Email adresi doğrulaması başarısız.',
				'ok' => 'Bu email adresi doğrulandı.',
				'unnecessary' => 'Bu email adresi zaten doğrulandı.',
				'wrong_token' => 'Email doğrulaması yanlış anahtar sebebi ile başarısız oldu.',
			),
			'need_to' => '%s kullanımından önce email doğrulaması yapmalısınız.',
			'resend_email' => 'Emaili yeniden gönder',
			'title' => 'Email adres doğrulaması',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => '%s kaydınız yapıldı, fakat email dğrulaması yapmanız gerekmektedir. Aşağıdaki bağlantıyı takip edin:',
			'title' => 'Hesabınızı doğrulamanız gerekmektedir',
			'welcome' => 'Hoşgeldin %s,',
		),
	),
	'password' => array(
		'invalid' => 'Parola geçersiz.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Kayıt için Hizmet Kullanım Koşullarını kabul etmek durumundasınız.',
		),
	),
	'username' => array(
		'invalid' => 'Kullanıcı adı geçersiz.',
		'taken' => 'Kullanıcı adı %s alınmış.',
	),
);
