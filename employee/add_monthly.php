<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/modal_header.php'); 
$obj=new Queries();
$objTransaction =new Transaction();
$employee_list=$obj->select("alpp_emp"," emp_status=0 order by emp_file",array("*"));


if(isset($_REQUEST['submit']))  /// insert code
{
 //   echo "okay";
    $all_emp_id=$_REQUEST['emp_ids'];
    $all_amount=$_REQUEST['bal'];
    
    $i=0;
    foreach($all_emp_id as $emp_id)
    {
     //   echo $emp_id;
        $all_amount[$i]=str_replace(",", ".",$all_amount[$i]);
        $insert=$objTransaction->InsertTransaction(array(
                        'emp_id'=>$emp_id,
                        'end_month_data'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['end_month_data'])),
                        'amount'=>$all_amount[$i],
                        'trans_type'=>'D',
                        'date'=> date("Y-m-d h:i:s"),
                        'done_by'=>$_SESSION['session_admin_id'],
                        'status'=>0
                    ));

    }               
}
?>

<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Add Manual Balance</h2>
            </div>
            
            
            
           <div class="box-content">
 
<?php
    if($insert)
		{         ?>
                    <div class="widget-body">
                        <div class="alert alert-success">
                                <button class="close" data-dismiss="alert">×</button>
                                <strong>Success!</strong> Balance Detail Submitted.
                        </div>
                    </div>
        <?php     // header('REFRESH:2, url=emp_balance.php?emp_id='.$_REQUEST['emp_id']);
		}
	
      
     ?>
     <form class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">

         <div class="form-group">
                    <label class="control-label col-sm-2">Month</label>
             
                    <div class="col-sm-4">
                        <input type="text" id="datepicker" class="form-control" name="end_month_data" value="<?php echo date('m/d/Y'); ?>">
                    </div>
                        
                    
                    </div>
          
         
            <table class="table table-striped table-bordered bootstrap-datatable datatable responsive">
  
         <thead>
    <tr>
        <th><input type="checkbox" id="toggle" value="select" onClick="do_this()"  /></th>
       <th>Ficha</th>
        <th>Nombre</th>
        <th>FECHA INGRESO</th>
        <th>Feriados Disponibles</th>
        
        <th>Balance</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($employee_list as $employee) {  ?>
        
    <tr>
        <td><input type=checkbox class=selectedId name=emp_ids[] value="<?php echo $employee['emp_id']; ?>"/></td>
        <td><?php echo $employee['emp_file']; ?></td>
        <td><?php echo $employee['emp_name']; ?></td>
        <td><?php echo date("m/d/Y",strtotime($employee['emp_current_contract'])); ?></td>
        <td><?php echo $employee['emp_count']; ?></td>
        
        <td class="center">
            <input type="number" name="bal[]" value="1.25"  >
        </td>
     
        
    </tr>
        <?php 
        $balance = 0;
           } ?>
    
    </tbody>
    </table>
         
         
                  
       <div class="form-group">        
                        <div class="col-sm-offset-4 col-sm-4">
                            <button type="submit" name="submit" class="btn btn-small btn-block btn-error">Save</button>
                         </div>
                    </div>  

         
                    <br>
                </form>

            </div>
        </div>
    </div>
    <!--/span-->

</div><!--/row-->

<?php include('../lib/modal_footer.php'); ?>

  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  $(function() {
    $( "#datepicker" ).datepicker();
  });
  </script>
  <?php
 function lastOfMonth()  
 {  
      return date("m/d/Y", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));  
 } 
 ?>
<script type="text/javascript">

    function do_this(){

        var checkboxes = document.getElementsByName('emp_ids[]');
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