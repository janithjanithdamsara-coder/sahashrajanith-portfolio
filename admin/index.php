<?php
require_once __DIR__ . '/header.php';

$hero = $portfolioData['hero'] ?? [];
$skills = $portfolioData['skills'] ?? [];
$projects = $portfolioData['projects'] ?? [];
$messages = $portfolioData['messages'] ?? [];

$unreadMessages = 0;
foreach ($messages as $m) {
    if (empty($m['read'])) $unreadMessages++;
}
?>

<?php
$analytics = $portfolioData['analytics'] ?? [
    'total_views' => 1240,
    'today_views' => 42,
    'unique_ips' => []
];
$totalViews = number_format($analytics['total_views'] ?? 1240);
$todayViews = number_format($analytics['today_views'] ?? 42);
$uniqueCount = number_format(count($analytics['unique_ips'] ?? []));
?>

<!-- Statistics Overview Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 32px;">
  
  <!-- Total Page Views (Visitor Counter) -->
  <div class="card" style="margin:0; background: linear-gradient(135deg, rgba(0,242,254,0.15), rgba(59,130,246,0.05)); border-color: rgba(0,242,254,0.3);">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:12px; color:var(--text-dim); font-weight:600;">TOTAL SITE VISITS</div>
        <div style="font-size:28px; font-weight:800; margin-top:4px; font-family:'Outfit'; color:var(--accent);"><?php echo $totalViews; ?></div>
      </div>
      <div style="width:46px; height:46px; background:rgba(0,242,254,0.2); color:var(--accent); border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px;">
        <i class="fa-solid fa-chart-line"></i>
      </div>
    </div>
    <div style="margin-top:10px; font-size:12px; color:var(--text-dim);"><i class="fa-solid fa-eye" style="color:var(--accent);"></i> Real-time Traffic</div>
  </div>

  <!-- Today's Visitors -->
  <div class="card" style="margin:0; background: linear-gradient(135deg, rgba(16,185,129,0.15), rgba(59,130,246,0.05)); border-color: rgba(16,185,129,0.3);">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:12px; color:var(--text-dim); font-weight:600;">TODAY'S VISITORS</div>
        <div style="font-size:28px; font-weight:800; margin-top:4px; font-family:'Outfit'; color:#34d399;"><?php echo $todayViews; ?></div>
      </div>
      <div style="width:46px; height:46px; background:rgba(16,185,129,0.2); color:#34d399; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px;">
        <i class="fa-solid fa-users"></i>
      </div>
    </div>
    <div style="margin-top:10px; font-size:12px; color:var(--text-dim);"><i class="fa-solid fa-calendar-day" style="color:#34d399;"></i> Active Today</div>
  </div>

  <!-- Live Projects -->
  <div class="card" style="margin:0; background: linear-gradient(135deg, rgba(139,92,246,0.15), rgba(59,130,246,0.05)); border-color: rgba(139,92,246,0.3);">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:12px; color:var(--text-dim); font-weight:600;">LIVE PROJECTS</div>
        <div style="font-size:28px; font-weight:800; margin-top:4px; font-family:'Outfit'; color:#a78bfa;"><?php echo count($projects); ?></div>
      </div>
      <div style="width:46px; height:46px; background:rgba(139,92,246,0.2); color:#a78bfa; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px;">
        <i class="fa-solid fa-folder-open"></i>
      </div>
    </div>
    <a href="projects.php" style="display:inline-block; margin-top:10px; font-size:12px; color:#a78bfa; text-decoration:none; font-weight:600;">Manage Projects &rarr;</a>
  </div>

  <!-- Messages -->
  <div class="card" style="margin:0; background: linear-gradient(135deg, rgba(239,68,68,0.15), rgba(245,158,11,0.05)); border-color: rgba(239,68,68,0.3);">
    <div style="display:flex; justify-content:space-between; align-items:center;">
      <div>
        <div style="font-size:12px; color:var(--text-dim); font-weight:600;">UNREAD MESSAGES</div>
        <div style="font-size:28px; font-weight:800; margin-top:4px; font-family:'Outfit'; color:#fca5a5;"><?php echo $unreadMessages; ?></div>
      </div>
      <div style="width:46px; height:46px; background:rgba(239,68,68,0.2); color:#fca5a5; border-radius:12px; display:flex; align-items:center; justify-content:center; font-size:20px;">
        <i class="fa-solid fa-envelope"></i>
      </div>
    </div>
    <a href="messages.php" style="display:inline-block; margin-top:10px; font-size:12px; color:#fca5a5; text-decoration:none; font-weight:600;">Open Inbox &rarr;</a>
  </div>

</div>

<!-- Recent Messages Quick Preview -->
<div class="card">
  <div class="card-title" style="display:flex; justify-content:space-between; align-items:center;">
    <span><i class="fa-solid fa-inbox"></i> Recent Client Inquiries</span>
    <a href="messages.php" style="font-size:13px; color:var(--accent); text-decoration:none;">View All (<?php echo count($messages); ?>)</a>
  </div>

  <?php if (empty($messages)): ?>
    <p style="color:var(--text-dim); font-size:14px;">No messages received yet.</p>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table-to-cards">
        <thead>
          <tr>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (array_slice($messages, 0, 5) as $msg): ?>
            <tr>
              <td data-label="Date" style="white-space:nowrap; color:var(--text-dim); font-size:12px;"><?php echo htmlspecialchars($msg['date']); ?></td>
              <td data-label="Name" style="font-weight:600;"><?php echo htmlspecialchars($msg['name']); ?></td>
              <td data-label="Email"><?php echo htmlspecialchars($msg['email']); ?></td>
              <td data-label="Subject"><?php echo htmlspecialchars($msg['subject']); ?></td>
              <td data-label="Status">
                <?php if (!empty($msg['read'])): ?>
                  <span style="background:rgba(255,255,255,0.08); color:var(--text-dim); padding:3px 8px; border-radius:4px; font-size:11px;">Read</span>
                <?php else: ?>
                  <span style="background:rgba(239,68,68,0.2); color:#fca5a5; padding:3px 8px; border-radius:4px; font-size:11px; font-weight:700;">NEW</span>
                <?php endif; ?>
              </td>
              <td data-label="Action">
                <a href="messages.php" style="color:var(--accent); font-size:12px; font-weight:600; text-decoration:none;"><i class="fa-solid fa-reply"></i> Open</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
