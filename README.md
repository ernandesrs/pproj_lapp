# LAPP - Laravel App
Este projeto é uma API em Laravel 10, criada para estudo de criação de APIs com Laravel.

# PRINTS
Alguns prints da API.

#### FAZENDO LOGIN
![lapp_login](https://github.com/ernandesrs/pproj_lapp/assets/70029077/c1a49874-d7e8-44d6-a576-c49b2c3abd10)

#### LISTANDO USUÁRIOS NA ÁREA ADMINISTRATIVA
![lapp_listing_users](https://github.com/ernandesrs/pproj_lapp/assets/70029077/b979b669-e921-478c-b66e-247a272373ef)

#### LISTANDO FUNÇÕES/CARGOS NA ÁREA ADMINISTRATIVA
![lapp_listing_roles](https://github.com/ernandesrs/pproj_lapp/assets/70029077/e0ecbd12-9ba5-4ae3-9f9d-09aa77ca41a3)

#### REALIZANDO UMA AÇÃO NÃO AUTORIZADA
![lapp_action_unauthorized](https://github.com/ernandesrs/pproj_lapp/assets/70029077/ce40078c-457f-4194-8075-2347270bc180)

# DOCUMENTAÇÃO
A documentação da API pode ser acessada [por aqui](https://documenter.getpostman.com/view/15369452/2s9YR57vX9).

# RECURSOS
O seguintes recursos estão atualmente implementados.

    - Registro de conta
        - Confirmar registro com envio de e-mail com link de confirmação
        - Reenviar e-mail com link de confirmação

    - Login/logout

    - Recuperação de senha com envio de e-mail com link de recuperação

    - Gerenciamento de conta
        - Atualização de dados básicos
        - Atualização de senha
        - Upload de foto
        - Exclusão de foto

# INSTALAÇÃO
1. Obtenha a API:
> git clone https://github.com/ernandesrs/pproj_lapp

2. Acesse a pasta do projeto:
> cd pproj_lapp

3. Copie, cole e renomeie o arquivo '.env.example' para '.env'.
Faça as devidas configurações, conforme a tabela abaixo:

| Campo | Tipo | Descrição |
| --- | --- | --- |
| FRONT_URL_BASE | Opcional. | URL do frontend que fará uso da API |
| FRONT_URL_REGISTER_VERIFICATION | Opcional | URL no frontend para onde o usuário será direcionado para verificar/confirmar criação de conta |
| FRONT_URL_UPDATE_PASSWORD | Opcional | URL no frontend para onde o usuário será direcionado para atualizar senha |
| FILESYSTEM_DISK | Opcional | Ideal definir como 'public' |

Todos as configurações relacionadas ao banco de dados e email são necessários.

4. Instale as dependências PHP:
> composer install

5. Gere uma chave para a aplicação:
> php artisan key:generate

6. Gere um link para arquivos publicos:
> php artisan storage:link

7. Gere as tabelas:
> php artisan migrate

8. (Opcional) Preencha o banco de dados:
> php artisan db:seed

Isso irá gerar diversos usuários, além de um usuário 'super usuário' e um usuário 'administrador' e também irá criar duas funções(roles): 'Super user' e 'Administrator'.

9. Execute o servidor:
> php artisan serve

# Dados de acesso
Ao seguir o passo <b>8</b>, um usuário 'super usuário' e um usuário 'administrador' será gerado na base de dados, veja abaixo os dados de acesso:

### USUÁRIO SUPER
Email: super@mail.com
Senha: password

### USUÁRIO ADMINISTRADOR
Email: admin@mail.com
Senha: password