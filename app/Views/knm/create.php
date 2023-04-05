<div class="modal fade" id="tambahData" data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
    aria-labelledby="tambahData" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahData">Tambah Kategori Non Medis Baru</h5>
                <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= route_to('knm.store') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="nama" class="form-label">Nama Kategori Non Medis</label>
                        <input type="text" class="form-control" name="nama" id="nama">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger text-white" data-coreui-dismiss="modal"><i
                            class="fas fa-times"></i>&nbsp;Batal</button>
                    <button type="submit" id="simpanTambah" class="btn btn-success text-white"><i
                            class="fas fa-save"></i>&nbsp;Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>