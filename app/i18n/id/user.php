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
			'invalid' => 'Alamat email ini tidak valid.',
			'required' => 'Diperlukan alamat email.',
		),
		'validation' => array(
			'change_email' => 'Anda dapat mengubah alamat email Anda <a href="%s">di halaman profil</a>.',
			'email_sent_to' => 'Kami mengirimi Anda email di <strong>%s</strong>. Harap ikuti instruksinya untuk memvalidasi alamat Anda.',
			'feedback' => array(
				'email_failed' => 'Kami tidak dapat mengirimi Anda email karena kesalahan konfigurasi server. ',
				'email_sent' => 'Email telah dikirim ke alamat Anda.',
				'error' => 'Validasi alamat email gagal.',
				'ok' => 'Alamat email ini telah divalidasi.',
				'unnecessary' => 'Alamat email ini sudah divalidasi.',
				'wrong_token' => 'Alamat email ini gagal divalidasi karena token yang salah.',
			),
			'need_to' => 'Anda perlu memvalidasi alamat email Anda sebelum dapat menggunakan %s.',
			'resend_email' => 'Kirim ulang email',
			'title' => 'Validasi Alamat Email',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Anda baru saja mendaftar %s,Tetapi Anda masih perlu memvalidasi alamat email Anda.Untuk itu, ikuti saja tautannya:',
			'title' => 'Anda perlu memvalidasi akun Anda',
			'welcome' => 'Welcome %s,',	// IGNORE
		),
	),
	'password' => array(
		'invalid' => 'Kata sandi tidak valid.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Anda harus menerima ketentuan layanan untuk dapat mendaftar.',
		),
	),
	'username' => array(
		'invalid' => 'Nama pengguna ini tidak valid.',
		'taken' => 'Nama pengguna ini, %s, telah diambil.',
	),
);
