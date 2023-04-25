<?= $this->extend('layouts/main'); ?>

<?= $this->section('title'); ?>
<?= 'Edit' . $title ?? null ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card">
        <form action="<?= route_to('penerimaan.update', $header['id']); ?>" method="post">
            <?= csrf_field() ?>
            <!-- <input type="hidden" name="_method" value="PUT"> -->
            <div class="card-header">
                <h5>
                    <?= $title; ?>
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="no_faktur" class="form-label">No. Faktur</label>
                            <input type="text" class="form-control" name="no_faktur" id="no_faktur"
                                value="<?= $header['no_faktur']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" id="tanggal"
                                value="<?= $header['tanggal'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="sp" class="form-label">No. Surat Pemesanan</label>
                            <input type="text" class="form-control" name="sp" id="sp" value="<?= $header['sp']; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama_supplier" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" name="nama_supplier" id="nama_supplier"
                                value="<?= $header['nama_supplier']; ?>">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-bordered dt-responsive nowrap" id="dataTable">
                        <thead class="table-dark">
                            <tr>
                                <th width="15">No</th>
                                <th>Nama Obat</th>
                                <th width="50px">Satuan</th>
                                <th width="50px">Quantity</th>
                                <th width="75px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($listPenerimaan as $key => $penerimaan) :?>
                            <tr>
                                <input type="hidden" name="id_detail[]" value="<?= $penerimaan['id']; ?>">
                                <input type="hidden" name="id_obat[]" value="<?= $penerimaan['id_obat']; ?>">
                                <td><?= $key+1; ?></td>
                                <td><?= $penerimaan['nama']; ?></td>
                                <td><?= $penerimaan['satuan']; ?></td>
                                <td><input type="number" class="form-control" name="quantity[]"
                                        value="<?= $penerimaan['quantity']; ?>"></td>
                                <td>

                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="<?= route_to('penerimaan.index'); ?>" class="btn btn-danger text-white"><i
                            class="fas fa-times"></i>
                        Kembali</a>
                    <button type="submit" class="btn btn-success text-white"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection(); ?>

<?= $this->section('styles'); ?>
<link rel="stylesheet" href="<?= base_url('vendors/dataTables/css/dataTables.bootstrap4.min.css'); ?>">
<?= $this->endSection(); ?>

<?= $this->section('scripts'); ?>
<script src="<?= base_url('vendors/dataTables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?= base_url('vendors/dataTables/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script>
$(document).ready(() => {
    $("#dataTable").DataTable();
});
</script>
<?php $this->endSection(); ?>