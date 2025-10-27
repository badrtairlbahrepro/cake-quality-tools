<?php
/**
 * Quality Tools Page
 * Display quality testing information and controls
 */
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1><i class="fas fa-tasks"></i> Outils de Qualité du Code</h1>
            <p class="text-muted">Gérez les tests, l'analyse statique et le style de code</p>
        </div>
    </div>

    <!-- Cards Informatives -->
    <div class="row mb-4">
        <div class="col-lg-4 mb-3">
            <div class="card border-primary">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-flask"></i> PHPUnit - Tests</h5>
                </div>
                <div class="card-body">
                    <p>Vérifie que votre code fonctionne correctement</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> 25 tests disponibles</li>
                        <li><i class="fas fa-check text-success"></i> 65 assertions</li>
                        <li><i class="fas fa-check text-success"></i> Pattern AAA</li>
                    </ul>
                    <button class="btn btn-primary" onclick="runTests()">
                        <i class="fas fa-play"></i> Lancer les Tests
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card border-info">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="fas fa-search"></i> PHPStan - Analyse</h5>
                </div>
                <div class="card-body">
                    <p>Détecte les erreurs potentielles avant l'exécution</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Niveau 8 (avancé)</li>
                        <li><i class="fas fa-check text-success"></i> Analyse statique</li>
                        <li><i class="fas fa-check text-success"></i> 0 erreur (baseline)</li>
                    </ul>
                    <button class="btn btn-info" onclick="runPHPStan()">
                        <i class="fas fa-search"></i> Analyser le Code
                    </button>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-3">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-broom"></i> CodeSniffer - Style</h5>
                </div>
                <div class="card-body">
                    <p>Uniformise le style du code</p>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-check text-success"></i> Standard PSR-12</li>
                        <li><i class="fas fa-check text-success"></i> Auto-fix disponible</li>
                        <li><i class="fas fa-check text-success"></i> Conformité assurée</li>
                    </ul>
                    <button class="btn btn-success" onclick="runCodeSniffer()">
                        <i class="fas fa-broom"></i> Vérifier le Style
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Résultats -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-terminal"></i> Résultats</h5>
                </div>
                <div class="card-body">
                    <div id="results" class="bg-dark text-light p-3 rounded" style="font-family: monospace; min-height: 200px; max-height: 500px; overflow-y: auto;">
                        <p class="text-muted mb-0">En attente d'exécution...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showLoading() {
    const results = document.getElementById('results');
    results.innerHTML = '<p class="text-info"><i class="fas fa-spinner fa-spin"></i> En cours d\'exécution...</p>';
}

function displayResults(output) {
    const results = document.getElementById('results');
    results.innerHTML = '<pre class="text-light">' + escapeHtml(output) + '</pre>';
}

function escapeHtml(text) {
    const map = {
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    };
    return text.replace(/[&<>"']/g, m => map[m]);
}

function runTests() {
    showLoading();
    
    fetch('/quality-tools/run-tests')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayResults(data.output);
        } else {
            displayResults('Erreur lors de l\'exécution des tests');
        }
    })
    .catch(error => {
        displayResults('Erreur: ' + error.message);
    });
}

function runPHPStan() {
    showLoading();
    
    fetch('/quality-tools/run-stan')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayResults(data.output);
        } else {
            displayResults('Erreur lors de l\'analyse PHPStan');
        }
    })
    .catch(error => {
        displayResults('Erreur: ' + error.message);
    });
}

function runCodeSniffer() {
    showLoading();
    
    fetch('/quality-tools/run-cs')
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            displayResults(data.output);
        } else {
            displayResults('Erreur lors de la vérification du style');
        }
    })
    .catch(error => {
        displayResults('Erreur: ' + error.message);
    });
}
</script>

