# 📚 Documentation Complète - Outils de Qualité du Code

## 🎯 Table des Matières

1. [Introduction](#introduction)
2. [Les 3 Outils Principaux](#les-3-outils-principaux)
3. [PHPUnit - Les Tests](#phpunit---les-tests)
4. [PHPStan - L'Analyseur Statique](#phpstan---lanalyseur-statique)
5. [CodeSniffer - Le Style](#codesniffer---le-style)
6. [Guide Complet](#guide-complet)

---

## 🌟 Introduction

### Pourquoi des Outils de Qualité ?

Imagine que vous construisez une maison. Vous ne vous contentez pas de la construire, vous vérifiez aussi que :
- Les murs sont droits
- Les portes ferment bien
- L'électricité fonctionne
- Le toit ne fuit pas

C'est pareil pour le code ! Les outils de qualité vérifient que votre code :
- ✅ Fonctionne correctement (tests)
- ✅ Respecte les bonnes pratiques (style)
- ✅ N'a pas d'erreurs cachées (analyse statique)
- ✅ Est facile à comprendre (bonne organisation)

---

## 🛠️ Les 3 Outils Principaux

### 1. PHPUnit - Les Tests

**Rôle :** Vérifie que votre code fait bien ce qu'il doit faire.

**Exemple :**
```php
// Votre code
function addition(int $a, int $b): int 
{
    return $a + $b;
}

// Test PHPUnit
public function testAddition(): void
{
    $result = addition(2, 3);
    $this->assertEquals(5, $result); // ✅ Ça marche !
}
```

**Pourquoi c'est important :**
- Vous savez immédiatement si quelque chose casse
- Vous pouvez modifier votre code en confiance
- Les tests sont comme une documentation vivante

### 2. PHPStan - L'Analyseur Statique

**Rôle :** Trouve les erreurs AVANT de lancer votre code.

**Exemple :**
```php
// ❌ Problème détecté par PHPStan
function divide($a, $b) 
{
    return $a / $b; // $b pourrait être 0 !
}

// ✅ Correction
function divide(int $a, int $b): int 
{
    if ($b === 0) {
        throw new InvalidArgumentException('Division par zéro');
    }
    return $a / $b;
}
```

**Pourquoi c'est important :**
- Détecte 90% des bugs avant qu'ils n'arrivent
- Force à écrire du code plus sûr
- Évite les erreurs en production

### 3. CodeSniffer - Le Nettoyeur de Code

**Rôle :** Uniformise le style du code dans tout le projet.

**Exemple :**
```php
// ❌ Avant (incohérent)
function test($a,$b){
return $a+$b;
}

// ✅ Après (uniforme)
function test(int $a, int $b): int
{
    return $a + $b;
}
```

**Pourquoi c'est important :**
- Tout le monde écrit de la même façon
- Le code est plus facile à lire
- Collaboration simplifiée

---

## 🧪 PHPUnit - Les Tests

### Qu'est-ce qu'un Test ?

Un test est une fonction qui vérifie que votre code fonctionne.

**Exemple Simple :**
```php
public function testAddition(): void
{
    // Arrange : Préparer
    $a = 2;
    $b = 3;
    
    // Act : Exécuter
    $result = $a + $b;
    
    // Assert : Vérifier
    $this->assertEquals(5, $result);
}
```

### Structure AAA (Arrange-Act-Assert)

Chaque test suit ces 3 étapes :

1. **Arrange** (Préparer) - Mettre en place les données
2. **Act** (Agir) - Exécuter la fonction testée
3. **Assert** (Vérifier) - Vérifier le résultat

**Exemple Détaillé :**
```php
public function testCreateUser(): void
{
    // ARRANGE - Préparer les données
    $email = 'john@example.com';
    $name = 'John Doe';
    
    // ACT - Exécuter le code à tester
    $user = new User($email, $name);
    
    // ASSERT - Vérifier le résultat
    $this->assertEquals($email, $user->getEmail());
    $this->assertEquals($name, $user->getName());
}
```

### Commandes PHPUnit

```bash
# Tous les tests
./vendor/bin/phpunit tests/TestCase/ --testdox

# Un fichier spécifique
./vendor/bin/phpunit tests/TestCase/Domain/User/Entity/UserTest.php

# Une méthode spécifique
./vendor/bin/phpunit --filter testCreateUserWithValidData

# S'arrêter au premier échec
./vendor/bin/phpunit tests/ --stop-on-failure
```

---

## 🔍 PHPStan - L'Analyseur Statique

### Niveaux d'Analyse

```
Level 0: Erreurs évidentes (ex: variable non définie)
Level 1: Types de base
Level 5: Types complexes
Level 8: Analyse très poussée (recommandé)
Level 9: Analyse maximale (peut être trop strict)
```

### Configuration

Fichier `phpstan.neon` :
```yaml
parameters:
    level: 8                # Niveau d'analyse
    paths:
        - src               # Dossiers à analyser
    excludePaths:
        - src/**/config/*   # Ignorer certains fichiers
```

### Commandes PHPStan

```bash
# Analyser le code
composer stan

# Générer un baseline (ignorer les erreurs existantes)
composer stan-baseline
```

---

## 🎨 CodeSniffer - Le Style

### Standards Supportés

- **PSR-12** : Standard de codage PHP recommandé
- **PSR-1** : Standard de codage de base
- **PSR-2** : Guide de style de codage

### Configuration

Fichier `.php-cs-fixer.dist.php` :
```php
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
    ->name('*.php');

$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR12' => true,
        'single_quote' => true,
        'array_syntax' => ['syntax' => 'short'],
    ])
    ->setFinder($finder);
```

### Commandes CodeSniffer

```bash
# Vérifier le style
composer cs-check

# Corriger automatiquement
composer cs-fix

# Vérifier un fichier spécifique
./vendor/bin/php-cs-fixer check src/Controller/AppController.php
```

---

## 💡 Bonnes Pratiques

### ✅ À Faire

1. **Nommer clairement les tests**
   ```php
   testCreateUserWithValidData()
   testUserWithInvalidEmail()
   ```

2. **Un test = Un comportement**
   ```php
   testEmailValidation()  // Teste SEULEMENT l'email
   testNameValidation()   // Teste SEULEMENT le nom
   ```

3. **Utiliser le pattern AAA**
   - **Arrange** : Préparer
   - **Act** : Exécuter
   - **Assert** : Vérifier

4. **Tester les cas limites**
   ```php
   testCreateUserWithEmptyName()
   testCreateUserWithNameTooLong()
   ```

### ❌ À Éviter

1. **Tests qui dépendent d'autres tests**
2. **Accès à la base de données réelle**
3. **Trop de mocks**
4. **Données bizarres**

---

## 📊 Résumé

✅ **3 outils essentiels** pour la qualité du code  
✅ **PHPUnit** pour les tests  
✅ **PHPStan** pour l'analyse statique  
✅ **CodeSniffer** pour le style  
✅ **100% automatisé** via l'interface web

---

## 📚 Ressources

- [Documentation PHPUnit](https://phpunit.de/documentation.html)
- [Documentation PHPStan](https://phpstan.org/user-guide/getting-started)
- [PSR-12 Standard](https://www.php-fig.org/psr/psr-12/)
- [CakePHP Testing Guide](https://book.cakephp.org/5/en/development/testing.html)

---


