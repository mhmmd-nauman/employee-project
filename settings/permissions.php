<?php 
include (dirname(__FILE__).'/../lib/include.php');
include (dirname(__FILE__).'/../lib/header.php'); 
$objPermission =new Permission();
$permission_list     =  $objPermission->GetAllPermissions("1 order by title",array("*"));
if(isset($_REQUEST['postback'])){
    //echo "<pre>";
    //print_r($_REQUEST['permision']);
    //echo "</pre>";
    $objPermission->UpdateGroupPermission( " 1 ",
                            array(
                                "status"=>0
                                )
                            );
    foreach($_REQUEST['permision'] as $group_id => $assigned_array){
        foreach($assigned_array as $per_id){
            // check if it already in
            $permission_group_exist     =  $objPermission->GetAllGroupPermissions(" group_id = $group_id and per_id = $per_id ",array("*"));
            if($permission_group_exist[0]['id']){
                    $objPermission->UpdateGroupPermission( "group_id = $group_id and per_id = $per_id",
                            array(
                                "date" => date("Y-m-d"),
                                "status"=>1
                                )
                            );
            }else{
                // else insert
                $objPermission->InsertUserPermission(array("group_id"=>$group_id,
                    "per_id"=>$per_id,
                    "date" => date("Y-m-d"),
                    "status"=>1
                    ));
            }
        }
    }
    ?>
    
    <div class="widget-body">
        <div class="alert alert-success">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> Updated Permissions.
        </div>
    </div> 
<?php
}
$permission_group_list     =  $objPermission->GetAllGroupPermissions(" status = 1 ",array("*"));
//echo "<pre>";
//print_r($permission_group_list);
//echo "</pre>";
foreach($permission_group_list as $row){
    $group_per_data[$row['group_id']][] = $row['per_id'];
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
                <h2><i class="glyphicon glyphicon-star-empty"></i>PREMISOLOGÍA</h2>
            </div>
            
    <div class="box-content">
        <form action="?postback=1" class="form-horizontal" role="form"  method="post">    
    <table class="table table-striped table-bordered  responsive" style="font-size: 12px;">
  
         <thead>
    <tr>
        <th>Title</th>
        <th style="text-align: center;">EMPLOYEE</th>
        <th style="text-align: center;">SUPERVISOR</th>
        <th style="text-align: center;">ADMINISTRATOR</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($permission_list as $permission) {  ?>
        
    <tr>
        <td><?php echo $permission['title']; ?></td>
        <td style="text-align: center;">
            <input type="checkbox" <?php if(in_array($permission['id'], $group_per_data[2]))echo"checked";?> value="<?php echo $permission['id'];?>" name="permision[2][]">
        </td>
        <td style="text-align: center;">
            <input type="checkbox" <?php if(in_array($permission['id'], $group_per_data[3]))echo"checked";?> value="<?php echo $permission['id'];?>" name="permision[3][]">
        </td>
        <td class="center" style="text-align: center;">
            <input type="checkbox" <?php if(in_array($permission['id'], $group_per_data[1]))echo"checked";?> value="<?php echo $permission['id'];?>" name="permision[1][]">
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
        <td colspan="2">
            &nbsp;
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