<?php
// require top
require('top.php');

$obj->isAdmin();
?>

<?php
$color='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id = clean($conn,$_GET['id']);
	$sql = mysqli_query($conn,"SELECT * FROM color_master WHERE id='$id'");
	$check = mysqli_num_rows($sql);
	if($check>0){
		$row = mysqli_fetch_assoc($sql);
		$color = $row['color'];
	}else{
		?>
		<script>
			window.location.href="color";
		</script>
		<?php
		die();
	}
}

if(isset($_POST['submit'])){
	$color = mysqli_real_escape_string($conn, $_POST['color']);
	$color = str_replace(' ', '', $color);
	$sql=mysqli_query($conn,"SELECT * FROM color_master WHERE color='$color'");
	$check=mysqli_num_rows($sql);
	
	if($check>0){
		if(isset($_POST['id']) && $_POST['id']>0){
			
			$getData = mysqli_fetch_assoc($sql);
			if($id == $getData['id']){
				
			}else{
				$msg="Color already exist";
			}
		}
	}

	if($msg==''){
		if(isset($_POST['id']) && $_POST['id']>0){
			
			$id = mysqli_real_escape_string($conn,$_POST['id']);
			mysqli_query($conn,"UPDATE color_master SET color='$color' WHERE id='$id'");
		}else{
			mysqli_query($conn,"INSERT INTO color_master(color,status) VALUES('$color','1')");
		}
		?>
		<script>
			window.location.href="color";
		</script>
		<?php
		die();
	}
}
?>

      <div class="content">
              
                  <!-- form area start-->
            	    <div class="form">
            			<form class="login-form" action="manage_color" method="POST">
            			    <p>
            			        <input class="user-input" type="hidden" name="id" placeholder="Enter color name" required style="box-sizing: border-box" value="<?php if(isset($id)){echo $id;} ?>">
            			        <input class="user-input" type="text" name="color" placeholder="Enter color name" required style="box-sizing: border-box" value="<?php echo $color ?>">
            			    </p>
            			    <p>
            			        <input class="button-submit" type="submit" name="submit" value="Add color">
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
