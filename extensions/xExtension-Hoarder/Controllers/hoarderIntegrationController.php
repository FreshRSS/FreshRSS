<?php

declare(strict_types=1);

class FreshExtension_hoarderIntegration_Controller extends Minz_ActionController
{
    public function jsVarsAction(): void
    {
        $config = FreshRSS_Context::$user_conf->HoarderIntegration ?? [];
        
        $this->view->hoarder_Integration_vars = json_encode([
            'api_key' => $config['api_key'] ?? '',
            'ip_address' => $config['ip_address'] ?? '',
            'server_addr' => $config['server_addr'] ?? '',
            'keyboard_shortcut' => $config['keyboard_shortcut'] ?? '',
            'icons' => [
                'bookmark_added' => Minz_ExtensionManager::findExtension('Hoarder Integration')->getFileUrl('added_to_hoarder.svg', 'svg')
            ],
            'i18n' => [
                'added_bookmark' => _t('ext.hoarderIntegration.notifications.added_bookmark', '%s'),
                'failed_to_add_bookmark' => _t('ext.hoarderIntegration.notifications.failed_to_add_bookmark', '%s'),
                'ajax_request_failed' => _t('ext.hoarderIntegration.notifications.ajax_request_failed'),
                'bookmark_not_found' => _t('ext.hoarderIntegration.notifications.bookmark_not_found'),
            ]
        ]);

        $this->view->_layout(null);
        $this->view->_path('hoarderIntegration/vars.js');

        header('Content-Type: application/javascript; charset=utf-8');
    }

public function addAction(): void
{
    $input = json_decode(file_get_contents('php://input'), true);

    if (!isset($input['url'])) {
        http_response_code(400);
        echo json_encode(['status' => 400, 'message' => 'Invalid input data: Missing URL']);
        exit;
    }

    $url = $input['url'];

    $config = FreshRSS_Context::$user_conf->HoarderIntegration ?? [];
    if (empty($config)) {
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'HoarderIntegration configuration not found']);
        exit;
    }

    $apiKey = $config['api_key'] ?? '';
    $ipaddress = trim($config['ip_address'] ?? '');
    if (empty($apiKey) || empty($ipaddress)) {
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'Invalid HoarderIntegration configuration (missing API key or IP address)']);
        exit;
    }

    $apiUrl = "$ipaddress/api/v1/bookmarks";

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer ' . $apiKey,
    ]);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
        'type' => 'link',
        'url' => $url,
    ]));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($response === false) {
        $error = curl_error($ch);
        http_response_code(500);
        echo json_encode(['status' => 500, 'message' => 'cURL error: ' . $error]);
        curl_close($ch);
        exit;
    }

    curl_close($ch);

    $parsedResponse = json_decode($response, true);

    if ($httpCode === 201 && $parsedResponse) {
        echo json_encode(['status' => 201, 'message' => 'Bookmark added successfully', 'response' => $parsedResponse]);
        exit;
    }

    http_response_code($httpCode);
    echo json_encode([
        'status' => $httpCode,
        'message' => $parsedResponse['message'] ?? 'Failed to add bookmark',
        'response' => $parsedResponse ?? $response
    ]);
}

    
}
