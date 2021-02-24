function getBootBoxForm(_formId) {
    return document.getElementById(_formId).parentElement.innerHTML;
}

function getBootBoxInputValue(_formId, _inputName) {
    return getFormInputValue($('.bootbox-body #' + _formId), _inputName);
}

function getFormInputValue(_form, _inputName) {
    const input = $(_form).find('[name="' + _inputName + '"]');
    if (input.prop('type') === 'checkbox') {
        return input.is(':checked');
    }
    return input.val();
}

function setFormInputValue(_form, _inputName, _value) {
    const input = $(_form).find('[name="' + _inputName + '"]');
    if (input.prop('type') === 'checkbox') {
        input.prop('checked', _value);
    }
    input.val(_value);
}