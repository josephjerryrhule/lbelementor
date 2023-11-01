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
