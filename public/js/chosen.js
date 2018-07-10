$(function(){
    $(".chosen-tag").chosen({
        width: "95%"
    });

    $(".single-chosen-tag").chosen({
        max_selected_options: 1,
        width: "40%",
        disable_search: true
    })

    $(".unite-chosen-tag").chosen({
        max_selected_options: 1,
        disable_search: true
    })

    $(".cid-chosen-tag").chosen({
        width: "40%",
        disable_search: true
    })

    $(".analyse-chosen-tag").chosen({
       // max_selected_options : 1,
        width: "95%",
        disable_search: true
    })
});