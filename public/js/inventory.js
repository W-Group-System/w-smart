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
    let selectedCategoryId = 1;
    let selectedCategoryName;
    let selectedSubCategoryId = 0;
    let selectedSubCategoryName;
    let rowsPerPage = parseInt(rowsPerPageSelect.value, 10) || 10;
    let selectedText = subsidiary.selectedOptions[0].text;
    subsidiary.addEventListener("change", function () {
        selectedText = subsidiary.selectedOptions[0].text;
    });
    let formattedItemCode;

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
                    if (data.data.length <= 0) {
                        let maxItemCode = 0;

                        let newItemCode = maxItemCode + 1;

                        formattedItemCode = newItemCode.toString().padStart(4, '0');
                        generateItemCode();
                    }
                    else
                    {
                        let parts = data.data[data.data.length - 1].item_code.split('-');

                        let itemNumber = parts[2];

                        let incrementedItemNumber = parseInt(itemNumber) + 1;

                        formattedItemCode = incrementedItemNumber.toString().padStart(4, '0')
                        generateItemCode();
                    }
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
    function generateItemCode() {
        const categoryCode = selectedCategoryId.toString().padStart(2, '0') || "00";
        const subcategoryCode = selectedSubCategoryId.toString().padStart(3, '0') || "000";
        document.getElementById("newItemCode").value = `${categoryCode}-${subcategoryCode}-${formattedItemCode}`;
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


    const addInventoryButton = document.getElementById("addInventory");

    function updateDateTime() {
        const now = new Date();
        const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
        const philippineTime = new Date(utcTime + (8 * 60 * 60 * 1000));
        const formattedDateTime = `${philippineTime.toISOString().split("T")[0]} ${philippineTime.toTimeString().split(' ')[0]}`;
        
        // Update the dateCreated input field
        document.getElementById("dateCreated").value = formattedDateTime;
    }


    if (addInventoryButton) {
        addInventoryButton.addEventListener("click", async (e) => {
            e.preventDefault();
            getSelectedCategory();
            getSelectedSubCategory();
            const now = new Date();
            const utcTime = now.getTime() + (now.getTimezoneOffset() * 60000);
            const philippineTime = new Date(utcTime + (8 * 60 * 60 * 1000));
            updateDateTime();
            setInterval(updateDateTime, 100);
            const formattedDateTime = `${philippineTime.toISOString().split("T")[0]} ${philippineTime.toTimeString().split(' ')[0]}`;
            document.getElementById("dateCreated").value = updateDateTime;
        });
    } else {
        console.warn("Element with ID 'addInventory' not found.");
    }

    async function populateCategories() {
        try {

            const response = await axios.get('/api/inventory/categories');

            const categories = await response.data.data;
            
            const categorySelect = document.getElementById('newCategory');
            
            categorySelect.innerHTML = '';
            
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.text = category.name;
                categorySelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    }

    async function getSelectedCategory() {
        const selectElement = document.getElementById('newCategory');
        const selectedOption = selectElement.options[selectElement.selectedIndex];
        selectedCategoryId = selectedOption.value;
        selectedCategoryName = selectedOption.text;
        try {
            if(selectedCategoryId) {
                const response = await axios.get(`/api/inventory/subcategories/${selectedCategoryId}`);

                const categories = await response.data.data;
                
                const categorySelect = document.getElementById('subCategory');
                
                categorySelect.innerHTML = '';
                
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.text = category.name;
                    categorySelect.appendChild(option);
                });    

                generateItemCode();

            }
            else {
                const response = await axios.get(`/api/inventory/subcategories/1`);

                const categories = await response.data.data;
                
                const categorySelect = document.getElementById('subCategory');
                
                categorySelect.innerHTML = '';
                
                categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.text = category.name;
                    categorySelect.appendChild(option);
                });

                selectElementSubCategory = document.getElementById('subCategory');
                selectedOptionSubCategory = selectElementSubCategory.options[selectElementSubCategory.selectedIndex];
                selectedSubCategoryId = selectedOptionSubCategory.value;
                selectedSubCategoryName = selectedOptionSubCategory.text;
                generateItemCode();
            }
            
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    }

    async function getSelectedSubCategory() {

        const selectElementSubCategory = document.getElementById('subCategory');
        const selectedOptionSubCategory = selectElementSubCategory.options[selectElementSubCategory.selectedIndex];
        selectedSubCategoryId = selectedOptionSubCategory.value;
        selectedSubCategoryName = selectedOptionSubCategory.text;

        try {

            generateItemCode();
            
        } catch (error) {
            console.error('Error fetching categories:', error);
        }
    }

    document.getElementById('newCategory').addEventListener('change', getSelectedCategory);

    document.getElementById('subCategory').addEventListener('change', getSelectedSubCategory);

    generateItemCode();

    populateCategories();

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
                    category_id: selectedCategoryId,
                    item_category: selectedCategoryName,
                    subcategory_id: selectedSubCategoryId,
                    subcategory_name: selectedSubCategoryName,
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
