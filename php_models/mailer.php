<?php
class Mailer 
{
    public $to;
    public $from;
    public $message;
    public $headers;
    public $cc;
    public $reply;

    public function Send()
    {
        $this->DeclareHeaders();
        mail($this->to, $this->from, $this->message, $this->headers);
    }

    public function DeclareHeaders()
    {
        $this->headers.="From: ".$this->from;    
        $this->headers = "MIME-Version: 1.0" . "\r\n";
        $this->headers.="Content-type: text/html; charset=utf-8" . "\r\n";
    }

}
?>