const input = document.getElementById("input_search");
let active = false;

fetch("/api/plats?page=1")
  .then((response) => response.json())
  .then((json) => {
    const plats = json.member;

    input.addEventListener("input", () => {
      const searchTerm = input.value.toLowerCase();

      const results = plats.filter((plat) =>
        plat.libelle.toLowerCase().includes(searchTerm)
      );

      const limitedResults = results.slice(0, 3);

      console.log("Plats trouvés:", limitedResults);

      limitedResults.forEach((plat) => {
        console.log(
          `ID: ${plat.id}, Libellé: ${plat.libelle}, Lien: ${plat["@id"]}`
        );
      });
    });
  })
  .catch((error) => {
    console.error("Erreur : ", error);
  });

input.addEventListener("focus", () => {
  if (active == false) {
    active = true;
    console.log(active);
  } else {
    active = false;
    console.log(active);
  }
});

input.addEventListener("blur", () => {
  if (active == false) {
    active = true;
    console.log(active);
  } else {
    active = false;
    console.log(active);
  }
});
