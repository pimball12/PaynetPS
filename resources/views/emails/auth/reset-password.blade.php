@component('mail::message')
# Redefinição de Senha

Você está recebendo este e-mail porque recebemos uma solicitação de redefinição de senha para sua conta.

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Redefinir Senha
@endcomponent

Este link de redefinição de senha expirará em {{ $expires }} minutos.

Se você não solicitou uma redefinição de senha, nenhuma ação adicional é necessária.

Atenciosamente,<br>
{{ config('app.name') }}

@component('mail::subcopy')
Se você estiver tendo problemas para clicar no botão "Redefinir Senha", copie e cole a URL abaixo no seu navegador:
[{{ $url }}]({{ $url }})
@endcomponent
@endcomponent
