$(function () {
  // Mobile navigation
  $(".mobile-menu").on("click", function () {
    $(".main-nav").toggleClass("open");
    $(this).find("i").toggleClass("fa-bars fa-xmark");
  });

  $(".main-nav a").on("click", function () {
    $(".main-nav").removeClass("open");
    $(".mobile-menu i").removeClass("fa-xmark").addClass("fa-bars");
  });

  // Search tabs: keep selected tab state and adjust placeholder context
  const placeholders = {
    vehicles: "Make, model or keyword",
    property: "Search houses, plots or apartments",
    matrimonial: "Search profile ID or keyword",
    classifieds: "Search products and classifieds",
    jobs: "Job title, skill or company"
  };
  $(".search-tab").on("click", function () {
    $(".search-tab").removeClass("selected");
    $(this).addClass("selected");
    const type = $(this).data("tab");
    $(".search-input input").attr("placeholder", placeholders[type] || "Search keyword");
  });

  // Favourite buttons
  $(".favorite").on("click", function () {
    $(this).toggleClass("is-favorite");
    const icon = $(this).find("i");
    icon.toggleClass("fa-regular fa-solid");
    icon.toggleClass("fa-heart");
  });

  // Search form demo behavior
  $(".search-fields").on("submit", function (e) {
    e.preventDefault();
    const query = $(this).find('input[type="search"]').val().trim();
    if (!query) {
      $(this).find('input[type="search"]').trigger("focus");
      return;
    }
    const target = $(".search-tab.selected").data("tab");
    const sectionMap = {
      jobs: "#jobs", property: "#property", classifieds: "#classifieds",
      vehicles: "#vehicles", matrimonial: "#matrimonial"
    };
    const $section = $(sectionMap[target] || "#vehicles");
    const $cards = $section.find(".listing-card, .profile-card");
    let matches = 0;
    $cards.each(function () {
      const found = $(this).text().toLowerCase().includes(query.toLowerCase());
      $(this).toggle(found);
      if (found) matches++;
    });
    $section[0].scrollIntoView({ behavior: "smooth", block: "start" });
    if (matches === 0) {
      $cards.show();
      alert("No exact match found in this sample section. Showing all listings.");
    }
  });

  // Category pill quick scroll
  $(".category-pills button").on("click", function () {
    $(".category-pills button").removeClass("active");
    $(this).addClass("active");
    const label = $(this).text().toLowerCase();
    const map = { car: "#vehicles", property: "#property", marriage: "#matrimonial",
      classified: "#classifieds", "job search": "#jobs" };
    if (map[label]) $(map[label])[0].scrollIntoView({ behavior: "smooth", block: "start" });
  });

  // Newsletter demo validation
  $(".newsletter form").on("submit", function (e) {
    e.preventDefault();
    const $input = $(this).find("input");
    if ($input[0].checkValidity()) {
      alert("Thanks for subscribing!");
      $input.val("");
    } else {
      $input[0].reportValidity();
    }
  });
});