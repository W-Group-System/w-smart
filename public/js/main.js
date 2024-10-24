function fetchUserPermissions(userRoleId) {
    axios
        .get("/api/permissions", { params: { role: userRoleId } })
        .then((response) => {
            if (response.data.status === "success") {
                const permissions = response.data.data;

                const userPermissions = permissions.filter((p) => p.roleid == userRoleId);

                const features = [...new Set(
                    userPermissions
                        .filter((p) => p.subfeature_id === null)
                        .map((p) => p.featureid)
                )];

                const subfeatures = [...new Set(
                    userPermissions
                        .filter((p) => p.subfeature_id !== null)
                        .map((p) => p.subfeature_id)
                )];

                if (features.length === 0 && subfeatures.length === 0) {
                    displayAllFeatures();
                } else {
                    displayFeatures(features, subfeatures);
                }
            } else {
                console.error("Failed to fetch permissions:", response.data.message);
            }
        })
        .catch((error) => {
            console.error("Error fetching permissions:", error);
            displayAllFeatures();
        });
}


function displayFeatures(features, subfeatures) {
    const featureMenus = {
        inventory: { menu: "inventory-menu", subItems: ["inventory-list-item", "inventory-transfer-item", "withdrawal-request-item", "returned-inventory-item"] },
        equipment: { menu: "equipment-menu", subItems: ["new-asset-item", "transfer-asset-item", "disposal-asset-item"] },
        procurement: { menu: "procurement-menu", subItems: ["purchase-request-item", "canvassing-item", "purchase-order-item"] },
        settings: { menu: "settings-menu", subItems: ["company-item", "department-item", "role-item", "category-item"] },
        report: { menu: "report-menu", subItems: ["summary-report-item", "detailed-report-item"] }
    };

    Object.values(featureMenus).forEach((feature) => {
        document.getElementById(feature.menu).style.display = "none";
        feature.subItems.forEach((item) => {
            const element = document.getElementById(item);
            if (element) {
                element.style.display = "none";
            }
        });
    });

    if (features.includes(1) || subfeatures.some((sf) => [1, 2, 3, 4].includes(sf))) {
        document.getElementById(featureMenus.inventory.menu).style.display = "block";
        if (subfeatures.includes(1)) document.getElementById("inventory-list-item").style.display = "block";
        if (subfeatures.includes(2)) document.getElementById("inventory-transfer-item").style.display = "block";
        if (subfeatures.includes(3)) document.getElementById("withdrawal-request-item").style.display = "block";
        if (subfeatures.includes(4)) document.getElementById("returned-inventory-item").style.display = "block";
    }

    if (features.includes(2) || subfeatures.some((sf) => [5, 6, 7].includes(sf))) {
        document.getElementById(featureMenus.equipment.menu).style.display = "block";
        if (subfeatures.includes(5)) document.getElementById("new-asset-item").style.display = "block";
        if (subfeatures.includes(6)) document.getElementById("transfer-asset-item").style.display = "block";
        if (subfeatures.includes(7)) document.getElementById("disposal-asset-item").style.display = "block";
    }

    if (features.includes(3) || subfeatures.some((sf) => [8, 9, 10].includes(sf))) {
        document.getElementById(featureMenus.procurement.menu).style.display = "block";
        if (subfeatures.includes(8)) document.getElementById("purchase-request-item").style.display = "block";
        if (subfeatures.includes(9)) document.getElementById("canvassing-item").style.display = "block";
        if (subfeatures.includes(10)) document.getElementById("purchase-order-item").style.display = "block";
    }

    if (features.includes(4) || subfeatures.some((sf) => [11, 12, 13, 14].includes(sf))) {
        document.getElementById(featureMenus.settings.menu).style.display = "block";
        if (subfeatures.includes(11)) document.getElementById("company-item").style.display = "block";
        if (subfeatures.includes(12)) document.getElementById("department-item").style.display = "block";
        if (subfeatures.includes(13)) document.getElementById("role-item").style.display = "block";
        if (subfeatures.includes(14)) document.getElementById("category-item").style.display = "block";
    }

    if (features.includes(5) || subfeatures.some((sf) => [15, 16].includes(sf))) {
        document.getElementById(featureMenus.report.menu).style.display = "block";
        if (subfeatures.includes(15)) document.getElementById("summary-report-item").style.display = "block";
        if (subfeatures.includes(16)) document.getElementById("detailed-report-item").style.display = "block";
    }
}

function displayAllFeatures() {
    document.getElementById("inventory-menu").style.display = "block";
    document.getElementById("procurement-menu").style.display = "block";
    document.getElementById("equipment-menu").style.display = "block";
    document.getElementById("settings-menu").style.display = "block";
    document.getElementById("report-menu").style.display = "block";

    document.querySelectorAll(".dashboard-list").forEach((el) => {
        el.style.display = "block";
    });
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
