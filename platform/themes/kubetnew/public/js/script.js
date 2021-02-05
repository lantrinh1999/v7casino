$(document).ready(function () {
    $('.home-slider').slick({
        slidesToShow: 1,
        arrows: true,
        autoplay: true,
    });

    $('.feedback-slider').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        arrows: false,
        dots: true,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]
    });

    //Sticky menu

    // Optimalisation: Store the references outside the event handler:
    let $window = $(window);
    let $pane = $('#pane1');

    function checkWidth() {
        let windowsize = $window.width();
        if (windowsize < 769) {
            let sticky2 = new Waypoint.Sticky({
                element: $('.header-top')
            })
        }

        if (windowsize > 991) {
            let sticky = new Waypoint.Sticky({
                element: $('div.header-all')
            })
        }
    }

    // Execute on load
    checkWidth();
    // Bind event listener
    $(window).resize(checkWidth);

    //Mobile menu

    let menu = new MmenuLight(
        document.querySelector('.menu-wrap-mobile'),
        'all'
    );

    let navigator = menu.navigation({
        slidingSubmenus: true,
        theme: 'dark',
        title: 'Menu'
    });

    let drawer = menu.offcanvas({
        position: 'left'
    });

    //	Open the menu.
    document.querySelector('.toggle-menu')
        .addEventListener('click', evnt => {
            evnt.preventDefault();
            drawer.open();
        });

});