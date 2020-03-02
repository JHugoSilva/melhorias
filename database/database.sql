CREATE DATABASE melhorias WITH ENCODING='UTF8'
    LC_CTYPE = 'en_US.utf8' 
    LC_COLLATE = 'en_US.utf8'
    TEMPLATE = template0
    OWNER=postgres
    CONNECTION LIMIT=-1
;

\c melhorias

CREATE SCHEMA config AUTHORIZATION postgres;
GRANT ALL ON SCHEMA config TO postgres;

CREATE TABLE config.gravidade (
    id  serial primary key,
    descricao varchar(250)
);

INSERT INTO config.gravidade (descricao) VALUES ('Sem gravidade'), ('Pouco grave'), ('Grave'), ('Muito grave'), ('Extremamente grave');

CREATE TABLE config.urgencia (
    id  serial primary key,
    descricao varchar(250)
);
INSERT INTO config.urgencia (descricao) VALUES ('Pode esperar'), ('Pouco urgente'), ('Merece atenção, curto prazo'), ('Muito urgente'), ('Precisa de ação imediata');

CREATE TABLE config.tendencia (
    id  serial primary key,
    descricao varchar(250)
);
INSERT INTO config.tendencia (descricao) VALUES ('Não irá mudar'), ('Piora em longo prazo'), ('Piora em médio prazo'), ('Piora em curto prazo'), ('Piora rapidamente');

CREATE TABLE area (
    id serial primary key,
    descricao varchar(250)
);

CREATE TABLE melhorias (
    id  serial primary key,
    tarefa varchar(250),
    descricao text not null,
    demanda_legal boolean not null default false,
    prazo_acordado date,
    prazo_legal date,
    gravidade int8,
    urgencia int8, 
    tendencia int8,
    area int8 NOT NULL
);

ALTER TABLE melhorias ADD CONSTRAINT melhoria_gravidade_fk FOREIGN KEY (gravidade) REFERENCES config.gravidade (id);
ALTER TABLE melhorias ADD CONSTRAINT melhoria_urgencia_fk FOREIGN KEY (urgencia) REFERENCES config.urgencia (id);
ALTER TABLE melhorias ADD CONSTRAINT melhoria_tendencia_fk FOREIGN KEY (tendencia) REFERENCES config.tendencia (id);
ALTER TABLE melhorias ADD CONSTRAINT melhoria_area_fk FOREIGN KEY (area) references area (id);

