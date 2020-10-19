<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="card">
            <h5 class="card-header bg-dark text-white">Pengaturan Absensi</h5>
            <div class="card-body">
                <form method="POST" action="<?php echo base_url(); ?>karyawan/settingAbsensi">
                    <div class="col-6 col-md-6">
                        <div class="form-group">
                            <label for="start" class="col-form-label">Mulai absen (*Contoh: 06:00)</label>
                            <input id="start" name="start" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-6 col-md-6">
                            <label for="end" class="col-form-label">Selesai absen (*Contoh: 08:00)</label>
                            <input id="end" name="end" type="text" class="form-control">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>

                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>