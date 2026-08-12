document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Smooth Scroll
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('a[href^="#"]').forEach(function (link) {

        link.addEventListener('click', function (event) {

            const targetId = this.getAttribute('href');

            if (!targetId || targetId === '#') {
                return;
            }

            const target = document.querySelector(targetId);

            if (!target) {
                return;
            }

            event.preventDefault();

            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Network Animation
    |--------------------------------------------------------------------------
    */

    const networkNodes =
        document.querySelectorAll('.network-node');

    networkNodes.forEach(function (node, index) {

        node.style.animationDelay =
            `${index * 0.25}s`;

    });


    /*
    |--------------------------------------------------------------------------
    | Package Card Animation
    |--------------------------------------------------------------------------
    */

    const packageCards =
        document.querySelectorAll('.package-card');

    if ('IntersectionObserver' in window) {

        const observer = new IntersectionObserver(
            function (entries) {

                entries.forEach(function (entry) {

                    if (entry.isIntersecting) {

                        entry.target.classList.add('show');

                        observer.unobserve(entry.target);

                    }

                });

            },
            {
                threshold: 0.10
            }
        );

        packageCards.forEach(function (card) {

            observer.observe(card);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Number Counter
    |--------------------------------------------------------------------------
    */

    const counters =
        document.querySelectorAll('[data-counter]');

    counters.forEach(function (counter) {

        const target =
            parseInt(
                counter.getAttribute('data-counter'),
                10
            );

        if (isNaN(target)) {
            return;
        }

        let current = 0;

        const increment =
            Math.max(
                1,
                Math.ceil(target / 40)
            );

        const timer = setInterval(function () {

            current += increment;

            if (current >= target) {

                current = target;

                clearInterval(timer);

            }

            counter.textContent =
                current.toLocaleString('en-IN');

        }, 30);

    });


});