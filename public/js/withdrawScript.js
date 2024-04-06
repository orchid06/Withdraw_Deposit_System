document.getElementById('withdraw-method').addEventListener('change', function () {
    const selectedMethod = this.value;
    const methodOptions = this.querySelectorAll('option');
    let selectedMethodFields = null;


    methodOptions.forEach(option => {
        if (option.value === selectedMethod) {
            console.log('Data fields:', option.getAttribute('data-fields'));
            selectedMethodFields = JSON.parse(option.getAttribute('data-fields'));

        }
    });


    document.getElementById('additional-fields').innerHTML = '';


    if (selectedMethodFields) {
        selectedMethodFields.forEach(field => {
            const fieldElement = document.createElement('div');
            const capitalizedLabel = field.label_name.charAt(0).toUpperCase() + field.label_name.slice(1);
            fieldElement.innerHTML = `
                <label>${capitalizedLabel}<span class="${field.condition == 1 ? 'required' : ''}"></span></label>
                <input type="${field.input_type}" name="${field.label_name}" class="form-control" ${field.condition == 1 ? 'required' : ''}>
            `;
            fieldElement.style.marginBottom = '10px'
            document.getElementById('additional-fields').appendChild(fieldElement);
        });
    }
});