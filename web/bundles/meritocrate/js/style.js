/**
 * Created by Florent Alemany on 16/05/2017.
 */

'use strict';

/***** LIST OF ROUTES TO CHECK *****/
var register = /\/register/;
var profileEdit = /\/profile\/edit/;
var discussion = /\/discussion/;

/***** NAMESPACES *****/
var namespaces = {
    /***** DISPLAY BURGER MENU WITH SOME EFFECT *****/
    burger: function(){
        var burgerElt = document.getElementById('burger');
        var crossElt = document.getElementById('cross');
        var inf768ListElt = document.getElementById('inf768List');
        var liElts = document.querySelectorAll("#inf768List > li");

        burgerElt.addEventListener('click', function() {
            inf768ListElt.style.display = 'flex';

            for(var i=0; i<liElts.length; i++){
                liElts[i].style.display = "none";
            }

            var interval = setInterval(height, 100);
            var height = 0;

            function height(){
                if(height >= 400){
                    clearInterval(interval);
                }
                else{
                    height += 100;
                    if(height === 100){
                        liElts[0].style.display = "block";
                    }
                    if(height === 200){
                        liElts[1].style.display = "block";
                    }
                    if(height === 300){
                        liElts[2].style.display = "block";
                    }
                    if(height === 400){
                        liElts[3].style.display = "block";
                    }

                    inf768ListElt.style.height = height + '%';
                }
            }
            this.style.display = 'none';
            this.nextElementSibling.style.display = 'block';
        });

        crossElt.addEventListener('click', function(){
            inf768ListElt.style.display = 'none';
            this.style.display = 'none';
            this.previousElementSibling.style.display = 'block';

            /* Put the height back to 0 for following clicks */
            inf768ListElt.style.height = '0';
        });
    },

    jQuery: function(){
        $(document).ready(function() {
            $('select').material_select();
            Materialize.updateTextFields();
        });
    },

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
            location.reload();
        }
    },

    ajaxDiscussion : function ajaxPost(url, callback, idUser, idGroup){
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener("load", function(){
            if(req.status >=200 && req.status <400){
                console.log(req.responseText);
            }
        });
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send("idUser="+idUser+"&idDiscussion="+idGroup+"");
    },

    register : function(){
        namespaces.jQuery();

        var inputFileElt = document.querySelectorAll('form #fos_user_registration_form_picture');
        var checkPictureElt = document.getElementById('check-picture');
        inputFileElt[0].addEventListener('change', function () {

            var file = this.files[0];
            var imgElt = document.createElement('img');
            var deleteElt = document.createElement('button');
            var iElt = document.createElement('i');

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
                inputFileElt[0].value = '';
            });
        });
    },

    profileEdit : function(){
        namespaces.jQuery();

        var submitElt = document.getElementById('submit');
        var processingElt = document.getElementById('processing');
        var pictureElt = document.getElementById('edit-picture');
        var newPictureElt = document.getElementById('new-picture');
        var deleteElt = document.getElementById('delete');
        var imgElt = document.getElementById('avatar');

        newPictureElt.addEventListener('click', function (e) {
            e.preventDefault();
            pictureElt.style.display = "block";
        });

        deleteElt.addEventListener('click', function (e) {
            e.preventDefault();
            imgElt.remove();
        });

        var formElt = document.getElementsByTagName('form');

        formElt[0].addEventListener('submit', function (e) {
            submitElt.disabled = true;
            processingElt.style.display = 'block';
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
                alert(req.responseText);
            }
        });
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send("idUser="+idUser+"&idDiscussion="+idGroup+"");
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
if(register.test(location.href)){
    namespaces.register();
}

/* if the route matches /profile/edit */
if(profileEdit.test(location.href)) {
    namespaces.profileEdit();
}

if(window.innerWidth <= 768){
    namespaces.burger();
}





