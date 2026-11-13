/**
 * landing/assets/home.js
 * Module selector, one-time sample counters and a scrolled-in reveal.
 *
 * Everything here is an enhancement: nothing is hidden by CSS before this
 * file runs, so the page reads completely without JavaScript.
 */
(function () {
  'use strict';

  var prefersReducedMotion = window.matchMedia
    ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
    : false;

  /* ── Module selector ─────────────────────────────────────────────────── */
  var tabs = Array.prototype.slice.call(document.querySelectorAll('[data-module-tab]'));
  var panels = Array.prototype.slice.call(document.querySelectorAll('[data-module-panel]'));

  function selectTab(tab) {
    var name = tab.getAttribute('data-module-tab');

    tabs.forEach(function (item) {
      var selected = item === tab;
      item.setAttribute('aria-selected', selected ? 'true' : 'false');
      item.tabIndex = selected ? 0 : -1;
    });

    panels.forEach(function (panel) {
      var selected = panel.getAttribute('data-module-panel') === name;
      panel.classList.toggle('is-active', selected);
      if (selected) {
        panel.removeAttribute('hidden');
      } else {
        panel.setAttribute('hidden', '');
      }
    });

    startCounters(document.getElementById(tab.getAttribute('aria-controls')));
  }

  tabs.forEach(function (tab) {
    tab.addEventListener('click', function () {
      selectTab(tab);
    });

    tab.addEventListener('keydown', function (event) {
      var index = tabs.indexOf(tab);
      var next = null;

      if (event.key === 'ArrowRight') {
        next = tabs[(index + 1) % tabs.length];
      } else if (event.key === 'ArrowLeft') {
        next = tabs[(index - 1 + tabs.length) % tabs.length];
      } else if (event.key === 'Home') {
        next = tabs[0];
      } else if (event.key === 'End') {
        next = tabs[tabs.length - 1];
      }

      if (next) {
        event.preventDefault();
        next.focus();
        selectTab(next);
      }
    });
  });

  /* ── Sample counters ────────────────────────────────────────────────── */
  /* Each value is already in the markup; this animates to it once, so a
     screenshot, print or failed script still shows the real figure. */
  function startCounters(scope) {
    if (!scope) {
      return;
    }

    Array.prototype.forEach.call(scope.querySelectorAll('[data-count]'), function (node) {
      if (node.getAttribute('data-counted') === 'true') {
        return;
      }
      node.setAttribute('data-counted', 'true');

      var target = parseInt(node.getAttribute('data-count'), 10) || 0;

      if (prefersReducedMotion) {
        node.textContent = String(target);
        return;
      }

      var startedAt = null;
      var duration = 620;

      node.textContent = '0';

      function step(timestamp) {
        if (startedAt === null) {
          startedAt = timestamp;
        }
        var progress = Math.min((timestamp - startedAt) / duration, 1);
        var eased = 1 - Math.pow(1 - progress, 3);
        node.textContent = String(Math.round(target * eased));

        if (progress < 1) {
          window.requestAnimationFrame(step);
        } else {
          node.textContent = String(target);
        }
      }

      window.requestAnimationFrame(step);
    });
  }

  /* ── Reveal on first view ───────────────────────────────────────────── */
  var revealables = Array.prototype.slice.call(document.querySelectorAll('[data-reveal]'));

  if (revealables.length && 'IntersectionObserver' in window && !prefersReducedMotion) {
    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) {
            return;
          }
          entry.target.classList.add('is-revealing');
          observer.unobserve(entry.target);
        });
      },
      { rootMargin: '0px 0px -4% 0px', threshold: 0.04 }
    );

    revealables.forEach(function (element) {
      if (element.getBoundingClientRect().top > window.innerHeight) {
        observer.observe(element);
      }
    });
  }

  startCounters(document.getElementById('panel-reports'));
})();
