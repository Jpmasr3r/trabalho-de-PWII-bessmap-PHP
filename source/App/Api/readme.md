# Classe API

A classe `Api` é projetada para ser a base de todas as APIs no projeto. Ela gerencia a autenticação do usuário e a resposta padrão para as solicitações. Abaixo está uma explicação detalhada de seus componentes e funcionalidades:

## Construtor

- **Content-Type**: Ao instanciar a classe, o `Content-Type` é definido como `application/json; charset=UTF-8` para garantir que todas as respostas sejam em JSON e com a codificação correta.
- **Headers**: Os cabeçalhos de todas as solicitações são recuperados e armazenados na propriedade `$headers`.
- **Autenticação do Usuário**: Verifica se existe um token no cabeçalho `token`. Se o token estiver presente e for válido (verificado pelo método `verify` da classe `TokenJWT`), a propriedade `$userAuth` é atualizada com os dados do usuário extraídos do token.

## Método `back`

- **Resposta Padrão**: Este método é responsável por enviar a resposta para o cliente. Ele recebe um array `$response` com os dados a serem enviados e um código de status HTTP `$code`, que por padrão é `200`.
- **Configuração do Código de Resposta**: O código de status HTTP da resposta é definido pelo `http_response_code`.
- **Envio da Resposta**: A resposta é codificada em JSON e enviada ao cliente usando `echo`. A codificação é feita com as opções `JSON_PRETTY_PRINT` e `JSON_UNESCAPED_UNICODE` para melhorar a legibilidade e suportar caracteres Unicode.

Essa estrutura facilita a criação de endpoints de API, padronizando a autenticação e a resposta, além de promover a reutilização de código.

# Classe Users

A classe `Users` estende a classe `Api` e é responsável por gerenciar operações relacionadas a usuários dentro da API. Ela oferece métodos para listar, criar, atualizar, deletar e autenticar usuários, além de fornecer informações sobre o usuário autenticado.

## Construtor

- **__construct**: Chama o construtor da classe pai `Api` para inicializar as configurações básicas.

## Métodos

### listUsers

- **Objetivo**: Retorna uma lista de todos os usuários.
- **Processo**: Instancia a classe `User` para recuperar todos os usuários do banco de dados e envia a lista como resposta.

### createUser

- **Objetivo**: Cria um novo usuário com os dados fornecidos.
- **Validação**:
  - Verifica se todos os campos obrigatórios estão preenchidos.
  - Confirma se as senhas fornecidas correspondem.
- **Processo**: Cria uma instância de `User` e tenta inseri-la no banco de dados. Se bem-sucedido, retorna uma mensagem de sucesso. Em caso de falha, retorna uma mensagem de erro com a causa.

### loginUser

- **Objetivo**: Autentica um usuário com base no e-mail e senha fornecidos.
- **Processo**: Tenta autenticar o usuário com as credenciais fornecidas. Se bem-sucedido, gera e retorna um token JWT para sessões futuras.

### updateUser

- **Objetivo**: Atualiza os dados de um usuário autenticado.
- **Validação**: Verifica se o usuário está autenticado.
- **Processo**: Recupera os dados atuais do usuário, preenche os campos não alterados e atualiza o usuário no banco de dados. Retorna uma mensagem de sucesso ou erro dependendo do resultado.

### setPassword

- **Objetivo**: Altera a senha do usuário autenticado.
- **Validação**: Verifica se o usuário está autenticado.
- **Processo**: Tenta atualizar a senha do usuário com base nas credenciais atuais e novas. Retorna uma mensagem de sucesso ou erro.

### deleteUser

- **Objetivo**: Deleta a conta do usuário autenticado.
- **Validação**: Verifica se o usuário está autenticado.
- **Processo**: Tenta deletar o usuário do banco de dados. Retorna uma mensagem de sucesso ou erro dependendo do resultado.

### logged

- **Objetivo**: Verifica se há um usuário autenticado na sessão.
- **Processo**: Retorna um booleano indicando se o usuário está ou não autenticado.

### getInfs

- **Objetivo**: Retorna as informações do usuário autenticado.
- **Validação**: Verifica se o usuário está autenticado.
- **Processo**: Se o usuário pertence a uma equipe, retorna seu nome e o nome da equipe. Caso contrário, informa que o usuário não pertence a nenhuma equipe.

## Resumo

A classe `Users` fornece uma API completa para o gerenciamento de usuários, incluindo operações de criação, autenticação, atualização e exclusão. Todos os métodos retornam respostas padronizadas utilizando o método `back` herdado da classe `Api`, garantindo uma comunicação consistente e fácil manutenção do código.


# Classe Teams

A classe `Teams` estende a classe `Api` e é especializada em operações relacionadas a equipes na API. Ela implementa métodos para listar, criar, ingressar, atualizar, excluir, sair de equipes, além de obter informações específicas sobre uma equipe. Abaixo, segue um detalhamento de cada método e sua funcionalidade:

## Construtor

- Chama o construtor da classe pai `Api` para inicializar as configurações básicas, como definir o `Content-Type` e processar a autenticação do usuário.
- Verifica se o usuário está autenticado. Se não estiver, retorna uma resposta de erro informando que o acesso não é permitido.

## Métodos

### listTeams

- **Objetivo**: Retorna uma lista de todas as equipes.
- **Processo**: Instancia a classe `Team` e utiliza o método `selectAll()` para recuperar todas as equipes. Utiliza o método `back` herdado para enviar a resposta ao cliente.

### createTeam

- **Objetivo**: Cria uma nova equipe com os dados fornecidos.
- **Validação**: Verifica se todos os campos necessários estão preenchidos.
- **Processo**: Cria uma instância de `Team` com os dados fornecidos e tenta inseri-la no banco de dados. Se bem-sucedido, associa o usuário autenticado à equipe criada e atualiza o número de membros. Retorna uma resposta de sucesso ou erro, dependendo do resultado da operação.

### joinTeam

- **Objetivo**: Permite que o usuário autenticado ingresse em uma equipe existente.
- **Validação**: Verifica se o usuário já pertence a uma equipe e se os dados fornecidos estão completos.
- **Processo**: Busca a equipe pelo nome e, se encontrada, associa o usuário à equipe e atualiza o número de membros. Retorna uma resposta de sucesso ou erro.

### updateTeam

- **Objetivo**: Atualiza as informações da equipe à qual o usuário autenticado pertence.
- **Validação**: Verifica se todos os campos necessários estão preenchidos.
- **Processo**: Atualiza o nome da equipe no banco de dados e retorna uma resposta de sucesso ou erro.

### deleteTeam

- **Objetivo**: Exclui a equipe à qual o usuário autenticado pertence e remove a associação de todos os membros dessa equipe.
- **Processo**: Remove a equipe do banco de dados e dissocia todos os membros dela. Retorna uma resposta de sucesso ou erro.

### exitTeam

- **Objetivo**: Permite que o usuário autenticado saia da equipe à qual pertence.
- **Processo**: Dissocia o usuário da equipe e atualiza o número de membros. Retorna uma resposta de sucesso ou erro.

### getInfs

- **Objetivo**: Retorna informações detalhadas sobre a equipe à qual o usuário autenticado pertence.
- **Processo**: Busca os dados da equipe e a lista de membros. Retorna essas informações junto com os dados do próprio usuário.

### getTeams

- **Objetivo**: Busca e retorna uma lista de equipes com base em um critério de nome fornecido.
- **Processo**: Busca as equipes que correspondem ao critério e retorna os resultados.

## Resumo

A classe `Teams` fornece uma API robusta para operações de gerenciamento de equipes, garantindo que todas as ações sejam realizadas de maneira segura e consistente. Cada método utiliza o método `back` herdado da classe `Api` para enviar respostas ao cliente, garantindo uma interface de comunicação uniforme e facilitando a manutenção do código.

# Classe Produtions

A classe `Produtions` estende a classe `Api` e é responsável por gerenciar operações relacionadas a produções dentro da API. Ela oferece métodos para listar produções por equipe, inserir novas produções e deletar produções existentes. Abaixo, segue um detalhamento de cada método e sua funcionalidade.

## Construtor

- Chama o construtor da classe pai `Api` para inicializar as configurações básicas, como definir o `Content-Type` e processar a autenticação do usuário.
- Verifica se o usuário está autenticado. Se não estiver, retorna uma resposta de erro informando que o acesso não é permitido.

## Métodos

### listByTeam

- **Objetivo**: Retorna uma lista de todas as produções associadas à equipe do usuário autenticado.
- **Processo**: Instancia a classe `User` para recuperar os detalhes do usuário autenticado e utiliza o método `selectBy` da classe `Prodution` para listar todas as produções associadas à equipe do usuário. Utiliza o método `back` herdado para enviar a resposta ao cliente.

### insert

- **Objetivo**: Insere uma nova produção com os dados fornecidos.
- **Validação**: Verifica se todos os campos necessários estão preenchidos.
- **Processo**: Cria uma instância de `Prodution` com os dados fornecidos e tenta inseri-la no banco de dados. Se bem-sucedido, retorna uma mensagem de sucesso. Em caso de falha, retorna uma mensagem de erro com a causa.

### delete

- **Objetivo**: Exclui uma produção existente com base no ID fornecido.
- **Processo**: Cria uma instância de `Prodution` com o ID da produção e tenta deletá-la do banco de dados. Retorna uma mensagem de sucesso ou erro, dependendo do resultado da operação.

## Resumo

A classe `Produtions` oferece uma API eficaz para gerenciar produções, garantindo que as operações sejam realizadas de maneira segura e consistente. Cada método utiliza o método `back` herdado da classe `Api` para enviar respostas ao cliente, assegurando uma interface de comunicação uniforme e facilitando a manutenção do código.
