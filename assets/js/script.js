document.addEventListener("DOMContentLoaded", function () {
  const slides = document.querySelectorAll('.slide');
  const prevBtn = document.querySelector('.prev');
  const nextBtn = document.querySelector('.next');

  let currentIndex = 0;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.classList.remove('active');
      if (i === index) {
        slide.classList.add('active');
      }
    });
  }

  prevBtn?.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + slides.length) % slides.length;
    showSlide(currentIndex);
  });

  nextBtn?.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % slides.length;
    showSlide(currentIndex);
  });

  // Menu burger
  const burger = document.querySelector('.burger');
  const navLinks = document.querySelector('.nav-links');
  const closeBtn = document.querySelector('.close-btn');

  burger?.addEventListener('click', () => {
    navLinks.classList.add('open');
  });

  closeBtn?.addEventListener('click', () => {
    navLinks.classList.remove('open');
  });
});
