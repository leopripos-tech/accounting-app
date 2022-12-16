<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Daftar Status</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Status</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <a href="<?= site_url("transaction-statuses/create") ?>" class="btn btn-primary">
                    Tambah
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($statuses as $index => $status) : ?>
                            <tr>
                                <th scope="row"><?= $index + 1 ?></th>
                                <td><?= $status->name ?></td>
                                <td><?= $status->description ?></td>
                                <td class="text-center" style="width:200px;">
                                    <a href="<?= site_url("transaction-statuses/$status->id/update") ?>" class="btn btn-warning  btn-sm">
                                        <em class="fas fa-pencil-alt btn-small"></em>
                                        Edit
                                    </a>
                                    <form id="<?= "form-del-$status->id" ?>" class="d-inline" method="POST" action="<?= site_url("transaction-statuses/$status->id/delete") ?>">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-danger btn-sm" data-confirm="Apakah anda yakin untuk menghapus?" data-confirm-yes="submitDeleteForm(<?= $status->id ?>)">
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
</section>
<?= $this->endSection() ?>