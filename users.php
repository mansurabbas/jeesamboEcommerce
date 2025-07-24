<?php
include("top.php");

if(isset($_GET['type']) && $_GET['type']!=''){
	$type=clean($conn,$_GET['type']);
	if($type=='delete'){
		$id=clean($conn,$_GET['id']);
		$delete_sql="delete from users where id='$id'";
		mysqli_query($conn,$delete_sql);
	}
}
    $time=time();
    if(!isset($_SESSION['USER_LOGIN'])) {
        $_SESSION['redirectURL'] = $_SERVER['REQUEST_URI'];
    }


$time=time();
$sql="SELECT * FROM users ";
$sql=mysqli_query($conn,$sql);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- High Chart -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- High Chart -->
    <style> .center-block {display: block;margin-left: auto;margin-right: auto:}</style>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <head>
		<style>
      /* Table styling start */

    /*
    Generic Styling, for Desktops/Laptops
    */
    table {
    width: 90%;
    margin: auto;
    border-collapse: collapse;
    }
    /* Zebra striping */
    tr:nth-of-type(odd) {
    background: #eee;
    }
    th {
    background: #333;
    color: white;
    font-weight: bold;
    }


    td, th {
    padding: 6px;
    border: 1px solid #ccc;
    text-align: left;
    }
    /*
    Max width before this PARTICULAR table gets nasty
    This query will take effect for any screen smaller than 760px
    and also iPads specifically.
    */
    @media
    only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px)  {

    /* Force table to not be like tables anymore */
    table, thead, tbody, th, td, tr {
      display: block;
    }

    /* Hide table headers (but not display: none;, for accessibility) */
    thead {
      position: absolute;
      top: -9999px;
      left: -9999px;
    }

    tr { border: 1px solid #ccc; }

    td {
      /* Behave  like a "row" */
      border: none;
      border-bottom: 1px solid #eee;
      position: relative;
      padding-left: 50%;
    }

    td:before {
      /* Now like a table header */
      position: absolute;
      /* Top/left values mimic padding */
      top: 6px;
      left: 6px;
      width: 45%;
      padding-right: 10px;
      white-space: nowrap;
    }

    /*
    Label the data
    */
    td:nth-of-type(1):before { content: "No."; }
    td:nth-of-type(2):before { content: "Firstname"; }
    td:nth-of-type(3):before { content: "Email"; }
    td:nth-of-type(4):before { content: "Addded On"; }
    td:nth-of-type(5):before { content: "Status"; }
    td:nth-of-type(6):before { content: "Action"; }
    }
    /* Table styling end */
    .status {
        padding: 4px 5px;
    }

    table tbody tr td .badge-complete {
        background: #00c292;
        padding: 4px 5px;
        border-radius: 3px;

    }

    table tbody tr td .badge-pending {
        background: #fb9678;
        padding: 4px 5px;
        border-radius: 3px;

    }

    table tbody tr td .badge-delete {
        background: #FF0000;
        padding: 4px 5px;
        border-radius: 3px;

    }

    table tbody tr td a {
      color: #f2f2f2;
        font-weight: normal;
    }
      </style>			 
	</head>
    	<body>
		<div class="content">
        		<table>
                    <thead>
                    <tr>
                       <th>No.</th>
                       <th>Firstname</th>
                       <th>Email</th>
                       <th>Added On</th>
                       <th>Status</th>
                       <th>Action</th>
                    </tr>
                    </thead>
                    <tbody id="user_grid">
                        <?php
                        	$i=1;
                        	while($row=mysqli_fetch_assoc($sql)) { 
                    		    $status='Offline';
                    			$color="red";
                    			if($row['last_login']>$time){
                    				$status='Online';
                    				$color="green";
                    			}
                        		
                        	?>
                        	<tr>
                        		<td><?php echo $i?></td>
                        		<td><?php echo $row['firstname']?></td>
                        		<td style="word-wrap: break-word"><?php echo $row['email']?></td>
                        		<td><?php echo $row['added_on']?></td>
                        		<td><span class="status" style="background: <?php echo $color?>; color: #fff"><?php echo $status?></span></td>
                        		<td>
                        			
                        		    <span class="badge badge-delete"><a href="?type=delete&id='<?php echo $row['id']?>'"><i class="fas fa-trash-alt"></i>Delete</a></span>
                        		</td>
                        	</tr>
                        <?php $i++; } ?>
                    </tbody>
                </table>
		</div>
		
	
	</body>

<?php
require_once('footer.inc.php');
?>


