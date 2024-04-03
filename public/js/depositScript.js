document.getElementById('method').addEventListener('change', function () {
    var selectedOption = this.options[this.selectedIndex];
    var additionalFields = JSON.parse(selectedOption.getAttribute('data-fields'));
    var additionalFieldsHtml = '';

    additionalFields.forEach(function (field) {
        additionalFieldsHtml += '<div class="form-group">';
        additionalFieldsHtml += '<label for="' + field.name + '">' + field.label + '</label>';
        additionalFieldsHtml += '<input type="' + field.type + '" id="' + field.name + '" name="' + field.name + '" class="form-control">';
        additionalFieldsHtml += '</div>';
    });

    document.getElementById('additional-fields').innerHTML = additionalFieldsHtml;
});
