const sections = [
  "profil_edit_section",
  "profil_password_section",
  "profil_email_section",
];
const buttons = ["btn_inf", "btn_pwd", "btn_email"];

buttons.forEach((btnId, index) => {
  document.getElementById(btnId).addEventListener("click", () => {
    sections.forEach((id) =>
      document.getElementById(id).classList.add("d-none")
    );
    document.getElementById(sections[index]).classList.remove("d-none");
  });
});

const btn = document.getElementById("btn_delete_profil");
const btn_confirm = document.getElementById("btn_confirm_profil");

let btn_disabled = false;

btn.addEventListener("click", (e) => {
  e.preventDefault();
  if (btn_disabled == false) {
    btn_disabled = true;

    btn.style.backgroundColor = "grey";

    setTimeout(() => {
      btn.textContent = 3;
    }, 0);

    setTimeout(() => {
      btn.textContent = 2;
    }, 1000);

    setTimeout(() => {
      btn.textContent = 1;
    }, 2000);
    setTimeout(() => {
      btn_confirm.classList.toggle("d-none");
      btn.classList.add("d-none");
    }, 3000);
  }
});

btn_confirm.addEventListener("click", (e) => {
  let input = prompt(
    'Veuillez écrire "confirmer" pour confirmer la suppression de votre compte'
  );
  if (input?.toLowerCase() !== "confirmer") {
    e.preventDefault();
  }
});

// ------------- Profil

const erreur_message = {
  nom: "Le nom ne doit contenir que des lettres.",
  prenom: "Le prénom ne doit contenir que des lettres.",
  telephone: "Le numéro de téléphone doit être valide.",
  adresse: "Veuillez entrer une adresse valide.",
  cp: "Le code postal doit être un nombre à 5 chiffres.",
  ville: "Le nom de la ville ne doit contenir que des lettres.",
};

const regex = {
  nom: /^[a-zA-Z\s]+$/,
  prenom: /^[a-zA-Z\s]+$/,
  telephone: /^(\+33|0)[1-9](\d{2}){4}$/,
  adresse: /^[a-zA-Z0-9\s]+$/,
  cp: /^\d{5}$/,
  ville: /^[a-zA-Z\s]+$/,
};

const form = {
  nom: document.getElementById("profil_nom"),
  prenom: document.getElementById("profil_prenom"),
  telephone: document.getElementById("profil_telephone"),
  adresse: document.getElementById("profil_adresse"),
  cp: document.getElementById("profil_cp"),
  ville: document.getElementById("profil_ville"),
};

function ErrorShow(form, erreur, e) {
  e.preventDefault();
  form.style.outline = "2px solid red";

  let existingError = form.parentNode.querySelector(".error-message");

  if (existingError) {
    existingError.textContent = erreur;
  } else {
    const error_show = document.createElement("div");
    error_show.classList.add("error-message", "text-danger", "mt-2");
    error_show.textContent = erreur;
    form.parentNode.appendChild(error_show);
  }
}

function erreur(e) {
  for (let i = 0; i < Object.keys(form).length; i++) {
    if (!regex[Object.keys(form)[i]].test(form[Object.keys(form)[i]].value)) {
      ErrorShow(Object.values(form)[i], Object.values(erreur_message)[i], e);
    } else {
      Object.values(form)[i].style.outline = "2px solid green";
    }
  }
}

document.getElementById("btn_update_profil").addEventListener("click", (e) => {
  erreur(e);
});

// ------------- Password

const newpass = document.getElementById("profil_password_newPassword_first");
const newpass_confirm = document.getElementById(
  "profil_password_newPassword_second"
);
const btn_pass = document.getElementById("newpass_button");

function error_password(input, error_text) {
  input.style.outline = "2px solid red";

  let existingMessage = input.parentElement.querySelector("p");
  if (!existingMessage) {
    const message = document.createElement("p");
    message.textContent = error_text;
    message.style.color = "red";
    input.parentElement.appendChild(message);
  }
}

function clear_error(input) {
  input.style.outline = "";
  let existingMessage = input.parentElement.querySelector("p");
  if (existingMessage) {
    existingMessage.remove();
  }
}

btn_pass.addEventListener("click", (e) => {
  clear_error(newpass);
  clear_error(newpass_confirm);

  let isValid = true;

  if (!/^(?=.*[A-Z])(?=.*\d)(?=.*[^ws]).{8,}$/.test(newpass.value)) {
    e.preventDefault();
    error_password(
      newpass,
      "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial."
    );
    isValid = false;
  }

  if (newpass.value !== newpass_confirm.value) {
    e.preventDefault();
    error_password(newpass_confirm, "Les mots de passe ne correspondent pas.");
    isValid = false;
  }

  if (isValid) {
    console.log("Mot de passe validé");
  }
});
