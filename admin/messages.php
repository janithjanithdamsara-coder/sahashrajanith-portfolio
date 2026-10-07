<?php
require_once __DIR__ . '/header.php';

$successMsg = '';
$messages = &$portfolioData['messages'];
if (!is_array($messages)) $messages = [];

// Delete Message Action
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $deleteId = $_GET['id'];
    $messages = array_filter($messages, function($m) use ($deleteId) {
        return $m['id'] !== $deleteId;
    });
    $portfolioData['messages'] = array_values($messages);
    save_portfolio_data($portfolioData);
    $successMsg = 'Message deleted.';
}

// Mark Read / Unread Action
if (isset($_GET['action']) && $_GET['action'] === 'toggle_read' && isset($_GET['id'])) {
    $targetId = $_GET['id'];
    foreach ($messages as &$m) {
        if ($m['id'] === $targetId) {
            $m['read'] = empty($m['read']);
            break;
        }
    }
    save_portfolio_data($portfolioData);
    $successMsg = 'Message status updated.';
}
?>

<?php if (!empty($successMsg)): ?>
  <div class="alert-success">
    <i class="fa-solid fa-circle-check"></i> <?php echo htmlspecialchars($successMsg); ?>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-title">
    <i class="fa-solid fa-inbox"></i> Client Contact Messages Inbox (<?php echo count($messages); ?>)
  </div>

  <?php if (empty($messages)): ?>
    <div style="text-align:center; padding:40px; color:var(--text-dim);">
      <i class="fa-regular fa-envelope-open" style="font-size:48px; margin-bottom:12px;"></i>
      <p>No contact messages yet. Submissions from the website form will show up here instantly!</p>
    </div>
  <?php else: ?>
    <div style="display:flex; flex-direction:column; gap:16px;">
      <?php foreach ($messages as $msg): ?>
        <div style="background:#1e293b; border:1px solid <?php echo empty($msg['read']) ? 'var(--accent)' : 'var(--border-color)'; ?>; border-radius:12px; padding:20px;">
          
          <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px; margin-bottom:12px;">
            <div>
              <div style="display:flex; align-items:center; gap:8px;">
                <h3 style="font-size:16px; font-weight:700; color:var(--text-main);"><?php echo htmlspecialchars($msg['name']); ?></h3>
                <?php if (empty($msg['read'])): ?>
                  <span style="background:#ef4444; color:#fff; padding:2px 8px; border-radius:4px; font-size:10px; font-weight:800;">UNREAD</span>
                <?php endif; ?>
              </div>
              <div style="font-size:13px; color:var(--accent); margin-top:2px;">
                <i class="fa-solid fa-envelope"></i> <?php echo htmlspecialchars($msg['email']); ?>
              </div>
            </div>

            <div style="font-size:12px; color:var(--text-dim); text-align:right;">
              <i class="fa-regular fa-clock"></i> <?php echo htmlspecialchars($msg['date']); ?>
            </div>
          </div>

          <div style="font-size:14px; font-weight:600; color:#cbd5e1; margin-bottom:8px;">
            Subject: <?php echo htmlspecialchars($msg['subject']); ?>
          </div>

          <div style="background:#0f172a; border-radius:8px; padding:14px; font-size:14px; color:#e2e8f0; line-height:1.5; margin-bottom:14px; white-space:pre-wrap; font-family:sans-serif;">
            <?php echo htmlspecialchars($msg['message']); ?>
          </div>

          <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px;">
            <div style="display:flex; gap:10px;">
              <!-- Email Reply -->
              <a href="mailto:<?php echo htmlspecialchars($msg['email']); ?>?subject=Re: <?php echo urlencode($msg['subject']); ?>" class="btn-save" style="padding:7px 14px; font-size:12px;">
                <i class="fa-solid fa-reply"></i> Reply via Email
              </a>

              <!-- WhatsApp Reply if available -->
              <a href="https://wa.me/?text=Hi%20<?php echo urlencode($msg['name']); ?>%2C%20regarding%20your%20inquiry..." target="_blank" style="padding:7px 14px; font-size:12px; background:#10b981; color:#fff; text-decoration:none; border-radius:8px; font-weight:700; display:inline-flex; align-items:center; gap:6px;">
                <i class="fa-brands fa-whatsapp"></i> WhatsApp Reply
              </a>
            </div>

            <div style="display:flex; gap:10px; align-items:center;">
              <a href="messages.php?action=toggle_read&id=<?php echo urlencode($msg['id']); ?>" style="color:var(--text-dim); font-size:12px; text-decoration:none;">
                <i class="fa-solid fa-eye<?php echo empty($msg['read']) ? '' : '-slash'; ?>"></i> Mark as <?php echo empty($msg['read']) ? 'Read' : 'Unread'; ?>
              </a>
              <a href="messages.php?action=delete&id=<?php echo urlencode($msg['id']); ?>" onclick="return confirm('Delete this message?');" class="btn-danger">
                <i class="fa-solid fa-trash"></i> Delete
              </a>
            </div>
          </div>

        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
