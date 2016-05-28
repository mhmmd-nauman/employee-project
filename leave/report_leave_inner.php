
                <div class="row">&nbsp;</div>
                <div class="row rep_background">
                    <div class="col-md-3">
                        <b>De Ficha</b>: <?php echo $employee_data[0]['emp_file'];?>
                    </div>
                    <div class="col-md-5">
                        <b>Nombre Del Trabajador</b>: <?php echo $employee_data[0]['emp_name'];?>
                    </div>
                    <div class="col-md-3">
                        <b>Seccion</b>: <?php echo $employee_data[0]['emp_department'];?>
                    </div>
                </div>
                
                <div class="row rep_background">
                    <div class="col-md-5">
                        Supervisor: <?php echo $_SESSION['session_admin_name'];?>
                    </div>
                    <div class="col-md-3">
                        Fecha Del Registro: <?php echo date("d/m/Y"); ?>
                    </div>
                    <div class="col-md-1">
                        Hora: <?php echo date("h:i"); ?>
                    </div>
                </div>
                
                <div class="row rep_background">
                    <div class="col-md-3 ">
                        <div class="row">
                            <div class="col-md-12 ">
                                Motivo Del Permiso
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 cel_data big_cel_data">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 ">
                        <div class="row">
                            <div class="col-md-12">
                                Periodo Del Permiso
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                Des Sde
                            </div>
                            <div class="col-md-4">
                                Hasta
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 cel_data">
                                <?php echo date("d/m/Y", strtotime($leave_data[0]['leave_duration_from'])); ?> 
                            </div>
                            <div class="col-md-4 cel_data">
                                <?php echo date("d/m/Y", strtotime($leave_data[0]['leave_duration_to'])); ?> 
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-5 rep_background">
                                Horas
                            </div>
                            <div class="col-md-5 rep_background">
                               USO RRHH
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-6" >
                                <div class="row">
                                    <div class="col-md-4 rep_background">
                                        DSDE
                                    </div>
                                    <div class="col-md-4 rep_background">
                                        HASTA
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4 rep_background" style="margin-left:15px;">
                                &nbsp;
                            </div>
                        </div>
                        <div class="row" >
                            <div class="col-md-6" >
                                <div class="row">
                                    <div class="col-md-4 cel_data">
                                        &nbsp;
                                    </div>
                                    <div class="col-md-4 cel_data">
                                        &nbsp;
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-4 " style="margin-left:15px;">
                                &nbsp;
                            </div>
                        </div>
                </div>
               </div>
                <!-- leave balance information -->
                <div class="row">
                    <div class="col-md-3">
                        Days available: <?php echo $balance_before_leave ?>
                    </div>
                    <div class="col-md-5">
                    Days taken: <?php echo $leave_data[0]['leave_duration'];?>
                    </div>
                    <div class="col-md-3">
                    Final balance: <?php echo $balance_before_leave - $leave_data[0]['leave_duration'];?>
                    </div>
                </div>
                
                <!-- end of balance section -->
            <div class="row rep_background">
                <div class="col-md-11 ">
                    Observaciones
                </div>
                
            </div>
            <div class="row ">
                <div class="col-md-11 cel_data big_cel_data">
                    <?php echo $leave_data[0]['leave_reason'];?>
                </div>
                
            </div>
            <div class="row">
                &nbsp;
            </div>
              <div class="row">
                <div class="col-md-5 cel_data big_cel_data">
                    <b><?php echo $employee_data[0]['emp_name'];?></b><br>
                    Trabajador
                </div>
                <div class="col-md-3 cel_data big_cel_data">
                    <b><?php echo $_SESSION['session_admin_name'];?></b><br>
                    Supervisor/Jefe Directo
                </div>
                <div class="col-md-3 cel_data big_cel_data">
                    <br>
                    Recursos Humanos
                </div>
            </div>  
        