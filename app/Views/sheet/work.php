<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <section class="section">
        <div class="section-header">
            <h1>Neraca Lajur</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Neraca Lajur</div>
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
                            <button style="submit" class="btn btn-primary">Filter</button>
                        </div>
                        <div class="col text-right">
                            <a href="<?= site_url("sheet/work/pdf") ?>" class="btn btn-info">Download</a>
                        </div>
                    </form>
                    <table class="table table-striped table-md">
                        <thead>
                        <tr>
                            <th scope="col" rowspan="2" style="vertical-align: middle">Kode</th>
                            <th scope="col" rowspan="2" style="vertical-align: middle">Nama</th>
                            <th scope="col" colspan="2" style="max-width: 150px;" class="text-center">Necara Saldo</th>
                            <th scope="col" colspan="2" style="max-width: 150px;" class="text-center">Jurnal Penyesuaian</th>
                            <th scope="col" colspan="2" style="max-width: 150px;" class="text-center">NC Disesuaikan</th>
                            <th scope="col" colspan="2" style="max-width: 150px;" class="text-center">Laba Rugi</th>
                            <th scope="col" colspan="2" style="max-width: 150px;" class="text-center">Neraca</th>
                        </tr>
                        <tr>
                            <th scope="col" style="max-width: 150px;" class="text-center">Debit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Kredit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Debit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Kredit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Debit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Kredit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Debit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Kredit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Debit</th>
                            <th scope="col" style="max-width: 150px;" class="text-center">Kredit</th>
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
                                    <?= number_format($item->balance_debit) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->balance_credit) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->adjustment_debit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->adjustment_credit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->adjusted_balance_debit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->adjusted_balance_credit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->revenue_debit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->revenue_credit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->sheet_balance_credit ?? 0) ?>
                                </td>
                                <td class="text-right">
                                    <?= number_format($item->sheet_balance_debit ?? 0) ?>
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