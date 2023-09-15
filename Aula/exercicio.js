function tabela_dinamica(){

    var totalDeLinhas = prompt("Digite a qunantidade de linhas da tabela");
    var totalDeColunas = prompt("Digite a qunantidade de colunas da tabela");
    var contador = 1;

    document.write("<table border = '1'>");

    for(var linha = 0; linha < totalDeLinhas; linha++){
        if(linha %2 == 0){
            document.write("<tr bgcolor='blue'>");
        }else{
            document.write("<tr bgcolor='white'>");
        }

        for(var coluna = 0; coluna < totalDeColunas; coluna++){
            document.write("<td>");
            document.write("coluna: " + (contador++));
            document.write("</td>");
        }
        document.write("</tr>");
    }
    document.write("</table>");
}

function exercicio7(){
    var nome = prompt("Digite o nome do produto");
    var preco = prompt("Digite o preço do produto");

    if(isNaN(preco)){
        alert("Preço digitado não é um número");
        return;
    }

    if(parseInt(preco) > 100){
        alert("Preço ultrapassa limite");
    }else{
        alert("Preço menor que 100");
    }
}