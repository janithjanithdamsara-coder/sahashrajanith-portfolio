<?php
require_once __DIR__ . '/header.php';

$successMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $portfolioData['hero']['name'] = trim($_POST['name'] ?? '');
    $portfolioData['hero']['title'] = trim($_POST['title'] ?? '');
    $portfolioData['hero']['tagline'] = trim($_POST['tagline'] ?? '');
    $portfolioData['hero']['subtitle'] = trim($_POST['subtitle'] ?? '');
    $portfolioData['hero']['availability'] = trim($_POST['availability'] ?? '');
    $portfolioData['hero']['email'] = trim($_POST['email'] ?? '');
    $portfolioData['hero']['phone'] = trim($_POST['phone'] ?? '');
    $portfolioData['hero']['location'] = trim($_POST['location'] ?? '');
    $portfolioData['hero']['github'] = trim($_POST['github'] ?? '');
    $portfolioData['hero']['linkedin'] = trim($_POST['linkedin'] ?? '');
    $portfolioData['hero']['whatsapp'] = trim($_POST['whatsapp'] ?? '');
    $portfolioData['hero']['about_text_1'] = trim($_POST['about_text_1'] ?? '');
    $portfolioData['hero']['about_text_2'] = trim($_POST['about_text_2'] ?? '');

    save_portfolio_data($portfolioData);
    $successMsg = 'Hero profile details updated successfully!';
}

$hero = $portfolioData['hero'] ?? [];
?>

<?php if (!empty($successMsg)): ?>
  <div class="alert-success">
    <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($successMsg); ?>
  </div>
<?php endif; ?>

<form method="POST" action="hero.php">
  <div class="card">
    <div class="card-title"><i class="fa-solid fa-id-card"></i> Personal Profile & Hero Header</div>
    
    <div class="form-grid">
      <div class="form-group">
        <label>Full Name</label>
        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($hero['name'] ?? ''); ?>" required />
      </div>

      <div class="form-group">
        <label>Professional Title</label>
        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($hero['title'] ?? ''); ?>" required />
      </div>

      <div class="form-group">
        <label>Tagline / Cert Badge</label>
        <input type="text" name="tagline" class="form-control" value="<?php echo htmlspecialchars($hero['tagline'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>Availability Status</label>
        <input type="text" name="availability" class="form-control" value="<?php echo htmlspecialchars($hero['availability'] ?? ''); ?>" />
      </div>
    </div>

    <div class="form-group">
      <label>Hero Subtitle / Description</label>
      <textarea name="subtitle" class="form-control"><?php echo htmlspecialchars($hero['subtitle'] ?? ''); ?></textarea>
    </div>
  </div>

  <div class="card">
    <div class="card-title"><i class="fa-solid fa-address-book"></i> Contact Details & Social Links</div>

    <div class="form-grid">
      <div class="form-group">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($hero['email'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>Phone / Mobile</label>
        <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($hero['phone'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>Location</label>
        <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($hero['location'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>GitHub Profile URL</label>
        <input type="url" name="github" class="form-control" value="<?php echo htmlspecialchars($hero['github'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>LinkedIn Profile URL</label>
        <input type="url" name="linkedin" class="form-control" value="<?php echo htmlspecialchars($hero['linkedin'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>WhatsApp Contact Link</label>
        <input type="url" name="whatsapp" class="form-control" value="<?php echo htmlspecialchars($hero['whatsapp'] ?? ''); ?>" />
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-title"><i class="fa-solid fa-file-user"></i> About Me Bio Content</div>

    <div class="form-group">
      <label>Bio Paragraph 1</label>
      <textarea name="about_text_1" class="form-control"><?php echo htmlspecialchars($hero['about_text_1'] ?? ''); ?></textarea>
    </div>

    <div class="form-group">
      <label>Bio Paragraph 2</label>
      <textarea name="about_text_2" class="form-control"><?php echo htmlspecialchars($hero['about_text_2'] ?? ''); ?></textarea>
    </div>
  </div>

  <button type="submit" class="btn-save">
    <i class="fa-solid fa-floppy-disk"></i> Save Profile Changes
  </button>
</form>

<?php require_once __DIR__ . '/footer.php'; ?>
