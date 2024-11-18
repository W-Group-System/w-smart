document.addEventListener("DOMContentLoaded", function () {
    let selectedUserId;
    
    // Show "Add New User" Modal
    document
        .getElementById("newUser")
        .addEventListener("click", function () {
            let addUserModal = new bootstrap.Modal(
                document.getElementById("addUserModal")
            );
            addUserModal.show();
        });

    // Function to load users and populate the user table
    function loadSubsidiary() {
        const subsidiarySelect = document.getElementById("userSubsidiary");

        axios
            .get("/api/subsidiary")
            .then((response) => {
                subsidiarySelect.innerHTML = ""; 
                response.data.data.forEach((subsidiary) => {
                    const option = document.createElement("option");
                    option.value = subsidiary.subsidiary_id; 
                    option.textContent = subsidiary.subsidiary_name;
                    subsidiarySelect.appendChild(option);
                });
            })
            .catch((error) => console.error("Error fetching subsidiaries:", error));
    }

    function loadEditSubsidiary() {
        const subsidiarySelect = document.getElementById("editUserSubsidiary");

        axios
            .get("/api/subsidiary")
            .then((response) => {
                subsidiarySelect.innerHTML = ""; 
                response.data.data.forEach((subsidiary) => {
                    const option = document.createElement("option");
                    option.value = subsidiary.subsidiary_id; 
                    option.textContent = subsidiary.subsidiary_name;
                    subsidiarySelect.appendChild(option);
                });
            })
            .catch((error) => console.error("Error fetching subsidiaries:", error));
    }
    loadSubsidiary();
    function loadUsers() {
        let userMap = {};
        const userList = document.getElementById("userList");

        axios
            .get("/api/users")
            .then((response) => {
                userList.innerHTML = ""; // Clear the table body first

                // Loop through each user
                response.data.data.forEach((user) => {
                    let userName = user.name;
                    let userEmail = user.email;
                    let userSubsidiary = user.subsidiary;
                    let id = user.id;

                    // Populate user map with necessary details
                    userMap[id] = { name: userName, email: userEmail, subsidiary: userSubsidiary };
                });
                updateUserList(userMap);
            })
            .catch((error) => console.error("Error fetching users:", error));
    }
    loadUsers();
    function updateUserList(userMap) {
        const userList = document.getElementById("userList");
        userList.innerHTML = ""; // Clear existing rows

        for (let id in userMap) {
            let row = document.createElement("tr");
            row.innerHTML = `
                <td>${userMap[id].name}</td>
                <td>${userMap[id].email}</td>
                <td>${userMap[id].subsidiary}</td>
                <td>
                	<button class="btn btn-danger add-subsidiary" data-user-id="${id}">Edit</button>
                	<button class="btn btn-danger delete-user" data-user-email="${userMap[id].email}">Delete</button>
                </td>

            `;
            userList.appendChild(row);
        }

        // Add event listeners to the newly created Edit buttons
        document.querySelectorAll('.add-subsidiary').forEach(button => {
            button.addEventListener('click', function() {
                selectedUserId = this.getAttribute('data-user-id');
                // Find the user based on selectedUserId
                const user = userMap[selectedUserId];
                openEditModal(user);  // Pass the user object to the modal
            });
        });
        document.querySelectorAll('.delete-user').forEach(button => {
            button.addEventListener('click', function () {
                const userEmail = this.getAttribute('data-user-email');
                console.log(userEmail)
                const confirmation = confirm("Are you sure you want to delete this user?");
                const user = {
                    email: userEmail,
                };
                if (confirmation) {
                    // Send a delete request to the server
                    axios.post(`/api/delete-user`, user)
                        .then(response => {
                            alert('User deleted successfully!');
                            loadUsers();  // Reload the user list
                        })
                        .catch(error => {
                            console.error('Error deleting user:', error);
                            alert('Failed to delete user.');
                        });
                }
            });
        });
    }

    function collectUserValues() {
        return {
            name: document.getElementById("userName").value,
            email: document.getElementById("userEmail").value,
            subsidiary: document.getElementById("userSubsidiary").selectedOptions[0].textContent, // subsidiary name
            subsidiaryid: document.getElementById("userSubsidiary").value // subsidiary id
        };
    } 

    // Handle form submission for adding a new user
    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const userData = collectUserValues();
        axios.post('/api/register', userData)
        .then(response => {
            alert('User saved successfully');
            document.getElementById('addUserForm').reset();
            loadUsers();
            const addUserModalInstance = bootstrap.Modal.getInstance(document.getElementById("addUserModal"));
            if (addUserModalInstance) {
                addUserModalInstance.hide();
            }
            setTimeout(() => {
                document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
                document.body.classList.remove("modal-open");
                document.body.style.overflow = "";
            }, 300);
        })
        .catch(error => {
            console.error('Error saving user:', error);
        });
    });

    function openEditModal(user) {
        loadEditSubsidiary()
        document.getElementById('editUserId').value = user.id;
        document.getElementById('editUserName').value = user.name;
        document.getElementById('editUserEmail').value = user.email;

        // Initialize the modal and show it
        let editUserModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editUserModal.show();
    }

    document.getElementById('editUserForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const userId = document.getElementById('editUserId').value;
        const updatedUser = {
            name: document.getElementById('editUserName').value,
            email: document.getElementById('editUserEmail').value,
            password: document.getElementById('editUserPassword').value || undefined,
            subsidiary: document.getElementById("editUserSubsidiary").selectedOptions[0].textContent,
            subsidiaryid: document.getElementById('editUserSubsidiary').value
        };
        axios.post(`/api/edit-user`, updatedUser)
            .then(response => {
                alert('User updated successfully');
                loadUsers();
                closeModal('editUserModal');
            })
            .catch(error => {
                console.error('Error updating user:', error);
            });
    });

    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        const modalInstance = bootstrap.Modal.getInstance(modal);
        if (modalInstance) modalInstance.hide();
        setTimeout(() => {
            document.querySelectorAll(".modal-backdrop").forEach((el) => el.remove());
            document.body.classList.remove("modal-open");
            document.body.style.overflow = "";
        }, 300);
    }

    document.getElementById('togglePasswordVisibility').addEventListener('click', function() {
        const passwordInput = document.getElementById('editUserPassword');
        const currentType = passwordInput.type;

        // Toggle between "password" and "text" input types
        if (currentType === "password") {
            passwordInput.type = "text"; // Show password
            this.textContent = "Hide Password"; // Change button text
        } else {
            passwordInput.type = "password"; // Hide password
            this.textContent = "Show Password"; // Change button text
        }
    });


});
