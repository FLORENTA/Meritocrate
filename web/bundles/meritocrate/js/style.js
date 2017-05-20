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

/***** LIST OF ROUTES TO TEST *****/
var register = /\/register/;
var profileEdit = /profile\/edit/;

/* NAMESPACES */
var namespaces = {
    register: function(){
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
                e.preventDefault()
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

        function ajaxPost(url, confirmEdit, formData) {
            var req = new XMLHttpRequest();
            req.open('post', url, true);
            req.addEventListener('load', function () {
                if (req.status >= 200 && req.status < 400) {
                    confirmEdit(req.responseText);
                }
            });
            req.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            req.send(formData);
        }

        function confirmEdit(response) {
            alert(response);
        }

        var formElt = document.getElementsByTagName('form');

        formElt[0].addEventListener('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            ajaxPost(window.location.href, confirmEdit, formData);
        });
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




