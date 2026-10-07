<?php
require_once __DIR__ . '/header.php';

$successMsg = '';
$skills = &$portfolioData['skills'];
if (!is_array($skills)) $skills = [];

// Handle Delete Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteId = $_GET['id'];
    $skills = array_filter($skills, function($s) use ($deleteId) {
        return ($s['id'] ?? $s['name']) !== $deleteId;
    });
    $portfolioData['skills'] = array_values($skills);
    save_portfolio_data($portfolioData);
    $successMsg = 'Skill removed successfully.';
}

// Handle Add / Edit Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skillId = trim($_POST['skill_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $level = intval($_POST['level'] ?? 90);
    $category = trim($_POST['category'] ?? 'backend');
    $badge = trim($_POST['badge'] ?? 'Expert');

    if (!empty($name)) {
        if (!empty($skillId)) {
            // Edit existing
            foreach ($skills as &$s) {
                if (($s['id'] ?? $s['name']) === $skillId) {
                    $s['name'] = $name;
                    $s['level'] = $level;
                    $s['category'] = $category;
                    $s['badge'] = $badge;
                    break;
                }
            }
            $successMsg = 'Skill updated successfully!';
        } else {
            // Add new
            $newId = 's_' . time();
            $skills[] = [
                'id' => $newId,
                'name' => $name,
                'level' => $level,
                'category' => $category,
                'badge' => $badge
            ];
            $successMsg = 'New skill added!';
        }
        $portfolioData['skills'] = array_values($skills);
        save_portfolio_data($portfolioData);
    }
}

// Fetch item to edit if requested
$editItem = null;
if (isset($_GET['action']) && $_GET['action'] === 'edit' && isset($_GET['id'])) {
    foreach ($skills as $s) {
        if (($s['id'] ?? $s['name']) === $_GET['id']) {
            $editItem = $s;
            break;
        }
    }
}
?>

<?php if (!empty($successMsg)): ?>
  <div class="alert-success">
    <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($successMsg); ?>
  </div>
<?php endif; ?>

<!-- Add / Edit Skill Form -->
<div class="card">
  <div class="card-title">
    <i class="fa-solid fa-square-plus"></i> <?php echo $editItem ? 'Edit Skill: ' . htmlspecialchars($editItem['name']) : 'Add New Skill to Matrix'; ?>
  </div>

  <form method="POST" action="skills.php">
    <input type="hidden" name="skill_id" value="<?php echo htmlspecialchars($editItem['id'] ?? $editItem['name'] ?? ''); ?>" />

    <div class="form-grid">
      <div class="form-group">
        <label>Skill / Technology Name</label>
        <input type="text" name="name" class="form-control" placeholder="e.g. Node.js & REST APIs" value="<?php echo htmlspecialchars($editItem['name'] ?? ''); ?>" required />
      </div>

      <div class="form-group">
        <label>Proficiency Level (%)</label>
        <input type="number" min="1" max="100" name="level" class="form-control" placeholder="90" value="<?php echo htmlspecialchars($editItem['level'] ?? 90); ?>" required />
      </div>

      <div class="form-group">
        <label>Category</label>
        <select name="category" class="form-control">
          <option value="backend" <?php echo ($editItem['category'] ?? '') === 'backend' ? 'selected' : ''; ?>>Backend & Database</option>
          <option value="frontend" <?php echo ($editItem['category'] ?? '') === 'frontend' ? 'selected' : ''; ?>>Frontend & Web</option>
          <option value="3d" <?php echo ($editItem['category'] ?? '') === '3d' ? 'selected' : ''; ?>>3D & Motion Graphics</option>
          <option value="tools" <?php echo ($editItem['category'] ?? '') === 'tools' ? 'selected' : ''; ?>>Mobile & Dev Tools</option>
        </select>
      </div>

      <div class="form-group">
        <label>Badge Label</label>
        <select name="badge" class="form-control">
          <option value="Master" <?php echo ($editItem['badge'] ?? '') === 'Master' ? 'selected' : ''; ?>>Master</option>
          <option value="Expert" <?php echo ($editItem['badge'] ?? '') === 'Expert' ? 'selected' : ''; ?>>Expert</option>
          <option value="Advanced" <?php echo ($editItem['badge'] ?? '') === 'Advanced' ? 'selected' : ''; ?>>Advanced</option>
          <option value="Certified" <?php echo ($editItem['badge'] ?? '') === 'Certified' ? 'selected' : ''; ?>>Certified</option>
        </select>
      </div>
    </div>

    <button type="submit" class="btn-save">
      <i class="fa-solid fa-floppy-disk"></i> <?php echo $editItem ? 'Update Skill' : 'Add Skill'; ?>
    </button>

    <?php if ($editItem): ?>
      <a href="skills.php" style="margin-left:12px; font-size:13px; color:var(--text-dim); text-decoration:none;">Cancel Edit</a>
    <?php endif; ?>
  </form>
</div>

<!-- List of Existing Skills -->
<div class="card">
  <div class="card-title"><i class="fa-solid fa-layer-group"></i> Current Skill Matrix (<?php echo count($skills); ?>)</div>

  <div class="table-responsive">
    <table class="table-to-cards">
      <thead>
        <tr>
          <th>Skill Name</th>
          <th>Category</th>
          <th>Proficiency</th>
          <th>Badge</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($skills as $s): ?>
          <?php $sid = $s['id'] ?? $s['name']; ?>
          <tr>
            <td data-label="Skill Name" style="font-weight:700; color:var(--text-main);"><?php echo htmlspecialchars($s['name']); ?></td>
            <td data-label="Category">
              <span style="background:rgba(255,255,255,0.06); color:var(--text-dim); padding:4px 8px; border-radius:6px; font-size:12px;">
                <?php echo htmlspecialchars(strtoupper($s['category'])); ?>
              </span>
            </td>
            <td data-label="Proficiency">
              <div style="display:flex; align-items:center; gap:8px;">
                <div style="flex:1; max-width:100px; height:6px; background:#1e293b; border-radius:4px; overflow:hidden;">
                  <div style="width:<?php echo $s['level']; ?>%; height:100%; background:var(--accent);"></div>
                </div>
                <span style="font-size:12px; font-weight:700;"><?php echo $s['level']; ?>%</span>
              </div>
            </td>
            <td data-label="Badge">
              <span style="background:rgba(0,242,254,0.15); color:var(--accent); padding:2px 8px; border-radius:4px; font-size:11px; font-weight:700;">
                <?php echo htmlspecialchars($s['badge']); ?>
              </span>
            </td>
            <td data-label="Actions">
              <a href="skills.php?action=edit&id=<?php echo urlencode($sid); ?>" style="color:var(--accent); font-weight:600; font-size:13px; margin-right:12px; text-decoration:none;"><i class="fa-solid fa-pen"></i> Edit</a>
              <a href="skills.php?action=delete&id=<?php echo urlencode($sid); ?>" onclick="return confirm('Delete this skill?');" class="btn-danger"><i class="fa-solid fa-trash"></i> Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
