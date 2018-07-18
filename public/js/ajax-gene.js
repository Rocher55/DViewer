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

                    if(data.length > 0){
                        $.each(data, function (i, item) {
                            dropdown.append($('<option>', { value: item, text : item }));
                        });
                        dropdown.css('border-color','');
                    }else{
                        dropdown.css('border-color','red');
                    }

                },
                'json'
            );
        }
    });
});

//contextmenu == clic droit
//doit toujours retourner false
$('[name="gene"]').on('contextmenu',function(){
    let textarea = $('[name="genes"]');

    if($('[name="gene"] option:selected').val()) {
        if (textarea.val().length == 0) {
            textarea.val(textarea.val() + $('[name="gene"] option:selected').val());
        } else {
            textarea.val(textarea.val() + '; ' + $('[name="gene"] option:selected').val());
        }
    }
    return false;
});