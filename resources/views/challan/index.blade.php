@extends('layout.master')
@section('content')
	<table class="table table-bordered table-hover">
	<thead>
	<th>Product ID</th>
	<th>Product Name</th>
	<th>Product Price</th>
	<th>Product Qty</th>
	<th>Product Model</th>
	<th>Action</th>
	</thead>
	<tbody>
	<?php foreach ($data as $row){
	?>	
	<tr>
	<td><?php echo $row->id ?></td>
	<td><?php echo $row->product_name ?></td>
	<td><?php echo $row->product_price ?></td>
	<td><?php echo $row->product_qty ?></td>
	<td><?php echo $row->product_model ?></td>
	<td>
		<a href="<?php echo 'EditProduct/'.$row->id ?>">Edit</a> |
		<a href="<?php echo 'DeleteProduct/'.$row->id ?>">Delete</a>
	</td>
	</tr>
	
	<?php } ?>
	</tbody>
	</table>


@stop()