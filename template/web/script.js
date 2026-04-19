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

$(document).ready(function() {
  const base_url = window.location.origin + window.location.pathname.substring(0, window.location.pathname.indexOf('/', 1) + 1);

  // 1. Review Form Validation & AJAX
  if ($("#reviewForm").length) {
    $("#reviewForm").validate({
      submitHandler: function(form) {
        let formData = $(form).serialize() + "&action=forcoment";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#reviewMsg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
            if (response.action === "success") form.reset();
          },
          error: function() {
            $("#reviewMsg").html(`<div class="alert alert-danger">An error occurred while submitting your review. Please try again.</div>`);
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 2. Contact Us Form Validation & AJAX
  if ($("#contactForm").length) {
    $("#contactForm").validate({
      rules: {
        name: "required",
        email: {
          required: true,
          email: true
        },
        country: "required",
        emobile: "required",
        message: "required"
      },
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      },
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }

        let formData = $(form).serialize() + "&action=forcoment";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#contactMsg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
            if (response.action === "success") {
                form.reset();
                if (typeof grecaptcha !== "undefined") grecaptcha.reset();
            }
          },
          error: function() {
            $("#contactMsg").html(`<div class="alert alert-danger">An error occurred while sending your message. Please try again.</div>`);
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 3. Fixed Departure Form Validation & AJAX
  if ($("#fixedDepartureForm").length) {
    $("#fixedDepartureForm").validate({
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }
        
        let formData = $(form).serialize();
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "includes/controllers/ajax.bookinginfo.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#bookmsg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
            if (response.action === "success") {
                form.reset();
                if (typeof grecaptcha !== "undefined") grecaptcha.reset();
            }
          },
          error: function() {
            $("#bookmsg").html(`<div class="alert alert-danger">An error occurred while processing your booking. Please try again.</div>`);
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 4. Customize Form Validation & AJAX (Inner Modal)
  if ($("#customizeForm").length) {
    $("#customizeForm").validate({
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }
        
        let formData = $(form).serialize();
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#customizeMsg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
            if (response.action === "success") {
              form.reset();
              if (typeof grecaptcha !== "undefined") {
                  try { grecaptcha.reset(); } catch(e) {}
              }
            }
          },
          error: function() {
            $("#customizeMsg").html('<div class="alert alert-danger">An error occurred while processing your request. Please try again.</div>');
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 5. Booking Form Validation & AJAX
  if ($("#bookingForm").length) {
    $("#bookingForm").validate({
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }
        
        let formData = $(form).serialize();
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "includes/controllers/ajax.bookinginfo.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#bookingMsg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
            if (response.action === "success") {
                form.reset();
                if (typeof grecaptcha !== "undefined") grecaptcha.reset();
            }
          },
          error: function() {
            $("#bookingMsg").html(`<div class="alert alert-danger">An error occurred while processing your booking. Please try again.</div>`);
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 6. Header Plan Your Trip Form Validation & AJAX
  if ($("#planTripForm").length) {
    $("#planTripForm").validate({
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }
        
        let formData = $(form).serialize() + "&action=plan_trip";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#planTripMsg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>');
            if (response.action === "success") {
              form.reset();
              if (typeof grecaptcha !== "undefined") grecaptcha.reset();
            }
          },
          error: function() {
            $("#planTripMsg").html('<div class="alert alert-danger">An error occurred while processing your request. Please try again.</div>');
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 7. Enquiry Form Validation & AJAX
  if ($("#enquiry_form").length) {
    $("#enquiry_form").validate({
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }
        
        let formData = $(form).serialize() + "&action=forcoment";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#msg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>').show();
            if (response.action === "success") {
                form.reset();
                if (typeof grecaptcha !== "undefined") grecaptcha.reset();
            }
          },
          error: function() {
            $("#msg").html(`<div class="alert alert-danger">An error occurred while sending your enquiry. Please try again.</div>`).show();
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 8. Customize Form (Full Page) Validation & AJAX
  if ($("#customize_form").length) {
    $("#customize_form").validate({
      submitHandler: function(form) {
        if (typeof grecaptcha !== "undefined") {
          var response = $(form).find('textarea[name="g-recaptcha-response"]').val();
          if (!response) {
            alert("Please verify that you are not a robot.");
            return false;
          }
        }
        
        let formData = $(form).serialize() + "&action=forcoment";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: base_url + "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#msg").html('<div class="alert alert-' + (response.action === 'success' ? 'success' : 'danger') + '">' + response.message + '</div>').show();
            if (response.action === "success") {
                form.reset();
                if (typeof grecaptcha !== "undefined") grecaptcha.reset();
            }
          },
          error: function() {
            $("#msg").html(`<div class="alert alert-danger">An error occurred while sending your request. Please try again.</div>`).show();
          },
          complete: function() {
            $btn.text(btnText).prop("disabled", false);
          }
        });
      }
    });
  }

  // 9. About Page: Team tabs and detail popups
  $(document).on("click", ".team-tabs .tab", function(e) {
    e.preventDefault();
    const targetTab = $(this).data("tab");
    if (!targetTab) return;

    $(this).addClass("active").siblings(".tab").removeClass("active");
    $(".team-content").removeClass("active");
    $("#" + targetTab).addClass("active");
  });

  $(document).on("click", ".show-more", function(e) {
    e.preventDefault();
    const $overlay = $(this).siblings(".popup-overlay");
    if ($overlay.length) {
      $overlay.css("display", "flex");
      $("body").css("overflow", "hidden");
    }
  });

  $(document).on("click", ".popup-overlay .close-btn", function(e) {
    e.preventDefault();
    $(this).closest(".popup-overlay").hide();
    $("body").css("overflow", "");
  });

  $(document).on("click", ".popup-overlay", function(e) {
    if (e.target === this) {
      $(this).hide();
      $("body").css("overflow", "");
    }
  });

  // 10. About Page: Legal documents image lightbox
  const legalPopup = document.getElementById("imgPopup");
  const legalPopupImage = document.getElementById("popupImage");

  if (legalPopup && legalPopupImage) {
    const legalImages = Array.from(document.querySelectorAll(".legal-grid .popup-img"));
    const closeBtn = legalPopup.querySelector(".close");
    const prevBtn = legalPopup.querySelector(".prev");
    const nextBtn = legalPopup.querySelector(".next");
    let currentIndex = 0;

    const openLegalPopup = index => {
      if (!legalImages.length) return;
      currentIndex = (index + legalImages.length) % legalImages.length;
      legalPopupImage.src = legalImages[currentIndex].src;
      legalPopupImage.alt = legalImages[currentIndex].alt || "Legal document preview";
      legalPopup.style.display = "flex";
      document.body.style.overflow = "hidden";
    };

    const closeLegalPopup = () => {
      legalPopup.style.display = "none";
      document.body.style.overflow = "";
    };

    legalImages.forEach((img, index) => {
      img.addEventListener("click", () => openLegalPopup(index));

      const wrapper = img.closest(".docs_wrapper");
      if (wrapper) {
        wrapper.addEventListener("click", evt => {
          if (evt.target.closest(".search-icon") || evt.target === wrapper) {
            openLegalPopup(index);
          }
        });
      }
    });

    if (closeBtn) {
      closeBtn.addEventListener("click", closeLegalPopup);
    }
    if (prevBtn) {
      prevBtn.addEventListener("click", evt => {
        evt.stopPropagation();
        openLegalPopup(currentIndex - 1);
      });
    }
    if (nextBtn) {
      nextBtn.addEventListener("click", evt => {
        evt.stopPropagation();
        openLegalPopup(currentIndex + 1);
      });
    }

    legalPopup.addEventListener("click", evt => {
      if (evt.target === legalPopup) {
        closeLegalPopup();
      }
    });

    document.addEventListener("keydown", evt => {
      const isPopupVisible = legalPopup.style.display === "flex";
      if (!isPopupVisible) return;

      if (evt.key === "Escape") closeLegalPopup();
      if (evt.key === "ArrowLeft") openLegalPopup(currentIndex - 1);
      if (evt.key === "ArrowRight") openLegalPopup(currentIndex + 1);
    });
  }

  // --- Plan Your Trip Dynamic Calculations ---
  
  function updateInquiryPrice() {
    const $pkgSel = $("#inq_package");
    const $priceInput = $("#inq_price");
    const $paxInput = $("#inq_pax");

    if (!$pkgSel.length || !$priceInput.length || !$paxInput.length) return;

    const $selected = $pkgSel.find("option:selected");
    const priceAttr = $selected.attr("data-price") || "";
    const pax = parseInt($paxInput.val()) || 1;

    if (priceAttr === "") {
        $priceInput.val("");
        return;
    }

    // Extract numeric value (remove anything except digits and dot)
    const numericStr = priceAttr.replace(/[^0-9.]/g, "");
    const pricePerPax = parseFloat(numericStr);

    if (!isNaN(pricePerPax)) {
        const total = pricePerPax * (pax > 0 ? pax : 1);
        $priceInput.val(total.toFixed(2));
    } else {
        // Fallback to original attribute if not a number
        $priceInput.val(priceAttr);
    }
    
    // Manually trigger validation if it exists
    if (typeof $priceInput.valid === "function") {
        $priceInput.valid();
    }
  }

  // Handle Package / Pax change
  $(document).on("change", "#inq_package", updateInquiryPrice);
  $(document).on("input change", "#inq_pax", updateInquiryPrice);

  // Handle Country Code Selection - Fixed Departure
  $(document).on("change", ".tripCountry", function() {
    const $selected = $(this).find("option:selected");
    const dialCode = $selected.attr("data-code") || "";
    $(this).closest("form").find(".country-code-input").val(dialCode);
  });

  // Handle Country Code Selection - Customize
  $(document).on("change", ".customizeCountry", function() {
    const $selected = $(this).find("option:selected");
    const dialCode = $selected.attr("data-code") || "";
    $("#customizeCountryCode").val(dialCode);
  });

  // Handle Country Code Selection - Booking
  $(document).on("change", ".row3Country", function() {
    const $selected = $(this).find("option:selected");
    const dialCode = $selected.attr("data-code") || "";
    $("#row3CountryCode").val(dialCode);
  });

  // Initial call to set price if something is already selected
  updateInquiryPrice();

  // 11. Homepage package sections: show 8 cards first, reveal more on click
  document.querySelectorAll(".packages-wrapper").forEach(function(section) {
    const cards = Array.from(section.querySelectorAll(".packages-grid .package-card"));
    const btn = section.querySelector(".js-load-more-packages");

    if (!btn || !cards.length) return;

    const initial = parseInt(btn.getAttribute("data-initial"), 10) || 8;
    const step = parseInt(btn.getAttribute("data-step"), 10) || 4;
    const loadMoreWrap = btn.closest(".load-more-wrap");

    if (cards.length <= initial) {
      if (loadMoreWrap) loadMoreWrap.style.display = "none";
      return;
    }

    let shown = initial;
    cards.forEach(function(card, index) {
      if (index >= shown) {
        card.style.display = "none";
      }
    });

    btn.addEventListener("click", function() {
      const next = Math.min(shown + step, cards.length);
      for (let i = shown; i < next; i++) {
        cards[i].style.display = "";
      }
      shown = next;

      if (shown >= cards.length && loadMoreWrap) {
        loadMoreWrap.style.display = "none";
      }
    });
  });

});
