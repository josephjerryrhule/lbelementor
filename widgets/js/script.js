document.addEventListener("DOMContentLoaded", () => {
  const btns = document.querySelectorAll(".lbmodalbtn");
  const modals = document.querySelectorAll(".lb-elementor-modal");
  const dialogs = document.querySelectorAll(".lb-elementor-modaldialog");
  const closes = document.querySelectorAll(".lb-modal-close");

  btns.forEach((btn, index) => {
    btn.addEventListener("click", () => {
      const modal = modals[index];
      const dialog = dialogs[index];
      const close = closes[index];

      if (modal && dialog) {
        modal.classList.add("open");
        dialog.classList.add("open");
      }

      close.addEventListener("click", () => {
        if (modal && dialog) {
          modal.classList.remove("open");
          dialog.classList.remove("open");
        }
      });
    });
  });
});

jQuery(document).ready(function ($) {
  $(".lb-wperfume-radio-item").hover(
    function () {
      // On hover, disable other radio items with the same class
      $(".lb-wperfume-radio-item").not(this).addClass("disabled");
    },
    function () {
      // On hover out, enable all radio items with the same class
      $(".lb-wperfume-radio-item").removeClass("disabled");
    }
  );
});

jQuery(document).ready(function ($) {
  $(".lb-wperfumenotes-radio-item").hover(
    function () {
      // On hover, disable other radio items with the same class
      $(".lb-wperfumenotes-radio-item").not(this).addClass("disabled");
    },
    function () {
      // On hover out, enable all radio items with the same class
      $(".lb-wperfumenotes-radio-item").removeClass("disabled");
    }
  );
});

jQuery(document).ready(($) => {
  // Disable the Next button initially
  $("#nextStep1").prop("disabled", true);

  // Initialize a variable to keep track of the currently selected item
  let selectedRadio = null;

  // Add event listener for radio buttons in Step 1 form
  $(".lb-wperfume-radio-item").change(function () {
    // Enable the Next button
    $("#nextStep1").prop("disabled", false);

    // Add disabled class to other radio items with the same class
    $(".lb-wperfume-radio-item").not(this).addClass("disabled");

    // Toggle lbselected class on the selected radio item
    $(this).toggleClass("lbselected");

    // If a radio item was previously selected, remove lbselected class
    if (selectedRadio !== null && selectedRadio !== this) {
      $(selectedRadio).removeClass("lbselected");
    }

    // Remove disabled class from the Next button
    $("#nextStep1").removeClass("disabled");

    // Update the selectedRadio variable
    selectedRadio = this;
  });
});

jQuery(document).ready(($) => {
  // Disable the Next button initially
  $("#nextStep2").prop("disabled", true);

  // Initialize a variable to keep track of the currently selected item
  let selectedRadio2 = null;

  // Add event listener for radio buttons in Step 1 form
  $(".lb-wperfumenotes-radio-item").change(function () {
    // Enable the Next button
    $("#nextStep2").prop("disabled", false);

    // Add disabled class to other radio items with the same class
    $(".lb-wperfumenotes-radio-item").not(this).addClass("disabled");

    // Toggle lbselected class on the selected radio item
    $(this).toggleClass("lbselected");

    // If a radio item was previously selected, remove lbselected class
    if (selectedRadio2 !== null && selectedRadio2 !== this) {
      $(selectedRadio2).removeClass("lbselected");
    }

    // Remove disabled class from the Next button
    $("#nextStep2").removeClass("disabled");

    // Update the selectedRadio2 variable
    selectedRadio2 = this;
  });
});

jQuery(document).ready(($) => {
  // Disable the Next button initially
  $("#nextStep3").prop("disabled", true);

  // Initialize a variable to keep track of the currently selected item
  let selectedRadio3 = null;

  // Add event listener for radio buttons in Step 1 form
  $(".lb-wperfumemoments-radio-item").change(function () {
    // Enable the Next button
    $("#nextStep3").prop("disabled", false);

    // Add disabled class to other radio items with the same class
    $(".lb-wperfumemoments-radio-item").not(this).addClass("disabled");

    // Toggle lbselected class on the selected radio item
    $(this).toggleClass("lbselected");

    // If a radio item was previously selected, remove lbselected class
    if (selectedRadio3 !== null && selectedRadio3 !== this) {
      $(selectedRadio3).removeClass("lbselected");
    }

    // Remove disabled class from the Next button
    $("#nextStep3").removeClass("disabled");

    // Update the selectedRadio2 variable
    selectedRadio3 = this;
  });
});

jQuery(document).ready(($) => {
  // Initialize an object to store user selections
  var userSelections = {};

  // Function to handle form progression
  function nextStep(stepNumber) {
    // Update the progress bar width based on the current step
    var progressBarWidth = stepNumber * (100 / 4); // Assuming 5 steps, adjust as needed
    $(".lbabsolute").css("width", progressBarWidth + "%");

    // Store user selections based on the current step
    if (stepNumber === 1) {
      userSelections.lbcategory = $("input[name='lbcategory']:checked").val();
    } else if (stepNumber === 2) {
      userSelections.notes = $("input[name='notes']:checked").val();
    } else if (stepNumber === 3) {
      userSelections.moment = $("input[name='moment']:checked").val();
    } else if (stepNumber === 4) {
      userSelections.intensity = $("#intensity").val();
      // If it's the last step, show the results
      showResults();
      $("#step4Form").hide();
      return; // Stop further progression after showing results
    }

    // Hide current step
    $("#step" + stepNumber + "Form").hide();

    // Show next step
    var nextStepNumber = stepNumber + 1;
    $("#step" + nextStepNumber + "Form").show();
  }

  // Function to show results
  function showResults() {
    // Perform an AJAX request to fetch results based on userSelections
    $.ajax({
      url: custom_script_vars.ajax_url,
      type: "POST",
      data: {
        action: "get_results",
        userSelections: userSelections,
      },
      success: function (response) {
        // Display the results in the 'results' div
        $("#results").html(response).show();
      },
      error: function (error) {
        console.log(error);
      },
    });
  }

  // Click event listeners for the buttons
  $("#nextStep1").on("click", function () {
    nextStep(1);
  });

  $("#nextStep2").on("click", function () {
    nextStep(2);
  });

  $("#nextStep3").on("click", function () {
    nextStep(3);
  });

  $("#nextStep4").on("click", function () {
    nextStep(4);
  });

  // Click event listener for the "Step Back" button
  $("#stepback").on("click", function () {
    var currentStep = $(".lbabsolute").width() / (100 / 4) + 1; // Calculate current step based on progress bar width
    var previousStep = Math.max(currentStep - 1, 1); // Ensure previous step is at least 1

    // Hide current step
    $("#step" + currentStep + "Form").hide();

    // Show previous step
    $("#step" + previousStep + "Form").show();

    // Update the progress bar width
    var progressBarWidth = (previousStep - 1) * (100 / 4);
    $(".lbabsolute").css("width", progressBarWidth + "%");
  });
});

document.addEventListener("DOMContentLoaded", () => {
  var notesSwiper = new Swiper(".wperfumenote-swiper", {
    direction: "horizontal",
    slidesPerView: 1,
    breakpoints: {
      375: {
        spaceBetween: 10,
      },
      1220: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
    },
  });
});

document.addEventListener("DOMContentLoaded", () => {
  var momentsSwiper = new Swiper(".wperfumemoment-swiper", {
    direction: "horizontal",
    slidesPerView: 1,
    breakpoints: {
      375: {
        spaceBetween: 10,
      },
      1220: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
    },
  });
});

document.addEventListener("DOMContentLoaded", () => {
  var swiper = new Swiper(".lbSwiper", {
    loop: true,
    spaceBetween: 0,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    autoplay: true,
  });

  var swiper2 = new Swiper(".lbSwiper2", {
    loop: true,
    spaceBetween: 0,
    autoplay: true,
    thumbs: {
      swiper: swiper,
    },
  });
});

document.addEventListener("DOMContentLoaded", () => {
  var smSwiper = new Swiper(".lb-product-swiper", {
    loop: true,
    spaceBetween: 0,
    slidesPerView: 1,
    pagination: {
      el: ".swiper-pagination",
    },
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const galleryImages = document.querySelectorAll(".lb-gallery-image");
  const dragImage = document.querySelector(".lb-drag-image");
  const circles = document.querySelectorAll(".lb-drag-circle");

  let isDragging = false;
  let initialY = 0;

  dragImage.addEventListener("mousedown", startDragging);
  dragImage.addEventListener("touchstart", startDragging);

  function startDragging(e) {
    e.preventDefault();
    isDragging = true;
    dragImage.classList.add("dragging");

    initialY = e.clientY || e.touches[0].clientY - dragImage.offsetTop;
  }

  document.addEventListener("mousemove", handleDragging);
  document.addEventListener("touchmove", handleDragging);

  function handleDragging(e) {
    if (isDragging) {
      let newY = (e.clientY || e.touches[0].clientY) - initialY;
      dragImage.style.top =
        Math.max(
          0,
          Math.min(
            newY,
            dragImage.parentElement.clientHeight - dragImage.clientHeight
          )
        ) + "px";

      let nearestCircle = null;
      let minDistance = Infinity;

      circles.forEach((circle) => {
        const distance = Math.abs(circle.offsetTop - dragImage.offsetTop);
        if (distance < minDistance) {
          minDistance = distance;
          nearestCircle = circle;
        }
      });

      if (nearestCircle) {
        const index = nearestCircle.id.replace("lb-image-", "");
        galleryImages.forEach((image) => {
          image.classList.remove("active");
        });
        galleryImages[index].classList.add("active");
      }
    }
  }

  document.addEventListener("mouseup", stopDragging);
  document.addEventListener("touchend", stopDragging);

  function stopDragging() {
    if (isDragging) {
      isDragging = false;
      dragImage.classList.remove("dragging");
    }
  }
});
