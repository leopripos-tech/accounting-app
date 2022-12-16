<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Laporan Posting</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Laporan Posting</div>
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
                            <select class="form-control" name="account_id">
                                <?php foreach ($accounts as $account): ?>
                                    <option value="<?= $account->id ?>"><?= $account->displayName ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col text-right" style="padding-right: 0;">
                            <a href="<?= site_url("posting/pdf") ?>" class="btn btn-info">Download Pdf</a>
                            <a href="<?= site_url("posting/excel") ?>" class="btn btn-info">Download Excel</a>
                        </div>
                    </form>
                    <table class="table table-striped table-md">
                        <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="vertical-align: middle">Tanggal</th>
                            <th scope="col" rowspan="2" style="vertical-align: middle">Keterangan</th>
                            <th scope="col" rowspan="2" style="vertical-align: middle">Ref</th>
                            <th scope="col" rowspan="2" style="max-width: 150px; vertical-align: middle"
                                class="text-right">Debit (Rp.)
                            </th>
                            <th scope="col" rowspan="2" style="max-width: 150px; vertical-align: middle"
                                class="text-right">Kredit (Rp.)
                            </th>
                            <th scope="col" colspan="2" style="max-width: 300px;" class="text-center">Saldo</th>
                        </tr>
                        </tr>
                        <tr>
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
                                    <?= $item->transaction_journal_description ?>
                                </td>
                                <td>
                                    <?= $item->getReceiptNo() ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->debit) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->credit) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->balance_debit) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->balance_credit) ?>
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