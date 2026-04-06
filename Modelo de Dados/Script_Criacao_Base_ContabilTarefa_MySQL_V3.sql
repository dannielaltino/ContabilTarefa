-- Configurações de sessão para compatibilidade
SET FOREIGN_KEY_CHECKS = 0;

-- Tabela: andamento_da_execucao_do_servico
CREATE TABLE andamento_da_execucao_do_servico (
    followupserviceexecutionid             INTEGER NOT NULL,
    execucao_do_servico_serviceexecutionid INTEGER NOT NULL,
    followupserviceexecutiontxt            VARCHAR(255) NOT NULL,
    followupserviceexecutiondatetime       DATETIME NOT NULL,
    statusserviceexecution                 VARCHAR(50) NOT NULL, -- Corrigido de 'unknown'
    PRIMARY KEY (followupserviceexecutionid)
);

-- Tabela: documento
CREATE TABLE documento (
    documentid                                               INTEGER NOT NULL,
    documentname                                             VARCHAR(255) NOT NULL,
    docdatetime                                              DATETIME NOT NULL,
    documentpath                                             VARCHAR(255) NOT NULL,
    tipo_de_documento_doctypeid                              INTEGER NOT NULL,
    andamento_da_execucao_do_servico_followupserviceexecutionid INTEGER NOT NULL,
    PRIMARY KEY (documentid)
);

-- Tabela: execucao_do_servico
CREATE TABLE execucao_do_servico (
    serviceexecutionid               INTEGER NOT NULL,
    serviceexecutiondatetimecreation DATETIME NOT NULL,
    `usuário_da_contabilidade_accountinguserid` INTEGER, -- Mantido acento com backticks
    `usuário_cliente_userclientid`   INTEGER NOT NULL,
    servico_serv_id                  INTEGER NOT NULL,
    `identificador_do_serviço`       INTEGER NOT NULL,
    PRIMARY KEY (serviceexecutionid)
);

-- Tabela: serviço
CREATE TABLE `serviço` (
    `identificador_do_serviço` INTEGER NOT NULL,
    `descrição_do_serviço`     VARCHAR(255) NOT NULL,
    PRIMARY KEY (`identificador_do_serviço`)
);

-- Tabela: serviços_de_cliente
CREATE TABLE `serviços_de_cliente` (
    clientserviceid                  INTEGER NOT NULL,
    `serviço_identificador_do_serviço` INTEGER NOT NULL,
    `usuário_cliente_userclientid`   INTEGER NOT NULL,
    clientservicefreq                VARCHAR(50) NOT NULL,
    PRIMARY KEY (clientserviceid)
);

-- Tabela: tenant
CREATE TABLE tenant (
    tenantid   INTEGER NOT NULL,
    tenantdesc VARCHAR(255) NOT NULL,
    tenantcnpj VARCHAR(20) NOT NULL,
    PRIMARY KEY (tenantid)
);

-- Tabela: tipo_de_documento
CREATE TABLE tipo_de_documento (
    doctypeid   INTEGER NOT NULL,
    doctypedesc VARCHAR(100) NOT NULL,
    PRIMARY KEY (doctypeid)
);

-- Tabela: usuário_cliente
CREATE TABLE `usuário_cliente` (
    userclientid         INTEGER NOT NULL,
    userclientcnpj       VARCHAR(20) NOT NULL,
    userclientname       VARCHAR(255) NOT NULL,
    userclientemail      VARCHAR(255) NOT NULL,
    tenant_tenantid      INTEGER NOT NULL,
    userclientinadimplente TINYINT(1) NOT NULL, -- Corrigido de NUMBER
    userclienttoken      VARCHAR(255) NOT NULL,
    userclienttimestamp  DATETIME NOT NULL,
    PRIMARY KEY (userclientid)
);

-- Tabela: usuário_da_contabilidade
CREATE TABLE `usuário_da_contabilidade` (
    accountinguserid        INTEGER NOT NULL,
    accountinguserdesc      VARCHAR(255) NOT NULL,
    accountinguseremail     VARCHAR(255) NOT NULL,
    tenant_tenantid         INTEGER NOT NULL,
    usucont_cpf_usuario     BIGINT,
    accountingusercpf       BIGINT NOT NULL,
    accountingusertoken     VARCHAR(255) NOT NULL,
    accountingusertimestamp DATETIME NOT NULL,
    PRIMARY KEY (accountinguserid)
);

-- Constraints de Chave Estrangeira (FKs)

ALTER TABLE andamento_da_execucao_do_servico
    ADD CONSTRAINT fk_andamento_execucao FOREIGN KEY (execucao_do_servico_serviceexecutionid)
    REFERENCES execucao_do_servico (serviceexecutionid);

ALTER TABLE documento
    ADD CONSTRAINT fk_doc_andamento FOREIGN KEY (andamento_da_execucao_do_servico_followupserviceexecutionid)
    REFERENCES andamento_da_execucao_do_servico (followupserviceexecutionid);

ALTER TABLE documento
    ADD CONSTRAINT fk_doc_tipo FOREIGN KEY (tipo_de_documento_doctypeid)
    REFERENCES tipo_de_documento (doctypeid);

ALTER TABLE execucao_do_servico
    ADD CONSTRAINT fk_exec_servico FOREIGN KEY (servico_serv_id)
    REFERENCES `serviço` (`identificador_do_serviço`);

ALTER TABLE execucao_do_servico
    ADD CONSTRAINT fk_exec_user_cli FOREIGN KEY (`usuário_cliente_userclientid`)
    REFERENCES `usuário_cliente` (userclientid);

ALTER TABLE execucao_do_servico
    ADD CONSTRAINT fk_exec_user_cont FOREIGN KEY (`usuário_da_contabilidade_accountinguserid`)
    REFERENCES `usuário_da_contabilidade` (accountinguserid);

ALTER TABLE `serviços_de_cliente`
    ADD CONSTRAINT fk_cli_serv_servico FOREIGN KEY (`serviço_identificador_do_serviço`)
    REFERENCES `serviço` (`identificador_do_serviço`);

ALTER TABLE `serviços_de_cliente`
    ADD CONSTRAINT fk_cli_serv_user_cli FOREIGN KEY (`usuário_cliente_userclientid`)
    REFERENCES `usuário_cliente` (userclientid);

ALTER TABLE `usuário_cliente`
    ADD CONSTRAINT fk_user_cli_tenant FOREIGN KEY (tenant_tenantid)
    REFERENCES tenant (tenantid);

ALTER TABLE `usuário_da_contabilidade`
    ADD CONSTRAINT fk_user_cont_tenant FOREIGN KEY (tenant_tenantid)
    REFERENCES tenant (tenantid);

SET FOREIGN_KEY_CHECKS = 1;