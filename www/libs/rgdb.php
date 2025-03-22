<?php
#[\AllowDynamicProperties]
class RGDB extends mysqli
{
    const POINT_KEY = 'rgdb_savepoint_';
    const MAX_ROWS = 10000;

    public $persistent = false;
    public $last_result = [];

    public $dbuser;
    public $dbpassword;
    public $dbname;
    public $dbhost;
    public $port;
    public $connected;
    public $in_transaction;
    public $show_errors;
    public $initial_query;
    public $connect_timeout;
    public $ban_checked;
    public $max_rows;

    public function __construct($dbuser = '', $dbpassword = '', $dbname = '', $dbhost = 'localhost', $check_ban = false)
    {
        $this->dbuser = $dbuser;
        $this->dbpassword = $dbpassword;
        $this->dbname = $dbname;
        $this->dbhost = $dbhost;
        $this->port = null;
        $this->connected = false;
        $this->in_transaction = 0;
        $this->show_errors = true;
        $this->initial_query = false;
        $this->connect_timeout = 10;

        // Check IP banned
        if ($check_ban) {
            $this->ban_checked = check_ip_noaccess(1); 
        } else {
            $this->ban_checked = true;
        }

        // Límite de resultados si estamos en entorno web
        if (!empty($_SERVER['HTTP_HOST'])) {
            $this->max_rows = self::MAX_ROWS;
        } else {
            $this->max_rows = PHP_INT_MAX;
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    public function close()
    {
        if (!$this->connected) {
            return;
        }

        // Rollback si quedara transacción pendiente
        if ($this->in_transaction > 0) {
            parent::rollback();
            syslog(LOG_INFO, "Dangling transactions, rollback forced " . $_SERVER['SCRIPT_NAME']);
        }

        parent::close();
        $this->connected = false;
    }

    public function hide_errors()
    {
        $this->show_errors = false;
    }

    public function show_errors()
    {
        $this->show_errors = true;
    }

    public function initial_query($query)
    {
        $this->initial_query = $query;
        if ($this->connected) {
            return $this->query($query);
        }
    }

    public function transaction()
    {
        $this->in_transaction++;
        if ($this->in_transaction == 1) {
            $this->query('START TRANSACTION');
        } else {
            $savep = $this->savepoint_name();
            if (!$this->query('SAVEPOINT ' . $savep)) {
                syslog(LOG_INFO, 'Error SAVEPOINT ' . $savep . ' ' . $_SERVER['SCRIPT_NAME']);
            }
        }
        return $this->in_transaction;
    }

    public function savepoint_name()
    {
        if ($this->in_transaction > 1) {
            return self::POINT_KEY . $this->in_transaction;
        }
    }

    #[\ReturnTypeWillChange]
    public function commit($flags = null, $name = null)
    {
        if ($this->in_transaction <= 0) {
            syslog(LOG_INFO, 'Error COMMIT, transaction = 0 ' . $_SERVER['SCRIPT_NAME']);
            return false;
        }

        if ($this->in_transaction > 1) {
            $r = $this->query('RELEASE SAVEPOINT ' . $this->savepoint_name());
        } else {
            $r = parent::commit();
        }

        if (!$r) {
            syslog(LOG_INFO, 'Error commit/RELEASE SAVEPOINT ' . $this->savepoint_name() . ' ' . $_SERVER['SCRIPT_NAME']);
        }

        $this->in_transaction--;
        return $r;
    }

    #[\ReturnTypeWillChange]
    public function rollback($flags = null, $name = null)
    {
        if ($this->in_transaction <= 0) {
            syslog(LOG_INFO, 'Error ROLLBACK, transaction = 0 ' . $_SERVER['SCRIPT_NAME']);
            return false;
        }
    
        if ($this->in_transaction > 1) {
            $r = $this->query('ROLLBACK TO ' . $this->savepoint_name());
        } else {
            $r = parent::rollback();
        }
    
        if (!$r) {
            syslog(LOG_INFO, 'Error rollback/ROLLBACK TO ' . $this->savepoint_name() . ' ' . $_SERVER['SCRIPT_NAME']);
        }
    
        $this->in_transaction--;
        return $r;
    }

    // Reset to the slave if we were on the master
    public function barrier()
    {
    }

    public function connect(
        ?string $host = null,
        ?string $username = null,
        ?string $passwd = null,
        ?string $dbname = null,
        ?int $port = null,
        ?string $socket = null
    ): bool
    {
        if ($this->connected) {
            return true;
        }

        @parent::init();
        @parent::options(MYSQLI_OPT_CONNECT_TIMEOUT, $this->connect_timeout);

        if ($this->persistent && version_compare(PHP_VERSION, '5.3.0') > 0) {
            $this->connected = @parent::real_connect('p:' . $this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname, $this->port);
        } else {
            $this->connected = @parent::real_connect($this->dbhost, $this->dbuser, $this->dbpassword, $this->dbname, $this->port);
        }

        if (!$this->connected) {
            header('HTTP/1.1 503 Service Unavailable');
            return false;
        }

        $this->set_charset('utf8');

        if (!$this->ban_checked) {
            check_ip_noaccess(2); 
            $this->ban_checked = true;
        }

        if ($this->initial_query) {
            $this->query($this->initial_query);
        }

        return true;
    }

    public function escape($str)
    {
        $this->connect();
        if ($str === null) {
            $str = '';
        }
        return $this->real_escape_string($str);
    }

    /**
     * Envía error a la función mi_error() si show_errors está activo
     * y también a syslog.
     */
    public function print_error($str = '')
    {
        if ($this->show_errors) {
            if (!headers_sent()) {
                header('HTTP/1.1 503 Database error');
                header('Content-Type: text/plain');
            }
            // Llamada a tu función de debug con tipo "mysql"
            mi_error("MySQL Error.\nQuery: $str\nMySQL says: " . $this->error, 'mysql');
        }

        syslog(LOG_NOTICE, "rgdb.php ($this->dbhost) error $str " . $_SERVER['REQUEST_URI'] . " ($this->error)");
        return false;
    }

    public function flush()
    {
        $this->last_result = [];
    }

    /**
     * Ejecuta la query y guarda los resultados en $this->last_result si es SELECT.
     * Hace logging con mi_error() y muestra en el log las 2 llamadas superiores (backtrace).
     */
    #[\ReturnTypeWillChange]
    public function query($query, $class_name = null, $index_name = null)
    {
        $is_select = preg_match('/^\s*(select|show)\s/i', trim($query));

        $this->connect();

        // Vaciamos resultados anteriores
        $this->last_result = [];

        // Preparamos backtrace y mostramos las dos llamadas inmediatamente anteriores
        $backtrace = debug_backtrace();
        $bt_info = [];
        // Del índice 1 en adelante son los llamadores
        for ($i = 1; $i <= 2; $i++) {
            if (isset($backtrace[$i])) {
                $fn   = $backtrace[$i]['function'] ?? '(no-fn)';
                $file = $backtrace[$i]['file'] ?? '(no-file)';
                $line = $backtrace[$i]['line'] ?? '(no-line)';
                $bt_info[] = "#$i => function '$fn' at $file:$line";
            }
        }
        // Log con tu función
        mi_error("[QUERY LOG] Backtrace:\n" . implode("\n", $bt_info), 'mysql');
        mi_error("[QUERY LOG] $query", 'mysql');

        // Realizamos la consulta
        $result = @parent::query($query);

        // Si falla => se imprime error y se retorna false
        if (!$result) {
            return $this->print_error($query);
        }

        // No es SELECT => devolvemos true y listo
        if (!$is_select) {
            return true;
        }

        // En SELECT: pasamos resultados a last_result
        if (!$class_name) {
            $class_name = 'stdClass';
        }

        $num_rows = 0;
        while (($row = $result->fetch_object($class_name)) && ($num_rows < $this->max_rows)) {
            $index = $index_name ? $row->$index_name : $num_rows;
            $this->last_result[$index] = $row;
            $num_rows++;
        }

        global $globals;
        if ($num_rows >= $this->max_rows) {
            syslog(LOG_INFO, 'MAX_ROWS reached by ' . ($globals['user_ip'] ?? '??') . ' in ' . ($_SERVER['REQUEST_URI'] ?? '??'));
        }

        @$result->close();
        return true;
    }

    public function object_iterator($query, $class = null)
    {
        $is_select = preg_match('/^\s*(select|show)\s/i', trim($query));
        $this->connect();

        if (!$this->real_query($query)) {
            return false;
        }

        if ($is_select && $this->field_count) {
            return new QueryResult($this, $class);
        }
        return $this->affected_rows;
    }

    public function get_var($query = null, $x = 0, $y = 0)
    {
        if ($query) {
            $this->query($query);
        }
        if (!empty($this->last_result[$y]) && is_object($this->last_result[$y])) {
            $values = array_values(get_object_vars($this->last_result[$y]));
        }
        return $values[$x] ?? null;
    }

    public function get_object($query, $class)
    {
        return $this->get_row($query, 0, $class);
    }

    public function get_row($query = null, $y = 0, $class_name = null)
    {
        if ($query) {
            $this->query($query, $class_name);
        }
        return $this->last_result[$y] ?? null;
    }

    public function get_col($query = null, $x = 0)
    {
        if ($query) {
            $this->query($query);
        }
        $return = [];
        $n = count($this->last_result);
        for ($i = 0; $i < $n; $i++) {
            $return[$i] = $this->get_var(null, $x, $i);
        }
        return $return;
    }

    public function get_results($query = null, $class_name = null, $index_name = null)
    {
        if ($query) {
            $this->query($query, $class_name, $index_name);
        }
        return $this->last_result ?: [];
    }

    public function get_enum_values($table, $column)
    {
        if (($table === 'links') && ($column === 'link_status')) {
            return [
                'discard' => 1,
                'queued' => 2,
                'published' => 3,
                'abuse' => 4,
                'duplicated' => 5,
                'autodiscard' => 6,
                'metapublished' => 7
            ];
        }

        // SHOW COLUMNS ... y parsear
        $row = $this->get_row('SHOW COLUMNS FROM `' . $table . '` LIKE "' . $column . '"');
        preg_match_all("/'(.*?)'/", $row->Type ?? '', $matches);
        if (empty($matches[1])) {
            return [];
        }

        $enum = [];
        foreach ($matches[1] as $v => $str) {
            $enum[$str] = $v + 1;
        }
        return $enum;
    }
}

// Iterators for results, etc.
class ObjectIterator implements Iterator
{
    protected $result;
    protected $class;
    protected $position;
    protected $currentRow;

    public function __construct($result, $class = null)
    {
        $this->result = $result;
        $this->class = $class;
    }

    public function __destruct()
    {
        $this->result->free();
    }

    #[\ReturnTypeWillChange]
    public function rewind()
    {
        $this->result->data_seek($this->position = 0);
        $this->currentRow = $this->result->fetch_object($this->class);
    }

    #[\ReturnTypeWillChange]
    public function next()
    {
        $this->currentRow = $this->result->fetch_object($this->class);
        ++$this->position;
    }

    #[\ReturnTypeWillChange]
    public function valid()
    {
        return $this->position < $this->result->num_rows;
    }

    #[\ReturnTypeWillChange]
    public function current()
    {
        $this->currentRow->read = true;
        return $this->currentRow;
    }

    #[\ReturnTypeWillChange]
    public function key()
    {
        return $this->position;
    }
}

class QueryResult extends MySQLi_Result implements IteratorAggregate
{
    protected $class;

    public function __construct($result, $class = null)
    {
        parent::__construct($result);
        $this->class = $class;
    }

    public function getIterator(): Iterator
    {
        return new ObjectIterator($this, $this->class);
    }
}
