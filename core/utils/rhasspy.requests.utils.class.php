<?php

class RhasspyRequestsUtils
{
    protected static $_curlHdl = null;

    public static function postAssistantSentences(JeerhasspyAssistant $_assistant, $_interactionsPayload)
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_sentences;

        $result = self::_request('POST', $url, $_interactionsPayload);
        if (!$result->isSuccess()) {
            return $result->setImpossibleConnectionError($uri);
        }
        return $result->setSuccess();
    }

    public static function postAssistantSlots(JeerhasspyAssistant $_assistant, $_slotPayload)
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_slots.'?overwrite_all=true';

        $result = self::_request('POST', $url, $_slotPayload);
        if (!$result->isSuccess()) {
            return $result->setImpossibleConnectionError($uri);
        }
        return $result->setSuccess();
    }

    public static function getAssistantVersion(JeerhasspyAssistant $_assistant)
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_version;

        $result = self::_request('GET', $url);
        if (!$result->isSuccess()) {
            return $result->setImpossibleConnectionError($uri);
        }

        $version = $result->getResult();
        JeerhasspyUtils::logger('version: ' . $version);
        if (!JeerhasspyUtils::isSupportedVersion($version)) {
            return $result->setSuccess(rhasspy_unsupported_version);
        }
        return $result->setSuccess($version);
    }

    public static function getAssistantSiteId($_uri)
    {
        $result = self::getAssistantRhasspyProfile($_uri);
        if (!$result->isSuccess()) {
            return $result;
        }

        $profile = $result->getResult();
        JeerhasspyUtils::logger('profile: ' . json_encode($profile));
        $siteId = '';
        if (isset($profile['mqtt']['site_id'])) {
            $allSiteIds = explode(',', $profile['mqtt']['site_id']);
            if (count($allSiteIds) > 0) {
                $siteId = $allSiteIds[0];
            }
        }
        if ($siteId == '') {
            return $result->setError('{{Aucun siteId n\'est configuré sur l\'assistant Rhasspy}} ' . $_uri);
        }
        return $result->setSuccess($siteId);
    }

    public static function getAssistantDefaultLang(JeerhasspyAssistant $_assistant)
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_profiles;

        $result = self::_request('GET', $url);
        if (!$result->isSuccess()) {
            return $result->setImpossibleConnectionError($uri);
        }

        $profiles = json_decode($result->getResult(), true);
        JeerhasspyUtils::logger('profiles: ' . $profiles);
        $defaultLang = $profiles['default_profile'];
        if (!isset($defaultLang)) {
            return $result->setError('{{Impossible de récupérer le profil sur l\'assistant Rhasspy}} ' . $url);
        }
        return $result->setSuccess($defaultLang);
    }

    public static function repeatAssistant(JeerhasspyAssistant $_assistant)
    {
        $url = $_assistant->getUri().rhasspy_api_tts.'?repeat=true';
        return self::_request('POST', $url);
    }

    public static function testAssistant(JeerhasspyAssistant $_assistant)
    {
        $_options = array(
            'message' => $_assistant->getSiteId().', ceci est un test.',
        );
        return self::textToSpeech($_assistant, $_options);
    }

    public static function textToSpeech(JeerhasspyAssistant $_assistant, $_options)
    {
        $result = new JeerhasspyResponse();
        if (!is_array($_options))
        {
            return $result->setError('{{Impossible de parser les options}}');
        }
        //get either siteId/lang or get master one:
        $lang = $_assistant->getDefaultLang();
        $siteId = null;
        if ($_assistant->isMaster() && isset($_options['title']) && $_options['title'] != '') {
            $_string = $_options['title'];
            if (strpos($_string, ':') !== false) {
                $siteId = explode(':', $_string)[0];
                $lang = explode(':', $_string)[1];
            } else {
                $siteId = $_options['title'];
            }
        }

        if ($siteId === null || $siteId === '') {
            $siteId = $_assistant->getSiteId();
        }

        //get either text or test:
        $siteId = str_replace(' ', '', $siteId);
        $lang = JeerhasspyUtils::sanitizeLang($lang);
        $_message = JeerhasspyUtils::sanitizeString($lang, $_options['message']);

        JeerhasspyUtils::logger('$_message: '.$_message.' | siteId: '.$siteId.' | lang: '.$lang);

        $uri = $_assistant->getUri().rhasspy_api_tts.'?siteId='.$siteId;
        if ($lang) {
            $uri .= '&language='.$lang;
        }

        return self::_request('POST', $uri, $_message);
    }

    public static function speakToAsk(JeerhasspyAssistant $_assistant, $_options)
    {
        $result = new JeerhasspyResponse();
        if (!is_array($_options))
        {
            return $result->setError('{{Impossible de parser les options}}');
        }

        $answerEntity = $_options['answer'][0];
        $answerVariable = $_options['variable'];
        $askData = $answerEntity . '::' . $answerVariable;
        $url = $_assistant->getUri().rhasspy_api_listenCommand.'?entity=askData&value='.$askData;
        $result = self::_request('POST', $url);
        if (!$result->isSuccess()) {
            return $result;
        }

        //Intent answer:
        $payload = json_decode($result->getResult(), true);
        JeerhasspyUtils::logger($payload);

        $answer = false;
        $intentName = $payload['intent']['name'];
        if ($intentName != '') {
            if (isset($payload['entities'])) {
                foreach ($payload['entities'] as $entity) {
                    if ($entity['entity'] == $answerEntity) {
                        $answer = $entity['value'];
                        break;
                    }
                }
                if ($answer) {
                    scenario::setData($answerVariable, $answer);
                    JeerhasspyUtils::logger('Ask answer received, set answer variable: '.$answer);
                }
            }
        }

        if (!$answer) {
            scenario::setData($answerVariable, '--No Answer--');
        }
        return $result->setSuccess();
    }

    public static function setLEDs(JeerhasspyAssistant $_assistant, $_state)
    {
        if ($_state == 0) {
            $url = $_assistant->getUri().rhasspy_api_hermes_leds_off;
        } else {
            $url = $_assistant->getUri().rhasspy_api_hermes_leds_on;
        }
        return self::_request('POST', $url);
    }

    public static function setVolume(JeerhasspyAssistant $_assistant, $_level)
    {
        $level = $_level;
        if ($level > 100)
        {
            $level = 100;
        }
        if ($level < 0)
        {
            $level = 0;
        }
        $level = round($level / 100, 2);

        $url = $_assistant->getUri().rhasspy_api_setVolume;

        $result = self::_request('POST', $url, $level);
        if (!$result->isSuccess()) {
            return $result;
        }

        $cmd = $_assistant->getCmd(jeerhasspy_cmd_volume);
        if (is_object($cmd)) {
            $cmd->event($_level);
        }
        return $result->setSuccess();
    }

    protected static function getAssistantRhasspyProfile($_uri, $onlyDifferencesWithDefault = false)
    {
        $url = $_uri . rhasspy_api_profile;
        if ($onlyDifferencesWithDefault) {
            $url .= '?layers=profile';
        }
        $result = self::_request('GET', $url);
        if (!$result->isSuccess()) {
            return $result->setImpossibleConnectionError($_uri);
        }
        $profile = json_decode($result->getResult(), true);
        return $result->setSuccess($profile);
    }

    public static function trainAssistant(JeerhasspyAssistant $_assistant)
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_train;
        $result = self::_request('POST', $url, '');
        if (!$result->isSuccess()) {
            return $result->setError('{{Impossible d\'entrainer l\'assistant:}} ' . $uri);
        }
        return $result->setSuccess();
    }

    public static function restartAssistant(JeerhasspyAssistant $_assistant, $_message = '')
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_restart;
        $result = self::_request('POST', $url, $_message);
        if (!$result->isSuccess()) {
            return $result->setError('{{Impossible de redémarrer l\'assistant:}} ' . $uri);
        }
        return $result->setSuccess();
    }

    public static function configureAssistantProfile(JeerhasspyAssistant $_assistant, $_uri, $_configRemote, $_configWake)
    {
        $result = new JeerhasspyResponse();
        JeerhasspyUtils::logger('_uri: ' . $_uri . ' _configRemote: ' . $_configRemote . ' _configWake: ' . $_configWake);

        if (!$_configWake && !$_configRemote) {
            return $result->setSuccess();
        }

        $result->fromResult(self::getAssistantRhasspyProfile($_assistant->getUri(), true));
        if (!$result->isSuccess()) {
            return $result;
        }
        $profile = $result->getResult();

        //apply new profile settings
        if ($_configRemote) {
            $profile['handle']['system'] = 'remote';
            $profile['handle']['remote']['url'] = $_uri;
        }
        if ($_configWake) {
            $profile['webhooks']['awake'][0] = $_uri;
        }

        $result->fromResult(self::saveAssistantProfile($_assistant, $profile));
        if (!$result->isSuccess()) {
            return $result;
        }

        //check
        $result->fromResult(self::checkAssistantProfileUpdate($_assistant, $_uri, $_configRemote, $_configWake));
        if (!$result->isSuccess()) {
            return $result;
        }

        //restart
        return self::restartAssistant($_assistant, 'Profile configuration from Jeedom');
    }

    protected static function saveAssistantProfile(JeerhasspyAssistant $_assistant, $_newProfile)
    {
        $uri = $_assistant->getUri();
        $url = $uri . rhasspy_api_profile;
        $result = self::_request('POST', $url, json_encode($_newProfile, JSON_UNESCAPED_SLASHES));
        if (!$result->isSuccess()) {
            return $result->setError('{{Impossible d\'appliquer les paramètres à l\'assistant: }}' . $uri);
        }
        return $result->setSuccess();
    }

    protected static function checkAssistantProfileUpdate(JeerhasspyAssistant $_assistant, $_uri, $_configRemote, $_configWake)
    {
        $result = self::getAssistantRhasspyProfile($_assistant->getUri(), true);
        if (!$result->isSuccess()) {
            return $result;
        }

        $profile = $result->getResult();
        $hasError = false;
        if ($_configRemote) {
            if ($profile['handle']['system'] !== 'remote') {
                $hasError = true;
            }
            if ($profile['handle']['remote']['url'] !== $_uri) {
                $hasError = true;
            }
        }
        if ($_configWake) {
            if ($profile['webhooks']['awake'][0] !== $_uri) {
                $hasError = true;
            }
        }

        if ($hasError) {
            return $result->setError('{{Impossible d\'appliquer les paramètres à l\'assistant: }}' . $_assistant->getUri());
        }
        return $result->setSuccess();
    }

    //CALLING FUNCTIONS===================================================
    protected static function _request($method, $url, $post = null)
    {
        $result = new JeerhasspyResponse();
        JeerhasspyUtils::logger($method . ' | ' . $url . ' | ' . $post);

        //init curl handle if necessary:
        if (!isset(self::$_curlHdl)) {
            self::$_curlHdl = curl_init();
            curl_setopt(self::$_curlHdl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt(self::$_curlHdl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt(self::$_curlHdl, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt(self::$_curlHdl, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        }

        curl_setopt(self::$_curlHdl, CURLOPT_URL, $url);
        curl_setopt(self::$_curlHdl, CURLOPT_CUSTOMREQUEST, $method);

        //is POST
        curl_setopt(self::$_curlHdl, CURLOPT_POSTFIELDS, '');
        curl_setopt(self::$_curlHdl, CURLOPT_POST, 0);
        if (isset($post)) {
            curl_setopt(self::$_curlHdl, CURLOPT_POSTFIELDS, $post);
        }

        //send request
        $response = curl_exec(self::$_curlHdl);
        $httpCode = curl_getinfo(self::$_curlHdl, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            $errNo = curl_errno(self::$_curlHdl);
            JeerhasspyUtils::logger('errno: ' . $errNo);
            return $result->setError($errNo);
        }
        return $result->setSuccess($response);
    }
}
