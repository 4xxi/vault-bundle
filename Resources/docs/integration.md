# Интеграция vault с symfony

Существует несколько вариантов интеграции vault с symfony:
1. Использование данных из vault как параметров в symfony
2. Динамически запрашивать данные через сервис обертку
3. Использовать комбинацию двух подходов выше

Далее расскажу о этих подходах, о их преимуществах и недостатках.
В качестве bundle для интеграции с symfony будем использовать https://github.com/4xxi/vault-bundle

## Установка бандла

Подключение пакета
```bash
composer require fourxxi/vault-bundle:dev-master
```

Конфигурация:
```yaml
fourxxi_vault:
    enabled: true
    auth:
        token: "571f9ef0-583b-cf7a-81af-191c43515c8e"
    connection:
        schema: http
        host: 127.0.0.1
        port: 8200
        api_version: 'v1'
```
Флаг ```enabled``` необходим для разработки, если в локальной среде нет vault.

В данный момент, доступен только один способ авторизации - через token. В будущем планируется добавить еще несколько из списка:
https://www.vaultproject.io/docs/auth/index.html

## Использование данных из vault как параметров в symfony

### Плюсы
Плюсы:
* Параметры попадают в кеш, это значит, что при следующем обращении к symfony вы уже не будете обращаться к vault.
 
### Минусы
* Так как параметры попадают в кеш, 
то невозможно сделать динамическую смену параметров. Т.е, при смене параметров в vault
 они не поменяются в вашем php приложении, пока вы не сбросите кеш
* Вы лишаетесь еще одного слоя защиты: чтобы злоумышленник узнал параметры ему достаточно будет сделать grep по кешу,
 но вот если бы данных в кеше не было, то у злоумышленника ушло на 30 минут больше, чтобы узнать где лежат параметры.
 За это время вы можете успеть "откатить" все credentials

### Использование

Предположим вы записали в vault данные в следующем формате:

```bash
vault write secret/elasticsearch value=@elasticsearch.yml
vault write secret/mysql database_host=db_host database_pass=db_pass
```

elasticsearch.yml:
```yaml
elasticsearch_host: el_host
elasticsearch_password: el_pass
```

Для того, чтобы данные появились в параметрах symfony 
необходимо объявить два ParameterProvider c тегом `fourxxi_vault.cached_parameters` 

```yaml
    app.vault.mapper.yaml:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\YamlParameterMapper
        arguments: ["value"]

    app.vault.mapper.simple:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\SimpleParameterMapper

    app.vault.parameter_provider.elasticsearch:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\VaultParameterProvider
        factory: "fourxxi_vault.parameter_provider.vault_factory:create"
        arguments: ["secret/elasticsearch", "@app.vault.mapper.yaml"]
        tags:
            - { name: fourxxi_vault.cached_parameters }

    app.vault.parameter_provider.mysql:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\VaultParameterProvider
        factory: "fourxxi_vault.parameter_provider.vault_factory:create"
        arguments: ["secret/mysql", "@app.vault.mapper.simple"]
        tags:
            - { name: fourxxi_vault.cached_parameters }
```

Теперь можно обратится к параметрам:
```php
...
$container->getParameter('elasticsearch_host');
$container->getParameter('elasticsearch_password');

$container->getParameter('database_host');
$container->getParameter('database_pass');
...
```
Теперь по порядку:

`ParameterMapper` нужен для того, чтобы маппить параметры из vault в `ParameterBag`
Пример:  
* `app.vault.mapper.yaml` - парсит yaml из поле value, которое приходит из vault
* `app.vault.mapper.simple` - Ничего не делает, то есть данные будут положены в `ParameterBag`, в таком же виде, в каком они придут из vault

`ParameterProvider` - обеспечивает нас самими параметрами. 

Пример:
* `app.vault.parameter_provider.elasticsearch` - `ParameterProvider`, который создается через фабрику, которая принимает два аргумента:
 путь по которому лежат параметры в vault, `ParameterMapper`, который "говорит" как их нужна маппить
  
Если флаг `enabled` равен `false` в настройках `fourxxi_vault`, то обращение к vault не будет и вам надо будет  объявить параметры, которые лежат в vault, в `parameters.yml` или в переменных окружения 

 
## Динамически запрашивать данные через сервис обертку

### Плюсы
* Возможно динамически менять параметры в vault и ваше php приложение узнает об этом при следующем своем запуске. Стоит отметить, что consumers все таки придется перезапустить
* Дополнительный слой защиты - все переменные хранятся в памяти вашего application, так что злоумышленнику придется сначала разобраться в вашем коде. Что дает вам 20-30 минут дополнительного времени
* Параметры загружаются в lazy режиме, т.е, только когда они потребуются

### Минусы
* Если в vault лежат часто запрашиваемые параметры, то вам придется практически на каждый запрос делать от 1..N запросов к vault.
Что приводит к тому, что надо делать vault отказоустойчивым

### Использование

Для того, чтобы воспользоваться данными из vault необходимо объявит `ParameterProvider`-ы c тегами:
 * fourxxi_vault.fourxxi_vault.enabled_parameter_provider - provider, который будет использоватся когда флаг `enabled` равен true
 * fourxxi_vault.fourxxi_vault.disabled_parameter_provider - provider, который будет использоватся когда флаг `enabled` равен false

Пример:
```yaml
    app.vault.mapper.yaml:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\YamlParameterMapper
        arguments: ["value"]

    app.vault.mapper.simple:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\SimpleParameterMapper

    app.vault.enabled_parameter_provider.elasticsearch:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\VaultParameterProvider
        factory: "fourxxi_vault.parameter_provider.vault_factory:create"
        arguments: ["secret/elasticsearch", "@app.vault.mapper.yaml"]
        tags:
            - { name: fourxxi_vault.enabled_parameter_provider, provider_name: 'el' }

    app.vault.disabled_parameters_provider.elasticsearch:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\SimpleParameterProvider
        arguments: ["@=service('service_container').getParameterBag()"]
        tags:
            - { name: fourxxi_vault.disabled_parameter_provider, provider_name: 'el' }

    app.vault.enabled_parameter_provider.mysql:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\VaultParameterProvider
        factory: "fourxxi_vault.parameter_provider.vault_factory:create"
        arguments: ["secret/mysql", "@app.vault.mapper.simple"]
        tags:
            - { name: fourxxi_vault.enabled_parameter_provider, provider_name: 'mysql' }

    app.vault.disabled_parameters_provider.mysql:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\SimpleParameterProvider
        arguments: ["@=service('service_container').getParameterBag()"]
        tags:
            - { name: fourxxi_vault.disabled_parameter_provider, provider_name: 'mysql' }

    app.test.elasticsearch:
        class: App\Test
        public: true
        arguments:
            - "@=v('el','elasticsearch_host')"
            - "@=vault('el','elasticsearch_password')"
    app.test.mysql:
        class: App\Test
        public: true
        arguments:
            - "@=fourxxi_vault('mysql', 'database_pass')"
            - "@=service('fourxxi_vault.parameter_getter').get('mysql','database_host')"
```

Для обращения к параметрам вы можете использовать следующий синтаксис в yaml файле:
```yaml
@=v('<provider_name>', '<field>')
@=vault('<provider_name>', '<field>')
@=fourxxi_vault('<provider_name>', '<field>')
@=service('fourxxi_vault.parameter_getter').get('<provider_name>','<field>')
```

Или из php кода:
```php
$container->get('fourxxi_vault.parameter_getter')->get('<provider_name>', '<field>');
```
