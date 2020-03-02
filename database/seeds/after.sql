UPDATE melhorias SET descricao = replace(descricao, '\n', chr(10)) WHERE id IN (SELECT id FROM melhorias WHERE strpos(descricao, '\n') > 0);
UPDATE melhorias SET tarefa = replace(substr(descricao, 0, 100), chr(10), ' ') ;
UPDATE melhorias SET tarefa = tarefa || '...' WHERE length(replace(descricao, chr(10), ' ')) > 100;
