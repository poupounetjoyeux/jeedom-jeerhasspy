function allAssistants(_callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "allAssistants"
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

function bySiteIdAssitant(_siteId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "bySiteIdAssitant",
            siteId: _siteId
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

function saveAssistant(_assistant, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "saveAssistant",
            assistant: _assistant
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

function deleteAssistant(_siteId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "deleteAssistant",
            siteId: _siteId,
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
    })
}

function testAssistant(_siteId, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "testAssistant",
            siteId: _siteId,
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
    })
}

function syncAssistants(_syncInformations, _syncInteractions, _syncAnswers, _syncSlots, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "syncAssistants",
            syncInformations: _syncInformations,
            syncInteractions: _syncInteractions,
            syncAnswers: _syncAnswers,
            syncSlots: _syncSlots
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
    })
}

function syncAssistant(_siteId, _syncInformations, _syncInteractions, _syncAnswers, _syncSots, _callbackError, _callbackSuccess) {
    $.hideAlert();
    $.ajax({
        type: "POST",
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "syncAssistant",
            siteId: _siteId,
            syncInformations: _syncInformations,
            syncInteractions: _syncInteractions,
            syncAnswers: _syncAnswers,
            syncSots: _syncSots
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
    })
}

function configureAssistantRhasspyProfile(_siteId, _useInternalUrl, _configRemote, _configWake, _callbackError, _callbackSuccess) {
    $.ajax({
        url: "plugins/jeerhasspy/core/ajax/jeerhasspy.ajax.php",
        data: {
            action: "configureAssistantProfile",
            siteId: _siteId,
            useInternalUrl: _useInternalUrl,
            configRemote: _configRemote,
            configWake: _configWake
        },
        dataType: 'json',
        error: function (request, status, error) {
            handleAjaxError(request, status, error);
        },
        success: function (data) {
            if (data.state != 'ok') {
                _callbackError(data.result);
                return;
            }
            _callbackSuccess();
        }
    })
}