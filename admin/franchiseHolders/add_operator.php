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
                    <form action="insert_operator.php" method="post" enctype="multipart/form-data" style='margin-bottom: 10px;'>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Tricycle Franchise Number</label>
                                <input type="number" class="form-control" name="id" placeholder="TF no" required>
                            </div>
                            <div class="col-md-6">
                                <label for="operatorMonth"class="form-label">Month</label>
                                <select id="operatorMonth" name="operatorMonth" class="form-control custom-select" required>
                                            <option value=" ">Select Month</option>
                                            <option value="jan_operators">January</option>
                                            <option value="feb_operators">February</option>
                                            <option value="march_operators">March</option>
                                            <option value="apr_operators">April</option>
                                            <option value="may_operators">May</option>
                                            <option value="jun_operators">June</option>
                                            <option value="jul_operators">July</option>
                                            <option value="aug_operators">August</option>
                                            <option value="sep_operators">September</option>
                                            <option value="oct_operators">October</option>
                                </select>
                            </div>
                        </div>
                    
                        
                        <div class="form-group row">
                            <div class="col-md-5">
                                <label class="form-label">First Name:</label>
                                <input type="text" class="form-control" name="first_name" placeholder="Albert" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Last Name:</label>
                                <input type="text" class="form-control" name="last_name" placeholder="Einstein" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name:</label>
                                <input type="text" class="form-control" name="m_name" placeholder="Santos" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-5">
                                <label class="form-label">Tricycle Color</label>
                                <input type="text" class="form-control" name="tricColor" placeholder="Blue" required>
                            </div>
                            <div class="col-md-4">
                                <label for="tricType"class="form-label">Tricycle Type</label>
                                <select id="tricType" name="tricType" class="form-control custom-select" required>
                                            <option value=" ">Select Tricycle Type</option>
                                            <option value="Tricycle">Tricycle</option>
                                            <option value="Tuktuk">Tuktuk</option>
                                </select>
                            </div>
                            <div class="col-md-3">
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
                                <label class="form-label">Registered Driver 2</label>
                                <input type="text" class="form-control" name="driver2_name" placeholder="Registered Driver 2" required>
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
                                <input type="text" class="form-control" name="contact_num" placeholder="123-456-7890"required>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
