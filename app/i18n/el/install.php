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
	'action' => array(
		'finish' => 'Ολοκλήρωση εγκατάστασης',
		'fix_errors_before' => 'Διορθώστε όλα τα σφάλματα πριν συνεχίσετε στο επόμενο βήμα.',
		'keep_install' => 'Διατήρηση των προηγούμενων ρυθμίσεων',
		'next_step' => 'Μεταβείτε στο επόμενο βήμα',
		'reinstall' => 'Επανεγκατάσταση του FreshRSS',
	),
	'auth' => array(
		'form' => 'Web form (σύνηθες, απαιτεί JavaScript)',
		'http' => 'HTTP (για έμπειρους χρήστες με HTTPS)',
		'none' => 'Καμία (ριψοκίνδυνο)',
		'password_form' => 'Κωδικός Πρόσβασης<br /><small>(για την μέθοδο σύνδεσης με Web-form)</small>',
		'password_format' => 'Τουλάχιστον 7 χαρακτήρες',
		'type' => 'Μέθοδος Πιστοποίησης',
	),
	'bdd' => array(
		'_' => 'Βάση Δεδομένων',
		'conf' => array(
			'_' => 'Ρυθμίσεις Βάσης Δεδομένων',
			'ko' => 'Επιβεβαιώστε τις ρυθμίσεις της βάσης δεδομένων σας.',
			'ok' => 'Οι ρυθμίσεις της βάσης δεδομένων σας αποθηκεύτηκαν.',
		),
		'host' => 'Εξυπηρετητής',
		'password' => 'Κωδικός Πρόσβασης Βάσης Δεδομένων',
		'prefix' => 'Πρόθεμα Πίνακα',
		'type' => 'Τύπος Βάσης Δεδομένων',
		'username' => 'Όνομα Χρήστη Βάσης Δεδομένων',
	),
	'check' => array(
		'_' => 'Έλεγχοι',
		'already_installed' => 'Διαπιστώσαμε ότι το FreshRSS είναι ήδη εγκατεστημένο!',
		'cache' => array(
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>%1$s</em> για τον χρήστη <em>%2$s</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο προσωρινής μνήμης (cache) είναι εντάξει.',
		),
		'ctype' => array(
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για τον έλεγχο τύπου χαρακτήρων (php-ctype).',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για τον έλεγχο τύπου χαρακτήρων (ctype).',
		),
		'curl' => array(
			'nok' => 'Δεν βρέθηκε η βιβλιοθήκη cURL (php-curl package).',
			'ok' => 'Βρέθηκε η βιβλιοθήκη cURL.',
		),
		'data' => array(
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>%1$s</em> για τον χρήστη <em>%2$s</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο δεδομένων (data) είναι εντάξει.',
		),
		'dom' => array(
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για περιήγηση στο DOM.',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για περιήγηση στο DOM.',
		),
		'favicons' => array(
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>%1$s</em> για τον χρήστη <em>%2$s</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο δεδομένων (favicons) είναι εντάξει.',
		),
		'fileinfo' => array(
			'nok' => 'Δεν βρέθηκε η βιβλιοθήκη PHP fileinfo (fileinfo package).',
			'ok' => 'Βρέθηκε η βιβλιοθήκη fileinfo.',
		),
		'json' => array(
			'nok' => 'Δεν βρέθηκε η συνιστώμενη βιβλιοθήκη για ανάλυση JSON.',
			'ok' => 'Βρέθηκε η συνιστώμενη βιβλιοθήκη για ανάλυση JSON.',
		),
		'mbstring' => array(
			'nok' => 'Δεν βρέθηκε η συνιστώμενη βιβλιοθήκη mbstring για Unicode.',
			'ok' => 'Βρέθηκε η συνιστώμενη βιβλιοθήκη mbstring για Unicode.',
		),
		'pcre' => array(
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για regular expressions (php-pcre).',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για regular expressions (php-pcre).',
		),
		'pdo' => array(
			'nok' => 'Δεν βρέθηκε ο PDO ή ένας από τους υποστηριζόμενους οδηγούς (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Βρέθηκε ο PDO ή ένας από τους υποστηριζόμενους οδηγούς (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		),
		'php' => array(
			'nok' => 'Η έκδοση της PHP σας είναι %s, αλλά το FreshRSS απαιτεί τουλάχιστον έκδοση %s.',
			'ok' => 'Η έκδοση της PHP σας, %s, είναι συμβατή με το FreshRSS.',
		),
		'reload' => 'Ελέγξτε πάλι',
		'tmp' => array(
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>%1$s</em> για τον χρήστη <em>%2$s</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο προσωρινών αρχείων (temp) είναι εντάξει.',
		),
		'unknown_process_username' => 'άγνωστο',
		'users' => array(
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>%1$s</em> για τον χρήστη <em>%2$s</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο χρηστών (users) είναι εντάξει.',
		),
		'xml' => array(
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για ανάλυση XML.',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για ανάλυση XML.',
		),
	),
	'conf' => array(
		'_' => 'Γενικές Ρυθμίσεις',
		'ok' => 'Οι γενικές ρυθμίσεις αποθηκεύτηκαν.',
	),
	'congratulations' => 'Συγχαρητήρια!',
	'default_user' => array(
		'_' => 'Όνομα χρήστη για τον προεπιλεγμένο χρήστη',
		'max_char' => 'μέγιστο 16 αλφαριθμητικοί χαρακτήρες',
	),
	'fix_errors_before' => 'Παρακαλούμε διορθώστε τα σφάλματα πριν συνεχίσετε στο επόμενο βήμα.',
	'javascript_is_better' => 'Το FreshRSS είναι πιο ευχάριστο με ενεργοποιημένη την JavaScript',
	'js' => array(
		'confirm_reinstall' => 'Επανεγκαθιστώντας το FreshRSS, θα χάσετε τις προηγούμενες ρυθμίσεις σας. Είστε σίγουροι ότι επιθυμείτε να συνεχίσετε;',
	),
	'language' => array(
		'_' => 'Γλώσσα',
		'choose' => 'Επιλέξτε μια γλώσσα για το FreshRSS',
		'defined' => 'Η γλώσσα έχει ορισθεί.',
	),
	'missing_applied_migrations' => 'Κάτι πήγε στραβά. Θα πρέπει να δημιουργήσετε ένα κενό <em>%s</em> αρχείο, χειροκίνητα.',
	'ok' => 'Η διαδικασία εγκατάστασης ήταν επιτυχής.',
	'session' => array(
		'nok' => 'Ο διακομιστής ιστού φαίνεται να έχει ρυθμιστεί εσφαλμένα για τα cookies που απαιτούνται για τις PHP sessions!',
	),
	'step' => 'βήμα %d',
	'steps' => 'Βήματα',
	'this_is_the_end' => 'Αυτό είναι το τέλος',
	'title' => 'Εγκατάσταση · FreshRSS',
);
