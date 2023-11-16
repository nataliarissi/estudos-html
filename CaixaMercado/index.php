<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixa</title>
    <style>
        
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1, h2 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input, button {
            margin-bottom: 10px;
        }

        button {
            background-color: rgb(13, 2, 135);
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 5px;
        }

        #relatorio {
            margin-top: 20px;
        }
        
    </style>
</head>
<style>
        body {
            background-image: url('fnaf.png');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
            height: 100vh;
        }
        .content {
            padding: 20px;
            color: white;
        }
    </style>
<body>   
    <h1>Caixa</h1>
    
    <form id="checkoutForm">
        <label for="productName">Nome do Produto:</label>
        <input type="text" id="productName" required>
        
        <label for="productPrice">Preço do Produto:</label>
        <input type="number" id="productPrice" step="0.01" required>

        <label for="productQuantity">Quantidade do Produto:</label>
        <input type="number" id="productQuantity" required>
        
        <button onclick="addItem()">Adicionar Item</button>
    </form>

    <h2>Itens Comprados</h2>
    <ul id="itemsList"></ul>

    <p>Total: R$ <span id="totalAmount">0.00</span></p>

    <button onclick="cadastrarItens()">Finalizar Compra</button>

    <button onclick="gerarRelatorio()">Gerar Relatório</button>
    <br/>
    <?php require 'metodos.php'?>

    <div id="relatorio"></div>

    <script>
        let items = [];
        let totalAmount = 0;

        function addItem() {
            const productName = document.getElementById('productName').value;
            const productPrice = parseFloat(document.getElementById('productPrice').value);
            const productQuantity = parseInt(document.getElementById('productQuantity').value);

            if (productName && !isNaN(productPrice) && !isNaN(productQuantity) && productQuantity > 0) {
                items.push({ nome: productName, preco: productPrice, quantidade: productQuantity });
                updateItemList();
                updateTotalAmount();
                clearForm();
            }
        }

        function updateItemList() {
            const itemsList = document.getElementById('itemsList');
            itemsList.innerHTML = '';
            items.forEach(item => {
                const li = document.createElement('li');
                li.textContent = `${item.nome} - R$ ${item.preco.toFixed(2)} x ${item.quantidade}`;
                itemsList.appendChild(li);
            });
        }

        function updateTotalAmount() {
            totalAmount = items.reduce((total, item) => total + item.preco * item.quantidade, 0);
            document.getElementById('totalAmount').textContent = totalAmount.toFixed(2);
        }

        function clearForm() {
            document.getElementById('productName').value = '';
            document.getElementById('productPrice').value = '';
            document.getElementById('productQuantity').value = '';
        }
        
        function cadastrarItens(){
            const form = document.createElement('form');
            form.style.display = 'none';
            form.method = 'post';
            form.action = window.location.href;

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'itensCadastrados';
            input.value = JSON.stringify(items);

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }

        function gerarRelatorio(){
            const form = document.createElement('form');
            form.style.display = 'none';
            form.method = 'post';
            form.action = window.location.href; 
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'relatorioSolicitado';
            input.value = "true";
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>