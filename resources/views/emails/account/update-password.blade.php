<x-mail::message>
# Olá {{$firstName}}, aqui está o seu link de atualização de senha.

Você solicitou a recuperação de senha da sua conta, clique no botão abaixo para iniciar o processo de atualização.

<x-mail::button :url="$url">
Atualizar senha
</x-mail::button>

Caso encontre algum problema no botão, copie e cole o link a seguir no seu navegador: <a href="{{$url}}">{{$url}}</a>

Obrigado,<br>
{{ config('app.name') }}.
</x-mail::message>
