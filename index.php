<?php
$page_title  = "Premium Eco-Friendly Tableware Manufacturer";
$active_page = "home";
$meta_desc   = "DonaMart is India's leading B2B manufacturer of organic, 100% biodegradable Dona, Pattal, Areca leaf plates, bowls and compartment plates.";

require_once 'config/db.php';
require_once 'includes/header.php';

try {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.is_featured = 1 AND p.status = 1 LIMIT 4");
    $stmt->execute();
    $featured_products = $stmt->fetchAll();
    $total_products    = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1")->fetchColumn();
} catch (PDOException $e) {
    $featured_products = [];
    $total_products    = 6;
}
?>

<!-- ── HERO ── -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center" style="min-height:82vh;">
            <div class="col-lg-7" data-aos="fade-right">
                <div class="hero-badge mb-4">
                    <i class="fa-solid fa-leaf"></i> 100% Biodegradable & Compostable
                </div>
                <h1 class="mb-4 font-weight-bold" style="color:#fff;font-size:clamp(2rem,4vw,3.2rem);line-height:1.15;">
                    Crafting a Greener<br>Tomorrow with<br>
                    <span style="color:var(--forest-light,#52b788);">Organic Tableware</span>
                </h1>
                <p class="mb-5" style="color:rgba(255,255,255,0.65);font-size:1.05rem;max-width:520px;line-height:1.75;">
                    Premium B2B manufacturer & bulk supplier of Areca Leaf Plates, Bowls,
                    Stitched Dona, and Pattal. Trusted by 2,500+ businesses across 18 countries.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 mb-5">
                    <a href="/DonaMart/products.php" class="btn btn-accent px-5 py-3 rounded-pill shadow-lg font-weight-bold">Explore Products</a>
                    <a href="/DonaMart/bulk-order.php" class="btn btn-outline-light px-5 py-3 rounded-pill font-weight-bold">Request Bulk Quote</a>
                </div>
                <div class="hero-trust-bar">
                    <div class="hero-trust-item"><i class="fa-solid fa-circle-check"></i> Chemical Free</div>
                    <div class="hero-trust-item"><i class="fa-solid fa-circle-check"></i> FDA Certified</div>
                    <div class="hero-trust-item"><i class="fa-solid fa-circle-check"></i> ISO 9001:2015</div>
                    <div class="hero-trust-item"><i class="fa-solid fa-circle-check"></i> Export Ready</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── ABOUT ── -->
<section class="py-5" style="background:var(--cream,#fcfaf5);">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-label">About DonaMart</span>
                <h2 class="mt-2 mb-4">Leading the Way in Sustainable Tableware Solutions</h2>
                <p class="text-muted mb-3">DonaMart is a premier B2B manufacturer and exporter of eco-friendly disposable tableware. Established with the mission to eliminate single-use plastics, we manufacture plates and bowls from naturally fallen palm leaves and organic agricultural residues.</p>
                <p class="text-muted mb-4">Our state-of-the-art facility combines traditional eco-practices with modern hydraulic pressing technology, ensuring each product is durable, hygienic, and perfectly shaped.</p>
                <div class="row g-3 mb-4">
                    <?php foreach(['Chemical & Dye Free','Microwave & Oven Safe','100% Compostable','Leak & Heat Resistant'] as $f): ?>
                    <div class="col-sm-6 d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check text-success fs-5"></i>
                        <span class="font-weight-bold text-dark"><?= $f ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <a href="/DonaMart/about.php" class="btn btn-outline-primary-custom rounded-pill px-4 py-2 font-weight-bold">Learn More About Us</a>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="/DonaMart/assets/images/about_image.png" alt="DonaMart Factory" class="img-fluid rounded-custom shadow-lg">
                    <div class="position-absolute bottom-0 end-0 m-3 d-none d-sm-block"
                         style="background:var(--forest,#1b4332);color:#fff;padding:16px 20px;border-radius:14px;box-shadow:0 4px 20px rgba(0,0,0,0.2);">
                        <div style="font-size:22px;font-weight:800;line-height:1;">100%</div>
                        <div style="font-size:12px;color:rgba(255,255,255,0.65);margin-top:2px;">Organic & Natural</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ── CATEGORIES — FIXED ── -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Categories</span>
            <h2 class="mt-2">Our Biodegradable Tableware Range</h2>
            <div class="section-divider mx-auto"></div>
        </div>

        <div class="row g-4">
            <?php
            // Each category: [name, slug, icon, gradient-colors, description]
            $cats = [
                ['Areca Leaf Plates',  'areca-leaf-plates',  'fa-plate-wheat',    '#2d6a4f','#1b4332', 'Round, square & oval plates from areca palm'],
                ['Dona',               'dona',               'fa-bowl-food',      '#5c4033','#3e2723', 'Stitched & pressed leaf bowls in all sizes'],
                ['Pattal',             'pattal',             'fa-leaf',           '#1b5e20','#0f2b1f', 'Traditional flat leaf plates, large & jumbo'],
                ['Bowls',              'bowls',              'fa-bowl-rice',      '#4a148c','#1b4332', 'Deep bowls for curries, soups & desserts'],
                ['Compartment Plates', 'compartment-plates', 'fa-table-cells',    '#e65100','#bf360c', '2 & 3 section divided meal plates'],
                ['Disposable Glasses', 'disposable-glasses', 'fa-wine-glass',     '#006064','#004d40', 'Eco paper & leaf glasses for events'],
            ];
            $delays = [100,200,300,400,500,600];
            foreach ($cats as $i => $cat): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= $delays[$i] ?>">
                <a href="/DonaMart/products.php?category=<?= $cat[1] ?>" style="text-decoration:none;">
                    <div style="
                        background: linear-gradient(135deg, <?= $cat[3] ?> 0%, <?= $cat[4] ?> 100%);
                        border-radius: 16px;
                        padding: 36px 28px;
                        position: relative;
                        overflow: hidden;
                        height: 200px;
                        display: flex;
                        flex-direction: column;
                        justify-content: flex-end;
                        transition: transform 0.25s, box-shadow 0.25s;
                        cursor: pointer;
                    "
                    onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.2)'"
                    onmouseout="this.style.transform='';this.style.boxShadow=''">

                        <!-- Background icon watermark -->
                        <i class="fa-solid <?= $cat[2] ?>"
                           style="position:absolute;top:16px;right:20px;font-size:72px;
                                  color:rgba(255,255,255,0.1);pointer-events:none;"></i>

                        <!-- Small icon badge -->
                        <div style="
                            width:44px;height:44px;
                            background:rgba(255,255,255,0.15);
                            border-radius:10px;
                            display:flex;align-items:center;justify-content:center;
                            margin-bottom:14px;
                        ">
                            <i class="fa-solid <?= $cat[2] ?>" style="color:#fff;font-size:20px;"></i>
                        </div>

                        <h4 style="color:#fff;font-size:18px;font-weight:700;margin:0 0 4px;"><?= $cat[0] ?></h4>
                        <p style="color:rgba(255,255,255,0.65);font-size:12px;margin:0 0 12px;"><?= $cat[5] ?></p>

                        <div style="display:inline-flex;align-items:center;gap:6px;
                                    color:rgba(255,255,255,0.9);font-size:13px;font-weight:600;">
                            View Products
                            <i class="fa-solid fa-arrow-right" style="font-size:11px;"></i>
                        </div>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── FEATURED PRODUCTS ── -->
<section class="py-5" style="background:var(--cream,#fcfaf5);">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5" data-aos="fade-up">
            <div>
                <span class="section-label">Bestsellers</span>
                <h2 class="mt-2 mb-0">Featured Products</h2>
            </div>
            <a href="/DonaMart/products.php" class="btn btn-outline-primary-custom px-4 py-2 rounded-pill mt-3 mt-md-0 font-weight-bold">View All Products</a>
        </div>
        <div class="row g-4">
            <?php if (!empty($featured_products)): ?>
                <?php foreach ($featured_products as $p): ?>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <span class="product-badge"><?= htmlspecialchars($p['category_name']) ?></span>
                            <a href="/DonaMart/product-details.php?slug=<?= urlencode($p['slug']) ?>">
                                <img src="/DonaMart/uploads/<?= htmlspecialchars($p['image']) ?>"
                                     alt="<?= htmlspecialchars($p['name']) ?>"
                                     onerror="this.src='/DonaMart/assets/images/placeholder.png'">
                            </a>
                        </div>
                        <div class="product-details">
                            <h4 class="h5 mb-2 font-weight-bold text-primary-dark">
                                <a href="/DonaMart/product-details.php?slug=<?= urlencode($p['slug']) ?>"
                                   class="text-decoration-none text-primary-dark hover-accent">
                                    <?= htmlspecialchars($p['name']) ?>
                                </a>
                            </h4>
                            <p class="text-muted text-sm mb-3"><?= htmlspecialchars(substr($p['description'],0,80)) ?>...</p>
                            <table class="table product-spec-table">
                                <tr><td>Sizes:</td><td><?= htmlspecialchars($p['sizes']) ?></td></tr>
                                <tr><td>Material:</td><td><?= htmlspecialchars($p['material']) ?></td></tr>
                                <tr><td>MOQ:</td><td><?= number_format($p['moq']) ?> pcs</td></tr>
                            </table>
                            <div class="product-actions d-grid gap-2">
                                <a href="/DonaMart/bulk-order.php?product=<?= urlencode($p['name']) ?>"
                                   class="btn btn-accent rounded-pill btn-sm font-weight-bold">Enquire Now</a>
                                <a href="https://wa.me/918874812003?text=Hi%20DonaMart,%20I'm%20interested%20in:%20<?= urlencode($p['name']) ?>"
                                   target="_blank" class="btn btn-whatsapp rounded-pill btn-sm font-weight-bold">
                                    <i class="fa-brands fa-whatsapp me-1"></i>WhatsApp Order
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
            <div class="col-12 text-center py-5">
                <i class="fa-solid fa-leaf text-muted" style="font-size:40px;opacity:0.3;display:block;margin-bottom:12px;"></i>
                <p class="text-muted mb-3">No featured products yet. Add products from admin panel.</p>
                <a href="/DonaMart/products.php" class="btn btn-accent rounded-pill px-4 font-weight-bold">Browse All Products</a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ── WHY CHOOSE US ── -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Our Strength</span>
            <h2 class="mt-2">Why Choose DonaMart?</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php
            $whys = [
                ['fa-industry',     'si-green', 'Large Scale Manufacturing',  'High-capacity hydraulic machines fulfill heavy bulk orders within strict deadlines without compromising quality.'],
                ['fa-shield-halved','si-teal',  'Quality Standards',          'Every batch undergoes rigorous quality checks for thickness, moisture control, and heat-sealing perfection.'],
                ['fa-globe',        'si-amber', 'Global Shipping',            'Trusted supply chain supplying sustainable tableware to domestic markets and exporting to 18+ countries.'],
                ['fa-leaf',         'si-green', '100% Eco Friendly',         'Zero chemicals, dyes or lacquers. Fully compostable within 60–90 days — returns nutrients back to soil.'],
                ['fa-tag',          'si-teal',  'Factory Direct Pricing',    'No middlemen. Direct factory rates for bulk buyers with flexible MOQs starting from 1,000 pieces.'],
                ['fa-headset',      'si-amber', 'Dedicated Support',         '24-hour response guarantee. Dedicated account managers for export clients and large distributors.'],
            ];
            foreach ($whys as $i => $w): ?>
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="<?= ($i+1)*100 ?>">
                <div class="why-card">
                    <div class="why-icon <?= $w[1] ?> mx-auto">
                        <i class="fa-solid <?= $w[0] ?>"></i>
                    </div>
                    <h4 class="mb-2 font-weight-bold" style="font-size:16px;"><?= $w[2] ?></h4>
                    <p class="text-muted mb-0" style="font-size:13px;"><?= $w[3] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── MANUFACTURING PROCESS ── -->
<section class="py-5" style="background:var(--cream,#fcfaf5);">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">How It's Made</span>
            <h2 class="mt-2">Our Manufacturing Process</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php
            $steps = [
                ['fa-leaf',       'Raw Material Collection', 'Naturally shed palm leaves collected from organic certified farms with zero tree cutting.'],
                ['fa-droplet',    'Washing & Sorting',       'Leaves washed with fresh water, cleaned of dirt, and sorted by quality grades.'],
                ['fa-gears',      'Hydraulic Pressing',      'Pressed and molded in high-heat hydraulic machines to give beautiful, uniform final shapes.'],
                ['fa-truck-fast', 'Quality Check & Dispatch','Sterilized, shrink-wrapped, and dispatched worldwide with proper documentation.'],
            ];
            foreach ($steps as $i => $s): ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i+1)*100 ?>">
                <div class="process-step">
                    <div class="process-step-num"><?= $i+1 ?></div>
                    <div class="process-icon-wrapper">
                        <i class="fa-solid <?= $s[0] ?>"></i>
                    </div>
                    <h4 class="h5 mt-3 font-weight-bold"><?= $s[1] ?></h4>
                    <p class="text-muted text-sm mb-0"><?= $s[2] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── STATS ── -->
<section class="py-5 stat-section text-center">
    <div class="container py-4" style="position:relative;z-index:1;">
        <div class="row g-4">
            <?php
            $stats = [['2,500+','Happy B2B Clients',100],['500+','Bulk Shipments Done',200],[$total_products.'+','Product SKUs',300],['18+','Export Countries',400]];
            foreach ($stats as $st): ?>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="<?= $st[2] ?>">
                <div class="stat-box">
                    <h2><?= $st[0] ?></h2>
                    <p class="mb-0 font-weight-bold" style="color:rgba(255,255,255,0.6);"><?= $st[1] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── TESTIMONIALS ── -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="section-label">Client Feedback</span>
            <h2 class="mt-2">What Our Clients Say</h2>
            <div class="section-divider mx-auto"></div>
        </div>
        <div class="row g-4">
            <?php
            $testimonials = [
                ['"DonaMart\'s Areca Leaf Plates are exceptionally sturdy. We ordered 10,000 plates for our corporate eco-buffet and the feedback was outstanding. Material feels premium, unlike cardboard."',
                 'Vaibhaw Singh','Operations Director, Green Catering Corp','g1.png'],
                ['"Finding a reliable B2B supplier of organic stitched Dona and Pattal was difficult until we found DonaMart. Their supply chain is robust and MOQ terms are very business-friendly."',
                 'Rahul Mehta','Procurement Head, Organic Grocers Ltd','g2.png'],
                ['"Excellent quality compartment plates for our restaurant chain. DonaMart delivered 50,000 units on time with perfect packaging. Will definitely reorder. Highly recommended!"',
                 'Priya Sharma','Owner, EcoEats Restaurant Chain','g3.png'],
            ];
            foreach ($testimonials as $i => $t): ?>
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?= ($i+1)*100 ?>">
                <div class="testimonial-card">
                    <div class="testimonial-stars">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                    </div>
                    <p class="text-muted italic mb-0" style="font-size:14px;line-height:1.7;"><?= $t[0] ?></p>
                    <div class="testimonial-user">
                        <img src="/DonaMart/uploads/<?= $t[3] ?>" alt="<?= $t[1] ?>"
                             class="testimonial-avatar"
                             onerror="this.style.display='none'">
                        <div>
                            <h5 class="mb-0 font-weight-bold text-primary-dark" style="font-size:14px;"><?= $t[1] ?></h5>
                            <small class="text-muted"><?= $t[2] ?></small>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ── CTA ── -->
<section class="container my-5 py-2" data-aos="zoom-in">
    <div class="cta-section text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8" style="position:relative;z-index:1;">
                <span class="section-label" style="color:var(--tan,#b5835a);">Partner With Us</span>
                <h2 class="font-weight-bold mb-3 mt-2" style="color:#fff;">Ready to Make the Eco-Friendly Shift?</h2>
                <p class="mb-5" style="color:rgba(255,255,255,0.6);font-size:15px;max-width:500px;margin:0 auto 28px;line-height:1.7;">
                    Partner with DonaMart for premium quality tableware. Customized packaging, custom sizes, and direct shipping for distributors worldwide.
                </p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                    <a href="/DonaMart/bulk-order.php" class="btn btn-accent px-5 py-3 rounded-pill font-weight-bold shadow-md">Get B2B Price List</a>
                    <a href="/DonaMart/contact.php" class="btn btn-outline-light px-5 py-3 rounded-pill font-weight-bold">Talk to Sales Expert</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>