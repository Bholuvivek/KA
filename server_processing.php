<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// DataTables server-side processing
$requestData = $_REQUEST;

$columns = array(
    array('db' => 'Lead_ID', 'dt' => 0),
    array('db' => 'Name', 'dt' => 1),
    array('db' => 'Mobile', 'dt' => 2),
    array('db' => 'Alternate_Mobile', 'dt' => 3),
    array('db' => 'Whatsapp', 'dt' => 4),
    array('db' => 'Email', 'dt' => 5),
    array('db' => 'Interested_In', 'dt' => 6),
    array('db' => 'Source', 'dt' => 7),
    array('db' => 'Status', 'dt' => 8),
    array('db' => 'DOR', 'dt' => 9),
    array('db' => 'Summary_Note', 'dt' => 10),
    array('db' => 'Caller', 'dt' => 11),
    array('db' => 'State', 'dt' => 12),
    array('db' => 'City', 'dt' => 13),
);

$length = isset($_REQUEST['length']) ? intval($_REQUEST['length']) : 10;

$query = "
SELECT
    lmd.Lead_ID,
    lmd.Name,
    lmd.Mobile,
    lmd.Alternate_Mobile,
    lmd.Whatsapp,
    lmd.Email,
    lmd.Interested_In,
    lmd.Source,
    lmd.Status,
    lmd.DOR,
   
    cs.Summary_Note,
    ca.Name AS Caller,
    lmd.State,
    lmd.City
FROM
    crm_lead_master_data lmd
LEFT JOIN (
    SELECT
        Lead_ID,
        MAX(DOR) AS Last_DOR,
        Summary_Note
    FROM
        crm_calling_status
    GROUP BY
        Lead_ID
) cs ON lmd.Lead_ID = cs.Lead_ID
LEFT JOIN crm_admin ca ON lmd.Caller_ID = ca.Admin_ID
ORDER BY
    lmd.Lead_ID LIMIT $length";

$result = mysqli_query($conn, $query);

if (!$result) {
    throw new Exception('Error in query: ' . mysqli_error($conn));
}

$data = [
    'data' => [],
];

// Fetch rows from the result set
while ($row = mysqli_fetch_assoc($result)) {
    $data['data'][] = $row;
}

echo json_encode($data);
mysqli_close($conn);
?>
