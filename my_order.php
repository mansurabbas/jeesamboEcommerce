<?php
// This include session, connection and functions
include "top.php";
?>
<?php
if(!isset($_SESSION['USER_LOGIN'])){
	$_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
	redirect('login');
}
?>

<body id="index">
<div class="content">

            <table>
            <thead>
                    <tr>
                        <th>Order ID</th>
                        <th><span>Order Date</span></th>
                        <th><span> Phone </span></th>
                        <th><span> Address </span></th>
                        <th><span> Reference Code</span></th>
                        <th><span> Total Price </span></th>
                        <th style="text-align: left"><span> Zipcode </span></th>
                    </tr>
            </thead>
                <tbody>
                    <?php
                    $uid=$_SESSION['USER_ID'];
                    $sql=mysqli_query($conn,"SELECT * FROM `order` WHERE user_id='$uid' ORDER BY id DESC");
                    while($row=mysqli_fetch_assoc($sql)){
                    ?>
                    <tr>
                        <td><a href="<?php echo SITE_PATH?>my_order_details?id=<?php echo $row['id']?>"> <?php echo $row['id']?></a>
                        <br/>
                        <a href="<?php echo SITE_PATH?>order_pdf?id=<?php echo $row['id']?>"> PDF</a>
                        </td>
                        <td><?php echo $row['added_on']?></td>
                        <td>
                        <?php echo $row['phone']?><br/>
                        </td>
                        <td>
                        <?php echo $row['address']?><br/>
                        </td>
                        <td>
                        <?php echo $row['reference']?>
                        </td>
                        <td><?php echo number_format($row['total_price'],2)?></td>
                        <td style="text-align: left"><?php echo ucfirst($row['zipcode'])?></td>

                    </tr>
                    <?php } ?>
                </tbody>

            </table>
</div>
<?php include('footer.inc.php'); ?>

<script>
        var loader = document.getElementById("preloader");
        window.addEventListener("load", function(){
            loader.style.display = "none";
        })
</script>
</body>
</html>
