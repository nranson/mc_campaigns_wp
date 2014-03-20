jQuery(document).ready(function() {
jQuery("#sortable1, #sortable2").sortable({
  connectWith: ".connectedSortable"
}).disableSelection();
});
