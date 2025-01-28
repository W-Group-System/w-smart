
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
    $("#addRowBtn").on('click', function() {
        // console.log('sadasd');
        
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

        $('#tbodyAddRow').append(newRow)
    })

    $("#deleteRowBtn").on('click', function() {
        
        var row = $('#tbodyAddRow').children();
        
        if (row.length > 1) {
            row.last().remove()
        }
        // $("#tbodyAddRow").children().last().remove()
        
    })

    
})