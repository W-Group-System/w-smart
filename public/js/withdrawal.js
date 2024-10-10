document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submitRequestWithdraw");
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");
    const subsidiary = document.getElementById("subsidiary");
    const subsidiary_id = document.getElementById("usersubsidiaryid").value;
    const rowsPerPageSelect = document.querySelector("select.form-select-sm");
    const tableBody = document.querySelector("tbody");
    const totalItemsText = document.querySelector(".dynamic-rows-info");
    const pagination = document.querySelector("ul.pagination");
    const form = document.getElementById("filter-submit");
    const downloadButton = document.getElementById("downloadButton");
    const searchInput = document.getElementById("searchInput");   
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value, 10) || 10;
    let selectedText = subsidiary.selectedOptions[0].text;
    subsidiary.addEventListener("change", function () {
        selectedText = subsidiary.selectedOptions[0].text; 
    });

    function generateItemCode() {
        const prefix = "WITHDRAW";
        const datePart = new Date()
            .toISOString()
            .split("T")[0]
            .replace(/-/g, "");
        const randomPart = Math.floor(Math.random() * 90000) + 10000;
        return `${prefix}-${datePart}-${randomPart}`;
    }

    function validateItems() {
        const table = document.getElementById("itemsTable");
        const rows = table.getElementsByTagName("tbody")[0].rows;
        let hasValidItems = false;

        // Ensure the submit button is correctly referenced
        const submitButton = document.getElementById("submitRequestWithdraw");

        Array.from(rows).forEach((row) => {
            const itemCode = row.querySelector("#itemCodeInput").value;
            const uomCell = row.querySelector("#uom");
            const reasonCell = row.querySelector("#reason");
            const qtyCell = row.querySelector("#requestedQty");

            const uom = uomCell ? uomCell.textContent.trim() : '';
            const reason = reasonCell ? reasonCell.textContent.trim() : '';
            const qty = qtyCell ? parseFloat(qtyCell.textContent.trim()) : 0;

            if (itemCode && uom && reason && qty > 0) {
                hasValidItems = true;
            }
        });

        submitButton.disabled = !hasValidItems;
    }

    function getFormattedDate(date) {
        let year = date.getFullYear();
        let month = ("0" + (date.getMonth() + 1)).slice(-2);
        let day = ("0" + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    const today = new Date();
    startDateInput.value = getFormattedDate(today);
    endDateInput.value = getFormattedDate(today);
    startDateInput.style.color = "#adb5bd";
    endDateInput.style.color = "#adb5bd";
    startDateInput.style.fontWeight = "300";
    endDateInput.style.fontWeight = "300";

    [startDateInput, endDateInput].forEach(input => {
        input.addEventListener("input", function () {
            this.style.color = this.value === "" ? "#adb5bd" : "";
        });
    });

    document
        .getElementById("itemCodeInput")
        .addEventListener("blur", function (e) {
            e.preventDefault();
            const itemCode = e.target.value;
            if (itemCode) {
                fetchItemDetails(itemCode, subsidiary_id, e.target);
                validateItems();
            }
        });

    function fetchItemDetails(itemCode, subsidiaryId, targetCell) {
        const row = targetCell.closest("tr");
        axios
            .get(`/api/inventory/search-item`, {
                params: {
                    item_code: itemCode,
                    subsidiary_id: subsidiaryId,
                },
            })
            .then((response) => {
                if (response.data.status === "success" && response.data.data) {
                    const item = response.data.data;
                    
                    row.querySelector("#itemDescription").textContent =
                        item.item_description;
                    row.querySelector("#itemCategory").textContent =
                        item.item_category;
                    row.querySelector("#requestedQty").textContent = item.qty;
                    const qtyCell = row.querySelector("#requestedQty");
                    const maxQty = parseFloat(item.qty);
                    qtyCell.contentEditable = "true";
                    qtyCell.addEventListener("input", function () {
                        const currentQty = parseFloat(qtyCell.textContent);
                        if (currentQty > maxQty) {
                            qtyCell.textContent = maxQty;
                            alert(`Maximum allowed quantity is ${maxQty}`);
                        }
                    });
                    validateItems();
                } else if (response.data.status === "warning") {
                    alert(
                        `${response.data.message} Please check the correct subsidiary.`
                    );
                } else {
                    alert("Item not found in the inventory.");
                }
            })
            .catch((error) => {
                row.querySelector("#itemDescription").textContent = '';
                row.querySelector("#itemCategory").textContent = '';
                row.querySelector("#uom").textContent = '';
                row.querySelector("#releasedQty").textContent = '';
                console.error("Error fetching item details:", error);
                alert("Failed to fetch item details. Please try again.");
            });
    }

    document.getElementById('itemCodeInput').addEventListener('input', async (e) => {
        
        const searchTerm = e.target.value.trim();
        if (searchTerm.length > 1) {
            const url = `/api/inventory/suggestions`;
            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        subsidiaryId: subsidiary_id,
                        searchTerm: searchTerm 
                    }),
                });
                if (!response.ok) {
                   throw new Error('Failed to fetch data');
                }

                const data = await response.json();
                const suggestions = document.getElementById('itemSuggestions');
                suggestions.innerHTML = '';

                data.data.forEach(item => {
                   const option = document.createElement('option');
                   option.value = item.item_code;
                   suggestions.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching items:', error);
            }
        }
    });

    document.getElementById('reason').addEventListener('input', async (e) => {
        e.preventDefault();
        validateItems();
    });

    document.getElementById('uom').addEventListener('input', async (e) => {
        e.preventDefault();
        validateItems();
    });

    async function fetchWithdrawal(page, search) {

        await fetch(`/api/inventory/withdraw?page=${page}&per_page=${rowsPerPage}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                start_date: startDateInput.value,
                end_date: endDateInput.value,
                subsidiaryid: subsidiary_id,
            })
        })
        .then((response) => response.json())
        .then((data) => {
            console.log(data.data)
            if (data.data === "No records found") {

                initializeDynamicTable(data.data, data.pagination.total_items);
                updatePagination(data.pagination);
            } else {
                initializeDynamicTable(data.data, data.pagination.total_items);
                updatePagination(data.pagination);
            }
        })
        .catch((error) => {
            console.error("Error fetching inventory:", error);
        });
    }

    
    fetchWithdrawal(currentPage);

    
    function initializeDynamicTable(inventoryData, totalPages) {
        renderTable(inventoryData, totalPages);
        initializePopovers();
    }

    function renderTable(inventoryData, totalPages) {
        tableBody.innerHTML = "";
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const currentItems = inventoryData.slice(startIndex, endIndex);

        currentItems.forEach((item, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td style="text-align: center; padding: 2px 10px;">${item.id}
                    <input type="checkbox" style="margin-left: 10px;">
                </td>
                <td style="text-align: center; padding: 2px 10px;">${item.created_at}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.requestor_name}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.request_number}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.item_code}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.item_description}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.requested_qty}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.uom}</td>
                <td style="text-align: center; padding: 2px 10px;">Pending</td>
                <td style="text-align: center; padding: 2px 10px;">${item.reason}</td>
                <td style="text-align: center; padding: 2px 10px;">
                    <span class="badge bg-${Number(item.status) === 0 ? 'danger' : 'success'}">
                        ${Number(item.status) === 0 ? 'Pending' : 'Approved'}
                    </span>
                </td>
            `;
            tableBody.appendChild(row);
        });

        totalItemsText.textContent = `${startIndex + 1}-${Math.min(
            endIndex,
            inventoryData.length
        )} of ${totalPages}`;
    }

    function updatePagination(paginationData) {
        pagination.innerHTML = ""; 

        if (!paginationData) {
            console.error("Pagination data is undefined.");
            return;
        }

        const totalPages = paginationData.total_pages || 1; 
        const currentPage = paginationData.current_page || 1;

        // Create Previous button
        const prevPage = document.createElement("li");
        prevPage.classList.add("page-item");
        if (currentPage === totalPages) {
            prevPage.classList.add("disabled");
        }
        prevPage.innerHTML = `
            <a class="page-link" href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        `;
        prevPage.addEventListener("click", function (event) {
            event.preventDefault();
            if (currentPage > 1) {
                fetchWithdrawal(currentPage - 1);
            }
        });
        pagination.appendChild(prevPage);

        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement("li");
            pageItem.classList.add("page-item");
            if (i === currentPage) {
                pageItem.classList.add("active");
            }
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener("click", function (event) {
                event.preventDefault();
                fetchWithdrawal(i);
            });
            pagination.appendChild(pageItem);
        }

        // Create Next button
        const nextPage = document.createElement("li");
        nextPage.classList.add("page-item");
        if (currentPage === totalPages) {
            nextPage.classList.add("disabled");
        }
        nextPage.innerHTML = `
            <a class="page-link" href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        `;
        nextPage.addEventListener("click", function (event) {
            event.preventDefault();
            if (currentPage < totalPages) {
                fetchWithdrawal(currentPage + 1);
            }
        });
        pagination.appendChild(nextPage);
    }

    
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        fetchWithdrawal(currentPage);
    });

    
    rowsPerPageSelect.addEventListener("change", function () {
        rowsPerPage = parseInt(this.value, 10);
        currentPage = 1; 
        fetchWithdrawal(currentPage);
    });

   
    const popover = new bootstrap.Popover(downloadButton, {
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

    function initializePopovers() {
        const popoverElements = document.querySelectorAll(".actionButton");
        popoverElements.forEach(function (popoverElement) {
            let popoverInstance = new bootstrap.Popover(popoverElement, {
                html: true,
                sanitize: false,
                trigger: "focus",
            });

            document.addEventListener("click", function (event) {
                if (!popoverElement.contains(event.target) && !popoverInstance._isWithActiveTrigger()) {
                    popoverInstance.hide();
                }
            });
        });
    }

    searchInput.addEventListener("input", function () {
        const searchTerm = this.value;  
        fetchInventory(currentPage, searchTerm);
    });


    document.getElementById('addWithdraw').addEventListener('click', (e) => {
        e.preventDefault();

        const today = new Date().toISOString().split('T')[0];
        const userId = document.getElementById('userId').value;
        const userName = document.getElementById('userName').value;
        const subsidiary = document.getElementById('usersubsidiary').value;
        const subsidiaryid = document.getElementById('usersubsidiaryid').value;
        document.getElementById('withdrawalDate').value = today;
        document.getElementById('requestNumber').value = generateItemCode();
        document.getElementById('requestName').value = userName;
        document.getElementById('subsidiary').value = subsidiary;
        document.getElementById('subsidiaryid').value = subsidiaryid;
        validateItems();
        
    });

    document.getElementById('addRowBtn').addEventListener('click', function(e) {
    	e.preventDefault();
        const newRow = `
            <tr>
                <td contenteditable="true">
                    <div style="position: relative;">
                        <input type="text" id="itemCodeInput" list="itemSuggestions" class="form-control form-control-sm" placeholder="Enter Item Code" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;">
                        <datalist id="itemSuggestions"></datalist>
                    </div>
                </td>
                <td contenteditable="false" id="itemDescription" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                <td contenteditable="false" id="itemCategory" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                <td contenteditable="true" id="uom"></td>
                <td contenteditable="true" id="reason"></td>
                <td contenteditable="true" id="requestedQty"></td>
                <td contenteditable="true" id="releasedQty"></td>
            </tr>
        `;
        
        document.getElementById('itemTableBody').insertAdjacentHTML('beforeend', newRow);
    });

    submitButton.addEventListener("click", function () {
        const requestorName = document.getElementById('userName').value;
        const requestorNumber = document.getElementById('requestNumber').value; 
        const requestorId = document.getElementById('userId').value; 
        const subsidiaryId = document.getElementById('usersubsidiaryid').value; 
        const subsidiary = document.getElementById('usersubsidiary').value; 
        const remarks = document.getElementById("remarks").textContent;
        const items = Array.from(
            document.querySelectorAll("#itemsTable tbody tr")
        )
            .map((row) => {
                return {
                    item_code: row
                        .querySelector("#itemCodeInput")
                        .value,
                    qty: parseFloat(
                        row.querySelector("#requestedQty").textContent.trim()
                    ),
                    item_description: 
                        row.querySelector("#itemDescription").textContent.trim()
                    ,
                    item_category:
                        row.querySelector("#itemCategory").textContent.trim()
                    ,
                    uom:
                        row.querySelector("#uom").textContent.trim()
                    ,
                    reason:
                        row.querySelector("#reason").textContent.trim()
                    ,
                };
            })
            .filter((item) => item.item_code && item.qty > 0);

        if (items.length === 0) {
            alert("Please add at least one valid item before submitting.");
            return;
        }

        axios
            .post("/api/inventory/withdraw/request", {
                requestor_name: requestorName,
                requestor_number: requestorNumber,
                requestor_id: requestorId,
                items: items,
                remarks: remarks,
                subsidiaryid: subsidiaryId,
                subsidiaryname: subsidiary,
            })
            .then((response) => {
                alert(response.data.message || "Withdraw request submitted.");

                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("inventoryWithdrawalModal"));
                requestTransferModal.hide();
                fetchWithdrawal();
                clearTransferModal();
                document
                    .querySelectorAll(".modal-backdrop")
                    .forEach((el) => el.remove());
                document.body.classList.remove("modal-open");
                document.body.style = "";
            })
            .catch((error) => {
                alert(
                    "Failed to submit the transfer request. Please try again."
                );
                console.error(error);
            });
    });

    function clearTransferModal() {
        const tableBody = document
            .getElementById("itemsTable")
            .getElementsByTagName("tbody")[0];
        const rows = tableBody.getElementsByTagName("tr");

        Array.from(rows).forEach((row) => {
            row.querySelector("#itemCodeInput").value = "";
            row.querySelector("#itemDescription").textContent = "";
            row.querySelector("#itemCategory").textContent = "";
            row.querySelector("#uom").textContent = "";
            row.querySelector("#reason").textContent = "";
            row.querySelector("#requestedQty").textContent = "";
            row.querySelector("#releasedQty").textContent = "";
        });

        document.getElementById("remarks").value = "";
    }

    validateItems()
});
