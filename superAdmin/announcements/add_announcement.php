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
    <style>
    .custom-width {
        max-width: 700px; /* Adjust the width as needed */
    }
    </style>
</head>
<body>
    <div class="modal fade" id="add_announcement_Modal" tabindex="-1" role="dialog" aria-labelledby="add_announcement_ModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog custom-width" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_announcement_ModalLabel">Add Announcement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="insert_announcement.php" method="post" enctype="multipart/form-data" style='margin-bottom: 10px;'>
                    
                  
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label class="form-label">Title:</label>
                                <input type="text" class="form-control" name="title" placeholder="Announcement Title" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Image:</label>
                                <input type="file" class="form-control-file form-control" name="image" accept="image/*"required>
                            </div>
                        </div>
                   
                        <!--<div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label">Link</label>
                                <textarea class="form-control" name="link" rows="1" placeholder="Paste Link Here"></textarea>
                            </div>
                        </div>-->
                                               
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="form-label">Announcement Content</label>
                                <textarea class="form-control" name="content" rows="2" placeholder="Type Annoucement Content"></textarea>
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
