
function add() {
    var formfield = document.getElementById("formfield");
    var newRow = document.createElement("div");
    newRow.classList.add("row");

    var fieldNameInput = document.createElement("input");
    fieldNameInput.type = "text";
    fieldNameInput.name = "fieldname";
    fieldNameInput.classList.add("fieldname");
    fieldNameInput.placeholder = "Field Name";
    fieldNameInput.required = true;

    var fieldValueInput = document.createElement("input");
    fieldValueInput.type = "text";
    fieldValueInput.name = "fieldvalue";
    fieldValueInput.classList.add("fieldvalue");
    fieldValueInput.placeholder = "Field Value";
    fieldValueInput.required = true;
    newRow.appendChild(fieldNameInput);
    newRow.appendChild(fieldValueInput);
    formfield.appendChild(newRow);
}

function remove() {
    var formfield = document.getElementById("formfield");
    var rows = formfield.getElementsByClassName("row");
    if (rows.length > 1) {
        formfield.removeChild(rows[rows.length - 1]);
    }
}


window.onload = fetchUsersAndRedirect;
