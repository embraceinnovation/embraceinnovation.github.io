<?php 
    require_once('./util.php');
    DBUtil::Connect();
?>
<html>

<head>
    <title>Show Directory Info</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
    <link href="<?php echo PathUtil::GetCurrentPath(); ?>webfont/style.css" rel="stylesheet" />
    <link href="<?php echo PathUtil::GetCurrentPath(); ?>jq_msp/css/multi.select.css" rel="stylesheet" />
    <script type="text/javascript" src="<?php echo PathUtil::GetCurrentPath(); ?>jq_msp/js/multi.select.js"></script>
    <script type="text/javascript" src="<?php echo PathUtil::GetCurrentPath(); ?>multiselect_values.js"></script>
    <script type="text/javascript" src="<?php echo PathUtil::GetCurrentPath(); ?>country_list.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo PathUtil::GetCurrentPath(); ?>script.js"></script>
    <style type="text/css">
        
        body {
            font-family: 'Lato Regular';
        }
        
       .alert {
          margin-bottom: 1px;
          color: black;
          width: 100%;
          height: 40px;
          line-height:40px;
          padding:0px 15px;
        }

        .multiselect_dd_label {
            margin: 0px;
            text-overflow: ellipsis;
            display: block;
            overflow: hidden;
            white-space: nowrap;
        }

        .multiselect_dd a:,
        .multiselect_dd a:hover {
            color: #FFFFFF;
        }

        .multi-menu li.selected a {
            color: #fff !important;
        }

        .multi-menu>li>a {
            color: #333 !important;
        }

        .multi-menu>li>a {
            color: #333 !important;
        }

        .multi-menu {
            width: auto !important;
            min-width: 100%;
        }

        .multiselect_dd .multi-menu li.control .select-all-none {
            display: none;
        }

        .multiselect_dd .multi-menu .dd_disabled .select-none {
            color: #cecece !important;
            cursor: default;
        }
        
    </style>
 <!-- Update - alert success message fade out -->
<script>
        window.setTimeout(function () {
            $(".alert-success").fadeTo(200, 0).slideUp(200, function () {
            $(this).remove();
        });
        }, 2000);
 </script>  
    
</head>

<body>
    <?php
        $isRecordSaved = false;
        $isFormSubmitted = false;
        if(isset($_POST['_form_submit'])) {
            if(isset($_POST['sfid']) && !empty($_POST['sfid'])) {
                $isFormSubmitted = true;
                $rowsUpdated = DBUtil::UpdateItem($_POST);
                $isRecordSaved = $rowsUpdated > 0;
            }
        }
    ?>

    <?php 
        $isEdit = false;
        $d = [];
        if(isset($_GET['id'])) {
            $d = DBUtil::FetchItem(htmlspecialchars(trim($_GET['id']))); 
            if(isset($d['sfid'])) {
                $isEdit = true;
            }
        }
    ?>
   
 <!-- Show Directory Banner -->    
    <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 text-center">
                <img class="img-fluid" src="/img/DIRACCT_BANNER.jpeg" />
            </div>
        </div>
    </div>

    <?php if(!$isEdit): ?>
    <div class="container mt-2">
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error!</h4>
            <p>Invalid record id provided. Link you have opened is not correct.</p>
            <hr />
            <?php if(isset($_GET['id'])): ?>
            <p class="mb-0">Record Id: <?php echo @($_GET['id']); ?>.</p>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
    <?php if($isRecordSaved): ?>
     <div class="container mt-2">  
            <div class="alert alert-success center-block"> <a href="#" class="close" data-dismiss="alert"></a>
                    <p class="text-center">
                        <strong>Your Show Directory information has been submitted</string>
                    </p>
            </div>
        </div>  
    <?php endif; ?>

    <form method="post">
        <input type="hidden" name="sfid" value="<?php echo @$d['sfid']; ?>" />
        <input type="hidden" name="_form_submit" value="1" />
        <div class="container mt-4">
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                   <strong> <label for="name">Company Name</label></strong>
                    <input value="<?php echo @$d['name']; ?>" name="name" type="text" class="form-control" style="text-color: #A9A9A9;font-weight:bold;background-color:#F4C030;border-radius:0 !important" readonly/>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div class="form-group">
                    <strong><label for="booth__C">Booth Number</label></strong>
                    <input value="<?php echo @$d['booth__c']; ?>" name="booth__c" type="text"
                        class="form-control" style="font-weight:bold;background-color: #F4C030;border-radius:0 !important" readonly/>
                </div>
            </div>
        </div>   
        <div class="container mt-4">
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <h4 class="text-left">
                        ENTER INFORMATION AS YOU WOULD LIKE IT TO APPEAR IN THE SHOW DIRECTORY
                    </h4>
                </div>
            </div>
   <!--         <div class="row mt-3">
                <div class="col-sm-12 col-md-12">
                    <h3>
                        Company Information
                    </h3>
                </div>
            </div> 
    -->
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="company_name_in_directory__c">Company Name as you would like it to appear in the Directory</label>
                        <input value="<?php echo @$d['company_name_in_directory__c']; ?>"
                            name="company_name_in_directory__c" type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="directory_website__c">Website</label>
                        <input value="<?php echo @$d['directory_website__c']; ?>" name="directory_website__c"
                            pattern="((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9\-]+(\.[a-z]{2,}){1,3}(:[0-9]{1,6})?(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?"
                            title="Invalid website address."
                            type="text" 
                            style = "border-radius:0 !important"
                            class="form-control website-input-trim" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="directory_address_street__c">Street</label>
                        <input value="<?php echo @$d['directory_address_street__c']; ?>"
                            name="directory_address_street__c" type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="directory_address_city__c">City</label>
                        <input value="<?php echo @$d['directory_address_city__c']; ?>" name="directory_address_city__c"
                            type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="directory_address_state__c">State/Province</label>
                        <input value="<?php echo @$d['directory_address_state__c']; ?>"
                            name="directory_address_state__c" type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="directory_address_country__c">Country</label>
                        <div>
                            <select id="directory_address_country__c" class="form-control chosen_dd"
                                data-placeholder="Choose a country"
                                data-selected="<?php echo @$d['directory_address_country__c']; ?>"
                                name="directory_address_country__c" type="text" style="border-radius:0 !important" class="form-control">

                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="directory_address_postal_code__c">Zip/Postal Code</label>
                        <input value="<?php echo @$d['directory_address_postal_code__c']; ?>"
                            name="directory_address_postal_code__c" type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="directory_phone_country_code__c">Phone Country Code</label>
                        <input value="<?php echo @$d['directory_phone_country_code__c']; ?>"
                            name="directory_phone_country_code__c" type="text" style="border-radius:0 !important" class="form-control"
                            pattern="[+]*[\d][\d\s]{0,10}"
                            title="Country code can only contains digits(0-9) or space and must start with plus(+) or a digit." />
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="directory_phone_area_code__c">Phone Area Code</label>
                        <input value="<?php echo @$d['directory_phone_area_code__c']; ?>"
                            name="directory_phone_area_code__c" type="text" style="border-radius:0 !important" class="form-control"
                            pattern="[\d][\d\s]{0,15}"
                            title="Area code can only contains digits(0-9) or space and must start with a digit." />
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="directory_phone_number__c">Phone Number</label>
                        <input value="<?php echo @$d['directory_phone_number__c']; ?>" name="directory_phone_number__c"
                            type="text" style="border-radius:0 !important" class="form-control" pattern="[\d][\d\s]{0,15}"
                            title="Number can only contains digits(0-9) or space and must start with a digit." />
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="directory_mobile_country_code__c">Mobile Country Code</label>
                        <input value="<?php echo @$d['directory_mobile_country_code__c']; ?>"
                            name="directory_mobile_country_code__c" style="border-radius:0 !important" type="text" class="form-control"
                            pattern="[+]*[\d][\d\s]{0,10}"
                            title="Country code can only contains digits(0-9) or space and may start with plus(+) or a digit." />
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="directory_mobile_area_code__c">Mobile Area Code</label>
                        <input value="<?php echo @$d['directory_mobile_area_code__c']; ?>"
                            name="directory_mobile_area_code__c" type="text" style="border-radius:0 !important" class="form-control"
                            pattern="[\d][\d\s]{0,15}"
                            title="Area code can only contains digits(0-9) or space and must start with a digit." />
                    </div>
                </div>
                <div class="col-sm-12 col-md-2">
                    <div class="form-group">
                        <label for="directory_mobile_number__c">Mobile Number</label>
                        <input value="<?php echo @$d['directory_mobile_number__c']; ?>"
                            name="directory_mobile_number__c" type="text" style="border-radius:0 !important" class="form-control"
                            pattern="[\d][\d\s]{0,15}"
                            title="Number can only contains digits(0-9) or space and must start with a digit." />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="directory_contact_first_name__c">Contact First/Given Name</label>
                        <input value="<?php echo @$d['directory_contact_first_name__c']; ?>"
                            name="directory_contact_first_name__c" type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="directory_contact_last_name__c">Contact Surname/Family Name</label>
                        <input value="<?php echo @$d['directory_contact_last_name__c']; ?>"
                            name="directory_contact_last_name__c" type="text" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
                <div class="col-sm-12 col-md-4">
                    <div class="form-group">
                        <label for="directory_contact_email__c">Contact Email Address</label>
                        <input value="<?php echo @$d['directory_contact_email__c']; ?>"
                            name="directory_contact_email__c" type="email" style="border-radius:0 !important" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-sm-12 col-md-12">
                    <div class="text-center">
                        <strong>Please select the Products/Services you will Exhibit at the Show - Maximum of 20 Selections Total</strong>
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Fin Fish</label>
                        <div class="multiselect_dd" id="finfish__c"></div>
                        <input type="hidden" name="finfish__c" value="<?php echo @$d['finfish__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Shellfish</label>
                        <div class="multiselect_dd" id="shellfish__c"></div>
                        <input type="hidden" name="shellfish__c" value="<?php echo @$d['shellfish__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Other Seafood</label>
                        <div class="multiselect_dd" id="other_seafood__c"></div>
                        <input type="hidden" name="other_seafood__c" value="<?php echo @$d['other_seafood__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Value-Added Products</label>
                        <div class="multiselect_dd" id="value_added_products__c"></div>
                        <input type="hidden" name="value_added_products__c"
                            value="<?php echo @$d['value_added_products__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Aquaculture Technology & Equipment</label>
                        <div class="multiselect_dd" id="aquaculture_tech_equipment__c"></div>
                        <input type="hidden" name="aquaculture_tech_equipment__c"
                            value="<?php echo @$d['aquaculture_tech_equipment__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Service</label>
                        <div class="multiselect_dd" id="service__c"></div>
                        <input type="hidden" name="service__c" value="<?php echo @$d['service__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Packing / Packing Equipment</label>
                        <div class="multiselect_dd" id="packing_equipment__c"></div>
                        <input type="hidden" name="packing_equipment__c"
                            value="<?php echo @$d['packing_equipment__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Processing Equipment / Materials</label>
                        <div class="multiselect_dd" id="processing_equipment_matls__c"></div>
                        <input type="hidden" name="processing_equipment_matls__c"
                            value="<?php echo @$d['processing_equipment_matls__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Quality Control</label>
                        <div class="multiselect_dd" id="quality_control__c"></div>
                        <input type="hidden" name="quality_control__c"
                            value="<?php echo @$d['quality_control__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Refrigeration / Freezing Equipment</label>
                        <div class="multiselect_dd" id="refrigeration_freezing_equipment__c"></div>
                        <input type="hidden" name="refrigeration_freezing_equipment__c"
                            value="<?php echo @$d['refrigeration_freezing_equipment__c']; ?>" />
                    </div>
                </div>

                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label class="multiselect_dd_label">Fishing Machinery / Fishing Gear</label>
                        <div class="multiselect_dd" id="fishing_machinery_gear__c"></div>
                        <input type="hidden" name="fishing_machinery_gear__c"
                            value="<?php echo @$d['fishing_machinery_gear__c']; ?>" />
                    </div>
                </div>
                <div class="col-sm-12 col-md-3">
                    <div class="form-group">
                        <label for="other_products_services__c">Other</label>
                        <textarea name="other_products_services__c" class="form-control"><?php echo @$d['other_products_services__c']; ?></textarea>
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="offset-md-4 offset-sm-0 col-sm-12 col-md-4 text-center">
                    <button type="submit" class="btn btn-lg btn-success btn-block" style="border-radius:0 !important;background-color:C9010A !important">Submit/Update Information</button>
                </div>
            </div>
        </div>   
    </form>
    <?php endif; ?>
</body>

</html>
