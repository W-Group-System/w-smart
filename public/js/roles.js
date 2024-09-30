document.addEventListener("DOMContentLoaded", function () {
    let createRoleButton = document.querySelector("button[type='submit']");
    createRoleButton.disabled = true;

    function toggleCreateRoleButton() {
        let roleName = document.getElementById("role").value.trim();
        console.log(roleName)
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

    axios
        .get("/api/features")
        .then((response) => {
            if (response.data.data.length > 0) {
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
            }
            else {
                let featureContainer = document.getElementById("features");

                featureContainer.innerHTML = ''; 
                featureContainer.classList.add("ps-4");

                let labelDiv = document.createElement("div");
                labelDiv.className = "alert alert-warning mt-2"; // Added margin for better display
                labelDiv.innerHTML = "No features available.";

                featureContainer.appendChild(labelDiv);   
            }

        })
        .catch((error) => {
            console.error("Error fetching features:", error);
        });

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

            axios
                .post("/api/create-role", { role: roleName })
                .then((response) => {
                    let newRole = response.data.data;

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

                    Promise.all(permissionPromises)
                        .then((results) => {
                            console.log(
                                "Permissions created for all features:",
                                results
                            );

                            Swal.fire({
                                title: "Role Created!",
                                text: "The role has been successfully created.",
                                icon: "success",
                                confirmButtonText: "OK",
                            });

                            loadPermissions();

                            document.getElementById("createRoleForm").reset();
                            createRoleButton.disabled = true;
                        })
                        .catch((error) => {
                            console.error("Error creating permissions:", error);
                        });
                })
                .catch((error) => {
                    console.error("Error creating role:", error);
                });
        });

    function loadPermissions() {
        axios
            .get("/api/permissions")
            .then((response) => {
                let roleList = document.getElementById("roleList");
                roleList.innerHTML = ""; 

                let roleMap = {};

                response.data.data.forEach((permission) => {
                    let roleId = permission.roleid;
                    let roleName = permission.role;
                    let featureName = permission.feature;

                    if (!roleMap[roleId]) {
                        roleMap[roleId] = {
                            role: roleName,
                            features: [],
                        };
                    }
                    roleMap[roleId].features.push(featureName);
                });

                for (let roleId in roleMap) {
                    let row = document.createElement("tr");
                    row.innerHTML = `
                            <td>${roleMap[roleId].role}</td>
                            <td class="text-wrap">${roleMap[
                                roleId
                            ].features.join(", ")}</td>
                            <td><button class="btn btn-danger" data-role-id="${roleId}">Delete</button></td>
                        `;
                    roleList.appendChild(row);
                }
            })
            .catch((error) => {
                console.error("Error fetching permissions:", error);
            });
    }

    loadPermissions();
});
