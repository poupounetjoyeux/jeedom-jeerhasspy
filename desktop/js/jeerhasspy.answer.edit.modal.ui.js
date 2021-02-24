function saveAnswerClick() {
    const form = $('#answerForm')
    const answer = {
        name: getFormInputValue(form, 'name'),
        configuration: getFormInputValue(form, 'configuration'),
        isSync: getFormInputValue(form, 'isSync')
    }
    if (answerId) {
        answer.id = answerId;
    }
    saveAnswer(answer, (_err) => {
        $('#div_alertAnswer').showAlert({message: _err, level: 'danger'});
    }, (_newAnswer) => {
        removeAnswerCard(_newAnswer.id);
        addAnswerCard(_newAnswer);
        $('#div_alertAnswer').showAlert({
            message: '{{Réponse sauvegardé. Synchroniser l\'assistant pour pousser les modifications}}',
            level: 'success'
        });
    });
}

$(() => {
    if (answerId) {
        byIdAnswer(answerId, (_err) => {
            $('#div_alertAnswer').showAlert({message: _err, level: 'danger'});
        }, (_answer) => {
            const form = $('#answerForm');
            setFormInputValue(form, 'name', _answer.name);
            setFormInputValue(form, 'configuration', _answer.configuration);
            setFormInputValue(form, 'isSync', _answer.isSync);
        });
    }
});
