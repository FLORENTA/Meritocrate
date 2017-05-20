/**
 * Created by Florent on 16/05/2017.
 */

'use strict';

$(document).ready(function() {
    $('select').material_select();
    Materialize.updateTextFields();

    $('.datepicker').pickadate({
        selectMonths: true, // Creates a dropdown to control month
        selectYears: 150 // Creates a dropdown of 15 years to control year
    });
});

/***** LIST OF ROUTES TO CHECK *****/
var register = /\/register/;
var profileEdit = /\/profile\/edit/;
var discussion = /\/discussion/;

/***** NAMESPACES *****/
var namespaces = {
    ajaxEdit: function ajaxPost(url, formData) {
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener('load', function () {
            if (req.status >= 200 && req.status < 400) {
                confirmEdit(req.responseText);
            }
        });
        req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        req.send(formData);

        function confirmEdit(response) {
            alert(response);
        }
    },

    ajaxDiscussion : function ajaxPost(url, callback, idUser, idGroup){
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener("load", function(){
            if(req.status >=200 && req.status <400){
                callback(req.responseText);
            }
        });
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send("idUser="+idUser+"&idDiscussion="+idGroup+"");
    },

    register : function(){
        console.log('yes');
        var inputFileElt = document.querySelectorAll('form #fos_user_registration_form_picture');
        var checkPictureElt = document.getElementById('check-picture');
        inputFileElt[0].addEventListener('change', function () {

            var file = this.files[0];
            var imgElt = document.createElement('img');
            var deleteElt = document.createElement('button');
            var iElt = document.createElement('i');

            console.log(file);

            deleteElt.setAttribute('class', 'btn waves-effect waves-light red');
            deleteElt.textContent = "delete";
            deleteElt.style.display = "block";

            iElt.setAttribute('class', 'material-icons left');

            deleteElt.appendChild(iElt);
            iElt.textContent = "delete";

            imgElt.setAttribute('src', window.URL.createObjectURL(file));
            checkPictureElt.appendChild(imgElt);
            checkPictureElt.appendChild(deleteElt);

            deleteElt.addEventListener('click', function (e) {
                e.preventDefault();
                this.previousElementSibling.remove();
                this.remove();
                reset();
            });
        });
    },

    profileEdit : function(){
        var pictureElt = document.getElementById('edit-picture');
        var newPictureElt = document.getElementById('new-picture');

        newPictureElt.addEventListener('click', function (e) {
            e.preventDefault();
            pictureElt.style.display = "block";
        });

        var formElt = document.getElementsByTagName('form');

        formElt[0].addEventListener('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            namespaces.ajaxEdit(window.location.href, formData);
        });
    },

    /***** SENDS A REQUEST WHEN SOMEONE PRESSES TO SPEAK *****/
    speak: function ajaxPost(url, idUser, idGroup){
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener("load", function(){
            if(req.status >=200 && req.status <400){
                show(req.responseText);
            }
        });
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send("idUser="+idUser+"&idDiscussion="+idGroup+"");

        function show(response) {
            setTimeout(function () {
                buttonSpeakElt.disabled = false;
            }, 3000);
        }
    },

    /***** UPDATES THE SPEAKERS LIST EVERY 5 SECONDS *****/
    users : function ajaxUpdateUsers(url, callback, idLastSpeech, idGroup) {
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener("load", function () {
            if (req.status >= 200 && req.status < 400) {
                callback(req.responseText);
            }
        });
        req.addEventListener("error", function () {
            console.log("erreur");
        });
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send("idLastSpeech=" + idLastSpeech + "&idDiscussion=" + idGroup + "");
    },

    /***** SENDS A REQUEST WHEN SOMEONE PRESSES THE STAR *****/
    merits : function ajaxAddMerit(url, idSpeech, idRator) {
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener("load", function () {
            if (req.status >= 200 && req.status < 400) {
                show(req.responseText);
            }
        });
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send("idSpeech=" + idSpeech + "&idRator=" + idRator + "");

        function show(response) {
            console.log(response);
        }
    }
};

/* if the route matches /register */
if(register.test(window.location.href)){
    namespaces.register();
}

/* if the route matches /profile/edit */
if(profileEdit.test(window.location.href)) {
    namespaces.profileEdit();
}






