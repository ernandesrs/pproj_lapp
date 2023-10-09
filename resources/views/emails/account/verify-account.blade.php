<x-mail::message>
# Olá {{$firstName}}, bem vindo(a)!

Agora só falta você finalizar confirmando a criação da sua conta clicando no botão abaixo.

<x-mail::button :url="$url">
Confirmar minha conta
</x-mail::button>

Caso encontre algum problema no botão, copie e cole o link a seguir no seu navegador: <a href="{{$url}}">{{$url}}</a>

Obrigado,<br>
{{ config('app.name') }}.
</x-mail::message>
