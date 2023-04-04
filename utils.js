

//fonction qui permet de faire des popups Bootstrap pour les formulaires (sans jQuery)
function popupForm_valide(title, content, callback, mode) {
    //structure du popup (avec Bootstrap) en HTML :

    let ppBtn;
    let ppClose;

    //on verifie si un element avec l'id "popup_form_submit" existe déjà
    if (document.getElementById("popup_form_submit")) {
        //on le supprime
        document.getElementById("popup_form_submit").remove();
    };

    //mode : confirm ou ok
    if (mode=="confirm") {
        ppBtn = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="popup_form_submit">Confirmer</button>
        `;
        ppClose = `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`;
    } else if (mode=="ok") {
        ppBtn = `
        <button type="button" class="btn btn-primary" id="popup_form_submit">OK</button>
        `;
        ppClose = ``;
    };


    var popup = document.createElement("div");
    popup.className = "modal fade";
    popup.id = "popup_form";
    popup.setAttribute("tabindex", "-1");
    popup.setAttribute("aria-labelledby", "popup_form_label");
    popup.setAttribute("aria-hidden", "true");
    popup.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popup_form_label">${title}</h5>
                    ${ppClose}
                </div>
                `
                + (content ? `<div class="modal-body">${content}</div>` : "") +
                `
                <div class="modal-footer">
                    ${ppBtn}
                </div>
            </div>
        </div>
    `;
    document.body.appendChild(popup);
    //on affiche le popup
    var popup_form = new bootstrap.Modal(popup);
    popup_form.show();
    //on ajoute un listener sur le bouton de confirmation
    var popup_form_submit = document.getElementById("popup_form_submit");
    popup_form_submit.addEventListener("click", function() {
        popup_form.hide();
        callback();
    }
    );

    //on ajoute un listener sur le bouton de fermeture
    
    var popup_form_close = document.getElementById("popup_form_close");
    popup_form_close.addEventListener("click", function() {
        popup_form.hide();
    }
    );
    


    
}

//fonction qui permet de faire des popups Bootstrap pour les formulaires (sans jQuery) (avec 4 entrées de texte)
function popupForm_edit(title, content, callback) {
    //structure du popup (avec Bootstrap) en HTML :

    let ppBtn;
    let ppClose;
    //content en tant que tableau de 4 éléments : [0] = texte 1, [1] = texte 2, [2] = texte 3, [3] = texte 4
    //on verifie si content est un tableau
    if (!Array.isArray(content)) {
        //on affiche un message d'erreur
        console.log("popupForm_edit : content n'est pas un tableau");
        return;
    }

    let elt_1 = content[0]; //premier texte pour la première entrée (ex: "Nom :")
    let elt_2 = content[1];
    let elt_3 = content[2];
    let elt_4 = content[3];

    //recuperation des valeurs des options du select
    let select = document.getElementById("type");
    let select_value = select.options
    let select_array = [];
    for (let i = 0; i < select_value.length; i++) {
        //on prend le texte de l'option
        select_array.push(select_value[i].text);
    }

    console.log(select_array);
    console.log(select_value);



    //on verifie si un element avec l'id "popup_form_submit" existe déjà
    if (document.getElementById("popup_form_submit")) {
        //on le supprime
        document.getElementById("popup_form_submit").remove();
    };

    //mode : confirm ou ok
        ppBtn = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
        <button type="button" class="btn btn-primary" id="popup_form_submit">Confirmer</button>
        `;
        ppClose = `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`;

    var popup = document.createElement("div");
    popup.className = "modal fade";
    popup.id = "popup_form";
    popup.setAttribute("tabindex", "-1");
    popup.setAttribute("aria-labelledby", "popup_form_label");
    popup.setAttribute("aria-hidden", "true");
    popup.innerHTML = `
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="popup_form_label">${title}</h5>
                    ${ppClose}
                </div>
                `
                + (content ? `<div class="modal-body">
                <div class="mb-3">
                    <label for="popup_form_input_1" class="form-label">${elt_1}</label>
                    <input type="date" class="form-control" id="popup_form_input_1">
                </div>
                <div class="mb-3">
                    <label for="popup_form_input_2" class="form-label">${elt_2}</label>
                    <input type="text" class="form-control" id="popup_form_input_2">
                </div>
                <div class="mb-3">
                    <label for="popup_form_input_3" class="form-label">${elt_3}</label>
                    <input type="text" class="form-control" id="popup_form_input_3">
                </div>
                <div class="mb-3">
                    <label for="popup_form_input_4" class="form-label">${elt_4}</label>
                    <select class="form-select" aria-label="Default select example" id="popup_form_input_4">
                        `
                        + select_array.map((elt) => `<option value="${elt}">${elt}</option>`).join("") +                        
                        
                        `
                    </select>
                </div>
                </div>` : "") + //fin du if content
                `
                <div class="modal-footer">
                    ${ppBtn}
                </div>

            </div>
        </div>
    `;
    document.body.appendChild(popup);
    //on affiche le popup
    var popup_form = new bootstrap.Modal(popup);
    popup_form.show();
    //on ajoute un listener sur le bouton de confirmation
    var popup_form_submit = document.getElementById("popup_form_submit");
    popup_form_submit.addEventListener("click", function() {
        popup_form.hide();
        //on récupère les valeurs des inputs
        var input_1 = document.getElementById("popup_form_input_1").value;
        var input_2 = document.getElementById("popup_form_input_2").value;
        var input_3 = document.getElementById("popup_form_input_3").value;
        var input_4 = document.getElementById("popup_form_input_4").value;
        //on appelle la fonction callback avec les valeurs des inputs
        callback(input_1, input_2, input_3, input_4);
    }
    );





}






//soumission de formulaire
function submitForm(form, file_name, callback) {
    var data = {};
    form.find("input, select, textarea").each(function() {
        data[$(this).attr("name")] = $(this).val();
    });
    $.post(file_name, data, function(data) {
        callback(data);
    });
}



//supprime un utilisateur (avec popup de confirmation)
function deleteUser(id, file_name, details) {
    console.log("delete user 1");
    popupForm_valide("Supprimer un utilisateur", "Voulez-vous vraiment supprimer cet utilisateur ? <br><strong>"+details.toString()+"</strong>.", function() {
        //on envoie la requête POST
        $.post(file_name, {delete_user: id}, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm_valide("Utilisateur supprimé", "L'utilisateur a bien été supprimé.", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });


    }, "confirm");
}


//supprime un frais (avec popup de confirmation)
function deleteFrais(id, file_name, details) {
    console.log("delete frais 1");
    popupForm_valide("Supprimer un frais", "Voulez-vous vraiment supprimer ce frais ? <br><strong>"+details.toString()+"</strong>.", function() {
        //on envoie la requête POST
        $.post(file_name, {delete_frais: id}, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm_valide("Frais supprimé", "Le frais a bien été supprimé.", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });

    }, "confirm");
}


//modifie un frais (avec popup de confirmation)
function editFrais(id, file_name, details) {
    console.log("edit frais 1");
    details = "<strong>" + details.toString() + "</strong>";
    let TODO = "<strong>TODO : le code PHP pour modifier un frais</strong>";
    popupForm_edit("Modifier un frais (WIP) : " + details + " (id : "+id+")", ["Date : ", "Libellé : ", "Montant : ", "Type : "], function(input_1, input_2, input_3, input_4) {
        //on envoie la requête POST
        $.post(file_name, {edit_frais: id, date: input_1, libelle: input_2, montant: input_3, justificatif: input_4}, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm_valide("Frais modifié", "Le frais a bien été modifié.<br>"+TODO, function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });

    });
}



