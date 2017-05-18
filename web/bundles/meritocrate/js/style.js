/**
 * Created by Florent on 16/05/2017.
 */

'use strict';

$(document).ready(function() {
    $('select').material_select();
    Materialize.updateTextFields();
});

var inputFileElt = document.querySelectorAll('form #fos_user_registration_form_picture');
var checkPictureElt = document.getElementById('check-picture');
inputFileElt[0].addEventListener('change', function(){

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

    deleteElt.addEventListener('click', function(e){
        e.preventDefault()
        this.previousElementSibling.remove();
        this.remove();
        reset();
    });
});
