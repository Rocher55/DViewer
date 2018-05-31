$(document).ready(function () {
    $('#recherche').change(function(){
        $.ajax({
            url : 'ajax', // La ressource ciblée
            type : 'GET', // Le type de la requête HTTP.
            data : 'recherche='+$('#recherche').val()+'&_token='+$("[name='csrf-token']").val(),
            dataType : 'json',
            success: function() {
               window.alert('ok');
            }
        });
    });


});