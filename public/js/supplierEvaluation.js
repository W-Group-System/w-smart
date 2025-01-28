document.addEventListener('DOMContentLoaded', function () {
    const scoreFields = document.querySelectorAll('.score-field');
    const totalScoreField = document.getElementById('total-score');
    const updatedScores = new Map(); // Track the fields and their entered values

    function calculateTotalScore() {
        let total = 0;

        // Sum the values of all updated fields
        updatedScores.forEach(value => {
            total += value;
        });

        // Update the total score field
        totalScoreField.value = total.toFixed(2); // Two decimal places
    }

    // Attach an event listener to each score field
    scoreFields.forEach(field => {
        field.addEventListener('input', function () {
            const value = parseFloat(this.value) || 0; // Parse value or default to 0
            updatedScores.set(this.name, value); // Update or add the value to the map
            calculateTotalScore(); // Recalculate the total
        });
    });
});


// $(document).ready(function () {
//     $('#vendor_id').on('change', function () {  // Changed 'click' to 'change'
//         var vendorId = $(this).val();  // Get the selected vendor ID

//         if (vendorId) {
//             // Send an AJAX request to fetch the corporate_name
//             $.ajax({
//                 url: '/get-vendor-name/' + vendorId,  // Use full URL path (leading slash)
//                 type: 'GET',
//                 dataType: 'json',  // Expect JSON response
//                 success: function (response) {
//                     // Update the name input field with the corporate_name
//                     $('#name').val(response.corporate_name);  // Correct response handling
//                 },
//                 error: function () {
//                     // Handle errors (e.g., vendor not found)
//                     $('#name').val('Error fetching vendor name');
//                 }
//             });
//         } else {
//             // Clear the name field if no vendor is selected
//             $('#name').val('');
//         }
//     });
// });


async function getVendorName(value) {
    // Get the input field where the corporate_name will be displayed
    let nameInput = document.getElementById("name");
    dd(route('refresh.vendor.name'));
    if (value) {
        try {
            // Make an AJAX request to fetch the corporate_name
            const response = await axios.post(
                "{{ url('refresh_vendor_name') }}", // Laravel route for the AJAX request
                {
                    vendor_id: value
                },
                {
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }
            );

            // Update the name input field with the corporate_name
            if (response.data.corporate_name) {
                nameInput.value = response.data.corporate_name;
            } 
        } catch (error) {
            nameInput.value = "Error fetching corporate name";
        }
    } else {
        // Clear the input field if no vendor is selected
        nameInput.value = "";
    }
}