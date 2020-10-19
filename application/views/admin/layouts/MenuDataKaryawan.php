                <div class="row">
                    <!-- ============================================================== -->
                    <!-- basic table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <h5 class="card-header bg-dark text-white">Data Pegawai</h5>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data_karyawan" class="table  table-bordered first">
                                        <thead class="bg-dark">
                                            <tr>
                                                <th class="text-white">No</th>
                                                <th class="text-white">Nama</th>
                                                <th class="text-white">Posisisi</th>
                                                <th class="text-white">Usia</th>
                                                <th class="text-white">Awal Kerja</th>
                                                <th class="text-white">Upah</th>
                                                <th class="text-white">NIK</th>
                                                <th class="text-white">Opsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1; foreach($getAllDataKaryawan as $rows) { ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $rows->name; ?></td>
                                                <td><?= $rows->position; ?></td>
                                                <td><?= $rows->age; ?></td>
                                                <td><?= $rows->start_date; ?></td>
                                                <td>Rp. <?= $rows->salary; ?></td>
                                                <td><?= $rows->nik; ?></td>
                                                <td><a href="<?php echo base_url(); ?>karyawan/edit/<?= $rows->id; ?>" class="btn btn-primary btn-space"><i class="icon s7-mail"></i><font color="WHITE"> Lihat</font></a><a href="<?php echo base_url(); ?>karyawan/delete/<?= $rows->id; ?>" class="btn btn-danger btn-space"><i class="icon s7-close"></i><font color="WHITE"> Hapus</font></a></td>
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