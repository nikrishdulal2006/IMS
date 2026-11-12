<?php
$pageTitle = 'IMS Nepal | Inventory and Sales Management';
$currentPage = 'home';
$bodyClass = '';
require __DIR__ . '/includes/header.php';
?>

    <main>
        <section class="hero-band">
            <div class="hero home-hero">
                <div class="hero-copy">
                    <p class="eyebrow"><span class="eyebrow-mark"></span> FOR SHOP OWNERS AND STAFF</p>
                    <h1>A sale shouldn't leave your stock list out of date.</h1>
                    <p class="hero-description">
                        Record a sale once. IMS deducts the quantity, saves the bill, and keeps the sale in your reports.
                    </p>
                    <div class="hero-actions">
                        <a class="button" href="../signin.php?action=register">Create your account <span aria-hidden="true">→</span></a>
                        <a class="button button-secondary" href="#features">Explore the features</a>
                    </div>
                </div>

                <figure class="sale-flow">
                    <figcaption>
                        <span class="sale-flow-kicker">THE EVERYDAY WORKFLOW</span>
                        <strong>One sale. Updated records.</strong>
                    </figcaption>
                    <ol>
                        <li><span class="sale-flow-number">01</span><span><strong>Record the sale</strong><small>Add the product, quantity, and customer.</small></span></li>
                        <li><span class="sale-flow-number">02</span><span><strong>Stock adjusts</strong><small>Inventory reflects the quantity sold.</small></span></li>
                        <li><span class="sale-flow-number">03</span><span><strong>Review it later</strong><small>Find the sale in your reports and bill history.</small></span></li>
                    </ol>
                    <div class="sale-flow-foot"><span aria-hidden="true"></span>SALE TO STOCK TO REPORTS</div>
                </figure>
            </div>
        </section>

        <section class="feature-section" id="features">
            <div class="section-heading">
                <p class="eyebrow"><span class="eyebrow-mark"></span> INVENTORY, SALES, REPORTS</p>
                <h2>The details your shop needs to keep straight.</h2>
                <p class="section-intro">A practical set of tools for keeping product records current and checking what has sold.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card" id="inventory">
                    <span class="feature-index">01 / INVENTORY</span>
                    <h3>Know what is on the shelf</h3>
                    <p>Keep each product's ID, price, and quantity together. Update counts when stock arrives or changes.</p>
                    <a href="about.php#stock">How stock tracking works <span aria-hidden="true">→</span></a>
                </article>
                <article class="feature-card" id="sales">
                    <span class="feature-index">02 / SALES</span>
                    <h3>Finish the sale and the paperwork</h3>
                    <p>Save the product, quantity, customer, and staff details. Print a bill with the 13% VAT breakdown.</p>
                    <a href="about.php#sales">What a sale records <span aria-hidden="true">→</span></a>
                </article>
                <article class="feature-card" id="reports">
                    <span class="feature-index">03 / REPORTS</span>
                    <h3>Find sales and low stock</h3>
                    <p>Review sales by date, product, or staff member. Low-stock alerts flag items with 10 units or fewer.</p>
                    <a href="about.php#reports">What reports include <span aria-hidden="true">→</span></a>
                </article>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
