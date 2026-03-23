-- Gerado por Oracle SQL Developer Data Modeler 23.1.0.087.0806
--   em:        2026-03-23 11:54:08 BRT

CREATE TABLE andamento_execucao_servico (
    andexeser_id        INTEGER NOT NULL,
    andexeser_exeser_id INTEGER NOT NULL,
    andexeser_descricao VARCHAR2(1000) NOT NULL,
    andexeser_data      DATE NOT NULL,
    andexeser_status    CHAR(1) NOT NULL
);

ALTER TABLE andamento_execucao_servico ADD CONSTRAINT andamento_execucao_servico_pk PRIMARY KEY ( andexeser_id );

CREATE TABLE documento (
    doc_id           INTEGER NOT NULL,
    doc_nome         VARCHAR2(100) NOT NULL,
    doc_data         DATE NOT NULL,
    doc_caminho      VARCHAR2(250) NOT NULL,
    doc_tipodoc_id   INTEGER NOT NULL,
    doc_andexeser_id INTEGER NOT NULL
);

ALTER TABLE documento ADD CONSTRAINT documento_pk PRIMARY KEY ( doc_id );

CREATE TABLE execucao_servico (
    exeser_id          INTEGER NOT NULL,
    exeser_datacriacao DATE NOT NULL,
    exeser_tenant_id   INTEGER,
    exeser_usucli_id   INTEGER NOT NULL
);

ALTER TABLE execucao_servico ADD CONSTRAINT execucao_servico_pk PRIMARY KEY ( exeser_id );

CREATE TABLE servico (
    serv_id        INTEGER NOT NULL,
    serv_descricao VARCHAR2(100) NOT NULL
);

ALTER TABLE servico ADD CONSTRAINT servico_pk PRIMARY KEY ( serv_id );

CREATE TABLE servicos_cliente (
    servcli_id         INTEGER NOT NULL,
    servcli_serv_id    INTEGER NOT NULL,
    servcli_usucli_id  INTEGER NOT NULL,
    servcli_frequencia VARCHAR2(30) NOT NULL
);

ALTER TABLE servicos_cliente ADD CONSTRAINT servicos_cliente_pk PRIMARY KEY ( servcli_id );

CREATE TABLE tenant (
    tenant_id   INTEGER NOT NULL,
    tenant_nome VARCHAR2(200) NOT NULL,
    tenant_cnpj VARCHAR2(50) NOT NULL
);

ALTER TABLE tenant ADD CONSTRAINT tenant_pk PRIMARY KEY ( tenant_id );

CREATE TABLE tipo_documento (
    tipodoc_id        INTEGER NOT NULL,
    tipodoc_descricao VARCHAR2(100) NOT NULL
);

ALTER TABLE tipo_documento ADD CONSTRAINT tipo_documento_pk PRIMARY KEY ( tipodoc_id );

CREATE TABLE usuario_cliente (
    usucli_id           INTEGER NOT NULL,
    usucli_cnpj         VARCHAR2(50) NOT NULL,
    usucli_nome         VARCHAR2(100) NOT NULL,
    usucli_email        VARCHAR2(50) NOT NULL,
    usucli_tenantid     INTEGER NOT NULL,
    usucli_inadimplente CHAR(1) NOT NULL
);

ALTER TABLE usuario_cliente ADD CONSTRAINT usuario_cliente_pk PRIMARY KEY ( usucli_id );

CREATE TABLE usuario_contabilidade (
    usucont_id        INTEGER NOT NULL,
    usucont_nome      VARCHAR2(100) NOT NULL,
    usucont_email     VARCHAR2(50) NOT NULL,
    usucont_tenant_id INTEGER NOT NULL
);

ALTER TABLE usuario_contabilidade ADD CONSTRAINT usuario_contabilidade_pk PRIMARY KEY ( usucont_id );

ALTER TABLE andamento_execucao_servico
    ADD CONSTRAINT andamentoexeser_exeser_fk FOREIGN KEY ( andexeser_exeser_id )
        REFERENCES execucao_servico ( exeser_id );

ALTER TABLE documento
    ADD CONSTRAINT documento_andamentoexeserv_fk FOREIGN KEY ( doc_andexeser_id )
        REFERENCES andamento_execucao_servico ( andexeser_id );

ALTER TABLE documento
    ADD CONSTRAINT documento_tipo_documento_fk FOREIGN KEY ( doc_tipodoc_id )
        REFERENCES tipo_documento ( tipodoc_id );

ALTER TABLE execucao_servico
    ADD CONSTRAINT execucaoservico_usucliente_fk FOREIGN KEY ( exeser_usucli_id )
        REFERENCES usuario_cliente ( usucli_id );

ALTER TABLE execucao_servico
    ADD CONSTRAINT execucaoservico_usucontab_fk FOREIGN KEY ( exeser_tenant_id )
        REFERENCES usuario_contabilidade ( usucont_id );

ALTER TABLE servicos_cliente
    ADD CONSTRAINT servicoscli_servico_fk FOREIGN KEY ( servcli_serv_id )
        REFERENCES servico ( serv_id );

ALTER TABLE servicos_cliente
    ADD CONSTRAINT servicoscli_usucliente_fk FOREIGN KEY ( servcli_usucli_id )
        REFERENCES usuario_cliente ( usucli_id );

ALTER TABLE usuario_cliente
    ADD CONSTRAINT usuario_cliente_tenant_fk FOREIGN KEY ( usucli_tenantid )
        REFERENCES tenant ( tenant_id );

ALTER TABLE usuario_contabilidade
    ADD CONSTRAINT usuariocontabilidade_tenant_fk FOREIGN KEY ( usucont_tenant_id )
        REFERENCES tenant ( tenant_id );
