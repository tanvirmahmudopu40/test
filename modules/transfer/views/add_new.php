<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
     
           <link href="common/extranal/css/transfer/add_new.css" rel="stylesheet">
        <section class="col-md-6">
            <header class="panel-heading">
                <?php
                if (!empty($transfer->id))
                    echo lang('edit_transfer_patient');
                else
                    echo lang('transfer_patient');
                ?>
            </header>
            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="clearfix">
                        <div class="col-lg-12">
                            <div class="col-lg-3"></div>
                            <div class="col-lg-6">
                                <?php echo validation_errors(); ?>
                                <?php echo $this->session->flashdata('feedback'); ?>
                            </div>
                            <div class="col-lg-3"></div>
                        </div>
                        <form role="form" action="transfer/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                            
                        <div class="col-md-6 panel">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('transfer'); ?></label>
                        <select class="form-control js-example-basic-single" id="" name="patient" value=''>
                        <option value="">Select</option>
                            <?php foreach ($patients as $patient) { ?>
                                <option  value="<?php echo $patient->id; ?>" <?php
                                if ($patient->id == $transfer->patient) {
                                    echo 'selected';
                                }
                                ?>> <?php echo $patient->name; ?></option>  
                                     <?php } ?>
                        </select>
                    </div>

                            <!-- <div class="form-group col-md-6">
                                <label for="exampleInputEmail1">Transfer <?php echo lang('patient'); ?></label>
                               
                            <select class="form-control m-bot15  pos_select" id="pos_select" name="patient" value='' required> 
                            <?php if (!empty($appointment)) { ?>
                                    <option value="<?php echo $patients->id; ?>" selected="selected"><?php echo $patients->name; ?> - <?php echo $patients->id; ?></option>  
                                <?php } ?>
                            </select>
                          
                            </div> -->
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"> <?php echo lang('hospital'); ?> <?php echo lang('name'); ?> &#42;</label>
                                <input type="text" class="form-control" name="hospital"  value='<?php
                                if (!empty($transfer->hospital)) {
                                    echo $transfer->hospital;
                                }
                                ?>' placeholder="" required="">
                            </div>

 <div class="pos_client clearfix">
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('name'); ?> &#42;</label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_name" value='<?php
                                if (!empty($payment->p_name)) {
                                    echo $payment->p_name;
                                }
                                ?>' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('email'); ?> &#42;</label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_email" value='<?php
                                if (!empty($payment->p_email)) {
                                    echo $payment->p_email;
                                }
                                ?>' placeholder="">
                            </div>
                        </div>
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('phone'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_phone" value='<?php
                                if (!empty($payment->p_phone)) {
                                    echo $payment->p_phone;
                                }
                                ?>' placeholder="">
                            </div>
                        </div>

                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('age'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <input type="text" class="form-control pay_in" name="p_age" value='<?php
                                if (!empty($payment->p_age)) {
                                    echo $payment->p_age;
                                }
                                ?>' placeholder="">
                            </div>
                        </div> 
                        <div class="col-md-8 payment pad_bot pull-right">
                            <div class="col-md-3 payment_label"> 
                                <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> <?php echo lang('gender'); ?></label>
                            </div>
                            <div class="col-md-9"> 
                                <select class="form-control m-bot15" name="p_gender" value=''>

                                    <option value="Male" <?php
                                    if (!empty($patient->sex)) {
                                        if ($patient->sex == 'Male') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > Male </option>   
                                    <option value="Female" <?php
                                    if (!empty($patient->sex)) {
                                        if ($patient->sex == 'Female') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > Female </option>
                                    <option value="Others" <?php
                                    if (!empty($patient->sex)) {
                                        if ($patient->sex == 'Others') {
                                            echo 'selected';
                                        }
                                    }
                                    ?> > Others </option>
                                </select>
                            </div>
                        </div>
                    </div>

                            <div class="form-group col-md-12 ">
                                <label><?php echo lang('reason'); ?> &#42;</label>
                                
                                    <textarea class="ckeditor form-control editor" id="editor" name="reason" value="" rows="10" required=""> </textarea>
                                
                            </div>



                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"> <?php echo lang('date'); ?> &#42;</label>
                                <input type="text" class="form-control default-date-picker" name="date"  value='' placeholder="" required="" onkeypress="return false;">
                            </div>




                            <input type="hidden" name="id" value='<?php
                            if (!empty($transfer->id)) {
                                echo $transfer->id;
                            }
                            ?>'>


                            <button type="submit" name="submit" class="btn btn-info"> <?php echo lang('submit'); ?></button>
                        </form>

                    </div>
                </div>

            </div>
        </section>
    </section>
    <!-- page end-->
</section>
<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/transfer.js"></script>
<script type="text/javascript">var select_patient = "<?php echo lang('select_patient'); ?>";</script>
