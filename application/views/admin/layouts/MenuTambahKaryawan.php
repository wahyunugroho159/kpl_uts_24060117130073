                        <div class="row">
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header bg-dark text-white">Tambah Pegawai</h5>
                                    <div class="card-body">
                                        <form method="POST" action="<?php echo base_url(); ?>karyawan/tambahKaryawan" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label for="name" class="col-form-label">Nama</label>
                                                <input id="name" name="name" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="position" class="col-form-label">Posisi</label>
                                                <input id="position" name="position" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="age" class="col-form-label">Umur</label>
                                                <input id="age" name="age" type="number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="start_date" class="col-form-label">Mulai Kerja (dd/mm/yyyy)</label>
                                                <input id="start_date" name="start_date" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="salary" class="col-form-label">Upah</label>
                                                <input id="salary" name="salary" type="text" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email</label>
                                                <input id="email" name="email" type="email" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="handphone" class="col-form-label">Handphone</label>
                                                <input id="handphone" name="handphone" type="number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="nik" class="col-form-label">NIK</label>
                                                <input id="nik" name="nik" type="number" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <label for="password" class="col-form-label">Kata Sandi</label>
                                                <input id="password" name="password" type="text" class="form-control">
                                            </div>
                                            <div class="custom-file mb-3">
                                                <input type="file" class="custom-file-input" id="uploadImage" name="upload_image">
                                                <label class="custom-file-label" for="uploadImage">Upload Foto Diri</label>
                                            </div>
                                            <div class="form-group">
                                                <label for="tentangKaryawan">Tentang Pegawai (*Gunakan tag < br > untuk bari baru)</label>
                                                <textarea class="form-control" id="tentangKaryawan" name="tentang" rows="3"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>