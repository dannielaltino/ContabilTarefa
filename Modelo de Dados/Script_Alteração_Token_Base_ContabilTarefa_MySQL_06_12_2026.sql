-- Adição de campos na tabela de Usuário Cliente
ALTER TABLE usuario_cliente 
    ADD COLUMN userclienttoken VARCHAR(255) NULL,
    ADD COLUMN userclienttimestamp DATETIME NULL;

-- Adição de campos na tabela de Usuário da Contabilidade
ALTER TABLE usuario_contabilidade 
    ADD COLUMN accountingusertoken VARCHAR(255) NULL,
    ADD COLUMN accountingusertimestamp DATETIME NULL;