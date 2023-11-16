<!-- Back to Top -->
<a href="#" class="btn btn-lg btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>

<!-- JavaScript Libraries -->
<script src="{{ asset('client/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('client/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('client/lib/easing/easing.min.js') }}"></script>
<script src="{{ asset('client/lib/waypoints/waypoints.min.js') }}"></script>
<script src="{{ asset('client/lib/counterup/counterup.min.js') }}"></script>
<script src="{{ asset('client/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('client/lib/tempusdominus/js/moment.min.js') }}"></script>
<script src="{{ asset('client/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
<script src="{{ asset('client/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

<!-- Contact Javascript File -->
<script src="{{ asset('client/mail/jqBootstrapValidation.min.js') }}"></script>
<script src="{{ asset('client/mail/contact.js') }}"></script>

<!-- Template Javascript -->
<script src="{{ asset('client/js/main.js?v=').date('His') }}"></script>
<!-- LOBIBOX -->
<script src="{{ asset('plugin/lobibox/dist/js/lobibox.min.js?v='.date('his')) }}"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker@3.1.0/daterangepicker.min.js"></script>
@yield('js')