document.addEventListener("turbo:load", function () {
  let lastcolor;
  const colors = [
    { backgroundColor: "#ff5733", color: "white" },
    { backgroundColor: "#33ff57", color: "black" },
    { backgroundColor: "#0044ff", color: "white" },
    { backgroundColor: "#970747", color: "white" },
    { backgroundColor: "#5527ff", color: "white" },
  ];

  let style = document.createElement("style");
  document.head.appendChild(style);

  style.sheet.insertRule(
    `::selection { background-color: transparent; color: transparent; }`,
    0
  );

  document.addEventListener("mousedown", () => {
    let newcolors = colors[Math.floor(Math.random() * colors.length)];

    if (lastcolor === newcolors) {
      newcolors = colors[Math.floor(Math.random() * colors.length)];
    }

    if (!style.sheet) {
      style = document.createElement("style");
      document.head.appendChild(style);
    }

    if (style.sheet.cssRules.length > 0) {
      style.sheet.deleteRule(0);
    }

    style.sheet.insertRule(
      `::selection {
      background-color: ${newcolors.backgroundColor};
      color: ${newcolors.color};
    }`,
      0
    );

    lastcolor = newcolors;
  });

  // ------------

  const logo = document.getElementById("logo_header");
  const input = document.getElementById("input_search");
  let i = 0;
  let angle = 0;

  input.addEventListener("click", () => {
    i++;
    if (i === 10) {
      for (let i = 0; i < 100; i++) {
        angle += 360;
        logo.style.transition = "transform 2s ease-in-out";
        logo.style.transform = `rotate(${angle}deg)`;
      }
      i = 0;
    }
  });
});
