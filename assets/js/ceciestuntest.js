const input = document.getElementById("test_input_search");

fetch("http://127.0.0.1:36359/api/plats?page=1")
  .then((response) => response.json())
  .then((json) => {
    console.log(json.member);
  })
  .catch((error) => {
    console.error("Erreur : ", error);
  });
