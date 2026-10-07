/* ==========================================================================
   PROJECT VAULT & 3D PERSPECTIVE CARD CONTROLLER (SAHASHRA JANITH REAL PROJECTS)
   ========================================================================== */

const projectsData = [
  {
    id: 'zenith-academy',
    title: 'Zenith Academy LMS & Exam Portal',
    category: 'fullstack',
    desc: 'Comprehensive educational academy platform featuring online exam management, student portals, and digital course resources.',
    image: 'assets/images/project_ai_platform.jpg',
    tags: ['PHP', 'MySQL', 'JavaScript', 'LMS', 'Exam Engine'],
    demoUrl: 'https://exampro.site/',
    githubUrl: 'https://github.com/sahashrajanith',
    longDesc: 'Zenith Academy is a full-featured Learning Management & Online Examination System built to streamline tuition operations. Features timed online quizzes, student progress dashboards, automated grade calculation, and secure resource downloads.',
    features: [
      'Timed online examination & automated grading engine',
      'Student portal for lecture notes & video resource access',
      'Admin analytics dashboard for class attendance and scores',
      'Responsive dark-theme UI with secure PHP/MySQL backend'
    ]
  },
  {
    id: 'scholarpro',
    title: 'ScholarPro Academic Evaluation Portal',
    category: 'fullstack',
    desc: 'Advanced web platform designed for academic testing, online exams, student performance tracking, and resource distribution.',
    image: 'assets/images/project_creative_web.jpg',
    tags: ['PHP', 'MySQL', 'Glassmorphic UI', 'Web Portal'],
    demoUrl: 'https://scholarpro.exampro.site/',
    githubUrl: 'https://github.com/sahashrajanith',
    longDesc: 'ScholarPro empowers educational institutions with an online testing environment. Provides instant result generation, detailed subject-wise analytical reports, and interactive study modules.',
    features: [
      'Multi-tier student & teacher access control',
      'Instant exam feedback & question bank management',
      'High speed responsive interface built with modern CSS',
      'Secure MySQL database schema for student records'
    ]
  },
  {
    id: 'science-portal',
    title: 'Sahashra Janith Science Learning Portal',
    category: 'frontend',
    desc: 'Dedicated online science education website featuring digital lessons, interactive quiz modules, and study materials.',
    image: 'assets/images/project_dev_tools.jpg',
    tags: ['PHP', 'MySQL', 'HTML5/CSS3', 'Educational Web'],
    demoUrl: 'https://science.sahashrajanith.site/',
    githubUrl: 'https://github.com/sahashrajanith',
    longDesc: 'A specialized web portal tailored for science students. Includes categorized subject modules, interactive lesson quizzes, downloadable revision papers, and direct student inquiry channels.',
    features: [
      'Categorized science curriculum modules',
      'Interactive self-assessment quizzes with live scoring',
      'Mobile-optimized glassmorphism UI design system',
      'Direct teacher-student message integration'
    ]
  },
  {
    id: 'bloomy-haven',
    title: 'Bloomy Haven E-Commerce Store',
    category: 'ecom',
    desc: 'Full-featured online store with product catalogs, shopping cart engine, responsive product showcase, and checkout system.',
    image: 'assets/images/project_3d_ecom.jpg',
    tags: ['PHP', 'MySQL', 'E-Commerce', 'Cart API', 'Fullstack'],
    demoUrl: 'https://bloomyhaven.store/',
    githubUrl: 'https://github.com/sahashrajanith',
    longDesc: 'Bloomy Haven is an e-commerce platform built for online shopping. Delivers fluid product filtering, dynamic cart drawer management, category browsing, and order confirmation workflows.',
    features: [
      'Dynamic product filtering & category navigation',
      'Real-time shopping cart session management',
      'Responsive modern shop layout with smooth transitions',
      'Order processing & inventory tracking database'
    ]
  },
  {
    id: 'sahashra-site',
    title: 'Sahashra Janith Custom Web Platform',
    category: 'frontend',
    desc: 'Official web domain platform hosting live web applications, digital client services, and modern software solutions.',
    image: 'assets/images/project_creative_web.jpg',
    tags: ['Web Platform', 'PHP', 'HTML5/CSS3', 'JavaScript'],
    demoUrl: 'https://sahashrajanith.site/',
    githubUrl: 'https://github.com/sahashrajanith',
    longDesc: 'Personal web domain platform serving as the primary hub for Sahashra Janith’s live web applications, client solutions, and software deployments.',
    features: [
      'Unified hub for live web projects & services',
      'Sleek modern visual layout with high performance',
      'SEO-optimized semantic HTML architecture',
      'SSL-encrypted cloud hosting deployment'
    ]
  },
  {
    id: 'al-class-mgmt',
    title: 'AL Class Management System',
    category: 'fullstack',
    desc: 'Student and class management web portal built for A/L tuition institutes to handle enrollments, fees, and attendance.',
    image: 'assets/images/project_dev_tools.jpg',
    tags: ['PHP', 'MySQL', 'Management System', 'Fullstack'],
    demoUrl: 'https://futuremindssite.site',
    githubUrl: 'https://github.com/AL-Class-manegement-System/AL-Class-Management-System.git',
    longDesc: 'Hosted online tuition class management system designed for managing student profiles, class schedules, fee payments, and attendance records efficiently.',
    features: [
      'Student profile & enrollment tracking database',
      'Class fee payment status & receipt generation',
      'Hosted online live demo at futuremindssite.site',
      'Open source repository on GitHub'
    ]
  },
  {
    id: 'future-mind-app',
    title: 'Future Mind Android Mobile App',
    category: 'mobile',
    desc: 'Mobile Android application built for A/L class management, student announcements, and mobile schedule access.',
    image: 'assets/images/project_ai_platform.jpg',
    tags: ['Android', 'Java', 'Mobile App', 'XML', 'API'],
    demoUrl: 'https://github.com/sahashrajanith/future-mind-app.git',
    githubUrl: 'https://github.com/sahashrajanith/future-mind-app.git',
    longDesc: 'Native Android mobile application built with Java enabling students and tuition administrators to access class schedules, receive real-time notifications, and track course updates on mobile devices.',
    features: [
      'Native Android UI built with Java & XML',
      'Real-time class schedule & announcement updates',
      'Student notification system & user authentication',
      'Available on GitHub repository'
    ]
  }
];

class ProjectVault {
  constructor() {
    this.container = document.getElementById('projects-grid');
    this.modalOverlay = document.getElementById('project-modal');
    this.modalCard = document.getElementById('modal-content-area');
    this.modalCloseBtn = document.getElementById('modal-close');

    this.init();
  }

  init() {
    if (!this.container) return;
    this.data = (window.portfolioData && window.portfolioData.projects && window.portfolioData.projects.length) ? window.portfolioData.projects : projectsData;
    
    // Fetch live portfolio.json data asynchronously
    fetch('api/get_data.php')
      .then(res => res.json())
      .then(liveData => {
        if (liveData && Array.isArray(liveData.projects) && liveData.projects.length > 0) {
          this.data = liveData.projects;
          this.renderProjects(this.data);
        }
      })
      .catch(() => {});

    this.renderProjects(this.data);
    this.initFilters();
    this.initModalEvents();
  }

  initFilters() {
    const buttons = document.querySelectorAll('.project-filter-btn');
    buttons.forEach(btn => {
      btn.addEventListener('click', (e) => {
        buttons.forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        const cat = e.target.getAttribute('data-filter');
        const filtered = cat === 'all' ? this.data : this.data.filter(p => p.category === cat);
        this.renderProjects(filtered);
        if (window.soundFx) window.soundFx.playClickSound();
      });
    });
  }

  renderProjects(items) {
    this.container.innerHTML = items.map(p => {
      const img = p.image || 'assets/images/project_creative_web.jpg';
      const tags = Array.isArray(p.tags) ? p.tags : (typeof p.tags === 'string' ? p.tags.split(',') : ['Fullstack']);
      return `
        <div class="project-card tilt-card" data-id="${p.id}">
          <div class="project-img-wrapper">
            <img src="${img}" alt="${p.title}" class="project-img" loading="lazy" />
            <div class="project-overlay"></div>
          </div>
          <div class="project-body">
            <h3 class="project-title">${p.title}</h3>
            <p class="project-desc">${p.desc || ''}</p>
            <div class="project-tags">
              ${tags.map(t => `<span class="tag">${t.trim()}</span>`).join('')}
            </div>
            <div class="project-footer">
              <button class="link-btn open-details-btn" data-id="${p.id}">
                <span>View Deep Dive</span>
                <i data-lucide="arrow-right"></i>
              </button>
            </div>
          </div>
        </div>
      `;
    }).join('');

    if (window.lucide) lucide.createIcons();
    this.applyTiltEffect();
    this.bindDetailButtons();
  }

  applyTiltEffect() {
    const cards = this.container.querySelectorAll('.tilt-card');
    cards.forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;

        const centerX = rect.width / 2;
        const centerY = rect.height / 2;

        const rotateX = ((y - centerY) / centerY) * -8;
        const rotateY = ((x - centerX) / centerX) * 8;

        card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
        card.style.setProperty('--mouse-x', `${(x / rect.width) * 100}%`);
        card.style.setProperty('--mouse-y', `${(y / rect.height) * 100}%`);
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
      });

      card.addEventListener('mouseenter', () => {
        if (window.soundFx) window.soundFx.playHoverSound();
      });
    });
  }

  bindDetailButtons() {
    this.container.querySelectorAll('.open-details-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const project = (this.data && this.data.find(p => p.id === id)) || projectsData.find(p => p.id === id);
        if (project) this.openModal(project);
      });
    });
  }

  openModal(p) {
    if (!this.modalOverlay || !this.modalCard) return;

    const img = p.image || 'assets/images/project_creative_web.jpg';
    const longDesc = p.longDesc || p.desc || 'Comprehensive web application developed by Sahashra Janith.';
    const features = Array.isArray(p.features) && p.features.length ? p.features : [
      'High performance backend & responsive design system',
      'Optimized database schema and secure data structures',
      'Deployed on secure server infrastructure'
    ];
    const tags = Array.isArray(p.tags) ? p.tags : (typeof p.tags === 'string' ? p.tags.split(',') : ['Fullstack']);

    this.modalCard.innerHTML = `
      <div style="position:relative; width:100%; height:300px; overflow:hidden; border-radius:16px 16px 0 0;">
        <img src="${img}" alt="${p.title}" style="width:100%; height:100%; object-fit:cover;" />
        <div style="position:absolute; inset:0; background:linear-gradient(to top, #12161f 0%, transparent 80%);"></div>
      </div>
      <div style="padding: 32px;">
        <span style="font-family:var(--font-mono); color:var(--accent-cyan); font-size:0.85rem;">SAHASHRA JANITH PROJECT CASE STUDY</span>
        <h2 style="font-family:var(--font-display); font-size:1.8rem; margin:8px 0 16px 0;">${p.title}</h2>
        <p style="color:var(--text-muted); font-size:1.05rem; line-height:1.7; margin-bottom:24px;">${longDesc}</p>

        <h4 style="font-family:var(--font-display); font-size:1.1rem; margin-bottom:12px;">Key Architectural Highlights:</h4>
        <ul style="list-style:none; display:flex; flex-direction:column; gap:10px; margin-bottom:32px;">
          ${features.map(f => `
            <li style="display:flex; align-items:center; gap:10px; color:var(--text-main);">
              <span style="color:var(--accent-cyan);">✦</span> ${f}
            </li>
          `).join('')}
        </ul>

        <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:32px;">
          ${tags.map(t => `<span class="tag" style="padding:6px 14px; font-size:0.85rem;">${t.trim()}</span>`).join('')}
        </div>

        <div style="display:flex; gap:16px; align-items:center; flex-wrap:wrap;">
          ${p.demoUrl ? `
            <a href="${p.demoUrl}" target="_blank" class="btn-primary" style="padding:12px 24px; font-size:0.95rem;">
              <span>Visit Live Platform</span>
              <i data-lucide="external-link"></i>
            </a>
          ` : ''}
        </div>
      </div>
    `;

    if (window.lucide) lucide.createIcons();
    this.modalOverlay.classList.add('active');
    if (window.soundFx) window.soundFx.playClickSound();
  }

  initModalEvents() {
    if (this.modalCloseBtn) {
      this.modalCloseBtn.addEventListener('click', () => {
        this.closeModal();
      });
    }

    if (this.modalOverlay) {
      this.modalOverlay.addEventListener('click', (e) => {
        if (e.target === this.modalOverlay) {
          this.closeModal();
        }
      });
    }

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && this.modalOverlay.classList.contains('active')) {
        this.closeModal();
      }
    });
  }

  closeModal() {
    if (this.modalOverlay) {
      this.modalOverlay.classList.remove('active');
      if (window.soundFx) window.soundFx.playClickSound();
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  window.projectVault = new ProjectVault();
});
