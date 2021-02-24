function allAnswers(_callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "allAnswers"
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

function byIdAnswer(_answerId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "byIdAnswer",
            answerId: _answerId
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

function saveAnswer(_answer, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "saveAnswer",
            answer: _answer
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

function deleteAnswer(_answerId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "deleteAnswer",
            answerId: _answerId
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