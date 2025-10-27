# CakeQualityTools - Dashboard de Tests et Qualité

## 📋 Description

Plugin CakePHP pour gérer et visualiser les outils de qualité du code (PHPUnit, PHPStan, CodeSniffer) via une interface web conviviale.

## ✨ Fonctionnalités

- ✅ **Dashboard interactif** pour lancer les tests, analyses et vérifications de style
- ✅ **Interface Bootstrap** compatible PHP 7.4+
- ✅ **Exécution en temps réel** des commandes de qualité via AJAX
- ✅ **Affichage des résultats** directement dans l'interface
- ✅ **Compatible CakePHP 4.x et 5.x**

## 🚀 Installation

### 1. Installation via Composer

```bash
composer require badrtairlbahrepro/cake-quality-tools
```

### 2. Charger le Plugin

Dans votre fichier `src/Application.php` :

```php
public function bootstrap(): void
{
    parent::bootstrap();
    
    // Charger le plugin
    $this->addPlugin('CakeQualityTools');
}
```

### 3. Configurer les Routes

Dans votre fichier `config/routes.php` :

```php
$builder->scope('/quality-tools', function (RouteBuilder $routes) {
    $routes->connect('/', [
        'plugin' => 'CakeQualityTools',
        'controller' => 'QualityTools',
        'action' => 'index'
    ]);
    $routes->connect('/run-tests', [
        'plugin' => 'CakeQualityTools',
        'controller' => 'QualityTools',
        'action' => 'runTests'
    ]);
    $routes->connect('/run-stan', [
        'plugin' => 'CakeQualityTools',
        'controller' => 'QualityTools',
        'action' => 'runStan'
    ]);
    $routes->connect('/run-cs', [
        'plugin' => 'CakeQualityTools',
        'controller' => 'QualityTools',
        'action' => 'runCodeSniffer'
    ]);
});
```

### 4. Accéder au Dashboard

Accédez à : **http://votre-domaine.com/quality-tools**

## 🎯 Utilisation

### Lancer les Tests PHPUnit

Cliquez sur le bouton **"Lancer les Tests"** dans la carte PHPUnit. Les résultats s'afficheront dans la zone de résultats.

### Analyser avec PHPStan

Cliquez sur le bouton **"Analyser le Code"** dans la carte PHPStan pour effectuer une analyse statique.

### Vérifier le Style avec CodeSniffer

Cliquez sur le bouton **"Vérifier le Style"** dans la carte CodeSniffer pour vérifier la conformité PSR-12.

## 📋 Prérequis

- PHP >= 7.4
- CakePHP >= 4.0 ou >= 5.0
- Les outils de qualité installés : PHPUnit, PHPStan, CodeSniffer (dans `composer.json`)

## 📝 Configuration des Commandes

Le plugin utilise ces commandes par défaut :

- **Tests** : `./vendor/bin/phpunit tests/TestCase/ --testdox`
- **PHPStan** : `composer stan`
- **CodeSniffer** : `composer cs-check`

Ces commandes peuvent être personnalisées dans le contrôleur.

## 🔧 Personnalisation

### Modifier les Commandes

Éditez `src/Controller/QualityToolsController.php` pour changer les commandes exécutées :

```php
$command = 'cd ' . ROOT . ' && ./vendor/bin/phpunit tests/TestCase/ --testdox 2>&1';
```

### Changer le Chemin

Modifiez le template `templates/QualityTools/index.php` pour adapter l'interface à vos besoins.

## 📊 Compatibilité

| Version | CakePHP | PHP  |
|---------|---------|------|
| 1.0.x   | 4.x / 5.x | 7.4+ |
| 1.0.x   | 4.x / 5.x | 8.0+ |

## 🐛 Troubleshooting

### Erreur : "Permission denied"

Assurez-vous que les scripts ont les permissions d'exécution :

```bash
chmod +x vendor/bin/phpunit
```

### Les résultats ne s'affichent pas

Vérifiez que les routes sont correctement configurées dans `config/routes.php`.

### CSRF Token Error

Les endpoints AJAX utilisent GET pour éviter les problèmes CSRF.

## 📚 Documentation

Pour plus d'informations sur les outils de qualité :

- [Guide Complet des Tests](QUALITY_DOCUMENTATION.md)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [CodeSniffer Documentation](https://github.com/squizlabs/PHP_CodeSniffer)

## 🤝 Contribution

Les contributions sont les bienvenues ! N'hésitez pas à ouvrir une issue ou une pull request.

## 📄 Licence

MIT License - Voir le fichier [LICENSE](LICENSE)

## 👤 Auteur

Badr Tairlbahre - [GitHub](https://github.com/badrtairlbahrepro)

---

**Note** : Ce plugin nécessite que les outils de qualité (PHPUnit, PHPStan, CodeSniffer) soient installés dans votre projet via Composer.

