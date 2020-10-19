<div class="row">
    <!-- ============================================================== -->
    <!-- basic table  -->
    <!-- ============================================================== -->
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header bg-dark text-white">Absensi Pegawai</h5>
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
                                <th class="text-white">Status</th>
                                <th class="text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            foreach ($daftarAbsen as $rows) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $rows->nama; ?></td>
                                    <td><?= $rows->tanggal; ?></td>
                                    <td><?= $rows->jam_masuk; ?></td>
                                    <td><?= $rows->jam_pulang; ?></td>
                                    <td><?= $rows->status; ?></td>

                                    <td>
                                        <a href="<?php echo base_url(); ?>karyawan/absenMasuk/<?= $rows->id; ?>" class="btn btn-success btn-space"><i class="icon s7-mail"></i>
                                            <font color="WHITE"> Masuk</font>
                                        </a><a href="<?php echo base_url(); ?>karyawan/absenPulang/<?= $rows->id; ?>" class="btn btn-warning btn-space"><i class="icon s7-close"></i>
                                            <font color="WHITE"> Pulang</font>
                                        </a><a href="<?= base_url() ?>karyawan/reset/<?= $rows->id; ?>" class="btn btn-danger btn-space"><i class="icon s7-close"></i>
                                            <font color="WHITE">Reset</font>
                                        </a>
                                        </>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <hr>
                    <h5 class="card-title">Reset data absen harian (*Semua karyawan)</h5>

                    <a href="<?= base_url(); ?>karyawan/resetAbsen" class="btn btn-danger">
                        <font color="WHITE">Reset</font>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- end basic table  -->
    <!-- ============================================================== -->
</div>


<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header bg-dark text-white">Absensi Pegawai</h5>
            <div class="card-body">
                <form method="POST" action="<?php echo base_url(); ?>karyawan/absensiKaryawan">
                    <h5 class="card-title">Pilih nama karyawan dan kehadiran</h5>
                    <select class="selectpicker" data-style="btn-dark" name="name">
                        <?php foreach ($dataKaryawan as $rows) { ?>
                            <option value="<?= $rows->name; ?>"><?= $rows->name; ?></option>
                        <?php } ?>
                    </select>
                    <select class="selectpicker" data-style="btn-dark" name="kehadiran">
                        <option value="tidak_hadir">Tidak Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                    </select>
                    <div class="form-group">
                        <label for="jumlah" class="col-form-label">Jumlah</label>
                        <input id="jumlah" name="jumlah" type="number" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="alasan">Alasan</label>
                        <textarea class="form-control" id="alasan" name="alasan" rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </form>

            </div>
        </div>
    </div>
</div>
</div>
</div>