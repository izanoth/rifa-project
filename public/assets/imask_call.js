$(document).ready(function () {
    //FIELD MASK
    function mask(element, parameter) {
        IMask(element, {
            mask: parameter
        });
    }
    mask($('#phone')[0], '(00) 00000-0000');
    mask($('#cpf')[0], '000.000.000-00');
})