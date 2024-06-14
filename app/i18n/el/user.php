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
			'invalid' => 'Αυτή η διεύθυνση email δεν είναι έγκυρη.',
			'required' => 'Απαιτείται μια διεύθυνση email.',
		),
		'validation' => array(
			'change_email' => 'Μπορείτε να αλλάξετε την διεύθυνση email σας <a href="%s">στην σελίδα προφίλ</a>.',
			'email_sent_to' => 'Σας στείλαμε ένα email στο <strong>%s</strong>. Παρακαλούμε ακολουθήστε τις οδηγίες του για να επιβεβαιώσετε την διεύθυνσή σας.',
			'feedback' => array(
				'email_failed' => 'Δεν μπορέσαμε να σας στειλουμε κάποιο email λόγω κάποιου σφάλματος στην παραμετροποίηση του διακομιστή.',
				'email_sent' => 'Έχει αποσταλεί ένα email στην διεύθυνσή σας.',
				'error' => 'Η επαλήθευση της διεύθυνσης email απέτυχε.',
				'ok' => 'Αυτή η διεύθυνση email έχει επιβεβαιωθεί.',
				'unnecessary' => 'Αυτή η διεύθυνση email είναι επιβεβαιωμένη.',
				'wrong_token' => 'Αυτή η διεύθυνση email απέτυχε να επιβεβαιωθεί λόγω εσφαλμένου διακριτικού πρόσβασης.',
			),
			'need_to' => 'Θα πρέπει να επιβεβαιώσετε την διεύθυνση email σας προτού μπορέσετε να χρησιμοποιήσετε το %s.',
			'resend_email' => 'Ξαναστείλτε το email',
			'title' => 'Επιβεβαίωση διεύθυνσης email',
		),
	),
	'mailer' => array(
		'email_need_validation' => array(
			'body' => 'Έχετε εγγραφεί στο %s, αλλά θα πρέπει να επιβεβαίωσετε την διεύθυνση email σας. Για να το πραγματοποιήσετε, απλώς ακολουθήστε τον σύνδεσμο:',
			'title' => 'Θα πρέπει να επιβεβαιώσετε τον λογαριασμό σας',
			'welcome' => 'Καλώς ήλθες %s,',
		),
	),
	'password' => array(
		'invalid' => 'Ο κωδικός πρόσβασης δεν είναι έγκυρος.',
	),
	'tos' => array(
		'feedback' => array(
			'invalid' => 'Θα πρέπει να αποδεχτείτε τους Όρους Χρήσης για να μπορέσετε να εγγραφείτε.',
		),
	),
	'username' => array(
		'invalid' => 'Αυτό το όνομα χρήστη δεν είναι έγκυρο.',
		'taken' => 'Αυτό το όνομα χρήστη, %s, χρησιμοποιείται ήδη.',
	),
);
