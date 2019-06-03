$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

path = window.location.pathname;
$(document).ready(function () {
    $('#recherche').on("change keyup", function(){
        if($('#recherche').val().length >= 2){
            $('[name="gene"]').css('border-color','');
            if(path.indexOf('webDV')>=0){
                $.get(
                    '/webDV/ajax-genes',
                    {
                        recherche : $('#recherche').val()
                    },
                    function(data){
                        displayGenesInLeftArray(data)
                    }
                    ,
                    'json'
                );
            }else{
                $.get(
                    '/ajax-genes',
                    {
                        recherche : $('#recherche').val()
                    },
                    function(data){
                        displayGenesInLeftArray(data)
                    },
                    'json'
                );
            }

        }
    });
});

function displayGenesInLeftArray(data){
    let dropdown = $('[name="gene"]');
    dropdown.find('li').remove().end();

    if(data.length > 0){
        $.each(data, function (i, item) {
            //dropdown.append($('<option>', { value: item, text : item }));
            dropdown.append($('<li class = "list-group-item">').html(item));
        });
        dropdown.css('border-color','');
    }else{
        dropdown.css('border-color','red');
    }
}

//contextmenu == clic droit
//doit toujours retourner false
$("ul").off().on("click", "li.list-group-item",function(event){

    pickOrRemove($(this).text());
    let SelectedGenes=$('[name="SelectedGenes"]');
    SelectedGenes.empty().end();
    $("#genes").val(listGene);

    $.each(listGene,function (i,item) {
        SelectedGenes.append($('<li class = "list-group-item">').html(item));
    })

    return false;
});


// Tableau symbolisant les genes choisis par l'utilisateur
listGene =  [];

//permet d'ajouter un gene a la liste des genes choisis par l'utilisateur si il n'est pas deja présent, l'enlève sinon.
function pickOrRemove(gene){
    let index = $.inArray(gene,listGene);
    //si l'élément gene est dans la liste
    if (index!==-1){
        listGene.splice(index,1); //enlever gene
    }else{
        listGene.push(gene);
        listGene.sort();
    }
}
