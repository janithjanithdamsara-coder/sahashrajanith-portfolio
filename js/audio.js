/* ==========================================================================
   AUDIO CONTROLLER (MUTED BY DEFAULT - NO SOUND EFFECTS)
   ========================================================================== */

class AudioController {
  constructor() {
    this.isMuted = true;
  }

  init() {}
  getAudioContext() { return null; }
  toggleSound() {}
  playHoverSound() { return; }
  playClickSound() { return; }
  playKeySound() { return; }
  playKeystrokeSound() { return; }
}

document.addEventListener('DOMContentLoaded', () => {
  window.soundFx = new AudioController();
  window.audioController = window.soundFx;
});
