<?php

namespace PhpAmqpLib\Wire\IO;

use PhpAmqpLib\Exception\AMQPIOException;
use PhpAmqpLib\Exception\AMQPRuntimeException;
use PhpAmqpLib\Exception\AMQPTimeoutException;
use PhpAmqpLib\Helper\MiscHelper;

class StreamIO extends AbstractIO
{

    private $sock = null;



    public function __construct($host, $port, $connection_timeout, $read_write_timeout, $context = null)
    {
        $this->sock = null;
        $this->host = $host;
        $this->port = $port;
        $this->connection_timeout = $connection_timeout;
        $this->read_write_timeout = $read_write_timeout;
        $this->context = $context;
    }



    /**
     * Setup the stream connection
     *
     * @throws \PhpAmqpLib\Exception\AMQPRuntimeException
     * @throws \Exception
     */
    public function connect()
    {
        $errstr = $errno = null;

        if ($this->context) {
            $remote = sprintf('ssl://%s:%s', $this->host, $this->port);
            $this->sock = @stream_socket_client($remote, $errno, $errstr, $this->connection_timeout, STREAM_CLIENT_CONNECT, $this->context);
        } else {
            $remote = sprintf('tcp://%s:%s', $this->host, $this->port);
            $this->sock = @stream_socket_client($remote, $errno, $errstr, $this->connection_timeout, STREAM_CLIENT_CONNECT);
        }

        if (!$this->sock) {
            throw new AMQPRuntimeException("Error Connecting to server($errno): $errstr ");
        }

        list($sec, $uSec) = MiscHelper::splitSecondsMicroseconds($this->read_write_timeout);
        if (!stream_set_timeout($this->sock, $sec, $uSec)) {
            throw new AMQPIOException("Timeout could not be set");
        }

        stream_set_blocking($this->sock, 1);
    }



    /**
     * Reconnect the socket
     */
    public function reconnect()
    {
        $this->close();
        $this->connect();
    }



    public function read($n)
    {
        $res = '';
        $read = 0;

        while ($read < $n && !feof($this->sock) && (false !== ($buf = fread($this->sock, $n - $read)))) {
            if ($buf === '') {
                continue;
            }

            $read += mb_strlen($buf, 'ASCII');
            $res .= $buf;
        }

        if (mb_strlen($res, 'ASCII') != $n) {
            throw new AMQPRuntimeException("Error reading data. Received " .
                mb_strlen($res, 'ASCII') . " instead of expected $n bytes");
        }

        return $res;
    }



    public function write($data)
    {
        $len = mb_strlen($data, 'ASCII');
        while (true) {
            if (is_null($this->sock)) {
                throw new AMQPRuntimeException("Broken pipe or closed connection");
            }

            if (false === ($written = @fwrite($this->sock, $data))) {
                throw new AMQPRuntimeException("Error sending data");
            }

            if ($written === 0) {
                throw new AMQPRuntimeException("Broken pipe or closed connection");
            }

            if ($this->timed_out()) {
                throw new AMQPTimeoutException("Error sending data. Socket connection timed out");
            }

            $len = $len - $written;
            if ($len > 0) {
                $data = mb_substr($data, 0 - $len, 0 - $len, 'ASCII');

            } else {
                break;
            }
        }
    }



    public function close()
    {
        if (is_resource($this->sock)) {
            fclose($this->sock);
        }
        $this->sock = null;
    }



    public function get_socket()
    {
        return $this->sock;
    }



    public function select($sec, $usec)
    {
        $read = array($this->sock);
        $write = null;
        $except = null;
        return stream_select($read, $write, $except, $sec, $usec);
    }



    protected function timed_out()
    {
        // get status of socket to determine whether or not it has timed out
        $info = stream_get_meta_data($this->sock);
        return $info['timed_out'];
    }

}
