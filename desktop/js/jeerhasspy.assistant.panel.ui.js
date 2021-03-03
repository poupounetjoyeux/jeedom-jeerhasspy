function loadAssistants() {
    const container = getAssistantsContainer();
    allAssistants((_err) => {
            $('#div_alert').showAlert({message: _err, level: 'danger'});
        },
        (_assistants) => {
            container.innerHTML = '';
            _assistants.forEach((_assistant) => {
                addAssistantCard(_assistant);
            });
        });
}

function renderAssistantCard(_assistant) {
    const card = document.createElement('div');
    card.dataset.site_id = _assistant.siteId;
    card.classList.add('jeeRhasspyAssistantCard', 'cursor', 'center', 'col-sm-2');
    card.innerHTML = `<i class="fas fa-microphone${_assistant.isMaster ? '' : '-alt'}" style="font-size: 36px;"></i><br>${_assistant.type}<br>`;
    card.innerHTML += `<span class="name">${_assistant.name}</span><br>`;
    card.innerHTML += `<strong class="name">${_assistant.siteId}</strong>`;
    card.innerHTML += '<br><div class="input-group">';
    card.innerHTML += `<a class="danger" style="padding: 0 6px;" title="{{Supprimer l\'assistant}}" onclick="deleteAssistantClick('${_assistant.siteId}')"><i class="fas fa-minus-circle"></i></a>`;
    card.innerHTML += `<a class="warning" style="padding: 0 6px;" title="{{Configurer l\'assistant}}" onclick="assistantConfigureClick('${_assistant.siteId}')"><i class="fas fa-cogs"></i></a>`;
    card.innerHTML += `<a class="info" style="padding: 0 6px;" title="{{Test TTS}}" onclick="speakTestClick('${_assistant.siteId}')"><i class="fas fa-headphones"></i></a>`;
    card.innerHTML += `<a class="success" style="padding: 0 6px;" title="{{Ouvrir l\'interface de Rhasspy}}" onclick="openInterfaceClick('${_assistant.uri}')"><i class="fas fa-server"></i></a>`;
    card.innerHTML += '</div>';
    return card;
}

function addAssistantCard(_assistant) {
    getAssistantsContainer().appendChild(renderAssistantCard(_assistant));
}

function removeAssistantCard(_siteId) {
    const card = $(getAssistantsContainer()).find('.jeeRhasspyAssistantCard[data-site_id="' + _siteId + '"]');
    if (card) {
        card.remove();
    }
}

function getAssistantsContainer() {
    return $('#assistantsItems')[0];
}

//Events:
function assistantConfigureClick(_siteId) {
    $('#md_modal3').dialog({title: "{{Edition de l'équipement}}"}).load('index.php?v=d&plugin=jeerhasspy&modal=assistant.edit&siteId=' + _siteId).dialog('open');
}

function deleteAssistantClick(_siteId) {
    $.hideAlert();
    bootbox.confirm('{{Êtes-vous sûr de vouloir supprimer cet assistant ?}}', (result) => {
        if (result) {
            deleteAssistant(_siteId, (_err) => {
                    $('#div_alert').showAlert({message: _err, level: 'danger'});
                },
                () => {
                    removeAssistantCard(_siteId);
                    $('#div_alert').showAlert({message: '{{Suppression de l\'assistant réussie}}', level: 'success'});
                });
            if (coreVersion < 4.2) {
                $('.eqLogicThumbnailContainer').packery();
            }
        }
    });
}

function speakTestClick(_siteId) {
    testAssistant(_siteId, (_err) => {
            $('#div_alert').showAlert({message: _err, level: 'danger'});
        },
        () => {
            $('#div_alert').showAlert({message: '{{Test TTS envoyé}}', level: 'success'});
        });
}

function openInterfaceClick(_uri) {
    $.hideAlert();
    window.open(_uri).focus();
}