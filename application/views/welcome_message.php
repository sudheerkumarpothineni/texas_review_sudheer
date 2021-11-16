<!DOCTYPE html>
<html lang="en">
<head>
  <title>Customer Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h2 class="text-center">Customer Details</h2>
  <button type="button" class="btn btn-info" id="add_button">Add Customer</button>
  <table class="table">
    <thead>
      <tr>
        <th>S.No</th>
        <th>Customer Name</th>
        <th>Address</th>
        <th>Postal Code</th>
        <th>Order Quantity</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    	
    </tbody>
  </table>
</div>

<!-- Users Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
   <form id="user_form" method="POST" enctype="multipart/form-data">
    <div class="modal-content">
      <div class="modal-header">
        <span id="success_message"></span>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body row">
          <div class="form-group col-sm-4">
            <label>Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control">
            <div id="customer_name_error" class="text-danger"></div>
          </div>
          <div class="form-group col-sm-4">
            <label>Address</label>
            <input type="text" name="address" id="address" class="form-control">
            <span id="address_error" class="text-danger"></span>
          </div>
          <div class="form-group col-sm-4">
            <label>City</label>
            <input type="text" name="city" id="city" class="form-control">
          </div>
          <div class="form-group col-sm-4">
            <label>Postalcode</label>
            <input type="text" name="postalcode" id="postalcode" class="form-control">
            <span id="postalcode_error" class="text-danger"></span>
          </div>
          <div class="form-group col-sm-4">
            <label>Order Quantity</label>
            <input type="text" name="order_quantity" id="order_quantity" class="form-control">
            <span id="order_quantity_error" class="text-danger"></span>
          </div>
          <div class="form-group col-sm-4">
            <label>Trade Mark</label>
            <input type="text" name="trade_mark" id="trade_mark" class="form-control">
          </div>
        </div>
      <div class="modal-footer">
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="data_action" id="data_action" value="Insert">
        <input type="submit" name="action" id="action" value="Add" class="btn btn-success">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
   </form>

  </div>
</div>
</body>
</html>

<script type="text/javascript">
  $(document).ready(function(){


//To fetch all users
    function fetch_all(){
      $.ajax({
        url:'<?php echo base_url()?>index.php/welcome/action',
        method:'POST',
        data:{'data_action':'fetch_all'},
        success:function(data){
          $('tbody').html(data);
        }
      });
    }

    fetch_all();


    //Add Button
    $(document).on('click','#add_button',function(){
      $('#user_form')[0].reset();
      $('.modal-title').text('Add Customer');
      $('#data_action').val('Insert');
      $('#action').val('Add');
      $('#success_message').html('');
      $('#id').val('');
      $('#myModal').modal('show');
    });

    // Insert & Update
    $(document).on('submit','#user_form',function(event){
      event.preventDefault();
      $.ajax({
        url:'<?php echo base_url()?>index.php/welcome/action',
        method:'POST',
        data:new FormData(this),
        dataType:'json',
        contentType: false,
        cache: false,
        processData:false,
        success:function(data){
          if(data.success) {
            $('#user_form')[0].reset();
            $('#myModal').modal('show');
              $('#success_message').html('<div class="alert alert-success">'+data.msg+'</div>');
              $('#myModal').delay(3000).modal('hide');
              fetch_all();
          } 
          if(data.error) {
            $('#customer_name_error').html(data.customer_name_error);
            $('#address_error').html(data.address_error);
            $('#postalcode_error').html(data.postalcode_error);
          }
        }
      });
    });

    //Fetch Single User Data
    $(document).on('click','.edit',function(){
      var origin = $(this).attr('id');
      console.log(origin);
      $.ajax({
          url:'<?php echo base_url()?>index.php/welcome/action',
          method:'POST',
          data:{origin:origin,data_action:'fetch_single_user_data'},
          dataType:'json',
          success:function(data){
            console.log(data);
          $('#myModal').modal('show');
          $('.modal-title').text('Edit Customer');
          $('#data_action').val('Update');
          $('#action').val('Edit');
          $('#success_message').html('');
          $('#id').val(data.id);
          $('#customer_name').val(data.customer_name);
          $('#address').val(data.address);
          $('#postalcode').val(data.postalcode);
          $('#order_quantity').val(data.order_quantity);
          $('#city').val(data.city);
          $('#trade_mark').val(data.trade_mark);
        }
      });
    });

    // Delete
    $(document).on('click','.delete',function(){
      var origin = $(this).attr('id');
      console.log(origin);
      if (confirm("Are You Sure You Want To Delete This ? ")) {
        $.ajax({
            url:'<?php echo base_url()?>index.php/welcome/action',
            method:'POST',
            data:{origin:origin,data_action:'Delete'},
            dataType:'json',
            success:function(data){
              if (data.success) {
              	fetch_all();
              }
            }
        });
      }
    });
  });
</script>
