// Image comparison slider functionality
window.addEventListener("load", () => {
    document.querySelectorAll(".slider-container").forEach((slider) => {
        const sliderHandle = slider.querySelector(".slider-handle");
        const sliderLine = slider.querySelector(".slider-line");
        const beforeImage = slider.querySelector(".before-image");
        const afterImage = slider.querySelector(".after-image");
        const icon = slider.querySelector(".pulse-container");

        let isDragging = false;

        const initializeSlider = () => {
            sliderHandle.style.transition = "left 0.3s ease";
            sliderLine.style.transition = "left 0.3s ease";

            sliderHandle.style.left = "50%";
            sliderLine.style.left = "50%";

            beforeImage.style.clipPath = `inset(0 50% 0 0)`;
            afterImage.style.clipPath = `inset(0 0 0 50%)`;
        };

        const moveSlider = (clientX) => {
            const rect = slider.getBoundingClientRect();
            let offsetX = clientX - rect.left;

            if (offsetX < 0) offsetX = 0;
            if (offsetX > rect.width) offsetX = rect.width;

            const percentage = (offsetX / rect.width) * 100;

            sliderHandle.style.left = percentage + "%";
            sliderLine.style.left = percentage + "%";

            beforeImage.style.clipPath = `inset(0 ${100 - percentage}% 0 0)`;
            afterImage.style.clipPath = `inset(0 0 0 ${percentage}%)`;
        };

        const startDragging = () => {
            isDragging = true;
            sliderHandle.style.transition = "none";
            sliderLine.style.transition = "none";
        };

        const stopDragging = () => {
            isDragging = false;
            sliderHandle.style.transition = "left 0.3s ease";
            sliderLine.style.transition = "left 0.3s ease";
        };

        // Desktop
        sliderHandle.addEventListener("mousedown", startDragging);
        sliderLine.addEventListener("mousedown", startDragging);
        icon.addEventListener("mousedown", startDragging);

        window.addEventListener("mousemove", (e) => {
            if (isDragging) moveSlider(e.clientX);
        });

        window.addEventListener("mouseup", stopDragging);

        // Mobile
        sliderHandle.addEventListener("touchstart", startDragging);
        sliderLine.addEventListener("touchstart", startDragging);
        icon.addEventListener("touchstart", startDragging);

        window.addEventListener("touchmove", (e) => {
            if (isDragging) moveSlider(e.touches[0].clientX);
        });

        window.addEventListener("touchend", stopDragging);

        initializeSlider();
    });

});


// video play button functionality
// document.querySelectorAll('.video_wrap').forEach(box => {
//     const video = box.querySelector('.myVideo');
//     const playBtn = box.querySelector('.playBtn');
//     const overlay = box.querySelector('.overlay');

//     // play button click
//     playBtn.addEventListener('click', () => {
//         video.play(); 
//         playBtn.classList.add('d-none');
//         overlay.classList.add('d-none');
//     });

//     // pause when clicking video
//     video.addEventListener('click', () => {
//         if (!video.paused) {
//             video.pause();

//             // show button + overlay again
//             playBtn.classList.remove('d-none');
//             overlay.classList.remove('d-none');
//         }
//     });

//     // when video ends
//     video.addEventListener('ended', () => {
//         playBtn.classList.remove('d-none');
//         overlay.classList.remove('d-none');
//     });

// });
document.querySelectorAll('.video_wrap').forEach(box => {

    const playBtn = box.querySelector('.playBtn');
    const overlay = box.querySelector('.overlay');
    const poster = box.querySelector('.posterImg');
    const iframe = box.querySelector('.youtubeVideo');

    playBtn.addEventListener('click', () => {

        let src = iframe.getAttribute('src');

        iframe.setAttribute(
            'src',
            src + '&autoplay=1'
        );

        playBtn.style.display = 'none';
        overlay.style.display = 'none';
        poster.style.display = 'none';
    });

});

// Owl Carousel initialization
jQuery(document).ready(function(){
    // Web or Mobile section owl carousel
    jQuery('.web_or_mobile').owlCarousel({
        loop: true,
        margin: 24,
        center: true,
        autoplay: false,
        autoplayTimeout: 2500,
        responsive: {
            0: { items: 1 },
            576: { items: 3 },
            992: { items: 6 }
            
        }
    });

    // Studio-quality section Content owl carousel
    const owl = jQuery('.studio-quality_content_owl_carousel');

    // init carousel
    owl.owlCarousel({
        loop: true,
        margin: 0,
        center: true,
        autoplay: false,
        nav: false,
        dots: false,
        autoplayTimeout: 2500,
        mouseDrag: false,
        touchDrag: false,
        pullDrag: false,
        items: 1,
    });

    // total real items (ignore clones)
    const total = owl.find('.owl-item:not(.cloned)').length;

    // create dots inside each item
    jQuery('.custom-dots').each(function () {
        for (let i = 0; i < total; i++) {
            jQuery(this).append(`<span class="dot" data-index="${i}"></span>`);
        }
    });

    // click dot → go to slide
    jQuery(document).on('click', '.dot', function () {
        const index = jQuery(this).data('index');
        owl.trigger('to.owl.carousel', [index, 300]);
    });

    // set active dot
    owl.on('changed.owl.carousel', function (event) {
        let index = event.item.index - event.relatedTarget._clones.length / 2;

        if (index < 0) index = total + index;
        if (index >= total) index = index - total;

        jQuery('.dot').removeClass('active');
        jQuery(`.dot[data-index="${index}"]`).addClass('active');
    });

    // set first active on load
    setTimeout(() => {
        jQuery('.dot[data-index="0"]').addClass('active');
    }, 100);


    // Behind the scenes section - Left carousel (Left → Right NORMAL)
    jQuery('.behind_left_carousel').owlCarousel({
        loop: true,
        margin: 24,
        autoplay: true,
        slideTransition: 'linear',
        autoplaySpeed: 6000,
        smartSpeed: 6000,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 3
          },
          1000: {
            items: 7
          }
        }
      })

    // Behind the scenes section - Right carousel (Right → Left REAL reverse)
    jQuery('.behind_right_carousel').owlCarousel({
        loop: true,
        margin: 24,
        autoplay: true,
        slideTransition: 'linear',
        autoplaySpeed: 6000,
        smartSpeed: 6000,
        autoplayHoverPause: true,
        rtl: true, // Enable right-to-left for real reverse
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 3
          },
          1000: {
            items: 7
          }
        }
    })

});

// Contact form AJAX
jQuery(function ($) {
    var form = $('#optifo-contact-form');
    if (!form.length || typeof optifoData === 'undefined') return;
    form.on('submit', function (e) {
        e.preventDefault();
        var data = form.serializeArray();
        data.push({ name: 'action', value: 'optifo_contact' });
        data.push({ name: 'nonce', value: optifoData.nonce });
        $.post(optifoData.ajaxUrl, data, function (res) {
            var msg = form.find('.optifo-form-message');
            if (res.success) {
                msg.text(res.data.message).css('color', '#198754');
                form[0].reset();
            } else {
                msg.text(res.data && res.data.message ? res.data.message : 'Error').css('color', '#dc3545');
            }
        });
    });
});

