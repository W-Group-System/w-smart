document.addEventListener("DOMContentLoaded", function() {
    
    const addRowBtn = document.querySelector("#addRow");
    const deleteRowBtn = document.querySelector("#deleteRowBtn");
    const tBody = document.querySelector("#tbodyAddRow");

    addRowBtn.addEventListener('click', function() {
        
        const newRow = document.createElement('tr');

        for (let i = 0; i < 5; i++) {
            const cell = document.createElement('td');
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control form-control-sm'
            cell.appendChild(input);
            newRow.appendChild(cell);
        }

        tBody.appendChild(newRow);
    })
    
    deleteRowBtn.addEventListener('click', function() {
        
    })
})