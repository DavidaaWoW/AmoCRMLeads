SELECT 'CREATE DATABASE maindb'
WHERE NOT EXISTS (SELECT FROM pg_database WHERE datname = 'maindb')\gexec

\c maindb;