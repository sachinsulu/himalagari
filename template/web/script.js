document.addEventListener("DOMContentLoaded", () => {
  const toggleBtns = document.querySelectorAll(".searchToggle");
  const bottomSearch = document.querySelector(".bottomSearch");

  // Toggle on button click
  toggleBtns.forEach((btn) => {
    btn.addEventListener("click", (e) => {
      e.stopPropagation(); // prevent document click from firing
      bottomSearch.classList.toggle("active");
    });
  });

  // Click outside to close
  document.addEventListener("click", (e) => {
    const clickedInsideSearch = bottomSearch.contains(e.target);
    const clickedToggleBtn = [...toggleBtns].some((btn) =>
      btn.contains(e.target),
    );

    if (!clickedInsideSearch && !clickedToggleBtn) {
      bottomSearch.classList.remove("active");
    }
  });
});
