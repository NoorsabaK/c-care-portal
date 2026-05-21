(function() {
    "use strict";
    
    // Preloader
    let preloader = document.querySelector('#preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            preloader.remove();
        });
    }
    
    // Scroll top button
    let scrollTop = document.querySelector('.scroll-top');
    if (scrollTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 100) {
                scrollTop.classList.add('active');
            } else {
                scrollTop.classList.remove('active');
            }
        });
        scrollTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    }
    
    // Mobile navigation toggle
    let mobileNavToggle = document.querySelector('.mobile-nav-toggle');
    if (mobileNavToggle) {
        mobileNavToggle.addEventListener('click', function() {
            document.querySelector('body').classList.toggle('mobile-nav-active');
            this.classList.toggle('bi-list');
            this.classList.toggle('bi-x');
        });
    }
    
    // Init AOS
    if (typeof AOS !== 'undefined') {
        AOS.init({ duration: 600, easing: 'ease-in-out', once: true });
    }
    
    // Init swiper for testimonials
    if (document.querySelector('.init-swiper')) {
        let swiperElements = document.querySelectorAll('.init-swiper');
        for (let i = 0; i < swiperElements.length; i++) {
            let config = JSON.parse(swiperElements[i].querySelector('.swiper-config').innerHTML);
            new Swiper(swiperElements[i], config);
        }
    }
    
    // Gallery lightbox
    if (typeof GLightbox !== 'undefined') {
        GLightbox({ selector: '.glightbox' });
    }
    
    // FAQ accordion
    document.querySelectorAll('.faq-item h3, .faq-item .faq-toggle').forEach((faqItem) => {
        faqItem.addEventListener('click', () => {
            faqItem.parentNode.classList.toggle('faq-active');
        });
    });
})();