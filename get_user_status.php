<?php
session_start();
include('storescripts/connect_to_mysql.php');

//$uid=$_SESSION['UID'];
$time=time();
$user_sql="SELECT DISTINCT * FROM users GROUP BY id ORDER BY id DESC";
$user_sql=mysqli_query($conn,$user_sql) or die (mysqli_error($conn));
$i=1;
$html='';
    while($row=mysqli_fetch_assoc($user_sql)){
    	$status='Offline';
    	$color="red";
    	if($row['last_login']>$time){
    		$status='Online';
    		$color="green";
    	}
    	$html.='<tr>
    	 		          <td><a href="'.SITE_PATH.'users_master_details?id='.$row['id'].'">'.$row['id'].'</a></td>
    	 		          
    	 		          <td>'.$row['firstname'].'</td>
    	 		          <td >'.$row['email'].'</td>
    	 		          <td>'.$row['added_on'].'</td>
    	 		          <td><span class="status" style="background: '.$color.'; color: #fff">'.$status.'</span></td>
    	 		          <td>
    	 		          
    	 		          <span class="badge badge-delete"><a href="?type=delete&id='.$row['id'].'"><i class="fas fa-trash-alt"></i>Delete</a></span>  
    	 		          </td>
    	 		          
     	       </tr>';
    $i++;
    } 
echo $html;
?>