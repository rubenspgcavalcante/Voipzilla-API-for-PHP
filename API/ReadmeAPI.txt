A API do VoIPzilla é uma interface para interação direta na base de dados
através de uma conexão TCP/IP na porta 8080 do servidor.

A estrutura da API de comunicação é:
[comando] [parâmetro]

sendo um comando por linha e, ao final da série de comandos, duas linhas
em branco ("\n\n"). As duas linhas em branco sinalizam fim de envio,
tanto do cliente quanto do servidor.

Para conectar: {IP do servidor]:8080

Assim que conectar, você receberá o greeting.

Para logar, utilize os comandos login e password:
login usuario
password senha

depois, você poderá utilizar os comandos:command e bye.

command inicia uma série de transmissão de informações para obter um
retorno.

bye encerra a sessão.

para command, estão disponíveis:

cli-search-cnpj_cpf
cli-search-auth
cli-search-auth-pwd
cli-retrieve-data
cli-retrieve-ani
cli-retrieve-auth
cli-retrieve-cdr
cli-retrieve-baltrans
cli-retrieve-rates
cli-unblock
cli-block
cli-update-pwd
cli-insert-baltrans
ppcc-search-seqid
ppcc-search-pin
ppcc-retrieve-data
ppcc-retrieve-pin
ppcc-retrieve-cdr
ppcc-retrieve-baltrans
ppcc-retrieve-rates
ppcc-activate
ppcc-deactivate
ppcc-insert-baltrans
currency-retrieve

----------------------------------------------------
Para fazer a busca de um cliente pelo CNPJ / CPF:
command cli-search-cnpj_cpf
cnpj_cpf [cpf]
[duas linhas em branco]

----------------------------------------------------
Para fazer a busca de um cliente pela sua Auth ou ANI:
command cli-search-auth
auth [auth ou ani]
[duas linhas em branco]

Considere:
[auth] - uma autenticação (ou parte) no sistema. Serão listados todos os clientes que tiverem uma autenticação ativa que inicie com o valor especificado.

----------------------------------------------------
Para fazer a busca de um cliente ativo pela sua Auth e senha de login:
command cli-search-auth-pwd
auth [auth]
pwd [password]
[duas linhas em branco]

Considere:
[auth] - uma autenticação completa no sistema. Será listado o cliente que tiver uma autenticação ativa e senha com o valor especificado.
[password] - senha do cliente.

----------------------------------------------------
Para carregar as informações de um cliente:
command cli-retrieve-data
cliente [id cliente]
[duas linhas em branco]

----------------------------------------------------
Para carregar todos ANIs de um cliente:
command cli-retrieve-ani
cliente [id cliente]
[duas linhas em branco]

----------------------------------------------------
Para carregar um ANI específico:
command cli-retrieve-ani
cliente [id cliente]
ani [id ani]
[duas linhas em branco]

----------------------------------------------------
Para carregar todos Auths de um cliente:
command cli-retrieve-auth
cliente [id cliente]
[duas linhas em branco]

----------------------------------------------------
Para carregar um Auth específico:
command cli-retrieve-auth
cliente [id cliente]
auth [id auth]
[duas linhas em branco]

----------------------------------------------------
Para carregar o CDR de um cliente para um período:
command cli-retrieve-cdr
cliente [id cliente]
data_inicio [data formato internacional]
data_fim [data formato internacional]

Considere:
[id cliente] - ID do cliente fornecido pelo sistema.
[data formato internacional] - data no formato YYYY-MM-DD

----------------------------------------------------
Para carregar as Transacoes Financeiras (Lancamentos) do cliente:
command cli-retrieve-baltrans
cliente [id cliente]
ultimas [ocorrencias]

Considere:
[id cliente] - ID do cliente fornecido pelo sistema.
[ocorrencias] - numero de ocorrencias

----------------------------------------------------
Para carregar as Tarifas do cliente:
command cli-retrieve-rates
cliente [id cliente]
localidade [localidade]

Considere:
[id cliente] - ID do cliente fornecido pelo sistema.
[localidade] - parte inicial do nome da localidade 

----------------------------------------------------
Para bloquear um cliente (e todas Auth e ANI):
command cli-block
cliente [id cliente]
[duas linhas em branco]

----------------------------------------------------
Para desbloquear um cliente (não altera status Auth e ANI):
command cli-unblock
cliente [id cliente]
[duas linhas em branco]

Considere:
Você deve desbloquear os Auth e ANI manualmente.

----------------------------------------------------
Para atualizar a senha de login do Cliente:
command cli-update-pwd
cliente [id cliente]
old_pwd [password]
new_pwd [password]
[duas linhas em branco]

----------------------------------------------------
Para bloquear um Auth ou ANI de cliente:
command cli-block
cliente [id cliente]
auth [auth ou ani]
[duas linhas em branco]

----------------------------------------------------
Para desbloquear um Auth ou ANI de cliente:
command cli-unblock
cliente [id cliente]
auth [auth ou ani]
[duas linhas em branco]

----------------------------------------------------
Para inserir uma Transacao Financeira (Lancamento) no cliente:
command cli-insert-baltrans
cliente [id cliente]
historico [historico]
valor [valor]
credito [C/D]
icms [S/N]

Considere:
[id cliente] - ID do cliente fornecido pelo sistema.
[historico] - Historico do Lancamento.
[valor] - Valor no formato 999999.99.
[credito] - (C)redito ou (D)ebito.
[icms] - Incidencia ICMS: (S)im ou (N)ao.

----------------------------------------------------
Para fazer a busca de um PPCC pelo SeqID:
command ppcc-search-seqid
seqid [seqID]
[duas linhas em branco]

----------------------------------------------------
Para fazer a busca de um PPCC pelo PIN:
command ppcc-search-pin
pin [pin]
[duas linhas em branco]

----------------------------------------------------
Para carregar as informações de um PPCC:
command ppcc-retrieve-data
ppcc [id ppcc]
[duas linhas em branco]

----------------------------------------------------
Para carregar as informações de um PIN:
command ppcc-retrieve-pin
ppcc [id ppcc]
[duas linhas em branco]

----------------------------------------------------
Para carregar o CDR de um PPCC para um período:
command ppcc-retrieve-cdr
ppcc [id ppcc]
data_inicio [data formato internacional]
data_fim [data formato internacional]

Considere:
[id ppcc] - ID do PPCC fornecido pelo sistema.
[data formato internacional] - data no formato YYYY-MM-DD

----------------------------------------------------
Para carregar as Transacoes Financeiras (Lancamentos) de um PPCC:
command cli-retrieve-baltrans
ppcc [id ppcc]
ultimas [ocorrencias]

Considere:
[id ppcc] - ID do PPCC fornecido pelo sistema.
[ocorrencias] - numero de ocorrencias

----------------------------------------------------
Para carregar as Tarifas de um PPCC:
command ppcc-retrieve-rates
ppcc [id ppcc]
localidade [localidade]

Considere:
[id ppcc] - ID do PPCC fornecido pelo sistema.
[localidade] - parte inicial do nome da localidade 

----------------------------------------------------
Para ativar (desbloquear) cartões PPCC:
command ppcc-activate
seqid_inicio [seqID]
seqid_fim [seqID]
[duas linhas em branco]

Considere:
O intervalo seqid_inicio e seqid_fim máximo aceito é 1000.

----------------------------------------------------
Para desativar (bloquear) cartões PPCC:
command ppcc-deactivate
seqid_inicio [seqID]
seqid_fim [seqID]
[duas linhas em branco]

Considere:
O intervalo seqid_inicio e seqid_fim máximo aceito é 1000.

----------------------------------------------------
Para inserir uma Transacao Financeira (Lancamento) no PPCC:
command ppcc-insert-baltrans
ppcc [id ppcc]
historico [historico]
valor [valor]
credito [C/D]
icms [S/N]

Considere:
[id ppcc] - ID do PPCC fornecido pelo sistema.
[historico] - Historico do Lancamento.
[valor] - Valor no formato 999999.99.
[credito] - (C)redito ou (D)ebito.
[icms] - Incidencia ICMS: (S)im ou (N)ao.

----------------------------------------------------
Para carregar a atual cotacao da segunda moeda:
command currency-retrieve

----------------------------------------------------
Uma sequencia exemplo de comandos:

telnet 200.219.197.4 8080
Trying 200.219.197.4...
Connected to 200.219.197.4.
Escape character is '^]'.
API Vzilla 1.0
login admin
password senha
command cli-search-cnpj_cpf
cnpj_cpf 186.717.918-07


^^^^^^ note as duas linhas em branco
a API retornou:

cliente MzAzMzg=/718031757
cnpj_cpf 186.717.918-07
nome Planet Telecom, Inc.

^^^^^^^ a linha "cliente" indica o ID do cliente
Para buscar as informações deste cliente, enviei:

command cli-retrieve-data
cliente MzAzMzg=/718031757


^^^^^^ note as duas linhas em branco
a API retornou:

nome Planet Telecom, Inc.
tipo F
cnpj_cpf 186.717.918-07
ie ISENTO
contato Patrik Bok
endereco .
complemento
bairro
cep 00000000
cidade .
uf SP
tel1
tel2
tel3
email noc@planet-telecom.com
dia_fatura 15
limite 0
saldo 0.000


^^^^^^^ cada coluna em uma linha
Para buscar as auths deste cliente, enviei:

command cli-retrieve-auth
cliente MzAzMzg=/718031757


^^^^^^ note as duas linhas em branco
a API retornou:

auth MzM0MDA=/415246615
id 833498
senha .
assoctel
iporigem 66.238.233.32
loosepassword 1
ativo 1
---

^^^^^^^ a linha auth indica o ID da autenticação no sistema.
Para encerrar a sessão:

bye


