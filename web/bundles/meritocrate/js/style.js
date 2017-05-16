/**
 * Created by Florent on 16/05/2017.
 */

$(document).ready(function() {
    Materialize.updateTextFields();

    $('.datepicker').pickadate({
        selectMonths: true,
        selectYears: 150
    });
});
