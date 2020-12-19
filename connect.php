<?php

class Database
{
    private $db_host = '127.0.0.1';
    private $db_user = 'root';
    private $db_pass = '123456a@';
    private $db_name = 'test';
    private $con = false;
    private $result = [];

    public function __construct()
    {
        $connect = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        return $connect;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function connect()
    {
        if (!$this->con) {
            $myconn = $this->mySqliConnect();
            if ($myconn) {
                $seldb = mysqli_select_db($myconn, $this->db_name);
                if ($seldb) {
                    $this->con = true;
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    private function mySqliConnect()
    {
        $connect = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        return $connect;
    }

    public function disconnect()
    {
        if ($this->con) {
            if (@mysqli_close()) {
                $this->con = false;
                return true;
            } else {
                return false;
            }
        }
    }

    public function select($table, $rows = '*', $where = null, $order = null)
    {
        $myconn = $this->mySqliConnect();
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        if ($where != null)
            $q .= ' WHERE ' . $where;
        if ($order != null)
            $q .= ' ORDER BY ' . $order;
        if ($this->tableExists($table)) {
            $query = $myconn->query($q);
            if ($query) {
                $this->numResults = $query->num_rows;
                for ($i = 0; $i < $this->numResults; $i++) {
                    $r = $query->fetch_array(MYSQLI_ASSOC);
                    $key = array_keys($r);
                    for ($x = 0; $x < count($key); $x++) {
                        // Sanitizes keys so only alphavalues are allowed
                        if (!is_int($key[$x])) {
                            if ($query->num_rows > 1)
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                            else if ($query->num_rows < 1)
                                $this->result = null;
                            else
                                $this->result[$key[$x]] = $r[$key[$x]];
                        }
                    }
                }
                return true;
            } else {
                return false;
            }
        } else
            return false;
    }

    private function tableExists($table)
    {
        $myconn = $this->mySqliConnect();

        $result = $myconn->query('SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table . '"');
        if ($result) {
            if ($result->num_rows == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function insert($table, $values, $rows = [])
    {
        $myconn = $this->mySqliConnect();
        if ($this->tableExists($table)) {
            $insert = 'INSERT INTO ' . $table;
            if (count($rows)) {
                $rows = implode(', ', $rows);
                $insert .= ' (' . $rows . ')';
            }

            for ($i = 0; $i < count($values); $i++) {
                if (is_string($values[$i]))
                    $values[$i] = '"' . $values[$i] . '"';
            }
            $values = implode(', ', $values);
            $insert .= ' VALUES (' . $values . ')';
            $ins = $myconn->query($insert);
            if ($ins) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function delete($table, $where = null)
    {
        if ($this->tableExists($table)) {
            if ($where == null) {
                $delete = 'DELETE ' . $table;
            } else {
                $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where;
            }
            $del = @mysqli_query($delete);

            if ($del) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function update($table, $rows, $where)
    {
        if ($this->tableExists($table)) {
            // Parse the where values
            // even values (including 0) contain the where rows
            // odd values contain the clauses for the row
            for ($i = 0; $i < count($where); $i++) {
                if ($i % 2 != 0) {
                    if (is_string($where[$i])) {
                        if (($i + 1) != null)
                            $where[$i] = '"' . $where[$i] . '" AND ';
                        else
                            $where[$i] = '"' . $where[$i] . '"';
                    }
                }
            }
            $where = implode('=', $where);


            $update = 'UPDATE ' . $table . ' SET ';
            $keys = array_keys($rows);
            for ($i = 0; $i < count($rows); $i++) {
                if (is_string($rows[$keys[$i]])) {
                    $update .= $keys[$i] . '="' . $rows[$keys[$i]] . '"';
                } else {
                    $update .= $keys[$i] . '=' . $rows[$keys[$i]];
                }

                // Parse to add commas
                if ($i != count($rows) - 1) {
                    $update .= ',';
                }
            }
            $update .= ' WHERE ' . $where;
            $query = @mysqli_query($update);
            if ($query) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}

?>