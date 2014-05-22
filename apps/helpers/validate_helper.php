<?php

class ValidateHelper
{

    public function __construct()
    {
        
    }

    public function isEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public function required($param = array())
    {
        
    }

// server side validate sign up post data
    public function validation($data, $isUsedEmail, $needed = false)
    {
        // validate data
        $message = '';
        $isEmptyField = false;
        // contains any empty field?
        if (is_array($data))
        {
            foreach ($data as $postVar)
            {
                if (empty($postVar))
                    $isEmptyField = true;
            }
        }else
        {
            if (empty($data))
                $isEmptyField = true;
        }

        if ($isEmptyField)
        {
            $message = 'You have to fill in all fields.';
        }
        else
        {
            // validate email
            if (is_array($data) && !$this->isEmail($data['emailSignUp']))
                $message = 'Incorrectly formatted email.';
            if (!is_array($data) && !$this->isEmail($data))
                $message = 'Incorrectly formatted email.';
            // check for used email

            if ($isUsedEmail && !$needed)
                $message = 'Used email.';
            if (!$isUsedEmail && $needed)
                $message = 'Email is not exist. Please try again with other information.';
        }
        return $message;
    }

}