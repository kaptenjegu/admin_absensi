<!--footer>
    <p>All right reserved. Template by: <a href="http://webthemez.com">WebThemez</a></p>
</footer-->
</div>
<!-- /. PAGE INNER  -->
</div>
<!-- /. PAGE WRAPPER  -->
</div>
<!-- /. WRAPPER  -->
<!-- JS Scripts-->
<!-- jQuery Js -->
<script src="<?= base_url() ?>assets/js/jquery-1.10.2.js"></script>
<!-- Bootstrap Js -->
<script src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>
<!-- Metis Menu Js -->
<script src="<?= base_url() ?>assets/js/jquery.metisMenu.js"></script>
<!-- Morris Chart Js -->
<script src="<?= base_url() ?>assets/js/morris/raphael-2.1.0.min.js"></script>
<script src="<?= base_url() ?>assets/js/morris/morris.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables/dataTables.bootstrap.js"></script>
<script src="<?= base_url() ?>assets/js/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/daterangepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/css/daterangepicker.css" />

<script>
    $(document).ready(function() {
        $('#dataTables-master').dataTable();
    });
    $(document).ready(function() {
        $('#dataTables-master2').dataTable();
    });
</script>

<?php if ($page == "Dashboard") { ?>
    <script type="text/javascript">
        (function($) {
            "use strict";
            var mainApp = {

                initFunction: function() {
                    /*MENU 
                    ------------------------------------*/
                    $('#main-menu').metisMenu();

                    $(window).bind("load resize", function() {
                        if ($(this).width() < 768) {
                            $('div.sidebar-collapse').addClass('collapse')
                        } else {
                            $('div.sidebar-collapse').removeClass('collapse')
                        }
                    });

                    var masuk, tdk_masuk;

                    /*$.ajax({
                        url: "<?= base_url() ?>Dashboard/get_data_chart/",
                        type: "GET",
                        dataType: "JSON",
                        success: function(data) {
                            masuk = data['masuk'];
                            tdk_masuk = data['tdk_masuk'];
                            console.log(data);
                        },
                        error: function(data) {
                            alert('error')
                            console.log(data);
                        }
                    });*/

                    /* MORRIS DONUT CHART
			----------------------------------------*/
                    Morris.Donut({
                        element: 'hari_ini',
                        data: [{
                            label: "Masuk",
                            value: <?= $chart['masuk'] ?>
                        }, {
                            label: "Tidak Masuk",
                            value: <?= $chart['tdk_masuk'] ?>
                        }],
                        resize: true,
                        colors: ['green', 'red']
                    });

                    Morris.Donut({
                        element: 'tidak_masuk',
                        data: [{
                            label: "Cuti/Ijin/Sakit",
                            value: <?= $chart['off'] ?>
                        }, {
                            label: "Tanpa Keterangan",
                            value: <?= $chart['tdk_masuk'] - $chart['off'] ?>
                        }],
                        resize: true,
                        colors: ['rgb(0, 188, 212)', 'red']
                    });



                },

                initialization: function() {
                    mainApp.initFunction();

                }

            }
            // Initializing ///

            $(document).ready(function() {
                mainApp.initFunction();
            });

        }(jQuery));
    </script>
    <script type="text/javascript">
        function get_data(id) {
            //console.log(id);
            $.ajax({
                url: "<?= base_url() ?>Dashboard/get_detail/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    document.getElementById('id_absen').value = data['id_absen'];
                    document.getElementById('id_user').value = data['id_user'];
                    document.getElementById('pending').value = data['pending'];
                    document.getElementById('nama_user').value = data['nama_user'];
                    document.getElementById('nama_jabatan').value = data['nama_jabatan'];
                    document.getElementById('tgl_absen').value = data['tgl_absen2'];
                    document.getElementById('absen_masuk').value = data['absen_masuk'];
                    document.getElementById('absen_pulang').value = data['absen_pulang'];
                    document.getElementById('status').value = data['nama_pending'];
                    document.getElementById('keterangan').value = data['catatan_pending'];
                    $('#detailForm').modal('show');
                    console.log(data);
                },
                error: function(data) {
                    alert('error')
                    console.log(data);
                }
            });
        }

        function get_data_lembur(id) {
            //console.log(id);
            $.ajax({
                url: "<?= base_url() ?>Dashboard/get_detail_lembur/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    document.getElementById('id_lembur').value = data['id_lembur'];
                    document.getElementById('id_user2').value = data['id_akun'];
                    document.getElementById('nama_user2').value = data['nama_user'];
                    document.getElementById('nama_jabatan2').value = data['nama_jabatan'];
                    document.getElementById('tgl_lembur').value = data['tgl_lembur2'];
                    document.getElementById('mulai_lembur').value = data['mulai_lembur'];
                    document.getElementById('selesai_lembur').value = data['selesai_lembur'];
                    //document.getElementById('status_lembur').value = data['status_lembur'];
                    document.getElementById('keterangan2').value = data['keterangan2'];
                    $('#detailLembur').modal('show');
                    console.log(data);
                },
                error: function(data) {
                    alert('error')
                    console.log(data);
                }
            });
        }
    </script>
<?php } ?>

<?php if ($page == "Jabatan") { ?>
    <script type="text/javascript">
        function get_data(id) {
            $.ajax({
                url: "<?= base_url() ?>Jabatan/get_data/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    document.getElementById('id_jabatan').value = data['id_jabatan'];
                    document.getElementById('nama_jabatan').value = data['nama_jabatan'];
                    $('#editForm').modal('show');
                    console.log(data);
                },
                error: function(data) {
                    alert('error')
                    console.log(data);
                }
            });
        }
    </script>
<?php } ?>

<?php if ($page == "Tempat") { ?>
    <script type="text/javascript">
        function get_lokasi(id) {
            $.ajax({
                url: "<?= base_url() ?>Tempat/get_data/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    document.getElementById('id_lokasi').value = data['id_lokasi'];
                    document.getElementById('nama_lokasi').value = data['nama_lokasi'];
                    document.getElementById('long_lokasi').value = data['long_lokasi'];
                    document.getElementById('lat_lokasi').value = data['lat_lokasi'];
                    document.getElementById('batas_lokasi').value = data['batas_lokasi'];
                    $('#editTempat').modal('show');
                    console.log(data);
                },
                error: function(data) {
                    alert('error')
                    console.log(data);
                }
            });
        }
    </script>
<?php } ?>

<?php if ($page == "Libur") { ?>
    <script type="text/javascript">
        $(function() {
            $('input[name="tgl_libur"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                minYear: 2022,
                maxYear: parseInt(moment().format('YYYY'), 5),
                locale: {
                    format: 'YYYY-MM-DD'
                }

            });
        });

        function get_data(id) {
            //console.log(id);
            $.ajax({
                url: "<?= base_url() ?>Libur/get_detail/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    document.getElementById('id_libur').value = data['id_libur'];
                    document.getElementById('tgl_libur').value = data['tgl_libur'];
                    document.getElementById('keterangan').value = data['keterangan'];
                    $('#editForm').modal('show');
                    console.log(data);
                },
                error: function(data) {
                    alert('error')
                    console.log(data);
                }
            });
        }
    </script>
<?php } ?>


</body>

</html>