document.addEventListener("DOMContentLoaded", function () {
    // Get the date inputs
    var startDateInput = document.getElementById("start-date");
    var endDateInput = document.getElementById("end-date");

    // Apply lighter placeholder styling
    startDateInput.style.setProperty("color", "#adb5bd", "important");
    endDateInput.style.setProperty("color", "#adb5bd", "important");

    // Placeholder text styling
    startDateInput.style.fontWeight = "300";
    endDateInput.style.fontWeight = "300";

    // Add event listener to apply the style when user types in
    startDateInput.addEventListener("input", function () {
        if (this.value === "") {
            this.style.color = "#adb5bd"; // Lighter color for placeholder
        } else {
            this.style.color = ""; // Reset for actual date input
        }
    });

    endDateInput.addEventListener("input", function () {
        if (this.value === "") {
            this.style.color = "#adb5bd";
        } else {
            this.style.color = "";
        }
    });
});
