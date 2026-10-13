/* Allianz & Co – Main JS
   Pure vanilla, no dependencies. */
(function () {
  'use strict';

  // --- Mobile menu toggle ---
  function initMobileMenu() {
    const burger = document.querySelector('.al-burger');
    const menu   = document.querySelector('.al-mobile-menu');
    if (!burger || !menu) return;
    burger.addEventListener('click', function () {
      const open = menu.classList.toggle('is-open');
      burger.setAttribute('aria-expanded', open ? 'true' : 'false');
      document.body.style.overflow = open ? 'hidden' : '';
    });
    // Close on link click
    menu.querySelectorAll('a').forEach(function (a) {
      a.addEventListener('click', function () {
        menu.classList.remove('is-open');
        burger.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      });
    });
  }

  // --- FAQ accordion ---
  function initFaq() {
    document.querySelectorAll('.al-faq__item').forEach(function (item) {
      const q = item.querySelector('.al-faq__q');
      if (!q) return;
      q.addEventListener('click', function () {
        // Optional: close other open ones (single-open mode). Comment out for multi-open.
        const wasOpen = item.classList.contains('is-open');
        item.parentElement.querySelectorAll('.al-faq__item.is-open').forEach(function (o) {
          o.classList.remove('is-open');
          o.querySelector('.al-faq__q')?.setAttribute('aria-expanded', 'false');
        });
        if (!wasOpen) {
          item.classList.add('is-open');
          q.setAttribute('aria-expanded', 'true');
        }
      });
    });
  }

  // --- Header scroll state ---
  function initHeaderScroll() {
    const header = document.querySelector('.al-header');
    if (!header) return;
    const onScroll = function () {
      if (window.scrollY > 50) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }

  // --- Reveal on scroll ---
  function initReveal() {
    if (!('IntersectionObserver' in window)) {
      document.querySelectorAll('.al-reveal').forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }
    const io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-visible');
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.al-reveal').forEach(function (el) { io.observe(el); });
  }

  // --- Animated counters ---
  function animateCount(el) {
    const target = parseInt(el.getAttribute('data-count') || '0', 10);
    const duration = 1600;
    const start = performance.now();
    function tick(now) {
      const t = Math.min((now - start) / duration, 1);
      const eased = 1 - Math.pow(1 - t, 3);
      el.textContent = Math.floor(eased * target).toLocaleString();
      if (t < 1) requestAnimationFrame(tick);
      else el.textContent = target.toLocaleString();
    }
    requestAnimationFrame(tick);
  }
  function initCounters() {
    if (!('IntersectionObserver' in window)) return;
    const io = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          animateCount(entry.target);
          io.unobserve(entry.target);
        }
      });
    }, { threshold: 0.4 });
    document.querySelectorAll('.al-counter__num[data-count]').forEach(function (el) { io.observe(el); });
  }

  // --- Smooth scroll for hash links ---
  function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]:not([href="#"])').forEach(function (a) {
      a.addEventListener('click', function (e) {
        const id = a.getAttribute('href');
        const target = id ? document.querySelector(id) : null;
        if (target) {
          e.preventDefault();
          const top = target.getBoundingClientRect().top + window.pageYOffset - 80;
          window.scrollTo({ top: top, behavior: 'smooth' });
        }
      });
    });
  }

  // --- Header height CSS var ---
  function setHeaderHeight() {
    const h = document.querySelector('.al-header');
    if (h) {
      document.documentElement.style.setProperty('--al-header-h', h.offsetHeight + 'px');
    }
  }

  // --- Init ---
  document.addEventListener('DOMContentLoaded', function () {
    initMobileMenu();
    initFaq();
    initHeaderScroll();
    initReveal();
    initCounters();
    initSmoothScroll();
    setHeaderHeight();
  });
  window.addEventListener('resize', setHeaderHeight);
  window.addEventListener('load', setHeaderHeight);
})();
