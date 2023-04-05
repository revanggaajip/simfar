<?= $this->extend('layouts/main'); ?>

<?= $this->section('title'); ?>
Kategori
<?= $this->endSection(); ?>

<?= $this->section('content'); ?>
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5>
                    <?= $title; ?>
                </h5>
                <button type="button" class="btn btn-primary btn-sm" data-coreui-toggle="modal"
                    data-coreui-target="#tambahData">
                    <i class="fas fa-plus"></i>&nbsp;Tambah
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="15">No</th>
                            <th>Nama Kategori</th>
                            <th width="17%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listKategori as $key => $kategori) :?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><?= $kategori['nama']; ?></td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm text-white"
                                    data-coreui-toggle="modal" data-coreui-target="#editData_<?= $kategori['id']; ?>">
                                    <i class="fas fa-edit"></i>&nbsp;Ubah
                                </button>
                                <!-- Akhir Tombol Edit -->

                                <!-- Modal Edit -->
                                <div class="modal fade" id="editData_<?= $kategori['id'] ?>"
                                    data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
                                    aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Form Ubah kategori
                                                    <?= $kategori['nama']; ?></h5>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="<?= route_to('kategori.update',$kategori['id']); ?>"
                                                method="post">
                                                <?php csrf_field(); ?>
                                                <input type="hidden" name="_method" value="PUT">
                                                <div class="modal-body">
                                                    <div class="mb-2">
                                                        <label for="namakategoriEdit" clask s="form-label">Nama
                                                            kategori</label>
                                                        <input type="text" class="form-control" name="nama"
                                                            id="namakategoriEdit" value="<?= $kategori['nama']; ?>">
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
                                    data-coreui-toggle="modal" data-coreui-target="#hapusData_<?= $kategori['id']; ?>">
                                    <i class="fas fa-trash"></i>&nbsp;Hapus
                                </button>
                                <!-- Akhir Tombol Hapus -->

                                <!-- Modal hapus -->
                                <div class="modal fade" id="hapusData_<?= $kategori['id'] ?>"
                                    data-coreui-backdrop="static" data-coreui-keyboard="false" tabindex="-1"
                                    aria-labelledby="hapusModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="hapusModalLabel">Konfirmasi Hapus
                                                    <?= $kategori['nama']; ?></h5>
                                                <button type="button" class="btn-close" data-coreui-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin akan menghapus data <?= $kategori['nama']; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <form action="<?= route_to('kategori.delete', $kategori['id']) ?>"
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

<!-- Modal Tambah-->
<?= $this->include('kategori/create'); ?>
<!-- Modal Tambah -->

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