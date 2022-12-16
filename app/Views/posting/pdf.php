<!DOCTYPE html>
<html>
<style>
    table {
        font-family: Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    table td, table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #04AA6D;
        color: white;
    }
</style>
<body>

<h2>Laporan Posting</h2>
<p>Tanggal: <?= $startDate ?> hingga <?= $endDate ?></p>
<p>Akun: <?= $account->code ?> - <?= $account->name ?></p>

<table>
    <thead>
    <tr>
        <th scope="col" rowspan="2">Tanggal</th>
        <th scope="col" rowspan="2">Keterangan</th>
        <th scope="col" rowspan="2">Ref</th>
        <th scope="col" rowspan="2" style="max-width: 150px;" style="text-align: right">Debit</th>
        <th scope="col" rowspan="2" style="max-width: 150px;" style="text-align: right">Kredit</th>
        <th scope="col" colspan="2" style="max-width: 300px;" style="text-align: center">Balance</th>
    </tr>
    <tr>
        <th scope="col" style="max-width: 150px;" style="text-align: right">Debit</th>
        <th scope="col" style="max-width: 150px;" style="text-align: right">Kredit</th>
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
            <td style="text-align: right">
                <?= number_format($item->debit) ?>
            </td>
            <td style="text-align: right">
                <?= number_format($item->credit) ?>
            </td>
            <td style="text-align: right">
                <?= number_format($item->balance_debit) ?>
            </td>
            <td style="text-align: right">
                <?= number_format($item->balance_credit) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>