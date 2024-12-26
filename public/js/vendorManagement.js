document.addEventListener('DOMContentLoaded', function () {
    const soleProprietorCheckbox = document.getElementById('sole_proprietor');
    const companyNameDiv = document.getElementById('company_name');
    const companyNameInput = companyNameDiv.querySelector('input'); 

    companyNameDiv.style.display = 'none'; 

    soleProprietorCheckbox.addEventListener('change', function () {
        if (soleProprietorCheckbox.checked) {
            companyNameDiv.style.display = 'block'; 
        } else {
            companyNameDiv.style.display = 'none'; 
            companyNameInput.value = '';  
        }
    });
});


function addRow() {
    const tableBody = document.querySelector('#contactDetailsTable tbody');
    const rowCount = tableBody.rows.length;
    
    if (rowCount >= 1) {
        const newRow = document.createElement('tr');
        newRow.classList.add('contactRow');
        newRow.innerHTML = `
            <td><input type="text" name="work_email[]" class="form-control form-control-sm" placeholder="Enter Work Email"></td>
            <td><input type="text" name="phone_no[]" class="form-control form-control-sm" placeholder="Enter Phone Number"></td>
            <td><input type="text" name="fax_no[]" class="form-control form-control-sm" placeholder="Enter Fax Number"></td>
            <td><input type="text" name="alternative_phone[]" class="form-control form-control-sm" placeholder="Enter Alternate Phone Number"></td>
            <td><input type="text" name="address[]" class="form-control form-control-sm" placeholder="Enter Address"></td>
            <td><input type="text" name="contact_person[]" class="form-control form-control-sm" placeholder="Enter Contact Person"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
    }
}

function removeRow(button) {
    const row = button.closest('tr');
    const tableBody = document.querySelector('#contactDetailsTable tbody');
    
    if (tableBody.rows.length > 1) {
        row.remove();
    } else {
        alert('At least one row is required!');
    }
}

document.addEventListener("DOMContentLoaded", function() {
    function addRow(vendorId) {
        const tableBody = document.querySelector(`#contactDetailsTable${vendorId} tbody`);
        if (!tableBody) return;

        const newRow = document.createElement('tr');
        newRow.classList.add('contactRow');
        newRow.innerHTML = `
            <td><input type="text" name="work_email[]" class="form-control form-control-sm" placeholder="Enter Work Email"></td>
            <td><input type="text" name="phone_no[]" class="form-control form-control-sm" placeholder="Enter Phone Number"></td>
            <td><input type="text" name="fax_no[]" class="form-control form-control-sm" placeholder="Enter Fax Number"></td>
            <td><input type="text" name="alternative_phone[]" class="form-control form-control-sm" placeholder="Enter Alternate Phone Number"></td>
            <td><input type="text" name="address[]" class="form-control form-control-sm" placeholder="Enter Address"></td>
            <td><input type="text" name="contact_person[]" class="form-control form-control-sm" placeholder="Enter Contact Person"></td>
            <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">Remove</button></td>
        `;
        tableBody.appendChild(newRow);
    }

    function removeRow(button) {
        const row = button.closest('tr');
        if (row) {
            row.remove();
        }
    }

    document.querySelectorAll('[id^="contactDetailsTable"]').forEach(table => {
        const vendorId = table.id.replace('contactDetailsTable', ''); 
        const addButton = document.querySelector(`button[onclick="addRow()${vendorId}"]`);
        if (addButton) {
            addButton.addEventListener('click', () => addRow(vendorId));
        }
    });

    window.removeRow = removeRow;
});


document.addEventListener("DOMContentLoaded", function() {
    const checkboxes = document.querySelectorAll('.sole_proprietor');
    
    checkboxes.forEach(function(checkbox) {
        const vendorId = checkbox.getAttribute('data-vendor-id');  
        const companyNameDiv = document.querySelector(`.company_name[data-vendor-id="${vendorId}"]`); 
        const companyNameInput = companyNameDiv.querySelector('input');

        function toggleCompanyVisibility() {
            if (checkbox.checked) {
                companyNameDiv.style.display = 'block'; 
            } else {
                companyNameDiv.style.display = 'none'; 
                companyNameInput.value = '';
            }
        }

        toggleCompanyVisibility();

        checkbox.addEventListener('change', toggleCompanyVisibility);
    });
});
