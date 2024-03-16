# Coddle

### Framework para micro aplicações cli feitas com PHP

**Para criar um comando:**
~~~
php coddle generate brotas
~~~

**Para testar o comando criado:**
~~~
php coddle brotas -t
~~~

**Para executar o comando criado:**
~~~
php coddle brotas
~~~

**Regras de negócio:**
- A função action na trait é onde deve estar o seu código

**Configurar atributos ou opções:**
- Dentro do arquivo command que foi gerado, configure os arrays **args** e **options**:
~~~
$args = [
  '?optional_arg:The arg of the user',
  '*required_arg:The arg of the user'
];
static $options =[
  '-none_value_option:just a flag',
  '?not_required_value_option:maybe something',
  '*required_value_option:needs a value'
];
~~~

- \* obrigatório
- \? opcional
- \- flag vazia, apenas para option

O coddle vem com o laradump instalado, mas para ter acesso a ferramenta é preciso instalar o client: https://laradumps.dev/get-started/installation.html