function buscaCep() {
    retornoJson = '';
    var cep = document.getElementById('Cep').value;
    cep = cep.replace(/ - /g, "");
    $.ajax({
        url: 'https://viacep.com.br/ws/'+cep+'/json/',
        type: 'get',
        //contentType: 'application/json',
        data:{},
        header:{},
        //dataType: 'json',
        success: function(data){
            retornoJson = data;
        }
    }).done(function() {
        if (retornoJson.erro) {
            alert("CEP "+cep+" Inválido !");
        } else{
            //document.getElementById('jsonretorno').innerHTML = JSON.stringify(retornoJson);
            document.getElementById('Rua').value = retornoJson.logradouro;
            document.getElementById('Bairro').value = retornoJson.bairro;
            document.getElementById('Cidade').value = retornoJson.localidade;
            document.getElementById('Uf').value = retornoJson.uf;
            }
    });
}
$(document).ready(function () {
    $("#Cpf").mask("000.000.000-00");
    $('#Cep').mask('00000-000', {reverse: true});
    $('#Tel').mask('(00) 0000-0000');
    $('#Cel').mask('(00) 00000-0000')
});