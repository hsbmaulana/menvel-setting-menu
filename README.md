<h1 align="center">Menvel-Setting-Menu</h1>

Menvel-Setting-Menu is a setting menu helper for Lumen and Laravel.

Getting Started
---

Installation :

```
$ composer require hsbmaulana/menvel-setting-menu
```

How to use it :

- Put `Menvel\SettingMenu\SettingMenuServiceProvider` to service provider configuration list.

- Migrate.

```
$ php artisan migrate
```

- Sample usage.

```php
use Menvel\SettingMenu\Contracts\Repository\ISettingMenuRepository;

$repository = app(ISettingMenuRepository::class);
// $repository->setUser(...); //
// $repository->getUser(); //

// $repository->modify('headernavbar', null, null, null, 'feature.menu.headernavbar.home'); //
// $repository->modify('headernavbar', null, null, null, 'feature.menu.headernavbar.profile'); //
// $repository->modify('headernavbar', null, null, null, 'feature.menu.headernavbar.friend'); //
// $repository->modify('footernavbar', null, null, null, 'feature.menu.footernavbar.copyright'); //
// $repository->modify('sidenavbar', null, null, null, 'feature.menu.sidenavbar.projects'); //

// $repository->modify('sidenavbar', 'feature.menu.sidenavbar.projects', null, 'feature.menu.sidenavbar.projects', 'feature.menu.sidenavbar.projects.projectone'); //
// $repository->modify('sidenavbar', 'feature.menu.sidenavbar.projects', null, 'feature.menu.sidenavbar.projects', 'feature.menu.sidenavbar.projects.projecttwo'); //
// $repository->modify('sidenavbar', 'feature.menu.sidenavbar.projects', null, 'feature.menu.sidenavbar.projects', 'feature.menu.sidenavbar.projects.projectthree'); //
```

Author
---

- Hasby Maulana ([@hsbmaulana](https://linkedin.com/in/hsbmaulana))
