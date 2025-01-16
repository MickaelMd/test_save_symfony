const form = {
  email: document.getElementById("registration_form_email"),
  mdp: document.getElementById("registration_form_password"),
  nom: document.getElementById("registration_form_nom"),
  prenom: document.getElementById("registration_form_prenom"),
  telephone: document.getElementById("registration_form_telephone"),
  adresse: document.getElementById("registration_form_adresse"),
  cp: document.getElementById("registration_form_cp"),
  ville: document.getElementById("registration_form_ville"),
};

const regex = {
  email: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
  mdp: /^(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{8,}$/,
  nom: /^[a-zA-Z\s]+$/,
  prenom: /^[a-zA-Z\s]+$/,
  telephone: /^(\+33|0)[1-9](\d{2}){4}$/,
  adresse: /^[a-zA-Z0-9\s]+$/,
  cp: /^\d{5}$/,
  ville: /^[a-zA-Z\s]+$/,
};

const erreur = {
  email: "L'adresse e-mail que vous avez saisie n'est pas valide.",
  mdp: "Le mot de passe doit contenir au moins 8 caractères, une majuscule, un chiffre et un caractère spécial.",
  nom: "Le nom ne doit contenir que des lettres.",
  prenom: "Le prénom ne doit contenir que des lettres.",
  telephone: "Le numéro de téléphone doit être valide.",
  adresse: "Veuillez entrer une adresse valide.",
  cp: "Le code postal doit être un nombre à 5 chiffres.",
  ville: "Le nom de la ville ne doit contenir que des lettres.",
};

const submit = document.getElementById("submit_btn");

// ----------------------------------------------------

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

function confirmEmail(e) {
  const mdp = document.getElementById("registration_form_password");
  const confirmMdp = document.getElementById(
    "registration_form_confirmPassword"
  );

  if (mdp.value !== confirmMdp.value || confirmMdp.value == "") {
    ErrorShow(confirmMdp, "Les mots de passe ne correspondent pas.", e);
  } else {
    confirmMdp.style.outline = "2px solid green";
  }
}

function verif(e) {
  for (let i = 0; i < Object.keys(form).length; i++) {
    if (!regex[Object.keys(form)[i]].test(form[Object.keys(form)[i]].value)) {
      ErrorShow(Object.values(form)[i], Object.values(erreur)[i], e);
    } else {
      Object.values(form)[i].style.outline = "2px solid green";
    }
  }
}

function realTimeCheck() {
  for (let i = 0; i < Object.keys(form).length; i++) {
    Object.values(form)[i].addEventListener("input", (e) => {
      verif(e);
    });
  }

  document
    .getElementById("registration_form_confirmPassword")
    .addEventListener("input", (e) => {
      confirmEmail(e);
    });
}

submit.addEventListener("click", (e) => {
  verif(e);
  realTimeCheck();
  confirmEmail(e);
});
