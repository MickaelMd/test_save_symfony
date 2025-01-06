let lastcolor;

const colors = [
  { backgroundColor: "#ff5733", color: "white" },
  { backgroundColor: "#33ff57", color: "black" },
  { backgroundColor: "#3357ff", color: "yellow" },
  { backgroundColor: "#970747", color: "white" },
];

document.addEventListener("mousedown", () => {
  let newcolors = colors[Math.floor(Math.random() * colors.length)];

  if (lastcolor == newcolors) {
    newcolors = colors[Math.floor(Math.random() * colors.length)];
  }

  let style = document.createElement("style");
  document.head.appendChild(style);

  style.sheet.insertRule(
    `
      ::selection {
        background-color: ${newcolors.backgroundColor};
        color: ${newcolors.color};
      }
    `,
    style.sheet.cssRules.length
  );

  lastcolor = newcolors;
});
