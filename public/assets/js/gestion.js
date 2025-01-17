document.addEventListener("DOMContentLoaded", function () {
  const select = document.getElementById("plat-select");

  const in_libelle = document.getElementById("input_libelle");
  const in_desc = document.getElementById("input_description");
  const in_prix = document.getElementById("input_prix");
  const in_image = document.getElementById("input_image");
  const activeCheckbox = document.getElementById("input_active_check");

  select.addEventListener("change", (e) => {
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

      activeCheckbox.checked = active == 1;
    } else {
      document.getElementById("input_id").value = "";
      in_libelle.value = "";
      in_desc.value = "";
      in_prix.value = "";
      in_image.value = "";
      activeCheckbox.checked = false;
    }
  });
});
