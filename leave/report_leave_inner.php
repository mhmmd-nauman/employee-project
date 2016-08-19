<div class="row">
    <div class="col-md-2 ">
         <img alt="Indubal" src="<?php echo SITE_ADDRESS; ?>img/logo20.png" class="hidden-xs">
     </div>
    <div class=" col-md-7" data-original-title="" style=" text-align: center;">
        <h4> SOLICITUD DE VACACIONES</h4>
    </div>
    
</div>
                <div class="row">&nbsp;</div>
                <div class="row rep_background">
                    <div class="col-md-4">
                        <b>N° DE FICHA</b>: <?php echo $employee_data[0]['emp_file'];?>
                    </div>
                    <div class="col-md-5">
                        <b>NOMBRE DEL TRABAJADOR</b>: <?php echo $employee_data[0]['emp_name'];?>
                    </div>
                    <div class="col-md-2">
                        <b>SECCIÓN</b>: <?php echo $employee_data[0]['emp_department'];?>
                    </div>
                </div>
                
                <div class="row rep_background">
                    <div class="col-md-5">
                        SUPERVISOR / APROBADOR: <?php echo $approver_data[0]['emp_name'];?>
                    </div>
                    <div class="col-md-4">
                        FECHA DEL REGISTRO: <?php echo date("d-m-Y",  strtotime($leave_data[0]['leave_datetime'])); ?>
                    </div>
                    <div class="col-md-2">
                        HORA: <?php echo date("h:i"); ?>
                    </div>
                </div>
                
                <div class="row rep_background">
                    <div class="col-md-3 ">
                        <div class="row">
                            <div class="col-md-12 ">
                                TIPO DE VACACIONES
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 ">
                                <?php if($leave_data[0]['leave_balance_type']=='F'){?>
                                FERIADO LEGAL <?php }else{ ?> DIAS PROGRESIVOS
                                <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 ">
                        <div class="row">
                            <div class="col-md-12">
                                PERIODO DEL PERMISO
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Desde: <?php echo date("d-m-Y", strtotime($leave_data[0]['leave_duration_from'])); ?>
                            </div>
                            <div class="col-md-4">
                                Hasta: <?php echo date("d-m-Y", strtotime($leave_data[0]['leave_duration_to'])); ?>
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="col-md-2">
                        <div class="row">
                            <div class="col-md-11 ">
                                DÍAS SOLICITADOS: <?php echo $leave_data[0]['leave_duration'];?>
                            </div>
                            
                        </div>
                     </div>
               </div>
                <!-- leave balance information -->
                <div class="row rep_background">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-10" style="text-align: center;">
                                <b>SALDO FINAL DISPONIBLE</b>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5" style="text-align: center;">
                                FERIADOS LEGALES
                            </div>
                            <div class="col-md-5" style="text-align: center;">
                                DIAS PROGRESIVOS		
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5" style="text-align: center;">
                                <?php echo $balance_detail['F']-$balance_detail['leavesI'];?>
                            </div>
                            <div class="col-md-5" style="text-align: center;">
                                <?php echo $balance_detail['D']-$balance_detail['leavesD'];?>		
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <!-- end of balance section -->
                <div class="row rep_background" style="text-align: center;">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            Observaciones
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                           <?php echo $leave_data[0]['leave_reason'];?>
                        </div>
                        
                    </div>
                </div>
                
            </div>
            
                <div class="row" style="min-height: 40px;">
                    &nbsp;  
                </div>
                <div class="row" >
                <div class="col-md-5 cel_data big_cel_data" >
                    <b><?php echo $employee_data[0]['emp_name'];?></b><br>
                    TRABAJADOR
                </div>
                <div class="col-md-3 cel_data big_cel_data" >
                    <b><?php echo $approver_data[0]['emp_name'];?></b><br>
                    SUPERVISOR / APROBADOR
                </div>
                <div class="col-md-3 cel_data big_cel_data">
                    <br>
                    CONTROL DE GESTIÓN
                </div>
            </div>  
        