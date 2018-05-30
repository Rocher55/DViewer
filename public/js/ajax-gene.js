$('#recherche').autocomplete({
    source : function(requete, reponse){
        $.ajax({
            type:'POST',
            url : '/ajax', // on appelle le script JSON
            dataType : 'JSON', // on spécifie bien que le type de données est en JSON
            data : {
                _token : '<?php echo csrf_token() ?>',
                term : $('#recherche').val(), // on donne la chaîne de caractère tapée dans le champ de recherche
                maxRows : 15
            },

            success : function(donnee){
                reponse($.map(donnee.gene, function(objet){
                    return objet; // on retourne cette forme de suggestion
                }));
            }
        });
    },
    minLength : 3 // on indique qu'il faut taper au moins 3 caractères pour afficher l'autocomplétion
});