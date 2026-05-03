/**
 * load-more.js — Global "Load More / Show Less" handler for .packages-wrapper sections
 */
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".packages-wrapper").forEach(function (section) {
    var cards = Array.from(section.querySelectorAll(".package-card, .deal-card"));
    var btn = section.querySelector(".js-load-more-packages");

    if (!btn || !cards.length) return;

    var initial = parseInt(btn.getAttribute("data-initial"), 10) || 6;
    var step = parseInt(btn.getAttribute("data-step"), 10) || 24;
    var loadMoreWrap = btn.closest(".load-more-wrap");

    /* Ensure cards beyond initial are hidden */
    cards.forEach(function (card, i) {
      if (i >= initial) card.style.setProperty("display", "none", "important");
    });

    /* Hide button if not needed */
    if (cards.length <= initial) {
      if (loadMoreWrap) loadMoreWrap.style.setProperty("display", "none", "important");
      return;
    }

    var shown = initial;

    btn.addEventListener("click", function (e) {
      e.preventDefault();
      var pTag = btn.querySelector("p");

      if (btn.classList.contains("showing-all")) {
        /* ---- Show Less ---- */
        shown = initial;
        cards.forEach(function (card, i) {
          if (i >= shown) card.style.setProperty("display", "none", "important");
        });
        btn.classList.remove("showing-all");
        if (pTag) pTag.innerText = btn.getAttribute("data-text-more") || "Load More Packages";

        /* Scroll to TOP of this section smoothly */
        setTimeout(function () {
          section.scrollIntoView({ behavior: "smooth", block: "start" });
        }, 50);

      } else {
        /* ---- Show More ---- */
        var next = Math.min(shown + step, cards.length);
        for (var i = shown; i < next; i++) {
          cards[i].style.setProperty("display", "block", "important");
        }
        shown = next;

        if (shown >= cards.length) {
          btn.classList.add("showing-all");
          if (pTag) pTag.innerText = btn.getAttribute("data-text-less") || "Show Less Packages";
        }
      }
    });
  });
});
