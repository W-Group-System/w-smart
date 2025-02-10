$(document).ready(function () {
    function calculateScores(table) {
        let totalScore = 0;

        // Loop through all score fields within the current table and sum their values
        $(table).find(".score-field").each(function () {
            let score = parseFloat($(this).val()) || 0;
            totalScore += score;
        });

        // Update the total score field in the same table
        $(table).find("#total-score").val(totalScore.toFixed(2));
    }

    function calculateWeightedScore(inputField, weightClass, scoreField) {
        $(inputField).on("input", function () {
            let row = $(this).closest("tr"); // Get the current row
            let rating = parseFloat($(this).val()) || 0;
            let weight = parseFloat(row.find(weightClass).data("weight")) / 100;
            let weightedScore = rating * weight;

            row.find(scoreField).val(weightedScore.toFixed(2));

            // Recalculate total score only for the current table
            let table = $(this).closest("table");
            calculateScores(table);
        });
    }

    // Apply calculation for each rating and weight within the same table
    $("table").each(function () {
        let table = $(this);
        calculateWeightedScore(table.find(".rating-field"), ".weight1", "input[name='score1']");
        calculateWeightedScore(table.find(".rating-field2"), ".weight2", "input[name='score2']");
        calculateWeightedScore(table.find(".rating-field3"), ".weight3", "input[name='score3']");
        calculateWeightedScore(table.find(".rating-field4"), ".weight4", "input[name='score4']");
        calculateWeightedScore(table.find(".rating-field5"), ".weight5", "input[name='score5']");
        calculateWeightedScore(table.find(".rating-field6"), ".weight6", "input[name='score6']");
        calculateWeightedScore(table.find(".rating-field7"), ".weight7", "input[name='score7']");
    });
});


document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".rating-field, .rating-field2, .rating-field3, .rating-field4, .rating-field5, .rating-field6, .rating-field7").forEach(input => {
        input.addEventListener("input", function() {
            let row = this.closest("tr");
            let weightClass = this.classList.contains("rating-field") 
                ? ".weight1" 
                : this.classList.contains("rating-field2") 
                ? ".weight2" 
                : this.classList.contains("rating-field3") 
                ? ".weight3" 
                : this.classList.contains("rating-field4") 
                ? ".weight4" 
                : this.classList.contains("rating-field5") 
                ? ".weight5" 
                : this.classList.contains("rating-field6") 
                ? ".weight6" 
                : ".weight7";

            let rating = parseFloat(this.value) || 0;
            let weight = parseFloat(row.querySelector(weightClass)?.getAttribute("data-weight")) || 0;
            let scoreField = row.querySelector(".score-field");

            scoreField.value = ((rating * weight) / 100).toFixed(2);
        });
    });
});

