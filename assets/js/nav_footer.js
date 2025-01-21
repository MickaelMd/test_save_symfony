document.addEventListener("turbo:load", function () {
  const nav = document.getElementsByTagName("nav")[0];
  const btn_nav = document.getElementById("checkbox");
  let lastScroll = 0;
  let active = false;

  document.addEventListener("scroll", () => {
    const currentScroll = window.scrollY;

    if (currentScroll > 100) {
      if (active == false) {
        nav.style.top = "-100px";
        nav.style.transition = "1000ms";
      }
    }

    if (currentScroll < lastScroll) {
      if (active == false) {
        nav.style.top = "0";
        nav.style.transition = "300ms";
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
