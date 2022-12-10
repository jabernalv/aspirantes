<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace common\helpers;

/**
 * Description of AltiriaSMS
 *
 * @author jabernal
 */
class AltiriaSMS {

    public $_url;
    public $_domainId;
    public $_login;
    public $_password;
    public $_debug;

    public function getUrl() {
        return $this->_url;
    }

    public function setUrl($val) {
        $this->_url = $val;
        return $this;
    }

    public function getDomainId() {
        return $this->_domainId;
    }

    public function setDomainId($val) {
        $this->_domainId = $val;
        return $this;
    }

    public function getLogin() {
        return $this->_login;
    }

    public function setLogin($val) {
        $this->_login = $val;
        return $this;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($val) {
        $this->_password = $val;
        return $this;
    }

    public function getDebug() {
        return $this->_debug;
    }

    public function setDebug($val) {
        $this->_debug = $val;
        return $this;
    }

    public function sendSMS($destination, $message, $senderId = null) {

        $return = false;

        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded; charset=UTF-8'));
        curl_setopt($ch, CURLOPT_HEADER, false);
        // Max timeout in seconds to complete http request	
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);


        $COMANDO = 'cmd=sendsms&domainId=' . $this->getDomainId() . '&login=' . $this->getLogin() . '&passwd=' . $this->getPassword();
        $COMANDO .= '&msg=' . urlencode($message);

        //Como destinatarios se admite un array de teléfonos, una cadena de teléfonos separados por comas o un único teléfono
        if (is_array($destination)) {
            foreach ($destination as $telefono) {
                $this->logMsg("Add destination " . $telefono);
                $COMANDO .= '&dest=' . $telefono;
            }
        } else {
            if (strpos($destination, ',') !== false) {
                $destinationTmp = '&dest=' . str_replace(',', '&dest=', $destination) . '&';
                $COMANDO .= $destinationTmp;
                $this->logMsg("Add destination " . $destinationTmp);
            } else {
                $COMANDO .= '&dest=' . $destination;
            }
        }

        //No es posible utilizar el remitente en América pero sí en España y Europa
        if (!isset($senderId) || empty($senderId)) {
            $this->logMsg("NO senderId ");
        } else {
            $COMANDO .= '&senderId=' . $senderId;
            $this->logMsg("Add senderId " . $senderId);
        }


        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);

        // Get response from the server.
        $httpResponse = curl_exec($ch);


        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
            $this->logMsg("Server Altiria response: " . $httpResponse);

            if (strstr($httpResponse, "ERROR errNum")) {
                $this->logMsg("Error sending SMS: " . $httpResponse);
                return false;
            } else {
                $return = $httpResponse;
            }
        } else {
            $this->logMsg("Error sending SMS: " . curl_error($ch) . '(' . curl_errno($ch) . ')' . $httpResponse);

            $return = false;
        }

        curl_close($ch);
        return $return;
    }

    public function getCredit() {
        $return = false;
        // Set the curl parameters.
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->getUrl());
        curl_setopt($ch, CURLOPT_VERBOSE, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/x-www-form-urlencoded; charset=UTF-8'));
        curl_setopt($ch, CURLOPT_HEADER, false);
        // Max timeout in seconds to complete http request
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, 1);



        $COMANDO = 'cmd=getcredit&domainId=' . $this->getDomainId() . '&login=' . $this->getLogin() . '&passwd=' . $this->getPassword();


        // Set the request as a POST FIELD for curl.
        curl_setopt($ch, CURLOPT_POSTFIELDS, $COMANDO);

        // Get response from the server.
        $httpResponse = curl_exec($ch);


        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) === 200) {
            $this->logMsg("Server Altiria response: " . $httpResponse);

            if (strstr($httpResponse, "ERROR errNum")) {
                $this->logMsg("Error asking SMS credit: " . $httpResponse);
                $return = false;
            } else
                $return = $httpResponse;
        } else {
            $this->logMsg("Error asking SMS credit: " . curl_error($ch) . '(' . curl_errno($ch) . ')' . $httpResponse);

            $return = false;
        }

        curl_close($ch);
        return $return;
    }

    public function logMsg($msg) {
        if ($this->getDebug() === true)
            error_log("\n" . date(DATE_RFC2822) . " : " . $msg . "\r\n", 3, "app.log");
    }

}
