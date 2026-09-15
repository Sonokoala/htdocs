<?php
require_once 'db.php';
require_once 'validation.php';

/**
 * Class to handle SQL execution results and display them securely
 */
class SQLResult {
    private $connection;
    private $lastQuery;
    private $affectedRows;
    private $lastError;
    private $lastInsertId;
    
    public function __construct($connection) {
        $this->connection = $connection;
        $this->reset();
    }
    
    /**
     * Reset all result properties
     */
    private function reset() {
        $this->lastQuery = '';
        $this->affectedRows = 0;
        $this->lastError = null;
        $this->lastInsertId = null;
    }
    
    /**
     * Execute a SELECT query and return results
     * @param string $query The SQL query
     * @param array $params Parameters for prepared statement
     * @param string $types Parameter types (i: integer, s: string, d: double, b: blob)
     * @return array|false Results array or false on failure
     */
    public function select($query, $params = [], $types = '') {
        $this->reset();
        $this->lastQuery = $query;
        
        try {
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Query preparation failed: " . $this->connection->error);
            }
            
            if (!empty($params)) {
                if (strlen($types) !== count($params)) {
                    throw new Exception("Parameter type specification doesn't match parameter count");
                }
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
            
            $result = $stmt->get_result();
            $this->affectedRows = $stmt->affected_rows;
            
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            $stmt->close();
            return $data;
            
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Execute an INSERT query
     * @param string $query The SQL query
     * @param array $params Parameters for prepared statement
     * @param string $types Parameter types (i: integer, s: string, d: double, b: blob)
     * @return bool Success status
     */
    public function insert($query, $params = [], $types = '') {
        $this->reset();
        $this->lastQuery = $query;
        
        try {
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Query preparation failed: " . $this->connection->error);
            }
            
            if (!empty($params)) {
                if (strlen($types) !== count($params)) {
                    throw new Exception("Parameter type specification doesn't match parameter count");
                }
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
            
            $this->affectedRows = $stmt->affected_rows;
            $this->lastInsertId = $stmt->insert_id;
            
            $stmt->close();
            return true;
            
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Execute an UPDATE query
     * @param string $query The SQL query
     * @param array $params Parameters for prepared statement
     * @param string $types Parameter types (i: integer, s: string, d: double, b: blob)
     * @return bool Success status
     */
    public function update($query, $params = [], $types = '') {
        $this->reset();
        $this->lastQuery = $query;
        
        try {
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Query preparation failed: " . $this->connection->error);
            }
            
            if (!empty($params)) {
                if (strlen($types) !== count($params)) {
                    throw new Exception("Parameter type specification doesn't match parameter count");
                }
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
            
            $this->affectedRows = $stmt->affected_rows;
            
            $stmt->close();
            return true;
            
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Execute a DELETE query
     * @param string $query The SQL query
     * @param array $params Parameters for prepared statement
     * @param string $types Parameter types (i: integer, s: string, d: double, b: blob)
     * @return bool Success status
     */
    public function delete($query, $params = [], $types = '') {
        $this->reset();
        $this->lastQuery = $query;
        
        try {
            $stmt = $this->connection->prepare($query);
            if (!$stmt) {
                throw new Exception("Query preparation failed: " . $this->connection->error);
            }
            
            if (!empty($params)) {
                if (strlen($types) !== count($params)) {
                    throw new Exception("Parameter type specification doesn't match parameter count");
                }
                $stmt->bind_param($types, ...$params);
            }
            
            if (!$stmt->execute()) {
                throw new Exception("Query execution failed: " . $stmt->error);
            }
            
            $this->affectedRows = $stmt->affected_rows;
            
            $stmt->close();
            return true;
            
        } catch (Exception $e) {
            $this->lastError = $e->getMessage();
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Display query results in HTML format
     * @param string $title Optional title for the results
     * @return string HTML output
     */
    public function displayResult($title = '') {
        $output = '<div class="sql-result">';
        
        if ($title) {
            $output .= '<h3>' . htmlspecialchars($title) . '</h3>';
        }
        
        if ($this->lastError) {
            $output .= '<div class="alert alert-danger">
                           <strong>Error:</strong> ' . htmlspecialchars($this->lastError) . '
                       </div>';
        } else {
            $output .= '<div class="alert alert-success">';
            $output .= '<strong>Success!</strong><br>';
            $output .= '<strong>Affected Rows:</strong> ' . $this->affectedRows . '<br>';
            
            if ($this->lastInsertId) {
                $output .= '<strong>Last Insert ID:</strong> ' . $this->lastInsertId . '<br>';
            }
            
            $output .= '</div>';
        }
        
        $output .= '</div>';
        return $output;
    }
    
    /**
     * Get the number of affected rows
     * @return int
     */
    public function getAffectedRows() {
        return $this->affectedRows;
    }
    
    /**
     * Get the last insert ID
     * @return int|null
     */
    public function getLastInsertId() {
        return $this->lastInsertId;
    }
    
    /**
     * Get the last error message
     * @return string|null
     */
    public function getLastError() {
        return $this->lastError;
    }
}

// Example usage:
/*
$sqlResult = new SQLResult($connection);

// SELECT example
$results = $sqlResult->select(
    "SELECT * FROM staff WHERE roleID = ?",
    [1],
    "i"
);

if ($results !== false) {
    foreach ($results as $row) {
        // Process results
    }
}

// INSERT example
$success = $sqlResult->insert(
    "INSERT INTO staff (name, email, roleID) VALUES (?, ?, ?)",
    ["John Doe", "john@example.com", 1],
    "ssi"
);

// UPDATE example
$success = $sqlResult->update(
    "UPDATE staff SET name = ? WHERE staffID = ?",
    ["Jane Doe", 1],
    "si"
);

// DELETE example
$success = $sqlResult->delete(
    "DELETE FROM staff WHERE staffID = ?",
    [1],
    "i"
);

// Display results
echo $sqlResult->displayResult("Staff Update Results");
*/
?> 