<?php
$page_title = "Contact Us - DonaMart Sales & Operations";
$active_page = "contact";
$meta_desc = "Get in touch with DonaMart. Find our phone numbers, factory address, email IDs, and Google maps location for direct visits.";

require_once 'includes/header.php';
?>

<!-- Header Banner -->
<section class="bg-primary-custom text-white py-5">
    <div class="container text-center py-4">
        <h1 class="text-white font-weight-bold mb-2">Contact DonaMart</h1>
        <p class="text-white-50 lead mb-0">Have questions about our manufacturing capacity or custom orders? Reach out to us today!</p>
    </div>
</section>

<!-- Contact Form and Details -->
<section class="py-5">
    <div class="container py-4">
        <div class="row g-5">
            <!-- Details Panel -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="contact-info-card h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="text-accent text-uppercase font-weight-bold fs-6">Get In Touch</span>
                        <h2 class="mt-2 mb-4">Contact Information</h2>
                        
                        <div class="d-flex gap-3 mb-4">
                            <div class="contact-icon flex-shrink-0">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold mb-1">Factory & Corporate Address</h5>
                                <p class="text-muted text-sm mb-0">maruti nagar colony, lanka, varanasi- 221005</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <div class="contact-icon flex-shrink-0">
                                <i class="fa-solid fa-phone"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold mb-1">Phone & Mobile Numbers</h5>
                                <p class="text-muted text-sm mb-0">Sales: +91 8874812003<br>Customer Support: +91 9984020040</p>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-4">
                            <div class="contact-icon flex-shrink-0">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div>
                                <h5 class="font-weight-bold mb-1">Email Addresses</h5>
                                <p class="text-muted text-sm mb-0">General Enquiries: vaibhawrajput05@gmail.com<br>Exports: sales@donamart.com</p>
                            </div>
                        </div>
                    </div>

                    <!-- Map and social links -->
                    <div>
                        <hr class="border-light my-4">
                        <h5 class="font-weight-bold mb-3">Office Working Hours</h5>
                        <p class="text-muted text-sm mb-4">Monday - Saturday: 9:00 AM to 6:00 PM (IST)<br>Sunday: Closed</p>
                        
                        <div class="d-flex gap-2">
                            <a href="#" class="social-btn" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
                            <a href="#" class="social-btn" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
                            <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
                            <a href="#" class="social-btn" aria-label="Twitter"><i class="fa-brands fa-twitter"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Panel -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="bg-white rounded-custom p-4 p-md-5 shadow-sm border border-light">
                    <h3 class="mb-4 font-weight-bold">Send Us a Message</h3>
                    
                    <div id="contactMsg"></div>

                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label font-weight-bold text-dark text-sm">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control rounded-pill px-3" placeholder="Enter your name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label font-weight-bold text-dark text-sm">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" class="form-control rounded-pill px-3" placeholder="yourname@domain.com" required>
                            </div>
                            <div class="col-12">
                                <label for="phone" class="form-label font-weight-bold text-dark text-sm">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control rounded-pill px-3" placeholder="e.g. +91 99999 99999">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label font-weight-bold text-dark text-sm">Subject <span class="text-danger">*</span></label>
                                <input type="text" name="subject" id="subject" class="form-control rounded-pill px-3" placeholder="Subject of your message" required>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label font-weight-bold text-dark text-sm">Message <span class="text-danger">*</span></label>
                                <textarea name="message" id="message" class="form-control rounded-4 p-3" rows="5" placeholder="Write your message here..." required></textarea>
                            </div>
                            <div class="col-12 mt-4 text-center">
                                <button type="submit" class="btn btn-accent px-5 py-3 rounded-pill font-weight-bold shadow-md w-100">Send Message</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Map Embedded -->
        <div class="row mt-5" data-aos="fade-up">
            <div class="col-12 contact-map">
                <!-- Standard Google Maps placeholder showing generic Jaipur industrial area -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14234.621415777708!2d75.78722513955078!3d26.88266499999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396db44ef91eb973%3A0x8e8eb43e1d161d7b!2sIndustrial%20Area%2C%20Jaipur%2C%20Rajasthan!5e0!3m2!1sen!2sin!4v1680000000000!5m2!1sen!2sin" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
