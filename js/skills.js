/* ==========================================================================
   TECH STACK CONSTELLATION & MATRIX (SAHASHRA JANITH SKILLS)
   ========================================================================== */

const skillDetails = {
  'PHP & Server Architecture': {
    title: 'PHP & Backend',
    role: 'Server APIs, MVC & Security',
    badge: 'Expert',
    gradient: 'linear-gradient(135deg, #787cb5 0%, #4f5b93 100%)',
    glow: 'rgba(120, 124, 181, 0.45)',
    icon: 'fa-brands fa-php'
  },
  'MySQL & Database Design': {
    title: 'MySQL Database',
    role: 'Schemas, Indexing & Queries',
    badge: 'Advanced',
    gradient: 'linear-gradient(135deg, #00758f 0%, #00a4bd 100%)',
    glow: 'rgba(0, 164, 189, 0.45)',
    icon: 'fa-solid fa-database'
  },
  'Java (Desktop & Android)': {
    title: 'Java Systems',
    role: 'Desktop & Core OOP Software',
    badge: 'Advanced',
    gradient: 'linear-gradient(135deg, #f89820 0%, #e76f00 100%)',
    glow: 'rgba(248, 152, 32, 0.45)',
    icon: 'fa-brands fa-java'
  },
  'JavaScript (ES6+)': {
    title: 'JavaScript (ES6+)',
    role: 'Modern Async, DOM & Logic',
    badge: 'Expert',
    gradient: 'linear-gradient(135deg, #f7df1e 0%, #e5a900 100%)',
    glow: 'rgba(247, 223, 30, 0.45)',
    icon: 'fa-brands fa-js'
  },
  'HTML5 & Responsive CSS3': {
    title: 'HTML5 & CSS3',
    role: 'Responsive Flexbox & Grid',
    badge: 'Master',
    gradient: 'linear-gradient(135deg, #e34f26 0%, #f06529 100%)',
    glow: 'rgba(227, 79, 38, 0.45)',
    icon: 'fa-brands fa-html5'
  },
  'Glassmorphic UI Design': {
    title: 'Glassmorphic UI',
    role: 'Cyberpunk & Modern Micro-UX',
    badge: 'Creative',
    gradient: 'linear-gradient(135deg, #00f2fe 0%, #4facfe 100%)',
    glow: 'rgba(0, 242, 254, 0.45)',
    icon: 'fa-solid fa-wand-magic-sparkles'
  },
  'Three.js & 3D WebGL': {
    title: 'Three.js & 3D',
    role: 'Canvas WebGL & 3D Worlds',
    badge: 'Advanced',
    gradient: 'linear-gradient(135deg, #a855f7 0%, #6366f1 100%)',
    glow: 'rgba(168, 85, 247, 0.45)',
    icon: 'fa-solid fa-cubes'
  },
  'Android App Development': {
    title: 'Android Native',
    role: 'Java SDK & Mobile Apps',
    badge: 'Advanced',
    gradient: 'linear-gradient(135deg, #3ddc84 0%, #10b981 100%)',
    glow: 'rgba(61, 220, 132, 0.45)',
    icon: 'fa-brands fa-android'
  },
  'Fullstack E-Commerce Engine': {
    title: 'E-Commerce Engines',
    role: 'Cart, Checkout & Inventory',
    badge: 'Fullstack',
    gradient: 'linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%)',
    glow: 'rgba(56, 189, 248, 0.45)',
    icon: 'fa-solid fa-cart-shopping'
  },
  'Git & GitHub Repositories': {
    title: 'Git & GitHub',
    role: 'Version Control & Workflows',
    badge: 'Expert',
    gradient: 'linear-gradient(135deg, #f05032 0%, #c7381d 100%)',
    glow: 'rgba(240, 80, 50, 0.45)',
    icon: 'fa-brands fa-github'
  },
  'NVQ 4 & ICT Diploma Stack': {
    title: 'NVQ 4 & ICT Diploma',
    role: 'National Certified Standard',
    badge: 'Certified',
    gradient: 'linear-gradient(135deg, #fbbf24 0%, #d97706 100%)',
    glow: 'rgba(251, 191, 36, 0.45)',
    icon: 'fa-solid fa-award'
  }
};

const defaultSkill = {
  title: 'Fullstack Core',
  role: 'Software Development',
  badge: 'Specialist',
  gradient: 'linear-gradient(135deg, #00f2fe 0%, #4facfe 100%)',
  glow: 'rgba(0, 242, 254, 0.45)',
  icon: 'fa-solid fa-code'
};

const skillsData = [
  { name: 'PHP & Server Architecture', category: 'backend' },
  { name: 'MySQL & Database Design', category: 'backend' },
  { name: 'Java (Desktop & Android)', category: 'backend' },
  { name: 'JavaScript (ES6+)', category: 'frontend' },
  { name: 'HTML5 & Responsive CSS3', category: 'frontend' },
  { name: 'Glassmorphic UI Design', category: 'frontend' },
  { name: 'Three.js & 3D WebGL', category: '3d' },
  { name: 'Android App Development', category: 'tools' },
  { name: 'Fullstack E-Commerce Engine', category: 'backend' },
  { name: 'Git & GitHub Repositories', category: 'tools' },
  { name: 'NVQ 4 & ICT Diploma Stack', category: 'tools' }
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
      const meta = skillDetails[skill.name] || defaultSkill;
      return `
        <div class="tech-pill-card tilt-card" style="--card-grad:${meta.gradient}; --card-glow:${meta.glow};">
          <div class="tech-card-glow" style="background:${meta.gradient};"></div>
          
          <div class="tech-card-top">
            <div class="tech-icon-circle" style="background:${meta.gradient}; box-shadow:0 8px 20px ${meta.glow};">
              <i class="${meta.icon}"></i>
            </div>
            <span class="tech-badge" style="border-color:${meta.glow}; color:#ffffff; background:rgba(255,255,255,0.06);">
              ${skill.badge || meta.badge}
            </span>
          </div>

          <div class="tech-card-info">
            <h3 class="tech-name">${meta.title}</h3>
            <p class="tech-role">${meta.role}</p>
          </div>

          <div class="tech-card-accent" style="background:${meta.gradient};"></div>
        </div>
      `;
    }).join('');

    this.applyTiltEffect();
  }

  applyTiltEffect() {
    this.container.querySelectorAll('.tech-pill-card').forEach(card => {
      card.addEventListener('mousemove', (e) => {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const centerX = rect.width / 2;
        const centerY = rect.height / 2;
        const rotateX = ((y - centerY) / centerY) * -6;
        const rotateY = ((x - centerX) / centerX) * 6;
        card.style.transform = `perspective(800px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) translateY(-5px)`;
      });

      card.addEventListener('mouseleave', () => {
        card.style.transform = 'perspective(800px) rotateX(0deg) rotateY(0deg) translateY(0)';
      });

      card.addEventListener('mouseenter', () => {
        if (window.soundFx) window.soundFx.playHoverSound();
      });
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  window.skillsMatrix = new SkillsMatrix();
});
