<?php
$page_title  = "Request B2B Bulk Quotation";
$active_page = "bulk";
$meta_desc   = "Get custom bulk pricing on Areca leaf plates, biodegradable Dona, bowls, and Pattal.";

require_once 'config/db.php';
require_once 'includes/header.php';

$preselected_product = filter_input(INPUT_GET, 'product', FILTER_SANITIZE_SPECIAL_CHARS) ?? '';

try {
    $products = $pdo->query("SELECT name FROM products WHERE status = 1 ORDER BY name ASC")->fetchAll();
} catch (PDOException $e) {
    $products = [];
}
?>

<!-- Header Banner -->
<section class="bg-primary-custom text-white py-5">
    <div class="container text-center py-4">
        <div class="hero-badge mx-auto mb-3"><i class="fa-solid fa-boxes-packing"></i> B2B Wholesale</div>
        <h1 class="text-white font-weight-bold mb-2">Request Bulk Quotation</h1>
        <p class="text-white-50 lead mb-0">Fill out the form below. Our export team will respond within 24 hours.</p>
    </div>
</section>

<!-- Quotation Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-5 align-items-start">

            <!-- Left Info Panel -->
            <div class="col-lg-5" data-aos="fade-right">
                <div style="background:var(--forest,#1b4332);border-radius:20px;padding:40px 36px;height:100%;">

                    <span style="font-size:11px;font-weight:700;text-transform:uppercase;
                                 letter-spacing:0.1em;color:var(--tan,#b5835a);">B2B Wholesale</span>
                    <h2 style="color:#fff;margin-top:8px;margin-bottom:16px;font-size:clamp(1.4rem,2.5vw,1.9rem);line-height:1.25;">
                        Direct Factory Pricing & Logistics Support
                    </h2>
                    <p style="color:rgba(255,255,255,0.6);font-size:14px;line-height:1.7;margin-bottom:32px;">
                        DonaMart is a trusted supplier to distributors, catering corporations, hotel chains,
                        and retail wholesalers across Europe, USA, Australia, and India.
                    </p>

                    <!-- Feature 1 -->
                    <div style="display:flex;gap:14px;margin-bottom:22px;align-items:flex-start;">
                        <div style="width:42px;height:42px;background:rgba(255,255,255,0.1);border-radius:10px;
                                    display:flex;align-items:center;justify-content:center;
                                    color:#52b788;font-size:17px;flex-shrink:0;">
                            <i class="fa-solid fa-boxes-packing"></i>
                        </div>
                        <div>
                            <h5 style="color:#fff;font-size:14px;font-weight:700;margin-bottom:4px;">Custom Packaging & Branding</h5>
                            <p style="color:rgba(255,255,255,0.55);font-size:13px;margin:0;line-height:1.6;">
                                Private label shrink-wrap packaging, barcode insertions, and custom B2B boxes.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 2 -->
                    <div style="display:flex;gap:14px;margin-bottom:22px;align-items:flex-start;">
                        <div style="width:42px;height:42px;background:rgba(255,255,255,0.1);border-radius:10px;
                                    display:flex;align-items:center;justify-content:center;
                                    color:#52b788;font-size:17px;flex-shrink:0;">
                            <i class="fa-solid fa-ship"></i>
                        </div>
                        <div>
                            <h5 style="color:#fff;font-size:14px;font-weight:700;margin-bottom:4px;">FOB & CIF Shipping Terms</h5>
                            <p style="color:rgba(255,255,255,0.55);font-size:13px;margin:0;line-height:1.6;">
                                Container shipments via seaport customs clearance directly to your warehouse.
                            </p>
                        </div>
                    </div>

                    <!-- Feature 3 -->
                    <div style="display:flex;gap:14px;margin-bottom:32px;align-items:flex-start;">
                        <div style="width:42px;height:42px;background:rgba(255,255,255,0.1);border-radius:10px;
                                    display:flex;align-items:center;justify-content:center;
                                    color:#52b788;font-size:17px;flex-shrink:0;">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <div>
                            <h5 style="color:#fff;font-size:14px;font-weight:700;margin-bottom:4px;">Low Minimum Orders (MOQs)</h5>
                            <p style="color:rgba(255,255,255,0.55);font-size:13px;margin:0;line-height:1.6;">
                                Starting from 1,000 pieces per product category to trial market response.
                            </p>
                        </div>
                    </div>

                    <!-- Divider -->
                    <hr style="border:none;border-top:1px solid rgba(255,255,255,0.12);margin-bottom:24px;">

                    <!-- Quick contact -->
                    <p style="color:rgba(255,255,255,0.4);font-size:11px;text-transform:uppercase;
                               letter-spacing:0.08em;margin-bottom:12px;">Quick Contact</p>
                    <a href="https://wa.me/918874812003?text=Hi%20DonaMart%2C%20I%20want%20a%20bulk%20quotation."
                       target="_blank"
                       style="display:flex;align-items:center;gap:10px;background:rgba(37,211,102,0.15);
                              border:1px solid rgba(37,211,102,0.3);border-radius:10px;padding:12px 16px;
                              text-decoration:none;color:#fff;font-size:13px;font-weight:600;margin-bottom:10px;
                              transition:background 0.2s;"
                       onmouseover="this.style.background='rgba(37,211,102,0.25)'"
                       onmouseout="this.style.background='rgba(37,211,102,0.15)'">
                        <i class="fa-brands fa-whatsapp" style="color:#25d366;font-size:20px;"></i>
                        WhatsApp: +91 88748 12003
                    </a>
                    <a href="tel:+918874812003"
                       style="display:flex;align-items:center;gap:10px;background:rgba(255,255,255,0.07);
                              border:1px solid rgba(255,255,255,0.12);border-radius:10px;padding:12px 16px;
                              text-decoration:none;color:#fff;font-size:13px;font-weight:600;
                              transition:background 0.2s;"
                       onmouseover="this.style.background='rgba(255,255,255,0.12)'"
                       onmouseout="this.style.background='rgba(255,255,255,0.07)'">
                        <i class="fa-solid fa-phone" style="color:#52b788;font-size:16px;"></i>
                        Call: +91 88748 12003
                    </a>
                </div>
            </div>

            <!-- Right Form -->
            <div class="col-lg-7" data-aos="fade-left">
                <div style="background:#fff;border-radius:20px;padding:40px;
                            box-shadow:0 4px 24px rgba(0,0,0,0.06);border:1px solid #eee;">

                    <h3 style="font-size:22px;font-weight:700;color:#111;margin-bottom:4px;">
                        Quotation Enquiry Form
                    </h3>
                    <p style="font-size:13px;color:#999;margin-bottom:24px;">
                        Fields marked <span style="color:#e53e3e;">*</span> are required. We respond within 24 hours.
                    </p>

                    <!-- Response message -->
                    <div id="bulkMsg"></div>

                    <form id="bulkForm">
                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control"
                                       placeholder="Your full name" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name" class="form-control"
                                       placeholder="e.g. Eco Distributors Ltd">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                <input type="tel" name="phone" class="form-control"
                                       placeholder="+91 or country code" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control"
                                       placeholder="yourname@domain.com" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Product Required <span class="text-danger">*</span></label>
                                <select name="product_name" class="form-select" required>
                                    <option value="" disabled selected>Select a product</option>
                                    <?php foreach ($products as $p): ?>
                                        <option value="<?= htmlspecialchars($p['name']) ?>"
                                            <?= ($preselected_product === $p['name']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($p['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                    <option value="Custom Areca Leaf Tableware">Other / Custom</option>
                                    <option value="General Eco Tableware Bulk Enquiry">General Enquiry</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Expected Quantity <span class="text-danger">*</span></label>
                                <input type="number" name="quantity" class="form-control"
                                       min="1000" placeholder="Min. 1000 pieces" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Delivery Address & Port <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="3"
                                    placeholder="Street, City, State, Country, Pincode / Destination Port" required></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Special Requirements / Custom Packaging</label>
                                <textarea name="message" class="form-control" rows="3"
                                    placeholder="Size customizations, branding, certifications, etc."></textarea>
                            </div>

                            <!-- Trust badges -->
                            <div class="col-12">
                                <div style="display:flex;flex-wrap:wrap;gap:10px;padding:14px 16px;
                                            background:#f8f8f5;border-radius:10px;border:1px solid #eee;">
                                    <span style="font-size:12px;color:#555;display:flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-shield-halved" style="color:#3b6d11;"></i> Secure Submission
                                    </span>
                                    <span style="font-size:12px;color:#555;display:flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-clock" style="color:#3b6d11;"></i> 24hr Response
                                    </span>
                                    <span style="font-size:12px;color:#555;display:flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-certificate" style="color:#3b6d11;"></i> ISO 9001 Certified
                                    </span>
                                    <span style="font-size:12px;color:#555;display:flex;align-items:center;gap:6px;">
                                        <i class="fa-solid fa-globe" style="color:#3b6d11;"></i> Export to 18+ Countries
                                    </span>
                                </div>
                            </div>

                            <div class="col-12">
                                <button type="submit" id="bulkSubmitBtn"
                                    style="width:100%;background:var(--tan,#b5835a);color:#fff;border:none;
                                           padding:14px 24px;border-radius:50px;font-size:15px;font-weight:700;
                                           cursor:pointer;display:flex;align-items:center;justify-content:center;
                                           gap:8px;font-family:inherit;transition:background 0.2s,transform 0.1s;
                                           box-shadow:0 4px 14px rgba(181,131,90,0.35);"
                                    onmouseover="this.style.background='#9e6e48';this.style.transform='translateY(-1px)'"
                                    onmouseout="this.style.background='var(--tan,#b5835a)';this.style.transform=''">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    Submit Quotation Request
                                </button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
document.getElementById('bulkForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const btn   = document.getElementById('bulkSubmitBtn');
    const msgEl = document.getElementById('bulkMsg');

    btn.disabled   = true;
    btn.innerHTML  = '<i class="fa-solid fa-spinner fa-spin"></i> Sending...';
    msgEl.innerHTML = '';

    fetch('/DonaMart/actions/submit_bulk.php', {
        method: 'POST',
        body: new FormData(this)
    })
    .then(r => r.text())
    .then(text => {
        let data;
        try { data = JSON.parse(text); }
        catch(e) {
            console.error('Server response:', text);
            throw new Error('Server error. Please try again.');
        }

        if (data.success) {
            msgEl.innerHTML = `
                <div style="background:#eaf3de;border:1px solid #c3e6a0;border-radius:10px;
                            padding:16px 18px;margin-bottom:16px;color:#3b6d11;font-size:14px;
                            display:flex;align-items:flex-start;gap:10px;">
                    <i class="fa-solid fa-circle-check" style="font-size:20px;flex-shrink:0;margin-top:1px;"></i>
                    <div><strong>Request Submitted!</strong><br>${data.message}</div>
                </div>`;
            document.getElementById('bulkForm').reset();
        } else {
            msgEl.innerHTML = `
                <div style="background:#fcebeb;border:1px solid #f7c1c1;border-radius:10px;
                            padding:16px 18px;margin-bottom:16px;color:#a32d2d;font-size:14px;
                            display:flex;align-items:flex-start;gap:10px;">
                    <i class="fa-solid fa-circle-exclamation" style="font-size:20px;flex-shrink:0;margin-top:1px;"></i>
                    <div>${data.message}</div>
                </div>`;
        }
    })
    .catch(err => {
        msgEl.innerHTML = `
            <div style="background:#fcebeb;border:1px solid #f7c1c1;border-radius:10px;
                        padding:16px 18px;margin-bottom:16px;color:#a32d2d;font-size:14px;
                        display:flex;align-items:flex-start;gap:10px;">
                <i class="fa-solid fa-circle-exclamation" style="font-size:20px;flex-shrink:0;margin-top:1px;"></i>
                <div>${err.message}</div>
            </div>`;
    })
    .finally(() => {
        btn.disabled  = false;
        btn.innerHTML = '<i class="fa-solid fa-paper-plane"></i> Submit Quotation Request';
        msgEl.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>