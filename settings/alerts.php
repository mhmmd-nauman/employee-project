<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objAlertSystem =new AlertSystem();
$alert_list     =  $objAlertSystem->GetAllAlertSystem("1 order by title",array("*"));
if(isset($_REQUEST['postback'])){
    
    $objAlertSystem->UpdateAlertSystem( " 1 ",
                            array(
                                "status"=>0
                                )
                            );
    
    foreach($_REQUEST['alert'] as $id){
            // check if it already in
            $permission_group_exist     =  $objAlertSystem->GetAllAlertSystem("  id = $id ",array("*"));
            if($permission_group_exist[0]['id']){
                    $objAlertSystem->UpdateAlertSystem("id=$id",array(
                    "status"=>1
                    ));
            }else{
                // else insert
                $objAlertSystem->InsertAlertSystem(array(
                    "id"=>$id,
                    //"date" => date("Y-m-d"),
                    "status"=>1
                    ));
            }
        }
    
    ?>
    
    <div class="widget-body">
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Updated System Alerts.
        </div>
    </div> 
<?php
}
$alert_group_list     =  $objAlertSystem->GetAllAlertSystem(" status = 1 ",array("*"));
//echo "<pre>";
//print_r($alert_group_list);
//echo "</pre>";
foreach($alert_group_list as $row){
    $group_per_data[$row['id']] = $row['id'];
}
//echo "<pre>";
//print_r($group_per_data);
//echo "</pre>";
if(isset($_REQUEST['del']))	
{	
   //$del = $objHoliday->DeleteHoliday($_REQUEST['del']);
    if($del)
    {   ?>
     <div class="widget-body">
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Record Deleted.
        </div>
     </div>
     <?php  //header('refresh:1, url=holidays_list.php');
    }
}
?>
<script>
    $(document).ready(function(){
            $(".add_holiday").colorbox({iframe:true, width:"50%", height:"80%"});
    });
</script>

 <link href="<?php echo SITE_ADDRESS; ?>bower_components/datatables/media/css/demo_table_1.css" rel="stylesheet">
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i>System Alerts</h2>
            </div>
            
    <div class="box-content">
        <form action="?postback=1" class="form-horizontal" role="form"  method="post">    
    <table class="table table-striped table-bordered  responsive" style="font-size: 12px;">
  
         <thead>
    <tr>
        <th style=" width: 90%">Alert Type</th>
        <th style="text-align: center;">Enable/Disable</th>
        
    </tr>
    </thead>
    <tbody>
    <?php foreach($alert_list as $alert) {  ?>   
    <tr>
        <td><?php echo $alert['title'];?></td>
        <td style="text-align: center;">
            <input type="checkbox" <?php if(in_array($alert['id'], $group_per_data))echo"checked";?> value="<?php echo $alert['id'];?>" name="alert[]">
        </td>
        
    </tr>
    <?php } ?>
      
    <tr>
        <td>
            &nbsp;
        </td>
        <td  style="text-align: center;">
             <button type="submit" name="submit" class="btn btn-block btn-info">Save</button>
        </td>
        
    </tr>
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