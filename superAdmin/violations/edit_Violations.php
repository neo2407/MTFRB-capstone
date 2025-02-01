<?php

include "../include/headerAdmin.php";
include "../include/navbarAdmin.php";

$ticketNo = $_GET['ticketNo'];
$sql = "SELECT * FROM violations WHERE ticketNo = $ticketNo LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
?>

<style>
    
    .editable-fields input[readonly],
    .editable-fields textarea[readonly] {
        background-color: #e9ecef;
    }

    .btn-space {
    margin-left: 10px; /* Adjust the value as needed */
    }

    .container {
    display: flex;
    justify-content: center;
    }
    .row {
    width: 100%;
    max-width: 1200px; /* Adjust as needed */
    }
</style>
<div id="content-wrapper" class="d-flex flex-column ">   
    <?php include "../include/topbarAdmin.php";?>
    <div class="container mt-3 d-flex justify-content-center" style="width:50vw; min-width:150px;">
        <div class="card">
            <div class="card-header">
                <div class="text-left mb-1">
                    <h5>Violation Information <i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange; margin-bottom:10px;"></i></h5>
                </div>
            </div>

            <div class="container d-flex justify-content-center">
                <div class="row justify-content-center align-items-center" style="min-height: 60vh;">
                    <div class="col-md-10">
                        <form action="update_ViolationsInfo.php" method="post" style="width:100%; min-width:150px; margin-top:10px;">
                            <div class="editable-fields">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="ticketNo">Ticket No</label>
                                        <input type="text" class="form-control " name="ticketNo" value="<?php echo htmlspecialchars($row['ticketNo']) ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="violationDate">Violation Date</label>
                                        <input type="date" class="form-control readonly-field" name="violationDate" value="<?php echo htmlspecialchars($row['violationDate']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="violationType">Violation Type</label>
                                        <input type="text" class="form-control readonly-field" name="violationType" value="<?php echo htmlspecialchars($row['violationType']) ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="TFno">Tricycle Franchise No</label>
                                        <input type="text" class="form-control readonly-field" name="TFno" value="<?php echo htmlspecialchars($row['TFno']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="penaltyCharged">Penalty Charged</label>
                                        <input type="text" class="form-control readonly-field" name="penaltyCharged" value="<?php echo htmlspecialchars($row['penaltyCharged']) ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="penaltyStatus">Penalty Status</label>
                                        <input type="text" class="form-control " name="penaltyStatus" value="<?php echo htmlspecialchars($row['penaltyStatus']) ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label for="offenseType">Offense Type</label>
                                        <input type="text" class="form-control readonly-field" name="offenseType" value="<?php echo htmlspecialchars($row['offenseType']) ?>" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="enforcer">Enforcer In-charged</label>
                                        <input type="text" class="form-control readonly-field" name="enforcer" value="<?php echo htmlspecialchars($row['enforcer']) ?>" readonly>
                                    </div>
                                </div>
                            </div>
                              <input type="hidden" name="receiptNumber" value="<?php echo htmlspecialchars($row['receiptNumber']); ?>">
                              <input type="hidden"  name="operator_name"  value="<?php echo htmlspecialchars($row['operator_name']); ?>">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                            
                            <div class="d-flex justify-content-end" style="margin-right:20px;" >
                                <button type="submit" class="btn btn-success"  style="margin-right:10px;" name="submit">Update</button>
                                <a href="manageViolations.php" class="btn btn-danger">Exit</a>
                            </div>
                            <div class="text-left" style="margin-top:-40px; " >
                                <?php if (trim($row['penaltyStatus']) !== 'Pending'): ?>
                                    <button type="button" class="btn btn-primary" style="margin-right:10px;" id="generateReceiptBtn" data-ticketNo="<?= $row['ticketNo']; ?>">Generate Order of Payment</button>
                                <?php endif; ?>
                                
                                <div id="receiptTemplate" style="font-family: Arial, sans-serif; width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid black; padding: 20px; display: none;">
                                <div style="text-align: center;">
                                    <img src="../../assets/img/mtfrbLogo.jpg" alt="Logo1" style="width: 60px; vertical-align: middle;">
                                    <span style="font-size: 16px; font-weight: bold;">Municipal Tricycle Franchising Regulatory Board - Lucban</span>
                                    <img src="/../../assets/img/sbLogo.png" alt="Logo2" style="width: 60px; vertical-align: middle;">
                                    <p style="margin: 0;">88 A. Racelis Ave, Lucban, Quezon</p>
                                </div>
                                <h2 style="text-align: center;">ORDER OF PAYMENT</h2>
                                <p><strong>Receipt No:</strong> <span id="receiptNumber"></span></p>
                                <p><strong>Ticket No:</strong> <span id="ticketNumber"></span></p>
                                <p><strong>Tricycle Franchise No:</strong> <span id="tfNumber"></span></p>
                                <p><strong>Name:</strong> <span id="operator_name"></span></p>
                                <p><strong>Date:</strong> <span id="date"></span></p>
                                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                                    <thead>
                                        <tr>
                                            <th style="border: 1px solid black; padding: 5px;">Nature of Collection</th>
                                            <th style="border: 1px solid black; padding: 5px;">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="border: 1px solid black; padding: 5px;" id="penaltyDescription"></td>
                                            <td style="border: 1px solid black; padding: 5px;" id="penaltyCharged"></td>
                                        </tr>
                                        <tr>
                                            <td style="border: 1px solid black; padding: 5px; text-align: left;" colspan="1"><strong>Total</strong></td>
                                            <td style="border: 1px solid black; padding: 5px;" id="totalAmount"></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><strong>Amount in Words:</strong> <span id="amountInWords"></span></p>
                            </div>
                            <script>
                                // Function to convert numbers to words (simplified example)
                            function convertNumberToWords(amount) {
                                const units = [
                                    '', 'One', 'Two', 'Three', 'Four', 'Five', 'Six', 'Seven', 'Eight', 'Nine',
                                    'Ten', 'Eleven', 'Twelve', 'Thirteen', 'Fourteen', 'Fifteen', 'Sixteen', 'Seventeen', 'Eighteen', 'Nineteen'
                                ];
                                const tens = [
                                    '', '', 'Twenty', 'Thirty', 'Forty', 'Fifty', 'Sixty', 'Seventy', 'Eighty', 'Ninety'
                                ];
                                const thousands = [
                                    '', 'Thousand', 'Million', 'Billion'
                                ];
                            
                                // Function to convert a number less than 1000 into words
                                function convertToWords(num) {
                                    let word = '';
                                    if (num >= 100) {
                                        word += units[Math.floor(num / 100)] + ' Hundred ';
                                        num %= 100;
                                    }
                                    if (num > 10 && num < 20) {
                                        word += units[num] + ' ';
                                    } else {
                                        word += tens[Math.floor(num / 10)] + ' ';
                                        num %= 10;
                                        word += units[num] + ' ';
                                    }
                                    return word.trim();
                                }
                            
                                // Split the amount into integer and decimal parts
                                const [integerPart, decimalPart] = amount.toString().split('.');
                            
                                // Convert the integer part
                                let integerWords = '';
                                let num = parseInt(integerPart, 10);
                                if (num === 0) {
                                    integerWords = 'Zero';
                                } else {
                                    let i = 0;
                                    while (num > 0) {
                                        const part = num % 1000;
                                        if (part > 0) {
                                            integerWords = convertToWords(part) + ' ' + thousands[i] + ' ' + integerWords;
                                        }
                                        num = Math.floor(num / 1000);
                                        i++;
                                    }
                                }
                            
                                // Convert the decimal part (if any)
                                let decimalWords = '';
                                if (decimalPart && parseInt(decimalPart, 10) > 0) {
                                    decimalWords = 'and ' + convertToWords(parseInt(decimalPart, 10)) + ' Cents';
                                }
                            
                                // Combine the integer and decimal parts
                                return `${integerWords.trim()} Pesos Only ${decimalWords}`.trim();
                            }
                            </script>
                            <script>
                              window.addEventListener('DOMContentLoaded', function () {
                                document.getElementById('generateReceiptBtn').addEventListener('click', function () {
                                    console.log('Button clicked'); // Debugging line
                            
                                    // Check if all form fields exist before accessing their values
                                    var receiptNumber = document.querySelector('input[name="receiptNumber"]');
                                    var ticketNumber = document.querySelector('input[name="ticketNo"]');
                                    var tfNumber = document.querySelector('input[name="TFno"]');
                                    var operatorName = document.querySelector('input[name="operator_name"]');
                                    var violationDate = document.querySelector('input[name="violationDate"]');
                                    var violationType = document.querySelector('input[name="violationType"]');
                                    var penaltyCharged = document.querySelector('input[name="penaltyCharged"]');
                            
                                    if (receiptNumber && ticketNumber && tfNumber && operatorName && violationDate && violationType && penaltyCharged) {
                                        // Prepare the receipt content
                                        var amountInWords = convertNumberToWords(penaltyCharged.value); // Convert the penaltyCharged amount to words
                            
                                        var receiptContent = `
                                            <div style="font-family: Arial, sans-serif; width: 100%; max-width: 600px; margin: 0 auto; border: 1px solid black; padding: 20px;">
                                                <div style="text-align: center;">
                                                    <img src="../../assets/img/mtfrbLogo.jpg" alt="Logo1" style="width: 60px; vertical-align: middle;">
                                                    <span style="font-size: 16px; font-weight: bold;">Municipal Tricycle Franchising Regulatory Board - Lucban</span>
                                                    <img src="/../../assets/img/sbLogo.png" alt="Logo2" style="width: 60px; vertical-align: middle;">
                                                    <p style="margin: 0;">88 A. Racelis Ave, Lucban, Quezon</p>
                                                </div>
                                                <h2 style="text-align: center;">ORDER OF PAYMENT</h2>
                                                <p><strong>OR No:</strong> ${receiptNumber.value}</p>
                                                <p><strong>Ticket No:</strong> ${ticketNumber.value}</p>
                                                <p><strong>Tricycle Franchise No:</strong> ${tfNumber.value}</p>
                                                <p><strong>Name:</strong> ${operatorName.value}</p>
                                                <p><strong>Date:</strong> ${violationDate.value}</p>
                                                <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                                                    <thead>
                                                        <tr>
                                                            <th style="border: 1px solid black; padding: 5px;">Nature of Collection</th>
                                                            <th style="border: 1px solid black; padding: 5px;">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td style="border: 1px solid black; padding: 5px;">Violation: ${violationType.value}</td>
                                                            <td style="border: 1px solid black; padding: 5px;">${penaltyCharged.value}</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: 1px solid black; padding: 5px; text-align: left;" colspan="1"><strong>Total</strong></td>
                                                            <td style="border: 1px solid black; padding: 5px;">${penaltyCharged.value}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <p><strong>Amount in Words:</strong> ${amountInWords}</p>
                                               <div style="display: flex; justify-content: right; text-align: center;">
                                                <div>
                                                    <p>_________________</p>
                                                    <p><strong>Signature</strong></p>
                                                </div>
                                                </div>
                                                
                                            </div>
                                        `;
                            
                                        // Open a new window and write the receipt content
                                        var newWindow = window.open('', '_blank');
                                        newWindow.document.write(`
                                            <html>
                                                <head>
                                                    <title>Order of Payment</title>
                                                    <style>
                                                        body {
                                                            font-family: Arial, sans-serif;
                                                            margin: 0;
                                                            padding: 20px;
                                                        }
                                                    </style>
                                                </head>
                                                <body>
                                                    ${receiptContent}
                                                </body>
                                            </html>
                                        `);
                                        newWindow.document.close();
                            
                                        // Automatically open the print dialog
                                        newWindow.print();
                                    } else {
                                        console.error('One or more form fields are missing.');
                                    }
                                });
                            });
                                    </script>
                                     <script>
                                        $(document).on('click', '#generateReceiptBtn', function () {
                                            // Retrieve ticketNo from the button or fallback to URL
                                            const ticketNo = $(this).data('ticketno') || new URLSearchParams(window.location.search).get('ticketNo');
                                            console.log('Ticket No:', ticketNo);
                                        
                                            if (!ticketNo) {
                                                alert('Error: Ticket number is missing!');
                                                return;
                                            }
                                        
                                            $.ajax({
                                                url: 'logs_history_generateReceipt.php',
                                                type: 'POST',
                                                data: { ticketNo: ticketNo },
                                                dataType: 'json',
                                                success: function (response) {
                                                    if (response.success) {
                                                        //alert('Action logged successfully!');
                                                    } else {
                                                        console.error('Error logging action:', response.error);
                                                    }
                                                },
                                                error: function (xhr, status, error) {
                                                    console.error('AJAX error:', error);
                                                }
                                            });
                                        });

                                    </script>
                                </div>
                            </div>
                            </div>
                        </form>
                        </div>
                        <script>
                           document.getElementById('edit-icon').addEventListener('click', function() {
                                let fields = document.querySelectorAll('.editable-fields input, .editable-fields textarea');
                                fields.forEach(field => {
                                    if (field.hasAttribute('readonly')) {
                                        field.removeAttribute('readonly');
                                        field.style.backgroundColor = "#fff"; // Optional: change background color to indicate edit mode
                                    } else {
                                        field.setAttribute('readonly', 'readonly');
                                        field.style.backgroundColor = "#e9ecef"; // Reset background color to indicate read-only mode
                                    }
                                });
                            });
                        </script>
                    </div>  
                </div>  
            </div>
        </div>
    </div>
</div>


<?php 
        include "../include/scripts.php"; 
        include "../include/scriptsAdmin.php";
        include "../include/footerAdmin.php";
    ?>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
      <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
</div>



<!-- Receipt Template (hidden by default) -->

                
                
    <script>
        document.getElementById('edit-icon').addEventListener('click', function() {
            let fields = document.querySelectorAll('.editable-fields input:not(.readonly-field)');
            fields.forEach(field => {
                if (field.hasAttribute('readonly')) {
                    field.removeAttribute('readonly');
                    field.style.backgroundColor = "#fff"; // Optional: change background color to indicate edit mode
                } else {
                    field.setAttribute('readonly', 'readonly');
                    field.style.backgroundColor = ""; // Reset background color
                }
            });
        });
    </script>
    
    
 