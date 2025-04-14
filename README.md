<h1>Paynet - Autenticação</h1>

<p>Projeto com as implementações especifcadas pelo teste de laravel da Paynet.</p>

<h2>Instalação</h2>

<p>1) Clone o projeto.</p>
<p>2) Tenha o docker instalado.</p>
<p>3) Entre na pasta do projeto e execute o seguinte comando:</p>
<pre>> docker-compose up -d</pre>
<p>4) Execute o seguinte comando:
<pre>> docker exec -it paynetps-app bash</pre>
<p>5) Após isso, você estará dentro da pasta no escopo do container. Execute em sequência os seguintes comandos:</p>
<pre>> composer install
> cp .env.example .env
> php artisan key:generate
> php artisan migrate:fresh --seed</pre>
<p>Pronto! Agora é só acessar o app através de sua <a href="http://localhost:8000/">rede local</a>.</p>

<h2>Rotas</h2>

<h3>Front-End</h3>

<pre>GET    /</pre>
<p>Tela de login.</p>
<pre>GET    /register</pre>
<p>Usada para que um novo usuário se cadastre.</p>
<pre>GET    /forgot-password</pre>
<p>Possibilita o usuário a enviar um email para resetar a senha.</p>
<pre>GET    /reset-password</pre>
<p>Rota que possibilita o usuário a enviar um email para resetar a senha.</p>
<pre>GET    /home</pre>
<p>Lista os usuários, protegida pela autenticação.</p>

<h3>Back-End</h3>
<pre>GET|HEAD   /api/cep/{cep}</pre>
<p>Faz a ponte para a api de CEP da ViaCep.</p>
<pre>POST       /api/forgot-password</pre>
<p>Envia um email para resetar a senha.</p>
<pre>GET|HEAD   /api/home</pre>
<p>Faz a listagem dos usuários.</p>
<pre>POST       /api/login</pre>
<p>Faz a autenticação utilizando login e senha.</p>
<pre>POST       /api/logout</pre>
<p>Desloga do sistema.</p>
<pre>POST       /api/register</pre>
<pre>// Ex. Req:
{
    "city": "São Luís",
    "email": "usuario@teste.com",
    "name": "Usuário Teste",
    "neighborhood": "Recanto dos Nobres",
    "number": "123",
    "password": "senha1234",
    "password_confirmation": "senha1234",
    "state": "MA",
    "street": "Rua Sítio Santo Antonio",
    "zip_code": "65074-247"
}
</pre>
<p>Registra um novo usuario</p>
<pre>POST       /api/reset-password</pre>
<pre>Ex. Req:
{
    "email": "usuario@teste.com",
    "password": "novasenha",
    "password_confirmation": "novasenha",
    "token": "c7c291a7e05879b5a174d9010414faf3b3e3ae82d908b084af3b03800085943c"
}
</pre>
<p>Reseta a senha de usuário com base no token enviado pelo email.</p>
