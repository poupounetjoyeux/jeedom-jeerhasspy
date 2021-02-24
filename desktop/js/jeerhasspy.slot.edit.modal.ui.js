function saveSlotClick() {
    const form = $('#slotForm')
    const slot = {
        name: getFormInputValue(form, 'name'),
        configuration: getFormInputValue(form, 'configuration'),
        isSync: getFormInputValue(form, 'isSync')
    }
    if (slotId) {
        slot.id = slotId;
    }
    saveSlot(slot, (_err) => {
        $('#div_alertSlot').showAlert({message: _err, level: 'danger'});
    }, (_newSlot) => {
        removeSlotCard(_newSlot.id);
        addSlotCard(_newSlot);
        $('#div_alertSlot').showAlert({
            message: '{{Slot sauvegardé. Synchroniser l\'assistant pour pousser les modifications}}',
            level: 'success'
        });
    });
}

$(() => {
    if (slotId) {
        byIdSlot(slotId, (_err) => {
                $('#div_alertSlot').showAlert({message: _err, level: 'danger'});
            },
            (_slot) => {
                const form = $('#slotForm');
                setFormInputValue(form, 'name', _slot.name);
                setFormInputValue(form, 'configuration', _slot.configuration);
                setFormInputValue(form, 'isSync', _slot.isSync);
            });
    }
});