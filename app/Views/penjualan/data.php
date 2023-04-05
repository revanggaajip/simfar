<?= $this->extend('layouts/main'); ?>

<?= $this->section('title'); ?>
<?= $title ?>
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
            <div class="table-responsive">
                <table class="table table-striped table-bordered dt-responsive nowrap" id="dataTable">
                    <thead class="table-dark">
                        <tr>
                            <th width="15">No</th>
                            <th>Nama Pasien</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listHeader as $key => $header) :?>
                        <tr>
                            <td><?= $key+1; ?></td>
                            <td><?= $header['nama']; ?></td>
                            <td><?= date('d-m-Y', strtotime($header['tanggal'])); ?></td>
                            <td><?= rupiah($header['total']); ?></td>
                            <td><?= $header['keterangan']; ?></td>
                            <td>
                                <a href="<?= route_to('penjualan.detail', $header['id']) ?>"
                                    class="btn btn-primary btn-sm text-white"><i class="fas fa-info"></i> Detail</a>
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