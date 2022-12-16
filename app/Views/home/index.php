<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['growth']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="growth"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['debit_credit']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="debit_credit"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['debit_credit_activa']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="debit_credit_activa"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['debit_credit_hutang']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="debit_credit_hutang"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['debit_credit_modal']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="debit_credit_modal"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['debit_credit_pendapatan']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="debit_credit_pendapatan"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4><?= $charts['debit_credit_beban']['title'] ?></h4>
                    </div>
                    <div class="card-body">
                        <canvas id="debit_credit_beban"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>


<?= $this->section('javascript') ?>
<script>
    function lineChart(id, labels, datasets) {
        new Chart(document.getElementById(id).getContext("2d"), {
            type: "line",
            data: {
                labels: labels,
                datasets: datasets,
            },
            options: {
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: "#f2f2f2",
                        },
                    }, ],
                    xAxes: [{
                        ticks: {
                            display: true,
                        },
                        gridLines: {
                            display: false,
                        },
                    }, ],
                },
            },
        });
    }

    function barDebitCredit(id, labels, datashets) {
        new Chart(document.getElementById(id).getContext("2d"), {
            type: "bar",
            data: {
                labels: labels,
                datasets: datashets,
            },
            options: {
                legend: {
                    display: true,
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            drawBorder: false,
                            color: "#f2f2f2",
                        },
                    }, ],
                    xAxes: [{
                        ticks: {
                            display: true,
                        },
                        gridLines: {
                            display: false,
                        },
                    }, ],
                },
            },
        });
    }

    $(document).ready(() => {

        lineChart(
            'growth',
            <?= json_encode($charts['growth']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['growth']['datasets'])) ?>
        );

        barDebitCredit(
            "debit_credit",
            <?= json_encode($charts['debit_credit']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['debit_credit']['datasets'])) ?>
        );

        barDebitCredit(
            "debit_credit_activa",
            <?= json_encode($charts['debit_credit_activa']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['debit_credit_activa']['datasets'])) ?>
        );

        barDebitCredit(
            "debit_credit_hutang",
            <?= json_encode($charts['debit_credit_hutang']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['debit_credit_hutang']['datasets'])) ?>
        );

        barDebitCredit(
            "debit_credit_modal",
            <?= json_encode($charts['debit_credit_modal']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['debit_credit_modal']['datasets'])) ?>
        );

        barDebitCredit(
            "debit_credit_pendapatan",
            <?= json_encode($charts['debit_credit_pendapatan']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['debit_credit_pendapatan']['datasets'])) ?>
        );

        barDebitCredit(
            "debit_credit_beban",
            <?= json_encode($charts['debit_credit_beban']['labels']) ?>,
            <?= json_encode(array_map(function ($item) {
                return [
                    'label' => $item['title'] ?? 'Growth',
                    'data' => $item['data'] ?? [],
                    'borderWidth' => $item['borderWidth'] ?? 2,
                    'backgroundColor' => $item['backgroundColor'] ?? "transparent",
                    'borderColor' => $item['borderColor'] ?? "transparent",
                    'borderWidth' => $item['borderWidth'] ?? 2.5,
                    'pointBackgroundColor' => $item['pointBackgroundColor'] ?? "#ffffff",
                    'pointRadius' => $item['pointRadius'] ?? 4,
                ];
            }, $charts['debit_credit_beban']['datasets'])) ?>
        );
    });
</script>
<?= $this->endSection() ?>