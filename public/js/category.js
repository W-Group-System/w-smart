document.addEventListener("DOMContentLoaded", function () {
	let selectedCategoryId
    document
        .getElementById("newCategory")
        .addEventListener("click", function () {
            let addCategoryModal = new bootstrap.Modal(
                document.getElementById("addCategoryModal")
            );
            addCategoryModal.show();
        });

    
    document.getElementById('addSubCategoryButton').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const rowCount = document.querySelectorAll('#itemTableBody .input-group').length; 

        if (rowCount >= 5) {
            alert('You can only add a maximum of 5 sub-category items.');
            return;
        }

        const newRowId = `subCategoryName${rowCount}`;
        const newRow = `
            <div class="input-group">
                <input type="text" class="form-control mt-2" id="${newRowId}" placeholder="Enter sub-category name">
            </div>
        `;

        document.getElementById('itemTableBody').insertAdjacentHTML('beforeend', newRow);
        
        const newInput = document.getElementById(newRowId);
        newInput.focus();
    });    

    document.getElementById('addSubCategoryButtonV1').addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const rowCount = document.querySelectorAll('#itemTableBodySubCategory .input-group').length; 

        if (rowCount >= 5) {
            alert('You can only add a maximum of 5 sub-category items.');
            return;
        }

        const newRowId = `subCategoryName${rowCount}`;
        const newRow = `
            <div class="input-group">
                <input type="text" class="form-control mt-2" id="${newRowId}" placeholder="Enter sub-category name">
            </div>
        `;

        document.getElementById('itemTableBodySubCategory').insertAdjacentHTML('beforeend', newRow);
        
        const newInput = document.getElementById(newRowId);
        newInput.focus();
    });



    function loadCategory() {
        let categoryMap = {};
        const categoryList = document.getElementById("categoryList"); // Get the reference to the table body once

        axios
            .get("/api/inventory/categories")
            .then((response) => {
                categoryList.innerHTML = ""; // Clear the table body first

                // Loop through each category
                response.data.data.forEach((category) => {
                    let categoryName = category.name;
                    let id = category.id;

                    // Initialize categoryMap for this category if not already done
                    if (!categoryMap[id]) {
                        categoryMap[id] = { name: categoryName, subcategories: [] };
                    }

                    axios
                        .get(`/api/inventory/subcategories/${id}`)
                        .then((data) => {
                            data.data.data.forEach((subCategory) => {
                                categoryMap[id].subcategories.push(subCategory.name);
                            });
                            updateCategoryList(categoryMap);
                        })
                        .catch((error) => console.error("Error fetching subcategories:", error));
                });
            })
            .catch((error) => console.error("Error fetching categories:", error));
    }

    function updateCategoryList(categoryMap) {
        const categoryList = document.getElementById("categoryList");
        categoryList.innerHTML = ""; // Clear existing rows

        for (let id in categoryMap) {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td>${categoryMap[id].name}</td>
                <td class="text-wrap">${categoryMap[id].subcategories.join(", ")}</td>
                <td><button class="btn btn-danger add-subcategory" data-category-id="${id}">Add Subcategory</button></td>
            `;
            categoryList.appendChild(row);
        }

        // Add event listeners to the newly created buttons
        document.querySelectorAll('.add-subcategory').forEach(button => {
            button.addEventListener('click', function() {
                selectedCategoryId = this.getAttribute('data-category-id');
                let addCategoryModal = new bootstrap.Modal(
                    document.getElementById("addSubCategoryModal")
                );
                addCategoryModal.show();
            });
        });
    }

    function collectSubCategoryValues() {
        const subCategoryInputs = document.querySelectorAll('#itemTableBody input[type="text"]');
        const subCategoryNames = [];

        subCategoryInputs.forEach(input => {
            if (input.value.trim() !== '') { // Check for non-empty input
                subCategoryNames.push(input.value.trim());
            }
        });

        return {"name": subCategoryNames};
    }    

    function collectSubCategoryValuesV1() {
        const subCategoryInputs = document.querySelectorAll('#itemTableBodySubCategory input[type="text"]');
        const subCategoryNames = [];

        subCategoryInputs.forEach(input => {
            if (input.value.trim() !== '') { // Check for non-empty input
                subCategoryNames.push(input.value.trim());
            }
        });

        return subCategoryNames;
    }

    document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const categoryName = document.getElementById("categoryName").value
        const subCategoryNames = collectSubCategoryValues();

        axios.post('/api/inventory/categories', {
        	name: categoryName,
            subcategories: subCategoryNames
        })
        .then(response => {
            alert('Categories saved successfully:');
            document.getElementById('addCategoryForm').reset();
            loadCategory();
            const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("addCategoryModal"));
            if (requestTransferModal) {
                requestTransferModal.hide();
            }
            setTimeout(() => {
                document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                document.body.classList.remove("modal-open");
                document.body.style.overflow = "";
            }, 300);
        })
        .catch(error => {
            console.error('Error saving categories:', error);
        });
    });

    document.getElementById('addSubCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const subCategoryNames = collectSubCategoryValuesV1();

        axios.post('/api/inventory/subcategories', {
        	categoryid: selectedCategoryId,
            subcategories: subCategoryNames
        })
        .then(response => {
            alert('Sub-categories saved successfully!');
            loadCategory();
            const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("addSubCategoryModal"));
            if (requestTransferModal) {
                requestTransferModal.hide();
            }
            setTimeout(() => {
                document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                document.body.classList.remove("modal-open");
                document.body.style.overflow = "";
            }, 300);
        })
        .catch(error => {
            console.error('Error saving categories:', error);
        });
    });

    loadCategory();
});
