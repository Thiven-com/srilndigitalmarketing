<footer class="website-footer">

    <div class="container-custom">

        <div class="row g-5">


            <!-- BRAND -->

            <div class="col-lg-4">

                <a
                    href="{{ route('home') }}"
                    class="footer-brand"
                >

                    <img
                        src="{{ asset('website/images/logo.png') }}"
                        alt="Logo"
                        class="footer-logo"
                    >

                </a>


                <p class="footer-description">

                    Build your network, connect with people
                    and grow together through our modern
                    membership platform.

                </p>


                <!-- SOCIAL -->

                <div class="social-links">


                    <a
                        href="#"
                        class="social-link"
                    >

                        <i class="bi bi-facebook"></i>

                    </a>


                    <a
                        href="#"
                        class="social-link"
                    >

                        <i class="bi bi-instagram"></i>

                    </a>


                    <a
                        href="#"
                        class="social-link"
                    >

                        <i class="bi bi-whatsapp"></i>

                    </a>


                    <a
                        href="#"
                        class="social-link"
                    >

                        <i class="bi bi-youtube"></i>

                    </a>


                    <a
                        href="#"
                        class="social-link"
                    >

                        <i class="bi bi-telegram"></i>

                    </a>


                </div>

            </div>


            <!-- QUICK LINKS -->

            <div class="col-lg-2 col-md-4">

                <h5 class="footer-title">
                    Quick Links
                </h5>


                <ul class="footer-links">


                    <li>

                        <a href="{{ route('home') }}">
                            Home
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/about') }}">
                            About Us
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/packages') }}">
                            Packages
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/how-it-works') }}">
                            How It Works
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/faq') }}">
                            FAQ
                        </a>

                    </li>


                </ul>

            </div>


            <!-- MEMBER -->

            <div class="col-lg-2 col-md-4">

                <h5 class="footer-title">
                    Member Area
                </h5>


                <ul class="footer-links">


                    <li>

                        <a href="{{ url('/login') }}">
                            Login
                        </a>

                    </li>


                    <li>

                        <a href="{{ url('/register') }}">
                            Register
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            Dashboard
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            My Team
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            Income
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            Wallet
                        </a>

                    </li>


                </ul>

            </div>


            <!-- SUPPORT -->

            <div class="col-lg-2 col-md-4">

                <h5 class="footer-title">
                    Support
                </h5>


                <ul class="footer-links">


                    <li>

                        <a href="#">
                            Help Center
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            Terms & Conditions
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            Privacy Policy
                        </a>

                    </li>


                    <li>

                        <a href="#">
                            Refund Policy
                        </a>

                    </li>


                </ul>

            </div>


            <!-- CONTACT -->

            <div class="col-lg-2">

                <h5 class="footer-title">
                    Contact
                </h5>


                <div class="footer-contact">


                    <div class="footer-contact-item">

                        <span class="contact-icon">
                            <i class="bi bi-telephone"></i>
                        </span>

                        <span>
                            +91 12345 67890
                        </span>

                    </div>


                    <div class="footer-contact-item">

                        <span class="contact-icon">
                            <i class="bi bi-envelope"></i>
                        </span>

                        <span>
                            support@example.com
                        </span>

                    </div>


                    <div class="footer-contact-item">

                        <span class="contact-icon">
                            <i class="bi bi-geo-alt"></i>
                        </span>

                        <span>
                            India
                        </span>

                    </div>


                </div>

            </div>


        </div>


        <!-- COPYRIGHT -->

        <div class="footer-bottom">

            <div>
                © {{ date('Y') }} All Rights Reserved.
            </div>


            <div class="footer-bottom-links">

                <a href="#">
                    Privacy
                </a>

                <a href="#">
                    Terms
                </a>

            </div>

        </div>

    </div>

</footer>