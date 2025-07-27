<?php
// require top
require('top.php');

$obj->isAdmin();
?>

<?php
$categories='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$id = clean($conn,$_GET['id']);
	$sql = mysqli_query($conn,"SELECT * FROM categories WHERE id='$id'");
	$check = mysqli_num_rows($sql);
	if($check>0){
		$row = mysqli_fetch_assoc($sql);
		$categories = $row['categories'];
	}else{
		header('location:categories');
		die();
	}
}

if(isset($_POST['submit'])){
	$categories = clean($conn,$_POST['categories']);
	$sql=mysqli_query($conn,"SELECT * FROM categories WHERE categories='$categories'");
	$check=mysqli_num_rows($sql);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData = mysqli_fetch_assoc($sql);
			if($id == $getData['id']){

			}else{
				$msg="Categories already exist";
			}
		}else{
			$msg="Categories already exist";
		}
	}

	if($msg==''){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$id = clean($_GET['id']);
			mysqli_query($conn,"UPDATE categories SET categories='$categories' WHERE id='$id'");
		}else{
			mysqli_query($conn,"INSERT INTO categories(categories,status) VALUES('$categories','1')");
		}
		header('location:categories');
		die();
	}
}

?>

    <div class="content">
                  <!--form area start-->
        	    
        			<form class="login-form" action="manage_categories" method="POST">
        			    <p>
        			        <input class="user-input" type="text" name="categories" placeholder="Enter category name" required style="box-sizing: border-box" value="<?php echo $categories ?>">
        			    </p>
        				<p>
        				    <input class="button-submit" type="submit" name="submit" value="Add category" >
        				</p>
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
