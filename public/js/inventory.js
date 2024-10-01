document.addEventListener("DOMContentLoaded", function () {

    var startDateInput = document.getElementById("start-date");
    var endDateInput = document.getElementById("end-date");
    startDateInput.style.setProperty("color", "#adb5bd", "important");
    endDateInput.style.setProperty("color", "#adb5bd", "important");
    startDateInput.style.fontWeight = "300";
    endDateInput.style.fontWeight = "300";

    startDateInput.addEventListener("input", function () {
        this.style.color = this.value === "" ? "#adb5bd" : "";
    });

    endDateInput.addEventListener("input", function () {
        this.style.color = this.value === "" ? "#adb5bd" : "";
    });
    function getFormattedDate(date) {
        let year = date.getFullYear();
        let month = ("0" + (date.getMonth() + 1)).slice(-2);
        let day = ("0" + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    var today = new Date();

    startDateInput.value = getFormattedDate(today);

    endDateInput.value = getFormattedDate(today);

    fetch("/api/inventory", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify({
            start_date: startDateInput.value,
            end_date: endDateInput.value
        })
    })
    .then((response) => response.json())
    .then((data) => {
        console.log(data.data)
        if (data.status === "success") {
            initializeDynamicTable(data.data);
        } else {
            console.error("Failed to fetch inventory:", data.message);
        }
    })
    .catch((error) => {
        console.error("Error fetching inventory:", error);
    });

    var selectedStartDate

    var selectedEndDate

    startDateInput.onchange = function() {
        selectedStartDate = startDateInput.value;
    };
    endDateInput.onchange = function() {
        selectedEndDate = endDateInput.value;
    };

    var form = document.getElementById("filter-submit");

    form.addEventListener("submit", function(event) {
        event.preventDefault();
        fetch("/api/inventory", {
            method: "POST",
            headers: {
               "Content-Type": "application/json",
            },
            body: JSON.stringify({
               start_date: selectedStartDate ? selectedStartDate : startDateInput.value,
               end_date: selectedEndDate ? selectedEndDate : endDateInput.value
            })
       })
       .then((response) => response.json())
       .then((data) => {
            if (data.status === "success") {
               initializeDynamicTable(data.data);
            } else {
               console.error("Failed to fetch inventory:", data.message);
            }
       })
       .catch((error) => {
           console.error("Error fetching inventory:", error);
       });
   });

    var downloadButton = document.getElementById("downloadButton");

    var popover = new bootstrap.Popover(downloadButton, {
        html: true,
        sanitize: false,
    });

    document.body.addEventListener("click", function (event) {
        if (event.target.id === "downloadCSV") {
            alert("CSV download initiated");
        } else if (event.target.id === "downloadExcel") {
            alert("Excel download initiated");
        } else if (event.target.id === "downloadPDF") {
            alert("PDF download initiated");
        }
    });

    function initializeDynamicTable(inventoryData) {
        const rowsPerPageSelect = document.querySelector(
            "select.form-select-sm"
        );
        const tableBody = document.querySelector("tbody");
        const totalItemsText = document.querySelector(".dynamic-rows-info");
        const pagination = document.querySelector("ul.pagination");
        let currentPage = 1;
        let rowsPerPage = parseInt(rowsPerPageSelect.value);

        function renderTable() {
            tableBody.innerHTML = "";

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;
            const currentItems = inventoryData.slice(startIndex, endIndex);

            currentItems.forEach((item, index) => {

                const row = document.createElement("tr");
                row.innerHTML = `
                    <td style="text-align: center; padding: 2px 10px;">${
                        startIndex + index + 1
                    }
                        <input type="checkbox" style="margin-left: 10px;">
                    </td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.date
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.item_code
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.item_description
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.item_category
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.qty
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.uom
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.cost
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">${
                        item.usage
                    }</td>
                    <td style="text-align: center; padding: 2px 10px;">
                        <div style="position: relative;">
                            <button type="button" class="btn btn-link actionButton" data-bs-toggle="popover" data-bs-html="true"
                                aria-expanded="false" data-bs-trigger="focus" 
                                data-bs-content='
                                <div style="font-family: Inter, sans-serif; color: #79747E; text-align: center;">
                                    <button type="button" 
                                            class="btn btn-sm btn-light mt-1 modify-button" 
                                            style="display: flex; justify-content: center; width: 100%; align-items: center; border-radius: 8px; color: #79747E;"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modifyModal">
                                        Modify
                                    </button>
                                    <button class="btn btn-sm btn-light mt-1" style="display: flex; justify-content: center; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
                                        Inactive 
                                    </button>
                                </div>'>
                                <i class="bi bi-three-dots-vertical" style="color: black;"></i>
                            </button>
                        </div>
                    </td>
                `;
                tableBody.appendChild(row);
            });

            totalItemsText.textContent = `${startIndex + 1}-${Math.min(
                endIndex,
                inventoryData.length
            )} of ${inventoryData.length}`;

            initializePopovers();
        }

        function updatePagination() {
            pagination.innerHTML = "";

            const totalPages = Math.ceil(inventoryData.length / rowsPerPage);
            const prevPage = document.createElement("li");
            prevPage.classList.add(
                "page-item",
                currentPage === 1 ? "disabled" : ""
            );
            prevPage.innerHTML = `
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            `;
            prevPage.addEventListener("click", function (event) {
                event.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                    updatePagination();
                }
            });
            pagination.appendChild(prevPage);

            for (let i = 1; i <= totalPages; i++) {
                const pageItem = document.createElement("li");
                pageItem.classList.add(
                    "page-item",
                    i === currentPage ? "active" : ""
                );
                pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                pageItem.addEventListener("click", function (event) {
                    event.preventDefault();
                    currentPage = i;
                    renderTable();
                    updatePagination();
                });
                pagination.appendChild(pageItem);
            }

            const nextPage = document.createElement("li");
            nextPage.classList.add(
                "page-item",
                currentPage === totalPages ? "disabled" : ""
            );
            nextPage.innerHTML = `
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            `;
            nextPage.addEventListener("click", function (event) {
                event.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                    updatePagination();
                }
            });
            pagination.appendChild(nextPage);
        }

        rowsPerPageSelect.addEventListener("change", function () {
            rowsPerPage = parseInt(this.value);
            currentPage = 1;
            renderTable();
            updatePagination();
        });

        renderTable();
        updatePagination();
    }

    function initializePopovers() {
        const popoverElements = document.querySelectorAll(".actionButton");

        popoverElements.forEach(function (popoverElement) {
            let popoverInstance = new bootstrap.Popover(popoverElement, {
                html: true,
                sanitize: false,
                trigger: "focus",
            });

            document.addEventListener("click", function (event) {
                if (
                    !popoverElement.contains(event.target) &&
                    !popoverInstance._isWithActiveTrigger()
                ) {
                    popoverInstance.hide();
                }
            });
        });
    }
});
