document.addEventListener("DOMContentLoaded", function () {
    const startDateInput = document.getElementById("start-date");
    const endDateInput = document.getElementById("end-date");
    const subsidiary = document.getElementById("subsidiary");
    const rowsPerPageSelect = document.querySelector("select.form-select-sm");
    const tableBody = document.querySelector("tbody");
    const totalItemsText = document.querySelector(".dynamic-rows-info");
    const pagination = document.querySelector("ul.pagination");
    const form = document.getElementById("filter-submit");
    const searchInput = document.getElementById("searchInput");

    let currentPage = 1;
    let rowsPerPage = parseInt(rowsPerPageSelect.value, 10) || 10;

    function getFormattedDate(date) {
        let year = date.getFullYear();
        let month = ("0" + (date.getMonth() + 1)).slice(-2);
        let day = ("0" + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    const today = new Date();
    startDateInput.value = getFormattedDate(today);
    endDateInput.value = getFormattedDate(today);

    function fetchEquipment(page, search) {
        axios
            .get(`/api/equipment`, {
                params: {
                    page: page,
                    per_page: rowsPerPage,
                    start_date: startDateInput.value,
                    end_date: endDateInput.value,
                    subsidiary: subsidiary.value,
                    search: search,
                },
            })
            .then((response) => {
                const data = response.data;
                if (data.status === "success") {
                    initializeDynamicTable(
                        data.data,
                        data.pagination.total_items
                    );
                    updatePagination(data.pagination);
                } else {
                    console.error("Failed to fetch equipment:", data.message);
                }
            })
            .catch((error) => {
                console.error("Error fetching equipment:", error);
                alert(
                    "An error occurred while fetching equipment: " +
                        (error.response?.data?.message || error.message)
                );
            });
    }

    function initializeDynamicTable(equipmentData, totalPages) {
        renderTable(equipmentData, totalPages);
    }

    function renderTable(equipmentData, totalPages) {
        tableBody.innerHTML = "";

        equipmentData.forEach((item, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="text-center">${item.id}</td>
                <td class="text-center">${new Date(
                    item.date_purchased
                ).toLocaleDateString()}</td>
                <td class="text-center">${item.asset_name}</td>
                <td class="text-center">${item.asset_code}</td>
                <td class="text-center">${item.type}</td>
                <td class="text-center">${item.subcategory}</td>
                <td class="text-center">${item.status}</td>
                <td class="text-center">${item.subsidiary}</td>
                <td class="text-center">${item.remarks}</td>
                <td class="text-center">${item.asset_value}</td>
                <td class="text-center">
                    <button class="btn btn-info btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#viewAssetModal"
                        data-asset-id="${item.id}"
                        data-asset-name="${item.asset_name}"
                        data-asset-code="${item.asset_code}"
                        data-date-acquired="${item.date_acquired}"
                        data-date-purchased="${item.date_purchased}"
                        data-date-installation="${item.date_installation}"
                        data-date-transferred="${item.date_transferred}"
                        data-date-repaired="${item.date_repaired}"
                        data-type="${item.type}"
                        data-location="${item.location}"
                        data-category="${item.category}"
                        data-category-id="${item.category_id}"
                        data-subcategory="${item.subcategory}"
                        data-subcategory-id="${item.subcategory_id}"
                        data-status="${item.status}"
                        data-subsidiary="${item.subsidiary}"
                        data-subsidiary-id="${item.subsidiaryid}"
                        data-remarks="${item.remarks}"
                        data-assigned-to="${item.assigned_to}"
                        data-estimated-useful-life="${item.estimated_useful_life}"
                        data-serial-number="${item.serial_number}"
                        data-equipment-model="${item.equipment_model}"
                        data-warranty="${item.warranty}"
                        data-po-number="${item.po_number}"
                        data-brand="${item.brand}"
                        data-specifications="${item.specifications}"
                        data-asset-value="${item.asset_value}"
                        data-item-code="${item.item_code}"
                        data-updated-at="${item.updated_at}"
                        data-created-at="${item.created_at}">
                        View
                    </button>
                </td>
            `;
            tableBody.appendChild(row);

            const viewButton = row.querySelector(".btn-info");
            if (viewButton) {
                viewButton.addEventListener("click", function () {
                    const assetId = item.id;
                    viewAsset(assetId);
                });
            }
        });

        totalItemsText.textContent = `Showing ${equipmentData.length} of ${totalPages}`; // Update the pagination text
    }

    function viewAsset(assetId) {
        const button = document.querySelector(
            `[data-bs-target="#viewAssetModal"][data-asset-id="${assetId}"]`
        );

        if (!button) return;

        const assetName = button.getAttribute("data-asset-name");
        const assetCode = button.getAttribute("data-asset-code");
        const dateAcquired = button.getAttribute("data-date-acquired");
        const dateInstallation = button.getAttribute("data-date-installation");
        const datePurchased = button.getAttribute("data-date-purchased");
        const dateTransferred = button.getAttribute("data-date-transferred");
        const dateRepaired = button.getAttribute("data-date-repaired");
        const type = button.getAttribute("data-type");
        const category = button.getAttribute("data-subcategory");
        const location = button.getAttribute("data-location");
        const estimatedUsefulLife = button.getAttribute("data-estimated-useful-life");
        const status = button.getAttribute("data-status");
        const subsidiary = button.getAttribute("data-subsidiary");
        const remarks = button.getAttribute("data-remarks");
        const assignedTo = button.getAttribute("data-assigned-to");
        const serialNumber = button.getAttribute("data-serial-number");
        const equipmentModel = button.getAttribute("data-equipment-model");
        const warranty = button.getAttribute("data-warranty");
        const poNumber = button.getAttribute("data-po-number");
        const brand = button.getAttribute("data-brand");
        const specifications = button.getAttribute("data-specifications");
        const assetValue = button.getAttribute("data-asset-value");

        const formattedDateAcquired = new Date(dateAcquired).toISOString().split('T')[0];
        const formattedDateInstallation = new Date(dateInstallation).toISOString().split('T')[0];
        const formattedDatePurchased = new Date(datePurchased).toISOString().split('T')[0];
        const formattedDateTransferred = new Date(dateTransferred).toISOString().split('T')[0];
        const formattedDateRepaired = new Date(dateRepaired).toISOString().split('T')[0];

        document.getElementById("viewAssetName").value = assetName;
        document.getElementById("viewAssetCode").value = assetCode;
        document.getElementById("viewDateAcquired").value = formattedDateAcquired;
        document.getElementById("viewDateInstallation").value = formattedDateInstallation;
        document.getElementById("viewDatePurchased").value = formattedDatePurchased;
        document.getElementById("viewDateTransferred").value = formattedDateTransferred;
        document.getElementById("viewDateRepaired").value = formattedDateRepaired;
        document.getElementById("viewType").value = type;
        document.getElementById("viewCategory").value = category;
        document.getElementById("viewEstimatedUsefulLife").value = estimatedUsefulLife;
        document.getElementById("viewLocation").value = location;
        document.getElementById("viewStatus").value = status;
        document.getElementById("viewSubsidiary").value = subsidiary;
        document.getElementById("viewRemarks").value = remarks;
        document.getElementById("viewAssignedTo").value = assignedTo;
        document.getElementById("viewSerialNumber").value = serialNumber;
        document.getElementById("viewEquipmentModel").value = equipmentModel;
        document.getElementById("viewWarranty").value = warranty;
        document.getElementById("viewPONumber").value = poNumber;
        document.getElementById("viewBrand").value = brand;
        document.getElementById("viewSpecifications").value = specifications;
        document.getElementById("viewAssetValue").value = assetValue;

        const viewModal = new bootstrap.Modal(
            document.getElementById("viewAssetModal")
        );
        viewModal.show();
    }

    function updatePagination(paginationData) {
        pagination.innerHTML = "";

        const totalPages = paginationData.total_pages || 1;
        const currentPage = paginationData.current_page || 1;

        const prevPage = document.createElement("li");
        prevPage.classList.add("page-item");
        if (currentPage === 1) prevPage.classList.add("disabled");
        prevPage.innerHTML = `<a class="page-link" href="#">&laquo;</a>`;
        prevPage.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage > 1) fetchEquipment(currentPage - 1);
        });
        pagination.appendChild(prevPage);

        for (let i = 1; i <= totalPages; i++) {
            const pageItem = document.createElement("li");
            pageItem.classList.add("page-item");
            if (i === currentPage) pageItem.classList.add("active");
            pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            pageItem.addEventListener("click", (e) => {
                e.preventDefault();
                fetchEquipment(i);
            });
            pagination.appendChild(pageItem);
        }

        const nextPage = document.createElement("li");
        nextPage.classList.add("page-item");
        if (currentPage === totalPages) nextPage.classList.add("disabled");
        nextPage.innerHTML = `<a class="page-link" href="#">&raquo;</a>`;
        nextPage.addEventListener("click", (e) => {
            e.preventDefault();
            if (currentPage < totalPages) fetchEquipment(currentPage + 1);
        });
        pagination.appendChild(nextPage);
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();
        fetchEquipment(currentPage);
    });

    rowsPerPageSelect.addEventListener("change", function () {
        rowsPerPage = parseInt(this.value, 10);
        currentPage = 1;
        fetchEquipment(currentPage);
    });

    searchInput.addEventListener("input", function () {
        const search = this.value;
        fetchEquipment(currentPage, search);
    });

    fetchEquipment(currentPage);

    // Add Assets
    const categorySelect = document.getElementById("category");
    const subsidiarySelect = document.getElementById("subsidiaryModal");
    const assetCodeInput = document.getElementById("assetCode");

    let randomNumber = generateRandomNumber();

    function generateRandomNumber() {
        return String(Math.floor(1000 + Math.random() * 9000)).padStart(4, "0");
    }

    const requiredFields = [
        "assetName",
        "assetCode",
        "datePurchased",
        "dateAcquired",
        "type",
        "status",
        "subsidiary",
        "assetValue",
    ];

    async function fetchSubcategories() {
        try {
            const response = await axios.get(`/api/inventory/subcategories/2`);
            const data = response.data;

            if (data.status === "success") {
                categorySelect.innerHTML = `<option value="" disabled selected>Select a category</option>`;
                data.data.forEach((subcategory) => {
                    const option = document.createElement("option");
                    option.value = subcategory.id;
                    option.textContent = subcategory.name;
                    categorySelect.appendChild(option);
                });
                categorySelect.disabled = false;
            } else {
                console.error("Failed to fetch subcategories:", data.message);
            }
        } catch (error) {
            console.error("Error fetching subcategories:", error);
            alert(
                "An error occurred while fetching subcategories: " +
                    (error.response?.data?.message || error.message)
            );
        }
    }

    categorySelect.addEventListener("change", function () {
        const subcategoryIndex = categorySelect.selectedIndex - 1;
        if (subcategoryIndex >= 0) {
            const assetCode = `02-${String(subcategoryIndex + 1).padStart(
                3,
                "0"
            )}-${randomNumber}`;
            assetCodeInput.value = assetCode;
        }
    });

    assetCodeInput.readOnly = true;

    fetchSubcategories();

    async function fetchSubsidiaries() {
        try {
            const response = await axios.get("/api/subsidiary");
            const data = response.data;

            if (data.status === "success") {
                subsidiarySelect.innerHTML = `<option value="" disabled selected>Select a category</option>`;
                data.data.forEach((subsidiary) => {
                    const option = document.createElement("option");
                    option.value = subsidiary.subsidiary_id;
                    option.textContent = subsidiary.subsidiary_name;

                    subsidiarySelect.appendChild(option);
                });
                subsidiarySelect.disabled = false;
            } else {
                console.error("Failed to fetch subsidiaries:", data.message);
                alert("Could not load subsidiaries. Please try again later.");
            }
        } catch (error) {
            console.error("Error fetching subsidiaries:", error);
            alert(
                "An error occurred while fetching subsidiaries: " +
                    error.message
            );
        }
    }

    fetchSubsidiaries();

    const addAssetModal = document.getElementById("addAssetModal");

    addAssetModal.addEventListener("show.bs.modal", function () {
        randomNumber = generateRandomNumber();
        assetCodeInput.value = "";
    });

    document
        .getElementById("saveAssetButton")
        .addEventListener("click", async function () {
            const form = document.getElementById("addAssetForm");
            let formIsValid = true;

            requiredFields.forEach((fieldId) => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add("is-invalid");
                    formIsValid = false;
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            if (!formIsValid) {
                alert("Please fill out all required fields.");
                return;
            }

            const formData = new FormData(form);

            const selectedSubsidiary =
                subsidiarySelect.options[subsidiarySelect.selectedIndex];
            const subsidiaryId = selectedSubsidiary
                ? selectedSubsidiary.value
                : null;
            const subsidiaryName = selectedSubsidiary
                ? selectedSubsidiary.textContent
                : "";

            formData.append("subsidiary_id", subsidiaryId);
            formData.append("subsidiary", subsidiaryName);

            const selectedCategory =
                categorySelect.options[categorySelect.selectedIndex];
            formData.append("subcategory_id", selectedCategory.value);
            formData.append("subcategory", selectedCategory.textContent);

            try {
                console.log(
                    "Sending request to /api/equipment/create with Axios"
                );
                const response = await axios.post(
                    "/api/equipment/create",
                    formData,
                    {
                        headers: {
                            "Content-Type": "multipart/form-data",
                        },
                    }
                );

                console.log("Response:", response.data);
                if (response.data.status === "success") {
                    alert("Equipment created successfully!");
                    const addAssetModal = bootstrap.Modal.getInstance(
                        document.getElementById("addAssetModal")
                    );
                    if (addAssetModal) {
                        addAssetModal.hide();
                    }
                    fetchEquipment(1);
                } else {
                    alert(
                        "Failed to create equipment: " + response.data.message
                    );
                }
            } catch (error) {
                console.error("Error creating equipment:", error);
                alert(
                    "An error occurred while creating the equipment: " +
                        (error.response?.data?.message || error.message)
                );
            }
        });
});
