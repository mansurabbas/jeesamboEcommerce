<?php
// Require top
require("top.php");

$obj->isAdmin();
?>
<?php

 // query the Product
 if(isset($_GET['type']) && $_GET['type']!=''){
 	$type=clean($conn, $_GET['type']);
 	if($type=='status'){
 		$operation=clean($conn, $_GET['operation']);
 		$id=clean($conn, $_GET['id']);
 		if($operation=='active'){
 			$status='1';
 		}else{
 			$status='0';
 		}
 		$update_status_sql="update delivery_boy set status='$status' where id='$id'";
 		mysqli_query($conn,$update_status_sql);
 	}

 	if($type=='delete'){
 		$id=clean($conn,$_GET['id']);
 		$delete_sql="delete from delivery_boy where id='$id'";
 		mysqli_query($conn,$delete_sql);
 	}
 }

 $sql="SELECT * FROM delivery_boy ORDER BY id DESC";
 $sql=mysqli_query($conn,$sql);
 // query the Product
 ?>

     <div class="content">
          <a href="manage_delivery_boy.php">Add Delivery Boy</a>
          <table id="myTable" class="display responsive wrap" style="width:100%">
                  <thead>
                  <tr>
                      <th width="5%">ID</th>
                      <th width="15%">Name</th>
                      <th width="10%">Mobile</th>
                      <th width="15%">Password</th>
                      <th width="50%">Status</th>
                      <th width="10%">Added On</th>
                  </tr>
                  </thead>
                  <tbody>
                      <?php
                      if(mysqli_num_rows($sql)>0){
                      $i=1;
                      while($row=mysqli_fetch_assoc($sql)) { 

                      ?>
                      <tr>
                         <td><?php echo $row['id']?></td>
                         <td style="word-wrap: break-word;"><?php echo $row['name']?></td>
                         <td style="word-wrap: break-word;"><?php echo $row['mobile']?></td>
                         <td style="word-wrap: break-word;"><?php echo $row['password']?></td>
                         <td>
                        <?php
                        if($row['status']==1){
                            echo "<span class='badge badge-complete'><a href='?type=status&operation=deactive&id=".$row['id']."'><i class='fas fa-check'></i>&nbsp;Active</a></span>&nbsp;";
                        }else{
                            echo "<span class='badge badge-pending'><a href='?type=status&operation=active&id=".$row['id']."'><i class='fas fa-times'></i>&nbsp;Deactive</a></span>&nbsp;";
                        }
                        echo "<span class='badge badge-edit'><a href='manage_delivery_boy.php?id=".$row['id']."'><i class='far fa-edit'></i>&nbsp;Edit</a></span>&nbsp;";
        
                        echo "<span class='badge badge-delete'><a href='?type=delete&id=".$row['id']."'><i class='far fa-trash-alt'></i>&nbsp;Delete</a></span>";
        
                        ?>
                      </td>
                      <td><?php echo $row['added_on']?></td>
        
                  </tr>
                  <?php } } ?>
                  </tbody>
          </table>
 </div>

          <script type="text/javascript">
      $(document).ready(function(){
        $('.nav_btn').click(function(){
          $('.mobile_nav_items').toggleClass('active');
        });
      });
      </script>

<script src="../js/custom.js"></script>
</body>
</html>
