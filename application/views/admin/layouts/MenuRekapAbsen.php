<div class="row">
    <!-- ============================================================== -->
    <!-- basic table  -->
    <!-- ============================================================== -->
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header bg-dark text-white">Rekapitulasi Absen</h5>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="data_karyawan" class="table  table-bordered first">
                        <thead class="bg-dark">
                            <tr>
                                <th class="text-white">No</th>

                                <th class="text-white">Nama</th>
                                <th class="text-white">Tanggal</th>
                                <th class="text-white">Jam Masuk</th>
                                <th class="text-white">Jam Pulang</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($rekap as $rows) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $rows->nama; ?></td>
                                    <td><?= $rows->tanggal; ?></td>
                                    <td><?= $rows->jam_masuk; ?></td>
                                    <td><?= $rows->jam_pulang; ?></td>

                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end basic table  -->
    <!-- ============================================================== -->
</div>
</div>