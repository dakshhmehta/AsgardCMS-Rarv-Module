<?php

namespace Modules\Rarv\Channels;

use Modules\Rarv\Parser\VariableParser;

class SMSMessage
{
	private $mobile_no;
	private $message;
    private $model = null;

	public function __construct($mobile_no, $message, $model = null)
	{
		$this->mobile_no = $mobile_no;
        $this->model = $model;

		$this->setMessage($message);
    }

    /**
     * @return mixed
     */
    public function getMobileNo()
    {
        return $this->mobile_no;
    }

    /**
     * @param mixed $mobile_no
     *
     * @return self
     */
    public function setMobileNo($mobile_no)
    {
        $this->mobile_no = $mobile_no;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     *
     * @return self
     */
    public function setMessage($message)
    {
        if($this->model){
            $parser = new VariableParser;
            $message = $parser->parse($message, $this->model);
        }

        $this->message = $message;

        return $this;
    }
}