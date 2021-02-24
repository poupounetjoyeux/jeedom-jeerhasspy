<?php

function checkAnswersAjaxMethods()
{
    if (init('action') === jeerhasspy_ajax_allAnswers) {
        ajax::success(JeerhasspyUtils::jsonResult(JeerhasspyAnswer::all()));
    }

    if (init('action') === jeerhasspy_ajax_byIdAnswer) {
        $_answerId = init('answerId', null);
        $answer = JeerhasspyAnswer::byId($_answerId);
        if ($answer === null) {
            ajax::error('{{Désolé, cette réponse est introuvable}}');
        }
        ajax::success(JeerhasspyUtils::jsonResult($answer));
    }

    if (init('action') === jeerhasspy_ajax_saveAnswer) {
        $_answer = init('answer', null);
        if (isset($_answer['id'])) {
            $answer = JeerhasspyAnswer::byId($_answer['id']);
            if ($answer === null) {
                ajax::error('{{Cette réponse n\'existe pas}}');
            }
        } else {
            $answer = new JeerhasspyAnswer();
        }
        $result = $answer->update($_answer);
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        $answer->save();
        ajax::success(JeerhasspyUtils::jsonResult($answer));
    }

    if (init('action') === jeerhasspy_ajax_deleteAnswer) {
        $_answerId = init('answerId', null);
        $answer = JeerhasspyAnswer::byId($_answerId);
        if ($answer === null) {
            ajax::error('{{Cette réponse n\'existe pas}}');
        }
        $answer->remove();
        ajax::success();
    }
}