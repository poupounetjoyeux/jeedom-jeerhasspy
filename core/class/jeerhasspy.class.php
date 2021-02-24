<?php

class jeerhasspy extends eqLogic
{

    //rhasspy called endpoint forwarded by jeeAPI:
    public static function event()
    {
        JeerhasspyUtils::logger('__EVENT__: ' . file_get_contents('php://input'));
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $payload = json_decode(file_get_contents('php://input'), true);

            //wakeword received:
            if (isset($payload['modelId']) && !isset($payload['intent'])) {
                if (JeerhasspyUtils::getConfig(jeerhasspy_config_setWakeVariables) == '1') {
                    $siteId = explode(',', $payload['siteId'])[0];
                    scenario::setData('rhasspyWakeWord', $payload['modelId']);
                    scenario::setData('rhasspyWakeSiteId', $siteId);
                    JeerhasspyUtils::logger('--Awake -> set variables: rhasspyWakeWord->' . $payload['modelId'] . ' | rhasspyWakeSiteId->' . $siteId);
                }
                return;
            }

            $_answerToRhasspy = array('speech' => array('text' => ''));

            //intent received:
            if (isset($payload['intent']) && isset($payload['intent']['name'])) {
                $intentName = $payload['intent']['name'];
                $payload['site_id'] = explode(',', $payload['site_id'])[0];
                $assistant = JeerhasspyAssistant::bySiteId($payload['site_id']);
                if($assistant === null)
                {
                    JeerhasspyUtils::logger('No assistant matching with site ID : '.$payload['site_id']);
                    return;
                }
                $payload['eqName'] = $assistant->getName();

                if ($intentName != '') {
                    JeerhasspyUtils::logger('--Intent Recognized: ' . $payload['text'] . ' --> ' . json_encode($payload['intent']));
                    $interactionsIntentName = JeerhasspyUtils::getInteractionsIntentNameOrDefault();
                    $askAnswerIntentName = JeerhasspyUtils::getAskAnswerIntentNameOrDefault();
                    if ($interactionsIntentName === $intentName) {
                        JeerhasspyUtils::logger('--Send query to interact engine!');
                        $reply = interactQuery::tryToReply($payload['text'], $payload);
                        if (trim($reply['reply']) != '') {
                            $_answerToRhasspy['speech']['text'] = $reply['reply'];
                        }
                    } else if($askAnswerIntentName === $intentName) {
                        JeerhasspyUtils::logger('--Ask answer intent, let ask request handle the answer');
                    }
                } else {
                    JeerhasspyUtils::logger('--Unrecognized payload.');
                }

                //always answer to rhasspy:
                header('Content-Type: application/json');
                echo json_encode($_answerToRhasspy);
            }
        }
    }

    /*     * *********************Méthodes d'instance************************* */
    public function preInsert()
    {
    }

    public function postInsert()
    {
    }

    public function preSave()
    {
    }

    public function postSave()
    {
    }

    public function preUpdate()
    {
    }

    public function postUpdate()
    {
    }

    public function preRemove()
    {
    }

    public function postRemove()
    {
    }
}

class jeerhasspyCmd extends cmd
{

    public function execute($options = array())
    {
        $_assistant = new JeerhasspyAssistant($this->getEqLogic());
        $_cmdName = $this->getLogicalId();
        JeerhasspyUtils::logger($_assistant->getSiteId() . '.' . $_cmdName . '() | ' . json_encode($options));
        switch ($_cmdName) {
            case jeerhasspy_cmd_speak:
                self::speak($_assistant, $options);
                break;
            case jeerhasspy_cmd_dynamicSpeak:
                self::dynamicSpeak($_assistant, $options);
                break;
            case jeerhasspy_cmd_ask:
                self::ask($_assistant, $options);
                break;
            case jeerhasspy_cmd_ledOn:
                self::setLEDs($_assistant,1);
                break;
            case jeerhasspy_cmd_ledOff:
                self::setLEDs($_assistant,0);
                break;
            case jeerhasspy_cmd_setVolume:
                self::setVolume($_assistant, $options);
                break;
            case jeerhasspy_cmd_repeat:
                self::repeatTTS($_assistant, $options);
                break;
        }
    }

    public function speak(JeerhasspyAssistant $_assistant, $options)
    {
        RhasspyRequestsUtils::textToSpeech($_assistant, $options);
    }

    public function dynamicSpeak(JeerhasspyAssistant $_assistant, $options)
    {
        $options['message'] = JeerhasspyUtils::evalDynamicString($options['message']);
        RhasspyRequestsUtils::textToSpeech($_assistant, $options);
    }

    public function ask(JeerhasspyAssistant $_assistant, $options)
    {
        $answer_entity = $options['answer'][0];
        $answer_variable = $options['variable'];
        RhasspyRequestsUtils::textToSpeech($_assistant, $options);

        $options['askData'] = $answer_entity . '::' . $answer_variable;
        RhasspyRequestsUtils::speakToAsk($_assistant, $options);
    }

    public function setLEDs(JeerhasspyAssistant $_assistant, $state)
    {
        RhasspyRequestsUtils::setLEDs($_assistant, $state);
    }

    public function setVolume(JeerhasspyAssistant $_assistant, $options)
    {
        RhasspyRequestsUtils::setVolume($_assistant, $options['slider']);
    }

    public function repeatTTS(JeerhasspyAssistant $_assistant)
    {
        RhasspyRequestsUtils::repeatAssistant($_assistant);
    }
}
