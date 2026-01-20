<?php

/******************************************************************************
 * Each entry of that file can be associated with a comment to indicate its   *
 * state. When there is no comment, it means the entry is fully translated.   *
 * The recognized comments are (comment matching is case-insensitive):        *
 *   + TODO: the entry has never been translated.                             *
 *   + DIRTY: the entry has been translated but needs to be updated.          *
 *   + IGNORE: the entry does not need to be translated.                      *
 * When a comment is not recognized, it is discarded.                         *
 ******************************************************************************/

return array(
	'action' => array(
		'actualize' => 'Ενημέρωση πηγών',
		'add' => 'Προσθήκη',
		'back_to_rss_feeds' => '← Επιστροφή στις πηγές',
		'cancel' => 'Ακύρωση',
		'close' => 'Κλείσιμο',
		'create' => 'Δημιουργία',
		'delete_all_feeds' => 'Διαγραφή όλων των πηγών',
		'delete_errored_feeds' => 'Διαγραφή προβληματικών πηγών',
		'delete_muted_feeds' => 'Διαγραφή πηγών σε σίγαση',
		'demote' => 'Υποβάθμιση',
		'disable' => 'Απενεργοποίηση',
		'download' => 'Κατέβασμα',
		'empty' => 'Άδειασμα',
		'enable' => 'Ενεργοποίηση',
		'export' => 'Εξαγωγή',
		'filter' => 'Φιλτράρισμα',
		'import' => 'Εισαγωγή',
		'load_default_shortcuts' => 'Φόρτωση εργοστασιακών συντομεύσεων',
		'manage' => 'Διαχείριση',
		'mark_read' => 'Σήμανση ως αναγνωσμένο',
		'menu' => array(
			'open' => 'Άνοιγμα επιλογών',
		),
		'nav_buttons' => array(
			'next' => 'Επόμενο άρθρο',
			'prev' => 'Προηγούμενο άρθρο',
			'up' => 'Πήγαινε στην κορυφή',
		),
		'open_url' => 'Άνοιγμα συνδέσμου',
		'promote' => 'Προαγωγή',
		'purge' => 'Άδειασμα',
		'refresh_opml' => 'Φρεσκάρισμα OPML',
		'remove' => 'Αφαίρεση',
		'rename' => 'Μετονομασία',
		'see_website' => 'Προβολή ιστοσελίδας',
		'submit' => 'Καταχώρηση',
		'truncate' => 'Διαγραφή όλων των άρθρων',
		'update' => 'Ενημέρωση',
	),
	'auth' => array(
		'accept_tos' => 'Αποδέχομαι τους <a href="%s">Όρους και Συνθήκες</a>.',
		'email' => 'Διεύθυνση αλληλογραφίας',
		'keep_logged_in' => 'Κράτα με συνδεδεμένο για <small>(%s ημέρες)</small>',
		'login' => 'Σύνδεση',
		'logout' => 'Αποσύνδεση',
		'password' => array(
			'_' => 'Κωδικός',
			'format' => '<small>Τουλάχιστον 7 χαρακτήρες</small>',
		),
		'reauth' => array(
			'header' => 'Απαιτείται επανασύνδεση',
			'tip' => 'Δεν θα ζητηθεί επανασύνδεση για <u>%d λεπτά</u>',
			'title' => 'Επανασύνδεση',
		),
		'registration' => array(
			'_' => 'Νέος λογαριασμός',
			'ask' => 'Δημιουργία λογαριασμού;',
			'title' => 'Δημιουργία λογαριασμού',
		),
		'username' => array(
			'_' => 'Όνομα Χρήστη',
			'format' => '<small>Το μέγιστο είναι 16 αλφαριθμητικοί χαρακτήρες</small>',
		),
	),
	'date' => array(
		'Apr' => '\\Α\\π\\ρ\\ί\\λ\\ι\\ο\\ς',
		'Aug' => '\\Α\\ύ\\γ\\ο\\υ\\σ\\τ\\ο\\ς',
		'Dec' => '\\Δ\\ε\\κ\\έ\\μ\\β\\ρ\\ι\\ο\\ς',
		'Feb' => '\\Φ\\ε\\β\\ρ\\ο\\υ\\ά\\ρ\\ι\\ο\\ς',
		'Jan' => '\\Ι\\α\\ν\\ο\\υ\\ά\\ρ\\ι\\ο\\ς',
		'Jul' => '\\Ι\\ο\\ύ\\λ\\ι\\ο\\ς',
		'Jun' => '\\Ι\\ο\\ύ\\ν\\ι\\ο\\ς',
		'Mar' => '\\Μ\\ά\\ρ\\τ\\ι\\ο\\ς',
		'May' => '\\Μ\\ά\\ϊ\\ο\\ς',
		'Nov' => '\\Ν\\ο\\έ\\μ\\β\\ρ\\ι\\ο\\ς',
		'Oct' => '\\Ο\\κ\\τ\\ώ\\β\\ρ\\ι\\ο\\ς',
		'Sep' => '\\Σ\\ε\\π\\τ\\έ\\μ\\β\\ρ\\ι\\ο\\ς',
		'apr' => 'Απρ.',
		'april' => 'Απρίλιος',
		'aug' => 'Αυγ.',
		'august' => 'Αύγουστος',
		'before_yesterday' => 'Πρίν απο εχθές',
		'dec' => 'Δεκ.',
		'december' => 'Δεκέμβριος',
		'feb' => 'Φεβ.',
		'february' => 'Φεβρουάριος',
		'format_date' => 'j %s Ε',
		'format_date_hour' => 'j %s Ε \\a\\t Ω\\:i',
		'fri' => 'Παρ',
		'jan' => 'Ιαν.',
		'january' => 'Ιανουάριος',
		'jul' => 'Ιουλ',
		'july' => 'Ιούνιος',
		'jun' => 'Ιουν',
		'june' => 'Ιούνιος',
		'last_2_year' => 'Τελευταία δύο έτη',
		'last_3_month' => 'Τελευταίοι τρείς μήνες',
		'last_3_year' => 'Τελευταία τρία έτη',
		'last_5_year' => 'Τελευταία πέντε έτη',
		'last_6_month' => 'Τελευταίοι έξι μήνες',
		'last_month' => 'Τελευταίος μήνας',
		'last_week' => 'Τελευταία εβδομάδα',
		'last_year' => 'Τελευταίο έτος',
		'mar' => 'Μαρ.',
		'march' => 'Μάρτιος',
		'may' => 'Μαϊ',
		'may_' => 'Μάϊος',
		'mon' => 'Δευ',
		'month' => 'μήνες',
		'nov' => 'Νοβ.',
		'november' => 'Νοέμβριος',
		'oct' => 'Οκτ.',
		'october' => 'Οκτώβριος',
		'sat' => 'Σαβ',
		'sep' => 'Σεπτ.',
		'september' => 'Σεπτέμβριος',
		'sun' => 'Κυρ',
		'thu' => 'Πέμ',
		'today' => 'Σήμερα',
		'tue' => 'Τρι',
		'wed' => 'Τετ',
		'yesterday' => 'Εχθές',
	),
	'dir' => 'ltr',	// IGNORE
	'freshrss' => array(
		'_' => 'FreshRSS',	// IGNORE
		'about' => 'Σχετικά με το FreshRSS',
	),
	'js' => array(
		'category_empty' => 'Άδειασμα κατηγορίας',
		'confirm_action' => 'Είστε σίγουροι για την ενέργεια; Είναι μη αναστρέψιμη!',
		'confirm_action_feed_cat' => 'Είστε σίγουροι για την ενέργεια; Θα χάσετε τα αγαπημένα σας και τις ροές που έχετε δημιουργήσει. Είναι μη αναστρέψιμη!',
		'confirm_exit_slider' => 'Είστε σίγουροι οτι δεν θέλετε να αποθηκεύσετε τις τρέχουσες αλλαγές σας;',
		'feedback' => array(
			'body_new_articles' => 'Υπάρχουν %%d νέα άρθρα να διαβάσετε στο FreshRSS.',
			'body_unread_articles' => '(αδιάβαστα: %%d)',
			'request_failed' => 'Η αναζήτηση απέτυχε, ελέγξτε για πιθανά προβλήματα με την σύνδεση σας.',
			'title_new_articles' => 'FreshRSS: Νέα άρθρα!',
		),
		'labels_empty' => 'Χωρίς ετικέτα',
		'new_article' => 'Υπάρχουν νέα άρθρα διαθέσιμα, πατήστε για ανανέωση της σελίδας.',
		'should_be_activated' => 'Το JavaScript πρέπει να ενεργοποιηθεί',
		'unsafe_csp_header' => 'Η επικεφαλίδα CSP που χρησιμοποιείται δεν είναι ασφαλής και το FreshRSS μπορεί να είναι ανασφαλές απέναντι σε επιθέσεις XSS. <a target="_blank" href="https://freshrss.github.io/FreshRSS/en/admins/10_ServerConfig.html#security">Δείτε τις οδηγίες χρήσης</a>',
	),
	'lang' => array(
		'cs' => 'Čeština',	// IGNORE
		'de' => 'Deutsch',	// IGNORE
		'el' => 'Ελληνικά',	// IGNORE
		'en' => 'English',	// IGNORE
		'en-US' => 'English (United States)',	// IGNORE
		'es' => 'Español',	// IGNORE
		'fa' => 'فارسی',	// IGNORE
		'fi' => 'Suomi',	// IGNORE
		'fr' => 'Français',	// IGNORE
		'he' => 'עברית',	// IGNORE
		'hu' => 'Magyar',	// IGNORE
		'id' => 'Bahasa Indonesia',	// IGNORE
		'it' => 'Italiano',	// IGNORE
		'ja' => '日本語',	// IGNORE
		'ko' => '한국어',	// IGNORE
		'lv' => 'Latviešu',	// IGNORE
		'nl' => 'Nederlands',	// IGNORE
		'oc' => 'Occitan',	// IGNORE
		'pl' => 'Polski',	// IGNORE
		'pt-BR' => 'Português (Brasil)',	// IGNORE
		'pt-PT' => 'Português (Portugal)',	// IGNORE
		'ru' => 'Русский',	// IGNORE
		'sk' => 'Slovenčina',	// IGNORE
		'tr' => 'Türkçe',	// IGNORE
		'uk' => 'Українська',	// IGNORE
		'zh-CN' => '简体中文',	// IGNORE
		'zh-TW' => '正體中文',	// IGNORE
	),
	'menu' => array(
		'about' => 'Σχετικά',
		'account' => 'Λογαριασμός',
		'admin' => 'Διαχείριση',
		'advanced_search' => 'Σύνθετη αναζήτηση',
		'archiving' => 'Αποθήκευση',
		'authentication' => 'Διαπίστευση',
		'check_install' => 'Έλγχος εγκατάστσσης',
		'configuration' => 'Παραμετροπίηση',
		'display' => 'Εμφάνιση',
		'extensions' => 'Πρόσθετα',
		'logs' => 'Αρχείο καταγραφής',
		'privacy' => 'Ιδιωτικότητα',
		'queries' => 'Ενέργειες χρήστη',
		'reading' => 'Διάβασμα',
		'search' => 'Αναζήτηση λέξης ή #ετικέτας',
		'search_help' => 'Δείτε τις οδηγίες για σύνθετες <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">παραμέτρους αναζήτησης</a>',
		'sharing' => 'Διαμοιρασμός',
		'shortcuts' => 'Συντομεύσεις',
		'stats' => 'Στατιστικά',
		'system' => 'Διαχείριση συστήματος',
		'update' => 'Αναβάθμιση',
		'user_management' => 'Διαχείριση χρηστών',
		'user_profile' => 'Το προφίλ μου',
	),
	'period' => array(
		'days' => 'ημέρες',
		'hours' => 'ώρες',
		'months' => 'μήνες',
		'weeks' => 'εβδομάδες',
		'years' => 'χρόνια',
	),
	'readme' => array(
		'contribute' => 'contribute',	// IGNORE
		'language' => 'Language',	// IGNORE
		'translated' => 'Progress',	// IGNORE
	),
	'search' => array(
		'advanced_search_help' => 'Αυτή η φόρμα βοηθάει να δημιουργήσετε ενέργειες αυτόματα, αλλά οι χειροκίνητες ενέργειες είναι πολύ πιο ισχυρές.',
		'authors' => 'Συγγραφέας',
		'categories' => 'Κατηγορίες',
		'content' => 'Περιεχόμενο',
		'date_from' => 'Από',
		'date_past' => 'Στο παρελθόν',
		'date_published' => 'Ημερομηνία έκδοσης',
		'date_range' => 'Διάστημα ημερομηνίας',
		'date_received' => 'Ημερομηνία λήψης',
		'date_to' => 'Εως',
		'date_user' => 'Ημερομηνία παραμετροποίησης χρήστη',
		'feeds' => 'Πηγές',
		'free_text' => 'Ελεύθερο κείμενο',
		'free_text_help' => 'Αναζήτηση στον τίτλο και το περιεχόμενο',
		'full_documentation' => 'Δείτε τις <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#with-the-search-field" target="_blank">πλήρεις οδηγίες χρήσης</a>',
		'labels' => 'Οι ετικέτες μου',
		'multiple_help' => 'Επιλογή μιας ή πολλών επιλογών (κρατήστε το <kbd>Ctrl</kbd> ή το <kbd>Cmd</kbd>)',
		'sources' => 'Πηγές',
		'tags' => 'Ετικέτες άρθρου',
		'text' => 'Αναζήτηση κειμένου',
		'text_help' => 'Πολλαπλές γραμμές συνδυάζονται με το <i>or</i>. Επίσης υποστηρίζονται τα <a href="https://freshrss.github.io/FreshRSS/en/users/10_filter.html#regex" target="_blank">regular expressions</a>.',
		'text_placeholder' => 'Κείμενο',
		'title' => 'Τίτλος',
		'url' => 'Σύνδεσμος',
		'user_queries' => 'Ενέργειες χρήστη',
	),
	'share' => array(
		'Known' => 'Γνωστές ιστοσελίδες',
		'archiveIS' => 'archive.is',	// IGNORE
		'archiveORG' => 'archive.org',	// IGNORE
		'archivePH' => 'archive.ph',	// IGNORE
		'bluesky' => 'Bluesky',	// IGNORE
		'buffer' => 'Buffer',	// IGNORE
		'clipboard' => 'Σημειωματάριο',
		'diaspora' => 'Διασπορά*',
		'email' => 'Διεύθυνση αλληλογραφίας',
		'email-webmail-firefox-fix' => 'Διεύθυνση αλληλογραφίας (webmail - διόρθωση για τον Firefox)',
		'facebook' => 'Facebook',	// IGNORE
		'gnusocial' => 'GNU social',	// IGNORE
		'jdh' => 'Journal du hacker',	// IGNORE
		'lemmy' => 'Lemmy',	// IGNORE
		'linkding' => 'Linkding',	// IGNORE
		'linkedin' => 'LinkedIn',	// IGNORE
		'mastodon' => 'Mastodon',	// IGNORE
		'movim' => 'Movim',	// IGNORE
		'omnivore' => 'Omnivore',	// IGNORE
		'pinboard' => 'Pinboard',	// IGNORE
		'pinterest' => 'Pinterest',	// IGNORE
		'print' => 'Εκτύπωση',
		'raindrop' => 'Raindrop.io',	// IGNORE
		'reddit' => 'Reddit',	// IGNORE
		'shaarli' => 'Shaarli',	// IGNORE
		'telegram' => 'Telegram',	// IGNORE
		'twitter' => 'Twitter',	// IGNORE
		'wallabag' => 'wallabag v1',	// IGNORE
		'wallabagv2' => 'wallabag v2',	// IGNORE
		'web-sharing-api' => 'Διαμοιρασμός συστήματος',
		'whatsapp' => 'Whatsapp',	// IGNORE
		'xing' => 'Xing',	// IGNORE
	),
	'short' => array(
		'attention' => 'Προσοχή!',
		'blank_to_disable' => 'Αφήστε το κενό για απενεργοποίηση',
		'by_author' => 'Από:',
		'by_default' => 'Ώς προεπιλεγμένο',
		'damn' => 'Ούπς!',
		'default_category' => 'Μη κατηγοριοποιημένα',
		'no' => 'Όχι',
		'not_applicable' => 'Δεν διατίθεται',
		'ok' => 'Εντάξει!',
		'or' => 'ή',
		'yes' => 'Ναι',
	),
	'stream' => array(
		'load_more' => 'Φόρτωση περισσοτέρων άρθρων',
		'mark_all_read' => 'Επισήμανση όλων ως αναγνωσμένα',
		'nothing_to_load' => 'Δεν υπάρχουν άλλα άρθρα',
	),
);
