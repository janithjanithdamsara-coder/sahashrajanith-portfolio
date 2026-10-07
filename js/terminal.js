/* ==========================================================================
   DEVELOPER CLI TERMINAL CONTROLLER (WITH AUTO-FOCUS ON QUICK ACTIONS)
   ========================================================================== */

class DeveloperTerminal {
  constructor() {
    this.bodyEl = document.getElementById('terminal-body');
    this.inputEl = document.getElementById('terminal-input');
    this.history = [];
    this.historyIndex = -1;

    if (!this.bodyEl || !this.inputEl) return;

    this.init();
  }

  init() {
    this.inputEl.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        const command = this.inputEl.value.trim();
        if (command) {
          this.executeCommand(command);
          this.history.push(command);
          this.historyIndex = this.history.length;
          this.inputEl.value = '';
        }
      } else if (e.key === 'ArrowUp') {
        if (this.historyIndex > 0) {
          this.historyIndex--;
          this.inputEl.value = this.history[this.historyIndex];
        }
      } else if (e.key === 'ArrowDown') {
        if (this.historyIndex < this.history.length - 1) {
          this.historyIndex++;
          this.inputEl.value = this.history[this.historyIndex];
        } else {
          this.historyIndex = this.history.length;
          this.inputEl.value = '';
        }
      }
    });

    // Quick action buttons with AUTO-FOCUS ON TERMINAL INPUT
    const actionBtns = document.querySelectorAll('.term-action-btn, .term-quick-btn');
    actionBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const cmd = btn.getAttribute('data-cmd');
        if (cmd) {
          this.executeCommand(cmd);
          this.inputEl.focus(); // Auto-focus input for seamless typing!
        }
      });
    });
  }

  appendLine(userCmd, outputHtml) {
    const line = document.createElement('div');
    line.className = 'terminal-line';
    line.innerHTML = `
      <div><span class="prompt-user">sahashra@dev</span>:<span class="prompt-dir">~/portfolio</span>$&nbsp;<span class="cmd-text">${userCmd}</span></div>
      <div class="terminal-output">${outputHtml}</div>
    `;
    this.bodyEl.appendChild(line);
    this.bodyEl.scrollTop = this.bodyEl.scrollHeight;
  }

  executeCommand(cmd) {
    const cleanCmd = cmd.toLowerCase().trim();

    if (window.audioController) {
      window.audioController.playKeystrokeSound();
    }

    switch (cleanCmd) {
      case 'help':
        this.appendLine(cmd, `
          <strong>Available CLI Commands:</strong><br/>
          • <span class="terminal-accent">about</span> &nbsp;&nbsp;&nbsp;- Developer background & qualifications<br/>
          • <span class="terminal-accent">skills</span> &nbsp;&nbsp;- Full technical stack & matrix<br/>
          • <span class="terminal-accent">projects</span> - Showcase of 7 real live applications<br/>
          • <span class="terminal-accent">contact</span> &nbsp;- Email, WhatsApp & Social profiles<br/>
          • <span class="terminal-accent">theme cyber|emerald|amber</span> - Switch theme palette<br/>
          • <span class="terminal-accent">clear</span> &nbsp;&nbsp;&nbsp;- Clear terminal history
        `);
        break;

      case 'about':
        this.appendLine(cmd, `
          <strong>Sahashra Janith</strong> | Full-Stack Web Developer<br/>
          🎓 Qualifications: NVQ Level 4 in Software Development & Diploma in ICT (NVTI)<br/>
          🚀 Experience: 15+ Live Web Systems (LMS, Exam Portals, E-Commerce, Android Apps)<br/>
          💻 Main Tech: PHP, MySQL, Java, Android, JavaScript (ES6+), 3D WebGL (Three.js)
        `);
        break;

      case 'skills':
        this.appendLine(cmd, `
          <strong>Technical Stack:</strong><br/>
          [Backend] &nbsp;&nbsp;: PHP 8, MySQL, Java Core, Android SDK<br/>
          [Frontend] : JavaScript (ES6+), HTML5, CSS3, Three.js (WebGL)<br/>
          [Tools] &nbsp;&nbsp;&nbsp;&nbsp;: Git, GitHub, XAMPP, VS Code, Android Studio
        `);
        break;

      case 'projects':
        this.appendLine(cmd, `
          <strong>Featured Live Projects:</strong><br/>
          1. Zenith Academy Platform &nbsp;&nbsp;- <a href="https://exampro.site/" target="_blank" style="color:var(--accent-cyan);">exampro.site</a><br/>
          2. ScholarPro Exam Portal &nbsp;&nbsp;&nbsp;- <a href="https://scholarpro.exampro.site/" target="_blank" style="color:var(--accent-cyan);">scholarpro.exampro.site</a><br/>
          3. Science Tuition Platform &nbsp;- <a href="https://science.sahashrajanith.site/" target="_blank" style="color:var(--accent-cyan);">science.sahashrajanith.site</a><br/>
          4. AL Class Management System - <a href="https://futuremindssite.site" target="_blank" style="color:var(--accent-cyan);">futuremindssite.site</a><br/>
          5. Bloomy Haven Store &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a href="https://bloomyhaven.store/" target="_blank" style="color:var(--accent-cyan);">bloomyhaven.store</a><br/>
          6. Personal Portfolio &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;- <a href="https://sahashrajanith.site/" target="_blank" style="color:var(--accent-cyan);">sahashrajanith.site</a>
        `);
        break;

      case 'contact':
        this.appendLine(cmd, `
          <strong>Direct Contact Information:</strong><br/>
          📧 Email &nbsp;&nbsp;&nbsp;&nbsp;: <a href="mailto:sahashrajanith@gmail.com" style="color:var(--accent-cyan);">sahashrajanith@gmail.com</a><br/>
          📱 Phone/WA : <a href="https://wa.me/94773093941" target="_blank" style="color:var(--accent-cyan);">+94 77 309 3941</a><br/>
          🐙 GitHub &nbsp;&nbsp;: <a href="https://github.com/sahashrajanith" target="_blank" style="color:var(--accent-cyan);">github.com/sahashrajanith</a><br/>
          💼 LinkedIn : <a href="https://www.linkedin.com/in/sahashra-janith-6422353a1" target="_blank" style="color:var(--accent-cyan);">linkedin.com/in/sahashra-janith</a>
        `);
        break;

      case 'theme cyber':
        document.body.className = 'theme-cyber';
        this.appendLine(cmd, `<span class="terminal-success">Switched to Cyber Blue Theme!</span>`);
        break;

      case 'theme emerald':
        document.body.className = 'theme-emerald';
        this.appendLine(cmd, `<span class="terminal-success">Switched to Emerald Green Theme!</span>`);
        break;

      case 'theme amber':
        document.body.className = 'theme-amber';
        this.appendLine(cmd, `<span class="terminal-success">Switched to Amber Gold Theme!</span>`);
        break;

      case 'clear':
        this.bodyEl.innerHTML = `
          <div class="terminal-line"><span class="terminal-success">Terminal cleared. Type 'help' for options.</span></div>
        `;
        break;

      default:
        this.appendLine(cmd, `
          <span style="color:#ff5f56;">Command not recognized: '${cmd}'. Type <span class="terminal-accent">'help'</span> for command list.</span>
        `);
        break;
    }
  }
}

document.addEventListener('DOMContentLoaded', () => {
  window.devTerminal = new DeveloperTerminal();
});
