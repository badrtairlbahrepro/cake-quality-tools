# 📚 Documentation Complète - Outils de Qualité du Code

## 🎯 Table des Matières

1. [Introduction](#introduction)
2. [Qu'est-ce que la Qualité du Code ?](#quest-ce-que-la-qualité-du-code)
3. [Les Outils Installés](#les-outils-installés)
4. [Configuration Détails](#configuration-détails)
5. [Comment Utiliser ?](#comment-utiliser)
6. [Les Tests - Guide Complet](#les-tests-guide-complet)
7. [Troubleshooting](#troubleshooting)
8. [Bonnes Pratiques](#bonnes-pratiques)

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

### Les 3 Outils Principaux

```
┌─────────────────┐
│   PHPUnit       │ → Les tests : vérifie que tout fonctionne
└─────────────────┘

┌─────────────────┐
│   PHPStan       │ → L'analyse : détecte les erreurs potentielles
└─────────────────┘

┌─────────────────┐
│ CodeSniffer     │ → Le style : uniformise le code
└─────────────────┘
```

---

## 🤔 Qu'est-ce que la Qualité du Code ?

### Le Code "Sale" vs le Code "Propre"

#### 🚫 Code Sale (à éviter)
```php
// Pas d'espace après les virgules
function add($a,$b){return $a+$b;}

// Variables sans noms clairs
$x=$y+$z;

// Pas de vérification d'erreur
$result=divide(10, 0); // Crash !
```

#### ✅ Code Propre
```php
// Espaces corrects
function add(int $a, int $b): int 
{
    return $a + $b;
}

// Noms clairs
$total = $prix + $taxe;

// Gestion des erreurs
if ($diviseur != 0) {
    $result = divide(10, $diviseur);
} else {
    throw new Exception('Division par zéro !');
}
```

### Les 3 Pilliers de la Qualité

1. **Fonctionnel** → Ça marche
2. **Lisible** → Facile à comprendre
3. **Maintenable** → Facile à modifier

---

## 🛠️ Les Outils Installés

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

### 3. PHP_CodeSniffer - Le Nettoyeur de Code

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

## ⚙️ Configuration Détails

### Structure des Fichiers

```
votre-projet/
├── phpunit.xml.dist         → Config PHPUnit (tests)
├── phpstan.neon            → Config PHPStan (analyse)
├── phpstan-baseline.neon   → Baseline PHPStan (erreurs ignorées)
├── .php-cs-fixer.dist.php  → Config PHP-CS-Fixer (style)
└── composer.json            → Commandes disponibles
```

### 1. PHPUnit Configuration (`phpunit.xml.dist`)

#### C'est quoi ?
Le fichier qui dit à PHPUnit où trouver vos tests.

#### Configuration Clé

```xml
<phpunit>
    <!-- Dossier des tests -->
    <testsuites>
        <testsuite name="Application Test Suite">
            <directory>tests/TestCase</directory>
        </testsuite>
    </testsuites>
    
    <!-- Dossiers à ignorer -->
    <exclude>
        <directory>tests/TestCase/Application/Command</directory>
    </exclude>
</phpunit>
```

#### Pourquoi ?
- **`<testsuites>`** : Dit à PHPUnit où sont vos tests
- **`<exclude>`** : Ignore certains dossiers (ex: commandes CLI)

#### Comment Tester ?
```bash
# Lancer tous les tests
composer test

# Lancer un test spécifique
./vendor/bin/phpunit tests/TestCase/Domain/User/Entity/UserTest.php
```

---

### 2. PHPStan Configuration (`phpstan.neon`)

#### C'est quoi ?
Le fichier qui configure l'analyseur PHPStan.

#### Configuration Détaillée

```yaml
parameters:
    # Niveau d'analyse (0 = très basique, 9 = maximal)
    level: 8
    
    # Dossiers à analyser
    paths:
        - src
    
    # Dossiers à ignorer
    excludePaths:
        - src/**/config/*
    
    # Dossier temporaire
    tmpDir: tmp/phpstan

# Fichiers supplémentaires
includes:
    - phpstan-baseline.neon  # Ignore les erreurs existantes
```

#### Explication des Paramètres

**`level: 8`** - Niveau d'analyse
```
Level 0: Erreurs évidentes (ex: variable non définie)
Level 1: Types de base
Level 5: Types complexes
Level 8: Analyse très poussée (notre niveau)
Level 9: Analyse maximale (peut être trop strict)
```

**Pourquoi Level 8 ?**
- Pas trop strict pour un projet en cours
- Assez strict pour détecter les vrais problèmes
- Bon équilibre entre sécurité et praticité

**`excludePaths`** - Dossiers à ignorer
```yaml
excludePaths:
    - src/**/config/*  # Les fichiers de config CakePHP
```
→ Ces fichiers sont générés automatiquement, pas besoin de les analyser

**`includes: phpstan-baseline.neon`** - Le Baseline
```yaml
includes:
    - phpstan-baseline.neon
```
→ Ignore les erreurs existantes, mais détecte les nouvelles

**Comment ça marche ?**
1. Première analyse : 105 erreurs trouvées
2. Baseline générée : ces erreurs sont ignorées
3. Prochaines analyses : seules les NOUVELLES erreurs sont signalées

**Pourquoi un Baseline ?**
- On ne peut pas tout corriger d'un coup
- On se concentre sur les nouveaux problèmes
- Projet existant = baseline nécessaire

---

### 3. PHP-CS-Fixer Configuration (`.php-cs-fixer.dist.php`)

#### C'est quoi ?
Le fichier qui dit comment formater votre code automatiquement.

#### Configuration Détaillée

```php
<?php

// Dossiers à formater
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)              // Racine du projet
    ->exclude('vendor')        // Ignore vendor
    ->exclude('tmp')           // Ignore tmp
    ->name('*.php');           // Seulement les .php

// Règles à appliquer
$config = new PhpCsFixer\Config();
return $config
    ->setRules([
        '@PSR12' => true,      // Standard PSR-12
        'single_quote' => true, // Guillemets simples
        'array_syntax' => ['syntax' => 'short'], // array() → []
        // ... autres règles
    ])
    ->setFinder($finder);
```

#### Règles Importantes

**`@PSR12`** - Standard PHP
```php
// ❌ Avant
function test(){
return $a;
}

// ✅ Après
function test(): void
{
    return $a;
}
```

**`single_quote`** - Guillemets simples
```php
// ❌ Avant
echo "Hello World";

// ✅ Après
echo 'Hello World'; // Plus rapide
```

**`array_syntax`** - Syntaxe courte
```php
// ❌ Avant
$arr = array('a', 'b');

// ✅ Après
$arr = ['a', 'b']; // Plus moderne
```

---

## 🚀 Comment Utiliser ?

### Commandes Disponibles

#### 1. Tester le Code

```bash
# Lancer tous les tests
composer test

# Résultat attendu
OK (25 tests, 65 assertions)
```

**Quand l'utiliser ?**
- Avant de commit du code
- Après avoir modifié une fonction
- Avant de déployer en production

#### 2. Analyser le Code (PHPStan)

```bash
# Analyser le code
composer stan

# Résultat attendu
[OK] No errors
```

**Quand l'utiliser ?**
- Après avoir écrit du nouveau code
- Quand vous avez des doutes sur votre code
- Avant une release

#### 3. Vérifier le Style

```bash
# Vérifier le style
composer cs-check

# Résultat attendu
No sniff violations found
```

**Quand l'utiliser ?**
- Avant chaque commit
- Quand vous voyez du code avec un style différent

#### 4. Corriger Automatiquement le Style

```bash
# Corriger le style
composer cs-fix

# Résultat attendu
A TOTAL OF 149 ERRORS WERE FIXED IN 22 FILES
```

**Quand l'utiliser ?**
- Quand `cs-check` trouve des erreurs
- Quand vous copiez du code d'ailleurs
- Avant de commit

#### 5. Tout Vérifier en Une Fois

```bash
# Tests + Qualité
composer check

# Résultat attendu
OK (25 tests, 65 assertions)
No errors
```

**Quand l'utiliser ?**
- Avant un déploiement
- À la fin de chaque journée
- Avant une pull request

---

## 🧪 Les Tests - Guide Complet

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

### Structure d'un Test

Chaque test suit le pattern **AAA** :

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

### Les Tests du Projet

#### 1. Test d'Entité (`UserTest.php`)

**Fichier :** `tests/TestCase/Domain/User/Entity/UserTest.php`

**Rôle :** Vérifie que l'entité User fonctionne correctement.

**Tests Inclus :**

```php
// Test 1: Créer un utilisateur avec des données valides
public function testCreateUserWithValidData(): void
{
    $user = new User('john@example.com', 'John Doe');
    
    $this->assertEquals('john@example.com', $user->getEmail());
    $this->assertEquals('John Doe', $user->getName());
}
```
**À quoi ça sert ?** Vérifie que la création d'utilisateur fonctionne.

```php
// Test 2: Créer avec un email invalide
public function testCreateUserWithInvalidEmail(): void
{
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Format d\'email invalide');
    
    new User('not-an-email', 'John Doe');
}
```
**À quoi ça sert ?** Vérifie que les emails invalides sont refusés.

```php
// Test 3: Créer avec un nom trop court
public function testCreateUserWithNameTooShort(): void
{
    $this->expectException(InvalidArgumentException::class);
    $this->expectExceptionMessage('Le nom doit comporter au moins 2 caractères');
    
    new User('john@example.com', 'A');
}
```
**À quoi ça sert ?** Vérifie que les noms trop courts sont refusés.

---

#### 2. Test de Cas d'Usage (`CreateUserUseCaseTest.php`)

**Fichier :** `tests/TestCase/Application/UseCases/User/CreateUserUseCaseTest.php`

**Rôle :** Vérifie que le cas d'usage de création d'utilisateur fonctionne.

**Ce qui est Testé :**

**Test 1: Créer un utilisateur avec succès**
```php
public function testCreateUserSuccessfully(): void
{
    // Préparer
    $email = 'john@example.com';
    $name = 'John Doe';
    
    // Simuler le repository
    $this->repositoryMock
        ->expects($this->once())
        ->method('findByEmail')
        ->willReturn(null); // L'utilisateur n'existe pas
    
    $this->repositoryMock
        ->expects($this->once())
        ->method('save')
        ->willReturn(new User($email, $name, 1));
    
    // Exécuter
    $result = $this->useCase->execute($email, $name);
    
    // Vérifier
    $this->assertEquals($email, $result->getEmail());
    $this->assertEquals(1, $result->getId());
}
```
**À quoi ça sert ?** 
- Vérifie que la création fonctionne
- Vérifie que le repository est appelé correctement

**Test 2: Créer avec un email déjà existant**
```php
public function testCreateUserWithDuplicateEmail(): void
{
    $email = 'john@example.com';
    
    // Simuler un utilisateur existant
    $existingUser = new User($email, 'Existing', 1);
    $this->repositoryMock
        ->method('findByEmail')
        ->willReturn($existingUser); // L'utilisateur existe !
    
    // Attendre une exception
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Utilisateur avec cet email existe déjà');
    
    // Exécuter
    $this->useCase->execute($email, 'John Doe');
}
```
**À quoi ça sert ?**
- Vérifie qu'on ne peut pas créer 2 utilisateurs avec le même email
- Vérifie que la bonne exception est lancée

---

#### 3. Test de Cas d'Usage (`GetUserUseCaseTest.php`)

**Fichier :** `tests/TestCase/Application/UseCases/User/GetUserUseCaseTest.php`

**Rôle :** Vérifie que la récupération d'utilisateur fonctionne.

**Tests Inclus :**

**Test 1: Récupérer un utilisateur par ID**
```php
public function testGetUserByIdSuccessfully(): void
{
    $userId = 1;
    $expectedUser = new User('john@example.com', 'John Doe', $userId);
    
    $this->repositoryMock
        ->method('findById')
        ->with($userId)
        ->willReturn($expectedUser);
    
    $result = $this->useCase->execute($userId);
    
    $this->assertEquals($userId, $result->getId());
    $this->assertEquals('john@example.com', $result->getEmail());
}
```
**À quoi ça sert ?** Vérifie qu'on peut récupérer un utilisateur existant.

**Test 2: Récupérer un utilisateur inexistant**
```php
public function testGetUserNotFound(): void
{
    $this->repositoryMock
        ->method('findById')
        ->willReturn(null); // Utilisateur inexistant
    
    $this->expectException(RuntimeException::class);
    $this->expectExceptionMessage('Utilisateur non trouvé');
    
    $this->useCase->execute(999);
}
```
**À quoi ça sert ?** Vérifie qu'une exception est lancée si l'utilisateur n'existe pas.

---

### Les Mocks (Simulation)

#### Qu'est-ce qu'un Mock ?

Un **mock** est un objet factice qui simule le comportement d'un vrai objet.

**Pourquoi utiliser des Mocks ?**
- On ne veut pas tester la base de données
- On veut isoler la fonction testée
- On veut contrôler les résultats

**Exemple :**
```php
// Au lieu de cette ligne (appel réel)
$repository->findByEmail('john@example.com');

// On utilise un mock
$this->repositoryMock
    ->method('findByEmail')
    ->willReturn(new User(...)); // On contrôle le résultat
```

#### Comment Créer un Mock

```php
// 1. Créer le mock dans setUp()
protected function setUp(): void
{
    $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
    $this->useCase = new CreateUserUseCase($this->repositoryMock);
}

// 2. Configurer le mock dans chaque test
public function testSomething(): void
{
    // Configuration
    $this->repositoryMock
        ->expects($this->once())        // Combien de fois ?
        ->method('findByEmail')         // Quelle méthode ?
        ->with('john@example.com')      // Avec quels paramètres ?
        ->willReturn($existingUser);    // Quel résultat ?
    
    // Exécution
    $this->useCase->execute(...);
}
```

#### Options `expects()`

```php
// Exemple
->expects($this->once())      // Une seule fois
->expects($this->never())     // Jamais
->expects($this->atLeast(2))  // Au moins 2 fois
```

---

## 🔧 Troubleshooting

### Problèmes Courants

#### 1. Test Fail (Échec)

**Message :**
```
Failed asserting that 2 matches expected 5.
```

**Pourquoi ?**
La valeur retournée ne correspond pas à celle attendue.

**Solution :**
```php
// Vérifier la valeur attendue
$this->assertEquals(5, $result);

// Vérifier aussi le type
$this->assertSame(5, $result); // Vérifie aussi le type

// Déboguer
var_dump($result); // Voir la valeur réelle
```

#### 2. Mock Ne Fonctionne Pas

**Message :**
```
Method expects at least 1 call, but it was called 0 times.
```

**Pourquoi ?**
Le code n'appelle pas la méthode mockée.

**Solution :**
```php
// Vérifier que la méthode est appelée
$this->repositoryMock
    ->expects($this->once())  // Vérifie qu'elle est appelée
    ->method('save');

// Ou lancer le code qui devrait l'appeler
$this->useCase->execute($email, $name);
```

#### 3. PHPStan Trouve Trop d'Erreurs

**Message :**
```
Found 105 errors
```

**Pourquoi ?**
Beaucoup d'erreurs existantes dans le code.

**Solution :**
```bash
# Générer un baseline
composer stan-baseline

# Les anciennes erreurs sont ignorées
# Seules les nouvelles seront signalées
```

#### 4. CodeSniffer Ne Corrige Pas Tout

**Message :**
```
[ ] Line exceeds 120 characters
```

**Pourquoi ?**
Certaines règles ne peuvent pas être corrigées automatiquement.

**Solution :**
```php
// Avant (120+ caractères)
$result = $this->repository->findByEmail('verylongemail@verylongdomainname.com');

// Après (court)
$email = 'verylongemail@verylongdomainname.com';
$result = $this->repository->findByEmail($email);
```

---

## 💡 Bonnes Pratiques

### Pour Écrire de Bons Tests

#### ✅ À FAIRE

1. **Un test = Un comportement**
```php
// ✅ BON - Un test, un comportement
public function testEmailValidation(): void { ... }
public function testNameValidation(): void { ... }

// ❌ MAUVAIS - Un test, tout mélangé
public function testUser(): void {
    // Teste email, nom, date, etc.
}
```

2. **Nommer clairement les tests**
```php
// ✅ BON - Clair
testCreateUserWithInvalidEmail
testUserCannotBeCreatedWithEmptyName

// ❌ MAUVAIS - Pas clair
test1
testUser
testSomething
```

3. **Utiliser le pattern AAA**
```php
// Arrange
$user = new User(...);

// Act
$result = $user->getEmail();

// Assert
$this->assertEquals('john@example.com', $result);
```

4. **Tester les cas limites**
```php
// Teste les cas normaux
testCreateUserWithValidData()

// Teste aussi les cas limites
testCreateUserWithEmptyName()
testCreateUserWithNameTooLong()
testCreateUserWithSpecialCharacters()
```

#### ❌ À ÉVITER

1. **Tests qui dépendent d'autres tests**
```php
// ❌ MAUVAIS - Le test 2 dépend du test 1
public function testCreateUser(): void {
    $this->userId = 1; // Variable globale
}

public function testGetUser(): void {
    $this->useCase->execute($this->userId); // Dépend du test 1
}
```

2. **Tests sans assertions**
```php
// ❌ MAUVAIS - Ne teste rien
public function testSomething(): void {
    $user = new User('john@example.com', 'John');
    // Pas d'assertion !
}
```

3. **Tests qui touchent la base de données**
```php
// ❌ MAUVAIS - Lent et fragile
public function testCreateUser(): void {
    $repo = new UserRepository(); // Repository réel
    $user = $repo->save(new User(...)); // Enregistre en DB
}
```

4. **Données de test bizarres**
```php
// ❌ MAUVAIS - Pas réaliste
$email = 'a@b.c';
$name = 'x';

// ✅ BON - Réaliste
$email = 'john@example.com';
$name = 'John Doe';
```

---

## 📊 Résumé Visuel

### Workflow Complet

```
┌─────────────────────────────────────────────────┐
│  1. Écrire le code                               │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│  2. Lancer composer check                        │
│     ┌─────────────────────────────────────┐     │
│     │ Tests PHPUnit → 25/25 ✅            │     │
│     │ PHPStan      → 0 erreur ✅          │     │
│     │ CodeSniffer  → Pas d'erreur ✅      │     │
│     └─────────────────────────────────────┘     │
└─────────────────┬───────────────────────────────┘
                  │
                  ▼
┌─────────────────────────────────────────────────┐
│  3. Commit et Push                               │
└─────────────────────────────────────────────────┘
```

### Commandes Essentielles

| Commande | Quand l'utiliser ? | Que fait-elle ? |
|----------|-------------------|-----------------|
| `composer test` | Avant commit | Lance les tests |
| `composer stan` | Après nouveaux code | Analyse le code |
| `composer cs-check` | Avant commit | Vérifie le style |
| `composer cs-fix` | Après cs-check | Corrige le style |
| `composer check` | Avant push | Tout vérifier |

---

## 🎓 Conclusion

### Ce que Vous Avez Appris

✅ **Tests** - Vérifier que le code fonctionne
✅ **PHPStan** - Détecter les erreurs
✅ **CodeSniffer** - Uniformiser le style
✅ **Commandes** - Comment tout utiliser
✅ **Bonnes Pratiques** - Écrire de bons tests

### Prochaines Étapes

1. 🔨 **Pratiquer** - Lancez `composer check` régulièrement
2. 📚 **Lire** - Consultez les tests existants comme exemples
3. ✍️ **Écrire** - Commencez par des tests simples
4. 🤝 **Partager** - Demandez des avis sur vos tests

### Ressources Utiles

- [Documentation PHPUnit](https://phpunit.de/documentation.html)
- [Documentation PHPStan](https://phpstan.org/user-guide/getting-started)
- [PSR-12 Standard](https://www.php-fig.org/psr/psr-12/)

---

## 💬 Questions Fréquentes

### Q: Pourquoi mes tests échouent ?
**R:** Vérifiez que vous avez bien modifié le code testé. Lancez `composer test` pour voir l'erreur exacte.

### Q: PHPStan trouve trop d'erreurs, que faire ?
**R:** Utilisez `composer stan-baseline` pour ignorer les erreurs existantes. Les nouvelles seront quand même détectées.

### Q: Je ne comprends pas un test, comment faire ?
**R:** Lisez les commentaires dans le fichier de test. Les noms de test expliquent aussi ce qui est testé.

### Q: Dois-je tester absolument tout ?
**R:** Pas forcément. Concentrez-vous sur la logique métier importante. Les getters/setters simples n'ont pas besoin de tests.

---

**Bonne chance dans vos tests ! 🚀**
