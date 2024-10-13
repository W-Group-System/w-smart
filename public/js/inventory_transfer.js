document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submitRequestTransfer");

    function validateItems() {
        const table = document.getElementById("itemsTable");
        const rows = table.getElementsByTagName("tbody")[0].rows;
        let hasValidItems = false;

        Array.from(rows).forEach((row) => {
            const itemCode = row.querySelector("#itemCodeInput").value;
            const itemDescription = row
                .querySelector("#itemDescription")
                .textContent.trim();
            const qty = parseFloat(
                row.querySelector("#qty").textContent.trim()
            );

            if (itemCode && itemDescription && qty > 0) {
                hasValidItems = true;
            }
        });

        const hasSelectedApprovers =
            Array.from(
                document.querySelectorAll(
                    "#approverDropdownMenu .form-check-input:checked"
                )
            ).length > 0;

        submitButton.disabled = !hasValidItems || !hasSelectedApprovers;
    }

    function initializeItemCodeSearch(inputField) {
        const dataList = document.getElementById("itemSuggestions");

        inputField.setAttribute("list", "itemSuggestions"); 

        inputField.addEventListener("input", async function (e) {
            const searchTerm = e.target.value.trim();
            if (searchTerm.length > 1) {
                const transferFromValue = document.getElementById("transferFrom").value;
                try {
                    const response = await fetch('/api/inventory/suggestions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({
                            subsidiaryId: transferFromValue,
                            searchTerm: searchTerm,
                        }),
                    });

                    if (!response.ok) {
                        throw new Error('Failed to fetch data');
                    }

                    const data = await response.json();
                    dataList.innerHTML = '';

                    data.data.forEach((item) => {
                        const option = document.createElement('option');
                        option.value = item.item_code;
                        dataList.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error fetching items:', error);
                }
            }
        });

        inputField.addEventListener("blur", function (e) {
            e.preventDefault();
            const itemCode = inputField.value.trim();
            const transferFromValue = document.getElementById("transferFrom").value;
            if (itemCode && transferFromValue) {
                fetchItemDetails(itemCode, transferFromValue, inputField);
            }
        });
    }

    document.getElementById("addMoreItems").addEventListener("click", function () {
        const table = document.getElementById("itemsTable").getElementsByTagName("tbody")[0];
        const newRow = table.rows[0].cloneNode(true);
    
        newRow.querySelectorAll("td").forEach(function (cell, index) {
            if (index === 0) {
                cell.contentEditable = "true";
                const inputField = cell.querySelector("input");
                if (inputField) {
                    inputField.value = "";
                    initializeItemCodeSearch(inputField); 
                }
            } else if (index === 3) {
                const uomDropdown = cell.querySelector('.uom-dropdown');
                populateUOMOptions("", "", "", uomDropdown);
            } else if (index === 6) {
                cell.contentEditable = "true";
                cell.innerText = "";
            } else {
                cell.innerText = "";
                cell.contentEditable = "false";
            }
        });
    
        table.appendChild(newRow);
        validateItems();
    });

    const initialInputField = document.getElementById("itemCodeInput");
    if (initialInputField) {
        initializeItemCodeSearch(initialInputField);
    }

    // Subsidiary Dropdown
    const transferFrom = document.getElementById("transferFrom");
    const transferTo = document.getElementById("transferTo");

    function updateTransferToOptions() {
        const selectedFromValue = transferFrom.value;

        Array.from(transferTo.options).forEach((option) => {
            option.disabled = false;
        });

        if (selectedFromValue) {
            Array.from(transferTo.options).forEach((option) => {
                if (option.value === selectedFromValue) {
                    option.disabled = true;
                }
            });
        }
    }

    transferFrom.addEventListener("change", updateTransferToOptions);
    updateTransferToOptions();

    const transactionDateInput = document.getElementById("transactionDate");
    const transactionNumberInput = document.getElementById("transactionNumber");
    const today = new Date().toISOString().split("T")[0].replace(/-/g, "");

    transactionDateInput.value = new Date().toISOString().split("T")[0];

    let incrementNumber =
        localStorage.getItem("transactionIncrement") || "00001";
    transactionNumberInput.value = `TRANSFER-${today}-${incrementNumber}`;

    localStorage.setItem(
        "transactionIncrement",
        (parseInt(incrementNumber) + 1).toString().padStart(5, "0")
    );

    // Item Code Search
    document.getElementById("itemCodeInput").addEventListener("blur", function (e) {
        e.preventDefault();
        const itemCode = e.target.value;
        const transferFromValue = document.getElementById("transferFrom").value;
        if (itemCode && transferFromValue) {
            fetchItemDetails(itemCode, transferFromValue, e.target);
        }
    });

    function fetchItemDetails(itemCode, subsidiaryId, targetCell) {
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
                    const row = targetCell.closest("tr");
    
                    row.querySelector("#itemDescription").textContent = item.item_description;
                    row.querySelector("#itemCategory").textContent = item.item_category;
                    row.querySelector("#qty").textContent = item.qty;
                    row.querySelector("#cost").textContent = item.cost;
                    row.querySelector("#usage").textContent = item.usage;
    
                    const uomDropdown = row.querySelector(".uom-dropdown");
                    populateUOMOptions(item.uomp, item.uoms, item.uomt, uomDropdown);
    
                    const qtyCell = row.querySelector("#qty");
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
                    alert(`${response.data.message} Please check the correct subsidiary.`);
                } else {
                    alert("Item not found in the inventory.");
                }
            })
            .catch((error) => {
                console.error("Error fetching item details:", error);
                alert("Failed to fetch item details. Please try again.");
            });
    }

    submitButton.addEventListener("click", function () {
        const transactionNumber = document.getElementById("transactionNumber").value;
        const transferFrom = document.getElementById("transferFrom").value;
        const transferTo = document.getElementById("transferTo").value;
        const remarks = document.getElementById("remarks").value;
    
        const items = Array.from(document.querySelectorAll("#itemsTable tbody tr")).map((row) => {
            const itemCode = row.querySelector("#itemCodeInput").value;
            const qty = parseFloat(row.querySelector("#qty").textContent.trim());
    
            const uomDropdown = row.querySelector(".uom-dropdown");
            const selectedUOM = uomDropdown ? uomDropdown.value : '';

            let uomp, uoms, uomt;

            switch (selectedUOM) {
                case 'primary':
                    uomp = selectedUOM;
                    uoms = uomDropdown.options[1].text;  
                    uomt = uomDropdown.options[2].text;  
                    break;
                case 'secondary':
                    uomp = uomDropdown.options[1].text;  
                    uoms = uomDropdown.options[0].text;  
                    uomt = uomDropdown.options[2].text;  
                    break;
                case 'tertiary':
                    uomp = uomDropdown.options[2].text;  
                    uoms = uomDropdown.options[0].text; 
                    uomt = uomDropdown.options[1].text; 
                    break;
                default:
                    uomp = selectedUOM;
                    uoms = '';
                    uomt = '';
            }

            // Log the UOM values to ensure they are being swapped correctly
            console.log("UOM Values for Item:", {
                itemCode: itemCode,
                uomp: uomp,
                uoms: uoms,
                uomt: uomt,
                qty: qty
            });

            return {
                item_code: itemCode,
                qty: qty,
                uomp: uomp, 
                uoms: uoms,  
                uomt: uomt  
            };
        }).filter((item) => item.item_code && item.qty > 0 && item.uomp && item.uoms && item.uomt); 
    
        const selectedRoleIds = Array.from(
            document.querySelectorAll(
                "#approverDropdownMenu .form-check-input:checked"
            )
        ).map((input) => input.value).filter((value) => value);
    
        if (items.length === 0) {
            alert("Please add at least one valid item before submitting.");
            return;
        }
    
        axios.post("/api/inventory/transfer/request", {
                transact_id: transactionNumber,
                transfer_from: transferFrom,
                transfer_to: transferTo,
                items: items,
                remarks: remarks,
                approver_roles: selectedRoleIds,
                status: "Pending",
            })
            .then((response) => {
                alert(response.data.message || "Transfer request submitted.");
                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("requestTransferModal"));
                if (requestTransferModal) {
                    requestTransferModal.hide();
                }
                clearTransferModal();
            })
            .catch((error) => {
                alert("Failed to submit the transfer request. Please try again.");
                console.error(error);
            });
    });

    const approveTransferButton = document.getElementById(
        "approveTransferButton"
    );

    document.querySelectorAll(".clickable-row").forEach((row) => {
        row.addEventListener("click", function () {
            const transactionNumber = this.querySelector("td:nth-child(3)").textContent.trim();
            const approverRoles = this.dataset.approverRoles ? this.dataset.approverRoles.split(",") : [];
            const userRole = document.getElementById("userRole").value;
    
            if (approverRoles.length > 0 && !approverRoles.includes(userRole)) {
                console.warn("User is unauthorized to approve this transfer.");
                alert("You are unauthorized to approve this transfer.");
                return;
            }
    
            document.getElementById("approveTransferButton").dataset.transactionNumber = transactionNumber;
    
            const approveTransferModal = new bootstrap.Modal(
                document.getElementById("approveTransferModal")
            );
            approveTransferModal.show();
        });
    });

    approveTransferButton.addEventListener("click", function () {
        const transactionNumber =
            approveTransferButton.dataset.transactionNumber;
        const approvedBy = document.getElementById("userName").value;

        axios
            .post(`/api/inventory/transfer/approve/${transactionNumber}`, {
                approved_by: approvedBy,
            })
            .then((response) => {
                alert(response.data.message || "Transfer approved.");
                const approveTransferModal = new bootstrap.Modal(
                    document.getElementById("approveTransferModal")
                );
                approveTransferModal.hide();

                location.reload();
            })
            .catch((error) => {
                alert("Failed to approve the transfer. Please try again.");
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
            row.querySelector("#primaryUOM").textContent = "";
            row.querySelector("#secondaryUOM").textContent = "";
            row.querySelector("#tertiaryUOM").textContent = "";
            row.querySelector("#qty").textContent = "";
            row.querySelector("#cost").textContent = "";
            row.querySelector("#usage").textContent = "";
        });

        document.getElementById("remarks").value = "";
        document.getElementById("transferFrom").value = "1";
        document.getElementById("transferTo").value = "2";

        const today = new Date().toISOString().split("T")[0].replace(/-/g, "");
        let incrementNumber =
            localStorage.getItem("transactionIncrement") || "00001";
        document.getElementById(
            "transactionNumber"
        ).value = `TRANSFER-${today}-${incrementNumber}`;

        localStorage.setItem(
            "transactionIncrement",
            (parseInt(incrementNumber) + 1).toString().padStart(5, "0")
        );
    }

    document.getElementById("itemCodeInput").addEventListener("input", async (e) => {
        const searchTerm = e.target.value.trim();
        if (searchTerm.length > 1) {
            const transferFromValue = document.getElementById("transferFrom").value;
            try {
                const response = await fetch('/api/inventory/suggestions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify({
                        subsidiaryId: transferFromValue,
                        searchTerm: searchTerm,
                    }),
                });
    
                if (!response.ok) {
                    throw new Error('Failed to fetch data');
                }
    
                const data = await response.json();
                const suggestions = document.getElementById('itemSuggestions');
                suggestions.innerHTML = '';
    
                data.data.forEach((item) => {
                    const option = document.createElement('option');
                    option.value = item.item_code;
                    suggestions.appendChild(option);
                });
            } catch (error) {
                console.error('Error fetching items:', error);
            }
        }
    });

    validateItems();

    let selectedApprovers = new Set();
    let fetchedRoles = [];

    document.getElementById("approverDropdown").addEventListener("click", function () {
        const dropdownMenu = document.getElementById("approverDropdownMenu");
    
        if (dropdownMenu.style.display === "none") {
            if (fetchedRoles.length === 0) {
                axios
                    .get("/api/roles")
                    .then((response) => {
                        if (response.data.status === "success") {
                            fetchedRoles = response.data.data;
                            populateDropdownMenu(fetchedRoles);
                        } else {
                            alert("Failed to fetch roles.");
                        }
                    })
                    .catch((error) => {
                        console.error("Error fetching roles:", error);
                        alert("An error occurred while fetching roles.");
                    });
            } else {
                populateDropdownMenu(fetchedRoles);
            }
            dropdownMenu.style.display = "block";
        } else {
            dropdownMenu.style.display = "none";
        }
    });

    function populateDropdownMenu(roles) {
        const dropdownMenu = document.getElementById("approverDropdownMenu");
        dropdownMenu.innerHTML = "";
    
        roles.forEach((role) => {
            const roleElement = document.createElement("div");
            roleElement.className = "form-check";
            roleElement.style.marginLeft = "30px";
    
            const checkbox = document.createElement("input");
            checkbox.className = "form-check-input";
            checkbox.type = "checkbox";
            checkbox.value = role.id.toString(); // Ensure role ID is stored as a string
            checkbox.id = `approver${role.id}`;
    
            // Restore checked state if previously selected
            checkbox.checked = selectedApprovers.has(role.id.toString());
    
            const label = document.createElement("label");
            label.className = "form-check-label";
            label.htmlFor = `approver${role.id}`;
            label.textContent = role.role;
    
            roleElement.appendChild(checkbox);
            roleElement.appendChild(label);
            dropdownMenu.appendChild(roleElement);
        });
    
        document
            .querySelectorAll("#approverDropdownMenu .form-check-input")
            .forEach((checkbox) => {
                checkbox.addEventListener("change", function () {
                    if (checkbox.checked) {
                        selectedApprovers.add(checkbox.value);
                    } else {
                        selectedApprovers.delete(checkbox.value);
                    }
    
                    const selectedApproversText = Array.from(selectedApprovers).map(
                        (id) =>
                            document.querySelector(`label[for="approver${id}"]`)
                                .textContent
                    );
                    const approversList = document.getElementById("selectedApprovers");
                    approversList.textContent =
                        selectedApproversText.length > 0
                            ? selectedApproversText.join(", ")
                            : "No approver selected";
    
                    validateItems();
                });
            });
    }

    document.addEventListener("click", function (event) {
        const dropdownButton = document.getElementById("approverDropdown");
        const dropdownMenu = document.getElementById("approverDropdownMenu");
        if (
            !dropdownButton.contains(event.target) &&
            !dropdownMenu.contains(event.target)
        ) {
            dropdownMenu.style.display = "none";
        }
    });

    function populateUOMOptions(primaryUOM, secondaryUOM, tertiaryUOM, dropdown) {
        dropdown.innerHTML = '';
    
        const uomOptions = [
            { label: primaryUOM, value: 'primary' },
            { label: secondaryUOM, value: 'secondary' },
            { label: tertiaryUOM, value: 'tertiary' }
        ];
    
        uomOptions.forEach((uom, index) => {
            const option = document.createElement('option');
            option.value = uom.value;
            option.textContent = uom.label;
            dropdown.appendChild(option);
            if (index === 0) {
                option.selected = true;
            }
        });
    }
    
    document.querySelectorAll('.uom-dropdown').forEach(function (dropdown) {
        dropdown.addEventListener('change', function () {
            const row = dropdown.closest('tr');
    
            // Make sure the UOM elements exist before accessing them
            const primaryUOMElement = row.querySelector("#primaryUOM");
            const secondaryUOMElement = row.querySelector("#secondaryUOM");
            const tertiaryUOMElement = row.querySelector("#tertiaryUOM");
    
            if (primaryUOMElement && secondaryUOMElement && tertiaryUOMElement) {
                let primaryUOM = primaryUOMElement.textContent.trim();
                let secondaryUOM = secondaryUOMElement.textContent.trim();
                let tertiaryUOM = tertiaryUOMElement.textContent.trim();
    
                const selectedUOM = dropdown.value;
    
                // Swap logic based on the selected UOM
                switch (selectedUOM) {
                    case 'primary':
                        break;
                    case 'secondary':
                        [primaryUOM, secondaryUOM] = [secondaryUOM, primaryUOM];
                        break;
                    case 'tertiary':
                        [primaryUOM, tertiaryUOM] = [tertiaryUOM, primaryUOM];
                        break;
                }
    
                // Update the UOM display in the table row
                primaryUOMElement.textContent = primaryUOM;
                secondaryUOMElement.textContent = secondaryUOM;
                tertiaryUOMElement.textContent = tertiaryUOM;
    
                // Repopulate the dropdown with updated UOMs
                populateUOMOptions(primaryUOM, secondaryUOM, tertiaryUOM, dropdown);
            }
        });
    });
});
