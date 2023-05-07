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
    
    /*var popup_form_close = document.getElementById("popup_form_close");
    popup_form_close.addEventListener("click", function() {
        popup_form.hide();
    }
    );*/
    


    
}

//fonction qui permet de faire des popups Bootstrap pour les formulaires (sans jQuery) (avec 4 entrées de texte)
function popupForm_edit(title, content, params, callback) {
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
    console.log("select_array");
    console.log(select_array);
    console.log(select_value);

    //compteur pour select_array
    let compteur = 0;
    let wd_fichier = 0; //0 = no modif, 1 = modif/add, 2 = suppr



    //on verifie si un element avec l'id "popup_form_submit" existe déjà
    if (document.getElementById("popup_form_submit")) {
        //on le supprime
        document.getElementById("popup_form_submit").remove();
        document.querySelectorAll('input[name="popup_form_radio"]').forEach(e => e.remove());
        document.getElementById("popup_form_input_1").remove();
        document.getElementById("popup_form_input_2").remove();
        document.getElementById("popup_form_input_3").remove();
        document.getElementById("popup_form_input_4").remove();
        document.getElementById("popup_form_input_5").remove();


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
                    <input type="date" class="form-control" id="popup_form_input_1" value="${params[0]}">
                </div>
                <div class="mb-3">
                    <label for="popup_form_input_2" class="form-label">${elt_2}</label>
                    <input type="text" class="form-control" id="popup_form_input_2" value="${params[1]}">
                </div>
                <div class="mb-3">
                    <label for="popup_form_input_3" class="form-label">${elt_3}</label>
                    <input type="number" class="form-control" id="popup_form_input_3" value="${params[2]}">
                </div>
                <div class="mb-3">
                    <label for="popup_form_input_4" class="form-label">${elt_4}</label>
                    <select class="form-select" aria-label="Default select example" id="popup_form_input_4">
                        `
                        + 
                        
                        
                        //select_array.map((elt) => `<option value="${elt}">${elt}</option>`).join("") 
                        
                        select_array.map((elt) => {
                            compteur++;
                            if (compteur.toString() === params[3]) {
                                return `<option value="${elt}" selected>${elt}</option>`
                            } else {
                                return `<option value="${elt}">${elt}</option>`
                            }
                        }).join("")
                        
                        +                        
                        
                        `
                    </select>
                </div>

                <div class="mb-3">

                    <label for="popup_form_input_5" class="form-label">Fichier : ${params[4].split("/")[2]}</label>
                    <input type="file" class="form-control" id="popup_form_input_5" value="${params[4]}" placeholder="${params[4]}">

                    `+ (params[4] != "" ? `
                    <br>
                    <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-4">
                            <a type="button" class="btn btn-primary" id="popup_form_submit_dl" href="./download.php/?id=${params[5]}" target="_blank">Télécharger</a>
                        </div>
                        <div class="col-md-4">
                            <input type="radio" id="popup_form_radio_1" name="popup_form_radio" value="0" checked>
                            <label for="popup_form_radio_1">Ne pas modifier</label><br>
                            <input type="radio" id="popup_form_radio_2" name="popup_form_radio" value="1">
                            <label for="popup_form_radio_2">Modifier/Ajouter</label><br>
                            <input type="radio" id="popup_form_radio_3" name="popup_form_radio" value="2">
                            <label for="popup_form_radio_3">Supprimer</label><br>
                        </div>
                        <div class="col-md-2"></div>
                    </div>

                    ` : "") + `
                    
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

    let finput = document.getElementById("popup_form_input_5");
    if (params[4] != "") {
        finput.style.display = "none";
    }
    let input_5_radio = 1; //0 = ne pas modifier, 1 = modifier/ajouter, 2 = supprimer
    
    let input_5_radio_node = document.querySelectorAll('input[name="popup_form_radio"]');
    if (input_5_radio_node.length != 0) {
        input_5_radio = 0;
    }

    input_5_radio_node.forEach((elt) => {
        elt.addEventListener("change", function() {
            input_5_radio = document.querySelector('input[name="popup_form_radio"]:checked').value;
            if (input_5_radio == 1) {
                finput.style.display = "block";
            } else {
                finput.style.display = "none";
            }
        });
    });




    popup_form_submit.addEventListener("click", function() {
        popup_form.hide();
        //on récupère les valeurs des inputs
        var input_1 = document.getElementById("popup_form_input_1").value;
        var input_2 = document.getElementById("popup_form_input_2").value;
        var input_3 = document.getElementById("popup_form_input_3").value;
        var input_4 = document.getElementById("popup_form_input_4");
        var input_5 = document.getElementById("popup_form_input_5");
        
        
        input_4 = input_4.selectedIndex + 1; //on récupère l'index de l'option sélectionnée (commence à 0) et on ajoute 1 pour avoir le bon id
        //on appelle la fonction callback avec les valeurs des inputs
        console.log("popupForm_edit : ");
        console.log(input_1);
        console.log(input_2);
        console.log(input_3);
        console.log(input_4);
        console.log(input_5);
        callback(input_1, input_2, input_3, input_4, input_5, input_5_radio.toString());
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
    console.log("delete frais 0");
    //console.log(details);
    //console.log(id);
    //console.log(file_name);
    //console.log("delete frais 1");
    popupForm_valide("Supprimer un frais", "Voulez-vous vraiment supprimer ce frais ? <br><strong>"+details.toString()+"</strong>.", function() {
        //on envoie la requête POST
        $.post(file_name, {delete_fraie: id}, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //console.log("delete frais 2");
            //c'est ok
            popupForm_valide("Frais supprimé", "Le frais a bien été supprimé.", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });

    }, "confirm");
}


//modifie un frais (avec popup de confirmation)
function editFrais(id, file_name, details, params) {
    console.log("edit frais 1");
    params.push(id);
    console.log(params);
    details = "<strong>" + details.toString() + "</strong>";
    
    
    popupForm_edit("Modifier un frais : " + details , ["Date : ", "Libellé : ", "Montant : ", "Type : "], params, function(input_1, input_2, input_3, input_4, input_5, input_5_radio) {
        //on envoie la requête POST
        /*$.post(file_name, {edit_frais: id, date_frais: input_1, libelle_frais: input_2, prix_frais: input_3, type_frais: input_4, input_5}, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm_valide("Frais modifié", "Le frais a bien été modifié.<br>", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });*/

        var data = new FormData();
        data.append("edit_frais", id);
        data.append("date_frais", input_1);
        data.append("libelle_frais", input_2);
        data.append("prix_frais", input_3);
        data.append("type_frais", input_4);
        data.append("file_frais_fl", input_5.files[0]);
        data.append("file_frais", input_5.value);
        data.append("action_frais", input_5_radio);
        post_ajax(file_name, data, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm_valide("Frais modifié", "Le frais a bien été modifié.<br>", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");
        });

    });
}

function post_ajax(file_name, data, callback) {

    //transforme les données en FormData
    //console.log("---------------------");
    //console.log(data);
    //var data = {data: JSON.stringify(data)}
    //console.log(data);

    $.ajax({
        url: file_name,
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        success: function(data) {
            callback(data);
            
        }
    });

   /*$.post(file_name, data, function(data) {
        callback(data);
    });*/


}

//post ajax greating
post_ajax("commercial.php", {greating: "hello"}, function() { console.log('greating'); });


//ajoute un frais (avec popup de confirmation)
function addFrais(file_name) {
    console.log("add frais 1");
    //details = "<strong>" + details.toString() + "</strong>";

    let intitule = document.getElementsByName("intitulé")[0].value;
    let prix = document.getElementsByName("prix")[0].value;
    let date = document.getElementsByName("date")[0].value;
    let type = document.getElementsByName("type")[0].value;
    let file = -1;
    //console.log(intitule);
    //console.log(prix);
    //console.log(date);
    //console.log(type);
    
    let user = -1; //on met -1 pour dire puisque de toute façon PAR DÉFAUT cette valeur ne sera pas utilisée dans le PHP

    if (document.getElementsByName("user").length != 0) {
        user = document.getElementsByName("user");
        //select 
        user = user[0].options[user[0].selectedIndex].value;
    }

    if (document.getElementsByName("file")[0].value.length != 0) {
        file = document.getElementsByName("file")[0];
    }


    console.log(user);
    console.log(file);
    let fjs_file = -1;
    let fjs_formData = -1;
    let n_file = "";

    popupForm_valide("Ajouter un frais : "+intitule.toString(), "Voulez-vous vraiment ajouter ce frais ?", function() {
        // If de verification si les champs sont rentrés        
        if (intitule.length != 0 & prix.length != 0 & date.length != 0 & type.length != 0){

            // Si un fichier est ajouté
            if (file.files.length != 0){
                // On récupère le fichier
                fjs_file = file.files[0];
                // On le met dans un FormData
                fjs_formData = new FormData();
                n_file = fjs_file.name;
                fjs_formData.append("file", fjs_file);
                

            }

            console.log("fromdata");

            console.log(fjs_file);
            console.log(n_file);
            console.log(fjs_formData.get("file"));
            
        
        //on envoie la requête POST
        let ajax_fromdata = new FormData();
        ajax_fromdata.append("add_frais", 1);
        ajax_fromdata.append("date_frais", date);
        ajax_fromdata.append("libelle_frais", intitule);
        ajax_fromdata.append("prix_frais", prix);
        ajax_fromdata.append("type_frais", type);
        ajax_fromdata.append("user", user);
        ajax_fromdata.append("n_file", n_file);
        ajax_fromdata.append("file", fjs_file);
        console.log("fromdata");
        console.log(ajax_fromdata);
        console.dir(ajax_fromdata);
        console.log({add_frais: 1, date_frais: date, libelle_frais: intitule, prix_frais: prix, type_frais: type, user: user, file: fjs_file});
        console.dir({add_frais: 1, date_frais: date, libelle_frais: intitule, prix_frais: prix, type_frais: type, user: user, file: fjs_file});

        post_ajax(file_name, ajax_fromdata, function(data) {
            //on recharge la page
            //location.reload();
            //console.log(data);
            //c'est ok
            popupForm_valide("Frais ajouté", "Le frais a bien été ajouté.<br>", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");

        });

        }
        
/*
        
                $.post(file_name, {add_frais: 1, date_frais: date, libelle_frais: intitule, prix_frais: prix, type_frais: type, user: user}, function(data) {
                    //on recharge la page
                    //location.reload();
                    //console.log(data);
                    //c'est ok
                    popupForm_valide("Frais ajouté", "Le frais a bien été ajouté.<br>", function() {
                        //on recharge la page après avoir fermé le popup
                        location.reload();
                    }, "ok");
                
                });}
                */
                

        // Sinon on affiche un message d'erreur disant de remplir tous les champs
        
        else {
            popupForm_valide("Erreur", "Veuillez remplir tous les champs", function() {
                //on recharge la page après avoir fermé le popup
                location.reload();
            }, "ok");
        }        
            
    }, "confirm");
    
}



//valide un frais (avec popup de confirmation)
function valideFrais(demande, id, file_name, details) {
	console.log(demande)
    console.log("frais");
	if(demande=="accepter"){
		popupForm_valide("Accepter ce frais ?", "Voulez-vous vraiment accepter ce frais ? <br><strong>"+details.toString()+"</strong>.", function() {
			//on envoie la requête POST
			$.post(file_name, {accept: id}, function(data) {
				//on recharge la page
				//location.reload();
				//console.log(data);
				//c'est ok
				popupForm_valide("Frais accepté", "Le fraie a bien été accepté.", function() {
					//on recharge la page après avoir fermé le popup
					location.reload();
				}, "ok");

			});


		}, "confirm");
	}
	else{
		popupForm_valide("Refuser ce frais ?", "Voulez-vous vraiment refuser ce frais ? <br><strong>"+details.toString()+"</strong>.", function() {
			//on envoie la requête POST
			$.post(file_name, {refuse: id}, function(data) {
				//on recharge la page
				//location.reload();
				//console.log(data);
				//c'est ok
				popupForm_valide("Frais refusé", "Le fraie a bien été refusé.", function() {
					//on recharge la page après avoir fermé le popup
					location.reload();
				}, "ok");

			});


		}, "confirm");
	}
}

window.onload = function() {
    //script à exécuter à la fin du chargement de la page

    //on récupère le rôle de l'utilisateur
    const role = document.getElementById("user_info").outerText.split(" ")[2];

    //on change une variable css
    if (role == "Admin") {
        document.documentElement.style.setProperty('--warn-elt-color', '#ff00004d');
    }
}