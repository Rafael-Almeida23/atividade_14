# Sistema de Gerenciamento Kanban

Este é um sistema de gerenciamento de tarefas estilo Kanban desenvolvido em PHP, MySQL e Bootstrap. Permite cadastro de usuários, login, criação e gerenciamento de tarefas em um quadro Kanban, com integração opcional com a API ViaCEP para preenchimento automático de endereços via CEP.

## Pré-requisitos

- XAMPP (ou similar) com Apache e MySQL.
- Navegador web.

## Instalação

### 1. Instalar o XAMPP

1. Baixe o XAMPP do site oficial: [https://www.apachefriends.org/pt_br/index.html](https://www.apachefriends.org/pt_br/index.html).
2. Execute o instalador e siga as instruções padrão.
3. Após a instalação, inicie o painel de controle do XAMPP.
4. Inicie os módulos Apache e MySQL clicando em "Start" para cada um.

### 2. Configurar o Projeto

1. Copie a pasta do projeto (`atividade_14`) para o diretório `htdocs` do XAMPP. Geralmente localizado em `C:\xampp\htdocs\`.
2. Abra o painel de controle do XAMPP e clique em "Admin" ao lado de MySQL para abrir o phpMyAdmin.
3. No phpMyAdmin, crie um novo banco de dados chamado `kanban_db` (ou execute o script `db.sql` diretamente).
4. Abra o arquivo `db.sql` no projeto e execute o conteúdo no phpMyAdmin para criar as tabelas e inserir dados de exemplo.

### 3. Configurar o Banco de Dados

- Edite o arquivo `db.php` se necessário para ajustar as credenciais do banco (padrão: usuário `root`, senha vazia).
- Execute o script `db.sql` no phpMyAdmin para criar as tabelas.

## Como Usar

### Acesso ao Sistema

1. Abra o navegador e acesse: `http://localhost/atividade_14/`.
2. Você será redirecionado para a tela de login.

### Cadastro de Usuário

1. Na tela inicial, clique em "Cadastro de Usuário".
2. Preencha nome, e-mail e senha.
3. Clique em "Cadastrar".
4. Um usuário de exemplo já está criado: e-mail `admin@example.com`, senha `password`.

### Login

1. Na tela de login, insira e-mail e senha.
2. Clique em "Entrar".
3. Se as credenciais estiverem corretas, você será redirecionado para o gerenciamento de tarefas.

### Gerenciamento de Tarefas

1. Após login, você verá o quadro Kanban com colunas: A Fazer, Fazendo, Pronto.
2. Para adicionar uma tarefa:
   - Clique em "Cadastro de Tarefa" (no menu ou link).
   - Preencha descrição, setor, prioridade e status.
   - Opcional: Digite um CEP e clique em "Consultar CEP" para preencher a descrição com o endereço.
   - Clique em "Cadastrar Tarefa".
3. Para mover tarefas entre colunas, use os botões "Mover para Fazendo" ou "Mover para Pronto".
4. Para editar uma tarefa, clique em "Editar".
5. Para excluir, clique em "Excluir" (confirme a ação).
6. Para sair, clique em "Logout".

### Funcionalidades Adicionais

- **Integração com ViaCEP**: No cadastro de tarefas, digite um CEP e clique em "Consultar CEP" para buscar o endereço e preencher a descrição automaticamente.
- **Controle de Sessão**: Apenas usuários logados podem acessar as páginas internas. Tentativas de acesso sem login redirecionam para a tela de login.
- **Filtragem por Usuário**: Cada usuário vê apenas suas próprias tarefas.

## Estrutura do Projeto

- `db.php`: Conexão com o banco de dados.
- `db.sql`: Script para criar o banco e tabelas.
- `index.php`: Página inicial (redireciona baseado na sessão).
- `login.php`: Tela de login.
- `logout.php`: Logout (destroi sessão).
- `register_user.php`: Cadastro de usuário.
- `register_task.php`: Cadastro de tarefa.
- `gerenciar_tasks.php`: Quadro Kanban para gerenciamento.
- `edit_task.php`: Edição de tarefa.
- `session_check.php`: Verificação de sessão.
- `sugestao.php`: Integração com ViaCEP.
- `modelagem/`: Diagramas de caso de uso e DER.

## Tecnologias Utilizadas

- PHP 7+
- MySQL
- Bootstrap 5
- JavaScript (para AJAX na integração com ViaCEP)

## Licença

Este projeto está licenciado sob a MIT License. Veja o arquivo `licence` para mais detalhes.
