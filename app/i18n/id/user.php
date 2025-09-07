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
			'invalid' => 'Alamat surel ini tidak valid.',
			'required' => 'Alamat surel diperlukan.',
		),
		'validation' => array(
			'change_email' => 'Anda dapat mengubah alamat surel Anda <a href="%s">di halaman profil</a>.',
			'email_sent_to' => 'Kami sudah mengirimkan Anda surel ke <strong>%s</strong>. Ikuti petunjuk di surel untuk memvalidasi alamat surel Anda.',
			'feedback' => array(
				'email_failed' => 'Kami tidak dapat mengirimi Anda surel dikarenakan kesalahan konfigurasi di peladen. ',
				'email_sent' => 'Surel sudah dikirim ke surel Anda.',
				'error' => 'Validasi alamat surel Anda gagal.',
				'ok' => 'Alamat surel ini sudah divalidasi.',
				'unnecessary' => 'Alamat surel ini sudah divalidasi.',
				'wrong_token' => 'Alamat surel ini gagal divalidasi dikarenakan token yang salah.',
			),
			'need_to' => 'Anda perlu memvalidasi alamat surel Anda sebelum dapat menggunakan %s.',
			'resend_email' => 'Kirim ulang surel',
			'title' => 'Validasi alamat surel',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Anda baru saja mendaftar pada %s, tapi Anda masih perlu memvalidasi alamat surel Anda. Untuk itu, ikuti saja tautannya:',
			'title' => 'Anda perlu memvalidasi akun Anda',
			'welcome' => 'Selamat datang %s,',
		),
	),
	'password' => array(
		'invalid' => 'Kata sandi tidak valid.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Anda harus menyetujui Ketentuan Layanan untuk dapat mendaftar.',
		),
	),
	'username' => array(
		'invalid' => 'Nama pengguna ini tidak valid.',
		'taken' => 'Nama pengguna ini, %s, telah diambil.',
	),
);
