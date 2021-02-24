function saveAssistantClick() {
    const form = $('#assistantForm');
    const assistant = {
        siteId: siteId,
        name: getFormInputValue(form, 'name'),
        parentObjectId: getFormInputValue(form, 'parentObjectId'),
        isEnable: getFormInputValue(form, 'isEnable'),
        isVisible: getFormInputValue(form, 'isVisible'),
        uri: getFormInputValue(form, 'uri'),
        syncJeedomInteractions: getFormInputValue(form, 'syncJeedomInteractions'),
        syncAnswers: getFormInputValue(form, 'syncAnswers'),
        syncSlots: getFormInputValue(form, 'syncSlots'),
        type: getFormInputValue(form, 'type')
    }
    saveAssistant(assistant, (_err) => {
            $('#div_alertAssistant').showAlert({message: _err, level: 'danger'});
        },
        (_newAssistant) => {
            removeAssistantCard(_newAssistant.siteId);
            addAssistantCard(_newAssistant);
            $('#div_alertAssistant').showAlert({message: '{{Assistant sauvegardé avec succès}}', level: 'success'});

        });
}

function advancedConfigClick() {
    $('#md_modal').dialog().load('index.php?v=d&modal=eqLogic.configure&eqLogic_id=' + eqId).dialog('open');
}

function configureRhasspyProfileClick() {
    var configureRhasspyProfileFormId = 'configRhasspyProfileForm';
    bootbox.confirm({
        message: getBootBoxForm(configureRhasspyProfileFormId),
        callback: (result) => {
            if (result) {
                const _useInternalUrl = getBootBoxInputValue(configureRhasspyProfileFormId, 'useInternalUrl');
                const _configWakeEvent = getBootBoxInputValue(configureRhasspyProfileFormId, 'configWakeEvent');
                const _configHandler = getBootBoxInputValue(configureRhasspyProfileFormId, 'configHandler');
                configureAssistantRhasspyProfile(siteId, _useInternalUrl, _configHandler, _configWakeEvent, (_err) => {
                    $('#div_alertAssistant').showAlert({message: _err, level: 'danger'});
                }, () => {
                    $('#div_alertAssistant').showAlert({
                        message: '{{Configuration de votre Rhasspy réussie}}',
                        level: 'success'
                    });
                });
            }
        }
    })
}

function syncAssistantClick() {
    const syncAssistantFormId = 'syncAssistantForm';
    bootbox.confirm({
        message: getBootBoxForm(syncAssistantFormId),
        callback: (result) => {
            if (result) {
                let _syncInformations = getBootBoxInputValue(syncAssistantFormId, 'syncInformations');
                let _syncInteractions = getBootBoxInputValue(syncAssistantFormId, 'syncInteractions');
                let _syncAnswers = getBootBoxInputValue(syncAssistantFormId, 'syncAnswers');
                let _syncSlots = getBootBoxInputValue(syncAssistantFormId, 'syncSlots');
                syncAssistant(siteId, _syncInformations, _syncInteractions, _syncAnswers, _syncSlots, (_err) => {
                    $('#div_alertAssistant').showAlert({message: _err, level: 'danger'});
                }, () => {
                    $('#div_alertAssistant').showAlert({
                        message: '{{Synchronisation de l\'assistants terminée}}',
                        level: 'success'
                    });
                });
            }
        }
    })
}

$(() => {
    if (siteId) {
        bySiteIdAssitant(siteId, (_err) => {
            $('#div_alertAssistant').showAlert({message: _err, level: 'danger'});
        }, (_assistant) => {
            eqId = _assistant.id;
            const form = $('#assistantForm');
            setFormInputValue(form, 'name', _assistant.name);
            setFormInputValue(form, 'parentObjectId', _assistant.parentObjectId);
            setFormInputValue(form, 'isEnable', _assistant.isEnable);
            setFormInputValue(form, 'isVisible', _assistant.isVisible);
            setFormInputValue(form, 'uri', _assistant.uri);
            setFormInputValue(form, 'syncJeedomInteractions', _assistant.syncJeedomInteractions);
            setFormInputValue(form, 'syncAnswers', _assistant.syncAnswers);
            setFormInputValue(form, 'syncSlots', _assistant.syncSlots);
            setFormInputValue(form, 'type', _assistant.type);
            setFormInputValue(form, 'siteId', _assistant.siteId);
            setFormInputValue(form, 'assistantVersion', _assistant.assistantVersion);
            setFormInputValue(form, 'defaultLang', _assistant.defaultLang);
            setFormInputValue(form, 'importTime', _assistant.importTime);
        });
    }
});