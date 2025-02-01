<?php
include "../include/headerAdmin.php";
include "../include/navbarAdmin.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare a statement
    $stmt = $conn->prepare("SELECT * FROM announcements WHERE id = ? LIMIT 1");
    $stmt->bind_param("i", $id);  // "i" denotes an integer parameter
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No announcement found for the given ID.";
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid ID.";
    exit;
}
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

    
    <div id="content-wrapper" class="d-flex flex-column ">   
        <?php include "../include/topbarAdmin.php";?>
        <div class="col-md-10" style="margin-left:50px">
            <div class="card">
                <div class="card-header">
                    <div class="text-left mb-1">
                        <h5>Edit Announcement<i id="edit-icon" class="fas fa-edit" style="cursor: pointer; color: orange; margin-bottom:10px; margin-left:5px"></i></h5>
                    </div>
                </div>

                <div class="container d-flex justify-content-center">
                    <div class="col-md-12" >
                        <div class="col-md-12">
                            <form action="update_announcement.php" method="post"  enctype="multipart/form-data" style="margin-top:10px;">
                                <div class="editable-fields">
                                    <div class="form-group row" style="display: flex; justify-content: center;">
                                        <img class="card-img-top" src="../../uploads/announcements/<?php echo htmlspecialchars($row['image']); ?>" alt="Card image cap" style="width: 60%; height: 300px; margin-bottom: 1rem; object-fit: cover;">
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="image">Announcement Picture</label>
                                            <input type="file" class="form-control form-control-file"  style="height:40px; width:100%;" name="image" accept="image/*"   >
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control readonly-field" name="title" value="<?php echo htmlspecialchars($row['title']) ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="content">Content</label>
                                            <textarea class="form-control" name="content" rows="3" readonly><?php echo htmlspecialchars($row['content']); ?></textarea>
                                        </div>
                                    </div>
                                  
                                </div>
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                                    <div class="d-flex justify-content-end" style="margin-right:20px; margin-bottom:20px;" >
                                        <button type="submit" class="btn btn-primary"  style="margin-right:10px;" name="submit">Update</button>
                                        <a href="announcements.php" class="btn btn-danger">Exit</a>
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