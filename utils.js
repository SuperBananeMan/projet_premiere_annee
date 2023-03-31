

//fonction qui permet de faire des popups Bootstrap pour les formulaires (sans jQuery)
function popupForm(title, content, callback, mode) {
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
    popupForm("Supprimer un utilisateur", "Voulez-vous vraiment supprimer cet utilisateur ? <br><strong>"+details.toString()+"</strong>.", function() {
        //on envoie la requête POST
        $.post(file_name, {delete_user: id}, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm("Utilisateur supprimé", "L'utilisateur a bien été supprimé.", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });


    }, "confirm");
}





