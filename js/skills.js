/* ==========================================================================
   TECH STACK CONSTELLATION & MATRIX (SAHASHRA JANITH SKILLS)
   ========================================================================== */

const skillMeta = {
  'PHP & Server Architecture': {
    icon: 'fa-brands fa-php',
    color: '#787cb5',
    glow: 'rgba(120, 124, 181, 0.45)',
    tag: 'OOP, REST APIs & Backend Architecture'
  },
  'MySQL & Database Design': {
    icon: 'fa-solid fa-database',
    color: '#00758f',
    glow: 'rgba(0, 117, 143, 0.45)',
    tag: 'Relational Schemas, Indexing & ACID'
  },
  'Java (Desktop & Android)': {
    icon: 'fa-brands fa-java',
    color: '#f89820',
    glow: 'rgba(248, 152, 32, 0.45)',
    tag: 'Object-Oriented Desktop & Android SDK'
  },
  'JavaScript (ES6+)': {
    icon: 'fa-brands fa-js',
    color: '#f7df1e',
    glow: 'rgba(247, 223, 30, 0.45)',
    tag: 'Modern ES6+, Async/Await & DOM Engines'
  },
  'HTML5 & Responsive CSS3': {
    icon: 'fa-brands fa-html5',
    color: '#e34f26',
    glow: 'rgba(227, 79, 38, 0.45)',
    tag: 'Semantic, Mobile-First & Animations'
  },
  'Glassmorphic UI Design': {
    icon: 'fa-solid fa-wand-magic-sparkles',
    color: '#00f2fe',
    glow: 'rgba(0, 242, 254, 0.45)',
    tag: 'Cyberpunk Glass & Micro-Interactions'
  },
  'Three.js & 3D WebGL': {
    icon: 'fa-solid fa-cubes',
    color: '#a855f7',
    glow: 'rgba(168, 85, 247, 0.45)',
    tag: 'Interactive 3D Canvas & Shaders'
  },
  'Android App Development': {
    icon: 'fa-brands fa-android',
    color: '#3ddc84',
    glow: 'rgba(61, 220, 132, 0.45)',
    tag: 'Native Java, XML Layouts & REST Sync'
  },
  'Fullstack E-Commerce Engine': {
    icon: 'fa-solid fa-cart-shopping',
    color: '#38bdf8',
    glow: 'rgba(56, 189, 248, 0.45)',
    tag: 'Cart Architecture, Checkout & Inventory'
  },
  'Git & GitHub Repositories': {
    icon: 'fa-brands fa-github',
    color: '#f05032',
    glow: 'rgba(240, 80, 50, 0.45)',
    tag: 'Branching, Pull Requests & CI/CD'
  },
  'NVQ 4 & ICT Diploma Stack': {
    icon: 'fa-solid fa-award',
    color: '#fbbf24',
    glow: 'rgba(251, 191, 36, 0.45)',
    tag: 'Accredited National Qualifications'
  }
};

const defaultSkillMeta = {
  icon: 'fa-solid fa-code',
  color: '#00f2fe',
  glow: 'rgba(0, 242, 254, 0.35)',
  tag: 'Fullstack Core'
};

const skillsData = [
  { name: 'PHP & Server Architecture', level: 95, category: 'backend', badge: 'Expert' },
  { name: 'MySQL & Database Design', level: 92, category: 'backend', badge: 'Advanced' },
  { name: 'Java (Desktop & Android)', level: 90, category: 'backend', badge: 'Advanced' },
  { name: 'JavaScript (ES6+)', level: 94, category: 'frontend', badge: 'Expert' },
  { name: 'HTML5 & Responsive CSS3', level: 98, category: 'frontend', badge: 'Master' },
  { name: 'Glassmorphic UI Design', level: 95, category: 'frontend', badge: 'Expert' },
  { name: 'Three.js & 3D WebGL', level: 88, category: '3d', badge: 'Advanced' },
  { name: 'Android App Development', level: 86, category: 'tools', badge: 'Advanced' },
  { name: 'Fullstack E-Commerce Engine', level: 92, category: 'backend', badge: 'Expert' },
  { name: 'Git & GitHub Repositories', level: 94, category: 'tools', badge: 'Expert' },
  { name: 'NVQ 4 & ICT Diploma Stack', level: 96, category: 'tools', badge: 'Certified' }
];

class SkillsMatrix {
  constructor() {
    this.container = document.getElementById('skills-grid');
    this.filterContainer = document.getElementById('skills-filter');
    this.currentCategory = 'all';

    this.init();
  }

  init() {
    if (!this.container) return;
    this.renderFilters();
    this.renderSkills('all');
    this.initIntersectionObserver();
  }

  renderFilters() {
    if (!this.filterContainer) return;
    const categories = [
      { id: 'all', label: 'All Tech Stack', icon: 'fa-solid fa-bolt' },
      { id: 'backend', label: 'Backend & Core', icon: 'fa-solid fa-server' },
      { id: 'frontend', label: 'Frontend & UI', icon: 'fa-solid fa-code' },
      { id: '3d', label: '3D & Motion', icon: 'fa-solid fa-cubes' },
      { id: 'tools', label: 'Mobile & Tools', icon: 'fa-solid fa-mobile-screen-button' }
    ];

    this.filterContainer.innerHTML = categories.map(cat => `
      <button class="filter-btn ${cat.id === 'all' ? 'active' : ''}" data-cat="${cat.id}">
        <i class="${cat.icon}" style="margin-right:6px;"></i>
        <span>${cat.label}</span>
      </button>
    `).join('');

    this.filterContainer.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const button = e.currentTarget;
        const cat = button.getAttribute('data-cat');
        this.filterContainer.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        button.classList.add('active');
        this.renderSkills(cat);
        if (window.soundFx) window.soundFx.playClickSound();
      });
    });
  }

  renderSkills(category) {
    const list = (window.portfolioData && window.portfolioData.skills && window.portfolioData.skills.length) ? window.portfolioData.skills : skillsData;
    const filtered = category === 'all' ? list : list.filter(s => s.category === category);

    this.container.innerHTML = filtered.map(skill => {
      const meta = skillMeta[skill.name] || defaultSkillMeta;
      return `
        <div class="skill-card tilt-card" style="--skill-color:${meta.color}; --skill-glow:${meta.glow};">
          <div class="skill-card-inner">
            <div class="skill-icon-box" style="color:${meta.color}; border-color:${meta.color}40; background:${meta.color}15; box-shadow:0 0 16px ${meta.glow};">
              <i class="${meta.icon}"></i>
            </div>
            <div class="skill-content-block">
              <div class="skill-header">
                <span class="skill-name" title="${skill.name}">${skill.name}</span>
                <span class="skill-badge" style="color:${meta.color}; border-color:${meta.color}55; background:${meta.color}15;">${skill.badge}</span>
              </div>
              <div class="skill-sub-row">
                <span class="skill-tag-hint">${meta.tag}</span>
                <span class="skill-pct-label" style="color:${meta.color};">${skill.level}%</span>
              </div>
            </div>
          </div>
          <div class="skill-bar-bg">
            <div class="skill-bar-fill" data-level="${skill.level}" style="background:linear-gradient(90deg, ${meta.color}, var(--accent-cyan)); box-shadow:0 0 10px ${meta.glow};"></div>
          </div>
        </div>
      `;
    }).join('');

    setTimeout(() => {
      this.container.querySelectorAll('.skill-bar-fill').forEach(bar => {
        const level = bar.getAttribute('data-level');
        bar.style.width = `${level}%`;
      });
    }, 80);

    this.applyTiltEffect();
  }

  applyTiltEffect() {
    this.container.querySelectorAll('.skill-card').forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -6;
        const rotateY = ((x - centerX) / centerX) * 6;
        card.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-4px)`;
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) translateY(0)';
      });

      card.addEventListener('mouseenter', () => {
        if (window.soundFx) window.soundFx.playHoverSound();
      });
    });
  }

  initIntersectionObserver() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.querySelectorAll('.skill-bar-fill').forEach(bar => {
            const level = bar.getAttribute('data-level');
            bar.style.width = `${level}%`;
          });
        }
      });
    }, { threshold: 0.2 });

    if (this.container) observer.observe(this.container);
  }
}

document.addEventListener('DOMContentLoaded', () => {
  window.skillsMatrix = new SkillsMatrix();
});
