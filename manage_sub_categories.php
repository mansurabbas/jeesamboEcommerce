<?php
// require top
require('top.php');

$obj->isAdmin();
?>

<?php
$categories='';
$msg='';
$sub_categories='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id = clean($conn,$_GET['id']);
	$sub_categories = $_POST['sub_categories'];
	$sql=mysqli_query($conn,"select * from sub_categories where id='$id'");
	$check=mysqli_num_rows($sql);
	if($check>0){
		$row=mysqli_fetch_assoc($sql);
		$sub_categories=$row['sub_categories'];
		$categories=$row['categories_id'];
	}else{
		header('location:sub_categories');
		die();
	}
}

if(isset($_POST['submit'])){
	$categories = clean($conn,$_POST['categories_id']);
	$sub_categories = clean($conn,$_POST['sub_categories']);
	$sql=mysqli_query($conn,"select * from sub_categories where categories_id='$categories' and sub_categories='$sub_categories'");
	$check=mysqli_num_rows($sql);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($sql);
			if($id==$getData['id']){

			}else{
				$msg="Sub Categories already exist";
			}
		}else{
			$msg="Sub Categories already exist";
		}
	}

	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			mysqli_query($conn,"update sub_categories set categories_id='$categories',sub_categories='$sub_categories' where id='$id'");
		}else{

			mysqli_query($conn,"insert into sub_categories(categories_id,sub_categories,status) values('$categories','$sub_categories','1')");
		}
		redirect('sub_categories');
		die();
	}
}
?>

        <div class="content">
            <div class="contact">
                <div class="form">
                    <!--login form start-->
                    <form class="login-form" action="manage_sub_categories" method="post">
                        <p>
                        <select name="categories_id" required class="user-input" style="box-sizing: border-box">
    						<option value="">Select Categories</option>
    						<?php
    						$sql=mysqli_query($conn,"SELECT * FROM categories where status='1'");
    						while($row=mysqli_fetch_assoc($sql)){
                                $id = $row["id"];
                                $categories = $row["categories"];
    							if($id==$categories){
    								echo "<option value=".$id." selected>".$categories."</option>";
    							}else{
    								echo "<option value=".$id.">".$categories."</option>";
    							}
    						}
    						?>
    					</select>
                        </p>
                        <p>
                            <input class="user-input" type="text" name="sub_categories" placeholder="Sub category name" required style="box-sizing: border-box" value="<?php echo $sub_categories ?>">
                        </p>
                        <p>
                            <input class="btn" type="submit" name="submit" value="Add Sub Categories">
                        </p>
                        <div class=""><?php echo $msg?></div>
                    </form>

                </div>
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
