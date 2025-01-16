
function addRow(id)
{
    var newRow = `
            <tr>
                <td>
                    <input type="text" name="item_code[]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="text" name="item_category[]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="text" name="item_description[]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="text" name="item_quantity[]" class="form-control form-control-sm" required>
                </td>
                <td>
                    <input type="text" name="unit_of_measurement[]" class="form-control form-control-sm" required>
                </td>
            </tr>
        `;

    $('#tbodyAddRow'+id).append(newRow)
}

function deleteRow(id)
{
    var row = $('#tbodyAddRow'+id).children();
        
    if (row.length > 1) {
        row.last().remove()
    }
}

function removeFiles(id)
{
    // console.log('dasdad');
    var form = $("#deleteForm"+id)[0];

    Swal.fire({
        title: "Are you sure?",
        text: "The file will be deleted",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit()
        }
    });
    
}

$(document).ready(function() {
    $("#addRowBtnSupp").on('click', function() {        
        var newRow = `
            <tr>
                <td width="25%">
                    <input type="text" name="name[]" placeholder="Enter Name of Official Representatives" class="form-control form-control-sm">
                </td>
                <td width="25%">
                    <input type="text" name="designation[]" placeholder="Enter Designation" class="form-control form-control-sm">
                </td>
                <td width="25%">
                    <input type="text" name="contact[]" placeholder="Enter Contact Number" class="form-control form-control-sm">
                </td>
                <td width="25%">
                    <input type="email" name="email[]" placeholder="Enter Email Address" class="form-control form-control-sm">
                </td>
            </tr>
        `;

        $('#tbodyAddRow').append(newRow)
    })

    $("#deleteRowBtnSupp").on('click', function() {
        var row = $('#tbodyAddRow').children();
        if (row.length > 1) {
            row.last().remove()
        }
    })

    $("#addRowBtnSupp1").on('click', function() {    
        // console.log('asdasd');    
        var newRow = `
            <tr>
                <td width="30%">
                    <input type="text" name="owners[]" placeholder="Enter Owners/ Officers of the Company" class="form-control form-control-sm">
                </td>
                <td width="30%">
                    <input type="text" name="owners_designation[]" placeholder="Enter Designation" class="form-control form-control-sm">
                </td>
                <td width="40%">
                    <input type="text" name="address[]" placeholder="Enter Address" class="form-control form-control-sm">
                </td>
            </tr>
        `;

        $('#tbodyAddRow1').append(newRow)
    })

    $("#deleteRowBtnSupp1").on('click', function() {
        var row = $('#tbodyAddRow1').children();
        if (row.length > 1) {
            row.last().remove()
        }
    })

    $("#addRowBtnSupp2").on('click', function() {    
        // console.log('asdasd');    
        var newRow = `
            <tr>
                <td>
                    <input type="text" name="contacts[]" placeholder="Enter Contacts-Finance/ Accounting" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="contacts_designation[]" placeholder="Enter Designation" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="contact_number[]" placeholder="Enter Contact Number" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="email" name="contacts_email[]" placeholder="Enter Email Address" class="form-control form-control-sm">
                </td>
            </tr>
        `;

        $('#tbodyAddRow2').append(newRow)
    })

    $("#deleteRowBtnSupp2").on('click', function() {
        var row = $('#tbodyAddRow2').children();
        if (row.length > 1) {
            row.last().remove()
        }
    })

    $("#addRowBtnSupp3").on('click', function() {        
        var newRow = `
            <tr>
                <td>
                    <input type="text" name="company_name[]" placeholder="Enter Company Name" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="contact_person[]" placeholder="Enter Contact Person" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="tel_no[]" placeholder="Enter Telephone No." class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="terms[]" placeholder="Enter Termsss" class="form-control form-control-sm">
                </td>
            </tr>
        `;

        $('#tbodyAddRow3').append(newRow)
    })

    $("#deleteRowBtnSupp3").on('click', function() {
        var row = $('#tbodyAddRow3').children();
        if (row.length > 1) {
            row.last().remove()
        }
    })

    $("#addRowBtnSupp4").on('click', function() {        
        var newRow = `
            <tr>
                <td>
                    <input type="text" name="customer_company_name[]" placeholder="Enter Company Name" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="customer_contact_person[]" placeholder="Enter Contact Person" class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="customer_tel_no[]" placeholder="Enter Telephone No." class="form-control form-control-sm">
                </td>
                <td>
                    <input type="text" name="customer_terms[]" placeholder="Enter Terms" class="form-control form-control-sm">
                </td>
            </tr>
        `;

        $('#tbodyAddRow4').append(newRow)
    })

    $("#deleteRowBtnSupp4").on('click', function() {
        var row = $('#tbodyAddRow4').children();
        if (row.length > 1) {
            row.last().remove()
        }
    })

    $('#form_supplier_accreditation').on('submit', function(e) {
        e.preventDefault(); 

        $.ajax({
            url: $(this).attr('action'),
            method: $(this).attr('method'),
            data: new FormData(this),
            contentType: false,
            processData: false,
            success: function(response) {
                // Show success message with timer
                Swal.fire({
                    title: 'Success',
                    text: 'Form submitted successfully!',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    $('#form_supplier_accreditation')[0].reset();
                    location.reload();
                });
            },
            error: function(xhr) {
                Swal.fire('Error', 'Something went wrong!', 'error');
            }
        });
    });

    $("#addVendorBtn").on('click', function() {
        var newRow = `
            <tr>
                <td style="padding: 5px 10px;">
                    <select name="vendor_name[]" class="form-select" required>
                        <option value="">Select vendor name</option>
                    </select>
                </td>
                <td style="padding: 5px 10px;">
                    <select name="vendor_email[]" class="form-select" required>
                        <option value="">Select vendor email</option>
                    </select>
                </td>
            </tr>
        `
        
        $('#vendorTbodyRow').append(newRow);
    })

    $("#deleteVendorBtn").on('click', function() {
        
        if ($("#vendorTbodyRow").children().length > 1) 
        {
            $("#vendorTbodyRow").children().last().remove()
        }
    })

    $("#itemCheckboxAll").on('click', function() {
        $('.itemCheckbox').prop('checked', $(this).is(':checked'));
    })

    $("#fileCheckboxAll").on('click', function() {
        $('.fileCheckbox').prop('checked', $(this).is(':checked'));
    })

})