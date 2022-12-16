<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Daftar Transaksi</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Transaksi</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <a href="<?= site_url("transactions/create") ?>" class="btn btn-primary">
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
                                <th scope="col">Ket. Jurnal</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transactions as $index => $transaction) : ?>
                                <tr>
                                    <th scope="row"><?= $index + 1 ?></th>
                                    <td><?= $transaction->receiptNo?></td>
                                    <td><?= $transaction->date ?></td>
                                    <td><?= $transaction->description ?></td>
                                    <td><?= $transaction->journal_description ?></td>
                                    <td class="text-center" style="width:200px;">
                                        <a href="<?= site_url("transactions/$transaction->id") ?>" class="btn btn-info  btn-sm">
                                            <em class="fas fa-pencil-alt btn-small"></em>
                                            Detail
                                        </a>
                                        <form id="<?= "form-del-$transaction->id" ?>" class="d-inline" method="POST" action="<?= site_url("transactions/$transaction->id/delete") ?>">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-danger btn-sm" data-confirm="Apakah anda yakin untuk menghapus?" data-confirm-yes="submitDeleteForm(<?= $transaction->id ?>)">
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