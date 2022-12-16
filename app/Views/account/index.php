<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Daftar Akun</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Akun</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <a href="<?= site_url("accounts/create") ?>" class="btn btn-primary">
                        Tambah
                    </a>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($accounts as $index => $account) : ?>
                            <li class="list-group-item d-inline-flex justify-content-between"
                                style="padding-left: <?= $account->level * 10 + 20 ?>px;">

                                <div class="d-flex">
                                    <span><?= $account->code ?> |</span>
                                    <div class="d-flex flex-column ml-1">
                                        <span> <?= $account->name ?></span>
                                        <small style="line-height: 1;"><?= $account->description ?> </small>
                                    </div>
                                </div>
                                <div class="d-inline-flex justify-content-between align-items-center">
                                    <a href="<?= site_url("accounts/$account->id/create-sub") ?>"
                                       class="btn btn-primary btn-sm">
                                        Tambah Sub
                                    </a>
                                    <a href="<?= site_url("accounts/$account->id/update") ?>"
                                       class="btn btn-warning btn-sm">
                                        <em class="fas fa-pencil-alt btn-small"></em>
                                        Edit
                                    </a>
                                    <form id="<?= "form-del-$account->id" ?>" class="d-inline" method="POST"
                                          action="<?= site_url("accounts/$account->id/delete") ?>">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-danger btn-sm"
                                                data-confirm="Apakah anda yakin untuk menghapus?"
                                                data-confirm-yes="submitDeleteForm(<?= $account->id ?>)">
                                            <em class="fas fa-trash btn-small"></em>Del
                                        </button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>