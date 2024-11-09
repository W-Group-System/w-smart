document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submitRequestWithdraw");
    const returnSubmitButton = document.getElementById("submitRequestReturn");
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
/*    let selectedText = subsidiary.selectedOptions[0].text;
    subsidiary.addEventListener("change", function () {
        selectedText = subsidiary.selectedOptions[0].text; 
    });*/

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
        const submitButton = document.getElementById('submitRequestWithdraw');
        const rows = document.querySelectorAll('#itemTableBody tr');
        let allFieldsFilled = true;
    
        rows.forEach(row => {
            const itemCode = row.querySelector(".itemCodeInput")?.value.trim();
            const uom = row.querySelector('.uom-dropdown')?.value;
            const reason = row.querySelector('.reason')?.textContent.trim();
            const qty = row.querySelector('.requestedQty')?.textContent.trim();
    
            if (!itemCode || !uom || !reason || qty < 0) {
                allFieldsFilled = false;
            }
        });
        
        submitButton.disabled = !allFieldsFilled;
    }

    /*function validateItems() {
        const table = document.getElementById("itemsTable");
        const rows = table.getElementsByTagName("tbody")[0].rows;
        let hasValidItems = false;

        // Ensure the submit button is correctly referenced
        const submitButton = document.getElementById("submitRequestWithdraw");

        Array.from(rows).forEach((row) => {
            const itemCode = row.querySelector(".itemCodeInput").value;
            const uomCell = row.querySelector(".uom");
            const reasonCell = row.querySelector(".reason");
            const qtyCell = row.querySelector(".requestedQty");

            const uom = uomCell ? uomCell.textContent.trim() : '';
            const reason = reasonCell ? reasonCell.textContent.trim() : '';
            const qty = qtyCell ? parseFloat(qtyCell.textContent.trim()) : 0;

            if (itemCode && uom && reason && qty > 0) {
                hasValidItems = true;
            }
        });

        submitButton.disabled = !hasValidItems;
    }*/

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

    const itemCodeInputs = document.getElementsByClassName("itemCodeInput");

    Array.from(itemCodeInputs).forEach((input) => {
        input.addEventListener("blur", function (e) {
            e.preventDefault();
            const itemCode = e.target.value;
            if (itemCode) {
                fetchItemDetails(itemCode, subsidiary_id, e.target);
                validateItems();
            }
        });
    });

    function returnFetchItemDetails(itemCode, subsidiaryId, targetCell) {
        const row = targetCell.closest("tr");
        axios
            .post(`/api/return/search`, {
                request_id: itemCode,
                subsidiary_id: subsidiaryId,
            })
            .then((response) => {
                if (response.data.status === "success" && response.data.data) {
                    const item = response.data.data;
                    document.getElementById("returnItemCode").textContent = item[0].item_code;
                    document.getElementById("returnItemDescription").textContent = item[0].item_description;
                    document.getElementById("returnItemCategory").textContent = item[0].category;
                    const uomId = document.getElementById("uomId").textContent = item[0].uom_id;
                    const uomDropdown = document.getElementById("return-uom-dropdown");
                    const qtyCell = document.getElementById("returnQty");
                    const withdrewQty = document.getElementById("withdrewQty");
                    const maxQty = parseFloat(item[0].released_qty) || 0;
                    withdrewQty.textContent = item[0].primary_qty.toFixed(2);
                    withdrewQty.dataset.maxQty = item[0].primary_qty.toFixed(2);
                    qtyCell.textContent = item[0].primary_qty.toFixed(2);
                    row.dataset.uomId = item[0].uom_id;
                    row.dataset.baseQty = maxQty;
                    row.dataset.primaryValue = item[0].uomp_value || 1;
                    row.dataset.secondaryValue = item[0].uoms_value|| 1;
                    row.dataset.tertiaryValue = item[0].uomt_value || 1;
                    qtyCell.contentEditable = "true";
                    returnPopulateUOMOptions(
                        item[0].uomp || "Default UOM",
                        item[0].uoms || null,
                        item[0].uomt || null,
                        uomDropdown,
                        row
                    );
                    returnValidateItems();
                } else if (response.data.status === "warning") {
                    showAlert(`${response.data.message} Please check the correct subsidiary.`);
                } else {
                    showAlert("Item not found in the inventory.");
                }
            })
            .catch((error) => {
                console.error("Error fetching item details:", error);
                showAlert("An error occurred while fetching item details.");
            });
    }

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
                    row.querySelector(".itemDescription").textContent = item.item_description;
                    row.querySelector(".itemCategory").textContent = item.item_category;
    
                    const uomDropdown = row.querySelector(".uom-dropdown");
                    populateUOMOptions(item.uomp, item.uoms, item.uomt, uomDropdown);
                        
                    const qtyCell = row.querySelector(".requestedQty");
                    const maxQty = parseFloat(item.qty);
                    qtyCell.textContent = maxQty.toFixed(2);
                    qtyCell.dataset.maxQty = maxQty;
    
                    row.dataset.uomId = item.uom_id;
                    row.dataset.baseQty = maxQty;
                    row.dataset.primaryValue = item.primaryUOMValue || 1;
                    row.dataset.secondaryValue = item.secondaryUOMValue || 1;
                    row.dataset.tertiaryValue = item.tertiaryUOMValue || 1;
    
                    qtyCell.contentEditable = "true";
                    validateItems();
                } else if (response.data.status === "warning") {
                    alert(`${response.data.message} Please check the correct subsidiary.`);
                } else {
                    alert("Item not found in the inventory.");
                }
            })
            .catch((error) => {
                console.error("Error fetching item details:", error);
                alert("An error occurred while fetching item details.");
            });
    }
    const newItemCodeInput = document.querySelector('#itemTableBody tr:last-child .itemCodeInput');
    newItemCodeInput.addEventListener('input', async (e) => {
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

    const reasonInputs = document.getElementsByClassName('reason');

    Array.from(reasonInputs).forEach(input => {
        input.addEventListener('input', async (e) => {
            e.preventDefault();
            validateItems(); 
        });
    });

    const uomInputs = document.getElementsByClassName('uom');

    Array.from(uomInputs).forEach(input => {
        input.addEventListener('input', async (e) => {
            e.preventDefault();
            validateItems(); 
        });
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
        const currentItems = inventoryData.slice(0, rowsPerPage);

        currentItems.forEach((item, index) => {
            let statusBadge;
            if (item.status === 0 && item.approver_name) {
                statusBadge = `For Approval: ${item.approver_name}`;
            }
            if (item.status === 1 && item.requestor_name) {
                statusBadge = `For Receiving: ${item.requestor_name}`;
            }
            if (item.status === 2) {
                statusBadge = `Transaction Close`;
            }
            if (item.status === 4) {
                statusBadge = `Decline`;
            }
            if (item.status === 5) {
                statusBadge = `Not Received`;
            }
            if (item.status === 6) {
                statusBadge = `All items returned`;
            }
            const updatedAt = item.status >= 2 ? item.updated_at : 'Pending';
            const row = document.createElement("tr");
            row.classList.add("clickable-row");
            row.dataset.transactId = item.id;
            row.dataset.status = item.status;
            row.dataset.requesterId = item.requestor_id;
            row.dataset.approverId = item.approver_id;
            row.dataset.releasedQty = item.released_qty;
            row.dataset.remarks = item.remarks;
            row.innerHTML = `
                <td style="text-align: center; padding: 2px 10px;">${item.id}
                </td>
                <td style="text-align: center; padding: 2px 10px;">${item.created_at}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.requestor_name}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.request_number}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.item_code}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.item_description}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.requested_qty}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.released_qty}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.uomp}</td>
                <td style="text-align: center; padding: 2px 10px;">${updatedAt}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.reason}</td>
                <td style="text-align: center; padding: 2px 10px;">
                    <span class="badge bg-${item.status === 2 || item.status === 6 ? "success" : item.status === 1 || item.status === 4 || item.status === 5 ? "primary" : "danger"}">
                        ${statusBadge}
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

    document.getElementById('addWithdraw').addEventListener('click', (e) => {
        e.preventDefault();
        const withdrawalModal = new bootstrap.Modal(document.getElementById("inventoryWithdrawalModal"));
        withdrawalModal.show();
        
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
        getApprovers();
    
    });

    function populateUOMOptions(primaryUOM, secondaryUOM, tertiaryUOM, dropdown) {
        dropdown.innerHTML = '';
        
        const uomOptions = [
            { label: primaryUOM || 'Primary', value: 'primary'|| 'Primary' },
            { label: secondaryUOM || 'Secondary', value: 'secondary' || 'Secondary' }
        ];
    
        if (tertiaryUOM) {
            uomOptions.push({ label: tertiaryUOM, value: 'tertiary' });
        }
    
        uomOptions.forEach((uom, index) => {
            const option = document.createElement('option');
            option.value = uom.value;
            option.textContent = uom.label;
            dropdown.appendChild(option);
            
            if (index === 0) {
                option.selected = true;
            }
        });
    
        dropdown.addEventListener('change', function (event) {
            const row = dropdown.closest('tr');
            const qtyElement = row.querySelector(".requestedQty");
    
            let baseQty = parseFloat(row.dataset.baseQty) || parseFloat(qtyElement.textContent);
            if (!row.dataset.baseQty) {
                row.dataset.baseQty = baseQty;
            }
    
            const primaryValue = parseFloat(row.dataset.primaryValue) || 1;
            const secondaryValue = parseFloat(row.dataset.secondaryValue) || 1;
            const tertiaryValue = parseFloat(row.dataset.tertiaryValue) || 1;
            let selectedUOM = dropdown.value;
            let convertedQty;
            let maxConvertedQty;
            switch (selectedUOM) {
                case 'primary':
                    convertedQty = baseQty * primaryValue;
                    maxConvertedQty = baseQty * primaryValue;
                    break;
                case 'secondary':
                    convertedQty = baseQty * secondaryValue;
                    maxConvertedQty = baseQty * secondaryValue;
                    break;
                case 'tertiary':
                    convertedQty = baseQty * tertiaryValue;
                    maxConvertedQty = baseQty * tertiaryValue;
                    break;
                default:
                    convertedQty = baseQty;
                    maxConvertedQty = baseQty;
            }
    
            qtyElement.textContent = convertedQty.toFixed(2);
            qtyElement.setAttribute('data-max-qty', maxConvertedQty.toFixed(2));
            row.dataset.maxQty = maxConvertedQty;
    
            qtyElement.removeEventListener("input", handleQuantityInput);
            qtyElement.addEventListener("input", handleQuantityInput);
        });
    
        function handleQuantityInput(event) {
            const qtyElement = event.target;
            const maxAllowedQty = parseFloat(qtyElement.getAttribute('data-max-qty'));
            const currentQty = parseFloat(qtyElement.textContent) || 0;
    
            if (currentQty > maxAllowedQty) {
                qtyElement.textContent = maxAllowedQty.toFixed(2);
                alert(`Maximum allowed quantity is ${maxAllowedQty.toFixed(2)}`);
            }
        }
    }

    document.getElementById('addRowBtn').addEventListener('click', function(e) {
        e.preventDefault();
        const submitButton = document.getElementById('submitRequestWithdraw');
        submitButton.disabled = true;
        
        const newRow = `
            <tr>
                <td>
                    <div style="position: relative;">
                        <input type="text" class="form-control form-control-sm itemCodeInput" placeholder="Enter Item Code" list="itemSuggestions">
                        <datalist id="itemSuggestions"></datalist>
                    </div>
                </td>
                <td class="itemDescription" style="background-color: #E9ECEF; pointer-events: none;"></td>
                <td class="itemCategory" style="background-color: #E9ECEF; pointer-events: none;"></td>
                <td>
                    <select class="form-control uom-dropdown"></select>
                </td>
                <td contenteditable="true" class="reason"></td>
                <td contenteditable="true" class="requestedQty"></td>
            </tr>
        `;

        document.getElementById('itemTableBody').insertAdjacentHTML('beforeend', newRow);

        const newItemCodeInput = document.querySelector('#itemTableBody tr:last-child .itemCodeInput');
        const newReasonInput = document.querySelector('#itemTableBody tr:last-child .reason');
        const newUomDropdown = document.querySelector('#itemTableBody tr:last-child .uom-dropdown');
        
        newItemCodeInput.addEventListener('input', async (e) => {
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
                    const suggestions = newItemCodeInput.nextElementSibling;
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

        newItemCodeInput.addEventListener("blur", function(e) {
            e.preventDefault();
            const itemCode = e.target.value;
            const subsidiaryId = document.getElementById('usersubsidiaryid').value;
            if (itemCode) {
                fetchItemDetails(itemCode, subsidiaryId, e.target);
            }
        });

        newReasonInput.addEventListener("input", function(e) {
            e.preventDefault();
            validateItems();
        });
    });

    function closeModalAndCleanup(modalInstance) {
        document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
    
        if (modalInstance) {
            modalInstance.hide();
        }
    }

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
                const uomDropdown = row.querySelector(".uom-dropdown");
                const selectedUOM = uomDropdown ? uomDropdown.value : '';
                let uomp, uoms, uomt;
                switch (selectedUOM) {
                    case 'primary':
                        uomp = uomDropdown.options[0].text;
                        uoms = uomDropdown.options[1].text;
                        uomt = uomDropdown.options[2] ? uomDropdown.options[2].text : '';
                        break;
                    case 'secondary':
                        uomp = uomDropdown.options[1].text;
                        uoms = uomDropdown.options[0].text;
                        uomt = uomDropdown.options[2] ? uomDropdown.options[2].text : '';
                        break;
                    case 'tertiary':
                        uomp = uomDropdown.options[2] ? uomDropdown.options[2].text : ''; 
                        uoms = uomDropdown.options[0].text;
                        uomt = uomDropdown.options[1].text;
                        break;
                    default:
                        uomp = selectedUOM;
                        uoms = '';
                        uomt = '';
                }
                return {
                    item_code: row
                        .querySelector(".itemCodeInput")
                        .value,
                    qty: parseFloat(
                        row.querySelector(".requestedQty").textContent.trim()
                    ),
                    item_description: 
                        row.querySelector(".itemDescription").textContent.trim()
                    ,
                    item_category:
                        row.querySelector(".itemCategory").textContent.trim()
                    ,
                    uomp: uomp, 
                    uoms: uoms,  
                    uomt: uomt,
                    uom_id: row.dataset.uomId,
                    reason:
                        row.querySelector(".reason").textContent.trim()
                    ,
                };
            })
            .filter((item) => item.item_code && item.qty > 0);


        const approvals = Array.from(document.querySelectorAll("#approversTable tbody tr")).map((row) => {

            const approverIdField = row.querySelector("input[id^='userIdInput']");
            const approverId = approverIdField ? approverIdField.value : null;
            const approverName = row.querySelector("td[id^='approver']").textContent.trim();
            const hierarchy = row.querySelector(".hierarchy-input").textContent.trim();
            return {
                approver_id: approverId,  
                approver_name: approverName,
                hierarchy: parseInt(hierarchy)
            };
        });

        if (approvals.some((approval) => !approval.approver_id)) {
            alert("Please ensure all approvers have valid IDs.");
            return;
        }

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
                approvals: approvals,
            })
            .then((response) => {
                Swal.fire({
                    title: "Success!",
                    html: response.data.message,
                    icon: "success",
                    confirmButtonText: "Ok"
                }).then(() => {
                    clearTransferModal(); 
                });
/*                alert(response.data.message || "Withdraw request submitted.");*/
                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("inventoryWithdrawalModal"));
                if (requestTransferModal) {
                    requestTransferModal.hide();
                }
                const modalInstance = bootstrap.Modal.getInstance(document.getElementById("yourModalId"));
                closeModalAndCleanup(modalInstance);
                fetchWithdrawal(currentPage);
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
            row.querySelector(".itemCodeInput").value = "";
            row.querySelector(".itemDescription").textContent = "";
            row.querySelector(".itemCategory").textContent = "";
            row.querySelector(".uom-dropdown").value = "";
            row.querySelector(".reason").textContent = "";
            row.querySelector(".requestedQty").textContent = "";
        });

        document.getElementById("remarks").value = "";
    }

    searchInput.addEventListener("input", function (e) {
        const searchTerm = this.value;
        const url = `/api/search-withdrawal?page=${currentPage}&per_page=${rowsPerPage}`;

        // Ensure you get the actual value of userId
        const requestBody = {
            id: userId.value,
            search: searchTerm, 
            subsidiaryid: subsidiary_id
        };

        axios
            .post(url, requestBody)
            .then((response) => {
                if (response.data.status === "success") {
                    renderTable(response.data.data, response.data.pagination.total_items);
                    updatePagination(response.data.pagination);
                } else {
                    console.error("Failed to fetch withdraws:", response.data.message);
                }
            })
            .catch((error) => {
                console.error("Error fetching withdraws:", error);
            });
    });

    const userSearchInputField = document.getElementById("userSearchInput");
    if (userSearchInputField) {
        initializeUserSearch(userSearchInputField);
    }

    function initializeUserSearch(inputField) {
        const dataList = document.getElementById("userSuggestions");
        inputField.setAttribute("list", "userSuggestions");
    
        let lastRoleSearchTerm = '';
        inputField.addEventListener("input", async function (e) {
            const searchTerm = e.target.value.trim();
        
            if (searchTerm.length > 1 && searchTerm !== lastRoleSearchTerm) {
                lastRoleSearchTerm = searchTerm; 
        
                try {
                    const response = await axios.post('/api/users/suggestions', {
                        searchTerm: searchTerm,
                    });
        
                    if (response.data.status === "success") {
                        dataList.innerHTML = '';
        
                        response.data.data.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.name;
                            option.dataset.userId = user.id;
                            option.dataset.email = user.email;
                            option.dataset.roleName = user.role_name;
                            dataList.appendChild(option);
                        });
                    } else {
                        console.error('Failed to fetch user suggestions:', response.data.message);
                    }
                } catch (error) {
                    console.error('Error fetching user suggestions:', error);
                }
            }
        });
        inputField.addEventListener("blur", function (e) {
            const selectedOption = document.querySelector(`#userSuggestions option[value='${e.target.value}']`);
            if (selectedOption) {
                const approverIdField = e.target.closest("tr").querySelector("input[id^='userIdInput']");
                approverIdField.value = selectedOption.dataset.userId;
                document.getElementById('userEmailInput').value = selectedOption.dataset.email;
                if(selectedOption.dataset.roleName === null) {
                    document.getElementById(e.target.id.replace("userSearchInput", "userRoleInput")).textContent = selectedOption.dataset.roleName;     
                }
                else {
                    document.getElementById(e.target.id.replace("userSearchInput", "userRoleInput")).textContent = "Super Admin"; 
                }
                


            } else {
                console.warn("No matching option found for user.");
            }
        });
    }

    function initializeReturnUserSearch(inputField) {
        const dataList = document.getElementById("returnUserSuggestions");
        inputField.setAttribute("list", "returnUserSuggestions");
    
        let lastRoleSearchTerm = '';
        inputField.addEventListener("input", async function (e) {
            const searchTerm = e.target.value.trim();
        
            if (searchTerm.length > 1 && searchTerm !== lastRoleSearchTerm) {
                lastRoleSearchTerm = searchTerm; 
        
                try {
                    const response = await axios.post('/api/users/suggestions', {
                        searchTerm: searchTerm,
                    });
        
                    if (response.data.status === "success") {
                        dataList.innerHTML = '';
        
                        response.data.data.forEach(user => {
                            const option = document.createElement('option');
                            option.value = user.name;
                            option.dataset.userId = user.id;
                            option.dataset.email = user.email;
                            option.dataset.roleName = user.role_name;
                            dataList.appendChild(option);
                        });
                    } else {
                        console.error('Failed to fetch user suggestions:', response.data.message);
                    }
                } catch (error) {
                    console.error('Error fetching user suggestions:', error);
                }
            }
        });
        inputField.addEventListener("blur", function (e) {
            const selectedOption = document.querySelector(`#returnUserSuggestions option[value='${e.target.value}']`);
            if (selectedOption) {
                const approverIdField = e.target.closest("tr").querySelector("input[id^='returnUserIdInput']");
                
                approverIdField.value = selectedOption.dataset.userId;
                document.getElementById('returnUserEmailInput').value = selectedOption.dataset.email;
                if(selectedOption.dataset.roleName === null) {
                    document.getElementById(e.target.id.replace("returnUserSearchInput", "returnUserRoleInput")).textContent = selectedOption.dataset.roleName;     
                }
                else {
                    document.getElementById(e.target.id.replace("returnUserSearchInput", "returnUserRoleInput")).textContent = "Super Admin"; 
                }
                


            } else {
                console.warn("No matching option found for user.");
            }
        });
    }

    function returnGenerateItemCode() {
        const prefix = "RETURN";
        const datePart = new Date()
            .toISOString()
            .split("T")[0]
            .replace(/-/g, "");
        const randomPart = Math.floor(Math.random() * 90000) + 10000;
        return `${prefix}-${datePart}-${randomPart}`;
    }

    function returnValidateItems() {
        const submitButton = document.getElementById('submitRequestReturn');
        const rows = document.querySelectorAll('#returnItemTableBody tr');
        let allFieldsFilled = true;
        
        rows.forEach(row => {
            const itemCode = row.querySelector("#returnItemCode")?.textContent.trim();
            const uom = row.querySelector('#return-uom-dropdown')?.value;
            const returnQty = row.querySelector('#returnQty')?.textContent.trim();
    
            if (!itemCode || !uom || !returnQty) {
                allFieldsFilled = false;
            }
        });
    
        submitButton.disabled = !allFieldsFilled;
    }

    function returnPopulateUOMOptions(primaryUOM, secondaryUOM, tertiaryUOM, dropdown, data) {
        dropdown.innerHTML = '';

        const uomOptions = [
            { label: primaryUOM || 'Primary', value: primaryUOM || 'Primary' },
            { label: secondaryUOM || 'Secondary', value: secondaryUOM || 'Secondary' },
            tertiaryUOM ? { label: tertiaryUOM, value: tertiaryUOM } : null 
        ].filter(option => option !== null);
        uomOptions.forEach((uom, index) => {
            if (uom.label) {
                const option = document.createElement('option');
                option.value = uom.value; 
                option.textContent = uom.label;
                dropdown.appendChild(option);
                if (index === 0) {
                    option.selected = true;
                }
            }
        });
        dropdown.addEventListener('change', function (event) {
            const row = dropdown.closest('tr');
            const qtyElement = document.getElementById("returnQty");
            const uomId = document.getElementById("uomId").textContent = data.dataset.uomId;
            const withdrewElement = document.getElementById("withdrewQty");
            let baseQty = parseFloat(row.dataset.baseQty) || parseFloat(qtyElement.textContent);
            if (!row.dataset.baseQty) {
                row.dataset.baseQty = baseQty;
            }
            
            const primaryValue = parseFloat(data.dataset.primaryValue) || 1;
            const secondaryValue = parseFloat(data.dataset.secondaryValue) || 1;
            const tertiaryValue = parseFloat(data.dataset.tertiaryValue) || 1;
            let selectedUOM = dropdown.value;
            let convertedQty;
            let maxConvertedQty;
            switch (selectedUOM) {
                case primaryUOM:
                    convertedQty = baseQty * primaryValue;
                    maxConvertedQty = baseQty * primaryValue;
                    break;
                case secondaryUOM:
                    convertedQty = baseQty * secondaryValue;
                    maxConvertedQty = baseQty * secondaryValue;
                    break;
                case tertiaryUOM:
                    convertedQty = baseQty * tertiaryValue;
                    maxConvertedQty = baseQty * tertiaryValue;
                    break;
                default:
                    convertedQty = baseQty;
                    maxConvertedQty = baseQty;
            }
            qtyElement.textContent = convertedQty.toFixed(2);
            withdrewElement.textContent = convertedQty.toFixed(2);
            qtyElement.setAttribute('data-max-qty', maxConvertedQty.toFixed(2));
            row.dataset.maxQty = maxConvertedQty;
    
            qtyElement.removeEventListener("input", handleQuantityInput);
            qtyElement.addEventListener("input", handleQuantityInput);
            document.addEventListener("input", handleQuantityInput);
        });
    
        function handleQuantityInput(event) {
            const qtyElement = event.target;
            const maxAllowedQty = parseFloat(qtyElement.getAttribute('data-max-qty'));
            const currentQty = parseFloat(qtyElement.textContent) || 0;
    
            if (currentQty > maxAllowedQty) {
                qtyElement.textContent = maxAllowedQty.toFixed(2);
                alert(`Maximum allowed quantity is ${maxAllowedQty.toFixed(2)}`);
            }
        }
    }

    document.addEventListener("click", function(event) {
        const target = event.target.closest(".clickable-row");
        if (target) {
            const status = target.dataset.status;
            if (status === "2") {
                getReturnApprovers()
                const transactionCode = target.cells[3].textContent.trim();
                const today = new Date().toISOString().split('T')[0];
                const userId = document.getElementById('userId').value;
                const userName = document.getElementById('userName').value;
                const subsidiary = document.getElementById('usersubsidiary').value;
                const subsidiaryId = document.getElementById('usersubsidiaryid').value;
                
                if (transactionCode) {
                    returnFetchItemDetails(transactionCode, subsidiaryId, event.target);
                }
                document.getElementById('returnDate').value = today;
                document.getElementById('returnRequestNumber').value = returnGenerateItemCode();
                document.getElementById('returnRequestName').value = userName;
                document.getElementById('returnSubsidiary').value = subsidiary;
                document.getElementById('returnProcessId').textContent = transactionCode;
                returnValidateItems();
                    
                var inventoryReturnModal = new bootstrap.Modal(document.getElementById('inventoryReturnModal'));
                inventoryReturnModal.show();

            }

            else if (status === "4" || status === "5") {
                const reason = target.dataset.remarks || "No reason provided.";
                Swal.fire({
                    title: `Transfer is ${status}`,
                    text: reason,
                    icon: "info",
                    confirmButtonText: "Ok"
                });
                return;
            }

            else if (status === "6") {
                const reason = target.dataset.remarks || "No reason provided.";
                Swal.fire({
                    title: `All items has been returned`,
                    text: "No item to return",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
                return;   
            }

            else {
                const approverId = target.dataset.approverId;
                const requesterId = target.dataset.requesterId;
                const userId = document.getElementById("userId").value;
                const uom = target.querySelector("td:nth-child(9)").textContent.trim();
                if (target.dataset.status === "1") {
                    if (requesterId !== userId) {
                        Swal.fire({
                            title: 'Unauthorized!',
                            text: "You are unauthorized to receive this withdraw.",
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                        return;
                    }
                    
                    const transactionNumber = target.dataset.transactId;
                    const requestedQty = parseFloat(target.querySelector("td:nth-child(7)").textContent.trim());
                    const releasedQty = parseFloat(target.dataset.releasedQty);
                
                    document.getElementById("requestedQtyReceive").value = requestedQty;
                    document.getElementById("releasedQtyReceive").value = releasedQty;
                
                    const receiveWithdrawModal = new bootstrap.Modal(document.getElementById("receiveWithdrawModal"));
                    receiveWithdrawModal.show();
                } else {
                    if (approverId !== userId) {
                        Swal.fire({
                            title: 'Unauthorized!',
                            text: "You are unauthorized to approve this withdraw.",
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                        return;
                    }
                    const transactionNumber = target.dataset.transactId;
                    const approveWithdawButton = document.getElementById("approveWithdrawButton");
                
                    approveWithdawButton.dataset.transactionNumber = transactionNumber;
                
                    const approvedBy = document.getElementById("userName").value;
                    document.getElementById("approvedByText").textContent = `Approver: ${approvedBy}`;
                
                    const requestedQty = parseFloat(target.querySelector("td:nth-child(7)").textContent.trim());
                    const releasedQtyInput = document.getElementById("releasedQty");
                
                    const currentReleasedQty = target.dataset.releasedQty || "";
                    releasedQtyInput.value = currentReleasedQty !== "" ? currentReleasedQty : "";
                
                    document.getElementById("requestedQty").value = `${requestedQty} (${uom})`;
                    releasedQtyInput.setAttribute("max", requestedQty);
                
                    document.getElementById("approveWithdrawButton").disabled = true;
                
                    releasedQtyInput.addEventListener("input", function() {
                        const releasedQty = parseFloat(releasedQtyInput.value);
                        const warningMessage = document.getElementById("releasedQtyWarning");
                
                        if (releasedQty && releasedQty > 0 && releasedQty <= requestedQty) {
                            approveWithdrawButton.disabled = false;
                            if (warningMessage) {
                                warningMessage.textContent = "";
                            }
                        } else {
                            approveWithdrawButton.disabled = true;
                            if (!warningMessage) {
                                const messageElement = document.createElement("p");
                                messageElement.id = "releasedQtyWarning";
                                messageElement.textContent = "Released quantity exceeds the requested quantity!";
                                messageElement.style.color = "red";
                                releasedQtyInput.parentNode.appendChild(messageElement);
                            } else {
                                warningMessage.textContent = "Released quantity exceeds the requested quantity!";
                            }
                        }
                    });
                
                    const approveWithdrawModal = new bootstrap.Modal(document.getElementById("approveWithdrawModal"));
                    approveWithdrawModal.show();
                }
            }
        }
    });
    approveWithdrawButton.addEventListener("click", function () {
        const transactionNumber = approveWithdrawButton.dataset.transactionNumber;
        const approvedBy = document.getElementById("userName").value;
        const releasedQty = document.getElementById("releasedQty").value;
    
        const approverId = document.querySelector(`.clickable-row[data-transact-id='${transactionNumber}']`).dataset.approverId;
    
        axios
            .post(`/api/inventory/withdraw/approve/${transactionNumber}`, {
                approved_by: approvedBy,
                released_qty: releasedQty,
                approver_id: approverId,
            })
            .then((response) => {
                Swal.fire({
                    title: "Success!",
                    text: response.data.message || "Withdraw approved.",
                    icon: "success",
                    confirmButtonText: "Ok"
                }).then(() => {
                    fetchWithdrawal(currentPage); 
                    const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("approveWithdrawModal"));
                    if (requestTransferModal) {
                        requestTransferModal.hide();
                    }
                    setTimeout(() => {
                        clearTransferModal();
                        document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                        document.body.classList.remove("modal-open");
                        document.body.style.overflow = ""; // Resets body overflow style if needed
                    }, 300);
                });
            })
            .catch((error) => {
                Swal.fire({
                    title: "Error!",
                    text: "Failed to approve the withdraw. Please try again.",
                    icon: "error",
                    confirmButtonText: "Ok"
                });
                console.error(error);
            });
    });

    document.getElementById("receiveWithdrawButton").addEventListener("click", function () {
        const transactionNumber = document.querySelector('.clickable-row[data-status="1"]').dataset.transactId;
        const releasedQty = document.getElementById("releasedQtyReceive").value;
        const requesterId = document.getElementById("userId").value;
        
        axios
            .post(`/api/inventory/withdraw/approve/${transactionNumber}`, {
                released_qty: releasedQty,
                requester_id: requesterId,
                status: 2,
            })
            .then((response) => {
                if(response.data.status !== "error") {
                    Swal.fire({
                        title: "Success!",
                        text: response.data.message || "Withdraw release successfully.",
                        icon: "success",
                        confirmButtonText: "Ok",
                    }).then(() => {
                        fetchWithdrawal(currentPage); 
                        const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("receiveWithdrawModal"));
                        if (requestTransferModal) {
                            requestTransferModal.hide();
                        }
                        setTimeout(() => {
                            fetchWithdrawal(currentPage);
                            clearTransferModal();
                            document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                            document.body.classList.remove("modal-open");
                            document.body.style.overflow = ""; // Resets body overflow style if needed
                        }, 300);
                    });   
                }
                else {
                    const message = `${response.data.message} <br> available qty: ${response.data.available_qty}`;
                    Swal.fire({
                        title: "Failed!",
                        html: message  || "Withdraw release failed.",
                        icon: "error",
                        confirmButtonText: "Ok",
                    }).then(() => {
                        fetchWithdrawal(currentPage); 
                        const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("receiveWithdrawModal"));
                        if (requestTransferModal) {
                            requestTransferModal.hide();
                        }
                        setTimeout(() => {
                            fetchWithdrawal(currentPage);
                            clearTransferModal();
                            // Optionally remove backdrop and reset body styles
                            document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                            document.body.classList.remove("modal-open");
                            document.body.style.overflow = ""; // Resets body overflow style if needed
                        }, 300);
                    });
                }
                
            })
            .catch((error) => {
                Swal.fire({
                    title: "Failed!",
                    text: error,
                    icon: "error",
                    confirmButtonText: "Ok",
                });
                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("receiveWithdrawModal"));
                if (requestTransferModal) {
                    requestTransferModal.hide();
                }
                setTimeout(() => {
                    fetchWithdrawal(currentPage);
                    clearTransferModal();
                    // Optionally remove backdrop and reset body styles
                    document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                    document.body.classList.remove("modal-open");
                    document.body.style.overflow = ""; // Resets body overflow style if needed
                }, 300);
                console.error("Withdraw error:", error);
            });
    });

    document.getElementById('closeModalButton').addEventListener('click', function () {
        const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("receiveWithdrawModal"));
        if (requestTransferModal) {
           requestTransferModal.hide();
        }
        setTimeout(() => {
           fetchWithdrawal(currentPage);
           clearTransferModal();
           // Optionally remove backdrop and reset body styles
           document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
           document.body.classList.remove("modal-open");
           document.body.style.overflow = ""; // Resets body overflow style if needed
        }, 300);
    });

    document.getElementById('inventoryWithdrawalModalBtn').addEventListener('click', function () {
        const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("inventoryWithdrawalModal"));
        if (requestTransferModal) {
           requestTransferModal.hide();
        }
        setTimeout(() => {
           fetchWithdrawal(currentPage);
           clearTransferModal();
           document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
           document.body.classList.remove("modal-open");
           document.body.style.overflow = "";
        }, 300);
    });

    function formatDateForMySQL(date) {
        return date.getFullYear() + '-' +
        String(date.getMonth() + 1).padStart(2, '0') + '-' +
        String(date.getDate()).padStart(2, '0') + ' ' +
        String(date.getHours()).padStart(2, '0') + ':' +
        String(date.getMinutes()).padStart(2, '0') + ':' +
        String(date.getSeconds()).padStart(2, '0');
    }

    returnSubmitButton.addEventListener("click", function () {
        const requestorName = document.getElementById('userName').value;
        const requestorNumber = document.getElementById('returnRequestNumber').value; 
        const requestorId = document.getElementById('userId').value; 
        const subsidiaryId = document.getElementById('usersubsidiaryid').value; 
        const subsidiary = document.getElementById('usersubsidiary').value; 
        const remarks = document.getElementById("remarks").textContent;
        let validate = 0;
        const items = Array.from(document.querySelectorAll("#returnItemsTable tbody tr"))
            .map((row) => {
                const reason = document.getElementById("returnReason").textContent.trim();
                const itemCode = document.getElementById("returnItemCode").textContent.trim();
                const processId = document.getElementById("returnProcessId").textContent.trim();
                const withdrawQty = document.getElementById("withdrewQty").textContent.trim();
                const returnedQty = document.getElementById("returnQty").textContent.trim();

                if (!reason) {
                    document.getElementById("returnReason").style.border = "1px solid red";
                    validate = 0
                    return null;
                } else {
                    validate = 1
                    document.getElementById("returnReason").style.border = ""; 
                }

                if (!itemCode || !returnedQty) {
                    return null;
                }
                return {
                    item_code: itemCode,
                    process_id: processId,
                    withdraw_qty: withdrawQty,
                    item_description: document.getElementById("returnItemDescription").textContent.trim(),
                    item_category: document.getElementById("returnItemCategory").textContent.trim(),
                    uom: document.getElementById("return-uom-dropdown")?.value || '',
                    uomid: document.getElementById("uomId").textContent || '',
                    returned_qty: returnedQty,
                    reason: reason,
                    return_date: formatDateForMySQL(new Date())
                };  
            })
            .filter((item) => item !== null);
        if (validate === 0) {
            alert("Reason is required for all items.");
        }

        else {
            const approvals = Array.from(document.querySelectorAll("#returnApproversTable tbody tr")).map((row) => {
                const approverIdField = row.querySelector("input[id^='returnUserIdInput']");
                const approverId = approverIdField ? approverIdField.value : null;
                const approverName = row.querySelector("td[id^='returnApprover']").textContent.trim();
                const hierarchy = row.querySelector(".returnHierarchy-input").textContent.trim();
                return {
                    approver_id: approverId,  
                    approver_name: approverName,
                    hierarchy: parseInt(hierarchy)
                };
            });
            if (approvals.some((approval) => !approval.approver_id)) {
                alert("Please ensure all approvers have valid IDs.");
                return;
            }

            else if (items.length === 0) {
                alert("Please add at least one valid item before submitting.");
                return;
            }

            else 
            {
                axios
                    .post("/api/inventory/return/request", {
                        requestor_name: requestorName,
                        request_number: requestorNumber,
                        requestor_id: requestorId,
                        items: items,
                        remarks: remarks,
                        subsidiaryid: subsidiaryId,
                        subsidiary_name: subsidiary,
                        approvals: approvals,
                    })
                    .then((response) => {
                        Swal.fire({
                            title: "Success!",
                            html: response.data.message,
                            icon: "success",
                            confirmButtonText: "Ok"
                        });
        /*                alert(response.data.message || "Withdraw request submitted.");*/
                        const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("inventoryReturnModal"));
                        if (requestTransferModal) {
                            requestTransferModal.hide();
                        }
                        setTimeout(() => {
                            fetchReturn(currentPage);
                            clearTransferModal();
                            document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                            document.body.classList.remove("modal-open");
                            document.body.style.overflow = "";
                        }, 300); 

                    })
                    .catch((error) => {
                        alert(
                            "Failed to submit the transfer request. Please try again."
                        );
                        console.error(error);
                    }); 
            }
        }
        
    });

    document.getElementById("declineWithdrawButton").addEventListener("click", function () {
        const transactionNumber = approveWithdrawButton.dataset.transactionNumber;
    
        const approveTransferModalInstance = bootstrap.Modal.getInstance(document.getElementById("approveWithdrawModal"));
        if (approveTransferModalInstance) {
            approveTransferModalInstance.hide();
        }

        Swal.fire({
            title: 'Reason for Declining',
            html: `
                <label for="declineReasonTextarea">Enter reason for declining this withdraw:</label>
                <textarea id="declineReasonTextarea" class="swal2-textarea" placeholder="Enter reason here..." rows="4"></textarea>
            `,
            showCancelButton: true,
            confirmButtonText: 'Decline Withdraw',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const reason = document.getElementById('declineReasonTextarea').value;
                if (!reason) {
                    Swal.showValidationMessage('Please enter a reason for declining');
                    return false;
                }
                return reason;
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const reason = result.value;
                const approveTransferModalInstance = bootstrap.Modal.getInstance(document.getElementById("approveWithdrawModal"));
                approveTransferModalInstance.hide();
                axios.post(`/api/inventory/withdraw/decline/${transactionNumber}`, {
                    remarks: reason 
                })
                .then(response => {
                    Swal.fire({
                        title: "Declined!",
                        text: "Withdraw request has been declined.",
                        icon: "warning",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        fetchWithdrawal(currentPage);
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to decline the withdraw request. Please try again.",
                        icon: "error",
                        confirmButtonText: "Ok"
                    });
                    console.error("Decline transfer error:", error);
                });
            }
        });
    });
    
    document.getElementById("declineWithdrawButtonReceive").addEventListener("click", function () {
        const transactionNumber = document.querySelector('.clickable-row[data-status="Receiving"]').dataset.transactId;
        const receiveTransferModalInstance = bootstrap.Modal.getInstance(document.getElementById("receiveWithdrawModal"));
    
        if (receiveTransferModalInstance) {
            receiveTransferModalInstance.hide();
        }
    
        Swal.fire({
            title: 'Reason for Not Receiving',
            html: `
                <label for="declineReasonTextarea">Enter reason for declining this transfer:</label>
                <textarea id="declineReasonTextarea" class="swal2-textarea" placeholder="Enter reason here..." rows="4"></textarea>
                <br><label for="declineProofImage">Upload proof (optional):</label>
                <input type="file" id="declineProofImage" class="swal2-file" accept="image/*" />
            `,
            showCancelButton: true,
            confirmButtonText: 'Decline Withdraw',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const reason = document.getElementById('declineReasonTextarea').value;
                const imageFile = document.getElementById('declineProofImage').files[0];
                if (!reason) {
                    Swal.showValidationMessage('Please enter a reason for declining');
                    return false;
                }
                return { reason, imageFile };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { reason, imageFile } = result.value;
    
                const requestData = {
                    remarks: reason
                };
                
                if (imageFile) {
                    requestData.image = imageFile;
                }
    
                axios.post(`/api/inventory/withdraw/decline/${transactionNumber}`, requestData)
                .then(response => {
                    Swal.fire({
                        title: "Declined!",
                        text: "Withdraw request has been declined.",
                        icon: "warning",
                        confirmButtonText: "Ok"
                    }).then(() => {
                        fetchWithdrawal(currentPage);
                    });
                })
                .catch(error => {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to decline the withdraw request. Please try again.",
                        icon: "error",
                        confirmButtonText: "Ok"
                    });
                    console.error("Decline withdraw error:", error);
                });
            }
        });
    });

    function getApprovers() {
        axios
            .get(`/api/inventory/approvers/${subsidiary_id}`)
            .then((response) => {
                document.getElementById("approver1").textContent = response.data.data[0].name
                document.getElementById("userRoleInput1").textContent = response.data.data[0].role
                document.getElementById("userIdInput1").value = response.data.data[0].uid
                document.getElementById("approver2").textContent = response.data.data[1].name
                document.getElementById("userRoleInput2").textContent = response.data.data[1].role
                document.getElementById("userIdInput2").value = response.data.data[1].uid
            })
            .catch((error) => {
                console.error("Error fetching item details:", error);
                alert("An error occurred while fetching item details.");
            });
    }

    function getReturnApprovers() {
        axios
            .get(`/api/inventory/approvers/${subsidiary_id}`)
            .then((response) => {
                document.getElementById("returnApprover1").textContent = response.data.data[0].name
                document.getElementById("returnUserRoleInput1").textContent = response.data.data[0].role
                document.getElementById("returnUserIdInput1").value = response.data.data[0].uid
                document.getElementById("returnApprover2").textContent = response.data.data[1].name
                document.getElementById("returnUserRoleInput2").textContent = response.data.data[1].role
                document.getElementById("returnUserIdInput2").value = response.data.data[1].uid
            })
            .catch((error) => {
                console.error("Error fetching item details:", error);
                alert("An error occurred while fetching item details.");
            });
    }

    initializeUserSearch(document.getElementById("userSearchInput1"));
    initializeUserSearch(document.getElementById("userSearchInput2"));
    initializeReturnUserSearch(document.getElementById("returnUserSearchInput1"));
    initializeReturnUserSearch(document.getElementById("returnUserSearchInput2"));

    validateItems()
});
