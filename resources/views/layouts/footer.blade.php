
    <!-- Core JS -->
    <script src="{{ asset('sneat/assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('sneat/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/main.js') }}"></script>
    <script src="{{ asset('sneat/assets/js/dashboards-analytics.js') }}"></script>
    <script src="{{ asset('sweetalert2/dist/sweetalert2.all.min.js') }}"></script>
 
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

     <!-- Sweetalert -->
    @if (session('success'))
      <script>
        Swal.fire({
          title: "Sukses!",
          text: "{{ session('success') }}",
          icon: "success"
        });
      </script>
    @endif

    @if (session('error'))
      <script>
        Swal.fire({
          title: "Gagal",
          text: "{{ session('error') }}",
          icon: "error"
        });
      </script>
    @endif

  </body>
</html>
