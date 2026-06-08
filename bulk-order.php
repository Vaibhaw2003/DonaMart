<?php
$page_title = "Request B2B Bulk Quotation";
$active_page = "bulk";
$meta_desc = "Get custom bulk pricing on Areca leaf plates, biodegradable Dona, bowls, and Pattal. Fill out our quotation form for direct factory wholesale rates.";

require_once 'config/db.php';
require_once 'includes/header.php';

// Get pre-selected product if any
$preselected_product = filter_input(INPUT_GET, 'product', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

// Fetch all active products for the dropdown
try {
    $prod_stmt = $pdo->query("SELECT name FROM products WHERE status = 1 ORDER BY name ASC");
    $products = $prod_stmt->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
?>

<!-- Header Banner -->
<section class="bg-primary-custom text-white py-5">
    <div class="container text-center py-4">
        <h1 class="text-white font-weight-bold mb-2">Request Bulk Quotation</h1>
        <p class="text-white-50 lead mb-0">Fill out the B2B quote request. Our export & domestic sales team will respond within 24 hours.</p>
    </div>
</section>

<!-- Quotation Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Left Info Panel -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card h-100">
                    <span class="text-accent text-uppercase font-weight-bold fs-6">B2B Wholesale</span>
                    <h2 class="mt-2 mb-4">Direct Factory Pricing & Logistics Support</h2>
                    <p class="text-muted mb-4">
                        DonaMart is a trusted supplier to distributors, catering corporations, hotel chains, and retail wholesalers across Europe, USA, Australia, and India.
                    </p>
                    
                    <div class="d-flex gap-3 mb-4">
                        <div class="contact-icon flex-shrink-0">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1">Custom Packaging & Branding</h5>
                            <p class="text-muted text-sm mb-0">We support private label shrink-wrap packaging, barcode insertions, and custom B2B boxes.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3 mb-4">
                        <div class="contact-icon flex-shrink-0">
                            <i class="fa-solid fa-ship"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1">FOB & CIF Shipping Terms</h5>
                            <p class="text-muted text-sm mb-0">We handle logistics end-to-end, supplying container shipments via seaport customs clearance directly to your warehouse.</p>
                        </div>
                    </div>

                    <div class="d-flex gap-3">
                        <div class="contact-icon flex-shrink-0">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1">Low Minimum Orders (MOQs)</h5>
                            <p class="text-muted text-sm mb-0">Start scaling with flexible MOQs starting from 1,000 pieces per product category to trial market response.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Quotation Form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="bg-white rounded-custom p-4 p-md-5 shadow-sm border border-light">
                    <h3 class="mb-4 font-weight-bold">Quotation Enquiry Form</h3>
                    
                    <!-- Message placeholder for AJAX response -->
                    <div id="bulkMsg"></div>

                    <form id="bulkForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label font-weight-bold text-dark text-sm">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control rounded-pill px-3" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="company_name" class="form-label font-weight-bold text-dark text-sm">Company Name</label>
                                <input type="text" name="company_name" id="company_name" class="form-control rounded-pill px-3" placeholder="e.g. Eco Distributors Ltd">
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label font-weight-bold text-dark text-sm">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" id="phone" class="form-control rounded-pill px-3" placeholder="Include country code" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label font-weight-bold text-dark text-sm">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control rounded-pill px-3" placeholder="yourname@domain.com" required>
                            </div>
                            <div class="col-md-6">
                                <label for="product_name" class="form-label font-weight-bold text-dark text-sm">Product Required <span class="text-danger">*</span></label>
                                <select name="product_name" id="product_name" class="form-select rounded-pill px-3" required>
                                    <option value="" disabled <?php echo empty($preselected_product) ? 'selected' : ''; ?>>Select a product</option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?php echo htmlspecialchars($p['name']); ?>" 
                                            <?php echo ($preselected_product === $p['name']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($p['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="Custom Areca Leaf Tableware" <?php echo ($preselected_product === 'Custom Areca Leaf Tableware') ? 'selected' : ''; ?>>Other / Custom Areca Leaf Tableware</option>
                                    <option value="General Eco Tableware Bulk Enquiry" <?php echo ($preselected_product === 'General Eco Tableware Bulk Enquiry') ? 'selected' : ''; ?>>General Enquiry (Multiple Products)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="quantity" class="form-label font-weight-bold text-dark text-sm">Expected Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" id="quantity" class="form-control rounded-pill px-3" min="1000" placeholder="Min. MOQ 1000" required>
                            </div>
                            <div class="col-12">
                                <label for="address" class="form-label font-weight-bold text-dark text-sm">Delivery Address & Port (if overseas) <span class="text-danger">*</span></label>
                                <textarea name="address" id="address" class="form-control rounded-4 p-3" rows="3" placeholder="Street, State, Country, Zip Code / Destination Port" required></textarea>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label font-weight-bold text-dark text-sm">Special Requirements / Custom Packaging Instructions</label>
                                <textarea name="message" id="message" class="form-control rounded-4 p-3" rows="3" placeholder="Mention size customizations, shrink wrap branding requirements, certifications requested, etc."></textarea>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <button type="submit" class="btn btn-accent px-5 py-3 rounded-pill font-weight-bold shadow-md w-100">Submit Quotation Request</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
