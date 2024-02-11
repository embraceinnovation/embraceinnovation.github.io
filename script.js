var promptMessages = {
    itemSelectionLimitReached: "You are limited to a total of 20 Products & Services selections",
    invalidNumber: "Phone number should be numeric.",
    invalidEmail: "Invalid email address.",
}

var regex = {
    countryCode: /[+]*[\d\s]{1,5}/,
    email: /[+]*[\d\s]{1,5}/,
    website: /((https?|ftp|smtp):\/\/)?(www.)?[a-z0-9]+(\.[a-z]{2,}){1,3}(#?\/?[a-zA-Z0-9#]+)*\/?(\?[a-zA-Z0-9-_]+=[a-zA-Z0-9-%]+&?)?/
}

$(document).ready(function(){

    var countryDD = $("#directory_address_country__c");
    var countrySelectedValue = countryDD.data("selected");
    countryDD.append($("<option></option>").attr("value", "").text("Select Country").prop("disabled",true).prop("selected",true));
    $.each(countryList,function(index,json){
        var optItem = $("<option></option>").attr("value", json.Value).text(json.Label);
        if(json.Value == countrySelectedValue) {
            optItem.prop("selected", true);
        }
        countryDD.append(optItem);
    });
    // $(".chosen_dd").chosen();

    var msOptions = {
        selectColor: 'blue',
        selectSize: 'medium',
        selectText: 'None Selected',
        duration: 300,
        easing: 'slide',
        listMaxHeight: 300,
        selectedCount: 2,
        sortByText: true,
        fillButton: true,
        onSelect: function(values) {
            // console.log('return values: ', values);
        }
    };

    $("#finfish__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues.FinFish)
    }));

    $("#shellfish__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues.Shellfish)
    }));

    $("#other_seafood__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Other-Seafood"])
    }));

    $("#value_added_products__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Value-Added-Products"])
    }));

    $("#aquaculture_tech_equipment__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Aquaculture-Tech-Equipment"])
    }));
    
    $("#service__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues.Service)
    }));
    
    $("#packing_equipment__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Packing-Equipment"])
    }));

    $("#processing_equipment_matls__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Processing-Equipment-Materials"])
    }));

    $("#quality_control__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Quality-Control"])
    }));

    $("#refrigeration_freezing_equipment__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Refrigeration-Equipment"])
    }));

    $("#fishing_machinery_gear__c").multi_select(Object.assign({}, msOptions, {
        data: ObjectArrayToKeyValueJSON(multiselectValues["Fishing-Machinery-Gear"])
    }));

    
    $(".multiselect_dd .multi-menu, .multiselect_dd .multi-menu *").off("click");

    $(".multiselect_dd .control .select-all-none").after("<a class='select-none'>Clear all Selections</a>");
    $(".multiselect_dd .control").addClass("dd_disabled");

    $(".website-input-trim").on("focusout, blur", function() {
        $(this).val($(this).val().trim());
    })

    setTimeout(function(){
        $(".multiselect_dd").each(function(){
            var name = $(this).attr("id");
            var values = $("[name='"+name+"']").val().trim();
            if(values.length > 0) {
                values = values.split(";");
            }
            else {
                values = [];
            }
            if(values.length > 0) {
                var listItems = $(this).find("li.list-items")
                var itemClicked = 0;
                
                for(var i in listItems) {
                    var id = listItems.eq(i).data('id')
                    if(values.includes(id)) {
                        listItems.eq(i).click();
                        itemClicked++;
                    }
    
                    if(itemClicked >= values.length) break;
                }
           }
        });
    }, 700);
    

    $(".multiselect_dd .multi-menu li").on("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        var control = $(this).closest(".multiselect_dd");

        if(!$(this).hasClass("control")) {
            var isItemSelected = $(this).hasClass("selected");

            if(selectedOptionsTotalCount < 20 || isItemSelected) {
                $(this).toggleClass("selected")

                var name = control.attr("id");
                control.multi_select('_setSelected');
                $("[name='"+name+"']").val(control.multi_select('getSelectedValues').join(";"));
                
                updateTotalSelectionCount();
                
            }
            else {
                alert(promptMessages.itemSelectionLimitReached);
            }
        }
        else {
            var control = $(this).closest(".multiselect_dd");
            control.multi_select('clearValues');
            updateTotalSelectionCount();
        }

        if(control.multi_select("getSelectedValues").length == 0) {
            control.find(".control").addClass("dd_disabled");
        }
        else {
            control.find(".control").removeClass("dd_disabled");
        }
    });

})

var selectedOptionsTotalCount = 0;

function updateTotalSelectionCount() {
    var count = 0;
    $(".multiselect_dd").each(function(i){
        count += $(this).multi_select("getSelectedValues").length
    })
    selectedOptionsTotalCount = count;
}

function ObjectArrayToKeyValueJSON(obj) {
    var kvList = {};
    for(var i in obj) {
        kvList[obj[i].Value] = obj[i].Label
    }
    return kvList;
}
