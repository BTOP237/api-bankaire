<?php
/**
 * Classe Database - Gestion de la base de données SQLite
 */
class Database {
    private static $db;

    /**
     * Initialiser la base de données
     */
    public static function init() {
        try {
            self::$db = new SQLite3(DB_FILE);
            self::$db->busyTimeout(5000);
            self::createTables();
        } catch (Exception $e) {
            die(json_encode(['error' => 'Erreur de connexion DB: ' . $e->getMessage()]));
        }
    }

    /**
     * Créer les tables si elles n'existent pas
     */
    private static function createTables() {
        $sql = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            first_name TEXT NOT NULL,
            last_name TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            phone TEXT,
            account_number TEXT UNIQUE NOT NULL,
            balance REAL DEFAULT 0.0,
            account_type TEXT DEFAULT 'standard',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        );
        ";
        
        self::$db->exec($sql);
    }

    /**
     * Exécuter une requête SELECT
     */
    public static function query($sql, $params = []) {
        $stmt = self::$db->prepare($sql);
        
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? SQLITE3_INTEGER : SQLITE3_TEXT);
            }
        }
        
        $result = $stmt->execute();
        $data = [];
        
        while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
            $data[] = $row;
        }
        
        return $data;
    }

    /**
     * Exécuter une requête INSERT/UPDATE/DELETE
     */
    public static function execute($sql, $params = []) {
        $stmt = self::$db->prepare($sql);
        
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value, is_int($value) ? SQLITE3_INTEGER : SQLITE3_TEXT);
            }
        }
        
        $result = $stmt->execute();
        
        if (!$result) {
            throw new Exception('Erreur d\'exécution: ' . self::$db->lastErrorMsg());
        }
        
        return self::$db->lastInsertRowid();
    }

    /**
     * Obtenir une seule ligne
     */
    public static function getOne($sql, $params = []) {
        $result = self::query($sql, $params);
        return !empty($result) ? $result[0] : null;
    }

    /**
     * Fermer la connexion
     */
    public static function close() {
        if (self::$db) {
            self::$db->close();
        }
    }
}
?>
