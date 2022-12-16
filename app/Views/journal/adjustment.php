<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Jurnal Penyesuaian</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Jurnal Penyesuaian</div>
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
                        <div class="col text-right" style="padding-right:0px">
                            <a href="<?= site_url("journal/adjustment/pdf") ?>" class="btn btn-info">Download Pdf</a>
                            <a href="<?= site_url("journal/adjustment/excel") ?>" class="btn btn-info">Download Excel</a>
                        </div>
                    </form>
                    <table class="table table-striped table-md">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col" style="max-width: 150px;" class="text-right">Debit (Rp.)</th>
                            <th scope="col" style="max-width: 150px;" class="text-right">Kredit (Rp.)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $index => $item) : ?>
                            <tr>
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
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2" class="text-right">
                                Total
                            </td>
                            <td class="text-right">
                                <?= number_format($totalDebit); ?>
                            </td>
                            <td class="text-right">
                                <?= number_format($totalCredit) ?>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </section>
<?= $this->endSection() ?>