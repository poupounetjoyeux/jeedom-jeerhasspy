function allInteractions(_callback) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "allInteractions"
        },
        dataType: 'json',
        error: (request, status, error) => {
            handleAjaxError(request, status, error);
        },
        success: (data) => {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            _callback($.parseJSON(data.result));
        }
    });
}

function saveInteractions(_interactions, _callback) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "saveInteractions",
            interactions: _interactions
        },
        dataType: 'json',
        error: (request, status, error) => {
            handleAjaxError(request, status, error);
        },
        success: (data) => {
            if (data.state != 'ok') {
                $('#div_alert').showAlert({message: data.result, level: 'danger'});
                return;
            }
            _callback($.parseJSON(data.result));
        }
    });
}