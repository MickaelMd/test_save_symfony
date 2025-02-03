document.addEventListener("turbo:load", function () {
  const nav = document.getElementsByTagName("nav")[0];
  const btn_nav = document.getElementById("checkbox");
  const btn_panier = document.getElementById("cart_logo_footer");
  let lastScroll = 0;
  let active = false;

  // --

  if (!localStorage.getItem("panier")) {
    localStorage.setItem("panier", JSON.stringify([]));
    localStorage.setItem("panierActive", false);
  }
  let panier = JSON.parse(localStorage.getItem("panier"));

  function CheckPanier() {
    let images = document.querySelectorAll(".shopping_nav_logo");
    let filter;

    if (panier.length > 0) {
      localStorage.setItem("panierActive", true);
      filter = "invert(20%) sepia(100%) saturate(5000%) hue-rotate(-10deg)";

      images.forEach((img) => {
        img.style.filter = filter;

        setInterval(() => {
          img.style.transition = "transform 0.3s ease-in-out";
          img.style.transform = "translateY(6px)";

          setTimeout(() => {
            img.style.transform = "translateY(0px)";
          }, 300);
        }, 1300);
      });
    } else {
      localStorage.setItem("panierActive", false);
      filter = "white";
      images.forEach((img) => {
        img.style.filter = filter;
      });
    }
  }

  CheckPanier();

  // --

  document.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;

    if (currentScroll > 100) {
      let panierActive = localStorage.getItem("panierActive");
      if (active == false) {
        nav.style.top = "-100px";
        nav.style.transition = "1000ms";

        if (
          panierActive == "true" &&
          !window.location.href.includes("panier")
        ) {
          btn_panier.style.display = "block";
          btn_panier.style.transition = "300ms";
          btn_panier.style.bottom = "100px";
        } else {
          btn_panier.style.display = "none";
        }
      }
    }

    if (currentScroll < lastScroll) {
      let panierActive = localStorage.getItem("panierActive");
      if (active == false) {
        nav.style.top = "0";
        nav.style.transition = "300ms";

        if (
          panierActive == "true" &&
          !window.location.href.includes("panier")
        ) {
          btn_panier.style.display = "block";
          btn_panier.style.transition = "300ms";
          btn_panier.style.bottom = "-100px";
        } else {
          btn_panier.style.display = "none";
        }
      }
    }

    lastScroll = currentScroll;
  });

  btn_nav.addEventListener("click", () => {
    if (active == false) {
      active = true;
      nav.style.height = "320px";
    } else {
      nav.style.height = "";
      active = false;
    }
  });

  document.addEventListener("keydown", (event) => {
    if (event.key === "Escape") {
      if (active) {
        nav.style.height = "";
        btn_nav.checked = false;
        active = false;
      }
    }
  });

  const mediaQuery = window.matchMedia("(min-width: 805px)");

  function handleScreenChange(e) {
    if (e.matches) {
      nav.style.height = "";
      btn_nav.checked = false;
      active = false;
    }
  }

  handleScreenChange(mediaQuery);

  mediaQuery.addEventListener("change", handleScreenChange);

  // ---------------------

  document.querySelectorAll("nav a").forEach((link) => {
    if (link.href === window.location.href) {
      link.classList.add("active");
    }
  });

  document.querySelectorAll("footer a").forEach((link) => {
    if (link.href === window.location.href) {
      link.classList.add("active");
    }
  });
});
