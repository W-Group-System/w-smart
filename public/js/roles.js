document.addEventListener("DOMContentLoaded", function () {
    let createRoleButton = document.querySelector("button[type='submit']");
    createRoleButton.disabled = true;

    // Function to enable/disable the Create Role button
    function toggleCreateRoleButton() {
        let roleName = document.getElementById("role").value.trim();
        let selectedFeatures = Array.from(
            document.querySelectorAll(
                '#features input[type="checkbox"]:checked'
            )
        );
        createRoleButton.disabled =
            roleName === "" || selectedFeatures.length === 0;
    }

    document
        .getElementById("role")
        .addEventListener("input", toggleCreateRoleButton);

    document
        .getElementById("features")
        .addEventListener("change", toggleCreateRoleButton);

    // Fetch features and generate checkboxes
    axios
        .get("/api/features")
        .then((response) => {
            let featureContainer = document.getElementById("features");
            featureContainer.classList.add("ps-4");
            response.data.data.forEach((feature) => {
                let checkboxDiv = document.createElement("div");
                checkboxDiv.className = "form-check mb-2";
                checkboxDiv.innerHTML = `
                    <input class="form-check-input" type="checkbox" id="feature_${feature.id}" value="${feature.id}">
                    <label class="form-check-label ms-1" for="feature_${feature.id}">${feature.feature}</label>
                `;
                featureContainer.appendChild(checkboxDiv);
            });

            toggleCreateRoleButton();
        })
        .catch((error) => {
            console.error("Error fetching features:", error);
        });

    // Handle role creation
    document
        .getElementById("createRoleForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            let roleName = document.getElementById("role").value;
            let selectedFeatures = Array.from(
                document.querySelectorAll(
                    '#features input[type="checkbox"]:checked'
                )
            );

            // Step 1: Create the role
            axios
                .post("/api/create-role", { role: roleName })
                .then((response) => {
                    let newRole = response.data.data; // Role data

                    // Step 2: Iterate over the selected features and create permissions
                    let permissionPromises = selectedFeatures.map(
                        (checkbox) => {
                            let featureId = checkbox.value;
                            let featureName = document
                                .querySelector(
                                    `label[for="feature_${featureId}"]`
                                )
                                .textContent.trim();

                            return axios.post("/api/create-permission", {
                                roleid: newRole.id,
                                role: newRole.role,
                                featureid: featureId,
                                feature: featureName,
                            });
                        }
                    );

                    // Wait for all permissions to be created
                    Promise.all(permissionPromises)
                        .then((results) => {
                            console.log(
                                "Permissions created for all features:",
                                results
                            );
                            loadRoles(); // Refresh the list of roles
                        })
                        .catch((error) => {
                            console.error("Error creating permissions:", error);
                        });
                })
                .catch((error) => {
                    console.error("Error creating role:", error);
                });
        });

    // Fetch and display roles
    function loadRoles() {
        axios
            .get("/api/roles")
            .then((response) => {
                let roleList = document.getElementById("roleList");
                roleList.innerHTML = ""; // Clear the current list
                response.data.data.forEach((role) => {
                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${role.role}</td>
                        <td>${role.features
                            .map((f) => f.feature)
                            .join(", ")}</td>
                        <td><button class="btn btn-danger">Delete</button></td>
                    `;
                    roleList.appendChild(row);
                });
            })
            .catch((error) => {
                console.error("Error fetching roles:", error);
            });
    }

    loadRoles(); // Initial load of roles
});
