<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Daftar Penyesuaian</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Penyesuaian</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <a href="<?= site_url("adjustments/create") ?>" class="btn btn-primary">
                    Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md datatable-enable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kwitansi</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Deskripsi</th>
                                <th scope="col">Nilai</th>
                                <th scope="col">Waktu (bulan)</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($adjustments as $index => $adjustment) : ?>
                                <tr>
                                    <th scope="row"><?= $index + 1 ?></th>
                                    <td><?= $adjustment->receiptNo?></td>
                                    <td><?= $adjustment->date ?></td>
                                    <td><?= $adjustment->description ?></td>
                                    <td>Rp. <?= number_format($adjustment->value) ?></td>
                                    <td><?= number_format($adjustment->time) ?></td>
                                    <td class="text-center" style="width:200px;">
                                        <a href="<?= site_url("adjustments/$adjustment->id") ?>" class="btn btn-info  btn-sm">
                                            <em class="fas fa-pencil-alt btn-small"></em>
                                            Detail
                                        </a>
                                        <form id="<?= "form-del-$adjustment->id" ?>" class="d-inline" method="POST" action="<?= site_url("adjustments/$adjustment->id/delete") ?>">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-danger btn-sm" data-confirm="Apakah anda yakin untuk menghapus?" data-confirm-yes="submitDeleteForm(<?= $adjustment->id ?>)">
                                                <em class="fas fa-trash btn-small"></em>Del
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>