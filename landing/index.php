<?php
/**
 * landing/index.php
 * Public home page.
 *
 * Every figure on this page comes from one sample sale and from the same
 * rules the dashboard applies (TAX_RATE and LOW_STOCK_THRESHOLD in
 * includes/functions.php), so the previews, the printed bill and the report
 * can never contradict each other.
 */
$pageTitle    = 'IMS Nepal | Inventory and Sales Management';
$currentPage  = 'home';
$extraStyles  = ['css/site.css?v=2'];
$extraScripts = ['assets/home.js?v=1'];

require_once __DIR__ . '/../includes/functions.php';

$vatPercent = (int) round(TAX_RATE * 100);
$lowStock   = (int) LOW_STOCK_THRESHOLD;
$today      = date('Y-m-d');

$escape = static function (string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
};

$money = static function (float $amount): string {
    return number_format($amount, 2);
};

$daysAgo = static function (int $days): string {
    return date('Y-m-d', strtotime('-' . $days . ' days'));
};

/* ── The sample sale every preview refers to ───────────────────────────── */
$sale = [
    'bill_no'      => 'BILL-00107',
    'date'         => $today,
    'customer'     => 'Bimala Shrestha',
    'phone'        => '9841234567',
    'product'      => 'Ilam Gold Tea 250g',
    'code'         => 'TEA-014',
    'quantity'     => 2,
    'unit_price'   => 250.00,
    'stock_after'  => $lowStock,
];
$sale['stock_before'] = $sale['stock_after'] + $sale['quantity'];
$sale['subtotal']     = round($sale['unit_price'] * $sale['quantity'], 2);
$sale['vat']          = round($sale['subtotal'] * TAX_RATE, 2);
$sale['total']        = round($sale['subtotal'] + $sale['vat'], 2);

/* ── Sample records ───────────────────────────────────────────────────── */
$products = [
    [
        'name'     => $sale['product'],
        'code'     => $sale['code'],
        'category' => 'Beverages',
        'price'    => $sale['unit_price'],
        'stock'    => $sale['stock_after'],
        'state'    => 'low',
    ],
    ['name' => 'Sona Mansuli Rice 25kg', 'code' => 'RIC-001', 'category' => 'Grains', 'price' => 2150.00, 'stock' => 18, 'state' => ''],
    ['name' => 'Mustard Oil 1L', 'code' => 'OIL-006', 'category' => 'Cooking oil', 'price' => 320.00, 'stock' => 34, 'state' => ''],
    ['name' => 'Sugar 1kg', 'code' => 'SUG-002', 'category' => 'Groceries', 'price' => 105.00, 'stock' => 0, 'state' => 'out'],
    ['name' => 'Detergent Powder 500g', 'code' => 'DET-031', 'category' => 'Household', 'price' => 210.00, 'stock' => 6, 'state' => 'low'],
];

/* The module preview is a narrower crop of the same table. */
$moduleProducts = [$products[0], $products[1], $products[3], $products[4]];

/* Movement history for the sampled product: 0 +15 → 15 −3 → 12 −2 → 10. */
$movements = [
    ['date' => $sale['date'], 'type' => 'Sale', 'reference' => $sale['bill_no'], 'change' => -$sale['quantity'], 'balance' => $sale['stock_after']],
    ['date' => $daysAgo(2), 'type' => 'Adjustment', 'reference' => '', 'change' => -3, 'balance' => $sale['stock_after'] + $sale['quantity']],
    ['date' => $daysAgo(11), 'type' => 'Stock in', 'reference' => '', 'change' => 15, 'balance' => 15],
];

$reportFigures = [
    [9, 14, 7940.00],
    [12, 21, 11265.00],
    [7, 9, 4610.00],
    [11, 18, 9875.00],
    [8, 12, 6320.00],
    [10, 16, 8455.00],
];
$reportDays = [];
foreach ($reportFigures as $index => $figure) {
    $reportDays[] = [
        'date'  => $daysAgo($index),
        'bills' => $figure[0],
        'units' => $figure[1],
        'sales' => $figure[2],
    ];
}
$reportTotals = [
    'bills' => array_sum(array_column($reportDays, 'bills')),
    'units' => array_sum(array_column($reportDays, 'units')),
    'sales' => array_sum(array_column($reportDays, 'sales')),
];

$staff = [
    ['username' => 'sita', 'added' => $daysAgo(101), 'sales' => 214],
    ['username' => 'ramthapa', 'added' => $daysAgo(62), 'sales' => 176],
    ['username' => 'bikashg', 'added' => $daysAgo(16), 'sales' => 63],
    ['username' => 'anitag', 'added' => $daysAgo(11), 'sales' => 21],
    ['username' => 'sureshm', 'added' => $daysAgo(7), 'sales' => 9],
];

/* Wording mirrors checkStockNotification() in includes/functions.php. */
$alerts = [
    [
        'level'   => 'warn',
        'title'   => 'Low stock alert',
        'message' => '"' . $sale['product'] . '" (Product-ID: ' . $sale['code'] . ') has only ' . $sale['stock_after'] . ' unit(s) left.',
    ],
    [
        'level'   => 'out',
        'title'   => 'Out of stock',
        'message' => '"Sugar 1kg" (Product-ID: SUG-002) is out of stock. Please restock.',
    ],
];

$faqs = [
    [
        'question' => 'Can one sale include several products?',
        'answer'   => 'No. Each sale records one product and gets its own bill number, so a customer buying two products receives two bills.',
    ],
    [
        'question' => 'How is VAT shown on a bill?',
        'answer'   => 'VAT is ' . $vatPercent . '% of the subtotal. The subtotal, the VAT amount and the total print as separate lines: Rs. '
            . $money($sale['subtotal']) . ' + Rs. ' . $money($sale['vat']) . ' = Rs. ' . $money($sale['total']) . '.',
    ],
    [
        'question' => 'When is a product marked low stock?',
        'answer'   => 'At ' . $lowStock . ' units or fewer. An alert is raised when a sale or adjustment takes a product down to that level, and a separate alert when it reaches zero.',
    ],
    [
        'question' => 'What account does registration create?',
        'answer'   => 'A staff account. It can record sales, see its own sales report and print its own bills. An administrator account is added separately.',
    ],
    [
        'question' => 'Can bills be printed again later?',
        'answer'   => 'Yes. Any sale in the sales report can be opened and printed or saved as a PDF.',
    ],
    [
        'question' => 'How does password recovery work?',
        'answer'   => 'A reset code is emailed to the account. Delivery depends on mail being configured on the server that runs IMS Nepal.',
    ],
];

/* Verified against staff_dashboard.php: staff may view the product list,
   record a sale, and read or print only their own sales. */
$capabilities = [
    ['task' => 'Record a sale', 'admin' => true, 'staff' => true],
    ['task' => 'Print a bill', 'admin' => true, 'staff' => 'own'],
    ['task' => 'View sales report', 'admin' => true, 'staff' => 'own'],
    ['task' => 'Sales summary by product, staff and day', 'admin' => true, 'staff' => false],
    ['task' => 'Add and edit products', 'admin' => true, 'staff' => false],
    ['task' => 'Adjust stock and view movements', 'admin' => true, 'staff' => false],
    ['task' => 'Low-stock and out-of-stock alerts', 'admin' => true, 'staff' => false],
    ['task' => 'Manage staff accounts', 'admin' => true, 'staff' => false],
];

$modules = [
    'inventory' => 'Inventory',
    'sales'     => 'Sales and billing',
    'reports'   => 'Reports',
    'staff'     => 'Staff and alerts',
];

/* Render helpers */
$stateChip = static function (string $state): string {
    if ($state === 'low') {
        return '<span class="chip chip-warn">Low</span>';
    }
    if ($state === 'out') {
        return '<span class="chip chip-bad">Out of stock</span>';
    }
    return '';
};

$stockClass = static function (string $state): string {
    if ($state === 'low') {
        return ' stock-low';
    }
    if ($state === 'out') {
        return ' stock-zero';
    }
    return '';
};

$capability = static function ($value): string {
    if ($value === true) {
        return '<span class="yes">Yes</span>';
    }
    if ($value === 'own') {
        return '<span class="partial">Own sales only</span>';
    }
    return '<span class="no">No</span>';
};

$chevron  = '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
$fieldChevron = '<svg class="ico f-chev" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>';
$printerIcon = '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9V3h12v6"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8" rx="1"/></svg>';
$phoneIcon = '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 4h3.5l1.8 4.5-2.2 1.4a11.5 11.5 0 0 0 5.6 5.6l1.4-2.2L19.6 15v3.5a2 2 0 0 1-2.2 2A15.4 15.4 0 0 1 3 6.2 2 2 0 0 1 5 4Z"/></svg>';
$mailIcon = '<svg class="ico" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3.5 6.5 8.5 6 8.5-6"/></svg>';

require __DIR__ . '/includes/header.php';
?>

<main>
    <!-- ═══════ HERO ═══════ -->
    <section class="hero">
        <div class="wrap">
            <div class="hero-intro">
                <h1>Record a sale.<br>Stock updates automatically.</h1>
                <div class="hero-aside">
                    <p>Product records, sales, bills and stock history for one shop, in one place.</p>
                    <div class="hero-actions">
                        <a class="btn btn-primary" href="../signin.php?action=register">Create your account</a>
                        <a class="link-arrow" href="#modules">See the modules</a>
                    </div>
                </div>
            </div>

            <div class="hero-evidence" data-reveal>
                <div class="pv">
                    <div class="pv-bar">
                        <span class="pv-title">Products</span>
                        <span class="pv-meta"><?php echo count($products); ?> records</span>
                    </div>
                    <table class="ui">
                        <thead>
                            <tr>
                                <th scope="col">Product</th>
                                <th scope="col" class="num">Price</th>
                                <th scope="col" class="num">Stock</th>
                                <th scope="col">State</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <span class="p-name"><?php echo $escape($product['name']); ?></span>
                                        <span class="p-id"><?php echo $escape($product['code']); ?></span>
                                    </td>
                                    <td class="num"><?php echo $money($product['price']); ?></td>
                                    <td class="num<?php echo $stockClass($product['state']); ?>"><?php echo (int) $product['stock']; ?></td>
                                    <td><?php echo $stateChip($product['state']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="pv-foot">
                        <span>Low stock: <b><?php echo $lowStock; ?> units or fewer</b></span>
                        <span>Prices in Rs.</span>
                    </div>
                </div>

                <div class="pv">
                    <div class="pv-bar">
                        <span class="pv-title">Record sale</span>
                        <span class="pv-meta"><?php echo $escape($sale['date']); ?></span>
                    </div>
                    <div class="pv-body">
                        <div class="field">
                            <span class="f-label">Customer name</span>
                            <span class="f-value"><?php echo $escape($sale['customer']); ?></span>
                        </div>
                        <div class="field">
                            <span class="f-label">Product</span>
                            <span class="f-value"><?php echo $escape($sale['product']); ?> (<?php echo $escape($sale['code']); ?>) <?php echo $fieldChevron; ?></span>
                        </div>
                        <div class="field-row">
                            <div class="field">
                                <span class="f-label">Quantity</span>
                                <span class="f-value num"><?php echo (int) $sale['quantity']; ?></span>
                            </div>
                            <div class="field">
                                <span class="f-label">Unit price</span>
                                <span class="f-value num is-readonly"><?php echo $money($sale['unit_price']); ?></span>
                            </div>
                        </div>
                        <dl class="totals">
                            <div><dt>Subtotal</dt><dd>Rs. <?php echo $money($sale['subtotal']); ?></dd></div>
                            <div><dt>VAT <?php echo $vatPercent; ?>%</dt><dd>Rs. <?php echo $money($sale['vat']); ?></dd></div>
                            <div class="totals-final"><dt>Total</dt><dd>Rs. <?php echo $money($sale['total']); ?></dd></div>
                        </dl>
                        <div class="pv-submit">Record Sale</div>
                    </div>
                </div>
            </div>

            <p class="evidence-note">
                <span>Sample records: one tea sale, <?php echo (int) $sale['quantity']; ?> units at Rs. <?php echo $money($sale['unit_price']); ?></span>
                <span>One product per sale</span>
            </p>
        </div>
    </section>

    <!-- ═══════ MODULES ═══════ -->
    <section class="section" id="modules">
        <div class="wrap">
            <div class="section-head">
                <h2>Stock, sales and daily records.</h2>
                <p>Four modules cover a day at the shop: products and stock, sales and bills, reports, and the staff accounts that use them.</p>
            </div>

            <div class="tabs" role="tablist" aria-label="Modules">
                <?php $tabIndex = 0; ?>
                <?php foreach ($modules as $key => $label): ?>
                    <button class="tab"
                            type="button"
                            role="tab"
                            id="tab-<?php echo $escape($key); ?>"
                            data-module-tab="<?php echo $escape($key); ?>"
                            aria-controls="panel-<?php echo $escape($key); ?>"
                            aria-selected="<?php echo $tabIndex === 0 ? 'true' : 'false'; ?>"
                            tabindex="<?php echo $tabIndex === 0 ? '0' : '-1'; ?>">
                        <?php echo $escape($label); ?>
                    </button>
                    <?php $tabIndex++; ?>
                <?php endforeach; ?>
            </div>

            <!-- Inventory -->
            <div class="module is-active"
                 id="panel-inventory"
                 data-module-panel="inventory"
                 role="tabpanel"
                 aria-labelledby="tab-inventory">
                <div class="module-copy">
                    <h3>Inventory</h3>
                    <p>Each product keeps its name, product ID, category, price and quantity. Every change to a quantity is logged against that product.</p>
                    <ul class="field-list">
                        <li>Product ID and category</li>
                        <li>Price and quantity</li>
                        <li>Stock in, stock out, sale, adjustment</li>
                    </ul>
                    <p class="module-note">Low stock: <?php echo $lowStock; ?> units or fewer</p>
                </div>
                <div class="module-panel">
                    <div class="pv">
                        <div class="pv-bar">
                            <span class="pv-title">Products</span>
                            <span class="pv-meta"><?php echo count($moduleProducts); ?> records</span>
                        </div>
                        <table class="ui ui-products">
                            <thead>
                                <tr>
                                    <th scope="col">Product</th>
                                    <th scope="col">Category</th>
                                    <th scope="col" class="num">Price</th>
                                    <th scope="col" class="num">Stock</th>
                                    <th scope="col">State</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($moduleProducts as $product): ?>
                                    <tr>
                                        <td>
                                            <span class="p-name"><?php echo $escape($product['name']); ?></span>
                                            <span class="p-id"><?php echo $escape($product['code']); ?></span>
                                        </td>
                                        <td><?php echo $escape($product['category']); ?></td>
                                        <td class="num"><?php echo $money($product['price']); ?></td>
                                        <td class="num<?php echo $stockClass($product['state']); ?>"><?php echo (int) $product['stock']; ?></td>
                                        <td><?php echo $stateChip($product['state']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pv-sub">
                            <div class="pv-sub-head">
                                <span class="pv-sub-title">Movement history</span>
                                <span class="pv-sub-meta"><?php echo $escape($sale['code']); ?></span>
                            </div>
                            <table class="ui">
                                <thead>
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Movement</th>
                                        <th scope="col" class="num">Qty</th>
                                        <th scope="col" class="num">Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($movements as $movement): ?>
                                        <tr>
                                            <td class="mono"><?php echo $escape($movement['date']); ?></td>
                                            <td>
                                                <span class="type-tag"><?php echo $escape($movement['type']); ?></span>
                                                <?php echo $escape($movement['reference']); ?>
                                            </td>
                                            <td class="num"><?php echo $movement['change'] > 0 ? '+' : '&minus;'; ?><?php echo abs((int) $movement['change']); ?></td>
                                            <td class="num"><?php echo (int) $movement['balance']; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sales and billing -->
            <div class="module"
                 id="panel-sales"
                 data-module-panel="sales"
                 role="tabpanel"
                 aria-labelledby="tab-sales"
                 hidden>
                <div class="module-copy">
                    <h3>Sales and billing</h3>
                    <p>A sale records one product, its quantity, the customer and the staff member who keyed it in. Stock is deducted in the same step.</p>
                    <ul class="field-list">
                        <li>Customer name and phone</li>
                        <li>Subtotal, VAT <?php echo $vatPercent; ?>%, total</li>
                        <li>Bill number on save</li>
                    </ul>
                    <a class="link-arrow" href="#bill">Printed bill &rarr;</a>
                </div>
                <div class="module-panel">
                    <div class="pv">
                        <div class="pv-bar">
                            <span class="pv-title">Sale details</span>
                            <span class="pv-meta">Bill <?php echo $escape($sale['bill_no']); ?></span>
                        </div>
                        <div class="pv-body">
                            <div class="field-row">
                                <div class="field">
                                    <span class="f-label">Customer name</span>
                                    <span class="f-value"><?php echo $escape($sale['customer']); ?></span>
                                </div>
                                <div class="field">
                                    <span class="f-label">Phone</span>
                                    <span class="f-value num"><?php echo $escape($sale['phone']); ?></span>
                                </div>
                            </div>
                            <div class="field">
                                <span class="f-label">Product</span>
                                <span class="f-value"><?php echo $escape($sale['product']); ?> (<?php echo $escape($sale['code']); ?>) <?php echo $fieldChevron; ?></span>
                            </div>
                            <div class="field-row field-row--3">
                                <div class="field">
                                    <span class="f-label">Quantity</span>
                                    <span class="f-value num"><?php echo (int) $sale['quantity']; ?></span>
                                </div>
                                <div class="field">
                                    <span class="f-label">Unit price</span>
                                    <span class="f-value num is-readonly"><?php echo $money($sale['unit_price']); ?></span>
                                </div>
                                <div class="field">
                                    <span class="f-label">Sale date</span>
                                    <span class="f-value num is-readonly"><?php echo $escape($sale['date']); ?></span>
                                </div>
                            </div>
                            <div class="field">
                                <span class="f-label">Note</span>
                                <span class="f-value" style="color:#8A8A8A">Optional</span>
                            </div>
                            <dl class="totals">
                                <div><dt>Subtotal</dt><dd>Rs. <?php echo $money($sale['subtotal']); ?></dd></div>
                                <div><dt>VAT <?php echo $vatPercent; ?>%</dt><dd>Rs. <?php echo $money($sale['vat']); ?></dd></div>
                                <div class="totals-final"><dt>Total</dt><dd>Rs. <?php echo $money($sale['total']); ?></dd></div>
                            </dl>
                            <div class="pv-submit">Record Sale</div>
                        </div>
                        <div class="pv-foot">
                            <span>Stock before saving</span>
                            <span><b><?php echo $escape($sale['code']); ?> &rarr; <?php echo (int) $sale['stock_before']; ?> units</b></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reports -->
            <div class="module"
                 id="panel-reports"
                 data-module-panel="reports"
                 role="tabpanel"
                 aria-labelledby="tab-reports"
                 hidden>
                <div class="module-copy">
                    <h3>Reports</h3>
                    <p>Filter by date, product or category. Summaries group the same sales by day, by product and by the staff member who recorded them.</p>
                    <ul class="field-list">
                        <li>Daily totals</li>
                        <li>Sales by product</li>
                        <li>Sales by staff member</li>
                    </ul>
                    <p class="module-note">Same date range across all three</p>
                </div>
                <div class="module-panel">
                    <div class="pv">
                        <div class="pv-bar">
                            <span class="pv-title">Sales summary</span>
                            <span class="pv-meta">By day</span>
                        </div>
                        <div class="pv-body" style="padding-bottom:8px">
                            <div class="field-row field-row--3 field-row--sm">
                                <div class="field">
                                    <span class="f-label">From</span>
                                    <span class="f-value num"><?php echo $escape($reportDays[count($reportDays) - 1]['date']); ?></span>
                                </div>
                                <div class="field">
                                    <span class="f-label">To</span>
                                    <span class="f-value num"><?php echo $escape($reportDays[0]['date']); ?></span>
                                </div>
                                <div class="field">
                                    <span class="f-label">Category</span>
                                    <span class="f-value">All categories <?php echo $fieldChevron; ?></span>
                                </div>
                            </div>
                        </div>
                        <table class="ui">
                            <thead>
                                <tr>
                                    <th scope="col">Date</th>
                                    <th scope="col" class="num">Bills</th>
                                    <th scope="col" class="num">Units</th>
                                    <th scope="col" class="num">Sales (Rs.)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($reportDays as $day): ?>
                                    <tr>
                                        <td class="mono"><?php echo $escape($day['date']); ?></td>
                                        <td class="num"><?php echo (int) $day['bills']; ?></td>
                                        <td class="num"><?php echo (int) $day['units']; ?></td>
                                        <td class="num"><?php echo $money($day['sales']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td style="font-weight:600">Total</td>
                                    <td class="num" style="font-weight:600"><span class="counter" data-count="<?php echo (int) $reportTotals['bills']; ?>"><?php echo (int) $reportTotals['bills']; ?></span></td>
                                    <td class="num" style="font-weight:600"><span class="counter" data-count="<?php echo (int) $reportTotals['units']; ?>"><?php echo (int) $reportTotals['units']; ?></span></td>
                                    <td class="num" style="font-weight:600"><?php echo $money($reportTotals['sales']); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                        <div class="pv-foot">
                            <span>VAT <?php echo $vatPercent; ?>% included in each bill total</span>
                            <span><?php echo count($reportDays); ?> days</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Staff and alerts -->
            <div class="module"
                 id="panel-staff"
                 data-module-panel="staff"
                 role="tabpanel"
                 aria-labelledby="tab-staff"
                 hidden>
                <div class="module-copy">
                    <h3>Staff and alerts</h3>
                    <p>An administrator adds staff accounts. Staff sign in to record sales and print their own bills. Alerts cover low stock and out-of-stock items.</p>
                    <ul class="field-list">
                        <li>Staff accounts</li>
                        <li>Low-stock alerts</li>
                        <li>Out-of-stock alerts</li>
                    </ul>
                    <p class="module-note">Self-registration creates a staff account</p>
                </div>
                <div class="module-panel">
                    <div class="pv">
                        <div class="pv-bar">
                            <span class="pv-title">Manage staff</span>
                            <span class="pv-meta"><?php echo count($staff); ?> accounts</span>
                        </div>
                        <table class="ui">
                            <thead>
                                <tr>
                                    <th scope="col">Staff account</th>
                                    <th scope="col">Added</th>
                                    <th scope="col" class="num">Sales recorded</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staff as $member): ?>
                                    <tr>
                                        <td><span class="p-name"><?php echo $escape($member['username']); ?></span></td>
                                        <td class="mono"><?php echo $escape($member['added']); ?></td>
                                        <td class="num"><?php echo (int) $member['sales']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <div class="pv-sub">
                            <div class="pv-sub-head">
                                <span class="pv-sub-title">Stock notifications</span>
                                <span class="pv-sub-meta"><?php echo count($alerts); ?> unread</span>
                            </div>
                            <?php foreach ($alerts as $alert): ?>
                                <div class="alert-row<?php echo $alert['level'] === 'out' ? ' is-out' : ''; ?>">
                                    <span class="alert-dot" aria-hidden="true"></span>
                                    <span class="alert-copy">
                                        <strong><?php echo $escape($alert['title']); ?></strong>
                                        <span><?php echo $escape($alert['message']); ?></span>
                                    </span>
                                    <span class="alert-flag">Unread</span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ PRINTED BILL ═══════ -->
    <section class="bill-section" id="bill">
        <div class="wrap">
            <div class="section-head section-head--row">
                <h2>What prints on a bill.</h2>
                <p>Recording a sale saves it and issues one bill number. The bill prints from the browser, so it can go on paper or be saved as a PDF.</p>
            </div>

            <div class="bill-grid">
                <figure class="bill-figure" data-reveal>
                    <div class="bill">
                        <div class="bill-head">
                            <strong>IMS Nepal</strong>
                            <span>Ph: +977 9842020363 | sales@IMS.com</span>
                        </div>
                        <hr>
                        <dl class="bill-meta">
                            <div><dt>Bill</dt><dd><?php echo $escape($sale['bill_no']); ?></dd></div>
                            <div><dt>Date</dt><dd><?php echo $escape($sale['date']); ?></dd></div>
                            <div><dt>Customer</dt><dd><?php echo $escape($sale['customer']); ?> (<?php echo $escape($sale['phone']); ?>)</dd></div>
                        </dl>
                        <hr>
                        <table class="bill-items">
                            <tbody>
                                <tr class="head">
                                    <td>Item</td>
                                    <td class="num">Qty</td>
                                    <td class="num">Rate</td>
                                    <td class="num">Amt</td>
                                </tr>
                                <tr>
                                    <td>
                                        <?php echo $escape($sale['product']); ?>
                                        <span class="bill-pid"><?php echo $escape($sale['code']); ?></span>
                                    </td>
                                    <td class="num"><?php echo (int) $sale['quantity']; ?></td>
                                    <td class="num"><?php echo $money($sale['unit_price']); ?></td>
                                    <td class="num"><?php echo $money($sale['subtotal']); ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <hr>
                        <div class="bill-foot"><span>Subtotal</span><span>Rs. <?php echo $money($sale['subtotal']); ?></span></div>
                        <div class="bill-foot"><span>VAT (<?php echo $vatPercent; ?>%)</span><span>Rs. <?php echo $money($sale['vat']); ?></span></div>
                        <div class="bill-foot"><b>TOTAL</b><b>Rs. <?php echo $money($sale['total']); ?></b></div>
                        <hr>
                        <p class="bill-thanks">Thank you for your business!</p>
                        <div class="bill-print"><?php echo $printerIcon; ?> Print / Save PDF</div>
                    </div>
                </figure>

                <div data-reveal>
                    <ul class="bill-spec">
                        <li><span>Bill number</span><b><?php echo $escape($sale['bill_no']); ?></b></li>
                        <li><span>Sale date</span><b><?php echo $escape($sale['date']); ?></b></li>
                        <li><span>Customer and phone</span><b><?php echo $escape($sale['customer']); ?></b></li>
                        <li><span>Item and product ID</span><b><?php echo $escape($sale['code']); ?></b></li>
                        <li><span>Quantity and rate</span><b><?php echo (int) $sale['quantity']; ?> &times; Rs. <?php echo $money($sale['unit_price']); ?></b></li>
                        <li><span>Subtotal</span><b>Rs. <?php echo $money($sale['subtotal']); ?></b></li>
                        <li><span>VAT at <?php echo $vatPercent; ?>%</span><b>Rs. <?php echo $money($sale['vat']); ?></b></li>
                        <li><span>Total</span><b>Rs. <?php echo $money($sale['total']); ?></b></li>
                        <li><span>Note</span><b>If entered</b></li>
                    </ul>
                    <p class="bill-spec-note">Category and the staff member who recorded the sale stay in the sales records. The printed bill carries the item line and the totals.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ HOW IT WORKS ═══════ -->
    <section class="section section--steps" id="how">
        <div class="wrap">
            <div class="section-head">
                <h2>How it works.</h2>
            </div>
            <div class="steps">
                <div class="step">
                    <h3>Add products</h3>
                    <p>Enter each product once with the fields the shop already keeps.</p>
                    <p class="step-fields">Name<br>Product ID<br>Category<br>Price, quantity</p>
                </div>
                <div class="step">
                    <h3>Record sales</h3>
                    <p>Pick the product, quantity and customer. Stock is deducted and a bill number is issued.</p>
                    <p class="step-fields">Product, quantity<br>Customer, phone<br>Staff member<br>VAT <?php echo $vatPercent; ?>%</p>
                </div>
                <div class="step">
                    <h3>Read reports</h3>
                    <p>Filter the same sales by date, product, category or staff member, and print any bill again.</p>
                    <p class="step-fields">Daily totals<br>By product<br>By staff member</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══════ ACCOUNT ROLES ═══════ -->
    <section class="section" id="roles">
        <div class="wrap">
            <div class="section-head section-head--row">
                <h2>Two account types.</h2>
                <p>Administrators run the records. Staff record sales at the counter and see only the sales they recorded.</p>
            </div>

            <div class="table-card" data-reveal>
                <table class="roles">
                    <thead>
                        <tr>
                            <th scope="col">Task</th>
                            <th scope="col">Administrator</th>
                            <th scope="col">Staff</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($capabilities as $row): ?>
                            <tr>
                                <td><?php echo $escape($row['task']); ?></td>
                                <td><?php echo $capability($row['admin']); ?></td>
                                <td><?php echo $capability($row['staff']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <p class="table-note">Accounts created through registration start with the staff role. An administrator adds the rest from Manage Staff.</p>
        </div>
    </section>

    <!-- ═══════ QUESTIONS ═══════ -->
    <section class="section section--faq" id="questions">
        <div class="wrap">
            <div class="section-head">
                <h2>Common questions.</h2>
            </div>
            <div class="faq">
                <?php foreach ($faqs as $faq): ?>
                    <details>
                        <summary>
                            <?php echo $escape($faq['question']); ?>
                            <?php echo $chevron; ?>
                        </summary>
                        <p class="faq-a"><?php echo $escape($faq['answer']); ?></p>
                    </details>
                <?php endforeach; ?>
            </div>
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
