<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;

class EmailController extends Controller
{
    private $email;

    public function __construct(Email $email) {
        $this->email = $email;
    }
    /**
     * Sends email messages.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function send()
    {
        var_dump($this->email->send());
    }
}
