<?php

function checkAssistantAjaxMethods()
{
    if (init('action') === jeerhasspy_ajax_allAssistants) {
        ajax::success(JeerhasspyUtils::jsonResult(JeerhasspyAssistant::all()));
    }

    if (init('action') === jeerhasspy_ajax_bySiteIdAssitant) {
        $_siteId = init('siteId', null);
        $assistant = JeerhasspyAssistant::bySiteId($_siteId);
        if ($assistant === null) {
            ajax::error('{{Désolé, cet assistant est introuvable}}');
        }
        ajax::success(JeerhasspyUtils::jsonResult($assistant));
    }

    if (init('action') === jeerhasspy_ajax_saveAssistant) {
        $_assistant = init('assistant', null);
        $result = JeerhasspyAssistant::createOrUpdateAssistant($_assistant);
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        ajax::success($result->getJsonResult());
    }

    if (init('action') === jeerhasspy_ajax_deleteAssistant) {
        $_siteId = init('siteId', null);
        $assistant = JeerhasspyAssistant::bySiteId($_siteId);
        if ($assistant === null) {
            ajax::error('{{Désolé, cet assistant est introuvable}}');
        }
        $assistant->remove();
        ajax::success();
    }

    if (init('action') === jeerhasspy_ajax_syncAssistant) {
        $_siteId = init('siteId', null);
        $_syncInformations = JeerhasspyUtils::toBool(init('syncInformations', false));
        $_syncInteractions = JeerhasspyUtils::toBool(init('syncInteractions', false));
        $_syncAnswers = JeerhasspyUtils::toBool(init('syncAnswers', false));
        $_syncSlots = JeerhasspyUtils::toBool(init('syncSlots', false));
        $assistant = JeerhasspyAssistant::bySiteId($_siteId);
        if ($assistant === null) {
            ajax::error('{{Désolé, cet assistant est introuvable}}');
        }
        $result = $assistant->syncAssistant($_syncInformations, $_syncInteractions, $_syncAnswers, $_syncSlots);
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        ajax::success();
    }

    if (init('action') === jeerhasspy_ajax_syncAssistants) {
        $_syncInformations = JeerhasspyUtils::toBool(init('syncInformations', false));
        $_syncInteractions = JeerhasspyUtils::toBool(init('syncInteractions', false));
        $_syncAnswers = JeerhasspyUtils::toBool(init('syncAnswers', false));
        $_syncSlots = JeerhasspyUtils::toBool(init('syncSlots', false));
        $result = JeerhasspyAssistant::syncAllAssistants($_syncInformations, $_syncInteractions, $_syncAnswers, $_syncSlots);
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        ajax::success();
    }

    if (init('action') === jeerhasspy_ajax_configureAssitantProfile) {
        $_siteId = init('siteId', null);
        $_useInternalUrl = JeerhasspyUtils::toBool(init('useInternalUrl', true));
        $_configRemote = JeerhasspyUtils::toBool(init('configRemote', false));
        $_configWake = JeerhasspyUtils::toBool(init('configWake', false));
        $assistant = JeerhasspyAssistant::bySiteId($_siteId);
        if ($assistant === null) {
            ajax::error('{{Désolé, cet assistant est introuvable}}');
        }
        $_url = JeerhasspyUtils::getPluginApiUri($_useInternalUrl);
        $result = RhasspyRequestsUtils::configureAssistantProfile($assistant, $_url, $_configRemote, $_configWake);
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        ajax::success();
    }

    if (init('action') == jeerhasspy_ajax_testAssistant) {
        $_siteId = init('siteId', null);
        $assistant = JeerhasspyAssistant::bySiteId($_siteId);
        if ($assistant === null) {
            ajax::error('{{Désolé, cet assistant est introuvable}}');
        }
        $result = RhasspyRequestsUtils::testAssistant($assistant);
        if(!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        ajax::success();
    }
}