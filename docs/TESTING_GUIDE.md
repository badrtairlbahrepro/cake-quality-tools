# 🧪 Guide Complet des Tests

## 📖 Introduction

Ce guide explique **comment tester votre code** avec les outils installés dans le projet.

### 🎯 Objectifs

- ✅ Comprendre pourquoi tester
- ✅ Savoir écrire des tests
- ✅ Utiliser les commandes de test
- ✅ Interpréter les résultats

---

## 1️⃣ PHPUnit - Les Tests

### Qu'est-ce que c'est ?

**PHPUnit** vérifie que votre code fonctionne correctement.

**Exemple simple :**

```php
// Votre fonction
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

### Pourquoi c'est important ?

✅ Vous savez immédiatement si quelque chose casse  
✅ Vous pouvez modifier votre code en confiance  
✅ Les tests sont comme une documentation vivante

---

## 2️⃣ Comment Écrire un Test ?

### Structure AAA (Arrange-Act-Assert)

**Chaque test suit ces 3 étapes :**

```php
public function testCreateUser(): void
{
    // 🎯 ARRANGE - Préparer les données
    $email = 'john@example.com';
    $name = 'John Doe';
    
    // ⚡ ACT - Exécuter le code à tester
    $user = new User($email, $name);
    
    // ✅ ASSERT - Vérifier le résultat
    $this->assertEquals($email, $user->getEmail());
    $this->assertEquals($name, $user->getName());
}
```

---

## 3️⃣ Les Tests Existants

### Fichiers de Test Disponibles

```
tests/TestCase/
├── Domain/
│   └── User/
│       └── Entity/
│           └── UserTest.php              # 13 tests
├── Application/
│   └── UseCases/
│       └── User/
│           ├── CreateUserUseCaseTest.php  # 6 tests
│           └── GetUserUseCaseTest.php     # 6 tests
```

**Total : 25 tests, 65 assertions**

---

## 4️⃣ Lancer les Tests

### Commandes de Base

```bash
# Tous les tests
./vendor/bin/phpunit tests/TestCase/ --testdox

# Un dossier spécifique
./vendor/bin/phpunit tests/TestCase/Domain/ --testdox

# Un fichier spécifique
./vendor/bin/phpunit tests/TestCase/Domain/User/Entity/UserTest.php --testdox

# Une méthode spécifique
./vendor/bin/phpunit --filter testCreateUserWithValidData

# S'arrêter au premier échec
./vendor/bin/phpunit tests/ --stop-on-failure
```

---

## 5️⃣ Interpréter les Résultats

### ✅ Test Réussi

```
✔ Create user with valid data
Time: 00:00.035
OK (1 test, 2 assertions)
```

**Signification :** Tout fonctionne correctement.

### ❌ Test Échoué

```
✘ Create user with valid data
Failed asserting that 2 matches expected 5.
```

**Signification :** Le résultat obtenu (2) ne correspond pas à ce qui était attendu (5).

---

## 6️⃣ Les Mocks

### Qu'est-ce qu'un Mock ?

Un **mock** est un objet factice qui simule le comportement d'un vrai objet.

**Pourquoi l'utiliser ?**

```
Sans Mock: User → Repository → Database  ❌ Compliqué
Avec Mock:  User → Mock Repository        ✅ Simple et rapide
```

### Exemple avec Mock

```php
protected function setUp(): void
{
    // Créer un mock du repository
    $this->repositoryMock = $this->createMock(UserRepositoryInterface::class);
    
    // Injecter le mock au use case
    $this->useCase = new CreateUserUseCase($this->repositoryMock);
}

public function testCreateUser(): void
{
    // Configurer le mock
    $this->repositoryMock
        ->expects($this->once())        // Combien de fois ?
        ->method('findByEmail')         // Quelle méthode ?
        ->with('john@example.com')      // Avec quels paramètres ?
        ->willReturn(null);             // Quel résultat ?
    
    // Exécuter le code
    $result = $this->useCase->execute('john@example.com', 'John');
}
```

---

## 7️⃣ Bonnes Pratiques

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

### ❌ À Éviter

1. **Tests qui dépendent d'autres tests**
2. **Accès à la base de données réelle**
3. **Trop de mocks**
4. **Données bizarres**

---

## 🎯 Résumé

✅ **25 tests** couvrant le code  
✅ **Pattern AAA** pour structure claire  
✅ **Mocks** pour isoler les dépendances  
✅ **100% de réussite** actuel

Pour plus de détails, consultez `TESTING.md` et `TESTS_QUICKSTART.md`

