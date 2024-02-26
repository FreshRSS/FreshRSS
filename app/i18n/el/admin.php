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

return [
	'auth' => [
		'allow_anonymous' => 'Allow anonymous reading of the default user’s articles (%s)',	// TODO
		'allow_anonymous_refresh' => 'Allow anonymous refresh of the articles',	// TODO
		'api_enabled' => 'Allow <abbr>API</abbr> access <small>(required for mobile apps)</small>',	// TODO
		'form' => 'Web form (σύνηθες, απαιτεί JavaScript)',
		'http' => 'HTTP (για έμπειρους χρήστες με )',
		'none' => 'Καμία (ριψοκίνδυνο)',
		'title' => 'Πιστοποίηση',
		'token' => 'Master authentication token',	// TODO
		'token_help' => 'Allows access to all RSS outputs of the user as well as refreshing feeds without authentication:',	// TODO
		'type' => 'Μέθοδος Πιστοποίησης',
		'unsafe_autologin' => 'Επιτρέψτε την μη ασφαλή αυτόματη σύνδεση με την χρήση της μορφής: ',
	],
	'check_install' => [
		'cache' => [
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>./data/cache</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο προσωρινής μνήμης (cache) είναι εντάξει.',
		],
		'categories' => [
			'nok' => 'Ο πίνακας κατηγορίας (Category) δεν έχει ρυθμιστεί σωστά.',
			'ok' => 'Ο πίνακας κατηγορίας (Category) είναι εντάξει.',
		],
		'connection' => [
			'nok' => 'Δεν ήταν δυνατή η σύνδεση με την βάση δεδομένων.',
			'ok' => 'Η σύνδεση με την βάση δεδομένων είναι εντάξει.',
		],
		'ctype' => [
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για τον έλεγχο τύπου χαρακτήρων (php-ctype).',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για τον έλεγχο τύπου χαρακτήρων (ctype).',
		],
		'curl' => [
			'nok' => 'Δεν βρέθηκε η βιβλιοθήκη cURL (php-curl package).',
			'ok' => 'Βρέθηκε η βιβλιοθήκη cURL.',
		],
		'data' => [
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>./data</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο δεδομένων (data) είναι εντάξει.',
		],
		'database' => 'Εγκατάσταση βάσης δεδομένων',
		'dom' => [
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για περιήγηση στο DOM (php-xml package).',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για περιήγηση στο DOM.',
		],
		'entries' => [
			'nok' => 'Ο πίνακας καταχώρισης (Entry) δεν έχει ρυθμιστεί σωστά..',
			'ok' => 'Ο πίνακας καταχώρισης (Entry) είναι εντάξει.',
		],
		'favicons' => [
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>./data/favicons</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής.',
			'ok' => 'Τα δικαιώματα στον κατάλογο δεδομένων (favicons) είναι εντάξει.',
		],
		'feeds' => [
			'nok' => 'Ο πίνακας τροφοδοσίας (Feed) δεν έχει ρυθμιστεί σωστά..',
			'ok' => 'Ο πίνακας τροφοδοσίας (Feed) είναι εντάξει.',
		],
		'fileinfo' => [
			'nok' => 'Δεν βρέθηκε η βιβλιοθήκη PHP fileinfo (fileinfo package).',
			'ok' => 'Βρέθηκε η βιβλιοθήκη fileinfo.',
		],
		'files' => 'Εγκατάσταση αρχείων',
		'json' => [
			'nok' => 'Δεν βρέθηκε η επέκταση JSON (php-json package).',
			'ok' => 'Βρέθηκε η επέκταση JSON.',
		],
		'mbstring' => [
			'nok' => 'Δεν βρέθηκε η συνιστώμενη βιβλιοθήκη mbstring για Unicode.',
			'ok' => 'Βρέθηκε η συνιστώμενη βιβλιοθήκη mbstring για Unicode.',
		],
		'pcre' => [
			'nok' => 'Δεν βρέθηκε η απαιτούμενη βιβλιοθήκη για regular expressions (php-pcre).',
			'ok' => 'Βρέθηκε η απαιτούμενη βιβλιοθήκη για regular expressions (PCRE).',
		],
		'pdo' => [
			'nok' => 'Δεν βρέθηκε ο PDO ή ένας από τους υποστηριζόμενους οδηγούς (pdo_mysql, pdo_sqlite, pdo_pgsql).',
			'ok' => 'Βρέθηκε ο PDO ή ένας από τους υποστηριζόμενους οδηγούς (pdo_mysql, pdo_sqlite, pdo_pgsql).',
		],
		'php' => [
			'_' => 'Εγκατάσταση PHP',
			'nok' => 'Η έκδοση της PHP σας είναι %s, αλλά το FreshRSS απαιτεί τουλάχιστον έκδοση %s.',
			'ok' => 'Η έκδοση της PHP σας, %s, είναι συμβατή με το FreshRSS.',
		],
		'tables' => [
			'nok' => 'Λείπουν ένας ή περισσότεροι πίνακες από την βάση δεδομένων.',
			'ok' => 'Υπάρχουν οι κατάλληλοι φάκελοι στην βάση δεδομένων.',
		],
		'title' => 'Έλεγχος εγκατάστασης',
		'tokens' => [
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>./data/tokens</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής',
			'ok' => 'Τα δικαιώματα στον κατάλογο διακριτικών (tokens) είναι εντάξει.',
		],
		'users' => [
			'nok' => 'Ελέγξτε τα δικαιώματα στον κατάλογο <em>./data/users</em>. Ο διακομιστής HTTP πρέπει να έχει δικαίωμα εγγραφής',
			'ok' => 'Τα δικαιώματα στον κατάλογο χρηστών (users) είναι εντάξει.',
		],
		'zip' => [
			'nok' => 'Δεν βρέθηκε η επέκταση ZIP (php-zip package).',
			'ok' => 'Βρέθηκε η επέκταση ZIP .',
		],
	],
	'extensions' => [
		'author' => 'Συντάκτης',
		'community' => 'Διαθέσιμες επεκτάσεις κοινότητας',
		'description' => 'Περιγραφή',
		'disabled' => 'Απενεργοποιημένες',
		'empty_list' => 'Δεν υπάρχουν εγκατεστημένες επεκτάσεις',
		'enabled' => 'Ενεργοποιημένες',
		'latest' => 'Εγκατεστημένες',
		'name' => 'Όνομα',
		'no_configure_view' => 'Αυτή η επέκταση δεν μπορεί να ρυθμιστεί.',
		'system' => [
			'_' => 'Επεκτάσεις συστήματος',
			'no_rights' => 'Επέκταση συστήματος (δεν έχετε τα απαραίτητα δικαιώματα)',
		],
		'title' => 'Επεκτάσεις',
		'update' => 'Διαθέσιμη ενημέρωση',
		'user' => 'Επεκτάσεις χρήστη',
		'version' => 'Έκδοση',
	],
	'stats' => [
		'_' => 'Στατιστικά',
		'all_feeds' => 'Όλες οι τροφοδοσίες',
		'category' => 'Κατηγορία',
		'entry_count' => 'Αριθμός καταχωρίσεων',
		'entry_per_category' => 'Καταχωρίσεις ανά κατηγορία',
		'entry_per_day' => 'Καταχωρίσεις ανά ημέρα (τελευταίες 30 ημέρες)',
		'entry_per_day_of_week' => 'Ανά ημέρα της εβδομάδας (μέσος όρος: %.2f μηνύματα)',
		'entry_per_hour' => 'Ανά ώρα (μέσος όρος: %.2f μηνύματα)',
		'entry_per_month' => 'Ανά μήνα (μέσος όρος: %.2f μηνύματα)',
		'entry_repartition' => 'Entries repartition',	// TODO
		'feed' => 'Τροφοδοσία',
		'feed_per_category' => 'Τροφοδοσίες ανά κατηγορία',
		'idle' => 'Αδρανείς τροφοδοσίες',
		'main' => 'Κύρια στατισικά',
		'main_stream' => 'Κύρια ροή',
		'no_idle' => 'Δεν υπάρχουν αδρανείς τροφοδοσίες!',
		'number_entries' => '%d άρθρα',
		'percent_of_total' => '% εκ του συνόλου',
		'repartition' => 'Articles repartition',	// TODO
		'status_favorites' => 'Αγαπημένα',
		'status_read' => 'Ανάγνωση',
		'status_total' => 'Σύνολο',
		'status_unread' => 'Μη αναγνωσμένα',
		'title' => 'Στατιστικά',
		'top_feed' => 'Κορυφαίες δέκα τροφοδοσίες',
	],
	'system' => [
		'_' => 'Ρυθμίσεις συστήματος',
		'auto-update-url' => 'Αυτόματη ενημέρωση URL διακομιστή',
		'base-url' => [
			'_' => 'Base URL',	// TODO
			'recommendation' => 'Automatic recommendation: <kbd>%s</kbd>',	// TODO
		],
		'cookie-duration' => [
			'help' => 'σε δευτερόλεπτα',
			'number' => 'Διάρκεια παραμονής σε σύνδεση',
		],
		'force_email_validation' => 'Επιβολή επιβεβαίωσης διεύθυνσης email',
		'instance-name' => 'Instance name',	// TODO
		'max-categories' => 'Μέγιστος αριθμός κατηγοριών ανά χρήστη',
		'max-feeds' => 'Μέγιστος αριθμός τροφοδοσιών ανά χρήστη',
		'registration' => [
			'number' => 'Μέγιστος αριθμός λογαριασμών',
			'select' => [
				'label' => 'Φόρμα εγγραφής',
				'option' => [
					'noform' => 'Απενεργοποιημένη: Χωρίς φόρμα εγγραφής',
					'nolimit' => 'Ενεργοποιημένη: Χωρίς όριο λογαριασμών',
					'setaccountsnumber' => 'Ορίστε μέγιστο αριθμό λογαριασμών',
				],
			],
			'status' => [
				'disabled' => 'Η φόρμα είναι απενεργοποιημένη',
				'enabled' => 'Η φόρμα είναι ενεργοποιημένη',
			],
			'title' => 'Φόρμα εγγραφής χρήστη',
		],
		'sensitive-parameter' => 'Sensitive parameter. Edit manually in <kbd>./data/config.php</kbd>',	// TODO
		'tos' => [
			'disabled' => 'is not given',	// TODO
			'enabled' => '<a href="./?a=tos">is enabled</a>',	// TODO
			'help' => 'How to <a href="https://freshrss.github.io/FreshRSS/en/admins/12_User_management.html#enable-terms-of-service-tos" target="_blank">enable the Terms of Service</a>',	// TODO
		],
		'websub' => [
			'help' => 'About <a href="https://freshrss.github.io/FreshRSS/en/users/WebSub.html" target="_blank">WebSub</a>',	// TODO
		],
	],
	'update' => [
		'_' => 'Ενημέρωση συστήματος',
		'apply' => 'Εφαρμογή',
		'changelog' => 'Changelog',	// TODO
		'check' => 'Έλεγχος για νέες ενημερώσεις',
		'copiedFromURL' => 'update.php copied from %s to ./data',	// TODO
		'current_version' => 'Η τρέχουσα έκδοση του',
		'last' => 'Τελευταία επαλήθευση',
		'loading' => 'Updating…',	// TODO
		'none' => 'Δεν υπάρχουν ενημερώσεις',
		'releaseChannel' => [
			'_' => 'Release channel',	// TODO
			'edge' => 'Rolling release (“edge”)',	// TODO
			'latest' => 'Stable release (“latest”)',	// TODO
		],
		'title' => 'Ενημέρωση συστήματος',
		'viaGit' => 'Update via git and Github.com started',	// TODO
	],
	'user' => [
		'admin' => 'Διαχειριστής',
		'article_count' => 'Άρθρα',
		'back_to_manage' => '← Επιστροφή στην λίστα χρηστών',
		'create' => 'Δημιουργια νέου χρήστη',
		'database_size' => 'Μέγεθος βάσης δεδομένων',
		'email' => 'Διεύθυνση email',
		'enabled' => 'Ενεργοποιημένο',
		'feed_count' => 'Τροφοδοσίες',
		'is_admin' => 'Είναι διαχειριστής',
		'language' => 'Γλώσσα',
		'last_user_activity' => 'Τελευταία δραστηριότητα χρήστη',
		'list' => 'Λίστα χρηστών',
		'number' => 'Δημιουργήθηκε %d λογαριασμός',
		'numbers' => 'Δημιουργήθηκαν %d λογαριασμοί',
		'password_form' => 'Κωδικός πρόσβασης<br /><small>(για την μέθοδο σύνδεσης με Web-form)</small>',
		'password_format' => 'Τουλάχιστον 7 χαρακτήρες',
		'title' => 'Διαχείριση χρηστών',
		'username' => 'Όνομα χρήστη',
	],
];
