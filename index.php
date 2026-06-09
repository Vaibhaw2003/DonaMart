<?php
$page_title = "Premium Eco-Friendly Tableware Manufacturer";
$active_page = "home";
$meta_desc = "DonaMart is India's leading B2B manufacturer of organic, 100% biodegradable and compostable Dona, Pattal, Areca leaf plates, bowls, and compartment plates.";

require_once 'config/db.php';
require_once 'includes/header.php';

// Fetch featured products
try {
    $stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE p.is_featured = 1 AND p.status = 1 LIMIT 4");
    $stmt->execute();
    $featured_products = $stmt->fetchAll();
    
    // Count total products for stats
    $prod_count_stmt = $pdo->query("SELECT COUNT(*) FROM products WHERE status = 1");
    $total_products = $prod_count_stmt->fetchColumn();
} catch (PDOException $e) {
    $featured_products = [];
    $total_products = 6;
}
?>

<!-- Hero Banner Section -->
<section class="hero-section">
    <div class="container text-center text-md-start">
        <div class="row align-items-center">
            <div class="col-lg-8" data-aos="fade-right">
                <span class="badge bg-accent-custom mb-3 px-3 py-2 text-uppercase font-weight-bold">100% Biodegradable & Compostable</span>
                <h1 class="mb-3 font-weight-bold">Crafting a Greener Tomorrow with Organic Tableware</h1>
                <p class="lead mb-4 text-white-50">Premium manufacturer & bulk supplier of Areca Leaf Plates, Bowls, Stitched Dona, and Pattal. Join the sustainable revolution.</p>
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center justify-content-md-start">
                    <a href="/DonaMart/products.php" class="btn btn-accent px-5 py-3 rounded-pill shadow-lg font-weight-bold">Explore Products</a>
                    <a href="/DonaMart/bulk-order.php" class="btn btn-outline-light px-5 py-3 rounded-pill font-weight-bold">Request Bulk Quote</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Company Introduction -->
<section class="py-5">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <div class="pe-lg-4">
                    <span class="text-accent text-uppercase font-weight-bold fs-6">About DonaMart</span>
                    <h2 class="mt-2 mb-4">Leading the Way in Sustainable Tableware Solutions</h2>
                    <p class="text-muted mb-4">
                        DonaMart is a premier B2B manufacturer and exporter of eco-friendly disposable tableware. Established with the mission to eliminate single-use plastics, we manufacture plates and bowls from naturally fallen palm leaves and organic agricultural residues.
                    </p>
                    <p class="text-muted mb-4">
                        Our state-of-the-art manufacturing facility combines traditional eco-practices with modern hydraulic pressing technology, ensuring each product is durable, hygienic, and perfectly shaped.
                    </p>
                    <div class="row g-3">
                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa-solid fa-circle-check text-success fs-4 me-2"></i>
                            <span class="font-weight-bold text-dark">Chemical & Dye Free</span>
                        </div>
                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa-solid fa-circle-check text-success fs-4 me-2"></i>
                            <span class="font-weight-bold text-dark">Microwave & Oven Safe</span>
                        </div>
                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa-solid fa-circle-check text-success fs-4 me-2"></i>
                            <span class="font-weight-bold text-dark">100% Compostable</span>
                        </div>
                        <div class="col-sm-6 d-flex align-items-center">
                            <i class="fa-solid fa-circle-check text-success fs-4 me-2"></i>
                            <span class="font-weight-bold text-dark">Leak & Heat Resistant</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <div class="position-relative">
                    <img src="/DonaMart/assets/images/about_image.png" alt="DonaMart Factory" class="img-fluid rounded-custom shadow-lg">
                    <div class="position-absolute bottom-0 end-0 bg-primary-custom text-white p-4 rounded-custom m-4 d-none d-sm-block shadow-lg">
                        <h5 class="mb-0 font-weight-bold">100% Organic</h5>
                        <p class="mb-0 text-white-50">Zero environmental footprint</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Product Categories Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="text-accent text-uppercase font-weight-bold">Categories</span>
            <h2 class="mt-2">Our Biodegradable Tableware Range</h2>
            <div class="mx-auto bg-accent-custom mt-3" style="width: 60px; height: 3px;"></div>
        </div>

        <div class="row g-4">
            <!-- Category 1: Areca Leaf Plates -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="category-card">
                    <div class="category-img-container">
                        <img src="/DonaMart/uploads/areca_square.png" alt="Areca Leaf Plates">
                        <div class="category-overlay">
                            <div>
                                <h4 class="text-white mb-1">Areca Leaf Plates</h4>
                                <a href="/DonaMart/products.php?category=areca-leaf-plates" class="text-accent-light text-decoration-none">View Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category 2: Dona (Leaf Bowls) -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="category-card">
                    <div class="category-img-container">
                        <img src="/DonaMart/uploads/dona_sal.png" alt="Leaf Dona">
                        <div class="category-overlay">
                            <div>
                                <h4 class="text-white mb-1">Dona</h4>
                                <a href="/DonaMart/products.php?category=dona" class="text-accent-light text-decoration-none">View Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category 3: Pattal -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="category-card">
                    <div class="category-img-container">
                        <img src="/DonaMart/uploads/paper_glass.png" alt="Leaf Pattal">
                        <div class="category-overlay">
                            <div>
                                <h4 class="text-white mb-1">Pattal</h4>
                                <a href="/DonaMart/products.php?category=pattal" class="text-accent-light text-decoration-none">View Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category 4: Bowls -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="category-card">
                    <div class="category-img-container">
                        <img src="/DonaMart/uploads/areca_bowl.png" alt="Areca Bowls">
                        <div class="category-overlay">
                            <div>
                                <h4 class="text-white mb-1">Bowls</h4>
                                <a href="/DonaMart/products.php?category=bowls" class="text-accent-light text-decoration-none">View Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category 5: Compartment Plates -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="category-card">
                    <div class="category-img-container">
                        <img src="/DonaMart/uploads/areca_3comp.png" alt="Compartment Plates">
                        <div class="category-overlay">
                            <div>
                                <h4 class="text-white mb-1">Compartment Plates</h4>
                                <a href="/DonaMart/products.php?category=compartment-plates" class="text-accent-light text-decoration-none">View Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Category 6: Disposable Glasses -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="category-card">
                    <div class="category-img-container">
                        <img src="/DonaMart/uploads/paper_glass.png" alt="Disposable Glasses">
                        <div class="category-overlay">
                            <div>
                                <h4 class="text-white mb-1">Disposable Glasses</h4>
                                <a href="/DonaMart/products.php?category=disposable-glasses" class="text-accent-light text-decoration-none">View Products <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-5">
    <div class="container py-4">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5" data-aos="fade-up">
            <div>
                <span class="text-accent text-uppercase font-weight-bold">Bestsellers</span>
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
                                <span class="product-badge"><?php echo htmlspecialchars($p['category_name']); ?></span>
                                <a href="/DonaMart/product-details.php?slug=<?php echo urlencode($p['slug']); ?>">
                                    <img src="/DonaMart/uploads/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
                                </a>
                            </div>
                            <div class="product-details">
                                <h4 class="h5 mb-2 font-weight-bold text-primary-dark">
                                    <a href="/DonaMart/product-details.php?slug=<?php echo urlencode($p['slug']); ?>" class="text-decoration-none text-primary-dark hover-accent">
                                        <?php echo htmlspecialchars($p['name']); ?>
                                    </a>
                                </h4>
                                <p class="text-muted text-sm mb-3 flex-grow-1"><?php echo htmlspecialchars(substr($p['description'], 0, 80)) . '...'; ?></p>
                                
                                <table class="table product-spec-table">
                                    <tr>
                                        <td>Sizes:</td>
                                        <td><?php echo htmlspecialchars($p['sizes']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>Material:</td>
                                        <td><?php echo htmlspecialchars($p['material']); ?></td>
                                    </tr>
                                    <tr>
                                        <td>MOQ:</td>
                                        <td><?php echo htmlspecialchars($p['moq']); ?> pcs</td>
                                    </tr>
                                </table>
                                
                                <div class="product-actions d-grid gap-2">
                                    <a href="/DonaMart/bulk-order.php?product=<?php echo urlencode($p['name']); ?>" class="btn btn-accent rounded-pill btn-sm font-weight-bold">Enquire Now</a>
                                    <a href="https://wa.me/919876543210?text=Hi%20DonaMart,%20I'm%20interested%20in%20your%20product:%20<?php echo urlencode($p['name']); ?>" target="_blank" class="btn btn-whatsapp rounded-pill btn-sm font-weight-bold"><i class="fa-brands fa-whatsapp me-1"></i> WhatsApp Order</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">No featured products found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="text-accent text-uppercase font-weight-bold">Our Strength</span>
            <h2 class="mt-2">Why Choose DonaMart?</h2>
            <div class="mx-auto bg-accent-custom mt-3" style="width: 60px; height: 3px;"></div>
        </div>

        <div class="row g-4">
            <!-- Reason 1 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="100">
                <div class="p-4 text-center border-0 card h-100">
                    <div class="mx-auto mb-3 bg-accent-custom text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-industry fs-3"></i>
                    </div>
                    <h4 class="mb-2">Large Scale Manufacturing</h4>
                    <p class="text-muted mb-0">With our high-capacity hydraulic machines, we fulfill heavy bulk orders within strict deadlines without compromising quality.</p>
                </div>
            </div>
            <!-- Reason 2 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="200">
                <div class="p-4 text-center border-0 card h-100">
                    <div class="mx-auto mb-3 bg-primary-custom text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-shield-halved fs-3"></i>
                    </div>
                    <h4 class="mb-2">Quality Standards</h4>
                    <p class="text-muted mb-0">Every batch undergoes rigorous quality check procedures, checking for thickness, moisture control, and heat-sealing perfection.</p>
                </div>
            </div>
            <!-- Reason 3 -->
            <div class="col-lg-4 col-md-6" data-aos="zoom-in" data-aos-delay="300">
                <div class="p-4 text-center border-0 card h-100">
                    <div class="mx-auto mb-3 bg-accent-custom text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-globe fs-3"></i>
                    </div>
                    <h4 class="mb-2">Global Shipping</h4>
                    <p class="text-muted mb-0">We have a trusted supply chain network supplying sustainable tableware to domestic markets and exporting worldwide.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Manufacturing Process -->
<section class="py-5">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="text-accent text-uppercase font-weight-bold">How it's made</span>
            <h2 class="mt-2">Our Manufacturing Process</h2>
            <div class="mx-auto bg-accent-custom mt-3" style="width: 60px; height: 3px;"></div>
        </div>

        <div class="row g-4">
            <!-- Step 1 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="process-step">
                    <div class="process-icon-wrapper">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <h4 class="h5 mt-3 font-weight-bold">Raw Material</h4>
                    <p class="text-muted text-sm">We collect naturally shed palm leaves directly from organic certified farms.</p>
                </div>
            </div>
            <!-- Step 2 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="process-step">
                    <div class="process-icon-wrapper">
                        <i class="fa-solid fa-water"></i>
                    </div>
                    <h4 class="h5 mt-3 font-weight-bold">Washing & Sorting</h4>
                    <p class="text-muted text-sm">Leaves are washed with fresh water to clean dirt, and selected by quality grades.</p>
                </div>
            </div>
            <!-- Step 3 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="process-step">
                    <div class="process-icon-wrapper">
                        <i class="fa-solid fa-gears"></i>
                    </div>
                    <h4 class="h5 mt-3 font-weight-bold">Hydraulic Pressing</h4>
                    <p class="text-muted text-sm">Pressed and molded in high-heat hydraulic machines to give them beautiful final shapes.</p>
                </div>
            </div>
            <!-- Step 4 -->
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="process-step">
                    <div class="process-icon-wrapper">
                        <i class="fa-solid fa-truck-fast"></i>
                    </div>
                    <h4 class="h5 mt-3 font-weight-bold">Quality Check & Dispatch</h4>
                    <p class="text-muted text-sm">Sterilized, packed securely in shrink wrap, and dispatched for global deliveries.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="py-5 stat-section text-center">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-box">
                    <h2>2.5K+</h2>
                    <p class="text-white-50 mb-0 font-weight-bold">Happy B2B Clients</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-box">
                    <h2>500+</h2>
                    <p class="text-white-50 mb-0 font-weight-bold">Bulk Shipments Done</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-box">
                    <h2><?php echo $total_products; ?>+</h2>
                    <p class="text-white-50 mb-0 font-weight-bold">Product SKUs</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-box">
                    <h2>8+</h2>
                    <p class="text-white-50 mb-0 font-weight-bold">Years of Experience</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Customer Testimonials -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="text-accent text-uppercase font-weight-bold">Feedback</span>
            <h2 class="mt-2">What Our Clients Say</h2>
            <div class="mx-auto bg-accent-custom mt-3" style="width: 60px; height: 3px;"></div>
        </div>

        <div class="row g-4">
            <!-- Testimonial 1 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="testimonial-card">
                    <p class="text-muted italic">
                        "DonaMart's Areca Leaf Plates are exceptionally sturdy. We ordered 10,000 plates for our corporate eco-buffet, and the feedback was outstanding. The material feels premium, unlike cardboard."
                    </p>
                    <div class="testimonial-user">
                        <img src="/DonaMart/uploads/g1.png" alt="Client Avatar" class="testimonial-avatar">
                        <div>
                            <h5 class="mb-0 font-weight-bold text-primary-dark">Vaibhaw Singh</h5>
                            <small class="text-muted">Operations Director, Green Catering Corp</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Testimonial 2 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="testimonial-card">
                    <p class="text-muted italic">
                        "Finding a reliable B2B supplier of organic stitched Dona and Pattal was difficult until we found DonaMart. Their supply chain is robust, and MOQ terms are very business-friendly."
                    </p>
                    <div class="testimonial-user">
                        <img src="/DonaMart/uploads/g2.png" alt="Client Avatar" class="testimonial-avatar">
                        <div>
                            <h5 class="mb-0 font-weight-bold text-primary-dark">Satyam Singh</h5>
                            <small class="text-muted">Procurement Head, Organic Grocers Ltd</small>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Testimonial 3 -->
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card">
                    <p class="text-muted italic">
                        "We are committed to delivering high-quality, eco-friendly compartment plates and bowls manufactured with a focus on durability, sustainability, and customer satisfaction."
                    </p>
                    <div class="testimonial-user">
                        <img src="/DonaMart/uploads/g3.png" alt="Client Avatar" class="testimonial-avatar">
                        <div>
                            <h5 class="mb-0 font-weight-bold text-primary-dark">Satyam Singh</h5>
                            <small class="text-muted">Procurement Head, Organic Grocers Ltd</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call-to-action Section -->
<section class="container my-5 py-5 cta-section text-center" data-aos="zoom-in">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h2 class="font-weight-bold mb-3">Ready to Make the Eco-Friendly Shift?</h2>
            <p class="lead text-white-50 mb-4">Partner with DonaMart for premium quality tableware. We offer customized packaging, customized sizes, and direct shipping for distributors worldwide.</p>
            <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                <a href="/DonaMart/bulk-order.php" class="btn btn-light px-5 py-3 rounded-pill font-weight-bold text-primary-dark shadow-sm">Get B2B Price List</a>
                <a href="/DonaMart/contact.php" class="btn btn-outline-light px-5 py-3 rounded-pill font-weight-bold">Talk to Sales Expert</a>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
