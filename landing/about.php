<?php
/**
 * landing/about.php
 * What IMS Nepal is, the rules its records follow, what it deliberately
 * leaves out, and what the installation needs to run.
 */
$pageTitle    = 'About IMS Nepal | Inventory and Sales Management';
$currentPage  = 'about';
$extraStyles  = ['css/site.css?v=2', 'css/about.css?v=1'];
$extraScripts = ['assets/home.js?v=1'];

require_once __DIR__ . '/../includes/functions.php';

$vatPercent = (int) round(TAX_RATE * 100);
$lowStock   = (int) LOW_STOCK_THRESHOLD;

$escape = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

$records = [
    [
        'name'   => 'Products',
        'detail' => 'Name, product ID, category, price and quantity, with the current count kept up to date.',
    ],
    [
        'name'   => 'Stock movements',
        'detail' => 'Every stock in, stock out, sale and adjustment, with the balance after each entry.',
    ],
    [
        'name'   => 'Sales',
        'detail' => 'Bill number, product snapshot, quantity, unit price, subtotal, VAT, total, customer and the staff member who recorded it.',
    ],
    [
        'name'   => 'Alerts',
        'detail' => 'Low-stock and out-of-stock notices for a product, each kept until someone reads it.',
    ],
    [
        'name'   => 'Accounts',
        'detail' => 'Administrator and staff sign-in, plus expiring reset codes for password recovery.',
    ],
];

$rules = [
    ['label' => 'VAT', 'value' => $vatPercent . '% of the subtotal, printed as its own line on every bill.'],
    ['label' => 'Low stock', 'value' => $lowStock . ' units or fewer raises an alert; reaching zero raises an out-of-stock alert.'],
    ['label' => 'One product per sale', 'value' => 'Each sale carries one product, so a purchase of two products becomes two bills.'],
    ['label' => 'Bill numbers', 'value' => 'Issued when the sale is saved, in the form BILL-00107.'],
    ['label' => 'Currency', 'value' => 'Nepali rupees, shown to two decimal places.'],
];

$limits = [
    [
        'name'   => 'Several products on one bill',
        'detail' => 'A sale holds one product. Two products mean two bills, which is how the records are kept today.',
    ],
    [
        'name'   => 'Taking payments',
        'detail' => 'Cash, card and wallet payments happen outside IMS Nepal. The sale is recorded here; the money is taken where the shop takes it.',
    ],
    [
        'name'   => 'Barcode scanning',
        'detail' => 'Products are found by name, product ID or category.',
    ],
    [
        'name'   => 'Connections to other systems',
        'detail' => 'No accounting, e-commerce or payment integrations.',
    ],
    [
        'name'   => 'Several shops in one account',
        'detail' => 'One installation keeps the records of one shop.',
    ],
];

$requirements = [
    ['label' => 'PHP', 'value' => '7.4 or newer, with PDO MySQL'],
    ['label' => 'Database', 'value' => 'MySQL or MariaDB with InnoDB'],
    ['label' => 'Web server', 'value' => 'Apache or another PHP-capable server'],
    ['label' => 'Password recovery', 'value' => 'Needs a sendmail-compatible relay; optional'],
    ['label' => 'Build step', 'value' => 'None. No Composer and no package manager'],
];

$phoneIcon = '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h3.5l1.8 4.5-2.2 1.4a11.5 11.5 0 0 0 5.6 5.6l1.4-2.2L19.6 15v3.5a2 2 0 0 1-2.2 2A15.4 15.4 0 0 1 3 6.2 2 2 0 0 1 5 4Z"/></svg>';
$mailIcon = '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6 8.5-6"/></svg>';

require __DIR__ . '/includes/header.php';
?>

<main>
    <!-- ═══════ HERO ═══════ -->
    <section class="hero">
        <div class="wrap">
            <div class="hero-intro">
                <h1>An inventory and sales system for one shop.</h1>
                <div class="hero-aside">
                    <p>IMS Nepal keeps products, stock movements, sales, bills and staff accounts in one place, on the shop's own server. It is built for local retail shops and the people working the counter.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="../signin.php?action=register">Create your account</a>
                        <a class="link-arrow" href="contact.php">Contact us &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ WHAT IT RECORDS ═══════ -->
    <section class="section" id="records">
        <div class="wrap">
            <div class="section-head">
                <h2>What it records.</h2>
                <p>Five kinds of record, kept connected: the product list, every movement of stock, the sales, the alerts those sales raise and the accounts that use them.</p>
            </div>

            <div class="table-card" data-reveal>
                <table class="records">
                    <thead>
                        <tr>
                            <th scope="col">Record</th>
                            <th scope="col">What it holds</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record): ?>
                            <tr>
                                <td><?php echo $escape($record['name']); ?></td>
                                <td><?php echo $escape($record['detail']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ═══════ RULES ═══════ -->
    <section class="section" id="rules">
        <div class="wrap">
            <div class="section-head section-head--row">
                <h2>The rules the records follow.</h2>
                <p>VAT, the low-stock threshold and the one-product sale are fixed rules, not settings that change from bill to bill.</p>
            </div>

            <ul class="spec" data-reveal>
                <?php foreach ($rules as $rule): ?>
                    <li>
                        <span class="spec-label"><?php echo $escape($rule['label']); ?></span>
                        <span class="spec-value"><?php echo $escape($rule['value']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ═══════ WHAT IT LEAVES OUT ═══════ -->
    <section class="section" id="limits">
        <div class="wrap">
            <div class="section-head">
                <h2>What it leaves out.</h2>
                <p>IMS Nepal records sales; it does not take payments or scan barcodes. Knowing the edges is worth more than a longer feature list.</p>
            </div>

            <div class="table-card" data-reveal>
                <table class="records">
                    <thead>
                        <tr>
                            <th scope="col">Not included</th>
                            <th scope="col">What happens instead</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($limits as $limit): ?>
                            <tr>
                                <td><?php echo $escape($limit['name']); ?></td>
                                <td><?php echo $escape($limit['detail']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- ═══════ TO RUN IT ═══════ -->
    <section class="section" id="requirements">
        <div class="wrap">
            <div class="section-head section-head--row">
                <h2>To run it.</h2>
                <p>It runs on ordinary shared hosting. Styles, scripts and images are served from the same installation, so no CDN or external font is required.</p>
            </div>

            <ul class="spec spec--mono" data-reveal>
                <?php foreach ($requirements as $requirement): ?>
                    <li>
                        <span class="spec-label"><?php echo $escape($requirement['label']); ?></span>
                        <span class="spec-value"><?php echo $escape($requirement['value']); ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </section>

    <!-- ═══════ CONTACT ═══════ -->
    <section class="contact" id="contact">
        <div class="wrap contact-inner">
            <div>
                <h2>Contact</h2>
                <p>Call or email about setting up IMS Nepal, stock records or bills.</p>
            </div>
            <div class="contact-right">
                <div class="contact-links">
                    <a class="contact-link" href="tel:+9779842020363"><?php echo $phoneIcon; ?>+977 9842020363</a>
                    <a class="contact-link" href="mailto:itsnikrish@gmail.com"><?php echo $mailIcon; ?>itsnikrish@gmail.com</a>
                </div>
                <div class="contact-actions">
                    <a class="btn btn-primary" href="../signin.php?action=register">Create your account</a>
                    <a class="link-plain" href="../signin.php">Sign in</a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require __DIR__ . '/includes/footer.php'; ?>
