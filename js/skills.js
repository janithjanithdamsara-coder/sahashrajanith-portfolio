/* ==========================================================================
   TECH STACK CONSTELLATION & MATRIX (SAHASHRA JANITH SKILLS)
   ========================================================================== */

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
      { id: 'all', label: '⚡ All Skills' },
      { id: 'backend', label: '⚙️ Backend & Java/PHP' },
      { id: 'frontend', label: '🎨 Frontend & Web' },
      { id: '3d', label: '🔮 3D & Motion' },
      { id: 'tools', label: '🛠️ Mobile & Tools' }
    ];

    this.filterContainer.innerHTML = categories.map(cat => `
      <button class="filter-btn ${cat.id === 'all' ? 'active' : ''}" data-cat="${cat.id}">
        ${cat.label}
      </button>
    `).join('');

    this.filterContainer.querySelectorAll('.filter-btn').forEach(btn => {
      btn.addEventListener('click', (e) => {
        const cat = e.target.getAttribute('data-cat');
        this.filterContainer.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        e.target.classList.add('active');
        this.renderSkills(cat);
        if (window.soundFx) window.soundFx.playClickSound();
      });
    });
  }

  renderSkills(category) {
    const list = (window.portfolioData && window.portfolioData.skills && window.portfolioData.skills.length) ? window.portfolioData.skills : skillsData;
    const filtered = category === 'all' ? list : list.filter(s => s.category === category);

    this.container.innerHTML = filtered.map(skill => `
      <div class="skill-card">
        <div class="skill-header">
          <span class="skill-name">${skill.name}</span>
          <span class="skill-badge">${skill.badge}</span>
        </div>
        <div class="skill-bar-bg">
          <div class="skill-bar-fill" data-level="${skill.level}"></div>
        </div>
      </div>
    `).join('');

    setTimeout(() => {
      this.container.querySelectorAll('.skill-bar-fill').forEach(bar => {
        const level = bar.getAttribute('data-level');
        bar.style.width = `${level}%`;
      });
    }, 100);

    this.container.querySelectorAll('.skill-card').forEach(card => {
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
