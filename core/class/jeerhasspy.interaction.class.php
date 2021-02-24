<?php

class JeerhasspyInteraction
{
    private $_interactDef;

    /*     * **********************Ctor*************************** */

    public function __construct($_interactDef)
    {
        $this->_interactDef = $_interactDef;
    }

    public static function getById($_id)
    {
        if ($_id === null) {
            return null;
        }
        $_interactDef = interactDef::byId($_id);
        if (is_object($_interactDef)) {
            return new self($_interactDef);
        }
        return null;
    }

    /*     * **********************Getteur Setteur*************************** */

    public function getName()
    {
        return $this->_interactDef->getHumanName();
    }

    public function getId()
    {
        return $this->_interactDef->getId();
    }

    public function getQueriesCount()
    {
        return count($this->generateQueryVariant());
    }

    public function generateQueryVariant()
    {
        return $this->_interactDef->generateQueryVariant();
    }

    public function getIgnore()
    {
        $_ignoredInteractionsConfig = self::getIgnoredInteractions();
        return in_array($this->getId(), $_ignoredInteractionsConfig);
    }

    public function setIgnore($_ignore)
    {
        if (JeerhasspyUtils::toBool($_ignore) === $this->getIgnore()) {
            return;
        }
        $ignoredInteractionsConfig = self::getIgnoredInteractions();
        if ($_ignore) {
            array_push($ignoredInteractionsConfig, $this->getId());
        } else {
            $_index = array_search($this->getId(), $ignoredInteractionsConfig);
            array_splice($ignoredInteractionsConfig, $_index, 1);
        }
        self::saveIgnoredInteractions($ignoredInteractionsConfig);
    }

    //Methods

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'queriesCount' => $this->getQueriesCount(),
            'ignore' => $this->getIgnore()
        ];
    }

    public static function getIgnoredInteractions()
    {
        return explode('|', JeerhasspyUtils::getConfig(jeerhasspy_config_ignoredInteractions));
    }

    public static function saveIgnoredInteractions($_ignoredInteractions)
    {
        JeerhasspyUtils::setConfig(jeerhasspy_config_ignoredInteractions, implode("|", $_ignoredInteractions));
    }

    /**
     * Returns a list of JeerhasspyInteraction objects
     * @return JeerhasspyInteraction[]
     */
    public static function all()
    {
        $result = [];
        $_interactDefs = interactDef::all();
        foreach ($_interactDefs as $_interactDef) {
            array_push($result, new self($_interactDef));
        }
        return $result;
    }
}