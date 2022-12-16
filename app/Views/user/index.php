<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Daftar Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Users</div>
        </div>
    </div>

    <div class="section-body">
        <div class="card">
            <div class="card-header">
                <a href="<?= site_url("users/create") ?>" class="btn btn-primary">
                    Tambah
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-md datatable-enable">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user) : ?>
                                <tr>
                                    <th scope="row"><?= $index + 1 ?></th>
                                    <td><?= $user->username ?></td>
                                    <td><?= $user->email ?></td>
                                    <td class="text-center" style="width:200px;">
                                        <a href="<?= site_url("users/$user->id/update") ?>" class="btn btn-warning  btn-sm">
                                            <em class="fas fa-pencil-alt btn-small"></em>
                                            Edit
                                        </a>
                                        <form id="<?= "form-del-$user->id" ?>" class="d-inline" method="POST" action="<?= site_url("users/$user->id/delete") ?>">
                                            <?= csrf_field() ?>
                                            <button class="btn btn-danger btn-sm" data-confirm="Apakah anda yakin untuk menghapus?" data-confirm-yes="submitDeleteForm(<?= $user->id ?>)">
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