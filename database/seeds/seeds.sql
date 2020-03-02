\c melhorias

INSERT INTO area (descricao) VALUES 
     ('Configurações')
    ,('Educação')
    ,('Financeiro')
    ,('Patrimonial')
    ,('Saúde')
    ,('Tributário')
    ,('Folha')
;

INSERT INTO melhorias (area, descricao, prazo_acordado, prazo_legal, demanda_legal, gravidade, urgencia, tendencia) VALUES 
    ((SELECT id FROM area WHERE descricao ilike 'Tributário'),     'A equipe de suporte precisa saber que o deploy automatizado no Heroku facilitou a resolução de conflito da execução parelela de funções em multi-threads.', '2019-12-31', null,         'f', null, 1, null),
    ((SELECT id FROM area WHERE descricao ilike 'Tributário'),     'Nesse pull request, um erro não identificado otimizou a renderização na organização alfanumérico dos arrays multidimensionais', '2019-04-30', null,         'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Tributário'),     'Desde ontem a noite o gerenciador de dependências do frontend corrigiu o bug da execução parelela de funções em multi-threads.', '2019-05-31', null,         'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Tributário'),     'Fala pro cliente que a disposição dos elementos HTML deletou todas as entradas do fluxo de dados de forma retroativa no server.', '2019-04-30', null,         'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Tributário'),     'Explica pro Product Onwer que a disposição dos elementos HTML complexificou o merge no fechamento automático das tags.', '2019-08-28', null,         'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Saúde'),          'Dado o fluxo de dados atual, a normalização da data facilitou a resolução de conflito na definição de variaveis com tipos estáticos.', '2019-08-28', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Saúde'),          'Fala pro cliente que o gerenciador de dependências do frontend causou a race condition do carregamento de JSON delimitado por linhas.', '2019-03-28', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Saúde'),          'Desde ontem a noite um erro não identificado deletou todas as entradas na organização alfanumérico dos arrays multidimensionais', '2019-12-31', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Saúde'),          'Explica pro Product Onwer que o último pull request desse SCRUM causou o bug do polimorfismo aplicado nas classes.', null,         '2019-05-31', 'f', null, 3, null),
    ((SELECT id FROM area WHERE descricao ilike 'Saúde'),          'Nesse pull request, a otimização de performance da renderização do DOM deletou todas as entradas do polimorfismo aplicado nas classe', null,         '2019-06-30', 'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Patrimonial'),    'Desde ontem a noite o módulo de recursão paralela causou a race condition da execução parelela de funções em multi-threads.', null,         '2019-05-02', 'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Patrimonial'),    'Explica pro Product Onwer que o deploy automatizado no Heroku superou o desempenho na organização alfanumérico dos arrays multidimensionais', null,         '2019-05-30', 'f', null, 1, null),
    ((SELECT id FROM area WHERE descricao ilike 'Patrimonial'),    'Nesse pull request, o gerenciador de dependências do frontend otimizou a renderização do polimorfismo aplicado nas classes.', '2019-05-31', null,         't', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Patrimonial'),    'Com este commit, a compilação final do programa complexificou o merge do carregamento de JSON delimitado por linhas.', '2019-12-31', null,         't', null, 1, null),
    ((SELECT id FROM area WHERE descricao ilike 'Patrimonial'),    'A equipe de suporte precisa saber que a normalização da data facilitou a resolução de conflito do fluxo de dados de forma retroativa no server.', '2019-04-30', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Folha'),          'Desde ontem a noite o deploy automatizado no Heroku superou o desempenho de uma configuração Webpack eficiente nos builds.', '2019-05-31', null,         't', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Folha'),          'A equipe de suporte precisa saber que um erro não identificado causou o bug da execução de requisições effcientes na API.', '2019-04-30', null,         'f', null, 3, null),
    ((SELECT id FROM area WHERE descricao ilike 'Folha'),          'Nesse pull request, a otimização de performance da renderização do DOM causou o bug no fechamento automático das tags.', '2019-08-28', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Folha'),          'Explica pro Product Onwer que a otimização de performance da renderização do DOM otimizou a renderização no parse retroativo do DOM.', '2019-08-28', null,         'f', null, 3, null),
    ((SELECT id FROM area WHERE descricao ilike 'Folha'),          'Fala pro cliente que o deploy automatizado no Heroku causou o bug na estabilidade do protocolo de transferência de dados.', '2019-03-28', null,         'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Financeiro'),     'Com este commit, o módulo de recursão paralela otimizou a renderização de uma compilação com tempo acima da media.', '2019-12-31', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Financeiro'),     'Nesse pull request, a compilação final do programa causou a race condition na estabilidade do protocolo de transferência de dados.', '2019-05-31', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Financeiro'),     'Desde ontem a noite o último pull request desse SCRUM complexificou o merge do JSON compilado a partir de proto-buffers.', '2019-06-30', null,         'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Financeiro'),     'Fala pro cliente que a compilação final do programa facilitou a resolução de conflito na organização alfanumérico dos arrays multidimensionais', null,         '2019-05-02', 'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Financeiro'),     'Dado o fluxo de dados atual, o gerenciador de dependências do frontend corrigiu o bug na compilação de templates literais.', null,         '2019-05-30', 'f', null, 4, null),
    ((SELECT id FROM area WHERE descricao ilike 'Educação'),       'Nesse pull request, o deploy automatizado no Heroku causou a race condition da renderização de floats parciais.', null,         '2019-05-31', 'f', null, 2, null),
    ((SELECT id FROM area WHERE descricao ilike 'Educação'),       'A equipe de suporte precisa saber que a disposição dos elementos HTML superou o desempenho na criação de novos polyfills para suportar os processos.', null,         '2019-08-28', 'f', null, 3, null),
    ((SELECT id FROM area WHERE descricao ilike 'Educação'),       'Desde ontem a noite a otimização de performance da renderização do DOM otimizou a renderização do fluxo de dados de forma retroativa no server.', '2019-08-28', null,         't', null, 3, null),
    ((SELECT id FROM area WHERE descricao ilike 'Educação'),       'Com este commit, a compilação final do programa causou o bug na compilação de templates literais.', '2019-03-28', null,         't', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Educação'),       'Fala pro cliente que o gerenciador de dependências do frontend deletou todas as entradas na definição de variaveis com tipos estáticos.', null,         '2019-12-31', 't', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Configurações'),  'Explica pro Product Onwer que a normalização da data deletou todas as entradas dos parametros passados em funções privadas.', null,         '2019-05-31', 'f', null, 1, null),
    ((SELECT id FROM area WHERE descricao ilike 'Configurações'),  'Nesse pull request, o módulo de recursão paralela facilitou a resolução de conflito de uma compilação com tempo acima da media.', null,         '2019-06-30', 'f', null, 1, null),
    ((SELECT id FROM area WHERE descricao ilike 'Configurações'),  'Explica pro Product Onwer que a normalização da data otimizou a renderização no fechamento automático das tags.', '2019-05-02', null,         'f', null, 1, null),
    ((SELECT id FROM area WHERE descricao ilike 'Configurações'),  'Fala pro cliente que a normalização da data otimizou a renderização da execução parelela de funções em multi-threads.', '2019-05-30', null,         'f', null, 5, null),
    ((SELECT id FROM area WHERE descricao ilike 'Configurações'),  'A equipe de suporte precisa saber que a compilação final do programa complexificou o merge no fechamento automático das tags.', '2019-05-31', null,         'f', null, 5, null)
;

\i seeds/after.sql