$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//$(".previous-button").on('click',
function sendPrevious(){
    let previousPath = window.location.pathname;
            $.post(
                '/ajax-previous',
                {
                    previous : previousPath
                },
                window.history.back()
            );

};
