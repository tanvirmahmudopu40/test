<!--sidebar end-->
<!--main content start-->

<?php
$current_user = $this->ion_auth->get_user_id();
if ($this->ion_auth->in_group('Doctor')) {
    $doctor_id = $this->db->get_where('doctor', array('ion_user_id' => $current_user))->row()->id;
    // $doctordetails = $this->db->get_where('doctor', array('id' => $doctor_id))->row();
}
?>
<section id="main-content">
    <section class="wrapper site-min-height">
     
           <link href="common/extranal/css/notice/add_new.css" rel="stylesheet">
        <section class="col-md-6">
            <header class="panel-heading">
                <?php
                if (!empty($leavemanager->id))
                    echo lang('edit_leave');
                else
                    echo lang('add_leave');
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
                        <form role="form" action="leavemanager/addNew" class="clearfix" method="post" enctype="multipart/form-data">

                        <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> </label>
                        <select class="form-control js-example-basic-single" id="" name="patient" value=''>
                        <option value="">Select Patient</option>
                            <?php foreach ($patients as $patient) { ?>
                                <option  value="<?php echo $patient->id; ?>" <?php
                                if ($patient->id == $leavemanager->patient) {
                                    echo 'selected';
                                }
                                ?>> <?php echo $patient->name; ?> - (PH :: <?php echo $patient->phone; ?>)</option>  
                                     <?php } ?>
                        </select>
                    </div>
                    <?php if (!$this->ion_auth->in_group('Doctor')) { ?>
                    <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> </label>
                        <select class="form-control js-example-basic-single" id="" name="doctor" value=''>
                        <option value="">Select Doctor</option>
                            <?php foreach ($doctors as $doctor) { ?>
                                <option  value="<?php echo $doctor->id; ?>" <?php
                                if ($doctor->id == $leavemanager->doctor) {
                                    echo 'selected';
                                }
                                ?>> <?php echo $doctor->name; ?> - (PH :: <?php echo $doctor->phone; ?>)</option>  
                                     <?php } ?>
                        </select>
                    </div>
                    <?php } else { ?>
                        <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> </label>
                        <select class="form-control js-example-basic-single" id="" name="doctor" value=''>
                        <option value="">Select Doctor</option>
                            <?php foreach ($doctors as $doctor) { ?>
                                <option  value="<?php echo $doctor->id; ?>" <?php
                                if ($doctor->id == $doctor_id) {
                                    echo 'selected';
                                }
                                ?>> <?php echo $doctor->name; ?> - (PH :: <?php echo $doctor->phone; ?>)</option>  
                                     <?php } ?>
                        </select>
                    </div>
                        <?php } ?>

                            
                            



                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"> <?php echo lang('start_date'); ?> &#42;</label>
                                <input type="text" class="form-control default-date-picker" name="start_date"  value='<?php
                            if (!empty($leavemanager->start_date)) {
                                echo date('d-m-Y', $leavemanager->start_date);
                            }
                            ?>' placeholder="" required="" onkeypress="return false;">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"> <?php echo lang('end_date'); ?> &#42;</label>
                                <input type="text" class="form-control default-date-picker" name="end_date"  value='<?php
                            if (!empty($leavemanager->end_date)) {
                                echo date('d-m-Y', $leavemanager->end_date);
                            }
                            ?>' placeholder="" required="" onkeypress="return false;">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"> <?php echo lang('company'); ?> &#42;</label>
                                <input type="text" class="form-control" name="company"  value='<?php
                            if (!empty($leavemanager->company)) {
                                echo $leavemanager->company;
                            }
                            ?>' placeholder="" required="">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label class=""><?php echo lang('diagnosis'); ?> &#42;</label>
                                
                                    <textarea class="form-control" id="" name="diagnosis" value="" rows="10" required=""> <?php
                            if (!empty($leavemanager->diagnosis)) {
                                echo $leavemanager->diagnosis;
                            }
                            ?></textarea>
                                
                            </div>


                            <input type="hidden" name="id" value='<?php
                            if (!empty($leavemanager->id)) {
                                echo $leavemanager->id;
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
<script src="common/extranal/js/leavemanager.js"></script>
