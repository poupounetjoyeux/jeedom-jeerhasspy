function loadSlots() {
    const container = getSlotsContainer();
    allSlots((_err) => {
            $('#div_alert').showAlert({message: _err, level: 'danger'});
        },
        (_slots) => {
            container.innerHTML = '';
            _slots.forEach((_slot) => {
                addSlotCard(_slot);
            });
        });
}

function renderSlotCard(_slot) {
    const card = document.createElement('div');
    card.dataset.slot_id = _slot.id;
    card.classList.add('jeeRhasspySlotCard', 'cursor', 'center', 'col-sm-2');
    card.innerHTML = `<i class="fas fa-comments text-primary" style="font-size: 36px;"></i><br>`;
    card.innerHTML += `<strong class="name">${_slot.name}</strong>`;
    card.innerHTML += '<br><div class="input-group">';
    card.innerHTML += `<a class="danger" style="padding: 0 6px;" title="{{Supprimer le Slot}}" onclick="deleteSlotClick('${_slot.id}')"><i class="fas fa-minus-circle"></i></a>`;
    card.innerHTML += `<a class="warning" style="padding: 0 6px;" title="{{Configurer le Slot}}" onclick="configureSlotClick('${_slot.id}')"><i class="fas fa-cogs"></i></a>`;
    card.innerHTML += '</div>';
    return card;
}

function addSlotCard(_slot) {
    getSlotsContainer().appendChild(renderSlotCard(_slot));
}

function removeSlotCard(_slotId) {
    const card = $(getSlotsContainer()).find('.jeeRhasspySlotCard[data-slot_id="' + _slotId + '"]');
    if (card) {
        card.remove();
    }
}

function getSlotsContainer() {
    return $('#slotsItems')[0];
}

//Events
function deleteSlotClick(_slotId) {
    $.hideAlert();
    bootbox.confirm('{{Êtes-vous sûr de vouloir supprimer ce Slot ?}}', (result) => {
        if (result) {
            deleteSlot(_slotId, (_err) => {
                    $('#div_alert').showAlert({message: _err, level: 'danger'});
                },
                () => {
                    removeSlotCard(_slotId);
                    $('#div_alert').showAlert({
                        message: '{{Suppression du Slot. Synchronisez l\'assistant pour réentrainer Rhasspy}}',
                        level: 'success'
                    });
                });
            if (coreVersion < 4.2) {
                $('.eqLogicThumbnailContainer').packery();
            }
        }
    });
}

function configureSlotClick(_slotId) {
    $('#md_modal3').dialog({title: "{{Edition du slot}}"}).load('index.php?v=d&plugin=jeerhasspy&modal=slot.edit&id=' + _slotId).dialog('open');
}

function addSlotClick() {
    $('#md_modal3').dialog({title: "{{Edition du slot}}"}).load('index.php?v=d&plugin=jeerhasspy&modal=slot.edit').dialog('open');
}