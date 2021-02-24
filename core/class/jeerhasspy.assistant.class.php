<?php

class JeerhasspyAssistant
{
    private $_eqLogic;

    /*     * **********************Ctor*************************** */

    public function __construct($_eqLogic)
    {
        $this->_eqLogic = $_eqLogic;
    }

    public static function getNewAssistant($_siteId, $_uri, $_type)
    {
        $eqLogic = new jeerhasspy();
        $eqLogic->setEqType_name(jeerhasspy_id);
        $eqLogic->setIsVisible(1);
        $eqLogic->setIsEnable(1);
        $eqLogic->setCategory(jeerhasspy_eqCategory, 1);
        $eqLogic->setObject_id(-1);

        $assistant = new self($eqLogic);
        $assistant->setType($_type);
        $assistant->setUri($_uri);
        $assistant->setSiteId($_siteId);
        $assistant->setName('Rhasspy-' . $_siteId);

        $isMaster = $assistant->isMaster();
        $assistant->setSyncJeedomInteractions($isMaster);
        $assistant->setSyncSlots($isMaster);
        $assistant->setSyncAnswers($isMaster);

        $result = $assistant->syncAssistantInfos();
        if (!$result->isSuccess()) {
            return $result;
        }
        return $result->setSuccess($assistant);
    }

    public static function bySiteId($_siteId)
    {
        if ($_siteId === null) {
            return null;
        }
        $eqLogic = eqLogic::byLogicalId($_siteId, jeerhasspy_id);
        if (is_object($eqLogic)) {
            return new self($eqLogic);
        }
        return null;
    }

    /*     * **********************Getteur Setteur*************************** */

    public function getId()
    {
        return $this->_eqLogic->getId();
    }

    public function getType()
    {
        return $this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_type);
    }

    public function setType($_type)
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_type, $_type);
    }

    public function isMaster()
    {
        return $this->getType() === jeerhasspy_master_type;
    }

    public function getUri()
    {
        return $this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_uri);
    }

    public function setUri($_uri)
    {
        $uri = $_uri;
        if (!JeerhasspyUtils::startsWith($uri, 'http')) {
            $uri = 'http://' . $uri;
        }
        if (JeerhasspyUtils::endsWith($uri, '/')) {
            $uri = substr($uri, 0, -1);
        }
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_uri, $uri);
    }

    public function getSiteId()
    {
        return $this->_eqLogic->getLogicalId();
    }

    public function setSiteId($_siteId)
    {
        return $this->_eqLogic->setLogicalId($_siteId);
    }

    public function getName()
    {
        return $this->_eqLogic->getName();
    }

    public function setName($_name)
    {
        return $this->_eqLogic->setName($_name);
    }

    public function getIsVisible()
    {
        return JeerhasspyUtils::toBool($this->_eqLogic->getIsVisible());
    }

    public function setIsVisible($_isVisible)
    {
        return $this->_eqLogic->setIsVisible(JeerhasspyUtils::boolToInteger($_isVisible));
    }

    public function getIsEnable()
    {
        return JeerhasspyUtils::toBool($this->_eqLogic->getIsEnable());
    }

    public function setIsEnable($_isEnable)
    {
        return $this->_eqLogic->setIsEnable(JeerhasspyUtils::boolToInteger($_isEnable));
    }

    public function getParentObjectId()
    {
        return $this->_eqLogic->getObject_id();
    }

    public function setParentObjectId($_objectId)
    {
        return $this->_eqLogic->setObject_id($_objectId);
    }

    public function getDefaultLang()
    {
        return $this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_defaultLang);
    }

    public function setDefaultLang($_lang)
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_defaultLang, $_lang);
    }

    public function getAssistantVersion()
    {
        return $this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_assistantVersion);
    }

    public function setAssistantVersion($_version)
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_assistantVersion, $_version);
    }

    public function getImportTime()
    {
        return $this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_assistantDate);
    }

    public function setImportTimeToNow()
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_assistantDate, date('Y-m-d H:i:s'));
    }

    public function getSyncJeedomInteractions()
    {
        return JeerhasspyUtils::toBool($this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_syncJeedomInteractions));
    }

    public function setSyncJeedomInteractions($_sync)
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_syncJeedomInteractions, JeerhasspyUtils::boolToInteger($_sync));
    }

    public function getSyncAnswers()
    {
        return JeerhasspyUtils::toBool($this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_syncAnswers));
    }

    public function setSyncAnswers($_sync)
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_syncAnswers, JeerhasspyUtils::boolToInteger($_sync));
    }

    public function getSyncSlots()
    {
        return JeerhasspyUtils::toBool($this->_eqLogic->getConfiguration(jeerhasspy_eqLogic_syncSlots));
    }

    public function setSyncSlots($_sync)
    {
        return $this->_eqLogic->setConfiguration(jeerhasspy_eqLogic_syncSlots, JeerhasspyUtils::boolToInteger($_sync));
    }

    public function getCmd($_cmdKey)
    {
        return $this->_eqLogic->getCmd(null, $_cmdKey);
    }

    //Methods

    public function save()
    {
        $this->_eqLogic->save();
        $this->createUpdateAssistantCommands();
    }

    public function remove()
    {
        $this->_eqLogic->remove();
    }

    public function update($_assistant)
    {
        $result = new JeerhasspyResponse();
        if (!isset($_assistant['name']) || trim($_assistant['name']) === '') {
            return $result->setError('{{Un assistant requiert un nom}}');
        }
        $this->setName($_assistant['name']);
        $this->setType($_assistant['type']);
        $this->setType($_assistant['type']);
        $this->setUri($_assistant['uri']);
        $this->setParentObjectId($_assistant['parentObjectId']);
        $this->setIsEnable($_assistant['isEnable']);
        $this->setIsVisible($_assistant['isVisible']);
        $this->setSyncJeedomInteractions($_assistant['syncJeedomInteractions']);
        $this->setSyncAnswers($_assistant['syncAnswers']);
        $this->setSyncSlots($_assistant['syncSlots']);
        $result->fromResult($this->syncAssistantInfos());
        return $result;
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'siteId' => $this->getSiteId(),
            'uri' => $this->getUri(),
            'defaultLang' => $this->getDefaultLang(),
            'syncJeedomInteractions' => $this->getSyncJeedomInteractions(),
            'syncAnswers' => $this->getSyncAnswers(),
            'syncSlots' => $this->getSyncSlots(),
            'assistantVersion' => $this->getAssistantVersion(),
            'importTime' => $this->getImportTime(),
            'isMaster' => JeerhasspyUtils::toBool($this->isMaster()),
            'parentObjectId' => $this->getParentObjectId(),
            'isVisible' => $this->getIsVisible(),
            'isEnable' => $this->getIsEnable()
        ];
    }

    /**
     * Returns a list of JeerhasspyAssistant objects
     * @return JeerhasspyAssistant[]
     */
    public static function all()
    {
        $result = [];
        $_eqLogics = eqLogic::byType(jeerhasspy_id);
        foreach ($_eqLogics as $_eqLogic) {
            array_push($result, new self($_eqLogic));
        }
        return $result;
    }

    public static function createOrUpdateAssistant($_assistant)
    {
        $result = new JeerhasspyResponse();
        if (isset($_assistant['siteId'])) {
            $assistant = JeerhasspyAssistant::bySiteId($_assistant['siteId']);
            if ($assistant === null) {
                return $result->setError('{{Désolé, cet assistant est introuvable}}');
            }
            $result = $assistant->update($_assistant);
            if (!$result->isSuccess()) {
                return $result;
            }
            $assistant->save();
            return $result->setSuccess($assistant);
        }

        $_uri = $_assistant['uri'];
        $_type = $_assistant['type'];
        $result = RhasspyRequestsUtils::getAssistantSiteId($_uri);
        if (!$result->isSuccess()) {
            return $result;
        }
        $_siteId = $result->getResult();

        $result = self::getNewAssistant($_siteId, $_uri, $_type);
        if (!$result->isSuccess()) {
            return $result;
        }
        $assistant = $result->getResult();
        $assistant->save();
        return $result->setSuccess($assistant);
    }

    public function syncAssistantInfos()
    {
        $uri = $this->getUri();
        $result = new JeerhasspyResponse();
        JeerhasspyUtils::logger('Loading infos for assistant: ' . $uri);
        $this->setImportTimeToNow();

        //load assistant version
        $result->fromResult(RhasspyRequestsUtils::getAssistantVersion($this));
        if (!$result->isSuccess()) {
            return $result;
        }
        $this->setAssistantVersion($result->getResult());

        //load siteId
        $result->fromResult(RhasspyRequestsUtils::getAssistantSiteId($uri));
        if (!$result->isSuccess()) {
            return $result;
        }
        $siteId = $result->getResult();
        if ($siteId !== $this->getSiteId()) {
            $existing = JeerhasspyAssistant::bySiteId($siteId);
            if ($existing !== null) {
                return $result->setError('{{Un autre assistant dispose déjà du même site ID, imposible de synchroniser : }} ' . $uri);
            }
        }
        $this->setSiteId($siteId);

        //load default language
        $result->fromResult(RhasspyRequestsUtils::getAssistantDefaultLang($this));
        if (!$result->isSuccess()) {
            return $result;
        }
        $this->setDefaultLang($result->getResult());

        return $result->setSuccess();
    }

    public function syncAssistant($_syncInformations, $_syncInteractions, $_syncAnswers, $_syncSlots)
    {
        $result = new JeerhasspyResponse();
        if ($_syncInformations) {
            $result->fromResult($this->syncAssistantInfos());
            if (!$result->isSuccess()) {
                return $result;
            }
            $this->save();
        }

        if ($_syncInteractions && $this->getSyncJeedomInteractions()) {
            $_interactionsPayload = JeerhasspyUtils::generateInteractionsPayload();
            $result->fromResult(RhasspyRequestsUtils::postAssistantSentences($this, $_interactionsPayload));
            if (!$result->isSuccess()) {
                return $result;
            }
        }

        if ($_syncAnswers && $this->getSyncAnswers()) {
            $_answersPayload = JeerhasspyUtils::generateAnswersPayload();
            $result->fromResult(RhasspyRequestsUtils::postAssistantSentences($this, $_answersPayload));
            if (!$result->isSuccess()) {
                return $result;
            }
        }

        if($_syncSlots && $this->getSyncSlots()) {
            $_slotsPayload = JeerhasspyUtils::generateSlotsPayload();
            $result->fromResult(RhasspyRequestsUtils::postAssistantSlots($this, $_slotsPayload));
            if (!$result->isSuccess()) {
                return $result;
            }
        }

        if($_syncAnswers || $_syncSlots || $_syncInteractions) {
            $result->fromResult(RhasspyRequestsUtils::trainAssistant($this));
            if (!$result->isSuccess()) {
                return $result;
            }
        }

        return $result->setSuccess();
    }

    public static function syncAllAssistants($_syncInformations, $_syncInteractions, $_syncAnswers, $_syncSlots)
    {
        $result = new JeerhasspyResponse();
        $assistants = JeerhasspyAssistant::all();
        $interactionsPayload = '';
        $answersPayload = '';
        $slotsPayload = '';
        if ($_syncInteractions) {
            $interactionsPayload = JeerhasspyUtils::generateInteractionsPayload();
        }
        if ($_syncAnswers) {
            $answersPayload = JeerhasspyUtils::generateAnswersPayload();
        }
        if($_syncSlots) {
            $slotsPayload = JeerhasspyUtils::generateSlotsPayload();
        }
        foreach ($assistants as $assistant) {

            if ($_syncInformations) {
                $result = $assistant->syncAssistantInfos();
                if (!$result->isSuccess()) {
                    return $result;
                }
                $assistant->save();
            }

            if ($_syncInteractions && $assistant->getSyncJeedomInteractions()) {
                $result->fromResult(RhasspyRequestsUtils::postAssistantSentences($assistant, $interactionsPayload));
                if (!$result->isSuccess()) {
                    return $result;
                }
            }

            if($_syncAnswers && $assistant->getSyncAnswers()) {
                $result->fromResult(RhasspyRequestsUtils::postAssistantSentences($assistant, $answersPayload));
                if (!$result->isSuccess()) {
                    return $result;
                }
            }

            if($_syncSlots && $assistant->getSyncSlots()) {
                $result->fromResult(RhasspyRequestsUtils::postAssistantSlots($assistant, $slotsPayload));
                if (!$result->isSuccess()) {
                    return $result;
                }
            }

            if($_syncAnswers || $_syncSlots || $_syncInteractions) {
                $result->fromResult(RhasspyRequestsUtils::trainAssistant($assistant));
                if (!$result->isSuccess()) {
                    return $result;
                }
            }
        }

        return $result->setSuccess();
    }

    protected function createUpdateAssistantCommands()
    {
        $eqId = $this->getId();

        //Dynamic speak
        $dynamicSpeakCmd = $this->getCmd(jeerhasspy_cmd_dynamicSpeak);
        if (!is_object($dynamicSpeakCmd)) {
            $dynamicSpeakCmd = new jeerhasspyCmd();
            $dynamicSpeakCmd->setName('Dynamic speak');
            $dynamicSpeakCmd->setIsVisible(1);
            $dynamicSpeakCmd->setOrder(0);
            $dynamicSpeakCmd->setDisplay('message_placeholder', 'TTS dynamic');
            $dynamicSpeakCmd->setEqLogic_id($eqId);
            $dynamicSpeakCmd->setLogicalId(jeerhasspy_cmd_dynamicSpeak);
            $dynamicSpeakCmd->setType('action');
            $dynamicSpeakCmd->setSubType('message');
            $dynamicSpeakCmd->setIsVisible(0);
        }
        if ($this->isMaster()) {
            $dynamicSpeakCmd->setDisplay('title_placeholder', 'siteId:lang');
        } else {
            $dynamicSpeakCmd->setDisplay('title_disable', 1);
        }
        $dynamicSpeakCmd->save();

        //Speak
        $speakCmd = $this->getCmd(jeerhasspy_cmd_speak);
        if (!is_object($speakCmd)) {
            $speakCmd = new jeerhasspyCmd();
            $speakCmd->setName('Speak');
            $speakCmd->setIsVisible(1);
            $speakCmd->setOrder(1);
            $speakCmd->setDisplay('message_placeholder', 'TTS text');
            $speakCmd->setEqLogic_id($eqId);
            $speakCmd->setLogicalId(jeerhasspy_cmd_speak);
            $speakCmd->setType('action');
            $speakCmd->setSubType('message');
        }
        if ($this->isMaster()) {
            $speakCmd->setDisplay('title_placeholder', 'siteId:lang');
        } else {
            $speakCmd->setDisplay('title_disable', 1);
        }
        $speakCmd->save();

        //Ask
        $askCmd = $this->getCmd(jeerhasspy_cmd_ask);
        if (!is_object($askCmd)) {
            $askCmd = new jeerhasspyCmd();
            $askCmd->setName('Ask');
            $askCmd->setIsVisible(1);
            $askCmd->setOrder(2);
            $askCmd->setEqLogic_id($eqId);
            $askCmd->setLogicalId(jeerhasspy_cmd_ask);
            $askCmd->setType('action');
            $askCmd->setSubType('message');
            $askCmd->setDisplay('title_placeholder', 'Intent');
            $askCmd->setDisplay('message_placeholder', 'Question');
            $askCmd->setIsVisible(0);
            $askCmd->save();
        }

        //LEDs ON
        $ledOnCmd = $this->getCmd(jeerhasspy_cmd_ledOn);
        if (!is_object($ledOnCmd)) {
            $ledOnCmd = new jeerhasspyCmd();
            $ledOnCmd->setName('LEDs ON');
            $ledOnCmd->setIsVisible(1);
            $ledOnCmd->setOrder(3);
            $ledOnCmd->setEqLogic_id($eqId);
            $ledOnCmd->setLogicalId(jeerhasspy_cmd_ledOn);
            $ledOnCmd->setType('action');
            $ledOnCmd->setSubType('other');
            $ledOnCmd->save();
        }

        //LEDs OFF:
        $ledOffCmd = $this->getCmd(jeerhasspy_cmd_ledOff);
        if (!is_object($ledOffCmd)) {
            $ledOffCmd = new jeerhasspyCmd();
            $ledOffCmd->setName('LEDs OFF');
            $ledOffCmd->setIsVisible(1);
            $ledOffCmd->setOrder(4);
            $ledOffCmd->setEqLogic_id($eqId);
            $ledOffCmd->setLogicalId(jeerhasspy_cmd_ledOff);
            $ledOffCmd->setType('action');
            $ledOffCmd->setSubType('other');
            $ledOffCmd->save();
        }

        //Volume level
        $volumeLevelCmd = $this->getCmd(jeerhasspy_cmd_volume);
        if (!is_object($volumeLevelCmd)) {
            $volumeLevelCmd = new jeerhasspyCmd();
            $volumeLevelCmd->setName('Volume level');
            $volumeLevelCmd->setIsVisible(0);
            $volumeLevelCmd->setIsHistorized(0);
            $volumeLevelCmd->setTemplate('dashboard', 'core::horizontal');
            $volumeLevelCmd->setTemplate('mobile', 'core::horizontal');
            $volumeLevelCmd->setOrder(6);
            $volumeLevelCmd->setLogicalId(jeerhasspy_cmd_volume);
            $volumeLevelCmd->setEqLogic_id($eqId);
            $volumeLevelCmd->setType('info');
            $volumeLevelCmd->setSubType('numeric');
            $volumeLevelCmd->setConfiguration('minValue', 0);
            $volumeLevelCmd->setConfiguration('maxValue', 100);
            $volumeLevelCmd->save();
        }

        //Volume:
        $setVolumeCmd = $this->getCmd(jeerhasspy_cmd_setVolume);
        if (!is_object($setVolumeCmd)) {
            $setVolumeCmd = new jeerhasspyCmd();
            $setVolumeCmd->setName('Volume');
            $setVolumeCmd->setIsVisible(1);
            $setVolumeCmd->setOrder(5);
            $setVolumeCmd->setEqLogic_id($eqId);
            $setVolumeCmd->setLogicalId(jeerhasspy_cmd_setVolume);
            $setVolumeCmd->setType('action');
            $setVolumeCmd->setSubType('slider');
            $setVolumeCmd->setConfiguration('minValue', 0);
            $setVolumeCmd->setConfiguration('maxValue', 100);
            $setVolumeCmd->setConfiguration('infoId', $volumeLevelCmd->getId());
            $setVolumeCmd->save();
        }

        //Repeat
        $repeatCmd = $this->getCmd(jeerhasspy_cmd_repeat);
        if (!is_object($repeatCmd)) {
            $repeatCmd = new jeerhasspyCmd();
            $repeatCmd->setName('Repeat');
            $repeatCmd->setIsVisible(1);
            $repeatCmd->setOrder(7);
            $repeatCmd->setEqLogic_id($eqId);
            $repeatCmd->setLogicalId(jeerhasspy_cmd_repeat);
            $repeatCmd->setType('action');
            $repeatCmd->setSubType('other');
            $repeatCmd->save();
        }
    }
}
