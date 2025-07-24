<?php require_once('top.php');?>
<?php
    if(!isset($_SESSION['USER_LOGIN'])){
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
        redirect('login');
    }
?>

<body id="index">
<div class="content">
    
<div class="data-history-container">
            <h2>Data History</h2>
            <table class="data-history-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Plan</th>
                        <th>Plan amount</th>
                        <th>Number</th>
                        <th>Plan network</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    // SQL query to fetch data from transactions_history table
                    $sql = "SELECT * FROM transactions_history WHERE user_id = '".$_SESSION['USER_ID']."' ORDER BY create_date desc";
                    $result = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $id = $row['id'];
                            $data_id = $row['data_id'];
                            $plan_name = $row['plan_name'];
                            $amount = $row['amount'];
                            $phone_number = $row['phone_number'];
                            $ident = $row['ident'];
                            $status = $row['status'];
                            $plan_network = $row['plan_network'];
                            $create_date = $row['create_date'];
                            $balance_before = $row['balance_before'];
                            $balance_after = $row['balance_after'];

                        echo "<tr>";
                        echo "<td>$ident</td>";
                        echo "<td>$plan_name</td>";
                        echo "<td>$amount</td>";
                        echo "<td>$phone_number</td>";
                        echo "<td>$plan_network</td>";
                        echo "<td>$create_date</td>";
                        echo "<td><span class='data-status-success'>$status</span></td>";
                        echo "<td><span class='data-action-view'><a href='transactions_history_detail?id=" . $data_id . "'>View</a></span></td>";
                        echo "</tr>";
                        }

                    } else {
                        echo "<p>No history data found.</p>";
                    }
                ?>
                    
                </tbody>
            </table>
        </div>

    <!-- <script src="script.js"></script> -->
</div>
<?php require_once('footer.inc.php'); ?>
</body>
</html>
