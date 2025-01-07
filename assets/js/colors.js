let lastcolor;

const colors = [
  { backgroundColor: "#ff5733", color: "white" },
  { backgroundColor: "#33ff57", color: "black" },
  { backgroundColor: "#0044ff", color: "white" },
  { backgroundColor: "#970747", color: "white" },
  { backgroundColor: "#5527ff", color: "white" },
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
