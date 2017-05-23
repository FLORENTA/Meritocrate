/**
 * Created by Florent Alemany on 16/05/2017.
 */

'use strict';

/***** LIST OF ROUTES TO CHECK *****/
var register = /\/register/;
var profileEdit = /\/profile\/edit/;
var discussion = /\/discussion/;
var newGroup = /\/new/;
var chat = /\/livechat/;

/***** NAMESPACES *****/
var namespaces = {
    /***** DISPLAY BURGER MENU WITH SOME EFFECT *****/
    burger: function () {
        var burgerElt = document.getElementById('burger');
        var crossElt = document.getElementById('cross');
        var inf768ListElt = document.getElementById('inf768List');
        var liElts = document.querySelectorAll("#inf768List > li");

        burgerElt.addEventListener('click', function () {
            inf768ListElt.style.display = 'flex';
            for(var i=0; i<4; i++){
                liElts[i].style.display = 'none';
            }
            var interval = setInterval(height, 100);
            var height = 0;

            function height() {
                if (height >= 400) {
                    clearInterval(interval);
                }
                else {
                    height += 100;
                    if (height === 100) {
                        liElts[0].style.display = "block";
                    }
                    if (height === 200) {
                        liElts[1].style.display = "block";
                    }
                    if (height === 300) {
                        liElts[2].style.display = "block";
                    }
                    if (height === 400) {
                        liElts[3].style.display = "block";
                    }
                    inf768ListElt.style.height = height + '%';
                }
            }

            this.style.display = 'none';
            this.nextElementSibling.style.display = 'block';
        });

        crossElt.addEventListener('click', function () {
            inf768ListElt.style.display = 'none';
            this.style.display = 'none';
            this.previousElementSibling.style.display = 'block';

            /* Put the height back to 0 for following clicks */
            inf768ListElt.style.height = '0';
        });
    },

    menu: function () {
        var liElts = document.querySelectorAll("#sup768List > li");

        for (var i = 0; i < 4; i++) {
            liElts[i].addEventListener('mouseover', function () {
                this.style.backgroundColor = "#26a69a";
            });
            liElts[i].addEventListener('mouseleave', function () {
                this.style.backgroundColor = "black";
            });
        }
    },

    jQuery: function () {
        $(document).ready(function () {
            $('select').material_select();
            Materialize.updateTextFields();
        });
    },

    req : function(url){
        var req = new XMLHttpRequest(url);
        req.open('post', url, true);
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        return req;
    },

    ajaxEdit: function ajaxPost(url, formData) {
        /* See handle Request in the controller */
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener('load', function () {
            if (req.status >= 200 && req.status < 400) {
                confirmEdit(req.responseText);
            }
        });
        req.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        req.send(formData);

        function confirmEdit(response) {
            location.reload();
        }
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
        var hiddenInputElt = document.getElementById('isDeleted');
        var imgElt = document.getElementById('avatar');
        var inputFileElt = document.querySelector('form #fos_user_profile_form_picture');
        var checkImageElt = document.getElementById('image-checking');

        inputFileElt.addEventListener('change', function(){
            deleteElt.style.display = 'none';
            var fileElt = this.files[0];
            var cancelOperationElt = document.createElement('button');
            var newImgElt = document.createElement('img');

            imgElt.style.display = 'none';
            cancelOperationElt.setAttribute('class', 'btn waves-effect waves-light red')
            cancelOperationElt.style.display = 'block';
            cancelOperationElt.textContent = 'Cancel operation';
            newImgElt.setAttribute('src', window.URL.createObjectURL(fileElt));

            checkImageElt.appendChild(newImgElt);
            checkImageElt.appendChild(cancelOperationElt);

            cancelOperationElt.addEventListener('click', function(){
                checkImageElt.removeChild(newImgElt);
                checkImageElt.removeChild(cancelOperationElt);
                inputFileElt.value = '';
                imgElt.style.display = 'block';
                newPictureElt.style.display = 'block';
                pictureElt.style.display = 'none';
                deleteElt.style.display = 'block';
            });
        });

        newPictureElt.addEventListener('click', function (e) {
            e.preventDefault();
            pictureElt.style.display = 'block';
            this.style.display = 'none';
        });

        deleteElt.addEventListener('click', function (e) {
            e.preventDefault();
            this.style.display = 'none';
            imgElt.remove();
            isDeleted.value = "true";
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
    speak : function ajaxPost(url, idUser, idGroup){
        var req = namespaces.req(url);
        req.addEventListener("load", function(){
            if(req.status >=200 && req.status <400){
                console.log(req.responseText);
            }
        });
        req.send("idUser="+idUser+"&idDiscussion="+idGroup+"");
    },

    /***** UPDATES THE SPEAKERS LIST EVERY 5 SECONDS *****/
    users : function ajaxUpdateUsers(url, callback, idLastSpeech, idGroup) {
        var req = namespaces.req(url);
        req.addEventListener("load", function () {
            if (req.status >= 200 && req.status < 400) {
                callback(req.responseText);
            }
        });
        req.send("idLastSpeech=" + idLastSpeech + "&idDiscussion=" + idGroup + "");
    },

    /***** SENDS A REQUEST WHEN SOMEONE PRESSES THE STAR *****/
    merits : function ajaxAddMerit(url, idSpeech, idRator) {
        var req = namespaces.req(url);
        req.addEventListener("load", function () {
            if (req.status >= 200 && req.status < 400) {
                show(req.responseText);
            }
        });
        req.send("idSpeech=" + idSpeech + "&idRator=" + idRator + "");

        function show(response) {
            console.log(response);
        }
    },

    newGroup : function(){
        namespaces.jQuery();
        var $privacyElt = $('#meritocratebundle_discussion_privacy');
        var $passwordInputElt = $('#password');
        $privacyElt.change(function(){
            if($(this).val() == 1){
                $passwordInputElt.fadeIn(800);
            }
            else{
                $passwordInputElt.fadeOut(800);
            }
        });
    },

    ajaxChat : function(url, formData){
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.setRequestHeader('X-requested-With', 'XMLHttpRequest');
        req.send(formData);
    },

    ajaxGetMessages : function(url, idLastMessage, idDiscussion){
        var req = new XMLHttpRequest();
        req.open('post', url, true);
        req.addEventListener('load', function(){
            if(req.status >= 200 && req.status < 400){
                show(req.responseText);
            }
        });
        req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        req.send('idLastMessage='+idLastMessage+'&idDiscussion='+idDiscussion+'');
    },

    chat : function(){
        var attachmentElt = document.getElementById('attachment');
        var textareaElt = document.getElementById('message');

        var formElt = document.querySelector('form');
        formElt.addEventListener('submit', function(e){
            e.preventDefault();
            var formData = new FormData(this);
            namespaces.ajaxChat(window.location.href, formData);
        });
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

/* if the route matches /new */
if(newGroup.test(location.href)){
    namespaces.newGroup();
}

if(chat.test(location.href)){
    namespaces.chat();
}

/* if the window width is less than 768 px, display burger menu */
if(window.innerWidth <= 768){
    namespaces.burger();
}
else{
    namespaces.menu();
}





