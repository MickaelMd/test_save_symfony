document.addEventListener("turbo:load", function () {
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

  function createElement(link, message) {
    const a = document.createElement("a");
    a.className = "result_result";
    a.href = link;

    const h6 = document.createElement("h6");
    h6.textContent = message;
    a.appendChild(h6);
    const searchResultContainer = document.getElementById("search_result");
    searchResultContainer.appendChild(a);
  }

  function foreachData(results) {
    const limitedResults = results.slice(0, 4);

    limitedResults.forEach((plat) => {
      createElement("/plats/" + plat.id, plat.libelle);
    });

    if (limitedResults.length < 1) {
      createElement("/plats/", "Aucun plat trouvé");
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
      createElement("/plats/", "Erreur de chargement");
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
});
