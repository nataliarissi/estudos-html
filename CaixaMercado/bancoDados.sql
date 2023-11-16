CREATE TABLE IF NOT EXISTS item (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    quantidade INT NOT NULL DEFAULT 1
);

INSERT INTO item (nome, preco, quantidade) VALUES 
('Chocolate', 10.00, 2),
('CocaCola', 15.50, 1),
('Leite', 5.25, 3);