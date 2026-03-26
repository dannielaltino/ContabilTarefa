-- Gerado por Oracle SQL Developer Data Modeler 23.1.0.087.0806
--   em:        2026-03-26 00:10:02 BRT
--   site:      Oracle Database 12c
--   tipo:      Oracle Database 12c



-- predefined type, no DDL - MDSYS.SDO_GEOMETRY

-- predefined type, no DDL - XMLTYPE

--  ERROR: Table name length exceeds maximum allowed length(30) 
CREATE TABLE andamento_da_execucao_do_servico (
    followupserviceexecutionid       INTEGER NOT NULL,
    execucao_servico_exeser_id       INTEGER NOT NULL,
    followupserviceexecutiontxt      VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL, 
--  ERROR: Column name length exceeds maximum allowed length(30) 
    followupserviceexecutiondatetime DATE NOT NULL,
    statusserviceexecution           unknown 
--  ERROR: Datatype UNKNOWN is not allowed 
     NOT NULL
);

ALTER TABLE andamento_da_execucao_do_servico ADD CONSTRAINT andamento_execucao_servico_pk PRIMARY KEY ( followupserviceexecutionid );

CREATE TABLE documento (
    documentid                              INTEGER NOT NULL,
    documentname                            VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    docdatetime                             DATE NOT NULL,
    documentpath                            VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    tipo_documento_tipodoc_id               INTEGER NOT NULL, 
--  ERROR: Column name length exceeds maximum allowed length(30) 
    andamento_execucao_servico_andexeser_id INTEGER NOT NULL
);

ALTER TABLE documento ADD CONSTRAINT documento_pk PRIMARY KEY ( documentid );

CREATE TABLE execucao_do_servico (
    serviceexecutionid               INTEGER NOT NULL, 
--  ERROR: Column name length exceeds maximum allowed length(30) 
    serviceexecutiondatetimecreation DATE NOT NULL, 
--  ERROR: Column name length exceeds maximum allowed length(30) 
    usuario_contabilidade_usucont_id INTEGER,
    usuario_cliente_usucli_id        INTEGER NOT NULL,
    servico_serv_id                  INTEGER NOT NULL,
    identificador_do_serviço         INTEGER NOT NULL
);

ALTER TABLE execucao_do_servico ADD CONSTRAINT execucao_servico_pk PRIMARY KEY ( serviceexecutionid );

CREATE TABLE serviço (
    identificador_do_serviço INTEGER NOT NULL,
    descrição_do_serviço     VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL
);

ALTER TABLE serviço ADD CONSTRAINT servico_pk PRIMARY KEY ( identificador_do_serviço );

CREATE TABLE serviços_de_cliente (
    clientserviceid           INTEGER NOT NULL,
    servico_serv_id           INTEGER NOT NULL,
    usuario_cliente_usucli_id INTEGER NOT NULL,
    clientservicefreq         VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL
);

ALTER TABLE serviços_de_cliente ADD CONSTRAINT servicos_cliente_pk PRIMARY KEY ( clientserviceid );

CREATE TABLE tenant (
    tenantid   INTEGER NOT NULL,
    tenantdesc VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    tenantcnpj VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL
);

ALTER TABLE tenant ADD CONSTRAINT tenant_pk PRIMARY KEY ( tenantid );

CREATE TABLE tipo_de_documento (
    doctypeid   INTEGER NOT NULL,
    doctypedesc VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL
);

ALTER TABLE tipo_de_documento ADD CONSTRAINT tipo_documento_pk PRIMARY KEY ( doctypeid );

CREATE TABLE usuário_cliente (
    userclientid           INTEGER NOT NULL,
    userclientcnpj         VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    userclientname         VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    userclientemail        VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    tenant_tenant_id       INTEGER NOT NULL,
    userclientinadimplente NUMBER NOT NULL
);

ALTER TABLE usuário_cliente ADD CONSTRAINT usuario_cliente_pk PRIMARY KEY ( userclientid );

CREATE TABLE usuário_da_contabilidade (
    accountinguserid                INTEGER NOT NULL,
    accountinguserdesc              VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    accountinguseremail             VARCHAR2 
--  ERROR: VARCHAR2 size not specified 
     NOT NULL,
    tenant_tenant_id                INTEGER NOT NULL,
    usucont_cpf_usuario             INTEGER, 
--  ERROR: Column name length exceeds maximum allowed length(30) 
    cpf_do_usuário_da_contabilidade INTEGER
);

ALTER TABLE usuário_da_contabilidade ADD CONSTRAINT usuario_contabilidade_pk PRIMARY KEY ( accountinguserid );

--  ERROR: FK name length exceeds maximum allowed length(30) 
ALTER TABLE andamento_da_execucao_do_servico
    ADD CONSTRAINT andamento_execucao_servico_execucao_servico_fk FOREIGN KEY ( execucao_servico_exeser_id )
        REFERENCES execucao_do_servico ( serviceexecutionid );

--  ERROR: FK name length exceeds maximum allowed length(30) 
ALTER TABLE documento
    ADD CONSTRAINT documento_andamento_execucao_servico_fk FOREIGN KEY ( andamento_execucao_servico_andexeser_id )
        REFERENCES andamento_da_execucao_do_servico ( followupserviceexecutionid );

ALTER TABLE documento
    ADD CONSTRAINT documento_tipo_documento_fk FOREIGN KEY ( tipo_documento_tipodoc_id )
        REFERENCES tipo_de_documento ( doctypeid );

ALTER TABLE execucao_do_servico
    ADD CONSTRAINT execucao_servico_servico_fk FOREIGN KEY ( servico_serv_id )
        REFERENCES serviço ( identificador_do_serviço );

--  ERROR: FK name length exceeds maximum allowed length(30) 
ALTER TABLE execucao_do_servico
    ADD CONSTRAINT execucao_servico_usuario_cliente_fk FOREIGN KEY ( usuario_cliente_usucli_id )
        REFERENCES usuário_cliente ( userclientid );

--  ERROR: FK name length exceeds maximum allowed length(30) 
ALTER TABLE execucao_do_servico
    ADD CONSTRAINT execucao_servico_usuario_contabilidade_fk FOREIGN KEY ( usuario_contabilidade_usucont_id )
        REFERENCES usuário_da_contabilidade ( accountinguserid );

ALTER TABLE serviços_de_cliente
    ADD CONSTRAINT servicos_cliente_servico_fk FOREIGN KEY ( servico_serv_id )
        REFERENCES serviço ( identificador_do_serviço );

--  ERROR: FK name length exceeds maximum allowed length(30) 
ALTER TABLE serviços_de_cliente
    ADD CONSTRAINT servicos_cliente_usuario_cliente_fk FOREIGN KEY ( usuario_cliente_usucli_id )
        REFERENCES usuário_cliente ( userclientid );

ALTER TABLE usuário_cliente
    ADD CONSTRAINT usuario_cliente_tenant_fk FOREIGN KEY ( tenant_tenant_id )
        REFERENCES tenant ( tenantid );

--  ERROR: FK name length exceeds maximum allowed length(30) 
ALTER TABLE usuário_da_contabilidade
    ADD CONSTRAINT usuario_contabilidade_tenant_fk FOREIGN KEY ( tenant_tenant_id )
        REFERENCES tenant ( tenantid );



-- Relatório do Resumo do Oracle SQL Developer Data Modeler: 
-- 
-- CREATE TABLE                             9
-- CREATE INDEX                             0
-- ALTER TABLE                             19
-- CREATE VIEW                              0
-- ALTER VIEW                               0
-- CREATE PACKAGE                           0
-- CREATE PACKAGE BODY                      0
-- CREATE PROCEDURE                         0
-- CREATE FUNCTION                          0
-- CREATE TRIGGER                           0
-- ALTER TRIGGER                            0
-- CREATE COLLECTION TYPE                   0
-- CREATE STRUCTURED TYPE                   0
-- CREATE STRUCTURED TYPE BODY              0
-- CREATE CLUSTER                           0
-- CREATE CONTEXT                           0
-- CREATE DATABASE                          0
-- CREATE DIMENSION                         0
-- CREATE DIRECTORY                         0
-- CREATE DISK GROUP                        0
-- CREATE ROLE                              0
-- CREATE ROLLBACK SEGMENT                  0
-- CREATE SEQUENCE                          0
-- CREATE MATERIALIZED VIEW                 0
-- CREATE MATERIALIZED VIEW LOG             0
-- CREATE SYNONYM                           0
-- CREATE TABLESPACE                        0
-- CREATE USER                              0
-- 
-- DROP TABLESPACE                          0
-- DROP DATABASE                            0
-- 
-- REDACTION POLICY                         0
-- TSDP POLICY                              0
-- 
-- ORDS DROP SCHEMA                         0
-- ORDS ENABLE SCHEMA                       0
-- ORDS ENABLE OBJECT                       0
-- 
-- ERRORS                                  26
-- WARNINGS                                 0
