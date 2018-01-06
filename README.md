# Vault bundle
Symfony bundle for vault integration
=======

### Configuration
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

### Examples
```yaml
    app.vault.mapper.yaml:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\YamlParameterMapper
        arguments: ["value"]

    app.vault.mapper.simple:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\SimpleParameterMapper

    # for cached parameters
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
    
    # For dynamic parameters
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
