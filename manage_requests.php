<?php 
include (dirname(__FILE__).'/lib/include.php');
include (dirname(__FILE__).'/lib/header.php'); 
$obj=new Queries();

$list=$obj->select("alpp_leave join alpp_emp on alpp_emp.emp_id=alpp_leave.leave_emp_id "," leave_approval!=2  order by emp_file ",array("*")); 

if(isset($_REQUEST['submit']))  /// insert code
{
    $all_leave_id =   $_REQUEST['leave_ids'];
    $status     =   $_REQUEST['status'];
    
    foreach($all_leave_id as $leave_id)
    {
        if($status==1 || $status==2)    // cancel | Approve
        { 
            $action=$obj->Update("alpp_leave",'leave_id='.$leave_id , array('leave_approval'=>$status));
        } 
        else if($status==3) // delete
        { 
            $action = $obj->Delete("alpp_leave",'leave_id='.$leave_id);
        }
    }
        if($action)
	{        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong>". ($status==3) ? 'Record Deleted' : 'Status Updated' ;;
            header('REFRESH:4, url='.SITE_ADDRESS.'manage_requests.php');
	}               
}
?>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Leave Requests</h2>
                <div class="box-icon">
                    <a href="#" class="btn btn-minimize btn-round btn-default"><i class="glyphicon glyphicon-chevron-up"></i></a>
                    <a href="#" class="btn btn-close btn-round btn-default"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </div>
            
            <div class="box-content" >
     <br>
    <form class="form-horizontal" role="form"  method="post" >
        
        <div class="form-group">
            <label class="control-label col-sm-2" style=" text-align: left;">Checked Status<br><em style="font-size: 9px">Applied on checked records only</em></label>
            <div class="col-sm-4" style=" align: left;">          
                <select name="status" required="" class="form-control">
                    <option value="">Select</option>
                    <option value="2">Approve</option>
                    <option value="1">Cancel</option>
                    <option value="2">Delete</option>
                </select>
            </div>
             <div class="col-sm-4"> 
                <button type="submit" name="submit" class="btn btn-small btn-success">Update Status</button>
             </div>
        </div>
        <br>
<table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
   <thead>
    <tr>
        <th><input type="checkbox" id="toggle" value="select" onClick="do_this()"  /></th>
       <th>Ficha</th>
       <th>Nombre</th>
       <th>Days</th>
       <th>Duration</th>
       <th>Type</th>
       <th>Status</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($list as $request) {  ?>
    <tr>
        <td  style=" width: 5%;"><input type=checkbox class=selectedId name=leave_ids[] value="<?php echo $request['leave_id']; ?>"/></td>
        <td><?php echo $request['emp_file']; ?></td>
        <td><?php echo $request['emp_name']; ?></td>
         <td><?php echo $request['leave_duration']; ?></td>
        <td>
        <?php   $from=$to='';
                    if($request['leave_duration_from'])
                    {
                               $from = new DateTime($request['leave_duration_from']);
                               echo  $from = $from->format("d-m-Y");

                            if($request['leave_duration_to'])
                            {
                                        echo "  -  "; 
                                        $to = new DateTime($request['leave_duration_to']);
                                       echo $to = $to->format("d-m-Y");
                            }
                    }
        ?>
        </td> 

        <td><?php if($request['leave_balance_type']=='D') echo "DIAS PROGRESIVOS";
                        else if($leave['leave_balance_type']=='I') echo "FERIADO LEGAL";
                        else echo "";
                  ?>
              </td>
        <?php	
        if($request['leave_approval']==0)       echo"<td class='hidden-phone '><span class='label label-danger'>Pending</span></td>";
        else if($request['leave_approval']==2)	echo"<td class='hidden-phone '><span class='label label-success'>Approved</span></td>";
        else if($request['leave_approval']==1)  echo"<td class='hidden-phone '><span class='label label-small label-danger'>Cancelled </span></td>";?>
    </tr>
        <?php        } ?>
    
    </tbody>
    </table>
                  
   
     <br>
                </form>
            </div>
        </div>
    </div>
</div><!--/row-->

<?php include('lib/footer.php'); ?>
<script type="text/javascript">

    function do_this(){

        var checkboxes = document.getElementsByName('leave_ids[]');
        var button = document.getElementById('toggle');

        if(button.value == 'select'){
            for (var i in checkboxes){
                checkboxes[i].checked = 'FALSE';
            }
            button.value = 'deselect'
        }else{
            for (var i in checkboxes){
                checkboxes[i].checked = '';
            }
            button.value = 'select';
        }
    }
</script>