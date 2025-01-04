<?php
// Simulate a database connection and data retrieval
$applications = [
    [
        'id' => '001',
        'user' => 'John Doe',
        'email' => 'john.doe@example.com',
        'service' => 'Driving License',
        'status' => 'Pending',
        'date' => '2024-12-01',
    ],
    [
        'id' => '002',
        'user' => 'Jane Smith',
        'email' => 'jane.smith@example.com',
        'service' => 'Vehicle Registration',
        'status' => 'Pending',
        'date' => '2024-12-02',
    ],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $appId = $_POST['appId'];
    $comment = $_POST['comment'] ?? '';

    foreach ($applications as &$application) {
        if ($application['id'] === $appId) {
            if ($action === 'approve') {
                $application['status'] = 'Approved';
                $message = "Application $appId approved successfully.";
            } elseif ($action === 'reject' && !empty($comment)) {
                $application['status'] = 'Rejected';
                $application['comment'] = $comment;
                $message = "Application $appId rejected with reason: $comment";
            } else {
                $error = 'Rejection requires a comment.';
            }
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <?php if (!empty($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php elseif (!empty($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

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
            <?php foreach ($applications as $application): ?>
                <tr>
                    <td><?php echo $application['id']; ?></td>
                    <td><?php echo $application['user']; ?><br><?php echo $application['email']; ?></td>
                    <td><?php echo $application['service']; ?></td>
                    <td><?php echo $application['status']; ?></td>
                    <td><?php echo $application['date']; ?></td>
                    <td>
                        <?php if ($application['status'] === 'Pending'): ?>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="appId" value="<?php echo $application['id']; ?>">
                                <input type="hidden" name="action" value="approve">
                                <button type="submit">Approve</button>
                            </form>
                            <form method="POST" style="display: inline;">
                                <input type="hidden" name="appId" value="<?php echo $application['id']; ?>">
                                <input type="hidden" name="action" value="reject">
                                <textarea name="comment" placeholder="Reason for rejection"></textarea>
                                <button type="submit">Reject</button>
                            </form>
                        <?php else: ?>
                            <?php echo $application['status']; ?>
                            <?php if (!empty($application['comment'])): ?>
                                <br>Reason: <?php echo $application['comment']; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
