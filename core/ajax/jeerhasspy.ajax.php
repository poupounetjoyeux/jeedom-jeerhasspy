<?php

require_once dirname(__FILE__) . '/../php/jeerhasspy.inc.php';

try {
    include_file('core', 'authentification', 'php');
    if (!isConnect('admin')) {
        throw new Exception(__('401 - Accès non autorisé', __FILE__));
    }

    checkAssistantAjaxMethods();
    checkInteractionAjaxMethods();
    checkSlotsAjaxMethods();
    checkAnswersAjaxMethods();

    throw new Exception(__('Aucune méthode correspondante à : ', __FILE__) . init('action'));
    /*     * *********Catch exeption*************** */
} catch (Exception $e) {
    ajax::error(displayExeption($e), $e->getCode());
}
