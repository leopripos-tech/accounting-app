<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Tambah Transaksi</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="<?= site_url("transactions") ?>">Transaksi</a></div>
                <div class="breadcrumb-item">Tambah</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form method="POST" autocomplete="false">
                        <?= csrf_field() ?>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal</label>
                            <div class="col-sm-12 col-md-7">
                                <input name="date" type="date" value="<?= $transaction->date ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Deskripsi</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea name="description" style="min-height:100px" rows="3"
                                          class="form-control"><?= $transaction->description ?></textarea>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Keterangan
                                Jurnal</label>
                            <div class="col-sm-12 col-md-7">
                                <input name="journal_description" type="texts"
                                       value="<?= $transaction->journal_description ?>" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <div class="col-12">
                                <table class="table table-striped table-md">
                                    <thead>
                                    <tr>
                                        <th scope="col">Akun</th>
                                        <th scope="col">Debit</th>
                                        <th scope="col" style="max-width: 150px;">Kredit</th>
                                        <th scope="col" style="max-width: 150px;">Status</th>
                                        <th scope="col" class="text-center">
                                            <button data-action="add-new-row" class="btn btn-primary btn-sm"
                                                    type="button">Tambah
                                            </button>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($items as $index => $item) : ?>
                                        <tr>
                                            <td>
                                                <select class="form-control" name="account_id[]">
                                                    <?php foreach ($accounts as $account): ?>
                                                        <option value="<?= $account->id ?>"><?= $account->displayName ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            Rp.
                                                        </div>
                                                    </div>
                                                    <input name="debit[]" type="number"
                                                           class="form-control currency">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            Rp.
                                                        </div>
                                                    </div>
                                                    <input name="credit[]" type="number"
                                                           class="form-control currency">
                                                </div>
                                            </td>
                                            <td>
                                                <select class="form-control" name="status_id[]">
                                                    <?php foreach ($statuses as $status): ?>
                                                        <option value="<?= $status->id ?>"><?= $status->name ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td class="text-center" style="width:150px;">
                                                <button class="btn btn-danger btn-sm" data-action="remove-row">
                                                    <em class="fas fa-trash btn-small"></em>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="row-template">
                                        <td>
                                            <select class="form-control" name="account_id[]">
                                                <?php foreach ($accounts as $account): ?>
                                                    <option value="<?= $account->id ?>"><?= $account->displayName ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        Rp.
                                                    </div>
                                                </div>
                                                <input name="debit[]" type="number"
                                                       class="form-control currency">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">
                                                        Rp.
                                                    </div>
                                                </div>
                                                <input name="credit[]" type="number"
                                                       class="form-control currency">
                                            </div>
                                        </td>
                                        <td>
                                            <select class="form-control" name="status_id[]">
                                                <?php foreach ($statuses as $status): ?>
                                                    <option value="<?= $status->id ?>"><?= $status->name ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>
                                        <td class="text-center" style="width:150px;">
                                            <button class="btn btn-danger btn-sm" data-action="remove-row">
                                                <em class="fas fa-trash btn-small"></em>
                                            </button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12"></label>
                            <div class="col-sm-12 col-md-7">
                                <button style="submit" class="btn btn-primary">Simpan</button>
                                <a type="button" href="<?= site_url("transactions") ?>" class="btn btn-light">Batal</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?= $this->endSection() ?>