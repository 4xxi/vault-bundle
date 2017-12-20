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
    app.vault.yaml_mapper:
        class: Fourxxi\Bundle\VaultBundle\ParameterMapper\YamlParameterMapper
        arguments: ["parameters"]

    app.vault.cached_parameters_provider:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\VaultParameterProvider
        factory: "fourxxi_vault.parameter_provider.vault_factory:create"
        arguments: ["secret/parameters/static", "@app.vault.yaml_mapper"]
        tags: [fourxxi_vault.cached_parameters]

    app.vault.enabled.parameters_provider:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\VaultParameterProvider
        factory: "fourxxi_vault.parameter_provider.vault_factory:create"
        arguments: ["secret/parameters/dynamic", "@app.vault.yaml_mapper"]
        tags:
            - { name: fourxxi_vault.enabled.parameters_provider, provider_name: 'dynamic' }

    app.vault.disabled.parameters_provider:
        class: Fourxxi\Bundle\VaultBundle\ParameterProvider\SimpleParameterProvider
        arguments: ["@=service('service_container').getParameterBag()"]
        tags:
            - { name: fourxxi_vault.disabled.parameters_provider, provider_name: 'dynamic' }

    app.test:
        class: App\Test
        public: true
        arguments: [
            - "@=v('dynamic','hello_world')"
            - "@=vault('dynamic','hello_world')"
            - "@=fourxxi_vault('dynamic','hello_world')"
```
