//efeito de esconder formulário de cadastro

$(document).ready(function(){
//  document.getElementById("botao-cadastrar").click()
    $("#botao-cadastrar").click(function(){

        $("#form-cadastrar").slideToggle("slow");
        $("#section-login").slideToggle("slow");
        $("#botao-cadastrar").hide();
});
});