$(document).ready(function(){
  // Máscara para telefone
  var telefoneField = $('#telefone');

  var maskBehavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
  };

  var options = {
    onKeyPress: function(val, e, field, options) {
      field.mask(maskBehavior.apply({}, arguments), options);
    }
  };

  telefoneField.mask(maskBehavior, options);

  // Máscara para data de nascimento: dd/mm/aaaa
  $('#data_nascimento').mask('00/00/0000');
});
