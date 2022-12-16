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

    .text-right {
        text-align: right;
    }
</style>
<body>

<h2>Neraca</h2>
<p>Tanggal: <?= $startDate ?> hingga <?= $endDate ?></p>

<table>
    <thead>
    <tr>
        <th scope="col" rowspan="2">Kode</th>
        <th scope="col" rowspan="2">Nama</th>
        <th scope="col" colspan="2" style="text-align: center">Neraca</th>
    </tr>
    <tr>
        <th scope="col" style="max-width: 150px;" style="text-align: center">Debit (Rp.)</th>
        <th scope="col" style="max-width: 150px;" style="text-align: center">Kredit (Rp.)</th>
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
                <?= number_format($item->sheet_balance_credit ?? 0) ?>
            </td>
            <td class="text-right">
                <?= number_format($item->sheet_balance_debit ?? 0) ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>