document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");
    const subsidiary = document.getElementById("subsidiary");
    const rowsPerPageSelect = document.querySelector("select.form-select-sm");
    const tableBody = document.querySelector("tbody");
    const totalItemsText = document.querySelector(".dynamic-rows-info");
    const pagination = document.querySelector("ul.pagination");
    const form = document.getElementById("filter-submit");
    const downloadButton = document.getElementById("downloadButton");
    const searchInput = document.getElementById("searchInput");
    const searchInputTransfer = document.getElementById("searchInputTransfer");
    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value, 10) || 10;
    let selectedText = subsidiary.selectedOptions[0].text;
    subsidiary.addEventListener("change", function () {
        selectedText = subsidiary.selectedOptions[0].text;
    });
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

    [startDateInput, endDateInput].forEach((input) => {
        input.addEventListener("input", function () {
            this.style.color = this.value === "" ? "#adb5bd" : "";
        });
    });

    function fetchTransfer(page, search) {
        const url = `/api/inventory/transfer?page=${page}&per_page=${rowsPerPage}`;
        const requestBody = {
           start_date: startDateInput.value,
           end_date: endDateInput.value,
           subsidiaryid: subsidiary.value,
           search: search
        };
        axios
            .post(url, requestBody)
            .then((response) => {
                if (response.data.status === "success") {
                    renderTransferTable(response.data.data, response.data.pagination.total_items);
                    updatePagination(response.data.pagination);
                } else {
                    console.error(
                        "Failed to fetch transfers:",
                        response.data.message
                    );
                }
            })
            .catch((error) => {
                console.error("Error fetching transfers:", error);
            });
    }

    function fetchInventory(page, search) {
        fetch(`/api/inventory?page=${page}&per_page=${rowsPerPage}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({
                start_date: startDateInput.value,
                end_date: endDateInput.value,
                subsidiaryid: subsidiary.value,
                per_page: rowsPerPage,
                search: search,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.status === "success") {
                    initializeDynamicTable(data.data, data.pagination.total_items);
                    updatePagination(data.pagination);
                } else {
                    console.error("Failed to fetch inventory:", data.message);
                }
            })
            .catch((error) => {
                console.error("Error fetching inventory:", error);
            });
    }

    function determineFetchFunction(search) {
        const isTransferRoute = window.location.pathname.includes(
            "/inventory/transfer"
        );

        if (isTransferRoute) {
            fetchTransfer(currentPage);
        } else {
            fetchInventory(currentPage, search);
        }
    }

    determineFetchFunction();

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
                <td style="text-align: center; padding: 2px 10px;">${
                    item.inventory_id
                }
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
                <td style="text-align: center; padding: 2px 10px;">
                    ${item.uomp || item.uoms || item.uomt || "N/A"}
                </td>
                <td style="text-align: center; padding: 2px 10px;">${
                    item.cost
                }</td>
                <td style="text-align: center; padding: 2px 10px;">${
                    item.usage
                }</td>
                <td style="text-align: center; padding: 2px 10px;">
                    <div style="position: relative;">
                        <button type="button" class="btn btn-link actionButton" data-bs-toggle="popover" 
                                data-bs-html="true" aria-expanded="false" data-bs-trigger="focus" 
                                data-bs-content='
                                <div style="font-family: Inter, sans-serif; color: #79747E; text-align: center;">
                                    <button type="button" class="btn btn-sm btn-light mt-1 modify-button" 
                                            style="display: flex; justify-content: center; width: 100%; align-items: center; border-radius: 8px; color: #79747E;"
                                            data-bs-toggle="modal" data-bs-target="#modifyModal">
                                        Modify
                                    </button>
                                    <button class="btn btn-sm btn-light mt-1" 
                                            style="display: flex; justify-content: center; width: 100%; align-items: center; border-radius: 8px; color: #79747E;">
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
        )} of ${totalPages}`;
    }

    function renderTransferTable(transferData, totalPages) {
        tableBody.innerHTML = "";
        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const currentItems = transferData.slice(startIndex, endIndex);

        currentItems.forEach((item) => {
            const row = document.createElement("tr");
            row.classList.add("clickable-row");
            row.dataset.transactId = item.transfer_id;
            row.dataset.status = item.status;
            row.dataset.approverRoles = item.approver_roles || "";
            row.innerHTML = `
                <td style="text-align: center; padding: 8px 10px;">${
                    item.transfer_id
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.transfer_from
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.transfer_to
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.item_code
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.item_description || "N/A"
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.item_category
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.qty
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.uomp
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.cost
                }</td>
                <td style="text-align: center; padding: 8px 10px;">${
                    item.usage
                }</td>
                <td style="text-align: center; padding: 8px 10px;">
                <span class="badge bg-${
                    item.status === "Approved" ? "success" : "danger"
                }">${item.status}</span>
            </td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll(".clickable-row").forEach((row) => {
            row.addEventListener("click", function () {
                const transactionNumber = this.dataset.transactId;
                const approverRoles = this.dataset.approverRoles ? this.dataset.approverRoles.split(",") : [];
                const userRole = document.getElementById("userRole").value;
                const userName = document.getElementById("userName").value;
                const status = this.dataset.status;
        
                if (status === "Pending" && approverRoles.length > 0 && !approverRoles.includes(userRole)) {
                    console.warn("User is unauthorized to approve this transfer.");
                    alert("You are unauthorized to approve this transfer.");
                    return;
                }
        
                document.getElementById("approveTransferButton").dataset.transactionNumber = transactionNumber;
        
                const approvedByText = document.getElementById("approvedByText");
                approvedByText.textContent = `Approved By: ${userName}`;
        
                const approveTransferModal = new bootstrap.Modal(
                    document.getElementById("approveTransferModal")
                );
                approveTransferModal.show();
            });
        });

        totalItemsText.textContent = `${startIndex + 1}-${Math.min(
            endIndex,
            transferData.length
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
                const isTransferRoute = window.location.pathname.includes(
                    "/inventory/transfer"
                );
                if (isTransferRoute) {
                    fetchTransfer(currentPage - 1);
                } else {
                    fetchInventory(currentPage - 1);
                }
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
                const isTransferRoute = window.location.pathname.includes(
                    "/inventory/transfer"
                );
                if (isTransferRoute) {
                    fetchTransfer(i);
                } else {
                    fetchInventory(i);
                }
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
                const isTransferRoute = window.location.pathname.includes(
                    "/inventory/transfer"
                );
                if (isTransferRoute) {
                    fetchTransfer(currentPage + 1);
                } else {
                    fetchInventory(currentPage + 1);
                }
            }
        });
        pagination.appendChild(nextPage);
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        fetchInventory(currentPage);
    });

    rowsPerPageSelect.addEventListener("change", function () {
        rowsPerPage = parseInt(this.value, 10);
        currentPage = 1;
        determineFetchFunction();
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
                if (
                    !popoverElement.contains(event.target) &&
                    !popoverInstance._isWithActiveTrigger()
                ) {
                    popoverInstance.hide();
                }
            });
        });
    }
    if(searchInput) {
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value;
            determineFetchFunction(searchTerm);
        });   
    }

    document
        .getElementById("filter-submit")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            determineFetchFunction();
        });

    function generateItemCode() {
        const prefix = "ITEM";
        const datePart = new Date()
            .toISOString()
            .split("T")[0]
            .replace(/-/g, ""); // YYYYMMDD
        const randomPart = Math.floor(Math.random() * 90000) + 10000; // Random 5-digit number
        return `${prefix}-${datePart}-${randomPart}`;
    }

    const addInventoryButton = document.getElementById("addInventory");

    if (addInventoryButton) {
        addInventoryButton.addEventListener("click", async (e) => {
            e.preventDefault();
            const today = new Date().toISOString().split("T")[0];
            document.getElementById("dateCreated").value = today;

            const itemCode = generateItemCode();
            document.getElementById("newItemCode").value = itemCode;
        });
    } else {
        console.warn("Element with ID 'addInventory' not found.");
    }

    const addInventoryButtonForm = document.getElementById("addInventoryForm");
    if (addInventoryButton) {
        document
            .getElementById("addInventoryForm")
            .addEventListener("submit", async (e) => {
                e.preventDefault();
                const descriptionInput =
                    document.getElementById("newItemDescription");

                if (!descriptionInput.value.trim()) {
                    alert("Item Description cannot be empty or whitespace only.");
                    descriptionInput.focus();
                    return;
                }
                const data = {
                    date: document.getElementById("dateCreated").value,
                    item_code: document.getElementById("newItemCode").value,
                    item_description: descriptionInput.value,
                    item_category: document.getElementById("newCategory").value,
                    subsidiaryid: document.getElementById("modalSubsidiary").value,
                    subsidiary:
                        document.getElementById("modalSubsidiary").options[
                            document.getElementById("modalSubsidiary").selectedIndex
                        ].text,
                    cost: document.getElementById("newCost").value,
                    primaryUOM:
                        document.getElementById("newPrimaryUOM").options[
                            document.getElementById("newPrimaryUOM").selectedIndex
                        ].text,
                    secondaryUOM:
                        document.getElementById("newSecondaryUOM").options[
                            document.getElementById("newSecondaryUOM").selectedIndex
                        ].text,
                    tertiaryUOM:
                        document.getElementById("newTertiaryUOM").options[
                            document.getElementById("newTertiaryUOM").selectedIndex
                        ].text,
                    qty: document.getElementById("newQuantity").value,
                    remarks: document.getElementById("remarks").value,
                    usage: document.getElementById("newUsage").value,
                };
                axios
                    .post(`/api/create-inventory`, data)
                    .then((response) => {
                        fetchInventory(currentPage);
                        const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("addInventoryModal"));
                        if (requestTransferModal) {
                            requestTransferModal.hide();
                        }
                        setTimeout(() => {
                            fetchInventory(currentPage);
                            // Optionally remove backdrop and reset body styles
                            document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                            document.body.classList.remove("modal-open");
                            document.body.style.overflow = ""; // Resets body overflow style if needed
                        }, 300);
                        alert("Item save successfully!");
                    })
                    .catch((error) => {
                        console.error("Error assigning role:", error);
                        alert("Error saving new Item.", error);
                    });
            });
        }
});
