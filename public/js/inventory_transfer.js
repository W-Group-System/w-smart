document.addEventListener("DOMContentLoaded", function () {
    const submitButton = document.getElementById("submitRequestTransfer");

    function validateItems() {
        const table = document.getElementById("itemsTable");
        const rows = table.getElementsByTagName("tbody")[0].rows;
        let hasValidItems = false;

        Array.from(rows).forEach((row) => {
            const itemCode = row.querySelector("#itemCode").textContent.trim();
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

        submitButton.disabled = !hasValidItems;
    }

    function initializeItemCodeSearch(cell) {
        cell.addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                const itemCode = cell.textContent.trim();
                const transferFromValue =
                    document.getElementById("transferFrom").value;
                if (itemCode && transferFromValue) {
                    fetchItemDetails(itemCode, transferFromValue, cell);
                }
            }
        });
    }

    document
        .getElementById("addMoreItems")
        .addEventListener("click", function () {
            var table = document
                .getElementById("itemsTable")
                .getElementsByTagName("tbody")[0];
            var newRow = table.rows[0].cloneNode(true);

            newRow.querySelectorAll("td").forEach(function (cell, index) {
                if (index === 0) {
                    cell.contentEditable = "true";
                    cell.innerText = "";
                    initializeItemCodeSearch(cell);
                } else if (index === 6) {
                    cell.contentEditable = "true";
                    cell.innerText = "";
                } else {
                    cell.innerText = "";
                }
            });

            table.appendChild(newRow);
            validateItems();
        });

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
    document
        .getElementById("itemCode")
        .addEventListener("keypress", function (e) {
            if (e.key === "Enter") {
                e.preventDefault();
                const itemCode = e.target.textContent.trim();
                const transferFromValue =
                    document.getElementById("transferFrom").value;
                if (itemCode && transferFromValue) {
                    fetchItemDetails(itemCode, transferFromValue, e.target);
                }
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
                    row.querySelector("#itemDescription").textContent =
                        item.item_description;
                    row.querySelector("#itemCategory").textContent =
                        item.item_category;
                    row.querySelector("#primaryUOM").textContent = item.uomp;
                    row.querySelector("#secondaryUOM").textContent = item.uoms;
                    row.querySelector("#tertiaryUOM").textContent = item.uomt;
                    row.querySelector("#qty").textContent = item.qty;
                    row.querySelector("#cost").textContent = item.cost;
                    row.querySelector("#usage").textContent = item.usage;

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
                    alert(
                        `${response.data.message} Please check the correct subsidiary.`
                    );
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
        const transactionNumber =
            document.getElementById("transactionNumber").value;
        const transferFrom = document.getElementById("transferFrom").value;
        const transferTo = document.getElementById("transferTo").value;
        const remarks = document.getElementById("remarks").value;

        const items = Array.from(
            document.querySelectorAll("#itemsTable tbody tr")
        )
            .map((row) => {
                return {
                    item_code: row
                        .querySelector("#itemCode")
                        .textContent.trim(),
                    qty: parseFloat(
                        row.querySelector("#qty").textContent.trim()
                    ),
                };
            })
            .filter((item) => item.item_code && item.qty > 0);

        if (items.length === 0) {
            alert("Please add at least one valid item before submitting.");
            return;
        }

        axios
            .post("/api/inventory/transfer/request", {
                transact_id: transactionNumber,
                transfer_from: transferFrom,
                transfer_to: transferTo,
                items: items,
                remarks: remarks,
                status: "Pending",
            })
            .then((response) => {
                alert(response.data.message || "Transfer request submitted.");

                const requestTransferModal = new bootstrap.Modal(
                    document.getElementById("requestTransferModal")
                );
                requestTransferModal.hide();

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

    const approveTransferButton = document.getElementById(
        "approveTransferButton"
    );

    document.querySelectorAll(".clickable-row").forEach((row) => {
        row.addEventListener("click", function () {
            const transactionNumber =
                this.querySelector("td:nth-child(3)").textContent.trim();
            document.getElementById(
                "approveTransferButton"
            ).dataset.transactionNumber = transactionNumber;

            const approveTransferModal = new bootstrap.Modal(
                document.getElementById("approveTransferModal")
            );
            approveTransferModal.show();
        });
    });

    approveTransferButton.addEventListener("click", function () {
        const transactionNumber =
            approveTransferButton.dataset.transactionNumber;
        const approveRemarks = document
            .getElementById("approveRemarks")
            .value.trim();

        axios
            .post(`/api/inventory/transfer/approve/${transactionNumber}`, {
                remarks: approveRemarks,
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
            row.querySelector("#itemCode").textContent = "";
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

    validateItems();
});
