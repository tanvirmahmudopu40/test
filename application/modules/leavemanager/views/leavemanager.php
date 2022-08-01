<!--sidebar end-->
<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <!-- page start-->
        <link href="common/extranal/css/leavemanager/leavemanager.css" rel="stylesheet">
        <section class="panel">
            <header class="panel-heading">
                <?php echo lang('leavemanager'); ?>
                <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                    <div class="col-md-4 no-print pull-right"> 
                        <a href="leavemanager/addNewView">
                            <div class="btn-group pull-right">
                                <button id="" class="btn green btn-xs">
                                    <i class="fa fa-plus-circle"></i> <?php echo lang('add_leave'); ?>
                                </button>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </header>




            <div class="panel-body">
                <div class="adv-table editable-table ">
                    <div class="space15"></div>
                    <table class="table table-striped table-hover table-bordered" id="editable-sample">
                        <thead>
                            <tr>
                            <th> Sl.</th>
                                <th> <?php echo lang('patient'); ?></th>
                                <th> <?php echo lang('doctor'); ?></th>
                                <th> <?php echo lang('start_date'); ?> </th>
                                <th> <?php echo lang('end_date'); ?> </th>
                                <th> <?php echo lang('company'); ?></th>
                                <?php if ($this->ion_auth->in_group(array('admin', 'Doctor'))) { ?>
                                    <th> <?php echo lang('options'); ?></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!-- page end-->
    </section>
</section>
<!--main content end-->
<!--footer start-->




<!-- Add Leavemanager Modal-->
<div class="modal fade" id="myModal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('add_leavemanager'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" action="leavemanager/addNew" class="clearfix row" method="post" enctype="multipart/form-data">

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"> <?php echo lang('title'); ?> &#42;</label>
                        <input type="text" class="form-control" name="title"  value='<?php
                        if (!empty($leavemanager->name)) {
                            echo $leavemanager->name;
                        }
                        ?>' placeholder="" required="">
                    </div>

                    <div class="form-group col-md-6">
                        <label for="exampleInputEmail1"><?php echo lang('leavemanager_for'); ?></label>
                        <select class="form-control m-bot15" name="type" value=''>
                            <option value="patient" <?php
                            if (!empty($leavemanager->type)) {
                                if ($leavemanager->type == 'patient') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('patient'); ?></option>
                            <option value="staff" <?php
                            if (!empty($leavemanager->type)) {
                                if ($leavemanager->type == 'staff') {
                                    echo 'selected';
                                }
                            }
                            ?>><?php echo lang('staff'); ?></option>

                        </select>
                    </div>

                    <div class="form-group col-md-12 des">
                        <label class=""><?php echo lang('description'); ?> &#42;</label>
                        <div class="">
                            <textarea class="ckeditor form-control editor" id="editor" name="description" value="" rows="10" required> </textarea>
                        </div>
                    </div>


                    <div class="form-group col-md-4">
                        <label for="exampleInputEmail1"> <?php echo lang('date'); ?> &#42;</label>
                        <input type="text" class="form-control default-date-picker" name="date"  value='' placeholder="" required="" onkeypress="return false;">
                    </div>




                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal2" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">   <?php echo lang('edit_leavemanager'); ?></h4>
            </div>
            <div class="modal-body">
                <form role="form" id="editLeavemanagerForm" class="clearfix row" action="leavemanager/addNew" method="post" enctype="multipart/form-data">

                <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('patient'); ?> </label>
                        <select class="form-control" id="" name="patient" value=''>
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

                    <div class="col-md-6 form-group">
                        <label for="exampleInputEmail1"> <?php echo lang('doctor'); ?> </label>
                        <select class="form-control" id="" name="doctor" value=''>
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


                            
                            



                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"> <?php echo lang('start_date'); ?> &#42;</label>
                                <input type="text" class="form-control default-date-picker" name="start_date"  value='' placeholder="" required="" onkeypress="return false;">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1"> <?php echo lang('end_date'); ?> &#42;</label>
                                <input type="text" class="form-control default-date-picker" name="end_date"  value='' placeholder="" required="" onkeypress="return false;">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1"> <?php echo lang('company'); ?> &#42;</label>
                                <input type="text" class="form-control" name="company"  value='' placeholder="" required="">
                            </div>
                            <div class="form-group col-md-12 ">
                                <label class=""><?php echo lang('diagnosis'); ?> &#42;</label>
                                
                                    <textarea class="form-control" id="" name="diagnosis" value="" rows="10" required=""> </textarea>
                                
                            </div>
                    <input type="hidden" name="id" value='<?php
                    if (!empty($leavemanager->id)) {
                        echo $leavemanager->id;
                    }
                            ?>'>
                    <div class="form-group col-md-12">
                        <button type="submit" name="submit" class="btn btn-info pull-right"> <?php echo lang('submit'); ?></button>
                    </div>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<script src="common/js/codearistos.min.js"></script>
<script type="text/javascript">var language = "<?php echo $this->language; ?>";</script>
<script src="common/extranal/js/leavemanager.js"></script>
