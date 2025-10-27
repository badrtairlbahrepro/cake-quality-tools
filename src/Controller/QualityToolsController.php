<?php

declare(strict_types=1);

namespace CakeQualityTools\Controller;

use Cake\Event\EventInterface;
use Cake\Http\Response;

/**
 * QualityTools Controller
 *
 * Dashboard for running quality checks (PHPUnit, PHPStan, CodeSniffer)
 * 
 * Compatible PHP 7.4+ and Bootstrap framework
 */
class QualityToolsController extends \App\Controller\AppController
{
    /**
     * Initialize method
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    /**
     * Before filter callback
     */
    public function beforeFilter(EventInterface $event): void
    {
        parent::beforeFilter($event);
        
        // Skip CSRF verification for AJAX endpoints
        // GET requests are not subject to CSRF protection in CakePHP
    }

    /**
     * Display quality tools dashboard
     */
    public function index(): void
    {
        // Render the quality dashboard
    }

    /**
     * Run PHPUnit tests via AJAX
     */
    public function runTests(): ?Response
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        try {
            $command = 'cd ' . ROOT . ' && ./vendor/bin/phpunit tests/TestCase/ --testdox 2>&1';
            $output = shell_exec($command);
            
            if ($output === null) {
                $output = 'Erreur: La commande n\'a retourné aucun résultat';
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'output' => $output,
                ]));
        } catch (\Exception $e) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'output' => 'Erreur: ' . $e->getMessage(),
                ]));
        }
    }

    /**
     * Run PHPStan analysis via AJAX
     */
    public function runStan(): ?Response
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        try {
            $command = 'cd ' . ROOT . ' && composer stan 2>&1';
            $output = shell_exec($command);
            
            if ($output === null) {
                $output = 'Erreur: La commande n\'a retourné aucun résultat';
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'output' => $output,
                ]));
        } catch (\Exception $e) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'output' => 'Erreur: ' . $e->getMessage(),
                ]));
        }
    }

    /**
     * Run CodeSniffer check via AJAX
     */
    public function runCodeSniffer(): ?Response
    {
        $this->request->allowMethod(['get']);
        $this->autoRender = false;

        try {
            $command = 'cd ' . ROOT . ' && composer cs-check 2>&1';
            $output = shell_exec($command);
            
            if ($output === null) {
                $output = 'Erreur: La commande n\'a retourné aucun résultat';
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'output' => $output,
                ]));
        } catch (\Exception $e) {
            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => false,
                    'output' => 'Erreur: ' . $e->getMessage(),
                ]));
        }
    }
}
