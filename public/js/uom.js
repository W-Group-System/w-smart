document.addEventListener("DOMContentLoaded", function () {
    let selectedUOMId;

    document
        .getElementById("searchPrimaryUOM")
        .addEventListener("input", function () {
            const searchTerm = this.value.trim();
            loadUOMs(searchTerm);
        });

    document
        .getElementById("newUOMButton")
        .addEventListener("click", function () {
            let addUOMModal = new bootstrap.Modal(
                document.getElementById("addUOMModal")
            );
            addUOMModal.show();
        });

    function collectUOMValues() {
        const primaryUOM = document.getElementById("primaryUOM").value.trim();
        const primaryUOMValue = document
            .getElementById("primaryUOMValue")
            .value.trim();
        const secondaryUOM = document
            .getElementById("secondaryUOM")
            .value.trim();
        const secondaryUOMValue = document
            .getElementById("secondaryUOMValue")
            .value.trim();
        const tertiaryUOM = document.getElementById("tertiaryUOM").value.trim();
        const tertiaryUOMValue = document
            .getElementById("tertiaryUOMValue")
            .value.trim();

        return {
            primaryUOM,
            primaryUOMValue,
            secondaryUOM,
            secondaryUOMValue,
            tertiaryUOM,
            tertiaryUOMValue,
        };
    }

    const saveButton = document.querySelector(
        "#addUOMForm button[type='submit']"
    );
    document.querySelectorAll("#addUOMForm input").forEach((input) => {
        input.addEventListener("input", () => {
            const primaryFilled = document.getElementById("primaryUOM").value.trim() !== "" &&
                                  document.getElementById("primaryUOMValue").value.trim() !== "";
            const secondaryFilled = document.getElementById("secondaryUOM").value.trim() !== "" &&
                                    document.getElementById("secondaryUOMValue").value.trim() !== "";
            const tertiaryFilled = document.getElementById("tertiaryUOM").value.trim() !== "" &&
                                   document.getElementById("tertiaryUOMValue").value.trim() !== "";
    
            saveButton.disabled = !(primaryFilled && secondaryFilled && (tertiaryFilled || !document.getElementById("tertiaryUOM").value));
        });
    });

    document
        .querySelectorAll(
            "#primaryUOMValue, #secondaryUOMValue, #tertiaryUOMValue"
        )
        .forEach((input) => {
            input.addEventListener("input", function (e) {
                this.value = this.value.replace(/[^0-9.]/g, "");
            });
        });

    document
        .getElementById("addUOMForm")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            const uomData = collectUOMValues();

            axios
                .get("/api/uom/list")
                .then((response) => {
                    const existingUOM = response.data.data.some(
                        (uom) =>
                            uom.primaryUOM.toLowerCase() ===
                                uomData.primaryUOM.toLowerCase() &&
                            uom.secondaryUOM.toLowerCase() ===
                                uomData.secondaryUOM.toLowerCase() &&
                            uom.tertiaryUOM.toLowerCase() ===
                                uomData.tertiaryUOM.toLowerCase()
                    );

                    if (existingUOM) {
                        const uomModalInstance = bootstrap.Modal.getInstance(
                            document.getElementById("addUOMModal")
                        );
                        if (uomModalInstance) {
                            uomModalInstance.hide();
                        }

                        Swal.fire({
                            icon: "warning",
                            title: "UOM already exists",
                            text: "The UOM you are trying to add already exists.",
                            willClose: () => {
                                let addUOMModal = new bootstrap.Modal(
                                    document.getElementById("addUOMModal")
                                );
                                addUOMModal.show();
                            },
                        });
                        return;
                    }

                    axios
                        .post("/api/uom/create", uomData)
                        .then((response) => {
                            Swal.fire({
                                icon: "success",
                                title: "Success",
                                text: "UOM added successfully!",
                            });
                            document.getElementById("addUOMForm").reset();
                            loadUOMs();

                            const uomModalInstance =
                                bootstrap.Modal.getInstance(
                                    document.getElementById("addUOMModal")
                                );
                            if (uomModalInstance) {
                                uomModalInstance.hide();
                            }

                            setTimeout(() => {
                                document
                                    .querySelectorAll(".modal-backdrop")
                                    .forEach((el) => el.remove());
                                document.body.classList.remove("modal-open");
                                document.body.style.overflow = "";
                            }, 300);
                        })
                        .catch((error) => {
                            console.error("Error creating UOM:", error);
                            Swal.fire({
                                icon: "error",
                                title: "Error",
                                text: "Error creating UOM. Please try again.",
                            });
                        });
                })
                .catch((error) => {
                    console.error("Error checking existing UOMs:", error);
                });
        });

    function loadUOMs(searchTerm = "") {
        let uomList = document.getElementById("uomList");
        uomList.innerHTML = "";

        axios
            .get("/api/uom/settings", { params: { searchPrimary: searchTerm } })
            .then((response) => {
                const uomGroups = response.data.data;

                uomGroups.forEach((group) => {
                    const firstUOM = group.uoms[0];
                    const relationId = group.relation_id;

                    let row = `
                            <tr class="uom-row" data-relation-id="${relationId}">
                                <td>${firstUOM.primaryUOM}</td>
                                <td>${firstUOM.primaryUOMValue}</td>
                                <td>${firstUOM.secondaryUOM}</td>
                                <td>${firstUOM.secondaryUOMValue}</td>
                                <td>${firstUOM.tertiaryUOM}</td>
                                <td>${firstUOM.tertiaryUOMValue}</td>
                                <td>
                                     <button class="btn btn-danger delete-uom" data-relation-id="${relationId}">Delete</button>
                                </td>
                            </tr>
                        `;

                    uomList.insertAdjacentHTML("beforeend", row);
                });

                document.querySelectorAll(".uom-row").forEach((row) => {
                    row.addEventListener("click", function () {
                        const relationId =
                            this.getAttribute("data-relation-id");
                        showUOMDetails(relationId);
                    });
                });

                document.querySelectorAll(".delete-uom").forEach((button) => {
                    button.addEventListener("click", function (e) {
                        e.stopPropagation();
                        const relationId =
                            this.getAttribute("data-relation-id");
                        deleteUOM(relationId);
                    });
                });
            })
            .catch((error) => {
                console.error("Error fetching UOMs:", error);
            });
    }

    function showUOMDetails(relationId) {
        axios
            .get(`/api/uom/settings?relation_id=${relationId}`)
            .then((response) => {
                const uomGroup = response.data.data.find(
                    (group) => group.relation_id === parseInt(relationId)
                );
                let uomDetailsContent = "";

                if (uomGroup && uomGroup.uoms) {
                    uomDetailsContent = `
                        <table class="table table-hover table-bordered" style="border-collapse: collapse; min-width: 1000px;">
                            <thead>
                                <tr>
                                    <th>Primary UOM</th>
                                    <th>Primary Value</th>
                                    <th>Secondary UOM</th>
                                    <th>Secondary Value</th>
                                    <th>Tertiary UOM</th>
                                    <th>Tertiary Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${uomGroup.uoms
                                    .map(
                                        (uom) => `
                                    <tr>
                                        <td>${uom.primaryUOM}</td>
                                        <td>${uom.primaryUOMValue}</td>
                                        <td>${uom.secondaryUOM}</td>
                                        <td>${uom.secondaryUOMValue}</td>
                                        <td>${uom.tertiaryUOM}</td>
                                        <td>${uom.tertiaryUOMValue}</td>
                                    </tr>
                                `
                                    )
                                    .join("")}
                            </tbody>
                        </table>
                    `;
                } else {
                    uomDetailsContent =
                        "<p>No variants found for this UOM.</p>";
                }

                document.getElementById("uomDetailsContent").innerHTML =
                    uomDetailsContent;
                let uomDetailsModal = new bootstrap.Modal(
                    document.getElementById("uomDetailsModal")
                );
                uomDetailsModal.show();
            })
            .catch((error) => {
                console.error("Error fetching UOM details:", error);
                document.getElementById("uomDetailsContent").innerHTML =
                    "<p>Failed to load UOM details.</p>";
                let uomDetailsModal = new bootstrap.Modal(
                    document.getElementById("uomDetailsModal")
                );
                uomDetailsModal.show();
            });
    }

    function deleteUOM(relationId) {
        axios
            .delete(`/api/uom/${relationId}`)
            .then((response) => {
                Swal.fire({
                    icon: "success",
                    title: "Deleted",
                    text: "UOM group deleted successfully!",
                });
                loadUOMs();
            })
            .catch((error) => {
                console.error("Error deleting UOM:", error);
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Failed to delete UOM group. Please try again.",
                });
            });
    }

    loadUOMs();
});
