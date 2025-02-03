const btn = document.getElementById("btn_delete_profil");
const btn_confirm = document.getElementById("btn_confirm_profil");

btn.addEventListener("click", (e) => {
  e.preventDefault();

  btn_confirm.classList.toggle("d-none");
  btn.classList.add("d-none");
});

btn_confirm.addEventListener("click", (e) => {
  let input = prompt(
    'Veuillez écrire "confirmer" pour confirmer la suppression de votre compte'
  );
  if (input?.toLowerCase() !== "confirmer") {
    e.preventDefault();
  }
});
