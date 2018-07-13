/*
* -----------------------------------------------------------------------------
* ---------------- Gestion de la saisie de l'utilisateur ----------------------
* -----------------------------------------------------------------------------
*/

let error = [];
let path = window.location.pathname;

//Verifie qu'au moins 1 nom de variable est choisit pour etre dans le resultat
$( "input[type=checkbox]" ).on( "click", function(){
    var n = $( "input:checked" ).length;    //Nombre de case cochees

    if(n == 0  ){
        error.push('nb');
    }else{
        remove('nb');
    }
    reactToErrors();
} );



//Au changement de valeur d'un champ de type number
$( "input[type=number]" ).on( "change", function(){
        var elt = this;
        //En fonction de notre position actuelle
        switch(path){
            case '/research/patient':
                twoPartsVerif(elt);
                break;
            case '/research/food':
                twoPartsVerif(elt);
                break;
            case '/research/biochemistry':
                threePartsVerif(elt);
                break;
        }
});



//Comparer les valeurs de champ dont les id ont le format
// id-from  ou id-to
function twoPartsVerif(elt){
    //Infos de l'element qui vient de changer
    var id = elt.getAttribute("id");
    var explode = id.split('-');
    var changedValue = parseInt(elt.value);

    //Infos de l'autre element
    var opositeId;
    //En fonction du type de valeur saisie (valeur de debut ou de fin)
    switch(explode[1]){
        case 'from':
            opositeId = "#"+explode[0]+"-to";
            break;
        case 'to':
            opositeId = "#"+explode[0]+"-from";
            break;
    }
    var opositeValue = parseInt($(opositeId).val());

        switch(explode[1]){
            case 'from':
                if(changedValue > opositeValue){
                    $("#"+id).css('border-color', 'red');
                    $(opositeId).css('border-color', 'red');

                    add(explode[0]);
                }else{
                    $("#"+id).css('border-color', '');
                    $(opositeId).css('border-color', '');

                    remove(explode[0]);
                }
                break;
            case 'to':
                if(changedValue < opositeValue){
                    $("#"+id).css('border-color', 'red');
                    $(opositeId).css('border-color', 'red');

                    add(explode[0]);
                }else{
                    $("#"+id).css('border-color', '');
                    $(opositeId).css('border-color', '');

                    remove(explode[0]);
                }
                break;
        }
reactToErrors();
}



//Comparer les valeurs de champ dont les id ont le format
// idN-from-idUM  ou idN-to-idUM
function threePartsVerif(elt){
    //Infos de l'element qui vient de changer
    var id = elt.getAttribute("id");
    var explode = id.split('-');
    var changedValue = parseInt(elt.value);

    //Infos de l'autre element
    var opositeId;
    //En fonction du type de valeur saisie (valeur de debut ou de fin)
    switch(explode[1]){
        case 'from':
            opositeId = "#"+explode[0]+"-to-"+explode[2];
            break;
        case 'to':
            opositeId = "#"+explode[0]+"-from-"+explode[2];
            break;
    }
    var opositeValue = parseInt($(opositeId).val());


    switch(explode[1]){
        case 'from':
            if(changedValue > opositeValue){
                $("#"+id).css('border-color', 'red');
                $(opositeId).css('border-color', 'red');

                add(explode[0]+'-'+explode[2]);
            }else{
                $("#"+id).css('border-color', '');
                $(opositeId).css('border-color', '');

                remove(explode[0]+'-'+explode[2]);
            }
            break;
        case 'to':
            if(changedValue < opositeValue){
                $("#"+id).css('border-color', 'red');
                $(opositeId).css('border-color', 'red');

                add(explode[0]+'-'+explode[2]);
            }else{
                $("#"+id).css('border-color', '');
                $(opositeId).css('border-color', '');

                remove(explode[0]+'-'+explode[2]);
            }
            break;
    }
    reactToErrors();
}



//Change l'etat du bouton suivant en fonction du nombre
//d'erreurs et du nombre de cases cochees
function reactToErrors(){

    if(path != '/research/biochemistry'){
        var n = 1;
    }else{
        var n = $( "input:checked" ).length;    //Nombre de case cochees
    }

    if(error.length == 0 && n > 0){
        $(".next-button").prop("disabled", false);
    }else{
        $(".next-button").prop("disabled",true);
    }
}

//Ajoute un element au tableau des erreurs
function add(toAdd){
    error.push(toAdd);
    error = [...new Set(error)];
}
//Supprime un element du tableau des erreurs
function remove(toRemove){
    var indice = error.indexOf(toRemove);
    if(indice != -1){
        error.splice(indice,1)
    }
}



/*
* -----------------------------------------------------------------------------
* ---------------- Suppression de la saisie de l'utilisateur ----------------------
* -----------------------------------------------------------------------------
*/
function resetFields(){
    switch(path){
        case '/research/protocol':
        case '/research/center':
            $(".chosen-tag").val([]).trigger('chosen:updated');
            break;
        case '/research/patient':
            $(".single-chosen-tag").val([]).trigger('chosen:updated');
            $("#form")[0].reset()
            break;
        case '/research/cid':
            $(".cid-chosen-tag").val([]).trigger("chosen:updated");
            break;
        case '/research/food':
            $(".unite-chosen-tag").val([]).trigger("chosen:updated");
            $("#form")[0].reset()
            break;
        case '/research/biochemistry':
            reactToErrors();
            $("#form")[0].reset()
            break;
        case '/research/analyse':
            $(".analyse-chosen-tag").val([]).trigger("chosen:updated");
            break;
        case '/research/select-gene':
            $("#form")[0].reset()
            break;
    }
    reactToErrors();
}