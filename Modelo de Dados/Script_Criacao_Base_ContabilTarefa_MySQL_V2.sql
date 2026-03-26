-- Criado manualmente via tradução técnica de DDL Oracle para MySQL
-- Removidos erros de tamanho de identificador e tipos incompatíveis

CREATE TABLE tenant (
    tenantid   INT NOT NULL,
    tenantdesc VARCHAR(255) NOT NULL,
    tenantcnpj VARCHAR(20) NOT NULL,
    CONSTRAINT tenant_pk PRIMARY KEY (tenantid)
);

CREATE TABLE tipo_documento (
    doctypeid   INT NOT NULL,
    doctypedesc VARCHAR(255) NOT NULL,
    CONSTRAINT tipo_documento_pk PRIMARY KEY (doctypeid)
);

CREATE TABLE servico (
    servico_id   INT NOT NULL,
    servico_desc VARCHAR(255) NOT NULL,
    CONSTRAINT servico_pk PRIMARY KEY (servico_id)
);

CREATE TABLE usuario_cliente (
    userclientid           INT NOT NULL,
    userclientcnpj         VARCHAR(20) NOT NULL,
    userclientname         VARCHAR(255) NOT NULL,
    userclientemail        VARCHAR(255) NOT NULL,
    tenant_id              INT NOT NULL,
    userclientinadimplente TINYINT NOT NULL DEFAULT 0,
    CONSTRAINT usuario_cliente_pk PRIMARY KEY (userclientid),
    CONSTRAINT usuario_cliente_tenant_fk FOREIGN KEY (tenant_id) REFERENCES tenant (tenantid)
);

CREATE TABLE usuario_contabilidade (
    accountinguserid    INT NOT NULL,
    accountinguserdesc  VARCHAR(255) NOT NULL,
    accountinguseremail VARCHAR(255) NOT NULL,
    tenant_id           INT NOT NULL,
    cpf_usuario         VARCHAR(14),
    CONSTRAINT usuario_contabilidade_pk PRIMARY KEY (accountinguserid),
    CONSTRAINT usuario_contabilidade_tenant_fk FOREIGN KEY (tenant_id) REFERENCES tenant (tenantid)
);

CREATE TABLE execucao_servico (
    serviceexecutionid      INT NOT NULL,
    datetime_creation       DATETIME NOT NULL,
    usuario_cont_id         INT,
    usuario_cli_id          INT NOT NULL,
    servico_id              INT NOT NULL,
    CONSTRAINT execucao_servico_pk PRIMARY KEY (serviceexecutionid),
    CONSTRAINT exec_serv_servico_fk FOREIGN KEY (servico_id) REFERENCES servico (servico_id),
    CONSTRAINT exec_serv_usu_cli_fk FOREIGN KEY (usuario_cli_id) REFERENCES usuario_cliente (userclientid),
    CONSTRAINT exec_serv_usu_cont_fk FOREIGN KEY (usuario_cont_id) REFERENCES usuario_contabilidade (accountinguserid)
);

CREATE TABLE andamento_execucao (
    followup_id         INT NOT NULL,
    execucao_servico_id INT NOT NULL,
    followup_txt        TEXT NOT NULL,
    followup_datetime   DATETIME NOT NULL,
    status_execution    VARCHAR(50) NOT NULL,
    CONSTRAINT andamento_execucao_pk PRIMARY KEY (followup_id),
    CONSTRAINT andamento_exec_serv_fk FOREIGN KEY (execucao_servico_id) REFERENCES execucao_servico (serviceexecutionid)
);

CREATE TABLE documento (
    documentid           INT NOT NULL,
    documentname         VARCHAR(255) NOT NULL,
    docdatetime          DATETIME NOT NULL,
    documentpath         VARCHAR(500) NOT NULL,
    tipo_documento_id    INT NOT NULL,
    andamento_servico_id INT NOT NULL,
    CONSTRAINT documento_pk PRIMARY KEY (documentid),
    CONSTRAINT doc_tipo_fk FOREIGN KEY (tipo_documento_id) REFERENCES tipo_documento (doctypeid),
    CONSTRAINT doc_andamento_fk FOREIGN KEY (andamento_servico_id) REFERENCES andamento_execucao (followup_id)
);

CREATE TABLE servicos_cliente (
    clientserviceid   INT NOT NULL,
    servico_id        INT NOT NULL,
    usuario_cliente_id INT NOT NULL,
    clientservicefreq VARCHAR(100) NOT NULL,
    CONSTRAINT servicos_cliente_pk PRIMARY KEY (clientserviceid),
    CONSTRAINT serv_cli_servico_fk FOREIGN KEY (servico_id) REFERENCES servico (servico_id),
    CONSTRAINT serv_cli_usuario_fk FOREIGN KEY (usuario_cliente_id) REFERENCES usuario_cliente (userclientid)
);