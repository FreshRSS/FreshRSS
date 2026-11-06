<?php

class hoarderIntegrationExtension extends Minz_Extension {
    public function init() {
        
        $this->registerTranslates();

        Minz_View::appendScript($this->getFileUrl('script.js', 'js'), false, false, false);
        Minz_View::appendStyle($this->getFileUrl('style.css', 'css'));
        Minz_View::appendScript(strval(_url('hoarderIntegration', 'jsVars')), false, true, false);

        $this->registerController('hoarderIntegration');

        $this->registerViews();
    }

    public function configure() {
        $userConf = FreshRSS_Context::$user_conf->HoarderIntegration ?? [];
        $this->view->api_key = $userConf['api_key'] ?? '';
        $this->view->server_addr = $userConf['server_addr'] ?? '';
        $this->view->ip_address = $userConf['ip_address'] ?? '';
        $this->view->keyboard_shortcut = $userConf['keyboard_shortcut'] ?? '';

        $this->view->render(__DIR__ . '/configure.phtml');
    }

    public function handleConfigureAction() {
        if (Minz_Request::isPost()) {
            $api_key = Minz_Request::paramString('api_key');
            $server_addr = Minz_Request::paramString('server_addr');
            $ip_address = Minz_Request::paramString('ip_address');
            $keyboard_shortcut = Minz_Request::paramString('keyboard_shortcut');

            FreshRSS_Context::userConf()->_attribute('HoarderIntegration', [
                'api_key' => $api_key,
                'server_addr' => $server_addr,
                'ip_address' => $ip_address,
                'keyboard_shortcut' => $keyboard_shortcut,
            ]);
            FreshRSS_Context::userConf()->save();
        }
    }
}
