<?php

function checkInteractionAjaxMethods()
{
    if (init('action') === jeerhasspy_ajax_allInteractions) {
        ajax::success(JeerhasspyUtils::jsonResult(JeerhasspyInteraction::all()));
    }

    if (init('action') === jeerhasspy_ajax_saveInteractions) {
        $_interactions = init('interactions', null);
        $result = [];
        foreach ($_interactions as $_interaction) {
            $interaction = JeerhasspyInteraction::getById($_interaction['id']);
            if ($interaction === null) {
                continue;
            }
            $interaction->setIgnore($_interaction['ignore']);
            array_push($result, $interaction);
        }
        ajax::success(JeerhasspyUtils::jsonResult($result));
    }
}