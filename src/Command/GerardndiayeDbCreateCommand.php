<?php

namespace App\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'gerardndiaye:db:create',
    description: 'Créer la base de données du projet'
)]
class GerardndiayeDbCreateCommand
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function __invoke(SymfonyStyle $io): int
    {
        // Récupérer les paramètres de connexion configurés dans Symfony.
        $params = $this->connection->getParams();
        $databaseName = $params['dbname'] ?? null;

        if (!$databaseName) {
            $io->error('Le nom de la base est absent de DATABASE_URL.');
            return Command::FAILURE;
        }

        // Vérifier le nom de la base avant de construire la requête SQL.
        if (!preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/', $databaseName)) {
            $io->error('Le nom de la base de données est invalide.');
            return Command::FAILURE;
        }

        // Se connecter à la base système PostgreSQL.
        $adminParams = $params;
        unset($adminParams['url']);
        $adminParams['dbname'] = 'postgres';

        $adminConnection = null;

        try {
            $adminConnection = DriverManager::getConnection($adminParams);

            // Vérifier si la base existe déjà.
            $exists = $adminConnection->fetchOne(
                'SELECT 1 FROM pg_database WHERE datname = ?',
                [$databaseName]
            );

            if ($exists) {
                $io->warning("La base '$databaseName' existe déjà.");
                return Command::SUCCESS;
            }

            // Créer la base de données.
            $adminConnection->executeStatement(
                'CREATE DATABASE "' . $databaseName . '"'
            );

            $io->success("La base '$databaseName' a été créée.");
            return Command::SUCCESS;

        } catch (\Throwable $e) {
            $io->error('Erreur : ' . $e->getMessage());
            return Command::FAILURE;

        } finally {
            $adminConnection?->close();
        }
    }
}
