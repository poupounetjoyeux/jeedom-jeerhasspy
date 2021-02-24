<?php

require_once dirname(__FILE__) . '/../php/jeerhasspy.inc.php';

try {
    include_file('core', 'authentification', 'php');
    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }

    if (init('action') == 'deleteIntents') {
        $result = JeerhasspyIntent::cleanIntents();
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        ajax::success();
    }


    /*if (init('action') == 'test') {
        $_siteId = init('siteId', null);
        $result = RhasspyRequestsUtils::test($_siteId);
        if ( isset($result['error']) ) {
            ajax::error($result['error']);
        }
        ajax::success();
    }*/

    checkAssistantAjaxMethods();
    checkInteractionAjaxMethods();
    checkSlotsAjaxMethods();
    checkAnswersAjaxMethods();

    if (init('action') == 'byId') {
        ajax::success(jeedom::toHumanReadable(utils::o2a(JeerhasspyIntent::byId(init('intentId')))));
    }

    if (init('action') == 'allIntents') {
        ajax::success(jeedom::toHumanReadable(utils::o2a(JeerhasspyIntent::all())));
    }

    if (init('action') == 'saveAllIntents') {
        $intents = json_decode(init('intentsValues'), true);
        foreach ($intents as $intent_json) {
            $intent = JeerhasspyIntent::byId($intent_json['id']);
            if (is_object($intent)) {
                utils::a2o($intent, jeedom::fromHumanReadable($intent_json));
                $intent->save();
            }
        }
        ajax::success();
    }

    if (init('action') == 'saveIntent') {
        $intentValues = json_decode(init('intentValues'), true);
        if (isset($intentValues['id'])) {
            $intent = JeerhasspyIntent::byId($intentValues['id']);
            if (!is_object($intent)) {
                ajax::error(__('Intention introuvable', __FILE__));
            }
            utils::a2o($intent, jeedom::fromHumanReadable($intentValues));
            $intent->save();
            ajax::success($intent->getName());
        }
        ajax::error(__('No id provided', __FILE__));
    }

    if (init('action') == 'remove') {
        $intent = JeerhasspyIntent::byId(init('intentId'));
        if (is_object($intent)) {
            $intentName = $intent->getName();
            $intent->remove();
            ajax::success($intentName);
        }
    }

    throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
