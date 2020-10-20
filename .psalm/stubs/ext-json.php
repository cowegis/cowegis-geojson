<?php

/**
 * Objects implementing JsonSerializable
 * can customize their JSON representation when encoded with <b>json_encode</b>.
 *
 * @link https://php.net/manual/en/class.jsonserializable.php
 * @template TValue
 */
interface JsonSerializable
{
    /**
     * Specify data which should be serialized to JSON
     * @link https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4
     *
     * @psalm-return TValue
     */
    public function jsonSerialize();
}
