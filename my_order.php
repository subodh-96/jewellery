<?php include 'admin/db_connect.php' ?>
<head>  
  <title>Webslesson Tutorial | Bootstrap Modal with Dynamic MySQL Data using Ajax & PHP</title>  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
  <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>   -->
 </head>  

<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-body">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Date Ordered</th>
						<th class="text-center">Order Code</th>
						<th class="text-center">Delivery Address</th>
						<th class="text-center">Status</th>
						<th class="text-center">Action</th>
						<th class="text-center">Change Address</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					$query = $conn->query("SELECT * FROM orders where user_id = '{$_SESSION['login_id']}' order by unix_timestamp(date_created)");
					while($row= $query->fetch_assoc()):
					?>
					<tr>
						<td class="text-center"><?php echo $i++ ?></td>
						<td class=""><?php echo date("M d, Y",strtotime($row['date_created'])) ?></td>
						<td class=""><?php echo $row['ref_id'] ?></td>
						<td class=""><?php echo $row['delivery_address'] ?></td>
						<td class="text-center">
							<?php if($row['status'] == 0): ?>
								<span class="badge badge-secondary">Pending</span>
							<?php elseif($row['status'] == 1): ?>
								<span class="badge badge-primary">Verified</span>
							<?php elseif($row['status'] == 2): ?>
								<span class="badge badge-info">Shipped</span>
							<?php elseif($row['status'] == 3): ?>
								<span class="badge badge-success">Delivered</span>
							<?php else: ?>
								<span class="badge badge-danger">Cancelled</span>
							<?php endif; ?>
						</td>
						<td class="text-center">
		                    <a href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-code="<?php echo $row['ref_id'] ?>" class="btn btn-primary btn-flat view_order">
		                          <i class="fas fa-eye"></i>View Order
	                        </a>
						</td>
						<form action="" method="post" enctype="multipart/form-data">
							<td class="text-center"><button type="button" class="btn btn-primary" id="save" name="name" data-toggle="modal" data-target="#myModal">Change Address</button></td>
						</form>
					</tr>
					<?php endwhile; ?>
				</tbody>
				
			</table>
		</div>
	</div>
</div>







 <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Tongue Twister</button><br><br><br> -->
 <!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <!-- <h4 class="modal-title" id="myModalLabel">Change Address</h4> -->
  </div>
  <div class="modal-body">
    <form method = "POST">
        <div class="form-group">
            
            <script type="text/javascript">
            $(document).ready(function() {
            $(window).keydown(function(event){
            if(event.keyCode == 13) {
            event.preventDefault();
            return false;
            }
            });
            });
            </script>
        </div>
        <div class="form-group">
            <textarea id="w3review" name="w3review" rows="4" cols="50"></textarea>
        </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary" name="save">Save changes</button>
    
	
	
	<?php if(isset($_POST['save']))
    {	
		$data = $_POST['w3review'];
		$dadd =$_SESSION['login_id'];
		
		echo "<script>alert('$data			$dadd');</script>";
      	$sql = "UPDATE orders SET delivery_address = $data WHERE user_id = $dadd";
      	mysqli_query($conn, $sql);
		$conn->query($sql);
		
     
    } 
    ?>



  </div>
  </form>
</div>
<script>
	$(document).ready(function(){
		$('table').dataTable()
		$('.view_order').click(function(){
			uni_modal("My Order "+$(this).attr('data-code'),"view_order.php?id="+$(this).attr('data-id'),"large")
		})
	})
</script>