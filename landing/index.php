<?php
$pageTitle = 'IMS Nepal | Inventory and Sales Management';
$currentPage = 'home';
$bodyClass = 'home-page';
require __DIR__ . '/includes/header.php';
?>

    <main>
        <section class="hero-band">
            <div class="hero">
                <div class="hero-copy">
                    <p class="eyebrow"><span class="eyebrow-mark"></span> Inventory and sales for local shops</p>
                    <h1>Record a sale. Keep stock current.</h1>
                    <p class="hero-description">
                        IMS logs the sale, updates its stock, and keeps the bill and report together.
                    </p>
                    <div class="hero-actions">
                        <a class="button" href="../signin.php?action=register">Create your account <span aria-hidden="true">→</span></a>
                        <a class="button button-secondary" href="#features">See how it works</a>
                    </div>
                </div>

                <figure class="sale-preview">
                    <figcaption><span>Example sale</span><strong>Sale details</strong></figcaption>
                    <div class="sale-preview-fields" role="img" aria-label="Illustrative IMS sale entry for two units of basmati rice at 850 rupees each, with 13 percent VAT">
                        <div class="sale-preview-field sale-preview-customer">
                            <span>Customer name</span>
                            <strong>Walk-in customer</strong>
                        </div>
                        <div class="sale-preview-field sale-preview-product">
                            <span>Product</span>
                            <strong>Basmati rice <small>Stock: 24</small></strong>
                        </div>
                        <div class="sale-preview-field">
                            <span>Quantity</span>
                            <strong>2</strong>
                        </div>
                        <div class="sale-preview-field">
                            <span>Unit price</span>
                            <strong>Rs. 850.00</strong>
                        </div>
                    </div>
                    <div class="sale-preview-total">
                        <div><span>Subtotal</span><strong>Rs. 1,700.00</strong></div>
                        <div><span>VAT 13%</span><strong>Rs. 221.00</strong></div>
                        <div class="sale-preview-grand-total"><span>Total</span><strong>Rs. 1,921.00</strong></div>
                    </div>
                    <div class="sale-preview-foot"><span>After the sale</span><strong>Stock: 22</strong></div>
                </figure>
            </div>
        </section>

        <section class="feature-section" id="features">
            <div class="section-heading">
                <p class="eyebrow"><span class="eyebrow-mark"></span> The everyday essentials</p>
                <h2>Products, sales, and the details around them.</h2>
                <p class="section-intro">Keep stock counts current, print bills, and check what has sold.</p>
            </div>
            <div class="feature-grid">
                <article class="feature-card" id="inventory">
                    <span class="feature-index">01 / Inventory</span>
                    <h3>Product and stock records</h3>
                    <p>Keep each product's ID, category, price, and quantity together. Update counts when stock arrives or changes.</p>
                    <a href="about.php#stock">About stock tracking <span aria-hidden="true">→</span></a>
                </article>
                <article class="feature-card" id="sales">
                    <span class="feature-index">02 / Sales</span>
                    <h3>Sales and printable bills</h3>
                    <p>Save the product, quantity, customer, and staff details. Print a bill with the 13% VAT breakdown.</p>
                    <a href="about.php#sales">About recording sales <span aria-hidden="true">→</span></a>
                </article>
                <article class="feature-card" id="reports">
                    <span class="feature-index">03 / Reports and alerts</span>
                    <h3>Sales reports and stock alerts</h3>
                    <p>Review sales by date, product, or staff member. Low-stock alerts flag items with 10 units or fewer.</p>
                    <a href="about.php#reports">About reports and alerts <span aria-hidden="true">→</span></a>
                </article>
            </div>
        </section>
    </main>

<?php require __DIR__ . '/includes/footer.php'; ?>
