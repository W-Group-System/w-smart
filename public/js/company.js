document.addEventListener("DOMContentLoaded", function () {
    document
        .getElementById("newCompany")
        .addEventListener("click", function () {
            let addCategoryModal = new bootstrap.Modal(
                document.getElementById("addCompanyModal")
            );
            addCategoryModal.show();
        });

        function loadCompany() {
            let categoryMap = {};
            const categoryList = document.getElementById("companyList"); // Get the reference to the table body once
        
            axios
                .get("/api/company")
                .then((response) => {

                    categoryList.innerHTML = ""; // Clear the table body first
        
                    // Loop through each company in the response data
                    response.data.data.forEach((company) => {
                        console.log(company)
                        let companyName = company.subsidiary_name;
                        let id = company.subsidiary_id;
        
                        // Create a new table row
                        let row = document.createElement("tr");
        
                        // Create the cells for the company name and ID
                        let nameCell = document.createElement("td");
                        nameCell.textContent = companyName;
                        let idCell = document.createElement("td");
                        idCell.textContent = id;
        
                        // Append the cells to the row
                        row.appendChild(idCell);
                        row.appendChild(nameCell);
        
                        // Append the row to the table body
                        categoryList.appendChild(row);
                    });
                })
                .catch((error) => console.error("Error fetching categories:", error));
        }
    

    document.getElementById('addCompanyForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const companyName = document.getElementById("companyName").value

        axios.post('/api/create-company', {
        	subsidiary: companyName,
        })
        .then(response => {
            alert('Company saved successfully:');
            document.getElementById('addCompanyForm').reset();
            loadCompany();
            const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("addCompanyModal"));
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
            console.error('Error saving company:', error);
        });
    });

    loadCompany();
});
