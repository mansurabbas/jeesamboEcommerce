<?php
// require top
require('top.php');

$obj->isAdmin();
?>
<?php

$name='';
$password='';
$mobile='';
$msg='';

if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id = mysqli_real_escape_string($conn, $_GET['id']);
	$sql=mysqli_query($conn,"SELECT * FROM delivery_boy WHERE id='$id'");
	$check=mysqli_num_rows($sql);
	if($check>0){
		$row=mysqli_fetch_assoc($sql);
		$name=$row['name'];
		$email=$row['email'];
		$mobile=$row['mobile'];
		$password=$row['password'];
	}else{
		?>
		<script>
			window.location.href="delivery_boy";
			die();
		</script>
		<?php
	}
}

if(isset($_POST['submit'])){
	$name=mysqli_real_escape_string($conn, $_POST['name']);
	$mobile=mysqli_real_escape_string($conn, $_POST['mobile']);
	$password=mysqli_real_escape_string($conn, $_POST['password']);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);

	$sql=mysqli_query($conn,"SELECT * FROM delivery_boy WHERE mobile='$mobile'");
	$check=mysqli_num_rows($sql);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($sql);

			if($id==$getData['id']){

			}else{
				$msg="mobile already exist";
			}
		}else{
			$msg="mobile already exist";
		}
	}


	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$update_sql="UPDATE delivery_boy name='$name',password='$password_hash',mobile='$mobile' WHERE id='$id'";
			mysqli_query($conn,$update_sql);
		}else{
			$added_on=date('Y-m-d h:i:s');
			mysqli_query($conn,"INSERT INTO delivery_boy(name,mobile,password,status,added_on) VALUES('$name','$mobile','$password_hash',0,'$added_on')");
			$lsat_insert_id = mysqli_insert_id($conn);
		}
		?>
		<script>
			window.location.href="delivery_boy";
			die();
		</script>
		<?php
	}
}
?>

<!--
<br><br><br><br><br><br><br><br><br><br><br> -->
        <div class="content">
            
                <div class="form">
                    <form class="login-form" action="manage_delivery_boy.php" method="post">
                        <p>
                            <input class="user-input" type="text" name="name" placeholder="Name" required style="box-sizing: border-box">
                        </p>
						<p>
                            <input class="user-input" type="text" name="mobile" placeholder="Mobile" required style="box-sizing: border-box">
                        </p>
                        <p>
                            <input class="user-input" type="password" name="password" placeholder="Password" required style="box-sizing: border-box">
                        </p>
                        <p>
                            <input class="btn" type="submit" name="submit" value="Add Delivery Boy">
                        </p>
          			</form>
                </div>

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
