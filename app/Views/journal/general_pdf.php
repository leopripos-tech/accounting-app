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

<h2>Jurnal Umum</h2>
<p>Tanggal: <?= $startDate ?> hingga <?= $endDate ?></p>

<table>
    <thead>
    <tr>
        <th scope="col">Tanggal</th>
        <th scope="col">Akun</th>
        <th scope="col">Ref</th>
        <th scope="col">Keterangan</th>
        <th scope="col" style="max-width: 150px;" style="text-align: right">Debit (Rp.)</th>
        <th scope="col" style="max-width: 150px;" style="text-align: right">Kredit (Rp.)</th>
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
            <td style="text-align: right">
                Rp. <?= $item->debit ?>
            </td>
            <td style="text-align: right">
                Rp. <?= $item->credit ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>