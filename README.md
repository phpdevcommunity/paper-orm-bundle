# 📦 PaperORMBundle

**PaperORMBundle** is a Symfony bundle that integrates [PaperORM](https://github.com/phpdevcommunity/paper-orm), a lightweight and performant PHP ORM.

PaperORM itself is framework-agnostic.
This bundle provides seamless integration into Symfony: configuration via `config/packages/`, service wiring, and logger support.

---

## 🚀 Installation

```bash
composer require phpdevcommunity/paper-orm-bundle:1.0.2-alpha
```

This will install both the bundle and the core [PaperORM](https://github.com/phpdevcommunity/paper-orm).

Then, enable the bundle (if Flex does not do it automatically):

```php
// config/bundles.php
return [
    // ...
    PhpDevCommunity\PaperORMBundle\PaperORMBundle::class => ['all' => true],
];
```

---

## ⚙️ Configuration

Add your configuration in `config/packages/paper_orm.yaml`:

```yaml
paper_orm:
  dsn: '%env(resolve:DATABASE_URL)%'
  debug: '%kernel.debug%'
  logger: 'paper.logger'
  entity_dir: '%kernel.project_dir%/src/Entity'
  migrations_dir: '%kernel.project_dir%/migrations'
  migrations_table: 'mig_versions'
```

### Options

| Key                | Type   | Default                           | Description                                 |
|--------------------| ------ | --------------------------------- |---------------------------------------------|
| `dsn`              | string | *(required)*                      | Database DSN                                |
| `debug`            | bool   | `false`                           | Enable verbose debugging                    |
| `logger`           | string | `null`                            | Service ID of a logger (ex: `paper.logger`) |
| `entity_dir`       | string | `%kernel.project_dir%/src/Entity` | Path to your entities                       |
| `migrations_dir`   | string | `%kernel.project_dir%/migrations` | Path to migration files                     |
| `migrations_table` | string | `mig_versions`                    | Table name used for migration tracking      |
| `proxy_autoload`   | bool   | `false`                           | Enable Proxy autoload for session           |

---

## 🛠️ Services

After configuration, the following services are available in the container:

* `PhpDevCommunity\PaperORM\EntityManagerInterface`
* `PhpDevCommunity\PaperORM\EntityManager`

You can inject them directly:

```php
use PhpDevCommunity\PaperORM\EntityManagerInterface;

final class UserService
{
    public function __construct(private EntityManagerInterface $em) {}

    public function createUser(string $name, string $email): void
    {
        $user = new User();
        $user->setName($name)->setEmail($email);

        $this->em->persist($user);
        $this->em->flush();
    }
}
```

---

## 📖 Documentation

Full ORM usage, entity mapping, and repositories are documented in the main **PaperORM** repository:

👉 [PaperORM Documentation](https://github.com/phpdevcommunity/paper-orm)

---

## 📌 Status

This bundle is in **alpha (1.0.1-alpha)**.
We welcome early feedback, bug reports, and contributions.
