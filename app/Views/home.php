<?php if (!empty($users)) {
    foreach ($users as $user): ?>
        <p><?= htmlspecialchars($user['name']) ?></p>
    <?php endforeach;
} ?>
