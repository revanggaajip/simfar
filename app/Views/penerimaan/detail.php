<?= $this->extend('layouts/main'); ?>

<?= $this->section('title'); ?>
<?= $title ?? null ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card">
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
                            value="<?= $header['no_faktur']; ?>" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" id="tanggal"
                            value="<?= $header['tanggal'] ?>" readonly>
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="sp" class="form-label">No. Surat Pemesanan</label>
                        <input type="text" class="form-control" name="sp" id="sp" value="<?= $header['sp']; ?>"
                            readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_supplier" class="form-label">Nama Supplier</label>
                        <input type="text" class="form-control" name="nama_supplier" id="nama_supplier"
                            value="<?= $header['nama_supplier']; ?>" readonly>
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
                            <th width="150px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listPenerimaan as $key => $penerimaan) :?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><?= $penerimaan['nama']; ?></td>
                            <td><?= $penerimaan['satuan']; ?></td>
                            <td><?= $penerimaan['quantity']; ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm text-white"
                                    data-coreui-toggle="modal" data-coreui-target="#editData_<?= $penerimaan['id']; ?>">
                                    <i class="fas fa-edit"></i>&nbsp;Ubah
                                </button>
                                <!-- Akhir Tombol Edit -->

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editData_<?= $penerimaan['id'] ?>"
                                    data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Form Ubah Penerimaaan
                                                    <?= $penerimaan['nama']; ?></h5>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form
                                                action="<?= route_to('penerimaan.updateDetail',$penerimaan['id'], $header['id']); ?>"
                                                method="post">
                                                <?php csrf_field(); ?>
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="namaEdit" clask s="form-label">Nama Obat</label>
                                                        <input type="text" class="form-control" name="nama"
                                                            id="namaEdit" value="<?= $penerimaan['nama']; ?>" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="qtyObat" clask s="form-label">Quantity Obat</label>
                                                        <input type="text" class="form-control" name="quantity"
                                                            id="qtyObat" value="<?= $penerimaan['quantity']; ?>">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger text-white"
                                                        data-coreui-dismiss="modal"><i
                                                            class="fas fa-times"></i>&nbsp;Batal</button>
                                                    <button type="submit" class="btn btn-success text-white"><i
                                                            class="fas fa-save"></i>&nbsp;Simpan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Edit -->

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger btn-sm text-white"
                                    data-coreui-toggle="modal"
                                    data-coreui-target="#hapusData_<?= $penerimaan['id']; ?>">
                                    <i class="fas fa-trash"></i>&nbsp;Hapus
                                </button>
                                <!-- Akhir Tombol Hapus -->

                                <!-- Modal hapus -->
                                <div class="modal fade" id="hapusData_<?= $penerimaan['id'] ?>"
                                    data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
                                    aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus
                                                    <?= $penerimaan['nama']; ?></h5>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin akan menghapus data <?= $penerimaan['nama']; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <form
                                                    action="<?= route_to('penerimaan.deleteDetail', $penerimaan['id'], $header['id']) ?>"
                                                    method="post">
                                                    <?php csrf_field(); ?>
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <button type="button" class="btn btn-danger text-white"
                                                        data-coreui-dismiss="modal"><i
                                                            class="fas fa-times"></i>&nbsp;Batal</button>
                                                    <button type="submit" class="btn btn-success text-white"><i
                                                            class="fas fa-trash"></i>&nbsp;Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Akhir Modal Hapus -->
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
                <a href="<?= route_to('penerimaan.edit', $header['id']); ?>" class="btn btn-warning text-white"><i
                        class="fas fa-edit">
                        Edit</i></a>
            </div>
        </div>
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