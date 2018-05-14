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
});