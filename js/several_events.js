all_events = $("div.custom-content-reveal > div.event").clone();
function show_hide() {
    current = $(this).text() - 1;
    all_events.each(function(i,e) {
        if(i == current) {
            $("div.custom-content-reveal > div.event").remove();
            $("div.custom-content-reveal").append(e);
        }
    });
}
if(all_events.length > 1) {
    $(".ca_container").append("<div class='col-md-2 select_container'><select class='form-control select'></select></div>");
    all_events.each(function(i) {
        $(".select").append("<option class='option'>"+(i + 1)+"</option>");
    });
    $(".option").bind("click", show_hide);
    $("div.custom-content-reveal > div.event:not(:first)").remove();
}