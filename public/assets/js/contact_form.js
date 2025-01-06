console.log("contact_form.js loaded");

const btn = document.getElementById("submit");

const objet = document.getElementById("contact_form_objet");
const email = document.getElementById("contact_form_email");
const message = document.getElementById("contact_form_message");

const label_objet = document.getElementById("label_objet");
const label_mail = document.getElementById("label_email");
const label_message = document.getElementById("label_message");

const regex_objet = /^[A-Za-z0-9À-ÿ .,'"\-!?()@#&%$:+/=]{1,50}$/;
const regex_mail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const regex_message = /^[A-Za-z0-9À-ÿ .,'"\-!?()@#&%$:+/=]{1,500}$/;

function redError(element) {
  element.style.outline = "2px solid red";
  element.style.transition = "100ms";
}
function greenError(element) {
  element.style.outline = "2px solid green";
  element.style.transition = "100ms";
}

function checkRealTime() {
  objet.addEventListener("input", () => {
    if (!regex_objet.test(objet.value)) {
      redError(objet);
      label_objet.innerHTML =
        "L'objet du message contient des caractères non valides, dépasse 50 caractères ou est vide.";
    } else {
      label_objet.innerHTML = "Sujet du message";
      greenError(objet);
    }
  });

  email.addEventListener("input", () => {
    if (!regex_mail.test(email.value)) {
      redError(email);
      label_mail.innerHTML = "L'adresse mail est invalide ou est vide.";
    } else {
      label_mail.innerHTML = "Votre adresse email";
      greenError(email);
    }
  });

  message.addEventListener("input", () => {
    if (!regex_message.test(message.value)) {
      redError(message);
      label_message.innerHTML =
        "Le message contient des caractères non valides ou est vide.";
    } else {
      label_message.innerHTML = "Votre message";
      greenError(message);
    }
  });
}

btn.addEventListener("click", (e) => {
  if (!regex_objet.test(objet.value)) {
    redError(objet);
    label_objet.innerHTML =
      "L'objet du message contient des caractères non valides, dépasse 50 caractères ou est vide.";
    e.preventDefault();
  } else {
    greenError(objet);
  }

  if (!regex_mail.test(email.value)) {
    redError(email);
    label_mail.innerHTML = "L'adresse mail est invalide ou est vide.";
    e.preventDefault();
  } else {
    greenError(email);
  }

  if (!regex_message.test(message.value)) {
    redError(message);
    label_message.innerHTML =
      "Le message contient des caractères non valides ou est vide.";
    e.preventDefault();
  } else {
    greenError(message);
  }
  checkRealTime();
});
