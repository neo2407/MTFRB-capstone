<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Account Modal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .swal2-container {
            z-index: 1060 !important; /* Ensure SweetAlert2 is on top of Bootstrap modal */
        }
    </style>
    
</head>
<body>
    <div class="modal fade" id="add_operator_Modal" tabindex="-1" role="dialog" aria-labelledby="add_operator_ModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog custom-width" role="document" style="max-width:700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_operator_ModalLabel">Add Operator</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form action="insert_operator.php" method="post" enctype="multipart/form-data" style="margin-bottom: 10px;">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <label class="form-label">Tricycle Franchise Number</label>
                            <input 
                                type="number" 
                                class="form-control" 
                                name="TFno" 
                                placeholder="Franchise No." 
                                required 
                                id="tfNo"
                                oninput="updateFields()"
                            >
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Expiration Date</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="expDate" 
                                id="expDate" 
                                placeholder="Expiration Date" 
                                readonly
                            >
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Day Banned</label>
                            <input 
                                type="text" 
                                class="form-control" 
                                name="dayBan" 
                                id="dayBanned" 
                                placeholder="Day Banned" 
                                readonly
                            >
                        </div>
                    </div>
                
                    <script>
                        function calculateExpirationDate(TFno) {
                            const TFnoStr = String(TFno);
                            const secondToLastDigit = parseInt(TFnoStr.charAt(TFnoStr.length - 2), 10);
                            const lastDigit = parseInt(TFnoStr.charAt(TFnoStr.length - 1), 10);
                
                            let expirationDay;
                            if ([1, 2, 3].includes(secondToLastDigit)) expirationDay = 7;
                            else if ([4, 5, 6].includes(secondToLastDigit)) expirationDay = 14;
                            else if ([7, 8].includes(secondToLastDigit)) expirationDay = 21;
                            else expirationDay = 28;
                
                            const months = {
                                1: '01', 2: '02', 3: '03', 4: '04',
                                5: '05', 6: '06', 7: '07', 8: '08',
                                9: '09', 0: '10'
                            };
                
                            const expirationMonth = months[lastDigit] || '01';
                            const currentYear = new Date().getFullYear();
                            const expirationYear = currentYear + 1;
                
                            return `${expirationDay}/${expirationMonth}/${expirationYear}`;
                        }
                
                        function calculateDayBan(TFno) {
                            const lastDigit = parseInt(String(TFno).charAt(String(TFno).length - 1), 10);
                            const dayMap = {
                                0: 'Monday', 1: 'Monday',
                                2: 'Tuesday', 3: 'Tuesday',
                                4: 'Wednesday', 5: 'Wednesday',
                                6: 'Thursday', 7: 'Thursday',
                                8: 'Friday', 9: 'Friday'
                            };
                            return dayMap[lastDigit] || '';
                        }
                
                        function updateFields() {
                            const tfNo = document.getElementById('tfNo').value;
                            if (tfNo && tfNo.length >= 2) {
                                const expDate = calculateExpirationDate(tfNo);
                                const dayBan = calculateDayBan(tfNo);
                                document.getElementById('expDate').value = expDate;
                                document.getElementById('dayBanned').value = dayBan;
                            } else {
                                document.getElementById('expDate').value = ''; // Clear field if input is invalid
                                document.getElementById('dayBanned').value = '';  // Clear field if input is invalid
                            }
                        }
                    </script>


            
                <div class="form-group row">
                    <div class="col-md-4">
                        <label class="form-label">First Name:</label>
                        <input type="text" class="form-control" name="first_name" placeholder="Albert" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Last Name:</label>
                        <input type="text" class="form-control" name="last_name" placeholder="Einstein" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Middle Name:</label>
                        <input type="text" class="form-control" name="m_name" placeholder="Santos" required>
                    </div>
                </div>

                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="form-label">Tricycle Color</label>
                                <input type="text" class="form-control" name="tricColor" placeholder="Blue" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tricType"class="form-label">Tricycle Type</label>
                                <select id="tricType" name="tricType" class="form-control custom-select" required>
                                            <option value=" ">Select Tricycle Type</option>
                                            <option value="Tricycle">Tricycle</option>
                                            <option value="Tricycle(Back-to-Back)">Tricycle(Back-to-Back)</option>
                                            <option value="Tuktuk">Tuktuk</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">TODA</label>
                                <select id="toda" name="toda" class="form-control custom-select" required>
                                    <option value="">Select TODA</option>
                                    <option value="Not Member of TODA">Not Member of TODA</option>
                                    <option value="ASIT">ASIT</option>
                                    <option value="CALMAR">CALMAR</option>
                                    <option value="CSIDE">CSIDE</option>
                                    <option value="FABIE">FABIE</option>
                                    <option value="GSLV">GSLV</option>
                                    <option value="KILIB">KILIB</option>
                                    <option value="KULAPI">KULAPI</option>
                                    <option value="LRE 200">LRE 200</option>
                                    <option value="LUCBAN">LUCBAN</option>
                                    <option value="MAKATC">MAKATC</option>
                                    <option value="MARKET">MARKET</option>
                                    <option value="MMD">MMD</option>
                                    <option value="MMDT">MMDT</option>
                                    <option value="MMK">MMK</option>
                                    <option value="MMONTE">MMONTE</option>
                                    <option value="NAGSIMANO">NAGSIMANO</option>
                                    <option value="ONGVILLE">ONGVILLE</option>
                                    <option value="PALOLA">PALOLA</option>
                                    <option value="PECTO">PECTO</option>
                                    <option value="PEL">PEL</option>
                                    <option value="PEL SERVICE">PEL SERVICE</option>
                                    <option value="PIIS">PIIS</option>
                                    <option value="PSL">PSL</option>
                                    <option value="SAMBAT">SAMBAT</option>
                                    <option value="SLSU">SLSU</option>
                                    <option value="SLSU AYUTI">SLSU AYUTI</option>
                                    <option value="TBT">TBT</option>
                                    <option value="TMG">TMG</option>
                                    <option value="TUKTUK B.">TUKTUK B.</option>
                                    <option value="UNAVP">UNAVP</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Registered Driver 1</label>
                                <input type="text" class="form-control" name="driver1_name" placeholder="Registered Driver 1" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Registered Driver 2</label><small></small>
                                <input type="text" class="form-control" name="driver2_name" placeholder="Put N/A if not applicable" required>
                            </div>
                        </div>
                  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Upload Operator Picture</label>
                                <input type="file" class="form-control-file form-control" style="width:320px;" name="operatorsPic" accept="image/*"required>
                            </div>

                            <div class="col-md-6">
                                <label for="sex"class="form-label">Sex</label>
                                <select id="sex" name="sex" class="form-control custom-select" required>
                                            <option value=" ">Select Sex</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                </select>
                            </div>
                        </div>

                       
                    
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Email" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number</label>
                                <input type="text" class="form-control" name="contact_num" placeholder="09XXXXXXXXX"required>
                            </div>
                        </div>
                                           
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label">Address</label>
                                <textarea class="form-control" name="address" rows="2" placeholder="Enter address"></textarea>
                            </div>
                        </div>
                       
                        <div class="form-group row">
                            <div class="col text-right">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                        
                    </for   m>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
