const input = document.getElementById("input_search");
const result = document.getElementById("search_result");
let active = false;

function activeSearch() {
  if (active == true) {
    result.style.display = "block";
  } else {
    result.style.display = "none";
  }
}

function foreachData(results) {
  const limitedResults = results.slice(0, 4);

  limitedResults.forEach((plat) => {
    const a = document.createElement("a");
    a.className = "result_result";
    a.href = "/plats/" + plat.id;

    const h6 = document.createElement("h6");
    h6.textContent = plat.libelle;
    a.appendChild(h6);

    const searchResultContainer = document.getElementById("search_result");
    searchResultContainer.appendChild(a);
  });

  if (limitedResults.length < 1) {
    const a = document.createElement("a");
    a.className = "result_result";
    a.href = "/plats/";

    const h6 = document.createElement("h6");
    h6.textContent = "Aucun plat trouvé";
    a.appendChild(h6);
    const searchResultContainer = document.getElementById("search_result");
    searchResultContainer.appendChild(a);
  }
}

fetch("/api/plats?page=1")
  .then((response) => response.json())
  .then((json) => {
    const plats = json.member;

    foreachData(plats);

    input.addEventListener("input", () => {
      const searchTerm = input.value.toLowerCase();
      const results = plats.filter((plat) =>
        plat.libelle.toLowerCase().includes(searchTerm)
      );

      const searchResultContainer = document.getElementById("search_result");
      searchResultContainer.innerHTML = "";

      foreachData(results);
    });
  })
  .catch((error) => {
    console.error("Erreur : ", error);
  });

const toggleActive = () => {
  active = !active;
  activeSearch();
};

input.addEventListener("focus", toggleActive);
input.addEventListener("blur", (event) => {
  const ClickInsideResult = result.contains(event.relatedTarget);
  if (!ClickInsideResult) {
    toggleActive();
  }
});
