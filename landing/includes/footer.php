<?php
$footerLinks = $currentPage === 'home'
    ? [
        ['href' => '#features', 'label' => 'Features'],
        ['href' => 'about.php', 'label' => 'About'],
        ['href' => 'contact.php', 'label' => 'Contact'],
    ]
    : [
        ['href' => 'index.php', 'label' => 'Home'],
        ['href' => 'about.php', 'label' => 'About'],
        ['href' => 'contact.php', 'label' => 'Contact'],
    ];
?>
    <footer class="site-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <a class="wordmark" href="index.php">IMS <span>Nepal</span></a>
                <p>Products, stock, sales, and reports in one place.</p>
            </div>
            <div class="footer-links">
                <?php foreach ($footerLinks as $link): ?>
                    <a href="<?php echo $link['href']; ?>"><?php echo $link['label']; ?></a>
                <?php endforeach; ?>
                <a href="../signin.php">Sign in</a>
            </div>
        </div>
    </footer>
</body>
</html>