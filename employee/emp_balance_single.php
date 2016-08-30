<?php 
include (dirname(__FILE__).'/../lib/include.php');
include('../lib/modal_header.php');

$objTransaction =new Transaction();
$objEmployee =new Employee();
$emp_list = $objEmployee->GetAllEmployee("emp_status = 0",array("*"));

switch ($_REQUEST['postback']){
    case 1:
        $balance=0.00;
        $balance = $objTransaction->GetEmpBalance($_REQUEST['emp_id']);
        $balance_detail= $objTransaction->GetEmpBalanceDetail($_REQUEST['emp_id']);
        $emp_data = $objEmployee->GetAllEmployee("emp_id = ".$_REQUEST['emp_id'],array("*"));
        $trasanction_list=$objTransaction->GetBalanceDetail("alpp_transactions.emp_id = ".$_REQUEST['emp_id']."");
        break;
    case 2:
        $_REQUEST['amount']=str_replace(",", ".", $_REQUEST['amount']);
        if(isset($_REQUEST['update_button']))  // update code
        {
            $emp_id=$_REQUEST['emp_id'];

            $updated=$objTransaction->UpdateTransaction("id=".$_REQUEST['id'],array(
                        'end_month_data'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['end_month_data'])),
                        'amount'=>$_REQUEST['amount'],
                        'trans_type'=>$_REQUEST['trans_type'],
                        'date'=> date("Y-m-d h:i:s"),
                        'done_by'=>$_SESSION['session_admin_id'],
                        'status'=>$_REQUEST['status']
                    ));

        } else {
            $insert=$objTransaction->InsertTransaction(array(
                    'emp_id'=>$_REQUEST['emp_id'],
                    'end_month_data'=>date("Y-m-d h:i:s",  strtotime($_REQUEST['end_month_data'])),
                    'amount'=>$_REQUEST['amount'],
                    'trans_type'=>$_REQUEST['trans_type'],
                    'date'=> date("Y-m-d h:i:s"),
                    'done_by'=>$_SESSION['session_admin_id'],
                    'status'=>$_REQUEST['status']
                ));
        }
        $message_type="alert-success"; 
        $message_text = "<strong>Success!</strong> Balance Updated.";
        header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance_single.php?emp_id='.$_REQUEST['emp_id']."&postback=1");
    break;
    case 3:
        // del the balance
        $id = $_REQUEST['del'];
	$del = $objTransaction->DeleteTransantion($id);
	
        if($del)
	{        
            $message_type="alert-success"; 
            $message_text = "<strong>Success!</strong> Transaction Deleted.";
            header('REFRESH:2, url='.SITE_ADDRESS.'employee/emp_balance_single.php?postback=1&activetab=0&emp_id='.$_REQUEST['emp_id']);
	}
        break;
    case 4:
        //echo " load the edit screen";
        $obj=new Queries();
        $id = $_REQUEST['update'];
        $transaction=$obj->select("alpp_transactions","id=$id ",array("*"));
        
        $balance=0.00;
        $balance = $objTransaction->GetEmpBalance($_REQUEST['emp_id']);
        $balance_detail= $objTransaction->GetEmpBalanceDetail($_REQUEST['emp_id']);
        $emp_data = $objEmployee->GetAllEmployee("emp_id = ".$_REQUEST['emp_id'],array("*"));
        $trasanction_list=$objTransaction->GetBalanceDetail("alpp_transactions.emp_id = ".$_REQUEST['emp_id']."");
        break;
    default :
        $trasanction_list=$objTransaction->GetBalanceDetail("alpp_transactions.emp_id = ".$_REQUEST['emp_id']."");
}


?>


<?php if($message_type){ ?>
     <div class="widget-body">
        <div class="alert <?php echo $message_type;?>">
                <button class="close" data-dismiss="alert">×</button>
                <?php echo $message_text;?>
        </div>
    </div>
<?php 
//exit;
}?>
<div class="row">
    <div class="box col-md-12">
        <div class="box-inner">
            <div class="box-header well" data-original-title="">
                <h2><i class="glyphicon glyphicon-star-empty"></i><?php echo $emp_data[0]['emp_file']." - ".$emp_data[0]['emp_name'];?>  - Modificar saldos</h2>
            </div>
<?php if(!isset($_REQUEST['postback'])){ ?>            
<form action="?postback=1" class="form-horizontal" role="form"  method="post" >
<div class="box-content">
   <div class="row">
            <div class="col-md-12">
                <div class="ui-widget" style="text-align:center; padding: 10px; width: 90%;">
                    <label>Select/Type Ficha or Employee Name:</label>
                    <select id="combobox" name="emp_id"   >
                        <option value="">Select one...</option>
                        <?php   foreach ($emp_list as $emp_row){?>
                        <option value="<?php echo $emp_row['emp_id'];?>"><?php echo $emp_row['emp_file']." - ".$emp_row['emp_name'];?></option>
                        <?php } ?>
                        
                </select>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" name="submit" class="btn  btn-info">Load</button>
                </div>
            </div>
            </div>
            
    </div>
 </form>
<?php } else{ ?>
            <table class="table table-striped table-bordered" >
                <tr>
                    <th>Feriado Legal</th><td style=" background-color: #FFFFFF"><?php echo $balance_detail['F']-$balance_detail['leavesI'];?></th>
                    <th>Dias Progresivos</th><td style=" background-color: #FFFFFF"><?php echo $balance_detail['D']-$balance_detail['leavesD'];?></th>
                </tr>
            </table>
             <div id="accordion">
                 <h3>Modificar saldos</h3>
                <div>
                    <table class="table table-striped table-bordered   responsive" style=" font-size: 12px;" >
                    <thead>
                    <tr>
                <!--        <th>ID</th>-->
                        <th style=" width: 10%;">Fecha</th>


                        <th>Observación</th>

                <!--        <th>Data Added</th>-->
                        <th>N° de Días</th>
                        <th>Estatus</th>
                <?php if($_SESSION['session_admin_role']=='admin') { ?>
                        <th style=" width: 14%;">Acciones</th>
                <?php } ?>   
                    </tr>
                    </thead>
                    <tbody>
                        <?php 
                        foreach($trasanction_list as $trasanction) { 
                            $trasanction_list_temp[$trasanction['id']] = $trasanction;
                        }
                        ksort($trasanction_list_temp);
                        $trasanction_list_temp = array_reverse($trasanction_list_temp);

                        $trasanction_list = $trasanction_list_temp;
                        foreach($trasanction_list as $trasanction) {   ?>

                    <tr>
                <!--        <td><?php //echo $trasanction['id']; ?></td>-->
                        <td><?php echo date("d-m-Y",strtotime($trasanction['entered_on_date'])); ?></td>

                            <?php
                            switch($trasanction['trans_type']) {
                                case"M":
                                    echo "<td>Manual</td>";
                                    break;
                                case"C":
                                    echo "<td>Auto System Added</td>";
                                    break;
                                case"F":
                                    echo "<td>FERIADO LEGAL</td>";
                                    break;
                                case"D":
                                    echo "<td>DIAS PROGRESIVOS</td>";
                                    break;
                                case"L":
                                    echo "<td>Leave -  (";
                                    if($trasanction['leave_type']=='D') echo "DIAS PROGRESIVOS";
                                        else if($trasanction['leave_type']=='F') echo "FERIADO LEGAL";
                                        else echo "";

                                        echo")</td>";
                                    break;
                            }?></td>
                <!--        <td><?php //echo date("m/d/Y",strtotime($trasanction['entry_date'])); ?></td>-->
                        <td><?php echo $trasanction['days']; ?></td>
                        <td class="center">
                           <?php if($trasanction['status']==0 && $trasanction['trans_type'] !='L') { ?>
                            <span class="label-success label label-default">Active</span>
                           <?php } 
                            if($trasanction['status']==0 && $trasanction['trans_type'] =='L')       echo"<span class='label label-danger'>Pending</span>";
                            else if($trasanction['status']==2 && $trasanction['trans_type'] =='L')	echo"<span class='label label-success'>Approved</span>";
                            else if($trasanction['status']==1 && $trasanction['trans_type'] =='L')  echo"<span class='label label-small label-danger'>Cancelled </span>";
                        ?>
                        </td>
                        <?php if($_SESSION['session_admin_role']=='admin') { ?>    
                        <td class="center">
                            <?php if($trasanction['trans_type'] !="L"){?>
                            <a class="  btn-sm add_balance " href="?postback=4&activetab=1&update=<?php echo $trasanction['id']; ?>&emp_id=<?php echo $trasanction['emp_id']; ?>">
                                <i class="glyphicon glyphicon-edit"></i>&nbsp;Edit
                            </a>
                            <a onclick="return confirmation();" class="" href="?postback=3&del=<?php echo $trasanction['id']; ?>&emp_id=<?php echo $trasanction['emp_id']; ?>">
                                <i class="glyphicon glyphicon-trash"></i>&nbsp;Delete
                            </a>
                            <?php }?>
                        </td>
                        <?php }?>    </tr>
                <?php } ?>

                    </tbody>
                    </table>

                </div>
                <h3>
                    <?php if($transaction[0]['id'] > 0){?>
                        Añadir Manual de Balanza
                    <?php } else {?>
                        Añadir Manual de Balanza
                    <?php } ?>
                </h3>
                <div>
                  <p>
                  <form action="?postback=2" class="form-horizontal" role="form"  method="post" enctype="multipart/form-data">
                                <input type="hidden" value="<?php echo $transaction[0]['id'];?>" name="id">
                                <input type="hidden" value="<?php echo $_REQUEST['emp_id'];?>" name="emp_id">
                                           <div class="form-group">

                                               <label class="control-label col-sm-2">N° de Días</label>
                                               <div class="col-sm-4">          
                                                   <input type="text" class="form-control" value="<?php echo $transaction[0]['amount']; ?>" placeholder="N° de Días" name="amount">
                                               </div>
                                           <label class="control-label col-sm-2">Fecha</label>
                                           <div class="col-sm-4">
                                               <?php
                                                $end_month_data=date("d-m-Y",strtotime($transaction[0]['end_month_data']));
                                               if(empty($end_month_data) || $end_month_data == "01-01-1970" || $end_month_data == "31-12-1969" ){
                                                   //$end_month_data = lastOfMonth();
                                                   $end_month_data = date("d-m-Y");
                                               }
                                               ?>
                                               <input type="text" id="datepicker" class="form-control" value="<?php echo $end_month_data;?>" placeholder="" name="end_month_data">
                                           </div>


                                           </div>
                                 <div class="form-group">
                                     <label class="control-label col-sm-2">Tipo</label>
                                     <div class="col-sm-4">
                                         <select name="trans_type" class="form-control" >
                       <!--                      <option value="M" <?php //if($transaction[0]['trans_type']=='M')echo"selected";?>>Manual</option>
                                             <option value="C" <?php //if($transaction[0]['trans_type']=='C')echo"selected";?>>Auto System Added</option>-->
                                             <option value="D" <?php if($transaction[0]['trans_type']=='D')echo"selected";?>>DIAS PROGRESIVOS</option>
                                             <option value="F" <?php if($transaction[0]['trans_type']=='F')echo"selected";?>>FERIADO LEGAL</option>

                                         </select>
                                     </div>
                                     <label class="control-label col-sm-2">Estatus</label>                     
                                               <div class="col-sm-4">
                                               <?php if($transaction[0]['status']==0) 
                                               {   ?>
                                                               <input type="radio" name="status" value="0" checked />Active
                                                               <input type="radio" name="status" value="1"  />Disabled
                                               <?php    } else { ?> 

                                                                        <input type="radio" name="status" value="0"  />Active
                                                                        <input type="radio" name="status" value="1"  checked />Disabled
                                               <?php     } ?> 

                                               </div>
                                 </div>

                       <?php  if(isset($_REQUEST['update']))	{  ?>
                              <div class="form-group">        
                                               <div class="col-sm-offset-4 col-sm-4">
                                                   <button type="submit" name="update_button" class="btn btn-small btn-block btn-info">Guardar</button>
                                                </div>
                                           </div>  
                       <?php } else {     ?>         
                              <div class="form-group">        
                                               <div class="col-sm-offset-4 col-sm-4">
                                                   <button type="submit" name="submit" class="btn btn-small btn-block btn-info">Guardar</button>
                                                </div>
                                           </div>  

                       <?php }?>
      
                        <br>
                    </form>
                  </p>
                </div>
                
                
              </div>
              
            <br><br>
            
<?php }?>
</div>
</div>
<!--/span-->

    </div><!--/row-->


 <script>
  var active_tab=<?php echo (int)$_REQUEST['activetab'];?>;
  $(function() {
    $( "#accordion" ).accordion({
      heightStyle: "content",
      active: active_tab
    });
  });
 </script>
<?php include('../lib/modal_footer.php'); ?>
<script>
    function confirmation() {
        var answer = confirm("Do you want to delete this record?");
    if(answer){
            return true;
    }else{
            return false;
    }
}
$(".add_balance").colorbox({iframe:true, width:"50%", height:"90%"});
</script>
<link href="../bower_components/lookups/css/base/jquery-ui-1.9.2.custom.css" rel="stylesheet">
<script src="../bower_components/lookups/js/jquery-1.8.3.js"></script>
<script src="../bower_components/lookups/js/jquery-ui-1.9.2.custom.js"></script>
<style>
.ui-combobox {
        position: relative;
        display: inline-block;
}
.ui-combobox-toggle {
        position: absolute;
        top: 0;
        bottom: 0;
        margin-left: -1px;
        padding: 0;
        /* adjust styles for IE 6/7 */
        *height: 1.7em;
        *top: 0.1em;
}
.ui-combobox-input {
        margin: 0;
        padding: 0.3em;
}
</style>
<script>
(function( $ ) {
        $.widget( "ui.combobox", {
                _create: function() {
                        var input,
                                that = this,
                                select = this.element.hide(),
                                selected = select.children( ":selected" ),
                                value = selected.val() ? selected.text() : "",
                                wrapper = this.wrapper = $( "<span>" )
                                        .addClass( "ui-combobox" )
                                        .insertAfter( select );

                        function removeIfInvalid(element) {
                                var value = $( element ).val(),
                                        matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
                                        valid = false;
                                select.children( "option" ).each(function() {
                                        if ( $( this ).text().match( matcher ) ) {
                                                this.selected = valid = true;
                                                return false;
                                        }
                                });
                                if ( !valid ) {
                                        // remove invalid value, as it didn't match anything
                                        $( element )
                                                .val( "" )
                                                .attr( "title", value + " didn't match any item" )
                                                .tooltip( "open" );
                                        select.val( "" );
                                        setTimeout(function() {
                                                input.tooltip( "close" ).attr( "title", "" );
                                        }, 2500 );
                                        input.data( "autocomplete" ).term = "";
                                        return false;
                                }
                        }

                        input = $( "<input>" )
                                .appendTo( wrapper )
                                .val( value )
                                .attr( "title", "" )
                                .addClass( "ui-state-default ui-combobox-input" )
                                .autocomplete({
                                        delay: 0,
                                        minLength: 0,
                                        source: function( request, response ) {
                                                var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
                                                response( select.children( "option" ).map(function() {
                                                        var text = $( this ).text();
                                                        if ( this.value && ( !request.term || matcher.test(text) ) )
                                                                return {
                                                                        label: text.replace(
                                                                                new RegExp(
                                                                                        "(?![^&;]+;)(?!<[^<>]*)(" +
                                                                                        $.ui.autocomplete.escapeRegex(request.term) +
                                                                                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
                                                                                ), "<strong>$1</strong>" ),
                                                                        value: text,
                                                                        option: this
                                                                };
                                                }) );
                                        },
                                        select: function( event, ui ) {
                                                ui.item.option.selected = true;
                                                that._trigger( "selected", event, {
                                                        item: ui.item.option
                                                });
                                        },
                                        change: function( event, ui ) {
                                                if ( !ui.item )
                                                        return removeIfInvalid( this );
                                        }
                                })
                                .addClass( "ui-widget ui-widget-content ui-corner-left" );

                        input.data( "autocomplete" )._renderItem = function( ul, item ) {
                                return $( "<li>" )
                                        .data( "item.autocomplete", item )
                                        .append( "<a>" + item.label + "</a>" )
                                        .appendTo( ul );
                        };

                        $( "<a>" )
                                .attr( "tabIndex", -1 )
                                .attr( "title", "Show All Employees" )
                                .tooltip()
                                .appendTo( wrapper )
                                .button({
                                        icons: {
                                                primary: "ui-icon-triangle-1-s"
                                        },
                                        text: false
                                })
                                .removeClass( "ui-corner-all" )
                                .addClass( "ui-corner-right ui-combobox-toggle" )
                                .click(function() {
                                        // close if already visible
                                        if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
                                                input.autocomplete( "close" );
                                                removeIfInvalid( input );
                                                return;
                                        }

                                        // work around a bug (likely same cause as #5265)
                                        $( this ).blur();

                                        // pass empty string as value to search for, displaying all results
                                        input.autocomplete( "search", "" );
                                        input.focus();
                                });

                                input
                                        .tooltip({
                                                position: {
                                                        of: this.button
                                                },
                                                tooltipClass: "ui-state-highlight"
                                        });
                },

                destroy: function() {
                        this.wrapper.remove();
                        this.element.show();
                        $.Widget.prototype.destroy.call( this );
                }
        });
})( jQuery );

$(function() {
        $( "#combobox" ).combobox();
        $( "#toggle" ).click(function() {
                $( "#combobox" ).toggle();
        });
});
</script>
<script>
$(function() {
  $( "#datepicker" ).datepicker({
        dateFormat: "dd-mm-yy"
    });
  
  
});
</script>