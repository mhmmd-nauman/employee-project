<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objTransaction =new Transaction();
$objEmployee =new Employee();
$employee_list=$objEmployee->GetAllEmployee(" emp_status=0 order by emp_name ",array("*"));
?>
<link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<script>
    $(document).ready(function(){
            $(".change_pass").colorbox({iframe:true, width:"40%", height:"70%"});
    });
</script>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i> Report</h2>
            </div>         
    <div class="box-content">    
    
        <br>
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
        <thead>
        <tr>
            <th>Ficha</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Password</th>
            <th>Action</th>
        </tr>
        </thead>
    <tbody>
        <?php foreach($employee_list as $employee) { ?>      
        <tr>
            <td><?php echo $employee['emp_file']; ?></td>
            <td><?php echo $employee['emp_name']; ?></td>
            <td><?php echo $employee['emp_email']; ?></td>
            <td><?php echo $employee['emp_password'];?></td>
            <td>
                <a class="btn btn-info btn-sm change_pass" href="<?php echo SITE_ADDRESS; ?>employee/set_password.php?id=<?php echo $employee['emp_id']; ?>">
                    <i class="glyphicon glyphicon-edit icon-white"></i>
                </a>
            </td>
        </tr>
        <?php 
        $balance = 0;
           } ?>
    </tbody>
    </table>
            </div>
        </div>
    </div>
</div>
<?php include('../lib/footer.php'); ?>