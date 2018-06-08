<?php
namespace com\selfcoders\ejabberdarchiveviewer;

use DateTime;
use DOMDocument;

class Entry
{
    /**
     * @var string
     */
    public $username;
    /**
     * @var DateTime
     */
    public $date;
    /**
     * @var string
     */
    public $peer;
    /**
     * @var string
     */
    public $bare_peer;
    /**
     * @var string
     */
    public $xml;
    /**
     * @var string
     */
    public $txt;
    /**
     * @var int
     */
    public $id;
    /**
     * @var string
     */
    public $kind;
    /**
     * @var string|null
     */
    public $nick;

    /**
     * @var string
     */
    public $from;
    /**
     * @var string
     */
    public $to;

    /**
     * @var int
     */
    private $timestamp;
    /**
     * @var string
     */
    private $created_at;

    public function __construct()
    {
        $this->id = (int)$this->id;
        $this->timestamp = (int)$this->timestamp;

        $this->date = new DateTime;
        $this->date->setTimestamp($this->timestamp / 1000000);// Timestamp is in microseconds

        $dom = new DOMDocument;

        $dom->loadXML(utf8_encode($this->xml));

        $messageElement = $dom->getElementsByTagName("message")->item(0);
        if ($messageElement !== null) {
            $this->from = $messageElement->getAttribute("from");
            $this->to = $messageElement->getAttribute("to");

            $bodyElement = $messageElement->getElementsByTagName("body")->item(0);
            if ($bodyElement !== null) {
                $this->txt = $bodyElement->textContent;
            }
        }
    }
}