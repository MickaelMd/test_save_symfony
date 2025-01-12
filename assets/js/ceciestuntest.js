const input = document.getElementById("input_search");
const result = document.getElementById("search_result");
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

      const limitedResults = results.slice(0, 4);
      const searchResultContainer = document.getElementById("search_result");

      searchResultContainer.innerHTML = "";

      limitedResults.forEach((plat) => {
        const a = document.createElement("a");
        a.className = "result_result";
        a.href = "/plats/" + plat.id;

        const h6 = document.createElement("h6");
        h6.textContent = plat.libelle;
        a.appendChild(h6);

        const searchResultContainer = document.getElementById("search_result");
        searchResultContainer.appendChild(a);

        // console.log(
        //   `ID: ${plat.id}, Libellé: ${plat.libelle}, Lien: ${plat["@id"]}`
        // );
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

result.style.position;
