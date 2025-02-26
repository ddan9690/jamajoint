 <!-- Footer Start -->
 <div class="container-fluid bg-primary text-light footer mt-5 pt-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container py-5 px-lg-5">
        <div class="row g-5">
            <div class="col-md-6 col-lg-3 mx-auto text-center">
                <h5 class="text-white mb-4">Get In Touch</h5>
                <p><i class="fa fa-phone-alt me-3"></i>0711317235</p>
                <p><i class="fa fa-envelope me-3"></i>ddan9690@gmail.com</p>
                <div class="d-flex pt-2">
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-instagram"></i></a>
                    <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>
            {{-- <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Popular Link</h5>
                <a class="btn btn-link" href="">About Us</a>
                <a class="btn btn-link" href="">Contact Us</a>
                <a class="btn btn-link" href="">Privacy Policy</a>
                <a class="btn btn-link" href="">Terms & Condition</a>
                <a class="btn btn-link" href="">Career</a>
            </div> --}}
            {{-- <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Project Gallery</h5>
                <div class="row g-2">
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('frontend/img/portfolio-1.jpg') }}" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('frontend/img/portfolio-2.jpg') }}" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('frontend/img/portfolio-3.jpg') }}" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('frontend/img/portfolio-4.jpg') }}" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('frontend/img/portfolio-5.jpg') }}" alt="Image">
                    </div>
                    <div class="col-4">
                        <img class="img-fluid" src="{{ asset('frontend/img/portfolio-6.jpg') }}" alt="Image">
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <h5 class="text-white mb-4">Jamajoint Newsletter</h5>
                <p>Subscribe to the Jamajoint newsletter to receive the latest updates, educational insights, and feature announcements.</p>
                <div class="position-relative w-100 mt-3">
                    <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="text" placeholder="Your Email" style="height: 48px;">
                    <button type="button" class="btn shadow-none position-absolute top-0 end-0 mt-1 me-2"><i class="fa fa-paper-plane text-primary fs-4"></i> Subscribe</button>
                </div>
            </div> --}}

        </div>
    </div>
    <div class="container px-lg-5">
        <div class="copyright">
            <div class="row">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    &copy; <a class="border-bottom" href="#">JamaJoint</a>, All Right Reserved.

                    <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                    Designed By <a class="border-bottom" href="">Jamadata</a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="footer-menu">
                        <a href="">Home</a>
                        <a href="{{ route('terms-of-service') }}">Terms of Service</a>
                        <a href={{ route('faq') }}>FQAs</a>
                        <a href={{ route('privacy-policy') }}>Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer End -->


<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top pt-2"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('frontend/lib/wow/wow.min.js') }}"></script>
<script src="{{ asset('frontend/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('frontend/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('frontend/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('frontend/lib/isotope/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('frontend/lib/lightbox/js/lightbox.min.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('frontend/js/main.js') }}"></script>
@stack('scripts')

</body>

</html>
