<?php 
    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
?>

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

        <div class="d-flex align-items-center gap-3 flex-wrap">
    <!-- Select Report Type -->
    <div class="report-type">
        <label for="reportType" class="form-label">Select Report</label>
        <select id="reportType" class="form-select custom-select" aria-label="Default select example">
            <option selected>Select Report</option>
            <option value="franchise">Tricycle Franchise</option>
            <option value="applicants">Franchise Applicants</option>
            <option value="complaints">Complaints</option>
            <option value="violations">Violations</option>
            <option value="application_fees">Franchise Application Fees</option>
        </select>
    </div>
    
    <!-- Select Report Duration -->
    <div class="report-duration" id="reportDurationSection">
        <label for="reportDuration" class="form-label">Report Duration</label>
        <select id="reportDuration" class="form-select custom-select" aria-label="Default select example">
            <option selected>Select Duration</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
    
    <!-- Start Date -->
    <div>
        <label for="startDate" class="form-label">Start Date</label>
        <input type="date" id="startDate" class="form-control">
    </div>

    <!-- End Date -->
    <div>
        <label for="endDate" class="form-label">End Date</label>
        <input type="date" id="endDate" class="form-control">
    </div>

    <!-- Action Buttons -->
    <div class="d-flex gap-2" style="margin-top:35px;">
        <button id="generateReport" class="btn btn-primary">Generate</button>
        <button id="printReport" class="btn btn-secondary">Print</button>
    </div>
</div>

<script>
    // Get the report type and duration section
    const reportType = document.getElementById('reportType');
    const reportDurationSection = document.getElementById('reportDurationSection');

    // Add an event listener to show or hide the duration based on the report type selection
    reportType.addEventListener('change', function() {
        if (reportType.value === 'franchise') {
            reportDurationSection.style.display = 'none';
        } else {
            reportDurationSection.style.display = 'block';
        }
    });
</script>


<!-- Franchise Report -->
<div id="franchiseReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px; margin-bottom:20px;">
                  <button onclick="switchView('table', 'franchise')" class="tab-btn no print">Table View</button>
                  <button onclick="switchView('chart', 'franchise')" class="tab-btn active-tab no print">Chart View</button>
            </div>
    
            <h3 id="franchiseReportTitle" style="text-align: center;"><b>Tricycle Franchise Report</b></h3>
    
            <!-- Display Total Applicants -->
            <div id="totalFranchise" class="text-center" style="font-size: 18px; margin-bottom: 20px; display:none;"></div>
    
            <!-- Table View -->
            <div id="tableViewFranchise" class="table-responsive" style="display: none;">
                <table id="reportTableFranchise" class="table table-striped text-center">
                    <thead>
                        <tr id="tableHeaderFranchise"></tr>
                    </thead>
                    <tbody id="tableBodyFranchise"></tbody>
                </table>
            </div>
    
            <!-- Chart View -->
            <div id="chartViewFranchise" class="chart-container mt-4" style="display: block;">
                <canvas id="reportChartFranchise" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                <!--<canvas id="paymentCollectedChartApplicants" style="width: 100%; height: auto;" width="300" height="150"></canvas>-->
            </div>
        </div>
    </div>
</div>

<!-- Applicants Report -->
<div id="applicantsReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px; margin-bottom:20px;">
                  <button onclick="switchView('table', 'applicants')" class="tab-btn no-print">Table View</button>
                  <button onclick="switchView('chart', 'applicants')" class="tab-btn active-tab no-print">Chart View</button>
            </div>
    
            <h3 id="applicantsReportTitle" style="text-align: center;"><b>Applicants Report</b></h3>
    
            <!-- Display Total Applicants -->
            <div id="totalApplicants" class="text-center" style="font-size: 18px; margin-bottom: 20px; display:none;"></div>
    
            <!-- Table View -->
            <div id="tableViewApplicants" class="table-responsive" style="display: none;">
                <table id="reportTableApplicants" class="table table-striped text-center">
                    <thead>
                        <tr id="tableHeaderApplicants"></tr>
                    </thead>
                    <tbody id="tableBodyApplicants"></tbody>
                </table>
            </div>
    
            <!-- Chart View -->
            <div id="chartViewApplicants" class="chart-container mt-4" style="display: block;">
                <canvas id="reportChartApplicants" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                <!--<canvas id="paymentCollectedChartApplicants" style="width: 100%; height: auto;" width="300" height="150"></canvas>-->
            </div>
        </div>
    </div>
</div>


<!-- Violations Report -->
<div id="violationsReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px; margin-bottom:20px;">
                  <button onclick="switchView('table', 'violations')" class="tab-btn">Table View</button>
                <button onclick="switchView('chart', 'violations')" class="tab-btn active-tab">Chart View</button>
            </div>
    
            <h3 id="violationsReportTitle" style="text-align: center;"><b>Violations Report</b></h3>
    
            <!-- Display Total Violations -->
            <div id="totalViolations" class="text-center" style="font-size: 18px; margin-bottom: 20px; display:none;"></div>
    
            <!-- Table View -->
            <div id="tableViewViolations" class="table-responsive" style="display: none;">
                <table id="reportTableViolations" class="table table-striped text-center">
                    <thead>
                        <tr id="tableHeaderViolations"></tr>
                    </thead>
                    <tbody id="tableBodyViolations"></tbody>
                </table>
            </div>
    
            <!-- Chart View -->
            <div id="chartViewViolations" class="chart-container mt-4" style="display: block;">
                <canvas id="reportChartViolations" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                <!--<canvas id="penaltyCollectedChartViolations" style="width: 100%; height: auto;" width="300" height="150"></canvas>-->
            </div>
        </div>
    </div>
</div>


<!-- Complaints Report -->
<div id="complaintsReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px; margin-bottom:20px;">
                  <button onclick="switchView('table', 'complaints')" class="tab-btn">Table View</button>
                    <button onclick="switchView('chart', 'complaints')" class="tab-btn active-tab">Chart View</button>
            </div>
    
            <h3 id="complaintsReportTitle" style="text-align: center;"><b>Complaints Report</b></h3>
    
            <!-- Display Total Violations -->
            <div id="totalViolations" class="text-center" style="font-size: 18px; margin-bottom: 20px; display:none;"></div>
    
            <!-- Table View -->
            <div id="tableViewComplaints" class="table-responsive" style="display: none;">
                <table id="reportTableComplaints" class="table table-striped text-center">
                    <thead>
                        <tr id="tableHeaderComplaints"></tr>
                    </thead>
                    <tbody id="tableBodyComplaints"></tbody>
                </table>
            </div>
    
            <!-- Chart View -->
            <div id="chartViewComplaints" class="chart-container mt-4" style="display: block;">
                <canvas id="reportChartComplaints" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                <!--<canvas id="penaltyCollectedChartViolations" style="width: 100%; height: auto;" width="300" height="150"></canvas>-->
            </div>
        </div>
    </div>
</div>  


<!-- Franchise Application Fees Report -->
<div id="application_feesReportContainer" class="col-md-12" style="max-width: 1000px; display: none; margin: 0 auto; margin-top:10px;">
    <div class="card" style="width: 100%;">
        <div class="card-body" style="max-width: 950px; margin: 0 auto;">
            <!-- Tabs for switching between Table and Chart -->
            <div class="tab-container" style="text-align: left; margin-top: 10px; margin-bottom:20px;">
                <button  onclick="switchView('table', 'applicationFees')" class="tab-btn ">Table View</button>
                <button  onclick="switchView('chart', 'applicationFees')" class="tab-btn active-tab ">Chart View</button>

            </div>
    
            <h3 id="application_feesReportTitle" style="text-align: center;"><b>Franchise Application Fees Report</b></h3>
    
            <!-- Display Total Applicants -->
            <div id="totalApplicationFees" class="text-center" style="font-size: 18px; margin-bottom: 20px; display:none;"></div>
    
            <!-- Table View -->
            <div id="tableViewApplicationFees" class="table-responsive" style="display: none;">
                <table id="reportTableApplicationFees" class="table table-striped text-center">
                    <thead>
                        <tr id="tableHeaderApplicationFees"></tr>
                    </thead>
                    <tbody id="tableBodyApplicationFees"></tbody>
                </table>
            </div>
    
            <!-- Chart View -->
            <div id="chartViewApplicationFees" class="chart-container mt-4" style="display: block;">
                <canvas id="reportChartApplicationFees" style="width: 100%; height: auto;" width="300" height="150"></canvas>
                
            </div>
        </div>
    </div>
</div>


<script>
document.getElementById('generateReport').addEventListener('click', function () {
    const reportType = document.getElementById('reportType').value;
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    const reportDuration = document.getElementById('reportDuration').value;

   if (!reportType || reportType === 'Select Report' || !startDate || !endDate || !reportDuration) {
        Swal.fire({
            icon: 'warning',
            title: 'Missing Information',
            text: 'Please select a report type and specify the date range.',
            confirmButtonText: 'OK'
        });
        return;
    }

  let url;
    if (reportType === 'applicants') {
        url = 'applicants_report.php';
    } else if (reportType === 'violations') {
        url = 'violations_report.php';
    } else if (reportType === 'complaints') {
        url = 'complaints_report.php';
    } else if (reportType === 'franchise') {
        url = 'franchise_report.php';
    } else if (reportType === 'application_fees') {
        url = 'application_fees.php';
    } else {
        url = 'default_report.php'; // Fallback
    }

        
    fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ reportType, startDate, endDate, reportDuration }),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Display the relevant container
            document.getElementById('applicantsReportContainer').style.display = reportType === 'applicants' ? 'block' : 'none';
            document.getElementById('applicantsReportTitle').innerText = `Applicants Report (${startDate} to ${endDate})`.toUpperCase();
            document.getElementById('violationsReportContainer').style.display = reportType === 'violations' ? 'block' : 'none';
            document.getElementById('violationsReportTitle').innerText = `Violations Report (${startDate} to ${endDate})`.toUpperCase();
            document.getElementById('complaintsReportContainer').style.display = reportType === 'complaints' ? 'block' : 'none';
            document.getElementById('complaintsReportTitle').innerText = `Complaints Report (${startDate} to ${endDate})`.toUpperCase();
            document.getElementById('franchiseReportContainer').style.display = reportType === 'franchise' ? 'block' : 'none';
            document.getElementById('franchiseReportTitle').innerText = `Tricycle Franchise Report (${startDate} to ${endDate})`.toUpperCase();
            document.getElementById('application_feesReportContainer').style.display = reportType === 'application_fees' ? 'block' : 'none';
            document.getElementById('application_feesReportTitle').innerText = `Franchise Application Fees Collected (${startDate} to ${endDate})`.toUpperCase();

            if (reportType === 'applicants') {
                populateApplicantsTable(data.tableData);
                renderApplicantsChart(data.chartData);
            } else if (reportType === 'violations') {
                populateViolationsTable(data.tableData);
                renderViolationsChart(data.chartData);
            } else if (reportType === 'complaints') {
                populateComplaintsTable(data.tableData);
                renderComplaintsChart(data.chartData);
            } else if (reportType === 'franchise') {
                populateFranchiseTable(data.tableData);
                renderFranchiseChart(data.tableData);
            }else if (reportType === 'application_fees') {
                populateApplicationFeesTable(data.tableData);
                renderApplicationFeesChart(data.chartData);
            } // Log the action in the database with the updated action message
            const user_id = <?php echo $_SESSION['user_id']; ?>; // Assuming PHP session variable
            const account_type = <?php echo json_encode($_SESSION['account_type']); ?>;
            const username = <?php echo json_encode($_SESSION['username']); ?>;
            const action = `Report generated: ${reportType}`; // Updated action format

            // Send log data to PHP for logging
            fetch('log_report_generation.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    user_id,
                    account_type,
                    username,
                    action,
                    startDate,
                    endDate,
                    reportType,
                })
            })
            .then(logResponse => logResponse.json())
            .then(logData => {
                if (logData.success) {
                    console.log('Report generation logged successfully');
                } else {
                    console.log('Failed to log report generation');
                }
            })
            .catch(error => console.error('Logging Error:', error));

        } else {
            Swal.fire({
                icon: 'info',
                title: 'No Data Found',
                text: 'No data found for the selected date range.',
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => console.error('Error:', error));
});


//franchise report table 
function populateFranchiseTable(tableData) {
    const tableHeader = document.getElementById('tableHeaderFranchise');
    const tableBody = document.getElementById('tableBodyFranchise');
    tableHeader.innerHTML = ''; // Reset header
    tableBody.innerHTML = ''; // Reset body

    if (!tableData || tableData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="4">No data available</td></tr>'; // Adjust colspan to match number of columns
        return;
    }

    // Define headers for the table
    const headers = [ 'Tables', 'Tricycle Operators', 'Expired', 'Renewed', 'Dropped', 'Renewal Fee Collected', 'Penalty Collected'];
    headers.forEach(header => {
        const th = document.createElement('th');
        th.innerText = header;
        tableHeader.appendChild(th);
    });

    // Initialize totals
    let totalOperators = 0;
    let totalExpired = 0;
    let totalRenewed = 0;
    let totalDropped = 0;
    let totalRenewal_Payment=0
    let totalPenalty = 0;
    

    // Populate rows and accumulate totals
    tableData.forEach(row => {
        const tr = document.createElement('tr');

        // Add month column
        const monthCell = document.createElement('td');
        monthCell.innerText = row.table.replace('_Operators', '').toUpperCase(); // Format table name
        tr.appendChild(monthCell);

        // Add total operators column
        const totalCell = document.createElement('td');
        totalCell.innerText = row.total;
        tr.appendChild(totalCell);
        totalOperators += parseInt(row.total, 10);

        // Add expired column
        const expiredCell = document.createElement('td');
        expiredCell.innerText = row.expired;
        tr.appendChild(expiredCell);
        totalExpired += parseInt(row.expired, 10);

        // Add renewed column
        const renewedCell = document.createElement('td');
        renewedCell.innerText = row.renewed;
        tr.appendChild(renewedCell);
        totalRenewed += parseInt(row.renewed, 10);
        
        // Add dropped column
        const droppedCell = document.createElement('td');
        droppedCell.innerText = row.dropped;
        tr.appendChild(droppedCell);
        totalDropped += parseInt(row.dropped, 10);
        
         // Add total renewal_payment collected column
        const renewal_paymentCell = document.createElement('td');
        renewal_paymentCell.innerText = row.renewal_payment;
        tr.appendChild(renewal_paymentCell);
        totalRenewal_Payment += parseInt(row.renewal_payment, 10);
        
        // Add total penalty collected column
        const penaltyCell = document.createElement('td');
        penaltyCell.innerText = row.penalty;
        tr.appendChild(penaltyCell);
        totalPenalty += parseInt(row.penalty, 10);

        tableBody.appendChild(tr);
    });

    // Add totals row
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = 'bold';

    // Add "Total" label
    const totalLabelCell = document.createElement('td');
    totalLabelCell.innerText = 'Total';
    totalRow.appendChild(totalLabelCell);

    // Add totals for each column
    const totals = [totalOperators, totalExpired, totalRenewed, totalDropped, totalRenewal_Payment, totalPenalty ];
    totals.forEach(total => {
        const td = document.createElement('td');
        td.innerText = total;
        totalRow.appendChild(td);
    });

    tableBody.appendChild(totalRow);
    
    renderFranchiseChart(tableData);
}


// applicants table 
function populateApplicantsTable(tableData) {
    const tableHeader = document.getElementById('tableHeaderApplicants');
    const tableBody = document.getElementById('tableBodyApplicants');
    tableHeader.innerHTML = ''; // Reset header
    tableBody.innerHTML = ''; // Reset body

    if (!tableData || tableData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="100%">No data available</td></tr>';
        return;
    }

   // Create headers dynamically
    const headers = Object.keys(tableData[0]);
    headers.forEach(header => {
        const th = document.createElement('th');
        th.innerText = header === 'total' ? 'No. of Applicants' :
                       header === 'label' ? 'Report Duration' :
                       header.charAt(0).toUpperCase() + header.slice(1);
        tableHeader.appendChild(th);
    });


    // Calculate totals
    let totals = {};
    headers.forEach(header => totals[header] = 0); // Initialize totals

    // Populate rows and accumulate totals
    tableData.forEach(row => {
        const tr = document.createElement('tr');
        headers.forEach(header => {
            const td = document.createElement('td');
            td.innerText = row[header];
            tr.appendChild(td);

            // Accumulate numeric totals
            if (!isNaN(parseFloat(row[header]))) {
                totals[header] += parseFloat(row[header]);
            }
        });
        tableBody.appendChild(tr);
    });

    // Add "Total" row
    const totalRow = document.createElement('tr');
    totalRow.style.fontWeight = 'bold';
    headers.forEach((header, index) => {
        const td = document.createElement('td');
        if (index === 0) {
            td.innerText = 'Total'; // Label for total row
        } else if (!isNaN(totals[header])) {
            td.innerText = totals[header]; // Display total
        } else {
            td.innerText = ''; // Leave empty for non-numeric columns
        }
        totalRow.appendChild(td);
    });
    tableBody.appendChild(totalRow);
}


// Populate table for Violations report
function populateViolationsTable(tableData) {
    const tableHeader = document.getElementById('tableHeaderViolations');
    const tableBody = document.getElementById('tableBodyViolations');
    tableHeader.innerHTML = ''; // Reset header

    // Create headers
    const headers = Object.keys(tableData[0]);
    headers.forEach(header => {
        const th = document.createElement('th');
        if (header.toLowerCase() === 'total') {
            th.innerText = 'No. of Violations';
        } else if (header.toLowerCase() === 'penalty_collected') {
            th.innerText = 'Penalty Fees Collected';
        }else if (header.toLowerCase() === 'label') {
            th.innerText = 'Report Duration';
        } else {
            th.innerText = header.charAt(0).toUpperCase() + header.slice(1);
        }
        tableHeader.appendChild(th);
    });

    tableBody.innerHTML = ''; // Reset body

    // Create rows
    tableData.forEach(row => {
        const tr = document.createElement('tr');
        headers.forEach(header => {
            const td = document.createElement('td');
            td.innerText = row[header];
            tr.appendChild(td);
        });
        tableBody.appendChild(tr);
    });
// Add totals row
    const totalsRow = document.createElement('tr');
    totalsRow.style.fontWeight = 'bold'; // Make the total row bold
    
    headers.forEach(header => {
        const td = document.createElement('td');
        if (header.toLowerCase() === 'label') {
            td.innerText = 'Total';
        } else if (!isNaN(tableData[0][header])) {
            // Calculate total for numeric columns
            const total = tableData.reduce((sum, row) => sum + (parseInt(row[header]) || 0), 0);
            td.innerText = total;
        } else {
            td.innerText = ''; // Leave empty for non-numeric columns
        }
        totalsRow.appendChild(td);
    });

    // Append totals row to table body
    tableBody.appendChild(totalsRow);
}


// Populate table for Complaints report
function populateComplaintsTable(tableData) {
    const tableHeader = document.getElementById('tableHeaderComplaints');
    const tableBody = document.getElementById('tableBodyComplaints');
    tableHeader.innerHTML = ''; // Reset header

    // Create headers
    const headers = Object.keys(tableData[0]);
    headers.forEach(header => {
        const th = document.createElement('th');
        if (header.toLowerCase() === 'total') {
            th.innerText = 'No. of Complaints';
        } else if (header.toLowerCase() === 'for_validation') {
            th.innerText = 'For Validation';
        } else if (header.toLowerCase() === 'label') {
            th.innerText = 'Report Duration';
        }else {
            th.innerText = header.charAt(0).toUpperCase() + header.slice(1);
        }
        tableHeader.appendChild(th);
    });

    tableBody.innerHTML = ''; // Reset body

    // Create rows
    tableData.forEach(row => {
        const tr = document.createElement('tr');
        headers.forEach(header => {
            const td = document.createElement('td');
            td.innerText = row[header];
            tr.appendChild(td);
        });
        tableBody.appendChild(tr);
    });

    // Add totals row
    const totalsRow = document.createElement('tr');
    totalsRow.style.fontWeight = 'bold'; 
    headers.forEach(header => {
        const td = document.createElement('td');
        if (header.toLowerCase() === 'label') {
            td.innerText = 'Total';
        } else if (!isNaN(tableData[0][header])) {
            // Calculate total for numeric columns
            const total = tableData.reduce((sum, row) => sum + (parseInt(row[header]) || 0), 0);
            td.innerText = total;
        } else {
            td.innerText = ''; // Leave empty for non-numeric columns
        }
        totalsRow.appendChild(td);
    });

    // Append totals row to table body
    tableBody.appendChild(totalsRow);
}


function populateApplicationFeesTable(tableData) {
    const tableHeader = document.getElementById('tableHeaderApplicationFees');
    const tableBody = document.getElementById('tableBodyApplicationFees');
    tableHeader.innerHTML = ''; // Reset header
    tableBody.innerHTML = ''; // Reset body

    if (!tableData || tableData.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="100%">No data available</td></tr>';
        return;
    }

    // Define the headers for the table based on the backend data structure
    const headers = [
        { key: 'label', text: 'Period' },
        { key: 'totalTransactions', text: 'Total Transactions' },
        { key: 'totalAmount', text: 'Amount Collected' },
    ];

    // Create headers dynamically
    headers.forEach(header => {
        const th = document.createElement('th');
        th.innerText = header.text;
        tableHeader.appendChild(th);
    });

    let totalTransactions = 0; // Variable to accumulate total transactions
    let totalAmount = 0; // Variable to accumulate total amount

    // Populate rows and accumulate totals
    tableData.forEach(row => {
        const tr = document.createElement('tr');
        headers.forEach(header => {
            const td = document.createElement('td');
            const value = row[header.key] !== undefined ? row[header.key] : '-'; // Show '-' for undefined values
            td.innerText = header.key === 'totalAmount' && value !== '-'
                ? parseFloat(value).toFixed() // Format totalAmount to 2 decimal places
                : value;
            tr.appendChild(td);
        });
        tableBody.appendChild(tr);

        // Accumulate totals
        if (row['totalTransactions'] !== undefined) {
            totalTransactions += parseInt(row['totalTransactions'], 10);
        }
        if (row['totalAmount'] !== undefined) {
            totalAmount += parseFloat(row['totalAmount']);
        }
    });

    // Add total row at the end of the table
    const totalRow = document.createElement('tr');
    totalRow.classList.add('total-row'); // Optional: Add a class for styling the total row

    // Create total cells
    const totalLabelCell = document.createElement('td');
    totalLabelCell.innerText = 'Total';
    totalLabelCell.style.fontWeight = 'bold';

    const totalTransactionsCell = document.createElement('td');
    totalTransactionsCell.innerText = totalTransactions;
    totalTransactionsCell.style.fontWeight = 'bold';

    const totalAmountCell = document.createElement('td');
    totalAmountCell.innerText = totalAmount.toFixed(); // Format total amount to 2 decimal places
    totalAmountCell.style.fontWeight = 'bold';

    // Append total cells to the total row
    totalRow.appendChild(totalLabelCell);
    totalRow.appendChild(totalTransactionsCell);
    totalRow.appendChild(totalAmountCell);
    tableBody.appendChild(totalRow);
}


// Global variables to store Chart instances
let applicantsChart = null;
let violationsChart = null;
let complaintsChart = null;
let franchiseChart = null;
let application_feesChart = null;


// Render chart for franchise report
// Function to render the chart
function renderFranchiseChart(tableData) {
    const ctx = document.getElementById('reportChartFranchise').getContext('2d');

    const labels = tableData.map(row => row.table.replace('_operators', '').toUpperCase()); // Month names
    const totalOperatorsData = tableData.map(row => row.total);
    const expiredData = tableData.map(row => row.expired);
    const renewedData = tableData.map(row => row.renewed);

    // If a chart exists, destroy it before creating a new one
    if (window.franchiseChart) {
        window.franchiseChart.destroy();
    }

    // Create the chart
    window.franchiseChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Total Operators',
                    data: totalOperatorsData,
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    borderWidth: 1
                },
                {
                    label: 'Expired',
                    data: expiredData,
                    backgroundColor: '#FF5733',
                    borderColor: '#FF5733',
                    borderWidth: 1
                },
                {
                    label: 'Renewed',
                    data: renewedData,
                    backgroundColor: '#28A745',
                    borderColor: '#28A745',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    beginAtZero: true
                },
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// Render chart for Applicants report
function renderApplicantsChart(chartData) {

    const ctx = document.getElementById('reportChartApplicants').getContext('2d');

    if (typeof applicantsChart !== 'undefined' && applicantsChart) {
        applicantsChart.destroy();
    }

    applicantsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [
                {
                    label: 'Total Applicants',
                    data: chartData.total,
                    backgroundColor: '#2680C2',
                    borderColor: '#2680C2',
                    borderWidth: 1,
                },
                {
                    label: 'Verified Applicants',
                    data: chartData.verified,
                    backgroundColor: 'gray',
                    borderColor: 'gray',
                    borderWidth: 1,
                },
                {
                    label: 'Denied Applicants',
                    data: chartData.denied,
                    backgroundColor: 'orange',
                    borderColor: 'orange',
                    borderWidth: 1,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: false, text: 'Applicants Report' }
            },
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });
}



// Render chart for Violations report
function renderViolationsChart(chartData) {
    const ctx = document.getElementById('reportChartViolations').getContext('2d');
    if (violationsChart) {
        violationsChart.destroy(); // Destroy the existing chart instance
    }
    violationsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Violations',
                data: chartData.total,
                backgroundColor: '#2680C2',
                borderColor: '#2680C2',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });
}

// Render chart for Complaints report
function renderComplaintsChart(chartData) {
    const ctx = document.getElementById('reportChartComplaints').getContext('2d');
    if (complaintsChart) {
        complaintsChart.destroy(); // Destroy the existing chart instance
    }
    complaintsChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels,
            datasets: [{
                label: 'Complaints',
                data: chartData.total,
                backgroundColor: '#2680C2',
                borderColor: '#2680C2',
                borderWidth: 1,
            }]
        },
        options: {
            scales: {
                x: { beginAtZero: true },
                y: { beginAtZero: true }
            }
        }
    });
}

// Render chart for Franchise Fee report
function renderApplicationFeesChart(chartData) {
    const ctx = document.getElementById('reportChartApplicationFees').getContext('2d');

    // Destroy existing chart instance if it exists
    if (typeof application_feesChart !== 'undefined' && application_feesChart) {
        application_feesChart.destroy();
    }

    // Validate chart data
    if (!chartData || !chartData.labels || !chartData.totalAmount || chartData.labels.length !== chartData.totalAmount.length) {
        console.error("Invalid chart data:", chartData);
        return;
    }

    // Create a new chart
    application_feesChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartData.labels, // X-axis labels
            datasets: [
                {
                    label: 'Amount Collected',
                    data: chartData.totalAmount, // Y-axis data
                    backgroundColor: '#2680C2', // Bar color
                    borderColor: '#2680C2', // Border color
                    borderWidth: 1, // Border width
                },
                
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
               
            },
            scales: {
                x: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Date',
                    },
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount Collected',
                    },
                },
            },
        },
    });
}


// Utility function to capitalize the first letter of report type
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

  
// Set table view as default
document.addEventListener('DOMContentLoaded', function () {
    switchView('table', 'applicants'); 
    switchView('table', 'violations'); 
    switchView('table', 'complaints');
    switchView('table', 'franchise');
    switchView('table', 'applicationFees');
});

function switchView(view, reportType) {
    let tableView = document.getElementById(`tableView${capitalizeFirstLetter(reportType)}`);
    let chartView = document.getElementById(`chartView${capitalizeFirstLetter(reportType)}`);

    if (!tableView || !chartView) {
        console.error(`Error: Could not find the elements for ${reportType}`);
        return; // Prevent further execution if elements are not found
    }

    // Hide all views first
    tableView.style.display = 'none';
    chartView.style.display = 'none';

    // Show the selected view
    if (view === 'table') {
        tableView.style.display = 'block';
    } else if (view === 'chart') {
        chartView.style.display = 'block';
    }

    // Toggle the active tab styles
    document.querySelectorAll(`.tab-btn`).forEach(tab => {
        tab.classList.remove('active-tab');
    });
    const activeTab = document.querySelector(`.tab-btn.${view}`);
    if (activeTab) {
        activeTab.classList.add('active-tab');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('printReport').addEventListener('click', printReport);
});

// Function to render the chart as an image
function renderChartAsImage(chartId) {
    const chartCanvas = document.getElementById(chartId);
    const image = chartCanvas.toDataURL('image/png');
   //console.log(image); // Log image data to check if it's being generated
    return image;
}
// Function to print the report
function printReport() {
    const reportType = document.getElementById('reportType').value;

    const reportContainers = {
        franchise: 'franchiseReportContainer',
        applicants: 'applicantsReportContainer',
        violations: 'violationsReportContainer',
        complaints: 'complaintsReportContainer',
        application_fees: 'application_feesReportContainer' // Corrected name here
    };

    const reportContainerId = reportContainers[reportType];
    const reportContainer = document.getElementById(reportContainerId);

    if (!reportContainer || reportContainer.style.display === 'none') {
        alert('No report to print. Please generate a report first.');
        return;
    }

    // Hide all buttons on the page
    const allButtons = document.querySelectorAll('.tab-btn');
    allButtons.forEach(button => {
        button.style.display = 'none';
    });

    // Clone the report container for printing
    const printContent = reportContainer.cloneNode(true);

    // Render the chart as an image and replace the canvas element with the image
    const chartIds = {
        franchise: 'reportChartFranchise',
        applicants: 'reportChartApplicants',
        violations: 'reportChartViolations',
        complaints: 'reportChartComplaints',
        application_fees: 'reportChartApplicationFees'
    };

    const chartId = chartIds[reportType];
    const chartImage = renderChartAsImage(chartId);

    const chartImageTag = `<img src="${chartImage}" alt="Chart" style="width: 100%; height: auto;">`;

    // Replace the chart container with the image in the cloned content
    const chartContainer = printContent.querySelector(`#chartView${capitalizeFirstLetter(reportType)}`);
    if (chartContainer) {
        chartContainer.innerHTML = chartImageTag;
    }

    // Open a new window for printing
    const printWindow = window.open('', '_blank', 'width=900,height=600');
    if (!printWindow) {
        alert('Unable to open print window. Please check your browser settings.');
        return;
    }

    // Write the content to the new window
    printWindow.document.open();
    printWindow.document.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>${reportType.charAt(0).toUpperCase() + reportType.slice(1)} Report</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    margin: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: center;
                }
            </style>
        </head>
        <body>
            ${printContent.outerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();

    // Print the content
    setTimeout(() => {
        printWindow.print();
        printWindow.close();

        // Re-show all the buttons after printing
        allButtons.forEach(button => {
            button.style.display = 'inline-block';
        });
    }, 500); // Adjust delay if necessary
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
