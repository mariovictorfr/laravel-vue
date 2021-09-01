# ToDo App (_Laravel + Vue_)

Este é um sistema de teste utilizando Vue como frontend e Laravel como backend.
Utiliza JWT para proteger as rotas.

##### Usuários:

- CRUD de Usuários;
- Cadastro de Usuários via CLI;
- Cadastro de usuário na página de Regristro;
- Envio de email para o usuário quando o seu cadastro é criado, atualizado ou excluído.

##### Tarefas:

- CRUD de Tarefas.

## Tecnologias Utilizadas

##### Frontend:

- Vue, VueRouter e Vuex;
- Axios;
- Bootstrap-vue;
- Vue Toasted.

##### Backend:

- Laravel 8;
- Tymon JWT.

## Executando o Backend

Acesse a pasta do Frontend.

```sh
cd todo-frontend
```

##### Banco de dados

`Crie um banco de dados` no teu MySQL e `configure o arquivo .env` _(utilize .env.example como base)_ com as informações de acesso.
Exemplo:

```sh
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo
DB_USERNAME=root
DB_PASSWORD=
```

Agora que criou o banco de dados e configurou o .env, execute o comando para criar as tabelas.

```sh
php artisan migrate
```

##### Envio de Emails para Usuários

Sempre que um usuário é criado, alterado ou deletado, o backend envia um email para o usuário cadastrado, para isso configure o arquivo `.env` com as informações do teu email:

```sh
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="${APP_NAME}"
```

##### Criando o primeiro usuário

Execute o comando abaixo e preencha as informações solicitadas para criar o primeiro usuário.

```sh
php artisan user:create
```

##### Executando o servidor

Para executar a aplicação você pode utilizar um servidor de sua preferência (Apache, por exemplo) ou executar o comando para iniciar um servidor:

```sh
php artisan serve
```

O servidor será hospedado por padrão na porta `8000`.

## Executando o Frontend

Acesse a pasta do Frontend.

```sh
cd todo-frontend
```

##### Instalando as dependências

Execute o comando `npm install` para instalar as dependências do projeto.

```sh
npm install
```

##### Configurações

Crie um arquivo `.env.local` e adicione a variável `VUE_APP_API_URL` com a url em que o backend está sendo executado.
Exemplo:

```sh
VUE_APP_API_URL=http://localhost:8000/api
```

##### Executando o servidor

Execute o comando para iniciar um servidor:

```sh
npm run serve
```

##### Criando versão de distribuição

Execute o comando abaixo para criar a versão de distribuição:

```sh
npm run build
```

Será criada uma pasta com nome `dist` dentro da pasta `todo-frontend`.
Copie o conteúdo desta pasta para seu servidor.
