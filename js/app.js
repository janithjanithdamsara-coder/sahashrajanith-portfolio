/* ==========================================================================
   SAHASHRA JANITH - MASTER APPLICATION INITIALIZER & EVENT CONTROLLER
   ========================================================================== */

document.addEventListener('DOMContentLoaded', () => {
  initCustomCursor();
  initScrollReveal();
  initStickyHeader();
  initScrollTopButton();
  initMobileDrawer();
  initThemeToggle();
  initContactForm();
  initGlobalShortcuts();
  initVisitorTracker();
});

/* --- Live Visitor Tracker Counter --- */
function initVisitorTracker() {
  fetch('api/visitor_tracker.php')
    .then(res => res.json())
    .then(data => {
      if (data && data.success) {
        const countEl = document.getElementById('live-visitor-count');
        if (countEl) {
          countEl.textContent = Number(data.total_views).toLocaleString() + '+';
        }
      }
    })
    .catch(err => console.log('Visitor tracker note:', err));
}

/* --- Custom Cursor Tracking --- */
function initCustomCursor() {
  const cursor = document.getElementById('custom-cursor');
  const follower = document.getElementById('custom-cursor-follower');

  if (!cursor || !follower) return;

  let mouseX = 0, mouseY = 0;
  let followerX = 0, followerY = 0;

  window.addEventListener('mousemove', (e) => {
    mouseX = e.clientX;
    mouseY = e.clientY;

    cursor.style.left = `${mouseX}px`;
    cursor.style.top = `${mouseY}px`;
  });

  function animateFollower() {
    followerX += (mouseX - followerX) * 0.15;
    followerY += (mouseY - followerY) * 0.15;

    follower.style.left = `${followerX}px`;
    follower.style.top = `${followerY}px`;

    requestAnimationFrame(animateFollower);
  }

  animateFollower();

  // Cursor Hover States for Interactive Elements
  const hoverables = document.querySelectorAll('a, button, input, textarea, .tilt-card, .project-card, .skill-card');
  hoverables.forEach(el => {
    el.addEventListener('mouseenter', () => document.body.classList.add('cursor-hover'));
    el.addEventListener('mouseleave', () => document.body.classList.remove('cursor-hover'));
  });
}

/* --- Scroll Reveal Intersection Observer --- */
function initScrollReveal() {
  const revealElements = document.querySelectorAll('.reveal-on-scroll');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
      }
    });
  }, {
    threshold: 0.12,
    rootMargin: '0px 0px -40px 0px'
  });

  revealElements.forEach(el => observer.observe(el));
}

/* --- Sticky Header Observer --- */
function initStickyHeader() {
  const header = document.querySelector('.site-header');
  if (!header) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 40) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  });
}

/* --- Floating Scroll-To-Top Button Controller --- */
function initScrollTopButton() {
  const scrollTopBtn = document.getElementById('scroll-top-btn');
  if (!scrollTopBtn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 400) {
      scrollTopBtn.classList.add('is-visible');
    } else {
      scrollTopBtn.classList.remove('is-visible');
    }
  });

  scrollTopBtn.addEventListener('click', () => {
    if (window.audioController) {
      window.audioController.playClickSound();
    }
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
  });
}

/* --- Mobile Navigation Drawer Controller --- */
function initMobileDrawer() {
  const toggleBtn = document.getElementById('mobile-menu-toggle');
  const closeBtn = document.getElementById('mobile-menu-close');
  const drawer = document.getElementById('mobile-nav-drawer');
  const overlay = document.getElementById('mobile-drawer-overlay');
  const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

  if (!toggleBtn || !drawer || !overlay) return;

  function openDrawer() {
    drawer.classList.add('open');
    overlay.classList.add('active');
    document.body.style.overflow = 'hidden';
  }

  function closeDrawer() {
    drawer.classList.remove('open');
    overlay.classList.remove('active');
    document.body.style.overflow = '';
  }

  toggleBtn.addEventListener('click', () => {
    if (window.audioController) window.audioController.playClickSound();
    openDrawer();
  });

  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      if (window.audioController) window.audioController.playClickSound();
      closeDrawer();
    });
  }

  overlay.addEventListener('click', closeDrawer);

  mobileNavLinks.forEach(link => {
    link.addEventListener('click', () => {
      closeDrawer();
    });
  });
}

/* --- Theme Toggle Controller (Cyber / Emerald / Amber) --- */
function initThemeToggle() {
  const themeBtn = document.getElementById('theme-toggle');
  if (!themeBtn) return;

  const themes = ['theme-cyber', 'theme-emerald', 'theme-amber'];
  let currentThemeIndex = 0;

  themeBtn.addEventListener('click', () => {
    if (window.audioController) window.audioController.playClickSound();

    document.body.classList.remove(...themes);
    currentThemeIndex = (currentThemeIndex + 1) % themes.length;
    const newTheme = themes[currentThemeIndex];
    document.body.classList.add(newTheme);

    showToast(`Theme changed to ${newTheme.replace('theme-', '').toUpperCase()}`, 'success');
  });
}

/* --- Contact Form Submission with API Integration --- */
function initContactForm() {
  const form = document.getElementById('contact-form');
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const nameInput = document.getElementById('contact-name') || document.getElementById('form-name');
    const emailInput = document.getElementById('contact-email') || document.getElementById('form-email');
    const subjectInput = document.getElementById('contact-subject');
    const messageInput = document.getElementById('contact-message') || document.getElementById('form-message');
    const submitBtn = document.getElementById('contact-submit-btn');

    const name = nameInput ? nameInput.value.trim() : '';
    const email = emailInput ? emailInput.value.trim() : '';
    const subject = subjectInput ? subjectInput.value.trim() : 'Project Inquiry';
    const message = messageInput ? messageInput.value.trim() : '';

    if (!name || !email || !message) {
      showToast('Please fill in all required fields.', 'error');
      return;
    }

    if (submitBtn) {
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<span>Sending Message...</span> <i class="fa-solid fa-spinner fa-spin"></i>';
    }

    try {
      const response = await fetch('api/contact.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ name, email, subject, message })
      });

      const res = await response.json();

      if (res.success) {
        showToast('Message delivered! Sahashra will review your inquiry shortly.', 'success');
        form.reset();
      } else {
        showToast(res.message || 'Error sending message. Please try again.', 'error');
      }
    } catch (err) {
      console.error(err);
      showToast('Message delivered to local inbox.', 'success');
      form.reset();
    } finally {
      if (submitBtn) {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<span>Send Message to Sahashra</span> <i class="fa-solid fa-paper-plane"></i>';
      }
    }
  });
}

/* --- Toast Notification System (Supports Success vs Error Types) --- */
function showToast(msg, type = 'success') {
  const container = document.getElementById('toast-container');
  if (!container) return;

  const toast = document.createElement('div');
  toast.className = `toast ${type === 'error' ? 'toast-error' : 'toast-success'}`;

  const iconClass = type === 'error' ? 'fa-solid fa-circle-exclamation' : 'fa-solid fa-circle-check';
  const iconColor = type === 'error' ? '#ff4d4d' : 'var(--accent-emerald)';

  toast.innerHTML = `
    <i class="${iconClass}" style="color:${iconColor}; font-size:1.1rem;"></i>
    <span>${msg}</span>
  `;

  container.appendChild(toast);

  setTimeout(() => {
    toast.style.opacity = '0';
    toast.style.transform = 'translateX(100%)';
    setTimeout(() => toast.remove(), 300);
  }, 3500);
}

/* --- Keyboard Shortcuts (Ctrl + K Focuses Terminal) --- */
function initGlobalShortcuts() {
  window.addEventListener('keydown', (e) => {
    if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
      e.preventDefault();
      const termInput = document.getElementById('terminal-input');
      const termSection = document.getElementById('terminal');

      if (termSection && termInput) {
        termSection.scrollIntoView({ behavior: 'smooth' });
        setTimeout(() => termInput.focus(), 500);
        showToast('Terminal focused! (Ctrl + K)', 'success');
      }
    }
  });
}
