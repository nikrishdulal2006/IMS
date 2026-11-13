<?php
$pageTitle = 'IMS Nepal | Inventory and Sales Management';
$currentPage = 'home';
require __DIR__ . '/includes/header.php';
?>

<main class="container">
    <section class="hero home-hero">
        <div class="hero-copy">
            <p class="hero-eyebrow"><mark></mark>For local shops</p>
            <h1>Know what you have. Know what you sell.</h1>
            <p>Keep product records, sales, bills, and stock updates together with IMS Nepal.</p>
            <div class="hero-actions">
                <a class="btn-primary" href="../signin.php?action=register">Create your account &rarr;</a>
                <a class="btn-outline" href="#features">Explore features</a>
            </div>
        </div>
        <div class="hero-visual">
            <figure class="home-visual">
                <img src="assets/retail-checkout.jpg" alt="Shop owner helping a customer at checkout">
                <figcaption class="home-visual-note">
                    <span class="status-dot" aria-hidden="true"></span>
                    <span>
                        <strong>Sale recorded</strong>
                        <small>Stock updates automatically</small>
                    </span>
                </figcaption>
            </figure>
        </div>
    </section>

    <section class="section home-features" id="features" aria-labelledby="features-title">
        <div class="section-heading">
            <p class="section-kicker">The everyday essentials</p>
            <h2 id="features-title">A clearer view of your shop.</h2>
            <p>Bring the key parts of daily shopkeeping into one straightforward workflow.</p>
        </div>
        <div class="feature-grid">
            <article class="feature-card">
                <span class="feature-number">01</span>
                <h3>Keep stock organized</h3>
                <p>Store product IDs, categories, prices, and quantities together. Update counts when stock arrives or changes.</p>
                <a href="about.php#stock">Explore stock management &rarr;</a>
            </article>
            <article class="feature-card">
                <span class="feature-number">02</span>
                <h3>Record sales with confidence</h3>
                <p>Save product, quantity, customer, and staff details. Print bills with a clear 13% VAT breakdown.</p>
                <a href="about.php#sales">Explore sales &amp; billing &rarr;</a>
            </article>
            <article class="feature-card">
                <span class="feature-number">03</span>
                <h3>Stay informed</h3>
                <p>Review sales by date, product, or staff member, and spot low-stock items with alerts.</p>
                <a href="about.php#reports">Explore reports &amp; alerts &rarr;</a>
            </article>
        </div>
    </section>

    <section class="home-cta" aria-labelledby="home-cta-title">
        <div>
            <p class="section-kicker">A simpler way to stay on top of things</p>
            <h2 id="home-cta-title">Bring your daily records together.</h2>
        </div>
        <a class="btn-primary" href="../signin.php?action=register">Get started &rarr;</a>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
