
<?php 
    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
    include "franchise_report.php";
    include "applicants_report.php";
    include "complaints_report.php";
    include "violations_report.php";
   
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
.btn.btn-primary {
    background-color: #2680C2;
    color: #fff;
    border: 1px solid #2680C2;
    box-shadow: inset 0 0 0 0 #fff;
    border-radius: 4px;
    transition: all 0.3s ease;
}

.btn.btn-primary:hover {
    background-color: #fff;
    border-color: #2680C2;
    color: #2680C2;
    box-shadow: inset 0 50px 0 0 #fff;
}

</style>

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
    
    <?php include "../include/topbarAdmin.php"; ?>
    
    <!-- Main Content -->
    <div class="col-md-12" style="margin-left:20px">
        <h1 class="h3 mb-0 text-gray-800">Reports</h1>

        <!-- Filters and Generate Button -->
        <div class="d-flex align-items-center mt-0 flex-wrap">
         
<!-- Select Report Type -->
<div class="report-type me-2">
    <select id="reportType" class="form-select custom-select" aria-label="Default select example">
        <option selected>Select Report</option>
        <option value="tricycleFranchise">Tricycle Franchise</option>
        <option value="applicants">Franchise Applicants</option>
        <option value="complaints">Complaints</option>
        <option value="violations">Violations</option>
    </select>
</div>

<div>
    <button id="generateReport" class="btn btn-primary" style="margin-right:5px;">Generate Report</button>
    <button id="printReport" class="btn btn-primary">Print Report</button>
</div>

<!-- Tricycle Franchise Report -->
<div id="tricycleFranchiseReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
             <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px;">
                <button onclick="switchView('tricycleFranchise', 'chart')" class="tab-btn active-tab">Chart View</button>
                <button onclick="switchView('tricycleFranchise', 'table')" class="tab-btn">Table View</button>
            </div>
            <h3 style="text-align: center;"><b>Tricycle Franchise Report - <?php echo date("Y"); ?></b></h3>
        
            <!-- Table View (hidden by default) -->
            <div id="tricycleFranchiseTable" class="table-responsive" style="display: none; align-items-center">
                <table class="table table-striped text-center" style="align-items-center; text-align: center;">
                    <thead>
                        <tr>
                            <th><b>Month</b></th>
                            <th><b>Total No. of Franchise</b></th>
                            <th><b>Total No. of Franchise Renewed</b></th>
                            <th><b>Total No. of Expired Franchise</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Define month labels and data arrays
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'];
                        $totalFranchises = [$jan_Count, $feb_Count, $march_Count, $apr_Count, $may_Count, $jun_Count, $jul_Count, $aug_Count, $sep_Count, $oct_Count];
                        $renewedFranchises = [$jan_renewedCount, $feb_renewedCount, $march_renewedCount, $apr_renewedCount, $may_renewedCount, $jun_renewedCount, $jul_renewedCount, $aug_renewedCount, $sep_renewedCount, $oct_renewedCount];
                        $expiredFranchises = [$jan_expiredCount, $feb_expiredCount, $march_expiredCount, $apr_expiredCount, $may_expiredCount, $jun_expiredCount, $jul_expiredCount, $aug_expiredCount, $sep_expiredCount, $oct_expiredCount];

                        // Calculate totals
                        $totalFranchisesSum = array_sum($totalFranchises);
                        $totalRenewedSum = array_sum($renewedFranchises);
                        $totalExpiredSum = array_sum($expiredFranchises);

                        // Loop through each month and display data
                        foreach ($months as $index => $month) {
                            echo "<tr>
                                    <td>{$month}</td>
                                    <td>{$totalFranchises[$index]}</td>
                                    <td>{$renewedFranchises[$index]}</td>
                                    <td>{$expiredFranchises[$index]}</td>
                                  </tr>";
                        }
                        ?>
                        <!-- Total Row -->
                        <tr class="total-row">
                            <td><strong>TOTAL</strong></td>
                            <td><b><?php echo $totalFranchisesSum; ?></b></td>
                            <td><b><?php echo $totalRenewedSum; ?></b></td>
                            <td><b><?php echo $totalExpiredSum; ?></b></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Chart View (visible by default) -->
            <div id="tricycleFranchiseChart" class="chart-container mt-4" style="display: block; max-width: 950px; margin: 0 auto;">
                <canvas id="monthlyFranchiseReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                <br><br><br>
                <canvas id="totalFranchiseReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
            </div>
        </div>
    </div>
</div>



<!-- Applicants Report -->
<div id="applicantsReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            
              <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px;">
                <button onclick="switchView('applicants', 'chart')" class="tab-btn active-tab">Chart View</button>
                <button onclick="switchView('applicants', 'table')" class="tab-btn">Table View</button>
            </div>

            <h3 style="text-align: center;"><b>Applicants Report - <?php echo date("Y")?></b></h3>
        
            <!-- Table View (hidden by default) -->
            <div id="applicantsTable" class="table-responsive" style="display: none; align-items-center">
                <table class="table table-striped text-center" style="align-items-center; text-align: center;">
                    <thead>
                        <tr>
                            <th><b>Month</b></th>
                            <th><b>Total No. of Applicants</b></th>
                            <th><b>Verified Applicants</b></th>
                            <th><b>Pending Applicants</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Define month labels and data arrays
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $totalApplicants = [$janCount, $febCount, $marCount, $aprCount, $mayCount, $junCount, $julCount, $augCount, $sepCount, $octCount, $novCount, $decCount];
                        $verifiedApplicants = [$janCount_verified, $febCount_verified, $marCount_verified, $aprCount_verified, $mayCount_verified, $junCount_verified, $julCount_verified, $augCount_verified, $sepCount_verified, $octCount_verified, $novCount_verified, $decCount_verified];
                        $pendingApplicants = [$janCount_pending, $febCount_pending, $marCount_pending, $aprCount_pending, $mayCount_pending, $junCount_pending, $julCount_pending, $augCount_pending, $sepCount_pending, $octCount_pending, $novCount_pending, $decCount_pending];

                        // Loop through each month and display data
                        foreach ($months as $index => $month) {
                            echo "<tr>
                                    <td>{$month}</td>
                                    <td>{$totalApplicants[$index]}</td>
                                    <td>{$verifiedApplicants[$index]}</td>
                                    <td>{$pendingApplicants[$index]}</td>
                                  </tr>";
                        }

                        // Total Row (aggregated totals for the whole year)
                        $totalApplicantsSum = array_sum($totalApplicants);
                        $verifiedApplicantsSum = array_sum($verifiedApplicants);
                        $pendingApplicantsSum = array_sum($pendingApplicants);

                        echo "<tr class='total-row'>
                                <td><strong>TOTAL</strong></td>
                                <td><b>{$totalApplicantsSum}</b></td>
                                <td><b>{$verifiedApplicantsSum}</b></td>
                                <td><b>{$pendingApplicantsSum}</b></td>
                              </tr>";
                        ?>
                    </tbody>
                </table>
            </div>

           <!-- Chart View (visible by default) -->
            <div id="applicantsChart" class="chart-container mt-4" style="display: block; max-width: 950px; margin: 0 auto;">
                <canvas id="applicantsChartReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                <br><br><br>
                <canvas id="totalApplicantReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
            </div>
        </div>
    </div>
</div>


<!-- Complaints Report -->
<div id="complaintsReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            
                <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px;">
                <button onclick="switchView('complaints', 'chart')" class="tab-btn active-tab">Chart View</button>
                <button onclick="switchView('complaints', 'table')" class="tab-btn">Table View</button>
            </div>

            <h3 style="text-align: center;"><b>Complaints Report - <?php echo date("Y")?></b></h3>
              <!-- Table View (hidden by default) -->
            <div id="complaintsTable" class="table-responsive" style="display: none; align-items-center">
                <table class="table table-striped text-center" style="align-items-center; text-align: center;">
                    <thead>
                        <tr>
                            <th><b>Month</b></th>
                            <th><b>Total No. of Complaints</b></th>
                            <th><b>Total No. of Resolved Complaints</b></th>
                            <th><b>Total No. of Dismissed Complaints</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Define month labels and data arrays
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $totalComplaints = [$jan_count, $feb_count, $mar_count, $apr_count, $may_count, $jun_count, $jul_count, $aug_count, $sep_count, $oct_count, $nov_count, $dec_count];
                        $complaintsMonth_ResolvedCount = [$janCount_resolved, $febCount_resolved, $marCount_resolved, $aprCount_resolved, $mayCount_resolved, $junCount_resolved, $julCount_resolved, $augCount_resolved, $sepCount_resolved, $octCount_resolved, $novCount_resolved, $decCount_resolved];
                        $complaintsMonth_DismissedCount = [$janCount_dismissed, $febCount_dismissed, $marCount_dismissed, $aprCount_dismissed, $mayCount_dismissed, $junCount_dismissed, $julCount_dismissed, $augCount_dismissed, $sepCount_dismissed, $octCount_dismissed, $novCount_dismissed, $decCount_dismissed];

                        // Loop through each month and display data
                        foreach ($months as $index => $month) {
                            echo "<tr>
                                    <td>{$month}</td>
                                    <td>{$totalComplaints[$index]}</td>
                                    <td>{$complaintsMonth_ResolvedCount[$index]}</td>
                                    <td>{$complaintsMonth_DismissedCount[$index]}</td>
                                  </tr>";
                        }

                        // Total Row (aggregated totals for the whole year)
                        $totalComplaintsSum = array_sum($totalComplaints);
                        $complaintsMonth_ResolvedCountSum = array_sum($complaintsMonth_ResolvedCount);
                        $complaintsMonth_DismissedCountSum = array_sum($complaintsMonth_DismissedCount);

                        echo "<tr class='total-row'>
                                <td><strong>TOTAL</strong></td>
                                <td><b>{$totalComplaintsSum }</b></td>
                                <td><b>{$complaintsMonth_ResolvedCountSum}</b></td>
                                <td><b>{$complaintsMonth_DismissedCountSum}</b></td>
                              </tr>";
                        ?>
                    </tbody>
                </table>
            </div>
            
          
           <!-- Chart View (visible by default) -->
                <div id="complaintsChart" div class="chart-container mt-4" style="max-width: 950px; margin: 0 auto;">
                    <canvas id="complaintsChartReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                    <br><br><br>
                    <canvas id="totalComplaintsReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Violations Report -->
<div id="violationsReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            
               <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px;">
                <button onclick="switchView('violations', 'chart')" class="tab-btn active-tab">Chart View</button>
                <button onclick="switchView('violations', 'table')" class="tab-btn">Table View</button>
            </div>
            
           <h3 style="text-align: center;"><b>Violations Report - <?php echo date("Y")?></b></h3>
           
           <!-- Table View (hidden by default) -->
            <div id="violationsTable" class="table-responsive" style="display: none; align-items-center">
                <table class="table table-striped text-center" style="align-items-center; text-align: center;">
                    <thead>
                        <tr>
                            <th><b>Month</b></th>
                            <th><b>Total No. of Violations</b></th>
                            <th><b>Settled Violations</b></th>
                            <th><b>UnSettled Violations</b></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Define month labels and data arrays
                        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                        $totalViolations = [$Jan_count, $Feb_count, $Mar_count, $Apr_count, $May_count, $Jun_count, $Jul_count, $Aug_count, $Sep_count, $Oct_count, $Nov_count, $Dec_count];
                        $violationsMonth_SettledCount = [$janCount_settled, $febCount_settled, $marCount_settled, $aprCount_settled, $mayCount_settled, $junCount_settled, $julCount_settled, $augCount_settled, $sepCount_settled, $octCount_settled, $novCount_settled, $decCount_settled];
                        $violationsMonth_UnSettledCount = [$janCount_unsettled, $febCount_unsettled, $marCount_unsettled, $aprCount_unsettled, $mayCount_unsettled, $junCount_unsettled, $julCount_unsettled, $augCount_unsettled, $sepCount_unsettled, $octCount_unsettled, $novCount_unsettled, $decCount_unsettled];

                        // Loop through each month and display data
                        foreach ($months as $index => $month) {
                            echo "<tr>
                                    <td>{$month}</td>
                                    <td>{$totalViolations[$index]}</td>
                                    <td>{$violationsMonth_SettledCount[$index]}</td>
                                    <td>{$violationsMonth_UnSettledCount[$index]}</td>
                                  </tr>";
                        }

                        // Total Row (aggregated totals for the whole year)
                        $totalViolationsSum = array_sum($totalViolations);
                        $violationsMonth_SettledCountSum = array_sum($violationsMonth_SettledCount);
                        $violationsMonth_UnSettledCountSum = array_sum($violationsMonth_UnSettledCount);

                        echo "<tr class='total-row'>
                                <td><strong>TOTAL</strong></td>
                                <td><b>{$totalViolationsSum}</b></td>
                                <td><b>{$violationsMonth_SettledCountSum}</b></td>
                                <td><b>{$violationsMonth_UnSettledCountSum}</b></td>
                              </tr>";
                        ?>
                    </tbody>
                </table>
            </div>

            
                <div id="violationsChart" div class="chart-container mt-4" style="max-width: 950px; margin: 0 auto;">
                    <canvas id="violationsChartReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                    <br><br><br>
                    <canvas id="totalViolationsReport" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                </div>
        </div>
    </div>
</div>

<style>
    .tab-btn {
    padding: 10px 20px;
    cursor: pointer;
    background-color: #f1f1f1;
    border: none;
    outline: none;
    transition: background-color 0.3s;
}

.tab-btn:hover {
    background-color: #ddd;
}

.active-tab {
    background-color: #ccc;
    font-weight: bold;
    
}
</style>
<script>
document.getElementById('generateReport').addEventListener('click', function () {
    var selectedReport = document.getElementById('reportType').value;

    // Hide both containers initially
    document.getElementById('tricycleFranchiseReportContainer').style.display = 'none';
    document.getElementById('applicantsReportContainer').style.display = 'none';
    document.getElementById('complaintsReportContainer').style.display = 'none';
    document.getElementById('violationsReportContainer').style.display = 'none';

    // Display the selected report container and draw the charts
    if (selectedReport === 'tricycleFranchise') {
        document.getElementById('tricycleFranchiseReportContainer').style.display = 'block';
        drawTricycleFranchiseCharts();
    } else if (selectedReport === 'applicants') {
        document.getElementById('applicantsReportContainer').style.display = 'block';
        drawApplicantsCharts();
    }else if (selectedReport === 'complaints') {
        document.getElementById('complaintsReportContainer').style.display = 'block';
        drawComplaintsCharts();
    }else if (selectedReport === 'violations') {
        document.getElementById('violationsReportContainer').style.display = 'block';
        drawViolationsCharts();
    }
    
    // Attach the print logic to the print button
    document.getElementById('printReport').addEventListener('click', function () {
        printReport(selectedReport);
    });
});

// tab switching
function switchView(reportType, view) {
    const tableView = document.getElementById(`${reportType}Table`);
    const chartView = document.getElementById(`${reportType}Chart`);
    const tableBtn = document.querySelector(`[onclick="switchView('${reportType}', 'table')"]`);
    const chartBtn = document.querySelector(`[onclick="switchView('${reportType}', 'chart')"]`);

    if (view === 'table') {
        tableView.style.display = 'block';
        chartView.style.display = 'none';
        tableBtn.classList.add('active-tab');
        chartBtn.classList.remove('active-tab');
    } else {
        tableView.style.display = 'none';
        chartView.style.display = 'block';
        tableBtn.classList.remove('active-tab');
        chartBtn.classList.add('active-tab');
        
        // Call the function to redraw the chart if switching back to chart view
        if (reportType === 'tricycleFranchise') {
            drawTricycleFranchiseCharts();
        } else if (reportType === 'applicants') {
            drawApplicantsCharts();
        } else if (reportType === 'complaints') {
            drawComplaintsCharts();
        } else if (reportType === 'violations') {
            drawViolationsCharts();
        }
    }
}

// printing report
let printWindow = null;

function printReport(selectedReport) {
     let reportContainerId;
    let reportTitle;
    const currentYear = new Date().getFullYear(); // Get the current year

    // Map the selected report to its container and title
    if (selectedReport === 'tricycleFranchise') {
        reportContainerId = 'tricycleFranchiseReportContainer';
        reportTitle = `Tricycle Franchise Report - ${currentYear}`;
    } else if (selectedReport === 'applicants') {
        reportContainerId = 'applicantsReportContainer';
        reportTitle = `Applicants Report - ${currentYear}`;
    } else if (selectedReport === 'complaints') {
        reportContainerId = 'complaintsReportContainer';
        reportTitle = `Complaints Report - ${currentYear}`;
    } else if (selectedReport === 'violations') {
        reportContainerId = 'violationsReportContainer';
        reportTitle = `Violations Report - ${currentYear}`;
    }
    
    const selectedReportContainer = document.getElementById(reportContainerId);
    const chartCanvases = selectedReportContainer.querySelectorAll('canvas');
    const tableElement = selectedReportContainer.querySelector('table');

    if (printWindow) {
        printWindow.close(); // Close the previous window to reset it
    }

    printWindow = window.open('', '', 'height=700,width=1000');

    printWindow.document.write(`
        <html>
        <head>
            <title>Print Report</title>
            <style>
                @media print {
                    body {
                        -webkit-print-color-adjust: exact;
                        font-family: Arial, sans-serif;
                    }
                    .chart-container, .table-container {
                        max-width: 950px;
                        margin: 0 auto;
                        page-break-after: always;
                    }
                    h1 {
                        text-align: center;
                        font-size: 24px;
                        margin: 20px 0;
                    }
                    img {
                        width: 100%;
                        height: auto;
                        display: block;
                        margin-bottom: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        border: 2px solid black;
                    }
                    th, td {
                        border: 1px solid black;
                        padding: 8px;
                        text-align: center;
                    }
                }
            </style>
        </head>
        <body>
            <h1>${reportTitle}</h1>
            <div id="chartContent" class="chart-container"></div>
            <div id="tableContent" class="table-container"></div>
        </body>
        </html>
    `);

    printWindow.document.close();

    // Clear previous content from print window
    const chartContent = printWindow.document.getElementById('chartContent');
    const tableContent = printWindow.document.getElementById('tableContent');
    chartContent.innerHTML = '';
    tableContent.innerHTML = '';

    // Add selected report charts to the print window
    Promise.all(
        Array.from(chartCanvases).map(chartCanvas => {
            return new Promise((resolve) => {
                const chartImage = new Image();
                chartImage.src = chartCanvas.toDataURL('image/png');
                chartImage.onload = () => {
                    chartContent.appendChild(chartImage);
                    resolve();
                };
            });
        })
    ).then(() => {
        // Clone the selected report's table and add to print window
        if (tableElement) {
            const tableClone = tableElement.cloneNode(true);
            tableContent.appendChild(tableClone);
        }

        // Print the report after a short delay to ensure content is loaded
        setTimeout(function () {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
            printWindow = null; // Reset the print window after printing
        }, 500);
    });
}



// Function to draw text on top of bars
const drawTotalsOnBars = {
    id: 'drawTotalsOnBars',
    afterDatasetsDraw(chart, args, options) {
        const { ctx, data } = chart;

        chart.data.datasets.forEach((dataset, index) => {
            const datasetMeta = chart.getDatasetMeta(index);
            datasetMeta.data.forEach((bar, i) => {
                if (dataset.data[i] !== null && dataset.data[i] !== 0) { // Only draw if value is not null or zero
                    const dataValue = dataset.data[i];
                    ctx.fillStyle = 'black'; // Text color
                    ctx.font = '12px Nunito'; // Text font
                    ctx.textAlign = 'center'; // Text alignment
                    ctx.fillText(dataValue, bar.x, bar.y - 5); // Position the text above the bar
                }
            });
        });
    }
};

let monthlyFranchiseChart;
let totalFranchiseChart;
let applicantsChart;
let totalApplicantChart;
let complaintsChart;
let totalComplaintsReport;
let violationsChart;
let totalViolationsReport;

function drawTricycleFranchiseCharts() {
    // Data for monthly chart
    var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'];
    var totalFranchises = <?php echo json_encode([$jan_Count, $feb_Count, $march_Count, $apr_Count, $may_Count, $jun_Count, $jul_Count, $aug_Count, $sep_Count, $oct_Count]); ?>;
    var renewedFranchises = <?php echo json_encode([$jan_renewedCount, $feb_renewedCount, $march_renewedCount, $apr_renewedCount, $may_renewedCount, $jun_renewedCount, $jul_renewedCount, $aug_renewedCount, $sep_renewedCount, $oct_renewedCount]); ?>;
    var expiredFranchises = <?php echo json_encode([$jan_expiredCount, $feb_expiredCount, $march_expiredCount, $apr_expiredCount, $may_expiredCount, $jun_expiredCount, $jul_expiredCount, $aug_expiredCount, $sep_expiredCount, $oct_expiredCount]); ?>;

    // Data for total chart
    var totalLabels = ['TOTAL NO. OF FRANCHISE', 'RENEWED FRANCHISE', 'EXPIRED FRANCHISE'];
    var totalFranchiseData = [<?php echo $operatorsCount; ?>, null, null];
    var totalRenewedData = [null, <?php echo $operators_renewedCount; ?>, null];
    var totalExpiredData = [null, null, <?php echo $operators_expiredCount; ?>];

    // Destroy existing charts if they exist
    if (monthlyFranchiseChart) {
        monthlyFranchiseChart.destroy();
    }
    if (totalFranchiseChart) {
        totalFranchiseChart.destroy();
    }

    // Draw Monthly Report Chart
    var ctx1 = document.getElementById('monthlyFranchiseReport').getContext('2d');
    monthlyFranchiseChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: ' No. of Franchise',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalFranchises
                },
                {
                    label: 'Renewed Franchise',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: renewedFranchises
                },
                {
                    label: 'Expired Franchise',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: expiredFranchises
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                }
            }
         },
        plugins: [drawTotalsOnBars] // Register the plugin
    });

    // Draw Total Report Chart
    var ctx2 = document.getElementById('totalFranchiseReport').getContext('2d');
    totalFranchiseChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: totalLabels,
            datasets: [
                {
                    label: 'Total No. of Franchise',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalFranchiseData
                },
                {
                    label: 'Total Renewed Franchise',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: totalRenewedData
                },
                {
                    label: 'Total Expired Franchise',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: totalExpiredData
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                },
                x: {
                    stacked: true, // Stack the bars for better alignment
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });
}

function drawApplicantsCharts() {
    var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var totalApplicants = <?php echo json_encode([$janCount, $febCount, $marCount, $aprCount, $mayCount, $junCount, $julCount, $augCount, $sepCount, $octCount, $novCount, $decCount]); ?>;
    var applicantsMonth_VerifiedCount = <?php echo json_encode([$janCount_verified, $febCount_verified, $marCount_verified, $aprCount_verified, $mayCount_verified, $junCount_verified, $julCount_verified, $augCount_verified, $sepCount_verified, $octCount_verified, $novCount_verified, $decCount_verified]); ?>;
    var applicantsMonth_PendingCount = <?php echo json_encode([$janCount_pending, $febCount_pending, $marCount_pending, $aprCount_pending, $mayCount_pending, $junCount_pending, $julCount_pending, $augCount_pending, $sepCount_pending, $octCount_pending, $novCount_pending, $decCount_pending]); ?>;

    // Data for total chart
    var totalLabels = ['TOTAL NO. OF APPLICANTS', 'VERIFIED APPLICANTS', 'PENDING APPLICANTS'];
    var total_Applicants = [<?php echo $total_applicants; ?>, null, null];
    var totalVerified = [null, <?php echo $total_applicantsVerified; ?>, null];
    var totalPending = [null, null, <?php echo $total_applicantsPending; ?>];

    // Destroy existing charts if they exist
    if (applicantsChart) {
        applicantsChart.destroy();
    }
    if (totalApplicantChart) { // Corrected from totalApplicantReport
        totalApplicantChart.destroy();
    }

    // Draw Applicants Chart
    var ctx = document.getElementById('applicantsChartReport').getContext('2d');
    applicantsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'No. of Applicants',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalApplicants
                },
                {
                    label: 'Verified Applicants',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: applicantsMonth_VerifiedCount
                },
                {
                    label: 'Pending Applicants',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: applicantsMonth_PendingCount
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });

    // Draw Total Report Chart
    var ctx2 = document.getElementById('totalApplicantReport').getContext('2d');
    totalApplicantChart = new Chart(ctx2, { // Corrected assignment
        type: 'bar',
        data: {
            labels: totalLabels,
            datasets: [
                {
                    label: 'Total No. of Applicants',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: total_Applicants
                },
                {
                    label: 'Verified Applicants',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: totalVerified
                },
                {
                    label: 'Pending Applicants',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: totalPending
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                },
                x: {
                    stacked: true, // Stack the bars for better alignment
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });
}


// complaints graph
function drawComplaintsCharts() {
    var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var totalComplaints = <?php echo json_encode([$jan_count, $feb_count, $mar_count, $apr_count, $may_count, $jun_count, $jul_count, $aug_count, $sep_count, $oct_count, $nov_count, $dec_count]); ?>;
    var complaintsMonth_ResolvedCount = <?php echo json_encode([$janCount_resolved, $febCount_resolved, $marCount_resolved, $aprCount_resolved, $mayCount_resolved, $junCount_resolved, $julCount_resolved, $augCount_resolved, $sepCount_resolved, $octCount_resolved, $novCount_resolved, $decCount_resolved]); ?>;
    var complaintsMonth_DismissedCount = <?php echo json_encode([$janCount_dismissed, $febCount_dismissed, $marCount_dismissed, $aprCount_dismissed, $mayCount_dismissed, $junCount_dismissed, $julCount_dismissed, $augCount_dismissed, $sepCount_dismissed, $octCount_dismissed, $novCount_dismissed, $decCount_dismissed]); ?>;

    // Data for total chart
    var totalLabels = ['TOTAL NO. OF COMPLAINTS', 'RESOLVED COMPLAINTS', 'DISMISSED COMPLAINTS'];
    var total_Complaints = [<?php echo $total_complaints; ?>, null, null];
    var totalResolved = [null, <?php echo $total_complaintsResolved; ?>, null];
    var totalDismissed = [null, null, <?php echo $total_complaintsDismissed; ?>];

    // Destroy existing charts if they exist
    if (complaintsChart) {
        complaintsChart.destroy();
    }
    if (totalComplaintsReport) { 
        totalComplaintsReport.destroy();
    }

    // Draw Applicants Chart
    var ctx = document.getElementById('complaintsChartReport').getContext('2d');
    complaintsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'No. of Complaints',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalComplaints
                },
                {
                    label: 'Resolved Complaints',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: complaintsMonth_ResolvedCount
                },
                {
                    label: 'Dismissed Complaints',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: complaintsMonth_DismissedCount
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });

    // Draw Total Report Chart
    var ctx2 = document.getElementById('totalComplaintsReport').getContext('2d');
    totalComplaintsReport = new Chart(ctx2, { // Corrected assignment
        type: 'bar',
        data: {
            labels: totalLabels,
            datasets: [
                {
                    label: 'Total No. of Complaints',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: total_Complaints
                },
                {
                    label: 'Resolved Complaints',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: totalResolved
                },
                {
                    label: 'Dismissed Complaints',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: totalDismissed
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                },
                x: {
                    stacked: true, // Stack the bars for better alignment
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });
}

// violations graph
function drawViolationsCharts() {
    var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var totalViolations = <?php echo json_encode([$Jan_count, $Feb_count, $Mar_count, $Apr_count, $May_count, $Jun_count, $Jul_count, $Aug_count, $Sep_count, $Oct_count, $Nov_count, $Dec_count]); ?>;
    var violationsMonth_SettledCount = <?php echo json_encode([$janCount_settled, $febCount_settled, $marCount_settled, $aprCount_settled, $mayCount_settled, $junCount_settled, $julCount_settled, $augCount_settled, $sepCount_settled, $octCount_settled, $novCount_settled, $decCount_settled]); ?>;
    var violationsMonth_UnSettledCount = <?php echo json_encode([$janCount_unsettled, $febCount_unsettled, $marCount_unsettled, $aprCount_unsettled, $mayCount_unsettled, $junCount_unsettled, $julCount_unsettled, $augCount_unsettled, $sepCount_unsettled, $octCount_unsettled, $novCount_unsettled, $decCount_unsettled]); ?>;

    // Data for total chart
    var totalLabels = ['TOTAL NO. OF VIOLATIONS', 'SETTLED VIOLATIONS', 'UNSETTLED VIOLATIONS'];
    var total_Violations = [<?php echo $total_violations; ?>, null, null];
    var totalSettled = [null, <?php echo $total_violationsSettled; ?>, null];
    var totalUnSettled = [null, null, <?php echo $total_violationsUnSettled; ?>];

    // Destroy existing charts if they exist
    if (violationsChart) {
        violationsChart.destroy();
    }
    if (totalViolationsReport) { 
        totalViolationsReport.destroy();
    }

    // Draw Violations Chart
    var ctx = document.getElementById('violationsChartReport').getContext('2d');
    violationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'No. of Violations',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalViolations
                },
                {
                    label: 'Settled Violations',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: violationsMonth_SettledCount
                },
                {
                    label: 'UnSettled Violations',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: violationsMonth_UnSettledCount
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });

    // Draw Total Report Chart
    var ctx2 = document.getElementById('totalViolationsReport').getContext('2d');
    totalViolationsReport = new Chart(ctx2, { 
        type: 'bar',
        data: {
            labels: totalLabels,
            datasets: [
                {
                    label: 'Total No. of Violations',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: total_Violations
                },
                {
                    label: 'Total Settled Violations',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: totalSettled
                },
                {
                    label: 'Total Settled Violations',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: totalUnSettled
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                },
                x: {
                    stacked: true, // Stack the bars for better alignment
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });
}



// redraw chart for printing
function drawTricycleFranchiseChartsInWindow(printWindow) {
    console.log(printWindow.document.getElementById('monthlyFranchiseReport')); // Check if element exists
    console.log(printWindow.document.getElementById('totalFranchiseReport')); // Check if element exists

    if (printWindow.document.getElementById('monthlyFranchiseReport') && printWindow.document.getElementById('totalFranchiseReport')) {
        // Define the variables again within this function
        var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October'];
        var totalFranchises = <?php echo json_encode([$jan_Count, $feb_Count, $march_Count, $apr_Count, $may_Count, $jun_Count, $jul_Count, $aug_Count, $sep_Count, $oct_Count]); ?>;
        var renewedFranchises = <?php echo json_encode([$jan_renewedCount, $feb_renewedCount, $march_renewedCount, $apr_renewedCount, $may_renewedCount, $jun_renewedCount, $jul_renewedCount, $aug_renewedCount, $sep_renewedCount, $oct_renewedCount]); ?>;
        var expiredFranchises = <?php echo json_encode([$jan_expiredCount, $feb_expiredCount, $march_expiredCount, $apr_expiredCount, $may_expiredCount, $jun_expiredCount, $jul_expiredCount, $aug_expiredCount, $sep_expiredCount, $oct_expiredCount]); ?>;

        // Data for total chart
        var totalLabels = ['TOTAL NO. OF FRANCHISE', 'RENEWED FRANCHISE', 'EXPIRED FRANCHISE'];
        var totalFranchiseData = [<?php echo $operatorsCount; ?>, null, null];
        var totalRenewedData = [null, <?php echo $operators_renewedCount; ?>, null];
        var totalExpiredData = [null, null, <?php echo $operators_expiredCount; ?>];

        // Draw Monthly Report Chart
        var ctx1 = printWindow.document.getElementById('monthlyFranchiseReport').getContext('2d');
        var monthlyChart = new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: ' No. of Franchise',
                        backgroundColor: '#2680C2',
                        borderColor: '#2680C2',
                        data: totalFranchises
                    },
                    {
                        label: 'Renewed Franchise',
                        backgroundColor: 'orange',
                        borderColor: 'orange',
                        data: renewedFranchises
                    },
                    {
                        label: 'Expired Franchise',
                        backgroundColor: 'gray',
                        borderColor: 'gray',
                        data: expiredFranchises
                    },
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            },
            plugins: [drawTotalsOnBars] // Register the plugin
        });

        // Draw Total Report Chart
        var ctx2 = printWindow.document.getElementById('totalFranchiseReport').getContext('2d');
        var totalChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: totalLabels,
                datasets: [
                    {
                        label: 'Total No. of Franchise',
                        backgroundColor: '#2680C2',
                        borderColor: '#2680C2',
                        data: totalFranchiseData
                    },
                    {
                        label: 'Total Renewed Franchise',
                        backgroundColor: 'orange',
                        borderColor: 'orange',
                        data: totalRenewedData
                    },
                    {
                        label: 'Total Expired Franchise',
                        backgroundColor: 'gray',
                        borderColor: 'gray',
                        data: totalExpiredData
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        stacked: true
                    }
                }
            },
            plugins: [drawTotalsOnBars] // Register the plugin
        });
    }
}

function drawApplicantsChartsInWindow(printWindow) {
    console.log(printWindow.document.getElementById('applicantsChart')); // Check if element exists
    console.log(printWindow.document.getElementById('totalApplicantReport')); // Check if element exists

    if (printWindow.document.getElementById('applicantsChart') && printWindow.document.getElementById('totalApplicantReport')) {
        var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        var totalApplicants = <?php echo json_encode([$janCount, $febCount, $marCount, $aprCount, $mayCount, $junCount, $julCount, $augCount, $sepCount, $octCount, $novCount, $decCount]); ?>;
        var applicantsMonth_VerifiedCount = <?php echo json_encode([$janCount_verified, $febCount_verified, $marCount_verified, $aprCount_verified, $mayCount_verified, $junCount_verified, $julCount_verified, $augCount_verified, $sepCount_verified, $octCount_verified, $novCount_verified, $decCount_verified]); ?>;
        var applicantsMonth_PendingCount = <?php echo json_encode([$janCount_pending, $febCount_pending, $marCount_pending, $aprCount_pending, $mayCount_pending, $junCount_pending, $julCount_pending, $augCount_pending, $sepCount_pending, $octCount_pending, $novCount_pending, $decCount_pending]); ?>;

        var totalLabels = ['TOTAL NO. OF APPLICANTS', 'VERIFIED APPLICANTS', 'PENDING APPLICANTS'];
        var total_Applicants = [<?php echo $total_applicants; ?>, null, null];
        var totalVerified= [null, <?php echo $total_applicantsVerified; ?>, null];
        var totalPending = [null, null, <?php echo $total_applicantsPending; ?>];

        var ctx = printWindow.document.getElementById('applicantsChart').getContext('2d');
        var applicantsChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: monthlyLabels,
                datasets: [
                    {
                        label: 'Total No. of Applicants',
                        backgroundColor: '#2680C2',
                        borderColor: '#2680C2',
                        data: totalApplicants
                    },
                    {
                        label: 'Verified Applicants',
                        backgroundColor: 'orange',
                        borderColor: 'orange',
                        data: applicantsMonth_VerifiedCount
                    },
                    {
                        label: 'Pending Applicants',
                        backgroundColor: 'gray',
                        borderColor: 'gray',
                        data: applicantsMonth_PendingCount
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            },
            plugins: [drawTotalsOnBars] // Register the plugin
        });

        var ctx2 = printWindow.document.getElementById('totalApplicantReport').getContext('2d');
        var totalApplicantsChart = new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: totalLabels,
                datasets: [
                    {
                        label: 'Total No. of Applicants',
                        backgroundColor: '#2680C2',
                        borderColor: '#2680C2',
                        data: total_Applicants
                    },
                    {
                        label: 'Verified Applicants',
                        backgroundColor: 'orange',
                        borderColor: 'orange',
                        data: totalVerified
                    },
                    {
                        label: 'Pending Applicants',
                        backgroundColor: 'gray',
                        borderColor: 'gray',
                        data: totalPending
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    },
                    x: {
                        stacked: true
                    }
                }
            },
            plugins: [drawTotalsOnBars] // Register the plugin
        });
    }
}


function drawComplaintsChartsInWindow(printWindow) {
    console.log(printWindow.document.getElementById('complaintsChart')); // Check if element exists
    console.log(printWindow.document.getElementById('totalComplaintsReport')); // Check if element exists

    if (printWindow.document.getElementById('complaintsChart') && printWindow.document.getElementById('totalComplaintsReport')) {
    var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var totalComplaints = <?php echo json_encode([$jan_count, $feb_count, $mar_count, $apr_count, $may_count, $jun_count, $jul_count, $aug_count, $sep_count, $oct_count, $nov_count, $dec_count]); ?>;
    var complaintsMonth_ResolvedCount = <?php echo json_encode([$janCount_resolved, $febCount_resolved, $marCount_resolved, $aprCount_resolved, $mayCount_resolved, $junCount_resolved, $julCount_resolved, $augCount_resolved, $sepCount_resolved, $octCount_resolved, $novCount_resolved, $decCount_resolved]); ?>;
    var complaintsMonth_DismissedCount = <?php echo json_encode([$janCount_dismissed, $febCount_dismissed, $marCount_dismissed, $aprCount_dismissed, $mayCount_dismissed, $junCount_dismissed, $julCount_dismissed, $augCount_dismissed, $sepCount_dismissed, $octCount_dismissed, $novCount_dismissed, $decCount_dismissed]); ?>;

    // Data for total chart
    var totalLabels = ['TOTAL NO. OF COMPLAINTS', 'RESOLVED COMPLAINTS', 'DISMISSED COMPLAINTS'];
    var total_Complaints = [<?php echo $total_complaints; ?>, null, null];
    var totalResolved = [null, <?php echo $total_complaintsResolved; ?>, null];
    var totalDismissed = [null, null, <?php echo $total_complaintsDismissed; ?>];

    // Draw Complaints Chart
    var ctx = printWindow.document.getElementById('complaintsChart').getContext('2d');
    complaintsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'No. of Complaints',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalComplaints
                },
                {
                    label: 'Resolved Complaints',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: complaintsMonth_ResolvedCount
                },
                {
                    label: 'Dismissed Complaints',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: complaintsMonth_DismissedCount
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });

    // Draw Total Report Chart
    var ctx2 = printWindow.document.getElementById('totalComplaintsReport').getContext('2d');
    totalComplaintsReport = new Chart(ctx2, { 
        type: 'bar',
        data: {
            labels: totalLabels,
            datasets: [
                {
                    label: 'Total No. of Complaints',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: total_Complaints
                },
                {
                    label: 'Resolved Complaints',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: totalResolved
                },
                {
                    label: 'Dismissed Complaints',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: totalDismissed
                }
            ]
        },
        options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Adjust this depending on the range of data
                        }
                    },
                    x: {
                        stacked: true, // Stack the bars for better alignment
                    }
                }
            },
            plugins: [drawTotalsOnBars] // Register the plugin
        });
    }
}

function drawViolationsChartsInWindow(printWindow) {
    var monthlyLabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var totalViolations = <?php echo json_encode([$Jan_count, $Feb_count, $Mar_count, $Apr_count, $May_count, $Jun_count, $Jul_count, $Aug_count, $Sep_count, $Oct_count, $Nov_count, $Dec_count]); ?>;
    var violationsMonth_SettledCount = <?php echo json_encode([$janCount_settled, $febCount_settled, $marCount_settled, $aprCount_settled, $mayCount_settled, $junCount_settled, $julCount_settled, $augCount_settled, $sepCount_settled, $octCount_settled, $novCount_settled, $decCount_settled]); ?>;
    var violationsMonth_UnSettledCount = <?php echo json_encode([$janCount_unsettled, $febCount_unsettled, $marCount_unsettled, $aprCount_unsettled, $mayCount_unsettled, $junCount_unsettled, $julCount_unsettled, $augCount_unsettled, $sepCount_unsettled, $octCount_unsettled, $novCount_unsettled, $decCount_unsettled]); ?>;

    // Data for total chart
    var totalLabels = ['TOTAL NO. OF VIOLATIONS', 'SETTLED VIOLATIONS', 'UNSETTLED VIOLATIONS'];
    var total_Violations = [<?php echo $total_violations; ?>, null, null];
    var totalSettled = [null, <?php echo $total_violationsSettled; ?>, null];
    var totalUnSettled = [null, null, <?php echo $total_violationsUnSettled; ?>];

    // Draw Violations Chart
    var ctx = printWindow.document.getElementById('violationsChart').getContext('2d');
    violationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: monthlyLabels,
            datasets: [
                {
                    label: 'No. of Violations',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: totalViolations
                },
                {
                    label: 'Settled Violations',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: violationsMonth_SettledCount
                },
                {
                    label: 'UnSettled Violations',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: violationsMonth_UnSettledCount
                },
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });

    // Draw Total Report Chart
    var ctx2 = printWindow.document.getElementById('totalViolationsReport').getContext('2d');
    totalViolationsReport = new Chart(ctx2, { 
        type: 'bar',
        data: {
            labels: totalLabels,
            datasets: [
                {
                    label: 'Total No. of Violations',
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    data: total_Violations
                },
                {
                    label: 'Total Settled Violations',
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    data: totalSettled
                },
                {
                    label: 'Total Settled Violations',
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    data: totalUnSettled
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1 // Adjust this depending on the range of data
                    }
                },
                x: {
                    stacked: true, // Stack the bars for better alignment
                }
            }
        },
        plugins: [drawTotalsOnBars] // Register the plugin
    });
}

</script>


<?php 
      include "../../include/scripts.php"; 
      include "../include/scriptsAdmin.php";
      include "../include/footerAdmin.php";
?>


<!-- Bootstrap  dito yan sa baba bawal mabago-->
<script 
src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"  integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>
