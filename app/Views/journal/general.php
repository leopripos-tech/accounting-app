<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Jurnal Umum</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Jurnal Umum</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form method="GET" autocomplete="false" class="row mb-4" style="width: 100%">
                        <div class="col">
                            <input name="startDate" type="date" value="<?= $startDate ?>" class="form-control">
                        </div>
                        <div class="col">
                            <input name="endDate" type="date" value="<?= $endDate ?>" class="form-control">
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col text-right" style="padding-right:0">
                            <a href="<?= site_url("journal/general/pdf") ?>" class="btn btn-info">Download Pdf</a>
                            <a href="<?= site_url("journal/general/excel") ?>" class="btn btn-info">Download Excel</a>
                        </div>
                    </form>
                    <table class="table table-striped table-md">
                        <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Akun</th>
                            <th scope="col">Ref</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" style="max-width: 150px;" class="text-right">Debit (Rp.)</th>
                            <th scope="col" style="max-width: 150px;" class="text-right">Kredit (Rp.)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $index => $item) : ?>
                            <tr>
                                <td>
                                    <?= $item->transaction_date ?>
                                </td>
                                <td>
                                    <?= $item->account_name ?>
                                </td>
                                <td>
                                    <?= $item->getReceiptNo() ?>
                                </td>
                                <td>
                                    <?= $item->transaction_journal_description ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->debit) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->credit) ?>
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