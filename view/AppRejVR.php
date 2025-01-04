<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - BRTA Service Portal</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <table border="1" width="100%">
        <thead>
            <tr>
                <th>Application ID</th>
                <th>User Details</th>
                <th>Service Type</th>
                <th>Status</th>
                <th>Submission Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $applications = [
                ["id" => "001", "user" => "Sadman", "email" => "sadman@gmail.com", "service" => "Driving License", "status" => "Pending", "date" => "2024-12-01"],
                ["id" => "002", "user" => "Rahim", "email" => "rahim22@gmail.com", "service" => "Vehicle Registration", "status" => "Pending", "date" => "2024-12-02"],
            ];

            foreach ($applications as $app) {
                echo "<tr>";
                echo "<td>{$app['id']}</td>";
                echo "<td>{$app['user']}<br>{$app['email']}</td>";
                echo "<td>{$app['service']}</td>";
                echo "<td id='status-{$app['id']}'>{$app['status']}</td>";
                echo "<td>{$app['date']}</td>";
                echo "<td>";
                echo "<form method='POST' action=''>";
                echo "<button type='submit' name='approve' value='{$app['id']}'>Approve</button>";
                echo "<button type='button' onclick='showCommentBox(\"{$app['id']}\")'>Reject</button>";
                echo "<div id='comment-box-{$app['id']}' style='display: none;'>";
                echo "<textarea name='comment' placeholder='Add rejection comments...'></textarea>";
                echo "<button type='submit' name='reject' value='{$app['id']}'>Submit Rejection</button>";
                echo "</div>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <script>
        function showCommentBox(id) {
            document.getElementById(`comment-box-${id}`).style.display = 'block';
        }
    </script>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['approve'])) {
            $id = $_POST['approve'];
            // Update application status to Approved
            echo "<div style='color: green;'>Application ID $id has been approved.</div>";
        }

        if (isset($_POST['reject'])) {
            $id = $_POST['reject'];
            $comment = $_POST['comment'] ?? '';

            if (empty($comment)) {
                echo "<div style='color: red;'>Rejection comment is required for Application ID $id.</div>";
            } else {
                // Update application status to Rejected with comments
                echo "<div style='color: red;'>Application ID $id has been rejected. Comment: $comment</div>";
            }
        }
    }
    ?>
</body>
</html>
