<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objHoliday =new Holiday();
$holiday_list     =  $objHoliday->GetAllHoliday("1 order by title",array("*"));
if(isset($_REQUEST['del']))	
{	
   $del = $objHoliday->DeleteHoliday($_REQUEST['del']);
    if($del)
    {   ?>
     <div class="widget-body">
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Record Deleted.
        </div>
     </div>
     <?php  header('refresh:1, url=holidays_list.php');
    }
}
?>
<script>
    $(document).ready(function(){
            $(".add_holiday").colorbox({iframe:true, width:"40%", height:"60%"});
    });
</script>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>Holiday List</h2>
            </div>
            
    <div class="box-content">
    <table class="table table-striped table-bordered bootstrap-datatable datatable responsive" style="font-size: 12px;">
  
         <thead>
    <tr>
        <th>Title</th>
        <th>Type</th>
        <th>Date</th>
        <th width="20%">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($holiday_list as $holiday) {  ?>
        
    <tr>
        <td><?php echo $holiday['title']; ?></td>
        <td><?php echo $holiday['type']; ?></td>
        <td><?php echo $holiday['date']; ?></td>
        <td class="center">            
            <a class="btn btn-info btn-sm add_holiday" href="add_holiday.php?update=<?php echo $holiday['id']; ?>">
               <i class="glyphicon glyphicon-edit icon-white"></i>
            </a>
            <a class="btn btn-danger btn-sm" onclick="return confirmation();" href="holidays_list.php?del=<?php echo $holiday['id']; ?>">
             <i class="glyphicon glyphicon-trash icon-white"></i>
            </a>
        </td>
    </tr>
        <?php } ?>
    
    </tbody>
    </table>
    </div>
    </div>
    </div>
    <!--/span-->

    </div><!--/row-->


<?php include('../lib/footer.php'); ?>
    <script>
    function confirmation() {
        var answer = confirm("Do you want to delete this record?");
    if(answer){
            return true;
    }else{
            return false;
    }
}
</script>