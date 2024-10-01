function fetchUserPermissions(userRoleId) {
    axios
        .get("/api/permissions")
        .then((response) => {
            if (response.data.status === "success") {
                const permissions = response.data.data;

                const userFeatures = permissions
                    .filter((p) => p.roleid == userRoleId)
                    .map((p) => p.feature);

                if (userFeatures.length === 0) {
                    displayAllFeatures();
                } else {
                    displayFeatures(userFeatures);
                }
            } else {
                console.error(
                    "Failed to fetch permissions:",
                    response.data.message
                );
            }
        })
        .catch((error) => {
            console.error("Error fetching permissions:", error);
            displayAllFeatures();
        });
}

function displayFeatures(userFeatures) {
    if (userFeatures.includes("Inventory Management")) {
        document.getElementById("inventory-menu").style.display = "block";
    }

    if (userFeatures.includes("Procurement")) {
        document.getElementById("procurement-menu").style.display = "block";
    }

    if (userFeatures.includes("Equipment & Asset")) {
        document.getElementById("equipment-menu").style.display = "block";
    }

    if (userFeatures.includes("Settings")) {
        document.getElementById("settings-menu").style.display = "block";
    }

    if (userFeatures.includes("Report")) {
        document.getElementById("report-menu").style.display = "block";
    }
}

function displayAllFeatures() {
    document.getElementById("inventory-menu").style.display = "block";
    document.getElementById("procurement-menu").style.display = "block";
    document.getElementById("equipment-menu").style.display = "block";
    document.getElementById("settings-menu").style.display = "block";
    document.getElementById("report-menu").style.display = "block";
}

document.addEventListener("DOMContentLoaded", function () {
    const userRoleId = document
        .querySelector('meta[name="user-role-id"]')
        .getAttribute("content");

    if (userRoleId) {
        fetchUserPermissions(userRoleId);
    } else {
        displayAllFeatures();
    }

    const toggles = [
        { toggle: "inventoryToggle", submenu: "inventorySubmenu" },
        { toggle: "equipmentToggle", submenu: "equipmentSubmenu" },
        { toggle: "procurementToggle", submenu: "procurementSubmenu" },
        { toggle: "settingsToggle", submenu: "settingsSubmenu" },
    ];

    toggles.forEach(({ toggle, submenu }) => {
        const submenuElement = new bootstrap.Collapse(
            document.getElementById(submenu),
            {
                toggle: false,
            }
        );

        let isToggling = false;

        document
            .getElementById(toggle)
            .addEventListener("click", function (event) {
                event.preventDefault();

                if (isToggling) return;

                isToggling = true;

                if (submenuElement._element.classList.contains("show")) {
                    submenuElement.hide();
                } else {
                    submenuElement.show();
                }

                setTimeout(() => {
                    isToggling = false;
                }, 350);
            });
    });
});
