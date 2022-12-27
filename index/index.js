document.querySelectorAll(".toggleBtn").forEach((e) => {
  e.addEventListener("click", () => {
    const target = e.dataset.target;

    if (target.includes("student")) {
      document
        .querySelector(".studentFormbox.active")
        .classList.remove("active");
      document.querySelector(`.${target}`).classList.add("active");
    } else {
      document
        .querySelector(".supervisorFormbox.active")
        .classList.remove("active");
      document.querySelector(`.${target}`).classList.add("active");
    }
  });
});
