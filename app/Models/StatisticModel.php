<?php

namespace App\Models;
use CodeIgniter\Model;

class StatisticModel extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'accounts';

    
    public function getGrowth($year)
    {
        $sql = "SELECT
            dates.year as year,
            dates.month as month,
            IFNULL(SUM(transaction_items.debit), 0) as transaction_debit,
            IFNULL(SUM(transaction_items.credit), 0) as transaction_credit,
            IFNULL(SUM(adjustment_items.debit), 0) as adjustment_debit,
            IFNULL(SUM(adjustment_items.credit), 0) as adjustment_credit,

            IFNULL(SUM(CASE WHEN accounts.code LIKE '1%' THEN transaction_items.debit ELSE 0 END), 0) as transaction_debit_activa,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '1%' THEN transaction_items.credit ELSE 0 END), 0) as transaction_credit_activa,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '1%' THEN adjustment_items.debit ELSE 0 END), 0) as adjustment_debit_activa,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '1%' THEN adjustment_items.credit ELSE 0 END), 0) as adjustment_credit_activa,

            IFNULL(SUM(CASE WHEN accounts.code LIKE '2%' THEN transaction_items.debit ELSE 0 END), 0) as transaction_debit_hutang,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '2%' THEN transaction_items.credit ELSE 0 END), 0) as transaction_credit_hutang,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '2%' THEN adjustment_items.debit ELSE 0 END), 0) as adjustment_debit_hutang,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '2%' THEN adjustment_items.credit ELSE 0 END), 0) as adjustment_credit_hutang,
            
            IFNULL(SUM(CASE WHEN accounts.code LIKE '3%' THEN transaction_items.debit ELSE 0 END), 0) as transaction_debit_modal,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '3%' THEN transaction_items.credit ELSE 0 END), 0) as transaction_credit_modal,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '3%' THEN adjustment_items.debit ELSE 0 END), 0) as adjustment_debit_modal,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '3%' THEN adjustment_items.credit ELSE 0 END), 0) as adjustment_credit_modal,
            
            IFNULL(SUM(CASE WHEN accounts.code LIKE '4%' THEN transaction_items.debit ELSE 0 END), 0) as transaction_debit_pendapatan,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '4%' THEN transaction_items.credit ELSE 0 END), 0) as transaction_credit_pendapatan,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '4%' THEN adjustment_items.debit ELSE 0 END), 0) as adjustment_debit_pendapatan,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '4%' THEN adjustment_items.credit ELSE 0 END), 0) as adjustment_credit_pendapatan,
            
            IFNULL(SUM(CASE WHEN accounts.code LIKE '5%' THEN transaction_items.debit ELSE 0 END), 0) as transaction_debit_beban,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '5%' THEN transaction_items.credit ELSE 0 END), 0) as transaction_credit_beban,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '5%' THEN adjustment_items.debit ELSE 0 END), 0) as adjustment_debit_beban,
            IFNULL(SUM(CASE WHEN accounts.code LIKE '5%' THEN adjustment_items.credit ELSE 0 END), 0) as adjustment_credit_beban
        FROM (
            SELECT 1 as month, :year: as year
            UNION SELECT 2 as month, :year: as year
            UNION SELECT 3 as month, :year: as year
            UNION SELECT 4 as month, :year: as year
            UNION SELECT 5 as month, :year: as year
            UNION SELECT 6 as month, :year: as year
            UNION SELECT 7 as month, :year: as year
            UNION SELECT 8 as month, :year: as year
            UNION SELECT 9 as month, :year: as year
            UNION SELECT 10 as month, :year: as year
            UNION SELECT 10 as month, :year: as year
            UNION SELECT 10 as month, :year: as year
            UNION SELECT 11 as month, :year: as year
            UNION SELECT 12 as month, :year: as year
        ) as dates
        LEFT JOIN transactions on MONTH(transactions.date) = dates.month AND YEAR(transactions.date) = dates.year
        LEFT JOIN transaction_items on transaction_items.transaction_id = transactions.id
        LEFT JOIN adjustments on MONTH(adjustments.date) = dates.month AND YEAR(adjustments.date) = dates.year
        LEFT JOIN adjustment_items on adjustment_items.adjustment_id = adjustments.id
        LEFT JOIN accounts on transaction_items.account_id = accounts.id OR adjustment_items.account_id = accounts.id
        GROUP BY dates.year, dates.month
        ORDER BY  dates.year ASC,  dates.month ASC
        ";

        $items = $this->db->query($sql, [
            'year' => $year
        ])->getResultArray();

        $activa = 0;
        $hutang = 0;
        $modal = 0;
        $pendapatan = 0;
        $beban = 0;
        foreach ($items as $index => $item) {
            $activa += $items[$index]['transaction_debit_activa'] ?? 0;
            $activa -= $items[$index]['transaction_credit_activa'] ?? 0;
            $activa += $items[$index]['adjustment_debit_activa'] ?? 0;
            $activa -= $items[$index]['adjustment_credit_activa'] ?? 0;
            $items[$index]['activa'] = $activa;

            $hutang += $items[$index]['transaction_debit_hutang'] ?? 0;
            $hutang -= $items[$index]['transaction_credit_hutang'] ?? 0;
            $hutang += $items[$index]['adjustment_debit_hutang'] ?? 0;
            $hutang -= $items[$index]['adjustment_credit_hutang'] ?? 0;
            $items[$index]['hutang'] = abs($hutang);

            $modal += $items[$index]['transaction_debit_modal'] ?? 0;
            $modal -= $items[$index]['transaction_credit_modal'] ?? 0;
            $modal += $items[$index]['adjustment_debit_modal'] ?? 0;
            $modal -= $items[$index]['adjustment_credit_modal'] ?? 0;
            $items[$index]['modal'] = abs($modal);

            $pendapatan += $items[$index]['transaction_debit_pendapatan'] ?? 0;
            $pendapatan -= $items[$index]['transaction_credit_pendapatan'] ?? 0;
            $pendapatan += $items[$index]['adjustment_debit_pendapatan'] ?? 0;
            $pendapatan -= $items[$index]['adjustment_credit_pendapatan'] ?? 0;
            $items[$index]['pendapatan'] = abs($pendapatan);
            
            $beban += $items[$index]['transaction_debit_beban'] ?? 0;
            $beban -= $items[$index]['transaction_credit_beban'] ?? 0;
            $beban += $items[$index]['adjustment_debit_beban'] ?? 0;
            $beban -= $items[$index]['adjustment_credit_beban'] ?? 0;
            $items[$index]['beban'] = abs($beban);
        }

        return $items;
    }

    public function getDebitCredit($year)
    {
        $sql = "SELECT
            accounts1.code,
            accounts1.name,
            IFNULL(SUM(transaction_items.debit), 0) as transaction_debit,
            IFNULL(SUM(transaction_items.credit), 0) as transaction_credit,
            IFNULL(SUM(adjustment_items.debit), 0) as adjustment_debit,
            IFNULL(SUM(adjustment_items.credit), 0) as adjustment_credit,
            (IFNULL(SUM(transaction_items.debit), 0) + IFNULL(SUM(adjustment_items.debit), 0)) as debit,
            (IFNULL(SUM(transaction_items.credit), 0) + IFNULL(SUM(adjustment_items.credit), 0)) as credit
        FROM (
            SELECT id, code, name from accounts where level = 0
        ) as accounts1
        LEFT JOIN accounts as accounts2 on accounts1.id = accounts2.parent_id AND accounts2.level = 1
        LEFT JOIN accounts as accounts3 on accounts2.id = accounts3.parent_id AND accounts3.level = 2
        LEFT JOIN transaction_items on transaction_items.account_id = accounts3.id
        LEFT JOIN adjustment_items on adjustment_items.account_id = accounts3.id
        GROUP BY accounts1.code, accounts1.name
        ORDER BY accounts1.code ASC
        ";

        $items = $this->db->query($sql, [
            'year' => $year
        ])->getResultArray();

        return $items;
    }

    public function getAccountDebitCredit($year, $accountCode)
    {
        $sql = "SELECT
            accounts3.code,
            accounts3.name,
            IFNULL(SUM(transaction_items.debit), 0) as transaction_debit,
            IFNULL(SUM(transaction_items.credit), 0) as transaction_credit,
            IFNULL(SUM(adjustment_items.debit), 0) as adjustment_debit,
            IFNULL(SUM(adjustment_items.credit), 0) as adjustment_credit,
            (IFNULL(SUM(transaction_items.debit), 0) + IFNULL(SUM(adjustment_items.debit), 0)) as debit,
            (IFNULL(SUM(transaction_items.credit), 0) + IFNULL(SUM(adjustment_items.credit), 0)) as credit
        FROM (
            SELECT id, code, name from accounts where code = :account_code:
        ) as accounts1
        LEFT JOIN accounts as accounts2 on accounts1.id = accounts2.parent_id AND accounts2.level = 1
        LEFT JOIN accounts as accounts3 on accounts2.id = accounts3.parent_id AND accounts3.level = 2
        LEFT JOIN transaction_items on transaction_items.account_id = accounts3.id
        LEFT JOIN adjustment_items on adjustment_items.account_id = accounts3.id
        GROUP BY accounts3.code, accounts3.name
        ORDER BY accounts3.code ASC
        ";

        $items = $this->db->query($sql, [
            'year' => $year,
            'account_code' => $accountCode,
        ])->getResultArray();

        return $items;
    }
}
