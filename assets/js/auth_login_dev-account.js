document.addEventListener("turbo:load", function () {
  if ("/login" === window.location.pathname) {
    const DevInterface = document.createElement("div");

    DevInterface.style.position = "fixed";
    DevInterface.style.bottom = "50px";
    DevInterface.style.left = "50%";
    DevInterface.style.transform = "translateX(-50%)";
    DevInterface.style.borderRadius = "16px";
    DevInterface.style.width = "500px";
    DevInterface.style.height = "150px";
    DevInterface.style.background = "rgba(0, 0, 0, 0.700)";
    DevInterface.style.display = "flex";
    DevInterface.style.flexDirection = "column";

    DevInterface.style.gap = "10px";

    const title = document.createElement("h6");
    title.textContent = "Compte Dev";
    title.classList = ["text-center text-light mt-3"];
    DevInterface.appendChild(title);

    const buttonContainer = document.createElement("div");
    buttonContainer.style.display = "flex";
    buttonContainer.style.justifyContent = "center";
    buttonContainer.style.gap = "10px";

    const btn_client = document.createElement("button");
    btn_client.classList = ["btn btn-light m-1"];
    btn_client.textContent = "Compte Client";
    buttonContainer.appendChild(btn_client);

    const btn_chef = document.createElement("button");
    btn_chef.classList = ["btn btn-light m-1"];
    btn_chef.textContent = "Compte Chef";
    buttonContainer.appendChild(btn_chef);

    const btn_admin = document.createElement("button");
    btn_admin.classList = ["btn btn-light m-1"];
    btn_admin.textContent = "Compte Admin";
    buttonContainer.appendChild(btn_admin);

    DevInterface.appendChild(buttonContainer);

    const class_a = document.createElement("a");
    class_a.classList.add(
      "text-decoration-none",
      "text-white",
      "text-center",
      "m-1"
    );
    class_a.style.cursor = "pointer";
    class_a.textContent = "Fermer";
    DevInterface.appendChild(class_a);

    document.body.appendChild(DevInterface);

    class_a.addEventListener("click", () => {
      DevInterface.remove();
    });

    const email = document.getElementById("username");
    const mdp = document.getElementById("password");

    btn_client.addEventListener("click", () => {
      email.value = "CompteClient@TestDev.com";
      mdp.value = "Qv6998tqD$]QPm5Ly{q4!TjwUzA/9(6a7nY66j#V%3m*:9-T[S";
    });

    btn_chef.addEventListener("click", () => {
      email.value = "CompteChef@TestDev.com";
      mdp.value = "V*{95y9/Q:L66jjvA73$!T6TtQ8qPzn[w6-Y%a9mUD(q94]#Sm";
    });

    btn_admin.addEventListener("click", () => {
      email.value = "CompteAdmin@TestDev.com";
      mdp.value = "9pR@Zyf7*ZL5b+76_^2i9hs3mP7=pKjX)6Z-8M4%K7Xy;[zMi:";
    });
  }
});
