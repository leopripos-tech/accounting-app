<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Detail Penyesuaian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="<?= site_url("adjustments") ?>">Penyesuaian</a></div>
                <div class="breadcrumb-item">Detail</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-header">
                    <a type="button" href="<?= site_url("adjustments") ?>" class="btn btn-light">Kembali</a>
                    <a href="<?= site_url("adjustments/$adjustment->id/update") ?>" class="btn btn-warning">
                        Update
                    </a>
                </div>
                <div class="card-body">
                    <div class="col-12 form-group row mb-1">
                        <label class="col-form-label  col-12 col-md-3 col-lg-2">No. Kuitansi</label>
                        <div class="col-sm-12 col-md-7 col-form-label">
                            <?= $adjustment->receiptNo ?>
                        </div>
                    </div>
                    <div class="col-12 form-group row mb-1">
                        <label class="col-form-label col-12 col-md-3 col-lg-2">Tanggal</label>
                        <div class="col-sm-12 col-md-7 col-form-label">
                            <?= $adjustment->date ?>
                        </div>
                    </div>
                    <div class="col-12 form-group row mb-1">
                        <label class="col-form-label col-12 col-md-3 col-lg-2">Deskriptis</label>
                        <div class="col-sm-12 col-md-7 col-form-label">
                            <?= $adjustment->description ?>
                        </div>
                    </div>
                    <div class="col-12 form-group row mb-1">
                        <label class="col-form-label col-12 col-md-3 col-lg-2">Nilai Disesuaikan</label>
                        <div class="col-sm-12 col-md-7 col-form-label">
                            <?= number_format($adjustment->value) ?>
                        </div>
                    </div>
                    <div class="col-12 form-group row mb-1">
                        <label class="col-form-label col-12 col-md-3 col-lg-2">Waktu Disesuaikan</label>
                        <div class="col-sm-12 col-md-7 col-form-label">
                            <?= number_format($adjustment->time) ?> Bulan
                        </div>
                    </div>
                    <div class="col-12 form-group row mb-1">
                        <label class="col-form-label col-12 col-md-3 col-lg-2">Total</label>
                            <div class="col-sm-12 col-md-7 col-form-label">
                            <?= number_format($adjustment->total) ?>
                        </div>
                    </div>
                    <div class="col-12">
                        <table class="table table-striped table-md">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Kode Akun</th>
                                <th scope="col">Nama Akun</th>
                                <th scope="col" class="text-right">Debit</th>
                                <th scope="col" style="max-width: 150px;" class="text-right">Kredit</th>
                                <th scope="col" style="max-width: 150px;">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($items as $index => $item) : ?>
                                <input name="id[]" type="hidden" value="<?= $item->id ?>">
                                <tr>
                                    <td>
                                        <?= $index + 1 ?>
                                    </td>
                                    <td>
                                        <?= $item->account_code ?>
                                    </td>
                                    <td>
                                        <?= $item->account_name ?>
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($item->debit) ?>
                                    </td>
                                    <td class="text-right">
                                        <?= number_format($item->credit) ?>
                                    </td>
                                    <td>
                                        <?= $item->status_name ?>
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