<?php
// Force Canonical Domain (non-www and HTTPS) to resolve GSC duplicate canonical issues
$requestHost = $_SERVER['HTTP_HOST'] ?? '';
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
if (stripos($requestHost, 'www.') === 0 || (!$isHttps && $requestHost !== 'localhost' && $requestHost !== '127.0.0.1')) {
    $canonicalHost = preg_replace('/^www\./i', '', $requestHost);
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    if (!empty($canonicalHost) && $canonicalHost !== 'localhost' && $canonicalHost !== '127.0.0.1') {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: https://{$canonicalHost}{$uri}");
        exit;
    }
}

// Always ensure fresh content & purge old server RAM cache
header('X-LiteSpeed-Purge: *');
header('Cache-Control: no-cache, no-store, must-revalidate');
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
  <title>Sahashra Janith Damsara | Full-Stack Software Engineer &amp; Web Developer</title>
  <meta name="description" content="Official portfolio of Sahashra Janith Damsara (Janith Damsara) — Full-Stack Software Engineer &amp; Web Developer based in Galle, Sri Lanka. Specializing in PHP, MySQL, Java, Android Apps, and Enterprise Web Systems." />
  
  <!-- Open Graph Meta Tags -->
  <meta property="og:site_name" content="Sahashra Janith Damsara Portfolio" />
  <meta property="og:title" content="Sahashra Janith Damsara | Full-Stack Software Engineer &amp; Web Developer" />
  <meta property="og:description" content="Official portfolio of Sahashra Janith Damsara (Janith Damsara) — Full-Stack Software Engineer &amp; Web Developer in Sri Lanka. Explore live enterprise systems, LMS portals, and Android apps." />
  <meta property="og:image" content="https://sahashrajanith.site/assets/images/sahashra_portrait.jpg" />
  <meta property="og:image:width" content="1200" />
  <meta property="og:image:height" content="630" />
  <meta property="og:image:alt" content="Sahashra Janith Damsara - Software Engineer" />
  <meta property="og:url" content="https://sahashrajanith.site/" />
  <meta property="og:type" content="profile" />
  <meta property="profile:first_name" content="Sahashra Janith" />
  <meta property="profile:last_name" content="Damsara" />
  <meta property="profile:username" content="sahashrajanith" />

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="Sahashra Janith Damsara | Full-Stack Software Engineer" />
  <meta name="twitter:description" content="Discover full-stack web platforms, LMS portals, Android applications, and enterprise systems built by Sahashra Janith Damsara (Janith Damsara)." />
  <meta name="twitter:image" content="https://sahashrajanith.site/assets/images/sahashra_portrait.jpg" />

  <!-- Search Engine Optimization (SEO) & Verification -->
  <meta name="google-site-verification" content="foj3BRnJ9HxGMsXSbAKuZ3CNFHmKP5Di-CvJr-Ioxb4" />
  <link rel="canonical" href="https://sahashrajanith.site/" />
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1" />
  <meta name="author" content="Sahashra Janith Damsara (Janith)" />
  <meta name="keywords" content="Janith, Sahashra, Sahashra Janith, Janith Damsara, Sahashra Janith Damsara, J.A. Sahashra Janith, Janith Galle, Janith Developer Sri Lanka, Sahashra Software Engineer, Full-Stack Developer Sri Lanka, Janith Portfolio, Web Developer Sri Lanka, Software Engineer Galle" />

  <!-- Google Knowledge Graph Schema (JSON-LD) -->
  <script type="application/ld+json">
  {
    "@context": "https://schema.org",
    "@graph": [
      {
        "@type": "Person",
        "@id": "https://sahashrajanith.site/#person",
        "name": "Sahashra Janith Damsara",
        "givenName": "Sahashra Janith",
        "familyName": "Damsara",
        "additionalName": "Janith",
        "alternateName": [
          "Janith",
          "Sahashra",
          "Sahashra Janith",
          "Janith Damsara",
          "J.A. Sahashra Janith Damsara",
          "Janith Developer",
          "Sahashra Janith Developer Sri Lanka"
        ],
        "jobTitle": "Full-Stack Software Engineer & Web Developer",
        "url": "https://sahashrajanith.site/",
        "image": {
          "@type": "ImageObject",
          "url": "https://sahashrajanith.site/assets/images/sahashra_portrait.jpg",
          "caption": "Sahashra Janith Damsara"
        },
        "sameAs": [
          "https://github.com/sahashrajanith",
          "https://github.com/janithjanithdamsara-coder",
          "https://www.linkedin.com/in/sahashra-janith-6422353a1"
        ],
        "address": {
          "@type": "PostalAddress",
          "addressLocality": "Galle",
          "addressRegion": "Southern Province",
          "addressCountry": "Sri Lanka"
        },
        "alumniOf": [
          {
            "@type": "EducationalOrganization",
            "name": "National Vocational Training Institute (NVTI)"
          }
        ],
        "hasCredential": [
          {
            "@type": "EducationalOccupationalCredential",
            "name": "NVQ Level 4 in Software Development",
            "credentialCategory": "degree"
          },
          {
            "@type": "EducationalOccupationalCredential",
            "name": "Diploma in Information & Communication Technology",
            "recognizedBy": {
              "@type": "EducationalOrganization",
              "name": "NVTI"
            }
          }
        ],
        "knowsAbout": [
          "Full-Stack Web Development",
          "Software Engineering",
          "PHP",
          "MySQL",
          "Java",
          "Android Studio App Development",
          "JavaScript (ES6+)",
          "Three.js & WebGL",
          "Learning Management Systems (LMS)",
          "E-Commerce Architecture",
          "REST APIs"
        ],
        "description": "Sahashra Janith Damsara (Janith Damsara) is a Full-Stack Software Engineer & Web Developer based in Galle, Sri Lanka. Expert in PHP, MySQL, Java, Android Apps, and production web systems."
      },
      {
        "@type": "WebSite",
        "@id": "https://sahashrajanith.site/#website",
        "url": "https://sahashrajanith.site/",
        "name": "Sahashra Janith Damsara Portfolio",
        "publisher": {
          "@id": "https://sahashrajanith.site/#person"
        },
        "inLanguage": "en-US"
      }
    ]
  }
  </script>

  <!-- SVG Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><rect width='100' height='100' rx='22' fill='%2300f2fe'/><text x='50%' y='54%' dominant-baseline='middle' text-anchor='middle' font-family='sans-serif' font-size='48' font-weight='900' fill='%2305070a'>SJ</text></svg>" />

  <!-- Preconnect to Font & CDN Servers -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin />

  <!-- Preload Hero LCP Image -->
  <link rel="preload" as="image" href="assets/images/sahashra_portrait_color_mobile.webp" media="(max-width: 768px)" fetchpriority="high" type="image/webp" />
  <link rel="preload" as="image" href="assets/images/sahashra_portrait_color.webp" media="(min-width: 769px)" fetchpriority="high" type="image/webp" />

  <!-- Premium Modern Google Fonts with display=swap -->
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" media="print" onload="this.media='all'" />
  <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Outfit:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;600;700&family=JetBrains+Mono:wght@400;500&display=swap" /></noscript>

  <!-- Asynchronous FontAwesome 6 Icons CDN -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" media="print" onload="this.media='all'" />
  <noscript><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /></noscript>

  <!-- Main Stylesheet -->
  <link rel="preload" as="style" href="styles.min.css?v=3.4" />
  <link rel="stylesheet" href="styles.min.css?v=3.4" />
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-solid-900.woff2" as="font" type="font/woff2" crossorigin />
  <link rel="preload" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/webfonts/fa-brands-400.woff2" as="font" type="font/woff2" crossorigin />
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
        <span class="logo-text-full">SAHASHRA<span style="color:var(--accent-cyan)">.JANITH</span></span>
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
          <i class="fa-solid fa-bars"></i>
        </button>
      </div>
    </div>
  </header>

  <!-- Mobile Navigation Overlay & Drawer -->
  <div id="mobile-drawer-overlay" class="mobile-drawer-overlay"></div>
  <aside id="mobile-nav-drawer" class="mobile-nav-drawer">
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:24px;">
      <div class="brand-logo">
        <span class="logo-text-full">SAHASHRA<span style="color:var(--accent-cyan)">.JANITH</span></span>
      </div>
      <button id="mobile-menu-close" class="icon-btn">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <ul class="mobile-nav-links">
      <li><a href="#hero" class="mobile-nav-link active"><i class="fa-solid fa-house" style="width:20px;"></i> Home</a></li>
      <li><a href="#about" class="mobile-nav-link"><i class="fa-solid fa-user" style="width:20px;"></i> About Me</a></li>
      <li><a href="#skills" class="mobile-nav-link"><i class="fa-solid fa-code" style="width:20px;"></i> Tech Skills</a></li>
      <li><a href="#projects" class="mobile-nav-link"><i class="fa-solid fa-laptop-code" style="width:20px;"></i> Live Projects</a></li>
      <li><a href="#terminal" class="mobile-nav-link"><i class="fa-solid fa-terminal" style="width:20px;"></i> Developer Terminal</a></li>
      <li><a href="#contact" class="mobile-nav-link"><i class="fa-solid fa-envelope" style="width:20px;"></i> Contact Me</a></li>
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
            <h1 class="hero-title">
              Hello, I'm <span class="hero-name"><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?></span>
            </h1>

            <p class="hero-subtitle">
              <?php echo htmlspecialchars($hero['subtitle'] ?? 'Full-Stack Web Developer & Software Engineer crafting high-performance web systems, LMS portals, e-commerce stores, Android mobile applications, and modern web experiences.'); ?>
            </p>

            <div class="hero-cta-group">
              <a href="#projects" class="btn-primary">
                <span>View Live Projects</span>
                <i class="fa-solid fa-arrow-down" style="font-size:0.85rem;"></i>
              </a>

              <a href="#contact" class="btn-secondary">
                <i class="fa-solid fa-envelope" style="font-size:0.9rem;"></i>
                <span>Hire Me</span>
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
              <picture>
                <source media="(max-width: 768px)" srcset="assets/images/sahashra_portrait_color_mobile.webp" width="340" height="435" type="image/webp">
                <source srcset="assets/images/sahashra_portrait_color.webp" type="image/webp">
                <img src="assets/images/sahashra_portrait_color.png" alt="Sahashra Janith Damsara - Full-Stack Software Engineer" class="direct-portrait-img" width="644" height="824" fetchpriority="high" decoding="async" />
              </picture>
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
                <picture>
                  <source srcset="assets/images/sahashra_portrait.webp" type="image/webp">
                  <img src="assets/images/sahashra_portrait.jpg" alt="<?php echo htmlspecialchars($hero['name'] ?? ''); ?> Portrait" class="about-portrait-img" loading="lazy" width="850" height="1050" decoding="async" />
                </picture>
                <div class="portrait-overlay-gradient"></div>
                
                <div class="portrait-name-tag">
                  <h4><?php echo htmlspecialchars($hero['name'] ?? 'Sahashra Janith'); ?></h4>
                  <p><?php echo htmlspecialchars($hero['title'] ?? 'Full-Stack Web Developer'); ?></p>
                </div>
              </div>

              <!-- Badges neatly placed below photo (Option 1) -->
              <div class="about-photo-badges">
                <div class="photo-pill-badge">
                  <i class="fa-solid fa-bolt" style="color:var(--accent-cyan);"></i>
                  <span>15+ Live Web Systems</span>
                </div>
                <div class="photo-pill-badge">
                  <i class="fa-solid fa-graduation-cap" style="color:var(--accent-emerald);"></i>
                  <span>NVQ 4 & ICT Diploma</span>
                </div>
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
                <span class="info-val">Sahashra Janith Damsara</span>
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
            <div class="card-icon-wrapper" style="background: rgba(0, 242, 254, 0.12); border-color: rgba(0, 242, 254, 0.4); box-shadow: 0 0 20px rgba(0, 242, 254, 0.25);">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:var(--accent-cyan); filter:drop-shadow(0 0 8px rgba(0,242,254,0.6));">
                <circle cx="12" cy="8" r="6"></circle>
                <path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"></path>
              </svg>
            </div>
            <h3>NVQ Level 4 Completed</h3>
            <p>Certified in Software Development with hands-on expertise in software engineering principles, database structures, and object-oriented programming.</p>
          </div>

          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper" style="background: rgba(56, 189, 248, 0.12); border-color: rgba(56, 189, 248, 0.4); box-shadow: 0 0 20px rgba(56, 189, 248, 0.25);">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#38bdf8; filter:drop-shadow(0 0 8px rgba(56,189,248,0.6));">
                <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
              </svg>
            </div>
            <h3>Diploma in ICT (NVTI)</h3>
            <p>Graduated with a Diploma in Information & Communication Technology from National Vocational Training Institute (NVTI).</p>
          </div>

          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper" style="background: rgba(168, 85, 247, 0.12); border-color: rgba(168, 85, 247, 0.4); box-shadow: 0 0 20px rgba(168, 85, 247, 0.25);">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#a855f7; filter:drop-shadow(0 0 8px rgba(168,85,247,0.6));">
                <path d="m12.83 2.18a2 2 0 0 0-1.66 0L2.6 6.08a1 1 0 0 0 0 1.83l8.58 3.91a2 2 0 0 0 1.66 0l8.58-3.9a1 1 0 0 0 0-1.83Z"></path>
                <path d="m22 17.65-9.17 4.16a2 2 0 0 1-1.66 0L2 17.65"></path>
                <path d="m22 12.65-9.17 4.16a2 2 0 0 1-1.66 0L2 12.65"></path>
              </svg>
            </div>
            <h3>15+ Live Web Systems</h3>
            <p>Engineered LMS portals, online exam platforms, e-commerce stores, and tuition management systems hosted live in production.</p>
          </div>

          <div class="tilt-card reveal-on-scroll">
            <div class="card-icon-wrapper" style="background: rgba(52, 211, 153, 0.12); border-color: rgba(52, 211, 153, 0.4); box-shadow: 0 0 20px rgba(52, 211, 153, 0.25);">
              <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#34d399; filter:drop-shadow(0 0 8px rgba(52,211,153,0.6));">
                <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect>
                <path d="M12 18h.01"></path>
              </svg>
            </div>
            <h3>Mobile & Fullstack Stack</h3>
            <p>Proficient across PHP, MySQL, Java, Android App development, JavaScript (ES6+), HTML5, CSS3, and 3D WebGL graphics.</p>
          </div>
        </div>
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

        <div class="skills-filter project-filters-wrapper reveal-on-scroll" style="display:flex; justify-content:center; gap:10px; flex-wrap:wrap; margin-bottom:36px;">
          <button class="filter-btn project-filter-btn active" data-filter="all">
            <i class="fa-solid fa-layer-group"></i>
            <span>All Projects</span>
            <span class="filter-count" data-count="all"><?php echo count($projects); ?></span>
          </button>
          <button class="filter-btn project-filter-btn" data-filter="fullstack">
            <i class="fa-solid fa-graduation-cap"></i>
            <span>LMS & Portals</span>
            <span class="filter-count" data-count="fullstack">3</span>
          </button>
          <button class="filter-btn project-filter-btn" data-filter="ecom">
            <i class="fa-solid fa-cart-shopping"></i>
            <span>E-Commerce</span>
            <span class="filter-count" data-count="ecom">1</span>
          </button>
          <button class="filter-btn project-filter-btn" data-filter="frontend">
            <i class="fa-solid fa-globe"></i>
            <span>Web Platforms</span>
            <span class="filter-count" data-count="frontend">2</span>
          </button>
          <button class="filter-btn project-filter-btn" data-filter="mobile">
            <i class="fa-brands fa-android"></i>
            <span>Android Apps</span>
            <span class="filter-count" data-count="mobile">1</span>
          </button>
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
                <!-- Anti-Spam Honeypot Field (Inaccessible to human users, traps automated bots) -->
                <div style="display:none !important; visibility:hidden; opacity:0; position:absolute; left:-9999px;" aria-hidden="true">
                  <label for="website_hp">Leave this blank</label>
                  <input type="text" id="website_hp" name="website_hp" tabindex="-1" autocomplete="off" />
                </div>

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

  <!-- Application Scripts (Optimized for 95-100 PageSpeed) -->
  <script>
    window.portfolioData = <?php echo json_encode($portfolio); ?>;
  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js" defer></script>
  <script src="js/audio.js" defer></script>
  <script src="js/terminal.js" defer></script>
  <script src="js/skills.js" defer></script>
  <script src="js/projects.js" defer></script>
  <script src="js/app.js" defer></script>

  <!-- Desktop-Only Three.js Background Particles (Eliminates 600KB+ on Mobile) -->
  <script>
    if (window.innerWidth >= 768) {
      window.addEventListener('load', function() {
        var tScript = document.createElement('script');
        tScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js';
        tScript.defer = true;
        tScript.onload = function() {
          var sScript = document.createElement('script');
          sScript.src = 'js/threeScene.js';
          sScript.defer = true;
          document.body.appendChild(sScript);
        };
        document.body.appendChild(tScript);
      });
    }
  </script>
</body>
</html>
