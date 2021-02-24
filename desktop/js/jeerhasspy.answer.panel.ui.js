function loadAnswers() {
    const container = getAnswersContainer();
    allAnswers((_err) => {
            $('#div_alert').showAlert({message: _err, level: 'danger'});
        },
        (_answers) => {
            container.innerHTML = '';
            _answers.forEach((_answer) => {
                addAnswerCard(_answer);
            });
        });
}

function renderAnswerCard(_answer) {
    const card = document.createElement('div');
    card.dataset.answer_id = _answer.id;
    card.classList.add('jeeRhasspyAnswerCard', 'cursor', 'center', 'col-sm-2');
    card.innerHTML = `<i class="fas fa-question-circle text-primary" style="font-size: 36px;"></i><br>`;
    card.innerHTML += `<strong class="name">${_answer.name}</strong>`;
    card.innerHTML += '<br><div class="input-group">';
    card.innerHTML += `<a class="danger" style="padding: 0 6px;" title="{{Supprimer la réponse}}" onclick="deleteAnswerClick('${_answer.id}')"><i class="fas fa-minus-circle"></i></a>`;
    card.innerHTML += `<a class="warning" style="padding: 0 6px;" title="{{Configurer la réponse}}" onclick="configureAnswerClick('${_answer.id}')"><i class="fas fa-cogs"></i></a>`;
    card.innerHTML += '</div>';
    return card;
}

function addAnswerCard(_answer) {
    getAnswersContainer().appendChild(renderAnswerCard(_answer));
}

function removeAnswerCard(_answerId) {
    const card = $(getAnswersContainer()).find('.jeeRhasspyAnswerCard[data-answer_id="' + _answerId + '"]');
    if (card) {
        card.remove();
    }
}

function getAnswersContainer() {
    return $('#answersItems')[0];
}

//Events
function deleteAnswerClick(_answerId) {
    $.hideAlert();
    bootbox.confirm('{{Êtes-vous sûr de vouloir supprimer cet réponse ?}}', (result) => {
        if (result) {
            deleteAnswer(_answerId, (_err) => {
                    $('#div_alert').showAlert({message: _err, level: 'danger'});
                },
                () => {
                    removeAnswerCard(_answerId);
                    $('#div_alert').showAlert({
                        message: '{{Suppression de la réussie. Synchronisez l\'assistant pour réentrainer Rhasspy}}',
                        level: 'success'
                    });
                });
            if (coreVersion < 4.2) {
                $('.eqLogicThumbnailContainer').packery();
            }
        }
    });
}

function configureAnswerClick(_answerId) {
    $('#md_modal3').dialog({title: "{{Edition de la réponse}}"}).load('index.php?v=d&plugin=jeerhasspy&modal=answer.edit&id=' + _answerId).dialog('open');
}

function addAnswerClick() {
    $('#md_modal3').dialog({title: "{{Edition de la réponse}}"}).load('index.php?v=d&plugin=jeerhasspy&modal=answer.edit').dialog('open');
}