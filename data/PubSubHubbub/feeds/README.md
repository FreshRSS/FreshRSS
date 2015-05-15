List of canonical URLS of the various feeds users have subscribed to.
Several feeds can share the same canonical URL (rel="self").
Several users can have subscribed to the same feed.

* ./base64url(canonicalUrl)/
	* ./secret.txt
	* ./base64url(feedUrl1)/
		* ./user1.txt
		* ./user2.txt
	* ./base64url(feedUrl2)/
		* ./user3.txt
		* ./user4.txt
