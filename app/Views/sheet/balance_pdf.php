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

<h2>Neraca Saldo</h2>
<p>Tanggal: <?= $startDate ?> hingga <?= $endDate ?></p>

<table>
    <thead>
    <tr>
        <th scope="col">Kode</th>
        <th scope="col">Nama</th>
        <th scope="col" style="max-width: 150px;" style="text-align: right">Debit (Rp.)</th>
        <th scope="col" style="max-width: 150px;" style="text-align: right">Kredit (Rp.)</th>
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
            <td style="text-align: right">
                <?= number_format( $item->debit) ?>
            </td>
            <td style="text-align: right">
                <?= number_format( $item->credit) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <td colspan="2" style="text-align: right">
            Total
        </td>
        <td style="text-align: right">
            s<?= number_format($totalDebit) ?>
        </td>
        <td style="text-align: right">
            <?= number_format( $totalCredit) ?>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>