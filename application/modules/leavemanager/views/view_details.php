<!--main content start-->
<?php if ($redirect == 'download') { ?>
    <!DOCTYPE html>
    <html lang="en" <?php if ($this->db->get('settings')->row()->language == 'arabic') { ?> dir="rtl" <?php } ?>>
        <link href="common/css/bootstrap.min.css" rel="stylesheet">
        <link href="common/css/bootstrap-reset.css" rel="stylesheet">

        <link href="common/assets/fontawesome5pro/css/all.min.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="common/assets/bootstrap-wysihtml5/bootstrap-wysihtml5.css" />
        <style>
            @import url('https://fonts.googleapis.com/css?family=Ubuntu&display=swap');
        </style>
        <link href="common/assets/DataTables/datatables.css" rel="stylesheet" />
        <link href="common/extranal/css/finance/downloadInvoice.css" rel="stylesheet" />

    <?php } ?>
    <link href="common/extranal/css/finance/invoice-all.css" rel="stylesheet" />
    <?php if ($redirect != 'download') { ?>
        <link href="common/extranal/css/leave_details.css" rel="stylesheet" />
        <section id="main-content">
            <section class="wrapper site-min-height">
            <?php } ?>
            <!-- invoice start-->
            <?php if ($redirect != 'download') { ?>
                <section class="col-md-6">
                <?php } else { ?>
                    <section class="col-md-12">
                    <?php } ?>
                    <div class="panel panel-primary" id="invoice">

                        <div class="panel-body invoice-all">
                            <div class="row invoice-list">

                                <div class="col-md-12 invoice_head clearfix logotitle">
                                <div class="col-md-12 text-center " style="margin-top: 10px;">
                                        <img alt="" src="<?php echo $this->settings_model->getSettings()->logo; ?>" width="80" height="80">
                                    </div>
                                    <div class="col-md-12 text-center ">
                                        <h3>
                                            <?php echo $settings->title ?>
                                        </h3>
                                        <h4>
                                            <?php echo $settings->address ?>
                                        </h4>
                                        <h4>
                                            Tel: <?php echo $settings->phone ?>
                                        </h4>
                                    </div>
                                    



                                </div>
                                <?php if ($redirect != 'download') { ?>
                                    <div class="col-md-12 hr_border">
                                        <hr>
                                    </div>
                                    <div class="col-md-12 title" >
                                        <h5 class="text-center invoice_lang">
                                            <?php echo lang('sick_leave_cirtificate') ?> 
                                        </h5>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12 title" >
                                        <h5 class="text-center invoice_lang">
                                        <?php echo lang('sick_leave_cirtificate') ?> 
                                        </h5>
                                    </div>
                                <?php } ?>

                                <?php if ($redirect == 'download') { ?>  
                                    <div class="col-md-12 invoice-box">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                            <td> 
                                                                <div class="paragraphprint">
                                                                    <label class="control-label"><?php echo lang('date_of_issue'); ?>  </label>
                                                                    <span class="info_text"> : 
                                                                        <?php
                                                                        if (!empty($leavemanager)) {
                                                                            echo date('d-m-Y', $leavemanager->add_date) . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span>  
                                                                </div>
                                                                
                                                               
                                                                
                                                            </td>

                                                            <td>
                                                                <div class="paragraphprint text-right">

                                                                    <label class="control-label"><?php echo lang('ref_no'); ?>  </label>
                                                                    <span class="info_text"> : 
                                                                        <?php
                                                                        if (!empty($leavemanager->id)) {
                                                                            echo $leavemanager->id;
                                                                        }
                                                                        ?>
                                                                    </span>

                                                                </div>
                                                                
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12">
                                        <div class="col-md-6 pull-left row info_position">
                                            <div class="col-md-12 row details">
                                                <p>
                                                <label class="control-label"><?php echo lang('date_of_issue'); ?>  </label>
                                                                    <span class="info_text"> : 
                                                                        <?php
                                                                        if (!empty($leavemanager)) {
                                                                            echo date('d-m-Y', $leavemanager->add_date) . ' <br>';
                                                                        }
                                                                        ?>
                                                                    </span> 
                                                </p>
                                            </div>
                                            
                                           


                                        </div>

                                        <div class="col-md-6 pull-right info_position">

                                            <div class="col-md-12 row details text-right">
                                                <p>
                                                <!-- <label class="control-label"><?php echo lang('ref_no'); ?>  </label> -->
                                                                    <!-- <span class="info_text"> : 
                                                                        <?php
                                                                        if (!empty($leavemanager->id)) {
                                                                            echo $leavemanager->id;
                                                                        }
                                                                        ?>
                                                                    </span> -->
                                                </p>
                                            </div>


                                           

                                            



                                        </div>

                                    </div>






                                </div> 
                            <?php }  ?>

<style>
    .t_border{
        border: 1px solid black;;
    }
    .text{
        font-size: 14px;
        text-align: justify;
    }
    .text2{
        font-size: 12px;
        text-align: justify;
        color: black;
        margin-top: 10px;
    }
    .padd{
        padding-left: 15px;
    }
</style>
                                
                            
                            <?php if ($redirect != 'download') { ?>
                                <table class="table table-striped table-hover detailssale">
                                <?php } else { ?>
                                    <table class="table table-striped table-hover detailssale" id="customers"> 
                                    <?php } ?>          
                                    <thead class="theadd">
                                    
                                        <tr class="table_tr t_border">
                                        <?php $patient_info = $this->db->get_where('patient', array('id' => $leavemanager->patient))->row(); ?>
                                           
                                            <th class="t_border"><?php echo lang('name_of_patient'); ?></th>
                                            <th class="t_border"><?php echo lang('working_company'); ?></th>
                                            <th class="t_border"><?php echo lang('date_of_birth'); ?></th>
                                            
                                       
                                           
                                        </tr>
                                    </thead>

                                    <tbody>
                                    <tr class="t_border">
                                                    <td class="t_border"><?php
                                                        if (!empty($patient_info)) {
                                                            echo $patient_info->name . ' <br>';
                                                        }
                                                        ?> </td>
                                                    <td class="t_border"> <?php
                                                        if (!empty($patient_info)) {
                                                            echo $leavemanager->company . ' <br>';
                                                        }
                                                        ?></td>
                                                    <td class="t_border"> <?php
                                                        if (!empty($patient_info)) {
                                                            echo $patient_info->birthdate . ' <br>';
                                                        }
                                                        ?></td>
                                                     </tr> 

                                    </tbody>

                                </table>
<table>
    <p class="text">This is to certify that the above mentioned person was examined/treated by me and found to suffer from <strong><?php if (!empty($leavemanager)) {
                                                            echo $leavemanager->diagnosis;
                                                        } ?></strong>  as an Out Patient on <?php if (!empty($leavemanager)) {
                                                            echo date('d-m-Y', $leavemanager->add_date);
                                                        } ?>. He is granted sick leave from <?php if (!empty($leavemanager)) {
                                                            echo date('d-m-Y', $leavemanager->start_date);
                                                        } ?> to <?php if (!empty($leavemanager)) {
                                                            echo date('d-m-Y', $leavemanager->end_date);
                                                        } ?>.</p>
</table>
<table><h4>Remarks </h4></table>
<table><p class="text">To be Countersigned by Consultant if sick leave exceeds Three days. This certificate is not valid without doctors signature and stamp of Clinic/Polyclinic/Hospital.</p></table>

<br><br>
<?php if ($redirect == 'download') { ?>  
                                    <div class="col-md-12 invoice-box">
                                        <table cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="2">
                                                    <table>
                                                        <tr>
                                                            <td> 
                                                                <div class="paragraphprint">
                                                                    
                                                                    <h4 class="info_text"> : 
                                                                        <?php
                                                                        
                                                                            echo $doctor_name . ' <br>';
                                                                       
                                                                        ?>
                                                                    </h4>  
                                                                </div>
                                                                <div class="paragraphprint">
                                                                <label class="control-label"><?php echo lang('place'); ?>  </label>
                                                                    <span class="info_text"> : 
                                                                    <?php echo $settings->title ?>
                                                                    </span>  
                                                                </div>
                                                                <div class="paragraphprint">
                                                                <label class="control-label"><?php echo lang('signature'); ?>  </label>
                                                                     
                                                                </div>
                                                                <div class="paragraphprint">
                                                                <label class="control-label"><?php echo lang('hospital_seal'); ?>  </label>
                                                                    
                                                                </div>
                                                               
                                                                
                                                            </td>

                                                            <td>
                                                                <div class="paragraphprint text-right">

                                                                    <label class="control-label"><?php echo lang('patient_signature'); ?>  </label>
                                                                    

                                                                </div>
                                                                
                                                                
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="col-md-12">
                                        <div class="col-md-6 pull-left row ">
                                            <div class="col-md-12 row details pad">
                                                <p>
                                                
                                                   
                                                
                                                   
                                                                    <h4 class="info_text"> 
                                                                    <?php if (!empty($leavemanager)) {
                                                            echo $leavemanager->doctor_name;
                                                        } ?>
                                                                    </h4> 
                                                </p>
                                            </div>
                                            <div class="col-md-12 row details pad">
                                                <p>
                                                
                                                <label class="text2"><?php echo lang('place'); ?>  </label>
                                                                    <span class="info_text"> : 
                                                                    <?php echo $settings->title ?>
                                                                    </span> 
                                                </p>
                                            </div>
                                           
                                            <div class="col-md-12 row details pad">
                                                <p>
                                                
                                                <label class="text2"><?php echo lang('signature'); ?>  </label>
                                                                    
                                                </p>
                                            </div>
                                            <div class="col-md-12 row details pad">
                                                <p>
                                                
                                                <label class="text2"><?php echo lang('hospital_seal'); ?>  </label>
                                                                    
                                                </p>
                                            </div>

                                        </div>

                                        <div class="col-md-6 pull-right ">

                                            <div class="col-md-12 row details text-right">
                                                <p>
                                                <label class="control-label text2"><?php echo lang('patient_signature'); ?>  </label>
                                                                    
                                                </p>
                                            </div>


                                        </div>
                                    </div>
                                </div> 
                            <?php }  ?>
                           
                            <table><p class="text padd">Countersigned by Directorate of Private Health Establishment Affairs, Sultanate Of Oman</p></table>
                               
                                <?php if ($redirect != 'download') { ?>
                                    
                                    
<?php if($redirectlink !='print'){ ?>
                                    <div class="col-md-12 hr_border">
                                        <hr>
                                    </div>
<?php } ?>
                                    <div class="col-md-12 invoice_footer">
                                        <div class="col-md-4 row pull-left">
                                            <?php echo lang('user'); ?> : <?php echo $this->ion_auth->user($leavemanager->user)->row()->username; ?>
                                            <div class="col-md-4 row pull-right">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                        </div>
                </section>

                <?php if ($redirect != 'download') { ?>
                    <section class="col-md-6">
                        <div class="col-md-5 no-print option_button">
               
                        
                            <div class="text-center col-md-12 row">
                                <a class="btn btn-info btn-sm invoice_button pull-left" onclick="javascript:window.print();"><i class="fa fa-print"></i> <?php echo lang('print'); ?> </a>
<!--                                 
                                  <?php if ($this->ion_auth->in_group(array('admin'))) { ?>
                                    <a href="leavemanager/download?id=<?php echo $leavemanager->id; ?>" class="btn btn-info btn-sm detailsbutton pull-left download"><i class="fa fa-download"></i> <?php echo lang('download'); ?>  </a>
                                <?php } ?> -->


                            </div>
                 

                        </div>

                    </section>
                <?php } ?>


                <link rel="stylesheet" href="common/extranal/css/leaveAll.css"/>



                <script src="common/js/codearistos.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.0.272/jspdf.debug.js"></script>
            </section>
            <?php if ($redirect == 'download') { ?>
                </html>
            <?php } ?>
            <!-- invoice end-->
            <?php if ($redirect != 'download') { ?>
            </section>
        </section>
        <!-- <link href="common/extranal/css/finance/print.css" rel="stylesheet" /> -->
        <script src="common/js/codearistos.min.js"></script>
        <script src="common/js/bootstrap.min.js"></script>




        <script  type="text/javascript" src="common/assets/DataTables/datatables.min.js"></script>

    <?php } ?>

    <script src="common/extranal/js/finance/invoice.js"></script>


    <?php if ($redirectlink == 'print') { ?>
        <script src="common/extranal/js/finance/printInvoice.js"></script>
    <?php } ?>