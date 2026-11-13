<?php
/**
 * views/record_sale.php - Record a new sale
 *
 * Requires: $products (array)
 */
$dashboardScript = $dashboardScript ?? 'dashboard.php';
$postedValue = static function (string $key): string {
    $value = $_POST[$key] ?? '';
    return is_scalar($value) ? (string)$value : '';
};
$selectedProductId = $postedValue('product_id');
$existingCustomers = [];
foreach ($customers ?? [] as $customer) {
    $existingCustomers[] = [
        'name' => (string)($customer['customer_name'] ?? ''),
        'phone' => (string)($customer['customer_phone'] ?? ''),
    ];
}
?>
<div class="form-card sale-entry-card">
    <div class="sale-card-heading">
        <h2>Sale details</h2>
    </div>

    <?php if (empty($products)): ?>
        <div class="empty-state">
            <p>You need a product before you can record a sale.</p>
            <a href="<?php echo htmlspecialchars($dashboardScript); ?>?view=add" class="btn btn-primary">Add Your First Product</a>
        </div>
    <?php else: ?>
        <form method="POST" action="<?php echo htmlspecialchars($dashboardScript); ?>?view=sale_add">
            <input type="hidden" name="action" value="sale">
            <?php echo csrfField(); ?>

            <div class="form-grid">
                <div class="form-group">
                    <label>Customer Name <span class="req">*</span></label>
                    <input type="text" id="customer_name" name="customer_name"
                           value="<?php echo htmlspecialchars($postedValue('customer_name'), ENT_QUOTES, 'UTF-8'); ?>"
                           autocomplete="name" maxlength="120"
                           pattern="\p{L}[\p{L}\p{M}]*(?: +\p{L}[\p{L}\p{M}]*)*"
                           title="Use letters and spaces only." required>
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <div class="customer-select-wrap">
                        <input type="text" id="customer_phone" name="customer_phone" class="customer-select-input" autocomplete="off"
                           value="<?php echo htmlspecialchars($postedValue('customer_phone'), ENT_QUOTES, 'UTF-8'); ?>"
                           maxlength="40">
                        <div class="pid-list" id="customerList"></div>
                    </div>
                </div>      

                <div class="form-group full">
                    <label>Product <span class="req">*</span></label>
                    <select id="product_id" name="product_id" required>
                        <option value="">Select a product</option>
                        <?php foreach ($products as $p): ?>
                            <option value="<?php echo (int)$p['id']; ?>"
                                    <?php echo (string)$p['id'] === $selectedProductId ? 'selected' : ''; ?>
                                    data-price="<?php echo (float)$p['price']; ?>"
                                    data-stock="<?php echo (int)$p['quantity']; ?>">
                                <?php echo htmlspecialchars(
                                    $p['name']
                                    . ' (' . $p['product_id'] . ')'
                                    . ' · Stock: ' . $p['quantity']
                                ); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Quantity <span class="req">*</span></label>
                    <input type="number" id="quantity" name="quantity"
                           min="1" step="1" required
                           value="<?php echo htmlspecialchars($postedValue('quantity') ?: '1', ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="form-group">
                    <label>Unit Price (Rs.)</label>
                    <input type="number" id="unit_price" name="unit_price"
                           step="0.01" min="0" required readonly
                           value="<?php echo htmlspecialchars($postedValue('unit_price'), ENT_QUOTES, 'UTF-8'); ?>">
                </div>

                <div class="form-group">
                    <label>Sale Date</label>
                    <input type="date" name="sale_date"
                           value="<?php echo date('Y-m-d'); ?>" readonly>
                </div>

                <div class="form-group">
                    <label>Note</label>
                    <input type="text" name="note"
                           value="<?php echo htmlspecialchars($postedValue('note'), ENT_QUOTES, 'UTF-8'); ?>"
                           maxlength="255" placeholder="Optional">
                </div>
            </div>

            <!-- Live VAT preview -->
            <div id="tax-preview"
                 class="sale-tax-preview"
                 style="display:none;">
                <span>Subtotal: <strong id="prev-sub">Rs.0.00</strong></span>
                &nbsp;|&nbsp;
                <span>VAT 13%: <strong id="prev-tax">Rs.0.00</strong></span>
                &nbsp;|&nbsp;
                <span>Total: <strong id="prev-total">Rs.0.00</strong></span>
            </div>

            <div class="form-actions">
                <a href="<?php echo htmlspecialchars($dashboardScript); ?>?view=sales" class="btn btn-ghost">Cancel</a>
                <button type="submit" class="btn btn-primary">Record Sale</button>
            </div>
        </form>

        <script type="application/json" id="existing-customers-data"><?php
            echo json_encode($existingCustomers, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
        ?></script>
    <?php endif; ?>
</div>