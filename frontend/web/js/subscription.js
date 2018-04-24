/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(function () {
    $('#frm_creditcard_process').validate({
        rules: {
            "card[card_number]": {
                required: true,
                creditcard: true,
                minlength: 13,
                maxlength: 16,
                digits: true
            },
            "card[cvv2]": {
                required: true,
                number: true,
                maxlength: 3
            }
        }
    });
});