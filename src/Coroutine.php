<?php

namespace Visry;

class Coroutine
{
    protected mixed $size;
    protected mixed $in;
    protected mixed $out;

    public function __construct($size = 8192) {
        $this->size = $size;
        list($this->in, $this->out) = stream_socket_pair(
            STREAM_PF_UNIX,
            STREAM_SOCK_DGRAM,
            STREAM_IPPROTO_IP
        );
    }

    /**
     * @return mixed
     */
    public function read(): mixed
    {
        $data = stream_socket_recvfrom($this->in, $this->size);
        return $data !== false ? unserialize($data) : false;
    }

    /**
     * @param $data
     * @return false|int
     */
    public function write($data): false|int
    {
        $serializedData = serialize($data);
        return stream_socket_sendto($this->out, $serializedData);
    }

    /**
     * @param callable $callback
     * @return $this
     */
    public function coroutine(callable $callback): static
    {
        php($this, $callback);
        return $this;
    }

    /**
     * @return array
     */
    public function fetchAll() : array
    {
        $results = [];
        while ($data = $this->read()) {
            $results[] = $data;
        }

        return $results;
    }

}
