<?= $this->extend('layouts/main'); ?>

<?= $this->section('title'); ?>
<?= $title ?>
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5>
                    <?= $title; ?>
                </h5>
                <div>
                    <a href="" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="15">No</th>
                            <th>No. Faktur</th>
                            <th>No. SP</th>
                            <th>Nama Supplier</th>
                            <th>tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listHeader as $key => $header) :?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><?= $header['no_faktur']; ?></td>
                            <td><?= $header['sp']; ?></td>
                            <td><?= $header['nama_supplier']; ?></td>
                            <td><?= date('d-m-Y', strtotime($header['tanggal'])); ?></td>
                            <td>
                                <a href="<?= route_to('penerimaan.detail', $header['id']) ?>"
                                    class="btn btn-primary btn-sm text-white"><i class="fas fa-info"></i> Detail</a>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm text-white"
                                    data-coreui-toggle="modal" data-coreui-target="#editData_<?= $header['id']; ?>">
                                    <i class="fas fa-edit"></i>&nbsp;Ubah
                                </button>
                                <!-- Akhir Tombol Edit -->

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editData_<?= $header['id'] ?>" data-coreui-backdrop="static"
                                    data-coreui-keyboard="false" tabindex="-1" aria-labelledby="editModalLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Form Ubah Data No Faktur
                                                    <?= $header['no_faktur']; ?></h5>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="<?= route_to('penerimaan.update',$header['id']); ?>"
                                                method="post">
                                                <?php csrf_field(); ?>
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="no_faktur" clask s="form-label">No Faktur</label>
                                                        <input type="text" class="form-control" name="no_faktur"
                                                            id="no_faktur" value="<?= $header['no_faktur']; ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="sp" clask s="form-label">Surat Permintaan</label>
                                                        <input type="text" class="form-control" name="sp" id="sp"
                                                            value="<?= $header['sp']; ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="nama" clask s="form-label">Nama Supplier</label>
                                                        <input type="text" class="form-control" name="nama_supplier"
                                                            id="nama" value="<?= $header['nama_supplier']; ?>">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="tanggal" clask s="form-label">Tanggal</label>
                                                        <input type="date" class="form-control" name="tanggal"
                                                            id="tanggal" value="<?= $header['tanggal']; ?>">
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
                                    data-coreui-toggle="modal" data-coreui-target="#hapusData_<?= $header['id']; ?>">
                                    <i class="fas fa-trash"></i>&nbsp;Hapus
                                </button>
                                <!-- Akhir Tombol Hapus -->

                                <!-- Modal hapus -->
                                <div class="modal fade" id="hapusData_<?= $header['id'] ?>"
                                    data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
                                    aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus No. Faktur
                                                    <?= $header['no_faktur']; ?></h5>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin akan menghapus data No Faktur
                                                <?= $header['no_faktur']; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="<?= route_to('penerimaan.delete', $header['id']) ?>"
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