document.addEventListener("DOMContentLoaded", function () {
    let createRoleButton = document.querySelector("button[type='submit']");
    createRoleButton.disabled = true;

    function toggleCreateRoleButton() {
        let roleName = document.getElementById("role").value.trim();
        console.log(roleName);
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

    document
        .getElementById("createRoleBtn")
        .addEventListener("click", function () {
            let createRoleModal = new bootstrap.Modal(
                document.getElementById("createRoleModal")
            );
            createRoleModal.show();
        });

    document
        .getElementById("assignRoleBtn")
        .addEventListener("click", function () {
            let assignRoleModal = new bootstrap.Modal(
                document.getElementById("assignRoleModal")
            );
            assignRoleModal.show();
        });

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
            } else {
                let featureContainer = document.getElementById("features");

                featureContainer.innerHTML = "";
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

                            const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("createRoleModal"));

                            if (requestTransferModal) {
                                requestTransferModal.hide();
                            }
                            
                            loadPermissions();
                            loadRoles();

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
                        roleMap[roleId] = { role: roleName, features: [] };
                    }
                    roleMap[roleId].features.push(featureName);
                });

                for (let roleId in roleMap) {
                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${roleMap[roleId].role}</td>
                        <td class="text-wrap">${roleMap[roleId].features.join(
                            ", "
                        )}</td>
                        <td><button class="btn btn-danger" data-role-id="${roleId}">Delete</button></td>
                    `;
                    roleList.appendChild(row);
                }
            })
            .catch((error) =>
                console.error("Error fetching permissions:", error)
            );
    }

    let roleMap = {};

    function loadRoles() {
        axios
            .get("/api/roles")
            .then((response) => {
                let roles = document.getElementById("assignRole");
                roles.innerHTML = "";

                let defaultOption = document.createElement("option");
                defaultOption.text = "Select a Role";
                defaultOption.value = "";
                defaultOption.disabled = true;
                defaultOption.selected = true;
                roles.appendChild(defaultOption);

                response.data.data.forEach((data) => {
                    let option = document.createElement("option");
                    option.value = data.id;
                    option.text = data.role;
                    roles.appendChild(option);

                    roleMap[data.id] = data.role;
                });
            })
            .catch((error) => console.error("Error fetching roles:", error));
    }

    function loadUsers() {
        axios
            .get("/api/users")
            .then((response) => {
                let userList = document.getElementById("userList");
                userList.innerHTML = "";

                response.data.data.forEach((user) => {
                    let roleName = roleMap[user.role] || "Super Admin"; // Default to "Super Admin" if role ID doesn't match

                    let row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${user.name}</td>
                        <td>${roleName}</td>
                    `;
                    userList.appendChild(row);
                });

                let employeeSelect = document.getElementById("employee");
                employeeSelect.innerHTML = "";

                response.data.data.forEach((user) => {
                    let option = document.createElement("option");
                    option.value = user.id;
                    option.text = user.name;
                    employeeSelect.appendChild(option);
                });
            })
            .catch((error) => console.error("Error fetching users:", error));
    }

    document
        .getElementById("assignRoleForm")
        .addEventListener("submit", function (event) {
            event.preventDefault();
            const employeeId = document.getElementById("employee").value;
            const roleId = document.getElementById("assignRole").value;
            if (!employeeId) {
                Swal.fire("Please select employee.");
            } else if (!roleId) {
                Swal.fire("Please assign role.");
            } else {
                submitAssignRole(employeeId, roleId);
                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("assignRoleModal"));
                if (requestTransferModal) {
                    requestTransferModal.hide();
                }
            }
        });

    function submitAssignRole(id, role) {
        axios
            .patch(`/api/update-role/${id}`, { role: role })
            .then((response) => {
                Swal.fire({
                    title: "Role assigned successfully!",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then((result) => {
                    if (result.isConfirmed) {
                        loadUsers();
                        loadPermissions();
                        loadRoles();
                        window.location.reload(); 
                    }
                });
            })
            .catch((error) => {
                console.error("Error assigning role:", error);
                Swal.fire("Error!", "Error assigning role.", "error");
            });
    }

    document.getElementById("roleList").addEventListener("click", function (e) {
        if (e.target && e.target.matches("button.btn-danger")) {
            const roleId = e.target.getAttribute("data-role-id");
            const roleName = roleMap[roleId];

            axios
                .get(`/api/users`, {
                    params: {
                        role: roleId,
                    },
                })
                .then((response) => {
                    const usersInRole = response.data.data;

                    if (usersInRole.length > 0) {
                        let userText =
                            usersInRole.length === 1 ? "user" : "users";

                        Swal.fire({
                            title: `There are currently ${usersInRole.length} ${userText} in this role.`,
                            text: "Proceed to transferring them?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, transfer",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                showTransferRoleModal(roleId, usersInRole);
                            }
                        });
                    } else {
                        Swal.fire({
                            title: `Do you want to delete the role "${roleName}"?`,
                            text: "This action is permanent.",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, delete it",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                deleteRole(roleId);
                            }
                        });
                    }
                })
                .catch((error) => {
                    console.error("Error fetching users in role:", error);
                });
        }
    });

    function deleteRole(roleId) {
        axios
            .post("/api/delete-role", { id: roleId })
            .then(() => {
                Swal.fire("Deleted!", "Role has been deleted.", "success");
                loadPermissions();
                loadRoles();
            })
            .catch((error) => {
                console.error("Error deleting role:", error);
                Swal.fire("Error!", "Failed to delete the role.", "error");
            });
    }

    function showTransferRoleModal(roleId, users) {
        let transferRoleModal = new bootstrap.Modal(
            document.getElementById("transferRoleModal")
        );

        let affectedUsersContainer = document.getElementById("affectedUsers");
        affectedUsersContainer.innerHTML = "";

        users.forEach((user) => {
            let listItem = document.createElement("li");
            listItem.textContent = user.name;
            affectedUsersContainer.appendChild(listItem);
        });

        transferRoleModal.show();

        let roleSelect = document.getElementById("transferRole");
        roleSelect.innerHTML = "";

        axios
            .get("/api/roles")
            .then((response) => {
                let roles = response.data.data;

                roles.forEach((role) => {
                    if (role.id != roleId) {
                        let option = document.createElement("option");
                        option.value = role.id;
                        option.text = role.role;
                        roleSelect.appendChild(option);
                    }
                });
            })
            .catch((error) => {
                console.error("Error fetching roles:", error);
            });

        document
            .getElementById("transferRoleForm")
            .addEventListener("submit", function (event) {
                event.preventDefault();
                const newRoleId = document.getElementById("transferRole").value;

                if (!newRoleId) {
                    Swal.fire("Please select a new role to transfer users.");
                    return;
                }

                let updatePromises = users.map((user) =>
                    axios.patch(`/api/update-role/${user.id}`, {
                        role: newRoleId,
                    })
                );

                Promise.all(updatePromises)
                    .then(() => {
                        Swal.fire({
                            title: "Transferred!",
                            text: "All users have been transferred.",
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                const requestTransferModal = bootstrap.Modal.getInstance(document.getElementById("transferRoleModal"));
                                if (requestTransferModal) {
                                    requestTransferModal.hide();
                                }
                                deleteRole(roleId);
                                loadUsers();
                                loadPermissions();
                                loadRoles();
                                window.location.reload(); 
                            }
                        });
                    })
                    .catch((error) => {
                        console.error("Error updating user roles:", error);
                        Swal.fire("Error!", "Failed to transfer users.", "error");
                    });
            });
    }

    loadPermissions();
    loadRoles();
    loadUsers();
});
