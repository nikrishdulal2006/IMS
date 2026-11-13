<?php
$pageTitle = 'About IMS Nepal';
$currentPage = 'about';
require __DIR__ . '/includes/header.php';
?>

<main class="container about-page">
    <section class="info-hero about-hero" aria-labelledby="about-title">
        <div class="about-copy">
            <p class="info-hero-eyebrow"><mark></mark>About IMS Nepal</p>
            <h1 id="about-title">A clearer way to run the day-to-day.</h1>
            <p>IMS Nepal helps shop owners and staff keep product details, stock, and sales records connected. Record a sale, update stock automatically, and keep the information you need close at hand.</p>
            <div class="about-actions">
                <a class="btn-primary" href="../signin.php?action=register">Create your account &rarr;</a>
                <a class="text-link" href="contact.php">Talk to us</a>
            </div>
        </div>
        <figure class="about-visual">
            <img src="assets/warehouse-login.jpg" alt="Shelves of products organized in a warehouse">
            <figcaption>
                <span>PRODUCTS TO SALES</span>
                <strong>Keep the records connected.</strong>
            </figcaption>
        </figure>
    </section>

    <section class="section about-workflow" aria-labelledby="workflow-title">
        <div class="section-heading">
            <p class="section-kicker">How it works</p>
            <h2 id="workflow-title">One connected workflow.</h2>
            <p>Move from keeping stock in order to understanding what is selling.</p>
        </div>
        <div class="workflow-grid">
            <article class="workflow-card" id="stock">
                <span class="workflow-number">01 / STOCK</span>
                <h3>Start with reliable product records.</h3>
                <p>Keep each product's name, ID, category, price, and quantity in one place. Update counts when deliveries arrive or stock changes.</p>
            </article>
            <article class="workflow-card" id="sales">
                <span class="workflow-number">02 / SALES</span>
                <h3>Record each sale as it happens.</h3>
                <p>Save the product, quantity, customer, and staff details. IMS updates stock automatically and lets you print a bill with 13% VAT.</p>
            </article>
            <article class="workflow-card" id="reports">
                <span class="workflow-number">03 / REPORTS</span>
                <h3>See the details that matter.</h3>
                <p>Review sales by date, product, or staff member. Low-stock alerts flag products with 10 units or fewer.</p>
            </article>
        </div>
    </section>

    <section class="about-cta" aria-labelledby="about-cta-title">
        <div>
            <p class="section-kicker">Questions about IMS?</p>
            <h2 id="about-cta-title">We&rsquo;re happy to help.</h2>
            <p>Get in touch to learn more about managing your shop with IMS Nepal.</p>
        </div>
        <a class="btn-primary" href="contact.php">Contact us &rarr;</a>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
