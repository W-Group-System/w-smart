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
            const itemCode = row.querySelector(".itemCodeInput").value.trim();
            const uom = row.querySelector('.uom').textContent.trim();
            const reason = row.querySelector('.reason').textContent.trim();
            if (itemCode === '' || uom === '' || reason === '') {
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
                    row.querySelector('.itemCategory').contentEditable = true;
                    row.querySelector('.uom').contentEditable = true;
                    row.querySelector('.reason').contentEditable = true;
                    row.querySelector('.requestedQty').contentEditable = true;
                    const item = response.data.data;
                    
                    row.querySelector(".itemDescription").textContent =
                        item.item_description;
                    row.querySelector(".itemCategory").textContent =
                        item.item_category;
                    row.querySelector(".requestedQty").textContent = item.qty;
                    const qtyCell = row.querySelector(".requestedQty");
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
                console.error("Error fetching item details:", error);
                alert("No item found with this item code.");
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
            const updatedAt = item.status === 2 ? item.updated_at : 'Pending';
            const row = document.createElement("tr");
            row.classList.add("clickable-row");
            row.dataset.transactId = item.id;
            row.dataset.status = item.status;
            row.dataset.requesterId = item.requestor_id;
            row.dataset.approverId = item.approver_id;
            row.dataset.releasedQty = item.released_qty;
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
                <td style="text-align: center; padding: 2px 10px;">${item.uom}</td>
                <td style="text-align: center; padding: 2px 10px;">${updatedAt}</td>
                <td style="text-align: center; padding: 2px 10px;">${item.reason}</td>
                <td style="text-align: center; padding: 2px 10px;">
                    <span class="badge bg-${item.status === 2 ? "success" : item.status === 1 ? "primary" : "danger"}">
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
        const submitButton = document.getElementById('submitRequestWithdraw');
        submitButton.disabled = true;
        const rowCount = document.querySelectorAll('#itemTableBody tr').length; // Get current row count for unique datalist ID
        const newRow = `
            <tr>
                <td contenteditable="true">
                    <div style="position: relative;">
                        <input type="text" class="form-control form-control-sm itemCodeInput" placeholder="Enter Item Code" style="width: 100%; max-width: 200px; padding: 6px; border-radius: 5px; border: 1px solid #ced4da;" list="itemSuggestions${rowCount}">
                        <datalist id="itemSuggestions${rowCount}"></datalist>
                    </div>
                </td>
                <td contenteditable="false" class="itemDescription" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                <td contenteditable="false" class="itemCategory" style="background-color: #E9ECEF; color: #999; pointer-events: none;"></td>
                <td contenteditable="true" class="uom"></td>
                <td contenteditable="true" class="reason"></td>
                <td contenteditable="true" class="requestedQty"></td>
            </tr>
        `;

        document.getElementById('itemTableBody').insertAdjacentHTML('beforeend', newRow);

        const newItemCodeInput = document.querySelector('#itemTableBody tr:last-child .itemCodeInput');
        const newReasonInput = document.querySelector('#itemTableBody tr:last-child .reason');
        const newUomInput = document.querySelector('#itemTableBody tr:last-child .uom');
        
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
            if (itemCode) {
                fetchItemDetails(itemCode, subsidiary_id, e.target);
            }
        });

        newReasonInput.addEventListener("input", function(e) {
            e.preventDefault();
            validateItems();
        });

        newUomInput.addEventListener("input", function(e) {
            e.preventDefault();
            validateItems();
        });
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
                    uom:
                        row.querySelector(".uom").textContent.trim()
                    ,
                    reason:
                        row.querySelector(".reason").textContent.trim()
                    ,
                };
            })
            .filter((item) => item.item_code && item.qty > 0);


        const approvals = Array.from(document.querySelectorAll("#approversTable tbody tr")).map((row) => {
            const approverIdField = row.querySelector("input[id^='userIdInput']");
            const approverId = approverIdField ? approverIdField.value : null;
            const approverName = row.querySelector("input[id^='userSearchInput']").value;
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
                });
/*                alert(response.data.message || "Withdraw request submitted.");*/
                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("inventoryWithdrawalModal"));
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
                }, 300); // Adjust delay as needed

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
            row.querySelector(".uom").textContent = "";
            row.querySelector(".reason").textContent = "";
            row.querySelector(".requestedQty").textContent = "";
            row.querySelector(".releasedQty").textContent = "";
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

    document.addEventListener("click", function(event) {
        const target = event.target.closest(".clickable-row");
        if (target) {

            const status = target.dataset.status;
            if (status === "2") {
                Swal.fire({
                    title: "Item withdraw request done",
                    text: "This withdraw transaction has already been marked as closed.",
                    icon: "info",
                    confirmButtonText: "Ok"
                });
                return;
            }

            else {
                const approverId = target.dataset.approverId;
                const requesterId = target.dataset.requesterId;
                const userId = document.getElementById("userId").value;
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
                
                    releasedQtyInput.setAttribute("max", requestedQty);
                    document.getElementById("requestedQty").value = requestedQty;
                
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

    initializeUserSearch(document.getElementById("userSearchInput1"));
    initializeUserSearch(document.getElementById("userSearchInput2"));

    validateItems()
});
