# desafio-king-host

##### Back End do desafio da King Host.
#####  Esse projeto é feito em Laravel 9 com o PHP 8.0.2

##  Pré-requisitos
```
- Composer
```
## Como instalação e configurar
```
- execute o comando: composer install
- coloque na raiz do projeto o arquivo .env que sera enviado por e-mail
- abra o arquivo .env e edite as seguintes variáveis de acordo com sua conexão de banco de  dados:
	DB_HOST=127.0.0.1
	DB_PORT=3306
	DB_DATABASE=king_host
	DB_USERNAME=root
	DB_PASSWORD=
- execute o comando: php artisan migrate:fresh --seed
	esse comando vai gerar as tabelas no banco de dados e criará um usuário necessário para a conexão com o front end
- execute o comando: php artisan serve
	esse comando é necessario para iniciar o servidor Laravel de desenvolvimento
	normalmente o servidor roda no endereço http://127.0.0.1:8000/
	sendo assim a url que deve esta na .env.local do front end é: http://127.0.0.1:8000/api/
```
##  Utilização 
```
- GET - /fetch-heroes -> Recebe uma string e busca na API da Marvel todos os hérois que começam com ela.
- GET - /heroes -> Busca os Heróis salvos no banco
- POST - /heroes -> Salva no banco os Heróis escolhidos pelo usuário
- GET - /heroes/{id}/stories' -> Recebe o ID de um herói e retorna suas historias gravadas no BD, caso não encontre nenhuma, busca na API e retorna ao usuário, salvando o resultado no BD
- GET - /reset -> Limpa o banco de dados
```

### Personalizar configuração
[Documentação do Laravel](https://laravel.com/docs/9.x).
