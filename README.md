
### Caixa eletrônico :moneybag:

<img src="https://img.shields.io/static/v1?label=COVERAGE&message=100&color=green&style=for-the-badge"/> <img src="https://img.shields.io/static/v1?label=Licese&message=MIT&color=blue&style=for-the-badge"/> <img src="https://img.shields.io/static/v1?label=PHP&message=7.3.23&color=purple&style=for-the-badge&logo=PHP"/> <img src="https://img.shields.io/static/v1?label=LARAVEL&message=8&color=red&style=for-the-badge&logo=LARAVEL"/>

### Tópicos

:small_blue_diamond: [Descrição do projeto](#descrição-do-projeto)

:small_blue_diamond: [Features](#features)

:small_blue_diamond: [Pré-requisitos](#pré-requisitos)

:small_blue_diamond: [Como rodar a aplicação ](#como-rodar-a-aplicação-arrow_forward)

:small_blue_diamond: [Documentação dos endpoints ](#documentação-dos-endpoints)

:small_blue_diamond: [Como rodar os testes ](#como-rodar-os-testes)


## Descrição do Projeto

Desenvolver uma plataforma capaz de realizar uma simulação de banco.

### Features
- Criar usuários
- Atualizar usuário
- Remover usuário
- Listar usuários
- Criar conta
- Depósito
- Saque

> Status do Projeto: Concluido :heavy_check_mark:

## Pré-requisitos

:warning: [Docker](https://www.docker.com/) :whale: 

:warning: [Docker compose](https://docs.docker.com/compose/) :octopus:

## Como rodar a aplicação :arrow_forward:

No terminal, clone o projeto:

```
git clone git@github.com:leotramontini/cashMachine.git
```

Entre na pasta do docker que está dentro do projeto:

```
cd cashMachine/docker
```

Vamos construir os container com os seguintes comandos:

```
docker-compose build && docker-compose up -d
```

Devemos verificar se as imagens estão de pé pelo comando:

```
docker ps
```

Aparacerá três containers: pgadmin, application e postgres.

Editar o seguinte arquivo:

```
sudo nano /etc/hosts
```

Adicionar:

```
127.0.0.1	cash-machine.local
```

Temos que entrar no container `application` para instalar as dependências do projeto, execute o comando:

```
docker exec -ti application bash
```

Em seguida entrar com o usuário docker :whale: :

```
su docker
```

Entrar na pasta do projeto:

```
cd cashMachine
```

Instalar as dependências do PHP :elephant: :

```
composer install
```


Criar o arquivo `.env` apartir do `.env.example` e alterar as seguintes informações:

```
DB_CONNECTION=pgsql  
DB_HOST=postgres  
DB_PORT=5432  
DB_DATABASE=cash-machine  
DB_USERNAME=postgres  
DB_PASSWORD=postgres
```

Para configurar o banco de dados em um browser acesse `localhost:5050`, usaremos as seguintes credenciais:

| email  | senha  |
| ------------ | ------------ |
|  pgadmin4@pgadmin.org | admin  |

Em `Serves` clique com o botão direito do mouse e clique na opção `Create` :arrow_right: `Servers`

Abrirá uma tela e devemos colocar as seguintes informações:

| Campo  | Valor  | Aba  |
| ------------ | ------------ | ------------ |
|  Name | Dev  | General  |
| Host name/connection  |  postgres | Connection  |
| Username |  postgres | Connection  |
| Password  |  postgres | Connection  |

Clicar no botão :floppy_disk: `Save`

Em seguida clicar com o botão direito em cima de `Databases` e selecionar a opção `Create` :arrow_right: `Database...`

|  Campo | Valor  |
| ------------ | ------------ |
| Database | cash-machine  |


Em seguida precisamos criar o banco de dados para os testes, funciona da mesma forma porém com outro nome: 

|  Campo | Valor  |
| ------------ | ------------ |
| Database | cashMachineTest  |


Clicar no botão :floppy_disk: `save` e o banco de dados está configurado

Rodar as migrations e seeds criadas:

```
php artisan migration --seed
```

Agora podemos acessar no browser:

`http://cash-machine.local`

E utilizar a aplicação sem moderação

## Documentação dos endpoints

Segue o [link](https://documenter.getpostman.com/view/6669330/TVYC8zEK) para documentação dos endpoints.

## Como rodar os testes

Coloque um passo a passo para executar os testes

```
$ phpunit
```

Caso queria executar os testes com coverage

```
$ phpunit --coverage-html coverage
```

Dentro da basta coverage terá um index.html para visualizar

## Linguagens, dependencias e libs utilizadas :books:

- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/docs/8.x) 

## Licença

The [MIT License]() (MIT)

Copyright :copyright: 2020 - Caixa Eletrônico



