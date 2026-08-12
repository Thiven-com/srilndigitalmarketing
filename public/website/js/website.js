document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Mobile Navigation
    |--------------------------------------------------------------------------
    */

    const navbar = document.getElementById('websiteNavbar');

    const navLinks = document.querySelectorAll(
        '#websiteNavbar .nav-link'
    );

    navLinks.forEach(function (link) {

        link.addEventListener('click', function () {

            if (
                window.innerWidth < 992 &&
                navbar &&
                navbar.classList.contains('show')
            ) {

                const collapse =
                    bootstrap.Collapse.getInstance(navbar);

                if (collapse) {
                    collapse.hide();
                }

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Scroll Header
    |--------------------------------------------------------------------------
    */

    const header =
        document.querySelector('.main-header');

    function handleHeaderScroll() {

        if (!header) {
            return;
        }

        if (window.scrollY > 20) {

            header.classList.add('header-scrolled');

        } else {

            header.classList.remove('header-scrolled');

        }

    }

    window.addEventListener(
        'scroll',
        handleHeaderScroll
    );

    handleHeaderScroll();


    /*
    |--------------------------------------------------------------------------
    | Smooth Anchor Scroll
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll(
        'a[href^="#"]'
    ).forEach(function (anchor) {

        anchor.addEventListener(
            'click',
            function (event) {

                const targetId =
                    this.getAttribute('href');

                if (
                    !targetId ||
                    targetId === '#'
                ) {
                    return;
                }

                const target =
                    document.querySelector(targetId);

                if (!target) {
                    return;
                }

                event.preventDefault();

                const headerHeight =
                    header
                        ? header.offsetHeight
                        : 0;

                const targetPosition =
                    target.getBoundingClientRect().top +
                    window.pageYOffset -
                    headerHeight -
                    10;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });

            }
        );

    });

});