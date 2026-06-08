// DonaMart Main JS Script

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Initialize AOS (Animate on Scroll)
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    }

    // 2. Navbar Scroll Effect
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', function() {
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // 3. Scroll to Top Button
    const scrollToTopBtn = document.getElementById('scrollToTopBtn');
    if (scrollToTopBtn) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                scrollToTopBtn.style.display = 'flex';
                scrollToTopBtn.style.alignItems = 'center';
                scrollToTopBtn.style.justifyContent = 'center';
            } else {
                scrollToTopBtn.style.display = 'none';
            }
        });

        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    // 4. Newsletter Subscription Form AJAX
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterMsg = document.getElementById('newsletterMsg');
    
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(newsletterForm);
            
            newsletterMsg.innerHTML = '<span class="text-info"><i class="fa-solid fa-circle-notch fa-spin me-1"></i> Subscribing...</span>';
            
            fetch('/DonaMart/actions/newsletter_sub.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    newsletterMsg.innerHTML = `<span class="text-success"><i class="fa-solid fa-circle-check me-1"></i> ${data.message}</span>`;
                    newsletterForm.reset();
                } else {
                    newsletterMsg.innerHTML = `<span class="text-danger"><i class="fa-solid fa-circle-xmark me-1"></i> ${data.message}</span>`;
                }
            })
            .catch(error => {
                newsletterMsg.innerHTML = '<span class="text-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Something went wrong. Please try again.</span>';
            });
        });
    }

    // 5. Contact Form AJAX (if present)
    const contactForm = document.getElementById('contactForm');
    const contactMsg = document.getElementById('contactMsg');
    
    if (contactForm && contactMsg) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(contactForm);
            contactMsg.innerHTML = '<div class="alert alert-info"><i class="fa-solid fa-circle-notch fa-spin me-1"></i> Sending message...</div>';
            
            fetch('/DonaMart/actions/contact_msg.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    contactMsg.innerHTML = `<div class="alert alert-success"><i class="fa-solid fa-circle-check me-1"></i> ${data.message}</div>`;
                    contactForm.reset();
                } else {
                    contactMsg.innerHTML = `<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-1"></i> ${data.message}</div>`;
                }
            })
            .catch(error => {
                contactMsg.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Something went wrong. Please try again.</div>';
            });
        });
    }

    // 6. Bulk Enquiry Form AJAX (if present)
    const bulkForm = document.getElementById('bulkForm');
    const bulkMsg = document.getElementById('bulkMsg');
    
    if (bulkForm && bulkMsg) {
        bulkForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(bulkForm);
            bulkMsg.innerHTML = '<div class="alert alert-info"><i class="fa-solid fa-circle-notch fa-spin me-1"></i> Submitting quotation request...</div>';
            
            fetch('/DonaMart/actions/bulk_enquiry.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    bulkMsg.innerHTML = `<div class="alert alert-success"><i class="fa-solid fa-circle-check me-1"></i> ${data.message}</div>`;
                    bulkForm.reset();
                } else {
                    bulkMsg.innerHTML = `<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-1"></i> ${data.message}</div>`;
                }
            })
            .catch(error => {
                bulkMsg.innerHTML = '<div class="alert alert-danger"><i class="fa-solid fa-circle-xmark me-1"></i> Something went wrong. Please try again.</div>';
            });
        });
    }
});
