document.addEventListener("DOMContentLoaded", function () {
  const select = document.getElementById("plat-select");

  const in_libelle = document.getElementById("input_libelle");
  const in_desc = document.getElementById("input_description");
  const in_prix = document.getElementById("input_prix");
  const in_image = document.getElementById("input_image");
  const upload_img = document.getElementById("input_image_upload");
  const show_img = document.getElementById("show_img");
  const activeCheckbox = document.getElementById("input_active_check");

  function Disable() {
    if (select.value === "") {
      in_libelle.disabled = true;
      in_desc.disabled = true;
      in_prix.disabled = true;
      in_image.disabled = true;
      activeCheckbox.disabled = true;
      upload_img.disabled = true;
    } else {
      in_libelle.disabled = false;
      in_desc.disabled = false;
      in_prix.disabled = false;
      in_image.disabled = false;
      activeCheckbox.disabled = false;
      upload_img.disabled = false;
    }
  }
  Disable();

  select.addEventListener("change", (e) => {
    Disable();
    const selectedOption = e.target.selectedOptions[0];

    if (selectedOption && selectedOption.value) {
      const description = selectedOption.getAttribute("data-description");
      const prix = selectedOption.getAttribute("data-prix");
      const image = selectedOption.getAttribute("data-image");
      const active = selectedOption.getAttribute("data-active");
      const libelle = selectedOption.textContent.trim();

      document.getElementById("input_id").value = selectedOption.value;
      in_libelle.value = libelle || "";
      in_desc.value = description || "";
      in_prix.value = prix || "0.00";
      in_image.value = image || "";
      show_img.src = "/assets/img/food/" + image || "";

      activeCheckbox.checked = active == 1;
    } else {
      document.getElementById("input_id").value = "";
      in_libelle.value = "";
      in_desc.value = "";
      in_prix.value = "";
      in_image.value = "";
      show_img.src = "/assets/img/bg3.jpeg";
      activeCheckbox.checked = false;
    }
  });

  upload_img.addEventListener("change", function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (event) {
        show_img.src = event.target.result;
      };
      reader.readAsDataURL(file);
      in_image.value = upload_img.value.split("\\").pop().replace(/ /g, "_");
    } else {
      show_img.src = "";
    }
  });

  // --------------------------

  const commandeSelect = document.getElementById("commande-select");

  commandeSelect.addEventListener("change", (event) => {
    const selectedCommandeId = event.target.value;

    document.querySelectorAll(".commande-details").forEach((div) => {
      div.style.display = "none";
    });

    if (selectedCommandeId) {
      const detailsDiv = document.getElementById(
        `details-commande-${selectedCommandeId}`
      );
      if (detailsDiv) {
        detailsDiv.style.display = "block";
      }
    }
  });
});
