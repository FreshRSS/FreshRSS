<?php
return array(
    'hoarderIntegration' => array(
        'configure' => array(
            'api_key' => 'API Key',
            'api_key_description' => '<ul class="listedNumbers">
                <li>Go to your Hoarder instance and navigate to \'<c><your_hoarder_instance>/settings/api-keys</c>\'</li>
                <li>Create a new API key</li>
                <li>Enter your Hoarder instance API key and IP, then click \'Submit\'</li>
            </ul>
            <span>For more details, visit <a href="todo" target="_blank">todo</a>!',
            'instance_url' => 'Provide the URL of your Hoarder server (e.g., https://hoarder.example.com). TODO!',
            'ip_addr' => 'Enter the IP address from which the Hoarder server can be accessed. (e.g, http://ip:port)',
            'keyboard_shortcut' => 'Specify a single character to be used as a keyboard shortcut for quick access to this integration.',
        ),
        'notifications' => array(
            'added_bookmark' => 'Successfully added <i>\'%s\'</i> to Hoarder!',
            'failed_to_add_bookmark' => 'Adding article to Hoarder failed! Hoarder API error code: %s',
            'ajax_request_failed' => 'Ajax request failed!',
            'article_not_found' => 'Can\'t find article!',
        )
    ),
);
