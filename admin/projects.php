<?php
require_once __DIR__ . '/header.php';

$successMsg = '';
$projects = &$portfolioData['projects'];
if (!is_array($projects)) $projects = [];

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteId = $_GET['id'];
    $projects = array_filter($projects, function($p) use ($deleteId) {
        return $p['id'] !== $deleteId;
    });
    $portfolioData['projects'] = array_values($projects);
    save_portfolio_data($portfolioData);
    $successMsg = 'Project deleted successfully.';
}

// Handle Add / Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $editId = trim($_POST['project_id'] ?? '');
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? 'fullstack');
    $desc = trim($_POST['desc'] ?? '');
    $longDesc = trim($_POST['longDesc'] ?? '');
    $demoUrl = trim($_POST['demoUrl'] ?? '');
    $githubUrl = trim($_POST['githubUrl'] ?? '');
    $tagsRaw = trim($_POST['tags'] ?? '');
    $tags = array_map('trim', explode(',', $tagsRaw));

    // Handle Image Upload / Select
    $image = trim($_POST['image'] ?? '');
    if (!empty($_POST['image_select'])) {
        $image = trim($_POST['image_select']);
    }

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../assets/images/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = preg_replace('/[^a-zA-Z0-9_.-]/', '_', basename($_FILES['image_file']['name']));
        $targetFile = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetFile)) {
            $image = 'assets/images/' . $fileName;
        }
    }

    if (empty($image)) {
        $image = 'assets/images/project_creative_web.jpg';
    }

    if (!empty($title)) {
        if (!empty($editId)) {
            // Edit existing
            foreach ($projects as &$p) {
                if ($p['id'] === $editId) {
                    $p['title'] = $title;
                    $p['category'] = $category;
                    $p['desc'] = $desc;
                    $p['longDesc'] = $longDesc;
                    $p['image'] = $image;
                    $p['demoUrl'] = $demoUrl;
                    $p['githubUrl'] = $githubUrl;
                    $p['tags'] = $tags;
                    break;
                }
            }
            $successMsg = 'Project updated successfully!';
        } else {
            // Add new
            $newId = 'proj_' . time();
            $projects[] = [
                'id' => $newId,
                'title' => $title,
                'category' => $category,
                'desc' => $desc,
                'longDesc' => $longDesc,
                'image' => $image,
                'tags' => $tags,
                'demoUrl' => $demoUrl,
                'githubUrl' => $githubUrl
            ];
            $successMsg = 'New project added successfully!';
        }
        $portfolioData['projects'] = array_values($projects);
        save_portfolio_data($portfolioData);
    }
}

// Fetch item to edit if requested
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    foreach ($projects as $p) {
        if ($p['id'] === $_GET['id']) {
            $editItem = $p;
            break;
        }
    }
}

// Fetch all available assets in assets/images/
$availableAssets = [];
$assetFiles = glob(__DIR__ . '/../assets/images/*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
if (is_array($assetFiles)) {
    foreach ($assetFiles as $file) {
        $availableAssets[] = 'assets/images/' . basename($file);
    }
}
?>

<?php if (!empty($successMsg)): ?>
  <div class="alert-success">
    <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($successMsg); ?>
  </div>
<?php endif; ?>

<!-- Form to Add/Edit Project -->
<div class="card">
  <div class="card-title">
    <i class="fa-solid fa-square-plus"></i> <?php echo $editItem ? 'Edit Project: ' . htmlspecialchars($editItem['title']) : 'Add New Portfolio Project'; ?>
  </div>

  <form method="POST" action="projects.php" enctype="multipart/form-data">
    <input type="hidden" name="project_id" value="<?php echo htmlspecialchars($editItem['id'] ?? ''); ?>" />

    <div class="form-grid">
      <div class="form-group">
        <label>Project Title</label>
        <input type="text" name="title" class="form-control" placeholder="e.g. Zenith LMS Portal" value="<?php echo htmlspecialchars($editItem['title'] ?? ''); ?>" required />
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category" class="form-control">
          <option value="fullstack" <?php echo ($editItem['category'] ?? '') === 'fullstack' ? 'selected' : ''; ?>>Fullstack & LMS</option>
          <option value="ecom" <?php echo ($editItem['category'] ?? '') === 'ecom' ? 'selected' : ''; ?>>E-Commerce</option>
          <option value="frontend" <?php echo ($editItem['category'] ?? '') === 'frontend' ? 'selected' : ''; ?>>Web Portals & Frontend</option>
          <option value="mobile" <?php echo ($editItem['category'] ?? '') === 'mobile' ? 'selected' : ''; ?>>Android Mobile Apps</option>
        </select>
      </div>

      <div class="form-group">
        <label>Live Demo URL</label>
        <input type="url" name="demoUrl" class="form-control" placeholder="https://exampro.site/" value="<?php echo htmlspecialchars($editItem['demoUrl'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>GitHub Repository URL</label>
        <input type="url" name="githubUrl" class="form-control" placeholder="https://github.com/sahashrajanith/..." value="<?php echo htmlspecialchars($editItem['githubUrl'] ?? ''); ?>" />
      </div>

      <div class="form-group">
        <label>Tags (Comma Separated)</label>
        <input type="text" name="tags" class="form-control" placeholder="PHP, MySQL, Android, LMS" value="<?php echo htmlspecialchars(isset($editItem['tags']) ? implode(', ', $editItem['tags']) : ''); ?>" />
      </div>

      <div class="form-group">
        <label><i class="fa-solid fa-images"></i> Select Image Asset from Server</label>
        <select name="image_select" class="form-control" id="imageSelect">
          <option value="">-- Choose Existing Asset --</option>
          <?php foreach ($availableAssets as $asset): ?>
            <option value="<?php echo htmlspecialchars($asset); ?>" <?php echo ($editItem['image'] ?? '') === $asset ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($asset); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
    </div>

    <div class="form-grid" style="margin-top:16px;">
      <div class="form-group">
        <label><i class="fa-solid fa-file-arrow-up"></i> Or Upload New Image File</label>
        <input type="file" name="image_file" class="form-control" accept="image/*" />
      </div>

      <div class="form-group">
        <label>Or Type Custom Asset Path</label>
        <input type="text" name="image" id="imagePathInput" class="form-control" value="<?php echo htmlspecialchars($editItem['image'] ?? 'assets/images/project_creative_web.jpg'); ?>" />
      </div>
    </div>

    <div class="form-group">
      <label>Short Description (Shown on card)</label>
      <input type="text" name="desc" class="form-control" value="<?php echo htmlspecialchars($editItem['desc'] ?? ''); ?>" required />
    </div>

    <div class="form-group">
      <label>Detailed Description (Modal Popup)</label>
      <textarea name="longDesc" class="form-control"><?php echo htmlspecialchars($editItem['longDesc'] ?? ''); ?></textarea>
    </div>

    <button type="submit" class="btn-save">
      <i class="fa-solid fa-floppy-disk"></i> <?php echo $editItem ? 'Update Project' : 'Add Project to Portfolio'; ?>
    </button>

    <?php if ($editItem): ?>
      <a href="projects.php" style="margin-left:12px; font-size:13px; color:var(--text-dim); text-decoration:none;">Cancel Edit</a>
    <?php endif; ?>
  </form>
</div>

<!-- List of Existing Projects -->
<div class="card">
  <div class="card-title"><i class="fa-solid fa-list-check"></i> Live Projects Portfolio (<?php echo count($projects); ?>)</div>

  <div class="table-responsive">
    <table class="table-to-cards">
      <thead>
        <tr>
          <th>Title</th>
          <th>Category</th>
          <th>Demo Link</th>
          <th>Tags</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($projects as $p): ?>
          <tr>
            <td data-label="Title" style="font-weight:700; color:var(--text-main);">
              <?php echo htmlspecialchars($p['title']); ?>
            </td>
            <td data-label="Category">
              <span style="background:rgba(0,242,254,0.1); color:var(--accent); padding:4px 8px; border-radius:6px; font-size:12px; font-weight:600;">
                <?php echo htmlspecialchars(strtoupper($p['category'])); ?>
              </span>
            </td>
            <td data-label="Demo Link">
              <?php if (!empty($p['demoUrl'])): ?>
                <a href="<?php echo htmlspecialchars($p['demoUrl']); ?>" target="_blank" style="color:var(--accent); font-size:13px;"><i class="fa-solid fa-arrow-up-right-from-square"></i> Visit</a>
              <?php else: ?>
                <span style="color:var(--text-dim);">-</span>
              <?php endif; ?>
            </td>
            <td data-label="Tags" style="font-size:12px; color:var(--text-dim);">
              <?php echo htmlspecialchars(implode(', ', $p['tags'] ?? [])); ?>
            </td>
            <td data-label="Actions">
              <a href="projects.php?action=edit&id=<?php echo urlencode($p['id']); ?>" style="color:var(--accent); font-weight:600; font-size:13px; margin-right:12px; text-decoration:none;"><i class="fa-solid fa-pen"></i> Edit</a>
              <a href="projects.php?action=delete&id=<?php echo urlencode($p['id']); ?>" onclick="return confirm('Are you sure you want to delete this project?');" class="btn-danger"><i class="fa-solid fa-trash"></i> Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
