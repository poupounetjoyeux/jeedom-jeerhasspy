function allSlots(_callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "allSlots"
        },
        dataType: 'json',
        error: (request, status, error) => {
            handleAjaxError(request, status, error);
        },
        success: (data) => {
            if (data.state != 'ok') {
                _callbackError(data.result);
                return;
            }
            _callbackSuccess($.parseJSON(data.result));
        }
    });
}

function byIdSlot(_slotId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "byIdSlot",
            slotId: _slotId
        },
        dataType: 'json',
        error: (request, status, error) => {
            handleAjaxError(request, status, error);
        },
        success: (data) => {
            if (data.state != 'ok') {
                _callbackError(data.result);
                return;
            }
            _callbackSuccess($.parseJSON(data.result));
        }
    });
}

function saveSlot(_slot, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "saveSlot",
            slot: _slot
        },
        dataType: 'json',
        error: (request, status, error) => {
            handleAjaxError(request, status, error);
        },
        success: (data) => {
            if (data.state != 'ok') {
                _callbackError(data.result);
                return;
            }
            _callbackSuccess($.parseJSON(data.result));
        }
    });
}

function deleteSlot(_slotId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "deleteSlot",
            slotId: _slotId
        },
        dataType: 'json',
        error: (request, status, error) => {
            handleAjaxError(request, status, error);
        },
        success: (data) => {
            if (data.state != 'ok') {
                _callbackError(data.result);
                return;
            }
            _callbackSuccess();
        }
    });
}