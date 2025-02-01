<?php 
    include "../include/headerAdmin.php";
    include "../include/navbarAdmin.php";
    include "data_count.php";
    include "../reports/applicants_report.php";
    include "../reports/franchise_report.php";
    include "../reports/violations_report.php";
    include "../reports/complaints_report.php";
   
   
?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <?php include "../include/topbarAdmin.php";?>
            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- operators count -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tricycle Operators</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $operatorsCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- applicant count -->
                        <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tricycle Franchise Applicants</div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                    <?php echo $franchiseCount; ?>
                                                </div>
                                            </div>
                                            <div class="col"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        <!-- complaints count -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Commuter Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $complaintsCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                            <!-- violationscount -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Violations</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $violationsCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                             <!-- Operators with pending complaints
                             <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Operators w/ Pending Complaints</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $operators_complaintCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    
                         <!-- Renewed Franchise 
                         <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Renewed Franchise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $renewedFranchiseCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                           <!-- Dropped Franchise 
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Dropped Franchise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $dropFranchiseCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        
                           <!-- Expired Franchise 
                           <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Expired Franchise</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $expiredFranchiseCount; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->
                    </div>
                    
                     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                     <div class=card>
                        <div class="form-group row">
                        
                        <div class="col-md-6">
                        <br>
                        <h6 style="text-align: center;">Tricycle Operators</h6>
                        <canvas id="operatorChart" style="width: 100%; max-width: 600px; height:300px;"></canvas>

                        <script>
                            // Ensure your PHP variables are passed to JavaScript
                            var operatorsCount = <?php echo json_encode([$jan_Count ?? 0, $feb_Count ?? 0, $march_Count ?? 0, $apr_Count ?? 0, $may_Count ?? 0, $jun_Count ?? 0, $jul_Count ?? 0, $aug_Count ?? 0, $sep_Count ?? 0, $oct_Count ?? 0]); ?>;
                            var operators_renewedCount = <?php echo json_encode([$jan_renewedCount ?? 0, $feb_renewedCount ?? 0, $march_renewedCount ?? 0, $apr_renewedCount ?? 0, $may_renewedCount ?? 0, $jun_renewedCount ?? 0, $jul_renewedCount ?? 0, $aug_renewedCount ?? 0, $sep_renewedCount ?? 0, $oct_renewedCount ?? 0]); ?>;
                            var operators_expiredCount = <?php echo json_encode([$jan_expiredCount ?? 0, $feb_expiredCount?? 0, $march_expiredCount ?? 0, $apr_expiredCount ?? 0, $may_expiredCount?? 0, $jun_expiredCount ?? 0, $jul_expiredCount ?? 0, $aug_expiredCount ?? 0, $sep_expiredCount ?? 0, $oct_expiredCount ?? 0]); ?>;
                        
                            // Log the data to check
                            console.log('Total Franchises:', operatorsCount);
                            console.log('Renewed Franchises:', operators_renewedCount);
                            console.log('Expired Franchises:', operators_expiredCount);
                        
                            // Create the chart
                            var ctx1 = document.getElementById('operatorChart').getContext('2d');
                            var myChart = new Chart(ctx1, {
                                type: 'bar',
                                data: {
                                    labels: ['Jan_operators', 'Feb_operators', 'Mar_operators', 'Apr_operators', 'May_operators', 'Jun_operators', 'Jul_operators', 'Aug_operators', 'Sep_operators', 'Oct_operators'], // Labels for months
                                    datasets: [{
                                        label: 'Total Franchises',
                                        data: operatorsCount, // Total franchises data
                                        backgroundColor: '#2680C2',
                                        borderColor: '#2680C2',
                                        borderWidth: 1
                                    }, {
                                        label: 'Renewed Franchises',
                                        data: operators_renewedCount, // Renewed franchises data
                                        backgroundColor: 'gray',
                                        borderColor: 'gray',
                                        borderWidth: 1
                                    }, {
                                        label: 'Expired Franchises',
                                        data: operators_expiredCount, // Expired franchises data
                                        backgroundColor: 'orange',
                                        borderColor: 'orange',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'top',
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(tooltipItem) {
                                                    return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                                }
                                            }
                                        }
                                    },
                                    scales: {
                                        x: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Months'
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            title: {
                                                display: true,
                                                text: 'Operators Count'
                                            }
                                        }
                                    }
                                }
                            });
                        </script>
                        </div>
                       
                        <div class="col-md-6">
                        <br>
                        <h6 style="text-align: center;">Tricycle Franchise Applicants</h6>
                          <canvas id="applicantsChart" style="width: 100%; max-width: 600px; height:300px;"></canvas>
                            
                            <script>
                                // Data from PHP
                                const applicantsMonthCount = {
                                    January: <?= $janCount ?>,
                                    February: <?= $febCount ?>,
                                    March: <?= $marCount ?>,
                                    April: <?= $aprCount ?>,
                                    May: <?= $mayCount ?>,
                                    June: <?= $junCount ?>,
                                    July: <?= $julCount ?>,
                                    August: <?= $augCount ?>,
                                    September: <?= $sepCount ?>,
                                    October: <?= $octCount ?>,
                                    November: <?= $novCount ?>,
                                    December: <?= $decCount ?>
                                };
                        
                                const verifiedCount = {
                                    January: <?= $janCount_verified ?>,
                                    February: <?= $febCount_verified ?>,
                                    March: <?= $marCount_verified ?>,
                                    April: <?= $aprCount_verified ?>,
                                    May: <?= $mayCount_verified ?>,
                                    June: <?= $junCount_verified ?>,
                                    July: <?= $julCount_verified ?>,
                                    August: <?= $augCount_verified ?>,
                                    September: <?= $sepCount_verified ?>,
                                    October: <?= $octCount_verified ?>,
                                    November: <?= $novCount_verified ?>,
                                    December: <?= $decCount_verified ?>
                                };
                        
                                const pendingCount = {
                                    January: <?= $janCount_pending ?>,
                                    February: <?= $febCount_pending ?>,
                                    March: <?= $marCount_pending ?>,
                                    April: <?= $aprCount_pending ?>,
                                    May: <?= $mayCount_pending ?>,
                                    June: <?= $junCount_pending ?>,
                                    July: <?= $julCount_pending ?>,
                                    August: <?= $augCount_pending ?>,
                                    September: <?= $sepCount_pending ?>,
                                    October: <?= $octCount_pending ?>,
                                    November: <?= $novCount_pending ?>,
                                    December: <?= $decCount_pending ?>
                                };
                        
                                // Extracting labels and data
                                const labels = Object.keys(applicantsMonthCount);
                                const totalData = Object.values(applicantsMonthCount);
                                const verifiedData = Object.values(verifiedCount);
                                const pendingData = Object.values(pendingCount);
                        
                                // Create the chart
                                const ctx = document.getElementById('applicantsChart').getContext('2d');
                                const applicantsChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [
                                            {
                                                label: 'Total Applicants',
                                                data: totalData,
                                                backgroundColor: '#2680C2',
                                                borderColor: '#2680C2',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Pending Applicants',
                                                data: pendingData,
                                                backgroundColor: 'gray',
                                                borderColor: 'gray',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Verified Applicants',
                                                data: verifiedData,
                                                backgroundColor: 'orange',
                                                borderColor: 'orange',
                                                borderWidth: 1
                                            }
                                            
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Months'
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Applicants Count'
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                        <div class="col-md-6">
                             <br>
                            <h6 style="text-align: center;">Commuters Complaints</h6>
                              <canvas id="complaintsChart" style="width: 100%; max-width: 600px; height:300px;"></canvas>
                            
                            <script>
                                // Data from PHP
                                const complaintsMonth_Count = {
                                    January: <?= $jan_count ?>,
                                    February: <?= $feb_count ?>,
                                    March: <?= $mar_count ?>,
                                    April: <?= $apr_count ?>,
                                    May: <?= $may_count ?>,
                                    June: <?= $jun_count ?>,
                                    July: <?= $jul_count ?>,
                                    August: <?= $aug_count ?>,
                                    September: <?= $sep_count ?>,
                                    October: <?= $oct_count ?>,
                                    November: <?= $nov_count ?>,
                                    December: <?= $dec_count ?>
                                };
                        
                                const complaintsMonth_ResolvedCount = {
                                    January: <?= $janCount_resolved ?>,
                                    February: <?= $febCount_resolved ?>,
                                    March: <?= $marCount_resolved ?>,
                                    April: <?= $aprCount_resolved ?>,
                                    May: <?= $mayCount_resolved ?>,
                                    June: <?= $junCount_resolved ?>,
                                    July: <?= $julCount_resolved ?>,
                                    August: <?= $augCount_resolved ?>,
                                    September: <?= $sepCount_resolved ?>,
                                    October: <?= $octCount_resolved ?>,
                                    November: <?= $novCount_resolved ?>,
                                    December: <?= $decCount_resolved ?>
                                };
                        
                                const complaintsMonth_DismissedCount = {
                                    January: <?= $janCount_dismissed ?>,
                                    February: <?= $febCount_dismissed ?>,
                                    March: <?= $marCount_dismissed ?>,
                                    April: <?= $aprCount_dismissed ?>,
                                    May: <?= $mayCount_dismissed ?>,
                                    June: <?= $junCount_dismissed ?>,
                                    July: <?= $julCount_dismissed ?>,
                                    August: <?= $augCount_dismissed ?>,
                                    September: <?= $sepCount_dismissed ?>,
                                    October: <?= $octCount_dismissed ?>,
                                    November: <?= $novCount_dismissed ?>,
                                    December: <?= $decCount_dismissed ?>
                                };
                        
                                // Extracting labels and data
                                const labels_complaints = Object.keys(complaintsMonth_Count);
                                const totalData_complaints = Object.values(complaintsMonth_Count);
                                const resolvedData = Object.values(complaintsMonth_ResolvedCount);
                                const dismissedData = Object.values(complaintsMonth_DismissedCount);
                            
                          
                        
                        
                                // Create the chart
                                const ctx3 = document.getElementById('complaintsChart').getContext('2d');
                                const complaintsChart = new Chart(ctx3, {
                                    type: 'bar',
                                    data: {
                                        labels: labels_complaints, // Change from labels_complaints to labels
                                        datasets: [
                                            {
                                                label: 'Total Complaints', // Change from label_complaints to label
                                                data: totalData_complaints,
                                                backgroundColor: '#2680C2',
                                                borderColor: '#2680C2',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Resolved Complaints', // Change from label_complaints to label
                                                data: resolvedData,
                                                backgroundColor: 'gray',
                                                borderColor: 'gray',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Dismissed Complaints', // Change from label_complaints to label
                                                data: dismissedData,
                                                backgroundColor: 'orange',
                                                borderColor: 'orange',
                                                borderWidth: 1
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Months'
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Complaints Count'
                                                }
                                            }
                                        }
                                    }
                                });
                            </script> 
                             </div>
                            <div class="col-md-6">
                             <br>
                            <h6 style="text-align: center;">Violations</h6>
                              <canvas id="violationsChart" style="width: 100%; max-width: 600px; height:300px;"></canvas>
                            
                            <script>
                                // Data from PHP
                                const violationsMonth_Count = {
                                    January: <?= $Jan_count ?>,
                                    February: <?= $Feb_count ?>,
                                    March: <?= $Mar_count ?>,
                                    April: <?= $Apr_count ?>,
                                    May: <?= $May_count ?>,
                                    June: <?= $Jun_count ?>,
                                    July: <?= $Jul_count ?>,
                                    August: <?= $Aug_count ?>,
                                    September: <?= $Sep_count ?>,
                                    October: <?= $Oct_count ?>,
                                    November: <?= $Nov_count ?>,
                                    December: <?= $Dec_count ?>
                                };
                        
                                const violationsMonth_SettledCount = {
                                    January: <?= $janCount_settled ?>,
                                    February: <?= $febCount_settled ?>,
                                    March: <?= $marCount_settled ?>,
                                    April: <?= $aprCount_settled ?>,
                                    May: <?= $mayCount_settled ?>,
                                    June: <?= $junCount_settled ?>,
                                    July: <?= $julCount_settled ?>,
                                    August: <?= $augCount_settled ?>,
                                    September: <?= $sepCount_settled ?>,
                                    October: <?= $octCount_settled ?>,
                                    November: <?= $novCount_settled ?>,
                                    December: <?= $decCount_settled ?>
                                };
                        
                                const violationsMonth_UnSettledCount = {
                                    January: <?= $janCount_unsettled ?>,
                                    February: <?= $febCount_unsettled ?>,
                                    March: <?= $marCount_unsettled ?>,
                                    April: <?= $aprCount_unsettled ?>,
                                    May: <?= $mayCount_unsettled ?>,
                                    June: <?= $junCount_unsettled ?>,
                                    July: <?= $julCount_unsettled ?>,
                                    August: <?= $augCount_unsettled ?>,
                                    September: <?= $sepCount_unsettled ?>,
                                    October: <?= $octCount_unsettled ?>,
                                    November: <?= $novCount_unsettled ?>,
                                    December: <?= $decCount_unsettled ?>
                                };
                        
                                // Extracting labels and data
                                const labels_violations = Object.keys(violationsMonth_Count);
                                const totalData_violations = Object.values(violationsMonth_Count);
                                const settledData = Object.values(violationsMonth_SettledCount);
                                const unsettledData = Object.values(violationsMonth_UnSettledCount);
                            
                                console.log('Total violations:',violationsMonth_Count);
                                console.log('settled:', violationsMonth_SettledCount);
                                console.log('unsettled:', violationsMonth_UnSettledCount);
                        
                        
                                // Create the chart
                                const ctx2 = document.getElementById('violationsChart').getContext('2d');
                                const violationsChart = new Chart(ctx2, {
                                    type: 'bar',
                                    data: {
                                        labels: labels_violations, // Change from labels_violations to labels
                                        datasets: [
                                            {
                                                label: 'Total Violations', // Change from label_violations to label
                                                data: totalData_violations,
                                                backgroundColor: '#2680C2',
                                                borderColor: '#2680C2',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Settled Violations', // Change from label_violations to label
                                                data: settledData,
                                                backgroundColor: 'gray',
                                                borderColor: 'gray',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'UnSettled Violations', // Change from label_violations to label
                                                data: unsettledData,
                                                backgroundColor: 'orange',
                                                borderColor: 'orange',
                                                borderWidth: 1
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        plugins: {
                                            legend: {
                                                position: 'top',
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(tooltipItem) {
                                                        return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                                                    }
                                                }
                                            }
                                        },
                                        scales: {
                                            x: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Months'
                                                }
                                            },
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Violations Count'
                                                }
                                            }
                                        }
                                    }
                                });
                            </script>  
                            </div>
                        </div>
                     </div><!-- class card end -->

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
    
            <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="../superAdmin_logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>
        </div>
    <?php 
        include "../include/scriptsAdmin.php";
        include "../include/footerAdmin.php";
    ?>