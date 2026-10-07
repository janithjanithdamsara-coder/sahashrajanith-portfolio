<?php
$dataFile = __DIR__ . '/data/portfolio.json';
$portfolio = [
    'hero' => [],
    'skills' => [],
    'projects' => [],
    'messages' => []
];

if (file_exists($dataFile)) {
    $json = file_get_contents($dataFile);
    $decoded = json_decode($json, true);
    if (is_array($decoded)) {
        $portfolio = array_merge($portfolio, $decoded);
    }
}

$hero = $portfolio['hero'];
$skills = $portfolio['skills'];
$projects = $portfolio['projects'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?> | <?php echo htmlspecialchars($hero['title'] ?? 'Full-Stack & 3D Web Developer'); ?></title>
  <meta name="description" content="Portfolio of Sahashra Janith - Full-Stack Web Developer & Software Engineer (NVQ Level 4 & Diploma in ICT). Specializing in PHP, MySQL, Java, Android, 3D WebGL, and high-performance web systems." />
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="<?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?> | Full-Stack & 3D Web Developer" />
  <meta property="og:description" content="<?php echo htmlspecialchars($hero['subtitle'] ?? 'Full-Stack Web Developer & Software Engineer.'); ?>" />
  <meta property="og:image" content="assets/images/sahashra_portrait.jpg" />
  <meta property="og:url" content="https://sahashrajanith.site" />
  <meta property="og:type" content="website" />

  <!-- SVG Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%2300f2fe'/><text x='50%' y='54%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='48' font-weight='900' fill='%2305070a'>SJ</text></svg>" />

  <!-- Preconnect to Font & CDN Servers -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />

  <!-- Preload Hero LCP Image -->
  <link rel="preload" as="image" href="assets/images/sahashra_portrait_color.png" fetchpriority="high" type="image/png" />

  <!-- Premium Modern Google Fonts with display=swap -->
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet" />

  <!-- Asynchronous FontAwesome 6 Icons CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'" />
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /></noscript>

  <!-- Main Stylesheet -->
  <link rel="stylesheet" href="styles.css" />

  <!-- Deferred 3D Libraries & Lucide Icons -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js" defer></script>
  <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="theme-cyber">

  <!-- Custom Mouse Cursor -->
  <div id="custom-cursor" class="custom-cursor"></div>
  <div id="custom-cursor-follower" class="custom-cursor-follower"></div>

  <!-- Three.js Ambient Particles Background Canvas -->
  <div id="canvas-container"></div>

  <!-- Toast Notification Container -->
  <div id="toast-container" class="toast-container"></div>

  <!-- Floating Scroll To Top Widget -->
  <button id="scroll-top-btn" class="scroll-top-widget" title="Back to Top">
    <div class="scroll-top-icon">
      <i class="fa-solid fa-chevron-up"></i>
    </div>
    <span class="scroll-top-label">Scroll Top</span>
  </button>

  <!-- Site Navigation Header -->
  <header class="site-header">
    <div class="container header-content">
      <a href="#hero" class="brand-logo">
        <div class="logo-box" title="Sahashra Janith Developer Logo">
          <svg viewBox="0 0 100 100" width="24" height="24" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M 38 30 L 18 50 L 38 70 M 62 30 L 82 50 L 62 70 M 36 50 L 64 50" />
            <circle cx="18" cy="50" r="6" fill="currentColor" />
            <circle cx="82" cy="50" r="6" fill="currentColor" />
          </svg>
        </div>
        <span class="logo-text-full">SAHASHRA<span style="color:var(--accent-cyan)">.JANITH</span></span>
        <span class="logo-text-short" style="display:none;">SJ<span style="color:var(--accent-cyan)">.DEV</span></span>
      </a>

      <!-- Desktop Navigation Menu -->
      <nav>
        <ul class="nav-menu">
          <li><a href="#hero" class="nav-link active">Home</a></li>
          <li><a href="#about" class="nav-link">About Me</a></li>
          <li><a href="#experience" class="nav-link">Experience</a></li>
          <li><a href="#skills" class="nav-link">Skills</a></li>
          <li><a href="#projects" class="nav-link">Live Projects</a></li>
          <li><a href="#terminal" class="nav-link">Terminal</a></li>
          <li><a href="#contact" class="nav-link">Contact</a></li>
        </ul>
      </nav>

      <div class="header-actions">
        <div class="status-badge" title="Status: <?php echo htmlspecialchars($hero['availability'] ?? 'Available for Hire'); ?>">
          <div class="status-dot"></div>
          <span><?php echo htmlspecialchars($hero['availability'] ?? 'Available for Hire'); ?></span>
        </div>

        <button id="mobile-menu-toggle" class="icon-btn mobile-toggle-btn" title="Toggle Mobile Navigation">
          <i data-lucide="menu"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile Navigation Overlay & Drawer -->
  <div id="mobile-drawer-overlay" class="mobile-drawer-overlay"></div>
  <aside id="mobile-nav-drawer" class="mobile-nav-drawer">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
      <div class="brand-logo">
        <div class="logo-box">SJ</div>
        <span>SAHASHRA</span>
      </div>
      <button id="mobile-menu-close" class="icon-btn">
        <i data-lucide="x"></i>
      </button>
    </div>

    <ul class="mobile-nav-links">
      <li><a href="#hero" class="mobile-nav-link active"><i data-lucide="home"></i> Home</a></li>
      <li><a href="#about" class="mobile-nav-link"><i data-lucide="user"></i> About Me</a></li>
      <li><a href="#skills" class="mobile-nav-link"><i data-lucide="code-2"></i> Tech Skills</a></li>
      <li><a href="#projects" class="mobile-nav-link"><i data-lucide="folder-git-2"></i> Live Projects</a></li>
      <li><a href="#terminal" class="mobile-nav-link"><i data-lucide="terminal"></i> Developer Terminal</a></li>
      <li><a href="#contact" class="mobile-nav-link"><i data-lucide="mail"></i> Contact Me</a></li>
    </ul>

    <div style="margin-top:auto; padding-top:20px; border-top:1px solid var(--border-glass);">
      <div style="display:flex; gap:12px; justify-content:center;">
        <a href="<?php echo htmlspecialchars($hero['github'] ?? '#'); ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-github"></i></a>
        <a href="<?php echo htmlspecialchars($hero['linkedin'] ?? '#'); ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-linkedin"></i></a>
        <a href="<?php echo htmlspecialchars($hero['whatsapp'] ?? '#'); ?>" target="_blank" class="icon-btn"><i class="fa-brands fa-whatsapp"></i></a>
      </div>
    </div>
  </aside>

  <!-- Main Content Wrapper -->
  <main>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
      <div class="container hero-container-clean">
        <div class="hero-grid">
          
          <!-- Left Column: Hero Text Content -->
          <div class="hero-text-content reveal-on-scroll">
            <div class="hero-tag">
              <i data-lucide="award"></i>
              <span><?php echo htmlspecialchars($hero['tagline'] ?? 'NVQ 4 CERTIFIED & DIPLOMA IN ICT (NVTI)'); ?></span>
            </div>

            <h1 class="hero-title">
              Hello, I'm <span class="hero-name"><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?></span>
            </h1>

            <p class="hero-subtitle">
              <?php echo htmlspecialchars($hero['subtitle'] ?? 'Full-Stack Web Developer & Software Engineer crafting high-performance web systems, LMS portals, e-commerce stores, Android mobile applications, and modern web experiences.'); ?>
            </p>

            <div class="hero-cta-group">
              <a href="#projects" class="btn-primary">
                <span>View Live Projects</span>
                <i data-lucide="arrow-down-right"></i>
              </a>

              <a href="#contact" class="btn-secondary">
                <i data-lucide="mail"></i>
                <span>Hire Me</span>
              </a>

              <a href="assets/Sahashra_Janith_CV.pdf" download class="btn-secondary" style="border-color:var(--accent-cyan); color:var(--accent-cyan);">
                <i class="fa-solid fa-file-pdf"></i>
                <span>Download CV</span>
              </a>
            </div>

            <div style="display:flex; gap:16px; margin-top:32px; align-items:center;">
              <a href="<?php echo htmlspecialchars($hero['github'] ?? '#'); ?>" target="_blank" class="icon-btn" title="GitHub Profile">
                <i class="fa-brands fa-github"></i>
              </a>
              <a href="<?php echo htmlspecialchars($hero['linkedin'] ?? '#'); ?>" target="_blank" class="icon-btn" title="LinkedIn Profile">
                <i class="fa-brands fa-linkedin"></i>
              </a>
              <a href="mailto:<?php echo htmlspecialchars($hero['email'] ?? ''); ?>" class="icon-btn" title="Send Direct Email">
                <i class="fa-solid fa-envelope"></i>
              </a>
              <a href="<?php echo htmlspecialchars($hero['whatsapp'] ?? '#'); ?>" target="_blank" class="icon-btn" title="WhatsApp Chat">
                <i class="fa-brands fa-whatsapp"></i>
              </a>
            </div>

          </div>

          <!-- Right Column: Direct Seamless Cutout Portrait (No Card Frame) -->
          <div class="hero-photo-column reveal-on-scroll">
            <div class="direct-portrait-wrapper">
              <img src="assets/images/sahashra_portrait_color.png" alt="Sahashra Janith Software Developer" class="direct-portrait-img" />
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- About Me Section -->
    <section id="about" class="section">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <span class="section-subtitle">// ABOUT THE DEVELOPER</span>
          <h2 class="section-title">Driven By Code. Built For Growth.</h2>
          <p class="section-desc">
            Learn more about my background, technical expertise, qualifications, and philosophy as a Full-Stack Software Developer.
          </p>
        </div>

        <div class="about-grid">
          <div class="about-photo-wrapper reveal-on-scroll">
            <div class="cyber-photo-container">
              <div class="about-portrait-card">
                <img src="assets/images/sahashra_portrait.jpg" alt="<?php echo htmlspecialchars($hero['name'] ?? ''); ?> Portrait" class="about-portrait-img" />
                <div class="portrait-overlay-gradient"></div>
                
                <div class="portrait-name-tag">
                  <h4><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?></h4>
                  <p><?php echo htmlspecialchars($hero['title'] ?? 'Full-Stack Web Developer'); ?></p>
                </div>
              </div>

              <div class="floating-badge badge-top-right">
                <i class="fa-solid fa-bolt" style="color:var(--accent-cyan);"></i>
                <span>15+ Live Web Systems</span>
              </div>

              <div class="floating-badge badge-bottom-left">
                <i class="fa-solid fa-graduation-cap" style="color:var(--accent-emerald);"></i>
                <span>NVQ 4 & ICT Diploma</span>
              </div>
            </div>
          </div>

          <div class="about-content reveal-on-scroll">
            <h3 class="about-heading">
              Hi, I'm <span style="color:var(--accent-cyan);"><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?></span> 👋
            </h3>
            
            <p class="about-text">
              <?php echo htmlspecialchars($hero['about_text_1'] ?? ''); ?>
            </p>

            <p class="about-text">
              <?php echo htmlspecialchars($hero['about_text_2'] ?? ''); ?>
            </p>

            <!-- Quick Info Grid -->
            <div class="about-info-grid">
              <div class="info-pill">
                <span class="info-label">Name:</span>
                <span class="info-val"><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?></span>
              </div>
              <div class="info-pill">
                <span class="info-label">Education:</span>
                <span class="info-val">Diploma in ICT (NVTI)</span>
              </div>
              <div class="info-pill">
                <span class="info-label">Certification:</span>
                <span class="info-val">NVQ Level 4 Software Dev</span>
              </div>
              <div class="info-pill">
                <span class="info-label">Main Stack:</span>
                <span class="info-val">PHP, MySQL, Java, Android</span>
              </div>
              <div class="info-pill">
                <span class="info-label">Frontend:</span>
                <span class="info-val">JS (ES6+), Three.js, WebGL</span>
              </div>
              <div class="info-pill">
                <span class="info-label">Availability:</span>
                <span class="info-val" style="color:var(--accent-emerald); font-weight:600;"><?php echo htmlspecialchars($hero['availability'] ?? 'Available'); ?></span>
              </div>
            </div>

            <!-- Stats Counters Bar -->
            <div class="about-stats-bar">
              <?php foreach ($hero['stats'] ?? [] as $st): ?>
                <div class="stat-item">
                  <div class="stat-num"><?php echo htmlspecialchars($st['num']); ?></div>
                  <div class="stat-lbl"><?php echo htmlspecialchars($st['label']); ?></div>
                </div>
              <?php endforeach; ?>
            </div>

            <div style="margin-top:28px;">
              <a href="#contact" class="btn-primary">
                <span>Start A Project With Me</span>
                <i class="fa-solid fa-paper-plane"></i>
              </a>
            </div>

          </div>
        </div>

        <div class="feature-grid" style="margin-top:60px;">
          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper">
              <i data-lucide="award"></i>
            </div>
            <h3>NVQ Level 4 Completed</h3>
            <p>Certified in Software Development with hands-on expertise in software engineering principles, database structures, and object-oriented programming.</p>
          </div>

          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper">
              <i data-lucide="graduation-cap"></i>
            </div>
            <h3>Diploma in ICT (NVTI)</h3>
            <p>Graduated with a Diploma in Information & Communication Technology from National Vocational Training Institute (NVTI).</p>
          </div>

          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper">
              <i data-lucide="layers"></i>
            </div>
            <h3>15+ Live Web Systems</h3>
            <p>Engineered LMS portals, online exam platforms, e-commerce stores, and tuition management systems hosted live in production.</p>
          </div>

          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper">
              <i data-lucide="smartphone"></i>
            </div>
            <h3>Mobile & Fullstack Stack</h3>
            <p>Proficient across PHP, MySQL, Java, Android App development, JavaScript (ES6+), HTML5, CSS3, and 3D WebGL graphics.</p>
          </div>
    </section>

    <!-- Work Experience & Career History Timeline -->
    <section id="experience" class="section" style="background: rgba(15, 23, 42, 0.4); border-top: 1px solid var(--border-glass); border-bottom: 1px solid var(--border-glass);">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <span class="section-subtitle">// CAREER HISTORY & WORK EXPERIENCE</span>
          <h2 class="section-title">Professional Experience</h2>
          <p class="section-desc">
            Hands-on software development roles, enterprise web applications, and industry work history.
          </p>
        </div>

        <div class="timeline-wrapper">
          <!-- Timeline Item 1: Mr.Link Technology -->
          <div class="timeline-card reveal-on-scroll">
            <div class="timeline-badge-year">
              <span class="timeline-dot-active"></span>
              <span>Present</span>
            </div>
            <div class="timeline-content">
              <div class="timeline-header">
                <div>
                  <h3 class="timeline-role">Software Developer</h3>
                  <div class="timeline-company"><i class="fa-solid fa-building" style="color:var(--accent-cyan);"></i> Mr.Link Technology</div>
                </div>
                <span class="role-type-badge active-role">Full-Time</span>
              </div>
              <p class="timeline-desc">
                Engineering web applications, enterprise software solutions, and custom backend systems. Responsible for database architecture, API integrations, responsive frontends, and client project deployment.
              </p>
              <div class="timeline-tags">
                <span class="tag">PHP</span>
                <span class="tag">MySQL</span>
                <span class="tag">JavaScript</span>
                <span class="tag">System Architecture</span>
                <span class="tag">Web Apps</span>
              </div>
            </div>
          </div>

          <!-- Timeline Item 2: Sakwa Canneries & Exports -->
          <div class="timeline-card reveal-on-scroll">
            <div class="timeline-badge-year">
              <span class="timeline-dot-completed"></span>
              <span>6 Months</span>
            </div>
            <div class="timeline-content">
              <div class="timeline-header">
                <div>
                  <h3 class="timeline-role">Intern Web Developer</h3>
                  <div class="timeline-company"><i class="fa-solid fa-boxes-stacked" style="color:var(--accent-emerald);"></i> Sakwa Canneries & Exports</div>
                </div>
                <span class="role-type-badge intern-role">Internship</span>
              </div>
              <p class="timeline-desc">
                Designed and engineered the official <strong>Sakwa Canneries & Exports Inventory Management System</strong>. Streamlined stock tracking, export batch management, supplier records, and real-time inventory reporting.
              </p>
              <div class="timeline-tags">
                <span class="tag">Inventory System</span>
                <span class="tag">PHP</span>
                <span class="tag">MySQL</span>
                <span class="tag">Database Design</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Tech Stack Matrix -->
    <section id="skills" class="section">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <span class="section-subtitle">// TECHNICAL ARSENAL</span>
          <h2 class="section-title">Tech Stack & Skill Matrix</h2>
          <p class="section-desc">
            Technical mastery across backend engineering, database optimization, mobile Android development, and modern web UI.
          </p>
        </div>

        <div id="skills-filter" class="skills-filter reveal-on-scroll"></div>
        <div id="skills-grid" class="skills-grid reveal-on-scroll"></div>
      </div>
    </section>

    <!-- Real Live Projects Showcase -->
    <section id="projects" class="section">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <span class="section-subtitle">// REAL LIVE PROJECTS</span>
          <h2 class="section-title">Featured Live Web Applications</h2>
          <p class="section-desc">
            Explore live LMS platforms, exam systems, e-commerce stores, Android mobile applications, and web services.
          </p>
        </div>

        <div class="skills-filter reveal-on-scroll">
          <button class="filter-btn project-filter-btn active" data-filter="all">All Projects (<?php echo count($projects); ?>)</button>
          <button class="filter-btn project-filter-btn" data-filter="fullstack">Fullstack & LMS</button>
          <button class="filter-btn project-filter-btn" data-filter="ecom">E-Commerce</button>
          <button class="filter-btn project-filter-btn" data-filter="frontend">Web Portals</button>
          <button class="filter-btn project-filter-btn" data-filter="mobile">Android Apps</button>
        </div>

        <div id="projects-grid" class="projects-grid reveal-on-scroll"></div>
      </div>
    </section>

    <!-- Developer CLI Terminal -->
    <section id="terminal" class="section">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <span class="section-subtitle">// INTERACTIVE CLI INTERFACE</span>
          <h2 class="section-title">Sahashra's CLI Terminal</h2>
          <p class="section-desc">
            Type commands or use quick action shortcuts below to inspect credentials, skills, repositories, and direct contact details.
          </p>
        </div>

        <div class="terminal-wrapper reveal-on-scroll">
          <div class="terminal-header">
            <div class="terminal-buttons">
              <span class="terminal-btn btn-close"></span>
              <span class="terminal-btn btn-min"></span>
              <span class="terminal-btn btn-max"></span>
            </div>
            <div class="terminal-title">sahashra@nexus-dev-terminal: ~ (zsh)</div>
            <div style="font-size:0.75rem; color:var(--text-dim); font-family:var(--font-mono);">PROD v2.4</div>
          </div>

          <div id="terminal-body" class="terminal-body">
            <div class="terminal-line"><span class="terminal-success">Welcome to SAHASHRA JANITH Developer Terminal v2.4</span></div>
            <div class="terminal-line">Type <span class="terminal-accent">'help'</span> to view available commands, or click quick buttons below.</div>
          </div>

          <div class="terminal-quick-actions">
            <button class="term-action-btn" data-cmd="help"><i class="fa-solid fa-circle-question"></i> help</button>
            <button class="term-action-btn" data-cmd="about"><i class="fa-solid fa-user"></i> about</button>
            <button class="term-action-btn" data-cmd="skills"><i class="fa-solid fa-code"></i> skills</button>
            <button class="term-action-btn" data-cmd="projects"><i class="fa-solid fa-folder-open"></i> projects</button>
            <button class="term-action-btn" data-cmd="contact"><i class="fa-solid fa-envelope"></i> contact</button>
            <button class="term-action-btn" data-cmd="clear"><i class="fa-solid fa-trash-can"></i> clear</button>
          </div>

          <div style="padding:14px 20px; background:#0b0f17; border-top:1px solid rgba(255,255,255,0.08);">
            <div class="terminal-input-row" style="display:flex; align-items:center; gap:8px;">
              <span class="prompt-user" style="color:var(--accent-cyan); font-family:var(--font-mono); font-weight:600;">guest@sahashrajanith</span>:<span class="prompt-dir" style="color:#a78bfa; font-family:var(--font-mono);">~$</span>
              <input type="text" id="terminal-input" class="terminal-input" placeholder="Type command here (e.g. 'skills')..." autocomplete="off" spellcheck="false" style="flex-grow:1; background:transparent; border:none; color:#fff; font-family:var(--font-mono); outline:none;" />
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Me Section -->
    <section id="contact" class="section">
      <div class="container">
        <div class="section-header reveal-on-scroll">
          <span class="section-subtitle">// DIRECT CHANNEL</span>
          <h2 class="section-title">Let's Build Something Exceptional</h2>
          <p class="section-desc">
            Have a project in mind, an inquiry about custom software/LMS development, or a job opening? Reach out directly!
          </p>
        </div>

        <div class="contact-grid">
          <div class="contact-info-column reveal-on-scroll">
            <div class="contact-card contact-info-panel">
              <h3 class="contact-panel-title">
                <i class="fa-solid fa-paper-plane" style="color:var(--accent-cyan);"></i> Get In Touch
              </h3>
              <p class="contact-panel-desc">
                Feel free to reach out for client inquiries, custom software projects, or collaboration opportunities.
              </p>

              <div class="contact-info-list">
                
                <div class="contact-info-item">
                  <div class="contact-icon">
                    <i class="fa-solid fa-envelope"></i>
                  </div>
                  <div class="contact-info-details">
                    <span class="info-item-label">Direct Email</span>
                    <a href="mailto:<?php echo htmlspecialchars($hero['email'] ?? ''); ?>" class="info-item-link">
                      <?php echo htmlspecialchars($hero['email'] ?? ''); ?>
                    </a>
                  </div>
                </div>

                <div class="contact-info-item">
                  <div class="contact-icon">
                    <i class="fa-brands fa-whatsapp"></i>
                  </div>
                  <div class="contact-info-details">
                    <span class="info-item-label">WhatsApp Inquiry</span>
                    <a href="<?php echo htmlspecialchars($hero['whatsapp'] ?? ''); ?>" target="_blank" class="info-item-link">
                      <?php echo htmlspecialchars($hero['phone'] ?? '+94 77 309 3941'); ?>
                    </a>
                  </div>
                </div>

                <div class="contact-info-item">
                  <div class="contact-icon">
                    <i class="fa-solid fa-location-dot"></i>
                  </div>
                  <div class="contact-info-details">
                    <span class="info-item-label">Location</span>
                    <span class="info-item-value"><?php echo htmlspecialchars($hero['location'] ?? 'Sri Lanka'); ?></span>
                  </div>
                </div>

                <div class="contact-info-item">
                  <div class="contact-icon">
                    <i class="fa-solid fa-circle-check"></i>
                  </div>
                  <div class="contact-info-details">
                    <span class="info-item-label">Work Status</span>
                    <span class="info-item-value" style="color:var(--accent-emerald); font-weight:700;">
                      Available for Hire
                    </span>
                  </div>
                </div>

              </div>

              <div class="contact-social-bar">
                <span class="social-bar-label">Connect on Socials:</span>
                <div class="social-icon-group">
                  <a href="<?php echo htmlspecialchars($hero['github'] ?? '#'); ?>" target="_blank" class="social-btn" title="GitHub Profile">
                    <i class="fa-brands fa-github"></i>
                  </a>
                  <a href="<?php echo htmlspecialchars($hero['linkedin'] ?? '#'); ?>" target="_blank" class="social-btn" title="LinkedIn Profile">
                    <i class="fa-brands fa-linkedin"></i>
                  </a>
                  <a href="<?php echo htmlspecialchars($hero['whatsapp'] ?? '#'); ?>" target="_blank" class="social-btn" title="WhatsApp Direct">
                    <i class="fa-brands fa-whatsapp"></i>
                  </a>
                </div>
              </div>

            </div>
          </div>

          <div class="contact-form-column reveal-on-scroll">
            <div class="contact-card">
              <form id="contact-form" class="contact-form">
                <div class="form-group">
                  <label for="contact-name" class="form-label">Your Full Name</label>
                  <input type="text" id="contact-name" name="name" required placeholder="John Doe" class="form-input" />
                </div>

                <div class="form-group">
                  <label for="contact-email" class="form-label">Your Email Address</label>
                  <input type="email" id="contact-email" name="email" required placeholder="john@example.com" class="form-input" />
                </div>

                <div class="form-group">
                  <label for="contact-subject" class="form-label">Subject</label>
                  <input type="text" id="contact-subject" name="subject" required placeholder="Project Inquiry / LMS Development" class="form-input" />
                </div>

                <div class="form-group">
                  <label for="contact-message" class="form-label">Your Message</label>
                  <textarea id="contact-message" name="message" required placeholder="Tell me about your project requirements..." rows="5" class="form-textarea"></textarea>
                </div>

                <button type="submit" id="contact-submit-btn" class="btn-primary btn-full">
                  <span>Send Message to Sahashra</span>
                  <i class="fa-solid fa-paper-plane"></i>
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Project Details Modal Popup -->
  <div id="project-modal" class="modal-overlay">
    <div class="modal-card">
      <button id="modal-close" class="modal-close-btn">&times;</button>
      <div id="modal-content-area"></div>
    </div>
  </div>

  <!-- Site Footer -->
  <footer class="site-footer">
    <div class="container">
      <div class="footer-main-grid">
        
        <!-- Column 1: Brand & Bio -->
        <div>
          <a href="#hero" class="brand-logo" style="margin-bottom:16px; display:inline-flex;">
            <div class="logo-box" title="Sahashra Janith Developer Logo">
              <svg viewBox="0 0 100 100" width="24" height="24" fill="none" stroke="currentColor" stroke-width="8" stroke-linecap="round" stroke-linejoin="round">
                <path d="M 38 30 L 18 50 L 38 70 M 62 30 L 82 50 L 62 70 M 36 50 L 64 50" />
                <circle cx="18" cy="50" r="6" fill="currentColor" />
                <circle cx="82" cy="50" r="6" fill="currentColor" />
              </svg>
            </div>
            <span class="logo-text-full">SAHASHRA<span style="color:var(--accent-cyan)">.JANITH</span></span>
          </a>
          <p style="color:var(--text-muted); font-size:0.9rem; line-height:1.6; margin-bottom:20px;">
            Full-Stack Web Developer & Software Engineer. Crafting high-performance LMS platforms, tuition systems, e-commerce stores, and Android mobile apps.
          </p>
          <div style="display:flex; gap:12px;">
            <a href="<?php echo htmlspecialchars($hero['github'] ?? '#'); ?>" target="_blank" class="icon-btn" title="GitHub"><i class="fa-brands fa-github"></i></a>
            <a href="<?php echo htmlspecialchars($hero['linkedin'] ?? '#'); ?>" target="_blank" class="icon-btn" title="LinkedIn"><i class="fa-brands fa-linkedin"></i></a>
            <a href="mailto:<?php echo htmlspecialchars($hero['email'] ?? ''); ?>" class="icon-btn" title="Email"><i class="fa-solid fa-envelope"></i></a>
            <a href="<?php echo htmlspecialchars($hero['whatsapp'] ?? '#'); ?>" target="_blank" class="icon-btn" title="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
          </div>
        </div>

        <!-- Column 2: Quick Links -->
        <div>
          <div class="footer-col-title"><i class="fa-solid fa-compass"></i> Navigation</div>
          <ul class="footer-links-list">
            <li class="footer-link-item"><a href="#hero">✦ Home</a></li>
            <li class="footer-link-item"><a href="#about">✦ About Me</a></li>
            <li class="footer-link-item"><a href="#skills">✦ Tech Arsenal</a></li>
            <li class="footer-link-item"><a href="#projects">✦ Live Projects</a></li>
            <li class="footer-link-item"><a href="#terminal">✦ CLI Terminal</a></li>
            <li class="footer-link-item"><a href="#contact">✦ Contact Portal</a></li>
          </ul>
        </div>

        <!-- Column 3: Core Expertise -->
        <div>
          <div class="footer-col-title"><i class="fa-solid fa-code-merge"></i> Services</div>
          <ul class="footer-links-list">
            <li class="footer-link-item"><a href="#projects">✦ LMS & Exam Portals</a></li>
            <li class="footer-link-item"><a href="#projects">✦ Tuition Management Apps</a></li>
            <li class="footer-link-item"><a href="#projects">✦ Full-Stack PHP & MySQL</a></li>
            <li class="footer-link-item"><a href="#projects">✦ E-Commerce Web Stores</a></li>
            <li class="footer-link-item"><a href="#projects">✦ Android App Development</a></li>
          </ul>
        </div>

        <!-- Column 4: Contact & Admin Link -->
        <div>
          <div class="footer-col-title"><i class="fa-solid fa-paper-plane"></i> Direct Channel</div>
          <p style="color:var(--text-muted); font-size:0.88rem; margin-bottom:12px;">
            <i class="fa-solid fa-envelope" style="color:var(--accent-cyan);"></i> <?php echo htmlspecialchars($hero['email'] ?? 'sahashrajanith@gmail.com'); ?>
          </p>
          <p style="color:var(--text-muted); font-size:0.88rem; margin-bottom:12px;">
            <i class="fa-brands fa-whatsapp" style="color:#34d399;"></i> <?php echo htmlspecialchars($hero['phone'] ?? '+94 77 309 3941'); ?>
          </p>
          <p style="color:var(--text-muted); font-size:0.88rem; margin-bottom:16px;">
            <i class="fa-solid fa-location-dot" style="color:var(--accent-cyan);"></i> <?php echo htmlspecialchars($hero['location'] ?? 'Galle, Sri Lanka'); ?>
          </p>
          <div style="background:rgba(0,242,254,0.06); border:1px solid rgba(0,242,254,0.3); border-radius:10px; padding:12px; font-size:0.82rem; color:var(--text-main);">
            <div style="display:flex; align-items:center; gap:8px; font-weight:700; color:var(--accent-cyan); margin-bottom:4px;">
              <span style="width:8px; height:8px; background:#34d399; border-radius:50%; display:inline-block; box-shadow:0 0 10px #34d399;"></span> Available for Hire
            </div>
            Open for freelance projects & software development contracts.
          </div>
        </div>

      </div>

      <!-- Bottom Copyright -->
      <div class="footer-bottom-bar" style="justify-content:center; text-align:center;">
        <div style="font-size:0.85rem; color:var(--text-dim);">
          &copy; <?php echo date('Y'); ?> <strong>Sahashra Janith</strong>.
        </div>
      </div>
    </div>
  </footer>

  <!-- Application Scripts (Deferred for Maximum Performance) -->
  <script>
    window.portfolioData = <?php echo json_encode($portfolio); ?>;
  </script>
  <script src="js/audio.js" defer></script>
  <script src="js/threeScene.js" defer></script>
  <script src="js/terminal.js" defer></script>
  <script src="js/skills.js" defer></script>
  <script src="js/projects.js" defer></script>
  <script src="js/app.js" defer></script>
</body>
</html>
