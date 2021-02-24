<?php

function checkSlotsAjaxMethods()
{
    if (init('action') === jeerhasspy_ajax_allSlots) {
        ajax::success(JeerhasspyUtils::jsonResult(JeerhasspySlot::all()));
    }

    if (init('action') === jeerhasspy_ajax_byIdSlot) {
        $_slotId = init('slotId', null);
        $slot = JeerhasspySlot::byId($_slotId);
        if ($slot === null) {
            ajax::error('{{Désolé, ce slot est introuvable}}');
        }
        ajax::success(JeerhasspyUtils::jsonResult($slot));
    }

    if (init('action') === jeerhasspy_ajax_saveSlot) {
        $_slot = init('slot', null);
        if (isset($_slot['id'])) {
            $slot = JeerhasspySlot::byId($_slot['id']);
            if ($slot === null) {
                ajax::error('{{Ce slot n\'existe pas}}');
            }
        } else {
            $slot = new JeerhasspySlot();
        }
        $result = $slot->update($_slot);
        if (!$result->isSuccess()) {
            ajax::error($result->getMessage());
        }
        $slot->save();
        ajax::success(JeerhasspyUtils::jsonResult($slot));
    }

    if (init('action') === jeerhasspy_ajax_deleteSlot) {
        $_slotId = init('slotId', null);
        $slot = JeerhasspySlot::byId($_slotId);
        if ($slot === null) {
            ajax::error('{{Ce slot n\'existe pas}}');
        }
        $slot->remove();
        ajax::success();
    }
}