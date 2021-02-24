function loadInteractions() {
    const table = getInteractionTable();
    allInteractions((_interacions) => {
        table.innerHTML = '';
        _interacions.forEach((interaction) => {
            addInteractionRow(interaction);
        });
    });
}

function renderInteractionRow(_interaction) {
    const row = document.createElement('tr');
    row.classList.add('jeeRhasspyInteractionRow');
    row.dataset.interaction_id = _interaction.id;
    row.innerHTML = `<td>${_interaction.name}</td>`;
    row.innerHTML += `<td>${_interaction.queriesCount}</td>`;
    row.innerHTML += `<td><input type="checkbox" name="ignore" ${_interaction.ignore ? 'checked' : ''} /></td>`;
    return row;
}

function addInteractionRow(_assistant) {
    getInteractionTable().appendChild(renderInteractionRow(_assistant));
}

function getInteractionTable() {
    return $('#interactionsContainer tbody')[0];
}

//Events:
function saveInteractionClick() {
    const toSave = [];
    $('.jeeRhasspyInteractionRow').each((_, interactionRow) => {
        const ignore = getFormInputValue($(interactionRow), 'ignore');
        const interaction = {
            id: interactionRow.dataset.interaction_id,
            ignore: ignore
        }
        toSave.push(interaction);
    });
    saveInteractions(toSave, (_interactions) => {
        const table = getInteractionTable();
        table.innerHTML = '';
        _interactions.forEach((interaction) => {
            addInteractionRow(interaction);
        });
        $('#div_alert').showAlert({message: '{{Sauvegarde des interactions réussie}}', level: 'success'});
    });

}