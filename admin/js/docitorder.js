jQuery(document).ready(function(){jQuery("#the-list").sortable({items:"tr",axis:"y",helper:fixHelper,update:function(e,r){jQuery.post(ajaxurl,{action:"update-menu-order",order:jQuery("#the-list").sortable("serialize")})}})});var fixHelper=function(e,r){return r.children().children().each(function(){jQuery(this).width(jQuery(this).width())}),r};