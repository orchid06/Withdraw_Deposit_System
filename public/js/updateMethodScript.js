let existingFieldsCount = document.getElementById("existingFieldsCount");
let counter = existingFieldsCount === null || existingFieldsCount === undefined ? 0 : parseInt(existingFieldsCount.textContent);
console.log(counter);

function add() {
    const fieldsContainer = document.getElementById("fieldsContainer");
    const newRow = document.createElement("div");
    newRow.classList.add("row", "mt-4");
    newRow.innerHTML = `
        <div class="col">
            <input type="text" class="form-control" name="label_name_${counter}" placeholder="Label name">
        </div>
        <div class="col">
            <select class="form-select" name="input_type_${counter}" aria-label="Default select example">
                <option selected>Input Type</option>
                <option value="text">Text</option>
                <option value="email">Email</option>
                <option value="number">Number</option>
                <option value="textarea">Description</option>
            </select>
        </div>
        <div class="col">
            <select class="form-select" name="condition_${counter}" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <option value="0">Optional</option>
                <option value="1">Required</option>
            </select>
        </div>
        <div class="col">
            <button class="button-2 removeButton" onclick="removeRow(this)">Remove</button>
        </div>
    `;
    fieldsContainer.appendChild(newRow);
    counter++;
}


function remove() {
    const fieldsContainer = document.getElementById("fieldsContainer");
    const rows = fieldsContainer.querySelectorAll(".row");
    if (rows.length > 0) {
        fieldsContainer.removeChild(rows[rows.length - 1]);
    }
}

// Function to remove a specific row
function removeRow(button) {
    const row = button.closest(".row");
    row.parentNode.removeChild(row);
}