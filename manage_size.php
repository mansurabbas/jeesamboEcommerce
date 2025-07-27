<?php
// require top
require('top.php');

$obj->isAdmin();
?>

<?php
$size='';
$order_by='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id = clean($conn,$_GET['id']);
	$sql = mysqli_query($conn,"SELECT * FROM size_master WHERE id='$id'");
	$check = mysqli_num_rows($sql);
	if($check>0){
		$row = mysqli_fetch_assoc($sql);
		$size = $row['size'];
		$order_by = $row['order_by'];
	}else{
		?>
		<script>
			window.location.href="size";
		</script>
		<?php
		die();
	}
}

if(isset($_POST['submit'])){
	$size = mysqli_real_escape_string($conn, $_POST['size']);
	$order_by = mysqli_real_escape_string($conn, $_POST['order_by']);
	$sql=mysqli_query($conn,"SELECT * FROM size_master WHERE size='$size'");
	$check=mysqli_num_rows($sql);
	if($check>0){
		if(isset($_POST['id']) && $_POST['id']!=''){
			$getData = mysqli_fetch_assoc($sql);
			if($id == $getData['id']){

			}else{
				$msg="Size already exist";
			}
		}else{
			$msg="Size already exist";
		}
	}

	if($msg==''){
		if(isset($_POST['id']) && $_POST['id']!=''){
			$id = mysqli_real_escape_string($conn, $_POST['id']);
			$order_by = mysqli_real_escape_string($conn, $_GET['order_by']);
			mysqli_query($conn,"UPDATE size_master SET size='$size' WHERE id='$id'");
		}else{
			mysqli_query($conn,"INSERT INTO size_master(size,order_by,status) VALUES('$size','$order_by','1')");
		}
		?>
		<script>
			window.location.href="size";
		</script>
		<?php
		die();
	}
}

?>

  <div class="content">
              
                    <!-- form area start-->
            	    <div class="form">
            			<form class="login-form" action="manage_size" method="POST">
            			    <p>
            			        <input class="user-input" type="hidden" name="id" placeholder="Enter size name" required value="<?php if(isset($id)){echo $id;}?>" style="box-sizing: border-box">
            			        <input class="user-input" type="text" name="size" placeholder="Enter size name" required value="<?php echo $size?>" style="box-sizing: border-box">
            			    </p>
            			    <p>
            			        <input class="user-input" type="text" name="order_by" placeholder="Enter order_by name" required value="<?php echo $order_by?>" style="box-sizing: border-box">
            			    </p>
            			    <p>
            			        <input class="button-submit" type="submit" name="submit" value="Add Size">
            			    </p>
            				<div class=""><?php echo $msg?></div>
            			</form>
            		</div>
        	
		            <!--form area end-->

		<script type="text/javascript">
		$('.options-02 a').click(function(){
			$('form').animate({
				height: "toggle", opacity: "toggle"
			}, "slow");
		});
		</script>

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
