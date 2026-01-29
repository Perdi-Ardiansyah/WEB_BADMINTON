</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
  All rights reserved.
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 3.2.0
  </div>
</footer>

<!-- jQuery -->
<script src="<?= base_url('template'); ?>/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?= base_url('template'); ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= base_url('template'); ?>/plugins/chart.js/Chart.min.js"></script>
<!-- daterangepicker -->
<script src="<?= base_url('template'); ?>/plugins/moment/moment.min.js"></script>
<script src="<?= base_url('template'); ?>/plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('template'); ?>/dist/js/adminlte.js"></script>


<script>
  function updateJamTanggal() {
    const now = new Date();

    const hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const bulan = [
      'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
      'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    const teks =
      hari[now.getDay()] + ', ' +
      now.getDate() + ' ' +
      bulan[now.getMonth()] + ' ' +
      now.getFullYear() + ' | ' +
      now.getHours().toString().padStart(2, '0') + ':' +
      now.getMinutes().toString().padStart(2, '0') + ':' +
      now.getSeconds().toString().padStart(2, '0');

    document.getElementById('jamTanggal').innerHTML = teks;
  }

  setInterval(updateJamTanggal, 10000); // Update every 10 seconds for better performance
  updateJamTanggal();
</script>
<script>
  $('#hapusTanggal').on('show.bs.collapse', function () {
    $('#generateTanggal').collapse('hide');
  });

  $('#generateTanggal').on('show.bs.collapse', function () {
    $('#hapusTanggal').collapse('hide');
  });
</script>
<script>
$('#generateSatuLapangan').on('show.bs.collapse', function () {
    $('#generateTanggal').collapse('hide');
    $('#hapusTanggal').collapse('hide');
});
</script>

</body>

</html>