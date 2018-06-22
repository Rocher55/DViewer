$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('#recherche').change(function(){
        if($('#recherche').val().length >= 2){
            $.get(
                '/ajax',
                {
                    recherche : $('#recherche').val()
                },
                function(data){
                    let dropdown = $('[name="gene"]');

                    dropdown.find('option').remove().end();

                    $.each(data, function (i, item) {
                        dropdown.append($('<option>', { value: item, text : item }));
                    });
                },
                'json'
            );
        }
    });
});

$('[name="gene"]').dblclick(function(){
    let textarea = $('[name="genes"]');

    if($('[name="gene"] option:selected').val()) {
        if (textarea.val().length == 0) {
            textarea.val(textarea.val() + $('[name="gene"] option:selected').val());
        } else {
            textarea.val(textarea.val() + '; ' + $('[name="gene"] option:selected').val());
        }
    }
});