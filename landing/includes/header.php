<?php
$pages = [
    'home' => ['label' => 'Home', 'href' => 'index.php'],
    'about' => ['label' => 'About', 'href' => 'about.php'],
    'contact' => ['label' => 'Contact', 'href' => 'contact.php'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($pageTitle, ENT_QUOTES, 'UTF-8'); ?></title>
    <link rel="stylesheet" href="css/landing.css?v=6">
    <?php foreach (($extraStyles ?? []) as $stylesheet): ?>
        <link rel="stylesheet" href="<?php echo htmlspecialchars($stylesheet, ENT_QUOTES, 'UTF-8'); ?>">
    <?php endforeach; ?>
</head>
<body>
    <header class="site-header">
        <div class="header-inner">
            <a class="wordmark" href="index.php" aria-label="IMS Nepal home">
                IMS <span>Nepal</span>
            </a>
            <nav class="nav-links" aria-label="Main navigation">
                <?php foreach ($pages as $key => $page): ?>
                    <a href="<?php echo $page['href']; ?>"<?php echo $currentPage === $key ? ' aria-current="page"' : ''; ?>><?php echo $page['label']; ?></a>
                <?php endforeach; ?>
            </nav>
            <div class="header-actions">
                <a class="btn-outline" href="../signin.php">Sign in</a>
                <a class="btn-primary" href="../signin.php?action=register">Create account</a>
            </div>
        </div>
    </header>