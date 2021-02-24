$(() => {
    loadAssistants();
    loadSlots();
    loadAnswers();
    loadInteractions();
});

function syncAssistantsClick() {
    $.hideAlert();

    if ($('.jeeRhasspyAssistantCard').length === 0) {
        $('#div_alert').showAlert({message: '{{Aucun assistant. Commencez par en créer un}}', level: 'danger'});
        return;
    }

    const syncAssistantsFormId = 'syncAssistantsForm';
    bootbox.confirm({
        message: getBootBoxForm(syncAssistantsFormId),
        callback: (result) => {
            if (result) {
                let _syncInformations = getBootBoxInputValue(syncAssistantsFormId, 'syncInformations');
                let _syncInteractions = getBootBoxInputValue(syncAssistantsFormId, 'syncInteractions');
                let _syncAnswers = getBootBoxInputValue(syncAssistantsFormId, 'syncAnswers');
                let _syncSlots = getBootBoxInputValue(syncAssistantsFormId, 'syncSlots');
                syncAssistants(_syncInformations, _syncInteractions, _syncAnswers, _syncSlots, (_err) =>  {
                    $('#div_alert').showAlert({
                        message: _err,
                        level: 'danger'
                    });
                }, () => {
                    $('#div_alert').showAlert({
                        message: '{{Synchronisation des assistants terminée}}',
                        level: 'success'
                    });
                });
            }
        }
    });
}

function addAssistantClick() {
    const addAssistantFormId = 'addAssistantForm';
    $.hideAlert();
    bootbox.confirm({
        message: getBootBoxForm(addAssistantFormId),
        callback: (result) => {
            if (result) {
                let _uri = getBootBoxInputValue(addAssistantFormId, 'uri');
                let _type = getBootBoxInputValue(addAssistantFormId, 'type');
                const newAssistant = {
                    'uri': _uri,
                    'type': _type
                }
                saveAssistant(newAssistant, (_err) => {
                        $('#div_alert').showAlert({message: _err, level: 'success'});
                    },
                    (_newAssistant) => {
                        removeAssistantCard(_newAssistant.siteId);
                        addAssistantCard(_newAssistant);
                        $('#div_alert').showAlert({message: '{{Assistant ajouté}}', level: 'success'});
                    });
            }
        }
    });
}