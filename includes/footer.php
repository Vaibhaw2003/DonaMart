<!-- ── Footer ── -->
<footer style="background: var(--forest-dark, #0f2b1f); padding: 64px 0 0;">

    <!-- Main Footer Grid -->
    <div class="container">
        <div class="row g-5 pb-5" style="border-bottom: 1px solid rgba(255,255,255,0.08);">

            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6">
                <a href="/DonaMart/index.php" style="display:inline-flex;align-items:center;gap:10px;text-decoration:none;margin-bottom:20px;">
                    <div style="width:40px;height:40px;background:var(--forest-mid,#2d6a4f);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#52b788;font-size:20px;">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <div>
                        <div style="font-size:20px;font-weight:800;color:#fff;line-height:1;">DonaMart</div>
                        <div style="font-size:10px;color:rgba(255,255,255,0.4);letter-spacing:0.08em;text-transform:uppercase;">Eco Tableware</div>
                    </div>
                </a>
                <p style="color:rgba(255,255,255,0.55);font-size:14px;line-height:1.7;margin-bottom:24px;">
                    India's leading B2B manufacturer and exporter of biodegradable Areca leaf plates, Dona, Pattal, and eco-friendly tableware. Serving 2,500+ clients across 18 countries.
                </p>
                <!-- Certifications -->
                <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:24px;">
                    <div style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:8px;padding:6px 12px;font-size:11px;color:rgba(255,255,255,0.6);font-weight:600;">ISO 9001:2015</div>
                    <div style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:8px;padding:6px 12px;font-size:11px;color:rgba(255,255,255,0.6);font-weight:600;">FDA Certified</div>
                    <div style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12);border-radius:8px;padding:6px 12px;font-size:11px;color:rgba(255,255,255,0.6);font-weight:600;">CE Mark</div>
                </div>
                <!-- Social Links -->
                <div style="display:flex;gap:8px;">
                    <a href="#" aria-label="Facebook"  style="width:36px;height:36px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);font-size:15px;text-decoration:none;transition:background 0.2s,color 0.2s;" onmouseover="this.style.background='#b5835a';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" aria-label="Instagram" style="width:36px;height:36px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);font-size:15px;text-decoration:none;transition:background 0.2s,color 0.2s;" onmouseover="this.style.background='#b5835a';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#" aria-label="LinkedIn"  style="width:36px;height:36px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);font-size:15px;text-decoration:none;transition:background 0.2s,color 0.2s;" onmouseover="this.style.background='#b5835a';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://wa.me/918874812003" aria-label="WhatsApp" style="width:36px;height:36px;background:rgba(255,255,255,0.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,0.6);font-size:15px;text-decoration:none;transition:background 0.2s,color 0.2s;" onmouseover="this.style.background='#25d366';this.style.color='#fff'" onmouseout="this.style.background='rgba(255,255,255,0.08)';this.style.color='rgba(255,255,255,0.6)'"><i class="fa-brands fa-whatsapp"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 style="color:#fff;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:18px;">Quick Links</h6>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                    <?php
                    $links = [
                        ['Home',        '/DonaMart/index.php'],
                        ['Products',    '/DonaMart/products.php'],
                        ['Gallery',     '/DonaMart/gallery.php'],
                        ['About Us',    '/DonaMart/about.php'],
                        ['Contact',     '/DonaMart/contact.php'],
                        ['Bulk Order',  '/DonaMart/bulk-order.php'],
                    ];
                    foreach ($links as $l): ?>
                    <li>
                        <a href="<?= $l[1] ?>" style="color:rgba(255,255,255,0.55);font-size:14px;text-decoration:none;display:flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#b5835a'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">
                            <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--tan,#b5835a);"></i><?= $l[0] ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Products -->
            <div class="col-lg-2 col-md-3 col-6">
                <h6 style="color:#fff;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:18px;">Products</h6>
                <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:10px;">
                    <?php
                    $prods = [
                        'Areca Leaf Plates',
                        'Dona & Bowls',
                        'Pattal Leaves',
                        'Compartment Plates',
                        'Disposable Glasses',
                        'Custom Tableware',
                    ];
                    foreach ($prods as $pr): ?>
                    <li>
                        <a href="/DonaMart/products.php" style="color:rgba(255,255,255,0.55);font-size:14px;text-decoration:none;display:flex;align-items:center;gap:6px;transition:color 0.2s;" onmouseover="this.style.color='#b5835a'" onmouseout="this.style.color='rgba(255,255,255,0.55)'">
                            <i class="fa-solid fa-chevron-right" style="font-size:9px;color:var(--tan,#b5835a);"></i><?= $pr ?>
                        </a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Contact Info + Newsletter -->
            <div class="col-lg-4 col-md-6">
                <h6 style="color:#fff;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:18px;">Get In Touch</h6>

                <div style="display:flex;flex-direction:column;gap:14px;margin-bottom:28px;">
                    <div style="display:flex;gap:12px;align-items:flex-start;">
                        <div style="width:34px;height:34px;background:rgba(255,255,255,0.07);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#52b788;font-size:14px;flex-shrink:0;">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <div>
                            <div style="font-size:12px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px;">Address</div>
                            <div style="font-size:14px;color:rgba(255,255,255,0.75);">Maruti Nagar Colony, Lanka, Varanasi – 221005</div>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;">
                        <div style="width:34px;height:34px;background:rgba(255,255,255,0.07);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#52b788;font-size:14px;flex-shrink:0;">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <div>
                            <div style="font-size:12px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px;">Phone</div>
                            <a href="tel:+918874812003" style="font-size:14px;color:rgba(255,255,255,0.75);text-decoration:none;">+91 88748 12003</a> &nbsp;|&nbsp;
                            <a href="tel:+919984020040" style="font-size:14px;color:rgba(255,255,255,0.75);text-decoration:none;">+91 99840 20040</a>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;">
                        <div style="width:34px;height:34px;background:rgba(255,255,255,0.07);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#52b788;font-size:14px;flex-shrink:0;">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <div>
                            <div style="font-size:12px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px;">Email</div>
                            <a href="mailto:vaibhawrajput05@gmail.com" style="font-size:14px;color:rgba(255,255,255,0.75);text-decoration:none;">donamartvns@gmail.com</a>
                        </div>
                    </div>
                    <div style="display:flex;gap:12px;align-items:center;">
                        <div style="width:34px;height:34px;background:rgba(255,255,255,0.07);border-radius:8px;display:flex;align-items:center;justify-content:center;color:#25d366;font-size:14px;flex-shrink:0;">
                            <i class="fa-brands fa-whatsapp"></i>
                        </div>
                        <div>
                            <div style="font-size:12px;color:rgba(255,255,255,0.4);text-transform:uppercase;letter-spacing:0.06em;margin-bottom:2px;">WhatsApp (Orders)</div>
                            <a href="https://wa.me/918874812003" target="_blank" style="font-size:14px;color:rgba(255,255,255,0.75);text-decoration:none;">+91 88748 12003</a>
                        </div>
                    </div>
                </div>

                <!-- Newsletter -->
                <h6 style="color:#fff;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:12px;">Newsletter</h6>
                <div id="footerNewsletterMsg"></div>
                <form id="footerNewsletterForm" style="display:flex;gap:0;border-radius:10px;overflow:hidden;border:1px solid rgba(255,255,255,0.15);">
                    <input type="email" id="footerEmail" placeholder="Your email address" required
                        style="flex:1;background:rgba(255,255,255,0.07);border:none;padding:11px 14px;color:#fff;font-size:13px;outline:none;min-width:0;">
                    <button type="submit"
                        style="background:var(--tan,#b5835a);color:#fff;border:none;padding:11px 18px;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;transition:background 0.2s;"
                        onmouseover="this.style.background='#9e6e48'" onmouseout="this.style.background='var(--tan,#b5835a)'">
                        Subscribe
                    </button>
                </form>
                <p style="font-size:11px;color:rgba(255,255,255,0.3);margin-top:8px;">No spam. Unsubscribe anytime.</p>
            </div>

        </div>
    </div>

    <!-- Bottom Bar -->
    <div style="padding:20px 0;">
        <div class="container">
            <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                <p style="font-size:13px;color:rgba(255,255,255,0.35);margin:0;">
                    &copy; <?= date('Y') ?> DonaMart. All rights reserved. Made with <i class="fa-solid fa-heart" style="color:#b5835a;font-size:11px;"></i> in Varanasi, India.
                </p>
                <div style="display:flex;gap:20px;">
                    <a href="#" style="font-size:12px;color:rgba(255,255,255,0.3);text-decoration:none;" onmouseover="this.style.color='rgba(255,255,255,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">Privacy Policy</a>
                    <a href="#" style="font-size:12px;color:rgba(255,255,255,0.3);text-decoration:none;" onmouseover="this.style.color='rgba(255,255,255,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">Terms of Use</a>
                    <a href="#" style="font-size:12px;color:rgba(255,255,255,0.3);text-decoration:none;" onmouseover="this.style.color='rgba(255,255,255,0.7)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">Sitemap</a>
                </div>
            </div>
        </div>
    </div>

</footer>

<!-- Floating WhatsApp Button -->
<a href="https://wa.me/918874812003?text=Hi%20DonaMart%2C%20I%27m%20interested%20in%20your%20eco-friendly%20products.%20Please%20share%20details."
   target="_blank" rel="noopener"
   aria-label="Chat on WhatsApp"
   style="position:fixed;bottom:24px;right:24px;width:54px;height:54px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-size:26px;text-decoration:none;z-index:999;box-shadow:0 4px 20px rgba(37,211,102,0.45);transition:transform 0.2s,box-shadow 0.2s;"
   onmouseover="this.style.transform='scale(1.1)';this.style.boxShadow='0 6px 28px rgba(37,211,102,0.55)'"
   onmouseout="this.style.transform='scale(1)';this.style.boxShadow='0 4px 20px rgba(37,211,102,0.45)'">
    <i class="fa-brands fa-whatsapp"></i>
</a>

<!-- Scroll to Top -->
<button id="scrollTopBtn" aria-label="Back to top"
    style="position:fixed;bottom:88px;right:24px;width:40px;height:40px;background:#fff;border:1px solid #ddd;border-radius:10px;display:none;align-items:center;justify-content:center;color:#555;font-size:16px;cursor:pointer;z-index:999;box-shadow:0 2px 10px rgba(0,0,0,0.1);transition:all 0.2s;"
    onmouseover="this.style.background='var(--forest,#1b4332)';this.style.color='#fff';this.style.borderColor='var(--forest,#1b4332)'"
    onmouseout="this.style.background='#fff';this.style.color='#555';this.style.borderColor='#ddd'">
    <i class="fa-solid fa-chevron-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AOS -->
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 600, easing: 'ease-out-cubic', once: true, offset: 60 });

// Scroll to top
const scrollBtn = document.getElementById('scrollTopBtn');
window.addEventListener('scroll', () => {
    scrollBtn.style.display = window.scrollY > 400 ? 'flex' : 'none';
});
scrollBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));

// Newsletter form
const footerForm = document.getElementById('footerNewsletterForm');
if (footerForm) {
    footerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = document.getElementById('footerEmail').value.trim();
        const msgEl = document.getElementById('footerNewsletterMsg');
        if (!email) return;
        fetch('/DonaMart/actions/subscribe_newsletter.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'email=' + encodeURIComponent(email)
        })
        .then(r => r.json())
        .then(data => {
            msgEl.innerHTML = `<div style="padding:8px 12px;border-radius:8px;font-size:13px;margin-bottom:10px;background:${data.success?'rgba(82,183,136,0.15)':'rgba(239,68,68,0.15)'};color:${data.success?'#86efac':'#fca5a5'};border:1px solid ${data.success?'rgba(82,183,136,0.3)':'rgba(239,68,68,0.3)'}">${data.message}</div>`;
            if (data.success) footerForm.reset();
        })
        .catch(() => {
            msgEl.innerHTML = `<div style="padding:8px 12px;border-radius:8px;font-size:13px;margin-bottom:10px;background:rgba(239,68,68,0.15);color:#fca5a5;border:1px solid rgba(239,68,68,0.3)">Something went wrong. Please try again.</div>`;
        });
    });
}

// Bulk enquiry AJAX
const bulkForm = document.getElementById('bulkForm');
if (bulkForm) {
    bulkForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = bulkForm.querySelector('button[type="submit"]');
        const msgEl = document.getElementById('bulkMsg');
        btn.disabled = true;
        btn.textContent = 'Sending...';
        fetch('/DonaMart/actions/submit_bulk.php', {
            method: 'POST',
            body: new FormData(bulkForm)
        })
        .then(r => r.json())
        .then(data => {
            msgEl.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'} rounded-3 mb-4">${data.message}</div>`;
            if (data.success) bulkForm.reset();
        })
        .catch(() => {
            msgEl.innerHTML = `<div class="alert alert-danger rounded-3 mb-4">Something went wrong. Please try again.</div>`;
        })
        .finally(() => { btn.disabled = false; btn.textContent = 'Submit Quotation Request'; });
    });
}

// Contact form AJAX
const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = contactForm.querySelector('button[type="submit"]');
        const msgEl = document.getElementById('contactMsg');
        btn.disabled = true;
        btn.textContent = 'Sending...';
        fetch('/DonaMart/actions/submit_contact.php', {
            method: 'POST',
            body: new FormData(contactForm)
        })
        .then(r => r.json())
        .then(data => {
            msgEl.innerHTML = `<div class="alert alert-${data.success ? 'success' : 'danger'} rounded-3 mb-4">${data.message}</div>`;
            if (data.success) contactForm.reset();
        })
        .catch(() => {
            msgEl.innerHTML = `<div class="alert alert-danger rounded-3 mb-4">Something went wrong. Please try again.</div>`;
        })
        .finally(() => { btn.disabled = false; btn.textContent = 'Send Message'; });
    });
}
</script>
</body>
</html>