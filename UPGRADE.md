# Upgrade

## From 1.x to 2.0

### Requirements

- PHP 7.2.5 or higher is required.
- Symfony 5.4 or 6.x is required. Symfony 2.x, 3.x, 4.x and 5.0 to 5.3 are no longer supported.
- Twig 2.10 or 3.x is required. Twig 1.x is no longer supported.
- `symfony/twig-bundle` is now required, as the bundle registers a Twig extension.

### DataLayerManager

The session is now retrieved from the `RequestStack` instead of being injected directly, as the
`session` service was removed in Symfony 6.

- The constructor signature changed:

  ```diff
  - public function __construct(SessionInterface $session, CollectorChain $collectorChain)
  + public function __construct(RequestStack $requestStack, CollectorChain $collectorChain)
  ```

  If you instantiate the manager yourself or redefine the `lexik_data_layer.manager.data_layer_manager`
  service, pass the `request_stack` service instead of `session`.

- The protected `$session` property was replaced by `$requestStack`. If you extend the class, use the
  new protected `getSession()` method instead.

- `add()`, `all()` and `reset()` now need a request with a session. Outside of an HTTP request
  (console commands, Messenger workers...), they throw a
  `Symfony\Component\HttpFoundation\Exception\SessionNotFoundException`.

### UserIdCollector

The user id is now computed from `UserInterface::getUserIdentifier()` (falling back to `getUsername()`
on Symfony 5.4). The `user_id` hash only changes if your user class returns a different value from
these two methods.

### Twig extension

- `DataLayerExtension` now extends `Twig\Extension\AbstractExtension` instead of `\Twig_Extension`.
- `DataLayerExtension::getName()` was removed.
- `DataLayerExtension::getFunctions()` now declares an `array` return type.

### Return types

If you extend one of the following classes, your overriding methods must declare the same return type:

| Method                                         | Return type   |
|------------------------------------------------|---------------|
| `LexikDataLayerBundle::build()`                | `void`        |
| `LexikDataLayerExtension::load()`              | `void`        |
| `Configuration::getConfigTreeBuilder()`        | `TreeBuilder` |
| `CollectorCompilerPass::process()`             | `void`        |
| `DataLayerExtension::getFunctions()`           | `array`       |

### Service configuration

`Resources/config/services.xml` was replaced by `Resources/config/services.php`. Service ids, aliases
and `*.class` parameters are unchanged. Only update your code if you imported the XML file directly.
