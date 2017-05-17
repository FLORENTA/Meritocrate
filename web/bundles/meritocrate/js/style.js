/**
 * Created by Florent on 16/05/2017.
 */

$(document).ready(function() {

    $('select').material_select();
    Materialize.updateTextFields();

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 150
    });
});
