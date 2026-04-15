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
          url: "enquiry_mail.php", // Assuming relative to root
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#reviewMsg").html(`<div class="alert alert-${response.action === 'success' ? 'success' : 'danger'}">${response.message}</div>`);
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
      submitHandler: function(form) {
        let formData = $(form).serialize() + "&action=forcoment";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: "enquiry_mail.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#contactMsg").html(`<div class="alert alert-${response.action === 'success' ? 'success' : 'danger'}">${response.message}</div>`);
            if (response.action === "success") form.reset();
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
        let formData = $(form).serialize() + "&action=request_inquiry";
        let $btn = $(form).find('button[type="submit"]');
        let btnText = $btn.text();
        $btn.text("Submitting...").prop("disabled", true);
        
        $.ajax({
          type: "POST",
          url: "includes/controllers/ajax.bookinginfo.php", 
          data: formData,
          dataType: "json",
          success: function(response) {
            $("#bookmsg").html(`<div class="alert alert-${response.action === 'success' ? 'success' : 'danger'}">${response.message}</div>`);
            if (response.action === "success") form.reset();
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
});
