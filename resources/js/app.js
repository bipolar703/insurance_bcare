import './bootstrap';
import Alpine from 'alpinejs';

// Import CSS
import '../css/app.css';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Import all assets
import.meta.glob([
    '../style_files/frontend/img/**',
    '../style_files/frontend/fonts/**',
    '../style_files/frontend/js/**',
    '../style_files/frontend/css/**',
]);

// Import jQuery
import $ from 'jquery';
import 'slick-carousel';

window.$ = window.jQuery = $;

// Import Slick Slider
import 'slick-carousel/slick/slick.css';
import 'slick-carousel/slick/slick-theme.css';

// Initialize your sliders and other components
$(document).ready(function() {
    // Initialize slick slider
    $('.heroSlider').slick({
        rtl: true,
        dots: true,
        infinite: true,
        speed: 500,
        fade: true,
        cssEase: 'linear',
        autoplay: true,
        autoplaySpeed: 3000,
    });
});

// Add cursor effect (desktop only)
if (window.innerWidth > 768) {
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    document.body.appendChild(cursor);

    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    });

    // Add hover effect for interactive elements
    const interactiveElements = document.querySelectorAll('a, button, .btn');
    interactiveElements.forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.classList.add('cursor-hover');
        });
        el.addEventListener('mouseleave', () => {
            cursor.classList.remove('cursor-hover');
        });
    });
}

// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Add form enhancement
document.querySelectorAll('.inputGroup input, .inputGroup select').forEach(input => {
  // Add placeholder support for floating labels
  input.setAttribute('placeholder', ' ');

  // Add focus animations
  input.addEventListener('focus', () => {
    input.parentElement.classList.add('focused');
  });

  input.addEventListener('blur', () => {
    input.parentElement.classList.remove('focused');
  });
});

// Add loading state handler
function showLoading(form) {
  form.classList.add('form-loading');
  const spinner = document.createElement('div');
  spinner.classList.add('loading-spinner');
  form.appendChild(spinner);
}

function hideLoading(form) {
  form.classList.remove('form-loading');
  const spinner = form.querySelector('.loading-spinner');
  if (spinner) spinner.remove();
}
