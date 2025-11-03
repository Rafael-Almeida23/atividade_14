# TODO: Implementar Sistema de Login, Controle de Sessão e Integração com API

## Passos a Executar

- [x] Atualizar db.sql: Adicionar coluna 'password' VARCHAR(255) na tabela users.
- [x] Modificar register_user.php: Adicionar campo senha obrigatório, hash com password_hash.
- [x] Criar login.php: Formulário de login com email e senha, verificar hash com password_verify.
- [x] Criar logout.php: Destruir sessão e redirecionar para index.php.
- [x] Criar session_check.php: Verificar se usuário está logado, redirecionar se não.
- [x] Modificar index.php: Redirecionar para gerenciar_tasks.php se logado, senão para login.php.
- [x] Modificar register_task.php: Usar $_SESSION['user_id'] em vez de $_POST['user_id'].
- [x] Modificar gerenciar_tasks.php: Filtrar tarefas por $_SESSION['user_id'].
- [x] Modificar edit_task.php: Verificar propriedade da tarefa por $_SESSION['user_id'].
- [x] Criar sugestao.php: Integrar com BoredAPI para gerar sugestões de tarefas.
- [x] Modificar register_task.php: Adicionar botão "Gerar Sugestão" que chama sugestao.php via AJAX e preenche descrição.
- [x] Testar integração com BoredAPI.
- [x] Substituir BoredAPI por ViaCEP para consultar CEP e preencher descrição com endereço.
- [x] Atualizar db.sql: Adicionar coluna 'cep' VARCHAR(10) NULL na tabela tasks.
- [x] Modificar register_task.php: Adicionar campo CEP opcional, integrar com ViaCEP via AJAX.
- [x] Modificar gerenciar_tasks.php: Incluir cep na query.
- [x] Modificar edit_task.php: Adicionar campo CEP opcional.
- [x] Testar funcionalidade de CEP.

## Funcionalidades Implementadas

- Sistema de login com hash de senha.
- Controle de sessão.
- Tarefas filtradas por usuário logado.
- Integração com ViaCEP para consultar CEP e preencher descrição com endereço.
- CRUD completo de tarefas com Kanban board.

## Próximos Passos (se necessário)

- Melhorar validação de CEP (máscara, etc.).
- Adicionar mais campos opcionais se necessário.
- Implementar notificações ou outras funcionalidades.
