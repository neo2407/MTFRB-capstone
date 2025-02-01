<?php
include "../../include/db_conn.php";

// Get filter and search values from request
$filter = $_GET['filter'] ?? '';
$search = $_GET['search'] ?? '';

// Build the SQL query based on the filter
$sql = "SELECT * FROM applicants WHERE applicantStatus='Pending'";

if ($filter && $search) {
    $filter = mysqli_real_escape_string($conn, $filter); // Sanitize filter
    $search = mysqli_real_escape_string($conn, $search); // Sanitize search
    $sql .= " AND $filter LIKE '%$search%'";
}

$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
       
        <td>{$row['id']}</td>
        <td>{$row['first_name']}</td>
        <td>{$row['last_name']}</td>
        <td>{$row['email']}</td>
        <td>{$row['applicationDate']}</td>
        <td>{$row['applicantStatus']}</td>
        <td>
          <a href='javascript:void(0);' onclick='showDetails({$row['id']});' class='link-dark'>
            <i class='fa-solid fa-eye fs-5 me-3'></i>
          </a>
          <a href='edit.php?id={$row['id']}' class='link-dark'>
            <i class='fa-solid fa-pen-to-square fs-5 me-3'></i>
          </a>
          <a href='javascript:void(0);' onclick='confirmDelete({$row['id']});' class='link-dark'>
            <i class='fa-solid fa-trash fs-5'></i>
          </a>
        </td>
      </tr>";
}
?>
